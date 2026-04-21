/**
 * RHODE ISLAND CAMPAIGN PAGE TEMPLATE - CODE SNIPPETS VERSION
 * 
 * COPIED FROM: Massport Campaign Template
 * MODIFIED FOR: Rhode Island Campaign
 * 
 * Installation Instructions:
 * 1. Go to: Snippets → Add New
 * 2. Title: "Rhode Island Campaign Template"
 * 3. Copy and paste this ENTIRE code
 * 4. Set to: Run Everywhere (or "Site Front-End")
 * 5. Click Save Changes and Activate
 * 6. Create a new page and select "Rhode Island Campaign" template
 * 
 * TEST MODE: Change $TEST_MODE below to switch between testing and production
 */

// ============================================
// TEST MODE CONFIGURATION
// ============================================
global $RI_TEST_MODE;
$RI_TEST_MODE = true;  // SET TO false WHEN READY TO LAUNCH
// ============================================

// Register custom page template
add_filter( 'theme_page_templates', 'rhode_island_add_page_template' );
function rhode_island_add_page_template( $templates ) {
    $templates['rhode-island-campaign'] = 'Rhode Island Campaign (No Theme Styles)';
    return $templates;
}

// Load custom template
add_filter( 'template_include', 'rhode_island_load_template' );
function rhode_island_load_template( $template ) {
    if ( is_page() ) {
        $page_template = get_post_meta( get_the_ID(), '_wp_page_template', true );
        if ( $page_template == 'rhode-island-campaign' ) {
            return rhode_island_render_template();
        }
    }
    return $template;
}

// Render the template
function rhode_island_render_template() {
    global $RI_TEST_MODE;  // Access the test mode variable
    ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title(); ?> | <?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
    
   <style>
    /* Reset WordPress and theme styles for this page */
    body.page-template-rhode-island-campaign *:not(.ri-action-page) {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    }

    body.page-template-rhode-island-campaign {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    line-height: 1.6;
    color: #333;
    background: #fff;
    min-height: 100vh;
    padding: 0;
    margin: 0;
}

    /* Hide WordPress admin bar spacing */
    body.page-template-rhode-island-campaign {
        margin-top: 0 !important;
    }

    /* Campaign page container - FULL WIDTH RESPONSIVE WITH PADDING */
    .ri-action-page {
        max-width: 1200px;
        width: 100%;
        margin: 0 auto;
        padding: 40px 40px;
    }
/* ADD THE NEW CSS HERE */
/* Force consistent font for full letter text */
/* Force consistent font for full letter text */
#fullLetterText, #fullLetterText * {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif !important;
    font-size: 18px !important;
    line-height: 1.6 !important;
    color: #333 !important;
}

#fullLetterText ul {
    margin: 15px 0 !important;
    padding-left: 25px !important;
}

#fullLetterText li {
    margin-bottom: 5px !important; /* Reduced from 20px since <br><br> handles spacing */
    list-style-type: disc !important;
    padding-bottom: 0 !important; /* Remove extra padding */
}

    /* Header with LEXINGTON ALARM BLUE */
    .action-header {
        background: #044f9d;    /* Lexington Alarm Blue */
        color: white;
        padding: 40px 30px;
        text-align: center;
        border-radius: 8px;
        margin-bottom: 30px;
    }

    /* Headings - SANS SERIF & LARGER */
    .action-header h1 {
        margin: 0 0 10px 0;
        font-size: 34px;
        font-family: sans-serif;
        color: white;
        font-weight: bold;
        line-height: 1.2;
    }

    .action-header p {
        margin: 0;
        font-size: 18px;
        opacity: 0.9;
        color: white;
        line-height: 1.4;
    }

    .action-section {
        background: #f8f9fa;
        border: 2px solid #dee2e6;
        border-radius: 8px;
        padding: 25px;
        margin-bottom: 25px;
    }

    /* Section headings - LEXINGTON BLUE & SANS SERIF & LARGER */
    .action-section h2 {
        margin-top: 0;
        color: #044f9d;         /* Lexington Alarm Blue */
        font-size: 28px;
        font-family: sans-serif;
        font-weight: bold;
        line-height: 1.3;
        margin-bottom: 15px;
    }

    /* h3 - SANS SERIF & LARGER */
    .action-section h3 {
        color: #333;
        font-size: 22px;
        font-family: sans-serif;
        margin-top: 20px;
        margin-bottom: 10px;
        font-weight: bold;
        line-height: 1.3;
    }

    /* Regular text - LARGER SIZE */
    .action-section p {
        color: #333;
        font-size: 18px;
        line-height: 1.6;
        margin-bottom: 15px;
    }

    .action-section ol,
    .action-section ul {
        color: #333;
        font-size: 18px;
        line-height: 1.6;
        margin-bottom: 15px;
        padding-left: 25px;
    }

    .action-section li {
        margin-bottom: 8px;
    }

    /* Button group - CENTERED */
    .button-group {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin: 20px 0;
        justify-content: center;
    }

    /* Action buttons - LEXINGTON BLUE, LARGER & MORE PROMINENT */
    .action-button {
        display: inline-block;
        background: #044f9d;    /* Lexington Alarm Blue */
        color: white !important;
        padding: 18px 40px;
        text-decoration: none !important;
        border-radius: 5px;
        font-weight: bold;
        font-size: 18px;
        transition: background 0.3s;
        border: none;
        cursor: pointer;
        line-height: 1.2;
        text-align: center;
        min-width: 200px;
    }

    .action-button:hover {
        background: #033d7d;    /* Darker Lexington Blue */
        text-decoration: none !important;
        color: white !important;
    }

    .action-button:visited {
        color: white !important;
    }

    .action-button.secondary {
        background: #6c757d;
    }

    .action-button.secondary:hover {
        background: #5a6268;
    }

    /* Submit button - LEXINGTON ALARM RED for prominence */
    .action-button.submit,
    button[type="submit"].action-button {
        background: #c3202e;    /* Lexington Alarm Red */
    }

    .action-button.submit:hover,
    button[type="submit"].action-button:hover {
        background: #a01a25;    /* Darker red */
    }

    /* Info boxes - LEXINGTON BLUE */
    .info-box {
        background: #e6f2ff;    /* Light tint of Lexington Blue */
        border-left: 4px solid #044f9d; /* Lexington Alarm Blue */
        padding: 15px;
        margin: 15px 0;
    }

    .info-box p {
        margin: 0;
        color: #333;
        font-size: 18px;
    }

    .info-box strong {
        color: #044f9d;         /* Lexington Alarm Blue */
    }

    .divider {
        text-align: center;
        margin: 30px 0;
        position: relative;
    }

    .divider::before {
        content: "";
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: #dee2e6;
    }

    .divider span {
        background: white;
        padding: 0 15px;
        position: relative;
        color: #6c757d;
        font-weight: bold;
        font-size: 18px;
    }

    .form-field {
        margin-bottom: 20px;
    }

    .form-field label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
        color: #333;
        font-size: 18px;
    }

    .form-field input,
    .form-field textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        font-size: 18px;
        box-sizing: border-box;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    }

    .form-field input:focus,
    .form-field textarea:focus {
        outline: none;
        border-color: #044f9d;  /* Lexington Alarm Blue */
        box-shadow: 0 0 0 3px rgba(4, 79, 157, 0.1);
    }

    .form-field small {
        display: block;
        margin-top: 5px;
        color: #6c757d;
        font-size: 16px;
    }


   /* Letter actions - CENTERED BUTTON CONTAINER */
