<?php
/**
 * Add Category Labels to WooCommerce Order Email Subjects
 * This snippet adds [DONATION], [LOCAL PICKUP], or [SHIPPING] to email subjects
 * Version: 2.0 - Fixed and Debugged
 * 
 * INSTALLATION:
 * 1. Go to WordPress Admin > WPCode > Add Snippet
 * 2. Choose "Add Your Custom Code (New Snippet)" > PHP Snippet
 * 3. Name it: "Category Email Labels - Fixed"
 * 4. Paste this entire code (without the <?php tag if WPCode adds it automatically)
 * 5. Set to "Run Everywhere" 
 * 6. Activate the snippet
 */

// Add category prefix to order email subjects
add_filter('woocommerce_email_subject_new_order', 'lexington_add_category_to_email_subject', 10, 2);
add_filter('woocommerce_email_subject_customer_processing_order', 'lexington_add_category_to_email_subject', 10, 2);
add_filter('woocommerce_email_subject_customer_completed_order', 'lexington_add_category_to_email_subject', 10, 2);
add_filter('woocommerce_email_subject_admin_new_order', 'lexington_add_category_to_email_subject', 10, 2);

function lexington_add_category_to_email_subject($subject, $order) {
    // Ensure we have a valid order object
    if (!$order || !is_a($order, 'WC_Order')) {
        return $subject;
    }
    
    // Initialize variables
    $category_prefix = '';
    $categories_found = array();
    
    // Get all items in the order
    $items = $order->get_items();
    
    // Loop through order items to find product categories
    foreach ($items as $item) {
        $product = $item->get_product();
        
        if (!$product) {
            continue;
        }
        
        // Get product categories
        $terms = get_the_terms($product->get_id(), 'product_cat');
        
        if ($terms && !is_wp_error($terms)) {
            foreach ($terms as $term) {
                // Store the category slug (normalized to lowercase)
                $category_slug = strtolower($term->slug);
                
                // Map category slugs to display labels
                if (strpos($category_slug, 'donation') !== false) {
                    $categories_found['donation'] = true;
                } elseif (strpos($category_slug, 'local-pickup') !== false || 
                         strpos($category_slug, 'local_pickup') !== false || 
                         strpos($category_slug, 'pickup') !== false) {
                    $categories_found['pickup'] = true;
                } elseif (strpos($category_slug, 'shipping') !== false || 
                         strpos($category_slug, 'ship') !== false) {
                    $categories_found['shipping'] = true;
                }
                
                // Also check the category name (not just slug)
                $category_name = strtolower($term->name);
                if (strpos($category_name, 'donation') !== false) {
                    $categories_found['donation'] = true;
                } elseif (strpos($category_name, 'local pickup') !== false) {
                    $categories_found['pickup'] = true;
                } elseif (strpos($category_name, 'shipping') !== false) {
                    $categories_found['shipping'] = true;
                }
            }
        }
        
        // Alternative: Check shipping class if categories aren't working
        $shipping_class = $product->get_shipping_class();
        if ($shipping_class) {
            if (strpos($shipping_class, 'local') !== false || strpos($shipping_class, 'pickup') !== false) {
                $categories_found['pickup'] = true;
            } elseif (strpos($shipping_class, 'ship') !== false) {
                $categories_found['shipping'] = true;
            }
        }
    }
    
    // Also check the shipping method selected by customer
    $shipping_methods = $order->get_shipping_methods();
    foreach ($shipping_methods as $shipping_method) {
        $method_id = $shipping_method->get_method_id();
        if (strpos($method_id, 'local_pickup') !== false) {
            $categories_found['pickup'] = true;
        } elseif (strpos($method_id, 'flat_rate') !== false || strpos($method_id, 'shipping') !== false) {
            $categories_found['shipping'] = true;
        }
    }
    
    // Determine which prefix to use (prioritize in this order)
    if (!empty($categories_found['donation'])) {
        $category_prefix = '[DONATION] ';
    } elseif (!empty($categories_found['pickup'])) {
        $category_prefix = '[LOCAL PICKUP] ';
    } elseif (!empty($categories_found['shipping'])) {
        $category_prefix = '[SHIPPING] ';
    }
    
    // Add debug logging (optional - comment out in production)
    if (function_exists('error_log')) {
        error_log('Lexington Alarm - Order #' . $order->get_id() . ' - Categories found: ' . print_r($categories_found, true));
        error_log('Lexington Alarm - Order #' . $order->get_id() . ' - Prefix: ' . $category_prefix);
    }
    
    // Return the subject with or without prefix
    if (!empty($category_prefix)) {
        // Check if prefix already exists to avoid duplication
        if (strpos($subject, $category_prefix) === false) {
            return $category_prefix . $subject;
        }
    }
    
    return $subject;
}

/**
 * DEBUGGING HELPER - Add category info to order notes
 * This helps verify categories are being detected correctly
 * Remove or comment out in production
 */
add_action('woocommerce_checkout_order_processed', 'lexington_debug_order_categories', 999, 1);
function lexington_debug_order_categories($order_id) {
    $order = wc_get_order($order_id);
    if (!$order) return;
    
    $debug_info = array();
    
    foreach ($order->get_items() as $item) {
        $product = $item->get_product();
        if (!$product) continue;
        
        $terms = get_the_terms($product->get_id(), 'product_cat');
        if ($terms && !is_wp_error($terms)) {
            foreach ($terms as $term) {
                $debug_info[] = 'Product: ' . $product->get_name() . ' | Category: ' . $term->name . ' (' . $term->slug . ')';
            }
        }
    }
    
    if (!empty($debug_info)) {
        $order->add_order_note('Category Debug: ' . implode('; ', $debug_info));
    }
}

/**
 * TEST FUNCTION - Use this to test the category detection
 * Access via: yourdomain.com/?test_category_labels=true&order_id=XXX
 * Remove in production!
 */
add_action('init', 'lexington_test_category_labels');
function lexington_test_category_labels() {
    if (isset($_GET['test_category_labels']) && current_user_can('manage_options')) {
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        
        if ($order_id) {
            $order = wc_get_order($order_id);
            if ($order) {
                echo '<h2>Testing Category Labels for Order #' . $order_id . '</h2>';
                echo '<pre>';
                
                foreach ($order->get_items() as $item) {
                    $product = $item->get_product();
                    if (!$product) continue;
                    
                    echo 'Product: ' . $product->get_name() . "\n";
                    echo 'Product ID: ' . $product->get_id() . "\n";
                    
                    // Check categories
                    $terms = get_the_terms($product->get_id(), 'product_cat');
                    if ($terms && !is_wp_error($terms)) {
                        echo "Categories:\n";
                        foreach ($terms as $term) {
                            echo "  - " . $term->name . " (slug: " . $term->slug . ")\n";
                        }
                    } else {
                        echo "No categories found\n";
                    }
                    
                    // Check shipping class
                    $shipping_class = $product->get_shipping_class();
                    echo 'Shipping Class: ' . ($shipping_class ?: 'None') . "\n";
                    
                    echo "\n---\n\n";
                }
                
                // Test the subject line
                $original_subject = 'New order #' . $order_id;
                $modified_subject = lexington_add_category_to_email_subject($original_subject, $order);
                echo 'Original Subject: ' . $original_subject . "\n";
                echo 'Modified Subject: ' . $modified_subject . "\n";
                
                echo '</pre>';
                exit;
            }
        }
        
        echo 'Please add ?test_category_labels=true&order_id=XXX to test a specific order.';
        exit;
    }
}
