<?php
/**
 * Massachusetts Massport Board Letters PDF Generator
 * Integrates with WPForms to generate PDF with 8 personalized letters:
 *   - 7 letters to Massport Board Members
 *   - 1 letter to Governor Healey
 * 
 * UPDATED: December 13, 2025
 * CHANGES:
 *   - Replaced Monica Tibbits-Nutt with Phillip Eng (new MassDOT Secretary)
 *   - Removed "RE:" prefix from letter subject line
 *   - Added Governor Healey as 8th letter recipient
 *   - Updated instruction page (7→8 letters, added Governor address)
 * 
 * Installation: Add to WordPress via Code Snippets plugin
 * Requirements: TCPDF library (auto-installed)
 * 
 * @version 2.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Main class for Massport PDF generation
 */
class Massport_PDF_Generator {



http://cbrealty.com/
    
    private $form_id = 1401;  // MA Board Letters form - UPDATE IF DIFFERENT
    
    public function __construct() {
        // Hook into WPForms submission
        add_action('wpforms_process_complete_' . $this->form_id, array($this, 'generate_and_send_pdf'), 10, 4);
    }
    
    /**
     * Main handler for form submission
     */
    public function generate_and_send_pdf($fields, $entry, $form_data, $entry_id) {
        
        // Extract form data - UPDATE FIELD IDs TO MATCH YOUR FORM
        $user_data = array(
            'name' => isset($fields[1]['value']) ? $fields[1]['value'] : '',
            'email' => isset($fields[2]['value']) ? sanitize_email($fields[2]['value']) : '',
            'street' => isset($fields[5]['value']) ? $fields[5]['value'] : '',
            'apt' => isset($fields[6]['value']) ? $fields[6]['value'] : '',
            'city' => isset($fields[7]['value']) ? $fields[7]['value'] : '',
            'zip' => isset($fields[9]['value']) ? $fields[9]['value'] : '',
            'organization' => isset($fields[10]['value']) ? $fields[10]['value'] : '',
            'date' => date('F j, Y')
        );
        
        // Build full address
        $full_address = $user_data['street'];
        if (!empty($user_data['apt'])) {
            $full_address .= ' ' . $user_data['apt'];
        }
        $city_state_zip = $user_data['city'] . ', MA ' . $user_data['zip'];
        
        try {
            // Generate PDF
            $pdf_path = $this->create_pdf($user_data, $full_address, $city_state_zip);
            
            // Send email with PDF attachment
            $this->send_email($user_data['email'], $user_data['name'], $pdf_path);
            
            // Clean up temporary file
            @unlink($pdf_path);
            
        } catch (Exception $e) {
            // Log error
            error_log('Massport PDF Generator Error: ' . $e->getMessage());
        }
    }
    
