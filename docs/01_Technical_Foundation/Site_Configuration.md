# Website_Stage_1: Lexington Alarm WordPress Development

## Project Overview
**Site URL:** `https://lexingtonalarm.org` (migrated from staging)  
**Platform:** WordPress with Kadence Theme  
**Status:** Live and Operational

---

## Technical Implementation Completed

### Core Files & Assets
```
/wp-content/
├── themes/kadence/
│   └── fonts/
│       ├── armalite_rifle.ttf
│       ├── UglyQua.ttf
│       └── UglyQuaItalic.ttf
└── uploads/2025/09/
    └── LexAlarmBanner8.svg
```

### Brand Specifications
**Colors (from SVG):**
- Primary Blue: `#044f9d`
- Primary Red: `#c3202e`
- White: `#ffffff`

**Typography Hierarchy:**
- H1-H3: Libre Baskerville (black)
- H4-H6: UglyQua (black)
- Body: Work Sans (black)
- Navigation/Buttons: UglyQua
- Banner Text: ArmaliteRifle (red, uppercase)

### Responsive Breakpoints
- Desktop: 1025px+ (full width banner, desktop navigation)
- Tablet/Mobile: 1024px and below (hamburger menu)
- Tablet Portrait (768-1024px): 500px max banner
- Phone Portrait (<768px): 280px max banner
- Phone Landscape: 350px max banner

---

## Site Structure Established

### Pages Created
1. Home
2. Events (with Tockify calendar integration)
3. News (with featured story, subscribe banner, newsletter archive)
4. Order Signs/Shop (WooCommerce)
5. Get Involved (Join Us)
6. About
   - History (submenu)

### Navigation System
- Desktop (1025px+): Horizontal menu below banner with hover dropdowns
- Mobile/Tablet (1024px and below): Hamburger menu with toggle arrows
- All internal links using WordPress page references (not hardcoded URLs)
- Submenus: News → Latest News, About → History

---

## CSS Framework Ready

### Available Content Classes
```css
/* Buttons */
.la-button              // Red button, white border
.la-button-secondary    // Blue button
.la-button-large        // Large button for CTAs

/* Content Boxes */
.la-text-box           // Standard bordered box
.la-highlight-box      // Blue border, red accent

/* Layout */
.la-two-column         // Flex two-column
.la-section            // Standard section padding

/* Utilities */
.la-text-center/left/right
.la-bg-blue/red/white
.la-mt-1/2/3          // Margin top
.la-mb-1/2/3          // Margin bottom
.la-p-1/2/3           // Padding
```

---

## Major Updates & Fixes

### Migration to Live Domain (2024)
- Completed 301 redirects from staging (bpx.ela.mybluehost.me/website_97a098b6)
- Updated all URLs to lexingtonalarm.org
- Verified all internal links and menu references

### WooCommerce Integration
- Three-category product system:
  - Local pickup items
  - Shipped items
  - Printful merchandise (separate fulfillment)
- Shipping class validation to prevent incompatible cart combinations
- Email automation through SendLayer/WP Mail SMTP
- Mailchimp newsletter integration (400+ subscribers)

### Events Page Implementation (September 2024)
- Two-tier display: Featured events (pinboard) + Full calendar (monthly view)
- Tockify calendar integration with "featured" tag filtering
- Responsive design with brand-consistent styling
- See: `Events_Page_documentation.txt` for full details

### News Page System
- Featured story section with image and excerpt
- Subscribe banner with Mailchimp integration
- Newsletter archive with blog post listings
- Single post layout with centered titles and featured images
- Automatic title hiding on page view (shown only on single posts)

### Mobile Menu Fix (November 2024)
**Problem:** Dropdown arrow buttons were oversized compared to menu text, creating visual imbalance and poor UX.

**Solution Implemented:**
- Increased main menu text size to 1.25rem for better readability
- Reduced dropdown toggle buttons from 28px to 24px square
- Reduced arrow icons from 14px to 12px for proper proportion
- Set submenu text to 1.1rem (smaller than parent items for hierarchy)
- Adjusted padding and spacing for better touch targets
- Maintained red background with white border for brand consistency

**Technical Details:**
- Applied to screens 1024px and below
- Uses flexbox for proper alignment
- Font family set to UglyQua for consistency
- Line-height optimized at 1.4 for readability

**Result:** Professional, balanced mobile menu with clear visual hierarchy and proportional elements.

### Desktop Navigation Behavior
- Hover shows submenu dropdown
- Click on parent item navigates to page (News, About)
- Submenu items styled with red boxes on transparent background
- All dropdown arrows hidden on desktop view

### Touch Device Handling
- Breakpoint set at 1024px to force hamburger menu on tablets
- Prevents hover-based navigation issues on touch screens
- Mobile menu uses toggle arrows for submenu expansion
- First tap on parent item navigates to page
- Toggle arrow expands submenu independently

---

## Known Issues & Notes

### Current Configuration
- Font paths use root WordPress directory structure
- All menu items use page references (auto-update on changes)
- Mobile and desktop headers configured separately in Kadence
- Social media icons positioned correctly across all screen sizes

### Maintenance Reminders
- Clear all caches after CSS changes
- Test navigation on actual touch devices (not just browser emulation)
- Safari Responsive Mode uses mouse hover (doesn't replicate true touch behavior)

---

## Active Features

### E-Commerce
- WooCommerce with Stripe integration (Payment Plugins)
- Three fulfillment workflows (local pickup, shipping, Printful)
- Cart validation to prevent mixed shipping classes
- Automated order notification emails with category tags

### Email & Communication
- SendLayer SMTP for reliable delivery to ProtonMail
- Mailchimp for newsletters with automated welcome sequences
- Volunteer tagging system for segmentation

### Calendar & Events
- Tockify integration with monthly default view
- Featured events filtering via tags
- Responsive display across all devices

### Forms
- WPForms Pro for contact and volunteer signup
- Direct email delivery (no database storage)
- Custom styling with brand colors

---

## Technical Contacts & Resources

**Hosting:** Bluehost (dedicated account for Lexington Alarm)  
**Theme:** Kadence (free version)  
**Critical Files:**
- Custom CSS: WordPress Customizer → Additional CSS
- Banner: `/uploads/2025/09/LexAlarmBanner8.svg`
- Fonts: `/themes/kadence/fonts/`

---

## CSS Maintenance Notes

The CSS file (~1400+ lines) is organized in sections:
1. Custom Properties/Variables
2. Font Definitions
3. WordPress/Kadence Overrides
4. Typography
5. Header & Banner
6. Navigation (Desktop & Mobile)
7. Buttons
8. Content Boxes
9. Layout Components
10. Footer
11. WooCommerce/Shop Grid
12. Dropdown Menu Styles
13. Forms
14. News Posts & Display
15. Mobile Hamburger Menu Styling
16. Social Media Icons
17. Navigation Behavior Fixes
18. Utility Classes
19. Mobile Responsive

Mobile/tablet responsive rules are consolidated with media queries throughout for easy maintenance.

---

## Future Enhancements

### Priority Items
- Complete "Get Involved" page with volunteer signup forms and committee selection
- Social media integration in site header (partially complete)
- Donation system with variable pricing options
- Speaker videos archive from recent rallies
- Letter-writing campaign tool for constituent outreach

### Content Development
- Expand historical content for 250th anniversary (2025)
- Build out event management with RSVP systems
- Newsletter template refinement in Mailchimp
- SEO optimization across all pages

---

**Document Version:** Stage 1 Complete + Mobile Menu Fix  
**Last Updated:** November 2024  
**Next Focus:** Get Involved page completion, social media integration, donation system expansion
