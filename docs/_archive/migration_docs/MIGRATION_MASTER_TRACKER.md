# Lexington Alarm WordPress Migration Master Tracker
**Last Updated:** September 8, 2025  
**Primary Working Directory:** `/wordpress working files/`
**Strategy:** Transform website into dynamic hub for all activities

---

## 📁 DIRECTORY STRUCTURE
This directory (`/wordpress working files/`) serves as our primary repository for:
- Migration documentation
- Progress tracking files
- Technical instructions
- Code snippets and templates
- Configuration backups

---

## 🎯 MIGRATION STATUS OVERVIEW

### Current Environment
- **Development URL:** `https://bpx.ela.mybluehost.me/website_97a098b6/`
- **Target Domain:** `lexingtonalarm.org`
- **Platform:** WordPress with Kadence Theme (free version)
- **Hosting:** Bluehost

### Migration Phases
- [x] **Stage 1:** WordPress Structure Complete (September 2024)
- [ ] **Stage 2:** Content Development (In Progress)
- [ ] **Stage 3:** Pre-Migration Testing
- [ ] **Stage 4:** Domain Migration
- [ ] **Stage 5:** Post-Migration Verification

### ✅ COMPLETED COMPONENTS
- **SVG Banner:** Fully implemented and tested across all screen sizes
- **Events Page:** Complete with Tockify calendar integration (two-tier display)
- **Footer:** Implemented with logo and all required elements
- **About Page:** Complete with Vision/Mission statements, responsive containers (Sept 8, 2025)

---

## 📄 KEY DOCUMENTATION FILES

| File | Purpose | Status |
|------|---------|--------|
| `Website_Stage_1- Lexington Alarm WordPress Development.md` | Core technical specs, CSS framework | ✅ Complete |
| `Events_Page_documentation.txt` | Tockify calendar integration | ✅ Complete |
| `Lexington_Alarm_Footer_Documentation.md` | Footer implementation | ✅ Complete |
| `LEXINGTON ALARM - WORDPRESS THEME STYLES Version- 1.0.txt` | Theme customizations | 📝 Active |
| `lexington-footer.html` | Footer HTML template | ✅ Complete |
| `tockify-events-page.html` | Events page template | ✅ Complete |
| `About_Page_COMPLETE.md` | Final About page implementation | ✅ Complete |

---

## 🚀 ACTIVE DEVELOPMENT TASKS

### REVISED SITE ARCHITECTURE

#### Top-Level Navigation (Simplified)
1. **Home** - Dynamic hub with sections for all activities
2. **Events** - ✅ Complete (Tockify integration)
3. **News** - Newsletter integration + curated links
4. **Shop** - Combined signs & merchandise page
5. **Get Involved** - Volunteer & newsletter signups
6. **About** - ✅ Complete

#### Home Page Sections (NEW)
- [ ] **Events Section** - Featured upcoming events
- [ ] **Order Signs Section** - Quick access to yard signs
- [ ] **News Section** - Latest updates/newsletter preview
- [ ] **Volunteer Section** - Join the movement CTA

---

## 📋 DETAILED PAGE SPECIFICATIONS

### 1. SHOP PAGE (Combined Solution)
**Structure:** Single page with two distinct sections

#### Top Section - Yard Signs (WooCommerce)
- [ ] Install & configure WooCommerce
- [ ] Set up local fulfillment products
- [ ] Configure payment processing (PayPal/Stripe)
- [ ] Add bulk order options
- [ ] Set up local pickup choices
- [ ] Configure shipping zones

#### Bottom Section - Merchandise (Printify)
- [ ] Implement Printify integration
- [ ] Choose embedding method:
  - Option A: Pop-up widget (easiest)
  - Option B: Direct product embeds
  - Option C: API integration (most complex)
- [ ] Add clear fulfillment labeling
- [ ] Create unified shop page design

**Visual Indicators:**
- "Ships from Lexington" badge for signs
- "Print-on-Demand" badge for merchandise

---

### 2. GET INVOLVED PAGE
**Components:**

#### Newsletter Signup
- [ ] Mailchimp integration form
- [ ] Create main list segment

#### Volunteer System
- [ ] Create volunteer interest form
- [ ] Set up form fields:
  - Name, email, phone
  - Availability preferences
  - Interest areas (tabling, organizing, etc.)
  - Geographic location
