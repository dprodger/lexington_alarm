from datetime import datetime, timezone

from sqlalchemy import (
    Boolean,
    DateTime,
    ForeignKey,
    Integer,
    String,
    Text,
)
from sqlalchemy.orm import Mapped, mapped_column, relationship

from .extensions import db


def _utcnow() -> datetime:
    return datetime.now(timezone.utc)


class Campaign(db.Model):
    __tablename__ = "campaigns"

    id: Mapped[int] = mapped_column(Integer, primary_key=True)
    slug: Mapped[str] = mapped_column(String(64), unique=True, nullable=False)
    name: Mapped[str] = mapped_column(String(200), nullable=False)
    subhead: Mapped[str] = mapped_column(String(300), nullable=False, default="")
    description: Mapped[str] = mapped_column(Text, nullable=False, default="")
    body_md: Mapped[str] = mapped_column(Text, nullable=False, default="")
    active: Mapped[bool] = mapped_column(Boolean, nullable=False, default=True)
    sort_order: Mapped[int] = mapped_column(Integer, nullable=False, default=0)
    created_at: Mapped[datetime] = mapped_column(DateTime(timezone=True), default=_utcnow)
    updated_at: Mapped[datetime] = mapped_column(
        DateTime(timezone=True), default=_utcnow, onupdate=_utcnow
    )

    targets: Mapped[list["Target"]] = relationship(
        back_populates="campaign",
        cascade="all, delete-orphan",
        order_by="Target.sort_order",
    )


class Target(db.Model):
    """A conceptual audience within a campaign — e.g. "Massport Board"
    or "Governor". A Target groups one or more Recipients (the actual
    people the writer will reach) and the Artifacts (letter templates)
    that get sent to those recipients.
    """

    __tablename__ = "targets"

    id: Mapped[int] = mapped_column(Integer, primary_key=True)
    campaign_id: Mapped[int] = mapped_column(
        ForeignKey("campaigns.id", ondelete="CASCADE"), nullable=False
    )

    name: Mapped[str] = mapped_column(String(200), nullable=False)
    description: Mapped[str] = mapped_column(Text, nullable=False, default="")
    sort_order: Mapped[int] = mapped_column(Integer, nullable=False, default=0)

    campaign: Mapped["Campaign"] = relationship(back_populates="targets")
    recipients: Mapped[list["Recipient"]] = relationship(
        back_populates="target",
        cascade="all, delete-orphan",
        order_by="Recipient.sort_order",
    )
    artifacts: Mapped[list["Artifact"]] = relationship(
        back_populates="target",
        cascade="all, delete-orphan",
        order_by="Artifact.sort_order",
    )
    parameters: Mapped[list["TargetParameter"]] = relationship(
        back_populates="target",
        cascade="all, delete-orphan",
        order_by="TargetParameter.sort_order",
    )


class Recipient(db.Model):
    """A real person within a Target — a row carrying contact info."""

    __tablename__ = "recipients"

    id: Mapped[int] = mapped_column(Integer, primary_key=True)
    target_id: Mapped[int] = mapped_column(
        ForeignKey("targets.id", ondelete="CASCADE"), nullable=False
    )

    formal_name: Mapped[str] = mapped_column(String(200), nullable=False)
    first_name: Mapped[str] = mapped_column(String(100), nullable=False, default="")
    last_name: Mapped[str] = mapped_column(String(100), nullable=False, default="")
    salutation: Mapped[str] = mapped_column(String(200), nullable=False, default="")
    title: Mapped[str] = mapped_column(String(200), nullable=False, default="")
    organization: Mapped[str] = mapped_column(String(200), nullable=False, default="")

    email: Mapped[str] = mapped_column(String(200), nullable=False, default="")
    street1: Mapped[str] = mapped_column(String(200), nullable=False, default="")
    street2: Mapped[str] = mapped_column(String(200), nullable=False, default="")
    city: Mapped[str] = mapped_column(String(120), nullable=False, default="")
    state: Mapped[str] = mapped_column(String(40), nullable=False, default="")
    postal_code: Mapped[str] = mapped_column(String(20), nullable=False, default="")

    sort_order: Mapped[int] = mapped_column(Integer, nullable=False, default=0)

    target: Mapped["Target"] = relationship(back_populates="recipients")

    @property
    def has_email(self) -> bool:
        return bool(self.email.strip())

    @property
    def has_address(self) -> bool:
        return bool(self.street1.strip() and self.city.strip())

    @property
    def address_block(self) -> str:
        """Multi-line postal address — street + city/state/zip.

        Does NOT include `formal_name`; templates typically render that
        separately on its own line above the address.
        """
        lines = []
        if self.street1:
            lines.append(self.street1)
        if self.street2:
            lines.append(self.street2)
        city_state = ", ".join(p for p in [self.city, self.state] if p)
        if self.postal_code:
            city_state = f"{city_state} {self.postal_code}".strip()
        if city_state:
            lines.append(city_state)
        return "\n".join(lines)


