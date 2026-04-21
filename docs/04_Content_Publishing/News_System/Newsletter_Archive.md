# Newsletter Archive Management

**Location:** News page (`/news/`) bottom section  
**Update Frequency:** Bi-weekly (when newsletter is sent)  
**Method:** Manual updates to WPCode snippets  
**Last Updated:** November 24, 2025

---

## Overview

The newsletter display system uses **two PHP snippets** in WPCode:

| Snippet | Shortcode | Purpose |
|---------|-----------|--------|
| Newsletter List 2025 | `[newsletter_list]` | Archive of all past newsletters |
| Current Newsletter Display | `[current_newsletter]` | Featured current issue with headlines |

Both link to Mailchimp's "View in Browser" versions rather than hosting copies on the site.

---

## Page Layout

On the News page, the newsletter sections appear in this order:

```
┌─────────────────────────────────────────┐
│          CURRENT NEWSLETTER             │
│       (Red header with month/year)      │
│                                         │
│   IN THIS ISSUE:                        │
│   → Story headline 1                    │
│   → Story headline 2                    │
│   → Story headline 3                    │
│                                         │
│   [ READ FULL NEWSLETTER → ]            │
├─────────────────────────────────────────┤
│          NEWSLETTER ARCHIVE             │
│    (Red rounded header, white text)     │
├─────────────────────────────────────────┤
│                                         │
│  📧 October 16th - Final Rally Update   │
│     View in Browser →                   │
│  ─────────────────────────────────────  │
│  📧 September 26th - Burlington Vote    │
│     View in Browser →                   │
│  ─────────────────────────────────────  │
│  📧 September 11th - Fall Meeting       │
│     View in Browser →                   │
│                                         │
└─────────────────────────────────────────┘
```

---

# SNIPPET 1: Current Newsletter Display

**Shortcode:** `[current_newsletter]`  
**WPCode Snippet Name:** "Current Newsletter Display"  
**Update Frequency:** Bi-weekly (when new newsletter is sent)

## What It Displays
- Red header with "CURRENT NEWSLETTER: [Month Year]"
- Publication date
- "IN THIS ISSUE" section with story headlines
- "READ FULL NEWSLETTER →" button linking to Mailchimp

## How to Update (Bi-Weekly)

### Step 1: Get Info from New Newsletter
1. Note the newsletter title/date
2. Copy the Mailchimp "View in Browser" URL
3. List the main story headlines (4-6 items)

### Step 2: Edit the Snippet
1. Go to **WPCode → All Snippets**
2. Find **"Current Newsletter Display"**
3. Click **Edit**

### Step 3: Update These Sections

**Update the header:**
```php
<h2>CURRENT NEWSLETTER: November 2025</h2>
<p class="newsletter-publish-date">Published: November 15, 2025</p>
```

**Update the story list:**
```php
<ul class="newsletter-story-list">
    <li>→ First headline here</li>
    <li>→ Second headline here</li>
    <li>→ Third headline here</li>
    <li>→ Fourth headline here</li>
</ul>
```

**Update the button URL:**
```php
<a href="https://mailchi.mp/lexingtonalarm/your-new-newsletter-slug" 
   target="_blank" 
   class="la-newsletter-button">
    READ FULL NEWSLETTER →
</a>
```

### Step 4: Save and Verify
1. Click **Update** in WPCode
2. Visit the News page
3. Verify current newsletter displays correctly
4. Test that button opens correct Mailchimp link

---

## Complete Code: Current Newsletter Display

