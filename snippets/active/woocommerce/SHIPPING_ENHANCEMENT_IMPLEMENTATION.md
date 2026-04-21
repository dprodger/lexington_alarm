# Shipping Order Email Enhancement - Implementation Guide

**Date:** October 16, 2025  
**Issue:** Shipping orders (like the 5-pack) need clearer indication in email subjects  
**Solution:** Enhanced email prefixes and admin visibility

---

## The Problem

**Current Situation:**
- Order #838: 5-pack of signs (needs shipping)
- Email subject: `[Lexington Alarm!]: You've got a new order: #838`
- No indication this requires packing and mailing

**Desired Result:**
- Email subject: `[SHIPPING] [Lexington Alarm!]: You've got a new order: #838`
- Immediately clear this needs shipping action

---

## The Solution - Three Components

### 1. **Enhanced Email Subject Prefixes**
Adds clear category indicators to ALL order emails:
- `[SHIPPING]` - Needs to be packed and mailed
- `[LOCAL PICKUP]` - Arrange porch pickup  
- `[DONATION]` - No fulfillment needed

### 2. **Admin Dashboard Visual Indicators**
- New "Type" column in order list with color-coded badges
- Prominent notice box on order detail page for shipping orders
- Order type stored in order meta for easy filtering

### 3. **Clear Product Category System**
- Every product assigned to proper category
- Multiple detection methods (category, shipping method, shipping class)
- Priority system when orders have mixed types

---

## Implementation Steps

### Step 1: Install Enhanced Email Subject Snippet

1. **Log into WordPress Admin**
   - URL: `https://bpx.ela.mybluehost.me/website_97a098b6/wp-admin`

2. **Go to WPCode**
   - Navigate to: Snippets → Add New

3. **Create New Snippet**
   - Click "Add Your Custom Code"
   - Choose "PHP Snippet"
   - Title: "Enhanced Category Email Labels v2.1"

4. **Paste the Code**
   - Copy entire contents of: `01a_category_email_labels_ENHANCED.php`
   - Paste into code editor
   - If WPCode adds `<?php` automatically, remove the duplicate at the top

5. **Configure Settings**
   - Location: "Run Everywhere"
   - Status: Inactive (for now)
   - Click "Save Snippet"

6. **Deactivate Old Snippet**
   - Go to: Snippets → All Snippets
   - Find: "Category Email Labels - Fixed" (if it exists)
   - Click "Inactive"

7. **Activate New Snippet**
   - Go back to your new snippet
   - Click "Activate"

### Step 2: Verify Product Categories

**For Each Shipping Product:**

1. **Navigate to Products**
   - WooCommerce → Products

2. **Edit the 5-pack product** (and all bulk packs)
   - SKU: LEX-YS-5PK, LEX-YS-10PK, LEX-YS-15PK, LEX-YS-25PK
   - 12x18 Window Sign (LEX-WS-1218)

3. **Check/Set Categories**
   - In right sidebar: "Product categories"
   - **Ensure "Shipping" is checked** ✓
   - Uncheck any other categories (except maybe general ones)

4. **Check Shipping Class**
   - Scroll to "Shipping" section
   - Shipping class: Select "Shippable Items"

5. **Verify Weight/Dimensions**
   - These are needed for Shippo rate calculation
   - Weight: Enter in lbs
   - Dimensions: Length × Width × Height in inches

6. **Update Product**

### Step 3: Test the System

**Test URL Format:**
```
https://bpx.ela.mybluehost.me/website_97a098b6/?test_order_type=true&order_id=838
```

Replace `838` with any recent order number.

**What You'll See:**
- Current order type (SHIPPING, PICKUP, or DONATION)
- Shipping methods used
- Product categories detected
- Before/after email subject comparison

**Expected Results for Order #838:**
```
Original Subject: [Lexington Alarm!]: You've got a new order: #838
Modified Subject: [SHIPPING] [Lexington Alarm!]: You've got a new order: #838
```

### Step 4: Place Test Order

1. **Add 5-pack to cart**
2. **Choose shipping method** (not local pickup)
3. **Complete purchase** (test mode if available)
4. **Check email subject line** - should start with `[SHIPPING]`
5. **Check order in admin** - should show blue "SHIP" badge

---

## What Changes After Implementation

### Email Subjects

**Before:**
```
[Lexington Alarm!]: You've got a new order: #838
```

**After:**
```
[SHIPPING] [Lexington Alarm!]: You've got a new order: #838
```

### Admin Order List

You'll see a new "Type" column with color-coded badges:

| Order # | Type | Status | Total |
|---------|------|--------|-------|
| #838 | ⚠️ SHIP | Processing | $45.00 |
| #837 | PICKUP | Processing | $10.00 |
| #836 | DONATION | Completed | $25.00 |

### Order Detail Page

When viewing a shipping order, you'll see a prominent blue notice at the top:

