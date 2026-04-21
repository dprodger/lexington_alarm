# Current Newsletter & Archive Shortcodes
**Matching your newsletter styling exactly**

---

## 📧 SHORTCODE 1: CURRENT NEWSLETTER

This displays the most recent newsletter with story headlines and anchor links.

### Add to WPCode Snippets:

**Title:** Current Newsletter Display
**Type:** PHP Snippet
**Location:** Run Everywhere

```php
<?php
/**
 * Current Newsletter Display
 * Shows most recent newsletter with story headlines
 * Update this manually every 2 weeks when newsletter is sent
 */

function display_current_newsletter() {
    ob_start();
    ?>
    <div class="current-newsletter-wrapper">
        <!-- Red Header Box (matches newsletter style) -->
        <div class="newsletter-red-header">
            <h2>CURRENT NEWSLETTER: September 2025</h2>
            <p class="newsletter-publish-date">Published: September 26, 2025</p>
        </div>
        
        <!-- Newsletter Content -->
        <div class="newsletter-content-box">
            <h3 class="in-this-issue">IN THIS ISSUE:</h3>
            
            <ul class="newsletter-story-list">
                <li>
                    <a href="https://mailchi.mp/lexingtonalarm/burlington-to-vote-on-ice-facility-oct-18th-work-meeting-is-monday-9-29#burlington-ice-vote">
                        → Burlington to Vote on ICE Facility; Oct 18th Work Meeting
                    </a>
                </li>
                <li>
                    <a href="https://mailchi.mp/lexingtonalarm/burlington-to-vote-on-ice-facility-oct-18th-work-meeting-is-monday-9-29#oct-18-meeting">
                        → Oct. 18th Working Meeting Sept 29th
                    </a>
                </li>
                <li>
                    <a href="https://mailchi.mp/lexingtonalarm/burlington-to-vote-on-ice-facility-oct-18th-work-meeting-is-monday-9-29#new-signs">
                        → New Post or Mail Signs Are Here
                    </a>
                </li>
                <li>
                    <a href="https://mailchi.mp/lexingtonalarm/burlington-to-vote-on-ice-facility-oct-18th-work-meeting-is-monday-9-29#ice-task-force">
                        → New Ice Task Force
                    </a>
                </li>
                <li>
                    <a href="https://mailchi.mp/lexingtonalarm/burlington-to-vote-on-ice-facility-oct-18th-work-meeting-is-monday-9-29#flag-policy">
                        → Letter to Select Board re: Battle Green Flag
                    </a>
                </li>
                <li>
                    <a href="https://mailchi.mp/lexingtonalarm/burlington-to-vote-on-ice-facility-oct-18th-work-meeting-is-monday-9-29#mira-alert">
                        → Mira Legislative Action Alert
                    </a>
                </li>
                <li>
                    <a href="https://mailchi.mp/lexingtonalarm/burlington-to-vote-on-ice-facility-oct-18th-work-meeting-is-monday-9-29#volunteers">
                        → Volunteers Needed for Face to Face Outreach
                    </a>
                </li>
            </ul>
            
            <div class="newsletter-read-button">
                <a href="https://mailchi.mp/lexingtonalarm/burlington-to-vote-on-ice-facility-oct-18th-work-meeting-is-monday-9-29" 
                   target="_blank" 
                   class="la-newsletter-button">
                    READ FULL NEWSLETTER →
                </a>
            </div>
        </div>
    </div>
    
    <style>
    /* Current Newsletter Styling - Matches Newsletter Exactly */
    .current-newsletter-wrapper {
        max-width: 660px;
        margin: 40px auto;
        padding: 0 24px;
    }
    
    /* Red Header Box (matches newsletter red headers) */
    .newsletter-red-header {
        background-color: #a33335;
        border-radius: 120px;
        padding: 24px;
        text-align: center;
        margin-bottom: 30px;
    }
    
    .newsletter-red-header h2 {
        color: #ffffff;
        font-family: 'Work Sans', sans-serif;
        font-weight: bold;
        font-size: 31px;
        line-height: 1.5;
        margin: 0;
        text-transform: uppercase;
    }
    
    .newsletter-publish-date {
        color: #ffffff;
        font-family: 'Work Sans', sans-serif;
        font-size: 18px;
        margin: 10px 0 0 0;
    }
    
    /* Newsletter Content Box */
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
    
    /* Story List (matches newsletter links) */
    .newsletter-story-list {
        list-style: none;
        padding: 0;
        margin: 0 0 30px 0;
    }
    
    .newsletter-story-list li {
        margin: 15px 0;
        line-height: 1.5;
    }
    
    .newsletter-story-list a {
        color: #a33335; /* Newsletter link color */
        text-decoration: underline;
        font-family: 'Work Sans', sans-serif;
        font-size: 21px; /* Newsletter body text size */
        font-weight: normal;
        transition: color 0.2s ease;
    }
    
    .newsletter-story-list a:hover {
        color: #8a2a2e;
        text-decoration: underline;
    }
    
    /* Read Full Newsletter Button */
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
        font-weight: normal;
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
            padding: 20px 15px;
            border-radius: 60px;
        }
        
        .newsletter-red-header h2 {
            font-size: 24px;
        }
        
        .newsletter-publish-date {
            font-size: 16px;
        }
        
        .newsletter-story-list a {
            font-size: 18px;
        }
        
        .in-this-issue {
            font-size: 20px;
        }
    }
    </style>
    <?php
    return ob_get_clean();
}
add_shortcode('current_newsletter', 'display_current_newsletter');
?>
```

