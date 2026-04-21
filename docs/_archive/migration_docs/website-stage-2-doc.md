# Website_Stage_2: Lexington Alarm WordPress Development

## Project Overview
**Site URL:** `https://bpx.ela.mybluehost.me/website_97a098b6/`  
**Future Domain:** `lexingtonalarm.org`  
**Platform:** WordPress with Kadence Theme  
**Status:** Core Pages Built - Content Development Phase

---

## Completed Development (Stage 2)

### 1. Events Page ✅
**URL:** `/events/`  
**Status:** Complete and functional

**Implementation:**
- **Calendar System:** Tockify integrated
- **Two-tier display:**
  - Featured Events section (filtered by "featured" tag)
  - All Upcoming Events (monthly calendar view)
- **Styling:** 
  - Red ArmaliteRifle headings
  - Blue border dividers
  - Centered section titles
  - Mobile responsive

**Configuration:**
```html
<!-- Pinboard for featured -->
<div data-tockify-component="pinboard" 
     data-tockify-calendar="lexingtonalarm"
     data-tockify-search="featured">

<!-- Monthly calendar for all -->
<div data-tockify-component="calendar" 
     data-tockify-calendar="lexingtonalarm"
     data-tockify-view="monthly">
```

### 2. Shop/Order Signs Page ✅
**URL:** `/order-signs/`  
**Status:** Functional, pending payment gateway

**WooCommerce Setup:**
- **Products Created:**
  1. No King! No Tyranny Sign ($10)
  2. Patriotic Stickers ($5-8)
  3. Liberty Buttons ($3-5)
  4. **Donation Product (Variable):**
     - $10 Donation
     - $15 Sign + Donation
     - $20 Donation
     - $25 Donation
     - $50 Donation
     - Other Amount (multiples of $5)

**Custom Donation Handler:**
- Code Snippets plugin implementation
- Custom field for "Other Amount" option
- Quantity multiplier for $5 increments
- Cart price override functionality

**Shop Display:**
- 6-column grid on desktop (CSS configured)
- 3-column tablet / 2-column mobile
- Compact product cards (150px max image height)

**Pending:**
- PayPal/Stripe payment gateway connection
- Shipping configuration for physical items
- Order notification emails

### 3. About Page ✅
**URL:** `/about/`  
**Status:** Complete with historical content

**Content Structure:**
- **Header:** 1775-2025 Anniversary messaging
- **Mission Statement:** Resistance to tyranny theme
- **Historical Context:** 
  - April 19, 1775 reference
  - Captain John Parker quotes
  - Lexington Green battle significance
- **Modern Application:**
  - Current mission
  - Community involvement
  - Sign distribution program

**Styling Applied:**
- `.la-text-box` for content sections
- `.la-highlight-box` for important quotes
- Patriotic color scheme (blue/red accents)

---

## In Progress Development

### 4. News Page 🔄
**URL:** `/news/`  
**Status:** Structure ready, needs content

**Planned Implementation:**
- WordPress blog posts system
- Categories: 
  - Community Updates
  - Historical Articles
  - Event Announcements
  - Liberty News
- Sidebar with recent posts widget
- Comment system (optional)

### 5. Home Page 🔄
**URL:** `/` (site root)  
**Status:** Design phase

**Planned Sections:**

1. **Hero Section**
   - Full-width banner (LexAlarmBanner8.svg)
   - Mission statement overlay
   - Primary CTA buttons: "Join Us" / "Order Sign"

2. **Introduction Block**
   ```
   250th Anniversary of the Shot Heard Round the World
   Standing for Liberty Since 1775
   ```

3. **Three-Column Features**
   - Get Your Sign (link to shop)
   - Upcoming Events (link to events)
   - Join the Cause (link to join page)

4. **Latest News Feed**
   - 3 most recent posts
   - "View All News" link

5. **Call to Action**
   - Donation appeal
   - Newsletter signup form

6. **Footer Enhancement**
   - Quick links
   - Contact information
   - Social media icons (if applicable)

---

## Technical Implementation Details

### Custom CSS Classes (Active)
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

/* Typography */
Font hierarchy maintained:
- H1-H3: ArmaliteRifle (red)
- H4-H6: UglyQua (red)
- Body: Work Sans
```

### Active Plugins
1. **Kadence Theme** (free version)
2. **WooCommerce** (shop functionality)
3. **Code Snippets** (custom donation handler)
4. **Tockify** (events calendar)

### Custom Code Implementations
1. **Donation Handler** (PHP via Code Snippets)
   - Custom amount field
   - Price override in cart
   - Quantity multiplier system

2. **Shop Styling** (CSS in Customizer)
   - 6-column grid layout
   - Compact product display
   - Responsive breakpoints

---

## Next Steps Priority

### Immediate (Week 1)
1. **Complete News Page**
   - Create 3-5 initial posts
   - Set up categories
   - Configure excerpt lengths

2. **Build Home Page**
   - Implement hero section
   - Add content blocks
   - Link all CTAs

3. **Payment Gateway**
   - Connect PayPal or Stripe
   - Test transaction flow
   - Configure receipts

### Short Term (Week 2-3)
1. **Content Population**
   - Historical articles
   - Event entries in Tockify
   - Product descriptions

2. **Join Us Page Enhancement**
   - Membership form
   - Volunteer opportunities
   - Contact information

3. **SEO Setup**
   - Meta descriptions
   - Yoast SEO plugin
   - XML sitemap

### Pre-Launch (Week 4)
1. **Testing**
   - Cross-browser compatibility
   - Mobile responsiveness
   - Form submissions
   - Payment processing

2. **Migration Preparation**
   - Remove `/website_97a098b6/` from paths
   - Database URL updates
   - DNS configuration

---

## Migration Checklist

- [ ] Remove subdirectory from font URLs in CSS
- [ ] Update WordPress Address/Site URLs
- [ ] Search-replace database for URL changes
- [ ] Configure SSL certificate
- [ ] Update Tockify embed if needed
- [ ] Test all payment gateways
- [ ] Verify all internal links
- [ ] Clear all caches
- [ ] Set up 301 redirects if needed
- [ ] Configure backup system

---

## Known Issues & Notes

### Current Limitations
- Payment gateway not connected (shop non-functional for purchases)
- Some CSS optimizations pending
- Newsletter integration not configured
- Social media links not added

### Development Environment
- Bluehost staging URL active
- Database prefix: custom for security
- Child theme not implemented (using Customizer for all custom CSS)

### Performance Considerations
- Custom fonts loaded locally (good for speed)
- SVG banner (scalable, small file size)
- Minimal plugin usage
- No page builder bloat

---

## Resource Links

**Development URL:** `https://bpx.ela.mybluehost.me/website_97a098b6/`  
**Admin Access:** `/wp-admin/`  
**Tockify Dashboard:** `https://tockify.com/` (separate login)  
**Theme Docs:** Kadence Theme documentation  
**Shop Docs:** WooCommerce documentation

---

## Contact & Support

**Hosting:** Bluehost Support  
**Domain (Future):** lexingtonalarm.org  
**Platform:** WordPress 6.x with WooCommerce  

---

**Document Version:** Stage 2 - Content Development Phase  
**Date:** September 2024  
**Next Review:** After home page completion