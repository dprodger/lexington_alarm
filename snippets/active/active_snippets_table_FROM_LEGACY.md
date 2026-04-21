# Lexington Alarm - Active WPCode Snippets Reference

**Site:** lexingtonalarm.org  
**Last Updated:** October 20, 2025  
**Platform:** WordPress with WooCommerce

---

## Active Snippets Overview

| # | Snippet Name | Status | Primary Function | Impact Area |
|---|--------------|--------|------------------|-------------|
| 1 | Admin Email Subject - Shipping/Pickup Labels | ✅ Active | Adds order type labels to admin email subjects | Admin Notifications |
| 2 | Validate Local Pickup Items | ✅ Active | Shows cart/checkout notices for local pickup items | Customer Experience |
| 3 | Shop Page Category Grid | ✅ Active | Custom shop page layout | Shop Display |
| 4 | Plausible Analytics | ✅ Active | Privacy-friendly analytics tracking | Site Analytics |
| 5 | Newsletter List 2025 | ✅ Active | Displays newsletter archive with shortcode | Content Display |
| 6 | Current Newsletter Display | ✅ Active | Shows current newsletter | Content Display |
| 7 | Blog Post Search | ✅ Active | Custom blog search functionality | Content Search |
| 8 | Export Page HTML | ✅ Active | Page export utility | Development Tool |
| 9 | News Shortcodes | ✅ Active | Custom shortcodes for news section | Content Display |
| 10 | Front End News System | ✅ Active | News display and management | Content Display |
| 11 | Shop Header Customization | ✅ Active | Custom shop page header styling | Shop Display |
| 12 | Local Pickup Handler | ✅ Active | Manages local pickup checkout process | Checkout Process |
| 13 | Shipping or Pickup Label (Customer Email) | ✅ Active | Adds shipping/pickup info to customer emails | Customer Notifications |
| 15 | Donation Handler Complete | ⛔ **DISABLED** | Simple product donation selector (not compatible) | N/A - Keep Disabled |
| 16 | Lexington Custom Donation Handler | ⛔ **DISABLED** | Variable product donation handler (not needed) | N/A - Keep Disabled |

---

## Detailed Snippet Functions

### 1. Admin Email Subject - Shipping/Pickup Labels
**Status:** ✅ Active (Recently Updated)  
**File Reference:** See artifacts in conversation  
**Function:** Modifies the subject line of admin "New Order" emails

**What It Does:**
- Detects donation orders by SKU (`Lex-Donation`) or product name
- Checks shipping methods to determine fulfillment type
- Adds appropriate prefix to email subject:
  - `[DONATION]` - for donation products
  - `[SHIPPING]` - for orders with standard shipping
  - `[LOCAL PICKUP]` - for local pickup orders
  - `[MIXED: SHIPPING + PICKUP]` - for orders with both

**Priority:** High - Critical for order processing workflow

**Recent Changes:**
- Updated 10/20/2025 to detect donations by SKU for variable products
- Fixed "UNCATEGORIZED" issue

---

### 2. Validate Local Pickup Items
**Status:** ✅ Active  
**Function:** Cart and checkout validation for local pickup items

**What It Does:**
- Displays prominent notices on cart page for local pickup items
- Shows blue/red styled notice on checkout page when cart contains pickup-only items
- Lists which items are pickup vs. shipping
- Shows pickup location (Lexington Visitor Center address)
- Warns about mixed orders (pickup + shipping)

