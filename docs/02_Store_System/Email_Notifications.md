# Email Notifications

**Last Updated:** November 22, 2024  
**Email Service:** SendLayer (SMTP)  
**From Address:** store@lexingtonalarm.org  
**Status:** Active and functioning

---

## Current State

### Email System Overview
**All WooCommerce order emails route through SendLayer SMTP plugin for reliable delivery.**

**Email Categories:**
1. Customer-facing order emails
2. Admin notification emails
3. Categorized by subject line tags for easy filtering

---

## Customer Order Emails

### New Order Confirmation
**Recipient:** Customer  
**Trigger:** Immediately after successful payment  
**Subject:** `[Category Tag] Order #{order_number} - Order Received`  

**Category Tags:**
- `[LOCAL PICKUP]` - For orders containing local pickup items
- `[SHIPPING]` - For orders to be shipped
- `[DONATION]` - For donation-only orders

**Content Includes:**
- Order number
- Order date
- Itemized list of products
- Order total
- Billing address
- Shipping address (if applicable)
- Payment method
- Pickup instructions (for local pickup orders)
- Estimated delivery (for shipped orders)

**Template Location:** WooCommerce → Settings → Emails → New Order

**Customizations:**
- Custom subject line with category tag
- Additional pickup instructions for local pickup
- Organization branding/mission statement in footer

### Processing Order Email
**Recipient:** Customer  
**Trigger:** When order status changed to "Processing" (typically automatic after payment)  
**Subject:** `Your Order #{order_number} is Being Processed`  

**Content Includes:**
- Confirmation that payment received
- Order is being prepared
- Next steps (pickup coordination or shipping timeline)
- Order details summary

**Note:** May be redundant with New Order email - consider if both are needed

### Completed Order Email
**Recipient:** Customer  
**Trigger:** When order status manually changed to "Completed"  
**Subject:** `Your Order #{order_number} is Complete`  

**Content Includes:**
- Confirmation of fulfillment
- Thank you message
- For shipped orders: Tracking information (if available)
- For local pickup: Confirmation of pickup
- Call to action: Share on social media, sign up for newsletter, etc.

### Failed Order Email
**Recipient:** Customer  
**Trigger:** When payment fails or is declined  
**Subject:** `Payment Failed for Order #{order_number}`  

**Content Includes:**
- Explanation that payment was not successful
- Possible reasons (declined card, insufficient funds)
- Instructions to retry
- Alternative payment methods
- Contact information for assistance

### Cancelled Order Email  
**Recipient:** Customer  
**Trigger:** When order status changed to "Cancelled"  
**Subject:** `Your Order #{order_number} Has Been Cancelled`  

**Content Includes:**
- Confirmation of cancellation
- Refund information (if applicable)
- Original order details for reference
- Contact information if customer has questions

### Customer Note Email
**Recipient:** Customer  
**Trigger:** When admin adds a note to order and marks it "Customer visible"  
**Subject:** `Note Added to Your Order #{order_number}`  

**Content Includes:**
- The note content
- Order details
- Call to action to log in and view order (if customer has account)

---

## Admin Notification Emails

### New Order Admin Notification
**Recipient:** Admin (store@lexingtonalarm.org or specified admin email)  
**Trigger:** Immediately after successful order placement  
**Subject:** `[Category Tag] New Order #{order_number}`  

**Category Tags:** Same as customer emails
- `[LOCAL PICKUP]`
- `[SHIPPING]`
- `[DONATION]`

**Content Includes:**
- Full order details
- Customer information
- Shipping/pickup details
- Payment information
- Direct link to order in WP admin

**Purpose:** 
- Immediate notification of new orders
- Category tag allows quick filtering in email client
- Prioritize fulfillment based on type

### Failed Order Admin Notification
**Recipient:** Admin  
**Trigger:** When order payment fails  
**Subject:** `Failed Order #{order_number}`  

**Content Includes:**
- Order details
- Reason for failure (if available)
- Customer contact information
- Suggestion to follow up with customer

