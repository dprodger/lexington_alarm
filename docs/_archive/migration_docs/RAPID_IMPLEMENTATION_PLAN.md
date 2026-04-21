# RAPID IMPLEMENTATION PLAN - Lexington Alarm WordPress Site
## 4-Hour Work Blocks for Complete Site Launch

**Project Start Date:** ___________  
**Target Completion:** 20 hours total (5 blocks × 4 hours)  
**Site URL:** https://ozp.xka.mybluehost.me/

---

## BLOCK 1: Foundation Setup (4 hours)
**Goal:** Get email, forms, and custom code infrastructure working

### Hour 1-2: Plugin Installation & API Connections
- [ X] Install MC4WP plugin (5 min)
- [X ] Install WPCode plugin (5 min)
- [x ] Get Mailchimp API key from Mailchimp account
- [x ] Connect MC4WP to Mailchimp (test connection)
- [x ] Configure WP Mail SMTP (test email sending)
- [ X] Export custom code snippets from old site via WPCode

### Hour 3-4: Import & Test Critical Functions
- [ x] Import WPCode snippets to new site
- [ ] Test Tockify events display (verify it still works)
- [ ] Create first test form in WPForms (basic contact)
- [ ] Test form submission and email delivery
- [ ] Verify Mailchimp connection receives test subscriber

**✅ Deliverable:** Working email system, connected Mailchimp, imported custom code  
**Completed:** ___________

---

## BLOCK 2: Get Involved Page Complete (4 hours)
**Goal:** Fully functional volunteer recruitment page with all forms

### Hour 1-2: Create All Volunteer Forms
- [ ] Main Volunteer Form (name, email, phone, interests checkboxes)
- [ ] Tabling Signup Form (availability calendar, location preferences)
- [ ] Committee Interest Form (dropdown of committees, experience fields)
- [ ] Simple Newsletter Signup (email only)
- [ ] Discussion Group Form (email, topics of interest)

### Hour 3: Connect Forms to Mailchimp
- [ ] Map each form to Mailchimp lists/tags
- [ ] Set up segmentation (Volunteers, Tablers, Committee, Newsletter)
- [ ] Configure confirmation messages
- [ ] Set up notification emails to organizers

### Hour 4: Build Get Involved Page
- [ ] Add intro text and call to action
- [ ] Embed main volunteer form
- [ ] Create dropdown/tabs for specific forms
- [ ] Style with existing CSS classes
- [ ] Test all forms on desktop and mobile

**✅ Deliverable:** Complete Get Involved page with 5 working forms  
**Completed:** ___________

---

## BLOCK 3: News Page & Newsletter Integration (4 hours)
**Goal:** Complete news hub with newsletter display and archive

### Hour 1: Newsletter API Integration
- [ ] Write/adapt PHP snippet to pull latest Mailchimp campaign
- [ ] Create shortcode for latest newsletter display
- [ ] Write PHP function to pull newsletter archive list
- [ ] Create shortcode for archive display

### Hour 2: Build News Page Structure
- [ ] Create News category for posts
- [ ] Write first news post (current feature story)
- [ ] Add latest post display section
- [ ] Add newsletter display section (using shortcode)

### Hour 3: Newsletter Archive & Signup
- [ ] Implement archive list with dates and links
- [ ] Create dedicated newsletter signup form
- [ ] Add signup form to page
- [ ] Style all sections with existing CSS

### Hour 4: Photo Gallery Submenu
- [ ] Create Gallery page as child of News
- [ ] Upload initial photos
- [ ] Configure Kadence gallery blocks
- [ ] Create navigation between News and Gallery

**✅ Deliverable:** Complete News page with dynamic newsletter content  
**Completed:** ___________

---

## BLOCK 4: Order Signs/Shop Setup (4 hours)
**Goal:** Working e-commerce for sign orders

### Hour 1: WooCommerce Product Setup
- [ ] Install Payment Plugins for Stripe
- [ ] Connect Stripe account (test mode)
- [ ] Create product categories (Local Pickup, Delivery)
- [ ] Add 5-10 sign products with images and prices

### Hour 2: Configure Checkout
- [ ] Set up shipping zones (local delivery area)
- [ ] Configure local pickup option
- [ ] Set tax settings if needed
- [ ] Test checkout flow with test payment

### Hour 3: Build Order Signs Page
- [ ] Create product showcase layout
- [ ] Add featured signs with images
- [ ] Include clear pickup/delivery options
- [ ] Add "Add to Cart" buttons
- [ ] Link to shop/cart

### Hour 4: Shop Page & Printful
- [ ] Configure main Shop page layout
- [ ] Add section for Printful products
- [ ] Create "Shop More on Printful" button
- [ ] Test complete purchase flow
- [ ] Switch Stripe to live mode

**✅ Deliverable:** Working e-commerce with sign ordering  
**Completed:** ___________

---

## BLOCK 5: Home Page Dynamic Content & Testing (4 hours)
**Goal:** Complete home page with all dynamic elements

### Hour 1: Feature Block Setup
- [ ] Create "Featured" category or custom field
- [ ] Write PHP snippet to rotate/display featured content
- [ ] Create shortcode for feature display
- [ ] Add to home page

### Hour 2: Dynamic Events Section
- [ ] Write PHP to pull next 3-5 events from Tockify
- [ ] Create attractive event cards display
- [ ] Add "See All Events" link
- [ ] Test event updates

### Hour 3: Complete Home Page
- [ ] Add Order Signs CTA buttons
- [ ] Create photo gallery section
- [ ] Arrange all blocks in correct order
- [ ] Apply responsive styling
- [ ] Test on mobile devices

### Hour 4: Full Site Testing
- [ ] Test all forms submissions
- [ ] Verify email notifications
- [ ] Check Mailchimp list updates
- [ ] Test sign ordering and checkout
- [ ] Test all pages on mobile
- [ ] Fix any critical issues

**✅ Deliverable:** Complete, functional website ready for launch  
**Completed:** ___________

---

## COMPLETION SUMMARY

**Total Time:** 20 hours (5 blocks × 4 hours)

**Implementation Options:**
- 2.5 days (working 8 hours/day)
- 5 days (working 4 hours/day)  
- 1 week (working evenings/partial days)

### Final Launch Checklist
- [ ] All forms tested and working
- [ ] Email notifications confirmed
- [ ] Mailchimp integration verified
- [ ] Payment processing live
- [ ] Mobile responsive verified
- [ ] DNS updated to lexingtonalarm.org
- [ ] SSL certificate active
- [ ] Backup created

---

## CRITICAL RESOURCES NEEDED

### API Keys & Accounts
- [ ] Mailchimp API Key: ___________
- [ ] Stripe API Keys (Live): ___________
- [ ] SMTP Credentials: ___________
- [ ] Tockify Calendar Name: lexingtonalarm

### Plugin List
**Already Installed:**
- ✅ WPForms
- ✅ WPForms Mailchimp
- ✅ WP Mail SMTP
- ✅ WooCommerce

**To Install:**
- [ ] MC4WP: Mailchimp for WordPress
- [ ] WPCode
- [ ] Payment Plugins for Stripe WooCommerce

---

## NOTES & ISSUES LOG

**Block 1 Issues:**
_____________________

**Block 2 Issues:**
_____________________

**Block 3 Issues:**
_____________________

**Block 4 Issues:**
_____________________

**Block 5 Issues:**
_____________________

---

**Project Manager:** ___________  
**Last Updated:** ___________