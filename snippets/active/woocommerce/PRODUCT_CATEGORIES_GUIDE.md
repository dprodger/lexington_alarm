# Product Categories & Classifications Guide
## Lexington Alarm WooCommerce Store

**Last Updated:** October 2025  
**Purpose:** Define product categories for proper email handling and fulfillment routing

---

## Overview

All products in the Lexington Alarm store fall into one of three primary categories that determine how orders are fulfilled and how email notifications are handled.

---

## Category Definitions

### 1. **DONATION Products**
**Purpose:** Simple monetary donations with no physical fulfillment

**Characteristics:**
- No physical product
- No shipping or pickup required
- Instant confirmation only

**Email Handling:**
- Subject Line: `[DONATION]`
- No fulfillment instructions needed
- Simple thank you message

**Category Settings:**
- WooCommerce Category: "Donations"
- Category Slug: `donations`
- Shipping: Virtual product (no shipping)

**Examples:**
- General donation ($10, $25, $50, $100)
- Monthly sustaining donation
- Memorial or tribute donation

---

### 2. **LOCAL PICKUP Products**
**Purpose:** Physical items available for 24/7 porch pickup in Lexington area

**Characteristics:**
- Physical product
- No shipping - pickup only
- Coordinator handles delivery to porch pickup location
- Available 24/7
- Primarily for local residents

**Email Handling:**
- Subject Line: `[LOCAL PICKUP]`
- Email includes: "You'll receive pickup instructions via email within 24 hours"
- Coordinator notification sent
- No tracking number

**Category Settings:**
- WooCommerce Category: "Local Pickup"
- Category Slug: `local-pickup`
- Shipping Class: "Local Pickup Only"
- Tax: Exempt (as 501c3)

**Examples:**
- 18" x 24" Yard Sign (single) - SKU: LEX-YS-1824
- 22" x 28" Rally Sign - SKU: LEX-DS-2228
- Any product when customer selects "Local Pickup" shipping method

**Pickup Zones Covered:**
Lexington, Concord, Cambridge, Arlington, Belmont, Watertown, Waltham, Newton, Lincoln, Bedford, Burlington, Winchester, Woburn, Medford

---

### 3. **SHIPPING Products**
**Purpose:** Physical items that will be mailed/shipped to customer

**Characteristics:**
- Physical product
- Requires packaging and shipping
- Ships next business day
- USPS tracking provided
- Available nationwide

**Email Handling:**
- Subject Line: `[SHIPPING]`
- Email includes: "Your order will ship by the next business day"
- Tracking number added when label is generated
- Shippo integration for labels

**Category Settings:**
- WooCommerce Category: "Shipping"
- Category Slug: `shipping` or `shippable-items`
- Shipping Class: "Shippable Items"
- Weight/dimensions required for rate calculation

**Examples:**
- 12" x 18" Window Sign (mailer format) - SKU: LEX-WS-1218
- 5 Yard Sign Pack - SKU: LEX-YS-5PK
- 10 Yard Sign Pack - SKU: LEX-YS-10PK
- 15 Yard Sign Pack - SKU: LEX-YS-15PK
- 25 Yard Sign Pack - SKU: LEX-YS-25PK

**Shipping Boxes:**
- Small (1-5 signs): First Class Package or Priority Mail Small Flat Rate
- Medium (10-15 signs): Priority Mail Medium Flat Rate
- Large (25 signs): Priority Mail Large Flat Rate

---

## How Categories Are Determined

The order fulfillment type is determined by checking (in priority order):

1. **Product Category Assignment**
   - Primary category assigned to product in WooCommerce
   - Category slug is checked first

2. **Shipping Method Selected**
   - If customer selects "Local Pickup" at checkout → LOCAL PICKUP
   - If customer selects any other shipping method → SHIPPING

3. **Shipping Class Assignment**
   - Shipping class on product (backup check)
   - "Local Pickup Only" → LOCAL PICKUP
   - "Shippable Items" → SHIPPING

