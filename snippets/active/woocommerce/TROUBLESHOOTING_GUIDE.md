# WooCommerce Email Category Labels - Troubleshooting Guide
**Date:** October 5, 2024
**Issue:** [SHIPPING] category label not appearing in order email subjects

---

## PROBLEM DIAGNOSIS

The category email labels snippet isn't working because:

1. **Product Categories May Not Be Properly Assigned**
   - The product needs to be in a category named "Shipping" or with slug "shipping"
   - WordPress categories are case-sensitive in slugs

2. **Hook Timing Issues**
   - The email subject filters might be running before categories are fully loaded
   - WooCommerce caching might interfere

3. **Category Detection Logic**
   - Original snippet may be too strict in matching category names

---

## SOLUTION: FIXED SNIPPET

The new snippet (`01_category_email_labels_FIXED.php`) includes:

1. **Multiple Detection Methods:**
   - Checks product categories (both name and slug)
   - Checks shipping class as fallback
   - Checks selected shipping method
   - Uses partial string matching for flexibility

2. **Debug Features:**
   - Adds category info to order notes
   - Includes test URL for verification
   - Optional error logging

3. **Improved Logic:**
   - Case-insensitive matching
   - Handles variations (local-pickup, local_pickup, etc.)
   - Prevents duplicate prefixes

---

## INSTALLATION STEPS

### Step 1: Remove Old Snippet
1. Go to **WPCode > Code Snippets**
2. Find "Category Email Labels" snippet
3. Deactivate it
4. Delete it (or keep deactivated for reference)

### Step 2: Install Fixed Snippet
1. Go to **WPCode > Add Snippet**
2. Click **"Add Your Custom Code"**
3. Choose **"PHP Snippet"**
4. Name it: `Category Email Labels - Fixed`
5. Copy the entire code from `01_category_email_labels_FIXED.php`
6. Paste into code area (remove opening `<?php` if WPCode adds it)
7. Set **"Insert Method"** to **"Run Everywhere"**
8. Save and Activate

### Step 3: Verify Product Categories
1. Go to **Products > Categories**
2. Ensure you have these categories:
   - **Donation** (slug: `donation`)
   - **Local Pickup** (slug: `local-pickup`)
   - **Shipping** (slug: `shipping`)

3. Edit your "5-Pack Yard Signs" product:
   - Go to **Products > All Products**
   - Edit the product
   - In right sidebar under **"Product categories"**
   - Check the **"Shipping"** category
   - Update the product

### Step 4: Test the Fix
1. Place a test order with the 5-Pack Yard Signs
2. After order is placed, go to **WooCommerce > Orders**
3. Click on the new order
4. Check the **Order Notes** - you should see "Category Debug" info
5. Check your email - subject should start with `[SHIPPING]`

### Step 5: Use Test URL (Admin Only)
Test without placing an order:
```
https://yourdomain.com/?test_category_labels=true&order_id=554
```
(Replace 554 with any order number)

This will show:
- Products in the order
- Their categories and slugs
- Shipping classes
- What the email subject would be

---

## ADDING SHIPPING MESSAGES

### Install Shipping Messages Snippet
1. Go to **WPCode > Add Snippet**
2. Add new PHP snippet named: `Shipping Messages`
3. Copy code from `02_shipping_messages.php`
4. Set to "Run Everywhere"
5. Activate

This adds:
- Shipping notice on thank you page
- Shipping info in order emails
- Fulfillment info in cart
- General notice on checkout page

---

## VERIFICATION CHECKLIST

After installation, verify:

- [ ] Product is in correct category
- [ ] Category slug matches expected value
- [ ] Test order shows category in order notes
- [ ] Email subject includes [SHIPPING] prefix
- [ ] Thank you page shows shipping message
- [ ] Order email includes shipping notice
- [ ] Cart shows "Ships next business day"

---

## TROUBLESHOOTING

### If Category Labels Still Don't Work:

1. **Clear Caches**
   - Clear WordPress cache
   - Clear browser cache
   - Clear any CDN cache

2. **Check Category Assignment**
   ```sql
   -- Run in phpMyAdmin to verify category assignment
   SELECT p.post_title, t.name, t.slug 
   FROM wp_posts p
   JOIN wp_term_relationships tr ON p.ID = tr.object_id
   JOIN wp_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
   JOIN wp_terms t ON tt.term_id = t.term_id
   WHERE p.post_type = 'product' 
   AND tt.taxonomy = 'product_cat'
   AND p.ID = [PRODUCT_ID];
   ```

3. **Enable Debug Logging**
   In `wp-config.php`:
   ```php
   define('WP_DEBUG', true);
   define('WP_DEBUG_LOG', true);
   define('WP_DEBUG_DISPLAY', false);
   ```
   Then check `/wp-content/debug.log`

4. **Test Alternative Approach**
   If categories don't work, use shipping method only:
   - Local Pickup → [LOCAL PICKUP]
   - Flat Rate → [SHIPPING]
   - Free Shipping → [DONATION]

### If Shipping Messages Don't Appear:

1. **Check Email Template**
   - Some email templates override hooks
   - May need to add to different hook

2. **Test Plain Text vs HTML**
   - Switch email type in WooCommerce settings
   - Some servers block HTML emails

3. **Verify Hook Priority**
   - Change `10` to `5` or `15` in add_action calls
   - Some plugins interfere with default priority

---

## PRODUCTION CLEANUP

Before going live:

1. **Remove Debug Code**
   - Comment out or remove the `lexington_debug_order_categories` function
   - Remove the `lexington_test_category_labels` function
   - Remove error_log calls

2. **Optimize Performance**
   - Cache category lookups if high volume
   - Consider storing category in order meta

3. **Add Admin Settings**
   - Create settings page to toggle features
   - Allow customization of messages
   - Make prefixes configurable

---

## SUPPORT CONTACTS

- **WPCode Documentation:** https://wpcode.com/docs/
- **WooCommerce Hooks:** https://woocommerce.github.io/code-reference/
- **Debug Guide:** https://wordpress.org/support/article/debugging-in-wordpress/

---

## FILES PROVIDED

1. `01_category_email_labels_FIXED.php` - Main category labels snippet
2. `02_shipping_messages.php` - Shipping notices for pages/emails
3. This troubleshooting guide

Copy these to your WordPress via WPCode plugin as instructed above.