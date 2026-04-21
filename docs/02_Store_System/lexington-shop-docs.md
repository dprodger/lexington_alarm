# Lexington Alarm Shop Page Configuration

**Last Updated:** October 15, 2025  
**Site:** lexingtonalarm.org  
**WooCommerce Version:** Current  
**Theme:** Kadence

---

## Overview

The Lexington Alarm shop page features a custom two-tier category grid system that clearly separates products by fulfillment method (local pickup vs shipping), making it easy for customers to find what they need.

---

## Shop Page Structure

### Visual Layout

```
╔═══════════════════════════════════════════════════════════╗
║         LOCAL PICKUP ITEMS (RED TEXT + BLUE LINE)         ║
╠═══════════════╦═══════════════╦═══════════════╗
║  Yard Signs   ║    Buttons    ║Window Sign    ║
║     Local     ║               ║   Mailers     ║
║      (2)      ║      (1)      ║      (1)      ║
╚═══════════════╩═══════════════╩═══════════════╝

╔═══════════════════════════════════════════════════════════════════╗
║      SHIPPED ITEMS & DONATIONS (BLUE TEXT + RED LINE)             ║
╠═══════════════╦═══════════════╦═══════════════╦═══════════════╗
║  Yard Signs   ║Window Sign Pk ║   Buttons     ║   Donation    ║
║   Shipped     ║   Shipped     ║  5-Pack Ship  ║               ║
║      (1)      ║      (1)      ║      (1)      ║      (1)      ║
╚═══════════════╩═══════════════╩═══════════════╩═══════════════╝

[Standard product grid continues below...]
```

---

## Categories Configuration

### Local Pickup Categories

#### 1. Yard Signs - Local Pickup
- **Slug:** `yard_signs_local`
- **Description:** Individual yard signs for local pickup in any quantity
- **Products:** 
  - 18″ x 24″ Yard Sign
  - 22″ x 28″ Rally Sign
- **Thumbnail:** Yard sign image
- **Count:** 2 products

#### 2. Buttons
- **Slug:** `buttons`
- **Description:** Buttons – local pickup only
- **Products:**
  - No King! No Tyranny! Buttons (Variable: Single $2.50 or 5-Pack $10)
- **Thumbnail:** Button image
- **Count:** 1 product (variable)

#### 3. Window Sign Mailers
- **Slug:** `mailers_local`
- **Description:** Window Sign Mailers for local Pickup. You mail yourself.
- **Products:**
  - 12″ x 18″ Window Sign – Single
- **Thumbnail:** Window sign image
- **Count:** 1 product
- **Special:** Customers can choose pickup OR shipping at checkout

---

### Shipped Items Categories

#### 4. Yard Signs - Shipped
- **Slug:** `yard_signs_shipped`
- **Description:** Package of 5 Lexington Alarm! Yard Signs with 10 X 30 inch stakes, shipping included in price
- **Products:**
  - 5 Pack for Shipping 18″ x 24″ Yard Sign
- **Thumbnail:** 5-pack yard sign image
- **Count:** 1 product
- **Price:** $80.00 (includes shipping)

#### 5. Window Sign Pack - Shipped
- **Slug:** `mailers_shipped`
- **Description:** Package of window sign/mailers shipped priority mail via USPS
- **Products:**
  - 5 Pack 12″ x 18″ Window Sign
- **Thumbnail:** Window sign pack image
- **Count:** 1 product
- **Price:** $35.00 (includes shipping)

#### 6. Buttons-5-pack-shipped
- **Slug:** `buttons-5-pack-shipped`
- **Description:** 5-pack commemorative buttons shipped nationwide
- **Products:**
  - Pack Buttons for Shipment
- **Thumbnail:** Button pack image
- **Count:** 1 product
- **Price:** $20.00 (includes shipping)

#### 7. Donation
- **Slug:** `donation`
- **Description:** Donations from website
- **Products:**
  - Donate to Lexington Alarm (Variable: $10, $25, $50, $100, Other Amount)
- **Thumbnail:** Logo/flag image
- **Count:** 1 product (variable)
- **Type:** Virtual (no shipping)

---

## Products Configuration