- [ ] Configure Mailchimp volunteer segment
- [ ] Set up bi-weekly volunteer email automation
- [ ] **Set up "Once a Week Club"**
  - [ ] Create Mailchimp tag: "once-a-week-club"
  - [ ] Design weekly activities email template
  - [ ] Include RSVP/interest system for each activity
  - [ ] Add connection feature for attendees to coordinate
  - [ ] Set up automated weekly send (e.g., Monday mornings)
  - [ ] Create signup option on volunteer form
  - [ ] Include "Find a buddy" feature for activities

#### Email Strategy
- [ ] Main newsletter (all subscribers)
- [ ] Volunteer-only emails (subset list)
- [ ] Opportunity alerts (automated)

---

### 3. NEWS PAGE
**Primary Function:** Newsletter hub with curated content

#### Newsletter Integration
- [ ] Embed Mailchimp archive
- [ ] Create signup form
- [ ] Display latest newsletter

#### Curated Links Section
- [ ] Create submission system for team
- [ ] Set up moderation workflow
- [ ] Design link display format

#### Future Enhancements (Post-Launch)
- [ ] Blog integration (dropdown menu)
- [ ] Article categories
- [ ] Search functionality
- [ ] RSS feed integration

---

### 4. SOCIAL MEDIA INTEGRATION

#### Social Media Bar
- [ ] Add to header or fixed sidebar
- [ ] Include platforms:
  - Facebook
  - Twitter/X
  - Instagram
  - YouTube (if applicable)
- [ ] Style with brand colors

#### Social Feed Page
- [ ] Create dedicated page (linked from News)
- [ ] Embed live social feeds
- [ ] Consider aggregator plugin options:
  - Smash Balloon (~$49/year)
  - Feed Them Social
  - Custom API integration

---

## 🛠️ TECHNICAL IMPLEMENTATION PRIORITIES

### Phase 1: Core Functionality (Pre-Launch)
1. [x] Events page with calendar ✅
2. [x] About page content ✅
3. [ ] Shop page - WooCommerce for signs
4. [ ] Get Involved - Basic volunteer form
5. [ ] News page - Newsletter integration
6. [ ] Home page sections

### Phase 2: Enhanced Engagement (Launch Week)
1. [ ] Printify merchandise integration
2. [ ] Social media bar
3. [ ] Volunteer email automation
4. [ ] Newsletter archive display

### Phase 3: Dynamic Features (Post-Launch)
1. [ ] Social media feed page
2. [ ] Blog functionality
3. [ ] Curated links system
4. [ ] Advanced volunteer scheduling
5. [ ] Analytics/page tracking setup

---

## ⚠️ CRITICAL PRE-MIGRATION TASKS

### Path Updates Required
- [ ] Remove `/website_97a098b6/` from all font URLs in CSS
- [ ] Update all hardcoded development URLs
- [ ] Verify all menu items use page references (not URLs)

### Database Tasks
- [ ] Run search-replace for development URLs → production URLs
- [ ] Export complete database backup
- [ ] Document any custom database tables

### File System Tasks
- [ ] Verify all custom fonts are in correct directories
- [ ] Ensure SVG banner is in uploads folder
- [ ] Check all image paths are relative

### WordPress Configuration
- [ ] Update General Settings URLs
- [ ] Configure SSL certificate
- [ ] Set up redirects from old URLs if needed
- [ ] Clear all caches post-migration

---

## 🎨 BRAND ASSETS REFERENCE

### Colors
- Primary Blue: `#044f9d`
- Primary Red: `#c3202e`
- White: `#ffffff`

### Typography
- Headlines (H1-H3): ArmaliteRifle (red, uppercase)
- Subheads (H4-H6): UglyQua (red)
- Body: Work Sans (black)
- Navigation/Buttons: UglyQua

### Key Files
- Banner: `/uploads/2025/09/LexAlarmBanner8.svg`
- Custom Fonts: `/themes/kadence/fonts/`
  - `armalite_rifle.ttf`
  - `UglyQua.ttf`
  - `UglyQuaItalic.ttf`

---

## 📊 PLUGIN REQUIREMENTS

### Currently Installed
- Kadence Blocks
- MC4WP (Mailchimp)
- WPCode Lite
- Tockify (Events)

### To Install
- [ ] WooCommerce (for signs)
- [ ] Printify integration plugin
- [ ] Social media feed plugin (TBD)
- [ ] Form plugin for volunteers (or use WPForms)
- [ ] Analytics tracking (Plausible or alternative)

