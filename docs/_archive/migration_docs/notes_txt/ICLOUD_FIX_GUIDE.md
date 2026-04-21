# iCloud File Management Issues - Solution Guide

## Problem
iCloud is automatically offloading your GitHub files to save space, making them unavailable locally. Files show with a cloud icon and have `.icloud` prefix when offloaded.

## Immediate Fix
Run these commands to download all files now:

```bash
cd /Users/jtsackton/Documents/github_lexington_alarm
find . -type f -exec brctl download {} \;
```

## Permanent Solutions

### Solution 1: Add .nosync to Folder (BEST)
Prevents iCloud from managing this folder entirely:

```bash
cd /Users/jtsackton/Documents
mv github_lexington_alarm github_lexington_alarm.nosync
ln -s github_lexington_alarm.nosync github_lexington_alarm
```

### Solution 2: Move Outside iCloud
Move the repository outside of Documents:

```bash
mv /Users/jtsackton/Documents/github_lexington_alarm ~/github_lexington_alarm
```

### Solution 3: Disable iCloud for Documents
1. System Preferences → Apple ID → iCloud
2. Click "Options" next to iCloud Drive
3. Uncheck "Desktop & Documents Folders"
   
**Warning:** This affects ALL documents, not just GitHub

### Solution 4: Use the Script
Run the `prevent_icloud_offload.sh` script periodically:

```bash
cd /Users/jtsackton/Documents/github_lexington_alarm/wordpress_site/notes_txt
chmod +x prevent_icloud_offload.sh
./prevent_icloud_offload.sh
```

## Check File Status

See which files are offloaded:
```bash
ls -la | grep .icloud
```

Check specific file status:
```bash
brctl evict status filename
```

## For Your WordPress Files

Your critical files to keep local:
- `wordpress_site/database/ozpxkamy_WPJYZ.sql` (7.3MB database)
- `wordpress_site/wp-content/` (all theme and plugin files)
- `wordpress_site/notes_txt/` (documentation)

## Recommended Action

1. **Immediately:** Run the download command to get all files local
2. **Then:** Rename folder to `github_lexington_alarm.nosync`
3. **Result:** iCloud will never offload these files again

## Why This Happens

- iCloud tries to save local space by offloading "older" files
- It doesn't understand these are active development files
- The `.nosync` extension tells iCloud to completely ignore the folder

---

**Note:** After renaming to `.nosync`, your folder path stays the same for all practical purposes due to the symbolic link.