```php
/**
 * Current Newsletter Display
 * Shows most recent newsletter with story headlines
 * Shortcode: [current_newsletter]
 */
if (!function_exists('display_current_newsletter')) {
    function display_current_newsletter() {
        ob_start();
        ?>
        <div class="current-newsletter-wrapper">
            <!-- Red Header Box -->
            <div class="newsletter-red-header">
                <h2>CURRENT NEWSLETTER: October 2025</h2>
                <p class="newsletter-publish-date">Published: October 30, 2025</p>
            </div>
            
            <!-- Newsletter Content -->
            <div class="newsletter-content-box">
                <h3 class="in-this-issue">IN THIS ISSUE:</h3>
                
                <ul class="newsletter-story-list">
                    <li>→ 6000 People rally on Battle Green for No Kings</li>
                    <li>→ Video of Ice Prison Flight from Hanscom Field</li>
                    <li>→ New Friday Standout at Hanscom Field to Protest ICE</li>
                    <li>→ MIRA launches Protecting Mass Communities Campaign</li>
                    <li>→ Continuing Call for Volunteers to support Our Activities</li>
                </ul>
                
                <div class="newsletter-read-button">
                    <a href="https://mailchi.mp/lexingtonalarm/lexington-alarm-newsletter-oct-30th" 
                       target="_blank" 
                       class="la-newsletter-button">
                        READ FULL NEWSLETTER →
                    </a>
                </div>
            </div>
        </div>
        
        <style>
        /* Current Newsletter Styling */
        .current-newsletter-wrapper {
            max-width: 660px;
            margin: 40px auto;
            padding: 0 24px;
        }
        
        .newsletter-red-header {
            background-color: #a33335;
            border-radius: 60px;
            padding: 20px 24px;
            text-align: center;
            margin-bottom: 30px;
        }
        
        .newsletter-red-header h2 {
            color: #ffffff;
            font-family: 'Work Sans', sans-serif;
            font-weight: bold;
            font-size: 28px;
            line-height: 1.3;
            margin: 0;
            text-transform: uppercase;
        }
        
        .newsletter-publish-date {
            color: #ffffff;
            font-family: 'Work Sans', sans-serif;
            font-size: 16px;
            margin: 8px 0 0 0;
        }
        
        .newsletter-content-box {
            background: #ffffff;
            padding: 20px 0;
        }
        
        .in-this-issue {
            font-family: 'Work Sans', sans-serif;
            font-size: 24px;
            font-weight: bold;
            color: #2b2b2b;
            margin: 0 0 20px 0;
        }
        
        .newsletter-story-list {
            list-style: none;
            padding: 0;
            margin: 0 0 30px 0;
        }
        
        .newsletter-story-list li {
            margin: 12px 0;
            line-height: 1.5;
            color: #2b2b2b;
            font-family: 'Work Sans', sans-serif;
            font-size: 18px;
            font-weight: normal;
        }
        
        .newsletter-read-button {
            text-align: center;
            margin: 30px 0;
        }
        
        .la-newsletter-button {
            display: inline-block;
            background: #ffffff;
            border: 2px solid #c3202e;
            border-radius: 50px;
            color: #2b2b2b;
            padding: 16px 28px;
            font-family: 'Work Sans', sans-serif;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .la-newsletter-button:hover {
            background: #c3202e;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .current-newsletter-wrapper {
                padding: 0 16px;
            }
            
            .newsletter-red-header {
                padding: 16px 20px;
                border-radius: 40px;
            }
            
            .newsletter-red-header h2 {
                font-size: 22px;
            }
            
            .newsletter-publish-date {
                font-size: 14px;
            }
            
            .newsletter-story-list li {
                font-size: 16px;
            }
            
            .in-this-issue {
                font-size: 20px;
            }
        }
        </style>
        <?php
        return ob_get_clean();
    }
}
add_shortcode('current_newsletter', 'display_current_newsletter');
```

---

# SNIPPET 2: Newsletter List (Archive)

**Shortcode:** `[newsletter_list]`  
**WPCode Snippet Name:** "Newsletter List 2025"  
**Update Frequency:** Bi-weekly (add previous newsletter to archive)

## What It Displays
- Red header: "NEWSLETTER ARCHIVE"
- List of all past newsletters with:
  - 📧 Email icon
  - Newsletter title (from Mailchimp subject line)
  - "View in Browser →" link

## How to Update (Bi-Weekly)

When you send a new newsletter:
1. The **current** newsletter becomes the **previous** newsletter
2. Add the previous newsletter to the archive array

### Step 1: Get the Mailchimp Link
1. Go to Mailchimp → Campaigns
2. Find the newsletter that was **previously current**
3. Click on the campaign
4. Click **"View"** or **"Share"**
5. Copy the **"View in Browser"** URL

### Step 2: Edit the Snippet
1. Go to **WPCode → All Snippets**
2. Find **"Newsletter List 2025"**
3. Click **Edit**

### Step 3: Add to the Array
Find the `$newsletters` array at the top of the code and add a new entry at the TOP:

```php
$newsletters = array(
    // ADD NEW ENTRIES HERE (newest first)
    'LexingtonAlarm! News Nov. 15th  New Title Here' => 'https://mailchi.mp/lexingtonalarm/new-newsletter-slug',
    'LexingtonAlarm! News Oct. 30th  Previous Newsletter' => 'https://mailchi.mp/lexingtonalarm/previous-slug',
    // ... older entries below
);
```

### Step 4: Save and Verify
1. Click **Update** in WPCode
2. Visit the News page
3. Scroll to Newsletter Archive section
4. Verify new entry appears at top
5. Test the link opens correctly