### Product #568: 18″ x 24″ Yard Sign
- **SKU:** LEX-YS-18X24
- **Price:** $10.00
- **Type:** Simple Product
- **Category:** Yard Signs - Local Pickup
- **Shipping Class:** Local Pickup Only
- **Status:** In stock

### Product #686: 22″ x 28″ Rally Sign
- **SKU:** LEX-DS-2228
- **Price:** $10.00
- **Type:** Simple Product
- **Category:** Yard Signs - Local Pickup
- **Shipping Class:** Local Pickup Only
- **Status:** In stock

### Product #685: 12″ x 18″ Window Sign – Single
- **SKU:** LEX-WS-1218
- **Price:** $5.00
- **Type:** Simple Product
- **Category:** Window Sign Mailers (mailers_local)
- **Shipping Class:** Pickup or Ship
- **Status:** In stock
- **Special:** Customers choose pickup (free) or shipping ($5 flat rate)

### Product #781: 5 Pack Window Signs
- **SKU:** LEX-WS-1218-1
- **Price:** $35.00
- **Type:** Simple Product
- **Category:** Window Sign Pack - Shipped
- **Shipping Class:** Ships Nationwide
- **Status:** In stock

### Product #796: Pack Buttons for Shipment
- **SKU:** Lexbut-5-ship
- **Price:** $20.00
- **Type:** Simple Product
- **Category:** Buttons-5-pack-shipped
- **Shipping Class:** Ships Nationwide
- **Status:** In stock

### Product #787: No King! No Tyranny! Buttons (Variable)
- **Price Range:** $2.50 - $10.00
- **Type:** Variable Product
- **Category:** Buttons
- **Status:** In stock

**Variations:**
- **Single Button:** $2.50, Shipping Class: Local Pickup Only
- **5-Pack:** $10.00, Shipping Class: Local Pickup Only

### Product #596: Donate to Lexington Alarm (Variable)
- **SKU:** Lex-Donation
- **Price Range:** $5.00 - $100.00
- **Type:** Variable Product
- **Category:** Donation
- **Status:** In stock

**Variations:**
- $10 → Price: $10, Virtual: Yes
- $25 → Price: $25, Virtual: Yes
- $50 → Price: $50, Virtual: Yes
- $100 → Price: $100, Virtual: Yes
- Other Amount → Price: $5 (base), Virtual: Yes, Uses quantity multiplier

### Product #553: 5 Pack Yard Signs for Shipping
- **SKU:** 18X24-S
- **Price:** $80.00
- **Type:** Simple Product
- **Category:** Yard Signs - Shipped
- **Shipping Class:** Ships Nationwide
- **Status:** In stock

---

## Shipping Classes Configuration

### Local Pickup Only
- **Used for:**
  - Individual yard signs
  - Single buttons
  - 5-pack buttons (local)
- **Checkout behavior:** Only "Local Pickup" option appears

### Pickup or Ship
- **Used for:**
  - Individual window sign mailers
- **Checkout behavior:** Customer chooses between "Local Pickup (Free)" or "USPS Shipping ($5.00)"

### Ships Nationwide
- **Used for:**
  - 5-pack yard signs
  - 5-pack mailers
  - 5-pack buttons (shipped)
- **Checkout behavior:** Only "USPS Shipping" option appears

### Virtual
- **Used for:**
  - Donation products
- **Checkout behavior:** No shipping required

---

## Shipping Methods Configuration

**WooCommerce → Settings → Shipping → United States**

### Local Pickup
- **Method title:** "Local Pickup - Lexington, MA"
- **Cost:** Free
- **Available for shipping classes:**
  - Local Pickup Only
  - Pickup or Ship

### USPS Flat Rate Shipping
- **Method title:** "USPS Shipping"
- **Cost:** $5.00
- **Available for shipping classes:**
  - Pickup or Ship
  - Ships Nationwide

---

## Code Implementation

### Code Snippets Plugin

**Snippet Name:** Shop Page Category Grid  
**Location:** Snippets → Shop Page Category Grid  
**Type:** PHP snippet  
**Run:** Everywhere  
**Status:** Active

**Code:**

