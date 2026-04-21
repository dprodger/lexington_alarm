# Shop Page - Current Working Code
**Last Updated:** December 3, 2025  
**Status:** ✅ RESOLVED - Working 2x2 grid layout with mobile stacking  
**Page:** Main shop landing/sorting page (`/browse-products/`)

---

## Solution Summary

**Problem:** Custom HTML grid CSS was being overridden by Kadence theme, causing cards to stack vertically on all screen sizes.

**Solution:** Use Kadence Row Layout blocks to control the grid structure, with Custom HTML blocks inside each column for the card content. This lets Kadence handle responsive behavior while preserving custom card styling.

**Result:** 
- 2x2 grid on desktop
- Single column stack on mobile (below 768px)
- Header, footer, navigation all preserved
- Cards display exactly as designed

---

## Page Structure (Using Kadence Blocks)

```
┌─────────────────────────────────────────────┐
│  Custom HTML Block: Hero Section            │
│  (Full width, page title disabled)          │
├─────────────────────────────────────────────┤
│  Kadence Row Layout Block (2 columns)       │
│  ┌──────────────┐  ┌──────────────┐         │
│  │ Custom HTML  │  │ Custom HTML  │         │
│  │ Local Pickup │  │ Nationwide   │         │
│  │              │  │ Shipping     │         │
│  └──────────────┘  └──────────────┘         │
├─────────────────────────────────────────────┤
│  Kadence Row Layout Block (2 columns)       │
│  ┌──────────────┐  ┌──────────────┐         │
│  │ Custom HTML  │  │ Custom HTML  │         │
│  │ Merchandise  │  │ Donate       │         │
│  │              │  │              │         │
│  └──────────────┘  └──────────────┘         │
├─────────────────────────────────────────────┤
│  Custom HTML Block: Footer Notice           │
└─────────────────────────────────────────────┘
```

---

## Kadence Page Settings

**Important:** These settings must be configured on the page:
- **Page Title:** Disabled (custom hero replaces it)
- **Page Layout:** Full Width recommended
- **Content Style:** Unboxed or Fullwidth

---

## Kadence Row Layout Settings

For each Row Layout block:
- **Columns:** 2 (50/50 split)
- **Max Width:** ~1100px
- **Alignment:** Center
- **Inner Column Gap:** ~25px
- **Mobile Behavior:** Automatic stacking (default)

---

## HTML Code Blocks

### Hero Section (Custom HTML Block)

```html
<div style="background-color: #044f9d; color: white; padding: 15px 20px; margin: 30px 20px 30px 20px; text-align: center;">
    <h1 style="color: white; margin-bottom: 8px;">SHOP LEXINGTON ALARM</h1>
    <p style="font-size: 18px; max-width: 800px; margin: 0 auto; color: white;">
        Choose your shopping method below. Items cannot be mixed - please shop each category separately.
    </p>
</div>
```

**Notes:**
- Square corners (no border-radius)
- 30px top margin for white space below header
- Compact padding (15px) to minimize height
- 20px side margins for visual breathing room

---

### Card 1: Local Pickup (Row 1, Left Column)

```html
<div style="border: 3px solid #044f9d; border-radius: 8px; padding: 25px 20px; text-align: center;">
    <h2 style="color: #c3202e; margin-bottom: 15px; font-size: 22px;">🏠 LOCAL PICKUP</h2>
    
    <img src="https://lexingtonalarm.org/wp-content/uploads/2025/09/Law_is_King.webp" alt="Yard Sign" style="max-width: 150px; height: auto; margin: 0 auto 15px; display: block; border: 2px solid #ddd;">
    
    <p style="font-size: 15px; margin-bottom: 12px; line-height: 1.5;">
        <strong>24/7 Porch Pickup • Free</strong><br>
        Available: Yard Signs, Window Signs, Buttons
    </p>
    
    <p style="font-size: 13px; color: #666; margin-bottom: 20px;">
        Pick up anytime within 8 miles of Lexington, MA
    </p>
    
    <a href="/shop/local-pickup/" style="display: inline-block; background-color: #044f9d; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-family: 'UglyQua', sans-serif; font-size: 16px; border: 2px solid white;">
        SHOP LOCAL PICKUP
    </a>
</div>
```

