# Lexington Alarm Python Scripts Reference

**Last Updated:** January 2025  
**Location:** `/Users/jtsackton/Desktop/LexingtonAlarm_Docs/wpforms_export_script/`

---

## Overview

This document provides a quick reference for all Python3 scripts created for Lexington Alarm. All scripts are located in the `wpforms_export_script` folder within the documentation directory.

---

## Script Inventory

| Script | Purpose | Run Frequency |
|--------|---------|---------------|
| `wpforms_export.py` | Main automated form export via REST API | Nightly (2 AM cron) |
| `wpforms_db_export.py` | Direct database export (bypass API) | Manual as needed |
| `fix_zipcodes.py` | Fix leading zeros in ZIP codes | One-time utility |

---

## Detailed Script Descriptions

### 1. wpforms_export.py (Main Export Script)

**Purpose:** Automated nightly export of WPForms entries to CSV files with optional deletion of old entries.

**What It Does:**
- Connects to WordPress site via REST API using Application Password
- Fetches new entries from specified WPForms
- Appends data to monthly CSV files in Proton Drive folder
- Queues entries older than 14 days for deletion (with 48-hour notification period)
- Sends email notifications about pending deletions
- Maintains activity log

**Location:**  
`/Users/jtsackton/Desktop/LexingtonAlarm_Docs/wpforms_export_script/wpforms_export.py`

**Configuration File:**  
`config.yaml` (same folder)

**Output Folder:**  
`/Users/jtsackton/Library/CloudStorage/ProtonDrive-info@lexingtonalarm.org-folder/LexingtonAlarm Executive/WP_Form_Data_Files/`

**How to Run Manually:**
```bash
cd /Users/jtsackton/Desktop/LexingtonAlarm_Docs/wpforms_export_script
python3 wpforms_export.py
```

**Automated Schedule:**  
Runs nightly at 2 AM via cron job:
```
0 2 * * * /usr/bin/python3 /Users/jtsackton/Desktop/LexingtonAlarm_Docs/wpforms_export_script/wpforms_export.py >> /tmp/wpforms_export.log 2>&1
```

**Key Settings in config.yaml:**
- `test_mode: true` - When true, no entries are deleted (safe testing)
- `retention_days: 14` - Days before entries are queued for deletion
- `wait_hours: 48` - Hours to wait before actually deleting

**How to Pause Deletions:**  
Create file `PAUSE_DELETIONS.txt` in the output folder

**Dependencies:**
```bash
pip3 install pyyaml requests
```

**Forms Exported:**
| Form Name | Form ID |
|-----------|---------|
| Massport Email Action | 1478 |
| Massport Board Letters | 1401 |
| Lexington Alarm Response | 21 |
| Battle Green Flag Policy | 19 |

---

### 2. wpforms_db_export.py (Direct Database Export)

**Purpose:** Export WPForms entries by connecting directly to the WordPress MySQL database, bypassing the REST API.

**When to Use:**
- If the REST API endpoint isn't working
- For faster bulk exports
- When you need entries from multiple forms combined into one CSV
- As a backup method if `wpforms_export.py` fails

**What It Does:**
- Connects directly to Bluehost MySQL database
- Exports Massport campaign forms (Governor, Email, Board Letters) into a **single combined CSV**
- Preserves leading zeros on ZIP codes
- Appends only new entries (checks for duplicates)
- Does NOT delete any entries (export only)

**Location:**  
`/Users/jtsackton/Desktop/LexingtonAlarm_Docs/wpforms_export_script/wpforms_db_export.py`

**How to Run:**
```bash
cd /Users/jtsackton/Desktop/LexingtonAlarm_Docs/wpforms_export_script
python3 wpforms_db_export.py
```

**Output File:**  
`massport_all-YYYY-MM.csv` (combines all 3 Massport forms)

**Output Location:**  
Same Proton Drive folder as the main script

**Database Connection:**
- Host: `50.6.2.226` (Bluehost Remote MySQL)
- Database: `ozpxkamy_WPJYZ`
- Credentials stored directly in script

