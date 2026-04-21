# Update Local WordPress from Live Backup

*Created December 2025*

## Purpose
Sync the local development copy of lexingtonalarm.org with the latest live site backup. This allows Claude to read current PHP snippets, templates, and pages.

## Prerequisites
- Local by Flywheel installed and running
- `la-wordpress-local` site started in Local
- Dropbox syncing UpdraftPlus backups to: `/Users/jtsackton/Library/CloudStorage/Dropbox/apps/UpdraftPlus.Com`
- WP-CLI installed (`wp --version` to verify)
- PHP installed via Homebrew

## Quick Command
```
update-wordpress
```
Run from anywhere in Terminal.

## What the Script Does Automatically
1. Finds latest backup date in Dropbox folder
2. Extracts and restores:
   - Plugins → wp-content/plugins
   - Themes → wp-content/themes
   - Uploads → wp-content/uploads
   - Other files → wp-content
3. Moves older backup files to Trash
4. Prompts you for manual database step

## Manual Steps (After Script Runs)

### Step 1: Import Database
1. Open `http://la-wordpress-local.local/wp-admin`
2. Go to **Settings → UpdraftPlus Backups**
3. Click **Upload backup files**
4. Upload ONLY the database file (`.gz` file)
5. Click **Restore** → select **Database only** → **Restore**

### Step 2: Fix URLs
1. Go to **Tools → Better Search Replace**
2. Search for: `https://lexingtonalarm.org`
3. Replace with: `http://la-wordpress-local.local`
4. Select all tables
5. Uncheck "Run as dry run"
6. Click **Search/Replace**

### Step 3: Verify
1. Visit `http://la-wordpress-local.local`
2. Confirm site loads correctly
3. Check Code Snippets → All Snippets if needed

## File Locations

| Item | Path |
|------|------|
| Script | `/Users/jtsackton/Desktop/LexingtonAlarm_Docs/wpforms_export_script/update-local-wordpress.sh` |
| Local site | `/Users/jtsackton/Local Sites/la-wordpress-local/app/public/` |
| Dropbox backups | `/Users/jtsackton/Library/CloudStorage/Dropbox/apps/UpdraftPlus.Com` |
| Themes | `/Users/jtsackton/Local Sites/la-wordpress-local/app/public/wp-content/themes/` |
| Plugins | `/Users/jtsackton/Local Sites/la-wordpress-local/app/public/wp-content/plugins/` |

## Schedule
Weekly on Monday - recurring task in Obsidian:
```
- [ ] Update local copy of Lexington Alarm website [[local scripts]] 🔁 every week on Monday 📅 2025-01-06
```

## Troubleshooting

**"MySQL socket not found"**
- Make sure Local is running AND the site is started (green indicator)

**"Database file too small"**
- Dropbox may still be syncing - wait a minute and retry

**"No backup files found"**
- Check Dropbox is syncing the UpdraftPlus folder
- Verify folder is set to "Available offline"

## Related
- [[Daily Notes and Calendar Setup]] - Obsidian workflow
- [[local scripts]] - Other automation scripts
- Full docs: `/Users/jtsackton/Desktop/LexingtonAlarm_Docs/`