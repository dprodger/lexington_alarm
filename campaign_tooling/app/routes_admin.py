"""Admin views.

Auth here is intentionally crude — a shared `ADMIN_TOKEN` from .env. Real
auth (Supabase Auth, Flask-Login + Postgres users, or HTTP Basic) is a
TODO before this goes anywhere near production.
"""

from __future__ import annotations

import re
from functools import wraps

from flask import (
    Blueprint,
    abort,
    current_app,
    flash,
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
    CampaignResource,
    ParameterChoice,
    Recipient,
    Respondent,
    RespondentParameter,
    Target,
    TargetParameter,
)
from .substitution import preview_to_html, render_for_preview

bp = Blueprint("admin", __name__, template_folder="templates")


# Base schema offered to the in-page autocomplete helper on the artifact
# body / subject fields. Keep this in sync with substitution.Writer /
# models.Recipient and the date variables passed into substitution.render().
# A `null` entry means "leaf — no further attributes." The `parameter` scope
# is added per-target by `_placeholder_schema_for(target)` when the target
# has any parameters defined.
_BASE_PLACEHOLDER_SCHEMA: dict = {
    "writer": [
        "name", "email", "organization",
        "street1", "street2", "city", "state", "postal_code",
        "address_block",
    ],
    "recipient": [
        "formal_name", "first_name", "last_name", "salutation",
        "title", "organization", "email",
        "street1", "street2", "city", "state", "postal_code",
        "address_block",
    ],
    "target": ["name", "description"],
    "date": None,
    "date_long": None,
}


def _placeholder_schema_for(target: Target) -> dict:
    schema = dict(_BASE_PLACEHOLDER_SCHEMA)
    if target.parameters:
        schema["parameter"] = [p.key for p in target.parameters]
    return schema


_PARAM_KEY_RE = re.compile(r"^[a-z][a-z0-9_]*$")


def _require_admin(view):
    @wraps(view)
    def wrapper(*args, **kwargs):
        if not session.get("is_admin"):
            return redirect(url_for("admin.login", next=request.path))
        return view(*args, **kwargs)

    return wrapper


@bp.route("/login", methods=["GET", "POST"])
def login():
    expected = current_app.config.get("ADMIN_TOKEN", "")
    if request.method == "POST":
        token = request.form.get("token", "")
        if expected and token == expected:
            session["is_admin"] = True
            return redirect(request.args.get("next") or url_for("admin.index"))
        flash("Invalid token.", "error")
    return render_template("admin/login.html")


@bp.route("/logout", methods=["POST"])
def logout():
    session.pop("is_admin", None)
    return redirect(url_for("public.index"))


@bp.route("/")
@_require_admin
def index():
    campaigns = db.session.scalars(
        db.select(Campaign).order_by(Campaign.sort_order, Campaign.name)
    ).all()
    return render_template("admin/index.html", campaigns=campaigns)


# --- Campaigns ------------------------------------------------------------


def _apply_campaign_form(c: Campaign, form) -> None:
    """Update editable fields from the form. ``sort_order`` is not edited
    via the form; it's managed by the drag-and-drop reorder route below.
    """
    c.slug = form["slug"].strip()
    c.name = form["name"].strip()
    c.subhead = form.get("subhead", "").strip()
    c.description = form.get("description", "").strip()
    c.body_md = form.get("body_md", "")
    c.action_header = form.get("action_header", "").strip()
    c.action_blurb = form.get("action_blurb", "").strip()
    c.active = "active" in form
    c.theme = form.get("theme", Campaign.THEME_DEFAULT).strip() or Campaign.THEME_DEFAULT


def _next_sort_order(rows) -> int:
    return (max((r.sort_order for r in rows), default=-1) + 1)


def _apply_reorder(model, valid_ids: set, raw_ids) -> None:
    """Renumber ``sort_order`` on rows of ``model`` that appear in
    ``raw_ids``. Skips ids not present in ``valid_ids`` to keep one
    parent's reorder request from touching another parent's rows.
    """
    for index, raw in enumerate(raw_ids):
        try:
            row_id = int(raw)
        except (TypeError, ValueError):
            continue
        if row_id not in valid_ids:
            continue
        row = db.session.get(model, row_id)
        if row is not None:
            row.sort_order = index
    db.session.commit()


