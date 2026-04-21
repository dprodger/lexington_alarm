# WPCode Snippets - News System

**Plugin:** WPCode (Code Snippets)  
**Last Updated:** November 24, 2025

---

## Overview

The news system requires three WPCode snippets to function:

| Snippet Name | Shortcodes Created | Purpose |
|--------------|-------------------|---------|
| Front End News System | `[la_news_login]` | Login form and submission system |
| News Shortcodes | `[featured_story]`, `[blog_posts_grid]` | Display shortcodes for news page |
| Newsletter Archive | `[newsletter_archive]` | Manual newsletter archive display |

All snippets should be set to:
- **Code Type:** PHP Snippet
- **Insert Method:** Auto Insert
- **Location:** Run Everywhere
- **Status:** Active

---

## Snippet 1: Front End News System

**Creates:** `[la_news_login]` shortcode

**Functionality:**
- Login form for non-authenticated users
- Full submission form for logged-in news team
- Post management interface (edit, delete, bulk operations)
- Image upload with featured image support
- Category assignment (feature vs. blog)

### Complete Code:

```php
<?php
/**
 * Front-End News Submission System
 * Shortcode: [la_news_login]
 */

// Login/Submission Form Handler
function la_custom_login_form() {
    if (is_user_logged_in()) {
        return la_show_post_form();
    }
    
    ob_start();
    ?>
    <div class="la-login-form" style="max-width: 400px; margin: 0 auto; padding: 20px; border: 2px solid #044f9d; border-radius: 8px;">
        <h2 style="color: #c3202e; text-align: center;">News Team Login</h2>
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
        <p style="text-align: center; margin-top: 15px;">
            <a href="<?php echo wp_lostpassword_url(get_permalink()); ?>">Forgot Password?</a>
        </p>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('la_news_login', 'la_custom_login_form');

// Show post form for logged-in users
function la_show_post_form() {
    if (!current_user_can('publish_posts') && !current_user_can('edit_posts')) {
        return '<p style="text-align: center; color: #c3202e;">You do not have permission to submit news stories.</p>';
    }
    
    // Handle form submission
    if (isset($_POST['la_news_submit']) && wp_verify_nonce($_POST['la_news_nonce'], 'la_news_submit_action')) {
        la_process_news_submission();
    }
    
    ob_start();
    ?>
    <div class="la-post-form" style="max-width: 800px; margin: 0 auto;">
        <div style="text-align: right; margin-bottom: 20px; padding: 10px; background: #f5f5f5; border-radius: 4px;">
            Welcome, <strong><?php echo esc_html(wp_get_current_user()->display_name); ?></strong> | 
            <a href="<?php echo wp_logout_url(get_permalink()); ?>">Logout</a>
        </div>
        
        <h2 style="color: #c3202e; text-align: center;">Submit News Story</h2>
        
        <?php if (isset($_GET['news_submitted']) && $_GET['news_submitted'] == 'success'): ?>
            <div style="background: #d4edda; border: 2px solid #28a745; color: #155724; padding: 15px; margin: 20px 0; text-align: center; border-radius: 4px;">
                <strong>Success!</strong> Your news story has been submitted.
            </div>
        <?php endif; ?>
        
        <form method="post" enctype="multipart/form-data" style="background: #fff; padding: 30px; border: 1px solid #ddd; border-radius: 8px;">
            <?php wp_nonce_field('la_news_submit_action', 'la_news_nonce'); ?>
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;">Story Title *</label>
                <input type="text" name="news_title" required 
                       style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 16px;">
            </div>
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;">Upload Image</label>
                <input type="file" name="news_image" accept="image/*" 
                       style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                <label style="display: block; margin-top: 10px;">
                    <input type="checkbox" name="set_featured" value="1"> Use as Featured Image
                </label>
            </div>
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;">Story Summary (Excerpt)</label>
                <textarea name="news_excerpt" rows="3" 
                          style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px;"
                          placeholder="Brief summary that appears on news cards (2-3 sentences)"></textarea>
            </div>
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;">Full Story *</label>
                <textarea name="news_content" rows="12" required 
                          style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px;"
                          placeholder="Write your full news story here..."></textarea>
            </div>
            
            <div style="margin-bottom: 25px;">
                <label style="display: block; font-weight: bold; margin-bottom: 10px;">Category *</label>
                <label style="display: block; margin-bottom: 8px;">
                    <input type="radio" name="news_category" value="blog" checked> Blog Post (appears in Recent News grid)
                </label>
                <label style="display: block;">
                    <input type="radio" name="news_category" value="feature"> Featured Story (appears at top of News page)
                </label>
                <p style="color: #666; font-size: 12px; margin-top: 5px;">Note: Only one Featured Story displays at a time.</p>
            </div>
            
            <button type="submit" name="la_news_submit" 
                    style="background: #c3202e; color: #fff; padding: 15px 40px; border: none; border-radius: 4px; font-size: 16px; font-weight: bold; cursor: pointer; width: 100%;">
                <?php echo current_user_can('publish_posts') ? 'PUBLISH STORY' : 'SUBMIT FOR REVIEW'; ?>
            </button>
        </form>
        
        <?php echo la_manage_posts_section(); ?>
    </div>
    <?php
    return ob_get_clean();
}

// Process form submission
function la_process_news_submission() {
    $title = sanitize_text_field($_POST['news_title']);
    $content = wp_kses_post($_POST['news_content']);
    $excerpt = sanitize_textarea_field($_POST['news_excerpt']);
    $category_slug = sanitize_text_field($_POST['news_category']);
    
    // Get category ID from slug
    $category = get_category_by_slug($category_slug);
    $cat_id = $category ? $category->term_id : 0;
    
    // Determine post status based on user capability
    $post_status = current_user_can('publish_posts') ? 'publish' : 'pending';
    
    // Create post
    $post_data = array(
        'post_title' => $title,
        'post_content' => $content,
        'post_excerpt' => $excerpt,
        'post_status' => $post_status,
        'post_author' => get_current_user_id(),
        'post_category' => array($cat_id)
    );
    
    $post_id = wp_insert_post($post_data);
    
    // Handle image upload
    if ($post_id && !empty($_FILES['news_image']['name'])) {
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');
        
        $attachment_id = media_handle_upload('news_image', $post_id);
        
        if (!is_wp_error($attachment_id)) {
            // Set as featured image if checkbox was checked
            if (isset($_POST['set_featured']) && $_POST['set_featured'] == '1') {
                set_post_thumbnail($post_id, $attachment_id);
            }
        }
    }
    
    // Redirect to prevent resubmission
    wp_redirect(add_query_arg('news_submitted', 'success', get_permalink()));
    exit;
}

// Post management section
function la_manage_posts_section() {
    if (!current_user_can('edit_posts')) {
        return '';
    }
    
    // Handle delete action
    if (isset($_POST['delete_posts']) && isset($_POST['post_ids']) && wp_verify_nonce($_POST['manage_nonce'], 'manage_posts_action')) {
        foreach ($_POST['post_ids'] as $post_id) {
            if (current_user_can('delete_post', $post_id)) {
                wp_delete_post(intval($post_id), true);
            }
        }
    }
    
    // Get recent posts
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 20,
        'post_status' => array('publish', 'pending', 'draft'),
        'orderby' => 'date',
        'order' => 'DESC'
    );
    
    // Non-editors can only see their own posts
    if (!current_user_can('edit_others_posts')) {
        $args['author'] = get_current_user_id();
    }
    
    $posts = get_posts($args);
    
    if (empty($posts)) {
        return '';
    }
    
    ob_start();
    ?>
    <div style="margin-top: 40px;">
        <h3 style="color: #044f9d; border-bottom: 2px solid #044f9d; padding-bottom: 10px;">Manage Recent Posts</h3>
        
        <form method="post">
            <?php wp_nonce_field('manage_posts_action', 'manage_nonce'); ?>
            
            <div style="background: #f9f9f9; border: 1px solid #ddd; border-radius: 4px; overflow: hidden;">
                <?php foreach ($posts as $post): ?>
                    <div style="padding: 15px; border-bottom: 1px solid #ddd; display: flex; align-items: center; gap: 15px;">
                        <input type="checkbox" name="post_ids[]" value="<?php echo $post->ID; ?>">
                        <div style="flex: 1;">
                            <strong><?php echo esc_html($post->post_title); ?></strong>
                            <span style="color: #666; font-size: 12px; margin-left: 10px;">
                                <?php echo get_the_date('M j, Y', $post->ID); ?>
                                | <?php echo ucfirst($post->post_status); ?>
                            </span>
                        </div>
                        <a href="<?php echo get_permalink($post->ID); ?>" target="_blank" style="color: #044f9d;">View</a>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <button type="submit" name="delete_posts" 
                    style="background: #dc3545; color: #fff; padding: 10px 20px; border: none; border-radius: 4px; margin-top: 15px; cursor: pointer;"
                    onclick="return confirm('Are you sure you want to delete the selected posts?');">
                Delete Selected
            </button>
        </form>
    </div>
    <?php
    return ob_get_clean();
}
```

