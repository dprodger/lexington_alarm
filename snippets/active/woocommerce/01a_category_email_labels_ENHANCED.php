<?php
/**
 * Enhanced Category Email Labels with Shipping Emphasis
 * 
 * This snippet adds clear prefixes to WooCommerce email subjects:
 * - [SHIPPING] for orders that need to be packed and mailed
 * - [LOCAL PICKUP] for porch pickup orders in Lexington area
 * - [DONATION] for monetary donations (no fulfillment)
 * 
 * Version: 2.1 - Enhanced for shipping visibility
 * Last Updated: October 2025
 * 
 * INSTALLATION:
 * 1. Go to WordPress Admin > WPCode > Add Snippet
 * 2. Choose "Add Your Custom Code (New Snippet)" > PHP Snippet
 * 3. Name it: "Category Email Labels - Enhanced Shipping"
 * 4. Paste this entire code (without the <?php tag if WPCode adds it automatically)
 * 5. Set to "Run Everywhere" 
 * 6. Activate the snippet
 * 7. DEACTIVATE the old "Category Email Labels - Fixed" snippet if it exists
 */

// Hook into all order notification emails
add_filter('woocommerce_email_subject_new_order', 'lexington_enhanced_email_subject', 10, 2);
add_filter('woocommerce_email_subject_customer_processing_order', 'lexington_enhanced_email_subject', 10, 2);
add_filter('woocommerce_email_subject_customer_completed_order', 'lexington_enhanced_email_subject', 10, 2);
add_filter('woocommerce_email_subject_admin_new_order', 'lexington_enhanced_email_subject', 10, 2);

function lexington_enhanced_email_subject($subject, $order) {
    // Ensure we have a valid order object
    if (!$order || !is_a($order, 'WC_Order')) {
        return $subject;
    }
    
    // Initialize tracking variables
    $order_type = '';
    $categories_found = array(
        'donation' => false,
        'pickup' => false,
        'shipping' => false
    );
    
    // STEP 1: Check shipping method first (most reliable indicator)
    $shipping_methods = $order->get_shipping_methods();
    
    if (empty($shipping_methods)) {
        // No shipping method = likely virtual/donation product
        $categories_found['donation'] = true;
    } else {
        foreach ($shipping_methods as $shipping_method) {
            $method_id = strtolower($shipping_method->get_method_id());
            $method_title = strtolower($shipping_method->get_method_title());
            
            // Check if it's local pickup
            if (strpos($method_id, 'local_pickup') !== false || 
                strpos($method_title, 'local pickup') !== false ||
                strpos($method_title, 'porch pickup') !== false) {
                $categories_found['pickup'] = true;
            } else {
                // Any other shipping method = needs to be shipped
                $categories_found['shipping'] = true;
            }
        }
    }
    
    // STEP 2: Check product categories for additional context
    $items = $order->get_items();
    foreach ($items as $item) {
        $product = $item->get_product();
        
        if (!$product) {
            continue;
        }
        
        // Check if product is virtual (donation)
        if ($product->is_virtual()) {
            $categories_found['donation'] = true;
        }
        
        // Get product categories
        $terms = get_the_terms($product->get_id(), 'product_cat');
        
        if ($terms && !is_wp_error($terms)) {
            foreach ($terms as $term) {
                $category_slug = strtolower($term->slug);
                $category_name = strtolower($term->name);
                
                // Check for donation category
                if (strpos($category_slug, 'donation') !== false || 
                    strpos($category_name, 'donation') !== false) {
                    $categories_found['donation'] = true;
                }
                
                // Check for local pickup category
                if (strpos($category_slug, 'local-pickup') !== false || 
                    strpos($category_slug, 'local_pickup') !== false || 
                    strpos($category_slug, 'pickup') !== false ||
                    strpos($category_name, 'local pickup') !== false ||
                    strpos($category_name, 'pickup') !== false) {
                    $categories_found['pickup'] = true;
                }
                
                // Check for shipping category
                if (strpos($category_slug, 'shipping') !== false || 
                    strpos($category_slug, 'shippable') !== false ||
                    strpos($category_name, 'shipping') !== false ||
                    strpos($category_name, 'shippable') !== false) {
                    $categories_found['shipping'] = true;
                }
            }
        }
        
        // STEP 3: Check shipping class as backup
        $shipping_class = $product->get_shipping_class();
        if ($shipping_class) {
            $shipping_class = strtolower($shipping_class);
            
            if (strpos($shipping_class, 'local') !== false || 
                strpos($shipping_class, 'pickup') !== false) {
                $categories_found['pickup'] = true;
            } elseif (strpos($shipping_class, 'ship') !== false) {
                $categories_found['shipping'] = true;
            }
        }
    }
    
    // STEP 4: Determine prefix based on priority
    // Priority: DONATION > LOCAL PICKUP > SHIPPING
    if ($categories_found['donation']) {
        $order_type = '[DONATION] ';
    } elseif ($categories_found['pickup']) {
        $order_type = '[LOCAL PICKUP] ';
    } elseif ($categories_found['shipping']) {
        $order_type = '[SHIPPING] ';
    } else {
        // Fallback - check if there's any shipping cost
        $shipping_total = $order->get_shipping_total();
        if ($shipping_total > 0) {
            $order_type = '[SHIPPING] ';
        } else {
            // No clear indicator - leave blank but log it
            error_log('Lexington Alarm - Order #' . $order->get_id() . ' - Unable to determine order type');
        }
    }
    
    // STEP 5: Add debugging info to order notes (can be disabled in production)
    if (!empty($order_type) && function_exists('error_log')) {
        error_log('Lexington Alarm - Order #' . $order->get_id() . ' - Type: ' . trim($order_type) . ' | Categories: ' . json_encode($categories_found));
    }
    
    // STEP 6: Apply prefix to subject
    if (!empty($order_type)) {
        // Check if prefix already exists to avoid duplication
        if (strpos($subject, $order_type) === false) {
            return $order_type . $subject;
        }
    }
    
    return $subject;
}

