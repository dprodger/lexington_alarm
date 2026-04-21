<?php
/**
 * SIMPLE MANUAL NEWSLETTER ARCHIVE
 * Just paste your Mailchimp URLs into the list below
 * 
 * SETUP:
 * 1. Add to WPCode as PHP snippet
 * 2. Paste newsletter URLs into $newsletters array below
 * 3. Activate snippet
 * 4. Use shortcode: [newsletter_archive]
 * 
 * MAINTENANCE:
 * When you send a new newsletter:
 * 1. Get the "View in browser" link from Mailchimp
 * 2. Add it to the TOP of the $newsletters array below
 * 3. Click Update
 * 4. Done! Takes 30 seconds.
 */

function simple_newsletter_archive() {
    
    // ═══════════════════════════════════════════════════════════
    // PASTE YOUR NEWSLETTER URLS HERE
    // Add newest at the TOP
    // ═══════════════════════════════════════════════════════════
    
    $newsletters = array(
        
        // Newsletter URLs - ADD NEW ONES AT THE TOP
        
        'https://mailchi.mp/lexingtonalarm/burlington-to-vote-on-ice-facility-oct-18th-work-meeting-is-monday-9-29',
        
        // Add more URLs below, one per line
        // Just paste the full URL from Mailchimp's "View in browser" link
        
        // Examples (DELETE THESE and add your real ones):
        // 'https://mailchi.mp/lexingtonalarm/october-newsletter',
        // 'https://mailchi.mp/lexingtonalarm/september-newsletter',
        // 'https://mailchi.mp/lexingtonalarm/august-newsletter',
        
    );
    
    // ═══════════════════════════════════════════════════════════
    // NO NEED TO EDIT BELOW THIS LINE
    // ═══════════════════════════════════════════════════════════
    
    if (empty($newsletters)) {
        return '<p>Newsletter archive coming soon.</p>';
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
            foreach ($newsletters as $url) :
                // Skip empty URLs
                if (empty(trim($url))) continue;
                
                // Extract title and date from URL or use generic
                $url_parts = parse_url($url);
                $path_parts = explode('/', trim($url_parts['path'], '/'));
                $slug = end($path_parts);
                
                // Try to make a nice title from the URL slug
                $title = ucwords(str_replace('-', ' ', $slug));
                
                // For now, we'll use a generic format
                // You can manually set titles if you want
                $title = "Newsletter";
                $date = "View Archive";
            ?>
                <?php if (!$first) : ?>
                    <div class="archive-divider"></div>
                <?php endif; ?>
                
                <div class="archive-entry">
                    <div class="archive-icon">📧</div>
                    <div class="archive-content">
                        <h4 class="archive-title"><?php echo esc_html($title); ?></h4>
                        <p class="archive-date"><?php echo esc_html($date); ?></p>
                        <a href="<?php echo esc_url($url); ?>" 
                           target="_blank" 
                           class="archive-link">
                            View in Browser →
                        </a>
                    </div>
                </div>
                
                <?php $first = false; ?>
            <?php endforeach; ?>
        </div>
    </div>
    
    <style>
    /* Newsletter Archive Styling */
    .newsletter-archive-wrapper {
        max-width: 660px;
        margin: 40px auto;
        padding: 0 24px;
    }
    
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
    
    .archive-list {
        background: #ffffff;
        padding: 20px 0;
    }
    
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
add_shortcode('newsletter_archive', 'simple_newsletter_archive');
?>