@bp.route("/campaigns/new", methods=["GET", "POST"])
@_require_admin
def campaign_new():
    if request.method == "POST":
        c = Campaign(slug=request.form["slug"].strip(), name=request.form["name"].strip())
        _apply_campaign_form(c, request.form)
        existing = db.session.scalars(db.select(Campaign)).all()
        c.sort_order = _next_sort_order(existing)
        db.session.add(c)
        db.session.commit()
        flash("Campaign created.", "success")
        return redirect(url_for("admin.campaign_edit", campaign_id=c.id))
    return render_template("admin/campaign_form.html", campaign=None, themes=Campaign.THEMES)


@bp.route("/campaigns/reorder", methods=["POST"])
@_require_admin
def campaigns_reorder():
    valid = {c.id for c in db.session.scalars(db.select(Campaign)).all()}
    _apply_reorder(Campaign, valid, request.form.getlist("ids[]"))
    return ("", 204)


@bp.route("/campaigns/<int:campaign_id>", methods=["GET", "POST"])
@_require_admin
def campaign_edit(campaign_id: int):
    campaign = db.session.get(Campaign, campaign_id) or abort(404)
    if request.method == "POST":
        _apply_campaign_form(campaign, request.form)
        db.session.commit()
        flash("Saved.", "success")
        return redirect(url_for("admin.campaign_edit", campaign_id=campaign.id))
    target_ids = [t.id for t in campaign.targets]
    respondent_counts: dict[int, int] = {}
    if target_ids:
        respondent_counts = dict(
            db.session.execute(
                db.select(Respondent.target_id, db.func.count(Respondent.id))
                .where(Respondent.target_id.in_(target_ids))
                .group_by(Respondent.target_id)
            ).all()
        )
    return render_template(
        "admin/campaign_form.html",
        campaign=campaign,
        respondent_counts=respondent_counts,
        themes=Campaign.THEMES,
    )


@bp.route("/campaigns/<int:campaign_id>/delete", methods=["POST"])
@_require_admin
def campaign_delete(campaign_id: int):
    campaign = db.session.get(Campaign, campaign_id) or abort(404)
    db.session.delete(campaign)
    db.session.commit()
    flash("Deleted.", "success")
    return redirect(url_for("admin.index"))


# --- Targets --------------------------------------------------------------


def _apply_target_form(target: Target, form) -> None:
    """Update name/description from the form. Sort order is not edited
    via the form; it's managed by the drag-and-drop reorder route below.
    """
    target.name = form.get("name", "").strip()
    target.description = form.get("description", "").strip()
    target.source_url = form.get("source_url", "").strip()


@bp.route("/campaigns/<int:campaign_id>/targets/new", methods=["POST"])
@_require_admin
def target_new(campaign_id: int):
    campaign = db.session.get(Campaign, campaign_id) or abort(404)
    target = Target(campaign_id=campaign.id, name=request.form.get("name", "").strip() or "Untitled")
    _apply_target_form(target, request.form)
    target.sort_order = _next_sort_order(campaign.targets)
    db.session.add(target)
    db.session.commit()
    flash("Target added.", "success")
    return redirect(url_for("admin.target_edit", target_id=target.id))


@bp.route("/campaigns/<int:campaign_id>/targets/reorder", methods=["POST"])
@_require_admin
def targets_reorder(campaign_id: int):
    campaign = db.session.get(Campaign, campaign_id) or abort(404)
    _apply_reorder(Target, {t.id for t in campaign.targets}, request.form.getlist("ids[]"))
    return ("", 204)


@bp.route("/targets/<int:target_id>", methods=["GET", "POST"])
@_require_admin
def target_edit(target_id: int):
    target = db.session.get(Target, target_id) or abort(404)
    if request.method == "POST":
        _apply_target_form(target, request.form)
        db.session.commit()
        flash("Saved.", "success")
        return redirect(url_for("admin.target_edit", target_id=target.id))
    return render_template(
        "admin/target_form.html",
        target=target,
        placeholder_schema=_placeholder_schema_for(target),
    )


@bp.route("/targets/<int:target_id>/delete", methods=["POST"])
@_require_admin
def target_delete(target_id: int):
    target = db.session.get(Target, target_id) or abort(404)
    campaign_id = target.campaign_id
    db.session.delete(target)
    db.session.commit()
    flash("Target deleted.", "success")
    return redirect(url_for("admin.campaign_edit", campaign_id=campaign_id))


