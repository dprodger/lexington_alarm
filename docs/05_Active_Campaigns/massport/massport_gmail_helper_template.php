<?php
/**
 * Massport Gmail Helper Page Template
 * 
 * Creates a page template for Gmail users to copy/paste email content
 * Install via Code Snippets plugin
 * 
 * After installing, create a page with slug "massport-gmail-helper"
 * and select "Massport Gmail Helper" as the template
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Register the template
add_filter('theme_page_templates', function($templates) {
    $templates['massport-gmail-helper'] = 'Massport Gmail Helper';
    return $templates;
});

add_filter('template_include', function($template) {
    global $post;
    
    if ($post && get_page_template_slug($post->ID) === 'massport-gmail-helper') {
        massport_gmail_helper_template();
        exit;
    }
    
    return $template;
});

function massport_gmail_helper_template() {
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gmail Helper - Massport Campaign | Lexington Alarm</title>
    <?php wp_head(); ?>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
            font-size: 16px;
            line-height: 1.6;
            color: #333;
            background: #f5f5f5;
        }
        
        .gmail-helper-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            background: #044f9d;
            color: white;
            padding: 30px 20px;
            text-align: center;
            margin: -20px -20px 30px -20px;
        }
        
        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .header p {
            font-size: 16px;
            opacity: 0.9;
        }
        
        .instructions {
            background: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
        }
        
        .instructions h2 {
            color: #856404;
            font-size: 20px;
            margin-bottom: 15px;
        }
        
        .instructions ol {
            margin-left: 20px;
        }
        
        .instructions li {
            margin-bottom: 10px;
        }
        
        .content-section {
            background: white;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #044f9d;
        }
        
        .section-header h3 {
            color: #044f9d;
            font-size: 18px;
            margin: 0;
        }
        
        .copy-button {
            background: #044f9d;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            transition: background 0.2s;
        }
        
        .copy-button:hover {
            background: #033d7d;
        }
        
        .copy-button.copied {
            background: #28a745;
        }
        
        .copyable-content {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            font-family: inherit;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        
        .email-field {
            font-family: monospace;
            background: #e9ecef;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 5px;
        }
        
        .cc-note {
            font-size: 14px;
            color: #666;
            margin-top: 10px;
            font-style: italic;
        }
        
        .letter-choice {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .letter-tab {
            flex: 1;
            padding: 15px;
            text-align: center;
            background: #e9ecef;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.2s;
        }
        
        .letter-tab:hover {
            background: #dee2e6;
        }
        
        .letter-tab.active {
            background: #044f9d;
            color: white;
            border-color: #044f9d;
        }
        
        .letter-content {
            display: none;
        }
        
        .letter-content.active {
            display: block;
        }
        
        .signature-section {
            background: #fff;
            border: 2px dashed #044f9d;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
        }
        
        .signature-section h3 {
            color: #044f9d;
            margin-bottom: 10px;
        }
        
        .signature-section p {
            color: #666;
        }
        
        .back-link {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
        }
        
        .back-link a {
            color: #044f9d;
            text-decoration: none;
            font-weight: bold;
        }
        
        .back-link a:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 600px) {
            .letter-choice {
                flex-direction: column;
            }
            
            .section-header {
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
            }
            
            .header h1 {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>
    <div class="gmail-helper-container">
        
        <div class="header">
            <h1>📧 Gmail Email Helper</h1>
            <p>Copy and paste the content below into your Gmail message</p>
        </div>
        
        <div class="instructions">
            <h2>📋 Instructions for Gmail Users</h2>
            <ol>
                <li><strong>Open Gmail</strong> in a new tab and click "Compose"</li>
                <li><strong>Copy the email address</strong> below and paste it in the "To" field</li>
                <li><strong>Copy the CC addresses</strong> and paste them in the "CC" field (click "Cc" next to "To" if you don't see it)</li>
                <li><strong>Copy the subject line</strong> and paste it in the "Subject" field</li>
                <li><strong>Choose either the Short or Long letter</strong> below and copy/paste into the message body</li>
                <li><strong>Add your signature</strong> at the bottom (your name and city/town)</li>
                <li><strong>Click Send!</strong></li>
            </ol>
        </div>
        
        <!-- EMAIL ADDRESS -->
        <div class="content-section">
            <div class="section-header">
                <h3>📬 To: Email Address</h3>
                <button class="copy-button" onclick="copyToClipboard('email-to', this)">Copy</button>
            </div>
            <div id="email-to" class="email-field">WrittenPublicComments@massport.com</div>
        </div>
        
        <!-- CC ADDRESSES -->
        <div class="content-section">
            <div class="section-header">
                <h3>📋 CC: State Officials</h3>
                <button class="copy-button" onclick="copyToClipboard('email-cc', this)">Copy All</button>
            </div>
            <div id="email-cc" class="email-field">governor.healey@mass.gov, ago@mass.gov, karen.spilka@masenate.gov, ronald.mariano@mahouse.gov</div>
            <p class="cc-note">These are: Governor Healey, Attorney General Campbell, Senate President Spilka, and Speaker Mariano</p>
        </div>
        
        <!-- SUBJECT LINE -->
        <div class="content-section">
            <div class="section-header">
                <h3>✉️ Subject Line</h3>
                <button class="copy-button" onclick="copyToClipboard('email-subject', this)">Copy</button>
            </div>
            <div id="email-subject" class="email-field">Demand Massport Stop ICE Charter Flights at Hanscom Field</div>
        </div>
        
        <!-- LETTER BODY -->
        <div class="content-section">
            <div class="section-header">
                <h3>📝 Message Body (Choose One)</h3>
            </div>
            
            <div class="letter-choice">
                <div class="letter-tab active" onclick="showLetter('short')">
                    ✉️ Short Letter<br><small>(Quick Action)</small>
                </div>
                <div class="letter-tab" onclick="showLetter('long')">
                    📄 Long Letter<br><small>(Full Detail)</small>
                </div>
            </div>
            
            <!-- SHORT LETTER -->
            <div id="letter-short" class="letter-content active">
                <div class="section-header">
                    <h3>Short Letter</h3>
                    <button class="copy-button" onclick="copyToClipboard('short-body', this)">Copy Short Letter</button>
                </div>
                <div id="short-body" class="copyable-content">Dear Chief Executive Officer Davey, Board Chair Jacobs, and Vice Chair O'Brien,

Over 2,000 Massachusetts residents have been forcibly removed from our state using ICE charter flights from Hanscom Field. Their constitutional rights of due process have been recklessly disregarded by Massport. Massport must ensure its operations do not violate Massachusetts residents' due-process rights under our state constitution.

When resident asylum seekers, holders of valid work permits, or spouses of U.S. citizens entitled to hearings before Massachusetts immigration judges are flown out of state without access to counsel or family support, their due-process rights are violated. Committee for Public Counsel Services v. ICE (D. Mass. 2020) supports this conclusion. In addition, Lunn v. Commonwealth confirms that state officials have no authority to hold people on civil immigration detainers.

We call on Massport to publish agreements and records of all ICE-related air operations, adopt a Lunn-Compliance and Custody-Transfer Transparency Directive, require charter operators to certify compliance with Massachusetts law, and create an MOU with State Police Troop F to ensure compliance with the Attorney General's guidelines.

Sincerely,

[YOUR NAME]
[YOUR CITY/TOWN], Massachusetts</div>
            </div>
            
            <!-- LONG LETTER -->
            <div id="letter-long" class="letter-content">
                <div class="section-header">
                    <h3>Long Letter (Full Detail)</h3>
                    <button class="copy-button" onclick="copyToClipboard('long-body', this)">Copy Long Letter</button>
                </div>
                <div id="long-body" class="copyable-content">Dear Chief Executive Officer Davey, Board Chair Jacobs, Vice Chair O'Brien, and Members of the Massport Board of Directors,

Over 2,000 Massachusetts residents have been forcibly removed from our state using ICE charter flights from Hanscom Field. Their constitutional rights of due process have been recklessly disregarded by Massport. Massport must ensure its operations do not violate Massachusetts residents' due-process rights under our state constitution.

When resident asylum seekers, holders of valid work permits, or spouses of U.S. citizens entitled to hearings before Massachusetts immigration judges are flown out of state without access to counsel or family support, their due-process rights are violated. Committee for Public Counsel Services v. ICE (D. Mass. 2020) supports this conclusion. In addition, Lunn v. Commonwealth confirms that state officials have no authority to hold people on civil immigration detainers.

We call on Massport to:

• Publish agreements and records in advance of all ICE-related air operations, using flight records obtained from Hanscom FBOs, as required under the Massachusetts Public Records Law and as requested by the Hanscom Field Advisory Commission in their letter of Sept. 17, 2025.

• Adopt a Lunn-Compliance and Custody-Transfer Transparency Directive for Hanscom Field and all Massport facilities. This policy must prohibit state actor facilitation based solely on ICE detainers, require warrant verification for any custody transfers, and mandate public monthly reporting of ICE charter operations.

• Require charter operators and fixed-base operators to certify their compliance with Massachusetts law, constitutional protections, and Massport's directives as a condition of using Massport property.

• Require charter operators to certify the safety of refueling operations with chained and shackled passengers. Air safety guidance for refueling does not envision chained and shackled passengers with limited movement. You must require all charter operators boarding shackled and chained passengers to certify their safety procedures and that flight attendants are trained in evacuating these passengers. If certification is not forthcoming, you must prohibit refueling if passengers are on board.

• Create an MOU with State Police Troop F to ensure that all State Police activities at Hanscom Field are fully compliant with Lunn and the Attorney General's guidelines prohibiting local law enforcement from assisting in ICE operations.

Other actions are available to Massport under the anti-commandeering doctrine of the Tenth Amendment of the U.S. Constitution. For example, Massport has no obligation to allow State Police from Troop F to provide any service to ICE contract flights that they do not already provide to other commercial contract operations.

Further, Massport is protected from loss of funding or other fiscal retaliation from the federal government if it changes contractor policies or withdraws special permissions granted to ICE alone. Recent injunctions and court cases—most notably Attorney General Andrea Campbell's successful lawsuit with 19 other states—resulted in a permanent injunction preventing the Department of Transportation from conditioning federal funds on cooperation or non-cooperation with ICE.

Massport cannot hide behind federal preemption to ignore our state constitutional protections where it has the power to intervene. Massport has full regulatory authority to impose conditions on all operators using their facilities that ensures Massport and its contractors are not flagrantly violating our State Constitution's guarantee of due process.

Sincerely,

[YOUR NAME]
[YOUR CITY/TOWN], Massachusetts</div>
            </div>
        </div>
        
        <!-- SIGNATURE REMINDER -->
        <div class="signature-section">
            <h3>✍️ Don't Forget Your Signature!</h3>
            <p>Replace [YOUR NAME] and [YOUR CITY/TOWN] with your actual name and Massachusetts city/town before sending.</p>
        </div>
        
        <!-- BACK LINK -->
        <div class="back-link">
            <a href="<?php echo esc_url( home_url('/stop-massport-ice-flights-campaign/') ); ?>">← Back to Campaign Page</a>
        </div>
        
    </div>
    
    <script>
        function copyToClipboard(elementId, button) {
            const element = document.getElementById(elementId);
            const text = element.innerText || element.textContent;
            
            navigator.clipboard.writeText(text).then(function() {
                const originalText = button.innerText;
                button.innerText = '✓ Copied!';
                button.classList.add('copied');
                
                setTimeout(function() {
                    button.innerText = originalText;
                    button.classList.remove('copied');
                }, 2000);
            }).catch(function(err) {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = text;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                
                const originalText = button.innerText;
                button.innerText = '✓ Copied!';
                button.classList.add('copied');
                
                setTimeout(function() {
                    button.innerText = originalText;
                    button.classList.remove('copied');
                }, 2000);
            });
        }
        
        function showLetter(type) {
            // Update tabs
            document.querySelectorAll('.letter-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            event.currentTarget.classList.add('active');
            
            // Update content
            document.querySelectorAll('.letter-content').forEach(content => {
                content.classList.remove('active');
            });
            document.getElementById('letter-' + type).classList.add('active');
        }
    </script>
    
    <?php wp_footer(); ?>
</body>
</html>
<?php
}
