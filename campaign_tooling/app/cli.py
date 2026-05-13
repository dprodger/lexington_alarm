"""Flask CLI commands.

Usage:
    flask export-seed                # dump every campaign to seed/<slug>.json
    flask import-seed [paths...]     # load seed/*.json (or named files)
    flask import-seed --replace      # overwrite existing campaigns on conflict
    flask reset-db                   # drop and recreate every table
"""

from __future__ import annotations

import json
from pathlib import Path

import click
from flask import Flask, current_app
from sqlalchemy import text

from .extensions import db
from .models import (
    Artifact,
    Campaign,
    CampaignResource,
    ParameterChoice,
    Recipient,
    Target,
    TargetParameter,
)


def register(app: Flask) -> None:
    app.cli.add_command(export_seed)
    app.cli.add_command(import_seed)
    app.cli.add_command(reset_db)


def _seed_dir() -> Path:
    """Path to the seed/ directory at the project root (next to instance/)."""
    return Path(current_app.root_path).parent / "seed"


# ---------------------------------------------------------------------------
# Serialization
# ---------------------------------------------------------------------------


def _serialize_recipient(r: Recipient) -> dict:
    return {
        "id": r.id,
        "formal_name": r.formal_name,
        "first_name": r.first_name,
        "last_name": r.last_name,
        "salutation": r.salutation,
        "title": r.title,
        "organization": r.organization,
        "email": r.email,
        "street1": r.street1,
        "street2": r.street2,
        "city": r.city,
        "state": r.state,
        "postal_code": r.postal_code,
        "sort_order": r.sort_order,
    }


def _serialize_artifact(a: Artifact) -> dict:
    return {
        "id": a.id,
        "name": a.name,
        "kind": a.kind,
        "subject": a.subject,
        "body": a.body,
        "sort_order": a.sort_order,
    }


def _serialize_choice(c: ParameterChoice) -> dict:
    return {
        "id": c.id,
        "value": c.value,
        "label": c.label,
        "sort_order": c.sort_order,
    }


def _serialize_parameter(p: TargetParameter) -> dict:
    return {
        "id": p.id,
        "key": p.key,
        "label": p.label,
        "help_text": p.help_text,
        "required": p.required,
        "kind": p.kind,
        "sort_order": p.sort_order,
        "choices": [_serialize_choice(c) for c in p.choices],
    }


def _serialize_target(t: Target) -> dict:
    return {
        "id": t.id,
        "name": t.name,
        "description": t.description,
        "source_url": t.source_url,
        "sort_order": t.sort_order,
        "parameters": [_serialize_parameter(p) for p in t.parameters],
        "recipients": [_serialize_recipient(r) for r in t.recipients],
        "artifacts": [_serialize_artifact(a) for a in t.artifacts],
    }


def _serialize_resource(r: CampaignResource) -> dict:
    return {
        "id": r.id,
        "category": r.category,
        "name": r.name,
        "url": r.url,
        "sort_order": r.sort_order,
    }


def _serialize_campaign(c: Campaign) -> dict:
    return {
        "campaign": {
            "id": c.id,
            "slug": c.slug,
            "name": c.name,
            "subhead": c.subhead,
            "description": c.description,
            "body_md": c.body_md,
            "action_header": c.action_header,
            "action_blurb": c.action_blurb,
            "active": c.active,
            "sort_order": c.sort_order,
            "theme": c.theme,
        },
        "targets": [_serialize_target(t) for t in c.targets],
        "resources": [_serialize_resource(r) for r in c.resources],
    }


# ---------------------------------------------------------------------------
# Export
# ---------------------------------------------------------------------------


@click.command("export-seed")
def export_seed() -> None:
    """Dump every campaign to seed/<slug>.json (overwrites existing files)."""
    seed_dir = _seed_dir()
    seed_dir.mkdir(exist_ok=True)

    campaigns = db.session.scalars(db.select(Campaign).order_by(Campaign.id)).all()
    for c in campaigns:
        path = seed_dir / f"{c.slug}.json"
        with path.open("w") as f:
            json.dump(_serialize_campaign(c), f, indent=2, ensure_ascii=False)
            f.write("\n")
        click.echo(f"Wrote {path}")
    click.echo(f"Exported {len(campaigns)} campaign(s).")


# ---------------------------------------------------------------------------
# Import
# ---------------------------------------------------------------------------


def _try_preserve_id(obj, requested_id, model) -> None:
    """Assign the JSON-recorded id to the new row if it isn't taken; otherwise
    let the DB auto-assign. Pre-checking avoids an IntegrityError on insert.

    On Postgres this leaves the SERIAL sequence behind the highest id,
    so the next auto-assigned id collides with a preserved one — see
    `_resync_postgres_sequences` below for the fix-up that runs after
    import.
    """
    if requested_id is None:
        return
    if db.session.get(model, requested_id) is None:
        obj.id = requested_id


_ID_TABLES = (Campaign, Target, Recipient, Artifact, TargetParameter, ParameterChoice, CampaignResource)


def _resync_postgres_sequences() -> None:
    """Bump each ``id`` sequence to ``MAX(id)`` after a seed import.

    No-op on SQLite (sequences are managed differently). Called from
    ``import-seed`` so a reseed can't leave admin-driven inserts colliding
    with preserved ids.
    """
    if db.engine.dialect.name != "postgresql":
        return
    for model in _ID_TABLES:
        schema = model.__table__.schema
        table = model.__tablename__
        full = f"{schema}.{table}" if schema else table
        db.session.execute(text(
            f"SELECT setval(pg_get_serial_sequence('{full}', 'id'), "
            f"COALESCE((SELECT MAX(id) FROM {full}), 1))"
        ))


