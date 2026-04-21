# AUTOMATED BACKUP PLAN - Lexington Alarm WordPress
**Goal:** Daily backups to local wordpress_site folder

---

## 🎯 BACKUP STRATEGY

### What to Backup:
1. **Database** (daily) - All content and settings
2. **Code Snippets** (when changed) - Custom PHP functions  
3. **Custom CSS** (when changed) - Site styling
4. **Media Uploads** (daily) - Recent images/files
5. **Plugin Updates** (when installed/updated) - Track versions

### Where Backups Go:
```
wordpress_site/
├── database/
│   └── daily-backup-YYYY-MM-DD.sql
├── exported_snippets/
│   └── wpcode-export-YYYY-MM-DD.json
├── current_state/
│   ├── css/kadence_custom.css
│   └── uploads/ (recent files)
└── backup_log.txt
```

---

## 🔧 AUTOMATED BACKUP OPTIONS

### Option 1: UpdraftPlus Plugin (RECOMMENDED - Easiest)
**Setup:**
1. Install UpdraftPlus plugin in WordPress
2. Configure backup schedule:
   - **Database:** Daily at 2 AM
   - **Files:** Weekly on Sunday at 3 AM
3. Set backup destination:
   - Google Drive (recommended)
   - OR Dropbox
   - OR local folder: `/Users/jtsackton/Documents/github_lexington_alarm/wordpress_site/updraftplus_backups/`
4. Enable "Retain 7 backups" (1 week of history)

**What it backs up automatically:**
- ✅ Full database
- ✅ wp-content (themes, plugins, uploads)
- ✅ WordPress core files
- ✅ One-click restore

**Setup Time:** 5 minutes  
**Cost:** Free (Pro version $70/yr for more features)

---

### Option 2: WP-CLI + Cron Job (Advanced - For developers)
**Only if you have SSH access to your server**

**Create backup script:** `/usr/local/bin/wp-backup.sh`
```bash
#!/bin/bash
DATE=$(date +%Y-%m-%d)
BACKUP_DIR="/Users/jtsackton/Documents/github_lexington_alarm/wordpress_site/database"
WP_PATH="/Users/jtsackton/Local Sites/la-wordpress-local/app/public"

# Export database
cd "$WP_PATH"
wp db export "$BACKUP_DIR/daily-backup-$DATE.sql"

# Keep only last 7 days
find "$BACKUP_DIR" -name "daily-backup-*.sql" -mtime +7 -delete

# Log it
echo "Backup completed: $DATE" >> "$BACKUP_DIR/backup_log.txt"
```

**Make executable:**
```bash
chmod +x /usr/local/bin/wp-backup.sh
```

**Add to cron (daily at 2 AM):**
```bash
crontab -e
# Add this line:
0 2 * * * /usr/local/bin/wp-backup.sh
```

**What it backs up:**
- ✅ Database daily
- ❌ Need separate script for files

**Setup Time:** 30 minutes  
**Cost:** Free

---

### Option 3: Local by Flywheel Built-in Backup
**Local app includes backup features:**

1. Open Local app
2. Right-click site → Export
3. Creates .zip file with:
   - Full database
   - All files
   - wp-config.php

**Manual Process:**
- Export weekly
- Save to: `wordpress_site/local_exports/`
- Name: `lexington-alarm-YYYY-MM-DD.zip`

**What it backs up:**
- ✅ Complete site
- ✅ One-click restore
- ❌ Must be done manually (not automated)

**Setup Time:** 0 minutes (built-in)  
**Cost:** Free

---

### Option 4: Bluehost Backup (Production Only)
**After migration to lexingtonalarm.org:**

1. Login to Bluehost cPanel
2. Check backup options included in your plan:
   - **Backup:** Most plans include daily backups
   - **CodeGuard:** Premium backup service ($24/yr)
3. Download backups weekly to local storage

**What it backs up:**
- ✅ Full site (files + database)
- ✅ 30-day retention
- ⚠️ Restore may require Bluehost support

**Setup Time:** Already configured  
**Cost:** Included (or $24/yr for CodeGuard)

---

## 📋 RECOMMENDED SETUP - HYBRID APPROACH

### For Local Development (Before Migration):
**Option 1: UpdraftPlus** ← Best for ease
- Install in Local WordPress site
- Backup to Google Drive daily
- Automatic, reliable, easy restore

**Option 3: Local Export** ← Best for peace of mind
- Export weekly as .zip file
- Keep 4 weeks of backups
- Offline copy on your computer

### For Production (After Migration):
**UpdraftPlus + Bluehost** ← Best combination
- UpdraftPlus backs up to cloud (Google Drive)
- Bluehost backup as redundancy
- Download monthly copy to local storage
- 3 backup locations: Cloud + Server + Local

---

## 🚀 QUICK START - RECOMMENDED PATH

### Step 1: Install UpdraftPlus (5 minutes)
```
1. WordPress Admin → Plugins → Add New
2. Search "UpdraftPlus"
3. Install and Activate
4. Settings → UpdraftPlus Backups → Settings tab
```

### Step 2: Configure Schedule
```
Database backup schedule: Daily at 02:00
Files backup schedule: Weekly on Sunday at 03:00
Retain backups: 7 (database), 4 (files)
```

### Step 3: Set Destination
```
Remote storage: Google Drive (free)
Click "Authenticate with Google"
Grant permissions
Test connection
```

### Step 4: Run First Backup
```
Click "Backup Now"
Select: Database + Files
Wait for completion (3-5 minutes)
Verify backup appears in Google Drive
```

### Step 5: Test Restore (Important!)
```
Go to UpdraftPlus → Restore tab
Restore to test that backups work
(Do this in Local, not production!)
```

