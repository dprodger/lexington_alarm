"""Admin views.

Auth here is intentionally crude — a shared `ADMIN_TOKEN` from .env. Real
auth (Supabase Auth, Flask-Login + Postgres users, or HTTP Basic) is a
TODO before this goes anywhere near production.
"""

from __future__ import annotations

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
from .models import Artifact, Campaign, Target

bp = Blueprint("admin", __name__, template_folder="templates")


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
    campaigns = db.session.scalars(db.select(Campaign).order_by(Campaign.name)).all()
    return render_template("admin/index.html", campaigns=campaigns)


@bp.route("/campaigns/new", methods=["GET", "POST"])
@_require_admin
def campaign_new():
    if request.method == "POST":
        c = Campaign(
            slug=request.form["slug"].strip(),
            name=request.form["name"].strip(),
            description=request.form.get("description", "").strip(),
            body_md=request.form.get("body_md", ""),
            active="active" in request.form,
        )
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
        campaign.slug = request.form["slug"].strip()
        campaign.name = request.form["name"].strip()
        campaign.description = request.form.get("description", "").strip()
        campaign.body_md = request.form.get("body_md", "")
        campaign.active = "active" in request.form
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


@bp.route("/campaigns/<int:campaign_id>/targets/new", methods=["POST"])
@_require_admin
def target_new(campaign_id: int):
    campaign = db.session.get(Campaign, campaign_id) or abort(404)
    target = Target(campaign_id=campaign.id, formal_name=request.form.get("formal_name", "").strip())
    _apply_target_form(target, request.form)
    db.session.add(target)
    db.session.commit()
    return redirect(url_for("admin.campaign_edit", campaign_id=campaign.id))


@bp.route("/targets/<int:target_id>/edit", methods=["POST"])
@_require_admin
def target_edit(target_id: int):
    target = db.session.get(Target, target_id) or abort(404)
    _apply_target_form(target, request.form)
    db.session.commit()
    return redirect(url_for("admin.campaign_edit", campaign_id=target.campaign_id))


@bp.route("/targets/<int:target_id>/delete", methods=["POST"])
@_require_admin
def target_delete(target_id: int):
    target = db.session.get(Target, target_id) or abort(404)
    campaign_id = target.campaign_id
    db.session.delete(target)
    db.session.commit()
    return redirect(url_for("admin.campaign_edit", campaign_id=campaign_id))


def _apply_target_form(target: Target, form) -> None:
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
        setattr(target, field, form.get(field, "").strip())
    try:
        target.sort_order = int(form.get("sort_order") or 0)
    except ValueError:
        target.sort_order = 0


# --- Artifacts ------------------------------------------------------------


@bp.route("/campaigns/<int:campaign_id>/artifacts/new", methods=["POST"])
@_require_admin
def artifact_new(campaign_id: int):
    campaign = db.session.get(Campaign, campaign_id) or abort(404)
    artifact = Artifact(campaign_id=campaign.id, name=request.form.get("name", "").strip() or "Untitled")
    _apply_artifact_form(artifact, request.form)
    db.session.add(artifact)
    db.session.commit()
    return redirect(url_for("admin.campaign_edit", campaign_id=campaign.id))


@bp.route("/artifacts/<int:artifact_id>/edit", methods=["POST"])
@_require_admin
def artifact_edit(artifact_id: int):
    artifact = db.session.get(Artifact, artifact_id) or abort(404)
    _apply_artifact_form(artifact, request.form)
    db.session.commit()
    return redirect(url_for("admin.campaign_edit", campaign_id=artifact.campaign_id))


@bp.route("/artifacts/<int:artifact_id>/delete", methods=["POST"])
@_require_admin
def artifact_delete(artifact_id: int):
    artifact = db.session.get(Artifact, artifact_id) or abort(404)
    campaign_id = artifact.campaign_id
    db.session.delete(artifact)
    db.session.commit()
    return redirect(url_for("admin.campaign_edit", campaign_id=campaign_id))


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