.letter-actions {
    display: flex;
    justify-content: center;
    gap: 15px;
    flex-wrap: wrap;
    margin: 20px 0;
    background: #e6f2ff;    /* Lexington light blue */
    padding: 20px;
    border-radius: 8px;
}

    /* Letter action buttons - MORE PROMINENT */
    .letter-actions .action-button {
        padding: 18px 35px;
        font-size: 18px;
        min-width: 250px;
        font-weight: bold;
    }

    #fullLetterText {
        background: white;
        padding: 20px;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        font-family: Georgia, serif;
        line-height: 1.8;
        color: #333;
    }

    #fullLetterText p {
        margin-bottom: 15px;
        color: #333;
        font-size: 18px;
    }

    #fullLetterText ul {
        margin: 15px 0;
        padding-left: 25px;
    }

    #fullLetterText li {
        margin-bottom: 10px;
        color: #333;
        font-size: 18px;
    }

    #fullLetterText strong {
        font-weight: bold;
        color: #000;
    }

    .coalition-footer {
        text-align: center;
        padding: 30px;
        color: #6c757d;
        font-size: 16px;
    }

    .coalition-footer p {
        margin-bottom: 10px;
    }

    .coalition-footer a {
        color: #044f9d;         /* Lexington Alarm Blue */
        text-decoration: none;
    }

    .coalition-footer a:hover {
        text-decoration: underline;
    }

    /* ============================================ */
    /* TEST MODE STYLES - ONLY ADDITIONS */
    /* ============================================ */
    
    .test-mode-banner {
        background: #ff6b6b;
        color: white;
        padding: 20px;
        text-align: center;
        font-weight: bold;
        font-size: 18px;
        margin-bottom: 20px;
        border-radius: 8px;
        border: 4px solid #e74c3c;
    }

    .test-mode-banner p {
        margin: 5px 0;
        color: white;
    }

    .test-email-box {
        background: #fff3cd;
        border: 3px solid #ffc107;
        border-radius: 8px;
        padding: 20px;
        margin: 20px 0;
    }

    .test-email-box h3 {
        color: #856404;
        margin-top: 0;
    }

    .test-email-box p {
        color: #333;
    }

    .test-email-box input[type="email"] {
        width: 100%;
        padding: 12px;
        font-size: 18px;
        border: 2px solid #044f9d;
        border-radius: 5px;
        margin: 10px 0;
    }

    /* ============================================ */
    /* END TEST MODE STYLES */
    /* ============================================ */

    /* RESPONSIVE BREAKPOINTS */
    
    /* Tablets (768px and below) */
    @media (max-width: 768px) {
        .ri-action-page {
            padding: 30px 20px;
        }

        .action-header {
            padding: 30px 20px;
        }

        .action-header h1 {
            font-size: 28px;
        }
        
        .action-header p {
            font-size: 17px;
        }

        .action-section {
            padding: 20px;
        }

        .action-section h2 {
            font-size: 24px;
        }

        .action-section h3 {
            font-size: 20px;
        }

        .action-section p,
        .action-section li {
            font-size: 17px;
        }
        
        .button-group {
            flex-direction: column;
        }
        
        .action-button {
            width: 100%;
            min-width: unset;
        }

        .letter-actions {
            flex-direction: column;
        }

        .letter-actions .action-button {
            width: 100%;
            min-width: unset;
        }
    }

    /* Mobile phones (480px and below) */
    @media (max-width: 480px) {
        .ri-action-page {
            padding: 20px 15px;
        }

        .action-header {
            padding: 25px 15px;
        }

        .action-header h1 {
            font-size: 24px;
        }
        
        .action-header p {
            font-size: 16px;
        }

        .action-section {
            padding: 15px;
        }

        .action-section h2 {
            font-size: 22px;
        }

        .action-section h3 {
            font-size: 19px;
        }

        .action-section p,
        .action-section li {
            font-size: 16px;
        }

        .action-button {
            padding: 15px 25px;
            font-size: 17px;
        }

        .info-box {
            padding: 12px;
        }

        #fullLetterText {
            padding: 15px;
            font-size: 16px;
        }

        #fullLetterText p,
        #fullLetterText li {
            font-size: 16px;
        }
    }

    /* Large screens (1200px and above) */
    @media (min-width: 1200px) {
        .ri-action-page {
            max-width: 1400px;
            padding: 50px 60px;
        }

        .action-header {
            padding: 50px 40px;
        }

        .action-header h1 {
            font-size: 38px;
        }

        .action-header p {
            font-size: 20px;
        }
    }

    /* Extra large screens (1600px and above) */
    @media (min-width: 1600px) {
        .ri-action-page {
            max-width: 1600px;
            padding: 60px 80px;
        }
    }
</style>
</head>

<body <?php body_class('page-template-rhode-island-campaign'); ?>>

<?php if ($RI_TEST_MODE): ?>
<!-- TEST MODE BANNER -->
<div class="test-mode-banner">
    <p>⚠️ TEST MODE ACTIVE - NO EMAILS WILL BE SENT TO OFFICIALS ⚠️</p>
    <p>Use your own email address to preview how this will work</p>
</div>
<?php endif; ?>

