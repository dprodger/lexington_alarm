# WordPress Code Snippets - Export Required

## ⚠️ ACTION NEEDED: Export PHP Code Snippets

Your WordPress site has **multiple code snippet plugins** installed, but the actual PHP code snippets are stored in the **database**, not in the file system. These need to be exported separately.

## Installed Snippet Management Plugins

1. **Code Snippets** (v3.7.0) - Active with files present
2. **WPCode Premium** - Directory exists but empty
3. **Header Footer Code Manager** - Installed
4. **Insert Headers and Footers** - Installed

## How to Export Your Code Snippets

### Method 1: From WordPress Admin (Recommended)

1. Login to WordPress Admin at: `https://bpx.ela.mybluehost.me/website_97a098b6/wp-admin`

2. **For Code Snippets Plugin:**
   - Go to **Snippets** → **Manage**
   - Click **Select All** checkbox
   - From "Bulk Actions" dropdown, choose **Export**
   - Select format: **Download as JSON** (recommended) or PHP
   - Save file as `code-snippets-export.json`

3. **For WPCode (if active):**
   - Go to **Code Snippets** → **Tools**
   - Click **Export** tab
   - Select all snippets
   - Export as JSON

4. **For Header/Footer Scripts:**
   - Go to **Settings** → **Insert Headers and Footers**
   - Copy any scripts shown there to a text file

### Method 2: Direct Database Export

The snippets are likely stored in these database tables:
- `vcS_snippets` (Code Snippets plugin)
- `vcS_wpcode_snippets` (WPCode)
- Options table entries for header/footer scripts

### What These Snippets Likely Contain

Based on your site's functionality, the PHP snippets probably include:

1. **Sign Ordering System**
   - Order form processing
   - PayPal integration
   - Order confirmation emails

2. **Member Management**
   - User registration customizations
   - Member-only content access
   - Role management

3. **Event Management**
   - Tockify calendar integration
   - Event registration forms

4. **Custom Functionality**
   - Custom shortcodes
   - Form processors
   - Email notifications
   - Security modifications

## Critical Snippets to Look For

When you export, look for snippets related to:
- WooCommerce customizations
- WPForms processors
- Payment gateways
- Email handlers
- Custom post types
- Security functions

## Storage Recommendation

Once exported, save the files as:
```
wordpress_site/
├── exported_snippets/
│   ├── code-snippets-export.json
│   ├── wpcode-export.json
│   ├── header-scripts.txt
│   └── footer-scripts.txt
```

## Next Steps

1. **Export immediately** - These snippets are critical for site functionality
2. **Document each snippet** - Note what each one does
3. **Test in staging** - Verify all snippets work when imported
4. **Version control** - Add exported files to your archive

## Note on Database Search

The database file (7.3 MB) contains all WordPress data including:
- Pages and posts
- Plugin settings
- User data
- **Code snippets** (embedded in the database)

Without the exported snippets, you would need to manually extract them from the SQL file, which is complex and error-prone.

---

**Priority: HIGH** - Export these snippets before migration to preserve all custom functionality!