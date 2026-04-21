# 03 — Email Systems

Documentation for email infrastructure and integrations.

## Scope

This directory covers:

- **Transactional email** (WooCommerce orders, volunteer signups, form notifications) via SendLayer + WP Mail SMTP
- **Marketing email** (newsletter distribution, campaign blasts) via Mailchimp → future migration to MailerLite
- **Email-to-web integrations** — newsletter archive on site, Mailchimp RSS bridging
- **Email deliverability** — SPF, DKIM, DMARC for `lexingtonalarm.org` mail, Proton Mail inboxes (info@, store@, volunteer@)

## Current content

- `MAILCHIMP_NEWS_SETUP_GUIDE.md` — Setting up Mailchimp campaigns for news content
- `MAILCHIMP_RSS_SETUP.md` — RSS feed bridge between WordPress and Mailchimp
- `MC4WP_FORM_SETUP_WITH_TOWN.md` — MC4WP form with town-of-residence field
- `NEWSLETTER_ARCHIVE_ARCHITECTURE.md` — How the on-site newsletter archive is structured
- `NEWSLETTER_SHORTCODES_COMPLETE.md` — Shortcode reference for newsletter display
- `Mailchimp_WooCommerce_Integration.md` — Syncing customer data between WooCommerce and Mailchimp

## What's missing / to be added

- MailerLite migration documentation (when we make the switch)
- SendLayer configuration reference
- Deliverability monitoring setup
- Email template source files

See `docs/00_INDEX.md` for related topics in other sections.
