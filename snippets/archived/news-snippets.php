<?php
/**
 * WPCode Snippet: Display Featured News Story
 * Add this to WPCode → Add Snippet → Custom Snippet
 * Use shortcode: [featured_news_story]
 */

function display_featured_news_story() {
    // Get the most recent post from "Featured Story" category
    $args = array(
        'category_name' => 'featured-story', // Change to your category slug
        'posts_per_page' => 1,
        'post_status' => 'publish'
    );
    
    $featured = new WP_Query($args);
    
    if ($featured->have_posts()) {
        ob_start();
        while ($featured->have_posts()) {
            $featured->the_post();
            ?>
            <div class="featured-story-block">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="featured-image">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>
                
                <h2 class="featured-title" style="color: #c3202e;">
                    <?php the_title(); ?>
                </h2>
                
                <div class="featured-date">
                    <?php echo get_the_date(); ?>
                </div>
                
                <div class="featured-excerpt">
                    <?php the_excerpt(); ?>
                </div>
                
                <a href="<?php the_permalink(); ?>" class="la-button">
                    Read Full Story →
                </a>
            </div>
            <?php
        }
        wp_reset_postdata();
        return ob_get_clean();
    }
    
    return '<p>No featured story available.</p>';
}

add_shortcode('featured_news_story', 'display_featured_news_story');

/**
 * Shortcode for Newsletter Archive
 * Use: [newsletter_archive]
 */
function display_newsletter_archive() {
    // Get all posts from "Newsletter" category
    $args = array(
        'category_name' => 'newsletter',
        'posts_per_page' => 12,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC'
    );
    
    $newsletters = new WP_Query($args);
    
    if ($newsletters->have_posts()) {
        ob_start();
        ?>
        <div class="newsletter-archive">
            <h2 style="color: #044f9d;">Newsletter Archive</h2>
            <?php
            while ($newsletters->have_posts()) {
                $newsletters->the_post();
                ?>
                <div class="newsletter-entry">
                    <span class="newsletter-date">
                        <?php echo get_the_date('F Y'); ?>
                    </span>
                    <div>
                        <a href="<?php the_permalink(); ?>" class="newsletter-link">
                            📧 <?php the_title(); ?>
                        </a>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
        wp_reset_postdata();
        return ob_get_clean();
    }
    
    return '<p>No newsletters available.</p>';
}

add_shortcode('newsletter_archive', 'display_newsletter_archive');