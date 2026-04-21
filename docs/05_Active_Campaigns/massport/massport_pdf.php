<?php
/**
 * Massport Board Letters PDF Generator
 * Integrates with WPForms to generate 15-page PDF with 7 personalized board member letters
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
 * Main class for Massport PDF generation
 */
class Massport_PDF_Generator {
    
    private $form_id = 1401;
    
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
        $pdf->SetCreator('DE-ICE Hanscom Campaign');
        $pdf->SetAuthor($user_data['name']);
        $pdf->SetTitle('Massport Board Letters - ' . $user_data['name']);
        $pdf->SetSubject('Letters to Massport Board of Directors');
        
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
            array('name' => 'Monica G. Tibbits-Nutt', 'title' => 'Secretary/Ex Officio (MassDOT)', 'salutation' => 'Ms. Tibbits-Nutt')
        );
        
        // PAGES 2-15: Seven letters (2 pages each)
        foreach ($board_members as $member) {
            $pdf->AddPage();
            $this->add_letter_page($pdf, $user_data, $full_address, $city_state_zip, $member);
        }
        
        // Save to temporary file
        $upload_dir = wp_upload_dir();
        $pdf_filename = 'massport-letters-' . sanitize_file_name($user_data['name']) . '-' . time() . '.pdf';
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
        $pdf->Cell(0, 0.3, 'INSTRUCTIONS FOR YOUR MASSPORT BOARD LETTERS', 0, 1, 'C');
        $pdf->Ln(0.2);
        
        // Greeting
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Write(0.2, "Dear {$user_name},");
        $pdf->Ln(0.15);
        
        // Thank you paragraph
        $pdf->Write(0.2, "Thank you for taking action to protect Massachusetts residents' constitutional rights! You're about to mail 7 personalized letters to each member of the Massport Board of Directors.");
        $pdf->Ln(0.15);
        
        // What you've received
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Write(0.2, 'WHAT YOU\'VE RECEIVED:');
        $pdf->Ln(0.1);
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Write(0.2, 'This PDF contains 7 letters (pages 2-15) addressed to each board member. Your name and address are already filled in on each letter.');
        $pdf->Ln(0.15);
        
        // Next steps
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Write(0.2, 'NEXT STEPS:');
        $pdf->Ln(0.1);
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Write(0.2, '1. PRINT all 15 pages (color or black & white)');
        $pdf->Ln(0.05);
        $pdf->Write(0.2, '2. ADD A HANDWRITTEN NOTE on each letter in the space provided above your signature');
        $pdf->Ln(0.05);
        $pdf->Write(0.2, '3. SIGN each letter where indicated');
        $pdf->Ln(0.05);
        $pdf->Write(0.2, '4. MAIL letters using the addresses shown on each page');
        $pdf->Ln(0.15);
        
        // Tips
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Write(0.2, 'TIPS FOR MAXIMUM IMPACT:');
        $pdf->Ln(0.1);
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Write(0.2, '• Personal stories matter — mention why this issue affects you or your community');
        $pdf->Ln(0.05);
        $pdf->Write(0.2, '• Keep handwritten notes brief (2-3 sentences)');
        $pdf->Ln(0.05);
        $pdf->Write(0.2, '• Use first-class postage');
        $pdf->Ln(0.05);
        $pdf->Write(0.2, '• Mail within 5 days while momentum is high');
        $pdf->Ln(0.15);
        
        // Mailing address
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Write(0.2, 'MAILING ADDRESS (same for all 7 letters):');
        $pdf->Ln(0.1);
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Write(0.2, 'Massachusetts Port Authority');
        $pdf->Ln(0.05);
        $pdf->Write(0.2, 'One Harborside Drive, Suite 200S');
        $pdf->Ln(0.05);
        $pdf->Write(0.2, 'East Boston, MA 02128');
        $pdf->Ln(0.2);
        
        // Questions
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Write(0.2, 'QUESTIONS?');
        $pdf->Ln(0.1);
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Write(0.2, 'Contact: DE-ICE HANSCOM CAMPAIGN');
        $pdf->Ln(0.05);
        $pdf->Write(0.2, 'Email: info@lexingtonalarm.org');
        $pdf->Ln(0.05);
        $pdf->Write(0.2, 'Webpage: https://lexingtonalarm.org/stop-massport-ice-flights-campaign/');
        $pdf->Ln(0.3);
        
        // Closing
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(0, 0.2, 'Together we can protect our community\'s constitutional rights and demand transparency from Massport.', 0, 1, 'C');
        $pdf->Ln(0.1);
        $pdf->SetFont('helvetica', 'I', 12);
        $pdf->Cell(0, 0.2, '— DE-ICE Hanscom Campaign Team', 0, 1, 'C');
    }
    
    /**
     * Add individual letter page
     */
    private function add_letter_page($pdf, $user_data, $full_address, $city_state_zip, $member) {
        
        $pdf->SetFont('helvetica', '', 12);
        
        // Sender info
        $pdf->Write(0.2, $user_data['name']);
        $pdf->Ln(0.05);
        $pdf->Write(0.2, $full_address);
        $pdf->Ln(0.05);
        $pdf->Write(0.2, $city_state_zip);
        $pdf->Ln(0.1);
        
        // Date
        $pdf->Write(0.2, $user_data['date']);
        $pdf->Ln(0.1);
        
        // Recipient
        $pdf->Write(0.2, $member['name']);
        $pdf->Ln(0.05);
        $pdf->Write(0.2, $member['title']);
        $pdf->Ln(0.05);
        $pdf->Write(0.2, 'Massachusetts Port Authority');
        $pdf->Ln(0.05);
        $pdf->Write(0.2, 'One Harborside Drive, Suite 200S, East Boston, MA 02128');
        $pdf->Ln(0.1);
        
        // Salutation
        $pdf->Write(0.2, 'Dear ' . $member['salutation'] . ':');
        $pdf->Ln(0.1);
        
        // RE line
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Write(0.2, 'RE: Massport must halt ICE operations that violate due process protections at Hanscom Field');
        $pdf->Ln(0.1);
        
        // Letter body
        $pdf->SetFont('helvetica', '', 12);
        
        $this->write_letter_body($pdf);
        
        // Space for handwritten note (6 blank lines)
        $pdf->Ln(0.3);
        $pdf->Ln(0.3);
        $pdf->Ln(0.3);
        $pdf->Ln(0.3);
        $pdf->Ln(0.3);
        $pdf->Ln(0.3);
        
        // Signature
        $pdf->Write(0.2, 'Sincerely,');
    }
    
    /**
     * Write the letter body content
     */
    private function write_letter_body($pdf) {
        
        $paragraphs = array(
            "Over 2,000 Massachusetts residents have been forcibly removed from our state using ICE charter flights from Hanscom Field. Their constitutional rights of due process have been recklessly disregarded by Massport. I demand that Massport ensure its operations do not violate Massachusetts residents' due process rights under our State Constitution.",
            
            "When resident asylum seekers, holders of valid work permits, or spouses of U.S. citizens entitled to hearings before Massachusetts immigration judges are flown out of state without access to counsel or family support, their due-process rights are violated. Committee for Public Counsel Services v. ICE (D. Mass. 2020) supports this. Lunn v. Commonwealth confirms state officials have no authority to hold people on civil immigration detainers.",
            
            "I demand Massport:"
        );
        
        foreach ($paragraphs as $para) {
            $pdf->Write(0.2, $para);
            $pdf->Ln(0.1);
        }
        
        // Bullets
        $bullets = array(
            "• Publish agreements and records of all ICE-related air operations using flight records obtained from Hanscom FBOs, as required under the Massachusetts Public Records Law and requested by the Hanscom Field Advisory Commission in their letter of Sept. 17, 2025.",
            
            "• Adopt a Lunn-Compliance and Custody-Transfer Transparency Directive for Hanscom Field. This policy must prohibit state-actor facilitation based solely on ICE detainers, require warrant verification for any custody transfers, and mandate monthly reporting of ICE charter operations.",
            
            "• Require charter operators and fixed-base operators to certify compliance with Massachusetts law, constitutional protections, and Massport's Directives as a condition of using Massport property.",
            
            "• Require charter operators to certify safety of refueling operations with chained and shackled passengers. Air safety guidance does not envision passengers with limited movement. Require certification of safety procedures and trained flight attendants. If certification is not forthcoming, prohibit refueling if passengers are aboard.",
            
            "• Create an MOU with State Police Troop F to ensure all State Police activities at Hanscom Field are fully compliant with Lunn and Attorney General guidelines prohibiting local law enforcement from assisting ICE."
        );
        
        foreach ($bullets as $bullet) {
            $pdf->Write(0.2, $bullet);
            $pdf->Ln(0.08);
        }
        
        // Closing paragraphs
        $closing = array(
            "Other actions are available under the anti-commandeering Doctrine of the 10th Amendment. Massport has no obligation to allow State Police from Troop F to provide any service to ICE Contract flights not already provided to other commercial operations.",
            
            "Massport is protected from loss of funding or federal retaliation if they change contractor policies or withdraw special permissions granted to ICE. Recent injunctions and court cases—including Attorney General Andrea Campbell's lawsuit with 19 other states—resulted in a permanent injunction preventing the Department of Transportation from conditioning federal funds on cooperation or non-cooperation with ICE.",
            
            "Massachusetts residents deserve transparency about how our public transportation infrastructure is used. We have a right to demand Massport desist from activities that materially harm citizens of the Commonwealth.",
            
            "Your role as a Board Member is critical to making sure residents of Massachusetts are not harmed through actions illegal under the state constitution by ICE and the Dept. of Homeland Security. Massport cannot hide behind federal preemption to ignore residents' constitutional protections where you have the power to intervene. Massport has full regulatory authority to impose conditions on all operators that ensure Massport and its contractors are not violating our guarantee of due process."
        );
        
        foreach ($closing as $para) {
            $pdf->Ln(0.1);
            $pdf->Write(0.2, $para);
        }
    }
    
    /**
     * Send email with PDF attachment
     */
    private function send_email($to_email, $to_name, $pdf_path) {
        
        $subject = 'Your Massport Board Letters Are Ready';
        
        $message = "Dear {$to_name},<br><br>";
        $message .= "Thank you for taking action! Your personalized letters to the Massport Board of Directors are attached.<br><br>";
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
new Massport_PDF_Generator();