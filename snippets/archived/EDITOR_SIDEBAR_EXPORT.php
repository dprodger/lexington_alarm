<?php
/**
 * Export Page HTML - Button in Editor Sidebar
 * 
 * This adds the export button directly in the page editor sidebar
 * which is more reliable than the admin bar.
 * 
 * Installation:
 * 1. Replace your current snippet with this code
 * 2. Make sure it's set to "Run Everywhere"
 * 3. Save and refresh your page editor
 * 
 * Usage:
 * Look in the right sidebar of the page editor for "Export Page" button
 */

// Add button to Gutenberg editor
add_action('enqueue_block_editor_assets', 'la_add_export_button_to_editor');
function la_add_export_button_to_editor() {
    ?>
    <script>
    (function() {
        // Wait for WordPress to be ready
        const checkReady = setInterval(function() {
            if (typeof wp !== 'undefined' && wp.plugins && wp.editPost && wp.element && wp.components) {
                clearInterval(checkReady);
                initExportButton();
            }
        }, 100);
        
        function initExportButton() {
            const { registerPlugin } = wp.plugins;
            const { PluginSidebar, PluginSidebarMoreMenuItem } = wp.editPost;
            const { Button, PanelBody } = wp.components;
            const { createElement } = wp.element;
            const { useSelect } = wp.data;
            
            const ExportPanel = function() {
                const { content, title } = useSelect(function(select) {
                    return {
                        content: select('core/editor').getEditedPostContent(),
                        title: select('core/editor').getEditedPostAttribute('title')
                    };
                });
                
                const handleExport = function() {
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
                    
                    alert('✅ Downloaded: ' + filename + '\n\nMove to: current_state/pages/');
                };
                
                return createElement(
                    PluginSidebar,
                    {
                        name: 'export-page-sidebar',
                        title: 'Export Page',
                        icon: 'download'
                    },
                    createElement(
                        PanelBody,
                        null,
                        createElement('p', null, 'Export this page as HTML for current_state sync.'),
                        createElement(
                            Button,
                            {
                                variant: 'primary',
                                onClick: handleExport,
                                style: { width: '100%', justifyContent: 'center' }
                            },
                            '📥 Download HTML'
                        )
                    )
                );
            };
            
            const ExportMenuItem = function() {
                return createElement(
                    PluginSidebarMoreMenuItem,
                    {
                        target: 'export-page-sidebar',
                        icon: 'download'
                    },
                    'Export Page'
                );
            };
            
            const ExportPlugin = function() {
                return createElement(
                    wp.element.Fragment,
                    null,
                    createElement(ExportMenuItem),
                    createElement(ExportPanel)
                );
            };
            
            registerPlugin('lexington-alarm-export', {
                render: ExportPlugin
            });
            
            console.log('✅ Export button loaded - look for "Export Page" in ⋮ menu');
        }
    })();
    </script>
    <style>
    /* Make the button more visible */
    .components-panel__body .components-button.is-primary {
        padding: 12px !important;
    }
    </style>
    <?php
}