---

### Card 2: Nationwide Shipping (Row 1, Right Column)

```html
<div style="border: 3px solid #c3202e; border-radius: 8px; padding: 25px 20px; text-align: center;">
    <h2 style="color: #c3202e; margin-bottom: 15px; font-size: 22px;">📦 NATIONWIDE SHIPPING</h2>
    
    <img src="https://lexingtonalarm.org/wp-content/uploads/2025/10/20250510-IMG_8342.webp" alt="Shipped Items" style="max-width: 150px; height: auto; margin: 0 auto 15px; display: block; border: 2px solid #ddd;">
    
    <p style="font-size: 15px; margin-bottom: 12px; line-height: 1.5;">
        <strong>Ships Anywhere in USA • Shipping Included</strong><br>
        Available: Sign Packs, Button Packs, Window Mailers
    </p>
    
    <p style="font-size: 13px; color: #666; margin-bottom: 20px;">
        We ship signs via UPS and stand alone button orders via USPS priority Mail. Delivery in 2-4 days. Buttons purchased with signs are included in the same package at a discounted price.
    </p>
    
    <a href="/shop/shipped-items/" style="display: inline-block; background-color: #c3202e; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-family: 'UglyQua', sans-serif; font-size: 16px; border: 2px solid white;">
        SHOP SHIPPED ITEMS
    </a>
</div>
```

---

### Card 3: Merchandise (Row 2, Left Column)

```html
<div style="border: 3px solid #044f9d; border-radius: 8px; padding: 25px 20px; text-align: center;">
    <h2 style="color: #c3202e; margin-bottom: 15px; font-size: 22px;">👕 MERCHANDISE</h2>
    
    <img src="https://lexingtonalarm.org/wp-content/uploads/2025/10/unisex-garment-dyed-heavyweight-t-shirt-midnight-front-68fd4763b902e.webp" alt="Merchandise" style="max-width: 150px; height: auto; margin: 0 auto 15px; display: block; border: 2px solid #ddd;">
    
    <p style="font-size: 15px; margin-bottom: 12px; line-height: 1.5;">
        <strong>Custom Printed • Ships Direct</strong><br>
        Available: T-Shirts, Hoodies, Tote Bags, and more
    </p>
    
    <p style="font-size: 13px; color: #666; margin-bottom: 20px;">
        Made-to-order, ships within 3-7 business days
    </p>
    
    <a href="/shop/printful-merchandise/" style="display: inline-block; background-color: #044f9d; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-family: 'UglyQua', sans-serif; font-size: 16px; border: 2px solid white;">
        SHOP MERCHANDISE
    </a>
</div>
```

---

### Card 4: Donate (Row 2, Right Column)

```html
<div style="border: 3px solid #c3202e; border-radius: 8px; padding: 25px 20px; text-align: center;">
    <h2 style="color: #c3202e; margin-bottom: 15px; font-size: 22px;">❤️ DONATE</h2>
    
    <img src="https://lexingtonalarm.org/wp-content/uploads/2025/09/Law_is_King.webp" alt="Donate to Lexington Alarm" style="max-width: 150px; height: auto; margin: 0 auto 15px; display: block; border: 2px solid #ddd;">
    
    <p style="font-size: 15px; margin-bottom: 12px; line-height: 1.5;">
        <strong>Support Our Mission • Any Amount</strong><br>
        Help defend democracy and constitutional rights
    </p>
    
    <p style="font-size: 13px; color: #666; margin-bottom: 20px;">
        100% of donations fund our organizing efforts
    </p>
    
    <a href="/product/donate-to-lexington-alarm/" style="display: inline-block; background-color: #c3202e; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-family: 'UglyQua', sans-serif; font-size: 16px; border: 2px solid white;">
        DONATE NOW
    </a>
</div>
```

---

### Footer Notice (Custom HTML Block)

