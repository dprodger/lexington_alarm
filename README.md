# Lexington Alarm — Site and Organization Repo

Canonical source for the custom code, documentation, snippets, scripts, and working materials supporting [lexingtonalarm.org](https://lexingtonalarm.org) and the organization's operations.

## What this repo is

- **Custom code** for the WordPress site: child theme, custom plugin (`la-custom`), and scripts.
- **Documentation** covering the technical stack, store, email systems, content publishing, and active campaigns.
- **Snippet references** and WPCode DB backups (JSON exports).
- **Tooling** — Python and shell scripts for WPForms export, sync operations, and deploys.
- **Campaign working materials** — letter templates, PDF generators, coalition artifacts.
- **Design assets** — fonts, logos, brand materials (optimized only; PSDs and large source files live on Proton Drive).

## What this repo is NOT

- WordPress core, Kadence theme files, third-party plugins — these are installed fresh per environment.
- The WordPress database — lives in the running site; backed up via UpdraftPlus → Dropbox.
- User uploads (WordPress media library) — same.
- Secrets, credentials, `wp-config.php`, `.env` files — explicitly excluded by `.gitignore`.

## Directory layout

```
docs/                  Documentation — the structured knowledge base
  00_INDEX.md          Master index
  01_Technical_Foundation/
  02_Store_System/
  03_Email_Systems/
  04_Content_Publishing/
  05_Active_Campaigns/  (massport, rhode_island, national_development)
  06_Change_Log/        Dated change entries
  07_Quick_References/  Brand assets, common tasks
  _archive/             Retired docs, migration history, event photos

code/                  Live, deployable code
  wp-content/
    plugins/la-custom/       Custom plugin (snippets migrating here gradually)
    themes/kadence-child/    Child theme overrides and CSS

snippets/              Snippet history (NOT deployed code)
  wpcode-exports/      Dated WPCode DB JSON exports
  active/              Current snippets still living in WPCode
  archived/            Retired or superseded snippets

scripts/               Tooling
  wpforms_export/      WPForms DB export Python scripts
  sync/                WordPress sync shell scripts
  deploy/              (future) deploy scripts

assets/                Design source materials (optimized versions only)
  fonts/               UglyQua, ArmaliteRifle + licenses
  logos/
  brand/               Banners, architecture diagrams, event images

dev/                   Local development environment
  DEV_SETUP.md         How to run locally
  docker-compose.yml   (future — Phase 1)
```

## Getting started

For current contributors, see `dev/DEV_SETUP.md` for how to get a working local environment.

For the project's history and current priorities, start with:
- `docs/00_INDEX.md` — navigation overview
- `docs/06_Change_Log/` — what's changed recently
- `docs/07_Quick_References/Common_Tasks.md` — frequent operations

## Related resources

- **Production site:** lexingtonalarm.org (Bluehost)
- **Archive and sensitive materials:** Proton Drive (`ProtonDrive-info@lexingtonalarm.org-folder/LexingtonAlarm Executive/`)
- **Legacy repo:** `github.com/tobysackton/lexington_alarm_legacy` — frozen snapshot of prior repo state, Apr 2026
- **Nightly site backups:** UpdraftPlus → Dropbox

## License and contributions

See `CONTRIBUTING.md` for how to propose changes. Currently active contributors: @tobysackton, @dprodger

---

*Repo established April 2026 as part of a site rationalization effort. Prior materials consolidated from `~/Desktop/LexingtonAlarm_Docs/` and the legacy repo. See `docs/_archive/MIGRATION_LOG.md` for migration details.*