@bp.route("/targets/<int:target_id>/respondents")
@_require_admin
def target_respondents(target_id: int):
    target = db.session.get(Target, target_id) or abort(404)
    respondents = db.session.scalars(
        db.select(Respondent)
        .where(Respondent.target_id == target_id)
        .order_by(Respondent.created_at.desc(), Respondent.id.desc())
    ).all()
    # (respondent_id, parameter_id) -> value, for O(1) lookup while
    # rendering one column per TargetParameter.
    param_values: dict[tuple[int, int], str] = {
        (rp.respondent_id, rp.parameter_id): rp.value
        for rp in db.session.scalars(
            db.select(RespondentParameter).where(
                RespondentParameter.target_id == target_id
            )
        ).all()
    }
    return render_template(
        "admin/target_respondents.html",
        campaign=target.campaign,
        target=target,
        respondents=respondents,
        param_values=param_values,
    )


# --- Recipients -----------------------------------------------------------


def _apply_recipient_form(recipient: Recipient, form) -> None:
    for field in (
        "formal_name",
        "first_name",
        "last_name",
        "salutation",
        "title",
        "organization",
        "email",
        "street1",
        "street2",
        "city",
        "state",
        "postal_code",
    ):
        setattr(recipient, field, form.get(field, "").strip())


@bp.route("/targets/<int:target_id>/recipients/new", methods=["POST"])
@_require_admin
def recipient_new(target_id: int):
    target = db.session.get(Target, target_id) or abort(404)
    recipient = Recipient(
        target_id=target.id,
        formal_name=request.form.get("formal_name", "").strip(),
    )
    _apply_recipient_form(recipient, request.form)
    recipient.sort_order = _next_sort_order(target.recipients)
    db.session.add(recipient)
    db.session.commit()
    return redirect(url_for("admin.target_edit", target_id=target.id))


@bp.route("/targets/<int:target_id>/recipients/reorder", methods=["POST"])
@_require_admin
def recipients_reorder(target_id: int):
    target = db.session.get(Target, target_id) or abort(404)
    _apply_reorder(Recipient, {r.id for r in target.recipients}, request.form.getlist("ids[]"))
    return ("", 204)


@bp.route("/recipients/<int:recipient_id>/edit", methods=["POST"])
@_require_admin
def recipient_edit(recipient_id: int):
    recipient = db.session.get(Recipient, recipient_id) or abort(404)
    _apply_recipient_form(recipient, request.form)
    db.session.commit()
    return redirect(url_for("admin.target_edit", target_id=recipient.target_id))


@bp.route("/recipients/<int:recipient_id>/delete", methods=["POST"])
@_require_admin
def recipient_delete(recipient_id: int):
    recipient = db.session.get(Recipient, recipient_id) or abort(404)
    target_id = recipient.target_id
    db.session.delete(recipient)
    db.session.commit()
    return redirect(url_for("admin.target_edit", target_id=target_id))


# --- Parameters -----------------------------------------------------------


def _apply_parameter_form(parameter: TargetParameter, form) -> str | None:
    """Mutate `parameter` from `form`. Returns an error message string, or
    None on success. Caller is responsible for committing.
    """
    raw_key = form.get("key", "").strip().lower()
    if not _PARAM_KEY_RE.match(raw_key):
        return "Key must start with a lowercase letter and contain only lowercase letters, digits, and underscores."

    # Reject duplicate keys within the same target.
    sibling = db.session.scalar(
        db.select(TargetParameter).where(
            TargetParameter.target_id == parameter.target_id,
            TargetParameter.key == raw_key,
            TargetParameter.id != (parameter.id or -1),
        )
    )
    if sibling is not None:
        return f"Another parameter on this target already uses the key '{raw_key}'."

    parameter.key = raw_key
    parameter.label = form.get("label", "").strip()
    parameter.help_text = form.get("help_text", "").strip()
    parameter.required = "required" in form
    raw_kind = form.get("kind", TargetParameter.KIND_TEXT)
    parameter.kind = raw_kind if raw_kind in (
        TargetParameter.KIND_TEXT, TargetParameter.KIND_SELECT
    ) else TargetParameter.KIND_TEXT
    return None


@bp.route("/targets/<int:target_id>/parameters/new", methods=["POST"])
@_require_admin
def parameter_new(target_id: int):
    target = db.session.get(Target, target_id) or abort(404)
    parameter = TargetParameter(target_id=target.id)
    error = _apply_parameter_form(parameter, request.form)
    if error:
        flash(error, "error")
        return redirect(url_for("admin.target_edit", target_id=target.id))
    parameter.sort_order = _next_sort_order(target.parameters)
    db.session.add(parameter)
    db.session.commit()
    flash("Parameter added.", "success")
    return redirect(url_for("admin.target_edit", target_id=target.id))