<div class="ri-action-page">

    <div class="action-header">
        <h1>Rhode Island: Stop Massport from Violating Constitutional Rights</h1>
        <p>Demand protection for Rhode Island and New England residents' due process rights at Hanscom Field</p>
    </div>

    <div class="action-section">
        <h2>Why This Matters</h2>
        <p>Over 1,000 Rhode Island residents have been forcibly removed using ICE charter flights from Hanscom Field. Transfers are a tactic used by ICE to instill terror, destroy due process, and separate Rhode Islanders from their families, lawyers, and local resources, oftentimes including life-saving medications.</p>
        <p><strong>Take action now by choosing one of the options below:</strong></p>
    </div>

    <div class="action-section">
        <h2>📧 Option 1: Submit Written Public Comment to Massport</h2>
        <p><strong>Fastest option (2 minutes)</strong> - Send an email directly to Massport's public comment address.</p>

        <?php if ($RI_TEST_MODE): ?>
        <!-- TEST MODE: User enters their info -->
        <div class="test-email-box">
            <h3>🧪 Test Mode - Preview Email</h3>
            <p>Enter your information below to preview the emails. In test mode, emails will only go to YOUR address.</p>
            
            <div style="margin-bottom: 15px;">
                <label for="user_name_ri" style="display: block; font-weight: 600; margin-bottom: 5px; color: #856404;">Your Name *</label>
                <input type="text" id="user_name_ri" placeholder="John Smith" required style="width: 100%; padding: 12px; font-size: 16px; border: 2px solid #044f9d; border-radius: 5px;">
            </div>
            
            <div style="margin-bottom: 15px;">
                <label for="user_email_ri" style="display: block; font-weight: 600; margin-bottom: 5px; color: #856404;">Your Email *</label>
                <input type="email" id="user_email_ri" placeholder="your-email@example.com" required style="width: 100%; padding: 12px; font-size: 16px; border: 2px solid #044f9d; border-radius: 5px;">
            </div>
            
            <div class="button-group">
                <button onclick="sendTestEmail()" class="action-button">Preview Short Email</button>
                <button onclick="openFullLetterEmail()" class="action-button secondary">Preview Full Letter</button>
            </div>
        </div>
        
   <script>
function sendTestEmail() {
    var testEmail = document.getElementById('user_email_ri').value;
    var userName = document.getElementById('user_name_ri').value;
    if (!testEmail || !testEmail.includes('@')) {
        alert('Please enter a valid email address');
        return;
    }
    if (!userName) {
        alert('Please enter your name');
        return;
    }
    
    var subject = "Massport Must Halt ICE Operations that Violate Due Process Rights at Hanscom Field";
    
    // RHODE ISLAND SHORT LETTER - WINDOWS LINE BREAKS
    var body = "Dear Chief Executive Officer Davey, Board Chair Jacobs, and Vice Chair O'Brien,%0D%0A%0D%0A" +
           "Over 1,000 Rhode Island residents have been forcibly removed from our state using ICE charter flights from Hanscom Field. Transfers are a tactic used by ICE to instill terror, destroy due process, and separate Rhode Islanders from their families, lawyers, and local resources, oftentimes including life-saving medications. Rhode Island resident's constitutional rights of due process have been recklessly disregarded by Massport. The regional ICE office initiates transfers for residents throughout the New England area, so Massport must ensure its operations do not violate Rhode Island and all New England residents' due-process rights under Massachusetts' state constitution.%0D%0A%0D%0A" +
           "When Rhode Islanders are transferred out of state in order to deny them life-saving medical care, their human rights are violated. When resident asylum seekers, holders of valid work permits, or spouses of U.S. citizens are flown out of state without access to counsel or family support, their constitutional right to seek release before a Rhode Island judge, or to have counsel file a habeas petition on their behalf, is effectively denied.%0D%0A%0D%0A" +
           "In Massachusetts, civil immigration warrants carry no state arrest authority.%0D%0A%0D%0A" +
           "Committee for Public Counsel Services v. ICE (D. Mass. 2020) and Lunn v. Commonwealth confirm that state officials have no authority to facilitate removals based solely on civil immigration detainers, and that state actors cannot override Massachusetts due process protections.%0D%0A%0D%0A" +
           "I urge Massport to:%0D%0A%0D%0A" +
           "(1) Make public all ICE-related agreements and flight records;%0D%0A" +
           "(2) Adopt a Lunn-Compliance and Custody-Transfer Transparency Directive;%0D%0A" +
           "(3) Require charter operators and FBOs to certify Massachusetts law compliance;%0D%0A" +
           "(4) Create an MOU with State Police ensuring Lunn compliance; and%0D%0A" +
           "(5) Exercise your full regulatory authority to protect residents' constitutional rights.%0D%0A%0D%0A" +
           "STOP ICE ACTIVITY AT HANSCOM!!!%0D%0A%0D%0A" +
           "Sincerely,%0D%0A[Your Name]%0D%0A[Your City/Town], RI";
    
    window.location.href = 'mailto:' + encodeURIComponent(testEmail) + 
        '?subject=' + encodeURIComponent(subject) +
        '&body=' + body;
}


</script>
<?php else: ?>
<!-- PRODUCTION MODE: Real email with all recipients -->

<!-- BLUE BOX WITH NAME/EMAIL FIELDS -->
<div style="background-color: #e6f2ff; border: 3px solid #044f9d; border-radius: 8px; padding: 30px; margin: 25px 0;">
    
    <div style="margin-bottom: 20px;">
        <label for="user_name_ri" style="display: block; font-weight: 600; margin-bottom: 8px; color: #044f9d; font-size: 18px;">
            Your Name *
        </label>
        <input 
            type="text" 
            id="user_name_ri" 
            placeholder="John Smith"
            required
            style="width: 100%; padding: 12px; font-size: 16px; border: 2px solid #044f9d; border-radius: 4px; box-sizing: border-box;"
        >
    </div>
    
    <div style="margin-bottom: 25px;">
        <label for="user_email_ri" style="display: block; font-weight: 600; margin-bottom: 8px; color: #044f9d; font-size: 18px;">
            Your Email *
        </label>
        <input 
            type="email" 
            id="user_email_ri" 
            placeholder="your.email@example.com"
            required
            style="width: 100%; padding: 12px; font-size: 16px; border: 2px solid #044f9d; border-radius: 4px; box-sizing: border-box;"
        >
    </div>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
        <button 
            type="button" 
            onclick="sendTrackedEmailRI('short')" 
            class="action-button"
            style="background-color: #044f9d; color: white; padding: 15px 20px; font-size: 16px; font-weight: 600; border: 2px solid white; border-radius: 5px; cursor: pointer;">
            📧 SEND SHORT EMAIL<br>
            <span style="font-size: 13px; font-weight: normal;">(3 minutes)</span>
        </button>
        
        <button 
            type="button" 
            onclick="sendTrackedEmailRI('long')" 
            class="action-button"
            style="background-color: #c3202e; color: white; padding: 15px 20px; font-size: 16px; font-weight: 600; border: 2px solid white; border-radius: 5px; cursor: pointer;">
            📧 SEND FULL LETTER<br>
            <span style="font-size: 13px; font-weight: normal;">(5 minutes)</span>
        </button>
    </div>
    
</div>

<p style="font-size: 14px; color: #666; text-align: center;">
    🔒 We'll send you a confirmation with info about joining the DE-ICE mailing list.
</p>

<!-- Hidden WPForms for RI Email Tracking -->
<div style="display: none;">
    <?php echo do_shortcode('[wpforms id="1654"]'); ?>
