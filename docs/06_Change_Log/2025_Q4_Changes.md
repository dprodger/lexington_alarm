# 2025 Q4 Changes

**Period:** October - December 2025  
**Status:** Active development and optimization

---

## Major Developments

### October 2025

#### October 18th Rally - Major Success
**Event:** Rally on Lexington Green drawing 6,000+ local attendees  
**Documentation:** Complete archive with speaker videos  
**Website Impact:** Featured content, video hosting, archive system  

**Technical Implementation:**
- Speaker video archive created
- Event documentation system established
- High-traffic load handled successfully

#### October 29, 2025 - Key Updates

**Comments Disabled Globally**
- Location: Settings → Discussion
- Action: Unchecked "Allow people to submit comments on new posts"
- Applied to: All existing posts via Bulk Edit (Comments set to "Do not allow")
- Reason: Comments feature not needed for current site operations

**Battle Green Flag Policy Form - Fixed After Migration**
- **Problem:** Form entries not being collected after site migration from staging to live
- **Root Cause:** Page was still referencing old staging form #408 instead of live form #19
- **Fix 1:** Updated form shortcode from `[wpforms id="408"]` to `[wpforms id="19"]`
- **Fix 2:** Updated confirmation redirect URL in form #19 settings from staging URL (`bpx.ela.mybluehost.me/website_97a098b6/`) to live URL (`lexingtonalarm.org`)
- **Result:** Entries now collecting properly in WPForms form #19
- **Email Confirmations:** Working correctly
  - Confirmation email to signer functioning
  - Confirmation email to info@lexingtonalarm.org functioning
- **Historical Data:** Old signatures from pre-migration period stored in form #408 on staging site (exported to CSV for records)

**Events Page Updates**
- Homepage Featured Events Display successfully highlighting max of 4 calendar events from Tockify
- Events must be tagged with "feature-home" to display
- Shows next four events matching that tag

**News Page Implementation**
- News team posting system implemented - allows team members to publish without WordPress admin access
- Newsletter archive system implemented
- Note: Adding newsletter to archive listing requires manually updating code snippet

**Store Page - Complete Overhaul**
- Shipping classes completely updated to incorporate three categories
- Includes Printful merchandise category integration
- Code added to prevent checkout with mixed shipping classes
- Email notifications for fulfillment properly labeled as:
  - [SHIPPING] for shipped orders
  - [LOCAL PICKUP] for pickup orders
  - [DONATION] for donations

#### Site Migration to Production Domain
**Completed:** Full migration from staging to lexingtonalarm.org  
**Key Actions:**
- 301 redirects implemented from bpx.ela.mybluehost.me/website_97a098b6/
- All font paths updated (removed /website_97a098b6/)
- DNS configured and SSL activated
- Email delivery verified
- WooCommerce test orders confirmed

**Status:** Fully operational on production domain

---

### November 2025

#### Store System Optimization

**WooCommerce Order Management:**
- Implemented email category tagging system
  - `[LOCAL PICKUP]` for yard sign orders
  - `[SHIPPING]` for button/merchandise orders
  - `[DONATION]` for donation-only orders
- Email notification system refined
- SendLayer integration optimized for delivery

**Shipping Class Challenges Identified:**
- Issue: Customers can mix incompatible shipping classes in cart
- Problem: Local pickup items + shipped items in same order
- Solution in Progress: Advanced Shipping Packages plugin implementation
- See: `02_Store_System/Checkout_Flow.md`

#### Massport Campaign Development

**November 16-17, 2025 - Campaign Goes Live:**
- Custom PDF generation system built (570 lines PHP/TCPDF)
- Email formatting challenges solved (cross-platform compatibility)
- Two-action system implemented:
  - Quick email to Massport officials
  - Automated personalized PDF letters to board members
- Campaign page: https://lexingtonalarm.org/stop-massport-ice-flights-campaign/
- See: `05_Active_Campaigns/Massport_Campaign.md`
- See: `07_Change_Log/2025-11-16_Massport_Email_Formatting_Progress.md`

**Technical Achievements:**
- Avoided $1,188/year in commercial PDF service costs
- Built custom PHP solution with TCPDF library
- Generates 15-page PDF packets in 3-5 seconds
- Zero ongoing monthly costs
- 100% automated delivery via email

**Still In Progress:** 
- Analytics tracking implementation
- Minor page updates

---