**Forms Combined:**
| Form Name | Form ID |
|-----------|---------|
| Massport Governor | 1510 |
| Massport Email | 1478 |
| Massport Board Letters | 1401 |

**Dependencies:**
```bash
pip3 install mysql-connector-python
```

---

### 3. fix_zipcodes.py (ZIP Code Fixer Utility)

**Purpose:** One-time utility to fix leading zeros stripped from ZIP codes in existing CSV files.

**When to Use:**
- If you notice ZIP codes like "2421" instead of "02421" in exported CSVs
- After importing data that lost leading zeros
- One-time fix for existing data (new exports now preserve zeros automatically)

**What It Does:**
- Reads a CSV file
- Finds any columns with "zip" in the name
- Pads 4-digit ZIP codes to 5 digits with leading zero (e.g., "2421" → "02421")
- Formats 9-digit ZIPs properly (e.g., "024211234" → "02421-1234")
- Overwrites the original file with fixed data

**Location:**  
`/Users/jtsackton/Desktop/LexingtonAlarm_Docs/wpforms_export_script/fix_zipcodes.py`

**How to Run:**
1. Edit the script to set the correct `INPUT_FILE` path
2. Run:
```bash
cd /Users/jtsackton/Desktop/LexingtonAlarm_Docs/wpforms_export_script
python3 fix_zipcodes.py
```

**Configuration:**  
Edit these lines in the script before running:
```python
INPUT_FILE = '/path/to/your/csv/file.csv'
OUTPUT_FILE = INPUT_FILE  # Set to same file to overwrite, or different path for new file
```

**No Dependencies Required** (uses only Python standard library)

---

## Supporting Files

| File | Purpose |
|------|---------|
| `config.yaml` | Configuration for wpforms_export.py (credentials, settings) |
| `requirements.txt` | Python package dependencies |
| `INSTALLATION-GUIDE.txt` | Detailed setup instructions |
| `README.md` | Quick start guide |
| `PAUSE_DELETIONS.txt` | Template - copy to output folder to pause deletions |
| `com.lexingtonalarm.wpforms-export.plist` | macOS launchd scheduler (alternative to cron) |
| `wpforms-entries-api-snippet.php` | PHP snippet for WordPress REST API endpoint |
| `wpforms-entries-api-snippet-v2.php` | Updated version of PHP API snippet |

---

## Common Tasks

### Check if nightly export is running:
```bash
crontab -l
```

### View recent export log:
```bash
tail -100 /tmp/wpforms_export.log
```

### Test WordPress API connection:
```bash
cd /Users/jtsackton/Desktop/LexingtonAlarm_Docs/wpforms_export_script
python3 -c "from wpforms_export import load_config, WPFormsAPI, setup_logging; c = load_config(); l = setup_logging(c); api = WPFormsAPI(c, l); print('Connected!' if api.test_connection() else 'Failed!')"
```

### Export Massport Forms Data (Most Common Task)

**One-liner for zsh terminal — copy and paste:**
```zsh
cd /Users/jtsackton/Desktop/LexingtonAlarm_Docs/wpforms_export_script && python3 wpforms_db_export.py
```

**Or step by step:**
```zsh
# Step 1: Change to scripts directory
cd /Users/jtsackton/Desktop/LexingtonAlarm_Docs/wpforms_export_script

# Step 2: Run the export
python3 wpforms_db_export.py
```

**Output:** Creates/updates `massport_all-YYYY-MM.csv` in Proton Drive folder

---

## Troubleshooting

**"No module named 'yaml'" or "No module named 'requests'":**
```bash
pip3 install pyyaml requests
```

**"No module named 'mysql.connector'":**
```bash
pip3 install mysql-connector-python
```

**"Connection refused" or timeout errors:**
- Check internet connection
- Verify WordPress site is accessible
- Check Bluehost Remote MySQL is enabled (for db_export)

**"401 Unauthorized":**
- Verify Application Password in config.yaml
- Create new Application Password in WordPress

