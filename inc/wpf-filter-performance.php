<?php

defined('ABSPATH') || exit;

if (!function_exists('main_theme_enqueue_wpf_filter_performance')) {
    function main_theme_enqueue_wpf_filter_performance() {
        if (is_admin()) {
            return;
        }

        $is_catalog = function_exists('is_shop') && is_shop();

        if (!$is_catalog && function_exists('is_product_taxonomy')) {
            $is_catalog = is_product_taxonomy();
        }

        if (!$is_catalog) {
            return;
        }

        $script_path = get_template_directory() . '/js/wpf-filter-performance.js';

        if (!file_exists($script_path)) {
            return;
        }

        wp_enqueue_script(
            'main-theme-wpf-filter-performance',
            get_template_directory_uri() . '/js/wpf-filter-performance.js',
            array('jquery', 'main'),
            filemtime($script_path),
            true
        );
    }
}

add_action('wp_enqueue_scripts', 'main_theme_enqueue_wpf_filter_performance', 40);
