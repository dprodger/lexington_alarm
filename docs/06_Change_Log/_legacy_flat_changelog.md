# Lexington Alarm - Site Changelog

**Site:** lexingtonalarm.org  
**Platform:** WordPress with Kadence Theme

---

## October 2025

### October 29, 2025
- **Comments Disabled Globally**
  - Location: Settings → Discussion
  - Action: Unchecked "Allow people to submit comments on new posts"
  - Applied to: All existing posts via Bulk Edit (Comments set to "Do not allow")
  - Reason: Comments feature not needed for current site operations

- **Battle Green Flag Policy Form - Fixed After Migration**
  - Problem: Form entries not being collected after site migration from staging to live
  - Root Cause: Page was still referencing old staging form #408 instead of live form #19
  - Fix 1: Updated form shortcode from `[wpforms id="408"]` to `[wpforms id="19"]`
  - Fix 2: Updated confirmation redirect URL in form #19 settings from staging URL (`bpx.ela.mybluehost.me/website_97a098b6/`) to live URL (`lexingtonalarm.org`)
  - Result: Entries now collecting properly in WPForms form #19
  - Email Confirmations: Working correctly
    - Confirmation email to signer functioning
    - Confirmation email to info@lexingtonalarm.org functioning
  - Historical Data: Old signatures from pre-migration period stored in form #408 on staging site (exported to CSV for records)

### Events Page Updates
- **Homepage Featured Events Display**
  - Successfully highlighting max of 4 calendar events from Tockify
  - Events must be tagged with "feature-home" to display
  - Shows next four events matching that tag

### News Page Implementation
- **News Team Posting System**
  - News team posting implemented - allows team members to publish without WordPress admin access
- **Newsletter Archive System**
  - Newsletter archive system implemented
  - Adding newsletter to archive listing involves manually updating code snippet
  - Note: Process requires manual code updates for each new archive entry

### Store Page - Complete Overhaul
- **Shipping Classes Implementation**
  - Completely updated to incorporate three shipping classes
  - Includes Printful merchandise category integration
  - Code added to prevent checkout with mixed shipping classes
- **Email Notification System**
  - Email notifications for fulfillment properly labeled as:
    - [SHIPPING] for shipped orders
    - [LOCAL PICKUP] for pickup orders
    - [DONATION] for donations

### Known Issues
- **⚠️ UNRESOLVED: Tablet Menu Header Bug**
  - Problem: Top-level menu items for NEWS and ABOUT pages do not function on tablet screen sizes
  - Cause: Conflict between hover states and screen width detection
  - Status: Menu functions properly on desktop and mobile screen sizes only
  - Note: Refer to previous troubleshooting conversation for technical details
  - Impact: Tablet users cannot access News and About top-level pages (submenu items work)

- **⚠️ UNRESOLVED: Shop Page Three-Column Layout on Desktop**
  - Problem: Three shop category cards (Local Pickup, Nationwide Shipping, Merchandise) stack vertically on all screen sizes, even wide desktop screens
  - Desired Behavior: Cards should display in one horizontal row on screens wider than 1260px, then stack vertically on tablet/mobile
  - Attempted Solutions:
    - CSS Grid with `grid-template-columns: 1fr 1fr 1fr` - cards still stacked
    - CSS Grid with `repeat(3, minmax(0, 1fr))` - cards still stacked
    - Flexbox with `flex: 1 1 calc(33.333% - 20px)` - cards still stacked
    - Added `!important` flags to all styles - cards still stacked
    - Clickable image cards with simplified layout - cards still stacked
    - Media query breakpoint at 1260px - cards still stacked
  - Suspected Cause: Kadence theme CSS overrides or WordPress block wrapper forcing full-width layout
  - Current Status: Reverted to original working code (cards stack on all screens)
  - Current Code: Using `grid-template-columns: repeat(auto-fit, minmax(280px, 1fr))` which allows stacking
  - Page: Shop landing page (main shop selector page)
  - Note: May need to investigate Kadence block editor settings or add custom CSS class to override theme defaults
  - Future Approach: Consider using Kadence's native column/row blocks instead of custom HTML grid, or investigate theme CSS that may be forcing full-width blocks

---

## September 2024

### Site Structure Established
- WordPress site created on Bluehost staging
- Kadence theme configured with custom fonts and branding
- Core pages created (Home, Events, News, Order Signs/Shop, Join Us, About)
- Custom CSS framework implemented (~600 lines)
- Navigation system configured (responsive with hamburger menu)

### Events Page Implemented
- Tockify calendar integration completed
- Two-tier display: Featured Events + Full Calendar
- Monthly view set as default
- Featured tag filtering configured

---

## Notes
- All changes documented here should include date, what changed, where it was changed, and why
- Technical details should reference specific WordPress settings locations when possible
- Known issues should be flagged with ⚠️ symbol for visibility