@bp.route("/targets/<int:target_id>/parameters/reorder", methods=["POST"])
@_require_admin
def parameters_reorder(target_id: int):
    target = db.session.get(Target, target_id) or abort(404)
    _apply_reorder(TargetParameter, {p.id for p in target.parameters}, request.form.getlist("ids[]"))
    return ("", 204)


@bp.route("/parameters/<int:parameter_id>/edit", methods=["POST"])
@_require_admin
def parameter_edit(parameter_id: int):
    parameter = db.session.get(TargetParameter, parameter_id) or abort(404)
    error = _apply_parameter_form(parameter, request.form)
    if error:
        flash(error, "error")
    else:
        db.session.commit()
    return redirect(url_for("admin.target_edit", target_id=parameter.target_id))


@bp.route("/parameters/<int:parameter_id>/delete", methods=["POST"])
@_require_admin
def parameter_delete(parameter_id: int):
    parameter = db.session.get(TargetParameter, parameter_id) or abort(404)
    target_id = parameter.target_id
    db.session.delete(parameter)
    db.session.commit()
    return redirect(url_for("admin.target_edit", target_id=target_id))


# --- Parameter choices ---------------------------------------------------


def _apply_choice_form(choice: ParameterChoice, form) -> str | None:
    value = form.get("value", "").strip()
    if not value:
        return "Stored value is required."
    sibling = db.session.scalar(
        db.select(ParameterChoice).where(
            ParameterChoice.parameter_id == choice.parameter_id,
            ParameterChoice.value == value,
            ParameterChoice.id != (choice.id or -1),
        )
    )
    if sibling is not None:
        return f"Another choice on this parameter already uses the value '{value}'."
    choice.value = value
    choice.label = form.get("label", "").strip()
    return None


@bp.route("/parameters/<int:parameter_id>/choices/new", methods=["POST"])
@_require_admin
def choice_new(parameter_id: int):
    parameter = db.session.get(TargetParameter, parameter_id) or abort(404)
    choice = ParameterChoice(parameter_id=parameter.id)
    error = _apply_choice_form(choice, request.form)
    if error:
        flash(error, "error")
        return redirect(url_for("admin.target_edit", target_id=parameter.target_id))
    choice.sort_order = _next_sort_order(parameter.choices)
    db.session.add(choice)
    db.session.commit()
    return redirect(url_for("admin.target_edit", target_id=parameter.target_id))


@bp.route("/choices/<int:choice_id>/edit", methods=["POST"])
@_require_admin
def choice_edit(choice_id: int):
    choice = db.session.get(ParameterChoice, choice_id) or abort(404)
    error = _apply_choice_form(choice, request.form)
    if error:
        flash(error, "error")
    else:
        db.session.commit()
    return redirect(url_for("admin.target_edit", target_id=choice.parameter.target_id))


@bp.route("/choices/<int:choice_id>/delete", methods=["POST"])
@_require_admin
def choice_delete(choice_id: int):
    choice = db.session.get(ParameterChoice, choice_id) or abort(404)
    target_id = choice.parameter.target_id
    db.session.delete(choice)
    db.session.commit()
    return redirect(url_for("admin.target_edit", target_id=target_id))


@bp.route("/parameters/<int:parameter_id>/choices/reorder", methods=["POST"])
@_require_admin
def choices_reorder(parameter_id: int):
    parameter = db.session.get(TargetParameter, parameter_id) or abort(404)
    _apply_reorder(ParameterChoice, {c.id for c in parameter.choices}, request.form.getlist("ids[]"))
    return ("", 204)


# --- Artifacts ------------------------------------------------------------


def _apply_artifact_form(artifact: Artifact, form) -> None:
    artifact.name = form.get("name", "").strip() or "Untitled"
    kind = form.get("kind", Artifact.KIND_EMAIL)
    artifact.kind = kind if kind in (Artifact.KIND_EMAIL, Artifact.KIND_LETTER) else Artifact.KIND_EMAIL
    artifact.subject = form.get("subject", "").strip()
    artifact.body = form.get("body", "")


@bp.route("/targets/<int:target_id>/artifacts/new", methods=["POST"])
@_require_admin
def artifact_new(target_id: int):
    target = db.session.get(Target, target_id) or abort(404)
    artifact = Artifact(target_id=target.id, name=request.form.get("name", "").strip() or "Untitled")
    _apply_artifact_form(artifact, request.form)
    artifact.sort_order = _next_sort_order(target.artifacts)
    db.session.add(artifact)
    db.session.commit()
    return redirect(url_for("admin.target_edit", target_id=target.id))


