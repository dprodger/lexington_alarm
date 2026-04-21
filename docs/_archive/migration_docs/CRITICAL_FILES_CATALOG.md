# Lexington Alarm WordPress - Critical Files Catalog
**Generated:** October 14, 2025  
**For:** Pre-migration documentation and backup verification

---

## 🎯 MIGRATION READINESS STATUS

### ✅ **READY - Complete Archives**
- Database backup (7.3 MB)
- WPCode snippets export (October 13, 2025)
- Custom CSS (synced October 11, 2025)
- All theme files with custom fonts
- Media library complete

### ⚠️ **NEEDS ATTENTION - Missing Exports**
- [ ] Home page HTML export
- [ ] About page HTML export  
- [ ] Events page HTML export
- [ ] Shop page HTML export
- [ ] Get Involved page HTML export
- [ ] Recent database export (wp_options, wp_posts, wp_postmeta)

---

## 📁 DIRECTORY STRUCTURE & ACCESS

### Claude Can Read These Folders:
```
/Users/jtsackton/Documents/github_lexington_alarm/
├── wordpress_site/                    ← MAIN ARCHIVE
│   ├── database/                      ← Database backups
│   ├── wp-content/                    ← WordPress content
│   │   ├── themes/kadence/            ← Active theme with fonts
│   │   ├── plugins/                   ← All plugins
│   │   └── uploads/                   ← Media library
│   ├── current_state/                 ← SYNCED WORKING FILES
│   │   ├── pages/                     ← HTML exports
│   │   ├── snippets/                  ← WPCode exports
│   │   ├── css/                       ← Custom CSS
│   │   └── uploads/                   ← Recent media
│   ├── exported_snippets/             ← WPCode JSON exports
│   └── notes_txt/                     ← Documentation
└── wordpress working files/           ← Planning docs & templates
```

### Claude CANNOT Read (Outside Allowed Directory):
- `/Users/jtsackton/Local Sites/la-wordpress-local/` ← Live local WordPress install
- (This is by design - use sync script to copy files to wordpress_site/)

---

## 🔥 CRITICAL FILES FOR MIGRATION

### 1. DATABASE (HIGHEST PRIORITY)
**Location:** `wordpress_site/database/ozpxkamy_WPJYZ.sql`  
**Size:** 7.3 MB  
**Date:** October 7, 2025  
**Contains:**
- All page content
- Menu structures
- Plugin settings (WooCommerce, WPCode, etc.)
- User accounts
- Site options (including Custom CSS!)
- Tockify calendar configuration

**⚠️ ACTION NEEDED:**
- Create fresh export before migration (tables may have changed since Oct 7)
- Export these specific tables from Local → Adminer:
  - `vcS_posts` (all pages/posts)
  - `vcS_postmeta` (custom fields)
  - `vcS_options` (site settings, **includes custom CSS**)
  - `vcS_woocommerce_*` (if store is configured)

---

### 2. WPCODE SNIPPETS (CRITICAL)
**Latest Export:** `exported_snippets/wpcode-snippets-export-2025-10-13.json`  
**Also in:** `current_state/snippets/wpcode-snippets-export-2025-10-11.json`  

**Contains:**
- Newsletter archive shortcodes
- Frontend news posting system
- Custom PHP functionality
- Page export utilities

**Status:** ✅ Up to date (Oct 13, 2025)

**Migration Action:**
1. Import via WordPress Admin → Code Snippets → Import
2. Verify all snippets activate successfully
3. Test newsletter archive and news pages

---

### 3. CUSTOM CSS (CRITICAL)
**Location:** `current_state/css/kadence_custom.css`  
**Last Synced:** October 11, 2025  
**Size:** ~600 lines  

**Contains:**
- Custom font definitions
- Brand color variables
- Mobile responsive rules
- Component styles (.la-button, .la-text-box, etc.)
- Tockify calendar overrides

**⚠️ FONT PATH ISSUE:**
Current paths include `/website_97a098b6/` which must be removed before migration.

**Migration Action:**
1. Before DNS change: Update all font URLs in CSS
2. Change: `/website_97a098b6/wp-content/themes/kadence/fonts/`
3. To: `/wp-content/themes/kadence/fonts/`
4. Apply via: WordPress Admin → Appearance → Customize → Additional CSS

---

### 4. CUSTOM FONTS (CRITICAL)
**Location:** `wp-content/themes/kadence/fonts/`

**Files:**
- `armalite_rifle.ttf` (H1-H3 headers)
- `UglyQua.ttf` (H4-H6, navigation, buttons)
- `UglyQuaItalic.ttf` (italic variant)