### December 2025 (Current)

#### December 6, 2025 - Home Page Restructure & Dynamic Content

**Home Page Featured Story - Dynamic Integration:**
- **Previous:** Manual HTML with hardcoded Massport ICE story content
- **New:** Dynamic `[featured_story]` shortcode integration
- **Benefit:** Featured story now auto-syncs with News page - update once, displays in both locations
- **Implementation:** Simple wrapper div with section title + shortcode
- **Layout:** Image left (40%), text right (60%), stacks on mobile
- **CSS:** Uses existing `.featured-story-section` and `.featured-article` classes

**Home Page Featured Items Section - New:**
- **Purpose:** Two-column product showcase below featured story
- **Left Column:** YouTube Short embed (mailable sign video) + description box
- **Right Column:** Product image (yard sign) + description box with price
- **Layout:** 50/50 split, stacks on mobile
- **Styling:** Blue borders, gray background boxes, red CTA buttons
- **Video URL:** https://www.youtube.com/shorts/biSHMU6aXZY
- **Product URL:** https://lexingtonalarm.org/product/18-x-24-yard-sign-no-king-no-tyranny-law-is-king/

**Rally Recap Section - Relocated:**
- **Previous Location:** Home page Section 2
- **New Location:** Speaker Videos page (dedicated archive page)
- **Content:** Photos, "6000 Turn Out" text, CTA buttons preserved
- **Page URL:** `/speaker-videos/` (renamed to "Oct 18 No Kings Recap")

**Speaker Videos Page - Cleaned Up:**
- **Problem:** Orphaned div tags and broken wrappers causing layout issues
- **Fix:** Complete code cleanup - removed stray `<!-- /wp:post-content -->` tags
- **Result:** Consistent 33.33%/66.66% column layout for all speakers
- **Layout:** Text/bio left, video embed right, with proper spacing

**Documentation Created:**
- New file: `04_Content_Publishing/Home_Page.md`
- Complete structure overview
- Featured Story shortcode usage instructions
- Featured Items section complete code
- Update instructions for both sections
- Troubleshooting guide for column layouts

**Key Technical Learning:**
- Column layouts break when wrapper divs are inserted between sibling columns
- Always close all `</div>` tags properly before starting new sections
- Use single container divs to keep image + text box aligned

---

#### December 4, 2025 - WPForms Spam Protection & News System Enhancements

**WPForms Cloudflare Turnstile CAPTCHA:**
- **Background:** SendLayer flagged high form submission volume as potential spam
- **Solution:** Implemented Cloudflare Turnstile (invisible CAPTCHA)
- **Setup:**
  - Created free Cloudflare account
  - Added Turnstile widget: Widget Name "Lexington Alarm", Domain lexingtonalarm.org
  - Widget Mode: Invisible (no user interaction required)
  - Pre-Clearance: Off
- **WPForms Configuration:** Settings → CAPTCHA → Turnstile selected, keys entered
- **Forms Protected:** All WPForms (Join Us, Contact, etc.)
- **Additional Spam Layers:** Honeypot enabled, minimum submit time 2-3 seconds
- **Result:** Bot submissions blocked without affecting legitimate users

**News Submission System - Byline Override Feature:**
- **Purpose:** Allow news team to override author attribution for reprints
- **Implementation:** Added Byline field to submission form
- **Behavior:**
  - Pre-fills with logged-in user's display name
  - Can be changed to any text (e.g., "Reprinted from Boston Globe")
  - Saved as post meta: `la_byline`
  - Automatically displays via `the_author` filter
- **Functions Added:** `la_get_byline()`, `la_filter_author_name()`
- **Shortcode:** `[la_byline]` for custom template use

**News Submission System - Auto-Backup Feature:**
- **Purpose:** Prevent content loss from browser crashes or accidental navigation
- **Implementation:**
  - Saves to browser localStorage every 2 seconds
  - "Draft saved" notification every 15 seconds
  - Manual "SAVE DRAFT" button added
  - Recovery prompt on page load if unsaved draft found
- **Storage Key:** `la_news_draft`
- **Fields Backed Up:** Title, Summary, Full Story, Featured checkbox
- **Auto-Cleanup:** Draft cleared after successful submission

**Documentation Updated:**
- `04_Content_Publishing/News_System/News_Team_Portal.md` - Complete rewrite with new features
- `01_Technical_Foundation/Plugins_And_Integrations.md` - Added Cloudflare Turnstile section