**Script runs but no data exported:**
- Check that forms have entries
- Verify form IDs match your live site
- Run with `python3 wpforms_export.py` to see output

---

## File Locations Summary

| What | Where |
|------|-------|
| Scripts | `/Users/jtsackton/Desktop/LexingtonAlarm_Docs/wpforms_export_script/` |
| CSV Output | `/Users/jtsackton/Library/CloudStorage/ProtonDrive-info@lexingtonalarm.org-folder/LexingtonAlarm Executive/WP_Form_Data_Files/` |
| Export Log | `/tmp/wpforms_export.log` (or in output folder as `export-log.txt`) |
| Pending Deletions | Output folder → `pending_deletions.json` |

---

## Quick Reference Commands (zsh)

```zsh
# ========================================
# MOST COMMON: Export Massport Forms Data
# ========================================
cd /Users/jtsackton/Desktop/LexingtonAlarm_Docs/wpforms_export_script && python3 wpforms_db_export.py

# ========================================
# Other Commands
# ========================================

# Navigate to scripts folder
cd /Users/jtsackton/Desktop/LexingtonAlarm_Docs/wpforms_export_script

# Run main export (API-based, runs nightly via cron)
python3 wpforms_export.py

# Fix ZIP codes in a CSV
python3 fix_zipcodes.py

# Check cron schedule
crontab -l

# View recent logs
tail -50 /tmp/wpforms_export.log
```

---

## Appendix: Full Script Code

### wpforms_db_export.py - Combined Massport Data Pull

This script pulls all entries from all three Massport forms (Governor, Email, Board Letters) and combines them into a single CSV file. Useful for seeing which people have taken multiple actions.

**Full Script Code:**

