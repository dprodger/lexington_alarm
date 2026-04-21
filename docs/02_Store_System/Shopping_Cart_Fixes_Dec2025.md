# Shopping Cart Fixes - December 2025

**Date:** December 11, 2025  
**Issue:** Donation product requiring shipping address at checkout  
**Status:** ✅ RESOLVED

---

## Problem Summary

The donation product was displaying shipping address fields at checkout even though donations are virtual products that don't require shipping.

### Root Causes Identified

1. **Virtual checkbox not checked on variations** - The donation product is a variable product, and each variation needs the "Virtual" checkbox checked individually
2. **Local Pickup Handler snippet** - The shipping logic wasn't accounting for virtual products, causing any product without `local_pickup` shipping class to trigger shipping fields

---

## Fixes Applied

### Fix 1: Donation Product Configuration

**Location:** Products → Donate to Lexington Alarm (ID: 596)

**Action:** Checked the "Virtual" checkbox on ALL variations:
- $5 variation → ✅ Virtual checked
- $10 variation → ✅ Virtual checked
- $25 variation → ✅ Virtual checked
- $50 variation → ✅ Virtual checked
- Other Amount variation → ✅ Virtual checked

**Important:** For variable products, Virtual must be set on EACH variation, not just the parent product.

### Fix 2: Local Pickup Handler Snippet Updated

**Location:** WPCode → Local Pickup Handler

**Change:** Added `$product->is_virtual()` checks to skip virtual products in shipping calculations.

Key functions updated:
- `disable_shipping_for_pickup_and_virtual()` - Now skips virtual products
- `disable_shipping_address_for_virtual_and_pickup()` - Now skips virtual products
- `add_local_pickup_notice()` - Only shows pickup notice for physical pickup items

### Fix 3: Shop Header Customization

**Location:** WPCode → Shop Header Customization

**Issue:** Line break in `<img>` tag was causing PHP error

**Action:** Cleaned up HTML to remove line break in img tag attributes

---

## Test Results - All Passing ✅

| Scenario | Shipping Fields | Result |
|----------|-----------------|--------|
| Donation only | None | ✅ Works |
| Local pickup only | None (pickup notice shown) | ✅ Works |
| Local pickup + donation | None (pickup notice shown) | ✅ Works |
| Shipped item only | Address fields shown | ✅ Works |
| Shipping + donation | Address fields shown | ✅ Works |
| Mixed pickup + shipped | Error message (not allowed) | ✅ Works |

---

## Current Active Snippets (Shopping)

| Snippet | Status | Function |
|---------|--------|----------|
| Local Pickup Handler | ✅ Active | Manages checkout fields, pickup notices, admin email checklist |
| Validate Local Pickup Items | ✅ Active | Shows notices on cart/checkout for pickup items |
| Shop Page Category Grid | ✅ Active | Custom shop page layout |
| Admin Email Subject Labels | ✅ Active | Adds [DONATION]/[SHIPPING]/[PICKUP] to email subjects |
| Add Category to New Order Email | ✅ Active | May be duplicate - review needed |
| Custom Mixed Cart Error Message | ✅ Active | Replaces generic "no shipping" error |
| Prevent Mixed Cart Checkout | ✅ Active | Blocks pickup + shipped mixed orders |
| Shop Header Customization | ✅ Active | Custom header with images on shop page |

### Disabled Snippets (Keep Disabled)

| Snippet | Reason |
|---------|--------|
| Donation Handler Complete | For simple products - not compatible with current variable product setup |
| Custom Donation Handler | Not needed with current variable product setup |
| Shipping or Pickup Label | Inactive - review if needed |

---

## Next Steps

### High Priority

1. **Fix Admin Email Subject for Mixed Orders**
   - Currently shows only [DONATION] for pickup + donation orders
   - Should show [LOCAL PICKUP + DONATION]
   - Need to review and update "Admin Email Subject Labels" snippet

### Medium Priority

2. **Snippet Cleanup**
   - Delete duplicate "Shop Header Customization" snippet
   - Review if "Add Category to New Order Email" duplicates "Admin Email Subject Labels"
   - Review if "Shipping or Pickup Label" adds value

3. **Cart Page Donation Add-On (Future)**
   - Feature requested: Show donation option on cart page for physical product orders
   - Snippet created but hook not firing - needs debugging
   - Not critical - can revisit later

### Low Priority

4. **Documentation**
   - Update WPCode_Active_Snippets.md with current status
   - Document final snippet configurations

---

## Key Learnings

1. **Variable products require Virtual on each variation** - Setting shipping class to "virtual" is NOT the same as checking the Virtual checkbox

2. **Snippet order matters** - Filters with priority 99 run after others, useful for overriding default behavior

3. **Test all scenarios** - Donation-only, pickup-only, shipped-only, and all combinations need individual testing

---

## Local Pickup Handler - Complete Code Reference

See: `/Users/jtsackton/Desktop/LexingtonAlarm_Docs/06_Code_Snippets/Local_Pickup_Handler.md`

---

**Document Version:** 1.0  
**Last Updated:** December 11, 2025
