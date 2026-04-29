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

if (!function_exists('main_theme_get_catalog_view_cookie_name')) {
    function main_theme_get_catalog_view_cookie_name() {
        return 'neter_catalog_view';
    }
}

if (!function_exists('main_theme_get_catalog_view')) {
    function main_theme_get_catalog_view() {
        $cookie_name = main_theme_get_catalog_view_cookie_name();
        $view = isset($_COOKIE[$cookie_name]) ? sanitize_key((string) wp_unslash($_COOKIE[$cookie_name])) : 'table';

        return in_array($view, array('table', 'cards'), true) ? $view : 'table';
    }
}

if (!function_exists('main_theme_get_product_attribute_values')) {
    function main_theme_get_product_attribute_values($product, $attribute_slug, $field = 'names') {
        if (!is_a($product, 'WC_Product')) {
            return array();
        }

        $attribute_slug = sanitize_key((string) $attribute_slug);
        $field = $field === 'slugs' ? 'slugs' : 'names';
        $values = array();
        $attributes = $product->get_attributes();

        if (isset($attributes[$attribute_slug]) && is_a($attributes[$attribute_slug], 'WC_Product_Attribute')) {
            $attribute = $attributes[$attribute_slug];

            if ($attribute->is_taxonomy()) {
                $taxonomy = $attribute->get_name();

                foreach ($attribute->get_options() as $term_id) {
                    $term = get_term((int) $term_id, $taxonomy);

                    if ($term && !is_wp_error($term)) {
                        $values[] = $field === 'slugs' ? $term->slug : $term->name;
                    }
                }
            } else {
                foreach ($attribute->get_options() as $option) {
                    $option = trim((string) $option);

                    if ($option !== '') {
                        $values[] = $field === 'slugs' ? sanitize_title($option) : $option;
                    }
                }
            }
        } elseif (taxonomy_exists($attribute_slug)) {
            $terms = get_the_terms($product->get_id(), $attribute_slug);

            if (!is_wp_error($terms) && !empty($terms)) {
                foreach ($terms as $term) {
                    $values[] = $field === 'slugs' ? $term->slug : $term->name;
                }
            }
        }

        if (empty($values)) {
            $raw_value = trim((string) $product->get_attribute($attribute_slug));

            if ($raw_value !== '') {
                $values = array_map('trim', explode(',', $raw_value));

                if ($field === 'slugs') {
                    $values = array_map('sanitize_title', $values);
                }
            }
        }

        return array_values(array_filter(array_unique($values), 'strlen'));
    }
}

if (!function_exists('main_theme_should_render_catalog_cards_loop')) {
    function main_theme_should_render_catalog_cards_loop() {
        if (main_theme_get_catalog_view() !== 'cards') {
            return false;
        }

        if (is_search() || isset($_GET['s']) || isset($_REQUEST['s'])) {
            return false;
        }

        $request_url = isset($_SERVER['REQUEST_URI']) ? (string) $_SERVER['REQUEST_URI'] : '';
        $referer_url = isset($_SERVER['HTTP_REFERER']) ? (string) $_SERVER['HTTP_REFERER'] : '';
        $search_pattern = '/(?:[?&]s=|\/\?s=)/';

        return !preg_match($search_pattern, $request_url) && !preg_match($search_pattern, $referer_url);
    }
}

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

if (!function_exists('main_theme_get_compare_cookie_name')) {
    function main_theme_get_compare_cookie_name() {
        return 'neter_compare_products';
    }
}