---

## 📊 BACKUP FREQUENCY RECOMMENDATIONS

| Content Type | Frequency | Why |
|--------------|-----------|-----|
| Database | Daily | Contains all posts, settings, changes |
| Code Snippets | When changed | Custom functionality |
| Custom CSS | When changed | Site styling |
| Uploads | Daily | New images/files |
| Full Site | Weekly | Complete snapshot |
| Off-site Copy | Monthly | Disaster recovery |

---

## 🔍 MONITORING YOUR BACKUPS

### Weekly Checklist:
- [ ] UpdraftPlus shows "Last backup: Success"
- [ ] Google Drive has latest backup files
- [ ] Backup log shows no errors
- [ ] File sizes look reasonable (database >5MB)

### Monthly Checklist:
- [ ] Test restore of backup (in Local, not production!)
- [ ] Download copy of backup to external drive
- [ ] Verify all backup destinations accessible
- [ ] Clean up old backups (keep 3 months)

---

## ⚠️ IMPORTANT BACKUP CONSIDERATIONS

### What UpdraftPlus Backs Up:
- ✅ Database (all posts, pages, settings)
- ✅ Themes (including Kadence + custom fonts)
- ✅ Plugins (all installed plugins)
- ✅ Uploads (all media files)
- ✅ wp-config.php (site configuration)

### What UpdraftPlus DOES NOT Back Up:
- ❌ Server configuration (handled by hosting)
- ❌ DNS records (managed at GoDaddy)
- ❌ Email (managed by Proton)
- ❌ .htaccess rules (may need manual backup)

### Manual Backups Still Needed:
1. **Code Snippets Export** (WPCode → Tools → Export)
   - Do this before major changes
   - Save to: `exported_snippets/`

2. **Custom CSS Copy** (When you make CSS changes)
   - Copy from Customizer
   - Save to: `current_state/css/kadence_custom.css`

3. **Page HTML Exports** (For Claude collaboration)
   - Use bookmarklet or code editor
   - Save to: `current_state/pages/`

---

## 🆘 RESTORE SCENARIOS

### Scenario 1: Accidental Page Deletion
**Use:** UpdraftPlus → Restore → Database only  
**Time:** 5 minutes  
**Impact:** Restores all content, loses changes since last backup

### Scenario 2: Plugin Breaking Site
**Use:** UpdraftPlus → Restore → Plugins only  
**Time:** 3 minutes  
**Impact:** Restores working plugin versions

### Scenario 3: Complete Site Disaster
**Use:** UpdraftPlus → Restore → All Components  
**Time:** 15-20 minutes  
**Impact:** Full site restore to last backup point

### Scenario 4: Migration Went Wrong
**Use:** Local by Flywheel → Import from .zip  
**Time:** 10 minutes  
**Impact:** Restore to pre-migration state

---

## 📁 BACKUP FILE STRUCTURE

After setup, your backups will be organized:

```
wordpress_site/
├── database/
│   └── daily-backup-2025-10-14.sql (manual exports)
├── exported_snippets/
│   └── wpcode-export-2025-10-14.json
├── current_state/
│   └── (synced working files)
└── updraftplus_backups/ (if storing locally)
    ├── backup-2025-10-14-database.gz
    ├── backup-2025-10-14-themes.zip
    ├── backup-2025-10-14-plugins.zip
    └── backup-2025-10-14-uploads.zip
```

Google Drive backups will be in:
```
Google Drive/UpdraftPlus/
└── lexingtonalarm.org/ (or site name)
    ├── backup-2025-10-14-database.gz
    ├── backup-2025-10-14-themes.zip
    ├── backup-2025-10-14-plugins.zip
    └── backup-2025-10-14-uploads.zip
```

---

## 💰 COST COMPARISON

| Method | Setup | Ongoing Cost | Automation | Ease |
|--------|-------|--------------|------------|------|
| UpdraftPlus Free | 5 min | $0 | Full | ⭐⭐⭐⭐⭐ |
| UpdraftPlus Pro | 5 min | $70/yr | Full+ | ⭐⭐⭐⭐⭐ |
| Local Export | 0 min | $0 | Manual | ⭐⭐⭐ |
| WP-CLI + Cron | 30 min | $0 | Partial | ⭐⭐ |
| Bluehost | 0 min | Included | Full | ⭐⭐⭐⭐ |

**Recommendation:** Start with UpdraftPlus Free + Google Drive

---

## ✅ FINAL RECOMMENDATION

### Best Setup for Your Needs:

**NOW (Pre-Migration):**
1. Install UpdraftPlus in Local WordPress
2. Backup to Google Drive daily
3. Do weekly Local exports as .zip files
4. Keep current_state/ folder synced for Claude

**AFTER MIGRATION (Production):**
1. Install UpdraftPlus on production site
2. Backup to Google Drive daily
3. Bluehost backups run automatically
4. Download monthly copy to external drive

**Result:**
- 3 backup locations (Cloud + Server + Local)
- Daily automated backups
- Easy one-click restore
- Peace of mind

---

**Total Setup Time:** 10 minutes  
**Total Cost:** $0 (free tier sufficient)  
**Maintenance:** 5 minutes per month

---

## 📞 NEED HELP?

**UpdraftPlus Support:**
- Docs: https://updraftplus.com/support/
- Video tutorials available
- Large community forum

**Questions for Claude:**
- "How do I test an UpdraftPlus restore?"
- "Walk me through first-time UpdraftPlus setup"
- "What if my backup fails?"

---

**Last Updated:** October 14, 2025  
**Status:** Ready to implement
