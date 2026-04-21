/**
 * Lexington Alarm News Submission System
 * With Auto-Backup Feature, Byline Override, Inline Featured Text Editing,
 * and Email Notifications
 * 
 * Version: 2.1 - December 2024
 * 
 * CHANGELOG:
 * v2.1 (Dec 22, 2024)
 * - Added la_notify_news_team() function for email notifications
 * - Fixed $post_status variable in la_handle_news_submission()
 * - Team receives email when any story is submitted (pending or published)
 * 
 * v2.0 (Dec 2024)
 * - Auto-backup drafts to localStorage
 * - Custom byline override for reprints
 * - Inline featured text editing
 */

// Enable featured image support
function enable_featured_images() {
    add_theme_support('post-thumbnails');
    add_image_size('news-featured', 600, 400, true);
    add_image_size('news-thumbnail', 300, 200, true);
}
add_action('after_setup_theme', 'enable_featured_images');

// =============================================
// EMAIL NOTIFICATIONS FOR NEWS TEAM
// =============================================
function la_notify_news_team($post_id, $post_status, $submitter_name) {
    // NEWS TEAM EMAIL ADDRESSES
    $news_team_emails = array(
        'achristinedall@gmail.com',
        'ssinger71@pm.me',
        'tsackton@gmail.com',
    );
    
    $post = get_post($post_id);
    $post_title = $post->post_title;
    
    // Determine email subject based on post status
    if ($post_status === 'pending') {
        $subject = '[Lexington Alarm] NEW STORY NEEDS REVIEW: ' . $post_title;
        $status_message = "This story has been submitted for review and needs approval before publishing.";
        $review_link = admin_url('edit.php?post_status=pending&post_type=post');
        $action_text = "Review and approve this story:";
    } else {
        $subject = '[Lexington Alarm] New Story Published: ' . $post_title;
        $status_message = "This story has been published and is now live on the site.";
        $review_link = get_permalink($post_id);
        $action_text = "View the published story:";
    }
    
    // Build email message
    $message = "
A new story has been submitted to Lexington Alarm News.

STORY DETAILS:
━━━━━━━━━━━━━━━━━━━━━━━
Title: {$post_title}
Submitted by: {$submitter_name}
Status: " . ucfirst($post_status) . "
Date: " . current_time('F j, Y \a\t g:i a') . "
━━━━━━━━━━━━━━━━━━━━━━━

{$status_message}

{$action_text}
{$review_link}

---
Lexington Alarm News System
https://lexingtonalarm.org/news/
";
    
    // Set email headers
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: Lexington Alarm <info@lexingtonalarm.org>'
    );
    
    // Send to each team member
    foreach ($news_team_emails as $email) {
        wp_mail($email, $subject, $message, $headers);
    }
}

// =============================================
// REST OF CODE - See WPCode snippet for full implementation
// =============================================
// 
// Key functions included:
// - la_custom_login_form() - Login shortcode [la_news_login]
// - la_show_post_form() - Submission form for logged-in users
// - la_handle_news_submission() - Process form submission + send notifications
// - la_handle_bulk_delete() - Bulk delete handler
// - la_handle_category_change() - AJAX category switcher
// - la_handle_excerpt_update() - AJAX inline excerpt editing
// - la_get_byline() / la_filter_author_name() - Custom byline system
//
// Full code is in WPCode snippet: "Front End News System"
