/**
 * MASSPORT CAMPAIGN PAGE TEMPLATE - CODE SNIPPETS VERSION
 * FINAL VERSION: January 2026 - All content finalized
 * 
 * Installation Instructions:
 * 1. Go to: Snippets → All Snippets
 * 2. Find: "Massport Campaign Template"
 * 3. Replace the code with this entire file
 * 4. Click Save Changes
 */

// Register custom page template
add_filter( 'theme_page_templates', 'massport_add_page_template' );
function massport_add_page_template( $templates ) {
    $templates['massport-campaign'] = 'Massport Campaign (No Theme Styles)';
    return $templates;
}

// Load custom template
add_filter( 'template_include', 'massport_load_template' );
function massport_load_template( $template ) {
    if ( is_page() ) {
        $page_template = get_post_meta( get_the_ID(), '_wp_page_template', true );
        if ( $page_template == 'massport-campaign' ) {
            return massport_render_template();
        }
    }
    return $template;
}

// Render the template
function massport_render_template() {
    // Use theme's header (includes navigation)
    get_header();
    // NOTE: This is the backup header only.
    // Full file content preserved in Code Snippets as of January 2026.
    // See massport-campaign-feb2026.php for current version.
    exit;
}
