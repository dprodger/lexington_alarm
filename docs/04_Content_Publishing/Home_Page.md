# Home Page - Structure and Dynamic Content

**Page URL:** `/` (lexingtonalarm.org)  
**Page Type:** WordPress page with custom HTML blocks  
**Last Updated:** December 6, 2025

---

## Page Structure Overview

The home page uses a combination of static content sections and dynamic shortcodes to display content.

```
┌─────────────────────────────────────────┐
│           HERO/MISSION SECTION          │
│    - "What Lexington Alarm! is About"   │
│    - Subscribe & Get Involved buttons   │
├─────────────────────────────────────────┤
│           FEATURED STORY                │
│    (Dynamic - pulls from News system)   │
│    - Image left, text right             │
│    - Auto-updates with news page        │
├─────────────────────────────────────────┤
│           FEATURED ITEMS                │
│    - Two-column product showcase        │
│    - Left: Mailable Signs video         │
│    - Right: Yard Sign product           │
├─────────────────────────────────────────┤
│           UPCOMING EVENTS               │
│    - Tockify calendar embed             │
│    - "View All Events" link             │
├─────────────────────────────────────────┤
│              FOOTER                     │
└─────────────────────────────────────────┘
```

---

## Section 1: Featured Story (Dynamic)

### How It Works

The Featured Story section uses the `[featured_story]` shortcode to automatically pull and display the current featured story from the News system. This means:

- **One update, two locations:** When you change the featured story on the News page, it automatically updates on the Home page
- **No manual editing required:** The home page featured story stays current without touching the home page

### HTML Code

```html
<!-- FEATURED STORY SECTION - Auto-pulls from News -->
<div class="featured-story-section">
    <h2 class="section-title">FEATURED STORY</h2>
    [featured_story]
</div>
```

### Layout

- **Desktop:** Image on left (40%), text on right (60%), side-by-side
- **Mobile:** Stacks vertically (image above text)
- **Blue border** around entire section
- **Red "FEATURED STORY" header** in ArmaliteRifle font

### Styling (from Additional CSS)

The layout is controlled by these CSS classes:

```css
.featured-story-section {
    border: 3px solid #044f9d;
    padding: 30px;
    margin-bottom: 40px;
    background: #fff;
}

.featured-article {
    display: flex;
    gap: 30px;
    align-items: start;
}

.featured-image {
    flex: 0 0 40%;
    max-width: 400px;
}

.featured-content {
    flex: 1;
}
```

### To Change the Featured Story

1. Go to **Posts** in WordPress admin
2. Find the story you want to feature
3. Change its category to **"Featured Story"** (slug: `feature`)
4. Remove the "Featured Story" category from the old featured post
5. Both the News page and Home page will update automatically

**Note:** Only ONE post should have the "Featured Story" category at a time.

---

## Section 2: Featured Items

### Purpose

Showcases two products/items in a side-by-side layout with video/image and description boxes.

### Current Configuration

| Left Column (50%) | Right Column (50%) |
|-------------------|-------------------|
| YouTube Short embed (mailable sign video) | Product image (yard sign) |
| Description box with details | Description box with price |
| "Order Mailable Signs" button | "Order Yard Sign" button |

### Complete HTML Code

