# Local Pickup Handler - Complete Code

**Snippet Name:** Local Pickup Handler  
**Status:** Active  
**Last Updated:** December 11, 2025

---

## Purpose

Manages checkout behavior for different product types:
- Virtual products (donations) → No shipping fields
- Local pickup products → No shipping fields, shows pickup notice
- Shipped products → Normal shipping address fields
- Adds printable pickup checklist to admin emails

---

## Complete Code

```php
/**
 * Local Pickup Handler for Lexington Alarm
 * Handles checkout fields, notices, and admin email checklists
 * Supports: Virtual products, Local pickup, Shipped items
 */

// Remove shipping fields when local pickup is the only option
add_filter('woocommerce_checkout_fields', 'remove_shipping_for_local_pickup_only');
function remove_shipping_for_local_pickup_only($fields) {
    $available_methods = WC()->shipping()->get_packages();
    
    $only_local_pickup = true;
    if (!empty($available_methods) && !empty($available_methods[0]['rates'])) {
        foreach ($available_methods[0]['rates'] as $rate) {
            if ($rate->method_id !== 'local_pickup') {
                $only_local_pickup = false;
                break;
            }
        }
    }
    
    if ($only_local_pickup) {
        unset($fields['shipping']);
    }
    
    return $fields;
}

// Determine if cart needs shipping (skip virtual products)
add_filter('woocommerce_cart_needs_shipping', 'disable_shipping_for_pickup_and_virtual');
function disable_shipping_for_pickup_and_virtual($needs_shipping) {
    foreach (WC()->cart->get_cart() as $cart_item) {
        $product = $cart_item['data'];
        
        // Skip virtual products - they never need shipping
        if ($product->is_virtual()) {
            continue;
        }
        
        // Physical product - check shipping class
        $shipping_class = $product->get_shipping_class();
        
        // If NOT local pickup, shipping is needed
        if ($shipping_class !== 'local_pickup') {
            return true;
        }
    }
    
    // All products are virtual or local pickup
    return false;
}

// Determine if cart needs shipping address (skip virtual products)
add_filter('woocommerce_cart_needs_shipping_address', 'disable_shipping_address_for_virtual_and_pickup', 99);
function disable_shipping_address_for_virtual_and_pickup($needs_address) {
    foreach (WC()->cart->get_cart() as $cart_item) {
        $product = $cart_item['data'];
        
        // Skip virtual products
        if ($product->is_virtual()) {
            continue;
        }
        
        // Physical product - check shipping class
        $shipping_class = $product->get_shipping_class();
        
        // If NOT local pickup, address is needed
        if ($shipping_class !== 'local_pickup') {
            return true;
        }
    }
    
    return false;
}

// Simplify billing fields for virtual/pickup orders
add_filter('woocommerce_billing_fields', 'simplify_billing_for_local_pickup', 20);
function simplify_billing_for_local_pickup($fields) {
    if (!WC()->cart->needs_shipping()) {
        if (isset($fields['billing_address_1'])) {
            $fields['billing_address_1']['required'] = false;
        }
        if (isset($fields['billing_postcode'])) {
            $fields['billing_postcode']['required'] = false;
        }
        if (isset($fields['billing_state'])) {
            $fields['billing_state']['required'] = false;
        }
        if (isset($fields['billing_city'])) {
            $fields['billing_city']['label'] = 'Your Town';
            $fields['billing_city']['placeholder'] = 'e.g., Lexington, Arlington';
        }
    }
    
    return $fields;
}

// Add notice for local pickup orders (not donations)
add_action('woocommerce_before_checkout_billing_form', 'add_local_pickup_notice');
function add_local_pickup_notice() {
    if (!WC()->cart->needs_shipping()) {
        $has_physical_pickup = false;
        foreach (WC()->cart->get_cart() as $cart_item) {
            $product = $cart_item['data'];
            if (!$product->is_virtual() && $product->get_shipping_class() === 'local_pickup') {
                $has_physical_pickup = true;
                break;
            }
        }
        
        if ($has_physical_pickup) {
            echo '<div style="background: #e8f4f8; border-left: 4px solid #044f9d; padding: 15px; margin-bottom: 20px;">';
            echo '<strong>🏠 Local Pickup Order</strong><br>';
            echo 'Thank you for your sign order. You will receive an email with the current address for local pickup in Lexington.<br>';
            echo '<strong>Please check off your name upon pickup.</strong>';
            echo '</div>';
        }
    }
}

// Add printable pickup checklist to admin order emails
add_action('woocommerce_email_order_details', 'add_pickup_checklist_to_admin_email', 5, 4);
function add_pickup_checklist_to_admin_email($order, $sent_to_admin, $plain_text, $email) {
    if (!$sent_to_admin) return;
    
    $has_local_pickup = false;
    foreach ($order->get_items() as $item) {
        $product = $item->get_product();
        if ($product && $product->get_shipping_class() === 'local_pickup') {
            $has_local_pickup = true;
            break;
        }
    }
    
    if ($has_local_pickup && !$plain_text) {
        $customer_name = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
        $customer_phone = $order->get_billing_phone();
        $customer_email = $order->get_billing_email();
        $customer_city = $order->get_billing_city();
        ?>
        <div style="border: 2px dashed #ccc; padding: 20px; margin: 20px 0; background: #f9f9f9;">
            <h2 style="color: #c3202e; margin-top: 0;">📋 PICKUP CHECKLIST - Print & Place with Order</h2>
            <div style="border: 1px solid #333; padding: 15px; background: white;">
                <h3 style="margin-top: 0;">Order #<?php echo $order->get_order_number(); ?></h3>
                <p style="font-size: 16px; margin: 10px 0;">
                    <strong>Customer:</strong> <?php echo esc_html($customer_name); ?><br>
                    <strong>Town:</strong> <?php echo esc_html($customer_city); ?><br>
                    <strong>Phone:</strong> <?php echo esc_html($customer_phone); ?><br>
                    <strong>Email:</strong> <?php echo esc_html($customer_email); ?>
                </p>
                <p style="font-size: 14px; margin: 15px 0;">
                    <strong>Items:</strong><br>
                    <?php
                    foreach ($order->get_items() as $item) {
                        echo '• ' . esc_html($item->get_name()) . ' (Qty: ' . $item->get_quantity() . ')<br>';
                    }
                    ?>
                </p>
                <div style="border: 2px solid #044f9d; padding: 15px; margin-top: 20px; background: #f0f8ff;">
                    <p style="font-size: 18px; margin: 0;"><strong>PICKUP CONFIRMATION:</strong></p>
                    <p style="font-size: 16px; margin: 10px 0;">☐ Signs picked up by: _______________________</p>
                    <p style="font-size: 16px; margin: 10px 0;">Date: _____________ Time: _____________</p>
                </div>
            </div>
            <p style="margin-top: 15px; font-style: italic; color: #666;">
                Print this checklist and place with the order for porch pickup.
            </p>
        </div>
        <?php
    }
}
```

---

## Functions Summary

| Function | Hook | Purpose |
|----------|------|---------|
| `remove_shipping_for_local_pickup_only` | `woocommerce_checkout_fields` | Removes shipping fields when only local pickup available |
| `disable_shipping_for_pickup_and_virtual` | `woocommerce_cart_needs_shipping` | Returns false for virtual/pickup-only carts |
| `disable_shipping_address_for_virtual_and_pickup` | `woocommerce_cart_needs_shipping_address` | Returns false for virtual/pickup-only carts |
| `simplify_billing_for_local_pickup` | `woocommerce_billing_fields` | Makes address fields optional for pickup |
| `add_local_pickup_notice` | `woocommerce_before_checkout_billing_form` | Shows pickup info box (not for donations) |
| `add_pickup_checklist_to_admin_email` | `woocommerce_email_order_details` | Adds printable checklist to admin emails |

---

## Shipping Class Requirements

- Local pickup products must have shipping class: `local_pickup`
- Donations must have "Virtual" checkbox checked on all variations
- Shipped products should have shipping class: `ships_nationwide` or similar

---

**Document Version:** 1.0  
**Last Updated:** December 11, 2025