</div>

<script>
function sendTrackedEmailRI(actionType) {
    console.log('=== sendTrackedEmailRI called ===');
    console.log('Action type:', actionType);
    
    var userName = document.getElementById('user_name_ri').value.trim();
    var userEmail = document.getElementById('user_email_ri').value.trim();
    
    console.log('User name:', userName);
    console.log('User email:', userEmail);
    
    if (!userName || !userEmail) {
        alert('Please enter your name and email');
        return;
    }
    
    // Validate email format
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(userEmail)) {
        alert('Please enter a valid email address');
        return;
    }
    
    console.log('Validation passed, filling hidden form...');
    
    // Find the hidden WPForms form and fill it - TODO: UPDATE FORM ID
    var nameField = document.querySelector('input[name="wpforms[fields][1]"]');
    var emailField = document.querySelector('input[name="wpforms[fields][2]"]');
    var actionField = document.querySelector('input[name="wpforms[fields][3]"]');
    
    if (nameField && emailField && actionField) {
        nameField.value = userName;
        emailField.value = userEmail;
        actionField.value = actionType;
        
        console.log('Hidden form fields populated');
        
        // Find and click the submit button
        var submitButton = document.querySelector('#wpforms-submit-1654');
        if (submitButton) {
            console.log('Clicking hidden form submit button');
            submitButton.click();
        } else {
            console.error('Submit button not found');
        }
    } else {
        console.error('Hidden form fields not found');
        console.log('Name field:', nameField);
        console.log('Email field:', emailField);
        console.log('Action field:', actionField);
    }
    
    console.log('Opening email client...');
    
    // Immediately call email function based on action type
    if (actionType === 'short') {
        sendProductionEmailRI();
    } else {
        openFullLetterEmail();
    }
}
    
   

