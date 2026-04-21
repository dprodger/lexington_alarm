<?php
/**
 * Rhode Island Board Letters PDF Generator
 * Integrates with WPForms to generate 15-page PDF with 7 personalized board member letters
 * 
 * COPIED FROM: Massport PDF Generator
 * MODIFIED FOR: Rhode Island Campaign
 * 
 * Installation: Add to your theme's functions.php or create as a plugin
 * Requirements: TCPDF library (will be included)
 * 
 * @version 1.0
 * @author Claude AI
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Main class for Rhode Island PDF generation
 */
class Rhode_Island_PDF_Generator {
    
    private $form_id = 1657;  // RI Board Letters form
    
    public function __construct() {
        // Hook into WPForms submission
        add_action('wpforms_process_complete_' . $this->form_id, array($this, 'generate_and_send_pdf'), 10, 4);
    }
    
    /**
     * Main handler for form submission
     */
    public function generate_and_send_pdf($fields, $entry, $form_data, $entry_id) {
        
        // Extract form data
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
        $city_state_zip = $user_data['city'] . ', RI ' . $user_data['zip'];  // Changed MA to RI
        
        try {
            // Generate PDF
            $pdf_path = $this->create_pdf($user_data, $full_address, $city_state_zip);
            
            // Send email with PDF attachment
            $this->send_email($user_data['email'], $user_data['name'], $pdf_path);
            
            // Clean up temporary file
            @unlink($pdf_path);
            
        } catch (Exception $e) {
            // Log error
            error_log('Rhode Island PDF Generator Error: ' . $e->getMessage());
        }
    }
    
    /**
     * Create the 15-page PDF
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
        $pdf->SetCreator('DE-ICE Hanscom Campaign - Rhode Island');
        $pdf->SetAuthor($user_data['name']);
        $pdf->SetTitle('Massport Board Letters - ' . $user_data['name']);
        $pdf->SetSubject('Letters to Massport Board of Directors from Rhode Island Resident');
        
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
        
        // Board members
        $board_members = array(
            array('name' => 'Patricia A. Jacobs', 'title' => 'Chair, Board of Directors', 'salutation' => 'Ms. Jacobs'),
            array('name' => 'Sean M. O\'Brien', 'title' => 'Vice Chair, Board of Directors', 'salutation' => 'Mr. O\'Brien'),
            array('name' => 'Lewis Evangelidis', 'title' => 'Board Member', 'salutation' => 'Mr. Evangelidis'),
            array('name' => 'Pamela Everhart', 'title' => 'Board Member', 'salutation' => 'Ms. Everhart'),
            array('name' => 'Warren Fields', 'title' => 'Board Member', 'salutation' => 'Mr. Fields'),
            array('name' => 'John Nucci', 'title' => 'Board Member', 'salutation' => 'Mr. Nucci'),
            array('name' => 'Phillip Eng', 'title' => 'Secretary/Ex Officio (MassDOT)', 'salutation' => 'Mr. Eng')
        );
        
        // PAGES 2-15: Seven letters (2 pages each)
        foreach ($board_members as $member) {
            $pdf->AddPage();
            $this->add_letter_page($pdf, $user_data, $full_address, $city_state_zip, $member);
        }
        
        // Save to temporary file
        $upload_dir = wp_upload_dir();
        $pdf_filename = 'ri-massport-letters-' . sanitize_file_name($user_data['name']) . '-' . time() . '.pdf';
        $pdf_path = $upload_dir['path'] . '/' . $pdf_filename;
        
        $pdf->Output($pdf_path, 'F');
        
        return $pdf_path;
    }
    
    /**
     * Add instructions page (Page 1)
     */
    private function add_instructions_page($pdf, $user_name) {
        
        // Title
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 0.4, 'INSTRUCTIONS FOR YOUR MASSPORT BOARD LETTERS', 0, 1, 'C');
        $pdf->Ln(0.3);
        
        // Greeting
        $pdf->SetFont('helvetica', '', 11);
        $pdf->MultiCell(0, 0.25, "Dear {$user_name},", 0, 'L');
        $pdf->Ln(0.15);
        
        // Thank you paragraph
        $pdf->MultiCell(0, 0.25, "Thank you for taking action to protect Rhode Island residents' constitutional rights! You're about to mail 7 personalized letters to each member of the Massport Board of Directors.", 0, 'L');
        $pdf->Ln(0.25);
        
        // What you've received
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->MultiCell(0, 0.25, 'WHAT YOU\'VE RECEIVED:', 0, 'L');
        $pdf->SetFont('helvetica', '', 11);
        $pdf->MultiCell(0, 0.25, 'This PDF contains 7 letters (pages 2-8) addressed to each board member. Your name and address are already filled in on each letter.', 0, 'L');
        $pdf->Ln(0.25);
        
