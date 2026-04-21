<?php
/**
 * Add Shipping Messages to WooCommerce Orders
 * This snippet adds "Ships next business day" messages to thank you pages and emails
 * Version: 1.0
 * 
 * INSTALLATION:
 * 1. Go to WordPress Admin > WPCode > Add Snippet
 * 2. Choose "Add Your Custom Code (New Snippet)" > PHP Snippet
 * 3. Name it: "Shipping Messages"
 * 4. Paste this entire code (without the <?php tag if WPCode adds it automatically)
 * 5. Set to "Run Everywhere"
 * 6. Activate the snippet
 */

/**
 * Add shipping message to the thank you page
 */
add_action('woocommerce_thankyou', 'lexington_add_shipping_message_thankyou', 5);
function lexington_add_shipping_message_thankyou($order_id) {
    $order = wc_get_order($order_id);
    if (!$order) return;
    
    // Check if order contains shipping items
    $has_shipping_items = false;
    $has_pickup_items = false;
    
    foreach ($order->get_items() as $item) {
        $product = $item->get_product();
        if (!$product) continue;
        
        // Check product categories
        $terms = get_the_terms($product->get_id(), 'product_cat');
        if ($terms && !is_wp_error($terms)) {
            foreach ($terms as $term) {
                $cat_slug = strtolower($term->slug);
                $cat_name = strtolower($term->name);
                
                if (strpos($cat_slug, 'shipping') !== false || strpos($cat_name, 'shipping') !== false) {
                    $has_shipping_items = true;
                }
                if (strpos($cat_slug, 'pickup') !== false || strpos($cat_name, 'local pickup') !== false) {
                    $has_pickup_items = true;
                }
            }
        }
    }
    
    // Also check shipping method
    $shipping_methods = $order->get_shipping_methods();
    foreach ($shipping_methods as $shipping_method) {
        if (strpos($shipping_method->get_method_id(), 'local_pickup') !== false) {
            $has_pickup_items = true;
        } else {
            $has_shipping_items = true;
        }
    }
    
    // Display appropriate message
    if ($has_shipping_items) {
        echo '<div class="woocommerce-info shipping-notice" style="background: #e8f4f8; border-left: 4px solid #044f9d; padding: 15px; margin: 20px 0;">';
        echo '<strong style="color: #044f9d;">📦 Shipping Information</strong><br>';
        echo 'Your order will ship by the next business day. You\'ll receive tracking information via email once your package is on its way.';
        echo '</div>';
    }
    
    if ($has_pickup_items) {
        echo '<div class="woocommerce-info pickup-notice" style="background: #f8e8e8; border-left: 4px solid #c3202e; padding: 15px; margin: 20px 0;">';
        echo '<strong style="color: #c3202e;">🏠 Local Pickup Information</strong><br>';
        echo 'You\'ll receive pickup instructions via email within 24 hours. Our signs are available for 24/7 porch pickup in Lexington.';
        echo '</div>';
    }
}

/**
 * Add shipping message to order confirmation emails
 */
