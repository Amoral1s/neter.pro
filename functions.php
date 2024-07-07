<?php
@include('inc/main.php');
@include('inc/posts.php');
@include('inc/seo.php');
@include('inc/shortcodes.php');
@include('inc/acf_blocks.php');
@include('inc/unisender.php');
@include('inc/woocommerce.php');
@include('inc/woo_single_product.php');
@include('inc/woo_review.php');
@include('inc/woo_loop_item.php');
@include('inc/woo_catalog.php');


add_filter('wpseo_breadcrumb_links', 'remove_shop_page_from_breadcrumbs');
function remove_shop_page_from_breadcrumbs($links) {
    // Получаем слаг страницы магазина
    $shop_page_slug = 'shop';

    // Проходим через каждый элемент в цепочке навигации
    foreach ($links as $key => $link) {
        // Проверяем наличие ключа 'url' и если это страница магазина
        if (isset($link['url']) && strpos($link['url'], $shop_page_slug) !== false) {
            // Удаляем элемент из массива
            unset($links[$key]);
        }
    }

    // Перестраиваем ключи массива, чтобы не было пропусков
    $links = array_values($links);

    return $links;
}








