# Campaign Tooling — Data Model

The system organizes a letter-writing campaign as a hierarchy: **Campaign → Targets → (Recipients, Artifacts, Parameters)**. Plus a **Writer** — the volunteer using the public site, captured from a form rather than stored in the DB.

## Campaign

The top-level container. Slug-addressed (`/c/<slug>`), with marketing copy for the public landing page.

| Field | Purpose |
|---|---|
| `slug` | URL identifier, unique |
| `name` | Title shown on the landing page |
| `subhead` | Short tagline under the title |
| `description` | One-paragraph blurb |
| `body_md` | Longer copy in a highlight box (currently plain text, "md" is aspirational) |
| `active` | Off-switch: inactive campaigns return 410 Gone |
| `sort_order` | Display order on the campaign list |

A campaign has many **Targets**.

## Target

A conceptual audience within a campaign — e.g. "Massport Board," "Governor's Office," "CT Treasury Pension Funds." Targets are what writers pick from cards on the campaign page.

| Field | Purpose |
|---|---|
| `name` | Card title shown to writers |
| `description` | Card body text |
| `sort_order` | Card order |

A target has many **Recipients**, **Artifacts**, and **Parameters**.

## Recipient

A real person within a target — the actual addressee of an email or letter. Each target's artifacts get fanned out across every eligible recipient.

| Field | Purpose |
|---|---|
| `formal_name` | "Hon. Maura Healey" — used in postal address blocks |
| `salutation` | "Governor Healey" — used in greetings |
| `first_name`, `last_name`, `title`, `organization` | Available to templates |
| `email` | If non-blank, recipient is eligible for email artifacts |
| `street1`, `street2`, `city`, `state`, `postal_code` | If `street1`+`city` non-blank, eligible for postal letters |

**Eligibility rule:** A recipient receives an email artifact only if they have an email; a postal letter only if they have an address. Mixed recipients (email-only or postal-only) don't crash — the artifact just skips them.

## Artifact

A letter template attached to a target. Subject and body are Jinja2 templates with `{{ placeholder }}` substitution.

| Field | Purpose |
|---|---|
| `name` | Internal label (writer doesn't see this) |
| `kind` | `email` or `letter` |
| `subject` | Email subject line (templated) |
| `body` | Letter body (templated) |
| `sort_order` | Display order on the target page |

A target can mix email and letter artifacts freely.

## TargetParameter

A free-form string the writer must supply before this target's artifacts can be rendered — e.g. `job_title`, `employer`, `union_name`. Defined per-target so each audience asks only for what it needs.

| Field | Purpose |
|---|---|
| `key` | Template identifier — referenced as `{{ parameter.<key> }}`. Lowercase letters/digits/underscores; must start with a letter. Unique per target. |
| `label` | What the writer sees on the form |
| `help_text` | Optional hint shown under the field |
| `required` | If true, the form blocks submission until filled |
| `sort_order` | Field order on the form |

## Writer

Not a DB row. The volunteer's contact info is collected on the per-target page and rides in the URL query string (`?name=…&email=…&p_<key>=…`). Stateless, shareable, restartable. Same shape as Recipient (name, email, address) plus optional `organization`.

## Substitution scopes

Artifact subjects and bodies have access to these template variables:

| Scope | Source |
|---|---|
| `writer.*` | Writer's form input |
| `recipient.*` | The DB row for whoever this letter is going to |
| `target.*` | The DB row for the audience |
| `parameter.<key>` | Writer's answers to that target's parameters |
| `date`, `date_long` | Today, ISO and long-form |

Missing or unsupplied values render as the empty string — no crashes if a template references an undefined parameter.

## Cascade behavior

Deletes flow downward:

- Delete a Campaign → its Targets, Recipients, Artifacts, and Parameters all go.
- Delete a Target → its Recipients, Artifacts, and Parameters go; the Campaign stays.
- Delete a Recipient / Artifact / Parameter → the Target stays.

## Rough cardinality (for sizing)

- Campaign: ~5–20 lifetime
- Targets per campaign: ~1–10
- Recipients per target: ~1–50
- Artifacts per target: ~1–5
- Parameters per target: ~0–8

## What's intentionally NOT modeled

- **Writer accounts / persistence.** No login, no DB row for the volunteer. Privacy stance plus simpler ops. May change if we add open-rate or click tracking.
- **Sent-letter records.** Email delivery is `mailto:` — sending happens in the writer's mail client, server never sees it. Postal letters are PDF/print only.
- **Eligibility rules** (e.g. "CT residents only"). Filed as a TODO; would attach to Campaign or Target.
- **Versioning of artifact bodies.** Edits overwrite. Restore would come from `flask export-seed` snapshots, not DB history.