function sendProductionEmailRI() {
    var subject = "Massport Must Halt ICE Operations that Violate Due Process Rights at Hanscom Field";
    
    // RHODE ISLAND SHORT LETTER
    var body = "Dear Chief Executive Officer Davey, Board Chair Jacobs, and Vice Chair O'Brien,%0D%0A%0D%0A" +
           "Over 1,000 Rhode Island residents have been forcibly removed from our state using ICE charter flights from Hanscom Field. Transfers are a tactic used by ICE to instill terror, destroy due process, and separate Rhode Islanders from their families, lawyers, and local resources, oftentimes including life-saving medications. Rhode Island resident's constitutional rights of due process have been recklessly disregarded by Massport. The regional ICE office initiates transfers for residents throughout the New England area, so Massport must ensure its operations do not violate Rhode Island and all New England residents' due-process rights under Massachusetts' state constitution.%0D%0A%0D%0A" +
           "When Rhode Islanders are transferred out of state in order to deny them life-saving medical care, their human rights are violated. When resident asylum seekers, holders of valid work permits, or spouses of U.S. citizens are flown out of state without access to counsel or family support, their constitutional right to seek release before a Rhode Island judge, or to have counsel file a habeas petition on their behalf, is effectively denied.%0D%0A%0D%0A" +
           "In Massachusetts, civil immigration warrants carry no state arrest authority.%0D%0A%0D%0A" +
           "Committee for Public Counsel Services v. ICE (D. Mass. 2020) and Lunn v. Commonwealth confirm that state officials have no authority to facilitate removals based solely on civil immigration detainers, and that state actors cannot override Massachusetts due process protections.%0D%0A%0D%0A" +
           "I urge Massport to:%0D%0A%0D%0A" +
           "(1) Make public all ICE-related agreements and flight records;%0D%0A" +
           "(2) Adopt a Lunn-Compliance and Custody-Transfer Transparency Directive;%0D%0A" +
           "(3) Require charter operators and FBOs to certify Massachusetts law compliance;%0D%0A" +
           "(4) Create an MOU with State Police ensuring Lunn compliance; and%0D%0A" +
           "(5) Exercise your full regulatory authority to protect residents' constitutional rights.%0D%0A%0D%0A" +
           "STOP ICE ACTIVITY AT HANSCOM!!!%0D%0A%0D%0A" +
           "Sincerely,%0D%0A[Your Name]%0D%0A[Your City/Town], RI";
    
    var recipient = 'WrittenPublicComments@massport.com';
    
    window.location.href = 'mailto:' + encodeURIComponent(recipient) + 
        '?subject=' + encodeURIComponent(subject) +
        '&body=' + body;
}
</script>
<?php endif; ?>
<script>
function openFullLetterEmail() {
    // RHODE ISLAND LONG/FULL LETTER
    var fullLetterText = `Dear Chief Executive Officer Davey, Board Chair Jacobs, and Vice Chair O'Brien, 

Over 1,000 Rhode Island residents have been forcibly removed from our state using ICE charter flights from Hanscom Field Airport. Transfers are a tactic used by ICE to instill terror, destroy due process, and separate Rhode Islanders from their families, lawyers, and local resources, oftentimes including life-saving medications. Rhode Island resident's constitutional rights of due process have been recklessly disregarded by Massport. The regional ICE office initiates transfers for residents throughout the New England area, so Massport must ensure its operations at Hanscom do not violate Rhode Island and all New England residents' due-process rights under Massachusetts' state constitution.

When Rhode Islanders are transferred out of state in order to deny them life-saving medical care, their human rights are violated. When resident asylum seekers, holders of valid work permits, or spouses of U.S. citizens entitled to hearings before Rhode Island immigration judges are flown out of state without access to counsel or family support, their due-process rights are violated. Committee for Public Counsel Services v. ICE (D. Mass. 2020) supports this conclusion. In addition, Lunn v. Commonwealth confirms that state officials have no authority to hold people on civil immigration detainers.

Our State Constitutional protections mean Massport needs to:

• Adopt a Lunn-Compliance and Custody-Transfer Transparency Directive for Hanscom Field and all Massport facilities. This policy must prohibit state actor facilitation based solely on ICE detainers, require warrant verification for any custody transfers, and mandate public monthly reporting of ICE charter operations.

• Require charter operators and fixed-base operators to certify their compliance with Massachusetts law, constitutional protections, and Massport's directives as a condition of using Massport property.

• Create an MOU with State Police Troop F to ensure that all State Police activities at Hanscom Field are fully compliant with Lunn and the Attorney General's guidelines prohibiting local law enforcement from assisting in ICE operations.

• Require charter operators to certify the safety of refueling operations with chained and shackled passengers. Air safety guidance for refueling does not envision chained and shackled passengers with limited movement. You must require all charter operators boarding shackled and chained passengers to certify their safety procedures and that flight attendants are trained in evacuating these passengers. If certification is not forthcoming, you must prohibit refueling if passengers are on board.

• Publish agreements and records in advance of all ICE-related air operations, using flight records obtained from Hanscom FBOs, as required under the Massachusetts Public Records Law and as requested by the Hanscom Field Advisory Commission in their letter of Sept. 17, 2025.

Other actions are available to Massport under the anti-commandeering doctrine of the Tenth Amendment of the U.S. Constitution. For example, Massport has no obligation to allow State Police from Troop F to provide any service to ICE contract flights that they do not already provide to other commercial contract operations.

Further, Massport is protected from loss of funding or other fiscal retaliation from the federal government if it changes contractor policies or withdraws special permissions granted to ICE alone. Recent injunctions and court cases—most notably Attorney General Andrea Campbell's successful lawsuit with 19 other states—resulted in a permanent injunction preventing the Department of Transportation from conditioning federal funds on cooperation or non-cooperation with ICE.

Massport cannot hide behind federal preemption to ignore New England residents' constitutional protections where it has the power to intervene. Massport has full regulatory authority to impose conditions on all operators using their facilities that ensures Massport and its contractors are not helping ICE to commit human rights violations, and are not flagrantly violating Massachusetts State Constitution's guarantee of due process.

STOP ICE ACTIVITY AT HANSCOM!!!

Sincerely,
[Your Name]
[Your Address]
[Your City, State ZIP]`;

    // Copy to clipboard using the same reliable method
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(fullLetterText).catch(function() {
            copyTextFallback(fullLetterText);
        });
    } else {
        copyTextFallback(fullLetterText);
    }
    
    // RHODE ISLAND LONG LETTER - EMAIL BODY WITH WINDOWS LINE BREAKS
    var emailBody = "Dear Chief Executive Officer Davey, Board Chair Jacobs, and Vice Chair O'Brien, %0D%0A%0D%0A" +
              "Over 1,000 Rhode Island residents have been forcibly removed from our state using ICE charter flights from Hanscom Field Airport. Transfers are a tactic used by ICE to instill terror, destroy due process, and separate Rhode Islanders from their families, lawyers, and local resources, oftentimes including life-saving medications. Rhode Island resident's constitutional rights of due process have been recklessly disregarded by Massport. The regional ICE office initiates transfers for residents throughout the New England area, so Massport must ensure its operations at Hanscom do not violate Rhode Island and all New England residents' due-process rights under Massachusetts' state constitution.%0D%0A%0D%0A" +
               "When Rhode Islanders are transferred out of state in order to deny them life-saving medical care, their human rights are violated. When resident asylum seekers, holders of valid work permits, or spouses of U.S. citizens entitled to hearings before Rhode Island immigration judges are flown out of state without access to counsel or family support, their due-process rights are violated. Committee for Public Counsel Services v. ICE (D. Mass. 2020) supports this conclusion. In addition, Lunn v. Commonwealth confirms that state officials have no authority to hold people on civil immigration detainers.%0D%0A%0D%0A" +
               "Our State Constitutional protections mean Massport needs to:%0D%0A%0D%0A" +
               "• Adopt a Lunn-Compliance and Custody-Transfer Transparency Directive for Hanscom Field and all Massport facilities. This policy must prohibit state actor facilitation based solely on ICE detainers, require warrant verification for any custody transfers, and mandate public monthly reporting of ICE charter operations.%0D%0A%0D%0A" +
               "• Require charter operators and fixed-base operators to certify their compliance with Massachusetts law, constitutional protections, and Massport's directives as a condition of using Massport property.%0D%0A%0D%0A" +
               "• Create an MOU with State Police Troop F to ensure that all State Police activities at Hanscom Field are fully compliant with Lunn and the Attorney General's guidelines prohibiting local law enforcement from assisting in ICE operations.%0D%0A%0D%0A" +
               "• Require charter operators to certify the safety of refueling operations with chained and shackled passengers. Air safety guidance for refueling does not envision chained and shackled passengers with limited movement. You must require all charter operators boarding shackled and chained passengers to certify their safety procedures and that flight attendants are trained in evacuating these passengers. If certification is not forthcoming, you must prohibit refueling if passengers are on board.%0D%0A%0D%0A" +
               "• Publish agreements and records in advance of all ICE-related air operations, using flight records obtained from Hanscom FBOs, as required under the Massachusetts Public Records Law and as requested by the Hanscom Field Advisory Commission in their letter of Sept. 17, 2025.%0D%0A%0D%0A" +
               "Other actions are available to Massport under the anti-commandeering doctrine of the Tenth Amendment of the U.S. Constitution. For example, Massport has no obligation to allow State Police from Troop F to provide any service to ICE contract flights that they do not already provide to other commercial contract operations.%0D%0A%0D%0A" +
               "Further, Massport is protected from loss of funding or other fiscal retaliation from the federal government if it changes contractor policies or withdraws special permissions granted to ICE alone. Recent injunctions and court cases—most notably Attorney General Andrea Campbell's successful lawsuit with 19 other states—resulted in a permanent injunction preventing the Department of Transportation from conditioning federal funds on cooperation or non-cooperation with ICE.%0D%0A%0D%0A" +
               "Massport cannot hide behind federal preemption to ignore New England residents' constitutional protections where it has the power to intervene. Massport has full regulatory authority to impose conditions on all operators using their facilities that ensures Massport and its contractors are not helping ICE to commit human rights violations, and are not flagrantly violating Massachusetts State Constitution's guarantee of due process.%0D%0A%0D%0A" +
               "STOP ICE ACTIVITY AT HANSCOM!!!%0D%0A%0D%0A" +
               "Sincerely,%0D%0A[Your Name]%0D%0A[Your Address]%0D%0A[Your City, State ZIP]";
                   

    // Open email with proper recipients
    <?php if ($RI_TEST_MODE): ?>
    var testEmail = document.getElementById('user_email_ri').value;
    var userName = document.getElementById('user_name_ri').value;
    if (!testEmail || !testEmail.includes('@')) {
        alert('Please enter your email address above first');
        return;
    }
    if (!userName) {
        alert('Please enter your name above first');
        return;
    }
    var recipient = testEmail;
    <?php else: ?>
    var recipient = 'WrittenPublicComments@massport.com';
    <?php endif; ?>
    
    var subject = 'Halt ICE Operations and Due Process Violations at Hanscom Field';
    
    // Use SAME encoding method as short email
    window.location.href = 'mailto:' + encodeURIComponent(recipient) + 
        '?subject=' + encodeURIComponent(subject) +
        '&body=' + emailBody; // Windows line breaks, no encodeURIComponent
    
    alert('✅ Full letter copied to clipboard AND email opened! Paste letter if email body is empty.');
}

