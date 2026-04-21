# Lexington Alarm - Active WPCode Snippets Reference

**Site:** lexingtonalarm.org  
**Last Updated:** December 27, 2025  
**Platform:** WordPress with WooCommerce

---

## Active Snippets Overview

| # | Snippet Name | Status | Primary Function | Impact Area |
|---|--------------|--------|------------------|-------------|
| 1 | Admin Email Subject Labels | ✅ Active | Adds [DONATION]/[SHIPPING]/[PICKUP] to admin email subjects | Admin Notifications |
| 2 | Add Category to New Order Email | ✅ Active | May duplicate #1 - review needed | Admin Notifications |
| 3 | Validate Local Pickup Items | ✅ Active | Shows cart/checkout notices for local pickup items | Customer Experience |
| 4 | Shop Page Category Grid | ✅ Active | Custom shop page layout | Shop Display |
| 5 | Shop Header Customization | ✅ Active | Custom header with images on shop page | Shop Display |
| 6 | Local Pickup Handler | ✅ Active | Manages checkout fields, pickup notices, admin checklist | Checkout Process |
| 7 | Custom Mixed Cart Error Message | ✅ Active | Replaces generic "no shipping" error | Customer Experience |
| 8 | Prevent Mixed Cart Checkout | ✅ Active | Blocks mixed pickup + shipped orders | Cart Validation |
| 9 | Plausible Analytics | ✅ Active | Privacy-friendly analytics tracking | Site Analytics |
| 10 | Newsletter List 2025 | ✅ Active | Displays newsletter archive with shortcode | Content Display |
| 11 | Current Newsletter Display | ✅ Active | Shows current newsletter | Content Display |
| 12 | Blog Post Search | ✅ Active | Custom blog search functionality (vanilla JS, no jQuery) | Content Search |
| 13 | Export Page HTML | ✅ Active | Page export utility | Development Tool |
| 14 | News Shortcodes | ✅ Active | Custom shortcodes for news section | Content Display |
| 15 | Front End News System | ✅ Active | News display and management | Content Display |
| 16 | Performance - Disable WordPress Emoji | ✅ Active | Removes emoji scripts/styles | Performance |
| 17 | Performance - YouTube Lite Embed v2 | ✅ Active | Lazy-loads YouTube videos | Performance |
| 18 | Performance - Conditional Tockify Loading | ✅ Active | Blocks Tockify on non-events pages | Performance |
| 19 | Performance - Conditional WooCommerce Assets | ✅ Active | Loads WC only on shop pages | Performance |
| 20 | Performance - Preconnect Resource Hints | ✅ Active | DNS preconnect for external resources | Performance |
| 21 | Performance - Cleanup Redundant Scripts | ✅ Active | Removes unnecessary WP head elements | Performance |
| 22 | Feature - Upcoming Events Widget v2 | ✅ Active | Cached events shortcode | Content Display |

### Disabled Snippets (Keep Disabled)

| Snippet Name | Status | Reason |
|--------------|--------|--------|
| Donation Handler Complete | ⛔ Disabled | For simple products only - incompatible with variable donation product |
| Custom Donation Handler | ⛔ Disabled | Not needed with current variable product setup |
| Shipping or Pickup Label | ⛔ Disabled | Review if needed for customer emails |

---

## Shopping Cart Snippets - Detailed

### Local Pickup Handler
**Status:** ✅ Active  
**Updated:** December 11, 2025  
**Full Code:** See `06_Code_Snippets/Local_Pickup_Handler.md`

**What It Does:**
- Removes shipping fields for virtual products (donations)
- Removes shipping fields for local pickup products
- Shows pickup notice at checkout (for physical pickup items only)
- Simplifies billing fields (makes address optional for pickup)
- Adds printable pickup checklist to admin emails

