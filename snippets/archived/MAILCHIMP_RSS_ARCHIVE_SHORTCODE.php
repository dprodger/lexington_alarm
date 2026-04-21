<?php
/**
 * MAILCHIMP RSS NEWSLETTER ARCHIVE
 * 
 * Automatically pulls newsletters from your Mailchimp RSS feed
 * Filters to show only official newsletters (not announcements)
 * 
 * SETUP INSTRUCTIONS:
 * 1. Find your Mailchimp RSS URL (see MAILCHIMP_RSS_SETUP.md)
 * 2. Replace MAILCHIMP_RSS_URL below with your actual URL
 * 3. Add to WPCode as PHP snippet
 * 4. Use shortcode: [mailchimp_newsletter_archive]
 * 
 * NAMING CONVENTION:
 * Official newsletters must start with "Newsletter -"
 * Examples:
 *   ✅ "Newsletter - October 2025"
 *   ✅ "Newsletter - September 2025" 
 *   ❌ "URGENT: Town Meeting"  (will be filtered out)
 *   ❌ "Save the Date"  (will be filtered out)
 */

function mailchimp_newsletter_archive() {
    // ═══════════════════════════════════════════════════════════
    // CONFIGURATION - REPLACE THIS WITH YOUR ACTUAL RSS FEED URL
    // ═══════════════════════════════════════════════════════════
    
    $rss_url = 'REPLACE_WITH_YOUR_MAILCHIMP_RSS_URL';
    
    // Example: 
    // $rss_url = 'https://us12.campaign-archive.com/feed?u=abc123&id=xyz789';
    
    
    // ═══════════════════════════════════════════════════════════
    // FILTERING OPTIONS
    // ═══════════════════════════════════════════════════════════
    
    // Only show campaigns that start with this prefix
    $newsletter_prefix = 'Newsletter -';
    
    // Maximum number of newsletters to display
    $max_items = 24;
    
    // Cache duration (in seconds) - 12 hours = 43200
    // This prevents hitting Mailchimp on every page load
    $cache_duration = 43200;
    
    
    // ═══════════════════════════════════════════════════════════
    // VALIDATION
    // ═══════════════════════════════════════════════════════════
    
    if ($rss_url === 'REPLACE_WITH_YOUR_MAILCHIMP_RSS_URL') {
        return '<div style="border: 2px solid #c3202e; padding: 20px; background: #fff3cd;">
                    <strong>⚠️ Newsletter Archive Not Configured</strong><br>
                    Please update the RSS URL in the WPCode snippet.<br>
                    See MAILCHIMP_RSS_SETUP.md for instructions.
                </div>';
    }
    
    
    // ═══════════════════════════════════════════════════════════
    // FETCH RSS FEED (with caching)
    // ═══════════════════════════════════════════════════════════
    
    // Check cache first
    $cache_key = 'mailchimp_newsletters_' . md5($rss_url);
    $cached_items = get_transient($cache_key);
    
    if ($cached_items !== false) {
        $newsletter_items = $cached_items;
    } else {
        // Fetch fresh data from Mailchimp
        $rss = fetch_feed($rss_url);
        
        if (is_wp_error($rss)) {
            return '<div style="border: 2px solid #c3202e; padding: 20px;">
                        <strong>Error loading newsletter archive</strong><br>
                        Unable to connect to Mailchimp. Please try again later.
                    </div>';
        }
        
        $maxitems = $rss->get_item_quantity($max_items * 2); // Get extra to filter
        $rss_items = $rss->get_items(0, $maxitems);
        
        // Filter for newsletters only
        $newsletter_items = array();
        foreach ($rss_items as $item) {
            $title = $item->get_title();
            
            // Only include items that start with our newsletter prefix
            if (stripos($title, $newsletter_prefix) === 0) {
                $newsletter_items[] = array(
                    'title' => $title,
                    'url' => $item->get_permalink(),
                    'date' => $item->get_date('F j, Y')
                );
                
                // Stop when we have enough
                if (count($newsletter_items) >= $max_items) {
                    break;
                }
            }
        }
        
        // Cache the results
        set_transient($cache_key, $newsletter_items, $cache_duration);
    }
    
    
    // ═══════════════════════════════════════════════════════════
    // DISPLAY NEWSLETTERS
    // ═══════════════════════════════════════════════════════════
    
    if (empty($newsletter_items)) {
        return '<p>No newsletters available yet. Check back soon!</p>';
    }
    
    ob_start();
    ?>
    <div class="newsletter-archive-wrapper">
        <!-- Red Header Box -->
        <div class="newsletter-red-header">
            <h2>NEWSLETTER ARCHIVE</h2>
        </div>
        
        <!-- Archive List -->
        <div class="archive-list">
            <?php 
            $first = true;
            foreach ($newsletter_items as $newsletter) : 
            ?>
                <?php if (!$first) : ?>
                    <div class="archive-divider"></div>
                <?php endif; ?>
                
                <div class="archive-entry">
                    <div class="archive-icon">📧</div>
                    <div class="archive-content">
                        <h4 class="archive-title"><?php echo esc_html($newsletter['title']); ?></h4>
                        <p class="archive-date">Published: <?php echo esc_html($newsletter['date']); ?></p>
                        <a href="<?php echo esc_url($newsletter['url']); ?>" 
                           target="_blank" 
                           class="archive-link">
                            View in Browser →
                        </a>
                    </div>
                </div>
                
                <?php $first = false; ?>
            <?php endforeach; ?>
        </div>
        
        <div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd;">
            <p style="color: #666; font-size: 0.9em;">
                🔄 Archive updates automatically when new newsletters are sent
            </p>
        </div>
    </div>
    
    <style>
    /* Newsletter Archive Styling - Matches Newsletter Design */
    .newsletter-archive-wrapper {
        max-width: 660px;
        margin: 40px auto;
        padding: 0 24px;
    }
    
    /* Red Header Box */
    .newsletter-archive-wrapper .newsletter-red-header {
        background-color: #a33335;
        border-radius: 120px;
        padding: 24px;
        text-align: center;
        margin-bottom: 30px;
    }
    
    .newsletter-archive-wrapper .newsletter-red-header h2 {
        color: #ffffff;
        font-family: 'Work Sans', sans-serif;
        font-weight: bold;
        font-size: 31px;
        line-height: 1.5;
        margin: 0;
        text-transform: uppercase;
    }
    
    /* Archive List */
    .archive-list {
        background: #ffffff;
        padding: 20px 0;
    }
    
    /* Individual Archive Entry */
    .archive-entry {
        display: flex;
        align-items: flex-start;
        gap: 15px;
        padding: 20px 0;
    }
    
    .archive-icon {
        font-size: 32px;
        line-height: 1;
        flex-shrink: 0;
    }
    
    .archive-content {
        flex: 1;
    }
    
    .archive-title {
        font-family: 'Work Sans', sans-serif;
        font-size: 21px;
        font-weight: bold;
        color: #2b2b2b;
        margin: 0 0 5px 0;
    }
    
    .archive-date {
        font-family: 'Work Sans', sans-serif;
        font-size: 16px;
        color: #666666;
        margin: 0 0 10px 0;
    }
    
    .archive-link {
        color: #a33335;
        text-decoration: underline;
        font-family: 'Work Sans', sans-serif;
        font-size: 16px;
        font-weight: bold;
        transition: color 0.2s ease;
    }
    
    .archive-link:hover {
        color: #8a2a2e;
    }
    
    /* Archive Divider */
    .archive-divider {
        border-top: 2px solid #000000;
        margin: 20px 0;
    }
    
    /* Mobile Responsive */
    @media (max-width: 768px) {
        .newsletter-archive-wrapper {
            padding: 0 16px;
        }
        
        .newsletter-archive-wrapper .newsletter-red-header {
            padding: 20px 15px;
            border-radius: 60px;
        }
        
        .newsletter-archive-wrapper .newsletter-red-header h2 {
            font-size: 24px;
        }
        
        .archive-entry {
            flex-direction: column;
            gap: 10px;
        }
        
        .archive-icon {
            font-size: 28px;
        }
        
        .archive-title {
            font-size: 18px;
        }
    }
    </style>
    <?php
    return ob_get_clean();
}
add_shortcode('mailchimp_newsletter_archive', 'mailchimp_newsletter_archive');


