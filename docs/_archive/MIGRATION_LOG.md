# Repo Migration Log — April 2026

This document captures the April 2026 consolidation of Lexington Alarm materials from multiple scattered locations into a single canonical repo (`lexington_alarm` on GitHub).

## Background

Prior to this migration, LA materials lived in four locations:
1. **`~/Desktop/LexingtonAlarm_Docs/`** — structured docs, organized 01–08 numbered subdirectories
2. **`~/Documents/github_lexington_alarm/`** — a repo that started life as the pre-WordPress static HTML site, accumulated WordPress working files, WP core dumps, seafood data, and Google Apps Script code
3. **Proton Drive archive** — long-term storage, untouched
4. **Obsidian vault at `~/vault/`** — personal scheduling, separate from LA docs

The legacy repo was 1.3 GB with 46K+ untracked files including full WordPress core installations, a 7 MB SQL database dump, and seafood analysis work (CSVs, HTMLs) from an October 2025 FCC speech. This was not a multi-user-ready foundation.

## What happened

### Legacy repo
1. **Pre-reorganization snapshot committed** to the legacy branch (commit `ea44452`) capturing 156 files of LA-related content. WordPress core, SQL dumps, and most of the 46K untracked files were correctly excluded via `.gitignore`.
2. **Seafood work moved out** to `~/Desktop/_seafood_review_from_legacy_repo/` for later verification against the `seafooddatasearch` repo.
3. **GitHub repo renamed** `lexington_alarm` → `lexington_alarm_legacy`.
4. **Local folder renamed** `~/Documents/github_lexington_alarm` → `~/Documents/github_lexington_alarm_legacy`.

### New repo
1. Fresh `lexington_alarm` created on GitHub.
2. Local `~/Documents/github_lexington_alarm/` initialized with designed structure.
3. Content migrated from both `LexingtonAlarm_Docs/` and the legacy repo.
4. Docs renumbered to close the gap at `03_Email_Systems/`: old `07_Change_Log` → `06_Change_Log`; old `08_Quick_References` → `07_Quick_References`.

## What moved where

### From `~/Desktop/LexingtonAlarm_Docs/`

| Source | Destination |
|---|---|
| `00_INDEX.md` | `docs/00_INDEX.md` (rewritten to reflect new structure) |
| `01_Technical_Foundation/` | `docs/01_Technical_Foundation/` |
| `02_Store_System/` | `docs/02_Store_System/` |
| `03_Email_Systems/` (empty) | `docs/03_Email_Systems/` (populated from other sources) |
| `04_Content_Publishing/` | `docs/04_Content_Publishing/` |
| `05_Active_Campaigns/Massport_campaign/` | `docs/05_Active_Campaigns/massport/` (renamed) |
| `05_Active_Campaigns/Rhode_Island_campaign/` | `docs/05_Active_Campaigns/rhode_island/` |
| `05_Active_Campaigns/National Developent campagn/` | `docs/05_Active_Campaigns/national_development/` (typo fixed) |
| `06_Code_Snippets/*.php` | `snippets/active/` and `snippets/archived/` |
| `06_Code_Snippets/wpcode-snippets-export-2026-03-07.json` | `snippets/wpcode-exports/` |
| `07_Change_Log/` | `docs/06_Change_Log/` (renumbered) |
| `08_Quick_References/` | `docs/07_Quick_References/` (renumbered) |
| `Claude_Filesystem_Sync_Guide.md` | `docs/_archive/` |
| `Development_Timeline_History.md` | `docs/_archive/` |
| `Healey_Massport_Letter_Update_Prep.md` | `docs/05_Active_Campaigns/massport/` |
| `Media_System_Team_Overview.md` | `docs/04_Content_Publishing/` |
| `Script_Instructions.md` | `docs/01_Technical_Foundation/` |
| `hfw-dashboard-index-FIXED.php` | `snippets/active/` |
| `Obsidian_Schedule_Templates/` | `docs/_archive/obsidian_schedule_templates/` |
| `update local copy lex alarm website/` | `docs/01_Technical_Foundation/` |
| `performance-snippets/` | `snippets/active/performance-snippets/` |
| `backblaze_log_issue.txt`, `bus-ticket-reminder-email-march26.html` | `docs/_archive/` |

