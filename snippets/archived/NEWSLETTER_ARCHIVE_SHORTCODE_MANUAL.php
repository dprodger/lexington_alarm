<?php
/**
 * MANUAL NEWSLETTER ARCHIVE SHORTCODE
 * Replace the existing newsletter_archive shortcode in WPCode with this version
 * This displays newsletters that you manually add to the code
 * 
 * To add to WPCode:
 * 1. Go to Snippets → + Add Snippet
 * 2. Title: "Newsletter Archive - Manual Version"
 * 3. Code Type: PHP Snippet
 * 4. Paste this entire code
 * 5. Location: Run Everywhere
 * 6. Activate
 * 
 * To update when you send a newsletter:
 * 1. Edit this snippet in WPCode
 * 2. Add new entry at the TOP of the $newsletters array
 * 3. Copy an existing entry and update the title, date, and URL
 */

function display_newsletter_archive_manual() {
    // YOUR NEWSLETTER ARCHIVE
    // Add newest newsletters at the TOP of this array
    $newsletters = array(
        array(
            'title' => 'September 2025 Newsletter',
            'date' => 'September 26, 2025',
            'url' => 'https://mailchi.mp/lexingtonalarm/burlington-to-vote-on-ice-facility-oct-18th-work-meeting-is-monday-9-29'
        ),
        // Add more newsletters below this line
        // Copy this format for each newsletter:
        // array(
        //     'title' => 'Month Year Newsletter',
        //     'date' => 'Month Day, Year',
        //     'url' => 'YOUR_MAILCHIMP_URL_HERE'
        // ),
        
        // Example entries - DELETE these when you add real ones
        array(
            'title' => 'August 2025 Newsletter',
            'date' => 'August 15, 2025',
            'url' => '#'
        ),
        array(
            'title' => 'July 2025 Newsletter',
            'date' => 'July 4, 2025',
            'url' => '#'
        ),
    );
    
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
            foreach ($newsletters as $newsletter) : 
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
    </div>
    
    <style>
    /* Newsletter Archive Styling - Matches Newsletter */
    .newsletter-archive-wrapper {
        max-width: 660px;
        margin: 40px auto;
        padding: 0 24px;
    }
    
    /* Red Header Box (same as current newsletter) */
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
        color: #a33335; /* Newsletter link color */
        text-decoration: underline;
        font-family: 'Work Sans', sans-serif;
        font-size: 16px;
        font-weight: bold;
        transition: color 0.2s ease;
    }
    
    .archive-link:hover {
        color: #8a2a2e;
    }
    
    /* Archive Divider (matches newsletter black dividers) */
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
add_shortcode('newsletter_archive', 'display_newsletter_archive_manual');
?>
