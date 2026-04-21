# Kadence Child Theme — lexingtonalarm.org

Child theme overriding the parent Kadence theme with Lexington Alarm customizations.

## Status

Initial scaffold. The `style.css` currently contains the accumulated Kadence Customizer CSS from the production site (imported from `Kadence_customize_CLEANED.css`) — this is a starting point, **not** a cleaned/organized final state.

## Roadmap

1. **Audit existing CSS** — identify what's actually referenced vs. dead rules.
2. **Organize by domain** — split into logical sections (or separate `@import`-loaded files): base, layout, store, campaigns, news, newsletter, mobile overrides.
3. **Migrate inline/Customizer CSS off WordPress** — everything should live here, version-controlled.
4. **Remove reliance on Kadence Customize panel** — the Customizer is fine for previews, but no production CSS should live there.

## Deployment

When pushing CSS changes:

1. Test locally in the dev environment (see `dev/DEV_SETUP.md`).
2. PR to `main`.
3. After merge, deploy by uploading `style.css` + `functions.php` to Bluehost at:
   `/public_html/wp-content/themes/kadence-child/`
4. Verify on production: hard-refresh, check responsive breakpoints.

## Caveats

- **Don't edit `style.css` by hand in WordPress Admin.** Any edit made there will be overwritten on next deploy.
- **Kadence mobile breakpoint is 1024px** (not the default 768px). Test tablet widths.
- Kadence updates can change theme hooks; review child theme after major Kadence version bumps.
