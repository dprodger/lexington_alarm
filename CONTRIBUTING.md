# Contributing to Lexington Alarm

This document describes how to make changes to the Lexington Alarm site and documentation.

## Who should read this

- Toby and any developer or designer with repo access
- News team contributors who want to understand how the site is maintained
- Anyone who's been given access to `lexingtonalarm.org` infrastructure

## Before you make any changes

1. **Clone the repo locally.** Don't edit directly on Bluehost.
2. **Read `docs/00_INDEX.md`** to orient on what the repo contains.
3. **Check `docs/06_Change_Log/`** for anything that's in motion — you may be stepping on active work.
4. **Run the local dev environment.** See `dev/DEV_SETUP.md`. Never test changes against production first.

## The workflow

All changes go through the same flow:

```
main branch (protected, stable)
    ↑
Pull Request (review + discussion)
    ↑
feature branch (your work)
    ↑
your local clone
```

Step by step:

1. Create a branch off `main`:
   ```bash
   git checkout main
   git pull
   git checkout -b fix/shopping-cart-validation
   ```
   Name your branch `fix/`, `feat/`, `docs/`, or `chore/` followed by a short slug.

2. Make your changes. Keep commits focused; one logical change per commit.

3. Test locally. If you're changing code, confirm the site works. If you're changing docs, read them in a markdown preview.

4. Push the branch and open a pull request on GitHub.
   ```bash
   git push -u origin fix/shopping-cart-validation
   ```

5. Someone with review permissions will look it over, ask questions, and approve or request changes.

6. Once approved and merged, the change is live in `main`. Deployment to production is a separate step — see `dev/DEV_SETUP.md`.

## What requires a PR

Everything except these exempt cases:

- **Exempt:** Personal schedule notes in `docs/_archive/obsidian_schedule_templates/`
- **Exempt:** Your own drafts that haven't been shared

Everything else — including documentation updates, brand asset additions, campaign copy, snippet references — goes through PR. This is not because the changes are risky; it's because multi-person visibility is the whole point.

## What NEVER gets committed

See `.gitignore` for the full list. The most important:

- **`wp-config.php`** — contains database credentials
- **`.env` files** — contain API keys, tokens
- **`.sql` or `.sqlite` files** — database dumps contain user data, orders, PII
- **`la_wordpress_local`** symlink — can balloon the repo
- **Source PSDs and uncompressed images** — go in Proton Drive, not git

If you accidentally commit sensitive data, stop, do not push, and tell @tobysackton immediately. The fix requires rewriting git history, which is easier before a push than after.

## Working with WPCode snippets

Today, most site logic lives in WPCode snippets stored in the WordPress database — not as files. The plan is to migrate them into the `code/wp-content/plugins/la-custom/` custom plugin over time.

For now:

- **Don't edit snippets directly in WordPress Admin without capturing the change in the repo.** Export the snippet as JSON (WPCode → Tools → Export) after changes and add the file to `snippets/wpcode-exports/`.
- **When you port a snippet into `la-custom/`, update `snippets/active/WPCode_Active_Snippets.md`** to mark it as migrated.
- **Never delete a snippet from WPCode until its replacement is confirmed working in production.** Keep the old version in `snippets/archived/` as a rollback path.

## Working with the child theme

`code/wp-content/themes/kadence-child/` holds your CSS overrides and any template customizations. When editing:

- **Keep CSS organized by domain** (store, campaigns, news, etc.) — don't dump everything in `style.css`.
- **Never override core Kadence CSS without a comment explaining why.** Kadence updates may break silent overrides.
- **Test responsive breakpoints.** Kadence's mobile header is configured at 1024px — mobile testing matters.

## Commit message conventions

Short, imperative, prefixed by type:

- `fix:` for bug fixes
- `feat:` for new functionality
- `docs:` for documentation changes
- `chore:` for housekeeping, deps, refactors
- `wip:` for in-progress work (rebase/squash before merge)

Example:
```
fix: correct Massport PDF template for new Governor address
```

## Getting help

- **Urgent production issue:** Text Toby directly.
- **Design / architecture questions:** Open a GitHub Discussion (or ask in the team chat).
- **Unclear about scope:** Ask in the PR itself — reviewers prefer a question over wrong code.

## Code of conduct

Be direct, be kind, assume good faith. The organization's external mission is civic engagement; that same spirit applies internally.
