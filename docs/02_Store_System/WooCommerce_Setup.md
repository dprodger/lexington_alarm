# WooCommerce Setup

**Last Updated:** November 22, 2024  
**WooCommerce Version:** (Current version)  
**Status:** Production - Live with Active Orders

---

## Current State

### Store Overview
**Store URL:** https://lexingtonalarm.org/shop/ (or configured slug)  
**Primary Purpose:** 
- Yard sign sales (local pickup)
- Merchandise sales (nationwide shipping)
- Donations
- Event tickets (potential future use)

**Active Products:** (Current count)  
**Order Volume:** (Document average orders per week/month)

---

## General Settings

### Store Address
**Location:** WooCommerce → Settings → General

```
Store Address:
(Street address)
City: Lexington
State: Massachusetts
ZIP: (ZIP code)
Country: United States

This address is used for:
- Tax calculations (if applicable)
- Local pickup location
- Legal/business address on receipts
```

### Currency
**Currency:** US Dollar ($)  
**Position:** Left with space ($)  
**Thousand Separator:** Comma  
**Decimal Separator:** Period  
**Number of Decimals:** 2

### Selling Locations
**Sell to:** All countries (or specific countries - document)  
**Ship to:** Specific locations (see Shipping configuration)

---

## Product Settings

### Shop Page
**Shop Base Page:** /shop/ (or configured slug)  
**Display:** Products per page (document number)  
**Shop Page Layout:** (Grid/List - document current)

### Product Catalog
**Display Prices:** With tax (or without - document)  
**Product Images:** 
- Catalog thumbnail size: (dimensions)
- Single product image size: (dimensions)

### Inventory
**Manage Stock:** Enabled at product level  
**Stock Display:** (Show/Hide remaining stock - document)  
**Low Stock Threshold:** (Number - document)  
**Out of Stock Threshold:** 0

**Out of Stock Visibility:** Hide out of stock products

---

## Shipping Configuration

### Shipping Zones
**Location:** WooCommerce → Settings → Shipping

#### Zone 1: Local Pickup (Lexington, MA)
**Region:** Lexington, MA (ZIP-based or radius)  
**Methods Available:**
- Local Pickup (Free)

**Shipping Classes:**
- Local Pickup Only

**Products:**
- Yard signs (2' x 3', 18" x 24")
- (Other local-only products)

#### Zone 2: Continental United States
**Region:** All US states excluding Alaska, Hawaii  
**Methods Available:**
- Flat Rate Shipping ($X.XX - document)
- Or calculated rates (document if using carrier rates)

**Shipping Classes:**
- Standard Shipping
- (Others if applicable)

**Products:**
- Buttons
- Donation items (if shipped)
- (Other nationwide products)

#### Zone 3: Printful Products
**Region:** Nationwide (all 50 states)  
**Methods:** Handled by Printful integration  
**Shipping Classes:**
- Printful

**Products:**
- T-shirts
- Other print-on-demand merchandise

### Shipping Classes
**Purpose:** Prevent incompatible items in same cart

1. **Local Pickup Only**
   - Yard signs
   - (Other bulky/local items)

2. **Standard Shipping**
   - Buttons
   - Small merchandise
   - (Other shippable items)

3. **Printful**
   - Print-on-demand merchandise
   - Ships directly from Printful

**Cart Validation:** See `02_Store_System/Checkout_Flow.md` for Advanced Shipping Packages configuration

---

## Payment Settings

### Enabled Payment Methods

#### Stripe (Primary)
**Gateway:** Payment Plugins for Stripe WooCommerce  
**Status:** Active  
**Test Mode:** Disabled (live processing)

**Accepted Cards:**
- Visa
- Mastercard
- American Express
- Discover
- (Others - document)

**Additional Payment Methods:**
- Apple Pay: Enabled (simplified setup)
- Google Pay: Disabled (intentionally - complexity concerns)

**Configuration:**
- Payment Intent API: Enabled
- Capture: Immediate (or authorized for later - document)
- 3D Secure: Enabled for fraud protection

#### PayPal (Under Consideration)
**Status:** Not currently enabled  
**Reason:** Previous negative experience with Venmo, concerns about account restrictions for advocacy organizations  
**Future:** May reconsider based on user demand

### Checkout Settings
**Guest Checkout:** Enabled (customers not required to create account)  
**Account Creation:** Optional at checkout  
**Coupon Field:** (Enabled/Disabled - document)

---

## Tax Settings

### Tax Configuration
**Calculate Taxes:** (Yes/No - document)  
**Tax Based On:** (Customer billing/shipping address, shop address - document)  
**Shipping Tax Class:** (Based on cart items or separate - document)

**Tax Status:** (Document current status)
- If tax-exempt organization: Document exemption details
- If charging tax: Document rates and jurisdictions

---

## Account & Privacy

### Customer Accounts
**Guest Checkout:** Enabled  
**Account Creation:** 
- Allow customers to create account during checkout: Yes
- Allow customers to create account on "My Account" page: Yes
- Automatically generate username: Yes
- Automatically generate password: Yes (with email notification)

### Privacy
**Privacy Policy Page:** (Document which page is set)  
**Terms and Conditions:** (Document which page is set)  
**Registration Policy Checkbox:** Enabled
**Checkout Privacy Policy Checkbox:** Enabled

---

## Email Settings

