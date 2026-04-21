# Website_Stage_1: Lexington Alarm WordPress Development

## Project Overview
**Site URL:** `https://bpx.ela.mybluehost.me/website_97a098b6/`  
**Future Domain:** `lexingtonalarm.org`  
**Platform:** WordPress with Kadence Theme  
**Status:** Structure Complete - Ready for Content

---

## Technical Implementation Completed

### Core Files & Assets
```
/website_97a098b6/
├── wp-content/
│   ├── themes/kadence/
│   │   └── fonts/
│   │       ├── armalite_rifle.ttf
│   │       ├── UglyQua.ttf
│   │       └── UglyQuaItalic.ttf
│   └── uploads/2025/09/
│       └── LexAlarmBanner8.svg
```

### Brand Specifications
**Colors (from SVG):**
- Primary Blue: `#044f9d`
- Primary Red: `#c3202e`
- White: `#ffffff`

**Typography Hierarchy:**
- H1-H3: ArmaliteRifle (red, uppercase)
- H4-H6: UglyQua (red)
- Body: Work Sans (black)
- Navigation/Buttons: UglyQua

### Responsive Breakpoints
- Desktop: Full width banner
- Tablet Portrait (768-1024px): 500px max banner
- Phone Portrait (<768px): 280px max banner
- Phone Landscape: 350px max banner

---

## Site Structure Established

### Pages Created
1. Home
2. Events
3. News
4. Order Signs/Shop
5. Join Us
6. About

### Navigation System
- Desktop: Horizontal menu below banner
- Mobile/Tablet: Hamburger menu (white on blue)
- All internal links using WordPress page references (not hardcoded URLs)

---

## CSS Framework Ready

### Available Content Classes
```css
/* Buttons */
.la-button              // Red button, white border
.la-button-secondary    // Blue button

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

## Known Issues & Notes

### Current Setup
- Font paths include `/website_97a098b6/` (needs removal at migration)
- All menu items use page references (will auto-update on domain change)
- Mobile header configured separately from desktop in Kadence

### Pre-Migration Tasks
- [ ] Remove `/website_97a098b6/` from font URLs in CSS
- [ ] Run database search-replace for URLs
- [ ] Update WordPress General Settings URLs
- [ ] Clear all caches after migration

---

## Next Phase: Content Development

### Priority 1 - Core Messaging
- Home page hero section with mission statement
- About page with historical context (1775-2025)
- Clear calls-to-action for joining/ordering signs

### Priority 2 - Engagement Features
- Events calendar/listing
- News/updates section
- Contact/join form
- Shop setup (PayPal/simple cart)

### Priority 3 - Enhancement
- Image galleries
- Social media integration
- Newsletter signup
- SEO optimization

---

## Technical Contacts & Resources

**Hosting:** Bluehost  
**Theme:** Kadence (free version)  
**Critical Files:**
- Custom CSS: WordPress Customizer → Additional CSS
- Banner: `/uploads/2025/09/LexAlarmBanner8.svg`
- Fonts: `/themes/kadence/fonts/`

---

## CSS Maintenance Notes

The CSS file (~600 lines) is organized in sections:
1. Custom Properties/Variables
2. Font Definitions
3. WordPress/Kadence Overrides
4. Typography
5. Header & Banner
6. Navigation
7. Buttons
8. Content Boxes
9. Layout Components
10. Footer
11. Mobile Responsive
12. Utility Classes
13. WordPress Specific Overrides

Mobile/tablet responsive rules are consolidated at the end for easy maintenance.

---

**Document Version:** Stage 1 Complete  
**Date:** September 2024  
**Next Conversation Focus:** Content creation and page-by-page development