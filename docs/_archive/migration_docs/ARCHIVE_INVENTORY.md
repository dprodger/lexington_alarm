# Lexington Alarm WordPress Site Archive
**Archive Date:** October 7, 2025  
**Original URL:** https://bpx.ela.mybluehost.me/website_97a098b6/  
**Future Domain:** lexingtonalarm.org  

## ✅ Archive Contents Verified

### 1. DATABASE (7.3 MB)
- **File:** `database/ozpxkamy_WPJYZ.sql`
- **Size:** 7,274,431 bytes
- **Contents:** Complete WordPress database including:
  - All pages (Home, Events, News, Shop, Join Us, About)
  - Posts and content
  - Menu configurations
  - Plugin settings
  - User accounts
  - Site settings
  - Tockify calendar integration settings

### 2. WORDPRESS CONFIGURATION
- **File:** `wp-config.php`
- **Status:** ✅ Present (contains database credentials and settings)

### 3. THEME FILES
#### Kadence Theme (Active)
- **Location:** `wp-content/themes/kadence/`
- **Custom Fonts:** ✅ All 3 brand fonts present
  - `fonts/armalite_rifle.ttf` - Headers (H1-H3)
  - `fonts/UglyQua.ttf` - Navigation/buttons (H4-H6)
  - `fonts/UglyQuaItalic.ttf` - Italic variant

#### Other Themes (Backup)
- twentytwentyfive
- twentytwentyfour
- twentytwentythree
- bluehost-blueprint

### 4. MEDIA ASSETS
#### Critical Brand Assets
- **Banner:** ✅ `wp-content/uploads/2025/09/LexAlarmBanner8.svg`
- **Logo variations:** Multiple sizes and formats present
- **Sign designs:** Yard sign variants (18x24)
- **Documents:** Select Board letters and PDFs

#### Image Library (September 2025)
- Multiple image variations in WebP format
- Responsive image sizes (100x100 to 2048px)
- Historical images and graphics
- "No King No Tyranny" campaign materials
- Law is King graphics

### 5. PLUGINS
- **Directory:** `wp-content/plugins/`
- Status: Directory present (specific plugins to be inventoried)

## 🔧 Migration Checklist

### Pre-Migration Tasks
- [ ] Update font paths in CSS (remove `/website_97a098b6/`)
- [ ] Database search-replace for URLs:
  - FROM: `bpx.ela.mybluehost.me/website_97a098b6`
  - TO: `lexingtonalarm.org`
- [ ] Update wp-config.php database credentials
- [ ] Update WordPress General Settings URLs

### Post-Migration Tasks
- [ ] Clear all caches
- [ ] Test all internal links
- [ ] Verify Tockify calendar integration
- [ ] Test responsive design breakpoints
- [ ] Verify font loading

## 📋 Known Configurations

### Brand Colors (from documentation)
- Primary Blue: `#044f9d`
- Primary Red: `#c3202e`
- White: `#ffffff`

### Typography Hierarchy
- H1-H3: ArmaliteRifle (red, uppercase)
- H4-H6: UglyQua (red)
- Body: Work Sans (black)
- Navigation/Buttons: UglyQua

### Responsive Breakpoints
- Desktop: Full width banner
- Tablet Portrait (768-1024px): 500px max banner
- Phone Portrait (<768px): 280px max banner
- Phone Landscape: 350px max banner

### CSS Classes Available
```css
.la-button              // Red button, white border
.la-button-secondary    // Blue button
.la-text-box           // Standard bordered box
.la-highlight-box      // Blue border, red accent
.la-two-column         // Flex two-column
.la-section            // Standard section padding
```

## 📝 Notes

1. **Custom CSS Location:** WordPress Customizer → Additional CSS (stored in database)
2. **Events System:** Tockify calendar integration configured
3. **Calendar Name:** lexingtonalarm
4. **Featured Events:** Use "featured" tag in Tockify

## ⚠️ Important Reminders

- This archive contains sensitive data (database with user accounts)
- Keep local only - do not commit to public repositories
- wp-config.php contains database passwords
- Database contains email addresses and user information

---

**Archive Status:** COMPLETE ✅  
**Ready for:** Local development / Migration to production