---

#### December 3, 2025 - Shop Page 2x2 Grid Layout Fixed

**Problem Solved:** Shop landing page cards now display in proper 2x2 grid on desktop

**Background:**
- Previous attempts to use CSS Grid with Custom HTML blocks failed
- Kadence theme CSS was overriding all custom grid styles
- Cards displayed in single vertical column on all screen sizes

**Solution Implemented:**
- Used Kadence Row Layout blocks (native theme blocks) for grid structure
- Created two Row Layout blocks, each with 2 columns (50/50 split)
- Placed Custom HTML blocks inside each column for card content
- Card styling preserved exactly as designed

**Additional Changes:**
- Added 4th card: Donate product (`/product/donate-to-lexington-alarm/`)
- Updated hero section: reduced height, added top margin for white space, square corners
- Disabled page title in Kadence Page Settings (hero serves as visual title)
- Page URL: `/browse-products/`

**Result:**
- 2x2 grid displays correctly on desktop
- Automatically stacks to single column on mobile (below 768px)
- Header, footer, navigation all preserved
- Fully integrated with WooCommerce store

**Key Learning:** Let Kadence handle layout structure; use Custom HTML only for content styling within native blocks.

**Related Issue (Not Yet Fixed):** Donation product cannot be combined with other fulfillment types in cart. Requires update to cart validation code.

**See:** `06_Code_Snippets/Shop_Page_Code.md` for complete code and implementation details.

---

#### Documentation System Overhaul
**Status:** In Progress (November 22, 2025)  
**Goal:** Create comprehensive, organized documentation system  
**Structure:** 8 main categories with detailed documents

**Purpose:**
- Reduce time explaining previous decisions
- Enable efficient problem-solving with proper context
- Support team member autonomy
- Maintain institutional knowledge

**Implementation:**
- Local folder structure on desktop
- Mirror to Project Knowledge for Claude conversations
- Regular updates as work progresses

#### Current Active Work

**1. Store Checkout Complexity**
**Issue:** Cart validation for shipping classes  
**Solution:** Advanced Shipping Packages plugin  
**Status:** Configuration and testing needed  
**Priority:** High - affects customer experience

**2. Massport Campaign Tracking**
**Issue:** Need analytics for campaign effectiveness  
**Solution:** Plausible Analytics event tracking implementation  
**Status:** Planning implementation  
**Priority:** Medium - valuable for campaign optimization

**3. Massport Page Updates**
**Issue:** Minor content updates needed  
**Status:** Ready for implementation  
**Priority:** Medium

---

## Known Issues

### ⚠️ UNRESOLVED: Tablet Menu Header Bug
- **Problem:** Top-level menu items for NEWS and ABOUT pages do not function on tablet screen sizes
- **Cause:** Conflict between hover states and screen width detection
- **Status:** Menu functions properly on desktop and mobile screen sizes only
- **Impact:** Tablet users cannot access News and About top-level pages (submenu items work)
- **Note:** Refer to previous troubleshooting conversation for technical details

### ✅ RESOLVED: Shop Page Grid Layout (December 3, 2025)
- **Original Problem:** Shop category cards stacked vertically on all screen sizes due to Kadence theme CSS overrides
- **Solution:** Used Kadence Row Layout blocks for grid structure with Custom HTML blocks inside for card content
- **Result:** 2x2 grid on desktop, single column on mobile, all styling preserved
- **Bonus:** Added 4th card (Donate) during fix
- **See:** `06_Code_Snippets/Shop_Page_Code.md` for complete implementation

### ⚠️ UNRESOLVED: Donation Product Cart Mixing
- **Problem:** Donation (virtual) product cannot be combined with Local Pickup or Shipped items in cart
- **Error:** "Cannot Mix Fulfillment Methods" when attempting to add donation to cart with other items
- **Cause:** Cart validation code treats Virtual as separate fulfillment category
- **Impact:** Customers must checkout donations separately from product orders
- **Future Fix:** Update cart validation snippet to allow Virtual/Donation items with any fulfillment type
- **Priority:** Medium - affects donation convenience but doesn't block purchases

---

## Product Catalog Updates

### Yard Signs
- 2' x 3' size active and selling
- 18" x 24" compact size active
- Local pickup only (shipping class configured)
- Inventory management system in place

