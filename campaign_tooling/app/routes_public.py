"""Public letter-writer flow.

Navigation: campaign overview → target → recipient.

  1. /                                    — list active campaigns
  2. /c/<slug>                            — campaign overview + target cards
                                            (no form)
  3. /c/<slug>/t/<target_id>              — per-target page: writer info +
                                            this target's parameters + the
                                            artifact previews
  4. /c/<slug>/t/<target_id>/print/<artifact_id>
                                          — printable view, one page per
                                            recipient, for a letter artifact
  5. /c/<slug>/t/<target_id>/pdf/<artifact_id>
                                          — combined PDF, one page per
                                            recipient

Writer info, parameter values, and consent flags live in the Flask session
(a signed cookie), not the URL, so PII never lands in access logs, browser
history, or the Referer header. Writer identity and consent are global to the
browser — a writer can pick a second target without re-entering name/email —
while parameter values are scoped per target. External hosts can still
deep-link a writer in with ``?name=…&email=…`` prefilled: the target page
consumes those query args into the session once, then redirects to a clean
URL (see ``_seed_session_from_args``).
"""

from __future__ import annotations

import re
from urllib.parse import quote, urlencode

from flask import (
    Blueprint,
    Response,
    abort,
    redirect,
    render_template,
    request,
    session,
    url_for,
)

from .extensions import db
from .models import (
    Artifact,
    Campaign,
    Respondent,
    RespondentAction,
    RespondentParameter,
    Target,
)
from .pdf import render_letters_pdf
from .substitution import (
    Writer,
    markers_to_html,
    render,
    render_for_preview,
    render_with_highlights,
)
from .themes import theme_config

bp = Blueprint("public", __name__, template_folder="templates")


@bp.app_context_processor
def _inject_theme_config() -> dict:
    """Make ``theme_for(campaign)`` callable from public templates so
    base_public.html can pick the right header/footer content for the
    campaign in scope without each route plumbing it through manually.
    """
    return {"theme_for": lambda campaign: theme_config(
        campaign.theme if campaign and campaign.theme else Campaign.THEME_DEFAULT
    )}


# Writer info, parameter answers, consent flags, and the respondent id live in
# the Flask session (a signed cookie) rather than the URL, so PII never lands in
# access logs, browser history, or the Referer header. Everything is global to
# the browser, which is what lets a writer answer once on a chain's head target
# and carry those answers through every following target. Parameter answers are
# keyed by parameter key (``session["answers"][<key>]``): a key means the same
# thing wherever it appears in a chain, so the writer only answers it once.
_WRITER_KEYS = (
    "name",
    "email",
    "street1",
    "street2",
    "city",
    "state",
    "postal_code",
    "organization",
)


def _writer_from_session() -> Writer:
    w = session.get("writer", {})
    return Writer(**{k: w.get(k, "") for k in _WRITER_KEYS})


def _parameters_from_session(target: Target) -> dict:
    """This target's parameter values, pulled by key from the shared answers.

    Missing ones come back as the empty string so templates render them as
    blank rather than raising.
    """
    answers = session.get("answers", {})
    return {p.key: answers.get(p.key, "") for p in target.parameters}


# Consent flags both default to True (checked).
def _consents_from_session() -> dict:
    c = session.get("consents", {})
    return {
        "email_copy": c.get("email_copy", True),
        "store_contact": c.get("store_contact", True),
    }


