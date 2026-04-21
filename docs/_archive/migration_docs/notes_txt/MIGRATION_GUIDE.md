# WordPress Migration Guide - Lexington Alarm

## Current Setup
- **Staging URL:** https://bpx.ela.mybluehost.me/website_97a098b6/
- **Target Domain:** lexingtonalarm.org
- **Platform:** WordPress with Kadence Theme
- **Database:** ozpxkamy_WPJYZ (7.3 MB)

## Files You Have Downloaded

### ✅ Complete
1. **Database:** `database/ozpxkamy_WPJYZ.sql`
2. **WordPress Config:** `wp-config.php`
3. **Theme Files:** Complete Kadence theme with custom fonts
4. **Media Library:** All uploads including banner SVG
5. **Plugins:** All plugin files

### ❌ Still Needed
1. **Code Snippets Export** (critical - contains custom PHP code)
2. **Customizer Settings Export** (theme customizations)

## Step-by-Step Migration Process

### Phase 1: Complete the Archive
1. Login to WordPress admin
2. Export code snippets (Snippets → Manage → Export)
3. Export Customizer settings (if plugin available)
4. Save any header/footer scripts

### Phase 2: Prepare New Environment
1. Set up fresh WordPress installation
2. Create new database
3. Update wp-config.php with new database credentials

### Phase 3: Database Migration
1. Import SQL file to new database
2. Run search-replace:
   ```sql
   UPDATE wp_options SET option_value = REPLACE(option_value, 
   'bpx.ela.mybluehost.me/website_97a098b6', 'lexingtonalarm.org');
   
   UPDATE wp_posts SET post_content = REPLACE(post_content, 
   'bpx.ela.mybluehost.me/website_97a098b6', 'lexingtonalarm.org');
   
   UPDATE wp_posts SET guid = REPLACE(guid, 
   'bpx.ela.mybluehost.me/website_97a098b6', 'lexingtonalarm.org');
   ```

### Phase 4: File Migration
1. Upload wp-content folder
2. Verify file permissions (755 for folders, 644 for files)
3. Update font paths in CSS (remove `/website_97a098b6/`)

### Phase 5: Post-Migration
1. Login to WordPress admin
2. Go to Settings → Permalinks and re-save
3. Import code snippets
4. Test all functionality:
   - [ ] Homepage loads with banner
   - [ ] Events calendar works
   - [ ] Sign ordering form functions
   - [ ] All pages accessible
   - [ ] Mobile responsive design
   - [ ] Fonts display correctly

## Critical Path References to Update

### CSS Font Paths
Current: `/website_97a098b6/wp-content/themes/kadence/fonts/`
Update to: `/wp-content/themes/kadence/fonts/`

### Database Table Prefix
Your tables use prefix: `vcS_`

### Important Files/Paths
- Banner: `/wp-content/uploads/2025/09/LexAlarmBanner8.svg`
- Fonts: `/wp-content/themes/kadence/fonts/`
- Custom CSS: Stored in database (wp_options table)

## Testing Checklist
- [ ] All pages load correctly
- [ ] Tockify calendar displays events
- [ ] WooCommerce shop functions
- [ ] Forms submit properly
- [ ] Emails send correctly
- [ ] Custom fonts display
- [ ] Banner scales responsively
- [ ] Sign ordering works
- [ ] Member registration functions

## Troubleshooting Common Issues

### White Screen of Death
- Check PHP error logs
- Increase PHP memory limit
- Disable plugins one by one

### Missing Styles
- Clear cache
- Re-save permalinks
- Check theme is activated

### Broken Images
- Run database search-replace
- Check file permissions
- Verify .htaccess rules

### Font Issues
- Update paths in CSS
- Check file permissions
- Clear browser cache

## Contact/Resources
- Current hosting: Bluehost
- Theme: Kadence (free version)
- Calendar: Tockify (lexingtonalarm calendar)

---

**Remember:** Export code snippets before staging site expires!