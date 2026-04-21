# Mailchimp RSS Newsletter Archive Setup

## What This Does

Automatically pulls your official newsletters from Mailchimp and displays them on your website. **Zero manual updates needed** - when you send a newsletter, it appears on your site within 12 hours (or instantly if you clear the cache).

---

## Architecture Overview

```
┌──────────────────────────────────────────────────────────────┐
│  MAILCHIMP                                                   │
├──────────────────────────────────────────────────────────────┤
│                                                              │
│  You send campaigns with consistent naming:                  │
│                                                              │
│  ✅ "Newsletter - October 2025"                              │
│  ✅ "Newsletter - September 2025"                            │
│  ❌ "URGENT: Rally Tomorrow"  (not a newsletter)             │
│  ❌ "Save the Date: April 19" (not a newsletter)             │
│                                                              │
│  Mailchimp automatically creates RSS feed with all campaigns │
└──────────────────────────────────────────────────────────────┘
                            ↓
                    (RSS Feed URL)
                            ↓
┌──────────────────────────────────────────────────────────────┐
│  YOUR WORDPRESS SITE                                         │
├──────────────────────────────────────────────────────────────┤
│                                                              │
│  Custom shortcode:                                           │
│  1. Fetches RSS feed from Mailchimp                          │
│  2. Filters for campaigns starting with "Newsletter -"       │
│  3. Displays in your branded archive format                  │
│  4. Caches results for 12 hours (performance)                │
│                                                              │
│  Result: Automatic, always up-to-date newsletter archive     │
└──────────────────────────────────────────────────────────────┘
```

---

## Step 1: Find Your Mailchimp RSS Feed URL

### Option A: Direct Method (Easiest)

1. **Log into Mailchimp**
2. **Send yourself a test campaign** (or use an existing one)
3. **Open the email**
4. **Look for "view this email in your browser" link**
5. **Click it** - the URL will look like:
   ```
   https://mailchi.mp/lexingtonalarm/some-campaign-name
   ```
6. **Replace the beginning** with:
   ```
   https://us12.campaign-archive.com/feed?u=...
   ```

### Option B: Through Mailchimp Dashboard

1. **Log into Mailchimp**
2. **Go to:** Audience → Manage Audience → Settings
3. **Click:** Audience name and campaign defaults
4. **Find:** 
   - **List ID** (looks like: `1a2b3c4d5e`)
   - **Account data center** (look at your Mailchimp URL, like `us12.admin.mailchimp.com`)

Your RSS feed URL format:
```
https://[DATA_CENTER].campaign-archive.com/feed?u=[USER_ID]&id=[LIST_ID]
```

Example:
```
https://us12.campaign-archive.com/feed?u=abc123def456&id=1a2b3c4d5e
```

### Option C: Look at Existing Campaign URL

1. **Go to any sent campaign**
2. **View the archive link** - looks like:
   ```
   https://us12.campaign-archive.com/?u=abc123&id=campaign123
   ```
3. **Change to RSS format:**
   ```
   https://us12.campaign-archive.com/feed?u=abc123&id=LIST_ID
   ```
   
**Note:** The `u=` parameter in campaign URLs is your USER_ID. You still need your LIST_ID from Audience settings.

---

## Step 2: Test Your RSS Feed

1. **Copy your RSS feed URL**
2. **Paste into browser**
3. **You should see XML** with all your campaigns:

```xml
<?xml version="1.0"?>
<rss version="2.0">
  <channel>
    <title>Lexington Alarm Campaigns</title>
    <item>
      <title>Newsletter - September 2025</title>
      <link>https://mailchi.mp/...</link>
      <pubDate>Thu, 26 Sep 2025 10:30:00 GMT</pubDate>
    </item>
    <item>
      <title>URGENT: Rally Tomorrow</title>
      <link>https://mailchi.mp/...</link>
      <pubDate>Mon, 15 Sep 2025 14:00:00 GMT</pubDate>
    </item>
  </channel>
</rss>
```

**If you get an error or blank page:** Your URL is incorrect. Double-check the data center and IDs.

---

## Step 3: Standardize Your Newsletter Naming

**From now on, name all official newsletters like this:**

```
Newsletter - [Month] [Year]

Examples:
✅ Newsletter - October 2025
✅ Newsletter - November 2025
✅ Newsletter - December 2025
```

**Everything else should NOT start with "Newsletter -":**

```
❌ Newsletter - URGENT Rally  (don't do this)
✅ URGENT: Rally Tomorrow
✅ Save the Date: April 19
✅ Meeting Reminder - Oct 15
```

**Why?** The WordPress shortcode filters for campaigns starting with "Newsletter -" so only official newsletters appear in the archive.

---

## Step 4: Add Shortcode to WordPress

1. **Go to:** WordPress Admin → Snippets → Add Snippet
2. **Title:** "Mailchimp RSS Newsletter Archive"
3. **Code Type:** PHP Snippet
4. **Paste the code from:** `MAILCHIMP_RSS_ARCHIVE_SHORTCODE.php`
5. **Find this line near the top:**
   ```php
   $rss_url = 'REPLACE_WITH_YOUR_MAILCHIMP_RSS_URL';
   ```
