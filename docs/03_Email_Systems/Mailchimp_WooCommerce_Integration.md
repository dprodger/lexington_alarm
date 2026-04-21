# Mailchimp WooCommerce Integration - Configuration Guide
**Project:** Lexington Alarm  
**Date:** September 2024  
**Purpose:** Email marketing integration with WooCommerce store

---

## Overview

Integrating Mailchimp with WooCommerce for the Lexington Alarm store requires careful planning to:
1. Respect existing subscriber preferences
2. Properly tag customers for segmentation
3. Avoid re-subscribing users who have opted out
4. Maintain separate tracking for purchasers vs subscribers

---

## Customer/Subscriber Universe

### Scenario Matrix

| Scenario | Customer Status | Mailchimp Status | Tags to Apply | Welcome Ladder | Marketing Emails |
|----------|----------------|------------------|---------------|----------------|------------------|
| 1 | New Customer | New to Mailchimp | `new-subscriber`, `woo-purchase`, `2025` | YES (if opted in) | Only if opted in |
| 2 | New Customer | Existing Subscriber | ADD `woo-purchase` | NO | Continue normal |
| 3 | New Customer | Unsubscribed | ADD `woo-purchase` only | NO | NO (respect unsub) |
| 4 | New Customer | No opt-in | `woo-purchase`, `non-subscribed` | NO | NO |
| 5 | Repeat Customer | Any status | ADD `repeat-buyer` | NO | Based on status |

### Additional Edge Cases

**Gift Purchases**
- Billing email ≠ Recipient
- Tag: `gift-giver`
- Don't auto-subscribe recipient

**Bulk/Organization Orders**
- May use organization email
- Tags: `organization`, `bulk-buyer`
- Different follow-up sequence needed

**Seasonal Buyers**
- Only purchase for specific events
- Tags: `patriots-day-2025`, `july-4th`
- Target with holiday campaigns

**Activists vs Supporters**
- Demo signs = `activist`
- Single yard sign = `supporter`
- Multiple product types = `engaged`

---

## Critical Configuration Decisions

### Initial Sync Settings

**⚠️ RECOMMENDED SETTING:**
```
Import customers (initial sync): "Sync existing contacts only"
```

**Why:** This is the SAFEST option because it:
- Prevents accidentally re-subscribing people who unsubscribed
- Avoids creating duplicate contacts
- Only updates existing Mailchimp contacts with purchase data
- Respects your existing email list hygiene

### Ongoing Sync Settings

```
✓ Sync new non-subscribed contacts: YES
```

**Why:** This allows you to:
- Capture purchase data without forcing subscription
- Send transactional emails (order confirmations)
- Use for abandoned cart automation
- Target with ads/postcards if needed
- Maintain purchase history

### Opt-in Checkbox Configuration

**At Checkout:**
```
□ Join the Lexington Alarm Network for event updates, 
  250th anniversary news, and action alerts (2-4 emails/month)
```

**Default State:** UNCHECKED (legally safer, higher quality subscribers)

---

## Tagging Strategy

### Base Tags (All Customers)
```
woo-customer         - Anyone who purchases
2025                 - Purchased during 2025 campaign
[YYYY-MM]           - Purchase month for cohort analysis
```

### Status-Based Tags
```
new-subscriber       - First time in Mailchimp via purchase
existing-subscriber  - Already in list when purchased
unsubscribed-buyer  - Purchased but opted out of emails
non-subscribed      - Purchased without opting in
```

### Product-Based Tags
```
yard-sign           - Purchased yard signs
window-sign         - Purchased mailer signs
demo-sign          - Purchased rally signs
bulk-buyer         - Purchased 10+ items
high-value         - Order over $100
```

### Geographic Tags
```
local-customer      - Used local pickup
lexington-area     - Based on zip code
ships-outside      - Required shipping
national-supporter - Outside local area
```

### Engagement Tags
```
repeat-buyer       - Multiple purchases
activist           - Bought demonstration materials
supporter          - Single sign purchase
engaged            - Multiple product types
```

---

## Implementation Code

### Smart Tagging Function

