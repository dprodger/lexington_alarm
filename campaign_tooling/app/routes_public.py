"""Public letter-writer flow.

Three-step flow:
  1. /                                — list active campaigns
  2. /c/<slug>                        — campaign detail + writer info form
  3. /c/<slug>/action                 — per-target action page
                                         (mailto links and printable letters)
  4. /c/<slug>/print/<target_id>/<artifact_id>
                                       — printable single letter view

Writer info is held in the URL query string (no DB persistence) so the
flow is shareable, restartable, and stateless. We can revisit if/when we
add tracking.
"""

from __future__ import annotations

from urllib.parse import quote, urlencode

from flask import Blueprint, abort, redirect, render_template, request, url_for

from .extensions import db
from .models import Artifact, Campaign, Target
from .substitution import Writer, render

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


@bp.route("/")
def index():
    campaigns = db.session.scalars(
        db.select(Campaign).where(Campaign.active.is_(True)).order_by(Campaign.name)
    ).all()
    return render_template("public/index.html", campaigns=campaigns)


@bp.route("/c/<slug>", methods=["GET", "POST"])
def campaign(slug: str):
    campaign = db.session.scalar(db.select(Campaign).where(Campaign.slug == slug))
    if campaign is None or not campaign.active:
        abort(404)
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
            url_for("public.action", slug=slug) + "?" + urlencode(_writer_query(writer))
        )
    writer = _writer_from_args()
    return render_template("public/campaign.html", campaign=campaign, writer=writer)


@bp.route("/c/<slug>/action")
def action(slug: str):
    campaign = db.session.scalar(db.select(Campaign).where(Campaign.slug == slug))
    if campaign is None or not campaign.active:
        abort(404)
    writer = _writer_from_args()
    if not writer.name:
        # No writer info — bounce back to the form.
        return redirect(url_for("public.campaign", slug=slug))

    rows = []
    for target in campaign.targets:
        per_artifact = []
        for artifact in campaign.artifacts:
            if artifact.kind == Artifact.KIND_EMAIL and not target.has_email:
                continue
            if artifact.kind == Artifact.KIND_LETTER and not target.has_address:
                continue
            rendered_subject = render(artifact.subject, writer=writer, target=target)
            rendered_body = render(artifact.body, writer=writer, target=target)
            per_artifact.append(
                {
                    "artifact": artifact,
                    "subject": rendered_subject,
                    "body": rendered_body,
                    "mailto": _mailto(target.email, rendered_subject, rendered_body)
                    if artifact.kind == Artifact.KIND_EMAIL
                    else None,
                }
            )
        if per_artifact:
            # Key is "entries" not "items" — dicts already have an .items() method
            # and Jinja's `row.items` would resolve to the method, not this list.
            rows.append({"target": target, "entries": per_artifact})

    return render_template(
        "public/action.html",
        campaign=campaign,
        writer=writer,
        rows=rows,
        writer_query=_writer_query(writer),
    )


@bp.route("/c/<slug>/print/<int:target_id>/<int:artifact_id>")
def print_letter(slug: str, target_id: int, artifact_id: int):
    campaign = db.session.scalar(db.select(Campaign).where(Campaign.slug == slug))
    if campaign is None or not campaign.active:
        abort(404)
    target = db.session.get(Target, target_id) or abort(404)
    artifact = db.session.get(Artifact, artifact_id) or abort(404)
    if target.campaign_id != campaign.id or artifact.campaign_id != campaign.id:
        abort(404)
    writer = _writer_from_args()
    if not writer.name:
        return redirect(url_for("public.campaign", slug=slug))
    body = render(artifact.body, writer=writer, target=target)
    return render_template(
        "public/print_letter.html",
        campaign=campaign,
        target=target,
        artifact=artifact,
        writer=writer,
        body=body,
    )


def _mailto(to_addr: str, subject: str, body: str) -> str:
    params = urlencode({"subject": subject, "body": body}, quote_via=quote)
    return f"mailto:{quote(to_addr)}?{params}"