// Keep the fallback copy function
function copyTextFallback(text) {
    const textArea = document.createElement('textarea');
    textArea.value = text;
    textArea.style.position = 'fixed';
    textArea.style.opacity = '0';
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    
    try {
        document.execCommand('copy');
    } catch (err) {
        console.error('Copy failed:', err);
    }
    
    document.body.removeChild(textArea);
}
</script>

        <div class="info-box" style="margin-top: 20px;">
    <p><strong>💡 Tip:</strong> Your email client will open with a pre-filled message. <span style="background-color: #c3202e; color: white; padding: 3px 6px; border-radius: 3px; font-weight: bold;">Add your name and city</span> before sending. For maximum impact, use the full letter option. You can read it below.</p>
</div>
    </div>

<!-- ============================================== -->
<!-- GOVERNOR HEALEY CONTACT SECTION - START -->
<!-- ============================================== -->

<div style="border: 2px solid #044f9d; background: #e6f2ff; padding: 30px; margin: 30px 0; border-radius: 8px;">
    
    <h2 style="color: #044f9d; margin-top: 0; font-family: sans-serif; font-size: 28px; text-align: center;">
        📣 CONTACT GOVERNOR HEALEY
    </h2>
    
    <p style="font-size: 18px; text-align: center; margin-bottom: 25px;">
        <strong>Send this letter to Gov. Healey. Subject Line: Stop Massport's Cooperation with ICE Deportation Flights </strong>
    </p>
    
    <ol style="font-size: 16px; line-height: 1.8; max-width: 800px; margin: 0 auto 25px auto; padding-left: 20px;">
        <li>Clicking the button will copy the letter and open the Governor's contact form.</li>
        <li>Fill in the contact form with your personal information. Paste the letter (on your clipboard) into the comments section. Then add any personal additions to your message. Submit the Form.</li>
        <li>After you have submitted, close that tab on your browser to return to this campaign page.</li>
        <li>Click the checkbox that you have emailed the Governor. You will receive an email confirmation from us.</li>
    </ol>
    
    <!-- Two-column layout for button and checkbox -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; align-items: center; max-width: 800px; margin: 0 auto;">
        
        <!-- Left column: Link styled as Button -->
        <div style="text-align: center;">
            <a href="https://www.mass.gov/info-details/email-the-governors-office" 
               target="_blank"
               onclick="return trackGovernorAndCopyLetter()"
               style="display: inline-block; background: #044f9d; color: white; padding: 15px 25px; font-size: 16px; font-weight: bold; border: none; border-radius: 5px; cursor: pointer; width: 100%; max-width: 320px; text-decoration: none; text-align: center; box-sizing: border-box;">
                📧 Send Letter to Gov. Healey via Contact Form
            </a>
        </div>
        
        <!-- Right column: Checkbox -->
        <div style="text-align: center;">
            <label style="font-size: 16px; cursor: pointer; display: inline-flex; align-items: center; gap: 10px;">
                <input type="checkbox" id="governor_contacted_checkbox" onchange="showGovernorConfirmation(this)" 
                       style="width: 20px; height: 20px; cursor: pointer;">
                <span>I have contacted the Governor</span>
            </label>
        </div>
        
    </div>
    
    <!-- Confirmation message (hidden initially) -->
    <div id="governor_confirmation_message" style="display: none; margin-top: 20px; padding: 15px; background: #d4edda; border: 1px solid #28a745; border-radius: 5px; text-align: center;">
        <strong>✅ Thank you!</strong> Your action has been recorded.
    </div>
    
</div>

<!-- Hidden WPForms for Governor Tracking - Uses same RI Email Tracking form -->
<div style="display: none;">
    <?php echo do_shortcode('[wpforms id="1654"]'); ?>
</div>

<script>
// Governor Healey letter text with URL-encoded Windows line breaks - RHODE ISLAND VERSION
var governorHealeyLetter = "Dear Governor Maura Healey,%0D%0A%0D%0A" +
    "Over 1,000 Rhode Island residents have been forcibly removed from our state using ICE charter flights from Hanscom Field Airport. Transfers are a tactic used by ICE to instill terror, destroy due process, and separate Rhode Islanders from their families, lawyers, and local resources, oftentimes including life-saving medications. Rhode Island resident's constitutional rights of due process have been recklessly disregarded by Massport. The regional ICE office initiates transfers for residents throughout the New England area, so Massport must ensure its operations at Hanscom do not violate Rhode Island and all New England residents' due-process rights under Massachusetts' state constitution.%0D%0A%0D%0A" +
    "When Rhode Islanders are transferred out of state in order to deny them life-saving medical care, their human rights are violated. When resident asylum seekers, holders of valid work permits, or spouses of U.S. citizens entitled to hearings before Rhode Island immigration judges are flown out of state without access to counsel or family support, their due-process rights are violated. Committee for Public Counsel Services v. ICE (D. Mass. 2020) supports this conclusion. In addition, Lunn v. Commonwealth confirms that state officials have no authority to hold people on civil immigration detainers.%0D%0A%0D%0A" +
    "We call on you to urge Massport to:%0D%0A%0D%0A" +
    "• Adopt a Lunn-Compliance and Custody-Transfer Transparency Directive for Hanscom Field and all Massport facilities. This policy must prohibit state actor facilitation based solely on ICE detainers, require warrant verification for any custody transfers, and mandate public monthly reporting of ICE charter operations.%0D%0A%0D%0A" +
    "• Require charter operators and fixed-base operators to certify their compliance with Massachusetts law, constitutional protections, and Massport's directives as a condition of using Massport property.%0D%0A%0D%0A" +
    "• Create an MOU with State Police Troop F to ensure that all State Police activities at Hanscom Field are fully compliant with Lunn and the Attorney General's guidelines prohibiting local law enforcement from assisting in ICE operations.%0D%0A%0D%0A" +
    "• Require charter operators to certify the safety of refueling operations with chained and shackled passengers. Air safety guidance for refueling does not envision chained and shackled passengers with limited movement. You must require all charter operators boarding shackled and chained passengers to certify their safety procedures and that flight attendants are trained in evacuating these passengers. If certification is not forthcoming, you must prohibit refueling if passengers are on board.%0D%0A%0D%0A" +
    "• Publish agreements and records in advance of all ICE-related air operations, using flight records obtained from Hanscom FBOs, as required under the Massachusetts Public Records Law and as requested by the Hanscom Field Advisory Commission in their letter of Sept. 17, 2025.%0D%0A%0D%0A" +
    "Other actions are available to Massport under the anti-commandeering doctrine of the Tenth Amendment of the U.S. Constitution. For example, Massport has no obligation to allow State Police from Troop F to provide any service to ICE contract flights that they do not already provide to other commercial contract operations.%0D%0A%0D%0A" +
    "Further, Massport is protected from loss of funding or other fiscal retaliation from the federal government if it changes contractor policies or withdraws special permissions granted to ICE alone. Recent injunctions and court cases—most notably Attorney General Andrea Campbell's successful lawsuit with 19 other states—resulted in a permanent injunction preventing the Department of Transportation from conditioning federal funds on cooperation or non-cooperation with ICE.%0D%0A%0D%0A" +
    "You must prevent Massport from hiding behind federal preemption to ignore New England residents' constitutional protections where it has the power to intervene. Massport has full regulatory authority to impose conditions on all operators using their facilities that ensures Massport and its contractors are not helping ICE to commit human rights violations, and are not flagrantly violating Massachusetts State Constitution's guarantee of due process.%0D%0A%0D%0A" +
    "STOP ICE ACTIVITY AT HANSCOM!!!%0D%0A%0D%0A" +
    "Sincerely,%0D%0A";