```php
// Add to functions.php or custom plugin
add_action('woocommerce_checkout_order_processed', 'lexington_alarm_mailchimp_tags', 10, 3);

function lexington_alarm_mailchimp_tags($order_id, $posted_data, $order) {
    $email = $order->get_billing_email();
    $tags = array();
    
    // Base tags for all purchases
    $tags[] = 'woo-customer';
    $tags[] = '2025';
    $tags[] = date('Y-m'); // Tag with purchase month
    
    // Check if opted in to newsletter
    $opted_in = isset($_POST['mailchimp_woocommerce_newsletter']);
    
    if ($opted_in) {
        $tags[] = 'newsletter-signup';
    } else {
        $tags[] = 'non-subscribed';
    }
    
    // Geographic tags
    if ($order->has_shipping_method('local_pickup')) {
        $tags[] = 'local-customer';
        $tags[] = 'lexington-area';
    } else {
        $tags[] = 'ships-outside';
        $tags[] = 'national-supporter';
    }
    
    // Product-based tags
    $total_quantity = 0;
    foreach ($order->get_items() as $item) {
        $product = $item->get_product();
        $quantity = $item->get_quantity();
        $total_quantity += $quantity;
        
        // Product type tags
        if (strpos($product->get_name(), 'Yard Sign') !== false) {
            $tags[] = 'yard-sign';
        }
        if (strpos($product->get_name(), 'Window') !== false) {
            $tags[] = 'window-sign';
        }
        if (strpos($product->get_name(), 'Rally') !== false || 
            strpos($product->get_name(), 'Demonstration') !== false) {
            $tags[] = 'demo-sign';
            $tags[] = 'activist';
        }
    }
    
    // Quantity-based tags
    if ($total_quantity >= 25) {
        $tags[] = 'bulk-buyer';
        $tags[] = 'vip';
    } elseif ($total_quantity >= 10) {
        $tags[] = 'bulk-buyer';
    }
    
    // Value-based tags
    if ($order->get_total() > 100) {
        $tags[] = 'high-value';
    }
    
    // Apply tags via Mailchimp API
    // This would integrate with the Mailchimp for WooCommerce plugin
    do_action('mailchimp_apply_tags', $email, $tags);
}
```

### Conditional Field Display

```php
// Show/hide address fields for local pickup
add_action('woocommerce_before_checkout_billing_form', 'pickup_conditional_fields');

function pickup_conditional_fields() {
    ?>
    <script>
    jQuery(function($) {
        function toggleAddressFields() {
            var method = $('input[name^="shipping_method"]:checked').val();
            
            if (method && method.includes('local_pickup')) {
                // Hide full address for pickup
                $('#billing_address_1_field').hide();
                $('#billing_address_2_field').hide();
                $('#billing_postcode_field').hide();
                
                // Show pickup message
                $('#pickup-notice').show();
            } else {
                // Show all fields for shipping
                $('#billing_address_1_field').show();
                $('#billing_address_2_field').show();
                $('#billing_postcode_field').show();
                
                $('#pickup-notice').hide();
            }
        }
        
        $(document.body).on('updated_checkout', toggleAddressFields);
        toggleAddressFields();
    });
    </script>
    
    <div id="pickup-notice" style="display:none; background:#f0f0f0; padding:15px; margin-bottom:20px;">
        <strong>Local Pickup Selected</strong><br>
        We only need your town and contact info for pickup orders.
    </div>
    <?php
}
```

---

## Testing Strategy

### Phase 1: Test Audience Setup

1. **Create Test Audience in Mailchimp**
   - Name: "LA Test List"
   - Import 5-10 test emails
   - Include various statuses (subscribed, unsubscribed, etc.)

2. **Connect WooCommerce to Test Audience**
   - Configure all settings as planned
   - Run initial sync

3. **Test Scenarios**
   ```
   Test 1: New customer, opts in
   Test 2: New customer, doesn't opt in  
   Test 3: Existing subscriber purchases
   Test 4: Unsubscribed contact purchases
   Test 5: Repeat purchase
   Test 6: Bulk order
   ```