**Key Features:**
- Checks product shipping class (`local-pickup-only`)
- Different notices for pickup-only vs. mixed orders
- Styled with brand colors (#044f9d blue, #c3202e red)

**Priority:** Medium - Important for customer clarity

---

### 3. Shop Page Category Grid
**Status:** ✅ Active  
**Function:** Unknown - custom shop page layout (code not provided in conversation)

**Priority:** Medium - Visual/UX enhancement

---

### 4. Plausible Analytics
**Status:** ✅ Active  
**Function:** Privacy-focused analytics tracking

**What It Does:**
- Integrates Plausible Analytics (GDPR-compliant alternative to Google Analytics)
- Likely adds tracking script to site header

**Priority:** Low - Analytics only, no customer-facing impact

---

### 5. Newsletter List 2025
**Status:** ✅ Active  
**File Reference:** Document #9  
**Function:** Displays archived newsletters using shortcode

**What It Does:**
- Provides `[newsletter_list]` shortcode
- Displays newsletter archive with:
  - Red header with "NEWSLETTER ARCHIVE" title
  - List of newsletters with titles and dates
  - Links to view in browser (Mailchimp archive)
  - Email icon (📧) for each entry
  - Dividers between entries
- Responsive design with mobile breakpoints

**Usage:** Add `[newsletter_list]` to any page

**Priority:** Low - Content display only

---

### 6. Current Newsletter Display
**Status:** ✅ Active  
**Function:** Unknown - likely displays most recent newsletter (code not provided)

**Priority:** Low - Content display only

---

### 7. Blog Post Search
**Status:** ✅ Active  
**Function:** Unknown - custom blog search (code not provided)

**Priority:** Low - Search functionality

---

### 8. Export Page HTML
**Status:** ✅ Active  
**Function:** Unknown - development/admin tool (code not provided)

**Priority:** Low - Development utility

---

### 9. News Shortcodes
**Status:** ✅ Active  
**Function:** Unknown - custom shortcodes for news (code not provided)

**Priority:** Low - Content display

---

### 10. Front End News System
**Status:** ✅ Active  
**Function:** Unknown - news management system (code not provided)

**Priority:** Medium - Content management

---

### 11. Shop Header Customization
**Status:** ✅ Active  
**Function:** Unknown - custom shop styling (code not provided)

**Priority:** Low - Visual enhancement

---

### 12. Local Pickup Handler
**Status:** ✅ Active  
**File Reference:** Document #10  
**Function:** Manages checkout process for local pickup orders

**What It Does:**
- **Removes shipping address fields** when only local pickup is available
- Forces local pickup items to behave like virtual products (no shipping needed)
- Simplifies billing fields for pickup orders (makes address optional)
- Updates city field label to "Your Town"
- Adds checkout notice with pickup instructions
- **Adds printable pickup checklist to admin emails** with:
  - Customer name, phone, email, town
  - Order items and quantities
  - Checkbox for pickup confirmation
  - Date/time fields

**Key Logic:**
- Checks product shipping class for `local_pickup`
- Disables `woocommerce_cart_needs_shipping()` for pickup-only carts
- Only affects admin emails, not customer emails

**Priority:** High - Critical for pickup order workflow

---

### 13. Shipping or Pickup Label (Customer Email)
**Status:** ✅ Active  
**File Reference:** Documents #3 and #4 (identical code - only one instance active)  
**Function:** Adds shipping/pickup information to customer emails

**What It Does:**
- Adds fulfillment info to thank you page after checkout
- Adds messages to customer order confirmation emails (processing & completed)
- Shows different messages for:
  - **Shipping orders:** "Ships next business day" with tracking info notice
  - **Local pickup:** Pickup instructions and 24/7 porch pickup availability
- Adds fulfillment info to cart items ("Ships next business day" or "Local pickup")
- Displays checkout notice with fulfillment information

**Detection Method:**
- Checks product categories for "shipping" or "pickup" keywords
- Also checks shipping methods selected at checkout

**Styling:**
- Blue boxes for shipping info (#e8f4f8 background, #044f9d border)
- Red boxes for pickup info (#f8e8e8 background, #c3202e border)

**⚠️ Note:** Code appears in two documents but only one snippet instance is active

**Priority:** High - Customer communication

---

### 15. Donation Handler Complete ⛔ DISABLED
**Status:** ⛔ Currently Disabled (Keep Disabled)  
**File Reference:** Document #11  
**Function:** Donation amount selector for SIMPLE products

**What It Does:**
- Adds dropdown selector with preset donation amounts ($5-$250)
- Allows custom "other amount" with minimum $5
- Updates price dynamically as user selects amount
- Saves donation amount to cart and order
- Hides quantity selector (forces quantity = 1)
- Hides price display on product page
- Customizes cart messages

**Why Disabled:**
- Designed for SIMPLE products only
- Current donation product is VARIABLE product with $5 variations
- Not compatible with current setup
- Would cause conflicts if enabled

**Keep disabled** unless donation product is converted to simple type

**Priority:** N/A - Incompatible with current setup

---

### 16. Lexington Custom Donation Handler ⛔ DISABLED
**Status:** ⛔ Currently Disabled  
**File Reference:** Document #6  
**Function:** Custom donation amount for variable products

**What It Does:**
- Shows custom field for entering "$5 units" (e.g., 14 units = $70)
- Appears when "Other Amount" variation is selected
- Calculates total dynamically
- Updates variation price based on quantity entered

**Why Disabled:**
- Current variable product setup with fixed variations ($5, $10, $25, etc.) works fine
- This snippet adds unnecessary complexity
- Not needed for current donation workflow

**Priority:** N/A - Not needed with current setup

---

## Cleanup Recommendations

### High Priority
1. ✅ **COMPLETED:** Fixed "UNCATEGORIZED/DONATION" email subject issue
2. ✅ **COMPLETED:** Updated donation detection to work with variable products

### Medium Priority
4. **Document remaining snippets:** Get code for snippets #3, 6, 7, 8, 9, 10, 11 to complete this reference

### Low Priority
5. **Review disabled snippets:** Confirm "Donation Handler Complete" and "Custom Donation Handler" can be permanently deleted if not needed in future

---

## Snippet Dependencies

### Order Processing Workflow
```
Customer Places Order
        ↓
[Admin Email Subject] - Adds [DONATION]/[SHIPPING]/[PICKUP] label
        ↓
[Local Pickup Handler] - Adds pickup checklist to admin email (if pickup)
        ↓
[Shipping/Pickup Label] - Adds fulfillment info to customer email
```

### Critical Snippets (Do Not Disable)
- Admin Email Subject - Shipping/Pickup Labels
- Local Pickup Handler
- One of the Shipping/Pickup Label snippets (customer emails)

### Safe to Disable
- Donation Handler Complete (incompatible)
- Lexington Custom Donation Handler (not needed)
- One duplicate Shipping/Pickup Label snippet

---

## Testing Checklist

When making changes to snippets, test these scenarios:

- [ ] Regular product with shipping
- [ ] Regular product with local pickup
- [ ] Donation (variable product)
- [ ] Mixed cart (shipping + pickup)
- [ ] Admin email subject labels
- [ ] Customer email content
- [ ] Checkout page notices
- [ ] Cart page notices

---

## Notes

**Brand Colors Used in Snippets:**
- Primary Blue: `#044f9d`
- Primary Red: `#c3202e`
- Light Blue Background: `#e8f4f8`
- Light Red Background: `#f8e8e8` or `#fef5f5`

**Common Product Detection Methods:**
- Product name (string matching)
- Product SKU (exact match - most reliable)
- Product categories (slug/name matching)
- Shipping class (local_pickup, ships-nationwide, etc.)
- Shipping method at checkout

---

**Document Version:** 1.0  
**Created:** October 20, 2025  
**Next Review:** After any snippet changes or WooCommerce updates