/**
 * ENHANCED: Add order type to order meta for easy reference
 * This stores the order type so it can be used by other functions
 */
add_action('woocommerce_checkout_order_processed', 'lexington_store_order_type', 10, 1);
function lexington_store_order_type($order_id) {
    $order = wc_get_order($order_id);
    if (!$order) return;
    
    // Determine order type using same logic
    $shipping_methods = $order->get_shipping_methods();
    $order_type = 'unknown';
    
    if (empty($shipping_methods)) {
        $order_type = 'donation';
    } else {
        foreach ($shipping_methods as $shipping_method) {
            $method_id = strtolower($shipping_method->get_method_id());
            if (strpos($method_id, 'local_pickup') !== false) {
                $order_type = 'local_pickup';
                break;
            } else {
                $order_type = 'shipping';
            }
        }
    }
    
    // Store as order meta for easy retrieval
    $order->update_meta_data('_la_order_type', $order_type);
    $order->save();
    
    // Add visible order note
    $type_labels = array(
        'donation' => 'Donation (no fulfillment)',
        'local_pickup' => 'Local Pickup (porch delivery)',
        'shipping' => 'Needs Shipping (pack and mail)'
    );
    
    $note = 'Order Type: ' . $type_labels[$order_type];
    $order->add_order_note($note);
}

/**
 * ENHANCED: Display order type prominently in admin order list
 */
add_filter('manage_edit-shop_order_columns', 'lexington_add_order_type_column', 20);
function lexington_add_order_type_column($columns) {
    $new_columns = array();
    
    foreach ($columns as $column_name => $column_info) {
        $new_columns[$column_name] = $column_info;
        
        // Add our column after order number
        if ('order_number' === $column_name) {
            $new_columns['order_type'] = 'Type';
        }
    }
    
    return $new_columns;
}

add_action('manage_shop_order_posts_custom_column', 'lexington_display_order_type_column', 10, 2);
function lexington_display_order_type_column($column, $post_id) {
    if ('order_type' === $column) {
        $order = wc_get_order($post_id);
        if (!$order) return;
        
        $order_type = $order->get_meta('_la_order_type');
        
        $type_display = array(
            'donation' => '<span style="background: #e8f4e8; color: #2d7c2d; padding: 3px 8px; border-radius: 3px; font-weight: bold; font-size: 11px;">DONATION</span>',
            'local_pickup' => '<span style="background: #fef5f5; color: #c3202e; padding: 3px 8px; border-radius: 3px; font-weight: bold; font-size: 11px;">PICKUP</span>',
            'shipping' => '<span style="background: #e8f4f8; color: #044f9d; padding: 3px 8px; border-radius: 3px; font-weight: bold; font-size: 11px;">⚠️ SHIP</span>'
        );
        
        echo $type_display[$order_type] ?? '<span style="color: #999;">—</span>';
    }
}

/**
 * ENHANCED: Add visual indicator to order details page
 */
