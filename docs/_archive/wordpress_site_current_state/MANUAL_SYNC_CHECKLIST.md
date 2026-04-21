# Manual Sync Checklist Template

**Date:** _______________  
**Session:** _______________

Use this checklist after running `sync-wordpress-state.sh` to ensure you've captured all changes.

---

## Pre-Sync

- [ ] Saved all changes in WordPress Admin
- [ ] Noted which pages/features were modified
- [ ] Ready to run sync script

---

## Automated Sync

- [ ] Ran `./sync-wordpress-state.sh`
- [ ] Reviewed console output for errors
- [ ] Checked that SYNC_REPORT.md was created

---

## Manual Exports

### Custom CSS
- [ ] Opened WP Admin → Appearance → Customize → Additional CSS
- [ ] Copied all CSS code
- [ ] Pasted into `current_state/css/kadence_custom.css`
- [ ] Verified file saved correctly

### WPCode Snippets (if changed)
- [ ] Opened WP Admin → WPCode → Tools → Export
- [ ] Downloaded JSON file
- [ ] Renamed to `wpcode-export-YYYY-MM-DD.json`
- [ ] Saved to `current_state/snippets/`
- [ ] Verified snippets are in the export

### Page Content (check all that you modified)
- [ ] **News** → `current_state/pages/news.html`
- [ ] **Home** → `current_state/pages/home.html`
- [ ] **About** → `current_state/pages/about.html`
- [ ] **Events** → `current_state/pages/events.html`
- [ ] **Shop** → `current_state/pages/shop.html`
- [ ] **Get Involved** → `current_state/pages/get-involved.html`
- [ ] **Other:** ___________ → `current_state/pages/________.html`

**For each page:**
- [ ] Opened page editor
- [ ] Switched to Code Editor view (⋮ menu)
- [ ] Copied all HTML
- [ ] Saved to appropriate .html file

### Database Export (only for major changes)
- [ ] Opened Local → Database → Adminer
- [ ] Exported wp_posts table
- [ ] Exported wp_postmeta table
- [ ] Exported wp_options table (contains custom CSS)
- [ ] Saved to `current_state/database_exports/`
- [ ] Named files with date: `wp_posts_YYYY-MM-DD.sql`

---

## Verification

- [ ] Opened `current_state/SYNC_REPORT.md` to verify timestamp
- [ ] Spot-checked a few files to ensure content is current
- [ ] Checked file sizes are reasonable (not 0 bytes)

---

## Git Commit (Recommended)

- [ ] Staged changes: `git add wordpress_site/current_state/`
- [ ] Committed: `git commit -m "Sync WordPress state - [description]"`
- [ ] Pushed to remote (if using remote repo)

---

## Ready for Claude

- [ ] All manual exports completed
- [ ] Files verified
- [ ] Ready to start collaboration session

---

## Notes for Claude

**What I changed this session:**
- 
- 
- 

**What I need help with:**
- 
- 
- 

**Specific files to review:**
- 
- 
- 

---

## Session Summary

**Time spent on WordPress changes:** ___ minutes  
**Time spent on sync/export:** ___ minutes  
**Total files updated:** ___  
**Next steps:** 
