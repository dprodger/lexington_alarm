# Change Log - December 11, 2025

## Shopping Cart Fixes

### Issues Resolved

**Primary Issue:** Donation product showing shipping address fields at checkout

**Root Cause:** 
1. Variable product variations did not have "Virtual" checkbox checked
2. Local Pickup Handler snippet didn't account for virtual products

### Changes Made

#### 1. Donation Product Configuration
- **Product:** Donate to Lexington Alarm (ID: 596)
- **Action:** Checked "Virtual" checkbox on ALL variations
- **Result:** Donations no longer trigger shipping address fields

#### 2. Local Pickup Handler Snippet
- **Action:** Updated code to include `$product->is_virtual()` checks
- **Functions updated:**
  - `disable_shipping_for_pickup_and_virtual()`
  - `disable_shipping_address_for_virtual_and_pickup()`
  - `add_local_pickup_notice()`
- **Result:** Virtual products properly skip shipping logic

#### 3. Shop Header Customization Snippet
- **Issue:** PHP error from line break in `<img>` tag
- **Action:** Cleaned up HTML formatting
- **Result:** Snippet now activates without error

### Testing Completed

| Scenario | Result |
|----------|--------|
| Donation only | ✅ Pass |
| Local pickup only | ✅ Pass |
| Local pickup + donation | ✅ Pass |
| Shipped item only | ✅ Pass |
| Shipping + donation | ✅ Pass |
| Mixed pickup + shipped | ✅ Pass (error message shown) |

### Documentation Created

1. `02_Store_System/Shopping_Cart_Fixes_Dec2025.md` - Full issue documentation
2. `06_Code_Snippets/Local_Pickup_Handler.md` - Complete code reference
3. `06_Code_Snippets/WPCode_Active_Snippets.md` - Updated to v2.0

---

## Pending Items

### High Priority
- [ ] Fix admin email subject for mixed orders (show both [LOCAL PICKUP + DONATION])

### Medium Priority
- [ ] Review duplicate email snippets
- [ ] Delete duplicate Shop Header Customization snippet

### Future
- [ ] Cart page donation add-on feature (debugging needed)

---

**Session Duration:** ~2 hours  
**Next Session Focus:** Email subject fix, snippet cleanup
