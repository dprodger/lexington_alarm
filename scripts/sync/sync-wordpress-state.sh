#!/bin/bash

##############################################################################
# Lexington Alarm WordPress State Sync Script
# 
# This script copies the current state of your Local WordPress site
# to the github repository so Claude can access the latest changes.
#
# Usage: ./sync-wordpress-state.sh
##############################################################################

# Colors for output
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Source and destination paths
LOCAL_WP="/Users/jtsackton/Local Sites/la-wordpress-local/app/public"
DEST_DIR="/Users/jtsackton/Documents/github_lexington_alarm/wordpress_site/current_state"

echo -e "${BLUE}╔════════════════════════════════════════════════════════════════╗${NC}"
echo -e "${BLUE}║        Lexington Alarm WordPress State Sync                   ║${NC}"
echo -e "${BLUE}╚════════════════════════════════════════════════════════════════╝${NC}"
echo ""

# Check if source directory exists
if [ ! -d "$LOCAL_WP" ]; then
    echo -e "${RED}✗ Error: Local WordPress directory not found!${NC}"
    echo -e "${YELLOW}  Expected: $LOCAL_WP${NC}"
    exit 1
fi

echo -e "${GREEN}✓ Found Local WordPress installation${NC}"
echo ""

##############################################################################
# 1. SYNC WPCODE SNIPPETS
##############################################################################
echo -e "${BLUE}[1/6] Syncing WPCode Snippets...${NC}"

# WPCode stores snippets in database, but we'll copy any export files
if [ -d "$LOCAL_WP/wp-content/uploads/wpcode" ]; then
    cp -r "$LOCAL_WP/wp-content/uploads/wpcode/"*.json "$DEST_DIR/snippets/" 2>/dev/null && \
        echo -e "${GREEN}  ✓ Copied WPCode exports${NC}" || \
        echo -e "${YELLOW}  ⚠ No WPCode export files found (you may need to export manually)${NC}"
else
    echo -e "${YELLOW}  ⚠ No WPCode upload directory found${NC}"
    echo -e "${YELLOW}    Export snippets manually: WPCode → Tools → Export${NC}"
fi

##############################################################################
# 2. SYNC CUSTOM CSS
##############################################################################
echo -e "${BLUE}[2/6] Syncing Custom CSS...${NC}"

# Kadence theme customizer CSS (stored in database, needs manual export)
echo -e "${YELLOW}  ⚠ Custom CSS is stored in WordPress database${NC}"
echo -e "${YELLOW}    To sync: WordPress Admin → Appearance → Customize → Additional CSS${NC}"
echo -e "${YELLOW}    Copy the content and paste into: $DEST_DIR/css/kadence_custom.css${NC}"

# Check if there's already a custom CSS file we can timestamp
if [ -f "$DEST_DIR/css/kadence_custom.css" ]; then
    LAST_MOD=$(date -r "$DEST_DIR/css/kadence_custom.css" "+%Y-%m-%d %H:%M:%S")
    echo -e "${BLUE}  ℹ Current CSS file last modified: $LAST_MOD${NC}"
fi

##############################################################################
# 3. SYNC UPLOADS (Images, Media)
##############################################################################
echo -e "${BLUE}[3/6] Syncing Recent Uploads...${NC}"

# Copy recent uploads (last 30 days) - adjust timeframe as needed
UPLOADS_SRC="$LOCAL_WP/wp-content/uploads"
UPLOADS_DEST="$DEST_DIR/uploads"

if [ -d "$UPLOADS_SRC" ]; then
    mkdir -p "$UPLOADS_DEST"
    
    # Copy only recent images/SVGs to avoid huge transfers
    find "$UPLOADS_SRC" -type f \( -name "*.svg" -o -name "*.png" -o -name "*.jpg" -o -name "*.webp" \) -mtime -30 -exec cp {} "$UPLOADS_DEST/" \; 2>/dev/null
    
    COUNT=$(ls -1 "$UPLOADS_DEST" 2>/dev/null | wc -l)
    echo -e "${GREEN}  ✓ Synced $COUNT recent media files${NC}"
else
    echo -e "${YELLOW}  ⚠ No uploads directory found${NC}"
fi

##############################################################################
# 4. SYNC PAGE CONTENT (needs manual export from WordPress)
##############################################################################
echo -e "${BLUE}[4/6] Syncing Page Content...${NC}"