def _seed_session_from_args(target: Target) -> bool:
    """Consume any writer / parameter / consent values passed in the query
    string into the session, once. Returns True if anything was seeded, so
    the caller can redirect to a clean URL and drop the PII from the address
    bar. This preserves the inbound hand-off from external hosts that
    deep-link a writer in with ``?name=…&email=…`` prefilled.
    """
    a = request.args
    seeded = False

    writer_vals = {k: a.get(k, "").strip() for k in _WRITER_KEYS if a.get(k)}
    if writer_vals:
        session.setdefault("writer", {}).update(writer_vals)
        seeded = True

    # Seed answers for every parameter across the chain, so an inbound prefill
    # can populate a later target's fields too.
    param_vals = {
        p.key: a.get(f"p_{p.key}", "").strip()
        for p in target.chain_parameters()
        if a.get(f"p_{p.key}")
    }
    if param_vals:
        session.setdefault("answers", {}).update(param_vals)
        seeded = True

    # Only explicit "no" choices ride the query string; a present flag means opt-out.
    if a.get("email_copy") == "0" or a.get("store_contact") == "0":
        consents = session.setdefault("consents", {})
        if a.get("email_copy") == "0":
            consents["email_copy"] = False
        if a.get("store_contact") == "0":
            consents["store_contact"] = False
        seeded = True

    if seeded:
        # Flask can't detect in-place mutation of nested session dicts.
        session.modified = True
    return seeded


def _missing_required(target: Target, parameters: dict) -> list:
    return [p for p in target.parameters if p.required and not parameters.get(p.key)]


def _load_campaign_or_404(slug: str) -> Campaign:
    campaign = db.session.scalar(db.select(Campaign).where(Campaign.slug == slug))
    if campaign is None:
        abort(404)
    return campaign


def _save_respondent(
    campaign: Campaign,
    target: Target,
    writer: Writer,
    submitted: dict,
    consents: dict,
) -> int:
    """Persist one Respondent + its non-empty parameter rows. Returns the new
    respondent id; the caller keeps it in the session so every target the
    writer walks through in the chain logs its actions against this one row.

    ``target`` is the chain's head (where the writer started). Parameter rows
    are saved for the whole chain, each tagged with its owning target so
    per-target rollups still work even though the writer answered once.

    When the writer has unchecked store_contact, the PII fields are
    blanked at write time; city / state / postal_code are always retained.
    """
    redact = not consents["store_contact"]
    respondent = Respondent(
        campaign_id=campaign.id,
        target_id=target.id,
        name="" if redact else writer.name,
        email="" if redact else writer.email,
        organization="" if redact else writer.organization,
        street1="" if redact else writer.street1,
        street2="" if redact else writer.street2,
        city=writer.city,
        state=writer.state,
        postal_code=writer.postal_code,
        email_copy_consent=consents["email_copy"],
        store_contact_consent=consents["store_contact"],
    )
    db.session.add(respondent)
    db.session.flush()  # populates respondent.id for the FK below

    seen_param_ids: set[int] = set()
    for chain_target in target.chain():
        for p in chain_target.parameters:
            if p.id in seen_param_ids:
                continue
            seen_param_ids.add(p.id)
            v = submitted.get(p.key, "").strip()
            if not v:
                continue
            db.session.add(
                RespondentParameter(
                    respondent_id=respondent.id,
                    campaign_id=campaign.id,
                    target_id=chain_target.id,
                    parameter_id=p.id,
                    value=v[: RespondentParameter.VALUE_MAX_LEN],
                )
            )
    db.session.commit()
    return respondent.id


def _current_respondent_id() -> int | None:
    """The respondent id for this browser's journey, set on the head target's
    POST and carried in the session across every target in the chain.
    """
    rid = session.get("respondent_id")
    return rid if isinstance(rid, int) else None


def _log_actions(
    respondent_id: int,
    campaign: Campaign,
    target: Target,
    artifact: Artifact,
    recipient_ids: list[int],
) -> None:
    """Insert one action row per (artifact, recipient) pair. Caller is
    responsible for resolving recipient_ids to ones that actually belong
    to ``target`` — we trust the caller and don't re-check here.
    """
    if not recipient_ids:
        return
    for rid in recipient_ids:
        db.session.add(
            RespondentAction(
                respondent_id=respondent_id,
                campaign_id=campaign.id,
                target_id=target.id,
                artifact_id=artifact.id,
                recipient_id=rid,
            )
        )
    db.session.commit()