---

## 📚 SHORTCODE 2: NEWSLETTER ARCHIVE

This displays all past newsletters in reverse chronological order.

### Add to WPCode Snippets:

**Title:** Newsletter Archive Display
**Type:** PHP Snippet
**Location:** Run Everywhere

```php
<?php
/**
 * Newsletter Archive Display
 * Shows past newsletters in reverse chronological order
 * Add one entry each time you send a newsletter
 */

function display_newsletter_archive() {
    ob_start();
    ?>
    <div class="newsletter-archive-wrapper">
        <!-- Red Header Box -->
        <div class="newsletter-red-header">
            <h2>NEWSLETTER ARCHIVE</h2>
        </div>
        
        <!-- Archive List -->
        <div class="archive-list">
            
            <!-- Archive Entry Template - Add newest at top -->
            
            <div class="archive-entry">
                <div class="archive-icon">📧</div>
                <div class="archive-content">
                    <h4 class="archive-title">September 2025 Newsletter</h4>
                    <p class="archive-date">Published: September 26, 2025</p>
                    <a href="https://mailchi.mp/lexingtonalarm/burlington-to-vote-on-ice-facility-oct-18th-work-meeting-is-monday-9-29" 
                       target="_blank" 
                       class="archive-link">
                        View in Browser →
                    </a>
                </div>
            </div>
            
            <!-- Black Divider (matches newsletter) -->
            <div class="archive-divider"></div>
            
            <!-- Add more entries below - newest first -->
            <!-- Copy the archive-entry div above and update:
                 - Title
                 - Date
                 - URL
            -->
            
            <!-- Example Entry (delete this when you add real ones) -->
            <div class="archive-entry">
                <div class="archive-icon">📧</div>
                <div class="archive-content">
                    <h4 class="archive-title">August 2025 Newsletter</h4>
                    <p class="archive-date">Published: August 15, 2025</p>
                    <a href="#" 
                       target="_blank" 
                       class="archive-link">
                        View in Browser →
                    </a>
                </div>
            </div>
            
            <div class="archive-divider"></div>
            
            <div class="archive-entry">
                <div class="archive-icon">📧</div>
                <div class="archive-content">
                    <h4 class="archive-title">July 2025 Newsletter</h4>
                    <p class="archive-date">Published: July 4, 2025</p>
                    <a href="#" 
                       target="_blank" 
                       class="archive-link">
                        View in Browser →
                    </a>
                </div>
            </div>
            
        </div>
    </div>
    
    <style>
    /* Newsletter Archive Styling - Matches Newsletter */
    .newsletter-archive-wrapper {
        max-width: 660px;
        margin: 40px auto;
        padding: 0 24px;
    }
    
    /* Red Header Box (same as current newsletter) */
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
    
    /* Archive List */
    .archive-list {
        background: #ffffff;
        padding: 20px 0;
    }
    
    /* Individual Archive Entry */
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
        margin: 0 0 5px 0;
    }
    
    .archive-date {
        font-family: 'Work Sans', sans-serif;
        font-size: 16px;
        color: #666666;
        margin: 0 0 10px 0;
    }
    
    .archive-link {
        color: #a33335; /* Newsletter link color */
        text-decoration: underline;
        font-family: 'Work Sans', sans-serif;
        font-size: 16px;
        font-weight: bold;
        transition: color 0.2s ease;
    }
    
    .archive-link:hover {
        color: #8a2a2e;
    }
    
    /* Archive Divider (matches newsletter black dividers) */
    .archive-divider {
        border-top: 2px solid #000000;
        margin: 20px 0;
    }
    
    /* Mobile Responsive */
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
add_shortcode('newsletter_archive', 'display_newsletter_archive');
?>
```

---

## 📝 HOW TO UPDATE (Every 2 Weeks)

### When You Send a Newsletter:

**Step 1: Update Current Newsletter Shortcode**

Edit the WPCode snippet "Current Newsletter Display" and change:
- Title and date
- Story headlines and anchor links
- "Read Full Newsletter" URL