@bp.route("/targets/<int:target_id>/artifacts/reorder", methods=["POST"])
@_require_admin
def artifacts_reorder(target_id: int):
    target = db.session.get(Target, target_id) or abort(404)
    _apply_reorder(Artifact, {a.id for a in target.artifacts}, request.form.getlist("ids[]"))
    return ("", 204)


@bp.route("/artifacts/<int:artifact_id>/edit", methods=["POST"])
@_require_admin
def artifact_edit(artifact_id: int):
    artifact = db.session.get(Artifact, artifact_id) or abort(404)
    _apply_artifact_form(artifact, request.form)
    db.session.commit()
    return redirect(url_for("admin.target_edit", target_id=artifact.target_id))


@bp.route("/artifacts/<int:artifact_id>/delete", methods=["POST"])
@_require_admin
def artifact_delete(artifact_id: int):
    artifact = db.session.get(Artifact, artifact_id) or abort(404)
    target_id = artifact.target_id
    db.session.delete(artifact)
    db.session.commit()
    return redirect(url_for("admin.target_edit", target_id=target_id))


# --- Resources ------------------------------------------------------------


def _apply_resource_form(resource: CampaignResource, form) -> str | None:
    name = form.get("name", "").strip()
    if not name:
        return "Resource name is required."
    raw_category = form.get("category", "")
    if raw_category not in CampaignResource.CATEGORY_LABELS:
        return f"Unknown category: {raw_category!r}."
    resource.category = raw_category
    resource.name = name
    resource.url = form.get("url", "").strip()
    return None


@bp.route("/campaigns/<int:campaign_id>/resources/new", methods=["POST"])
@_require_admin
def resource_new(campaign_id: int):
    campaign = db.session.get(Campaign, campaign_id) or abort(404)
    resource = CampaignResource(campaign_id=campaign.id)
    error = _apply_resource_form(resource, request.form)
    if error:
        flash(error, "error")
        return redirect(url_for("admin.campaign_edit", campaign_id=campaign.id))
    resource.sort_order = _next_sort_order(campaign.resources)
    db.session.add(resource)
    db.session.commit()
    flash("Resource added.", "success")
    return redirect(url_for("admin.campaign_edit", campaign_id=campaign.id))


@bp.route("/campaigns/<int:campaign_id>/resources/reorder", methods=["POST"])
@_require_admin
def resources_reorder(campaign_id: int):
    campaign = db.session.get(Campaign, campaign_id) or abort(404)
    _apply_reorder(CampaignResource, {r.id for r in campaign.resources}, request.form.getlist("ids[]"))
    return ("", 204)


@bp.route("/resources/<int:resource_id>/edit", methods=["POST"])
@_require_admin
def resource_edit(resource_id: int):
    resource = db.session.get(CampaignResource, resource_id) or abort(404)
    error = _apply_resource_form(resource, request.form)
    if error:
        flash(error, "error")
    else:
        db.session.commit()
    return redirect(url_for("admin.campaign_edit", campaign_id=resource.campaign_id))


@bp.route("/resources/<int:resource_id>/delete", methods=["POST"])
@_require_admin
def resource_delete(resource_id: int):
    resource = db.session.get(CampaignResource, resource_id) or abort(404)
    campaign_id = resource.campaign_id
    db.session.delete(resource)
    db.session.commit()
    return redirect(url_for("admin.campaign_edit", campaign_id=campaign_id))


@bp.route("/preview", methods=["POST"])
@_require_admin
def artifact_preview():
    """Render an unsaved artifact body with test data, highlighting substitutions."""
    name = request.form.get("name", "").strip() or "Untitled artifact"
    kind = request.form.get("kind", Artifact.KIND_EMAIL)
    subject = request.form.get("subject", "").strip()
    body = request.form.get("body", "")

    try:
        body_marked = render_for_preview(body)
        subject_marked = render_for_preview(subject) if subject else ""
        body_html = preview_to_html(body_marked)
        subject_html = preview_to_html(subject_marked) if subject_marked else ""
        error = None
    except Exception as exc:  # noqa: BLE001 — surface any Jinja error to the admin
        body_html = subject_html = ""
        error = f"{type(exc).__name__}: {exc}"

    return render_template(
        "admin/preview.html",
        name=name,
        kind=kind,
        subject_html=subject_html,
        body_html=body_html,
        error=error,
    )