```php
add_action('woocommerce_before_shop_loop', 'lexington_alarm_shop_categories', 5);
function lexington_alarm_shop_categories() {
    if (is_shop()) {
        ?>
        <!-- LOCAL PICKUP SECTION -->
        <div style="text-align: center; margin: 40px 0 30px;">
            <h2 style="color: #c3202e; font-family: 'UglyQua', 'Arial Black', sans-serif; font-size: 2.2em; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 15px;">LOCAL PICKUP ITEMS</h2>
            <div style="width: 200px; height: 4px; background: #044f9d; margin: 0 auto;"></div>
        </div>
        
        <div class="woocommerce columns-3">
            <ul class="products columns-3">
                <?php
                // LOCAL PICKUP categories
                $pickup_slugs = array('yard_signs_local', 'buttons', 'mailers_local');
                
                foreach ($pickup_slugs as $slug) {
                    $category = get_term_by('slug', $slug, 'product_cat');
                    if ($category && !is_wp_error($category)) {
                        $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                        $image = wp_get_attachment_url($thumbnail_id);
                        $cat_link = get_term_link($category);
                        ?>
                        <li class="product-category product">
                            <a href="<?php echo esc_url($cat_link); ?>">
                                <?php if ($image) : ?>
                                    <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($category->name); ?>" />
                                <?php else : ?>
                                    <img src="<?php echo wc_placeholder_img_src(); ?>" alt="<?php echo esc_attr($category->name); ?>" />
                                <?php endif; ?>
                                <h2 class="woocommerce-loop-category__title">
                                    <?php echo esc_html($category->name); ?>
                                    <mark class="count">(<?php echo esc_html($category->count); ?>)</mark>
                                </h2>
                            </a>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
        </div>

        <div style="height: 60px; clear: both;"></div>

        <!-- SHIPPED ITEMS SECTION -->
        <div style="text-align: center; margin: 40px 0 30px;">
            <h2 style="color: #044f9d; font-family: 'UglyQua', 'Arial Black', sans-serif; font-size: 2.2em; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 15px;">SHIPPED ITEMS & DONATIONS</h2>
            <div style="width: 200px; height: 4px; background: #c3202e; margin: 0 auto;"></div>
        </div>
        
        <div class="woocommerce columns-4">
            <ul class="products columns-4">
                <?php
                // SHIPPED categories
                $shipped_slugs = array('yard_signs_shipped', 'mailers_shipped', 'buttons-5-pack-shipped', 'donation');
                
                foreach ($shipped_slugs as $slug) {
                    $category = get_term_by('slug', $slug, 'product_cat');
                    if ($category && !is_wp_error($category)) {
                        $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                        $image = wp_get_attachment_url($thumbnail_id);
                        $cat_link = get_term_link($category);
                        ?>
                        <li class="product-category product">
                            <a href="<?php echo esc_url($cat_link); ?>">
                                <?php if ($image) : ?>
                                    <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($category->name); ?>" />
                                <?php else : ?>
                                    <img src="<?php echo wc_placeholder_img_src(); ?>" alt="<?php echo esc_attr($category->name); ?>" />
                                <?php endif; ?>
                                <h2 class="woocommerce-loop-category__title">
                                    <?php echo esc_html($category->name); ?>
                                    <mark class="count">(<?php echo esc_html($category->count); ?>)</mark>
                                </h2>
                            </a>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
        </div>

        <hr style="margin: 40px 0; border: 0; border-top: 3px solid #044f9d; clear: both;">
        <?php
    }
}
```

---

## Brand Colors Used

- **Primary Red:** `#c3202e` - Used for "LOCAL PICKUP ITEMS" header
- **Primary Blue:** `#044f9d` - Used for "SHIPPED ITEMS & DONATIONS" header and dividers
- **White:** `#ffffff` - Background
- **Font:** UglyQua (brand font for headers)

---

## Customer Experience Flow

### Scenario 1: Customer Wants Individual Yard Sign (Local Pickup)
1. Customer sees "LOCAL PICKUP ITEMS" section
2. Clicks "Yard Signs - Local Pickup"
3. Selects individual sign ($10)
4. At checkout: Only sees "Local Pickup - Lexington, MA (Free)"
5. Order email shows: "Shipping Method: Local Pickup"