### Cancelled Order Admin Notification
**Recipient:** Admin  
**Trigger:** When order is cancelled  
**Subject:** `Cancelled Order #{order_number}`  

**Content Includes:**
- Order details
- Cancellation reason (if provided)
- Whether refund was processed
- Customer information

---

## Email Categorization System

### Purpose
**Goal:** Enable quick identification and prioritization of orders by type

### Implementation
**Method:** Subject line prefix tags

### Categories and Logic

**[LOCAL PICKUP]:**
- Triggered when: Order contains products with "Local Pickup Only" shipping class
- Action needed: Coordinate pickup time/location with customer
- Priority: Medium (requires customer coordination)

**[SHIPPING]:**
- Triggered when: Order contains products with "Standard Shipping" class
- Action needed: Pack and ship order
- Priority: High (time-sensitive for customer satisfaction)

**[DONATION]:**
- Triggered when: Order is donation product only
- Action needed: None (no fulfillment required)
- Priority: Low (acknowledgment only)

### Email Filtering Rules
**Recommended Email Filter Setup:**

In admin email client (e.g., ProtonMail):
1. **Filter: Local Pickup**
   - If subject contains `[LOCAL PICKUP]`
   - Apply label: "Store - Local Pickup"
   - Priority: Normal

2. **Filter: Shipping**
   - If subject contains `[SHIPPING]`
   - Apply label: "Store - Shipping"
   - Priority: High

3. **Filter: Donations**
   - If subject contains `[DONATION]`
   - Apply label: "Store - Donations"
   - Priority: Low

---

## Email Template Customization

