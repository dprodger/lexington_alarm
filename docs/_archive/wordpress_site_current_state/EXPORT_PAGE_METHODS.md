# Easy Page Export Methods for WordPress

## 🎯 SIMPLEST METHOD: Manual Copy from Code Editor

### Step-by-Step:
1. **Edit your page** in WordPress
2. Click **⋮ menu** (top right, three dots)
3. Select **"Code editor"**
4. You'll see ALL the HTML blocks in one view
5. **Ctrl/Cmd + A** (Select All)
6. **Ctrl/Cmd + C** (Copy)
7. Paste into `current_state/pages/[pagename].html`

**Time: 30 seconds per page**

---

## 🚀 FASTER METHOD: Bookmarklet (One-Click Export)

### One-Time Setup:

1. **Create a new bookmark** in your browser
2. **Name it:** "Export WP Page"
3. **URL/Location:** Paste this code:

```javascript
javascript:(function(){if(typeof wp!=='undefined'&&wp.data){const content=wp.data.select('core/editor').getEditedPostContent();const title=wp.data.select('core/editor').getEditedPostAttribute('title');const filename=(title||'page').toLowerCase().replace(/[^a-z0-9]+/g,'-').replace(/^-|-$/g,'')+'.html';const blob=new Blob([content],{type:'text/html'});const url=window.URL.createObjectURL(blob);const a=document.createElement('a');a.href=url;a.download=filename;document.body.appendChild(a);a.click();document.body.removeChild(a);window.URL.revokeObjectURL(url);alert('Downloaded: '+filename+'\n\nMove to:\ncurrent_state/pages/');}else{alert('Please use this on a WordPress page editor');}})();
```

### How to Use:
1. Open any page in WordPress editor
2. Click your **"Export WP Page"** bookmark
3. Page HTML downloads automatically as `[pagename].html`
4. Move the file to `current_state/pages/`

**Time: 5 seconds per page!**

---

## 🔧 ADVANCED METHOD: WPCode Snippet (Adds Export Button)

I've created a snippet at `current_state/snippets/page-export-button-snippet.php`

### Installation:
1. Go to **WPCode → Add Snippet → Add Your Custom Code**
2. Choose **"PHP Snippet"**
3. Copy contents from `page-export-button-snippet.php`
4. Name it: "Page Export Button"
5. Set to **"Run Everywhere"**
6. **Activate**

### Usage:
After activation, when editing any page:
- Look in the **right sidebar** for "Export to Current State" panel
- Click **"📥 Export Page HTML"** button
- File downloads automatically
- Move to `current_state/pages/`

---

## 📊 Method Comparison

| Method | Setup Time | Export Time | Best For |
|--------|-----------|-------------|----------|
| **Code Editor** | None | 30 sec | Quick, no setup needed |
| **Bookmarklet** | 2 min | 5 sec | Frequent exports |
| **WPCode Snippet** | 5 min | 5 sec | Multiple editors, cleanest UI |

---

## 🎨 VISUAL GUIDE: Code Editor Method

```
WordPress Page Editor
┌────────────────────────────────────────┐
│  [Visual Editor]  [Code Editor]  ⋮    │ ← Click ⋮ menu
└────────────────────────────────────────┘
                      │
                      ├─ Code editor ✓ ← Click this
                      ├─ Copy all blocks
                      └─ Select all

Code Editor View
┌────────────────────────────────────────┐
│ <!-- wp:paragraph -->                  │
│ <p>Your content here</p>               │
│ <!-- /wp:paragraph -->                 │
│                                        │ ← Select ALL this
│ <!-- wp:heading -->                    │    (Ctrl+A / Cmd+A)
│ <h2>Your heading</h2>                  │
│ <!-- /wp:heading -->                   │
│ ...                                    │
└────────────────────────────────────────┘
```

---

## 💡 PRO TIPS

### For Multiple Pages:
Use the bookmarklet method - you can export all 6 pages in under a minute:
1. Open News page → Click bookmarklet → Downloads `news.html`
2. Open Home page → Click bookmarklet → Downloads `home.html`
3. Repeat for all pages
4. Move all downloaded files to `current_state/pages/` at once

### What Gets Exported:
✓ All WordPress block HTML  
✓ Block comments (like `<!-- wp:paragraph -->`)  
✓ Custom HTML blocks  
✓ Shortcodes  
✓ Embedded content  

❌ Does NOT include:  
- Custom CSS (export separately from Customizer)
- PHP code (that's in snippets)
- Database content (like dynamic posts)

### Automation Possibility:
If you want to get really fancy, we could create a WP-CLI command:
```bash
wp post get [page-id] --field=post_content > current_state/pages/news.html
```

But the bookmarklet is probably your best balance of ease and speed!

---

## 🎯 RECOMMENDED WORKFLOW

**Best approach for most users:**

1. **Setup once:** Create the bookmarklet (2 minutes)
2. **After editing pages:** Click bookmarklet on each changed page (5 sec each)
3. **Move files:** Drag downloaded files to `current_state/pages/`

**Total time for 3 page exports:** ~30 seconds

---

## ❓ TROUBLESHOOTING

### "Nothing happens when I click bookmarklet"
- Make sure you're on a page **editor** screen, not the page list
- Page must be in **Edit** mode, not preview

### "Download has wrong content"
- Make sure you've **saved** your changes first
- Bookmarklet exports the current editor content

### "I prefer manual copy"
That's fine! The Code Editor method works great and requires zero setup.

---

## 📝 QUICK REFERENCE

**Code Editor Path:**
Edit Page → ⋮ Menu → Code editor → Select All → Copy

**Bookmarklet:**
[Create bookmark with JavaScript code above]

**Destination:**
`current_state/pages/[pagename].html`

**When to Use:**
After making changes to any page content in WordPress

---

Choose the method that works best for you! The bookmarklet is fastest once set up, but the manual Code Editor method works perfectly fine too.
