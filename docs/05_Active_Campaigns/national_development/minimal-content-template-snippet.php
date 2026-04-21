<?php
/**
 * Minimal Content Page Template
 * 
 * Registers a page template via Code Snippets that keeps site header/footer
 * but resets content styling for pages with custom HTML.
 * 
 * Use for campaign letter pages, standalone action pages, etc.
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register the page template
 */
add_filter('theme_page_templates', function($templates) {
    $templates['minimal-content-template'] = 'Minimal Content (No Theme Styles)';
    return $templates;
});

/**
 * Load the template when selected
 */
add_filter('template_include', function($template) {
    global $post;
    
    if ($post && get_page_template_slug($post->ID) === 'minimal-content-template') {
        // Start output buffering to capture and modify
        add_action('wp_head', 'minimal_content_reset_styles', 999);
        add_filter('the_content', 'minimal_content_wrap_content', 999);
    }
    
    return $template;
});

/**
 * Add CSS reset for content area
 */
function minimal_content_reset_styles() {
    ?>
    <style id="minimal-content-reset">
        /* Reset Kadence/theme content styles for minimal template */
        .minimal-content-wrapper {
            all: initial;
            display: block;
            width: 100%;
            max-width: 100%;
            margin: 0;
            padding: 0;
        }
        
        .minimal-content-wrapper *,
        .minimal-content-wrapper *::before,
        .minimal-content-wrapper *::after {
            all: revert;
            box-sizing: border-box;
        }
        
        /* Reset inherited Kadence typography */
        .minimal-content-wrapper h1,
        .minimal-content-wrapper h2,
        .minimal-content-wrapper h3,
        .minimal-content-wrapper h4,
        .minimal-content-wrapper h5,
        .minimal-content-wrapper h6 {
            font-family: inherit;
            text-transform: none;
            letter-spacing: normal;
            color: inherit;
        }
        
        .minimal-content-wrapper p,
        .minimal-content-wrapper li,
        .minimal-content-wrapper span,
        .minimal-content-wrapper div,
        .minimal-content-wrapper button {
            font-family: inherit;
        }
        
        /* Remove Kadence content wrapper padding/margins */
        .entry-content-wrap .minimal-content-wrapper,
        .content-wrap .minimal-content-wrapper {
            padding: 0;
            margin: 0;
            max-width: none;
        }
    </style>
    <?php
}

/**
 * Wrap content in reset div
 */
function minimal_content_wrap_content($content) {
    return '<div class="minimal-content-wrapper">' . $content . '</div>';
}