// Track Governor action on button click AND copy letter
function trackGovernorAndCopyLetter() {
    console.log('=== trackGovernorAndCopyLetter called ===');
    
    // Check if name/email fields are populated from Section 1
    var nameField = document.getElementById('user_name_ri');
    var emailField = document.getElementById('user_email_ri');
    
    var userName = nameField ? nameField.value.trim() : '';
    var userEmail = emailField ? emailField.value.trim() : '';
    
    console.log('User name from Section 1:', userName || '(empty)');
    console.log('User email from Section 1:', userEmail || '(empty)');
    
    // Option B: Warn if no email, let them choose
    if (!userName || !userEmail) {
        var proceed = confirm('You haven\'t entered your name and email in Section 1 above.\n\nYou won\'t receive a confirmation email from us.\n\nClick OK to continue to the Governor\'s form anyway, or Cancel to go back and enter your information.');
        if (!proceed) {
            return false; // Stops the link from opening
        }
    }
    
    // Copy letter to clipboard
    var decodedLetter = decodeURIComponent(governorHealeyLetter);
    
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(decodedLetter).then(function() {
            console.log('Governor letter copied to clipboard');
        }).catch(function(err) {
            console.error('Clipboard write failed, using fallback:', err);
            copyTextFallbackGovernor(decodedLetter);
        });
    } else {
        copyTextFallbackGovernor(decodedLetter);
    }
    
    // Find the hidden Governor form fields - Uses RI Email Tracking form 1654
    var wpNameField = document.querySelector('#wpforms-1654 input[name="wpforms[fields][1]"]');
    var wpEmailField = document.querySelector('#wpforms-1654 input[name="wpforms[fields][2]"]');
    var wpActionField = document.querySelector('#wpforms-1654 input[name="wpforms[fields][3]"]');
    var submitButton = document.querySelector('#wpforms-submit-1654');
    
    if (wpNameField && wpEmailField && submitButton) {
        if (userName && userEmail) {
            // User filled in Section 1 - use that info for confirmation email
            wpNameField.value = userName;
            wpEmailField.value = userEmail;
            if (wpActionField) wpActionField.value = 'governor';
            
            console.log('Submitting Governor tracking form with user info...');
            submitButton.click();
        } else {
            // User chose to proceed without email - track action only
            wpNameField.value = 'Anonymous';
            wpEmailField.value = 'no-email@tracking-only.local';
            if (wpActionField) wpActionField.value = 'governor';
            
            console.log('Submitting Governor tracking form WITHOUT user info...');
            submitButton.click();
        }
    } else {
        console.error('Governor tracking form fields not found');
        console.log('Name field:', wpNameField);
        console.log('Email field:', wpEmailField);
        console.log('Submit button:', submitButton);
    }
    
    // Return true to allow the link to open
    return true;
}

// Fallback copy method for older browsers
function copyTextFallbackGovernor(text) {
    var textArea = document.createElement('textarea');
    textArea.value = text;
    textArea.style.position = 'fixed';
    textArea.style.left = '-9999px';
    textArea.style.top = '0';
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    try {
        document.execCommand('copy');
        console.log('Governor letter copied via fallback method');
    } catch (err) {
        console.error('Fallback copy failed:', err);
    }
    document.body.removeChild(textArea);
}

// Checkbox just shows confirmation (no form submission)
function showGovernorConfirmation(checkbox) {
    if (checkbox.checked) {
        document.getElementById('governor_confirmation_message').style.display = 'block';
        checkbox.disabled = true;
    } else {
        document.getElementById('governor_confirmation_message').style.display = 'none';
    }
}
</script>

<!-- ============================================== -->
<!-- GOVERNOR HEALEY CONTACT SECTION - END -->
<!-- ============================================== -->

    <div class="divider">
        <span>AND / OR</span>
    </div>

    <div class="action-section">
        <h2>📮 Option 2: Mail Individual Letters to All 7 Board Members </h2>
        <p><strong>Maximum impact option (10 minutes + postage)</strong> - Personal letters to each board member carry significant weight.</p>

        <?php if ($RI_TEST_MODE): ?>
        <div class="test-email-box">
            <p><strong>🧪 Test Mode:</strong> Form submissions will be sent to the test coordinator for review. No actual letters will be generated during testing.</p>
        </div>
        <?php endif; ?>

        <h3>How it works:</h3>
        <ol>
            <li>Enter your name and address below</li>
            <li>Submit the form</li>
            <li>Receive 7 personalized PDF letters via email (one for each board member)</li>
            <li>Print, sign, and mail each letter</li>
        </ol>

        <div class="info-box">
            <p><strong>📬 Estimated cost:</strong> ~$8 for 7 stamps (Forever stamps). <strong>Impact:</strong> Board members take postal mail very seriously.</p>
        </div>

       <?php echo do_shortcode('[wpforms id="1657"]'); ?>

        
    </div>

    <div id="full-letter" class="action-section">
        <h2>📋 Full Letter Text</h2>
        <p>This is the complete letter being sent to Massport:</p>
        
       <div class="letter-actions">
    <button onclick="copyFullLetter()" class="action-button secondary">
        📋 Copy Full Letter to Clipboard
    </button>
    
   <!-- TODO: UPDATE PDF LINK FOR RHODE ISLAND -->
   <a href="<?php echo esc_url( home_url('/wp-content/uploads/2025/12/RI_Massport_Sample_Letter.pdf') ); ?>" class="action-button secondary" download>
        📄 Download Letter to Massport Board of Directors (PDF)
    </a>
