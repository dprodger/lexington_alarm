# PRE-MIGRATION ACTION ITEMS - QUICK REFERENCE
**DO THESE BEFORE CHANGING DNS**

---

## ⏰ URGENT - DO TODAY

### 1. Export Missing Page HTML (15 minutes)
**Why:** Documentation for Claude collaboration  
**How:** Use bookmarklet or code editor

Missing pages:
- [ ] Home
- [ ] About  
- [ ] Events
- [ ] Shop
- [ ] Get Involved

**Save to:** `current_state/pages/[pagename].html`

---

### 2. Create Fresh Database Export (5 minutes)
**Why:** October 7 database may be outdated  
**How:**
1. Open Local app → Database tab
2. Click "Open Adminer"
3. Select these tables:
   - vcS_posts
   - vcS_postmeta
   - vcS_options (contains custom CSS!)
   - vcS_woocommerce_* (if any)
4. Export → SQL → Save

**Save to:** `wordpress_site/database/lexington-alarm-[today-date].sql`

---

### 3. Export Latest WPCode Snippets (2 minutes)
**Why:** Ensure you have newest custom code  
**How:**
1. WordPress Admin → Code Snippets → Tools → Export
2. Download JSON file

**Save to:** `exported_snippets/wpcode-export-2025-10-14.json`

**Current version:** October 13 (probably OK, but verify)

---

### 4. Fix Font Paths in CSS (10 minutes)
**Why:** Will break on production if not fixed  
**How:**
1. WordPress Admin → Appearance → Customize → Additional CSS
2. Find all instances of `/website_97a098b6/wp-content/themes/kadence/fonts/`
3. Replace with `/wp-content/themes/kadence/fonts/`
4. Publish changes
5. Copy updated CSS to: `current_state/css/kadence_custom.css`

**Critical lines to fix:**
```css
src: url('/website_97a098b6/wp-content/themes/kadence/fonts/armalite_rifle.ttf');
src: url('/website_97a098b6/wp-content/themes/kadence/fonts/UglyQua.ttf');
src: url('/website_97a098b6/wp-content/themes/kadence/fonts/UglyQuaItalic.ttf');
```

---

## 📋 VERIFY BEFORE MIGRATION

### Files Present in Archive:
- [x] Database: `database/ozpxkamy_WPJYZ.sql` (7.3 MB)
- [x] WPCode Snippets: `exported_snippets/wpcode-snippets-export-2025-10-13.json`
- [x] Custom CSS: `current_state/css/kadence_custom.css` (600 lines)
- [x] Custom Fonts: `wp-content/themes/kadence/fonts/` (3 files)
- [x] Banner: `wp-content/uploads/2025/09/LexAlarmBanner8.svg`
- [x] Theme: `wp-content/themes/kadence/`
- [x] Plugins: `wp-content/plugins/` (12 plugins)

### Configuration:
- [x] wp-config.php present (update credentials for production)
- [x] Database prefix: vcS_
- [x] Current domain: bpx.ela.mybluehost.me/website_97a098b6
- [x] Target domain: lexingtonalarm.org

---

## 🔧 GODADDY DNS CHANGES

### What to Change:
**A Record ONLY:**
- Type: A
- Host: @ (or lexingtonalarm.org)
- Points to: [Your Bluehost IP address]
- TTL: 1 hour (for testing, increase to 24 hrs after confirmed working)

### What NOT to Change:
**MX Records** - Leave these exactly as they are!
- These point to Proton email
- Changing them will break email

### Optional:
**CNAME for www:**
- Type: CNAME
- Host: www
- Points to: lexingtonalarm.org
- (Creates www.lexingtonalarm.org alias)

---

## 🚀 MIGRATION DAY SEQUENCE

**Recommended Time:** During low-traffic hours (early morning)

1. **T-1 hour:** Verify all files ready (checklist above)
2. **T-0:** Change DNS A record at GoDaddy
3. **T+5 min:** Clear all caches (WordPress, Bluehost)
4. **T+1 hour:** Test site at new domain (may need DNS checker)
5. **T+24 hrs:** Verify DNS propagation worldwide
6. **T+48 hrs:** Monitor analytics, check for errors

---

## 🆘 QUICK REFERENCE - WHAT CLAUDE CAN SEE

### ✅ Claude CAN Read:
- `wordpress_site/` - Full archive
  - `database/` - Database exports
  - `wp-content/` - Themes, plugins, uploads
  - `current_state/` - Synced working files
  - `exported_snippets/` - WPCode exports
  - `notes_txt/` - Documentation
- `wordpress working files/` - Planning docs

### ❌ Claude CANNOT Read:
- `/Users/jtsackton/Local Sites/la-wordpress-local/` - Live local install
- (Use sync script to copy files to wordpress_site/)

### To Share Files with Claude:
```bash
# Run sync script
cd /Users/jtsackton/Documents/github_lexington_alarm
bash sync-wordpress-state.sh

# Then manually copy CSS, pages, snippets as needed
```

---

## 📞 CONTACTS & CREDENTIALS

**Keep Handy During Migration:**

- GoDaddy login (for DNS changes)
- Bluehost cPanel login
- WordPress admin credentials (production)
- Database credentials (production)
- Proton email settings (to verify not changed)
- Tockify account (calendar: lexingtonalarm)

---

## ⚠️ MOST COMMON MISTAKES

1. ❌ Changing MX records → Email breaks
2. ❌ Forgetting to fix font paths → Fonts don't load
3. ❌ Not exporting code snippets → Custom functions missing
4. ❌ Skipping database search-replace → Internal links broken
5. ❌ Not clearing caches → Old content shows
6. ❌ Forgetting to re-save permalinks → 404 errors
7. ❌ Not testing SSL → Mixed content warnings

---

**Print This Page and Check Off Items As You Complete Them**

Last Updated: October 14, 2025