```python
#!/usr/bin/env python3
"""
WPForms Direct Database Export
==============================
Lexington Alarm - Simple Form Data Export

Connects directly to WordPress MySQL database and exports
WPForms entries to CSV files in Proton Drive folder.

No PHP, no REST API, no deletion - just reliable CSV export.
"""

import os
import csv
import json
import mysql.connector
from datetime import datetime
from pathlib import Path

# ============================================================
# CONFIGURATION - Edit these values as needed
# ============================================================

# Database connection (Bluehost Remote MySQL)
DB_CONFIG = {
    'host': '50.6.2.226',
    'database': 'ozpxkamy_WPJYZ',
    'user': 'ozpxkamy_WPJYZ',
    'password': '#P]%q{UdhplXiK@fR',
    'charset': 'utf8',
    'connection_timeout': 30
}

# WordPress table prefix
TABLE_PREFIX = 'vcS_'

# Massport campaign forms to combine into single CSV
MASSPORT_FORMS = [
    {'id': 1510, 'name': 'massport-governor'},
    {'id': 1478, 'name': 'massport-email'},
    {'id': 1401, 'name': 'massport-board-letters'},
]

# Output folder (Proton Drive)
OUTPUT_FOLDER = '/Users/jtsackton/Library/CloudStorage/ProtonDrive-info@lexingtonalarm.org-folder/LexingtonAlarm Executive/WP_Form_Data_Files'

# ============================================================
# MAIN SCRIPT - No need to edit below this line
# ============================================================

def get_existing_entry_keys(csv_path):
    """Read existing entry keys (form_id-entry_id) from CSV to avoid duplicates."""
    existing_keys = set()
    if csv_path.exists():
        try:
            with open(csv_path, 'r', newline='', encoding='utf-8') as f:
                reader = csv.DictReader(f)
                for row in reader:
                    if 'entry_id' in row and 'form_id' in row:
                        key = f"{row['form_id']}-{row['entry_id']}"
                        existing_keys.add(key)
        except Exception as e:
            print(f"  Warning: Could not read existing CSV: {e}")
    return existing_keys


def format_zip_code(value):
    """Format ZIP code to preserve leading zeros.
    
    Handles:
    - 5-digit ZIPs: "2421" -> "02421"
    - 9-digit ZIPs: "024211234" or "02421-1234" -> "02421-1234"
    - Empty/None values
    """
    if not value:
        return value
    
    # Remove any existing dashes and spaces
    clean_zip = str(value).replace('-', '').replace(' ', '').strip()
    
    # Skip if not numeric (might be non-US or invalid)
    if not clean_zip.isdigit():
        return value
    
    # 5-digit ZIP: pad with leading zeros
    if len(clean_zip) <= 5:
        return clean_zip.zfill(5)
    
    # 9-digit ZIP: format as XXXXX-XXXX
    if len(clean_zip) == 9:
        return f"{clean_zip[:5].zfill(5)}-{clean_zip[5:]}"
    
    # Other lengths: return as-is
    return value


def parse_fields(fields_json):
    """Parse WPForms fields JSON into flat dictionary."""
    fields = {}
    hidden_fields = {}
    if not fields_json:
        return fields, hidden_fields
    
    try:
        data = json.loads(fields_json)
        if isinstance(data, dict):
            for field_id, field_data in data.items():
                if isinstance(field_data, dict):
                    name = field_data.get('name', f'field_{field_id}')
                    value = field_data.get('value', '')
                    field_type = field_data.get('type', '')
                    
                    # Clean field name for CSV header
                    clean_name = name.lower().replace(' ', '_').replace('-', '_')
                    clean_name = ''.join(c for c in clean_name if c.isalnum() or c == '_')
                    
                    # Format ZIP codes to preserve leading zeros
                    if 'zip' in clean_name.lower():
                        value = format_zip_code(value)
                    
                    # Track hidden fields separately
                    if field_type == 'hidden':
                        hidden_fields[f"hidden_{clean_name}"] = value
                    
                    fields[clean_name] = value
                else:
                    fields[f'field_{field_id}'] = str(field_data)
    except json.JSONDecodeError:
        pass
    
    return fields, hidden_fields


def export_combined_massport(cursor, forms, output_folder):
    """Export entries from multiple forms into a single combined CSV."""
    print(f"\nProcessing combined Massport forms...")
    
    # Generate CSV filename with current month
    now = datetime.now()
    csv_filename = f"massport_all-{now.year}-{str(now.month).zfill(2)}.csv"
    csv_path = Path(output_folder) / csv_filename
    
    # Get existing entry keys to avoid duplicates
    existing_keys = get_existing_entry_keys(csv_path)
    print(f"  Existing entries in CSV: {len(existing_keys)}")
    
    # Build form ID to name mapping
    form_id_to_name = {form['id']: form['name'] for form in forms}
    form_ids = [form['id'] for form in forms]
    
    # Query database for entries from all forms
    table_name = f"{TABLE_PREFIX}wpforms_entries"
    placeholders = ', '.join(['%s'] * len(form_ids))
    query = f"""
        SELECT DISTINCT entry_id, form_id, user_id, status, 
               fields, date, date_modified, ip_address, user_agent
        FROM {table_name}
        WHERE form_id IN ({placeholders})
        ORDER BY date ASC, entry_id ASC
    """
    
    cursor.execute(query, form_ids)
    entries = cursor.fetchall()
    print(f"  Total entries in database across {len(forms)} forms: {len(entries)}")
    
    # Show per-form counts
    for form in forms:
        form_count = sum(1 for e in entries if e['form_id'] == form['id'])
        print(f"    - {form['name']} (ID {form['id']}): {form_count} entries")
    
    if not entries:
        print(f"  No entries found")
        return 0
    
    # Filter to only new entries
    new_entries = []
    for entry in entries:
        key = f"{entry['form_id']}-{entry['entry_id']}"
        if key not in existing_keys:
            new_entries.append(entry)
    
    print(f"  New entries to add: {len(new_entries)}")
    
    if not new_entries:
        print(f"  No new entries to export")
        return 0
    
    # Parse all entries and collect all field names
    parsed_entries = []
    all_field_names = set()
    all_hidden_names = set()
    
    for entry in new_entries:
        form_name = form_id_to_name.get(entry['form_id'], f"form_{entry['form_id']}")
        
        parsed = {
            'entry_id': entry['entry_id'],
            'form_id': entry['form_id'],
            'form_name': form_name,
            'date_created': entry['date'].isoformat() if entry['date'] else '',
            'date_modified': entry['date_modified'].isoformat() if entry.get('date_modified') else '',
            'status': entry.get('status', ''),
            'user_id': entry.get('user_id', ''),
            'ip_address': entry.get('ip_address', ''),
            'export_timestamp': now.isoformat()
        }
        
        # Parse form fields (including hidden fields)
        fields, hidden_fields = parse_fields(entry.get('fields', ''))
        parsed.update(fields)
        parsed.update(hidden_fields)
        all_field_names.update(fields.keys())
        all_hidden_names.update(hidden_fields.keys())
        
        parsed_entries.append(parsed)
    
    # Determine CSV headers - put form_name early, hidden fields at end
    standard_headers = ['entry_id', 'form_id', 'form_name', 'date_created', 'date_modified', 
                       'status', 'user_id', 'ip_address', 'export_timestamp']
    field_headers = sorted([f for f in all_field_names if not f.startswith('hidden_')])
    hidden_headers = sorted(list(all_hidden_names))
    
    # If file exists, read existing headers
    if csv_path.exists():
        with open(csv_path, 'r', newline='', encoding='utf-8') as f:
            reader = csv.reader(f)
            existing_headers = next(reader, [])
            # Merge headers (keep existing order, add new ones at end)
            for header in standard_headers + field_headers + hidden_headers:
                if header not in existing_headers:
                    existing_headers.append(header)
            all_headers = existing_headers
    else:
        all_headers = standard_headers + field_headers + hidden_headers
    
    # Write to CSV
    file_exists = csv_path.exists()
    mode = 'a' if file_exists else 'w'
    
    with open(csv_path, mode, newline='', encoding='utf-8') as f:
        writer = csv.DictWriter(f, fieldnames=all_headers, extrasaction='ignore')
        
        if not file_exists:
            writer.writeheader()
        
        for entry in parsed_entries:
            writer.writerow(entry)
    
    print(f"  ✓ Added {len(parsed_entries)} entries to {csv_filename}")
    return len(parsed_entries)


def main():
    """Main entry point."""
    print("=" * 60)
    print("WPForms Direct Database Export")
    print(f"Started: {datetime.now().strftime('%Y-%m-%d %H:%M:%S')}")
    print("=" * 60)
    
    # Ensure output folder exists
    output_path = Path(OUTPUT_FOLDER)
    output_path.mkdir(parents=True, exist_ok=True)
    
    # Connect to database
    print(f"\nConnecting to database at {DB_CONFIG['host']}...")
    
    try:
        connection = mysql.connector.connect(**DB_CONFIG)
        cursor = connection.cursor(dictionary=True)
        print("✓ Connected successfully")
    except mysql.connector.Error as e:
        print(f"✗ Database connection failed: {e}")
        return 1
    
    # Export combined Massport forms
    total_exported = 0
    
    try:
        count = export_combined_massport(cursor, MASSPORT_FORMS, OUTPUT_FOLDER)
        total_exported += count
    except Exception as e:
        print(f"\n✗ Error during export: {e}")
        import traceback
        traceback.print_exc()
        return 1
    finally:
        cursor.close()
        connection.close()
        print("\n✓ Database connection closed")
    
    # Summary
    print("\n" + "=" * 60)
    print("Export Complete!")
    print(f"  Total new entries exported: {total_exported}")
    print(f"  Output folder: {OUTPUT_FOLDER}")
    print(f"  Finished: {datetime.now().strftime('%Y-%m-%d %H:%M:%S')}")
    print("=" * 60)
    
    return 0


if __name__ == "__main__":
    exit(main())
```

**Note:** If you get an "Access denied" error when running this script, your home IP address may have changed. Add your new IP to Bluehost's Remote MySQL allowed list in cPanel (Databases → Remote MySQL).

---

*Document created: December 2025*
