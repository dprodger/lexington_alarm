# Inline Featured Text Editing

**Location:** News Team Portal → Manage Recent Posts  
**Added:** December 2024  
**Purpose:** Edit featured story text without accessing wp-admin

---

## Overview

The News Team Portal now includes inline editing for the "Featured Text" field - the custom excerpt that appears in the Featured Story section on the News page.

Previously, editing this text required either:
- Accessing wp-admin → Posts → Edit
- Deleting and resubmitting the entire story

Now team members can edit featured text directly from the portal.

---

## How It Works

### Display Logic (Featured Story Shortcode)

The Featured Story section uses this logic:
1. If custom Featured Text exists → display it
2. If empty → auto-generate from first 40 words of content

### In Manage Recent Posts

Each post now shows:

```
☐  Story Title Here
   Status: publish | Date: Dec 10, 2024 | [FEATURED]
   Featured Text: "First 60 chars of text..." [Edit Featured Text]
   
   Tag: [Blog Posts ▼]     Edit | View | Delete
```

Posts without custom text show:
```
   Featured Text: (auto-generated from content) [Edit Featured Text]
```

---

## Editing Workflow

1. Log in at `/submit-news/`
2. Scroll to **Manage Recent Posts**
3. Find the post you want to edit
4. Click **[Edit Featured Text]**
5. Textarea slides open with current text
6. Edit the text
7. Click **SAVE** (or press Ctrl+Enter)
8. Confirmation appears: "✓ Saved!"
9. Editor closes, preview updates

### Keyboard Shortcuts
- **Ctrl+Enter** - Save changes
- **Escape** - Cancel editing

---

## Clearing Featured Text

To revert to auto-generated text:
1. Open the editor
2. Delete all text (leave blank)
3. Save

The preview will change to "(auto-generated from content)" and the News page will show the first 40 words of the post content.

---

## Technical Notes

- Uses WordPress excerpt field (same as "Featured Text" in submission form)
- AJAX save - no page reload required
- Security: nonce verification, permission check for `edit_posts`
- Changes appear immediately on News page

---

## Related

- News Team Portal: `News_Team_Portal.md`
- News Page structure: `News_Page_Public.md`
