# Checkout Flow

**Last Updated:** November 22, 2024  
**Status:** Active with ongoing optimization  
**Current Focus:** Cart validation to prevent incompatible shipping class mixing

---

## Current State

### Checkout Process Overview
1. Customer adds products to cart
2. Cart page displays items and totals
3. Customer proceeds to checkout
4. Customer enters shipping/billing information
5. Shipping method automatically determined by product shipping class
6. Customer selects payment method (Stripe)
7. Order is processed and confirmation sent

---

## Shipping Class Complexity

### The Challenge
**Problem:** Customers can currently add products from incompatible shipping classes to the same cart:

**Incompatible Combinations:**
- Local Pickup items + Nationwide Shipping items
- Local Pickup items + Printful items
- Nationwide Shipping items + Printful items (potentially - document if this is an issue)

**Why This is a Problem:**
- Different fulfillment methods (local pickup vs. shipping vs. Printful)
- Different shipping costs/methods
- Customer confusion about receiving partial shipments
- Administrative complexity in order fulfillment

### Shipping Classes in Use

#### 1. Local Pickup Only
**Products:**
- 2' x 3' Yard Signs
- 18" x 24" Yard Signs

**Fulfillment:**
- Customer picks up in Lexington, MA
- No shipping cost
- Coordination required for pickup time/location

#### 2. Standard Shipping
**Products:**
- Buttons
- Small merchandise

**Fulfillment:**
- Ships via USPS/UPS
- Flat rate or calculated shipping
- Fulfilled by organization

#### 3. Printful
**Products:**
- T-shirts
- Apparel
- Print-on-demand merchandise

**Fulfillment:**
- Ships directly from Printful
- Separate shipping from organization
- Different shipping timeline (5-7 business days)

---

## Current Solution: Advanced Shipping Packages

### Plugin Details
**Plugin Name:** Advanced Shipping Packages for WooCommerce  
**Purpose:** Enforce cart validation to prevent incompatible shipping class mixing  
**Status:** (Testing/Active - document current status)  
**Version:** (Document version)

### How It Works
The plugin validates the cart before checkout:

1. Customer adds item to cart
2. Plugin checks shipping class of new item
3. Plugin compares to existing items in cart
4. If incompatible: Display error message, prevent adding to cart
5. If compatible: Allow adding to cart

### Configuration Needed
**Location:** WooCommerce → Settings → Shipping Packages (or similar)

**Rules to Set:**
1. **Rule 1:** Local Pickup items cannot be mixed with Shipping items
   - If cart contains: Local Pickup Only
   - Block: Standard Shipping, Printful

2. **Rule 2:** Standard Shipping items cannot be mixed with Local Pickup items
   - If cart contains: Standard Shipping
   - Block: Local Pickup Only

3. **Rule 3:** Printful items cannot be mixed with Local Pickup items
   - If cart contains: Printful
   - Block: Local Pickup Only

**Rule 4 (Optional):** Determine if Standard Shipping and Printful can be mixed
- If yes: Allow both in same cart (customer receives two separate shipments)
- If no: Block mixing these classes too

### Error Messages
**Customer-Facing Messages:** Should be clear and helpful

**Example Messages:**
```
"Yard signs are available for local pickup only and cannot be combined 
with shipped items. Please checkout separately or remove yard signs to 
continue with shipped items."

"This item ships separately and cannot be combined with local pickup 
items. Please checkout separately or remove pickup items."

"Items from different shipping categories must be ordered separately. 
Please complete this order first, then place a new order for the other items."
```

---

## Alternative/Complementary Solutions

### Solution 1: Separate Shops
**Concept:** Create separate shop pages for different fulfillment types
- Shop: Local Pickup Only
- Shop: Nationwide Shipping
- Shop: Printful Merchandise

**Pros:**
- Completely eliminates mixing issue
- Very clear to customers
- Simple to implement (categories/pages)

**Cons:**
- More navigation complexity
- May reduce cross-category discovery
- Requires duplicate navigation elements

**Status:** Under consideration as fallback

### Solution 2: Cart Notices/Warnings
**Concept:** Display prominent notices when cart has multiple shipping classes

**Implementation:**
- Custom WooCommerce notice on cart page
- Warning before checkout
- Explanation of separate fulfillment

