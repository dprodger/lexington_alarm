<?php
/**
 * Add category to new order email - CORRECTED VERSION
 * Fixed: Undefined variable $product error
 */

// Add category label to WooCommerce order email subjects
add_filter('woocommerce_email_subject_new_order', 'add_category_label_to_subject', 10, 2);
function add_category_label_to_subject($subject, $order) {
    if (!$order) return $subject;
    
    $prefix = '';
    $categories_found = array();
    
    // Check all products in the order
    foreach ($order->get_items() as $item) {
        $product = $item->get_product();
        
        if (!$product) continue; // Skip if product not found
        
        // Get product categories
        $terms = wp_get_post_terms($product->get_id(), 'product_cat', array('fields' => 'slugs'));
        
        // Determine which category this product belongs to
        if (empty($terms) || in_array('uncategorized', $terms)) {
            // No category = uncategorized (treating as donation)
            $categories_found[] = 'UNCATEGORIZED/DONATION';
        } elseif (in_array('donation', $terms)) {
            $categories_found[] = 'DONATION';
        } elseif (in_array('local_pickup', $terms) || in_array('local-pickup', $terms)) {
            $categories_found[] = 'LOCAL PICKUP';
        } elseif (in_array('shipping', $terms)) {
            $categories_found[] = 'SHIPPING';
        }
    }
    
    // Remove duplicates and create prefix
    $categories_found = array_unique($categories_found);
    
    if (!empty($categories_found)) {
        $prefix = '[' . implode(' + ', $categories_found) . ']';
    }
    
    // Add prefix to subject
    if ($prefix) {
        $subject = $prefix . ' ' . $subject;
    }
    
    return $subject;
}

// Also add to customer processing emails
add_filter('woocommerce_email_subject_customer_processing_order', 'add_category_label_to_subject', 10, 2);

// Optional: Also add to admin emails about completed orders
add_filter('woocommerce_email_subject_customer_completed_order', 'add_category_label_to_subject', 10, 2);