echo -e "${YELLOW}  ⚠ Page content must be exported manually from WordPress${NC}"
echo -e "${YELLOW}    For each page you've changed:${NC}"
echo -e "${YELLOW}    1. Edit page in WordPress${NC}"
echo -e "${YELLOW}    2. Switch to 'Code Editor' view (⋮ menu → Code editor)${NC}"
echo -e "${YELLOW}    3. Copy all HTML${NC}"
echo -e "${YELLOW}    4. Save to: $DEST_DIR/pages/[pagename].html${NC}"

##############################################################################
# 5. CREATE DATABASE SNAPSHOT INFO
##############################################################################
echo -e "${BLUE}[5/6] Creating Database Snapshot Info...${NC}"

# Create a snapshot timestamp file
TIMESTAMP=$(date "+%Y-%m-%d %H:%M:%S")
cat > "$DEST_DIR/database_exports/LAST_SYNC.txt" << EOF
Last Sync: $TIMESTAMP

This snapshot represents the WordPress state as of the above timestamp.

To export database tables:
1. Open Local → Database tab
2. Click "Open Adminer"
3. Select tables to export (wp_posts, wp_postmeta, wp_options)
4. Export as SQL
5. Save to this directory

Key tables for content:
- wp_posts (pages, posts, products)
- wp_postmeta (custom fields, product data)
- wp_options (site settings, including customizer CSS)
- wp_woocommerce_* (store data)
EOF

echo -e "${GREEN}  ✓ Created sync timestamp${NC}"

##############################################################################
# 6. GENERATE SYNC REPORT
##############################################################################
echo -e "${BLUE}[6/6] Generating Sync Report...${NC}"

cat > "$DEST_DIR/SYNC_REPORT.md" << EOF
# WordPress Sync Report
**Generated:** $(date "+%Y-%m-%d %H:%M:%S")
**Source:** $LOCAL_WP

---

## Automated Sync Status

### ✓ Completed Automatically
- WPCode snippet exports (if available)
- Recent media uploads (last 30 days)
- Timestamp record

### ⚠ Manual Sync Required

#### 1. Custom CSS
**Location:** WordPress Admin → Appearance → Customize → Additional CSS  
**Destination:** \`current_state/css/kadence_custom.css\`  
**Status:** Must be copied manually

#### 2. WPCode Snippets (if not auto-synced)
**Export from:** WordPress Admin → WPCode → Tools → Export  
**Destination:** \`current_state/snippets/wpcode-export-[date].json\`

#### 3. Page Content
For each modified page:
- **News:** \`current_state/pages/news.html\`
- **Home:** \`current_state/pages/home.html\`
- **About:** \`current_state/pages/about.html\`
- **Events:** \`current_state/pages/events.html\`
- **Shop:** \`current_state/pages/shop.html\`
- **Get Involved:** \`current_state/pages/get-involved.html\`

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

\`\`\`
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
\`\`\`

---

## Next Steps for Claude

After syncing, Claude can read the \`current_state/\` directory to see:
1. Latest code snippets
2. Current custom CSS
3. Page HTML structure
4. Recent media assets

This provides full context for suggestions and new development.
EOF

echo -e "${GREEN}  ✓ Generated sync report${NC}"

##############################################################################
# SUMMARY
##############################################################################
echo ""
echo -e "${BLUE}╔════════════════════════════════════════════════════════════════╗${NC}"
echo -e "${BLUE}║                    SYNC COMPLETE                               ║${NC}"
echo -e "${BLUE}╚════════════════════════════════════════════════════════════════╝${NC}"
echo ""
echo -e "${GREEN}Automated sync completed successfully!${NC}"
echo ""
echo -e "${YELLOW}📋 MANUAL STEPS REQUIRED:${NC}"
echo -e "   1. Copy Custom CSS from WordPress Customizer"
echo -e "   2. Export WPCode snippets (WPCode → Tools → Export)"
echo -e "   3. Copy modified page HTML content"
echo ""
echo -e "${BLUE}📄 Full sync report saved to:${NC}"
echo -e "   $DEST_DIR/SYNC_REPORT.md"
echo ""
echo -e "${GREEN}✓ Ready for Claude collaboration!${NC}"
echo ""
