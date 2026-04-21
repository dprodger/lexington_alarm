/**
 * Blog Post Search - Ajax Live Search (FIXED v2)
 * Searches all blog posts regardless of display status
 * 
 * FIX v2: Wait for jQuery to load before initializing
 * FIX v1: Added Enter key handler to prevent redirect
 * Updated: January 21, 2026
 * 
 * INSTALLATION:
 * 1. Go to WPCode → Code Snippets
 * 2. Find "Blog Post Search" snippet (#12)
 * 3. Replace ALL code with this file's contents
 * 4. Save and verify snippet is Active
 */

// Shortcode to display search box
function la_blog_search_box() {
    ob_start();
    ?>
    <div class="la-blog-search-container">
        <div class="la-search-box">
            <h3 class="search-title">SEARCH ALL STORIES</h3>
            <p class="search-description">Search our complete archive of news stories and updates</p>
            
            <div class="search-input-wrapper">
                <input type="text" 
                       id="la-blog-search" 
                       placeholder="Search by keyword, topic, or date..."
                       autocomplete="off">
                <span class="search-icon">🔍</span>
            </div>
            
            <div id="la-search-results" class="la-search-results"></div>
            <div id="la-search-loading" class="la-search-loading" style="display:none;">
                Searching...
            </div>
        </div>
    </div>
    
    <style>
    /* Search Container */
    .la-blog-search-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 0 24px;
    }
    
    .la-search-box {
        background: #f8f8f8;
        border: 3px solid #044f9d;
        padding: 30px;
        border-radius: 8px;
    }
    
    .search-title {
        color: #c3202e;
        font-family: 'ArmaliteRifle', sans-serif;
        text-transform: uppercase;
        text-align: center;
        font-size: 28px;
        margin: 0 0 10px 0;
    }
    
    .search-description {
        text-align: center;
        color: #044f9d;
        font-family: 'UglyQua', serif;
        font-size: 16px;
        margin: 0 0 20px 0;
    }
    
    /* Search Input */
    .search-input-wrapper {
        position: relative;
        margin-bottom: 20px;
    }
    
    #la-blog-search {
        width: 100%;
        padding: 15px 50px 15px 20px;
        font-size: 16px;
        border: 2px solid #044f9d;
        border-radius: 4px;
        font-family: 'Work Sans', sans-serif;
        box-sizing: border-box;
    }
    
    #la-blog-search:focus {
        outline: none;
        border-color: #c3202e;
        box-shadow: 0 0 5px rgba(195, 32, 46, 0.3);
    }
    
    .search-icon {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 20px;
        pointer-events: none;
    }
    
    /* Search Results */
    .la-search-results {
        background: white;
        border-radius: 4px;
        max-height: 500px;
        overflow-y: auto;
    }
    
    .search-result-item {
        padding: 20px;
        border-bottom: 1px solid #ddd;
        transition: background 0.2s ease;
    }
    
    .search-result-item:hover {
        background: #f0f8ff;
    }
    
    .search-result-item:last-child {
        border-bottom: none;
    }
    
    .result-title {
        margin: 0 0 8px 0;
    }
    
    .result-title a {
        color: #c3202e;
        text-decoration: none;
        font-size: 20px;
        font-weight: bold;
        font-family: 'Work Sans', sans-serif;
    }
    
    .result-title a:hover {
        text-decoration: underline;
    }
    
    .result-date {
        color: #044f9d;
        font-size: 14px;
        margin: 0 0 8px 0;
        font-weight: bold;
    }
    
    .result-excerpt {
        color: #333;
        line-height: 1.5;
        font-size: 15px;
    }
    
    .result-category {
        display: inline-block;
        background: #044f9d;
        color: white;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        margin-top: 8px;
        text-transform: uppercase;
    }
    
    .result-category.featured {
        background: #c3202e;
    }
    
    .no-results {
        padding: 30px;
        text-align: center;
        color: #666;
        font-style: italic;
    }
    
    .la-search-loading {
        text-align: center;
        padding: 20px;
        color: #044f9d;
        font-style: italic;
    }
    
    /* Mobile Responsive */
    @media (max-width: 768px) {
        .la-blog-search-container {
            padding: 0 16px;
        }
        
        .la-search-box {
            padding: 20px 15px;
        }
        
        .search-title {
            font-size: 24px;
        }
        
        .search-description {
            font-size: 14px;
        }
        
        #la-blog-search {
            padding: 12px 45px 12px 15px;
            font-size: 16px; /* Prevents zoom on mobile */
        }
    }
    </style>
    
    <script>
    /**
     * Wait for jQuery to be available, then initialize search
     * This fixes the "Can't find variable: jQuery" error
     */
    (function() {
        var ajaxUrl = '<?php echo admin_url('admin-ajax.php'); ?>';
        var nonce = '<?php echo wp_create_nonce('la_search_nonce'); ?>';
        
        function initBlogSearch() {
            var $ = jQuery;
            var searchTimeout;
            var $searchInput = $('#la-blog-search');
            var $results = $('#la-search-results');
            var $loading = $('#la-search-loading');
            
            // Exit if search input doesn't exist
            if ($searchInput.length === 0) {
                return;
            }
            
            // PREVENT ENTER KEY FROM TRIGGERING SITE SEARCH
            $searchInput.on('keypress', function(e) {
                if (e.which === 13) {
                    e.preventDefault();
                    e.stopPropagation();
                    clearTimeout(searchTimeout);
                    var searchTerm = $(this).val().trim();
                    if (searchTerm.length >= 3) {
                        performSearch(searchTerm);
                    }
                    return false;
                }
            });
            
            // Also catch keydown for Enter (belt and suspenders)
            $searchInput.on('keydown', function(e) {
                if (e.which === 13) {
                    e.preventDefault();
                    e.stopPropagation();
                    return false;
                }
            });
            
            // Search as user types (with delay)
            $searchInput.on('keyup', function(e) {
                if (e.which === 13) return;
                
                clearTimeout(searchTimeout);
                var searchTerm = $(this).val().trim();
                
                if (searchTerm.length === 0) {
                    $results.empty();
                    return;
                }
                
                if (searchTerm.length >= 3) {
                    searchTimeout = setTimeout(function() {
                        performSearch(searchTerm);
                    }, 500);
                }
            });
            
            function performSearch(searchTerm) {
                $loading.show();
                $results.empty();
                
                $.ajax({
                    url: ajaxUrl,
                    type: 'POST',
                    data: {
                        action: 'la_blog_search',
                        search: searchTerm,
                        nonce: nonce
                    },
                    success: function(response) {
                        $loading.hide();
                        
                        if (response.success && response.data.length > 0) {
                            displayResults(response.data);
                        } else {
                            $results.html('<div class="no-results">No stories found matching "' + searchTerm + '"</div>');
                        }
                    },
                    error: function() {
                        $loading.hide();
                        $results.html('<div class="no-results">Search error. Please try again.</div>');
                    }
                });
            }
            
            function displayResults(results) {
                var html = '';
                
                $.each(results, function(index, post) {
                    var categoryClass = post.is_featured ? 'featured' : '';
                    var categoryLabel = post.is_featured ? 'Featured Story' : 'Blog Post';
                    
                    html += '<div class="search-result-item">';
                    html += '<h4 class="result-title"><a href="' + post.url + '">' + post.title + '</a></h4>';
                    html += '<div class="result-date">📅 ' + post.date + '</div>';
                    html += '<div class="result-excerpt">' + post.excerpt + '</div>';
                    html += '<span class="result-category ' + categoryClass + '">' + categoryLabel + '</span>';
                    html += '</div>';
                });
                
                $results.html(html);
            }
            
            console.log('LA Blog Search initialized successfully');
        }
        
        // Wait for jQuery and DOM to be ready
        function waitForjQuery() {
            if (typeof jQuery !== 'undefined') {
                jQuery(document).ready(function() {
                    initBlogSearch();
                });
            } else {
                // jQuery not loaded yet, wait 100ms and try again
                setTimeout(waitForjQuery, 100);
            }
        }
        
        // Start waiting for jQuery
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', waitForjQuery);
        } else {
            waitForjQuery();
        }
    })();
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('la_blog_search', 'la_blog_search_box');

// Ajax handler for search
function la_blog_search_handler() {
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'la_search_nonce')) {
        wp_send_json_error('Invalid request');
    }
    
    $search_term = sanitize_text_field($_POST['search']);
    
    // Search query
    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 20,
        's' => $search_term,
        'category_name' => 'blog,feature', // Search both categories
        'orderby' => 'relevance',
        'order' => 'DESC'
    );
    
    $query = new WP_Query($args);
    $results = array();
    
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            
            // Check if featured
            $categories = get_the_category();
            $is_featured = false;
            foreach ($categories as $category) {
                if ($category->slug === 'feature') {
                    $is_featured = true;
                    break;
                }
            }
            
            $results[] = array(
                'title' => get_the_title(),
                'url' => get_permalink(),
                'date' => get_the_date('F j, Y'),
                'excerpt' => wp_trim_words(get_the_excerpt() ?: get_the_content(), 30, '...'),
                'is_featured' => $is_featured
            );
        }
        wp_reset_postdata();
    }
    
    wp_send_json_success($results);
}
add_action('wp_ajax_la_blog_search', 'la_blog_search_handler');
add_action('wp_ajax_nopriv_la_blog_search', 'la_blog_search_handler');
