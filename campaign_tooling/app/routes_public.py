"""Public letter-writer flow.

Navigation: campaign → target → recipient.

  1. /                                    — list active campaigns
  2. /c/<slug>                            — campaign detail + writer info form
  3. /c/<slug>/targets                    — list of targets (audiences) within
                                            the campaign
  4. /c/<slug>/t/<target_id>              — per-target action page (recipients
                                            and artifacts; "send all" buttons)
  5. /c/<slug>/t/<target_id>/print/<artifact_id>
                                          — printable view, one page per
                                            recipient, for a letter artifact
  6. /c/<slug>/t/<target_id>/pdf/<artifact_id>
                                          — combined PDF, one page per
                                            recipient

Writer info is held in the URL query string (no DB persistence) so the
flow is shareable, restartable, and stateless.
"""

from __future__ import annotations

import re
from urllib.parse import quote, urlencode

from flask import Blueprint, Response, abort, redirect, render_template, request, url_for

from .extensions import db
from .models import Artifact, Campaign, Target
from .pdf import render_letters_pdf
from .substitution import Writer, markers_to_html, render, render_with_highlights

bp = Blueprint("public", __name__, template_folder="templates")


def _writer_from_args() -> Writer:
    a = request.args
    return Writer(
        name=a.get("name", "").strip(),
        email=a.get("email", "").strip(),
        street1=a.get("street1", "").strip(),
        street2=a.get("street2", "").strip(),
        city=a.get("city", "").strip(),
        state=a.get("state", "").strip(),
        postal_code=a.get("postal_code", "").strip(),
        organization=a.get("organization", "").strip(),
    )


def _writer_query(writer: Writer) -> dict:
    return {
        k: v
        for k, v in {
            "name": writer.name,
            "email": writer.email,
            "street1": writer.street1,
            "street2": writer.street2,
            "city": writer.city,
            "state": writer.state,
            "postal_code": writer.postal_code,
            "organization": writer.organization,
        }.items()
        if v
    }


def _load_campaign_or_404(slug: str) -> Campaign:
    campaign = db.session.scalar(db.select(Campaign).where(Campaign.slug == slug))
    if campaign is None:
        abort(404)
    return campaign


@bp.route("/")
def index():
    campaigns = db.session.scalars(
        db.select(Campaign)
        .where(Campaign.active.is_(True))
        .order_by(Campaign.sort_order, Campaign.name)
    ).all()
    return render_template("public/index.html", campaigns=campaigns)


@bp.route("/c/<slug>", methods=["GET", "POST"])
def campaign(slug: str):
    campaign = _load_campaign_or_404(slug)
    if not campaign.active:
        return render_template("public/inactive.html", campaign=campaign), 410
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
        return redirect(
            url_for("public.targets", slug=slug) + "?" + urlencode(_writer_query(writer))
        )
    writer = _writer_from_args()
    return render_template("public/campaign.html", campaign=campaign, writer=writer)


@bp.route("/c/<slug>/targets")
def targets(slug: str):
    campaign = _load_campaign_or_404(slug)
    if not campaign.active:
        return redirect(url_for("public.campaign", slug=slug))
    writer = _writer_from_args()
    if not writer.name:
        return redirect(url_for("public.campaign", slug=slug))
    return render_template(
        "public/targets.html",
        campaign=campaign,
        writer=writer,
        writer_query=_writer_query(writer),
    )


@bp.route("/c/<slug>/t/<int:target_id>")
def target_action(slug: str, target_id: int):
    campaign = _load_campaign_or_404(slug)
    if not campaign.active:
        return redirect(url_for("public.campaign", slug=slug))
    target = db.session.get(Target, target_id) or abort(404)
    if target.campaign_id != campaign.id:
        abort(404)
    writer = _writer_from_args()
    if not writer.name:
        return redirect(url_for("public.campaign", slug=slug))

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
                artifact.subject, writer=writer, recipient=recipient, target=target
            )
            rendered_body = render(
                artifact.body, writer=writer, recipient=recipient, target=target
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
                    artifact.subject, writer=writer, recipient=sample, target=target
                )
            )
            if artifact.subject
            else ""
        )
        sample_body_html = markers_to_html(
            render_with_highlights(artifact.body, writer=writer, recipient=sample, target=target)
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
        writer_query=_writer_query(writer),
        artifact_views=artifact_views,
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
    writer = _writer_from_args()
    if not writer.name:
        return redirect(url_for("public.campaign", slug=slug))

    letters = []
    for recipient in target.recipients:
        if artifact.kind == Artifact.KIND_LETTER and not recipient.has_address:
            continue
        body = render(artifact.body, writer=writer, recipient=recipient, target=target)
        body_html = markers_to_html(
            render_with_highlights(artifact.body, writer=writer, recipient=recipient, target=target)
        )
        letters.append({"recipient": recipient, "body": body, "body_html": body_html})

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
    writer = _writer_from_args()
    if not writer.name:
        return redirect(url_for("public.campaign", slug=slug))

    bodies = []
    for recipient in target.recipients:
        if artifact.kind == Artifact.KIND_LETTER and not recipient.has_address:
            continue
        bodies.append(render(artifact.body, writer=writer, recipient=recipient, target=target))

    if not bodies:
        abort(404)

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