### Branding Elements
**Header:**
- Logo: (Document if custom logo is in email header)
- Organization name: Lexington Alarm
- Color scheme: Blue (#044f9d) and Red (#c3202e)

**Footer:**
- Organization mission statement
- Contact information
- Social media links
- Unsubscribe link (for marketing emails, not transactional)

### Customization Location
**Path:** WooCommerce → Settings → Emails → [Select Email Type] → Manage

**Available Customizations:**
- Subject line
- Heading
- Additional content (above order details)
- Footer text

### Email Colors
**From Email:** store@lexingtonalarm.org  
**Reply-To:** info@lexingtonalarm.org (or same as from)  
**Base Color:** Blue (#044f9d)  
**Background:** White (#ffffff)  
**Text Color:** Black

---

## SendLayer SMTP Configuration

### Plugin Settings
**Plugin Name:** (Document SMTP plugin name)  
**Location:** WordPress → Settings → Email (or plugin-specific settings)

**Configuration:**
- SMTP Host: (SendLayer host - document)
- SMTP Port: (Typically 587 or 465 - document)
- Encryption: TLS or SSL
- Authentication: Yes
- Username: (SendLayer username)
- Password: (Stored securely)

**From Email:** store@lexingtonalarm.org  
**From Name:** Lexington Alarm Store

### Deliverability
**Current Status:** Emails delivering reliably  
**Monitored Metrics:**
- Delivery rate
- Bounce rate
- Spam complaints

**SendLayer Dashboard:** Review regularly for delivery issues

### Email Limits
**SendLayer Plan:** (Document plan tier)  
**Monthly Limit:** (Number of emails per month)  
**Current Usage:** (Monitor monthly to avoid hitting limit)

---

## Testing Email Delivery

### Test Procedure
1. **Place Test Order:**
   - Use Stripe test card: 4242 4242 4242 4242
   - Complete full checkout process
   - Use real email address (not test@test.com)

2. **Check Customer Email:**
   - Verify new order confirmation received
   - Check correct category tag in subject
   - Verify all order details correct
   - Check links work (if any)
   - Verify from address and branding

3. **Check Admin Email:**
   - Verify admin notification received
   - Check category tag
   - Verify admin link to order works
   - Check all order details present

4. **Check Spam Folders:**
   - If not in inbox, check spam/junk
   - If in spam, may need to adjust email authentication

### Email Authentication
**SPF Record:** (Document if configured for lexingtonalarm.org)  
**DKIM:** (Document if configured)  
**DMARC:** (Document if configured)

**Purpose:** Improve deliverability, prevent emails going to spam

**Configuration:** Typically done in domain DNS settings with SendLayer values

---

## Common Email Issues

### Customer Not Receiving Emails
**Troubleshooting Steps:**
1. Check spam/junk folder
2. Verify email address correct in order
3. Check SendLayer dashboard for delivery status
4. Test with different email provider (Gmail vs. Outlook vs. ProtonMail)
5. Verify SMTP plugin settings correct

### Emails Going to Spam
**Possible Causes:**
- Email authentication not configured (SPF/DKIM)
- From address not matching domain
- Content triggers spam filters
- SendLayer IP reputation issue

**Solutions:**
- Configure SPF/DKIM records
- Use consistent from address
- Avoid spam trigger words in subject/content
- Contact SendLayer support if IP issue

### Emails Not Sending At All
**Possible Causes:**
- SMTP plugin misconfigured
- SendLayer credentials incorrect
- SendLayer monthly limit reached
- WordPress/plugin conflict

**Solutions:**
- Test SMTP connection in plugin settings
- Verify SendLayer credentials
- Check SendLayer dashboard for account status
- Deactivate other plugins to test for conflict

### Wrong Category Tag
**Possible Causes:**
- Shipping class not assigned to product
- Multiple shipping classes in same order (shouldn't happen with validation)
- Category tag logic not properly configured

**Solutions:**
- Verify product shipping class assignments
- Review category tag conditional logic
- Test with single-product orders of each type

---

## Email Personalization

### Available Merge Tags
WooCommerce provides merge tags for personalizing emails:

- `{site_title}` - Site name (Lexington Alarm)
- `{order_date}` - Order date
- `{order_number}` - Order number
- `{customer_first_name}` - Customer's first name
- `{customer_last_name}` - Customer's last name
- `{customer_email}` - Customer's email
- `{order_total}` - Total order amount
- (More available - document as used)

**Usage:** Insert merge tags in email template customization areas

---

## Order Note System

### Customer-Visible Notes
**Use Case:** Communicate updates directly to customer via email

**How to Add:**
1. WooCommerce → Orders → [Select Order]
2. Order Notes section
3. Type note
4. Check "Customer note"
5. Add note - email sent automatically

**Example Uses:**
- "Your order is ready for pickup. Please call 555-1234 to schedule."
- "Shipping update: Your order will ship tomorrow with tracking provided."
- "Thank you for your donation supporting our mission!"

### Private Admin Notes
**Use Case:** Internal notes not visible to customer

**How to Add:**
1. Same process as above
2. Leave "Customer note" unchecked
3. Add note - no email sent

**Example Uses:**
- "Contacted customer about pickup time"
- "Special request: Add extra bumper sticker"
- "Donation for rally support"

---

## Future Enhancements

### Planned Improvements
- [ ] Add pickup location map/directions to local pickup emails
- [ ] Include estimated shipping timeline in shipping emails
- [ ] Add social sharing buttons to completion emails
- [ ] Include related products/upsells in order emails
- [ ] Automated follow-up email sequence (feedback request, newsletter signup)

### Under Consideration
- [ ] SMS notifications for order status (via plugin)
- [ ] Order tracking integration for shipped orders
- [ ] Automated review request email after delivery
- [ ] Personalized recommendations based on purchase history

---

## Change History

### 2024 Q4
- Implemented category tag system ([LOCAL PICKUP], [SHIPPING], [DONATION])
- Customized email templates for brand consistency
- Configured email filtering recommendations
- (Document other changes)

### 2024 Q3
- Configured SendLayer SMTP for reliable delivery
- Set up WooCommerce email notifications
- Created custom email templates
- Established from address (store@lexingtonalarm.org)

---

**Related Documentation:**
- `02_Store_System/WooCommerce_Setup.md` - Overall store setup
- `02_Store_System/Checkout_Flow.md` - Order processing workflow
- `03_Email_Systems/Transactional_Email.md` - SendLayer configuration details
- `01_Technical_Foundation/Plugins_And_Integrations.md` - SMTP plugin info
