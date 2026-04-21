# Lexington Alarm Documentation — Master Index

**Site:** lexingtonalarm.org
**Repo:** github.com/tobysackton/lexington_alarm
**Last Updated:** April 21, 2026 (repo migration)

---

## Quick Navigation — When working on...

- **Store / WooCommerce issues** → `02_Store_System/`
- **Email, newsletter, Mailchimp** → `03_Email_Systems/`
- **Home page, news, events, content** → `04_Content_Publishing/`
- **Active campaigns (Massport, RI, Nat'l Dev)** → `05_Active_Campaigns/`
- **Styling / design / Kadence** → `01_Technical_Foundation/Theme_And_Styling.md`
- **Custom code / snippets** → `../snippets/` (outside docs/)
- **Plugin `la-custom` source** → `../code/wp-content/plugins/la-custom/`
- **Recent changes** → `06_Change_Log/`
- **Brand colors, fonts, common tasks** → `07_Quick_References/`

---

## Directory structure

### 01_Technical_Foundation/
Foundation-level site configuration, hosting, and architecture.
- `Site_Configuration.md` — WordPress, hosting, domains, DNS
- `Theme_And_Styling.md` — Kadence setup, CSS framework, fonts
- `Plugins_And_Integrations.md` — All plugins with versions and purpose
- `Custom_Page_Templates_Guide.md` — How custom page templates work
- `Script_Instructions.md` — How to use Python export scripts
- `sync_workflow/` — WordPress sync system docs (SETUP_COMPLETE, QUICK_REFERENCE_CARD, SYNC_WORKFLOW_QUICKSTART)
- `update local lex alarm website wordpress.md` — Local dev site update steps

### 02_Store_System/
WooCommerce e-commerce functionality.
- `WooCommerce_Setup.md` — Current configuration & settings
- `Products_Catalog.md` — All products, variations, shipping classes
- `Checkout_Flow.md` — Payment, shipping, cart validation
- `Email_Notifications.md` — Store-related automated emails
- `Shopping_Cart_Fixes_Dec2025.md` — December 2025 cart validation fixes
- `lexington-shop-docs.md` — Shop page reference

### 03_Email_Systems/
All email infrastructure and workflows.
- `MAILCHIMP_NEWS_SETUP_GUIDE.md` — Setting up Mailchimp campaigns
- `MAILCHIMP_RSS_SETUP.md` — RSS feed bridge
- `MC4WP_FORM_SETUP_WITH_TOWN.md` — MC4WP form with town-of-residence
- `NEWSLETTER_ARCHIVE_ARCHITECTURE.md` — Newsletter archive structure
- `NEWSLETTER_SHORTCODES_COMPLETE.md` — Shortcode reference
- `Mailchimp_WooCommerce_Integration.md` — Mailchimp ↔ WooCommerce sync

### 04_Content_Publishing/
Content management systems and workflows.
- `Home_Page.md` — Home page structure, dynamic content
- `Events_Calendar.md` — Tockify events integration
- `Speaker_Videos_Page.md` — Speaker video archive
- `Media_System_Team_Overview.md` — Media workflow for team
- `About_Page_COMPLETE.md`, `About_Page_Migration.md` — About page
- `Lexington_Alarm_Footer_Documentation.md` — Footer configuration
- HTML working files: `tockify-events-page.html`, `tockify-two-tier.html`, `lexington-footer.html`, `lexington_alarm_join_page.html`, `lexington-sign-placeholders.html`, `lexington_alarm_font_template.html`
- `News_System/` — Complete news system docs
  - `NEWS_SYSTEM_INDEX.md` — Overview and quick reference
  - Public page, team portal, roles, notifications, inline editing

### 05_Active_Campaigns/
Active advocacy campaigns, letter templates, PDF generators.
- `massport/` — Massport/Healey campaign
  - `Massport_Campaign.md` — Campaign strategy and status
  - `massport_pdf.php`, `massport_gmail_helper_template.php` — Code
  - `Healey_Massport_Letter_Update_Prep.md` — Letter iterations
  - `code_updates_2025-12-13/` — Dated code updates
- `rhode_island/` — Rhode Island variant
- `national_development/` — National Development campaign
- `ICE_Task_Force_Interest_Use.xlsx` — ICE task force signup data

### 06_Change_Log/
Dated change entries.
- `2025-11-16_Massport_Email_Formatting_Progress.md`
- `2025-12-11_Shopping_Cart_Fixes.md`
- `2025-12-13_Campaign_Proofreading_Corrections.md`
- `2025-12-27_Performance_Optimization.md`
- `2025_Q4_Changes.md` — Quarterly rollup
- `_legacy_flat_changelog.md` — Pre-structured changelog from legacy repo

### 07_Quick_References/
Essential references and cheat sheets.
- `Brand_Assets.md` — Colors, fonts, usage
- `Common_Tasks.md` — Frequent operations
- `IMPORTANT_Custom_Page_Templates_Guide.md` — Page template usage

### _archive/
Retired docs, migration history, event photos, Obsidian schedule templates. Reference-only.
See `_archive/MIGRATION_LOG.md` for the record of what moved where during the April 2026 migration.

---

## Where snippet code lives

- **`../code/wp-content/plugins/la-custom/`** — Custom plugin source. Snippets migrated from WPCode live here as PHP files.
- **`../snippets/active/`** — Reference `.md` docs for snippets still running in WPCode (not yet migrated to `la-custom`).
- **`../snippets/archived/`** — Retired or superseded snippets.
- **`../snippets/wpcode-exports/`** — Dated full-DB JSON exports of WPCode state (backups, reference).

See `../snippets/active/WPCode_Active_Snippets.md` for the authoritative list of what's currently running.

---

## Related repo locations

- **`../code/`** — Live, deployable site code (child theme, custom plugin)
- **`../scripts/`** — Python and shell tooling (WPForms export, sync operations)
- **`../assets/`** — Brand materials (logos, fonts, banners, architecture diagrams)
- **`../dev/`** — Local development environment setup

See root `README.md` for the full repo overview.

---

## Numbering notation

Numbering in this directory: `01` through `07`, closed gap (renumbered in April 2026 migration from previous `01`-`05, 07, 08` layout). `03_Email_Systems/` is now populated.