6. **Replace with your actual RSS URL:**
   ```php
   $rss_url = 'https://us12.campaign-archive.com/feed?u=abc123&id=xyz789';
   ```
7. **Location:** Run Everywhere
8. **Activate:** Toggle to ON
9. **Click:** Update

---

## Step 5: Update Your News Page

**Replace the existing `[newsletter_archive]` shortcode with:**

```html
[mailchimp_newsletter_archive]
```

**Full News page code:**

```html
<!-- wp:html -->
<div class="news-page-wrapper">
    
    <!-- FEATURED STORY -->
    <div class="featured-story-section">
        <h2 class="section-title">FEATURED STORY</h2>
        [featured_story]
    </div>
    
    <!-- SUBSCRIBE BANNER -->
    <div class="subscribe-banner">
        <!-- ... your existing subscribe section ... -->
    </div>
    
    <!-- RECENT POSTS -->
    <div class="blog-posts-section">
        <h2 class="section-title">RECENT NEWS</h2>
        [blog_posts_grid]
    </div>
    
    <!-- NEWSLETTER ARCHIVE (NEW SHORTCODE) -->
    <div class="newsletter-archive-section">
        [mailchimp_newsletter_archive]
    </div>
    
</div>
<!-- /wp:html -->
```

---

## Step 6: Test It!

1. **Visit your News page**
2. **Scroll to Newsletter Archive section**
3. **You should see:**
   - Red "NEWSLETTER ARCHIVE" header
   - All campaigns that start with "Newsletter -"
   - Automatically filtered and sorted
   - Direct links to Mailchimp archive

---

## Maintenance: Zero Work Required!

### When You Send a Newsletter:

1. **Name it:** "Newsletter - [Month] [Year]"
2. **Send it** through Mailchimp
3. **That's it!** 

The newsletter will automatically appear on your website within **12 hours** (due to caching).

### To Force Immediate Update:

**As an admin, visit:**
```
https://yoursite.com/news/?clear_newsletter_cache=1
```

This clears the cache and forces a fresh fetch from Mailchimp.

---

## Configuration Options

Edit the WPCode snippet to customize:

### Newsletter Naming Pattern
```php
$newsletter_prefix = 'Newsletter -';
```
Change this if you want a different pattern.

### Maximum Number to Display
```php
$max_items = 24;  // Show up to 24 newsletters
```

### Cache Duration
```php
$cache_duration = 43200;  // 12 hours in seconds
```
- Longer = Better performance, slower updates
- Shorter = Faster updates, more server load

**Recommended:** Keep at 12 hours. Use the clear cache URL for immediate updates when needed.

---

## Retroactive Cleanup

**Your existing campaigns that ARE newsletters:**

You can rename them in Mailchimp:
1. Go to Campaigns
2. Click the campaign
3. Edit → Rename
4. Add "Newsletter - " prefix

**Or:** Leave them as-is, they just won't show in the archive automatically.

---

## Benefits of This Approach

✅ **Zero manual updates** - Completely automatic  
✅ **No API complexity** - Uses simple RSS  
✅ **Fast performance** - Built-in caching  
✅ **Free** - No Zapier or additional services  
✅ **Reliable** - RSS is a proven standard  
✅ **Flexible filtering** - Easy to adjust naming pattern  
✅ **Always current** - Pulls directly from Mailchimp  
✅ **Works with your existing setup** - No new plugins needed

---

## Troubleshooting

### "Error loading newsletter archive"
- Check your RSS feed URL in a browser
- Verify it shows XML with campaigns
- Make sure URL is correctly entered in the snippet

### "No newsletters available yet"
- Make sure you have campaigns that start with "Newsletter -"
- Check the $newsletter_prefix matches your naming
- Try clearing the cache with ?clear_newsletter_cache=1

### "Archive shows announcements too"
- Those campaigns probably start with "Newsletter -"
- Rename them in Mailchimp to something else
- Clear the cache

### Newsletters not appearing immediately
- Normal! Cache is set to 12 hours
- Use ?clear_newsletter_cache=1 to force refresh
- Or adjust $cache_duration in the code

---

## Alternative: Mailchimp API Method

If you want even more control (like filtering by tags instead of name pattern), I can create an API-based version. But this requires:
- API key configuration
- More complex code
- Potential rate limits

**The RSS method is simpler and works great for most needs.**

---

## Next Steps

1. ✅ Find your RSS feed URL
2. ✅ Test it in browser
3. ✅ Standardize newsletter naming going forward
4. ✅ Add snippet to WordPress
5. ✅ Update News page
6. ✅ Test!

**Time to set up: 15-20 minutes**  
**Ongoing maintenance: 0 minutes** (automatic!)

---

Ready to set this up? Start with Step 1 and work through each step.