# The campaign index and per-campaign overview are intentionally not
# reachable from the web — writers are linked directly to a target action
# page from external hosts. Returning 404 here hides the internal surface
# without breaking the URL space.
@bp.route("/")
def index():
    abort(404)


@bp.route("/c/<slug>")
def campaign(slug: str):
    abort(404)


@bp.route("/c/<slug>/t/<int:target_id>", methods=["GET", "POST"])
def target_action(slug: str, target_id: int):
    campaign = _load_campaign_or_404(slug)
    if not campaign.active:
        return redirect(url_for("public.campaign", slug=slug))
    target = db.session.get(Target, target_id) or abort(404)
    if target.campaign_id != campaign.id:
        abort(404)

    # POST: writer info + the whole chain's parameters, answered once on the
    # head target. We stash everything in the session and redirect to a clean
    # GET so no PII rides the URL.
    if request.method == "POST":
        writer = Writer(
            name=request.form.get("name", "").strip(),
            email=request.form.get("email", "").strip(),
            street1=request.form.get("street1", "").strip(),
            street2=request.form.get("street2", "").strip(),
            city=request.form.get("city", "").strip(),
            state=request.form.get("state", "").strip(),
            postal_code=request.form.get("postal_code", "").strip(),
            organization=request.form.get("organization", "").strip(),
        )
        submitted = {
            p.key: request.form.get(f"p_{p.key}", "").strip()
            for p in target.chain_parameters()
        }
        # Unchecked checkboxes are absent from the form; presence == checked.
        consents = {
            "email_copy": "email_copy" in request.form,
            "store_contact": "store_contact" in request.form,
        }
        respondent_id = _save_respondent(campaign, target, writer, submitted, consents)

        session["writer"] = {k: getattr(writer, k) for k in _WRITER_KEYS}
        session.setdefault("answers", {}).update(submitted)
        session["consents"] = consents
        session["respondent_id"] = respondent_id
        # Persist across browser restarts so a writer can come back later in the
        # chain and still log against the same respondent (see PERMANENT_SESSION_LIFETIME).
        session.permanent = True
        session.modified = True

        return redirect(url_for("public.target_action", slug=slug, target_id=target_id))

    # GET: consume any inbound prefill from the query string into the session,
    # then bounce to a clean URL so the PII doesn't stick around in the address bar.
    if _seed_session_from_args(target):
        return redirect(url_for("public.target_action", slug=slug, target_id=target_id))

    writer = _writer_from_session()
    parameters = _parameters_from_session(target)
    consents = _consents_from_session()
    # The head form asks for the whole chain's parameters at once; `answers`
    # holds every value the writer has entered, keyed by parameter key.
    form_parameters = target.chain_parameters()
    answers = dict(session.get("answers", {}))
    chain = target.chain()
    next_target = target.next_target

    # No writer info yet → just show the form. Skip the artifact-rendering pass.
    if not writer.name:
        return render_template(
            "public/target_action.html",
            campaign=campaign,
            target=target,
            writer=writer,
            artifact_views=[],
            parameter_values=answers,
            form_parameters=form_parameters,
            chain=chain,
            next_target=next_target,
            consents=consents,
            ready=False,
        )

    artifact_views = []
    for artifact in target.artifacts:
        eligible = [
            r for r in target.recipients
            if (artifact.kind == Artifact.KIND_EMAIL and r.has_email)
            or (artifact.kind == Artifact.KIND_LETTER and r.has_address)
        ]
        if not eligible:
            continue

        per_recipient = []
        for recipient in eligible:
            rendered_subject = render(
                artifact.subject,
                writer=writer,
                recipient=recipient,
                target=target,
                parameters=parameters,
            )
            rendered_body = render(
                artifact.body,
                writer=writer,
                recipient=recipient,
                target=target,
                parameters=parameters,
            )
            per_recipient.append(
                {
                    "recipient": recipient,
                    "subject": rendered_subject,
                    "body": rendered_body,
                    "mailto": _mailto(recipient.email, rendered_subject, rendered_body)
                    if artifact.kind == Artifact.KIND_EMAIL
                    else None,
                }
            )

        # Preview using the first eligible recipient as a representative sample.
        sample = eligible[0]
        sample_subject_html = (
            markers_to_html(
                render_with_highlights(
                    artifact.subject,
                    writer=writer,
                    recipient=sample,
                    target=target,
                    parameters=parameters,
                )
            )
            if artifact.subject
            else ""
        )
        sample_body_html = markers_to_html(
            render_with_highlights(
                artifact.body,
                writer=writer,
                recipient=sample,
                target=target,
                parameters=parameters,
            )
        )

        artifact_views.append(
            {
                "artifact": artifact,
                "sample_recipient": sample,
                "sample_subject_html": sample_subject_html,
                "sample_body_html": sample_body_html,
                "per_recipient": per_recipient,
            }
        )

    return render_template(
        "public/target_action.html",
        campaign=campaign,
        target=target,
        writer=writer,
        artifact_views=artifact_views,
        parameter_values=answers,
        form_parameters=form_parameters,
        chain=chain,
        next_target=next_target,
        consents=consents,
        ready=True,
    )


