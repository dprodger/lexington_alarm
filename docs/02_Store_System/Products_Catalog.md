# Products Catalog

**Last Updated:** December 3, 2025  
**Total Products:** (Current count)  
**Product Categories:** Signs, Merchandise, Donations

---

## Current State

### Product Organization

**Categories:**
1. Yard Signs (Local Pickup)
2. Buttons & Small Items (Shipping)
3. Apparel (Printful)
4. Donations
5. (Others - document)

**Shipping Classes:**
- Local Pickup Only
- Standard Shipping  
- Printful

---

## Yard Signs (Local Pickup Only)

### Standard Yard Sign - 2' x 3'
**Product Type:** Variable  
**SKU:** (Document)  
**Price:** (Current price)  
**Shipping Class:** Local Pickup Only

**Variations:**
- Single sign
- (Multiple quantity options if available)

**Description:** Full-size yard sign featuring Lexington Alarm branding (1775-2025 logo with American flag)

**Product Details:**
- Material: Corrugated plastic
- Size: 2 feet × 3 feet
- Includes: Metal stake
- Durability: Weather-resistant

**Images:**
- Main product image
- Lifestyle image (sign in yard)
- Close-up of design

**Inventory:**
- Manage stock: Yes
- Stock quantity: (Current count)
- Allow backorders: (Yes/No - document)

### Compact Yard Sign - 18" x 24"
**Product Type:** Variable  
**SKU:** (Document)  
**Price:** (Current price - typically lower than 2'x3')  
**Shipping Class:** Local Pickup Only

**Variations:**
- Single sign
- (Multiple quantity options if available)

**Description:** Compact yard sign, same design, easier placement in smaller spaces

**Product Details:**
- Material: Corrugated plastic
- Size: 18 inches × 24 inches
- Includes: Metal stake
- Durability: Weather-resistant

**Images:**
- Main product image
- Size comparison image (vs larger sign)
- Installed image

**Inventory:**
- Manage stock: Yes
- Stock quantity: (Current count)
- Allow backorders: (Yes/No - document)

---

## Buttons & Small Items (Nationwide Shipping)

### Lexington Alarm Button
**Product Type:** Simple  
**SKU:** (Document)  
**Price:** (Current price)  
**Shipping Class:** Standard Shipping

**Description:** Round button featuring Lexington Alarm logo/design

**Product Details:**
- Size: (Diameter - typically 2.25" or 3")
- Type: Pin-back button
- Design: (Describe button design/slogan)

**Images:**
- Product image (front)
- Size reference image

**Inventory:**
- Manage stock: Yes
- Stock quantity: (Current count)
- Allow backorders: (Yes/No - document)

### Button Sets (if offered)
**Product Type:** Simple or Variable  
**Price:** (Discount pricing for sets)  
**Shipping Class:** Standard Shipping

**Variations (if applicable):**
- 5-pack
- 10-pack
- (Other quantities)

---

## Apparel & Merchandise (Printful)

### T-Shirt - Lexington Alarm Design
**Product Type:** Variable  
**SKU:** Printful-generated  
**Price:** (Current price)  
**Shipping Class:** Printful

**Variations:**
- Size: S, M, L, XL, 2XL, 3XL
- Color: (Available colors - document)

**Description:** High-quality t-shirt featuring Lexington Alarm branding

**Product Details:**
- Material: (Cotton blend, percentage - from Printful specs)
- Brand: (Printful shirt brand/style)
- Print: (Front/Back, print method)
- Fulfillment: Ships directly from Printful (5-7 business days)

**Images:**
- Mockup images (front, back)
- Model wearing shirt (if available)
- Design close-up

**Inventory:**
- Managed by: Printful (always in stock)
- Manage stock: No (print-on-demand)

### Additional Apparel Items (if available)
- Hoodies
- Long-sleeve shirts
- (Others)

**Same structure as t-shirts:** Size/color variations, Printful fulfillment

---

## Donations

