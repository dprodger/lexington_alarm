# Newsletter Archive - Quick Fix Instructions

## The Problem
The `[newsletter_archive]` shortcode on your News page shows "Newsletter archive coming soon" because it's looking for WordPress posts in the "archive" category, but you don't have any posts there yet.

## The Solution
Replace the existing shortcode with a manual version where you control the newsletter list directly.

---

## STEP 1: Update the WPCode Snippet

1. **Log into WordPress admin**
2. **Go to:** Snippets → All Snippets
3. **Find snippet:** "News Shortcodes" (ID: 651)
4. **Click to edit it**
5. **Find this section** in the code (it's at the bottom):

```php
// NEWSLETTER ARCHIVE SHORTCODE
function display_newsletter_archive() {
    $args = array(
        'category_name' => 'archive',
        ...
```

6. **Replace the ENTIRE `display_newsletter_archive()` function** with the code from the file: `NEWSLETTER_ARCHIVE_SHORTCODE_MANUAL.php`

7. **Click "Update"**

---

## STEP 2: Test It

1. **Visit your News page:** https://bpx.ela.mybluehost.me/website_97a098b6/news/
2. **Scroll to the bottom**
3. **You should now see:**
   - Red "NEWSLETTER ARCHIVE" header
   - September 2025 Newsletter entry with your real Mailchimp link
   - Two example entries (August and July - these can be deleted)

---

## STEP 3: Customize Your Archive

### To Add a New Newsletter (Every 2 weeks)

1. **Go to:** Snippets → News Shortcodes → Edit
2. **Find this section** (near the top of the `display_newsletter_archive_manual` function):

```php
$newsletters = array(
    array(
        'title' => 'September 2025 Newsletter',
        'date' => 'September 26, 2025',
        'url' => 'https://mailchi.mp/...'
    ),
```

3. **Add your new newsletter at the TOP:**

```php
$newsletters = array(
    array(
        'title' => 'October 2025 Newsletter',  // ← NEW
        'date' => 'October 10, 2025',         // ← NEW
        'url' => 'https://mailchi.mp/YOUR_NEW_URL'  // ← NEW
    ),
    array(
        'title' => 'September 2025 Newsletter',  // OLD stays below
        'date' => 'September 26, 2025',
        'url' => 'https://mailchi.mp/...'
    ),
```

4. **Click Update**
5. **Time required: 1 minute**

### To Remove Example Entries

Delete these entries from the array:
```php
array(
    'title' => 'August 2025 Newsletter',
    'date' => 'August 15, 2025',
    'url' => '#'
),
array(
    'title' => 'July 2025 Newsletter',
    'date' => 'July 4, 2025',
    'url' => '#'
),
```

---

## Alternative: Use the WordPress Post Method

If you prefer to create newsletter archive entries as WordPress posts instead of editing code:

### Current Setup
The existing `[newsletter_archive]` shortcode looks for posts with category "archive"

### How to Use It
1. **Create a post** in WordPress
2. **Title:** "September 2025 Newsletter" (or whatever you want)
3. **Content:** Can be empty or include newsletter summary
4. **Categories:** Check "Newsletter Archive" 
5. **Custom Fields (optional):** Add newsletter URL as custom field
6. **Publish**

### To Make This Work
You'd need to modify the shortcode to:
- Either create a link to the post itself
- Or pull the Mailchimp URL from a custom field

**Pros:** Easier for non-technical users, can add images/descriptions
**Cons:** Requires creating posts, more clicks

---

## My Recommendation

**Use the manual code version** because:
- ✅ Matches your newsletter design exactly
- ✅ Takes 1 minute to update
- ✅ No extra posts cluttering your WordPress
- ✅ Direct links to Mailchimp
- ✅ Simpler maintenance
- ✅ Ready to use right now

The WordPress post method is better if you have multiple people updating the archive who aren't comfortable editing code.

---

## Need Help?

If the shortcode still shows "Newsletter archive coming soon" after updating:
1. Clear your browser cache (Ctrl+Shift+R or Cmd+Shift+R)
2. Check that the shortcode code was saved properly
3. Make sure you're editing the right snippet (News Shortcodes, ID: 651)
4. Verify the `$newsletters` array has at least one entry

---

## Current Working Newsletter Entry

You already have one real entry ready to display:
```php
array(
    'title' => 'September 2025 Newsletter',
    'date' => 'September 26, 2025',
    'url' => 'https://mailchi.mp/lexingtonalarm/burlington-to-vote-on-ice-facility-oct-18th-work-meeting-is-monday-9-29'
),
```

This will show up immediately after you update the code.