**Pros:**
- Doesn't block customer from proceeding
- Educational approach
- Simpler than full validation

**Cons:**
- Doesn't prevent the issue
- Still requires admin handling of mixed orders
- Customer confusion may persist

**Status:** Could complement Advanced Shipping Packages

### Solution 3: Checkout Page Restrictions
**Concept:** Split orders automatically at checkout

**Implementation:**
- Plugin that detects multiple shipping classes
- Automatically creates separate orders
- Processes payments separately or splits payment

**Pros:**
- Allows customers to add whatever they want
- Handles splitting automatically
- Most user-friendly

**Cons:**
- Complex implementation
- Requires specialized plugin (may not exist)
- Payment splitting complexity
- Multiple order confirmation emails

**Status:** Ideal but may not be feasible

---

## Cart Page Configuration

### Cart Display
**Location:** WooCommerce → Settings → Cart

**Settings:**
- Display: Cart page (not sidebar/mini cart)
- Enable cart cross-sells: (Yes/No - document)
- Redirect to cart after adding: (Yes/No - document)

### Cart Notices/Messages
**Location:** Custom code (functions.php or plugin)

**Active Notices:**
- Shipping class incompatibility warning (via Advanced Shipping Packages)
- (Other cart notices - document)

---

## Checkout Page Configuration

### Checkout Fields
**Required Fields:**
- Email address
- First name
- Last name
- Street address
- City
- State
- ZIP code
- Phone number (optional/required - document)

**Billing vs. Shipping:**
- Option to "Ship to a different address": Yes/No (document current setting)

### Checkout Experience
**Guest Checkout:** Enabled (no forced account creation)  
**Account Creation Option:** Available but optional  
**Coupon Field:** (Enabled/Disabled on checkout page - document)

### Payment Section
**Accepted Methods:**
- Stripe (Credit/Debit cards, Apple Pay)

**Payment Information:**
- Collected via Stripe Elements (secure iframe)
- No card data stored on server (PCI compliant)

---

## Shipping Method Assignment

### Automatic Assignment
**How It Works:**
1. Customer's cart analyzed for shipping classes
2. Appropriate shipping method automatically selected
3. Shipping cost calculated based on method

**For Local Pickup:**
- Detects "Local Pickup Only" class
- Displays "Local Pickup" option only
- Cost: $0
- Customer sees pickup location/instructions

**For Standard Shipping:**
- Detects "Standard Shipping" class
- Displays flat rate shipping option
- Cost: (Document rate)
- Customer sees estimated delivery time

**For Printful:**
- Detects "Printful" class
- Shipping cost calculated by Printful
- Customer sees Printful shipping options
- Delivery estimate: 5-7 business days

---

## Order Processing After Checkout

### Order Status Flow
1. **Payment Processing:** Stripe processes payment
2. **Order Created:** WooCommerce creates order with "Processing" status
3. **Email Notifications:** Sent to customer and admin (see `02_Store_System/Email_Notifications.md`)
4. **Order Fulfillment:**
   - Local Pickup: Coordinate pickup with customer
   - Standard Shipping: Pack and ship from organization
   - Printful: Automatically sent to Printful for fulfillment
5. **Order Completed:** Status updated to "Completed"

### Order Categorization
**Email Subject Line Tags:**
- `[LOCAL PICKUP]` - Orders requiring local coordination
- `[SHIPPING]` - Orders to be packed and shipped
- `[DONATION]` - Donation-only orders (no fulfillment needed)

**Purpose:** Allow quick filtering and prioritization of orders in email inbox

---

## Mobile Checkout Optimization

### Mobile Considerations
- Form fields stack vertically
- Touch-friendly input fields
- Stripe payment form fully responsive
- Easy toggling between billing/shipping addresses

**Testing:** Regularly test checkout on:
- iPhone (Safari)
- Android (Chrome)
- Tablet devices

---

## Checkout Analytics

### Key Metrics to Track
1. **Cart Abandonment Rate:** % of users who add to cart but don't complete checkout
2. **Checkout Completion Rate:** % who reach checkout and complete order
3. **Average Order Value:** Average total per order
4. **Payment Method Usage:** Credit card vs. Apple Pay
5. **Shipping Class Distribution:** Local Pickup vs. Shipping vs. Printful percentages