4. **Virtual Product Flag**
   - If product is marked "Virtual" → DONATION (no shipping)

---

## Email Subject Line Rules

### Current Implementation
Email subjects automatically prefixed based on category:

```
[DONATION] New order #{order_number}
[LOCAL PICKUP] New order #{order_number}
[SHIPPING] New order #{order_number}
```

### Priority Logic
If an order contains **multiple categories** (rare but possible):

1. DONATION takes priority (if donation + anything else)
2. LOCAL PICKUP takes priority over SHIPPING
3. SHIPPING is default if no other category found

**Example:** An order with 1 donation + 2 yard signs = `[DONATION]` prefix

---

## Setting Up Products

### When Adding New Products

**For Local Pickup Products:**
1. Assign category: "Local Pickup"
2. Set shipping class: "Local Pickup Only"
3. Enter weight/dimensions for inventory
4. Product not marked as virtual

**For Shipping Products:**
1. Assign category: "Shipping"
2. Set shipping class: "Shippable Items"
3. **Must enter accurate weight** for rate calculation
4. **Must enter dimensions** for box selection
5. Product not marked as virtual

**For Donation Products:**
1. Assign category: "Donations"
2. Check "Virtual" product checkbox
3. Check "Downloadable" (optional, for tax receipt)
4. No weight/dimensions needed
5. No shipping class needed

---

## Testing Product Classification

### Test URL Format
```
yourdomain.com/?test_category_labels=true&order_id=XXX
```

This will show:
- All products in the order
- Categories assigned to each
- Shipping classes
- What email prefix would be used

### Manual Check
1. Go to order in WooCommerce admin
2. Check order notes for "Category Debug" entry
3. Verify correct category shown for each product

---

## Common Issues & Solutions

### Issue: Product not showing correct category prefix

**Check:**
1. Is product assigned to correct category?
2. Is category slug spelled correctly? (lowercase, hyphens not underscores)
3. If using shipping method detection, did customer select the right method?

**Fix:**
1. Edit product → Categories → Check proper category
2. Edit product → Shipping → Set shipping class
3. Clear WooCommerce cache: WooCommerce → Status → Tools → Clear cache

### Issue: Mixed orders showing wrong prefix

**Scenario:** Order has both pickup and shipping items  
**Current Behavior:** Shows one prefix based on priority (pickup > shipping)  
**Future Enhancement:** Could add "[MIXED ORDER]" prefix for these cases

---

## WPCode Snippet Integration

The category detection system is implemented via WPCode snippets:

**Snippet 1:** `01_category_email_labels_FIXED.php`
- Adds [DONATION], [LOCAL PICKUP], or [SHIPPING] to email subjects
- Checks multiple data sources for accuracy
- Includes debug logging

**Snippet 2:** `02_shipping_messages.php`
- Adds fulfillment info to thank you page
- Adds info boxes to email bodies
- Shows "Ships next business day" or pickup instructions

**Snippet 3:** (Planned) `04_coordinator_routing.php`
- Routes local pickup orders to rotating coordinator
- Manages coordinator schedule
- Sends pickup location instructions

---

## Future Enhancements

### Potential Additional Categories

**BULK ORDERS**
- Orders of 50+ signs
- Requires special handling
- Direct shipping from printer vs porch pickup

**PRE-ORDER**
- Items not yet in stock
- Different fulfillment timeline
- Requires special messaging

**EVENT PICKUP**
- Signs for specific event (rally, booth)
- Pickup at event location
- Specific coordinator handling

---

## Quick Reference

| Category | Email Prefix | Ships? | Pickup? | Tracking? |
|----------|-------------|--------|---------|-----------|
| Donation | [DONATION] | No | No | No |
| Local Pickup | [LOCAL PICKUP] | No | Yes | No |
| Shipping | [SHIPPING] | Yes | No | Yes |

---

**For Questions:** Check TROUBLESHOOTING_GUIDE.md in woocommerce_snippets folder
