<?php
/**
 * NATIONAL DEVELOPMENT LETTER PAGE TEMPLATE - CODE SNIPPETS VERSION
 * 
 * Based on: Massport Campaign Template (snippet #1397)
 * 
 * Installation Instructions:
 * 1. Go to: WPCode → Add New Snippet
 * 2. Title: "National Development Letter Template"
 * 3. Code Type: PHP Snippet
 * 4. Copy and paste this ENTIRE code
 * 5. Location: Run Everywhere
 * 6. Click Save Changes and Activate
 * 7. Edit the "Letter to National Development" page
 * 8. In Page Attributes, select "National Development Letter" template
 */

// Register custom page template
add_filter('theme_page_templates', 'nd_letter_add_page_template');
function nd_letter_add_page_template($templates) {
    $templates['nd-letter-template'] = 'National Development Letter';
    return $templates;
}

// Load custom template
add_filter('template_include', 'nd_letter_load_template');
function nd_letter_load_template($template) {
    if (is_page()) {
        $page_template = get_post_meta(get_the_ID(), '_wp_page_template', true);
        if ($page_template == 'nd-letter-template') {
            return nd_letter_render_template();
        }
    }
    return $template;
}

// Render the template
function nd_letter_render_template() {
    // Use theme's header (includes navigation) - SAME AS MASSPORT TEMPLATE
    get_header();
    ?>
    
<style>
/* ============================================== */
/* NATIONAL DEVELOPMENT LETTER CUSTOM STYLES */
/* Scoped to not conflict with theme */
/* ============================================== */

/* Campaign page container - FULL WIDTH RESPONSIVE WITH PADDING */
.nd-action-page {
    max-width: 800px;
    width: 100%;
    margin: 0 auto;
    padding: 40px 40px;
}

/* Page header section */
.nd-page-header {
    text-align: center;
    padding: 20px;
    margin-bottom: 20px;
    border-bottom: 3px solid #044f9d;
}

.nd-page-header h1 {
    color: #044f9d;
    font-family: Georgia, serif;
    font-size: 2rem;
    margin: 0 0 15px 0;
    text-transform: none;
}

.nd-page-header p {
    color: #044f9d;
    font-family: Georgia, serif;
    font-size: 1.4rem;
    margin: 0;
    font-weight: 500;
}

/* Instructions box */
.nd-instructions {
    background: #e8f4fc;
    border-left: 4px solid #044f9d;
    padding: 20px 25px;
    margin-bottom: 25px;
}

.nd-instructions h3 {
    color: #044f9d;
    margin: 0 0 15px 0;
    font-size: 1.4rem;
    font-family: Georgia, serif;
}

.nd-instructions ol {
    margin: 0;
    padding-left: 25px;
    font-size: 1.1rem;
}

.nd-instructions li {
    margin-bottom: 8px;
}

/* Print button */
.nd-action-buttons {
    text-align: center;
    margin-bottom: 25px;
}

.nd-btn {
    display: inline-block;
    padding: 15px 40px;
    font-size: 1.3rem;
    font-weight: bold;
    background: #044f9d;
    color: white !important;
    border: 2px solid #044f9d;
    cursor: pointer;
    text-decoration: none;
}

.nd-btn:hover {
    background: #033d7a;
    border-color: #033d7a;
    color: white !important;
}

/* Letter container */
.nd-letter-container {
    background: white;
    padding: 50px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    border: 1px solid #ddd;
    font-family: Georgia, serif;
    font-size: 12pt;
    line-height: 1.5;
    color: #333;
}

/* Letter styles */
.nd-address-block {
    margin-bottom: 24px;
}

.nd-address-block p {
    margin: 0;
    line-height: 1.3;
}

.nd-subject {
    margin: 24px 0;
    font-weight: bold;
}

.nd-salutation {
    margin-bottom: 24px;
}

.nd-body-text p {
    margin-bottom: 12px;
    text-align: justify;
}

.nd-body-text ul {
    margin: 12px 0 12px 20px;
}

.nd-body-text li {
    margin-bottom: 8px;
}

.nd-closing {
    margin-top: 24px;
}

.nd-signature {
    margin-top: 48px;
    border-top: 1px solid #000;
    width: 200px;
    padding-top: 4px;
}

/* Hide theme footer - we use custom footer */
.site-footer,
#colophon {
    display: none !important;
}

/* Print Styles */
@media print {
    /* Hide site header, nav, and our page header/buttons */
    .site-header,
    #masthead,
    header,
    .nd-page-header,
    .nd-instructions,
    .nd-action-buttons,
    .nd-custom-footer {
        display: none !important;
    }
    
    .nd-action-page {
        max-width: none;
        padding: 0;
    }
    
    .nd-letter-container {
        box-shadow: none;
        border: none;
        padding: 0;
        margin: 1in;
    }
}

