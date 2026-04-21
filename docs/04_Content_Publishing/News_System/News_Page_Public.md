# News Page - Public Structure

**Page URL:** `/news/`  
**Page Type:** WordPress page with custom HTML block  
**Last Updated:** November 24, 2025

---

## Page Structure Overview

The public news page uses a combination of HTML structure and WordPress shortcodes to display content dynamically.

```
┌─────────────────────────────────────────┐
│           FEATURED STORY                │
│    (Single post from "feature" cat)     │
│    - Large image                        │
│    - Title, date, excerpt               │
│    - "Read Full Story" button           │
├─────────────────────────────────────────┤
│          SUBSCRIBE BANNER               │
│    - "Stay Informed" heading            │
│    - Mailchimp signup form              │
├─────────────────────────────────────────┤
│           RECENT NEWS                   │
│    (Grid of posts from "blog" cat)      │
│    ┌──────────┐  ┌──────────┐          │
│    │  Post 1  │  │  Post 2  │          │
│    └──────────┘  └──────────┘          │
│    ┌──────────┐  ┌──────────┐          │
│    │  Post 3  │  │  Post 4  │          │
│    └──────────┘  └──────────┘          │
├─────────────────────────────────────────┤
│        NEWSLETTER ARCHIVE               │
│    - List of past newsletters           │
│    - Links to Mailchimp "View in        │
│      Browser" versions                  │
└─────────────────────────────────────────┘
```

---

## Complete HTML Structure

Add this to the News page in a **Custom HTML block** (not a Shortcode block):

```html
<!-- NEWS PAGE MAIN STRUCTURE -->
<div class="news-page-wrapper">
    
    <!-- FEATURED STORY SECTION -->
    <div class="featured-story-section">
        <h2 class="section-title">FEATURED STORY</h2>
        [featured_story]
    </div>
    
    <!-- SUBSCRIBE BANNER -->
    <div class="subscribe-banner" style="background: #044f9d; color: #fff; padding: 40px; text-align: center; margin: 40px 0;">
        <h2 style="color: #fff; margin-bottom: 10px;">STAY INFORMED</h2>
        <p style="margin-bottom: 20px;">Get the latest updates delivered to your inbox</p>
        [mc4wp_form id="XXX"]
    </div>
    
    <!-- RECENT BLOG POSTS -->
    <div class="blog-posts-section" style="margin-top: 40px;">
        <h2 class="section-title" style="color: #044f9d;">RECENT NEWS</h2>
        [blog_posts_grid]
    </div>
    
    <!-- BLACK DIVIDER -->
    <div style="max-width: 660px; margin: 40px auto; padding: 0 24px;">
        <div style="border-top: 2px solid #000000;"></div>
    </div>
    
    <!-- NEWSLETTER ARCHIVE -->
    <div class="newsletter-archive-section" style="margin: 40px 0;">
        [newsletter_archive]
    </div>
    
</div>
```

**Note:** Replace `XXX` in `[mc4wp_form id="XXX"]` with your actual Mailchimp form ID from MC4WP plugin.

---

## Shortcode Details

### `[featured_story]`

**Source:** "News Shortcodes" WPCode snippet  
**Pulls from:** Posts with category slug `feature`  
**Displays:** 1 most recent post

**Output Structure:**
- Post thumbnail (large size)
- Title (linked to full post)
- Date
- Excerpt (40 words if no manual excerpt set)
- "Read Full Story →" button

### `[blog_posts_grid]`

**Source:** "News Shortcodes" WPCode snippet  
**Pulls from:** Posts with category slug `blog`  
**Displays:** 6 most recent posts in 2-column grid

**Output Structure per Card:**
- Post thumbnail (medium size)
- Category label + date
- Title (linked to full post)
- Excerpt (20 words)
- Author and date
- "READ MORE →" link

### `[newsletter_archive]`

**Source:** "Newsletter Archive" WPCode snippet OR "News Shortcodes"  
**Two versions available:**
1. **Manual version** - Hardcoded Mailchimp links (recommended)
2. **Post-based version** - Pulls from posts in `archive` category

**Output Structure:**
- Red header: "NEWSLETTER ARCHIVE"
- List of newsletters with:
  - 📧 emoji icon
  - Newsletter title
  - Publication date
  - "View in Browser →" link to Mailchimp

---

## Styling Notes

### Section Title Styling
```css
.section-title {
    font-family: 'ArmaliteRifle', sans-serif;
    color: #c3202e;
    text-transform: uppercase;
    text-align: center;
    margin-bottom: 30px;
}
```

### Featured Story Card
```css
.featured-article {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.featured-image img {
    width: 100%;
    height: auto;
    border-radius: 4px;
}

.featured-title a {
    color: #c3202e;
    text-decoration: none;
}
```

### Blog Posts Grid
```css
.blog-posts-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 30px;
    margin-top: 40px;
}

@media (max-width: 768px) {
    .blog-posts-grid {
        grid-template-columns: 1fr;
    }
}
```

---

## Troubleshooting

### Featured Story Not Showing
1. Check that at least one post has category "Featured Story" (slug: `feature`)
2. Verify post is published (not draft/pending)
3. Verify "News Shortcodes" snippet is active in WPCode

### Blog Grid Empty
1. Check that posts have category "Blog Posts" (slug: `blog`)
2. Need at least 1 post, displays up to 6
3. Verify "News Shortcodes" snippet is active

### Newsletter Archive Shows "Coming Soon"
1. The manual archive snippet needs newsletter entries added
2. Or: post-based version needs posts in `archive` category
3. Verify correct shortcode name is used

### Shortcodes Display as Plain Text
1. Must be in **Custom HTML block**, not Shortcode block
2. Check WPCode snippets are activated
3. Clear any caching plugins

---

## Related Files

- Shortcode code: `News_System/WPCode_Snippets.md`
- Newsletter archive management: `News_System/Newsletter_Archive.md`
- CSS framework: `06_Code_Snippets/Custom_CSS.md`