### Buttons
- Standard buttons available
- Nationwide shipping enabled
- Considering button add-ons for donations

### Apparel
- Printful integration active
- T-shirts available with multiple sizes
- Print-on-demand fulfillment working

### Donations
- Donation product with amount variations
- Virtual product (no shipping)
- Considering enhancements for button add-ons

---

## Email System Enhancements

### Mailchimp Integration Progress
**Goal:** Sophisticated automation and tagging system  
**Current Status:** 400+ subscribers, bi-weekly newsletter schedule

**Tagging Strategy:**
- Volunteer coordination tags
- Committee assignment tags
- Engagement level tracking
- Geographic segmentation

**Newsletter Workflow:**
- Bi-weekly newsletter schedule
- Content compiled from individual news posts
- Archive system functioning
- Signup forms integrated

---

## Content Publishing System

### News Team Access
**Achievement:** Front-end submission system enables team independence  
**Team Members:** Christine Dall, Steve Singer  
**Workflow:** Direct publishing capability reduces bottlenecks

### Newsletter Archive
**System:** Comprehensive archive of newsletters  
**Access:** Public access to past newsletters  
**Format:** Newsletter landing page with organized archives

### Events Calendar
**System:** Tockify integration working well  
**Features:** Featured events + full calendar views  
**Status:** Stable and functional

---

## Infrastructure & Technical

### Hosting & Performance
**Provider:** Bluehost  
**Status:** Stable  
**Performance:** Handles traffic well, including rally event surge

### Backup System
**Solution:** UpdraftPlus with Dropbox storage  
**Status:** Active and functioning  
**Schedule:** Regular automated backups

### Email Delivery
**Transactional:** SendLayer SMTP working reliably  
**Newsletter:** Mailchimp for bulk emails  
**Organizational:** ProtonMail accounts (info@, store@, volunteer@)

### Analytics (Planned)
**Solution:** Plausible Analytics  
**Status:** Planning implementation  
**Goal:** Privacy-focused visitor and engagement tracking

---

## Issues Resolved This Quarter

### ✅ Migration from Staging to Production
- 301 redirects working
- Font paths corrected
- All functionality verified
- No broken links

### ✅ Battle Green Flag Policy Form
- Form ID mismatch fixed
- Entries collecting properly
- Email confirmations working
- Historical data preserved

### ✅ Email Deliverability
- SendLayer SMTP configured properly
- Order notifications sending reliably
- Category tagging working

### ✅ WooCommerce Payment Processing
- Stripe integration functioning
- Apple Pay simplified setup completed
- Test and live orders processing correctly

### ✅ October Rally Documentation
- Complete video archive created
- Speaker presentations preserved
- Event documented for historical record

### ✅ Massport Campaign PDF System
- Custom PHP solution built and deployed
- Email formatting cross-platform compatibility solved
- Zero ongoing costs achieved
- Production ready and live

### ✅ Shop Page 2x2 Grid Layout (December 3, 2025)
- Long-standing layout issue resolved
- Used Kadence Row Layout blocks instead of custom CSS Grid
- Added Donate card (4th card) to shop landing page
- Mobile responsive stacking working
- Hero section refined (compact height, white space margins)

---

## Ongoing Issues & Challenges

### 🔄 Cart Validation for Shipping Classes
**Status:** In progress with Advanced Shipping Packages  
**Impact:** Customer experience, order fulfillment complexity  
**Next Steps:** Configure plugin, test thoroughly, deploy

### 🔄 Newsletter Signup Workflow Optimization
**Status:** Working but could be enhanced  
**Goals:** 
- Better automation
- More sophisticated tagging
- Prevent re-subscribing people who opted out

### 🔄 Analytics Implementation
**Status:** Planned but not yet implemented  
**Need:** Better data on visitor behavior, campaign effectiveness  
**Solution:** Plausible Analytics installation and event tracking

### 🔄 Mobile Menu Tablet Issues
**Status:** Known issue, no solution yet
**Impact:** Tablet users cannot click top-level News/About pages
**Workaround:** Submenu items still functional

### 🔄 Shop Page Desktop Layout
**Status:** Functional but not ideal visual layout
**Impact:** Cards stack vertically even on wide screens
**Workaround:** Current layout works, just not optimal

---

## Team & Organization Updates

### Executive Committee
- Steve, Karin, Jonina
- Regular meetings and decision-making
- Strategic planning for 2025

