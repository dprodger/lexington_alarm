## Comparison: WPCode vs Code Snippets Plugins

Both are code snippet management plugins installed on your site, but you have different situations:

### **Code Snippets** (Active - Version 3.7.0)
- **Status:** Full plugin files present
- **Purpose:** Free, open-source snippet manager
- **Features:**
  - Add PHP/HTML/CSS/JS snippets without editing theme files
  - Snippets stored in database tables
  - Import/export functionality
  - Basic snippet management

### **WPCode Premium** (Directory exists but empty)
- **Status:** Directory present but no files
- **Purpose:** Premium version of WPCode (formerly WP Code)
- **Features (when active):**
  - Advanced snippet insertion options
  - Conditional logic for snippets
  - Conversion pixels & tracking
  - Header/footer scripts
  - Premium support

## Current Situation on Your Site

Looking at your database, I can see:
1. **Code Snippets plugin** is installed with files
2. **WPCode Premium** directory exists but is empty
3. **Header Footer Code Manager** also installed
4. **Insert Headers and Footers** also installed

## ⚠️ IMPORTANT: Export Your Code Snippets!

The PHP code snippets are stored in the **database**, not in files. To export them:

### From WordPress Admin:
1. Go to **Snippets** → **Manage** (if Code Snippets is active)
2. Select all snippets using checkbox
3. Choose **Export** from bulk actions
4. Download as JSON or PHP file

### Alternative: Database Extraction
The snippets can be extracted from your database SQL file, but this is complex. It's much better to export them properly through WordPress admin.

The snippets likely include critical functionality for:
- Sign ordering system
- Member management
- Custom forms processing
- Payment integration
- Email notifications

These snippets are **essential** to preserve as they contain your site's custom business logic!