"""Add the 11-member Massachusetts congressional delegation as recipients of
target_id=10 ("Mass Congressional Delegation").

Each recipient gets:
  - Their primary Massachusetts office address (Boston for the senators;
    primary in-state district office for each rep).
  - Their official constituent contact-form URL in the ``email`` field.
    (NB: Congress does not publish direct email addresses; the form URL is
    a placeholder. mailto:-based artifacts will not work for these recipients
    without further app work.)

Usage:
    DATABASE_URL=<prod-url> python seed/add_ma_delegation.py

Or, if .env at the project root already has the prod DATABASE_URL:
    python seed/add_ma_delegation.py

Idempotent: skips any recipient whose ``formal_name`` already exists on
target 10, so it's safe to re-run if a previous run was interrupted.
"""

from __future__ import annotations

import sys
from pathlib import Path

# Make this script runnable from anywhere — put the project root on sys.path
# so ``from app import ...`` works.
sys.path.insert(0, str(Path(__file__).resolve().parent.parent))

from app import create_app  # noqa: E402
from app.extensions import db  # noqa: E402
from app.models import Recipient, Target  # noqa: E402


TARGET_ID = 10
EXPECTED_TARGET_NAME = "Massachusetts Congressional Delegation"


# Order here = display order. Senators first, then reps by district.
RECIPIENTS: list[dict] = [
    {
        "title": "Senator",
        "first_name": "Elizabeth",
        "last_name": "Warren",
        "street1": "2400 JFK Federal Building",
        "street2": "15 New Sudbury Street",
        "city": "Boston",
        "postal_code": "02203",
        "email": "https://www.warren.senate.gov/contact/shareyouropinion",
    },
    {
        "title": "Senator",
        "first_name": "Ed",
        "last_name": "Markey",
        "street1": "975 JFK Federal Building",
        "street2": "15 New Sudbury Street",
        "city": "Boston",
        "postal_code": "02203",
        "email": "https://www.markey.senate.gov/contact/share-your-opinion",
    },
    {
        "title": "Representative",
        "first_name": "Richard",
        "last_name": "Neal",
        "street1": "300 State Street",
        "street2": "Suite 200",
        "city": "Springfield",
        "postal_code": "01105",
        "email": "https://neal.house.gov/email-me/",
    },
    {
        "title": "Representative",
        "first_name": "Jim",
        "last_name": "McGovern",
        "street1": "12 East Worcester Street",
        "street2": "Suite 1",
        "city": "Worcester",
        "postal_code": "01604",
        "email": "https://mcgovern.house.gov/contact",
    },
    {
        "title": "Representative",
        "first_name": "Lori",
        "last_name": "Trahan",
        "street1": "126 John Street",
        "street2": "Suite 12",
        "city": "Lowell",
        "postal_code": "01852",
        "email": "https://trahan.house.gov/contact/write-your-rep.htm",
    },
    {
        "title": "Representative",
        "first_name": "Jake",
        "last_name": "Auchincloss",
        "street1": "29 Crafts Street",
        "street2": "Suite 375",
        "city": "Newton",
        "postal_code": "02458",
        "email": "https://auchincloss.house.gov/contact/email-me",
    },
    {
        "title": "Representative",
        "first_name": "Katherine",
        "last_name": "Clark",
        "street1": "157 Pleasant Street",
        "street2": "Suite 4",
        "city": "Malden",
        "postal_code": "02148",
        "email": "https://katherineclark.house.gov/email-me",
    },
    {
        "title": "Representative",
        "first_name": "Seth",
        "last_name": "Moulton",
        "street1": "21 Front Street",
        "street2": "",
        "city": "Salem",
        "postal_code": "01970",
        "email": "https://moulton.house.gov/contact/write-to-me",
    },
    {
        "title": "Representative",
        "first_name": "Ayanna",
        "last_name": "Pressley",
        "street1": "50 Redfield Street",
        "street2": "Suite 302",
        "city": "Boston",
        "postal_code": "02122",
        "email": "https://pressley.house.gov/contact-us/",
    },
    {
        "title": "Representative",
        "first_name": "Stephen",
        "last_name": "Lynch",
        "street1": "One Harbor Street",
        "street2": "Suite 101",
        "city": "Boston",
        "postal_code": "02210",
        "email": "https://lynch.house.gov/email-me",
    },
    {
        "title": "Representative",
        "first_name": "Bill",
        "last_name": "Keating",
        "street1": "251 Stevens Street",
        "street2": "Suite E",
        "city": "Hyannis",
        "postal_code": "02601",
        "email": "https://keating.house.gov/contact",
    },
]


def _build(rec: dict, sort_order: int) -> Recipient:
    title = rec["title"]
    first = rec["first_name"]
    last = rec["last_name"]
    return Recipient(
        target_id=TARGET_ID,
        formal_name=f"{title} {first} {last}",
        first_name=first,
        last_name=last,
        salutation=f"{title} {last}",
        title=title,
        organization="",
        email=rec["email"],
        street1=rec["street1"],
        street2=rec.get("street2", ""),
        city=rec["city"],
        state="MA",
        postal_code=rec["postal_code"],
        sort_order=sort_order,
    )


def main() -> int:
    app = create_app()
    with app.app_context():
        target = db.session.get(Target, TARGET_ID)
        if target is None:
            print(f"ERROR: target {TARGET_ID} not found.", file=sys.stderr)
            return 1
        if target.name != EXPECTED_TARGET_NAME:
            print(
                f"ERROR: target {TARGET_ID} is named {target.name!r}, "
                f"expected {EXPECTED_TARGET_NAME!r}. Aborting in case this is "
                "the wrong database.",
                file=sys.stderr,
            )
            return 1

        existing_names = {r.formal_name for r in target.recipients}
        next_sort = max((r.sort_order for r in target.recipients), default=-1) + 1

        added: list[str] = []
        skipped: list[str] = []
        for rec in RECIPIENTS:
            formal = f"{rec['title']} {rec['first_name']} {rec['last_name']}"
            if formal in existing_names:
                skipped.append(formal)
                continue
            db.session.add(_build(rec, next_sort))
            added.append(formal)
            next_sort += 1

        db.session.commit()

    for name in added:
        print(f"  added:   {name}")
    for name in skipped:
        print(f"  skipped: {name} (already present)")
    print(f"\nDone — {len(added)} added, {len(skipped)} skipped.")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
