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
from .models import Artifact, Campaign, Recipient, Target, TargetParameter
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
    c.slug = form["slug"].strip()
    c.name = form["name"].strip()
    c.subhead = form.get("subhead", "").strip()
    c.description = form.get("description", "").strip()
    c.body_md = form.get("body_md", "")
    c.active = "active" in form
    try:
        c.sort_order = int(form.get("sort_order") or 0)
    except ValueError:
        c.sort_order = 0


@bp.route("/campaigns/new", methods=["GET", "POST"])
@_require_admin
def campaign_new():
    if request.method == "POST":
        c = Campaign(slug=request.form["slug"].strip(), name=request.form["name"].strip())
        _apply_campaign_form(c, request.form)
        db.session.add(c)
        db.session.commit()
        flash("Campaign created.", "success")
        return redirect(url_for("admin.campaign_edit", campaign_id=c.id))
    return render_template("admin/campaign_form.html", campaign=None)


@bp.route("/campaigns/<int:campaign_id>", methods=["GET", "POST"])
@_require_admin
def campaign_edit(campaign_id: int):
    campaign = db.session.get(Campaign, campaign_id) or abort(404)
    if request.method == "POST":
        _apply_campaign_form(campaign, request.form)
        db.session.commit()
        flash("Saved.", "success")
        return redirect(url_for("admin.campaign_edit", campaign_id=campaign.id))
    return render_template("admin/campaign_form.html", campaign=campaign)


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
    target.name = form.get("name", "").strip()
    target.description = form.get("description", "").strip()
    try:
        target.sort_order = int(form.get("sort_order") or 0)
    except ValueError:
        target.sort_order = 0


@bp.route("/campaigns/<int:campaign_id>/targets/new", methods=["POST"])
@_require_admin
def target_new(campaign_id: int):
    campaign = db.session.get(Campaign, campaign_id) or abort(404)
    target = Target(campaign_id=campaign.id, name=request.form.get("name", "").strip() or "Untitled")
    _apply_target_form(target, request.form)
    db.session.add(target)
    db.session.commit()
    flash("Target added.", "success")
    return redirect(url_for("admin.target_edit", target_id=target.id))


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
    try:
        recipient.sort_order = int(form.get("sort_order") or 0)
    except ValueError:
        recipient.sort_order = 0


@bp.route("/targets/<int:target_id>/recipients/new", methods=["POST"])
@_require_admin
def recipient_new(target_id: int):
    target = db.session.get(Target, target_id) or abort(404)
    recipient = Recipient(
        target_id=target.id,
        formal_name=request.form.get("formal_name", "").strip(),
    )
    _apply_recipient_form(recipient, request.form)
    db.session.add(recipient)
    db.session.commit()
    return redirect(url_for("admin.target_edit", target_id=target.id))


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
    try:
        parameter.sort_order = int(form.get("sort_order") or 0)
    except ValueError:
        parameter.sort_order = 0
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
    db.session.add(parameter)
    db.session.commit()
    flash("Parameter added.", "success")
    return redirect(url_for("admin.target_edit", target_id=target.id))


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


# --- Artifacts ------------------------------------------------------------


def _apply_artifact_form(artifact: Artifact, form) -> None:
    artifact.name = form.get("name", "").strip() or "Untitled"
    kind = form.get("kind", Artifact.KIND_EMAIL)
    artifact.kind = kind if kind in (Artifact.KIND_EMAIL, Artifact.KIND_LETTER) else Artifact.KIND_EMAIL
    artifact.subject = form.get("subject", "").strip()
    artifact.body = form.get("body", "")
    try:
        artifact.sort_order = int(form.get("sort_order") or 0)
    except ValueError:
        artifact.sort_order = 0


@bp.route("/targets/<int:target_id>/artifacts/new", methods=["POST"])
@_require_admin
def artifact_new(target_id: int):
    target = db.session.get(Target, target_id) or abort(404)
    artifact = Artifact(target_id=target.id, name=request.form.get("name", "").strip() or "Untitled")
    _apply_artifact_form(artifact, request.form)
    db.session.add(artifact)
    db.session.commit()
    return redirect(url_for("admin.target_edit", target_id=target.id))


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
