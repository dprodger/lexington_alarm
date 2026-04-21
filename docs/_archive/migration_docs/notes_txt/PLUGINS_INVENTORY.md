# WordPress Site Plugins Inventory

## Plugins Found in wp-content/plugins Directory

Based on your WordPress archive, here are the plugins installed:

### Form & Communication Plugins
1. **WPForms** - Forms plugin for contact forms, order forms
2. **WP Mail SMTP** - Ensures email delivery
3. **Mailchimp for WP** - Newsletter signup integration

### Code Management Plugins
1. **Code Snippets** (v3.7.0) - Active, manages PHP snippets
2. **WPCode Premium** - Directory exists but empty
3. **Header Footer Code Manager** - For adding scripts to header/footer
4. **Insert Headers and Footers** - Alternative header/footer script manager

### E-Commerce & Payment
1. **WooCommerce** - Full e-commerce functionality
2. **Woo Stripe Payment** - Stripe payment gateway for WooCommerce

### Utility Plugins
1. **SVG Support** - Allows SVG file uploads (important for your banner!)
2. **Customizer Export Import** - For exporting theme customizations
3. **WordPress Importer** - For importing/exporting WordPress content
4. **Bluehost WordPress Plugin** - Hosting-specific utilities

## Critical Notes

### Code Snippets Need Export
- The actual PHP code snippets are in the DATABASE, not the plugin folders
- Must export through WordPress admin before site expires
- These contain your custom business logic

### Active Theme
- **Kadence Theme** with custom fonts
- Custom CSS in WordPress Customizer (stored in database)

### Media Files
- Banner SVG: `LexAlarmBanner8.svg` ✅ Present
- Custom fonts: All 3 fonts ✅ Present
- Yard sign designs and campaign materials ✅ Present

## Migration Priority

1. **HIGH**: Export code snippets from admin panel
2. **HIGH**: Document any custom WooCommerce settings
3. **MEDIUM**: Export WPForms entries if needed
4. **LOW**: Note any special plugin configurations

---

*This inventory based on directory structure in wp-content/plugins*