/**
 * ═══════════════════════════════════════════════════════════
 * ADMIN UTILITY: Clear Cache Button
 * ═══════════════════════════════════════════════════════════
 * 
 * If you need to force refresh the newsletter list:
 * 1. Add this URL parameter to any page: ?clear_newsletter_cache=1
 * 2. Only works for administrators
 * 
 * Example: https://yoursite.com/news/?clear_newsletter_cache=1
 */
function clear_newsletter_cache_admin() {
    if (isset($_GET['clear_newsletter_cache']) && current_user_can('manage_options')) {
        // Clear all newsletter caches
        global $wpdb;
        $wpdb->query(
            "DELETE FROM $wpdb->options 
             WHERE option_name LIKE '_transient_mailchimp_newsletters_%' 
             OR option_name LIKE '_transient_timeout_mailchimp_newsletters_%'"
        );
        
        echo '<div style="position: fixed; top: 50px; right: 20px; 
                          background: #28a745; color: white; padding: 15px 20px; 
                          border-radius: 5px; z-index: 9999; box-shadow: 0 4px 6px rgba(0,0,0,0.2);">
                  ✅ Newsletter cache cleared! Page will refresh in 2 seconds...
              </div>';
        echo '<script>setTimeout(function(){ 
                window.location.href = window.location.pathname; 
              }, 2000);</script>';
    }
}
add_action('init', 'clear_newsletter_cache_admin');
?>
