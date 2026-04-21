# Local Development Setup

How to run a local copy of lexingtonalarm.org for development and testing.

## Overview

Three ways to run locally, in order of recommendation:

1. **wp-env** (recommended) — Official WordPress tool, simple JSON config, one command to start
2. **Docker Compose** — More control; use if Node.js tooling isn't your preference
3. **Local by Flywheel** — The legacy path; known to have drift issues, use only if the above don't work

All three give you a working WordPress site that mounts `code/wp-content/plugins/la-custom/` and `code/wp-content/themes/kadence-child/` from this repo. Edits to those folders reflect immediately in the running site.

---

## Option 1 — wp-env (recommended)

### Prerequisites

- Docker Desktop installed and running
- Node.js 16+ (check: `node --version`)

### Start the site

From the repo root:

```bash
cd ~/Documents/github_lexington_alarm
npx @wordpress/env start
```

First run downloads WordPress, PHP, MySQL, and the plugins listed in `.wp-env.json`. Takes a few minutes. Subsequent starts are fast.

Site available at: **http://localhost:8888**
WP Admin: **http://localhost:8888/wp-admin** (user: `admin`, password: `password`)

### Common wp-env commands

```bash
npx @wordpress/env start       # Start (or restart after config change)
npx @wordpress/env stop        # Stop cleanly
npx @wordpress/env destroy     # Nuke all containers + data (fresh start)
npx @wordpress/env run cli "wp plugin list"   # Run WP-CLI commands
npx @wordpress/env logs        # View logs
```

### What's included automatically

From `.wp-env.json`:

- WordPress core (latest stable)
- PHP 8.1
- The `la-custom` plugin from this repo (live-mounted)
- The Kadence child theme from this repo (live-mounted)
- Kadence parent theme (free version from WP.org)
- WooCommerce, Mailchimp for WP, WPForms Lite, UpdraftPlus, Relevanssi, Kadence Blocks

### What's NOT included (manual setup required)

These are premium/licensed products that wp-env can't install:

- **Kadence Pro parent theme** (if you need premium Kadence features like Header Builder)
- **WPCode Premium** (you have the free tier auto-installed; some snippets may need the paid version)
- **WPForms Pro** (auto-installed is Lite; conditional logic and pro fields require Pro)
- **Advanced Shipping Packages** (premium)
- **Payment Plugins for Stripe** (premium)

To install these:

1. Download the plugin/theme ZIP from your vendor account (Stellar, WPForms, etc.)
2. In WP Admin → Plugins → Add New → Upload Plugin (or Themes → Upload Theme)
3. Activate and enter license key

### Getting real content into the dev site

Fresh wp-env gives you empty WordPress. To match production:

1. Get a recent UpdraftPlus backup from Dropbox (the auto-nightly backup location).
2. Install UpdraftPlus in the dev site (auto-installed already).
3. WP Admin → Settings → UpdraftPlus → **Restore** tab → upload the backup files.
4. Run through the restore process.

---

## Option 2 — Docker Compose (alternative)

Use if you prefer not to use Node.js or need more control than wp-env gives.

### Prerequisites

- Docker Desktop installed and running

### Start

```bash
cd dev
docker compose up -d
```

Site: **http://localhost:8888**
PHPMyAdmin: **http://localhost:8081**

### Common commands

```bash
cd dev
docker compose up -d           # Start
docker compose down            # Stop (preserves DB)
docker compose down -v         # Stop + delete all data (fresh start)
docker compose logs wordpress  # View WordPress logs
docker compose exec wordpress bash   # Shell into WordPress container
```

### Caveats

- First run takes you to the WordPress setup wizard (`wp-admin/install.php`). Create an admin user and continue.
- After setup, manually install the Kadence parent theme and premium plugins (same as wp-env).
- Import UpdraftPlus backup as documented above.

Config lives in `dev/docker-compose.yml`.

---

## Option 3 — Local by Flywheel (legacy, only if above don't work)

The existing setup at `/Users/jtsackton/Local Sites/la-wordpress-local/`. It works but has known push-to-production issues. Use only if wp-env and Docker Compose aren't viable for your machine.

1. Install [Local by Flywheel](https://localwp.com/)
2. Get a recent UpdraftPlus backup from Dropbox
3. Create a new Local site matching the production stack: PHP 8.x, MySQL 8.x
4. Import the backup via UpdraftPlus Restore
5. Symlink `code/wp-content/plugins/la-custom/` and `code/wp-content/themes/kadence-child/` into the Local site's `wp-content/`

---

## Smoke-testing after setup

Regardless of which option you used, verify:

- [ ] Homepage renders with correct fonts (Libre Baskerville, Work Sans, UglyQua)
- [ ] Homepage shows brand colors (`#044f9d` blue, `#c3202e` red)
- [ ] Shop loads at `/browse-products/` with the 2x2 card grid
- [ ] Mobile header shows hamburger menu at widths below 1024px (not 768px)
- [ ] A news post renders and a draft submission works
- [ ] Newsletter archive shortcode `[la_newsletter_archive]` displays correctly

If any fail, check `wp-content/debug.log` for errors and compare active plugins against the production list (`docs/01_Technical_Foundation/Plugins_And_Integrations.md`).

---

## Deployment to Bluehost

We don't yet have automated deploy. Current process:

1. Merge PR to `main`.
2. Manually upload changed files via Bluehost File Manager or SFTP to:
   - `public_html/wp-content/plugins/la-custom/`
   - `public_html/wp-content/themes/kadence-child/`
3. Verify on production.

Planned: GitHub Action pushing via SSH. Will live in `scripts/deploy/`.

---

## Secrets and configuration

**Never commit `wp-config.php`** — it contains database credentials. Each environment (local, staging, production) has its own:

- **wp-env / Docker Compose local:** auto-generated, kept inside the container
- **Local by Flywheel:** auto-generated per site
- **Bluehost production:** managed via cPanel, never touched locally

Production API keys (Stripe, Mailchimp, SendLayer, Printful) are stored in Proton Pass family shared vault. Ask Toby for access.

For local dev API keys, use sandbox/test credentials where possible (Stripe has test mode; Mailchimp has dev lists). Never use production keys in a dev environment.
