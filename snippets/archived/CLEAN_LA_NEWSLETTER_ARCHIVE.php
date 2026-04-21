<?php
/**
 * Lexington Alarm Newsletter Archive
 * Clean version - no conflicts
 * Shortcode: [la_newsletter_archive]
 */

function la_newsletter_archive() {
    
    // ADD YOUR NEWSLETTERS HERE - NEWEST AT TOP
    $newsletters = array(
        
        'ICE Grabs Lexington Landscape Worker Aug 28th' => 'https://us17.campaign-archive.com/?u=3a64af74077cb1e5e461c36af&id=740436db51',
        
        // Add more newsletters below using this format:
        // 'Newsletter Title' => 'https://your-url-here',
        
    );
    
    if (empty($newsletters)) {
        return '<p>Newsletter archive coming soon.</p>';
    }
    
    ob_start();
    ?>
    <div class="newsletter-archive-wrapper">
        <div class="newsletter-red-header">
            <h2>NEWSLETTER ARCHIVE</h2>
        </div>
        
        <div class="archive-list">
            <?php 
            $first = true;
            foreach ($newsletters as $title => $url) :
                if (empty(trim($url))) continue;
            ?>
                <?php if (!$first) : ?>
                    <div class="archive-divider"></div>
                <?php endif; ?>
                
                <div class="archive-entry">
                    <div class="archive-icon">📧</div>
                    <div class="archive-content">
                        <h4 class="archive-title"><?php echo esc_html($title); ?></h4>
                        <a href="<?php echo esc_url($url); ?>" target="_blank" class="archive-link">
                            View in Browser →
                        </a>
                    </div>
                </div>
                
                <?php $first = false; ?>
            <?php endforeach; ?>
        </div>
    </div>
    
    <style>
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
        margin: 0 0 10px 0;
        line-height: 1.4;
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
add_shortcode('la_newsletter_archive', 'la_newsletter_archive');
?>
