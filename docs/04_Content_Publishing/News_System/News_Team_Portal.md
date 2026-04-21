# News Team Portal - Submission System

**Page URL:** `/post-news/` (or `/submit-news/`)  
**Page Type:** WordPress page with shortcode  
**Access:** Login required (News Team members only)  
**Last Updated:** December 4, 2025

---

## Purpose

The News Team Portal allows authorized team members to submit news stories without accessing the WordPress admin dashboard. This provides:

- Clean, focused submission interface
- Role-based permissions (publish vs. submit for review)
- Post management capabilities (edit, delete, bulk operations)
- Image upload support
- Category assignment (Featured vs. Blog)
- **Custom byline override** (for reprints or generic attribution)
- **Auto-backup drafts** (prevents content loss)

---

## Recent Updates (December 2025)

### Byline Override Feature
- Form now includes Byline field below Story Title
- Defaults to logged-in user's display name
- Can be changed for reprints (e.g., "Reprinted from Boston Globe")
- Saved as post meta and displays on published posts

### Auto-Backup System
- Drafts automatically save to browser every 2 seconds
- "Draft auto-saved" notification appears every 15 seconds
- Manual "SAVE DRAFT" button available
- If browser closes unexpectedly, draft can be recovered on next visit
- Draft automatically cleared after successful submission

---

## Page Structure

### For Non-Logged-In Users
```
┌─────────────────────────────────────────┐
│         NEWS TEAM PORTAL                │
│                                         │
│   ┌─────────────────────────────────┐   │
│   │      News Team Login            │   │
│   │                                 │   │
│   │   Username: [______________]    │   │
│   │   Password: [______________]    │   │
│   │                                 │   │
│   │        [  Login  ]              │   │
│   └─────────────────────────────────┘   │
└─────────────────────────────────────────┘
```

### For Logged-In News Team Members
```
┌─────────────────────────────────────────┐
│    Welcome, [Name] | Logout             │
├─────────────────────────────────────────┤
│         SUBMIT NEWS STORY               │
│                                         │
│   Story Title: [____________________]   │
│                                         │
│   Byline: [_________________________]   │
│   (Default: your name, change for       │
│    reprints)                            │
│                                         │
│   Upload Image: [Choose File]           │
│                                         │
│   Story Summary (Excerpt):              │
│   [_________________________________]   │
│                                         │
│   Full Story:                           │
│   [_________________________________]   │
│                                         │
│   ☐ Feature this story                  │
│                                         │
│   [PUBLISH STORY] [SAVE DRAFT]          │
├─────────────────────────────────────────┤
│       MANAGE RECENT POSTS               │
│                                         │
│   ☐ Post Title 1 - Oct 15  Tag:[▼]      │
│   ☐ Post Title 2 - Oct 12  Tag:[▼]      │
│                                         │
│   [Delete Selected]                     │
└─────────────────────────────────────────┘
```

---

## Page HTML

Add this to the Post News page:

```html
<div class="news-entry-wrapper" style="max-width: 800px; margin: 0 auto; padding: 20px;">
    <h1 style="text-align: center; color: #c3202e; font-family: ArmaliteRifle, sans-serif; text-transform: uppercase;">
        NEWS TEAM PORTAL
    </h1>
    
    <p style="text-align: center; color: #044f9d; font-size: 1.1em; margin-bottom: 30px;">
        Authorized members can submit news stories and updates here
    </p>
    
    [la_news_login]
</div>
```

**Note:** The `[la_news_login]` shortcode handles everything - login form for guests, submission form for authenticated users.

---

## Form Fields

