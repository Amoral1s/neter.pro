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

if (!function_exists('main_theme_get_featured_cookie_name')) {
    function main_theme_get_featured_cookie_name() {
        return 'neter_featured_products';
    }
}

if (!function_exists('main_theme_normalize_featured_product_ids')) {
    function main_theme_normalize_featured_product_ids($raw_ids) {
        if (!is_array($raw_ids)) {
            return array();
        }

        $product_ids = array();

        foreach ($raw_ids as $raw_id) {
            if (is_array($raw_id)) {
                $raw_id = isset($raw_id['product_id']) ? $raw_id['product_id'] : 0;
            }

            $product_id = absint($raw_id);

            if ($product_id && !in_array($product_id, $product_ids, true)) {
                $product_ids[] = $product_id;
            }
        }

        return $product_ids;
    }
}

if (!function_exists('main_theme_get_featured_product_ids_from_cookie')) {
    function main_theme_get_featured_product_ids_from_cookie() {
        $cookie_name = main_theme_get_featured_cookie_name();

        if (empty($_COOKIE[$cookie_name])) {
            return array();
        }

        $cookie_value = rawurldecode((string) wp_unslash($_COOKIE[$cookie_name]));
        $decoded_value = json_decode($cookie_value, true);

        if (is_array($decoded_value)) {
            return main_theme_normalize_featured_product_ids($decoded_value);
        }

        $csv_ids = array_filter(array_map('trim', explode(',', $cookie_value)));

        return main_theme_normalize_featured_product_ids($csv_ids);
    }
}

if (!function_exists('main_theme_get_valid_featured_product_ids')) {
    function main_theme_get_valid_featured_product_ids($product_ids) {
        if (!function_exists('wc_get_product')) {
            return array();
        }

        $product_ids = main_theme_normalize_featured_product_ids($product_ids);

        if (empty($product_ids)) {
            return array();
        }

        $products_query = new WP_Query(array(
            'post_type'              => 'product',
            'post_status'            => 'publish',
            'posts_per_page'         => count($product_ids),
            'post__in'               => $product_ids,
            'orderby'                => 'post__in',
            'no_found_rows'          => true,
            'ignore_sticky_posts'    => true,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
        ));

        $valid_ids = array();

        foreach ($products_query->posts as $product_post) {
            $product = wc_get_product($product_post->ID);

            if ($product && $product->exists() && $product->is_visible()) {
                $valid_ids[] = (int) $product_post->ID;
            }
        }

        wp_reset_postdata();

        return $valid_ids;
    }
}

function main_theme_validate_featured_products_ajax() {
    $raw_ids = isset($_POST['product_ids']) ? wp_unslash($_POST['product_ids']) : array();

    if (!is_array($raw_ids)) {
        $decoded_ids = json_decode(rawurldecode((string) $raw_ids), true);
        $raw_ids = is_array($decoded_ids) ? $decoded_ids : array_filter(array_map('trim', explode(',', (string) $raw_ids)));
    }

    $product_ids = main_theme_normalize_featured_product_ids($raw_ids);
    $valid_ids = main_theme_get_valid_featured_product_ids($product_ids);

    wp_send_json_success(array(
        'product_ids' => $valid_ids,
    ));
}

add_action('wp_ajax_validate_featured_products', 'main_theme_validate_featured_products_ajax');
add_action('wp_ajax_nopriv_validate_featured_products', 'main_theme_validate_featured_products_ajax');