**Status:** ✅ Present in archive

**Migration Action:**
- Upload to production: `/wp-content/themes/kadence/fonts/`
- Verify file permissions: 644
- Test font loading on all pages

---

### 5. BRAND BANNER (CRITICAL)
**Location:** `wp-content/uploads/2025/09/LexAlarmBanner8.svg`  
**Type:** SVG (scalable, responsive)  
**Colors:** Blue (#044f9d), Red (#c3202e), White (#ffffff)  

**Status:** ✅ Present in archive

**Used in:**
- Site header (mobile + desktop)
- Responsive at multiple breakpoints

**Migration Action:**
- Verify uploads to: `/wp-content/uploads/2025/09/`
- Check image paths in header settings

---

### 6. PAGE HTML EXPORTS (DOCUMENTATION)
**Location:** `current_state/pages/`

**Currently Exported:**
- ✅ News page (multiple versions)

**Missing Exports:**
- ❌ Home page
- ❌ About page
- ❌ Events page  
- ❌ Shop page
- ❌ Get Involved page

**Purpose:** Reference documentation for Claude collaboration

**⚠️ ACTION NEEDED:**
Use the bookmarklet or code editor to export remaining pages before migration.

---

### 7. WORDPRESS CONFIGURATION
**Location:** `wordpress_site/wp-config.php`  
**Contains:**
- Database credentials
- Security keys
- Table prefix: `vcS_`
- Debug settings

**⚠️ SECURITY:**
- Contains sensitive database passwords
- Do NOT commit to public repositories
- Update credentials for production database

**Migration Action:**
1. Copy wp-config.php to production
2. Update database name, user, password
3. Change `DB_HOST` if needed
4. Generate new security keys: https://api.wordpress.org/secret-key/1.1/salt/

---

### 8. PLUGINS (IMPORTANT)
**Location:** `wp-content/plugins/`

**Critical Plugins:**
- ✅ `code-snippets` (v3.7.0) - manages all custom PHP
- ✅ `wpcode-premium` - code management (empty dir - may not be active)
- ✅ `wpforms` - contact/order forms
- ✅ `mailchimp-for-wp` - newsletter signups
- ✅ `woocommerce` - store functionality
- ✅ `wp-mail-smtp` - email delivery
- ✅ `svg-support` - allows SVG uploads (needed for banner!)

**Also Present:**
- customizer-export-import
- header-footer-code-manager
- insert-headers-and-footers
- wordpress-importer
- woo-stripe-payment
- bluehost-wordpress-plugin

**Migration Action:**
1. Upload entire `/wp-content/plugins/` directory
2. Reactivate plugins via WordPress Admin
3. Test critical functions: forms, email, newsletter, shop

---

## 📋 DOCUMENTATION FILES (IMPORTANT)

### Primary Documentation (wordpress_site/notes_txt/)
1. **MIGRATION_GUIDE.md** - Complete migration walkthrough
2. **PLUGINS_INVENTORY.md** - All installed plugins
3. **LOCAL_SERVER_SETUP.md** - Local development setup
4. **NEWS_TEAM_SETUP.md** - Frontend posting system
5. **ICLOUD_FIX_GUIDE.md** - File sync issues

### Current State Documentation (current_state/)
1. **README.md** - How to sync files with Claude
2. **SYNC_REPORT.md** - Last sync timestamp
3. **NEWSLETTER_SHORTCODES_COMPLETE.md** - Mailchimp integration
4. **BLOG_SEARCH_IMPLEMENTATION.md** - Search functionality
5. **MAILCHIMP_RSS_SETUP.md** - RSS feed configuration

### Planning Documents (wordpress working files/)
1. **Website_Stage_1- Lexington Alarm WordPress Development.md** ← Original specs
2. **MIGRATION_MASTER_TRACKER.md** - Migration progress
3. **Events_Page_documentation.txt** - Tockify setup
4. **WooCommerce_Store_Setup.md** - Store configuration
5. **About_Page_COMPLETE.md** - About page structure

---

## 🔧 PRE-MIGRATION CHECKLIST

### Required Actions BEFORE DNS Change:

#### Database Preparation:
- [ ] Export fresh database from Local → Adminer
- [ ] Save to: `wordpress_site/database/[today's-date].sql`
- [ ] Verify size is >7 MB (should include all content)

#### File Preparation:
- [ ] Update CSS font paths (remove /website_97a098b6/)
- [ ] Export missing page HTML files for documentation
- [ ] Verify all 3 custom fonts are in kadence/fonts/
- [ ] Check banner SVG is in uploads/2025/09/

#### Code Snippets:
- [ ] Export latest WPCode snippets
- [ ] Save to: `exported_snippets/wpcode-export-[today's-date].json`
- [ ] Verify newsletter archive shortcodes are included

#### WordPress Settings:
- [ ] Note current permalinks structure
- [ ] Document any custom .htaccess rules
- [ ] List all active plugins
- [ ] Export theme customizer settings (if plugin available)

---

## 🚀 MIGRATION DAY CHECKLIST

### Step 1: Upload Files
- [ ] Upload entire /wp-content/ directory to production
- [ ] Upload wp-config.php (with updated credentials)
- [ ] Verify file permissions (755 folders, 644 files)

### Step 2: Database Migration
- [ ] Import database to production
- [ ] Run search-replace SQL (see MIGRATION_GUIDE.md)
- [ ] Update wp_options URLs

### Step 3: WordPress Configuration
- [ ] Login to WordPress admin
- [ ] Go to Settings → General, update URLs
- [ ] Go to Settings → Permalinks, re-save
- [ ] Verify custom CSS is present (Appearance → Customize)

### Step 4: Code & Plugins
- [ ] Import WPCode snippets (Code Snippets → Import)
- [ ] Activate all plugins
- [ ] Test forms (WPForms)
- [ ] Test newsletter signup (Mailchimp)
- [ ] Verify WooCommerce store

### Step 5: Testing
- [ ] Load all pages (Home, About, Events, News, Shop, Join)
- [ ] Test Tockify calendar
- [ ] Verify fonts display correctly
- [ ] Check banner responsiveness (mobile/tablet/desktop)
- [ ] Test internal navigation
- [ ] Submit test form
- [ ] Check email delivery

### Step 6: DNS & SSL
- [ ] Change GoDaddy A record
- [ ] Verify MX records unchanged (Proton email)
- [ ] Enable SSL certificate in Bluehost
- [ ] Force HTTPS in WordPress
- [ ] Clear all caches

### Step 7: Post-Migration
- [ ] Monitor for 24-48 hours
- [ ] Check Plausible analytics
- [ ] Verify no 404 errors
- [ ] Set up automated backups
- [ ] Create 301 redirects (new.lexingtonalarm.org → lexingtonalarm.org)

---

## 📊 FILE SIZE REFERENCE

**Total Archive Size:** ~8-10 MB (estimated)

**Breakdown:**
- Database: 7.3 MB
- Kadence Theme: ~500 KB
- Custom Fonts: ~200 KB
- Uploads (media): ~1-2 MB
- Plugins: ~5-8 MB (depends on versions)

---

## ⚠️ CRITICAL REMINDERS

1. **Do NOT change MX records** - Only A records for web traffic
2. **Font paths must be fixed** - Remove /website_97a098b6/ from CSS
3. **Export code snippets** - Not stored in files, only database
4. **Custom CSS is in database** - wp_options table, not a file
5. **Database prefix is vcS_** - Not the standard wp_
6. **SSL must be enabled** - Force HTTPS after migration
7. **Clear ALL caches** - WordPress, Kadence, Bluehost
8. **DNS propagation takes 24-48 hrs** - Plan accordingly

---

## 🆘 IF SOMETHING GOES WRONG

### Rollback Plan:
1. Keep staging site active during DNS propagation
2. Can point DNS back to staging if critical issues
3. Have database backup ready to restore
4. Keep local site functional as reference

### Common Issues & Fixes:
- **White screen:** Check PHP error logs, increase memory limit
- **Missing styles:** Clear cache, re-save permalinks, check CSS
- **Broken images:** Run database search-replace, check file permissions
- **Font issues:** Update paths, clear browser cache, check MIME types
- **404 errors:** Re-save permalinks in Settings

---

## 📞 KEY RESOURCES

**Hosting:** Bluehost  
**Theme:** Kadence (free version)  
**Database Prefix:** vcS_  
**Calendar:** Tockify (lexingtonalarm)  
**Email:** Proton (via GoDaddy MX records)  
**Analytics:** Plausible  

**Documentation Locations:**
- Full specs: `wordpress working files/Website_Stage_1...md`
- Migration guide: `notes_txt/MIGRATION_GUIDE.md`
- Events setup: `wordpress working files/Events_Page_documentation.txt`

---

**Catalog Status:** COMPLETE ✅  
**Last Verified:** October 14, 2025  
**Next Action:** Export missing page HTML files and create fresh database backup

---

*This catalog provides Claude with complete visibility into your WordPress archive for migration planning and troubleshooting.*
