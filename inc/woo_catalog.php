<?php

function custom_image_sizes() {
    add_image_size('offer-size', 900, 0, false);
}
add_action('after_setup_theme', 'custom_image_sizes');

remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
remove_action('woocommerce_shop_loop_header', 'woocommerce_product_taxonomy_archive_header', 10);
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);

/**
 * AJAX endpoint for cookie-based mini-cart.
 * Accepts a list of product IDs and returns lightweight product payload.
 */
function get_cookie_cart_products() {
    if (!function_exists('wc_get_product')) {
        wp_send_json(array());
    }

    $raw_ids = isset($_POST['product_ids']) ? (array) wp_unslash($_POST['product_ids']) : array();

    if (empty($raw_ids)) {
        wp_send_json(array());
    }

    $product_ids = array_values(array_unique(array_filter(array_map('intval', $raw_ids))));

    if (empty($product_ids)) {
        wp_send_json(array());
    }

    $products_payload = array();

    foreach ($product_ids as $product_id) {
        $product = wc_get_product($product_id);

        if (!$product || !$product->exists() || get_post_status($product_id) !== 'publish') {
            continue;
        }

        $products_payload[] = array(
            'product_id'   => $product_id,
            'product_name' => $product->get_name(),
            'sku'          => $product->get_sku(),
            'product_link' => get_permalink($product_id),
            'thumbnail'    => get_the_post_thumbnail_url($product_id, 'thumbnail'),
            'napryazhenie' => $product->get_attribute('pa_napryazhenie'),
            'emkost'       => $product->get_attribute('pa_emkost-ah'),
            'price'        => $product->get_price(),
        );
    }

    wp_send_json($products_payload);
}

add_action('wp_ajax_get_cookie_cart_products', 'get_cookie_cart_products');
add_action('wp_ajax_nopriv_get_cookie_cart_products', 'get_cookie_cart_products');
