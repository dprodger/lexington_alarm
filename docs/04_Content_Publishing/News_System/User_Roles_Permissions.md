# User Roles & Permissions - News Team Access

**Plugin Required:** User Role Editor  
**Last Updated:** November 24, 2025

---

## Overview

The news submission system uses WordPress user roles to control who can post, edit, and publish news stories. Two custom roles were created specifically for the news team.

---

## Custom Roles Created

### News Team (Full Access Editors)
**Purpose:** Trusted editors who can publish, edit, and manage all news content

**Capabilities:**
| Capability | Status |
|------------|--------|
| `edit_posts` | ✅ Yes |
| `publish_posts` | ✅ Yes |
| `read` | ✅ Yes |
| `upload_files` | ✅ Yes |
| `delete_posts` | ✅ Yes |
| `edit_others_posts` | ✅ Yes |
| `delete_others_posts` | ✅ Yes |
| `edit_published_posts` | ✅ Yes |
| `delete_published_posts` | ✅ Yes |

**What They Can Do:**
- Submit and immediately publish news stories
- Edit any team member's posts
- Delete any team member's posts
- Upload images
- Review and approve pending submissions from Contributors
- Access the Post News portal with full functionality

**Current Members:**
- Christine Dall
- Steve Singer

---

### News Contributor (Submit for Review)
**Purpose:** Occasional writers or new team members who need approval before publishing

**Capabilities:**
| Capability | Status |
|------------|--------|
| `edit_posts` | ✅ Yes |
| `read` | ✅ Yes |
| `upload_files` | ✅ Yes |
| `publish_posts` | ❌ No |
| `delete_posts` | ❌ No |
| `edit_others_posts` | ❌ No |

**What They Can Do:**
- Submit news stories (go to "Pending Review" status)
- Edit their own unpublished drafts
- Upload images
- Access the Post News portal

**What They Cannot Do:**
- Publish stories directly (must be approved by News Team or Admin)
- Edit or delete others' posts
- Delete any posts

---

## Role Comparison Matrix

| Action | Admin | News Team | News Contributor | Author | Contributor |
|--------|-------|-----------|------------------|--------|-------------|
| Submit stories | ✅ | ✅ | ✅ | ✅ | ✅ |
| Publish immediately | ✅ | ✅ | ❌ | ✅ (own) | ❌ |
| Edit own posts | ✅ | ✅ | ✅ | ✅ | ✅ |
| Edit others' posts | ✅ | ✅ | ❌ | ❌ | ❌ |
| Delete posts | ✅ | ✅ | ❌ | ✅ (own) | ❌ |
| Upload images | ✅ | ✅ | ✅ | ✅ | ❌ |
| Approve pending | ✅ | ✅ | ❌ | ❌ | ❌ |
| Access WP Admin | ✅ | ❌ | ❌ | ❌ | ❌ |

---

## Creating Custom Roles

### Install User Role Editor Plugin
1. Go to **Plugins → Add New**
2. Search for **"User Role Editor"**
3. Install and activate

### Create "News Team" Role
1. Go to **Users → User Role Editor**
2. Click **"Add Role"**
3. Enter:
   - **Role Name (ID):** `news_team`
   - **Display Name:** `News Team`
   - **Copy from:** `Editor` (or start fresh)
4. Click **"Add Role"**
5. Select these capabilities (check the boxes):
   - ✅ `edit_posts`
   - ✅ `publish_posts`
   - ✅ `read`
   - ✅ `upload_files`
   - ✅ `delete_posts`
   - ✅ `edit_others_posts`
   - ✅ `delete_others_posts`
   - ✅ `edit_published_posts`
   - ✅ `delete_published_posts`
6. Click **"Update"**

### Create "News Contributor" Role
1. Still in User Role Editor
2. Click **"Add Role"**
3. Enter:
   - **Role Name (ID):** `news_contributor`
   - **Display Name:** `News Contributor`
   - **Copy from:** `Contributor`
