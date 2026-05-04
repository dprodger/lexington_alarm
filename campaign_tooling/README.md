# Campaign Tooling

A standalone Flask app for managing email/postal letter-writing campaigns. Replaces the legacy WordPress + WPCode "massport" approach with a generalized data model where any campaign is **{Campaign + Targets + Artifacts}**.

See `docs/01_campaign_datamodel.md` for the domain model and `docs/02_stack.md` for the deploy stack.

## Local development

```bash
python3 -m venv .venv
source .venv/bin/activate
pip install -r requirements.txt

cp .env.example .env       # fill in DATABASE_URL and ADMIN_TOKEN — see below
flask --app wsgi seed      # creates a starter CT pension campaign
flask --app wsgi run --port 5050   # http://127.0.0.1:5050
```

> **macOS note:** Don't use the default port 5000. macOS AirPlay Receiver listens there and silently intercepts requests — Flask appears to start, but the browser shows a blank page and no requests reach Flask. Run on `--port 5050` (or any other free port), or disable AirPlay Receiver in *System Settings → General → AirDrop & Handoff*.

## Database

We use **Supabase Postgres** in both local development and production — same backing store, no SQLite-vs-Postgres drift. All app tables live in a dedicated `campaign_tooling` **schema** (the schema name is hardcoded in `app/extensions.py` via SQLAlchemy `MetaData(schema=...)`), keeping them namespaced away from anything else sharing the project.

### One-time Supabase setup

1. **Create the schema.** In the Supabase SQL Editor:
   ```sql
   CREATE SCHEMA campaign_tooling;
   ```