---

## Complete Code: Newsletter List 2025 (Archive)

```php
/**
 * Newsletter Archive List
 * Displays all past newsletters from array
 * Shortcode: [newsletter_list]
 */
if (!function_exists('lexalarm_newsletter_list')) {
    function lexalarm_newsletter_list() {
        
        // =====================================================
        // NEWSLETTER ARRAY - ADD NEW ENTRIES AT TOP
        // Format: 'Title' => 'Mailchimp URL',
        // =====================================================
        $newsletters = array(
            'LexingtonAlarm! News Oct. 16th  Final Update on Oct 18th No Kings Rally: It Started Here' => 'https://mailchi.mp/lexingtonalarm/lexington-alarm-news-final-update-on-oct-18th-rally',
            'LexingtonAlarm! News Sept. 26th  Burlington Town Mtg to Vote on ICE Facility' => 'https://us17.admin.mailchimp.com/campaigns/show-email?id=13883919',
            'LexingtonAlarm! News Sept. 11th  JOIN US FOR FALL MEETING' => 'https://us17.campaign-archive.com/?u=3a64af74077cb1e5e461c36af&id=07475962b1',
            'LexingtonAlarm! News August 28th Lexington Landscaper Seized by ICE' => 'https://us17.campaign-archive.com/?u=3a64af74077cb1e5e461c36af&id=0723197b0f',
            'LexingtonAlarm! Update August 6th  Small group non-cooperation meetings have started' => 'https://us17.campaign-archive.com/?u=3a64af74077cb1e5e461c36af&id=d6026b334a',
        );
        
        if (empty($newsletters)) {
            return '<p>Newsletter archive coming soon.</p>';
        }
        
        ob_start();
        ?>
        <div class="newsletter-archive-wrapper">
            <div class="newsletter-red-header">
                <h2>NEWSLETTER ARCHIVE</h2>
            </div>
            
            <div class="archive-list">
                <?php 
                $first = true;
                foreach ($newsletters as $title => $url) :
                    if (empty(trim($url))) continue;
                ?>
                    <?php if (!$first) : ?>
                        <div class="archive-divider"></div>
                    <?php endif; ?>
                    
                    <div class="archive-entry">
                        <div class="archive-icon">📧</div>
                        <div class="archive-content">
                            <h4 class="archive-title"><?php echo esc_html($title); ?></h4>
                            <a href="<?php echo esc_url($url); ?>" 
                               target="_blank" 
                               class="archive-link">
                                View in Browser →
                            </a>
                        </div>
                    </div>
                    
                    <?php $first = false; ?>
                <?php endforeach; ?>
            </div>
        </div>
        
        <style>
        .newsletter-archive-wrapper {
            max-width: 660px;
            margin: 40px auto;
            padding: 0 24px;
        }
        
        .newsletter-archive-wrapper .newsletter-red-header {
            background-color: #a33335;
            border-radius: 120px;
            padding: 24px;
            text-align: center;
            margin-bottom: 30px;
        }
        
        .newsletter-archive-wrapper .newsletter-red-header h2 {
            color: #ffffff;
            font-family: 'Work Sans', sans-serif;
            font-weight: bold;
            font-size: 31px;
            line-height: 1.5;
            margin: 0;
            text-transform: uppercase;
        }
        
        .archive-list {
            background: #ffffff;
            padding: 20px 0;
        }
        
        .archive-entry {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            padding: 20px 0;
        }
        
        .archive-icon {
            font-size: 32px;
            line-height: 1;
            flex-shrink: 0;
        }
        
        .archive-content {
            flex: 1;
        }
        
        .archive-title {
            font-family: 'Work Sans', sans-serif;
            font-size: 21px;
            font-weight: bold;
            color: #2b2b2b;
            margin: 0 0 10px 0;
            line-height: 1.4;
        }
        
        .archive-link {
            color: #a33335;
            text-decoration: underline;
            font-family: 'Work Sans', sans-serif;
            font-size: 16px;
            font-weight: bold;
            transition: color 0.2s ease;
        }
        
        .archive-link:hover {
            color: #8a2a2e;
        }
        
        .archive-divider {
            border-top: 2px solid #000000;
            margin: 20px 0;
        }
        
        @media (max-width: 768px) {
            .newsletter-archive-wrapper {
                padding: 0 16px;
            }
            
            .newsletter-archive-wrapper .newsletter-red-header {
                padding: 20px 15px;
                border-radius: 60px;
            }
            
            .newsletter-archive-wrapper .newsletter-red-header h2 {
                font-size: 24px;
            }
            
            .archive-entry {
                flex-direction: column;
                gap: 10px;
            }
            
            .archive-icon {
                font-size: 28px;
            }
            
            .archive-title {
                font-size: 18px;
            }
        }
        </style>
        <?php
        return ob_get_clean();
    }
}
add_shortcode('newsletter_list', 'lexalarm_newsletter_list');
```