```html
<!-- SECTION: FEATURED ITEMS -->
<!-- wp:html -->
<h2 style="font-family: 'ArmaliteRifle', Impact, sans-serif; color: #c3202e; font-size: clamp(1.8rem, 4.5vw, 3rem); text-transform: uppercase; margin-bottom: 30px; line-height: 1.2; text-align: center;">
    Featured Items
</h2>
<!-- /wp:html -->

<!-- wp:columns {"verticalAlignment":"top"} -->
<div class="wp-block-columns are-vertically-aligned-top">
    
    <!-- LEFT COLUMN - Mailable Sign Video -->
    <!-- wp:column {"verticalAlignment":"top","width":"50%"} -->
    <div class="wp-block-column is-vertically-aligned-top" style="flex-basis:50%; padding: 20px;">
        
        <!-- wp:html -->
        <div style="max-width: 350px; margin: 0 auto;">
            
            <!-- YouTube Short Embed -->
            <iframe 
                width="100%" 
                height="620" 
                src="https://www.youtube.com/embed/biSHMU6aXZY" 
                title="Lexington Alarm Mailable Sign" 
                frameborder="0" 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                allowfullscreen
                style="border: 3px solid #044f9d; border-radius: 8px;">
            </iframe>
            
            <!-- Description Box -->
            <div style="background: #f5f5f5; border: 2px solid #044f9d; border-radius: 8px; padding: 20px; margin-top: 20px;">
                <h3 style="font-family: 'UglyQua', Georgia, serif; color: #c3202e; font-size: 1.4rem; margin-bottom: 15px; text-align: center;">
                    NEW! Mailable Window Signs
                </h3>
                <p style="font-size: 1rem; line-height: 1.6; margin-bottom: 15px; text-align: center;">
                    Send a sign to a friend! Our new 12" x 18" window signs fold flat and mail anywhere in the USA. Perfect for sharing the message of resistance with friends and family nationwide.
                </p>
                <div style="text-align: center;">
                    <a href="https://lexingtonalarm.org/product/12-x-18-no-king-no-tyranny-window-sign-mailer-format/" 
                       class="la-button" 
                       style="display: inline-block; background-color: #c3202e; color: #ffffff; padding: 12px 25px; text-decoration: none; border: 2px solid #ffffff; border-radius: 5px; font-family: 'UglyQua', Georgia, serif; font-size: 1rem; font-weight: bold; text-transform: uppercase;">
                        Order Mailable Signs
                    </a>
                </div>
            </div>
            
        </div>
        <!-- /wp:html -->
        
    </div>
    <!-- /wp:column -->
    
    <!-- RIGHT COLUMN - Yard Sign Product -->
    <!-- wp:column {"verticalAlignment":"top","width":"50%"} -->
    <div class="wp-block-column is-vertically-aligned-top" style="flex-basis:50%; padding: 20px;">
        
        <!-- wp:html -->
        <div style="max-width: 400px; margin: 0 auto;">
            
            <!-- Product Image -->
            <a href="https://lexingtonalarm.org/product/18-x-24-yard-sign-no-king-no-tyranny-law-is-king/" style="display: block;">
                <img src="https://lexingtonalarm.org/wp-content/uploads/2025/09/NoKingNoTyranny_final-1-scaled-1-600x467.webp" 
                     alt="No King! No Tyranny Yard Sign" 
                     style="width: 100%; height: auto; border: 3px solid #044f9d; border-radius: 8px;"/>
            </a>
            
            <!-- Description Box -->
            <div style="background: #f5f5f5; border: 2px solid #044f9d; border-radius: 8px; padding: 20px; margin-top: 20px;">
                <h3 style="font-family: 'UglyQua', Georgia, serif; color: #c3202e; font-size: 1.4rem; margin-bottom: 15px; text-align: center;">
                    18" x 24" Yard Sign
                </h3>
                <p style="font-size: 1.2rem; font-weight: bold; color: #044f9d; text-align: center; margin-bottom: 10px;">
                    $10.00
                </p>
                <p style="font-size: 1rem; line-height: 1.6; margin-bottom: 15px; text-align: center;">
                    Display your patriotic Lexington Alarm yard sign! Double-sided, all-weather corrugated plastic with metal H-stake included. FREE local pickup in Lexington.
                </p>
                <div style="text-align: center;">
                    <a href="https://lexingtonalarm.org/product/18-x-24-yard-sign-no-king-no-tyranny-law-is-king/" 
                       class="la-button" 
                       style="display: inline-block; background-color: #c3202e; color: #ffffff; padding: 12px 25px; text-decoration: none; border: 2px solid #ffffff; border-radius: 5px; font-family: 'UglyQua', Georgia, serif; font-size: 1rem; font-weight: bold; text-transform: uppercase;">
                        Order Yard Sign
                    </a>
                </div>
            </div>
            
        </div>
        <!-- /wp:html -->
        
    </div>
    <!-- /wp:column -->
    
</div>
<!-- /wp:columns -->

<!-- wp:spacer {"height":"40px"} -->
<div style="height:40px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->
```

### To Update Featured Items

**To change the YouTube video (left column):**
1. Get the YouTube Short URL
2. Extract the video ID (the part after `shorts/`)
3. Replace `biSHMU6aXZY` in the iframe `src` with the new video ID
4. Update the description text and button link as needed

**To change the product (right column):**
1. Get the new product image URL from the Media Library
2. Replace the `img src` URL
3. Update the product title, price, description
4. Update the button link to the new product page

---

## Section 3: Upcoming Events

Uses Tockify calendar embed. See `Events_Calendar.md` for configuration details.

---

## Key Technical Notes

### Column Layout Rules

When using WordPress columns with custom HTML:

1. **Always close all tags properly** - Unclosed `</div>` tags will break subsequent sections
2. **Keep columns as siblings** - Don't insert wrapper divs between column opening/closing tags
3. **Use `flex-basis` for column widths** - e.g., `style="flex-basis:50%"`
4. **Add padding inside columns, not between** - e.g., `padding: 20px;` on the column div

### Common Issues

| Problem | Cause | Fix |
|---------|-------|-----|
| Next section appears inside columns | Missing closing `</div>` tags | Count and match all div opens/closes |
| Columns not side-by-side | Wrapper div inserted between columns | Remove any divs that aren't column children |
| Content not centered in column | Mismatched max-widths | Wrap image and text in single container with `margin: 0 auto` |

---

## Related Documentation

- **News System:** `04_Content_Publishing/News_System/`
- **Featured Story Shortcode:** `04_Content_Publishing/News_System/WPCode_Snippets.md`
- **Events Calendar:** `04_Content_Publishing/Events_Calendar.md`
- **CSS Framework:** `01_Technical_Foundation/` (if exists)

---

## Change Log

| Date | Change | Details |
|------|--------|---------|
| Dec 6, 2025 | Featured Story dynamic | Replaced manual Massport story with `[featured_story]` shortcode |
| Dec 6, 2025 | Featured Items section | New two-column section with video embed and product showcase |
| Dec 6, 2025 | Removed rally recap section | Old October 18th rally content moved to dedicated Speaker Videos page |