</div>

       <div id="fullLetterText">
    <p><strong>FROM:</strong> [Your Name]<br>
    <strong>TO:</strong> Richard Davey, Chief Executive Officer; Patricia Jacobs, Chair of the Board of Directors; Sean M. O'Brien, Vice Chair of the Board of Directors<br>
    <strong>RE:</strong> Massport must halt ICE operations that violate due-process protections at Hanscom Field</p>

    <p>Dear Chief Executive Officer Davey, Board Chair Jacobs, and Vice Chair O'Brien, </p>

    <p>Over 1,000 Rhode Island residents have been forcibly removed from our state using ICE charter flights from Hanscom Field Airport. Transfers are a tactic used by ICE to instill terror, destroy due process, and separate Rhode Islanders from their families, lawyers, and local resources, oftentimes including life-saving medications. Rhode Island resident's constitutional rights of due process have been recklessly disregarded by Massport. The regional ICE office initiates transfers for residents throughout the New England area, so Massport must ensure its operations at Hanscom do not violate Rhode Island and all New England residents' due-process rights under Massachusetts' state constitution.</p>

    <p>When Rhode Islanders are transferred out of state in order to deny them life-saving medical care, their human rights are violated. When resident asylum seekers, holders of valid work permits, or spouses of U.S. citizens entitled to hearings before Rhode Island immigration judges are flown out of state without access to counsel or family support, their due-process rights are violated. Committee for Public Counsel Services v. ICE (D. Mass. 2020) supports this conclusion. In addition, Lunn v. Commonwealth confirms that state officials have no authority to hold people on civil immigration detainers.</p>

    <p>Our State Constitutional protections mean Massport needs to:</p>

    <ul>
        <li>Adopt a Lunn-Compliance and Custody-Transfer Transparency Directive for Hanscom Field and all Massport facilities. This policy must prohibit state actor facilitation based solely on ICE detainers, require warrant verification for any custody transfers, and mandate public monthly reporting of ICE charter operations.<br><br></li>
        
        <li>Require charter operators and fixed-base operators to certify their compliance with Massachusetts law, constitutional protections, and Massport's directives as a condition of using Massport property.<br><br></li>
        
        <li>Create an MOU with State Police Troop F to ensure that all State Police activities at Hanscom Field are fully compliant with Lunn and the Attorney General's guidelines prohibiting local law enforcement from assisting in ICE operations.<br><br></li>
        
        <li>Require charter operators to certify the safety of refueling operations with chained and shackled passengers. Air safety guidance for refueling does not envision chained and shackled passengers with limited movement. You must require all charter operators boarding shackled and chained passengers to certify their safety procedures and that flight attendants are trained in evacuating these passengers. If certification is not forthcoming, you must prohibit refueling if passengers are on board.<br><br></li>
        
        <li>Publish agreements and records in advance of all ICE-related air operations, using flight records obtained from Hanscom FBOs, as required under the Massachusetts Public Records Law and as requested by the Hanscom Field Advisory Commission in their letter of Sept. 17, 2025.<br><br></li>
    </ul>

    <p>Other actions are available to Massport under the anti-commandeering doctrine of the Tenth Amendment of the U.S. Constitution. For example, Massport has no obligation to allow State Police from Troop F to provide any service to ICE contract flights that they do not already provide to other commercial contract operations.</p>

    <p>Further, Massport is protected from loss of funding or other fiscal retaliation from the federal government if it changes contractor policies or withdraws special permissions granted to ICE alone. Recent injunctions and court cases—most notably Attorney General Andrea Campbell's successful lawsuit with 19 other states—resulted in a permanent injunction preventing the Department of Transportation from conditioning federal funds on cooperation or non-cooperation with ICE.</p>

    <p>Massport cannot hide behind federal preemption to ignore New England residents' constitutional protections where it has the power to intervene. Massport has full regulatory authority to impose conditions on all operators using their facilities that ensures Massport and its contractors are not helping ICE to commit human rights violations, and are not flagrantly violating Massachusetts State Constitution's guarantee of due process.</p>

    <p><strong>STOP ICE ACTIVITY AT HANSCOM!!!</strong></p>

    <p>Sincerely,<br>
    [Your Name]<br>
    [Your Address]<br>
    [Your City/Town], RI [ZIP]</p>
</div>

    <div class="action-section">
        <h2>📚 Additional Resources</h2>
        <ul>
            <li><a href="https://www.aclum.org/cases/commonwealth-v-lunn-and-lunn-v-smith/" target="_blank">ACLU Background on Lunn v. Commonwealth and link to Decision</a></li>
            <li><a href="/stop-massport-ice-flights-campaign/official-addresses/">Board Member And Mass Officials Contact Information</a></li>
            <li><a href="#">Share This Campaign</a></li>
        </ul>
    </div>

    <div class="coalition-footer">
        <p><strong>The DE-ICE Hanscom campaign is supported by multiple organizations.</strong><br>
        </p>
        <p>Questions? Contact: <a href="mailto:info@lexingtonalarm.org">Lexington Alarm</a></p>
    </div>

</div>

<script>
function copyFullLetter() {
    const letterText = document.getElementById('fullLetterText').innerText;
    navigator.clipboard.writeText(letterText).then(() => {
        alert('✅ Full letter copied to clipboard! You can now paste it into an email or document.');
    }, () => {
        alert('❌ Copy failed. Please manually select and copy the text.');
    });
}

document.getElementById('boardLettersForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    alert('⚠️ Form submitted! Replace with WPForms shortcode or see implementation guide.');
});
</script>
<!-- Complete Footer with Combined Logos, Copyright, and Navigation -->
<div style="background-color: #044f9d; width: 100vw; position: relative; left: 50%; right: 50%; margin-left: -50vw; margin-right: -50vw; padding: 30px 0; text-align: center;">
    
    <!-- Combined Partner Logos Image -->
    <div style="margin-bottom: 20px; text-align: center;">
        <img src="https://lexingtonalarm.org/wp-content/uploads/2025/11/complete_DE-ICE-Logos-1.webp" 
             alt="DE-ICE Hanscom Campaign Partner Organizations" 
             style="display: inline-block; max-width: 800px; width: 90%; height: auto;">
    </div>
    
    <!-- Copyright Section -->
    <div style="margin: 20px auto; text-align: center; color: white; font-size: 16px; font-weight: bold;">
        © LEXINGTON ALARM! 2025
    </div>
    
    <!-- Divider -->
    <div style="width: 100%; max-width: 300px; height: 1px; background-color: rgba(255,255,255,0.3); margin: 20px auto;"></div>
    
    <!-- Navigation Links -->
    <div style="margin-top: 20px; text-align: center; color: white; font-size: 16px;">
        <a href="/about" style="color: white; text-decoration: none; padding: 0 10px; font-weight: bold;">ABOUT</a> | 
        <a href="/get-involved" style="color: white; text-decoration: none; padding: 0 10px; font-weight: bold;">GET INVOLVED</a> | 
        <a href="/events" style="color: white; text-decoration: none; padding: 0 10px; font-weight: bold;">EVENTS</a>
    </div>
    
</div>

<?php wp_footer(); ?>
</body>
</html>
    <?php
    exit;
}