if (!function_exists('main_theme_get_compare_product_ids_from_cookie')) {
    function main_theme_get_compare_product_ids_from_cookie() {
        $cookie_name = main_theme_get_compare_cookie_name();

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

if (!function_exists('main_theme_get_valid_compare_product_ids')) {
    function main_theme_get_valid_compare_product_ids($product_ids) {
        return main_theme_get_valid_featured_product_ids($product_ids);
    }
}

function main_theme_validate_compare_products_ajax() {
    $raw_ids = isset($_POST['product_ids']) ? wp_unslash($_POST['product_ids']) : array();

    if (!is_array($raw_ids)) {
        $decoded_ids = json_decode(rawurldecode((string) $raw_ids), true);
        $raw_ids = is_array($decoded_ids) ? $decoded_ids : array_filter(array_map('trim', explode(',', (string) $raw_ids)));
    }

    $product_ids = main_theme_normalize_featured_product_ids($raw_ids);
    $valid_ids = main_theme_get_valid_compare_product_ids($product_ids);

    wp_send_json_success(array(
        'product_ids' => $valid_ids,
    ));
}

add_action('wp_ajax_validate_compare_products', 'main_theme_validate_compare_products_ajax');
add_action('wp_ajax_nopriv_validate_compare_products', 'main_theme_validate_compare_products_ajax');

if (!function_exists('main_theme_should_exclude_compare_attribute_label')) {
    function main_theme_should_exclude_compare_attribute_label($label) {
        $label = trim(wp_strip_all_tags((string) $label));

        if ($label === '') {
            return true;
        }

        $normalized_label = function_exists('mb_strtolower') ? mb_strtolower($label) : strtolower($label);
        $normalized_label = preg_replace('/\s+/u', ' ', $normalized_label);

        $excluded_labels = array(
            'сфера применения',
            'сфера примения',
            'стоимость',
            'строимость',
        );

        if (in_array($normalized_label, $excluded_labels, true)) {
            return true;
        }

        return (bool) preg_match('/\([^)]*переклиновка[^)]*\)/iu', $label);
    }
}

if (!function_exists('main_theme_get_compare_attribute_rows')) {
    function main_theme_get_compare_attribute_rows($products) {
        if (empty($products) || !is_array($products)) {
            return array();
        }

        $rows = array();
        $known_attribute_keys = array();

        foreach ($products as $product) {
            if (!$product instanceof WC_Product) {
                continue;
            }

            foreach ($product->get_attributes() as $attribute_key => $attribute) {
                $attribute_name = $attribute_key;

                if ($attribute instanceof WC_Product_Attribute) {
                    if (!$attribute->get_visible()) {
                        continue;
                    }

                    $attribute_name = $attribute->get_name();
                }

                $attribute_name = (string) $attribute_name;

                if ($attribute_name === '' || isset($known_attribute_keys[$attribute_name])) {
                    continue;
                }

                $attribute_label = wc_attribute_label($attribute_name, $product);

                if (main_theme_should_exclude_compare_attribute_label($attribute_label)) {
                    continue;
                }

                $known_attribute_keys[$attribute_name] = true;
                $rows[] = array(
                    'key'        => $attribute_name,
                    'label'      => $attribute_label,
                    'is_price'   => false,
                    'values'     => array(),
                    'different'  => false,
                );
            }
        }

        if (!main_theme_should_exclude_compare_attribute_label('Стоимость')) {
            $rows[] = array(
                'key'        => '_compare_price',
                'label'      => 'Стоимость',
                'is_price'   => true,
                'values'     => array(),
                'different'  => false,
            );
        }

        foreach ($rows as $row_index => $row) {
            $normalized_values = array();

            foreach ($products as $product) {
                if (!$product instanceof WC_Product) {
                    continue;
                }

                $product_id = $product->get_id();
                $value = '-';
                $is_html = false;

                if (!empty($row['is_price'])) {
                    if ((float) $product->get_price() !== 1.0 && $product->get_price_html()) {
                        $value = $product->get_price_html();
                        $is_html = true;
                    }
                } else {
                    $attribute_value = trim((string) $product->get_attribute($row['key']));

                    if ($attribute_value !== '') {
                        $value = $attribute_value;
                    }
                }

                $rows[$row_index]['values'][$product_id] = array(
                    'value'   => $value,
                    'is_html' => $is_html,
                );

                $normalized_values[] = trim(wp_strip_all_tags((string) $value));
            }

            $rows[$row_index]['different'] = count(array_unique($normalized_values)) > 1;
        }

        return $rows;
    }
}