### From legacy repo

| Source | Destination |
|---|---|
| `wordpress working files/Kadence_customize_CLEANED.css` | `code/wp-content/themes/kadence-child/style.css` |
| `wordpress working files/Kadence_customize.css` | `code/wp-content/themes/kadence-child/style_ORIGINAL_unclean.css` |
| `wordpress working files/woocommerce_snippets/*.php` and `.md` | `snippets/active/woocommerce/` |
| `wordpress working files/fonts/` | `assets/fonts/` |
| `wordpress working files/LexingtonAlarm_logo_sm.png` | `assets/logos/` |
| `wordpress working files/About_Page_*.md` | `docs/04_Content_Publishing/` |
| `wordpress working files/Events_Page_documentation.txt` | `docs/04_Content_Publishing/` |
| `wordpress working files/tockify-*.html`, `lexington-*.html`, `lexington_alarm_*.html` | `docs/04_Content_Publishing/` |
| `wordpress working files/WooCommerce_Store_Setup.md` | `docs/02_Store_System/` |
| `wordpress working files/Mailchimp_WooCommerce_Integration.md` | `docs/03_Email_Systems/` |
| `wordpress working files/front end news posting oct 10.php` | `snippets/archived/front_end_news_posting_oct_10.php` |
| `wordpress working files/Oct*.jpg`, `Oct_18_crowd.webp` | `docs/_archive/event_photos/` |
| `wordpress working files/active_snippets_table.md` | `snippets/active/active_snippets_table_FROM_LEGACY.md` (superseded — see Drift section) |
| Migration planning docs | `docs/_archive/migration_docs/` |
| `wordpress_site/massport_pdf.php` | `docs/05_Active_Campaigns/massport/` |
| `wordpress_site/exported_snippets/*.json` | `snippets/wpcode-exports/` |
| `wordpress_site/current_state/MAILCHIMP_*.md`, `NEWSLETTER_ARCHITECTURE.md`, `NEWSLETTER_SHORTCODES_COMPLETE.md` | `docs/03_Email_Systems/` |
| `wordpress_site/current_state/*.md` (news/sync/misc) | `docs/_archive/wordpress_site_current_state/` |
| `wordpress_site/current_state/*.php` (newsletter archive variants) | `snippets/archived/` |
| `wordpress_site/current_state/pages/*.html` (exported WP pages) | `docs/_archive/wordpress_site_current_state/pages/` |
| `wordpress_site/database/extract_snippets.sh` | `scripts/` |
| `wordpress_site/lexington-shop-docs.md` | `docs/02_Store_System/` |
| `wordpress_site/notes_txt/*.md`, `.pdf` | `docs/_archive/migration_docs/notes_txt/` |
| `wordpress_site/notes_txt/frontend-*.php`, `news-*.html`, `news-*.php` | `snippets/archived/` |
| `wordpress_site/notes_txt/prevent_icloud_offload.sh` | `scripts/sync/` |
| Top-level `sync-wordpress-state.sh` | `scripts/sync/` |
| Top-level `SETUP_COMPLETE.md`, `SYNC_WORKFLOW_QUICKSTART.md`, `QUICK_REFERENCE_CARD.txt` | `docs/01_Technical_Foundation/sync_workflow/` |
| Top-level architecture diagrams (PNG) | `assets/brand/architecture_diagrams/` |
| Top-level `Lexington_Alarm_Meeting_Sept_16_2025_Formatted.txt` | `docs/_archive/` |
| Top-level `Lexington_Alarm_Site_Changelog.md` | `docs/06_Change_Log/_legacy_flat_changelog.md` |
| Top-level `Shop_Page_Current_Code.md` | `snippets/active/Shop_Page_Current_Code_FROM_LEGACY.md` (superseded) |
| Top-level `ICE_Task_Force_Interest_Use.xlsx` | `docs/05_Active_Campaigns/` |
| `images/LexAlarmBanner*`, `Website*Header*` | `assets/brand/banners/` |
| `images/NoKing*`, `Print_TeaseBattleGreen_*` | `assets/brand/event_images/` |
| `images/window*.jpg` | `assets/brand/window_signs/` |
| `images/la_logo_sm.jpeg`, `IMG_1642.png` | `assets/logos/`, `assets/brand/event_images/` |

