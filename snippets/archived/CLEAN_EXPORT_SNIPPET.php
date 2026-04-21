<?php
/**
 * Add "Export Page HTML" button to WordPress page editor
 * 
 * Installation:
 * 1. Go to WPCode → Add Snippet → Add Your Custom Code
 * 2. Choose "PHP Snippet"
 * 3. Paste this entire code
 * 4. Name it: "Export Page HTML"
 * 5. Set to "Run Everywhere"
 * 6. Activate
 * 
 * Usage:
 * When editing any page, you'll see "Export HTML" in the admin bar at top.
 * Click it to download the page HTML instantly.
 */

// Add "Export HTML" link to admin bar when editing pages
add_action('admin_bar_menu', 'la_add_export_link_to_admin_bar', 100);
function la_add_export_link_to_admin_bar($wp_admin_bar) {
    // Only show on page edit screens
    if (!is_admin()) {
        return;
    }
    
    $screen = get_current_screen();
    if (!$screen || $screen->base !== 'post' || $screen->post_type !== 'page') {
        return;
    }
    
    $wp_admin_bar->add_node(array(
        'id' => 'la-export-page-html',
        'title' => '📥 Export HTML',
        'href' => '#',
        'meta' => array(
            'onclick' => 'laExportPageHTML(); return false;',
            'title' => 'Download page HTML for current_state sync'
        )
    ));
}

// Add the JavaScript to handle the export
add_action('admin_footer', 'la_export_page_javascript');
function la_export_page_javascript() {
    $screen = get_current_screen();
    if (!$screen || $screen->base !== 'post' || $screen->post_type !== 'page') {
        return;
    }
    ?>
    <script>
    function laExportPageHTML() {
        // Check if Gutenberg editor is loaded
        if (typeof wp !== 'undefined' && wp.data) {
            // Get content from Gutenberg
            const content = wp.data.select('core/editor').getEditedPostContent();
            const title = wp.data.select('core/editor').getEditedPostAttribute('title');
            
            // Create filename from page title
            const filename = (title || 'page')
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-|-$/g, '') + '.html';
            
            // Create and download file
            const blob = new Blob([content], { type: 'text/html' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
            
            // Show success message
            alert('✅ Downloaded: ' + filename + '\n\nMove this file to:\ncurrent_state/pages/\n\nThen run: ./sync-wordpress-state.sh');
        } else {
            alert('⚠️ Please use this on a page editor screen');
        }
    }
    </script>
    <?php
}
