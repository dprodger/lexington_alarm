<?php
/**
 * SIMPLIFIED Export Page HTML Button
 * 
 * This version is easier to debug and should work more reliably.
 * If this doesn't work, we'll know there's a deeper issue.
 */

// Add Export button to admin bar
function la_export_html_button($wp_admin_bar) {
    global $pagenow;
    
    // Only show on post.php (edit screen)
    if ($pagenow !== 'post.php') {
        return;
    }
    
    // Add the button
    $wp_admin_bar->add_node(array(
        'id'    => 'export-page-html',
        'title' => 'Export HTML',
        'href'  => '#',
        'meta'  => array(
            'onclick' => 'exportPageHTML(); return false;'
        )
    ));
}
add_action('admin_bar_menu', 'la_export_html_button', 999);

// Add the export JavaScript
function la_export_html_script() {
    global $pagenow;
    
    if ($pagenow !== 'post.php') {
        return;
    }
    ?>
    <script>
    function exportPageHTML() {
        console.log('Export button clicked!');
        
        if (typeof wp === 'undefined' || !wp.data) {
            alert('WordPress editor not ready. Please try again.');
            return;
        }
        
        try {
            const content = wp.data.select('core/editor').getEditedPostContent();
            const title = wp.data.select('core/editor').getEditedPostAttribute('title');
            
            console.log('Got content, length:', content.length);
            console.log('Page title:', title);
            
            const filename = (title || 'page')
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-|-$/g, '') + '.html';
            
            const blob = new Blob([content], { type: 'text/html' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
            
            alert('Downloaded: ' + filename);
        } catch(error) {
            console.error('Export error:', error);
            alert('Error exporting: ' + error.message);
        }
    }
    
    // Debug: Log that script loaded
    console.log('Export HTML script loaded');
    </script>
    <?php
}
add_action('admin_footer', 'la_export_html_script');
