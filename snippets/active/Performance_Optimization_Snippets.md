# Lexington Alarm - Performance Optimization Snippets

**Site:** lexingtonalarm.org  
**Implemented:** December 27, 2025  
**Platform:** WordPress with WPCode

---

## Performance Results Summary

| Metric | Before | After | Improvement |
|--------|--------|-------|-------------|
| **Total Requests** | 92 | 34 | **-63%** |
| **Page Size** | 683 KB | 661 KB | -3% |
| **YouTube Requests** | 24 | 2 | **-92%** |
| **Tockify Requests** | 10 | 0 | **-100%** |
| **WooCommerce Requests** | 12 | 3 | **-75%** |
| **Stripe on Home Page** | Active | Blocked | **-100%** |

---

## Active Performance Snippets

### 1. Performance - Disable WordPress Emoji
**Status:** ✅ Active  
**Priority:** 10  
**Location:** Run Everywhere

**What It Does:**
- Removes emoji detection scripts from frontend
- Removes emoji styles
- Removes DNS prefetch for emoji CDN
- Removes from TinyMCE editor, RSS feeds, and emails

**Impact:** Eliminates ~2 unnecessary requests per page load

---

### 2. Performance - YouTube Lite Embed v2
**Status:** ✅ Active  
**Priority:** 10  
**Location:** Run Everywhere

**What It Does:**
- Provides `[youtube_lite]` shortcode for lazy-loaded YouTube embeds
- Shows thumbnail image instead of full iframe until clicked
- Auto-converts existing YouTube iframes in post content
- Supports custom aspect ratios for vertical videos (YouTube Shorts)

**Shortcode Usage:**
```
[youtube_lite id="VIDEO_ID"]
[youtube_lite id="VIDEO_ID" width="100%" aspect="9/16"]
```

**Functions:** `lexalarm_yt_lite_shortcode()`, `lexalarm_yt_lite_assets()`, `lexalarm_convert_yt_embeds()`

**Impact:** Reduces YouTube from 24 requests to 2 (thumbnails only until clicked)

---

### 3. Performance - Conditional Tockify Loading
**Status:** ✅ Active  
**Priority:** 5  
**Location:** Run Everywhere

**What It Does:**
- Blocks Tockify scripts on non-events pages
- Only loads Tockify on pages containing 'tockify' in content or on Events/Calendar pages

**Impact:** Eliminates 10 Tockify requests on home page

---

### 4. Performance - Conditional WooCommerce Assets
**Status:** ✅ Active  
**Priority:** 99  
**Location:** Run Everywhere

**What It Does:**
- Loads WooCommerce CSS/JS only on shop, cart, checkout, and product pages
- Removes cart fragments AJAX on non-cart pages
- Blocks Stripe scripts on non-checkout pages
- Removes WooCommerce blocks styles on non-shop pages

**Dequeued Assets:**
- `woocommerce-general`, `woocommerce-layout`, `woocommerce-smallscreen`
- `wc-cart-fragments`, `wc-add-to-cart`, `wc-add-to-cart-variation`
- `wc-product-addons`, `stripe_v3`, `wc-order-attribution`

**Impact:** Reduces WooCommerce from 12 requests to 3 on non-shop pages; blocks Stripe entirely on home page

---

### 5. Performance - Preconnect Resource Hints
**Status:** ✅ Active  
**Priority:** 1  
**Location:** Run Everywhere

**What It Does:**
- Adds preconnect hints for frequently used external resources
- Conditional preconnects for YouTube (only if video content detected)
- Adds `display=swap` to Google Fonts for better font loading

**Preconnected Domains:**
- `fonts.googleapis.com`
- `fonts.gstatic.com`
- `plausible.io`
- `i.ytimg.com` (conditional)
- `youtube-nocookie.com` (conditional)

**Impact:** Reduces connection time for external resources

---

### 6. Performance - Cleanup Redundant Scripts
**Status:** ✅ Active  
**Priority:** 99  
**Location:** Run Everywhere

**What It Does:**
- Removes Dashicons CSS for non-logged-in users
- Removes query strings from static resources (better caching)
- Defers non-critical JavaScript
- Removes unnecessary WordPress head elements:
  - oEmbed discovery links
  - REST API links
  - Windows Live Writer manifest
  - RSD link
  - Shortlink
  - Adjacent post links
  - Generator meta tag

**Impact:** Cleaner HTML head, fewer requests, better caching

---

## Feature Snippet

### Feature - Upcoming Events Widget v2
**Status:** ✅ Active  
**Priority:** 10  
**Location:** Run Everywhere

**What It Does:**
- Provides `[upcoming_events]` shortcode to display Tockify events
- Fetches events from Tockify JSON-LD schema (not full widget)
- Caches results for 2 hours (configurable)
- Displays event cards with date badge, title, time, location
- Adds admin toolbar button to clear cache

**Shortcode Usage:**
```
[upcoming_events count="3"]
[upcoming_events count="5" cache_hours="1"]
```

**Functions:** `lexalarm_events_shortcode()`, `lexalarm_events_styles()`, `lexalarm_add_clear_events_cache()`

**Impact:** Replaces 326 KB Tockify widget with ~2 KB cached HTML

---

## Home Page Updates Required

After enabling snippets, update home page HTML:

1. **Remove Tockify script tag:**
```html
<!-- DELETE THIS -->
<script data-cfasync="false" data-tockify-script="embed" 
        src="https://public.tockify.com/browser/embed.js"></script>
```

2. **Replace Tockify embed with shortcode:**
```html
[upcoming_events count="3"]
```

3. **Use YouTube Lite for vertical video:**
```html
<div style="max-width: 300px; margin: 0 auto;">
    [youtube_lite id="biSHMU6aXZY" width="100%" aspect="9/16"]
</div>
```

4. **Fix any local URLs** - change `http://la-wordpress-local.local/...` to `/...`

---

## Troubleshooting

### Events Not Showing
1. Check WordPress timezone in Settings → General (should be UTC-5 or America/New_York)
2. Clear events cache via admin toolbar button "🗓 Clear Events Cache"
3. Verify Tockify calendar has future events at tockify.com/lexingtonalarm

### YouTube Lite Not Working
1. Verify snippet is active
2. Check for PHP errors in WPCode
3. Function names use `lexalarm_` prefix to avoid conflicts

### WooCommerce Assets Loading Everywhere
1. Check snippet priority is 99
2. Verify no caching plugin is serving stale pages
3. Clear all caches after enabling snippet

---

## Export File

**Filename:** `wpcode-performance-snippets-fixed.json`  
**Contains:** All 7 performance/feature snippets  
**Import via:** WPCode → Tools → Import

**Note:** Snippets import as inactive - activate each one after import.

---

**Document Version:** 1.0  
**Created:** December 27, 2025
