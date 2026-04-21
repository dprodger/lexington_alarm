# How to Add Email Notifications to the News System

## Overview
You need to make TWO changes to your "Front End News System" snippet in WPCode:
1. Add a new notification function (paste it anywhere)
2. Add ONE line to the existing submission function

---

## Step 1: Open the Snippet

1. Go to **WPCode → Code Snippets**
2. Find **"Front End News System"**
3. Click to edit it

---

## Step 2: Add the Notification Function

Copy this entire block and paste it at the VERY END of the snippet, right before the closing line (if there is one):

```php
// EMAIL NOTIFICATIONS FOR NEWS TEAM
function la_notify_news_team($post_id, $post_status, $submitter_name) {
    // NEWS TEAM EMAILS - Update these addresses!
    $news_team_emails = array(
        'christine@example.com',  // Replace with real email
        'steve@example.com',      // Replace with real email
        // Add more as needed
    );
    
    $post = get_post($post_id);
    $post_title = $post->post_title;
    
    if ($post_status === 'pending') {
        $subject = '[Lexington Alarm] NEEDS REVIEW: ' . $post_title;
        $status_message = "This story needs approval before publishing.";
        $review_link = admin_url('edit.php?post_status=pending&post_type=post');
    } else {
        $subject = '[Lexington Alarm] New Story Published: ' . $post_title;
        $status_message = "This story is now live.";
        $review_link = get_permalink($post_id);
    }
    
    $message = "
A new story has been submitted to Lexington Alarm.

Title: {$post_title}
Submitted by: {$submitter_name}
Status: " . ucfirst($post_status) . "

{$status_message}

View/Review: {$review_link}

---
Lexington Alarm News System
";
    
    $headers = array('Content-Type: text/plain; charset=UTF-8');
    
    foreach ($news_team_emails as $email) {
        wp_mail($email, $subject, $message, $headers);
    }
}
```

---

## Step 3: Find This Section in the Existing Code

Look for the function called `la_process_news_submission`. Inside it, near the bottom, you'll see these lines:

```php
    // Redirect to prevent resubmission
    wp_redirect(add_query_arg('news_submitted', 'success', get_permalink()));
    exit;
}
```

---

## Step 4: Add ONE Line

Add this single line RIGHT BEFORE the `// Redirect` comment:

```php
    la_notify_news_team($post_id, $post_status, wp_get_current_user()->display_name);
```

So it looks like this AFTER your edit:

```php
    la_notify_news_team($post_id, $post_status, wp_get_current_user()->display_name);
    
    // Redirect to prevent resubmission
    wp_redirect(add_query_arg('news_submitted', 'success', get_permalink()));
    exit;
}
```

---

## Step 5: Update Email Addresses

Go back to the notification function you added in Step 2 and replace the example emails with real ones:

```php
    $news_team_emails = array(
        'christine@actualemail.com',
        'steve@actualemail.com',
    );
```

---

## Step 6: Save and Test

1. Click **Update** to save the snippet
2. Go to the news portal and submit a test story
3. Check that team members receive the notification email

---

## Quick Summary

| What | Where |
|------|-------|
| New `la_notify_news_team` function | Paste at END of snippet |
| One-line function call | Add BEFORE the `wp_redirect` line |
| Email addresses | Update in the `$news_team_emails` array |
