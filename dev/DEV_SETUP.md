# Local Development Setup

How to run a local copy of lexingtonalarm.org for development and testing.

## Current state (as of repo creation, April 2026)

**Local by Flywheel** at `/Users/jtsackton/Local Sites/la-wordpress-local/` is the existing local dev environment. It has known issues — pushes to production have broken things in recent weeks. We're planning to migrate to a Docker-based setup (see **Roadmap** below).

**For now**, if you're onboarding:

1. Install [Local by Flywheel](https://localwp.com/)
2. Ask Toby for a recent UpdraftPlus backup from Dropbox
3. Create a new Local site matching the production stack:
   - PHP 8.x
   - MySQL 8.x
   - WordPress (latest stable)
4. Import the UpdraftPlus backup (use the UpdraftPlus "Restore" option inside the Local site's WP Admin)
5. Clone this repo: `git clone git@github.com:tobysackton/lexington_alarm.git ~/Documents/github_lexington_alarm`
6. Symlink or copy `code/wp-content/plugins/la-custom/` into the Local site's plugins folder
7. Symlink or copy `code/wp-content/themes/kadence-child/` into the Local site's themes folder
8. Activate the child theme and `la-custom` plugin in WP Admin

Then test by loading the site in a browser and confirming basic flows:
- Homepage renders with correct fonts and layout
- Shop loads at `/browse-products/` with the 2x2 card grid
- A news post renders correctly
- Newsletter archive shortcode displays correctly

## Roadmap — Docker/wp-env migration (planned)

The goal is a reproducible, single-command local environment. Target stack:

- Docker Compose (or `@wordpress/env`)
- MySQL matching production version
- PHP matching production version
- Mapped volumes to `code/wp-content/plugins/` and `code/wp-content/themes/` in this repo

Once set up, onboarding becomes:

```bash
git clone git@github.com:tobysackton/lexington_alarm.git
cd lexington_alarm
docker-compose up
# site available at http://localhost:8888
```

Status: not yet built. Will live in `dev/docker-compose.yml`.

## Deployment to Bluehost

We don't yet have automated deploy. Current process:

1. Merge PR to `main`.
2. Manually upload the changed files via Bluehost File Manager or SFTP to:
   - `public_html/wp-content/plugins/la-custom/`
   - `public_html/wp-content/themes/kadence-child/`
3. Verify on production.

Future: automate with a GitHub Action pushing via SSH. Will live in `scripts/deploy/`.

## Secrets and configuration

**Never commit `wp-config.php`** — it contains database credentials. Each environment (local, staging, production) has its own.

For local: Local by Flywheel generates `wp-config.php` automatically when you create a site.

For Bluehost: managed via cPanel.

Production API keys (Stripe, Mailchimp, SendLayer) are stored in Proton Pass family shared vault. Ask Toby for access.