4. **Verify in Mailchimp**
   - Correct tags applied
   - Status respected (no resubscribing)
   - Welcome ladder triggers appropriately

### Phase 2: Production Rollout

1. **Pre-Launch Checklist**
   - [ ] Backup existing Mailchimp list
   - [ ] Document current subscriber count
   - [ ] Note unsubscribe count
   - [ ] Export list as CSV backup

2. **Connection Settings**
   ```
   Audience: LexingtonAlarm
   Initial Sync: Sync existing contacts only
   Ongoing: Sync non-subscribed contacts
   Base Tag: woo-customer
   ```

3. **Monitor First 48 Hours**
   - Check for unexpected resubscribes
   - Verify tag application
   - Monitor welcome ladder triggers
   - Review bounce/complaint rates

---

## Privacy & Legal Compliance

### Checkout Disclosure

```html
<div class="email-opt-in-disclosure">
    <label>
        <input type="checkbox" name="mailchimp_newsletter" value="1">
        <strong>Email me about events and updates</strong>
    </label>
    <p style="font-size:12px; margin-left:24px;">
        You'll receive:
        • 250th anniversary event notifications
        • Calls to action when democracy needs defending
        • New product announcements (max 1/month)
        <br><br>
        We respect your privacy and never share your information.
        Unsubscribe anytime. Typically 2-4 emails per month.
        <br><br>
        <em>Note: You'll receive order confirmations regardless 
        of newsletter subscription.</em>
    </p>
</div>
```

### Required Policies

1. **Privacy Policy** - Must include:
   - What data is collected
   - How it's used
   - Mailchimp as processor
   - Right to deletion

2. **Terms of Service** - Should cover:
   - Purchase terms
   - Email communications
   - Dispute resolution

---

## Mailchimp Automation Recommendations

### Welcome Series (Existing)
Your existing welcome ladder should trigger for:
- New subscribers who opt in at checkout
- Tag trigger: `new-subscriber` + `newsletter-signup`

### Purchase Follow-up Series (New)
Create automation for:
- All purchases regardless of subscription
- Tag trigger: `woo-customer`
- Emails:
  1. Order confirmation (immediate)
  2. Pickup/shipping info (immediate)
  3. Thank you + mission reminder (day 3)
  4. Share photo of sign (day 7)
  5. Invite to subscribe (day 14, if not subscribed)

### Abandoned Cart Series
- Requires non-subscribed contact sync
- 3-email series over 7 days
- Include urgency for 250th anniversary

---

## Key Decision Points

### Must Decide Before Going Live:

1. **Initial Sync Method**
   - Recommended: "Sync existing contacts only" ✓
   - Alternative: "Sync as non-subscribed" (riskier)

2. **Opt-in Default**
   - Recommended: Unchecked (quality over quantity) ✓
   - Alternative: Pre-checked (more subscribers, legal risk)

3. **Tag Structure**
   - Implement full tagging system (recommended) ✓
   - Or start simple with just `woo-customer`

4. **Unsubscribed Handling**
   - Never resubscribe (recommended) ✓
   - Allow purchase to re-engage (risky)

5. **Welcome Series**
   - Only for new opt-ins (recommended) ✓
   - Or for all purchasers (may annoy)

---

## Support Resources

- Mailchimp for WooCommerce Documentation: https://mailchimp.com/help/connect-or-disconnect-mailchimp-for-woocommerce/
- Mailchimp API Reference: https://mailchimp.com/developer/
- WooCommerce Hooks: https://woocommerce.github.io/code-reference/
- GDPR Compliance: https://mailchimp.com/help/about-gdpr/

---

## Next Steps

1. [ ] Install Mailchimp for WooCommerce plugin
2. [ ] Create test audience in Mailchimp
3. [ ] Configure and test with test audience
4. [ ] Implement custom tagging code
5. [ ] Create purchase follow-up automation
6. [ ] Test all scenarios
7. [ ] Switch to production audience
8. [ ] Monitor first week closely

---

**Critical Warning:** Always test with a separate Mailchimp audience first. Incorrect settings can damage list hygiene and trigger spam complaints from unintended resubscribes.