class Artifact(db.Model):
    """A letter template — body copy with {{var}} placeholders, attached
    to a Target. `kind` is "email" or "letter". A Target can carry a mix
    of email and letter artifacts; the public flow fans them out across
    every Recipient in the Target.
    """

    __tablename__ = "artifacts"

    KIND_EMAIL = "email"
    KIND_LETTER = "letter"

    id: Mapped[int] = mapped_column(Integer, primary_key=True)
    target_id: Mapped[int] = mapped_column(
        ForeignKey("targets.id", ondelete="CASCADE"), nullable=False
    )

    name: Mapped[str] = mapped_column(String(200), nullable=False)
    kind: Mapped[str] = mapped_column(String(20), nullable=False, default=KIND_EMAIL)
    subject: Mapped[str] = mapped_column(String(300), nullable=False, default="")
    body: Mapped[str] = mapped_column(Text, nullable=False, default="")
    sort_order: Mapped[int] = mapped_column(Integer, nullable=False, default=0)

    target: Mapped["Target"] = relationship(back_populates="artifacts")


class TargetParameter(db.Model):
    """A free-form string the writer must supply before a Target's artifacts
    can be rendered — e.g. ``job_title`` or ``employer``.

    Templates reference these as ``{{ parameter.<key> }}``. ``key`` is the
    identifier used in the template; ``label`` is what the writer sees on
    the form. ``kind`` is "text" (free-form input) or "select" (dropdown
    constrained to the linked ``ParameterChoice`` rows).
    """

    __tablename__ = "target_parameters"

    KIND_TEXT = "text"
    KIND_SELECT = "select"

    id: Mapped[int] = mapped_column(Integer, primary_key=True)
    target_id: Mapped[int] = mapped_column(
        ForeignKey("targets.id", ondelete="CASCADE"), nullable=False
    )

    key: Mapped[str] = mapped_column(String(64), nullable=False)
    label: Mapped[str] = mapped_column(String(200), nullable=False, default="")
    help_text: Mapped[str] = mapped_column(String(500), nullable=False, default="")
    required: Mapped[bool] = mapped_column(Boolean, nullable=False, default=True)
    kind: Mapped[str] = mapped_column(String(20), nullable=False, default=KIND_TEXT)
    sort_order: Mapped[int] = mapped_column(Integer, nullable=False, default=0)

    target: Mapped["Target"] = relationship(back_populates="parameters")
    choices: Mapped[list["ParameterChoice"]] = relationship(
        back_populates="parameter",
        cascade="all, delete-orphan",
        order_by="ParameterChoice.sort_order",
    )


class ParameterChoice(db.Model):
    """One option in a select-kind ``TargetParameter``.

    ``value`` is what gets substituted into letter templates (so an admin
    can keep template logic clean: ``{% if parameter.role == 'employed' %}``).
    ``label`` is the human-readable text the writer sees in the dropdown
    (e.g. "I am currently employed").
    """

    __tablename__ = "parameter_choices"

    id: Mapped[int] = mapped_column(Integer, primary_key=True)
    parameter_id: Mapped[int] = mapped_column(
        ForeignKey("target_parameters.id", ondelete="CASCADE"), nullable=False
    )
    value: Mapped[str] = mapped_column(String(200), nullable=False)
    label: Mapped[str] = mapped_column(String(200), nullable=False, default="")
    sort_order: Mapped[int] = mapped_column(Integer, nullable=False, default=0)

    parameter: Mapped["TargetParameter"] = relationship(back_populates="choices")