    /**
     * Create the PDF with 8 letters (7 board + 1 Governor)
     */
    private function create_pdf($user_data, $full_address, $city_state_zip) {
        
        // Load TCPDF
        require_once(ABSPATH . 'wp-includes/class-phpmailer.php');
        
        // Check if TCPDF exists, if not download it
        if (!class_exists('TCPDF')) {
            $this->install_tcpdf();
        }
        
        require_once($this->get_tcpdf_path() . 'tcpdf.php');
        
        // Create new PDF document
        $pdf = new TCPDF('P', 'in', 'LETTER', true, 'UTF-8', false);
        
        // Set document information
        $pdf->SetCreator('DE-ICE Hanscom Campaign');
        $pdf->SetAuthor($user_data['name']);
        $pdf->SetTitle('Massport Board & Governor Letters - ' . $user_data['name']);
        $pdf->SetSubject('Letters to Massport Board of Directors and Governor Healey');
        
        // Remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        
        // Set margins (0.75 inches)
        $pdf->SetMargins(0.75, 0.75, 0.75);
        $pdf->SetAutoPageBreak(true, 0.75);
        
        // Set font
        $pdf->SetFont('helvetica', '', 12);
        
        // PAGE 1: Instructions
        $pdf->AddPage();
        $this->add_instructions_page($pdf, $user_data['name']);
        
        // Board members - UPDATED: Phillip Eng replaces Monica Tibbits-Nutt
        $board_members = array(
            array('name' => 'Patricia A. Jacobs', 'title' => 'Chair, Board of Directors', 'salutation' => 'Ms. Jacobs'),
            array('name' => 'Sean M. O\'Brien', 'title' => 'Vice Chair, Board of Directors', 'salutation' => 'Mr. O\'Brien'),
            array('name' => 'Lewis Evangelidis', 'title' => 'Board Member', 'salutation' => 'Mr. Evangelidis'),
            array('name' => 'Pamela Everhart', 'title' => 'Board Member', 'salutation' => 'Ms. Everhart'),
            array('name' => 'Warren Fields', 'title' => 'Board Member', 'salutation' => 'Mr. Fields'),
            array('name' => 'John Nucci', 'title' => 'Board Member', 'salutation' => 'Mr. Nucci'),
            array('name' => 'Phillip Eng', 'title' => 'Secretary/Ex Officio (MassDOT)', 'salutation' => 'Mr. Eng')
        );
        
        // PAGES 2-8: Seven board member letters
        foreach ($board_members as $member) {
            $pdf->AddPage();
            $this->add_board_letter_page($pdf, $user_data, $full_address, $city_state_zip, $member);
        }
        
        // PAGE 9: Governor Healey letter
        $pdf->AddPage();
        $this->add_governor_letter_page($pdf, $user_data, $full_address, $city_state_zip);
        
        // Save to temporary file
        $upload_dir = wp_upload_dir();
        $pdf_filename = 'massport-letters-' . sanitize_file_name($user_data['name']) . '-' . time() . '.pdf';
        $pdf_path = $upload_dir['path'] . '/' . $pdf_filename;
        
        $pdf->Output($pdf_path, 'F');
        
        return $pdf_path;
    }
    
    /**
     * Add instructions page (Page 1) - UPDATED for 8 letters
     */
    private function add_instructions_page($pdf, $user_name) {
        
        // Title
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 0.4, 'INSTRUCTIONS FOR YOUR LETTERS', 0, 1, 'C');
        $pdf->Ln(0.2);
        
        // Greeting
        $pdf->SetFont('helvetica', '', 11);
        $pdf->MultiCell(0, 0.25, "Dear {$user_name},", 0, 'L');
        $pdf->Ln(0.15);
        
        // Thank you paragraph - UPDATED: 8 letters
        $pdf->MultiCell(0, 0.25, "Thank you for taking action to protect Massachusetts residents' constitutional rights! You're about to mail 8 personalized letters: 7 to each member of the Massport Board of Directors, and 1 to Governor Healey.", 0, 'L');
        $pdf->Ln(0.2);
        
        // What you've received - UPDATED
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->MultiCell(0, 0.25, 'WHAT YOU\'VE RECEIVED:', 0, 'L');
        $pdf->SetFont('helvetica', '', 11);
        $pdf->MultiCell(0, 0.25, 'This PDF contains 8 letters (pages 2-9): 7 addressed to each Massport board member, plus 1 letter to Governor Healey. Your name and address are already filled in on each letter.', 0, 'L');
        $pdf->Ln(0.2);
        
        // Next steps
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->MultiCell(0, 0.25, 'NEXT STEPS:', 0, 'L');
        $pdf->SetFont('helvetica', '', 11);
        $pdf->MultiCell(0, 0.25, '1. PRINT all 9 pages (color or black & white)', 0, 'L');
        $pdf->MultiCell(0, 0.25, '2. ADD A HANDWRITTEN NOTE on each letter in the space provided', 0, 'L');
        $pdf->MultiCell(0, 0.25, '3. SIGN each letter where indicated', 0, 'L');
        $pdf->MultiCell(0, 0.25, '4. ADDRESS envelopes with recipient name/title and address shown below', 0, 'L');
        $pdf->MultiCell(0, 0.25, '5. MAIL letters using first-class postage', 0, 'L');
        $pdf->Ln(0.2);
        