### Potential Premium Upgrades
- [ ] Kadence Pro ($149/year) - if advanced features needed
- [ ] Social feed plugin (~$49-99/year)
- [ ] Advanced forms plugin (if needed)

---

## 📝 NOTES & REMINDERS

### Content Strategy
- Website as "Dynamic Hub" for all activities
- Reduce friction for volunteers
- Make sign ordering prominent
- Integrate all communication channels
- Keep navigation simple (6 items max)

### User Experience Goals
- One-click volunteer signup
- Easy sign ordering process
- Clear event visibility
- Fresh, updated content
- Mobile-first design

### Testing Checklist
- [x] Desktop responsiveness (1200px+)
- [x] Tablet responsiveness (768-1024px)
- [x] Mobile responsiveness (<768px)
- [ ] Cross-browser compatibility
- [ ] Form submissions
- [ ] Payment processing
- [ ] Calendar functionality
- [ ] Social media links
- [ ] Newsletter signup flow
- [ ] Volunteer registration flow
- [ ] Shop checkout process

---

## 🔄 REVISION HISTORY

| Date | Update | By |
|------|--------|-----|
| 2025-09-08 | Added comprehensive shop, volunteer, news, and social media specifications | Current |
| 2025-09-08 | Completed: About page with Vision/Mission statements | Current |
| 2025-09-08 | Updated: Events page complete with Tockify, Footer complete, SVG banner tested | Current |
| 2025-09-08 | Created master tracker, established working directory | System |
| 2024-09 | Stage 1 structure complete | Previous work |

---

## 📞 TECHNICAL RESOURCES

- **Hosting Support:** Bluehost
- **Theme Documentation:** Kadence
- **Calendar System:** Tockify
- **E-commerce:** WooCommerce + Printify
- **Email Marketing:** Mailchimp
- **Development URL:** `https://bpx.ela.mybluehost.me/website_97a098b6/`

---

## 📈 ANALYTICS & TRACKING

### Page Tracking Options
1. **Plausible.io** (Current account available)
   - [ ] Install Plausible WordPress plugin
   - [ ] Configure tracking code
   - [ ] Set up custom events (sign orders, volunteer signups)
   - [ ] Create goals/conversions
   - Privacy-focused, GDPR compliant
   - Lightweight script (~1KB)

2. **Alternative Options**
   - Google Analytics (free, more features, privacy concerns)
   - Matomo (self-hosted option)
   - Fathom Analytics (similar to Plausible)
   - WordPress built-in Site Stats (basic)

### Key Metrics to Track
- [ ] Page views and unique visitors
- [ ] Traffic sources (social, direct, search)
- [ ] Most visited pages
- [ ] Sign order conversions
- [ ] Volunteer form completions
- [ ] Newsletter signup rates
- [ ] Event page engagement
- [ ] Average session duration
- [ ] Bounce rate
- [ ] Mobile vs desktop usage

### Implementation Steps
1. [ ] Choose analytics platform (recommend Plausible since account exists)
2. [ ] Install tracking plugin/code
3. [ ] **Set up Google Analytics (GA4)**
   - [ ] Create GA4 property for lexingtonalarm.org
   - [ ] Install Google Site Kit plugin or add GA4 code to header
   - [ ] Configure goals for conversions (sign orders, volunteer signups)
   - [ ] Set up custom events tracking
4. [ ] Configure custom events:
   - Form submissions
   - Button clicks (CTAs)
   - Shop interactions
   - Social media clicks
5. [ ] Set up dashboard for team access
6. [ ] Create monthly reporting template
7. [ ] **Configure Email Campaign Tracking**
   - [ ] Enable Google Analytics tracking in Mailchimp automations
   - [ ] Add UTM parameters to email links
   - [ ] Set up campaign naming conventions
   - [ ] Create email performance dashboard in GA4

---

## 🎯 SUCCESS METRICS (Post-Launch)

- [ ] Newsletter subscriber growth
- [ ] Volunteer signups per week
- [ ] Sign orders processed
- [ ] Event attendance tracking
- [ ] Social media engagement
- [ ] Site traffic analytics (via Plausible)
- [ ] Conversion rates for key actions

---

*This file should be updated regularly as migration progresses. All team members should reference this as the single source of truth for migration status.*