### News Team
- Christine Dall, Steve Singer
- Front-end publishing capability working well
- Regular content creation

### Volunteer Coordination
- Growing volunteer base
- Email-based coordination system
- Mailchimp tags for volunteer tracking

---

## Looking Ahead to 2025

### Q1 2025 Priorities
- Complete cart validation implementation
- Finalize Mailchimp automation
- Implement comprehensive analytics
- Expand product catalog (consider new items)
- Continue Massport campaign pressure

### 250th Anniversary (April 2025)
- Battle of Lexington anniversary approaching
- Major organizational milestone
- Events and content planning needed
- Historical narrative emphasis

### Ongoing Initiatives
- ICE flight monitoring at Hanscom
- Battle Green flag protocol advocacy
- Community organizing around democratic principles
- Newsletter growth and engagement

---

## Key Learnings Q4 2025

### Technical Simplicity > Complexity
- Example: Avoided complex Google Pay setup
- Example: Built custom PDF system instead of expensive commercial service
- Lesson: Reliable, straightforward solutions better than elaborate integrations
- Application: Keep future implementations simple and maintainable

### Custom Development Can Save Significant Money
- Massport PDF system saved $1,188/year
- 3 hours development time vs. years of monthly fees
- Open source tools (TCPDF) provide enterprise-grade functionality
- Investment in custom solutions pays off long-term

### Email Categorization Highly Valuable
- Subject line tags enable quick order prioritization
- Reduces time sorting through orders
- Improves fulfillment workflow efficiency

### Documentation Critical for Efficiency
- Time wasted re-explaining previous decisions
- Need systematic documentation to support ongoing work
- Investment in documentation pays off in reduced future friction

### Rally Success Demonstrates Impact
- 6,000 attendees proves strong community support
- Website serves critical role in organizing
- Video archive preserves historical record
- Model for future events

### Cross-Platform Compatibility Requires Testing
- Email clients handle formatting differently
- Windows vs. Unix line breaks matter
- Test on actual devices, not just browser emulation
- Solution: Windows-style line breaks (`%0D%0A`) for universal compatibility

---

## Metrics & Data

### Website Traffic
**Period:** October - December 2025  
**Data:** To be documented when analytics implemented
- Page views
- Unique visitors
- Top pages
- Traffic sources

### Store Performance
**Period:** October - December 2025  
**Orders:** (Document order counts)
- Yard signs (local pickup)
- Buttons (shipping)
- Donations
- Apparel

**Revenue:** (Document if tracked)  
**Conversion Rate:** (Document if tracked)

### Newsletter Growth
**Period:** October - December 2025  
**Subscribers:** 400+ and growing  
**Open Rate:** (Document from Mailchimp)  
**Click Rate:** (Document from Mailchimp)

### Massport Campaign
**Launch Date:** November 17, 2025  
**Early Metrics:** To be tracked
- PDF requests
- Email actions
- Page visits
- Conversion rate

---

## Documentation Created This Quarter

### November 2025 - Documentation System Established
**Structure Created:**
- 01_Technical_Foundation
- 02_Store_System
- 03_Email_Systems
- 04_Content_Publishing
- 05_Active_Campaigns
- 06_Code_Snippets
- 07_Change_Log
- 08_Quick_References

**Initial Documents:**
- Master INDEX with navigation
- Site Configuration (comprehensive)
- Theme and Styling
- Plugins and Integrations
- WooCommerce Setup
- Products Catalog
- Checkout Flow
- Email Notifications
- Massport Campaign (complete technical documentation)
- Massport Email Formatting Progress (Nov 16)
- WPCode Active Snippets reference
- Shop Page Code and troubleshooting
- Brand Assets Quick Reference
- Events Calendar
- 2025 Q4 Changes (this document)

**Purpose:** Systematic knowledge capture and efficient future work

---

## Change Log Notes

**How to Use This Document:**
1. Add significant changes as they occur
2. Organize by month within quarter
3. Link to detailed documentation when available
4. Include both successes and ongoing challenges
5. Capture key learnings and decisions

**Next Update:** End of Q4 2025 (December 31, 2025)  
**Future Quarterly Documents:** Will be created for Q1 2026, Q2 2026, etc.

---

**Related Documentation:**
- All other documentation references this change log
- This document provides historical context for decisions
- Link to specific documents for detailed implementation notes