### Not migrated (stayed in legacy or moved elsewhere)

- `website_97a098b6/` — 515 MB WordPress core dump. Not useful; WP core doesn't belong in git.
- `wordpress_site/wp-content/` — 283 MB of WP core + plugins. Same reason.
- `wordpress_site/current_state/uploads/` — 89 MB of media library. Not our code.
- `wordpress_site/database/*.sql` — Database dump. Contains user data; excluded for security.
- `wordpress_site/wp-config.php` — Database credentials. Excluded for security.
- `index.html`, `about.html`, `calendar.html`, etc. (pre-WordPress static site HTML) — Not useful for the WordPress era.
- `calendarFeed.js`, `appsscript.json`, `.clasp.json` — Google Apps Script for the old static calendar; the WP site uses Tockify.
- `FCC_Code/`, `FCC_Data/`, `additional charts/`, `CA_Exports_*`, `cod_analysis_*`, `trade-analysis-dashboard-*.html` — Seafood work, moved to `~/Desktop/_seafood_review_from_legacy_repo/` for verification against `seafooddatasearch` repo.
- `la_wordpress_local` symlink to Local by Flywheel site — would balloon the repo; replaced by future Docker setup.

## Drift check results

Files that existed in both `LexingtonAlarm_Docs/` and the legacy repo, with the drift determination:

| File | Canonical Version | Notes |
|---|---|---|
| `Shop_Page_Code.md` / `Shop_Page_Current_Code.md` | **Docs version** (Dec 3, 2025) | Docs has updated 2x2 grid with mobile stacking; legacy had Oct 29 older cards-stack version. |
| `WPCode_Active_Snippets.md` / `active_snippets_table.md` | **Docs version** (Dec 27, 2025) | Docs is newer and curated (194 lines); legacy is older Oct 20 but more exhaustive (336 lines). Legacy version retained as `*_FROM_LEGACY.md` for historical detail. |

Both legacy versions are retained in `snippets/active/` for reference but should not be edited going forward.

## Known issues to follow up on

- **`IMG_1642.png` is 11 MB.** Should be compressed to JPG or moved to Proton Drive. Flagged in `.gitignore` comments.
- **The `docs/03_Email_Systems/` folder was empty in the original docs.** Populated in this migration from legacy repo content; may benefit from an organizational pass.
- **Stray files** `style.css.new`, `style.css.tmp` in `code/wp-content/themes/kadence-child/` — leftover from repo construction, delete before initial commit.
- **Two superseded _FROM_LEGACY files** in `snippets/active/` — rename or move to `snippets/archived/` once review is complete.
- **Obsidian schedule templates in `_archive/`** — these are personal scheduling notes, not site docs. Consider moving to the Obsidian vault at `~/vault/` and removing from this repo.
- **Local by Flywheel is currently broken** for pushing back to production. See `dev/DEV_SETUP.md` for the migration-to-Docker plan.

## Next steps

1. Initial commit and push to `github.com/tobysackton/lexington_alarm`.
2. Seafood work verification against `seafooddatasearch` repo (Task 3 in the original plan).
3. Legacy folder can later move to external SSD for archival.
4. Begin Phase 1 of site architecture work (Docker dev environment, first snippet migration into `la-custom`).
5. Onboard first external contributor (once Phase 1 is at least partially done).

---

*Log created April 21, 2026 by the Cowork session driving the migration.*
