# WooCommerce Store Setup - Lexington Alarm
**Date:** September 2024  
**Status:** Initial Setup Phase Complete  
**URL:** https://bpx.ela.mybluehost.me/website_97a098b6/

---

## Current Setup Status

### ✅ Completed Items

#### 1. WooCommerce Installation
- Successfully installed WooCommerce plugin
- Basic configuration completed
- Store location: Lexington, MA
- Currency: USD
- Tax settings: Configured for Massachusetts (6.25% or tax-exempt status TBD)

#### 2. Product Template Established
**Standard Product Format:**
- Consistent description structure across all products
- Historical context linking to 1775
- Product details section
- "Perfect For" use cases
- 250th Anniversary tie-in
- Availability information

**Brand Messaging:**
- "Resist Tyranny! Support the Rule of Law"
- Historical connection to Lexington Alarm of 1775
- Thomas Paine quote: "In America the Law is King"
- Focus on defending democracy and constitutional rights

#### 3. Products Created (3 of 7)

**Product 1: 18" x 24" Yard Sign - Double-Sided**
- SKU: LEX-YS-1824
- Weight: 0.84 lbs
- Shipping Class: Local Pickup Only
- Features: Weather-resistant coroplast with metal H-stake
- Messaging: "No King! No Tyranny" / Thomas Paine quote

**Product 2: 12" x 18" Window Sign - Mailer Format**
- SKU: LEX-WS-1218
- Weight: ~0.2 lbs
- Shipping Class: Shippable Items
- Features: Folds to 9"x12" for first-class mail
- Target: Apartments, dorms, offices, gift-giving

**Product 3: 22" x 28" Rally Sign - Large Format Foldable**
- SKU: LEX-DS-2228
- Weight: ~0.5 lbs
- Shipping Class: Pickup Preferred
- Features: Foldable design for demonstrations/events
- Note: Requires edge taping for weather resistance

#### 4. Shipping Zones Configured

**Zone 1: Local Pickup Area**
- Free 24/7 porch pickup
- Zip codes covered: Lexington, Concord, Cambridge, Arlington, Belmont, Watertown, Waltham, Newton, Lincoln, Bedford, Burlington, Winchester, Woburn, Medford
- Rotating coordinator system planned

**Zone 2: National Shipping**
- Currently set with flat rate (temporary)
- Awaiting Shippo integration

#### 5. Shop Page Structure
- Shop page created as "Order Signs"
- Added to primary navigation menu
- Currently showing products (duplicate display issue to fix)

---

## Immediate Next Steps

### 🔲 Product Images
- [ ] Upload actual product photos for all three products
- [ ] Required images per product:
  - Main product shot (front)
  - Back side view
  - In-use/yard display photo
  - Size reference with stake
- [ ] Image specifications: 1200x1200px preferred
- [ ] Placeholder images created, need replacement with actual photos

### 🔲 Remaining Products to Add
- [ ] 5 Yard Sign Pack (SKU: LEX-YS-5PK)
- [ ] 10 Yard Sign Pack (SKU: LEX-YS-10PK)
- [ ] 15 Yard Sign Pack (SKU: LEX-YS-15PK)
- [ ] 25 Yard Sign Pack (SKU: LEX-YS-25PK)
- Consider: Variable product vs individual products for bulk packs

### 🔲 Shippo Integration
- [ ] Install Shippo for WooCommerce plugin
- [ ] Connect Shippo API
- [ ] Configure package sizes:
  - Small box (1-5 signs)
  - Medium box (10-15 signs)
  - Large box (25 signs)
- [ ] Set up carrier accounts (USPS, UPS, FedEx)
- [ ] Configure live rate calculation
- [ ] Test label generation
- [ ] Set up tracking email automation

### 🔲 Payment Processing
- [ ] Configure PayPal
  - Set up PayPal Standard or PayPal Checkout
  - Enter PayPal business email
  - Test in sandbox mode first
- [ ] Consider Stripe integration
  - Install Stripe for WooCommerce
  - Connect Stripe account
  - Enable credit card processing

### 🔲 Porch Pickup System
- [ ] Implement rotating coordinator system
- [ ] Add coordinator email routing
- [ ] Create pickup instruction emails
- [ ] Set up coordinator notification system
- [ ] Options:
  - Custom code solution (free)
  - WooCommerce Local Pickup Plus ($79/year)

---

## Technical Issues to Address

### Cart/Checkout Optimization
1. **Duplicate Product Display**
   - Shop page showing products twice
   - Check for duplicate `[products]` shortcode
   - Verify WooCommerce shop page settings

2. **Checkout Field Customization**
   - Local pickup orders don't need full address
   - Still want to collect town for records
   - Options:
     - Custom code to hide fields conditionally
     - Checkout Field Editor plugin
     - Simple messaging approach

3. **Cart Page Styling**
   - Need to apply Lexington Alarm branding
   - Add custom CSS for buttons and colors
   - Include pickup/shipping messaging

---

## Configuration Parameters

### Store Settings
```
Store Address: Lexington, MA 02420
Currency: USD ($)
Weight Unit: lbs
Dimension Unit: inches
Enable Coupons: Yes (for bulk discounts)
Tax Status: TBD (501c3 exempt or 6.25% MA tax)
```

### Shipping Classes
```
1. Local Pickup Only - Single yard signs
2. Shippable Items - Mailers, bulk packs
3. Pickup Preferred - Demonstration signs
```

### Product Pricing Structure (TBD)
```
Single yard sign: $XX
12x18 mailer: $XX
22x28 demo sign: $XX
5-pack: $XX (discount per unit)
10-pack: $XX (deeper discount)
15-pack: $XX
25-pack: $XX (best value)
```

---

## Future Enhancements

### Phase 2 - After Launch
- [ ] Add Printify integration for merchandise
- [ ] Implement quantity-based discounts
- [ ] Create customer accounts/portal
- [ ] Add order tracking page
- [ ] Set up abandoned cart recovery
- [ ] Implement review/testimonial system

### Marketing Integration
- [ ] Google Analytics setup
- [ ] Facebook Pixel (if desired)
- [ ] SEO optimization for products
- [ ] Social sharing buttons

---

## Testing Checklist Before Launch

- [ ] Test complete purchase flow (local pickup)
- [ ] Test complete purchase flow (shipped)
- [ ] Verify email notifications work
- [ ] Test on mobile devices
- [ ] Check cart calculations
- [ ] Verify shipping rates with Shippo
- [ ] Test payment processing
- [ ] Review all product descriptions
- [ ] Verify coordinator rotation system
- [ ] Test with real addresses (local and distant)

---

## Resource Links

- WordPress Admin: https://bpx.ela.mybluehost.me/website_97a098b6/wp-admin
- Shop Page: https://bpx.ela.mybluehost.me/website_97a098b6/order-signs
- WooCommerce Settings: /wp-admin/admin.php?page=wc-settings
- Shippo Dashboard: https://goshippo.com
- Theme Customizer: /wp-admin/customize.php

---

**Next Session Focus:** Product images, Shippo integration, and bulk product setup