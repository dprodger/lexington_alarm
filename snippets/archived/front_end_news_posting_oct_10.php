<?php
// Enable featured image support
function enable_featured_images() {
    add_theme_support('post-thumbnails');
    
    // Set image sizes for news
    add_image_size('news-featured', 600, 400, true);
    add_image_size('news-thumbnail', 300, 200, true);
}
add_action('after_setup_theme', 'enable_featured_images');

// Login form function
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

function la_show_post_form() {
    if (!current_user_can('publish_posts') && !current_user_can('edit_posts')) {
        return '<p>You do not have permission to submit news stories.</p>';
    }
    
    // Handle delete action
    if (isset($_GET['delete_post']) && isset($_GET['delete_nonce'])) {
        if (wp_verify_nonce($_GET['delete_nonce'], 'delete_post_' . $_GET['delete_post'])) {
            $post_id = intval($_GET['delete_post']);
            $post = get_post($post_id);
            
            // Check if user can delete this post
            if ($post && (current_user_can('delete_posts') || 
                ($post->post_author == get_current_user_id() && current_user_can('delete_posts')))) {
                
                wp_trash_post($post_id); // Move to trash instead of permanent delete
                echo '<div style="background: #d4edda; border: 2px solid #28a745; color: #155724; padding: 15px; margin: 20px 0;">
                        <strong>Success!</strong> The post has been moved to trash.
                      </div>';
            }
        }
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
        <h3 style="color: #c3202e;">Manage Recent Posts</h3>
        
        <!-- Bulk Delete Form -->
        <form method="post" id="bulk-delete-form" onsubmit="return confirm('Are you sure you want to delete the selected posts?');">
            <?php wp_nonce_field('la_bulk_delete', 'la_bulk_delete_nonce'); ?>
            
            <div style="margin-bottom: 20px; padding: 15px; background: #f5f5f5; border: 1px solid #ddd;">
                <button type="submit" name="bulk_delete" value="1" 
                        style="background: #dc3545; color: white; padding: 10px 20px; 
                               border: none; font-weight: bold; cursor: pointer;">
                    DELETE SELECTED
                </button>
                <span style="margin-left: 15px; color: #666;">
                    Check boxes next to posts you want to delete
                </span>
            </div>
            
            <?php
            $recent_posts = get_posts(array(
                'numberposts' => 20,
                'post_status' => array('publish', 'pending', 'draft'),
                'category_name' => 'feature,blog,archive'
            ));
            
            foreach ($recent_posts as $post) {
                $categories = get_the_category($post->ID);
                $cat_names = wp_list_pluck($categories, 'name');
                $is_featured = in_array('Featured Story', $cat_names);
                
                echo '<div style="margin: 10px 0; padding: 15px; border: 1px solid #ddd; background: white;">';
                echo '<div style="display: flex; align-items: center; gap: 15px;">';
                
                // Checkbox for deletion
                echo '<input type="checkbox" name="delete_posts[]" value="' . $post->ID . '" 
                            style="width: 20px; height: 20px;">';
                
                echo '<div style="flex: 1;">';
                echo '<strong style="font-size: 1.1em;">' . esc_html($post->post_title) . '</strong><br>';
                echo '<span style="color: #666; font-size: 0.9em;">';
                echo 'Status: <strong>' . $post->post_status . '</strong> | ';
                echo 'Date: ' . get_the_date('M j, Y', $post->ID) . ' | ';
                echo 'Categories: ' . implode(', ', $cat_names);
                if ($is_featured) {
                    echo ' <span style="color: #c3202e; font-weight: bold;">[FEATURED]</span>';
                }
                echo '</span>';
                echo '</div>';
                
                // Individual actions
                echo '<div style="display: flex; gap: 10px;">';
                echo '<a href="' . get_edit_post_link($post->ID) . '" target="_blank"
                         style="color: #044f9d; text-decoration: none; font-weight: bold;">Edit</a>';
                echo '<a href="' . get_permalink($post->ID) . '" target="_blank"
                         style="color: #28a745; text-decoration: none; font-weight: bold;">View</a>';
                
                // Quick delete link
                $delete_url = add_query_arg(array(
                    'delete_post' => $post->ID,
                    'delete_nonce' => wp_create_nonce('delete_post_' . $post->ID)
                ), get_permalink());
                
                echo '<a href="' . $delete_url . '" 
                         onclick="return confirm(\'Delete this post?\')"
                         style="color: #dc3545; text-decoration: none; font-weight: bold;">Delete</a>';
                echo '</div>';
                
                echo '</div>';
                echo '</div>';
            }
            ?>
        </form>
        <?php endif; ?>
    </div>
    
    <script>
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

// Handle bulk delete
function la_handle_bulk_delete() {
    if (isset($_POST['bulk_delete']) && isset($_POST['la_bulk_delete_nonce'])) {
        if (!wp_verify_nonce($_POST['la_bulk_delete_nonce'], 'la_bulk_delete')) {
            return;
        }
        
        if (!current_user_can('delete_posts')) {
            return;
        }
        
        if (isset($_POST['delete_posts']) && is_array($_POST['delete_posts'])) {
            foreach ($_POST['delete_posts'] as $post_id) {
                $post_id = intval($post_id);
                if ($post_id > 0) {
                    wp_trash_post($post_id);
                }
            }
            
            // Redirect to avoid form resubmission
            wp_redirect(add_query_arg('bulk_deleted', count($_POST['delete_posts']), get_permalink()));
            exit;
        }
    }
}
add_action('init', 'la_handle_bulk_delete');

function la_handle_news_submission() {
    if (!isset($_POST['la_news_nonce']) || 
        !wp_verify_nonce($_POST['la_news_nonce'], 'la_submit_news')) {
        return;
    }
    
    if (!is_user_logged_in()) {
        return;
    }
    
    // Get the correct category IDs based on your slugs
    $blog_cat = get_category_by_slug('blog');
    $categories = array();
    
    if ($blog_cat) {
        $categories[] = $blog_cat->term_id;
    }
    
    $post_data = array(
        'post_title' => sanitize_text_field($_POST['post_title']),
        'post_content' => wp_kses_post($_POST['post_content']),
        'post_excerpt' => sanitize_textarea_field($_POST['post_excerpt']),
        'post_status' => current_user_can('publish_posts') ? 'publish' : 'pending',
        'post_author' => get_current_user_id(),
        'post_type' => 'post',
        'post_category' => $categories
    );
    
    $post_id = wp_insert_post($post_data);
    
    if ($post_id && !is_wp_error($post_id)) {
        // If featured story is checked, add to feature category
        if (isset($_POST['featured_story']) && $_POST['featured_story'] == '1') {
            $featured_cat = get_category_by_slug('feature');
            if ($featured_cat) {
                wp_set_post_categories($post_id, array($featured_cat->term_id), true);
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
        
        $redirect_url = add_query_arg('news_submitted', 'success', get_permalink());
        wp_redirect($redirect_url);
        exit;
    }
}
add_action('init', 'la_handle_news_submission');

function la_hide_admin_bar() {
    if (!current_user_can('manage_options')) {
        show_admin_bar(false);
    }
}
add_action('after_setup_theme', 'la_hide_admin_bar');

function la_redirect_non_admins() {
    if (is_admin() && !current_user_can('manage_options') && 
        !wp_doing_ajax() && !current_user_can('upload_files')) {
        wp_redirect(home_url('/submit-news/'));
        exit;
    }
}
add_action('admin_init', 'la_redirect_non_admins');
// Add AJAX handler for category changes
function la_handle_category_change() {
    // Check nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'la_category_change')) {
        wp_die('Security check failed');
    }
    
    if (!current_user_can('edit_posts')) {
        wp_die('Permission denied');
    }
    
    $post_id = intval($_POST['post_id']);
    $new_category = sanitize_text_field($_POST['category']);
    
    // Get category objects
    $featured_cat = get_category_by_slug('feature');
    $blog_cat = get_category_by_slug('blog');
    
    if ($new_category === 'feature' && $featured_cat) {
        // Remove from all posts first if making featured
        $all_featured = get_posts(array(
            'category_name' => 'feature',
            'posts_per_page' => -1
        ));
        foreach ($all_featured as $post) {
            wp_remove_object_terms($post->ID, $featured_cat->term_id, 'category');
            if ($blog_cat) {
                wp_set_object_terms($post->ID, $blog_cat->term_id, 'category', true);
            }
        }
        // Set new featured
        wp_set_post_categories($post_id, array($featured_cat->term_id));
    } elseif ($new_category === 'blog' && $blog_cat) {
        wp_set_post_categories($post_id, array($blog_cat->term_id));
    }
    
    wp_die('Category updated');
}
add_action('wp_ajax_la_change_category', 'la_handle_category_change');