4. Click **"Add Role"**
5. Select ONLY these capabilities:
   - ✅ `edit_posts`
   - ✅ `read`
   - ✅ `upload_files`
6. Make sure `publish_posts` is **NOT** checked
7. Click **"Update"**

---

## Adding Users to News Team

### Create New User Account
1. Go to **Users → Add New**
2. Fill in:
   - **Username:** (they'll use this to login)
   - **Email:** (required - receives login details)
   - **First Name:** 
   - **Last Name:**
   - **Password:** Click "Generate Password" or create one
   - **Role:** Select **"News Team"** or **"News Contributor"**
3. Check **"Send User Notification"** (emails them login details)
4. Click **"Add New User"**

### Change Existing User's Role
1. Go to **Users → All Users**
2. Click on the username
3. Scroll to **Role** dropdown
4. Select new role
5. Click **"Update User"**

---

## Password Management

### Initial Password
When creating users, you have two options:
1. **Generate Password** - WordPress creates random strong password
2. **Manual Password** - You set it (share securely with user)

### User Password Reset
Users can reset their own passwords:
1. Go to login page
2. Click **"Lost your password?"**
3. Enter username or email
4. Receive email with reset link

### Admin Password Reset
If a user needs password reset:
1. Go to **Users → All Users**
2. Click on their username
3. Scroll to **Account Management**
4. Click **"Generate Password"** or **"Set New Password"**
5. Check **"Send User Notification"** to email them
6. Click **"Update User"**

---

## Login Instructions for News Team

Send this to new news team members:

---

### News Portal Access Instructions

**Website:** https://lexingtonalarm.org/post-news/

**Your Login:**
- Username: [their username]
- Password: [you set it or they receive reset link]

**To Submit News:**
1. Go to the news portal page
2. Log in with your credentials
3. Fill out the news form:
   - Add title
   - Upload image (optional)
   - Write summary
   - Write full story
   - Select category (Blog Post or Featured Story)
4. Click **"Publish Story"** (News Team) or **"Submit for Review"** (Contributors)

**To Manage Posts:**
- You'll see recent posts below the form
- Click checkboxes to select multiple posts
- Click "Delete" to remove individual posts

**Note:** You won't access the WordPress admin area. Everything is handled through our custom portal.

**Forgot Password?**
Click "Lost your password?" on the login page and enter your email.

---

## Security Considerations

### Why Custom Portal vs. WP Admin?
- Simpler interface for non-technical users
- Can't accidentally break site settings
- Focused on news-only tasks
- Easier to train new team members

### Role-Based Security
- Users can only see/do what their role allows
- Capability checks happen server-side
- Can't bypass by manipulating URLs

### Password Best Practices
- Require strong passwords
- Users should change from generated password
- No shared accounts - each user has their own

---

## Troubleshooting

### "You do not have permission to submit"
1. User role lacks `edit_posts` capability
2. Check user's role in Users → All Users
3. Assign to "News Team" or "News Contributor"

### User Can't Upload Images
1. Role needs `upload_files` capability
2. News Contributor role should have this - verify in User Role Editor

### Posts Going to "Pending" Instead of Publishing
1. This is correct behavior for News Contributor role
2. If user should publish directly, change role to News Team

### User Can't Delete Posts
1. Only News Team and Admin can delete
2. News Contributors cannot delete by design
3. Change role if deletion access needed

### Login Not Working
1. Verify username is correct (case-sensitive)
2. Try password reset
3. Check user account exists in WordPress

---

## Audit Log (Who Has Access)

| User | Role | Added | Notes |
|------|------|-------|-------|
| Toby Sackton | Administrator | Original | Full site access |
| Christine Dall | News Team | Oct 2025 | Full news access |
| Steve Singer | News Team | Oct 2025 | Full news access |

**Update this table when adding/removing users.**

---

## Related Documentation

- News Team Portal: `News_System/News_Team_Portal.md`
- WPCode snippets: `News_System/WPCode_Snippets.md`
- WordPress configuration: `01_Technical_Foundation/Site_Configuration.md`