### Email Sender
**From Name:** Lexington Alarm  
**From Email:** store@lexingtonalarm.org  
**Header Image:** (Document if set - path to logo/banner)

### Email Types Enabled
See `02_Store_System/Email_Notifications.md` for detailed configuration

**Customer Emails:**
- New Order (confirmation)
- Processing Order
- Completed Order
- Cancelled Order
- Failed Order
- Customer Note

**Admin Emails:**
- New Order notification
- Cancelled Order notification
- Failed Order notification

**SendLayer Integration:** All emails routed through SMTP plugin for reliable delivery

---

## Order Management

### Order Statuses
**Available Statuses:**
- Pending Payment
- Processing
- On Hold
- Completed
- Cancelled
- Refunded
- Failed

**Default New Order Status:** Processing (after successful payment)

### Order Numbers
**Sequential:** (Yes/No - document if custom order numbers)  
**Prefix:** (Document if using prefix)  
**Current Range:** (Document current order number range)

---

## Product Types in Use

### Simple Products
- Individual yard signs
- Buttons
- Donations (fixed amounts)
- T-shirts (via Printful)

### Variable Products
- Yard signs (2' x 3' vs 18" x 24")
- Donations (with amount variations)
- (Others with size/color/option variations)

**Variation Strategy:** Keep variations minimal for ease of management

---

## Advanced Settings

### REST API
**Status:** (Enabled/Disabled - document)  
**Use Case:** (Printful integration, mobile app, etc. - document if enabled)

### Webhooks
**Active Webhooks:** (Document any active webhooks)  
**Purpose:** (Printful order creation, external integrations - document)

### WooCommerce Analytics
**Enabled:** Yes (default)  
**Use:** Track sales, revenue, products, categories, orders

**Access:** WooCommerce → Analytics (in WordPress admin)

---

## Security & Compliance

### PCI Compliance
**Payment Processing:** Stripe handles card data (PCI-compliant)  
**Site Responsibility:** No card data stored on server  
**SSL Certificate:** Active and required for checkout

### GDPR Compliance
**Personal Data:**
- Order information (name, address, email)
- Account information (if customer creates account)

**Data Retention:**
- Orders: Retained indefinitely for business records
- Account data: Retained until account deletion requested

**Data Export/Deletion:** Available through WooCommerce tools (Tools → Export/Erase Personal Data)

---

## Performance Optimization

### Database Cleanup
**Transients:** Clear periodically (WooCommerce → Status → Tools → Clear transients)  
**Old Orders:** (Retention policy - document)  
**Pending Orders:** Auto-cancel after X days (if configured)

### Caching Exclusions
**Cart Page:** Excluded from caching  
**Checkout Page:** Excluded from caching  
**My Account Page:** Excluded from caching

---

## Common Store Management Tasks

### Adding a New Product
1. Products → Add New
2. Set title, description, short description
3. Add product image and gallery images
4. Set product data type (Simple/Variable)
5. Configure pricing, shipping class, inventory
6. Publish

### Processing an Order
1. WooCommerce → Orders
2. Click order to view details
3. Verify payment received (Stripe confirmation)
4. Update shipping class if needed
5. Mark as "Completed" when fulfilled
6. Customer receives completion email

### Handling Refunds
1. WooCommerce → Orders → Select order
2. Click "Refund" button
3. Enter refund amount
4. Select "Refund via Stripe" to process refund
5. Order status updates to "Refunded"

### Local Pickup Coordination
1. Orders with "Local Pickup" flagged in order notes
2. Email notification includes [LOCAL PICKUP] tag
3. Coordinate pickup location/time with customer
4. Mark as completed when picked up

---

## Known Issues

### Current
- Cart validation needed to prevent mixed shipping classes (in progress with Advanced Shipping Packages)
- (Document other current issues)

### Resolved
- ✅ Email deliverability (resolved with SendLayer SMTP)
- ✅ Stripe payment processing (properly configured)
- ✅ Order notification system (working with category labels)

---

## Troubleshooting Guide

### Orders Not Appearing
1. Check WooCommerce → Orders (may be in different status)
2. Verify email notifications working (check spam)
3. Check WooCommerce logs: WooCommerce → Status → Logs
4. Verify Stripe webhook working (Stripe dashboard → Webhooks)

### Payment Issues
1. Check Stripe dashboard for payment status
2. Verify Stripe plugin settings (test/live mode)
3. Check customer's payment method (declined card?)
4. Review WooCommerce logs for Stripe errors

### Shipping Calculation Issues
1. Verify shipping zones configured correctly
2. Check product shipping class assignments
3. Test checkout with different addresses
4. Review shipping class conflicts

---

## Change History

### 2024 Q4
- Implemented order categorization with email tags ([SHIPPING], [LOCAL PICKUP], [DONATION])
- Working on Advanced Shipping Packages for cart validation
- Optimized product variations for ease of ordering
- (Document other Q4 changes)

### 2024 Q3
- Initial WooCommerce setup and configuration
- Stripe payment gateway activated
- Product catalog created
- Email notification system configured

---

**Related Documentation:**
- `02_Store_System/Products_Catalog.md` - All products and variations
- `02_Store_System/Checkout_Flow.md` - Cart validation and checkout process
- `02_Store_System/Email_Notifications.md` - Email templates and configuration
- `01_Technical_Foundation/Plugins_And_Integrations.md` - Plugin details
