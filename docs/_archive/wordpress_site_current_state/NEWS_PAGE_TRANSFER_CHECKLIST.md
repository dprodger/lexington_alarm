# NEWS PAGE TRANSFER CHECKLIST
## From Local to Live Server

---

## ✅ PART 1: PAGE HTML

### File: News Page HTML Content

**Location on Local:** Pages → News → Edit

**What to copy:**
- The entire HTML content from the WordPress editor
- Should include:
  - Featured Story section with `[featured_story]`
  - Subscribe banner with MC4WP form
  - Recent News section with `[blog_posts_grid]`
  - Blog search with `[la_blog_search]`
  - Newsletter archive with `[newsletter_list]` (or whatever shortcode you're using)

**Action on Live:**
1. Go to Pages → News → Edit
2. Replace content with copied HTML
3. Update/Publish

---

## ✅ PART 2: WPCODE SNIPPETS

You need to transfer these snippets from Local to Live:

### Snippet 1: Front End News System
**Snippet Name:** "Front End News System" (ID: 646 on local)
**Contains:**
- `la_custom_login_form()` - Login form for news submitters
- `la_show_post_form()` - Post submission form
- Category management functions
- Bulk delete functionality

**Where to find on local:** Snippets → "Front End News System"

**Action on Live:**
1. Snippets → Add Snippet → PHP Snippet
2. Title: "Front End News System"
3. Copy entire code from local
4. Location: Run Everywhere
5. Activate

---

### Snippet 2: News Shortcodes
**Snippet Name:** "News Shortcodes" (ID: 651 on local)
**Contains:**
- `[featured_story]` - Featured story display
- `[blog_posts_grid]` - Blog posts grid
- `[la_blog_search]` - Search functionality

**Where to find on local:** Snippets → "News Shortcodes"

**Action on Live:**
1. Snippets → Add Snippet → PHP Snippet
2. Title: "News Shortcodes"
3. Copy entire code from local
4. Location: Run Everywhere
5. Activate

---

### Snippet 3: Newsletter Archive
**Snippet Name:** Whatever you named your active newsletter snippet
**Contains:**
- Newsletter list with titles and URLs
- The function that creates `[newsletter_list]` or `[la_newsletter_archive]`

**Where to find on local:** Snippets → (Your newsletter snippet name)

**Action on Live:**
1. Snippets → Add Snippet → PHP Snippet
2. Title: "Newsletter Archive"
3. Copy entire code from local (including all your newsletter URLs!)
4. Location: Run Everywhere
5. Activate

**IMPORTANT:** Make sure you copy the version with ALL your newsletters added!

---

## ✅ PART 3: CSS

### Custom CSS Location
**Location:** WordPress Customizer → Additional CSS
(Or Kadence → Customizer → Additional CSS)

**What to check for:**
The CSS should already be on the live site from previous work, but verify these sections exist:

```css
/* Featured Story Styles */
.featured-story-section { ... }

/* Blog Posts Grid */
.blog-posts-grid { ... }

/* Newsletter Archive */
.newsletter-archive-wrapper { ... }

/* Subscribe Banner */
.subscribe-banner { ... }

/* Search Functionality */
.la-blog-search { ... }
```

**Action on Live:**
1. Go to Customizer → Additional CSS
2. Check if news-related CSS exists
3. If missing any sections, copy from local

---

## ✅ PART 4: WORDPRESS CATEGORIES

Make sure these categories exist on LIVE:

### Required Categories:
1. **feature** - For featured story
2. **blog** - For regular blog posts  
3. **archive** - For newsletter archives (if using post-based method)

**Action on Live:**
1. Go to Posts → Categories
2. Create any missing categories
3. Match the slugs exactly: `feature`, `blog`, `archive`

---

## ✅ PART 5: MC4WP MAILCHIMP FORM

### Form Setup
**On Local:** You have form ID (check what number it is)

**Action on Live:**
1. Check if MC4WP plugin is installed and activated
2. Go to Mailchimp for WP → Forms
3. Create/edit form with same fields:
   - First Name (FNAME)
   - Last Name (LNAME)
   - Email (EMAIL)
   - Town (MMERGE9 or whatever your Mailchimp field is)
4. **Note the form ID number**
5. **Update the News page HTML** with the correct form ID:
   ```html
   [mc4wp_form id="YOUR_LIVE_FORM_ID"]
   ```

---

## ✅ PART 6: USER PERMISSIONS

If you have news submitters (non-admin users who can post):

**Action on Live:**
1. Create user accounts for news team members
2. Set role to "Author" or "Editor"
3. They should be able to access `/submit-news/` page

---

## ✅ STEP-BY-STEP TRANSFER PROCESS

### Step 1: Export from Local
1. ☐ Copy News page HTML to a text file
2. ☐ Go to Snippets → Tools → Export
3. ☐ Select your 3 news-related snippets
4. ☐ Export as JSON file
5. ☐ Copy Additional CSS to a text file

### Step 2: Prepare Live Site
1. ☐ Backup live site first!
2. ☐ Verify all plugins are installed:
   - WPCode
   - MC4WP (Mailchimp for WordPress)
3. ☐ Create categories: feature, blog, archive

### Step 3: Import to Live
1. ☐ Go to Snippets → Tools → Import
2. ☐ Upload the JSON file from Step 1
3. ☐ Activate all imported snippets
4. ☐ Create/configure MC4WP form
5. ☐ Update News page HTML (with correct form ID)
6. ☐ Check/add Additional CSS if needed

### Step 4: Test on Live
1. ☐ Visit /news/ page
2. ☐ Check featured story displays
3. ☐ Check blog posts grid displays
4. ☐ Check newsletter archive displays
5. ☐ Test search functionality
6. ☐ Test subscribe form
7. ☐ Test submitting a news story (if applicable)

---

## ✅ VERIFICATION CHECKLIST

After transfer, verify on LIVE site:

### Visual Check:
- ☐ Featured story appears at top
- ☐ Subscribe banner displays with form
- ☐ Recent news grid shows posts
- ☐ Newsletter archive shows all newsletters
- ☐ Search box works
- ☐ Mobile responsive (check on phone)

### Functionality Check:
- ☐ Subscribe form submits to Mailchimp
- ☐ Featured story link works
- ☐ Blog post links work
- ☐ Newsletter archive links work
- ☐ Search returns results
- ☐ News submission form works (if applicable)

### Shortcode Check:
- ☐ `[featured_story]` - working
- ☐ `[blog_posts_grid]` - working
- ☐ `[la_blog_search]` - working
- ☐ `[newsletter_list]` or `[la_newsletter_archive]` - working
- ☐ `[mc4wp_form id="X"]` - working

---

## 🔧 TROUBLESHOOTING

### If shortcodes show as plain text:
- Snippet not activated
- Snippet has PHP error
- Wrong shortcode name

### If styling looks wrong:
- CSS not copied to live
- Clear cache (browser + WordPress cache plugin)

### If subscribe form doesn't work:
- MC4WP not connected to Mailchimp
- Wrong form ID in shortcode
- Check MC4WP settings

### If newsletter archive is empty:
- No newsletters added to snippet
- Wrong shortcode name on page

---

## 📋 QUICK REFERENCE

**Shortcodes to use on News page:**
- `[featured_story]`
- `[blog_posts_grid]`
- `[la_blog_search]`
- `[newsletter_list]` (or whatever yours is named)
- `[mc4wp_form id="XXX"]`

**Required WPCode Snippets:**
1. Front End News System
2. News Shortcodes
3. Newsletter Archive

**Required Categories:**
- feature
- blog
- archive

---

## 🎯 FINAL CHECK

Before going live:
1. ☐ All snippets active on live
2. ☐ All shortcodes working on live
3. ☐ Test on desktop browser
4. ☐ Test on mobile device
5. ☐ Subscribe form submits successfully
6. ☐ Newsletter links work
7. ☐ No PHP errors in debug.log

---

**Estimated Transfer Time:** 30-45 minutes

**Ready to transfer?** Start with Part 1 and work through the checklist!