### Scenario 2: Customer Wants Bulk Signs (Shipping)
1. Customer sees "SHIPPED ITEMS & DONATIONS" section
2. Clicks "Yard Signs - Shipped"
3. Selects 5-pack ($80)
4. At checkout: Only sees "USPS Shipping ($5.00)" - but shipping already included in price
5. Order email shows: "Shipping Method: USPS Shipping" with address

### Scenario 3: Customer Wants Mailers (Flexible)
1. Customer sees "LOCAL PICKUP ITEMS" section
2. Clicks "Window Sign Mailers"
3. Selects single mailer ($5)
4. At checkout: Sees BOTH options:
   - Local Pickup - Free
   - USPS Shipping - $5.00
5. Customer chooses preferred method

### Scenario 4: Customer Wants to Donate
1. Customer sees "SHIPPED ITEMS & DONATIONS" section
2. Clicks "Donation"
3. Selects amount ($10, $25, $50, $100, or Other Amount)
4. At checkout: No shipping options (virtual product)
5. Completes donation

---

## Order Notification Emails

### Admin Email (store@lexingtonalarm.org)

**Configuration:**
- **WooCommerce → Settings → Emails → New order**
- **Recipient:** store@lexingtonalarm.org
- **Enabled:** Yes

**Email Content Includes:**
- Order number
- Customer details
- **Shipping Method:** (Clearly shows Local Pickup or USPS Shipping)
- Products ordered
- Totals
- Pickup location (if local pickup) or shipping address (if shipped)

This allows immediate identification of fulfillment method needed.

---

## Maintenance Notes

### Adding New Products

**For Local Pickup Products:**
1. Create product
2. Set appropriate category (yard_signs_local, buttons, or mailers_local)
3. Set shipping class: "Local Pickup Only" or "Pickup or Ship"
4. Product automatically appears in correct grid section

**For Shipped Products:**
1. Create product
2. Set appropriate category (yard_signs_shipped, mailers_shipped, buttons-5-pack-shipped)
3. Set shipping class: "Ships Nationwide"
4. Product automatically appears in shipped section

### Adding New Categories

**If adding a new category to the grid:**
1. Create category in Products → Categories
2. Add thumbnail image
3. Edit Code Snippet: Add category slug to appropriate array
   - `$pickup_slugs` for local pickup section
   - `$shipped_slugs` for shipped section
4. Update column count if needed (currently 3 for pickup, 4 for shipped)

### Troubleshooting

**Categories not showing:**
- Check category slug matches exactly in code
- Verify category has products assigned
- Check Code Snippet is activated

**Wrong categories appearing:**
- Verify product assigned to correct category
- Check shipping class is set correctly

**Images not displaying:**
- Confirm category thumbnail is uploaded
- Check image file exists in Media Library

**Shipping options incorrect:**
- Verify product shipping class
- Check WooCommerce shipping methods configuration
- Ensure shipping zones are set up correctly

---

## Future Enhancements

### Possible Additions:
- Add category images hover effects
- Include category descriptions below images
- Add "Quick View" functionality
- Implement Ajax cart for faster shopping
- Add product count badges
- Include "Most Popular" indicators

### Considerations:
- All 8 products currently fit well in existing structure
- Grid is mobile-responsive via Kadence theme
- Can accommodate additional products without code changes
- New categories require code update in snippet

---

## Dependencies

**Required Plugins:**
- WooCommerce (core)
- Code Snippets (for custom grid code)
- Payment Plugins for Stripe WooCommerce (payment processing)

**Theme:**
- Kadence Theme (provides responsive grid support)

**External Services:**
- Stripe (store@lexingtonalarm.org account)
- Bluehost hosting

---

## Related Documentation

- [Website Stage 1 Documentation](Website_Stage_1-Lexington_Alarm_WordPress_Development.md)
- [Events Page Documentation](Events_Page_documentation.txt)
- Stripe Payment Configuration (see conversation history)
- Domain Mapping System (temporary - remove after migration)

---

**Document Version:** 1.0  
**Date:** October 15, 2025  
**Next Review:** After site migration to lexingtonalarm.org