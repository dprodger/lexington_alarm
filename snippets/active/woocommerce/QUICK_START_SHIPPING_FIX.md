# 🚀 QUICK START: Fix Shipping Order Email Headers

**Problem:** Order #838 (5-pack) email doesn't indicate it needs shipping  
**Solution:** Enhanced email prefixes + admin visibility  
**Time:** 15 minutes  

---

## ⚡ Fast Track Implementation

### 1️⃣ Install New Snippet (5 min)

**WPCode → Add New → PHP Snippet**

```
Name: Enhanced Category Email Labels v2.1
File: 01a_category_email_labels_ENHANCED.php
Location: Run Everywhere
Status: Activate
```

**Then deactivate old snippet:** "Category Email Labels - Fixed"

### 2️⃣ Fix Product Categories (5 min)

**For ALL shipping products:**

| Product | Category | Shipping Class |
|---------|----------|----------------|
| 5-pack (LEX-YS-5PK) | ✓ Shipping | Shippable Items |
| 10-pack (LEX-YS-10PK) | ✓ Shipping | Shippable Items |
| 15-pack (LEX-YS-15PK) | ✓ Shipping | Shippable Items |
| 25-pack (LEX-YS-25PK) | ✓ Shipping | Shippable Items |
| Window sign (LEX-WS-1218) | ✓ Shipping | Shippable Items |

### 3️⃣ Test It (5 min)

**Test URL:**
```
yoursite.com/?test_order_type=true&order_id=838
```

**Expected Result:**
```
Modified Subject: [SHIPPING] [Lexington Alarm!]: You've got a new order: #838
```

---

## 📧 What Changes

### Email Subject Lines

**Before:**
```
[Lexington Alarm!]: You've got a new order: #838
```

**After:**
```
[SHIPPING] [Lexington Alarm!]: You've got a new order: #838
[LOCAL PICKUP] [Lexington Alarm!]: You've got a new order: #837
[DONATION] [Lexington Alarm!]: You've got a new order: #836
```

### Admin Order List

New "Type" column with badges:
- 🔵 **SHIP** - Needs packing/mailing
- 🔴 **PICKUP** - Arrange porch pickup
- 🟢 **DONATION** - No action needed

### Order Detail Page

Big notice box for shipping orders:
```
┌────────────────────────────────────┐
│ 📦 SHIPPING ORDER - ACTION REQUIRED │
│ Ship by next business day           │
└────────────────────────────────────┘
```

---

## 🎯 Benefits

✅ **Instant Visibility** - Know from subject line  
✅ **Inbox Filtering** - Filter by `[SHIPPING]`  
✅ **Error Prevention** - Can't miss shipping orders  
✅ **Batch Processing** - Process all shipping at once  
✅ **Mobile Friendly** - Prefix shows even on phone  

---

## 📝 Three Product Categories

### [SHIPPING] - Ships Next Business Day
**Products:**
- All bulk packs (5, 10, 15, 25)
- Window sign mailers
- Any product with "Shippable Items" class

**What happens:**
- Email says `[SHIPPING]` in subject
- Customer told "ships next business day"
- Needs Shippo label
- Tracking number sent

### [LOCAL PICKUP] - 24/7 Porch Pickup
**Products:**
- Single yard signs
- Rally signs
- Products with "Local Pickup Only" class

**What happens:**
- Email says `[LOCAL PICKUP]` in subject
- Customer told "instructions within 24 hours"
- Coordinator arranges drop-off
- No tracking needed

### [DONATION] - No Fulfillment
**Products:**
- Virtual donations
- No physical product

**What happens:**
- Email says `[DONATION]` in subject
- Just acknowledge payment
- No fulfillment action

---

## 🔍 Gmail Filters

**See only shipping orders:**
```
subject:[SHIPPING]
```

**See orders needing action:**
```
subject:[SHIPPING] OR subject:[LOCAL PICKUP]
```

---

## 🐛 Troubleshooting

**Email doesn't show prefix?**
1. Check snippet is activated
2. Check product has "Shipping" category
3. Use test URL to diagnose

**Wrong prefix showing?**
- Product in wrong category
- Fix: Edit product → Categories → Check correct one

---

## 📁 Complete Documentation

**Read these for full details:**

1. **SHIPPING_ENHANCEMENT_IMPLEMENTATION.md**  
   Complete installation guide with screenshots

2. **PRODUCT_CATEGORIES_GUIDE.md**  
   Everything about categories and classification

3. **EMAIL_SUBJECT_EXAMPLES.md**  
   Visual examples of what emails will look like

4. **01a_category_email_labels_ENHANCED.php**  
   The actual code to install

---

## ✅ Post-Implementation Checklist

After installation, verify:

- [ ] New snippet activated
- [ ] Old snippet deactivated
- [ ] 5-pack has "Shipping" category
- [ ] All bulk packs have "Shipping" category
- [ ] Window sign has "Shipping" category
- [ ] Test order shows `[SHIPPING]` in subject
- [ ] Admin order list shows type badges
- [ ] Gmail filter for `[SHIPPING]` works

---

## 🎓 How It Works

**Detection Order:**
1. Check shipping method selected (most reliable)
2. Check product category assignment
3. Check shipping class (backup)
4. Check if virtual product (donations)

**Priority Rules:**
- DONATION > LOCAL PICKUP > SHIPPING
- If order has multiple types, highest priority wins

---

## 🚀 Next Steps After This

**When ready:**
1. Add Shippo for automatic label generation
2. Add coordinator auto-routing for pickups
3. Add dashboard widget showing orders by type
4. Add order filtering by type in admin

---

## 📞 Support

**Files in:** `/wordpress working files/woocommerce_snippets/`

**Test command:**
```
?test_order_type=true&order_id=XXX
```

**Check logs:** `/wp-content/debug.log`

---

**Status:** ✅ Ready to implement  
**Priority:** 🔥 High  
**Impact:** Fixes Order #838 issue + all future shipping orders
