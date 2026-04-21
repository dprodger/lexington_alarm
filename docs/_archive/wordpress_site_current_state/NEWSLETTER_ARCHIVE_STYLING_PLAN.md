# Newsletter Archive System - Matching Your Newsletter Style
**Date:** October 11, 2025

---

## 🎨 DESIGN SPECIFICATIONS (From Your Newsletter)

**Story Section Headers:**
- Background: `#a33335` (your red)
- Text: White `#ffffff`
- Border-radius: `120px` (very rounded)
- Padding: `24px` top/bottom, `24px` left/right
- Font: Work Sans, bold
- Text-align: center

**Dividers:**
- Border: `2px solid #000000`
- Padding: `20px` top/bottom, `24px` left/right

**Body Text:**
- Font: Work Sans
- Size: `21px` (your newsletter standard)
- Color: `#2b2b2b`
- Line-height: 1.5

**Links:**
- Color: `#a33335` (red)
- Underline on hover

**Buttons:**
- Style 1: White background, red border `#c3202e`
- Style 2: Blue background `#034f9e`, white text
- Border-radius: `50px` for rounded buttons
- Padding: `16px 28px`

---

## 📋 PROPOSED NEWSLETTER ARCHIVE STRUCTURE

### TIER 1: Current Newsletter (Featured)
```
┌─────────────────────────────────────────────────────┐
│  [RED ROUNDED BOX]                                  │
│  CURRENT NEWSLETTER: September 2025                 │
│  Published: September 26, 2025                      │
└─────────────────────────────────────────────────────┘

IN THIS ISSUE:
→ Burlington to Vote on ICE Facility
→ Oct 18th Rally Planning Meeting
→ New Post/Mail Signs Available
→ ICE Task Force Formation
→ Battle Green Flag Policy Letter

[READ FULL NEWSLETTER →]

─────────────────── (black divider) ───────────────────
```

### TIER 2: Newsletter Archive (Auto-updating from Mailchimp)
```
┌─────────────────────────────────────────────────────┐
│  [RED ROUNDED BOX]                                  │
│  NEWSLETTER ARCHIVE                                 │
└─────────────────────────────────────────────────────┘

📧 September 2025 Newsletter
   Published: September 26, 2025
   [View in Browser →]

📧 August 2025 Newsletter
   Published: August 15, 2025
   [View in Browser →]

📧 July 2025 Newsletter
   Published: July 4, 2025
   [View in Browser →]
```

---

## 🔧 IMPLEMENTATION OPTIONS

### OPTION A: Manual Current Newsletter + Mailchimp RSS Feed

**Current Newsletter (Manual HTML - Update bi-weekly):**
- You paste story headlines manually
- Each headline links to anchor in Mailchimp newsletter
- Requires anchors in your Mailchimp template

**Archive List (Automated via Mailchimp RSS):**
- Pulls from Mailchimp campaign archive automatically
- Uses Mailchimp's RSS feed
- No manual updates needed

### OPTION B: Fully Manual (Simplest)

**Both sections manual:**
- Update current newsletter section every 2 weeks
- Add one line to archive list each time
- Takes 3-5 minutes per newsletter

### OPTION C: WordPress Posts for Both

**Everything in WordPress:**
- Create newsletter as WordPress post
- Custom shortcode displays current + archive
- Most flexible, requires more setup

---

## 💡 MY RECOMMENDATION: Option A (Hybrid)

**Why:**
1. Current newsletter = manual (gives you control over story headlines with anchor links)
2. Archive = automated RSS (set it and forget it)
3. Best balance of control and automation

---

## 📝 IMPLEMENTATION PLAN

### Step 1: Add Anchors to Your Mailchimp Template

In your Mailchimp newsletter template, add IDs to story sections:

```html
<!-- Story 1 -->
<div id="burlington-ice-vote">
    <h1 style="...background-color:#a33335;">
        Burlington ICE Facility Vote
    </h1>
    ...
</div>

<!-- Story 2 -->
<div id="oct-18-meeting">
    <h1 style="...background-color:#a33335;">
        Oct 18th Rally Planning
    </h1>
    ...
</div>
```

### Step 2: Create Current Newsletter Section (Manual HTML)

This goes on your News page, updated bi-weekly:

```html
<!-- CURRENT NEWSLETTER SECTION -->
<div class="newsletter-current-section">
    <!-- Red Header Box -->
    <div class="newsletter-header">
        <h2>CURRENT NEWSLETTER: September 2025</h2>
        <p class="newsletter-date">Published: September 26, 2025</p>
    </div>
    
    <!-- Story Headlines -->
    <div class="newsletter-stories">
        <h3>IN THIS ISSUE:</h3>
        <ul class="story-list">
            <li><a href="MAILCHIMP_URL#burlington-ice-vote">→ Burlington to Vote on ICE Facility</a></li>
            <li><a href="MAILCHIMP_URL#oct-18-meeting">→ Oct 18th Rally Planning Meeting</a></li>
            <li><a href="MAILCHIMP_URL#new-signs">→ New Post/Mail Signs Available</a></li>
            <li><a href="MAILCHIMP_URL#ice-task-force">→ ICE Task Force Formation</a></li>
            <li><a href="MAILCHIMP_URL#flag-policy">→ Battle Green Flag Policy Letter</a></li>
        </ul>
        
        <div class="newsletter-button">
            <a href="MAILCHIMP_URL" class="la-button">READ FULL NEWSLETTER →</a>
        </div>
    </div>
</div>

<!-- Divider (matches newsletter style) -->
<div class="newsletter-divider"></div>
```