def _import_campaign(data: dict, *, replace: bool) -> str:
    """Insert one campaign from a parsed JSON dict.

    Returns one of: "imported", "replaced", "skipped".
    """
    cdata = data["campaign"]
    slug = cdata["slug"]

    existing = db.session.scalar(db.select(Campaign).where(Campaign.slug == slug))
    status = "imported"
    if existing is not None:
        if not replace:
            return "skipped"
        db.session.delete(existing)
        db.session.flush()
        status = "replaced"

    campaign = Campaign(
        slug=cdata["slug"],
        name=cdata["name"],
        subhead=cdata.get("subhead", ""),
        description=cdata.get("description", ""),
        body_md=cdata.get("body_md", ""),
        action_header=cdata.get("action_header", ""),
        action_blurb=cdata.get("action_blurb", ""),
        active=cdata.get("active", True),
        sort_order=cdata.get("sort_order", 0),
        theme=cdata.get("theme", Campaign.THEME_DEFAULT),
    )
    _try_preserve_id(campaign, cdata.get("id"), Campaign)
    db.session.add(campaign)
    db.session.flush()

    _RECIPIENT_FIELDS = (
        "formal_name", "first_name", "last_name", "salutation",
        "title", "organization", "email",
        "street1", "street2", "city", "state", "postal_code",
    )

    for tdata in data.get("targets", []):
        target = Target(
            campaign_id=campaign.id,
            name=tdata["name"],
            description=tdata.get("description", ""),
            source_url=tdata.get("source_url", ""),
            sort_order=tdata.get("sort_order", 0),
        )
        _try_preserve_id(target, tdata.get("id"), Target)
        db.session.add(target)
        db.session.flush()

        for pdata in tdata.get("parameters", []):
            parameter = TargetParameter(
                target_id=target.id,
                key=pdata.get("key", ""),
                label=pdata.get("label", ""),
                help_text=pdata.get("help_text", ""),
                required=pdata.get("required", True),
                kind=pdata.get("kind", TargetParameter.KIND_TEXT),
                sort_order=pdata.get("sort_order", 0),
            )
            _try_preserve_id(parameter, pdata.get("id"), TargetParameter)
            db.session.add(parameter)
            db.session.flush()
            for cdata in pdata.get("choices", []):
                choice = ParameterChoice(
                    parameter_id=parameter.id,
                    value=cdata.get("value", ""),
                    label=cdata.get("label", ""),
                    sort_order=cdata.get("sort_order", 0),
                )
                _try_preserve_id(choice, cdata.get("id"), ParameterChoice)
                db.session.add(choice)

        for rdata in tdata.get("recipients", []):
            recipient = Recipient(target_id=target.id)
            for field in _RECIPIENT_FIELDS:
                setattr(recipient, field, rdata.get(field, ""))
            recipient.sort_order = rdata.get("sort_order", 0)
            _try_preserve_id(recipient, rdata.get("id"), Recipient)
            db.session.add(recipient)

        for adata in tdata.get("artifacts", []):
            artifact = Artifact(
                target_id=target.id,
                name=adata.get("name", "Untitled"),
                kind=adata.get("kind", Artifact.KIND_EMAIL),
                subject=adata.get("subject", ""),
                body=adata.get("body", ""),
                sort_order=adata.get("sort_order", 0),
            )
            _try_preserve_id(artifact, adata.get("id"), Artifact)
            db.session.add(artifact)

    for rdata in data.get("resources", []):
        resource = CampaignResource(
            campaign_id=campaign.id,
            category=rdata.get("category", CampaignResource.CATEGORY_PRIMARY_SOURCES),
            name=rdata.get("name", ""),
            url=rdata.get("url", ""),
            sort_order=rdata.get("sort_order", 0),
        )
        _try_preserve_id(resource, rdata.get("id"), CampaignResource)
        db.session.add(resource)

    db.session.flush()
    return status


@click.command("import-seed")
@click.option("--replace", is_flag=True, help="Replace existing campaigns with the same slug.")
@click.argument("paths", nargs=-1, type=click.Path(exists=True, dir_okay=False))
def import_seed(replace: bool, paths: tuple[str, ...]) -> None:
    """Load campaigns from seed/*.json (or specified files)."""
    if paths:
        path_objs = [Path(p) for p in paths]
    else:
        seed_dir = _seed_dir()
        path_objs = sorted(seed_dir.glob("*.json")) if seed_dir.exists() else []

    if not path_objs:
        click.echo("No seed files found.")
        return

    counts = {"imported": 0, "replaced": 0, "skipped": 0}
    for path in path_objs:
        with path.open() as f:
            data = json.load(f)
        result = _import_campaign(data, replace=replace)
        counts[result] += 1
        click.echo(f"  {result}: {path.name}")

    _resync_postgres_sequences()
    db.session.commit()
    click.echo(
        f"Done — {counts['imported']} imported, "
        f"{counts['replaced']} replaced, {counts['skipped']} skipped."
    )


# ---------------------------------------------------------------------------
# Maintenance
# ---------------------------------------------------------------------------


@click.command("reset-db")
@click.confirmation_option(prompt="This drops every table. Continue?")
def reset_db() -> None:
    """Drop all tables and recreate them."""
    db.drop_all()
    db.create_all()
    click.echo("Database reset.")
