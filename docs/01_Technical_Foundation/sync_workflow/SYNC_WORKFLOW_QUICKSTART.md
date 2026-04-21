# SYNC WORKFLOW QUICK START

## Setup (One Time Only)

1. **Make the sync script executable:**
   ```bash
   cd /Users/jtsackton/Documents/github_lexington_alarm
   chmod +x sync-wordpress-state.sh
   ```

2. **Test the script:**
   ```bash
   ./sync-wordpress-state.sh
   ```

---

## Daily Workflow

### After making changes in WordPress Admin:

#### Step 1: Run Sync Script
```bash
cd /Users/jtsackton/Documents/github_lexington_alarm
./sync-wordpress-state.sh
```

#### Step 2: Manual Exports (3-5 minutes)

**A. Custom CSS** (if you changed it)
- WP Admin → Appearance → Customize → Additional CSS
- Copy all → Paste into `wordpress_site/current_state/css/kadence_custom.css`

**B. WPCode Snippets** (if you added/changed snippets)
- WP Admin → WPCode → Tools → Export
- Save JSON to `wordpress_site/current_state/snippets/wpcode-export-[date].json`

**C. Page Content** (for any page you modified)
- Edit page in WordPress
- ⋮ menu → Code editor
- Copy HTML → Save to `wordpress_site/current_state/pages/[pagename].html`

#### Step 3: Start Claude Collaboration
Tell Claude:
> "I've synced the current_state directory. Please read the latest [news page/CSS/snippets] and help me with [your task]."

---

## Common Scenarios

### "I just changed the News page HTML"
```bash
./sync-wordpress-state.sh
# Then copy News page HTML to current_state/pages/news.html
```

### "I added a new WPCode snippet"
```bash
./sync-wordpress-state.sh
# Export snippets from WPCode → Tools → Export
# Save to current_state/snippets/
```

### "I tweaked some CSS"
```bash
./sync-wordpress-state.sh
# Copy CSS from Customizer to current_state/css/kadence_custom.css
```

### "I made lots of changes everywhere"
```bash
./sync-wordpress-state.sh
# Then do all manual exports (CSS, snippets, all changed pages)
```

---

## Troubleshooting

### "Script says permission denied"
```bash
chmod +x sync-wordpress-state.sh
```

### "Local WordPress path not found"
Edit `sync-wordpress-state.sh` and verify this path:
```bash
LOCAL_WP="/Users/jtsackton/Local Sites/la-wordpress-local/app/public"
```

### "I don't know which pages I changed"
In WordPress Admin → Pages, sort by "Last Modified" to see recent changes.

---

## Pro Tips

1. **Sync before asking Claude for help** - ensures Claude sees your latest work
2. **Create page snapshots before major changes** - copy to timestamped files
3. **Commit to Git after syncing** - creates a history of your WordPress state
4. **Don't sync huge media files** - the script only copies recent uploads (last 30 days)

---

## What Gets Synced Automatically vs Manually

### ✓ Automatic (script does it)
- Recent media uploads (last 30 days)
- Timestamp tracking
- Sync report generation

### ⚠ Manual (you do it)
- Custom CSS (from Customizer)
- WPCode snippets (from export)
- Page HTML (from code editor)
- Database exports (optional, for big changes)

**Why manual?** These are stored in WordPress database, not as files on disk.

---

## Quick Reference

**Sync script location:**  
`/Users/jtsackton/Documents/github_lexington_alarm/sync-wordpress-state.sh`

**Current state directory:**  
`/Users/jtsackton/Documents/github_lexington_alarm/wordpress_site/current_state/`

**Run sync:**  
`./sync-wordpress-state.sh`

**Check last sync:**  
Look at `wordpress_site/current_state/SYNC_REPORT.md`