### Donation - Variable Amount
**Product Type:** Virtual  
**Product Slug:** `donate-to-lexington-alarm`  
**Direct URL:** `/product/donate-to-lexington-alarm/`  
**SKU:** DONATION  
**Price:** Variable (customer selects amount)  
**Shipping Class:** None (virtual product - no shipping options)  
**Product Category:** Donation

**Configuration (Updated December 3, 2025):**
- Product type set to Virtual
- Removed from Local Pickup and Shipping categories
- No shipping address required at checkout
- Added to Shop landing page as 4th card

**Variations:**
- $10
- $25
- $50
- $100
- Custom amount (if available through plugin/customization)

**Description:** Support Lexington Alarm's mission to defend constitutional rights and the rule of law. Donations help fund yard signs, events, organizing, and community outreach.

**Product Details:**
- Type: Virtual product (no shipping)
- Tax-deductible: (Document organization's tax status)
- Receipt: Emailed immediately upon donation

**Inventory:**
- Manage stock: No (virtual product)

**Shop Page Display:**
- Featured on main shop landing page (`/browse-products/`)
- Red border card with ❤️ DONATE heading
- "DONATE NOW" button links directly to product page
- Image: Law is King sign image

**Known Issue (December 2025):**
- Donation cannot currently be combined with Local Pickup or Shipped items in same cart
- Error: "Cannot Mix Fulfillment Methods - Virtual"
- Cause: Cart validation treats Virtual as separate fulfillment category
- Workaround: Customers must checkout donations separately
- Future fix: Update cart validation to allow Virtual/Donation with any other fulfillment type

### Button Add-On Donation (planned)
**Status:** Under development  
**Concept:** Allow customers to add buttons to their order at donation pricing (lower than retail)

**Potential Implementation:**
- Product bundle
- Checkout add-on
- Donation variation with button included

---

## Product Creation Guidelines

### Standard Information Required
1. **Title:** Clear, descriptive product name
2. **Short Description:** Appears on product listing pages (1-2 sentences)
3. **Full Description:** Detailed information, benefits, specifications
4. **Product Data:**
   - Type (Simple/Variable)
   - Price
   - SKU
   - Shipping class
   - Inventory management
5. **Images:** 
   - Featured image (main product photo)
   - Gallery images (multiple angles, lifestyle shots)
   - Recommended size: 1200x1200px minimum
6. **Categories:** Assign to appropriate category
7. **Tags:** (If using tags for filtering)

### Shipping Class Assignment Rules
- **Local Pickup Only:** Large items (yard signs) that cannot be shipped
- **Standard Shipping:** Small items (buttons) that ship via USPS/UPS
- **Printful:** Print-on-demand items fulfilled by Printful

**Critical:** Products must have correct shipping class to enable cart validation

---

## Product Variations Management

### Creating Variations
1. Set product type to "Variable product"
2. Go to Attributes tab
3. Add attribute (Size, Color, Amount, etc.)
4. Check "Used for variations"
5. Save attributes
6. Go to Variations tab
7. Generate variations or add manually
8. Set price, SKU, stock for each variation

### Variation Naming Convention
- Clear, consistent names
- Include key differentiator (size, color, amount)
- Example: "2' x 3' Yard Sign", "18\" x 24\" Yard Sign"

---

## Pricing Strategy

### Yard Signs
**Pricing Model:** Cost recovery + minimal margin  
**Goal:** Make signs accessible while covering costs

**Considerations:**
- Material costs
- Stakes/hardware
- Storage/handling
- No shipping costs (local pickup)

### Buttons
**Pricing Model:** Cost + shipping + small fundraising margin  
**Goal:** Accessible pricing with contribution to organization

### Apparel
**Pricing Model:** Printful base cost + markup for organization  
**Goal:** Quality merchandise with fundraising component

### Donations
**Pricing Model:** Suggested amounts with flexibility  
**Goal:** Make giving easy at multiple levels

---

## Inventory Management

### Stock Levels
**Yard Signs:**
- Reorder threshold: (Number - document)
- Storage location: (Document)
- Reorder lead time: (Days - document)

**Buttons:**
- Reorder threshold: (Number - document)
- Storage location: (Document)
- Reorder lead time: (Days - document)

**Apparel:**
- Managed by Printful (no inventory management needed)

### Stock Alerts
**Low Stock Email:** Sent to (email address) when stock reaches threshold  
**Out of Stock:** Product automatically hidden from shop (WooCommerce setting)

### Inventory Updates
**Frequency:** (Document - after each order? Daily? Weekly?)  
**Responsibility:** (Who updates inventory counts)  
**Method:** WooCommerce → Products → Edit product → Update stock quantity

---

## Product Images

### Image Requirements
**Dimensions:** Minimum 1200x1200px (square)  
**Format:** JPG or PNG  
**Optimization:** Compress before upload (keep under 200KB per image)

### Image Types Needed
1. **Main Product Image:** Clean, white/neutral background, product centered
2. **Gallery Images:** 
   - Multiple angles
   - Lifestyle/in-use shots
   - Size comparisons
   - Detail shots

### Image Naming Convention
```
product-name-primary.jpg
product-name-angle1.jpg
product-name-lifestyle.jpg
product-name-detail.jpg
```

---

## Product Descriptions

### Short Description (Excerpt)
- 1-2 sentences
- Appears on: Shop page, category pages
- Should answer: What is this? Why would someone want it?

**Example (Yard Sign):**
"Show your support for constitutional rights with our weather-resistant yard sign featuring the Lexington Alarm 1775-2025 logo. Includes metal stake for easy installation."

### Full Description
- Several paragraphs
- Appears on: Individual product page
- Should include:
  - Detailed specifications
  - Benefits/use cases
  - Historical context (for organization mission)
  - Care/installation instructions (if applicable)

---

## Product SEO

### Product Titles
- Include key search terms
- Keep under 60 characters
- Clear and descriptive

### Product URLs (Slugs)
- Auto-generated from title
- Clean, readable
- Include primary keyword
- Example: `/product/yard-sign-2x3/`

### Meta Descriptions
(If SEO plugin installed)
- 150-160 characters
- Include primary keyword
- Compelling call-to-action

---

## Future Product Considerations

### Potential New Products
- [ ] Bumper stickers
- [ ] Tote bags (via Printful)
- [ ] Window clings
- [ ] Historical merchandise (1775 commemoration items)
- [ ] Event tickets (for rallies, educational events)

### Bundle Opportunities
- [ ] Yard sign + button bundle (discounted)
- [ ] Donation + button add-on
- [ ] Apparel multi-packs (multiple shirts at discount)

---

## Product Performance Tracking

### Metrics to Monitor
- **Best Sellers:** Which products sell most?
- **Revenue by Product:** Which generate most revenue?
- **Conversion Rate:** Product page views vs. purchases
- **Abandoned Carts:** Which products in abandoned carts?

**Access:** WooCommerce → Analytics → Products

### Regular Reviews
**Frequency:** Monthly  
**Actions:**
- Adjust pricing if needed
- Update descriptions based on customer questions
- Add new images if available
- Discontinue poor performers
- Identify opportunities for new products

---

## Known Issues

### Current
- (Document any current product catalog issues)

### Resolved
- ✅ Shipping class assignments corrected
- ✅ Product variations organized for clarity

---

## Change History

### 2024 Q4
- Added donation variations
- Optimized product descriptions for clarity
- Updated product images
- (Document other changes)

### 2024 Q3
- Initial product catalog created
- Yard signs (2 sizes) added
- Buttons added
- Printful apparel integrated
- Donation product created

---

**Related Documentation:**
- `02_Store_System/WooCommerce_Setup.md` - Overall store configuration
- `02_Store_System/Checkout_Flow.md` - How shipping classes affect checkout
- `08_Quick_References/Common_Tasks.md` - How to add/edit products
