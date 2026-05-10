"""Per-theme content (the strings and image URLs the public chrome
shows). Pure styling — colors, fonts, spacing — lives in
static/themes/<slug>.css instead.

Why split the two: header/footer text and the banner image URL aren't
expressible in CSS alone. Without this module each non-LA theme had to
hide the default LA markup with ``display: none`` and rebuild its own
header via ``::before``/``::after`` pseudo-elements, which bloated the
theme CSS files. By driving markup from this dict, base_public.html
renders the right HTML for each theme and the CSS only carries
appearance.

Adding a theme: add a new entry here AND ship a matching CSS file at
static/themes/<slug>.css. Then list the slug in ``Campaign.THEMES`` so
admins can pick it from the form.
"""

from __future__ import annotations


# Header.kind values:
#   "banner_image" — render <img src=url alt=alt> wrapped in a link to link
#   "text"         — render eyebrow + brand as text inside .public-header-text
#
# Footer keeps a single text/link pair; pass link=None for plain text.
THEMES = {
    "lexington_alarm": {
        "header": {
            "kind": "banner_image",
            "url": "https://lexingtonalarm.org/wp-content/uploads/2025/09/LexAlarmBanner8.svg",
            "alt": "Lexington Alarm",
            "link": "https://lexingtonalarm.org/",
        },
        "footer": {
            "text": "lexingtonalarm.org",
            "link": "https://lexingtonalarm.org/",
        },
    },
    "signature": {
        "header": {
            "kind": "text",
            "eyebrow": "A national letter campaign",
            "brand": "Stop Servicing ICE",
            "link": "/",
        },
        "footer": {
            "text": "A coalition campaign of state workers, retirees, union members, and concerned residents.",
            "link": None,
        },
    },
}


def theme_config(slug: str) -> dict:
    """Return the content config for a theme slug, falling back to the
    default theme if the slug is unknown. Centralized so callers don't
    each repeat the fallback logic.
    """
    from .models import Campaign

    return THEMES.get(slug) or THEMES[Campaign.THEME_DEFAULT]