---

## Current Archive Entries

| Date | Newsletter Title | Mailchimp URL |
|------|-----------------|---------------|
| Sep 26, 2025 | Burlington to Vote on ICE facility | mailchi.mp/lexingtonalarm/burlington-... |
| Sep 12, 2025 | (Title) | (URL) |
| Aug 6, 2025 | Meetings & Social Media Magic | mailchi.mp/lexingtonalarm/meetings-social-... |
| Jul 25, 2025 | Watch Party with No Kings July 30th | mailchi.mp/lexingtonalarm/watch-party-... |

**Note:** Keep this table updated when adding new newsletters.

---

## Integration with Newsletter Workflow

### Content Pipeline
1. **During bi-week:** Team posts stories to `/post-news/`
2. **Newsletter day:** Compile stories into Mailchimp newsletter
3. **After sending:** Add newsletter to archive
4. Stories remain on news page, newsletter provides curated digest

### Relationship to Blog Posts
- Blog posts are individual stories posted throughout the bi-week
- Newsletters compile and curate those stories for email subscribers
- Both serve different audiences (website visitors vs. email subscribers)
- Newsletter archive lets website visitors access curated digests

---

# BI-WEEKLY UPDATE WORKFLOW

## Complete Checklist When Sending New Newsletter

**When you send a new newsletter, do BOTH of these:**

### Task 1: Update Current Newsletter Display
1. ☐ Edit "Current Newsletter Display" snippet
2. ☐ Update header month/year and date
3. ☐ Update story headlines list
4. ☐ Update Mailchimp URL for new newsletter
5. ☐ Save and verify on News page

### Task 2: Add Previous to Archive
1. ☐ Edit "Newsletter List 2025" snippet
2. ☐ Add the **previous** current newsletter to top of array
3. ☐ Format: `'Title' => 'URL',`
4. ☐ Save and verify in archive section

**Time Required:** ~5 minutes total

---

## Current Archive Reference (as of November 2025)

| Date | Newsletter Title | Status |
|------|-----------------|--------|
| Oct 30, 2025 | 6000 People Rally / No Kings | **CURRENT** |
| Oct 16, 2025 | Final Update on Oct 18th Rally | Archive |
| Sept 26, 2025 | Burlington Town Mtg to Vote on ICE | Archive |
| Sept 11, 2025 | Join Us for Fall Meeting | Archive |
| Aug 28, 2025 | Lexington Landscaper Seized by ICE | Archive |
| Aug 6, 2025 | Small Group Meetings Started | Archive |

**Keep this table updated when adding new newsletters.**

---

## Troubleshooting

### Archive Shows "Newsletter archive coming soon"
1. The snippet has no entries added yet
2. Wrong shortcode being called on page
3. Check WPCode snippet is active

### Link Opens Wrong Newsletter
1. Double-check the Mailchimp URL copied correctly
2. URLs are case-sensitive for the slug portion

### Styling Looks Wrong
1. CSS may not be loading - check for PHP errors
2. Clear browser cache
3. Check snippet is outputting the `<style>` section

### New Entry Not Appearing
1. Make sure snippet was saved after editing
2. Clear any WordPress caching plugins
3. Check entry HTML syntax is correct (no unclosed tags)

---

## Alternative: Post-Based Archive

If you prefer to manage newsletters as WordPress posts instead of manual HTML entries:

1. Create posts with category "Newsletter Archive" (slug: `archive`)
2. Post title = Newsletter title
3. Post content = brief description or "View newsletter" link
4. Use the alternative `[newsletter_archive]` shortcode that queries posts

**Pros:** Uses WordPress post interface  
**Cons:** More clicks to add, harder to include Mailchimp links prominently

The manual method is recommended because:
- Faster to update (copy/paste new entry)
- Direct control over display
- Clear link to Mailchimp version
- No WordPress post clutter

---

## Related Documentation

- Newsletter workflow: `03_Email_Systems/Newsletter_Workflow.md`
- Mailchimp setup: `03_Email_Systems/Mailchimp_Integration.md`
- News page structure: `News_System/News_Page_Public.md`