        // Tips
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->MultiCell(0, 0.25, 'TIPS FOR MAXIMUM IMPACT:', 0, 'L');
        $pdf->SetFont('helvetica', '', 11);
        $pdf->MultiCell(0, 0.25, '- Personal stories matter - mention why this issue affects you or your community', 0, 'L');
        $pdf->MultiCell(0, 0.25, '- Keep handwritten notes brief (2-3 sentences)', 0, 'L');
        $pdf->MultiCell(0, 0.25, '- Include the recipient\'s name and title on the envelope', 0, 'L');
        $pdf->MultiCell(0, 0.25, '- Mail within 5 days while momentum is high', 0, 'L');
        $pdf->Ln(0.2);
        
        // Mailing address - MASSPORT
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->MultiCell(0, 0.25, 'MAILING ADDRESS FOR BOARD MEMBERS (Letters 1-7):', 0, 'L');
        $pdf->SetFont('helvetica', '', 11);
        $pdf->MultiCell(0, 0.25, '[Board Member Name and Title]', 0, 'L');
        $pdf->MultiCell(0, 0.25, 'Massachusetts Port Authority', 0, 'L');
        $pdf->MultiCell(0, 0.25, 'One Harborside Drive, Suite 200S', 0, 'L');
        $pdf->MultiCell(0, 0.25, 'East Boston, MA 02128', 0, 'L');
        $pdf->Ln(0.2);
        
        // Mailing address - GOVERNOR (NEW SECTION)
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->MultiCell(0, 0.25, 'MAILING ADDRESS FOR GOVERNOR HEALEY (Letter 8):', 0, 'L');
        $pdf->SetFont('helvetica', '', 11);
        $pdf->MultiCell(0, 0.25, 'Governor Maura Healey', 0, 'L');
        $pdf->MultiCell(0, 0.25, 'Office of the Governor', 0, 'L');
        $pdf->MultiCell(0, 0.25, 'Massachusetts State House, Room 280', 0, 'L');
        $pdf->MultiCell(0, 0.25, 'Boston, MA 02133', 0, 'L');
        $pdf->Ln(0.2);
        
        // Questions
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->MultiCell(0, 0.25, 'QUESTIONS?', 0, 'L');
        $pdf->SetFont('helvetica', '', 11);
        $pdf->MultiCell(0, 0.25, 'Contact: DE-ICE HANSCOM CAMPAIGN', 0, 'L');
        $pdf->MultiCell(0, 0.25, 'Email: info@lexingtonalarm.org', 0, 'L');
        $pdf->MultiCell(0, 0.25, 'Webpage: https://lexingtonalarm.org/stop-massport-ice-flights-campaign/', 0, 'L');
        $pdf->Ln(0.3);
        
