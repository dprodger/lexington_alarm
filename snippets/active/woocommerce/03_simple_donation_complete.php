<?php
/**
 * Lexington Alarm - Simple Donation Product with Amount Selector
 * Works with SIMPLE product type (not variable)
 * Product must be named exactly: "Donate to Lexington Alarm"
 */

// Add donation amount selector to simple product page
add_action('woocommerce_before_add_to_cart_button', 'lexington_simple_donation_selector');
function lexington_simple_donation_selector() {
    global $product;
    
    // Only show on our donation product
    if ($product->get_name() == 'Donate to Lexington Alarm' && $product->is_type('simple')) {
        ?>
        <div class="donation-amount-selector" style="margin-bottom: 20px;">
            <label for="donation_amount" style="display: block; margin-bottom: 8px; font-weight: bold;">
                Select Donation Amount:
            </label>
            <select name="donation_amount" id="donation_amount" required 
                    style="width: 100%; padding: 10px; border: 2px solid #044f9d; border-radius: 4px; font-size: 16px;">
                <option value="">Choose an amount...</option>
                <option value="5">$5</option>
                <option value="10">$10</option>
                <option value="25" selected>$25</option>
                <option value="50">$50</option>
                <option value="100">$100</option>
                <option value="250">$250</option>
                <option value="other">Other Amount (minimum $5)</option>
            </select>
            
            <div class="custom-amount-field" style="display:none; margin-top: 15px;">
                <label for="custom_amount" style="display: block; margin-bottom: 8px;">
                    Enter custom amount (minimum $5):
                </label>
                <div style="display: flex; align-items: center;">
                    <span style="font-size: 20px; margin-right: 5px;">$</span>
                    <input type="number" id="custom_amount" name="custom_amount" 
                           min="5" step="1" placeholder="Enter amount"
                           style="width: 100%; padding: 10px; border: 2px solid #044f9d; border-radius: 4px; font-size: 16px;">
                </div>

            </div>
        </div>
        
        <script>
        jQuery(document).ready(function($) {
            // Handle donation amount selection
            $('#donation_amount').change(function() {
                var selectedValue = $(this).val();
                
                if (selectedValue === 'other') {
                    $('.custom-amount-field').slideDown();
                    $('#custom_amount').prop('required', true);
                } else if (selectedValue) {
                    $('.custom-amount-field').slideUp();
                    $('#custom_amount').prop('required', false).val('');
                    
                    // Update displayed price
                    updateDisplayPrice(selectedValue);
                }
            });
            
            // Update price as user types custom amount
            $('#custom_amount').on('input', function() {
                var amount = $(this).val();
                if (amount && amount >= 5) {
                    updateDisplayPrice(amount);
                }
            });
            
            // Function to update displayed price
            function updateDisplayPrice(amount) {
                $('.woocommerce-Price-amount bdi').html(
                    '<span class="woocommerce-Price-currencySymbol">$</span>' + 
                    parseFloat(amount).toFixed(2)
                );
            }
            
            // Validate before adding to cart
            $('form.cart').on('submit', function(e) {
                var donationAmount = $('#donation_amount').val();
                
                if (!donationAmount) {
                    alert('Please select a donation amount.');
                    e.preventDefault();
                    return false;
                }
                
                if (donationAmount === 'other') {
                    var customAmount = $('#custom_amount').val();
                    if (!customAmount || customAmount < 5) {
                        alert('Please enter a custom amount of at least $5.');
                        e.preventDefault();
                        return false;
                    }
                }
            });
        });
        </script>
        <?php
    }
}

// Save donation amount to cart item data
add_filter('woocommerce_add_cart_item_data', 'save_donation_amount', 10, 2);
function save_donation_amount($cart_item_data, $product_id) {
    $product = wc_get_product($product_id);
    
    if ($product && $product->get_name() == 'Donate to Lexington Alarm') {
        if (isset($_POST['donation_amount'])) {
            $amount = $_POST['donation_amount'];
            
            if ($amount === 'other' && isset($_POST['custom_amount'])) {
                $final_amount = max(5, intval($_POST['custom_amount']));
            } else {
                $final_amount = intval($amount);
            }
            
            $cart_item_data['donation_amount'] = $final_amount;
            $cart_item_data['unique_key'] = md5(microtime().rand());
        }
    }
    
    return $cart_item_data;
}

// Update price in cart based on selected donation amount
add_action('woocommerce_before_calculate_totals', 'update_donation_price_in_cart', 99, 1);
function update_donation_price_in_cart($cart) {
    // Only run once
    if (is_admin() && !defined('DOING_AJAX')) return;
    if (did_action('woocommerce_before_calculate_totals') >= 2) return;
    
    foreach ($cart->get_cart() as $cart_item) {
        if (isset($cart_item['donation_amount'])) {
            $cart_item['data']->set_price($cart_item['donation_amount']);
        }
    }
}

// Display donation amount in cart and checkout
add_filter('woocommerce_get_item_data', 'display_donation_amount_in_cart', 10, 2);
function display_donation_amount_in_cart($item_data, $cart_item) {
    if (isset($cart_item['donation_amount'])) {
        $item_data[] = array(
            'name' => 'Donation Amount',
            'value' => wc_price($cart_item['donation_amount'])
        );
    }
    return $item_data;
}

// Save donation amount to order
add_action('woocommerce_checkout_create_order_line_item', 'save_donation_to_order', 10, 4);
function save_donation_to_order($item, $cart_item_key, $values, $order) {
    if (isset($values['donation_amount'])) {
        $item->add_meta_data('Donation Amount', wc_price($values['donation_amount']));
    }
}

// Fix cart item price display
add_filter('woocommerce_cart_item_price', 'fix_donation_cart_price', 10, 3);
function fix_donation_cart_price($price, $cart_item, $cart_item_key) {
    if (isset($cart_item['donation_amount'])) {
        return wc_price($cart_item['donation_amount']);
    }
    return $price;
}

// Fix cart item subtotal
add_filter('woocommerce_cart_item_subtotal', 'fix_donation_cart_subtotal', 10, 3);
function fix_donation_cart_subtotal($subtotal, $cart_item, $cart_item_key) {
    if (isset($cart_item['donation_amount'])) {
        $quantity = $cart_item['quantity'];
        return wc_price($cart_item['donation_amount'] * $quantity);
    }
    return $subtotal;
}

// Hide quantity selector for donation product
add_filter('woocommerce_quantity_input_args', 'hide_donation_quantity', 10, 2);
function hide_donation_quantity($args, $product) {
    if ($product && $product->get_name() == 'Donate to Lexington Alarm') {
        $args['max_value'] = 1;
        $args['min_value'] = 1;
        $args['step'] = 1;
    }
    return $args;
}

// Add CSS to hide quantity field for donation product
add_action('wp_head', 'donation_custom_css');
function donation_custom_css() {
    ?>
    <style>
    .post-type-product .product-type-simple.product-donate-to-lexington-alarm .quantity {
        display: none !important;
    }
    .donation-amount-selector {
        clear: both;
        margin: 20px 0;
    }
    </style>
    <?php
}