```html
<div style="max-width: 1100px; margin: 30px auto 40px; padding: 0 20px; text-align: center;">
    <div style="border: 2px solid #044f9d; border-left: 5px solid #c3202e; padding: 20px; background: #f9f9f9;">
        <p style="font-size: 16px; margin: 0;">
            <strong>Important:</strong> Local Pickup, Shipping, and Merchandise items cannot be combined in one order. 
            Please complete separate checkouts for each category.
        </p>
    </div>
</div>
```

---

## Card Design Specifications

### Border Colors (Alternating Pattern)
- **Blue border:** `#044f9d` - Local Pickup, Merchandise
- **Red border:** `#c3202e` - Nationwide Shipping, Donate

### Button Colors (Match Border)
- **Blue button:** `#044f9d` - Local Pickup, Merchandise
- **Red button:** `#c3202e` - Nationwide Shipping, Donate

### Common Card Styles
- Border: 3px solid
- Border radius: 8px
- Padding: 25px 20px
- Text align: center
- Heading: Red (#c3202e), 22px
- Image: 150px max-width, 2px border
- Button: White text, 2px white border, 5px border-radius

---

## Product Links

| Card | Link | Product Category |
|------|------|------------------|
| Local Pickup | `/shop/local-pickup/` | Local pickup items |
| Nationwide Shipping | `/shop/shipped-items/` | Shipped items |
| Merchandise | `/shop/printful-merchandise/` | Printful products |
| Donate | `/product/donate-to-lexington-alarm/` | Virtual donation product |

---

## Images Used

| Card | Image URL |
|------|-----------|
| Local Pickup | `/wp-content/uploads/2025/09/Law_is_King.webp` |
| Nationwide Shipping | `/wp-content/uploads/2025/10/20250510-IMG_8342.webp` |
| Merchandise | `/wp-content/uploads/2025/10/unisex-garment-dyed-heavyweight-t-shirt-midnight-front-68fd4763b902e.webp` |
| Donate | `/wp-content/uploads/2025/09/Law_is_King.webp` |

---

## Known Issue: Donation Cart Mixing

**Status:** Not yet resolved

**Issue:** Donation product (virtual, no shipping) cannot currently be combined with Local Pickup or Shipped items in the same cart. Error message appears: "Cannot Mix Fulfillment Methods."

**Cause:** Cart validation code treats Virtual as a separate fulfillment category.

**Future Fix:** Update cart validation to allow Virtual/Donation items to be added to any cart type.

**Current Workaround:** Customers must checkout donations separately.

---

## Troubleshooting History (Resolved)

### Original Problem
Custom HTML with CSS grid was being overridden by Kadence theme styles. Cards displayed in single column on all screen sizes regardless of CSS approach.

### Approaches That Failed
1. CSS Grid with `grid-template-columns: 1fr 1fr` - overridden
2. CSS Grid with `repeat(2, 1fr)` and `!important` - overridden
3. Inline styles with `!important` - overridden
4. Adding custom CSS to Customizer - still overridden
5. Various `<style>` blocks in page content - overridden

### Root Cause
Kadence theme and/or WordPress block editor wraps Custom HTML blocks in containers that constrain layout. Theme CSS has higher specificity than inline styles in some contexts.

### Solution That Worked
Use Kadence's native Row Layout blocks for grid structure. These blocks are designed to work with the theme's CSS and properly handle responsive breakpoints. Custom HTML blocks inside the columns preserve exact card styling.

**Key Insight:** Let the theme handle layout; use Custom HTML only for content styling.

---

## Related Documentation

- `02_Store_System/WooCommerce_Setup.md` - Store configuration
- `02_Store_System/Products_Catalog.md` - Product categories and Donate product
- `02_Store_System/Checkout_Flow.md` - Cart validation and fulfillment methods
- `07_Change_Log/2025_Q4_Changes.md` - December 2025 updates

---

**Document Version:** 2.0  
**Last Updated:** December 3, 2025  
**Previous Version:** October 29, 2025 (3-card layout, stacking issue unresolved)