### Step 3: Create Archive Section (Automated RSS)

Uses Mailchimp's campaign RSS feed:

```html
<!-- NEWSLETTER ARCHIVE SECTION -->
<div class="newsletter-archive-section">
    <!-- Red Header Box -->
    <div class="newsletter-header">
        <h2>NEWSLETTER ARCHIVE</h2>
    </div>
    
    <!-- RSS Feed Display -->
    [mailchimp_campaign_archive]
</div>
```

### Step 4: CSS Styling (Matches Newsletter Exactly)

```css
/* Newsletter Section Styling */
.newsletter-current-section,
.newsletter-archive-section {
    max-width: 660px;
    margin: 40px auto;
    padding: 0 24px;
}

/* Red Header Boxes (matches newsletter) */
.newsletter-header {
    background-color: #a33335;
    border-radius: 120px;
    padding: 24px;
    text-align: center;
    margin-bottom: 30px;
}

.newsletter-header h2 {
    color: #ffffff;
    font-family: 'Work Sans', sans-serif;
    font-weight: bold;
    font-size: 31px;
    margin: 0;
    text-transform: uppercase;
}

.newsletter-date {
    color: #ffffff;
    font-size: 18px;
    margin: 10px 0 0 0;
}

/* Story List */
.newsletter-stories {
    padding: 20px 0;
}

.newsletter-stories h3 {
    font-family: 'Work Sans', sans-serif;
    font-size: 24px;
    color: #2b2b2b;
    margin-bottom: 15px;
}

.story-list {
    list-style: none;
    padding: 0;
    margin: 0 0 30px 0;
}

.story-list li {
    margin: 12px 0;
}

.story-list a {
    color: #a33335;
    text-decoration: none;
    font-size: 21px;
    font-family: 'Work Sans', sans-serif;
    transition: all 0.2s ease;
}

.story-list a:hover {
    text-decoration: underline;
    color: #8a2a2e;
}

/* Divider (matches newsletter exactly) */
.newsletter-divider {
    border-top: 2px solid #000000;
    margin: 40px 24px;
}

/* Archive List Items */
.archive-item {
    padding: 20px 0;
    border-bottom: 1px solid #ddd;
}

.archive-item:last-child {
    border-bottom: none;
}

.archive-item h4 {
    font-family: 'Work Sans', sans-serif;
    font-size: 21px;
    color: #2b2b2b;
    margin: 0 0 5px 0;
}

.archive-item .date {
    color: #666;
    font-size: 16px;
    margin: 0 0 10px 0;
}

.archive-item a {
    color: #a33335;
    text-decoration: none;
    font-weight: bold;
}

.archive-item a:hover {
    text-decoration: underline;
}

/* Button (matches newsletter style) */
.newsletter-button {
    text-align: center;
    margin: 30px 0;
}

.newsletter-button .la-button {
    background: #ffffff;
    border: 2px solid #c3202e;
    color: #2b2b2b;
    padding: 16px 28px;
    border-radius: 50px;
    font-family: 'Work Sans', sans-serif;
    font-size: 16px;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s ease;
}

.newsletter-button .la-button:hover {
    background: #c3202e;
    color: #ffffff;
    transform: translateY(-2px);
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .newsletter-current-section,
    .newsletter-archive-section {
        padding: 0 16px;
    }
    
    .newsletter-header h2 {
        font-size: 24px;
    }
    
    .story-list a {
        font-size: 18px;
    }
}
```

---

## 🔄 MAILCHIMP RSS FEED SETUP

### Get Your Mailchimp RSS Feed URL:

1. Log into Mailchimp
2. Go to **Audience → Settings → Audience fields and *|MERGE|* tags**
3. Find your RSS feed URL (looks like):
   ```
   https://us17.campaign-archive.com/feed?u=YOUR_ID&id=YOUR_LIST_ID
   ```

### Display RSS on WordPress:

**Option 1: Use WP RSS Aggregator Plugin**
- Install "WP RSS Aggregator" plugin
- Add your Mailchimp campaign RSS feed
- Use shortcode `[wp-rss-aggregator]`

**Option 2: Custom Shortcode (I'll create this)**

---

## 📋 MAINTENANCE WORKFLOW

**Every 2 weeks when you send newsletter:**

1. Send newsletter via Mailchimp
2. Get the "View in Browser" link
3. Update News page Current Newsletter section:
   - Change title/date
   - Update story headlines
   - Update anchor links
   - Update "Read Full Newsletter" link
   
**Time:** 3-5 minutes

**Archive section:** Updates automatically via RSS ✅

---

## ✅ NEXT STEPS

Which approach do you prefer?

1. **Manual Current + RSS Archive** (recommended)
2. **Fully Manual** (simplest, no RSS)
3. **WordPress Posts** (most automated, more setup)

Once you choose, I'll create the complete code ready to paste into your News page!