add_action('woocommerce_admin_order_data_after_order_details', 'lexington_display_order_type_notice');
function lexington_display_order_type_notice($order) {
    $order_type = $order->get_meta('_la_order_type');
    
    if ($order_type === 'shipping') {
        echo '<div class="order-type-notice" style="background: #e8f4f8; border-left: 4px solid #044f9d; padding: 15px; margin: 20px 0;">';
        echo '<h4 style="margin-top: 0; color: #044f9d;">📦 SHIPPING ORDER - ACTION REQUIRED</h4>';
        echo '<p style="margin-bottom: 0;"><strong>This order needs to be packed and mailed.</strong><br>';
        echo 'Timeline: Ship by next business day with tracking.</p>';
        echo '</div>';
    } elseif ($order_type === 'local_pickup') {
        echo '<div class="order-type-notice" style="background: #fef5f5; border-left: 4px solid #c3202e; padding: 15px; margin: 20px 0;">';
        echo '<h4 style="margin-top: 0; color: #c3202e;">🏠 LOCAL PICKUP ORDER</h4>';
        echo '<p style="margin-bottom: 0;"><strong>Porch pickup in Lexington area.</strong><br>';
        echo 'Coordinator will be notified to arrange 24/7 pickup.</p>';
        echo '</div>';
    } elseif ($order_type === 'donation') {
        echo '<div class="order-type-notice" style="background: #e8f4e8; border-left: 4px solid #2d7c2d; padding: 15px; margin: 20px 0;">';
        echo '<h4 style="margin-top: 0; color: #2d7c2d;">💚 DONATION</h4>';
        echo '<p style="margin-bottom: 0;">No fulfillment required - monetary donation only.</p>';
        echo '</div>';
    }
}

/**
 * TEST FUNCTION - Enhanced testing interface
 * Access via: yourdomain.com/?test_order_type=true&order_id=XXX
 * Remove or comment out in production!
 */
add_action('init', 'lexington_test_order_type_detection');
function lexington_test_order_type_detection() {
    if (isset($_GET['test_order_type']) && current_user_can('manage_options')) {
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        
        if ($order_id) {
            $order = wc_get_order($order_id);
            if ($order) {
                echo '<html><head><title>Order Type Test</title></head><body>';
                echo '<h2>Order Type Detection Test - Order #' . $order_id . '</h2>';
                echo '<div style="background: #f7f9fa; padding: 20px; margin: 20px 0; border-radius: 5px;">';
                
                // Show current order type
                $stored_type = $order->get_meta('_la_order_type');
                echo '<h3>Current Order Type: <strong style="color: #044f9d;">' . strtoupper($stored_type) . '</strong></h3>';
                
                // Show shipping methods
                echo '<h3>Shipping Methods:</h3>';
                $shipping_methods = $order->get_shipping_methods();
                if (empty($shipping_methods)) {
                    echo '<p>No shipping methods (likely virtual/donation)</p>';
                } else {
                    echo '<ul>';
                    foreach ($shipping_methods as $method) {
                        echo '<li>' . $method->get_method_title() . ' (ID: ' . $method->get_method_id() . ')</li>';
                    }
                    echo '</ul>';
                }
                
                // Show products and categories
                echo '<h3>Products and Categories:</h3>';
                foreach ($order->get_items() as $item) {
                    $product = $item->get_product();
                    if (!$product) continue;
                    
                    echo '<div style="background: white; padding: 10px; margin: 10px 0; border-left: 3px solid #044f9d;">';
                    echo '<strong>' . $product->get_name() . '</strong><br>';
                    echo 'Virtual: ' . ($product->is_virtual() ? 'Yes' : 'No') . '<br>';
                    
                    $terms = get_the_terms($product->get_id(), 'product_cat');
                    if ($terms && !is_wp_error($terms)) {
                        echo 'Categories: ';
                        $cat_names = array();
                        foreach ($terms as $term) {
                            $cat_names[] = $term->name . ' (' . $term->slug . ')';
                        }
                        echo implode(', ', $cat_names) . '<br>';
                    }
                    
                    $shipping_class = $product->get_shipping_class();
                    echo 'Shipping Class: ' . ($shipping_class ?: 'None') . '<br>';
                    echo '</div>';
                }
                
                // Test the email subject line
                echo '<h3>Email Subject Test:</h3>';
                $original_subject = '[Lexington Alarm!]: You\'ve got a new order: #' . $order_id;
                $modified_subject = lexington_enhanced_email_subject($original_subject, $order);
                echo '<p><strong>Original:</strong> ' . esc_html($original_subject) . '</p>';
                echo '<p><strong>Modified:</strong> <span style="background: #e8f4f8; padding: 5px 10px; border-radius: 3px; font-weight: bold;">' . esc_html($modified_subject) . '</span></p>';
                
                echo '</div>';
                echo '</body></html>';
                exit;
            } else {
                echo 'Order not found.';
                exit;
            }
        }
        
        echo 'Please add ?test_order_type=true&order_id=XXX to test a specific order.';
        exit;
    }
}