```
┌─────────────────────────────────────────────────┐
│ 📦 SHIPPING ORDER - ACTION REQUIRED              │
│                                                   │
│ This order needs to be packed and mailed.        │
│ Timeline: Ship by next business day with tracking│
└─────────────────────────────────────────────────┘
```

---

## Product Category Assignments

### SHIPPING Category
**Products that should have this:**
- ✓ 12" x 18" Window Sign - Mailer Format (LEX-WS-1218)
- ✓ 5 Yard Sign Pack (LEX-YS-5PK)
- ✓ 10 Yard Sign Pack (LEX-YS-10PK)
- ✓ 15 Yard Sign Pack (LEX-YS-15PK)
- ✓ 25 Yard Sign Pack (LEX-YS-25PK)

**Why:** These products are designed to be mailed/shipped

### LOCAL PICKUP Category
**Products that should have this:**
- ✓ 18" x 24" Yard Sign - Single (LEX-YS-1824)
- ✓ 22" x 28" Rally Sign (LEX-DS-2228)

**Why:** These are bulky, local customers typically prefer pickup

**Note:** A customer CAN still choose shipping for these if they pay for it

### DONATION Category
**Products that should have this:**
- ✓ General Donation ($10, $25, $50, $100)
- ✓ Any "Virtual" products

**Why:** No physical fulfillment required

---

## How the System Decides

The snippet checks multiple data sources in this order:

1. **Shipping Method Selected by Customer**
   - "Local Pickup" → LOCAL PICKUP
   - Anything else with cost → SHIPPING

2. **Product Category Assignment**
   - Checks category slug and name

3. **Shipping Class**
   - Backup verification

4. **Virtual Product Flag**
   - Donations marked as virtual

5. **Priority Logic**
   - If order has multiple types: DONATION > PICKUP > SHIPPING

---

## Troubleshooting

### Issue: Email still doesn't show [SHIPPING] prefix

**Check:**
1. Is new snippet activated?
2. Is old snippet deactivated?
3. Is product in "Shipping" category?
4. Did customer select a shipping method?

**Debug:**
- Use test URL: `?test_order_type=true&order_id=XXX`
- Check WordPress error log
- Look for "Lexington Alarm - Order #XXX" entries

### Issue: Wrong prefix showing

**Most Common Cause:**
- Product in wrong category
- Shipping class not set

**Fix:**
- Edit product
- Categories: Check "Shipping"
- Shipping: Set "Shippable Items" class
- Update

### Issue: Multiple categories on one order

**Scenario:** Order has both pickup item and shipping item  
**Current Behavior:** Shows one prefix (highest priority)  
**Future:** Could show "[MIXED ORDER]"

---

## Future Enhancements

### Planned Additions:

1. **Order Filtering by Type**
   - Filter admin order list: "Show only SHIPPING orders"
   - Quick view of what needs to be mailed today

2. **Shippo Integration**
   - Auto-detect shipping orders
   - One-click label generation
   - Tracking number auto-added to emails

3. **Coordinator Auto-Routing**
   - LOCAL PICKUP orders email rotating coordinator
   - Automated porch pickup instructions
   - Coordinator schedule management

4. **Dashboard Widget**
   - "Orders awaiting shipment: 3"
   - "Orders for pickup: 5"
   - Quick action buttons

---

## Testing Checklist

Before going live, test:

- [ ] Place order for 5-pack with shipping
- [ ] Verify email subject has `[SHIPPING]` prefix
- [ ] Check order shows blue "SHIP" badge in admin
- [ ] Order detail page shows shipping notice
- [ ] Customer receives "ships next business day" message
- [ ] Place order for single sign with local pickup
- [ ] Verify email subject has `[LOCAL PICKUP]` prefix
- [ ] Check order shows red "PICKUP" badge
- [ ] Make a donation
- [ ] Verify email subject has `[DONATION]` prefix
- [ ] Check order shows green badge

---

## Files Reference

**Main Snippet:**
`/wordpress working files/woocommerce_snippets/01a_category_email_labels_ENHANCED.php`

**Documentation:**
- This file: `SHIPPING_ENHANCEMENT_IMPLEMENTATION.md`
- Category guide: `PRODUCT_CATEGORIES_GUIDE.md`
- Troubleshooting: `TROUBLESHOOTING_GUIDE.md`

**Related Snippets:**
- `02_shipping_messages.php` - Customer-facing messaging
- `03_simple_donation_complete.php` - Donation handling

---

## Support & Questions

**For Issues:**
1. Check error logs: `/wp-content/debug.log`
2. Use test URL to diagnose
3. Review product category assignments

**Common Commands:**
- Test: `?test_order_type=true&order_id=XXX`
- Clear cache: WooCommerce → Status → Tools → Clear transients

---

**Status:** Ready to implement  
**Priority:** High (affects daily operations)  
**Time Required:** 15-20 minutes

