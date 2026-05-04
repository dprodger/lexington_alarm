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
    artifacts: Mapped[list["Artifact"]] = relationship(
        back_populates="campaign",
        cascade="all, delete-orphan",
        order_by="Artifact.sort_order",
    )


class Target(db.Model):
    """A recipient of the campaign — a person to be written to."""

    __tablename__ = "targets"

    id: Mapped[int] = mapped_column(Integer, primary_key=True)
    campaign_id: Mapped[int] = mapped_column(
        ForeignKey("campaigns.id", ondelete="CASCADE"), nullable=False
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

    campaign: Mapped["Campaign"] = relationship(back_populates="targets")

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
        separately on its own line above the address. (Compare with
        Writer.address_block which does include the writer's name —
        that's intentional, since a writer's return address normally
        bundles the name with the address.)
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
    """A letter template — body copy with {{var}} placeholders.

    `kind` is "email" or "letter". Email artifacts produce a mailto: link;
    letter artifacts produce a printable view. Each campaign can carry
    several artifacts (e.g. short email + long email + postal letter).
    """

    __tablename__ = "artifacts"

    KIND_EMAIL = "email"
    KIND_LETTER = "letter"

    id: Mapped[int] = mapped_column(Integer, primary_key=True)
    campaign_id: Mapped[int] = mapped_column(
        ForeignKey("campaigns.id", ondelete="CASCADE"), nullable=False
    )

    name: Mapped[str] = mapped_column(String(200), nullable=False)
    kind: Mapped[str] = mapped_column(String(20), nullable=False, default=KIND_EMAIL)
    subject: Mapped[str] = mapped_column(String(300), nullable=False, default="")
    body: Mapped[str] = mapped_column(Text, nullable=False, default="")
    sort_order: Mapped[int] = mapped_column(Integer, nullable=False, default=0)

    campaign: Mapped["Campaign"] = relationship(back_populates="artifacts")
