# Email Subject Line Examples - Quick Reference

**Purpose:** Show exactly what email subjects will look like for different order types

---

## Current vs Enhanced Email Subjects

### SHIPPING ORDERS

**Current (Order #838 - 5 pack):**
```
Subject: [Lexington Alarm!]: You've got a new order: #838
```

**Enhanced:**
```
Subject: [SHIPPING] [Lexington Alarm!]: You've got a new order: #838
```

**Why This Matters:**
- Immediately clear that ORDER NEEDS TO BE MAILED
- No need to open email to know action required
- Can filter inbox by "[SHIPPING]" to see what needs packing
- Shippo workflow: Look for [SHIPPING] orders to generate labels

---

### LOCAL PICKUP ORDERS

**Current (Order #825 - Single yard sign):**
```
Subject: [Lexington Alarm!]: You've got a new order: #825
```

**Enhanced:**
```
Subject: [LOCAL PICKUP] [Lexington Alarm!]: You've got a new order: #825
```

**Why This Matters:**
- Coordinator knows to arrange porch pickup
- No shipping label needed
- Different workflow than shipping

---

### DONATION ORDERS

**Current (Order #820 - $25 donation):**
```
Subject: [Lexington Alarm!]: You've got a new order: #820
```

**Enhanced:**
```
Subject: [DONATION] [Lexington Alarm!]: You've got a new order: #820
```

**Why This Matters:**
- No fulfillment action needed
- Just acknowledge payment
- Different thank you process

---

## Real-World Inbox View

**What your inbox will look like with 10 orders:**

```
📧 Inbox (10 unread)

[SHIPPING] [Lexington Alarm!]: You've got a new order: #841     ← Pack & mail
[LOCAL PICKUP] [Lexington Alarm!]: You've got a new order: #840 ← Arrange pickup
[SHIPPING] [Lexington Alarm!]: You've got a new order: #839     ← Pack & mail
[SHIPPING] [Lexington Alarm!]: You've got a new order: #838     ← Pack & mail  ⭐ This one!
[DONATION] [Lexington Alarm!]: You've got a new order: #837     ← Just thanks
[LOCAL PICKUP] [Lexington Alarm!]: You've got a new order: #836 ← Arrange pickup
[SHIPPING] [Lexington Alarm!]: You've got a new order: #835     ← Pack & mail
[LOCAL PICKUP] [Lexington Alarm!]: You've got a new order: #834 ← Arrange pickup
[SHIPPING] [Lexington Alarm!]: You've got a new order: #833     ← Pack & mail
[DONATION] [Lexington Alarm!]: You've got a new order: #832     ← Just thanks
```

**At a glance:**
- 5 orders need shipping (highest priority - time-sensitive)
- 3 orders need pickup coordination
- 2 donations just need acknowledgment

---

## Gmail Search Filters

**To see only shipping orders:**
```
subject:[SHIPPING]
```

**To see only pickup orders:**
```
subject:[LOCAL PICKUP]
```

**To see all orders needing physical action:**
```
subject:[SHIPPING] OR subject:[LOCAL PICKUP]
```

**To exclude donations from order list:**
```
subject:"new order" -subject:[DONATION]
```

---

## Customer vs Admin Emails

### Customer Confirmation Email

**Shipping Order Subject:**
```
Subject: [SHIPPING] Order #838 confirmation - Lexington Alarm
```

**Email Body Includes:**
```
┌──────────────────────────────────────┐
│ 📦 Shipping Information              │
│                                      │
│ Your order will ship by the next    │
│ business day. You'll receive         │
│ tracking information via email once  │
│ your package is on its way.          │
└──────────────────────────────────────┘

[Order details table...]
```

### Admin New Order Email

**Subject:**
```
Subject: [SHIPPING] [Lexington Alarm!]: You've got a new order: #838
```

**This is the key improvement - you know immediately what action to take!**

---

## Benefits Summary

### Time Savings
- **Before:** Open every email to see what needs doing
- **After:** Know at a glance from subject line

### Workflow Efficiency
- **Before:** Read through order details to determine fulfillment type
- **After:** Filter inbox by [SHIPPING] and process batch

### Error Prevention
- **Before:** Easy to miss that order needs shipping
- **After:** Visual indicator prevents oversights

### Priority Management
- **Before:** All orders look equally urgent
- **After:** Shipping orders clearly flagged as time-sensitive

---

## Integration with Other Tools

### When Shippo is Added:
```
Workflow:
1. Filter inbox: subject:[SHIPPING]
2. Open orders one by one
3. Click "Create Shipping Label" in Shippo
4. Print labels for batch
5. Pack all shipping orders
6. Mark as fulfilled
```

### When Coordinator System is Added:
```
Workflow for [LOCAL PICKUP]:
1. Automatic email to coordinator
2. Coordinator arranges porch drop
3. Customer gets pickup instructions
4. Mark as fulfilled when picked up
```

---

## Edge Cases

### Mixed Orders
**Scenario:** Customer orders 1 single sign (pickup) + 1 5-pack (shipping)  

**Current Behavior:**
```
Subject: [LOCAL PICKUP] [Lexington Alarm!]: You've got a new order: #838
```
*(Shows pickup because it has priority)*

**Future Enhancement:**
```
Subject: [MIXED ORDER] [Lexington Alarm!]: You've got a new order: #838
```
*(Could add this prefix for orders with both types)*

### Donation + Physical Product
**Scenario:** Customer donates $25 AND orders a sign  

**Behavior:**
```
Subject: [LOCAL PICKUP] [Lexington Alarm!]: You've got a new order: #838
```
*(Physical fulfillment takes priority)*

---

## Mobile View

**On Phone Email Client:**

Short subject lines are truncated, so prefix comes first:

```
[SHIPPING] [Lexington Alarm!...
[LOCAL PICKUP] [Lexington Al...
[DONATION] [Lexington Alarm!...
```

Even on small screens, you immediately see order type!

---

## Comparison Chart

| Aspect | Before Enhancement | After Enhancement |
|--------|-------------------|-------------------|
| Shipping visibility | Not visible until email opened | Visible in subject line |
| Inbox filtering | Not possible | Filter by [SHIPPING] |
| Action priority | All orders equal | Shipping clearly flagged |
| Processing time | ~30 sec per email to determine | ~5 sec from subject line |
| Error risk | High (easy to miss shipping) | Low (visual indicator) |
| Batch processing | Difficult | Easy (filter + process) |
| Mobile usability | Poor (must open each) | Good (see type in list) |

---

## Testing Checklist

After implementation, send test orders and verify:

- [ ] **Shipping order** shows `[SHIPPING]` in subject
- [ ] **Pickup order** shows `[LOCAL PICKUP]` in subject  
- [ ] **Donation** shows `[DONATION]` in subject
- [ ] **Gmail filter** `subject:[SHIPPING]` works correctly
- [ ] **Mobile view** shows prefix clearly
- [ ] **Customer emails** also have prefix
- [ ] **Admin emails** have prefix

---

## Quick Implementation Reminder

**Current Issue:** Order #838 (5-pack) doesn't indicate it needs shipping

**Solution Files:**
- `01a_category_email_labels_ENHANCED.php` - New snippet to install
- `PRODUCT_CATEGORIES_GUIDE.md` - Category documentation
- `SHIPPING_ENHANCEMENT_IMPLEMENTATION.md` - Full setup guide

**Next Action:**
1. Install enhanced snippet in WPCode
2. Deactivate old snippet
3. Verify product categories
4. Test with new order

---

**Result:** Clear, scannable email subjects that immediately communicate fulfillment requirements!