---

## Snippet 2: News Shortcodes

**Creates:** `[featured_story]`, `[blog_posts_grid]`

**Functionality:**
- Featured story display (single post from `feature` category)
- Blog posts grid (6 posts from `blog` category, 2-column layout)

### Complete Code:

```php
<?php
/**
 * News Display Shortcodes
 * Shortcodes: [featured_story], [blog_posts_grid]
 */

// FEATURED STORY SHORTCODE
function display_featured_story() {
    $args = array(
        'category_name' => 'feature',
        'posts_per_page' => 1,
        'post_status' => 'publish'
    );
    
    $query = new WP_Query($args);
    
    if ($query->have_posts()) {
        ob_start();
        while ($query->have_posts()) {
            $query->the_post();
            ?>
            <div class="featured-article" style="max-width: 800px; margin: 0 auto; padding: 20px;">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="featured-image" style="margin-bottom: 20px;">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('large', array('style' => 'width: 100%; height: auto; border-radius: 4px;')); ?>
                        </a>
                    </div>
                <?php endif; ?>
                
                <div class="featured-content">
                    <h3 class="featured-title" style="font-size: 28px; margin-bottom: 10px;">
                        <a href="<?php the_permalink(); ?>" style="color: #c3202e; text-decoration: none;">
                            <?php the_title(); ?>
                        </a>
                    </h3>
                    <div class="featured-date" style="color: #666; margin-bottom: 15px;">
                        <?php echo get_the_date(); ?>
                    </div>
                    <div class="featured-excerpt" style="margin-bottom: 20px; line-height: 1.6;">
                        <?php 
                        if (has_excerpt()) {
                            the_excerpt();
                        } else {
                            echo wp_trim_words(get_the_content(), 40, '...');
                        }
                        ?>
                    </div>
                    <a href="<?php the_permalink(); ?>" class="la-button" 
                       style="display: inline-block; background: #c3202e; color: #fff; padding: 12px 25px; text-decoration: none; border-radius: 4px; font-weight: bold;">
                        Read Full Story →
                    </a>
                </div>
            </div>
            <?php
        }
        wp_reset_postdata();
        return ob_get_clean();
    }
    return '<p style="text-align: center; color: #666;">No featured story available.</p>';
}
add_shortcode('featured_story', 'display_featured_story');

// BLOG POSTS GRID SHORTCODE
function display_blog_posts_grid() {
    $args = array(
        'category_name' => 'blog',
        'posts_per_page' => 6,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC'
    );
    
    $query = new WP_Query($args);
    
    if ($query->have_posts()) {
        ob_start();
        ?>
        <div class="blog-posts-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 30px; margin-top: 20px;">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <div class="blog-post-card" style="border: 1px solid #ddd; padding: 20px; border-radius: 4px; background: #fff;">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="blog-post-image" style="margin-bottom: 15px;">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('medium', array('style' => 'width: 100%; height: auto; border-radius: 4px;')); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    
                    <div class="blog-post-meta" style="color: #044f9d; font-size: 0.85em; margin-bottom: 10px; text-transform: uppercase;">
                        BLOG POSTS | <?php echo get_the_date('M j, Y'); ?>
                    </div>
                    
                    <h3 class="blog-post-title" style="font-size: 18px; margin-bottom: 10px;">
                        <a href="<?php the_permalink(); ?>" style="color: #000; text-decoration: none;">
                            <?php the_title(); ?>
                        </a>
                    </h3>
                    
                    <div class="blog-post-excerpt" style="margin-bottom: 15px; color: #444; line-height: 1.5;">
                        <?php echo wp_trim_words(get_the_content(), 20, '...'); ?>
                    </div>
                    
                    <div class="blog-post-footer" style="font-size: 0.85em; color: #666; margin-bottom: 10px;">
                        <span>By <?php the_author(); ?></span>
                    </div>
                    
                    <a href="<?php the_permalink(); ?>" style="color: #c3202e; font-weight: bold; text-decoration: none;">
                        READ MORE →
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
        
        <style>
        @media (max-width: 768px) {
            .blog-posts-grid {
                grid-template-columns: 1fr !important;
            }
        }
        </style>
        <?php
        wp_reset_postdata();
        return ob_get_clean();
    }
    return '<p style="text-align: center; color: #666;">No blog posts available.</p>';
}
add_shortcode('blog_posts_grid', 'display_blog_posts_grid');
```

