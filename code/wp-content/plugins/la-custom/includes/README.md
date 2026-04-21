# la-custom plugin modules

Each subdirectory corresponds to a functional area of the site.

- `woocommerce/` — store logic: email labels, shipping messages, cart validation, donation handling
- `news/` — front-end news submission, role gating, Cloudflare Turnstile integration
- `newsletter/` — Newsletter archive shortcode, Mailchimp RSS integration
- `campaigns/` — campaign-specific tooling (Massport PDF generator, Rhode Island letter, etc.)
- `performance/` — optimization hooks, asset deferral, cache priming

## Migration path

Each `*.php` file in these subdirectories replaces a WPCode snippet currently running in production. The port-in process:

1. Copy the snippet's PHP into a new file here.
2. Wrap top-level functions in `if ( ! function_exists() )` guards.
3. Test locally in the dev environment.
4. Review and merge via PR.
5. After production deploys the plugin change, deactivate the corresponding WPCode snippet.
6. Update `snippets/active/WPCode_Active_Snippets.md` to mark the snippet as migrated.
7. Move the `.md` reference from `snippets/active/` to `snippets/archived/`.

## Current status

The plugin scaffold is in place. No modules loaded yet. Migration will proceed one snippet at a time starting with the highest-leverage, lowest-risk candidates.

See `docs/06_Change_Log/` for migration progress.
