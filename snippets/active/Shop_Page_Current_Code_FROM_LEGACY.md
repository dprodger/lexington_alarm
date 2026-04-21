# Shop Page - Current Working Code
**Last Updated:** October 29, 2025  
**Status:** Working (cards stack vertically on all screen sizes)  
**Page:** Main shop landing/sorting page

---

## Current HTML Code

```html
<!-- Hero Section -->
<div class="la-section la-text-center" style="background-color: #044f9d; color: white; padding: 40px 20px; margin-bottom: 50px;">
    <h1 style="color: white; margin-bottom: 15px;">SHOP LEXINGTON ALARM</h1>
    <p style="font-size: 20px; max-width: 800px; margin: 0 auto; color: white;">
        Choose your shopping method below. Items cannot be mixed - please shop each category separately.
    </p>
</div>

<!-- Three Column Grid -->
<div class="shop-sorting-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 25px; max-width: 1200px; margin: 0 auto 60px; padding: 0 20px;">
    <!-- Column 1: Local Pickup -->
    <div class="shop-category-card" style="border: 3px solid #044f9d; border-radius: 8px; padding: 25px 20px; text-align: center;">
        <h2 style="color: #c3202e; margin-bottom: 15px; font-size: 22px;">🏠 LOCAL PICKUP</h2>
        
        <img src="https://lexingtonalarm.org/wp-content/uploads/2025/09/Law_is_King.webp" alt="Yard Sign" style="max-width: 150px; height: auto; margin: 0 auto 15px; display: block; border: 2px solid #ddd;">
        
        <p style="font-size: 15px; margin-bottom: 12px; line-height: 1.5;">
            <strong>24/7 Porch Pickup • Free</strong><br>
            Available: Yard Signs, Window Signs, Buttons
        </p>
        
        <p style="font-size: 13px; color: #666; margin-bottom: 20px;">
            Pick up anytime within 8 miles of Lexington, MA
        </p>
        
        <a href="/shop/local-pickup/" class="la-button" style="display: inline-block; background-color: #044f9d; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-family: 'UglyQua', sans-serif; font-size: 16px; border: 2px solid white;">
            SHOP LOCAL PICKUP
        </a>
    </div>

    <!-- Column 2: Nationwide Shipping -->
    <div class="shop-category-card" style="border: 3px solid #c3202e; border-radius: 8px; padding: 25px 20px; text-align: center;">
        <h2 style="color: #c3202e; margin-bottom: 15px; font-size: 22px;">📦 NATIONWIDE SHIPPING</h2>
        
        <img src="https://lexingtonalarm.org/wp-content/uploads/2025/10/20250510-IMG_8342.webp" alt="Shipped Items" style="max-width: 150px; height: auto; margin: 0 auto 15px; display: block; border: 2px solid #ddd;">
        
        <p style="font-size: 15px; margin-bottom: 12px; line-height: 1.5;">
            <strong>Ships Anywhere in USA • Shipping Included</strong><br>
            Available: Sign Packs, Button Packs, Window Mailers
        </p>
        
        <p style="font-size: 13px; color: #666; margin-bottom: 20px;">
            We ship signs via UPS and stand alone button orders via USPS priority Mail. Delivery in 2-4 days. Buttons purchased with signs are included in the same package at a discounted price.
        </p>
        
        <a href="/shop/shipped-items/" class="la-button" style="display: inline-block; background-color: #c3202e; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-family: 'UglyQua', sans-serif; font-size: 16px; border: 2px solid white;">
            SHOP SHIPPED ITEMS
        </a>
    </div>

    <!-- Column 3: Printful Merchandise -->
    <div class="shop-category-card" style="border: 3px solid #044f9d; border-radius: 8px; padding: 25px 20px; text-align: center;">
        <h2 style="color: #c3202e; margin-bottom: 15px; font-size: 22px;">👕 MERCHANDISE</h2>
        
        <img src="https://lexingtonalarm.org/wp-content/uploads/2025/10/unisex-garment-dyed-heavyweight-t-shirt-midnight-front-68fd4763b902e.webp" alt="Merchandise" style="max-width: 150px; height: auto; margin: 0 auto 15px; display: block; border: 2px solid #ddd;">
        
        <p style="font-size: 15px; margin-bottom: 12px; line-height: 1.5;">
            <strong>Custom Printed • Ships Direct</strong><br>
            Available: T-Shirts, Hoodies, Tote Bags, and more
        </p>
        
        <p style="font-size: 13px; color: #666; margin-bottom: 20px;">
            Made-to-order, ships within 3-7 business days
        </p>
        
        <a href="/shop/printful-merchandise/" class="la-button" style="display: inline-block; background-color: #044f9d; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-family: 'UglyQua', sans-serif; font-size: 16px; border: 2px solid white;">
            SHOP MERCHANDISE
        </a>
    </div>

</div>

<!-- Important Notice -->
<div class="la-highlight-box" style="max-width: 800px; margin: 0 auto 40px; text-align: center;">
    <p style="font-size: 16px; margin: 0;">
        <strong>Important:</strong> Local Pickup, Shipping, and Merchandise items cannot be combined in one order. 
        Please complete separate checkouts for each category.
    </p>
</div>
```

---

## Technical Notes

### Current Behavior
- All three cards stack vertically on all screen sizes (desktop, tablet, mobile)
- Cards are centered and responsive
- Images scale to 150px max-width
- Clean, functional layout

### Grid Settings
- `grid-template-columns: repeat(auto-fit, minmax(280px, 1fr))`
- This allows cards to flow and stack based on available space
- With minmax of 280px, cards stack when screen is < ~900px wide for 3 columns

### Known Issue
- Cannot force three cards into one horizontal row on wide desktop screens
- Multiple CSS approaches attempted without success
- Suspected Kadence theme CSS override or WordPress block wrapper constraint

### Future Troubleshooting Ideas
1. Inspect actual rendered HTML/CSS in browser to identify overriding styles
2. Try using Kadence's native Row/Column blocks instead of custom HTML
3. Add custom CSS class in Kadence Theme settings that can override block styles
4. Consider using a different page template that doesn't constrain content width
5. Check if WordPress is wrapping the HTML in additional divs that force full-width

---

## File Locations
- **WordPress Page:** Shop (main landing page)
- **HTML Block:** Custom HTML block in WordPress editor
- **Images Used:**
  - `/wp-content/uploads/2025/09/Law_is_King.webp`
  - `/wp-content/uploads/2025/10/20250510-IMG_8342.webp`
  - `/wp-content/uploads/2025/10/unisex-garment-dyed-heavyweight-t-shirt-midnight-front-68fd4763b902e.webp`