| Field | Required | Description |
|-------|----------|-------------|
| Story Title | Yes | Post title |
| Byline | No | Author attribution (defaults to user's name, can override) |
| Featured Image | No | Image upload with preview |
| Story Summary | No | Excerpt - displays on news grid cards |
| Full Story | Yes | Main post content |
| Featured Story | No | Checkbox to promote to featured category |

---

## Byline System

### Purpose
Allows news team to post under their own name OR override for special cases:
- Reprints from other publications
- Generic attribution ("Lexington Alarm Staff")
- Guest contributors

### How It Works

**Form Field:**
- Pre-fills with logged-in user's WordPress display name
- Editor can change to any text
- Helper text: "Default is your name. Change for reprints..."

**Storage:**
- Saved as WordPress post meta: `la_byline`
- If empty or not set, falls back to post author's display name

**Display:**
- Automatically filters `the_author` function
- Kadence theme displays custom byline where author name appears
- Shortcode available: `[la_byline]` - outputs "By [name]"

### Function Reference
```php
// Get byline for any post
la_get_byline($post_id)  // Returns byline or author name

// Shortcode
[la_byline]  // Outputs: <span class="la-byline">By [name]</span>
```

---

## Auto-Backup System

### Purpose
Prevents content loss if browser crashes, network disconnects, or user accidentally navigates away.

### How It Works

**Automatic Saving:**
- Draft saves to browser localStorage every 2 seconds
- Notification "✓ Draft auto-saved at [time]" appears every 15 seconds
- Saves: Title, Summary, Full Story, Featured checkbox
- Does NOT save: Byline (resets to user default), Image

**Manual Save:**
- Gray "SAVE DRAFT" button next to Publish
- Click for immediate save with confirmation alert

**Draft Recovery:**
- On page load, checks localStorage for saved draft
- If found, shows yellow recovery prompt:
  - Preview of saved title and content
  - "RESTORE DRAFT" button - loads saved content
  - "DISCARD" button - deletes saved draft
- Recovery prompt shows how long ago draft was saved

**Auto-Cleanup:**
- Draft automatically deleted after successful submission
- URL shows `?news_submitted=success` to trigger cleanup

### Technical Details
```
Storage Key: la_news_draft
Save Interval: 2000ms (2 seconds)
Notification Interval: 15000ms (15 seconds)
Storage Type: Browser localStorage (device-specific)
```

---

## Post Management Features

### Individual Post Actions
- **Edit** - Opens post in WordPress editor
- **View** - Link to view published post
- **Delete** - Moves post to trash (confirmation required)

### Category Switcher
- Dropdown next to each post: "Blog Posts" / "Featured Story"
- Changing to Featured automatically demotes previous featured post
- Confirmation dialog before promoting to Featured

### Bulk Actions
- Checkbox selection for multiple posts
- **Delete Selected** - Remove multiple posts at once

---

## Categories

| Category Slug | Purpose |
|---------------|---------|
| `blog` | Default category for all news posts |
| `feature` | Featured story (only one at a time) |
| `archive` | Older/archived posts |

**Featured Story Behavior:**
- When a post is marked Featured, previous featured post automatically moves to Blog
- Only one featured story displays prominently on news page

---

## User Roles & Permissions

### Required Capabilities
News Team members need these WordPress capabilities:
- `publish_posts` - to publish directly
- `edit_posts` - to manage posts
- `delete_posts` - to remove posts
- `upload_files` - for featured images

**Recommended Role:** Author or Editor

### Permissions by Role
| Role | Publish | Edit Own | Edit Others | Delete |
|------|---------|----------|-------------|--------|
| News Team | ✅ | ✅ | ✅ | ✅ |
| News Contributor | ❌ (Submit only) | ✅ | ❌ | ❌ |

---

## Code Implementation

### WPCode Snippet
**Name:** Front End News System (with Auto-Backup and Byline)  
**Location:** WPCode → Code Snippets  
**Execution:** Run Everywhere

### Key Functions
| Function | Purpose |
|----------|---------|
| `la_custom_login_form()` | Login form shortcode |
| `la_show_post_form()` | Main submission form |
| `la_handle_news_submission()` | Processes form submission |
| `la_handle_bulk_delete()` | Bulk delete handler |
| `la_handle_category_change()` | AJAX category switcher |
| `la_get_byline()` | Retrieve custom byline |
| `la_filter_author_name()` | Filter author display |

### JavaScript Features
- Category switcher (AJAX, no page reload)
- Image preview on file select
- Auto-backup to localStorage
- Draft recovery prompt
- Manual save button

---

## Troubleshooting

### Login Form Not Appearing
1. Check `[la_news_login]` shortcode is in a Custom HTML block
2. Verify WPCode snippet is active
3. Check for PHP errors in snippet

### "You do not have permission" Message
1. User's WordPress role lacks required capabilities
2. Assign user to "News Team" or "Author" role
3. See `User_Roles_Permissions.md` for role setup

### Byline Not Displaying Custom Text
1. Verify post was created AFTER byline feature was added
2. Check post meta for `la_byline` field in WordPress admin
3. Ensure snippet includes byline filter functions

### Auto-Save Not Working
1. Check browser allows localStorage
2. Clear browser cache and reload
3. Look for JavaScript errors in browser console

### Draft Recovery Not Appearing
1. Draft is device-specific (different browser/device won't see it)
2. Draft may have been discarded or expired
3. Check localStorage in browser dev tools for `la_news_draft`

### Form Submits But Post Not Appearing
1. Check post status - might be "Pending Review" if user is Contributor
2. Verify category assignment is correct
3. Admin/Editor may need to publish pending posts

### Image Upload Failing
1. Check WordPress media upload permissions
2. Verify max file size in WordPress settings
3. User needs `upload_files` capability

---

## Instructions for News Team

### To Submit a News Story:
1. Go to `lexingtonalarm.org/post-news/`
2. Log in with your News Team credentials
3. Fill in the form:
   - **Title:** Clear, descriptive headline
   - **Byline:** Your name (default) or change for reprints
   - **Image:** Upload a relevant image (optional but recommended)
   - **Summary:** 2-3 sentence preview for news listing
   - **Full Story:** Complete article content
   - **Featured:** Check only if this should be THE featured story
4. Click **"Publish Story"**
5. Your post appears on the News page immediately

### Tips:
- Your draft auto-saves as you type - look for the green "Draft saved" message
- Only ONE post should be "Featured Story" at a time
- Use the gray "SAVE DRAFT" button if you want to save and come back later
- If your browser crashes, your draft should be recoverable when you return
- For reprints, change the Byline to give proper attribution

---

## Related Documentation

- User roles setup: `News_System/User_Roles_Permissions.md`
- WPCode snippet code: `News_System/WPCode_Snippets.md`
- Public news page: `News_System/News_Page_Public.md`
- Full code: `06_Code_Snippets/WPCode_Active_Snippets.md`