@bp.route("/c/<slug>/t/<int:target_id>/preview")
def target_preview(slug: str, target_id: int):
    """Standalone example of this target's letters/emails, rendered with
    fixed sample data so a writer can see what they'll produce before
    filling in their own details. Opened in a popup from the action page;
    the real details get substituted once the writer fills in the form.
    """
    campaign = _load_campaign_or_404(slug)
    target = db.session.get(Target, target_id) or abort(404)
    if target.campaign_id != campaign.id:
        abort(404)

    previews = []
    for artifact in target.artifacts:
        # Sample data; admin-authored templates so errors are unexpected,
        # but a single bad artifact shouldn't blank out the whole preview.
        try:
            subject_html = (
                markers_to_html(render_for_preview(artifact.subject))
                if artifact.subject
                else ""
            )
            body_html = markers_to_html(render_for_preview(artifact.body))
        except Exception:  # pragma: no cover - defensive
            continue
        previews.append(
            {
                "artifact": artifact,
                "subject_html": subject_html,
                "body_html": body_html,
            }
        )

    return render_template(
        "public/preview.html",
        campaign=campaign,
        target=target,
        previews=previews,
    )


@bp.route("/c/<slug>/t/<int:target_id>/track", methods=["POST"])
def track_action(slug: str, target_id: int):
    """Beacon endpoint for client-side mailto clicks. Body: JSON with
    ``artifact_id`` and ``recipient_ids`` (list). Silently no-ops if the
    respondent cookie is missing or the IDs don't belong to this target —
    we don't want a bad payload to break the user's send flow.
    """
    campaign = _load_campaign_or_404(slug)
    target = db.session.get(Target, target_id) or abort(404)
    if target.campaign_id != campaign.id:
        abort(404)

    respondent_id = _current_respondent_id()
    if respondent_id is None:
        return ("", 204)

    payload = request.get_json(silent=True) or {}
    artifact_id = payload.get("artifact_id")
    raw_recipient_ids = payload.get("recipient_ids") or []
    if not isinstance(artifact_id, int) or not isinstance(raw_recipient_ids, list):
        return ("", 204)

    artifact = db.session.get(Artifact, artifact_id)
    if artifact is None or artifact.target_id != target.id:
        return ("", 204)

    valid_recipient_ids = {r.id for r in target.recipients}
    recipient_ids = [
        rid for rid in raw_recipient_ids
        if isinstance(rid, int) and rid in valid_recipient_ids
    ]
    _log_actions(respondent_id, campaign, target, artifact, recipient_ids)
    return ("", 204)


