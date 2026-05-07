"""Artifact body rendering, backed by Jinja2.

Artifact bodies and email subjects are rendered as Jinja2 templates so admins
can use `{{ var }}` placeholders, `{% if %}` / `{% for %}` control flow,
and built-in filters. The template scope is:

    writer     — Writer dataclass (name, email, address fields, address_block)
    recipient  — SQLAlchemy Recipient row (formal_name, salutation, address, ...)
    target     — SQLAlchemy Target row (name, description) — the conceptual
                 group the recipient belongs to
    parameter  — namespace of free-form strings the writer supplied for this
                 Target (e.g. ``parameter.job_title``); empty string when a
                 referenced key wasn't supplied
    date       — ISO date string ("2026-05-04")
    date_long  — long form ("May 4, 2026")

Admins are token-gated and trusted to author templates. Writer, recipient,
and target values are passed as data, not re-rendered, so a writer cannot
inject template syntax via form input.

Output is plain text destined for `mailto:` URLs and printable letters,
so autoescape is off — HTML escaping would corrupt those outputs.
"""

from __future__ import annotations

import html
from dataclasses import dataclass
from datetime import date
from types import SimpleNamespace

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


# ---------------------------------------------------------------------------
# Highlighting environment — used by the admin preview and the public
# action-page sample render. Wraps the OUTPUT of every `{{ x }}` in
# sentinel markers via Jinja's `finalize` hook, so values stay plain
# during evaluation (`{% if x == 'foo' %}` works correctly). Markers are
# turned into `<mark>` tags by `markers_to_html` after HTML-escaping.
# ---------------------------------------------------------------------------

_MARK_OPEN = "\x01MARK_OPEN\x01"
_MARK_CLOSE = "\x01MARK_CLOSE\x01"


def _highlight_finalize(value):
    if value is None or value == "":
        return ""
    return f"{_MARK_OPEN}{value}{_MARK_CLOSE}"


_env_marked = Environment(
    autoescape=False, keep_trailing_newline=True, finalize=_highlight_finalize,
)


def render(
    template: str,
    *,
    writer,
    recipient,
    target=None,
    parameters: dict | None = None,
    today: date | None = None,
) -> str:
    today = today or date.today()
    return _env.from_string(template).render(
        writer=writer,
        recipient=recipient,
        target=target if target is not None else getattr(recipient, "target", None),
        parameter=SimpleNamespace(**(parameters or {})),
        date=today.isoformat(),
        date_long=today.strftime("%B %-d, %Y"),
    )


# ---------------------------------------------------------------------------
# Admin preview rendering — uses fixed test data and the highlighting
# environment (defined above). The HTML-escape + marker→<mark> sequence
# keeps any `<` or `&` from the admin-authored body literal in the
# output, while still letting the yellow highlight surround substituted
# values.
# ---------------------------------------------------------------------------


_PREVIEW_WRITER = Writer(
    name="Test Writer",
    email="test@example.com",
    organization="Sample Org",
    street1="123 Main Street",
    street2="",
    city="Hartford",
    state="CT",
    postal_code="06106",
)


_PREVIEW_RECIPIENT = SimpleNamespace(
    formal_name="Hon. Sample Recipient",
    first_name="Sample",
    last_name="Recipient",
    salutation="Senator Recipient",
    title="State Senator",
    organization="Sample State Government",
    email="recipient@example.gov",
    street1="1 Capitol Drive",
    street2="",
    city="Hartford",
    state="CT",
    postal_code="06106",
)


_PREVIEW_TARGET = SimpleNamespace(
    name="Sample Target Group",
    description="Sample description of the audience.",
)


class _PreviewParameters:
    """Stand-in for the ``parameter`` scope in admin preview rendering.

    The admin preview endpoint doesn't know which Target the artifact will
    end up under, so it can't enumerate the real parameter keys. Any
    ``parameter.<x>`` reference returns ``<x>`` so the preview shows what
    the placeholder would have been; the highlight environment wraps it
    in `<mark>` tags at output time.
    """

    def __getattr__(self, name):
        if name.startswith("_"):
            raise AttributeError(name)
        return f"<{name}>"


def render_with_highlights(
    template: str,
    *,
    writer,
    recipient,
    target=None,
    parameters: dict | None = None,
    today: date | None = None,
) -> str:
    """Render with the highlighting environment so every `{{ x }}` output
    is wrapped in sentinel markers. Pair with `markers_to_html` to produce
    safely escaped HTML with `<mark>` tags around substitutions. Values
    stay plain during evaluation, so `{% if x == 'foo' %}` works.
    """
    today = today or date.today()
    target = target if target is not None else getattr(recipient, "target", None)
    return _env_marked.from_string(template).render(
        writer=writer,
        recipient=recipient,
        target=target if target is not None else SimpleNamespace(),
        parameter=SimpleNamespace(**(parameters or {})),
        date=today.isoformat(),
        date_long=today.strftime("%B %-d, %Y"),
    )


def render_for_preview(template: str, today: date | None = None) -> str:
    """Render with fixed test data; uses the highlighting environment so
    every `{{ x }}` output is marker-wrapped. The `parameter` scope is a
    stand-in that displays any referenced key as ``<key>`` since the
    preview doesn't know the real Target.
    """
    today = today or date.today()
    return _env_marked.from_string(template).render(
        writer=_PREVIEW_WRITER,
        recipient=_PREVIEW_RECIPIENT,
        target=_PREVIEW_TARGET,
        parameter=_PreviewParameters(),
        date=today.isoformat(),
        date_long=today.strftime("%B %-d, %Y"),
    )


def markers_to_html(rendered_with_markers: str) -> str:
    """HTML-escape then convert the sentinels into <mark> tags."""
    escaped = html.escape(rendered_with_markers)
    return escaped.replace(_MARK_OPEN, "<mark>").replace(_MARK_CLOSE, "</mark>")


# Backwards-compatible alias for the original admin preview helper.
preview_to_html = markers_to_html
