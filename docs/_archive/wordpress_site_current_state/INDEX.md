# Current State Index

## Quick Navigation

### 📄 Files to Review
- **[CSS](css/kadence_custom.css)** - Custom Kadence theme CSS
- **[News Page](pages/news.html)** - News page HTML content
- **[Snippets](snippets/)** - WPCode PHP snippets
- **[Uploads](uploads/)** - Recent media files

### 📋 Documentation
- **[README](README.md)** - How to use this directory
- **[Sync Checklist](MANUAL_SYNC_CHECKLIST.md)** - Step-by-step sync guide
- **[Sync Report](SYNC_REPORT.md)** - Last sync details (generated)

### 🗂 Directory Contents

```
current_state/
├── css/
│   └── kadence_custom.css          [Manual sync required]
├── pages/
│   ├── news.html                   [Manual sync required]
│   ├── home.html                   [Create as needed]
│   ├── about.html                  [Create as needed]
│   ├── events.html                 [Create as needed]
│   ├── shop.html                   [Create as needed]
│   └── get-involved.html           [Create as needed]
├── snippets/
│   └── wpcode-export-YYYY-MM-DD.json [Manual sync required]
├── uploads/
│   └── [recent media files]        [Auto-synced by script]
├── database_exports/
│   ├── LAST_SYNC.txt               [Auto-generated]
│   └── [sql files]                 [Manual export, optional]
├── README.md
├── MANUAL_SYNC_CHECKLIST.md
├── SYNC_REPORT.md                  [Auto-generated]
└── INDEX.md                        [This file]
```

---

## Status Indicators

### ✓ Auto-Synced by Script
- Recent media uploads
- Sync timestamp
- Sync report

### ⚠ Manual Sync Required
- Custom CSS
- WPCode snippets
- Page HTML content
- Database exports (optional)

---

## For Claude

When starting a collaboration session, Claude should:
1. Check `SYNC_REPORT.md` for last sync time
2. Read relevant files based on the task:
   - CSS changes → `css/kadence_custom.css`
   - News page work → `pages/news.html` + relevant snippets
   - New features → check snippets + page HTML
3. Verify files have recent content (not template placeholders)

---

## Quick Commands

**View last sync:**
```bash
cat wordpress_site/current_state/SYNC_REPORT.md
```

**Check CSS:**
```bash
cat wordpress_site/current_state/css/kadence_custom.css
```

**List snippets:**
```bash
ls wordpress_site/current_state/snippets/
```

**View news page:**
```bash
cat wordpress_site/current_state/pages/news.html
```

---

Last updated: [Will be updated by sync script]
