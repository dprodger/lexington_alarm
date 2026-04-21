# Lexington Alarm News System - Complete Documentation

**Last Updated:** December 22, 2024  
**Status:** Fully Implemented  
**Pages:** `/news/` (public), `/post-news/` (team portal)

---

## 📂 News System Documentation Index

| Document | Description |
|----------|-------------|
| `News_Page_Public.md` | Public-facing news page structure and shortcodes |
| `News_Team_Portal.md` | Backend submission system for news team |
| `News_Team_Instructions.md` | **User guide for news team members** |
| `Add_News_Notifications.md` | **How to add email notifications (implementation guide)** |
| `Inline_Featured_Text_Editing.md` | Edit featured story text inline from portal |
| `Newsletter_Archive.md` | Managing the bi-weekly newsletter archive |
| `User_Roles_Permissions.md` | News team access control and WordPress roles |
| `WPCode_Snippets.md` | All PHP code snippets for the news system |

---

## 🎯 System Overview

The Lexington Alarm news system is a **two-page workflow**:

### Public Page: `/news/`
- Displays featured story prominently at top
- Shows grid of recent blog posts (6 posts, 2-column layout)
- Newsletter subscribe banner with Mailchimp integration
- Newsletter archive with links to past issues

### Team Portal: `/post-news/`
- Login-protected submission form
- Rich form with title, image upload, excerpt, full content
- Category selection (Featured Story vs Blog Posts)
- Post management (edit, delete, bulk operations)
- Role-based permissions for publishing vs review
- **Email notifications sent to team on all submissions**

---

## 🔧 Technical Components

### WordPress Categories Required
| Slug | Display Name | Purpose |
|------|--------------|---------|
| `feature` | Featured Story | Single featured article at top of news page |
| `blog` | Blog Posts | Regular news articles in the grid |
| `archive` | Newsletter Archive | Newsletter entries (if using post-based archive) |

### WPCode Snippets Required
1. **"Front End News System"** - Login, submission, and notifications (`[la_news_login]`)
2. **"News Shortcodes"** - Display shortcodes (`[featured_story]`, `[blog_posts_grid]`)
3. **"Current Newsletter Display"** - Current newsletter with headlines (`[current_newsletter]`)
4. **"Newsletter List 2025"** - Archive of past newsletters (`[newsletter_list]`)

### Shortcodes Available
| Shortcode | Function | Used On |
|-----------|----------|---------|
| `[featured_story]` | Displays most recent post from "feature" category | News page |
| `[blog_posts_grid]` | Shows 6 recent posts from "blog" category | News page |
| `[current_newsletter]` | Current newsletter with headlines & Mailchimp link | News page |
| `[newsletter_list]` | Archive list of all past newsletters | News page |
| `[la_news_login]` | Login form / submission system | Post News page |
| `[la_blog_search]` | Search functionality for blog posts | News page (optional) |
| `[mc4wp_form id="XXX"]` | Mailchimp subscribe form | News page |

---

## 👥 User Roles

| Role | Permissions | Use For |
|------|-------------|---------|
| **News Team** (custom) | Full publish/edit/delete | Trusted editors (Christine, Steve) |
| **News Contributor** (custom) | Submit for review only | Occasional writers, new members |
| **Author** (built-in) | Publish own posts | Alternative to custom roles |
| **Contributor** (built-in) | Submit for review | Alternative to custom roles |

---

## 📧 Email Notifications (Added Dec 2024)

When any story is submitted, all news team members receive an email:

| Status | Subject Line | Content |
|--------|--------------|---------|
| **Pending** | `[Lexington Alarm] NEW STORY NEEDS REVIEW: Title` | Link to approve in WP Admin |
| **Published** | `[Lexington Alarm] New Story Published: Title` | Link to view live story |

**Email Recipients:** Christine, Steve, Toby (configured in snippet)

---

## 📰 Bi-Weekly Workflow

### When a Newsletter is Sent:
1. **Update Current Newsletter Display snippet:**
   - Change header to new month/date
   - Update story headlines list
   - Update Mailchimp URL
2. **Update Newsletter List 2025 snippet:**
   - Add the PREVIOUS newsletter to top of array
   - Format: `'Title' => 'URL',`
3. Save both snippets and verify on live site

**See `Newsletter_Archive.md` for complete update instructions and code.**

### News Team Posting Workflow:
1. Go to `/post-news/`
2. Login with news team credentials
3. Fill in story details (title, image, excerpt, content)
4. Select category (Featured Story or Blog)
5. Click "Publish Story" (editors) or "Submit for Review" (contributors)
6. **Email notification sent to all team members**
7. Post appears on `/news/` page automatically (or waits for approval)

---

## ⚡ Quick Troubleshooting

| Problem | Check |
|---------|-------|
| Shortcodes showing as plain text | WPCode snippet not activated |
| Featured story not appearing | No posts in "feature" category |
| Blog grid empty | No posts in "blog" category |
| Newsletter archive says "coming soon" | Archive snippet not updated or wrong shortcode |
| Login not working on post-news | `[la_news_login]` shortcode in wrong block type |
| User can't submit news | User role doesn't have `edit_posts` capability |
| Not receiving notification emails | Check email addresses in `la_notify_news_team()` function |

---

## 📝 Related Documentation

- **Events Calendar:** `04_Content_Publishing/Events_Calendar.md`
- **Mailchimp Integration:** `03_Email_Systems/Mailchimp_Integration.md`
- **Email Workflows:** `03_Email_Systems/Newsletter_Workflow.md`
- **All Code Snippets:** `06_Code_Snippets/PHP_Functions.md`
- **Full PHP Code:** `06_Code_Snippets/Front_End_News_System_v2.1.php`