        // Closing
        $pdf->SetFont('helvetica', 'I', 11);
        $pdf->MultiCell(0, 0.25, 'Together we can protect our community\'s constitutional rights and demand transparency from Massport.', 0, 'C');
        $pdf->Ln(0.15);
        $pdf->MultiCell(0, 0.25, '- DE-ICE Hanscom Campaign Team', 0, 'C');
    }
    
    /**
     * Add board member letter page - UPDATED: removed "RE:" prefix
     */
    private function add_board_letter_page($pdf, $user_data, $full_address, $city_state_zip, $member) {
        
        $pdf->SetFont('helvetica', '', 10);
        
        // Sender info
        $pdf->MultiCell(0, 0.2, $user_data['name'], 0, 'L');
        $pdf->MultiCell(0, 0.2, $full_address, 0, 'L');
        $pdf->MultiCell(0, 0.2, $city_state_zip, 0, 'L');
        $pdf->Ln(0.15);
        
        // Date
        $pdf->MultiCell(0, 0.2, $user_data['date'], 0, 'L');
        $pdf->Ln(0.15);
        
        // Recipient
        $pdf->MultiCell(0, 0.2, $member['name'], 0, 'L');
        $pdf->MultiCell(0, 0.2, $member['title'], 0, 'L');
        $pdf->MultiCell(0, 0.2, 'Massachusetts Port Authority', 0, 'L');
        $pdf->MultiCell(0, 0.2, 'One Harborside Drive, Suite 200S, East Boston, MA 02128', 0, 'L');
        $pdf->Ln(0.15);
        
        // Salutation
        $pdf->MultiCell(0, 0.2, 'Dear ' . $member['salutation'] . ':', 0, 'L');
        $pdf->Ln(0.1);
        
        // Subject line - UPDATED: Removed "RE:" prefix
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->MultiCell(0, 0.2, 'Massport must halt ICE operations that violate due process protections at Hanscom Field', 0, 'L');
        $pdf->Ln(0.1);
        
        // Letter body
        $pdf->SetFont('helvetica', '', 10);
        $this->write_board_letter_body($pdf);
        
        // Space for handwritten note
        $pdf->Ln(0.4);
        $pdf->SetFont('helvetica', 'I', 9);
        $pdf->MultiCell(0, 0.2, '[Space for your handwritten note]', 0, 'L');
        $pdf->Ln(0.4);
        
        // Signature
        $pdf->SetFont('helvetica', '', 10);
        $pdf->MultiCell(0, 0.2, 'Sincerely,', 0, 'L');
        $pdf->Ln(0.4);
        $pdf->MultiCell(0, 0.2, $user_data['name'], 0, 'L');
    }
    
    /**
     * Add Governor Healey letter page - NEW FUNCTION
     */
    private function add_governor_letter_page($pdf, $user_data, $full_address, $city_state_zip) {
        
        $pdf->SetFont('helvetica', '', 10);
        
        // Sender info
        $pdf->MultiCell(0, 0.2, $user_data['name'], 0, 'L');
        $pdf->MultiCell(0, 0.2, $full_address, 0, 'L');
        $pdf->MultiCell(0, 0.2, $city_state_zip, 0, 'L');
        $pdf->Ln(0.15);
        
        // Date
        $pdf->MultiCell(0, 0.2, $user_data['date'], 0, 'L');
        $pdf->Ln(0.15);
        
        // Recipient - Governor
        $pdf->MultiCell(0, 0.2, 'Governor Maura Healey', 0, 'L');
        $pdf->MultiCell(0, 0.2, 'Office of the Governor', 0, 'L');
        $pdf->MultiCell(0, 0.2, 'Massachusetts State House, Room 280', 0, 'L');
        $pdf->MultiCell(0, 0.2, 'Boston, MA 02133', 0, 'L');
        $pdf->Ln(0.15);
        
        // Salutation
        $pdf->MultiCell(0, 0.2, 'Dear Governor Maura Healey:', 0, 'L');
        $pdf->Ln(0.1);
        
        // Letter body - Governor specific
        $pdf->SetFont('helvetica', '', 10);
        $this->write_governor_letter_body($pdf);
        
        // Space for handwritten note
        $pdf->Ln(0.4);
        $pdf->SetFont('helvetica', 'I', 9);
        $pdf->MultiCell(0, 0.2, '[Space for your handwritten note]', 0, 'L');
        $pdf->Ln(0.4);
        
        // Signature
        $pdf->SetFont('helvetica', '', 10);
        $pdf->MultiCell(0, 0.2, 'Sincerely,', 0, 'L');
        $pdf->Ln(0.4);
        $pdf->MultiCell(0, 0.2, $user_data['name'], 0, 'L');
    }
    
    /**
     * Write the board member letter body content - MASSACHUSETTS VERSION
     */
    private function write_board_letter_body($pdf) {
        
        $paragraphs = array(
            "Over 2,000 Massachusetts residents have been forcibly removed from our state using ICE charter flights from Hanscom Field. Their constitutional rights of due process have been recklessly disregarded by Massport. Massport must ensure its operations do not violate Massachusetts residents' due-process rights under our state constitution.",
            
            "When resident asylum seekers, holders of valid work permits, or spouses of U.S. citizens entitled to hearings before Massachusetts immigration judges are flown out of state without access to counsel or family support, their due-process rights are violated. Committee for Public Counsel Services v. ICE (D. Mass. 2020) supports this conclusion. In addition, Lunn v. Commonwealth confirms that state officials have no authority to hold people on civil immigration detainers.",
            
            "Your role as a Board Member is critical to ensuring Massport complies with Massachusetts constitutional protections. We call on you to direct Massport to:"
        );
        
        foreach ($paragraphs as $para) {
            $pdf->MultiCell(0, 0.18, $para, 0, 'L');
            $pdf->Ln(0.08);
        }
        
        // Bullets
        $bullets = array(
            "- Publish agreements and records in advance of all ICE-related air operations, using flight records obtained from Hanscom FBOs, as required under the Massachusetts Public Records Law and as requested by the Hanscom Field Advisory Commission in their letter of Sept. 17, 2025.",
            
            "- Adopt a Lunn-Compliance and Custody-Transfer Transparency Directive for Hanscom Field and all Massport facilities. This policy must prohibit state actor facilitation based solely on ICE detainers, require warrant verification for any custody transfers, and mandate public monthly reporting of ICE charter operations.",
            
            "- Require charter operators and fixed-base operators to certify their compliance with Massachusetts law, constitutional protections, and Massport's directives as a condition of using Massport property.",
            
            "- Require charter operators to certify the safety of refueling operations with chained and shackled passengers. Air safety guidance for refueling does not envision chained and shackled passengers with limited movement. You must require all charter operators boarding shackled and chained passengers to certify their safety procedures and that flight attendants are trained in evacuating these passengers. If certification is not forthcoming, you must prohibit refueling if passengers are on board.",
            
            "- Create an MOU with State Police Troop F to ensure that all State Police activities at Hanscom Field are fully compliant with Lunn and the Attorney General's guidelines prohibiting local law enforcement from assisting in ICE operations."
        );
        
        foreach ($bullets as $bullet) {
            $pdf->MultiCell(0, 0.18, $bullet, 0, 'L');
            $pdf->Ln(0.05);
        }
        
        // Closing paragraphs
        $closing = array(
            "Other actions are available to Massport under the anti-commandeering doctrine of the Tenth Amendment of the U.S. Constitution. For example, Massport has no obligation to allow State Police from Troop F to provide any service to ICE contract flights that they do not already provide to other commercial contract operations.",
            
            "Further, Massport is protected from loss of funding or other fiscal retaliation from the federal government if it changes contractor policies or withdraws special permissions granted to ICE alone. Recent injunctions and court cases - most notably Attorney General Andrea Campbell's successful lawsuit with 19 other states - resulted in a permanent injunction preventing the Department of Transportation from conditioning federal funds on cooperation or non-cooperation with ICE.",
            
            "Massport cannot hide behind federal preemption to ignore state residents' constitutional protections where it has the power to intervene. Massport has full regulatory authority to impose conditions on all operators using their facilities that ensures Massport and its contractors are not flagrantly violating our State Constitution's guarantee of due process."
        );
        
        foreach ($closing as $para) {
            $pdf->Ln(0.06);
            $pdf->MultiCell(0, 0.18, $para, 0, 'L');
        }
    }
    
    /**
     * Write the Governor Healey letter body content - NEW FUNCTION
     * Uses the text provided by Toby on December 13, 2025
     */
    private function write_governor_letter_body($pdf) {
        
        // Opening paragraphs
        $paragraphs = array(
            "Over 2,000 Massachusetts residents have been forcibly removed from our state using ICE charter flights from Hanscom Field. Their constitutional rights of due process have been recklessly disregarded by Massport. Massport must ensure its operations do not violate Massachusetts residents' due-process rights under our state constitution.",
            
            "You have the power to appoint 2 directors to the Massport Board in 2026:",
            
            "- Warren Fields, whose term expired June 2025 and has not been reappointed, and\n- Sean M. O'Brien, whose term expires in 2026.",
            
            "In addition your Secretary of the Dept. of Transportation is an ex-officio member.",
            
            "Therefore you have considerable leverage and authority to direct the Board to protect Massachusetts residents liberty interest under our State Constitution. Our communities are being terrorized by ICE's use of unconstitutional stops, searches, and refusals to allow immigrants and asylum seekers with legal agreements with the federal government or pending hearings to seek court review before their status is arbitrarily changed by ICE.",
            
            "When resident asylum seekers, holders of valid work permits, or spouses of U.S. citizens entitled to hearings before Massachusetts immigration judges are flown out of state without access to counsel or family support, their due-process rights are violated. Committee for Public Counsel Services v. ICE (D. Mass. 2020) supports this conclusion. In addition, Lunn v. Commonwealth confirms that state officials have no authority to hold people on civil immigration detainers.",
            
            "We call on you to urge Massport to:"
        );
        
        foreach ($paragraphs as $para) {
            $pdf->MultiCell(0, 0.18, $para, 0, 'L');
            $pdf->Ln(0.06);
        }
        
        // Bullets
        $bullets = array(
            "- Publish agreements and records in advance of all ICE-related air operations, using flight records obtained from Hanscom FBOs, as required under the Massachusetts Public Records Law and as requested by the Hanscom Field Advisory Commission in their letter of Sept. 17, 2025.",
            
            "- Adopt a Lunn-Compliance and Custody-Transfer Transparency Directive for Hanscom Field and all Massport facilities. This policy must prohibit state actor facilitation based solely on ICE detainers, require warrant verification for any custody transfers, and mandate public monthly reporting of ICE charter operations.",
            
            "- Require charter operators and fixed-base operators to certify their compliance with Massachusetts law, constitutional protections, and Massport's directives as a condition of using Massport property.",
            
            "- Require charter operators to certify the safety of refueling operations with chained and shackled passengers. Air safety guidance for refueling does not envision chained and shackled passengers with limited movement. You must require all charter operators boarding shackled and chained passengers to certify their safety procedures and that flight attendants are trained in evacuating these passengers. If certification is not forthcoming, you must prohibit refueling if passengers are on board.",
            
            "- Create an MOU with State Police Troop F to ensure that all State Police activities at Hanscom Field are fully compliant with Lunn and the Attorney General's guidelines prohibiting local law enforcement from assisting in ICE operations."
        );
        
        foreach ($bullets as $bullet) {
            $pdf->MultiCell(0, 0.18, $bullet, 0, 'L');
            $pdf->Ln(0.05);
        }
        
        // Closing paragraphs
        $closing = array(
            "Other actions are available to Massport under the anti-commandeering doctrine of the Tenth Amendment of the U.S. Constitution. For example, Massport has no obligation to allow State Police from Troop F to provide any service to ICE contract flights that they do not already provide to other commercial contract operations.",
            
            "Further, Massport is protected from loss of funding or other fiscal retaliation from the federal government if it changes contractor policies or withdraws special permissions granted to ICE alone. Recent injunctions and court cases - most notably Attorney General Andrea Campbell's successful lawsuit with 19 other states - resulted in a permanent injunction preventing the Department of Transportation from conditioning federal funds on cooperation or non-cooperation with ICE.",
            
            "You must prevent Massport from hiding behind federal preemption to ignore our state constitutional protections where it has the power to intervene. Massport has full regulatory authority to impose conditions on all operators using their facilities that ensures Massport and its contractors are not flagrantly violating our State Constitution's guarantee of due process.",
            
            "We expect you to use the full range of powers you have as Governor to protect residents of our state from being terrorized in their own communities."
        );
        
        foreach ($closing as $para) {
            $pdf->Ln(0.06);
            $pdf->MultiCell(0, 0.18, $para, 0, 'L');
        }
    }
    
    /**
     * Send email with PDF attachment - UPDATED for 8 letters
     */
    private function send_email($to_email, $to_name, $pdf_path) {
        
        $subject = 'Your Massport Board & Governor Letters Are Ready';
        
        $message = "Dear {$to_name},<br><br>";
        $message .= "Thank you for taking action! Your personalized letters to the Massport Board of Directors and Governor Healey are attached.<br><br>";
        $message .= "<strong>NEXT STEPS:</strong><br>";
        $message .= "1. Download and print the PDF (9 pages)<br>";
        $message .= "2. Add a brief handwritten note in the space provided on each letter<br>";
        $message .= "3. Sign each letter<br>";
        $message .= "4. Address envelopes with recipient name/title<br>";
        $message .= "5. Mail to the addresses shown below<br><br>";
        $message .= "<strong>MAILING ADDRESS FOR BOARD MEMBERS (7 letters):</strong><br>";
        $message .= "[Board Member Name and Title]<br>";
        $message .= "Massachusetts Port Authority<br>";
        $message .= "One Harborside Drive, Suite 200S<br>";
        $message .= "East Boston, MA 02128<br><br>";
        $message .= "<strong>MAILING ADDRESS FOR GOVERNOR HEALEY (1 letter):</strong><br>";
        $message .= "Governor Maura Healey<br>";
        $message .= "Office of the Governor<br>";
        $message .= "Massachusetts State House, Room 280<br>";
        $message .= "Boston, MA 02133<br><br>";
        $message .= "Your participation makes a difference!<br><br>";
        $message .= "— DE-ICE Hanscom Campaign Team<br>";
        $message .= "info@lexingtonalarm.org";
        
        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: DE-ICE Hanscom Campaign <info@lexingtonalarm.org>'
        );
        
        $attachments = array($pdf_path);
        
        wp_mail($to_email, $subject, $message, $headers, $attachments);
    }
    
    /**
     * Get TCPDF path
     */
    private function get_tcpdf_path() {
        $upload_dir = wp_upload_dir();
        return $upload_dir['basedir'] . '/tcpdf/';
    }
    
    /**
     * Install TCPDF if not present
     */
    private function install_tcpdf() {
        $tcpdf_path = $this->get_tcpdf_path();
        
        if (!file_exists($tcpdf_path)) {
            wp_mkdir_p($tcpdf_path);
            
            // Download TCPDF
            $tcpdf_url = 'https://github.com/tecnickcom/TCPDF/archive/refs/heads/main.zip';
            $zip_file = $tcpdf_path . 'tcpdf.zip';
            
            $response = wp_remote_get($tcpdf_url, array('timeout' => 300));
            
            if (!is_wp_error($response)) {
                file_put_contents($zip_file, wp_remote_retrieve_body($response));
                
                // Extract
                $zip = new ZipArchive;
                if ($zip->open($zip_file) === TRUE) {
                    $zip->extractTo($tcpdf_path);
                    $zip->close();
                    
                    // Move files from subdirectory
                    $extracted_dir = $tcpdf_path . 'TCPDF-main/';
                    if (file_exists($extracted_dir)) {
                        $this->recursive_copy($extracted_dir, $tcpdf_path);
                        $this->recursive_remove_directory($extracted_dir);
                    }
                }
                
                unlink($zip_file);
            }
        }
    }
    
    /**
     * Recursive copy helper
     */
    private function recursive_copy($src, $dst) {
        $dir = opendir($src);
        @mkdir($dst);
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    $this->recursive_copy($src . '/' . $file, $dst . '/' . $file);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }
    
    /**
     * Recursive remove directory helper
     */
    private function recursive_remove_directory($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir . "/" . $object)) {
                        $this->recursive_remove_directory($dir . "/" . $object);
                    } else {
                        unlink($dir . "/" . $object);
                    }
                }
            }
            rmdir($dir);
        }
    }
}

// Initialize the PDF generator
new Massport_PDF_Generator();