@bp.route("/c/<slug>/t/<int:target_id>/done")
def target_done(slug: str, target_id: int):
    campaign = _load_campaign_or_404(slug)
    target = db.session.get(Target, target_id) or abort(404)
    if target.campaign_id != campaign.id:
        abort(404)
    return render_template(
        "public/thank_you.html",
        campaign=campaign,
        target=target,
    )


@bp.route("/c/<slug>/t/<int:target_id>/print/<int:artifact_id>")
def print_letters(slug: str, target_id: int, artifact_id: int):
    campaign = _load_campaign_or_404(slug)
    if not campaign.active:
        return redirect(url_for("public.campaign", slug=slug))
    target = db.session.get(Target, target_id) or abort(404)
    artifact = db.session.get(Artifact, artifact_id) or abort(404)
    if target.campaign_id != campaign.id or artifact.target_id != target.id:
        abort(404)
    writer = _writer_from_session()
    parameters = _parameters_from_session(target)
    if not writer.name or _missing_required(target, parameters):
        return redirect(url_for("public.target_action", slug=slug, target_id=target_id))

    letters = []
    for recipient in target.recipients:
        if artifact.kind == Artifact.KIND_LETTER and not recipient.has_address:
            continue
        body = render(
            artifact.body,
            writer=writer,
            recipient=recipient,
            target=target,
            parameters=parameters,
        )
        body_html = markers_to_html(
            render_with_highlights(
                artifact.body,
                writer=writer,
                recipient=recipient,
                target=target,
                parameters=parameters,
            )
        )
        letters.append({"recipient": recipient, "body": body, "body_html": body_html})

    respondent_id = _current_respondent_id()
    if respondent_id is not None:
        _log_actions(
            respondent_id,
            campaign,
            target,
            artifact,
            [letter["recipient"].id for letter in letters],
        )

    return render_template(
        "public/print_letters.html",
        campaign=campaign,
        target=target,
        artifact=artifact,
        writer=writer,
        letters=letters,
    )


@bp.route("/c/<slug>/t/<int:target_id>/pdf/<int:artifact_id>")
def letters_pdf(slug: str, target_id: int, artifact_id: int):
    campaign = _load_campaign_or_404(slug)
    if not campaign.active:
        return redirect(url_for("public.campaign", slug=slug))
    target = db.session.get(Target, target_id) or abort(404)
    artifact = db.session.get(Artifact, artifact_id) or abort(404)
    if target.campaign_id != campaign.id or artifact.target_id != target.id:
        abort(404)
    writer = _writer_from_session()
    parameters = _parameters_from_session(target)
    if not writer.name or _missing_required(target, parameters):
        return redirect(url_for("public.target_action", slug=slug, target_id=target_id))

    bodies = []
    eligible_recipient_ids: list[int] = []
    for recipient in target.recipients:
        if artifact.kind == Artifact.KIND_LETTER and not recipient.has_address:
            continue
        bodies.append(
            render(
                artifact.body,
                writer=writer,
                recipient=recipient,
                target=target,
                parameters=parameters,
            )
        )
        eligible_recipient_ids.append(recipient.id)

    if not bodies:
        abort(404)

    respondent_id = _current_respondent_id()
    if respondent_id is not None:
        _log_actions(respondent_id, campaign, target, artifact, eligible_recipient_ids)

    pdf_bytes = render_letters_pdf(
        bodies,
        title=f"{campaign.name} — letters to {target.name}",
    )

    safe = re.sub(r"[^A-Za-z0-9]+", "_", target.name).strip("_")[:50] or "letters"
    filename = f"{campaign.slug}_{safe}.pdf"
    return Response(
        pdf_bytes,
        mimetype="application/pdf",
        headers={"Content-Disposition": f'inline; filename="{filename}"'},
    )


def _mailto(to_addr: str, subject: str, body: str) -> str:
    params = urlencode({"subject": subject, "body": body}, quote_via=quote)
    return f"mailto:{quote(to_addr)}?{params}"