**Step 2: Add to Archive**

Edit the WPCode snippet "Newsletter Archive Display" and add at the TOP:

```php
<div class="archive-entry">
    <div class="archive-icon">📧</div>
    <div class="archive-content">
        <h4 class="archive-title">September 2025 Newsletter</h4>
        <p class="archive-date">Published: September 26, 2025</p>
        <a href="YOUR_MAILCHIMP_URL" 
           target="_blank" 
           class="archive-link">
            View in Browser →
        </a>
    </div>
</div>

<div class="archive-divider"></div>
```

---

## 🎨 STYLING NOTES

Both shortcodes match your newsletter exactly:
- ✅ Red rounded header boxes (#a33335, 120px radius)
- ✅ Work Sans font, 21px body text
- ✅ Red links (#a33335)
- ✅ Black dividers (2px solid)
- ✅ White buttons with red border, rounded
- ✅ 660px max width
- ✅ Mobile responsive

---

## 📋 COMPLETE NEWS PAGE HTML

Here's your complete News page with everything:

```html
<!-- wp:html -->
<div class="news-page-wrapper">
    
    <!-- FEATURED STORY -->
    <div class="featured-story-section">
        <h2 class="section-title">FEATURED STORY</h2>
        [featured_story]
    </div>
    
    <!-- SEARCH ALL STORIES -->
    <div class="search-section" style="margin: 40px 0;">
        [la_blog_search]
    </div>
    
    <!-- SUBSCRIBE BANNER -->
    <div class="subscribe-banner" style="background: linear-gradient(135deg, #044f9d 0%, #0367c7 100%); 
         color: white; padding: 50px 30px; text-align: center; margin: 40px 0; 
         border: 4px solid #c3202e; position: relative; overflow: hidden;">
        
        <div style="position: absolute; top: 0; left: 0; width: 60px; height: 60px; 
             border-top: 3px solid white; border-left: 3px solid white;"></div>
        <div style="position: absolute; top: 0; right: 0; width: 60px; height: 60px; 
             border-top: 3px solid white; border-right: 3px solid white;"></div>
        <div style="position: absolute; bottom: 0; left: 0; width: 60px; height: 60px; 
             border-bottom: 3px solid white; border-left: 3px solid white;"></div>
        <div style="position: absolute; bottom: 0; right: 0; width: 60px; height: 60px; 
             border-bottom: 3px solid white; border-right: 3px solid white;"></div>
        
        <div style="position: relative; z-index: 1; max-width: 600px; margin: 0 auto;">
            <h2 style="color: white; font-family: 'ArmaliteRifle', sans-serif; 
                 font-size: 2.5em; text-transform: uppercase; margin-bottom: 15px; 
                 text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
                Get the Lexington Alarm! Newsletter
            </h2>
            
            <p style="font-size: 1.2em; margin-bottom: 30px; line-height: 1.6;">
                Our bi-monthly newsletter announces meetings and events, and showcases resistance actions in Lexington and surrounding towns. 
            </p>
            
            <div class="mailchimp-form-wrapper" style="background: white; padding: 30px; 
                 border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                [mc4wp_form id="629"]
            </div>
            
            <p style="font-size: 0.85em; margin-top: 20px; opacity: 0.9;">
                📧 Twice a month • Unsubscribe anytime • We never share your info
            </p>
        </div>
    </div>
    
    <!-- RECENT POSTS -->
    <div class="blog-posts-section">
        <h2 class="section-title" style="color: #044f9d;">RECENT NEWS</h2>
        [blog_posts_grid]
    </div>
    
    <!-- CURRENT NEWSLETTER -->
    [current_newsletter]
    
    <!-- BLACK DIVIDER -->
    <div style="max-width: 660px; margin: 40px auto; padding: 0 24px;">
        <div style="border-top: 2px solid #000000;"></div>
    </div>
    
    <!-- NEWSLETTER ARCHIVE -->
    [newsletter_archive]
    
</div>

<style>
@media (max-width: 768px) {
    .subscribe-banner {
        padding: 30px 15px !important;
    }
    
    .subscribe-banner h2 {
        font-size: 1.8em !important;
    }
    
    .subscribe-banner p {
        font-size: 1em !important;
    }
    
    .mailchimp-form-wrapper {
        padding: 20px 15px !important;
    }
}
</style>
<!-- /wp:html -->
```

---

## ✅ SETUP CHECKLIST

1. **Add Current Newsletter snippet** to WPCode
2. **Add Newsletter Archive snippet** to WPCode
3. **Update your News page** with the complete HTML above
4. **Test** - visit your News page

**Time to set up: 5 minutes**
**Time to update every 2 weeks: 5-10 minutes**

---

Ready to implement?
