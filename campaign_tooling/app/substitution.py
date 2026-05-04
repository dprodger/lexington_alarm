"""Variable substitution for artifact bodies.

Supports `{{ writer.name }}`, `{{ target.formal_name }}`, `{{ date }}`, etc.
Whitespace inside the braces is tolerated. Unknown placeholders are left
in place so admins can spot typos rather than silently dropping content.
"""

from __future__ import annotations

import re
from dataclasses import dataclass
from datetime import date


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


_PLACEHOLDER_RE = re.compile(r"\{\{\s*([a-zA-Z0-9_.]+)\s*\}\}")


def _resolve(path: str, scope: dict) -> str | None:
    """Walk dotted path against scope. Return None if not found."""
    parts = path.split(".")
    cur = scope
    for part in parts:
        if isinstance(cur, dict):
            if part not in cur:
                return None
            cur = cur[part]
        else:
            if not hasattr(cur, part):
                return None
            cur = getattr(cur, part)
    return "" if cur is None else str(cur)


def render(template: str, *, writer, target, today: date | None = None) -> str:
    """Substitute placeholders in `template`.

    Available scopes: `writer.*`, `target.*`, `date` (ISO yyyy-mm-dd),
    `date_long` (e.g. "May 4, 2026").
    """
    today = today or date.today()
    scope = {
        "writer": writer,
        "target": target,
        "date": today.isoformat(),
        "date_long": today.strftime("%B %-d, %Y") if hasattr(today, "strftime") else today.isoformat(),
    }

    def sub(match: re.Match) -> str:
        path = match.group(1)
        value = _resolve(path, scope)
        return match.group(0) if value is None else value

    return _PLACEHOLDER_RE.sub(sub, template)
