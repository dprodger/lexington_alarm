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
        add_action('wp_head', 'minimal_content_reset_styles', 999);
        add_filter('the_content', 'minimal_content_wrap_content', 999);
    }
    
    return $template;
});

/**
 * Add CSS reset and National Development letter styles
 */
function minimal_content_reset_styles() {
    ?>
    <style id="minimal-content-reset">
        /* Reset Kadence content styles */
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
        
        /* National Development Letter Styles */
        .nd-letter-wrapper {
            font-family: 'Georgia', serif !important;
            line-height: 1.6 !important;
            max-width: 800px !important;
            margin: 0 auto !important;
            padding: 20px !important;
            background: #f5f5f5 !important;
            color: #333 !important;
        }

        .nd-letter-wrapper .page-header {
            text-align: center !important;
            padding: 20px !important;
            margin-bottom: 20px !important;
            border-bottom: 3px solid #044f9d !important;
        }

        .nd-letter-wrapper .page-header h1 {
            color: #044f9d !important;
            font-family: 'Georgia', serif !important;
            font-size: 2rem !important;
            margin: 0 0 15px 0 !important;
            text-transform: none !important;
        }

        .nd-letter-wrapper .page-header p {
            color: #044f9d !important;
            font-family: 'Georgia', serif !important;
            font-size: 1.4rem !important;
            margin: 0 !important;
            font-weight: 500 !important;
        }

        .nd-letter-wrapper .instructions {
            background: #e8f4fc !important;
            border-left: 4px solid #044f9d !important;
            padding: 20px 25px !important;
            margin-bottom: 25px !important;
        }

        .nd-letter-wrapper .instructions h3 {
            color: #044f9d !important;
            font-family: 'Georgia', serif !important;
            margin: 0 0 15px 0 !important;
            font-size: 1.6rem !important;
            text-transform: none !important;
        }

        .nd-letter-wrapper .instructions ol {
            margin: 0 !important;
            padding-left: 25px !important;
            font-size: 1.1rem !important;
        }

        .nd-letter-wrapper .instructions li {
            margin-bottom: 8px !important;
            font-family: 'Georgia', serif !important;
            color: #333 !important;
        }

        .nd-letter-wrapper .action-buttons {
            text-align: center !important;
            margin-bottom: 25px !important;
        }

        .nd-letter-wrapper .btn {
            display: inline-block !important;
            padding: 15px 40px !important;
            font-size: 1.3rem !important;
            font-weight: bold !important;
            text-decoration: none !important;
            border: 2px solid #044f9d !important;
            cursor: pointer !important;
            background: #044f9d !important;
            color: #ffffff !important;
        }

        .nd-letter-wrapper .btn:hover {
            background: #033d7a !important;
            border-color: #033d7a !important;
        }

        .nd-letter-wrapper .letter-container {
            background: white !important;
            padding: 50px !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1) !important;
            border: 1px solid #ddd !important;
        }

        .nd-letter-wrapper .letter-recipient p {
            margin: 0 !important;
            line-height: 1.3 !important;
            font-family: 'Georgia', serif !important;
            font-size: 1rem !important;
            color: #333 !important;
        }

        .nd-letter-wrapper .letter-subject {
            margin: 25px 0 !important;
            font-weight: bold !important;
            font-family: 'Georgia', serif !important;
        }

        .nd-letter-wrapper .letter-salutation {
            margin-bottom: 25px !important;
            font-family: 'Georgia', serif !important;
        }

        .nd-letter-wrapper .letter-body p {
            margin-bottom: 15px !important;
            text-align: justify !important;
            font-family: 'Georgia', serif !important;
            font-size: 1rem !important;
            line-height: 1.6 !important;
        }

        .nd-letter-wrapper .letter-body ul {
            margin: 15px 0 15px 20px !important;
            padding-left: 20px !important;
        }

        .nd-letter-wrapper .letter-body li {
            margin-bottom: 10px !important;
            font-family: 'Georgia', serif !important;
            font-size: 1rem !important;
            line-height: 1.6 !important;
        }

        .nd-letter-wrapper .letter-closing p {
            font-family: 'Georgia', serif !important;
        }

        .nd-letter-wrapper .signature-line {
            margin-top: 50px !important;
            border-top: 1px solid #333 !important;
            width: 250px !important;
            padding-top: 5px !important;
            font-family: 'Georgia', serif !important;
        }

        /* Print Styles */
        @media print {
            .nd-letter-wrapper {
                background: white !important;
                padding: 0 !important;
                max-width: none !important;
            }
            
            .nd-letter-wrapper .page-header,
            .nd-letter-wrapper .action-buttons,
            .nd-letter-wrapper .instructions {
                display: none !important;
            }
            
            .nd-letter-wrapper .letter-container {
                box-shadow: none !important;
                border: none !important;
                padding: 40px !important;
            }
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
