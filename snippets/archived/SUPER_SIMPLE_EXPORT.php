<?php
/**
 * SUPER SIMPLE Export Page HTML
 * 
 * Adds an "Export Page" option in the editor's ⋮ menu (three dots, top right)
 * 
 * Installation:
 * 1. WPCode → Edit your snippet or create new
 * 2. Paste this code
 * 3. Set to "Run Everywhere"
 * 4. Save
 * 
 * Usage:
 * 1. Edit any page
 * 2. Click the ⋮ menu (top right, three vertical dots)
 * 3. Look for "Export Page" option
 * 4. Click it to download HTML
 */

add_action('admin_head', 'la_simple_export_script');
function la_simple_export_script() {
    global $pagenow;
    if ($pagenow !== 'post.php') return;
    ?>
    <script>
    // Wait for WordPress editor to load
    window.addEventListener('load', function() {
        setTimeout(function() {
            if (typeof wp === 'undefined' || !wp.data) {
                console.log('WordPress editor not available');
                return;
            }
            
            console.log('✅ Export script loaded!');
            
            // Create export function
            window.laExportPage = function() {
                try {
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
                    
                    alert('✅ Downloaded: ' + filename + '\n\nMove to: current_state/pages/');
                } catch(e) {
                    alert('Error: ' + e.message);
                }
            };
            
            // Add button to page
            const addButton = function() {
                // Check if button already exists
                if (document.getElementById('la-export-btn')) return;
                
                // Find a place to add the button
                const toolbar = document.querySelector('.edit-post-header__settings');
                if (!toolbar) {
                    setTimeout(addButton, 500);
                    return;
                }
                
                // Create button
                const btn = document.createElement('button');
                btn.id = 'la-export-btn';
                btn.className = 'components-button has-icon';
                btn.innerHTML = '📥 Export';
                btn.style.marginRight = '8px';
                btn.title = 'Export page HTML';
                btn.onclick = function(e) {
                    e.preventDefault();
                    window.laExportPage();
                    return false;
                };
                
                // Insert button
                toolbar.insertBefore(btn, toolbar.firstChild);
                console.log('✅ Export button added to toolbar');
            };
            
            addButton();
        }, 2000);
    });
    </script>
    <style>
    #la-export-btn {
        background: #2271b1 !important;
        color: white !important;
        padding: 6px 12px !important;
        border-radius: 2px !important;
        border: none !important;
        cursor: pointer !important;
        font-size: 13px !important;
    }
    #la-export-btn:hover {
        background: #135e96 !important;
    }
    </style>
    <?php
}