2. **Get a connection string.** Project Settings → Database → Connection string → **Session pooler** (port 5432, host `aws-0-<region>.pooler.supabase.com`). Avoid the transaction pooler (port 6543) — it strips features SQLAlchemy relies on.
3. **Set `DATABASE_URL` in `.env`.** Note the `+psycopg` driver suffix — required so SQLAlchemy uses psycopg3 (which we install) rather than psycopg2 (which we don't):
   ```
   DATABASE_URL=postgresql+psycopg://postgres.<project-ref>:<url-encoded-password>@aws-0-<region>.pooler.supabase.com:5432/postgres
   ```
   URL-encode any special characters in the password:
   ```bash
   python3 -c "import urllib.parse; print(urllib.parse.quote('your-password', safe=''))"
   ```
4. **Run `flask --app wsgi seed`.** `db.create_all()` runs at app startup and will create `campaigns`, `targets`, `artifacts` inside `campaign_tooling`.

### SQLite fallback

If `DATABASE_URL` is unset or doesn't start with `postgresql`, SQLAlchemy falls back to a local SQLite file (`campaign_tooling.db`). Useful for tests; not the recommended dev path.

## URL map

| Path | Audience | Purpose |
|---|---|---|
| `/` | public | List active campaigns |
| `/c/<slug>` | public | Campaign detail + writer-info form |
| `/c/<slug>/action` | public | Per-target email (`mailto:`) and printable letter actions |
| `/c/<slug>/print/<target>/<artifact>` | public | Single printable letter |
| `/admin/login` | admin | Token gate (uses `ADMIN_TOKEN` from `.env`) |
| `/admin/` | admin | Campaign list |
| `/admin/campaigns/new` | admin | Create campaign |
| `/admin/campaigns/<id>` | admin | Edit campaign + inline targets/artifacts |

## Layout

```
app/
  __init__.py        # Flask app factory
  extensions.py      # SQLAlchemy instance
  models.py          # Campaign, Target, Artifact
  substitution.py    # {{writer.*}}, {{target.*}}, {{date_long}} renderer
  routes_public.py   # Public letter-writer flow
  routes_admin.py    # Admin CRUD
  cli.py             # `flask seed`, `flask reset-db`
  templates/
    base.html
    admin/...
    public/...
  static/style.css
config.py
wsgi.py              # Entry point
```

## Variable substitution

Artifact bodies and email subjects support these placeholders:

| Placeholder | Source |
|---|---|
| `{{ writer.name }}`, `{{ writer.email }}`, `{{ writer.organization }}` | Letter-writer's form input |
| `{{ writer.street1 }}`, `{{ writer.city }}`, `{{ writer.state }}`, `{{ writer.postal_code }}` | Letter-writer's address |
| `{{ writer.address_block }}` | Multi-line formatted writer address |
| `{{ target.formal_name }}`, `{{ target.salutation }}`, `{{ target.first_name }}`, `{{ target.last_name }}` | Target (recipient) names |
| `{{ target.title }}`, `{{ target.organization }}`, `{{ target.email }}` | Target metadata |
| `{{ target.street1 }}`, `{{ target.city }}`, `{{ target.state }}`, `{{ target.postal_code }}` | Target's address |
| `{{ target.address_block }}` | Multi-line target address (street / city, state zip), *not* including `formal_name` |
| `{{ date }}` | ISO date (`2026-05-04`) |
| `{{ date_long }}` | Long form (`May 4, 2026`) |

Unknown placeholders are left untouched in the output so admins can spot typos.

## Send mechanics

By design, all email sends happen from the writer's own email client via `mailto:` links. We do not run an SMTP/Postmark/SES integration server-side — letters from real people are more persuasive to elected officials than letters from an intermediary, and skipping server-side sending also dodges deliverability and spoofing concerns.

Postal letters are rendered as a printable HTML view with a `Print` button. A future iteration may swap that for server-rendered PDFs (WeasyPrint or similar).

## Deployment (Render)

The repo ships a `render.yaml` Blueprint that defines the Render web service. It pins `rootDir: campaign_tooling` so Render builds only this subdirectory of the parent `lexington_alarm` repo.

### First-time setup

1. **Push your branch** to GitHub. Render pulls from there.
2. **Create the Blueprint**: Render dashboard → **New** → **Blueprint** → connect the `lexington_alarm` GitHub repo. Render reads `campaign_tooling/render.yaml` and offers to create the `campaign-tooling` service.
3. **Set the two secret env vars** (Render prompts you because they're declared `sync: false`):
   - `DATABASE_URL` — the same Supabase Session Pooler string from your local `.env`, with `+psycopg` driver and URL-encoded password.
   - `ADMIN_TOKEN` — a fresh strong value for production. Don't reuse the local `dev-admin`.
4. **Deploy**. The first build runs `pip install -r requirements.txt`; the start command boots gunicorn. Watch the deploy log for errors.
5. **Seed (one-time)**. Once the deploy is live, open the service's **Shell** tab in the Render dashboard and run `flask --app wsgi seed`. This creates the tables in the `campaign_tooling` schema and inserts the starter CT pension campaign.
6. **Visit the public URL** Render assigned (`https://campaign-tooling.onrender.com` or similar) and confirm the campaign list and admin login both work.

### Notes

- **Free tier sleeps after 15 minutes of inactivity** and the first request after sleep takes ~30s to wake. Upgrade to **Starter** ($7/mo) when this becomes user-visible.
- **Workers are pinned to 1** in `render.yaml`. `db.create_all()` runs in the app factory and isn't race-safe; once we wire Alembic migrations as a release step, raise `--workers` to 2.
- **`SECRET_KEY` is auto-generated** by Render via `generateValue: true`. Don't rotate it casually — it invalidates existing admin sessions.
- **Auto-deploy is on**: every push to `main` triggers a Render build. Disable in the dashboard if you want manual control.

## TODOs before this is production-ready

- [ ] **Real auth** — replace shared `ADMIN_TOKEN` with proper user accounts (Supabase Auth, Flask-Login, or HTTP basic at the reverse proxy).
- [ ] **Eligibility gates** — per-campaign rules like "Connecticut residents only" need a model for `validation_rules` on Campaign and a check on the writer-info form.
- [ ] **Tracking** — capture name/email/action when a writer clicks an action button (per the legacy WPForms-based logging).
- [ ] **PDF rendering** — server-side PDF for postal letters so writers don't depend on browser print quality.
- [ ] **Multi-state support** — the data model already allows multiple targets per campaign; we need UI to filter targets by writer's state and per-state artifact bodies.
- [ ] **Migrations** — `db.create_all()` only creates missing tables; it never alters existing ones. Wire up Alembic before any column changes ship to Supabase.
- [ ] **Deploy** — `Procfile` / `gunicorn` config + Render service + Supabase Postgres connection string.
- [ ] **Tests** — at minimum the substitution renderer and a smoke test of each public route.
```