        // Next steps
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->MultiCell(0, 0.25, 'NEXT STEPS:', 0, 'L');
        $pdf->SetFont('helvetica', '', 11);
        $pdf->MultiCell(0, 0.25, '1. PRINT all 8 pages (color or black & white)', 0, 'L');
        $pdf->MultiCell(0, 0.25, '2. ADD A HANDWRITTEN NOTE on each letter in the space provided', 0, 'L');
        $pdf->MultiCell(0, 0.25, '3. SIGN each letter where indicated', 0, 'L');
        $pdf->MultiCell(0, 0.25, '4. MAIL letters using the address shown below', 0, 'L');
        $pdf->Ln(0.25);
        
        // Tips
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->MultiCell(0, 0.25, 'TIPS FOR MAXIMUM IMPACT:', 0, 'L');
        $pdf->SetFont('helvetica', '', 11);
        $pdf->MultiCell(0, 0.25, '• Personal stories matter - mention why this issue affects you or your community', 0, 'L');
        $pdf->MultiCell(0, 0.25, '• Keep handwritten notes brief (2-3 sentences)', 0, 'L');
        $pdf->MultiCell(0, 0.25, '• Use first-class postage', 0, 'L');
        $pdf->MultiCell(0, 0.25, '• Mail within 5 days while momentum is high', 0, 'L');
        $pdf->Ln(0.25);
        
        // Mailing address
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->MultiCell(0, 0.25, 'MAILING ADDRESS (same for all 7 letters):', 0, 'L');
        $pdf->SetFont('helvetica', '', 11);
        $pdf->MultiCell(0, 0.25, 'Massachusetts Port Authority', 0, 'L');
        $pdf->MultiCell(0, 0.25, 'One Harborside Drive, Suite 200S', 0, 'L');
        $pdf->MultiCell(0, 0.25, 'East Boston, MA 02128', 0, 'L');
        $pdf->Ln(0.25);
        
        // Questions
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->MultiCell(0, 0.25, 'QUESTIONS?', 0, 'L');
        $pdf->SetFont('helvetica', '', 11);
        $pdf->MultiCell(0, 0.25, 'Contact: DE-ICE HANSCOM CAMPAIGN', 0, 'L');
        $pdf->MultiCell(0, 0.25, 'Email: info@lexingtonalarm.org', 0, 'L');
        $pdf->MultiCell(0, 0.25, 'Webpage: https://lexingtonalarm.org/rhode-island-stop-massport-ice-flights/', 0, 'L');
        $pdf->Ln(0.4);
        