**Key Functions:**
| Function | Purpose |
|----------|---------|
| `disable_shipping_for_pickup_and_virtual()` | Returns false for virtual/pickup-only carts |
| `disable_shipping_address_for_virtual_and_pickup()` | Skips address requirement for virtual/pickup |
| `add_local_pickup_notice()` | Shows pickup info (not for donations) |
| `add_pickup_checklist_to_admin_email()` | Adds checklist to admin emails |

---

### Validate Local Pickup Items
**Status:** ✅ Active

**What It Does:**
- Displays notices on cart/checkout for local pickup items
- Shows pickup location (Lexington Visitor Center)
- Warns about mixed orders

---

### Prevent Mixed Cart Checkout
**Status:** ✅ Active

**What It Does:**
- Blocks checkout when cart contains BOTH local pickup AND shipped items
- Shows error message with instructions to remove one type

---

### Custom Mixed Cart Error Message
**Status:** ✅ Active

**What It Does:**
- Replaces generic "no shipping available" WooCommerce error
- Shows clear message about mixed cart restrictions

---

## Email Snippets

### Admin Email Subject Labels
**Status:** ✅ Active

**What It Does:**
- Adds prefix to admin order email subjects:
  - `[DONATION]` - for donation products
  - `[SHIPPING]` - for shipped orders
  - `[LOCAL PICKUP]` - for pickup orders

**Known Issue:** Mixed orders (pickup + donation) may show only one label. Fix pending.

### Add Category to New Order Email
**Status:** ✅ Active

**Note:** May duplicate Admin Email Subject Labels. Review needed.

---

## Tested Scenarios (December 2025)

| Scenario | Status | Notes |
|----------|--------|-------|
| Donation only | ✅ Works | No shipping fields |
| Local pickup only | ✅ Works | Pickup notice shown |
| Local pickup + donation | ✅ Works | Pickup notice shown |
| Shipped item only | ✅ Works | Shipping fields shown |
| Shipping + donation | ✅ Works | Shipping fields shown |
| Mixed pickup + shipped | ✅ Works | Error message blocks checkout |

---

## Configuration Requirements

### Donation Product (ID: 596)
- **Type:** Variable product
- **Each variation must have:** ✅ Virtual checkbox checked
- **Shipping class:** Not required (Virtual overrides)

### Local Pickup Products
- **Shipping class:** `local_pickup`
- **Virtual:** Not checked (physical items)

### Shipped Products
- **Shipping class:** `ships_nationwide` or similar
- **Virtual:** Not checked (physical items)

---

## Next Steps

### High Priority
1. **Fix email subject for mixed orders** - Show [LOCAL PICKUP + DONATION] not just [DONATION]
2. **Review duplicate email snippets** - Check if both #1 and #2 are needed

### Medium Priority
3. **Delete duplicate Shop Header Customization** if one exists
4. **Review Shipping or Pickup Label** snippet for customer emails

### Future Enhancement
5. **Cart page donation add-on** - Feature to add donations from cart page (debugging needed)

---

## Brand Colors Used in Snippets

- Primary Blue: `#044f9d`
- Primary Red: `#c3202e`
- Light Blue Background: `#e8f4f8`
- Light Red Background: `#f8e8e8`

---

---

## Performance Snippets (Added December 27, 2025)

See full documentation: `06_Code_Snippets/Performance_Optimization_Snippets.md`

**Results:** 63% reduction in page requests (92 → 34)

| Snippet | Impact |
|---------|--------|
| Disable WordPress Emoji | -2 requests |
| YouTube Lite Embed v2 | -22 YouTube requests |
| Conditional Tockify Loading | -10 Tockify requests |
| Conditional WooCommerce Assets | -9 WC requests, blocks Stripe on home |
| Preconnect Resource Hints | Faster external connections |
| Cleanup Redundant Scripts | Cleaner HTML, better caching |
| Upcoming Events Widget v2 | Replaces Tockify widget with cached HTML |

---

**Document Version:** 3.0  
**Created:** October 20, 2025  
**Last Updated:** December 27, 2025
