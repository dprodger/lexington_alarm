"""Flask CLI commands.

Usage:
    flask seed       # creates a starter CT pension campaign
    flask reset-db   # drops and recreates all tables (DANGEROUS)
"""

from __future__ import annotations

import click
from flask import Flask

from .extensions import db
from .models import Artifact, Campaign, Target


def register(app: Flask) -> None:
    app.cli.add_command(seed)
    app.cli.add_command(reset_db)


@click.command("seed")
def seed() -> None:
    """Seed the DB with a starter CT pension fund campaign."""
    existing = db.session.scalar(db.select(Campaign).where(Campaign.slug == "ct-pension"))
    if existing:
        click.echo("ct-pension campaign already exists; skipping.")
        return

    campaign = Campaign(
        slug="ct-pension",
        name="Connecticut Pension Fund — Letter Campaign",
        description=(
            "Tell Connecticut state officials to protect public pensions and refuse "
            "risky private-equity exposure."
        ),
        body_md=(
            "Public pensions in Connecticut affect tens of thousands of retirees, "
            "teachers, and state workers. Send a personalized letter — by email or "
            "post — to the officials who set state investment policy."
        ),
        active=True,
    )
    db.session.add(campaign)
    db.session.flush()

    campaign.targets.append(
        Target(
            formal_name="Treasurer Erick Russell",
            first_name="Erick",
            last_name="Russell",
            salutation="Treasurer Russell",
            title="State Treasurer",
            organization="State of Connecticut",
            email="treasurer.russell@ct.gov",
            street1="165 Capitol Avenue",
            city="Hartford",
            state="CT",
            postal_code="06106",
            sort_order=1,
        )
    )

    campaign.artifacts.append(
        Artifact(
            kind=Artifact.KIND_EMAIL,
            name="Short email",
            subject="Protect Connecticut public pensions",
            body=(
                "Dear {{ target.salutation }},\n\n"
                "I am writing as a Connecticut resident to ask that you protect the "
                "state's public pension fund from inappropriate exposure to private-equity "
                "and other high-risk strategies.\n\n"
                "Please make decisions about pension fund allocation transparent to the "
                "people whose retirements depend on it.\n\n"
                "Sincerely,\n"
                "{{ writer.name }}\n"
                "{{ writer.city }}{% if writer.state %}, {{ writer.state }}{% endif %}\n"
            ),
            sort_order=1,
        )
    )

    campaign.artifacts.append(
        Artifact(
            kind=Artifact.KIND_LETTER,
            name="Postal letter",
            subject="",
            body=(
                "{{ writer.address_block }}\n\n"
                "{{ date_long }}\n\n"
                "{{ target.formal_name }}\n"
                "{{ target.street1 }}\n"
                "{{ target.city }}, {{ target.state }} {{ target.postal_code }}\n\n"
                "Dear {{ target.salutation }},\n\n"
                "I am writing as a Connecticut resident to ask that you protect the "
                "state's public pension fund from inappropriate exposure to private-equity "
                "and other high-risk strategies. The retirements of teachers, state "
                "workers, and many of my neighbors depend on the prudent stewardship of "
                "this fund.\n\n"
                "Specifically, I ask that you publish quarterly disclosures of all "
                "alternative-investment holdings, including fees paid, and that you "
                "establish a clear ceiling on illiquid allocations.\n\n"
                "Thank you for your attention to this matter.\n\n"
                "Sincerely,\n\n\n"
                "{{ writer.name }}\n"
            ),
            sort_order=2,
        )
    )

    db.session.commit()
    click.echo("Seeded ct-pension campaign with 1 target and 2 artifacts.")


@click.command("reset-db")
@click.confirmation_option(prompt="This drops every table. Continue?")
def reset_db() -> None:
    """Drop all tables and recreate them."""
    db.drop_all()
    db.create_all()
    click.echo("Database reset.")