add_action('woocommerce_email_before_order_table', 'lexington_add_shipping_message_email', 10, 4);
function lexington_add_shipping_message_email($order, $sent_to_admin, $plain_text, $email) {
    // Only add to customer emails, not admin
    if ($sent_to_admin) return;
    
    // Only add to processing and completed order emails
    $allowed_emails = array('customer_processing_order', 'customer_completed_order');
    if (!in_array($email->id, $allowed_emails)) return;
    
    $has_shipping_items = false;
    $has_pickup_items = false;
    
    foreach ($order->get_items() as $item) {
        $product = $item->get_product();
        if (!$product) continue;
        
        $terms = get_the_terms($product->get_id(), 'product_cat');
        if ($terms && !is_wp_error($terms)) {
            foreach ($terms as $term) {
                $cat_slug = strtolower($term->slug);
                $cat_name = strtolower($term->name);
                
                if (strpos($cat_slug, 'shipping') !== false || strpos($cat_name, 'shipping') !== false) {
                    $has_shipping_items = true;
                }
                if (strpos($cat_slug, 'pickup') !== false || strpos($cat_name, 'local pickup') !== false) {
                    $has_pickup_items = true;
                }
            }
        }
    }
    
    // Check shipping method
    $shipping_methods = $order->get_shipping_methods();
    foreach ($shipping_methods as $shipping_method) {
        if (strpos($shipping_method->get_method_id(), 'local_pickup') !== false) {
            $has_pickup_items = true;
        } else {
            $has_shipping_items = true;
        }
    }
    
    if ($plain_text) {
        // Plain text email format
        if ($has_shipping_items) {
            echo "\n======================\n";
            echo "SHIPPING INFORMATION\n";
            echo "======================\n";
            echo "Your order will ship by the next business day.\n";
            echo "You'll receive tracking information via email once your package is on its way.\n\n";
        }
        
        if ($has_pickup_items) {
            echo "\n======================\n";
            echo "LOCAL PICKUP INFORMATION\n";
            echo "======================\n";
            echo "You'll receive pickup instructions via email within 24 hours.\n";
            echo "Our signs are available for 24/7 porch pickup in Lexington.\n\n";
        }
    } else {
        // HTML email format
        if ($has_shipping_items) {
            echo '<div style="background: #e8f4f8; border: 1px solid #d1e5ee; padding: 15px; margin: 20px 0; border-radius: 5px;">';
            echo '<h3 style="color: #044f9d; margin-top: 0;">📦 Shipping Information</h3>';
            echo '<p style="margin-bottom: 0;">Your order will ship by the next business day. You\'ll receive tracking information via email once your package is on its way.</p>';
            echo '</div>';
        }
        
        if ($has_pickup_items) {
            echo '<div style="background: #fef5f5; border: 1px solid #f5d1d1; padding: 15px; margin: 20px 0; border-radius: 5px;">';
            echo '<h3 style="color: #c3202e; margin-top: 0;">🏠 Local Pickup Information</h3>';
            echo '<p style="margin-bottom: 0;">You\'ll receive pickup instructions via email within 24 hours. Our signs are available for 24/7 porch pickup in Lexington.</p>';
            echo '</div>';
        }
    }
}

/**
 * Add shipping/pickup info to individual product items in cart and checkout
 */
add_filter('woocommerce_get_item_data', 'lexington_add_fulfillment_info_to_cart', 10, 2);
function lexington_add_fulfillment_info_to_cart($item_data, $cart_item) {
    if (!isset($cart_item['product_id'])) return $item_data;
    
    $product = wc_get_product($cart_item['product_id']);
    if (!$product) return $item_data;
    
    $terms = get_the_terms($product->get_id(), 'product_cat');
    if ($terms && !is_wp_error($terms)) {
        foreach ($terms as $term) {
            $cat_slug = strtolower($term->slug);
            $cat_name = strtolower($term->name);
            
            if (strpos($cat_slug, 'shipping') !== false || strpos($cat_name, 'shipping') !== false) {
                $item_data[] = array(
                    'key'   => 'Fulfillment',
                    'value' => 'Ships next business day'
                );
                break;
            } elseif (strpos($cat_slug, 'pickup') !== false || strpos($cat_name, 'local pickup') !== false) {
                $item_data[] = array(
                    'key'   => 'Fulfillment',
                    'value' => 'Local pickup (Lexington)'
                );
                break;
            }
        }
    }
    
    return $item_data;
}

/**
 * Add a general shipping notice to the checkout page
 */
add_action('woocommerce_review_order_before_payment', 'lexington_checkout_shipping_notice');
function lexington_checkout_shipping_notice() {
    ?>
    <div class="checkout-shipping-notice" style="background: #f7f9fa; border: 1px solid #ddd; padding: 15px; margin: 20px 0; border-radius: 5px;">
        <p style="margin: 0;"><strong>Fulfillment Information:</strong></p>
        <ul style="margin: 10px 0 0 20px;">
            <li><strong>Shipping orders:</strong> Ship next business day with tracking</li>
            <li><strong>Local pickup:</strong> 24/7 porch pickup in Lexington (instructions sent within 24 hours)</li>
        </ul>
    </div>
    <?php
}
