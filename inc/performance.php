<?php

// ACF options are small, but repeaters otherwise read each subfield separately.
// Prime WordPress' normal option cache without changing values or autoload flags.
function main_theme_prime_acf_options() {
    if (wp_using_ext_object_cache()) {
        return;
    }

    global $wpdb;

    $options = $wpdb->get_results($wpdb->prepare(
        "SELECT option_name, option_value FROM {$wpdb->options} WHERE option_name LIKE %s OR option_name LIKE %s",
        $wpdb->esc_like('options_') . '%',
        $wpdb->esc_like('_options_') . '%'
    ), OBJECT_K);

    wp_cache_add_multiple(wp_list_pluck($options, 'option_value', 'option_name'), 'options');
}
add_action('template_redirect', 'main_theme_prime_acf_options', 1);

// Load the current product loop's image records together, including AJAX loops.
function main_theme_prime_product_thumbnails($query) {
    if (isset($query->posts[0]->post_type) && $query->posts[0]->post_type === 'product') {
        update_post_thumbnail_cache($query);
    }
}
add_action('loop_start', 'main_theme_prime_product_thumbnails');

// The theme renders filters in catalogue templates; content and widgets are
// detected by the plugin before this hook runs.
function main_theme_should_load_filter_assets($load, $filter_ids) {
    return $load && (!empty($filter_ids) || is_shop() || is_product_taxonomy() || is_search());
}
add_filter('wpf_enqueue_frontend_assets', 'main_theme_should_load_filter_assets', 10, 2);

// Carry the current catalogue's ordering into its AJAX product query.
function main_theme_filter_query_settings($settings) {
    global $wp_query;

    $settings['main_theme_sort'] = array(
        'custom'   => (int) (bool) $wp_query->get('main_theme_catalog_sort'),
        'orderby'  => $wp_query->get('orderby'),
        'order'    => $wp_query->get('order'),
        'meta_key' => $wp_query->get('meta_key'),
    );

    return $settings;
}
add_filter('wpf_frontend_query_settings', 'main_theme_filter_query_settings');

function main_theme_filter_product_query_args($args, $query_settings) {
    // Existing cached pages may still send the old payload without this key.
    if (empty($query_settings['main_theme_sort'])) {
        return $args;
    }

    $sort = $query_settings['main_theme_sort'];
    $args['main_theme_catalog_sort'] = !empty($sort['custom']);
    $args['orderby'] = $sort['orderby'];
    $args['order'] = $sort['order'];
    $args['meta_key'] = $sort['meta_key'];

    return $args;
}
add_filter('wpf_frontend_product_query_args', 'main_theme_filter_product_query_args', 10, 2);

function main_theme_filter_catalog_sort_clauses($clauses, $query) {
    // The filter plugin clears posts_clauses when it prepares AJAX ordering.
    return wp_doing_ajax() ? main_theme_catalog_sort_posts_clauses($clauses, $query) : $clauses;
}
add_filter('posts_clauses_request', 'main_theme_filter_catalog_sort_clauses', 20, 2);
