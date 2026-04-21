# Simple Newsletter Archive - Just Paste URLs

## Super Simple Setup (5 minutes)

### Step 1: Get Your Newsletter URLs

1. **Log into Mailchimp**
2. **Go to a sent newsletter**
3. **Find "View in browser" or "View archive" link**
4. **Copy the URL** - looks like:
   ```
   https://mailchi.mp/lexingtonalarm/your-newsletter-name
   ```
5. **Do this for each newsletter** you want in the archive

---

### Step 2: Add the Code to WordPress

1. **Go to:** WordPress Admin → Snippets → Add Snippet
2. **Title:** "Simple Newsletter Archive"
3. **Code Type:** PHP Snippet
4. **Paste** the entire code from `SIMPLE_MANUAL_NEWSLETTER_ARCHIVE.php`
5. **Location:** Run Everywhere
6. **Activate**

---

### Step 3: Paste Your URLs

In the code you just pasted, find this section near the top:

```php
$newsletters = array(
    
    // Newsletter URLs - ADD NEW ONES AT THE TOP
    
    'https://mailchi.mp/lexingtonalarm/burlington-to-vote-on-ice-facility-oct-18th-work-meeting-is-monday-9-29',
    
    // Add more URLs below, one per line
    
);
```

**Just add your URLs like this:**

```php
$newsletters = array(
    
    'https://mailchi.mp/lexingtonalarm/october-2025',
    'https://mailchi.mp/lexingtonalarm/september-2025',
    'https://mailchi.mp/lexingtonalarm/august-2025',
    'https://mailchi.mp/lexingtonalarm/july-2025',
    
);
```

**Rules:**
- ✅ One URL per line
- ✅ Wrap each URL in single quotes: `'URL'`
- ✅ Put a comma after each one (except the last)
- ✅ Newest newsletter goes at the TOP

---

### Step 4: Save and Test

1. **Click "Update"** in WPCode
2. **Visit your News page**
3. **Scroll to newsletter archive**
4. **You should see all your newsletters listed!**

---

## Adding New Newsletters (30 seconds)

When you send a new newsletter:

1. **Get the "View in browser" URL** from Mailchimp
2. **Edit the WPCode snippet**
3. **Add the URL at the TOP:**

```php
$newsletters = array(
    
    'https://mailchi.mp/lexingtonalarm/NEW-NEWSLETTER-URL',  ← ADD THIS
    'https://mailchi.mp/lexingtonalarm/october-2025',
    'https://mailchi.mp/lexingtonalarm/september-2025',
    
);
```

4. **Click Update**
5. **Done!**

---

## What It Looks Like

```
╔═══════════════════════════════════════╗
║                                       ║
║      NEWSLETTER ARCHIVE               ║
║                                       ║
╚═══════════════════════════════════════╝

📧  Newsletter
    View Archive
    View in Browser →

─────────────────────────────────────

📧  Newsletter
    View Archive
    View in Browser →

─────────────────────────────────────

📧  Newsletter
    View Archive
    View in Browser →
```

---

## Current State

Your existing shortcode in the News page:
```html
[newsletter_archive]
```

**No changes needed to the News page!** The new code uses the same shortcode name, so it will just work.

---

## FAQ

**Q: Can I customize the title/date for each newsletter?**

A: Yes! I can show you how to add titles and dates. For now, it just says "Newsletter" and "View Archive" for simplicity.

**Q: What if I want to remove a newsletter from the archive?**

A: Just delete that URL line from the array. Easy!

**Q: Do I need to keep them in order?**

A: The top one appears first in the archive. So yes, add newest at the top for reverse chronological order.

**Q: Can I add newsletters I sent months/years ago?**

A: Absolutely! Just find the archive URL in Mailchimp and add it to the list.

---

## Next Step

**Just paste this URL list to start:**

Go find 3-5 of your recent newsletter archive URLs from Mailchimp and paste them into the array. Then click Update and test!

Need help finding the URLs in Mailchimp? Let me know which screen you're looking at.
