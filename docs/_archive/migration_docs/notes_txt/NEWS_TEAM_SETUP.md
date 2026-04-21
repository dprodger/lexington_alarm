# News Team Setup Guide

## Step 1: Create User Accounts

### In WordPress Admin:
1. Go to **Users → Add New**
2. For each team member, create account with:
   - Username: firstname.lastname
   - Email: their email
   - Role: Choose based on trust level

## Step 2: User Roles Explained

### Contributors (Safest for new writers)
- ✅ Can write posts
- ✅ Can upload images
- ❌ Cannot publish (needs approval)
- ❌ Cannot edit others' posts
**Good for:** Volunteers, new members, occasional writers

### Authors (Trusted writers)
- ✅ Can write posts
- ✅ Can publish their OWN posts
- ✅ Can upload images
- ✅ Can edit their OWN posts
- ❌ Cannot edit others' posts
**Good for:** Regular news team members

### Editors (Team leaders)
- ✅ Can write and publish posts
- ✅ Can edit ANYONE's posts
- ✅ Can moderate comments
- ✅ Can manage categories
- ✅ Can approve pending posts
**Good for:** News team leaders, trusted members

## Step 3: Create Categories for Organization

### Suggested Categories:
- Featured Story (only editors can assign)
- Newsletter
- Community News
- Events
- Announcements
- Opinion/Editorial

## Step 4: Set Up Editorial Workflow

### Install "PublishPress" or "Edit Flow" Plugin (Optional)
These plugins add:
- Editorial calendar
- Custom post statuses (Draft → In Review → Approved → Published)
- Editorial comments
- Email notifications

### Or Use Built-in WordPress Workflow:
1. **Contributors** submit posts as "Pending Review"
2. **Editors** get email notifications
3. **Editors** review and publish

## Step 5: Create Guidelines Page

Create a private page with:
- Writing guidelines
- Image requirements (size, format)
- Categories to use
- How to format posts
- Contact info for help

## Step 6: Training Quick Guide

### For New Contributors:
1. Login at: http://lexingtonalarm.org/wp-admin
2. Go to Posts → Add New
3. Write your story
4. Add featured image (click "Set Featured Image")
5. Select category
6. Click "Submit for Review" (Contributors) or "Publish" (Authors)

## Step 7: Email Notifications

### To get notified of pending posts:
Add this to WPCode snippets:

```php
// Notify editors when post is pending review
function notify_editors_pending_post($post_id) {
    $post = get_post($post_id);
    if ($post->post_status === 'pending') {
        $editors = get_users(array('role' => 'editor'));
        $subject = 'New post pending review: ' . $post->post_title;
        $message = 'Please review: ' . admin_url('post.php?post=' . $post_id . '&action=edit');
        
        foreach ($editors as $editor) {
            wp_mail($editor->user_email, $subject, $message);
        }
    }
}
add_action('save_post', 'notify_editors_pending_post');
```

## Step 8: Display Authors on News Page

Add author byline to posts:

```php
// Add to your news display
echo 'By ' . get_the_author() . ' on ' . get_the_date();
```

## Security Best Practices

### DO:
- Use strong passwords
- Limit administrators (1-2 max)
- Regular backups
- Review user list monthly

### DON'T:
- Share login credentials
- Make everyone an admin
- Leave inactive accounts active

## Quick User Setup Commands

### To bulk create users (add to functions.php temporarily):
```php
$users = array(
    array('user' => 'john.doe', 'email' => 'john@example.com', 'role' => 'author'),
    array('user' => 'jane.smith', 'email' => 'jane@example.com', 'role' => 'contributor'),
);

foreach ($users as $new_user) {
    wp_create_user(
        $new_user['user'], 
        wp_generate_password(), 
        $new_user['email']
    );
    
    $user = get_user_by('email', $new_user['email']);
    $user->set_role($new_user['role']);
    
    // Send password reset email
    wp_new_user_notification($user->ID, null, 'user');
}
```

## News Page Display Settings

To show posts from all authors on News page:
- Featured story: Most recent from "Featured" category
- Archive: All posts regardless of author
- Show author name with each post
- Optional: Filter by author

---

This setup allows multiple people to contribute while maintaining quality control!