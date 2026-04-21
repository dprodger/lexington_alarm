<?php
/**
 * WPCode Snippet: Add "Export Page HTML" Button to Page Editor
 * 
 * This adds a button to the WordPress page editor that downloads
 * the page HTML content as a file, making it easy to sync to current_state
 * 
 * Installation:
 * 1. WPCode → Add Snippet → Add Your Custom Code
 * 2. Choose "PHP Snippet"
 * 3. Paste this code
 * 4. Set to "Run Everywhere"
 * 5. Activate
 * 
 * Usage:
 * 1. Edit any page
 * 2. Look for "Export HTML" button in top toolbar
 * 3. Click to download [pagename].html
 * 4. Move file to current_state/pages/
 */

// Add export button to Gutenberg editor toolbar
add_action('enqueue_block_editor_assets', 'la_add_page_export_button');
function la_add_page_export_button() {
    ?>
    <script>
    (function() {
        // Wait for WordPress editor to be ready
        if (typeof wp === 'undefined' || !wp.data) {
            setTimeout(arguments.callee, 100);
            return;
        }

        // Register our custom format button
        wp.domReady(function() {
            // Get the editor
            const { registerPlugin } = wp.plugins;
            const { PluginDocumentSettingPanel } = wp.editPost;
            const { Button } = wp.components;
            const { useSelect } = wp.data;
            const { createElement: el } = wp.element;

            // Create the export button component
            const ExportButton = function() {
                const postContent = useSelect(function(select) {
                    return select('core/editor').getEditedPostContent();
                });
                
                const postTitle = useSelect(function(select) {
                    return select('core/editor').getEditedPostAttribute('title');
                });

                const handleExport = function() {
                    // Get the page content
                    const content = postContent;
                    
                    // Create filename from page title
                    const filename = (postTitle || 'page')
                        .toLowerCase()
                        .replace(/[^a-z0-9]+/g, '-')
                        .replace(/^-|-$/g, '') + '.html';
                    
                    // Create downloadable file
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
                    wp.data.dispatch('core/notices').createSuccessNotice(
                        'Page HTML exported! Move ' + filename + ' to current_state/pages/',
                        { type: 'snackbar', isDismissible: true }
                    );
                };

                return el(
                    Button,
                    {
                        variant: 'primary',
                        onClick: handleExport,
                        style: { marginTop: '10px', width: '100%' }
                    },
                    '📥 Export Page HTML'
                );
            };

            // Register as a document settings panel
            const ExportPanel = function() {
                return el(
                    PluginDocumentSettingPanel,
                    {
                        name: 'page-export-panel',
                        title: 'Export to Current State',
                        icon: 'download'
                    },
                    el(ExportButton)
                );
            };

            // Register the plugin
            registerPlugin('la-page-export', {
                render: ExportPanel
            });
        });
    })();
    </script>
    <?php
}

// Alternative: Add admin bar link for quick export
add_action('admin_bar_menu', 'la_add_export_admin_bar_link', 100);
function la_add_export_admin_bar_link($wp_admin_bar) {
    // Only show on page edit screens
    if (!is_admin() || !function_exists('get_current_screen')) {
        return;
    }
    
    $screen = get_current_screen();
    if (!$screen || $screen->base !== 'post' || $screen->post_type !== 'page') {
        return;
    }
    
    $wp_admin_bar->add_node(array(
        'id' => 'la-export-page',
        'title' => '📥 Export HTML',
        'href' => '#',
        'meta' => array(
            'onclick' => 'laExportPageHTML(); return false;'
        )
    ));
}

// Add JavaScript for admin bar button
add_action('admin_footer', 'la_export_page_javascript');
function la_export_page_javascript() {
    $screen = get_current_screen();
    if (!$screen || $screen->base !== 'post' || $screen->post_type !== 'page') {
        return;
    }
    
    ?>
    <script>
    function laExportPageHTML() {
        // Get content from Gutenberg editor
        if (typeof wp !== 'undefined' && wp.data) {
            const content = wp.data.select('core/editor').getEditedPostContent();
            const title = wp.data.select('core/editor').getEditedPostAttribute('title');
            
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
            
            alert('Page HTML exported as: ' + filename + '\n\nMove this file to:\ncurrent_state/pages/');
        }
    }
    </script>
    <?php
}
