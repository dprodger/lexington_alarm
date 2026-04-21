# WordPress Sync Report
**Generated:** 2025-10-11 11:49:45
**Source:** /Users/jtsackton/Local Sites/la-wordpress-local/app/public

---

## Automated Sync Status

### ✓ Completed Automatically
- WPCode snippet exports (if available)
- Recent media uploads (last 30 days)
- Timestamp record

### ⚠ Manual Sync Required

#### 1. Custom CSS
**Location:** WordPress Admin → Appearance → Customize → Additional CSS  
**Destination:** `current_state/css/kadence_custom.css`  
**Status:** Must be copied manually

#### 2. WPCode Snippets (if not auto-synced)
**Export from:** WordPress Admin → WPCode → Tools → Export  
**Destination:** `current_state/snippets/wpcode-export-[date].json`

#### 3. Page Content
For each modified page:
- **News:** `current_state/pages/news.html`
- **Home:** `current_state/pages/home.html`
- **About:** `current_state/pages/about.html`
- **Events:** `current_state/pages/events.html`
- **Shop:** `current_state/pages/shop.html`
- **Get Involved:** `current_state/pages/get-involved.html`

**How to export:**
1. Edit page in WordPress
2. Switch to Code Editor (⋮ menu)
3. Copy all HTML
4. Save to appropriate file

#### 4. Database Exports (Optional, for major changes)
**Export from:** Local → Database → Open Adminer  
**Tables to export:**
- wp_posts
- wp_postmeta  
- wp_options (contains custom CSS!)

---

## Quick Checklist

After running this script, manually copy:
- [ ] Custom CSS from Customizer
- [ ] WPCode snippets (if not auto-exported)
- [ ] Modified page HTML content
- [ ] Database export (if major changes)

---

## File Structure

```
current_state/
├── css/
│   └── kadence_custom.css (manual)
├── pages/
│   ├── news.html (manual)
│   ├── home.html (manual)
│   └── [other pages] (manual)
├── snippets/
│   └── wpcode-export-YYYY-MM-DD.json (auto or manual)
├── uploads/
│   └── [recent media files] (auto)
├── database_exports/
│   ├── LAST_SYNC.txt (auto)
│   └── [sql exports] (manual)
└── SYNC_REPORT.md (auto - this file)
```

---

## Next Steps for Claude

After syncing, Claude can read the `current_state/` directory to see:
1. Latest code snippets
2. Current custom CSS
3. Page HTML structure
4. Recent media assets

This provides full context for suggestions and new development.