/* Responsive */
@media (max-width: 768px) {
    .nd-action-page {
        padding: 20px 15px;
    }
    
    .nd-letter-container {
        padding: 25px;
    }
    
    .nd-page-header h1 {
        font-size: 1.5rem;
    }
}
</style>

<div class="nd-action-page">
    
    <div class="nd-page-header">
        <h1>Take Action: Letter to National Development</h1>
        <p>Stand Against Selective Enforcement Targeting Peaceful Protesters</p>
    </div>
    
    <div class="nd-instructions">
        <h3>How to Send This Letter</h3>
        <ol>
            <li>Click "Print Letter" to print or save as PDF</li>
            <li>Sign your name at the bottom</li>
            <li>Mail to the address shown, or email to National Development</li>
        </ol>
    </div>
    
    <div class="nd-action-buttons">
        <button class="nd-btn" onclick="window.print()">Print Letter</button>
    </div>
    
    <div class="nd-letter-container">
        <div class="nd-letter">
            <div class="nd-address-block">
                <p>Charlie Rollins</p>
                <p>Principal and Chief Operating Officer</p>
                <p>National Development</p>
                <p>2310 Washington Street, Suite 200</p>
                <p>Newton Lower Falls, MA 02462</p>
            </div>
            
            <div class="nd-subject">RE: Selective Parking Enforcement and Community Impact at District Ave</div>
            
            <div class="nd-salutation">Dear Mr. Rollins,</div>
            
            <div class="nd-body-text">
                <p>We are writing to you today as members of the Greater Boston community to express our deep concern regarding the recent shift in parking enforcement policies at The District Burlington.</p>
                
                <p>National Development has long marketed itself as a firm that prioritizes "Social Impact" and "Community Partnership." Your official corporate responsibility materials highlight a commitment to building "socially connected" neighborhoods and fostering "diversity, equity, and inclusion." Furthermore, the late Tom Alperin's legacy of supporting organizations like Project Bread and Heading Home has solidified the firm's reputation as a civic leader in Massachusetts.</p>
                
                <p>However, the recent decision to begin towing vehicles belonging to peaceful protesters at District Ave represents a stark departure from these values. These protests, led by groups such as Bearing Witness @ ICE and Justice 4 All Thursdays, are comprised of the very faith leaders, nonprofit organizers, and community members that National Development claims to partner with.</p>
                
                <p>By allowing selective enforcement against those standing in opposition to the conditions at the ICE Field Office, while allowing ICE vehicles (not one of your tenants) to park on your property, National Development is effectively choosing a side in a humanitarian crisis. This action puts at risk the firm's standing with its many institutional and community partners, including:</p>
                
                <ul>
                    <li>The nearly 60 local nonprofits your firm supports, many of whom serve the immigrant populations directly impacted by ICE activities.</li>
                    <li>Local faith leaders from Burlington and Lexington who have participated in these vigils for years without incident.</li>
                    <li>Civic organizations like the League of Women Voters, who have recently joined these demonstrations to protect due process.</li>
                </ul>
                
                <p>The "abysmal" and "deplorable" conditions reported inside the 1000 District Ave facility are a matter of public record and local concern. We urge you to restore the previous status quo of allowing peaceful assembly and to cease the towing of vehicles in lots that have historically been available to the public.</p>
                
                <p>National Development has the power to facilitate civic engagement rather than suppress it. We look forward to seeing the firm return to its stated mission of strengthening the communities it calls home.</p>
            </div>
            
            <div class="nd-closing">Sincerely,</div>
            
            <div class="nd-signature">Your Name</div>
        </div>
    </div>
    
</div>

<!-- Custom Footer - Same style as Massport/RI campaigns -->
<div class="nd-custom-footer" style="background-color: #044f9d; width: 100%; padding: 30px 0; text-align: center; margin-top: 40px;">
    
    <!-- Copyright -->
    <div style="color: white; font-size: 16px; font-weight: bold; margin-bottom: 15px;">
        © LEXINGTON ALARM! 2025
    </div>
    
    <!-- Divider -->
    <div style="width: 100%; max-width: 300px; height: 1px; background-color: rgba(255,255,255,0.3); margin: 15px auto;"></div>
    
    <!-- Navigation Links -->
    <div style="color: white; font-size: 16px;">
        <a href="/about" style="color: white; text-decoration: none; padding: 0 10px; font-weight: bold;">ABOUT</a> | 
        <a href="/get-involved" style="color: white; text-decoration: none; padding: 0 10px; font-weight: bold;">GET INVOLVED</a> | 
        <a href="/events" style="color: white; text-decoration: none; padding: 0 10px; font-weight: bold;">EVENTS</a>
    </div>
    
</div>

<?php 
    wp_footer();
    ?>
    </body>
    </html>
    <?php
    exit;
}
