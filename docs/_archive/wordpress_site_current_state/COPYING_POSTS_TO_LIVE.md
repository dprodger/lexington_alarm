# COPYING POSTS FROM LOCAL TO LIVE

## Method 1: WordPress Export/Import (Recommended)

### Step 1: Export from Local

1. **Go to:** Tools → Export
2. **Select:** Posts
3. **Options:**
   - Choose: All content (or select specific categories)
   - Date range: All dates
   - Status: All statuses
4. **Click:** Download Export File
5. **Save the XML file**

---

### Step 2: Import to Live

1. **Go to:** Tools → Import
2. **Click:** WordPress (if not installed, click "Install Now" first)
3. **Click:** Run Importer
4. **Choose the XML file** you downloaded
5. **Import Settings:**
   - ☐ Download and import file attachments (CHECK THIS for images)
   - Author assignment: 
     - Create new users OR
     - Assign to existing user
6. **Click:** Submit
7. **Wait for import to complete**

---

## What Gets Copied:

✅ Post titles
✅ Post content  
✅ Post excerpts
✅ Categories
✅ Tags
✅ Featured images (if you checked "import attachments")
✅ Post dates
✅ Post status (published, draft, pending)
✅ Authors

---

## Method 2: Plugin Method (If Export/Import Has Issues)

### Use: All-in-One WP Migration or Duplicator

This copies EVERYTHING including posts, but is more complex.

---

## After Import Verification

### Check Posts on Live:

1. **Go to:** Posts → All Posts
2. **Verify:**
   - ☐ All posts imported
   - ☐ Categories assigned correctly
   - ☐ Featured images showing
   - ☐ Post content looks correct
   
3. **Check Categories:**
   - ☐ Posts tagged with "feature" for featured story
   - ☐ Posts tagged with "blog" for blog grid
   
4. **View on News Page:**
   - ☐ Featured story displays (from "feature" category)
   - ☐ Blog grid displays (from "blog" category)

---

## Important Notes:

### Featured Story
Only ONE post should have the "feature" category at a time. After import:
1. Decide which post should be featured
2. Make sure it's the ONLY post with "feature" category
3. All others should be in "blog" category only

### Images
If featured images don't import:
1. Make sure you checked "Download and import file attachments"
2. Re-import if needed
3. Or manually set featured images on live site

### Categories Must Match
Make sure categories exist on live BEFORE importing:
- `feature`
- `blog`
- `archive`

---

## Troubleshooting

**"Import failed" error:**
- File too large: Increase PHP upload limit or break into smaller exports
- Use a plugin like WP All Import instead

**Posts imported but no images:**
- Re-import with "import attachments" checked
- Or use a media migration plugin

**Posts imported but wrong categories:**
- Create categories on live first (with exact same slugs)
- Re-import

**Duplicate posts:**
- WordPress should detect duplicates
- If not, delete duplicates manually

---

## Quick Steps Summary:

1. ☐ Create categories on live (feature, blog, archive)
2. ☐ Local: Tools → Export → Posts → Download
3. ☐ Live: Tools → Import → WordPress → Upload file
4. ☐ Check "Download and import file attachments"
5. ☐ Submit and wait
6. ☐ Verify posts imported correctly
7. ☐ Check News page displays correctly

---

**Estimated Time:** 5-15 minutes (depending on number of posts)

Need help with any of these steps?
