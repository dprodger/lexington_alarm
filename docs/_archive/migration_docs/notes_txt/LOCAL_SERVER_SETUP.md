# Local WordPress Configuration

## Edit wp-config.php for Local Development

Change these settings in your wp-config.php:

```php
// Database settings for LOCAL MAMP
define( 'DB_NAME', 'lexington_alarm_local' );  // Your local database name
define( 'DB_USER', 'root' );                    // MAMP default
define( 'DB_PASSWORD', 'root' );                // MAMP default  
define( 'DB_HOST', 'localhost' );               // or localhost:8889 for MAMP

// Add these lines for local development
define( 'WP_HOME', 'http://localhost:8888/lexington-alarm' );
define( 'WP_SITEURL', 'http://localhost:8888/lexington-alarm' );

// Debug mode for local
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );
```

## Update Database URLs

Run these SQL queries in phpMyAdmin after importing:

```sql
-- Update site URLs to local
UPDATE vcS_options 
SET option_value = 'http://localhost:8888/lexington-alarm' 
WHERE option_name IN ('siteurl', 'home');

-- Update content URLs
UPDATE vcS_posts 
SET post_content = REPLACE(post_content, 
    'https://bpx.ela.mybluehost.me/website_97a098b6', 
    'http://localhost:8888/lexington-alarm');

UPDATE vcS_posts 
SET guid = REPLACE(guid, 
    'https://bpx.ela.mybluehost.me/website_97a098b6', 
    'http://localhost:8888/lexington-alarm');

-- Update any serialized data (be careful with this)
UPDATE vcS_postmeta 
SET meta_value = REPLACE(meta_value, 
    'bpx.ela.mybluehost.me/website_97a098b6', 
    'localhost:8888/lexington-alarm')
WHERE meta_value LIKE '%bpx.ela.mybluehost.me%';
```

## Fix File Permissions

```bash
# Make uploads writable
chmod -R 755 /Applications/MAMP/htdocs/lexington-alarm/wp-content/uploads
```

## Access Your Local Site

1. Start MAMP
2. Go to: http://localhost:8888/lexington-alarm
3. Admin: http://localhost:8888/lexington-alarm/wp-admin

## Import Code Snippets

1. Login to local WordPress admin
2. Go to Code Snippets → Tools → Import
3. Upload: wpcode-snippets-export-2025-10-07.json
4. Activate snippets as needed

## Troubleshooting

### If white screen:
- Check PHP version in MAMP (use 7.4 or 8.0)
- Check error logs in `/Applications/MAMP/logs/`

### If database connection error:
- Verify MAMP MySQL is running
- Check port (might be 8889 instead of 3306)
- Update DB_HOST to 'localhost:8889' if needed

### If styles broken:
- Re-save permalinks in Settings → Permalinks
- Clear browser cache
- Check .htaccess file exists

### If images missing:
- Check uploads folder permissions
- Run search-replace again for URLs
- Verify path in wp-config.php