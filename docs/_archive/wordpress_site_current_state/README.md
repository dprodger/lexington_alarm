# Current State Directory

This directory contains the **current snapshot** of your Local WordPress site for Claude collaboration.

## Purpose

When you make changes in WordPress Admin, run the sync script to update this directory. Claude can then read these files to understand your latest changes and provide accurate suggestions.

---

## Directory Structure

```
current_state/
├── css/                    # Custom CSS from WordPress Customizer
│   └── kadence_custom.css
├── pages/                  # Page HTML content
│   ├── news.html
│   ├── home.html
│   ├── about.html
│   ├── events.html
│   ├── shop.html
│   └── get-involved.html
├── snippets/               # WPCode PHP snippets
│   └── wpcode-export-YYYY-MM-DD.json
├── uploads/                # Recent media files
│   └── [images, SVGs]
├── database_exports/       # Database snapshots (optional)
│   ├── LAST_SYNC.txt
│   └── [SQL files]
└── SYNC_REPORT.md         # Generated after each sync
```

---

## How to Sync

### 1. Run the Sync Script

```bash
cd /Users/jtsackton/Documents/github_lexington_alarm
bash sync-wordpress-state.sh
```

This will:
- ✓ Copy recent media uploads automatically
- ✓ Create a timestamp
- ✓ Generate a sync report
- ⚠ Remind you what to copy manually

### 2. Complete Manual Steps

#### A. Copy Custom CSS
1. Go to WordPress Admin → Appearance → Customize → Additional CSS
2. Copy all the CSS code
3. Paste into: `current_state/css/kadence_custom.css`

#### B. Export WPCode Snippets
1. Go to WordPress Admin → WPCode → Tools → Export
2. Download the JSON file
3. Save to: `current_state/snippets/wpcode-export-[today's date].json`

#### C. Export Page Content (for modified pages only)

**FASTEST METHOD - Use the Bookmarklet (5 seconds per page):**
See `BOOKMARKLET_SETUP.txt` for one-time setup instructions
1. Edit page in WordPress
2. Click your "Export WP Page" bookmark
3. File downloads automatically (e.g., `news.html`)
4. Move to `current_state/pages/`

**MANUAL METHOD - Code Editor (30 seconds per page):**
1. Edit the page in WordPress
2. Click the ⋮ menu (three dots) → Code editor
3. Press Ctrl/Cmd+A (Select All), then Ctrl/Cmd+C (Copy)
4. Paste into: `current_state/pages/[pagename].html`

**FULL GUIDE:** See `EXPORT_PAGE_METHODS.md` for detailed instructions on all export methods

---

## Quick Workflow

**When you finish working on a feature:**

```bash
# 1. Run sync script
bash sync-wordpress-state.sh

# 2. Manually copy CSS, snippets, and page HTML (see above)

# 3. Tell Claude:
"I've updated the current_state directory. Can you read the latest [news page / CSS / snippets] and suggest improvements?"
```

---

## What Claude Can See

After syncing, Claude can read:
- Your custom CSS styles
- All WPCode PHP snippets
- Page HTML structure and content
- Recent images/media
- Database table exports (if you create them)

Claude **cannot** see:
- Live WordPress database content
- Real-time changes (only what's been synced)
- WordPress admin interface

---

## Tips

### For Small Changes
Just copy the specific file Claude needs:
- CSS tweaks → update `css/kadence_custom.css`
- New snippet → export to `snippets/`
- Page content → update relevant `pages/*.html`

### For Major Changes
Run the full sync + export database tables:
1. Run `sync-wordpress-state.sh`
2. Complete all manual steps
3. Export key database tables from Local → Adminer
4. Save SQL to `database_exports/`

### Before Starting Collaboration
Always sync first so Claude has your latest changes!

### Export Multiple Pages Quickly
Using the bookmarklet, you can export all 6 pages in under a minute:
1. Open each page in a new browser tab
2. Click through tabs, hitting the bookmarklet in each
3. All files download automatically
4. Move all files to `current_state/pages/` at once

---

## Last Sync

Check `SYNC_REPORT.md` to see when this directory was last updated.
