"""PDF rendering for printable letter artifacts.

Backed by fpdf2 — pure-Python, no system dependencies, deploys cleanly
on Render's standard Python image. Produces a single-page (or multi-page
with auto-overflow) US Letter PDF using the built-in Times font.

Built-in PDF fonts are Latin-1 only, so we sanitize a handful of common
typographic characters (em/en dashes, smart quotes, ellipsis) to ASCII
equivalents before passing the text to the renderer. Anything still
outside Latin-1 after that gets replaced with `?` rather than raising —
better a slightly-degraded PDF than a 500.
"""

from __future__ import annotations

from fpdf import FPDF


_TYPOGRAPHIC_REPLACEMENTS = {
    "—": "--",   # em dash
    "–": "-",    # en dash
    "‘": "'",    # left single quote
    "’": "'",    # right single quote
    "“": '"',    # left double quote
    "”": '"',    # right double quote
    "…": "...",  # ellipsis
    " ": " ",    # non-breaking space
}


def _to_latin1_safe(text: str) -> str:
    for old, new in _TYPOGRAPHIC_REPLACEMENTS.items():
        text = text.replace(old, new)
    # Final safety net: drop any remaining non-Latin-1 chars rather than
    # crash on encode. ? is fpdf2's default for unsupported glyphs anyway.
    return text.encode("latin-1", "replace").decode("latin-1")


def render_letter_pdf(body: str, *, title: str = "") -> bytes:
    """Render a single letter body as a US Letter PDF (one or more pages)."""
    return render_letters_pdf([body], title=title)


def render_letters_pdf(bodies: list[str], *, title: str = "") -> bytes:
    """Render one or more letter bodies as a single US Letter PDF.

    Each body starts on a fresh page. Margins are 1 inch on all sides;
    body text is 12pt Times with ~0.22 inch line height. Auto page-break
    handles overflow within a single body.
    """
    pdf = FPDF(format="letter", unit="in")
    if title:
        pdf.set_title(title)
    pdf.set_margins(left=1.0, top=1.0, right=1.0)
    pdf.set_auto_page_break(auto=True, margin=1.0)
    pdf.set_font("Times", size=12)
    for body in bodies:
        pdf.add_page()
        pdf.multi_cell(w=0, h=0.22, text=_to_latin1_safe(body))
    return bytes(pdf.output())
