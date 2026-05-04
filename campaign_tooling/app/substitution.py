"""Artifact body rendering, backed by Jinja2.

Artifact bodies and email subjects are rendered as Jinja2 templates so admins
can use `{{ var }}` placeholders, `{% if %}` / `{% for %}` control flow,
and built-in filters. The template scope is:

    writer     — Writer dataclass (name, email, address fields, address_block)
    target     — SQLAlchemy Target row (formal_name, salutation, address, ...)
    date       — ISO date string ("2026-05-04")
    date_long  — long form ("May 4, 2026")

Admins are token-gated and trusted to author templates. Writer and target
values are passed as data, not re-rendered, so a writer cannot inject
template syntax via form input.

Output is plain text destined for `mailto:` URLs and printable letters,
so autoescape is off — HTML escaping would corrupt those outputs.
"""

from __future__ import annotations

from dataclasses import dataclass
from datetime import date

from jinja2 import Environment


@dataclass
class Writer:
    name: str = ""
    email: str = ""
    street1: str = ""
    street2: str = ""
    city: str = ""
    state: str = ""
    postal_code: str = ""
    organization: str = ""

    @property
    def address_block(self) -> str:
        lines = [self.name, self.street1]
        if self.street2:
            lines.append(self.street2)
        city_state_zip = ", ".join(p for p in [self.city, self.state] if p).strip(", ")
        if self.postal_code:
            city_state_zip = f"{city_state_zip} {self.postal_code}".strip()
        if city_state_zip:
            lines.append(city_state_zip)
        return "\n".join(l for l in lines if l)


_env = Environment(autoescape=False, keep_trailing_newline=True)


def render(template: str, *, writer, target, today: date | None = None) -> str:
    today = today or date.today()
    return _env.from_string(template).render(
        writer=writer,
        target=target,
        date=today.isoformat(),
        date_long=today.strftime("%B %-d, %Y"),
    )