        // Closing
        $pdf->SetFont('helvetica', 'I', 11);
        $pdf->MultiCell(0, 0.25, 'Together we can protect our community\'s constitutional rights and demand transparency from Massport.', 0, 'C');
        $pdf->Ln(0.15);
        $pdf->MultiCell(0, 0.25, '- DE-ICE Hanscom Campaign Team', 0, 'C');
    }
    
    /**
     * Add individual letter page
     */
    private function add_letter_page($pdf, $user_data, $full_address, $city_state_zip, $member) {
        
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
        
        // RE line
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->MultiCell(0, 0.2, 'Massport must halt ICE operations that violate due process protections at Hanscom Field', 0, 'L');
        $pdf->Ln(0.1);
        
        // Letter body
        $pdf->SetFont('helvetica', '', 10);
        
        $this->write_letter_body($pdf);
        
        // Space for handwritten note
        $pdf->Ln(0.5);
        $pdf->SetFont('helvetica', 'I', 9);
        $pdf->MultiCell(0, 0.2, '[Space for your handwritten note]', 0, 'L');
        $pdf->Ln(0.5);
        
        // Signature
        $pdf->SetFont('helvetica', '', 10);
        $pdf->MultiCell(0, 0.2, 'Sincerely,', 0, 'L');
        $pdf->Ln(0.4);
        $pdf->MultiCell(0, 0.2, $user_data['name'], 0, 'L');
    }
    
    /**
     * Write the letter body content - RHODE ISLAND VERSION
     */
    private function write_letter_body($pdf) {
        
        $paragraphs = array(
            "Over 1,000 Rhode Island residents have been forcibly removed from our state using ICE charter flights from Hanscom Field Airport. Transfers are a tactic used by ICE to instill terror, destroy due process, and separate Rhode Islanders from their families, lawyers, and local resources, oftentimes including life-saving medications. Rhode Island resident's constitutional rights of due process have been recklessly disregarded by Massport. The regional ICE office initiates transfers for residents throughout the New England area, so Massport must ensure its operations at Hanscom do not violate Rhode Island and all New England residents' due-process rights under Massachusetts' state constitution.",
            
            "When Rhode Islanders are transferred out of state in order to deny them life-saving medical care, their human rights are violated. When resident asylum seekers, holders of valid work permits, or spouses of U.S. citizens entitled to hearings before Rhode Island immigration judges are flown out of state without access to counsel or family support, their due-process rights are violated. Committee for Public Counsel Services v. ICE (D. Mass. 2020) supports this conclusion. In addition, Lunn v. Commonwealth confirms that state officials have no authority to hold people on civil immigration detainers.",
            
            "Our State Constitutional protections mean Massport needs to:"
        );
        
        foreach ($paragraphs as $para) {
            $pdf->MultiCell(0, 0.18, $para, 0, 'L');
            $pdf->Ln(0.1);
        }
        
        // Bullets - RHODE ISLAND VERSION
        $bullets = array(
            "- Adopt a Lunn-Compliance and Custody-Transfer Transparency Directive for Hanscom Field and all Massport facilities. This policy must prohibit state actor facilitation based solely on ICE detainers, require warrant verification for any custody transfers, and mandate public monthly reporting of ICE charter operations.",
            
            "- Require charter operators and fixed-base operators to certify their compliance with Massachusetts law, constitutional protections, and Massport's directives as a condition of using Massport property.",
            
            "- Create an MOU with State Police Troop F to ensure that all State Police activities at Hanscom Field are fully compliant with Lunn and the Attorney General's guidelines prohibiting local law enforcement from assisting in ICE operations.",
            
            "- Require charter operators to certify the safety of refueling operations with chained and shackled passengers. Air safety guidance for refueling does not envision chained and shackled passengers with limited movement. You must require all charter operators boarding shackled and chained passengers to certify their safety procedures and that flight attendants are trained in evacuating these passengers. If certification is not forthcoming, you must prohibit refueling if passengers are on board.",
            
            "- Publish agreements and records in advance of all ICE-related air operations, using flight records obtained from Hanscom FBOs, as required under the Massachusetts Public Records Law and as requested by the Hanscom Field Advisory Commission in their letter of Sept. 17, 2025."
        );
        
        foreach ($bullets as $bullet) {
            $pdf->MultiCell(0, 0.18, $bullet, 0, 'L');
            $pdf->Ln(0.05);
        }
        
        // Closing paragraphs - RHODE ISLAND VERSION
        $closing = array(
            "Other actions are available to Massport under the anti-commandeering doctrine of the Tenth Amendment of the U.S. Constitution. For example, Massport has no obligation to allow State Police from Troop F to provide any service to ICE contract flights that they do not already provide to other commercial contract operations.",
            
            "Further, Massport is protected from loss of funding or other fiscal retaliation from the federal government if it changes contractor policies or withdraws special permissions granted to ICE alone. Recent injunctions and court cases - most notably Attorney General Andrea Campbell's successful lawsuit with 19 other states - resulted in a permanent injunction preventing the Department of Transportation from conditioning federal funds on cooperation or non-cooperation with ICE.",
            
            "Massport cannot hide behind federal preemption to ignore New England residents' constitutional protections where it has the power to intervene. Massport has full regulatory authority to impose conditions on all operators using their facilities that ensures Massport and its contractors are not helping ICE to commit human rights violations, and are not flagrantly violating Massachusetts State Constitution's guarantee of due process.",
            
            "STOP ICE ACTIVITY AT HANSCOM!!!"
        );
        
        foreach ($closing as $para) {
            $pdf->Ln(0.08);
            $pdf->MultiCell(0, 0.18, $para, 0, 'L');
        }
    }
    
    /**
     * Send email with PDF attachment - RHODE ISLAND VERSION
     */
    private function send_email($to_email, $to_name, $pdf_path) {
        
        $subject = 'Your Massport Board Letters Are Ready - Rhode Island Campaign';
        
        $message = "Dear {$to_name},<br><br>";
        $message .= "Thank you for taking action as a Rhode Island resident! Your personalized letters to the Massport Board of Directors are attached.<br><br>";
        $message .= "<strong>NEXT STEPS:</strong><br>";
        $message .= "1. Download and print the PDF (15 pages)<br>";
        $message .= "2. Add a brief handwritten note in the space provided on each letter<br>";
        $message .= "3. Sign each letter<br>";
        $message .= "4. Mail to the addresses shown<br><br>";
        $message .= "<strong>MAILING ADDRESS (same for all 7 letters):</strong><br>";
        $message .= "Massachusetts Port Authority<br>";
        $message .= "One Harborside Drive, Suite 200S<br>";
        $message .= "East Boston, MA 02128<br><br>";
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
new Rhode_Island_PDF_Generator();