---

## Snippet 3: Newsletter Archive

**Creates:** `[newsletter_archive]`

**Functionality:**
- Displays list of past newsletters
- Links to Mailchimp "View in Browser" versions
- Manually updated bi-weekly

See `Newsletter_Archive.md` for the complete code and update instructions.

---

## Snippet Configuration in WPCode

### For Each Snippet:
1. Go to **Snippets → Add Snippet → Add Your Custom Code**
2. Select **PHP Snippet**
3. Paste the code
4. Set:
   - **Insert Method:** Auto Insert
   - **Location:** Run Everywhere (Site Wide)
5. **Activate** the snippet
6. **Save**

### Verification:
After activating, test each shortcode on a test page:
- `[la_news_login]` - Should show login form
- `[featured_story]` - Should show featured post (if one exists)
- `[blog_posts_grid]` - Should show blog posts (if any exist)
- `[newsletter_archive]` - Should show newsletter list

---

## Troubleshooting Code Issues

### Syntax Errors on Activation
1. Check for missing semicolons or brackets
2. PHP opening tag should be `<?php` (not `<?`)
3. No closing `?>` tag needed at end (recommended)
4. Validate PHP syntax before pasting

### Shortcode Shows as Plain Text
1. Snippet not activated
2. Shortcode name mismatch (check `add_shortcode()` line)
3. PHP error preventing function registration

### Posts Not Displaying
1. Check category slug matches (`feature`, `blog`, `archive`)
2. Verify posts are published (not draft/pending)
3. Check post is assigned to correct category

### Styling Issues
1. Some themes may override inline styles
2. Add `!important` to critical styles if needed
3. Or move styles to main theme CSS

---

## Related Documentation

- News page structure: `News_System/News_Page_Public.md`
- News team portal: `News_System/News_Team_Portal.md`
- Newsletter archive updates: `News_System/Newsletter_Archive.md`
- All site CSS: `06_Code_Snippets/Custom_CSS.md`
