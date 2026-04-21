<?php
/**
 * Front-End News Submission System
 * Add this to WPCode as a new snippet
 */

// 1. Create a custom login page shortcode
function la_custom_login_form() {
    if (is_user_logged_in()) {
        return la_show_post_form();
    }
    
    ob_start();
    ?>
    <div class="la-login-form" style="max-width: 400px; margin: 0 auto; padding: 20px; border: 2px solid #044f9d;">
        <h2 style="color: #c3202e;">News Team Login</h2>
        <?php
        wp_login_form(array(
            'redirect' => get_permalink(),
            'form_id' => 'la-loginform',
            'label_username' => 'Username',
            'label_password' => 'Password',
            'label_log_in' => 'Login',
            'remember' => true
        ));
        ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('la_news_login', 'la_custom_login_form');

// 2. Show post form for logged-in users
function la_show_post_form() {
    // Check if user can publish posts
    if (!current_user_can('publish_posts') && !current_user_can('edit_posts')) {
        return '<p>You do not have permission to submit news stories.</p>';
    }
    
    ob_start();
    ?>
    <div class="la-post-form">
        <div style="text-align: right; margin-bottom: 20px;">
            Welcome, <?php echo wp_get_current_user()->display_name; ?> | 
            <a href="<?php echo wp_logout_url(get_permalink()); ?>">Logout</a>
        </div>
        
        <h2 style="color: #c3202e;">Submit News Story</h2>
        
        <form id="la-news-form" method="post" enctype="multipart/form-data">
            <?php wp_nonce_field('la_submit_news', 'la_news_nonce'); ?>
            
            <div class="form-group" style="margin-bottom: 20px;">
                <label for="post_title" style="display: block; font-weight: bold; margin-bottom: 5px;">
                    Story Title *
                </label>
                <input type="text" name="post_title" id="post_title" required
                       style="width: 100%; padding: 10px; border: 2px solid #044f9d;">
            </div>
            
            <div class="form-group" style="margin-bottom: 20px;">
                <label for="post_image" style="display: block; font-weight: bold; margin-bottom: 5px;">
                    Featured Image
                </label>
                <input type="file" name="post_image" id="post_image" accept="image/*">
                <div id="image-preview" style="margin-top: 10px;"></div>
            </div>
            
            <div class="form-group" style="margin-bottom: 20px;">
                <label for="post_excerpt" style="display: block; font-weight: bold; margin-bottom: 5px;">
                    Summary (appears on news page)
                </label>
                <textarea name="post_excerpt" id="post_excerpt" rows="3"
                          style="width: 100%; padding: 10px; border: 2px solid #044f9d;"></textarea>
            </div>
            
            <div class="form-group" style="margin-bottom: 20px;">
                <label for="post_content" style="display: block; font-weight: bold; margin-bottom: 5px;">
                    Full Story *
                </label>
                <textarea name="post_content" id="post_content" rows="15" required
                          style="width: 100%; padding: 10px; border: 2px solid #044f9d;"></textarea>
            </div>
            
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;">
                    Story Type
                </label>
                <label style="margin-right: 20px;">
                    <input type="checkbox" name="featured_story" value="1">
                    Feature this story (appears at top of news page)
                </label>
            </div>
            
            <?php if (current_user_can('publish_posts')) : ?>
                <button type="submit" name="action" value="publish"
                        style="background: #c3202e; color: white; padding: 15px 30px; 
                               border: none; font-size: 1.1em; font-weight: bold; cursor: pointer;">
                    PUBLISH STORY
                </button>
            <?php else : ?>
                <button type="submit" name="action" value="draft"
                        style="background: #044f9d; color: white; padding: 15px 30px; 
                               border: none; font-size: 1.1em; font-weight: bold; cursor: pointer;">
                    SUBMIT FOR REVIEW
                </button>
            <?php endif; ?>
        </form>
        
        <?php if (current_user_can('edit_posts')) : ?>
        <hr style="margin: 40px 0;">
        <h3>Recent Posts (click to edit)</h3>
        <?php
        $recent_posts = get_posts(array(
            'numberposts' => 10,
            'post_status' => array('publish', 'pending', 'draft')
        ));
        
        foreach ($recent_posts as $post) {
            echo '<div style="margin: 10px 0; padding: 10px; border: 1px solid #ddd;">';
            echo '<strong>' . esc_html($post->post_title) . '</strong> ';
            echo '(' . $post->post_status . ') ';
            echo '<a href="' . get_edit_post_link($post->ID) . '">Edit</a>';
            echo '</div>';
        }
        ?>
        <?php endif; ?>
    </div>
    
    <script>
    // Image preview
    document.getElementById('post_image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image-preview').innerHTML = 
                    '<img src="' + e.target.result + '" style="max-width: 300px; height: auto;">';
            };
            reader.readAsDataURL(file);
        }
    });
    </script>
    <?php
    return ob_get_clean();
}

// 3. Handle form submission
function la_handle_news_submission() {
    if (!isset($_POST['la_news_nonce']) || 
        !wp_verify_nonce($_POST['la_news_nonce'], 'la_submit_news')) {
        return;
    }
    
    if (!is_user_logged_in()) {
        return;
    }
    
    $post_data = array(
        'post_title' => sanitize_text_field($_POST['post_title']),
        'post_content' => wp_kses_post($_POST['post_content']),
        'post_excerpt' => sanitize_textarea_field($_POST['post_excerpt']),
        'post_status' => current_user_can('publish_posts') ? 'publish' : 'pending',
        'post_author' => get_current_user_id(),
        'post_type' => 'post',
        'post_category' => array(get_cat_ID('News'))
    );
    
    // Create the post
    $post_id = wp_insert_post($post_data);
    
    if ($post_id && !is_wp_error($post_id)) {
        
        // Handle featured story
        if (isset($_POST['featured_story']) && $_POST['featured_story'] == '1') {
            $featured_cat = get_cat_ID('Featured Story');
            if ($featured_cat) {
                wp_set_post_categories($post_id, array($featured_cat), true);
            }
        }
        
        // Handle image upload
        if (!empty($_FILES['post_image']['name'])) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            require_once(ABSPATH . 'wp-admin/includes/media.php');
            
            $attachment_id = media_handle_upload('post_image', $post_id);
            if (!is_wp_error($attachment_id)) {
                set_post_thumbnail($post_id, $attachment_id);
            }
        }
        
        // Redirect with success message
        $redirect_url = add_query_arg('news_submitted', 'success', get_permalink());
        wp_redirect($redirect_url);
        exit;
    }
}
add_action('init', 'la_handle_news_submission');

// 4. Hide admin bar for non-admins
function la_hide_admin_bar() {
    if (!current_user_can('manage_options')) {
        show_admin_bar(false);
    }
}
add_action('after_setup_theme', 'la_hide_admin_bar');

// 5. Redirect non-admins away from wp-admin
function la_redirect_non_admins() {
    if (is_admin() && !current_user_can('manage_options') && 
        !wp_doing_ajax() && !current_user_can('upload_files')) {
        wp_redirect(home_url('/submit-news/'));
        exit;
    }
}
add_action('admin_init', 'la_redirect_non_admins');