**Access:** WooCommerce → Analytics → Orders

### Optimization Opportunities
- Identify where customers drop off (cart vs. checkout)
- Test different shipping costs/offers
- A/B test checkout field requirements
- Monitor mobile vs. desktop completion rates

---

## Known Issues

### Current Issues
**Issue 1: Cart Mixing**
- **Status:** In progress with Advanced Shipping Packages
- **Impact:** Customers can mix incompatible shipping classes
- **Solution:** Plugin configuration and testing

**Issue 2: [If any others - document]**

### Resolved Issues
- ✅ Payment processing reliability (Stripe properly configured)
- ✅ Email notifications (SendLayer SMTP working)
- ✅ Order status workflow (properly configured)

---

## Cart Abandonment Recovery

### Current Strategy
**Status:** (Document if abandoned cart recovery is implemented)

**Potential Approaches:**
1. **Email Reminders:** Send reminder email after X hours
2. **Discount Codes:** Offer incentive to complete purchase
3. **Exit Intent Popups:** Display message when user attempts to leave cart

**Tools Available:**
- WooCommerce built-in (limited)
- Abandoned Cart plugins (various options)
- Email marketing integration (Mailchimp)

---

## Testing Procedures

### Pre-Launch Testing (for changes)
1. **Add to Cart:**
   - Test each product type individually
   - Test adding multiple quantities
   - Test adding from different categories

2. **Cart Validation:**
   - Test adding incompatible items (should be blocked)
   - Test error messages (clear and helpful?)
   - Test cart totals and shipping calculations

3. **Checkout Process:**
   - Complete test order (use Stripe test card)
   - Verify shipping method assignment
   - Confirm email notifications sent
   - Check order appears in WooCommerce → Orders

4. **Mobile Testing:**
   - Repeat above on mobile device
   - Check for layout issues
   - Verify payment processing works

### Test Payment Methods
**Stripe Test Cards:**
- Success: 4242 4242 4242 4242
- Declined: 4000 0000 0000 0002
- Requires authentication: 4000 0027 6000 3184

**Test in:** Stripe Test Mode (before enabling live mode)

---

## Customer Support - Common Checkout Issues

### "I can't add this item to my cart"
**Likely Cause:** Shipping class incompatibility  
**Solution:** Explain separate fulfillment methods, suggest checking out separately

### "Shipping seems expensive"
**Likely Cause:** Customer comparing to free shipping offers elsewhere  
**Solution:** Explain cost recovery model, emphasize mission support

### "Where is local pickup?"
**Likely Cause:** Pickup location not clear  
**Solution:** Ensure pickup instructions in order confirmation email, add to product description

### "My payment didn't go through"
**Likely Cause:** Declined card, 3D Secure issue  
**Solution:** Verify Stripe dashboard for specific error, suggest trying different card

---

## Future Enhancements

### Planned Improvements
- [ ] Complete Advanced Shipping Packages configuration and testing
- [ ] Add clearer shipping class explanations on product pages
- [ ] Implement abandoned cart recovery email sequence
- [ ] Add Plausible Analytics event tracking for cart actions
- [ ] Test and optimize mobile checkout experience

### Under Consideration
- [ ] PayPal payment option (concern about advocacy organization restrictions)
- [ ] Buy Now buttons that skip cart (for single-product purchases)
- [ ] One-page checkout (combine cart and checkout)
- [ ] Guest checkout optimization (fewer required fields)

---

## Change History

### 2024 Q4
- Added Advanced Shipping Packages plugin (testing phase)
- Implemented cart validation rules
- Updated checkout field requirements
- Optimized mobile checkout layout

### 2024 Q3
- Initial checkout flow implemented
- Stripe payment processing configured
- Email notification system created
- Order status workflow established

---

**Related Documentation:**
- `02_Store_System/WooCommerce_Setup.md` - Overall store configuration
- `02_Store_System/Products_Catalog.md` - Shipping class assignments
- `02_Store_System/Email_Notifications.md` - Order confirmation emails
- `01_Technical_Foundation/Plugins_And_Integrations.md` - Plugin details
