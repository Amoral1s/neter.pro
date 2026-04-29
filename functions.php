<?php

add_filter('wpcf7_recaptcha_threshold', function($threshold) {
    return 0.3; // Уменьшите порог (по умолчанию 0.5)
});
add_filter('wpcf7_spam', '__return_false'); // отключает внутреннюю проверку на спам
//add_filter('wpcf7_recaptcha_verification', '__return_true'); // отключает reCAPTCHA
//remove_filter('wpcf7_spam', 'wpcf7_akismet_check_spam', 10); // отключает Akismet (если установлен)
//
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
@include('inc/vacancy.php');
@include('inc/comments.php');

// Remove default prefixes from archive titles like "Категория:".
add_filter('get_the_archive_title', function($title) {
    if (is_category()) {
        return single_cat_title('', false);
    }

    if (is_tag()) {
        return single_tag_title('', false);
    }

    if (is_author()) {
        return get_the_author();
    }

    if (is_tax()) {
        return single_term_title('', false);
    }

    if (is_post_type_archive()) {
        return post_type_archive_title('', false);
    }

    return $title;
});

add_filter('wpseo_metadesc', function($desc) {
  if (is_post_type_archive('blog')) {
    return 'Блог компании НЭТЕР — всё о технологиях, разработках и опыте внедрения решений 🔋 Следите за новостями, историями и обновлениями от нашей команды, которая делает будущее уже сегодня.';
  }
  if (is_post_type_archive('projects')) {
    return 'Примеры реализованных проектов от НЭТЕР 🧪 Как мы создаем решения для складской техники, электромобилей, ИБП и систем хранения энергии. Ознакомьтесь с кейсами, где технологии встречаются с реальным бизнесом.';
  }
  return $desc;
});

add_filter('wpseo_breadcrumb_links', 'customize_yoast_breadcrumbs_last_link');

function customize_yoast_breadcrumbs_last_link($links) {
    if (is_tax() || is_category() || is_tag()) {
        $term = get_queried_object();
        $custom_breadcrumb_title = get_term_meta($term->term_id, '_yoast_wpseo_bctitle', true);

        if (!empty($custom_breadcrumb_title)) {
            // Изменяем только последнюю крошку в массиве
            $last_index = count($links) - 1;
            $links[$last_index]['text'] = $custom_breadcrumb_title;
        }
    }

    return $links;
}

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


//Сортировка каталога
// 1. Добавляем страницу в админку с кнопкой для обновления мета-данных продуктов
add_action('admin_menu', 'add_update_products_meta_page');

function add_update_products_meta_page() {
    add_submenu_page(
        'tools.php', // Подменю добавляется в раздел "Инструменты"
        'Обновить мета-данные продуктов', // Заголовок страницы
        'Обновить мета-данные продуктов', // Название пункта меню
        'manage_options', // Уровень прав доступа
        'update-products-meta', // Слаг страницы
        'run_update_all_products_meta_with_fallback_attributes' // Функция, которая будет отрисовывать страницу
    );
}

// 2. Отрисовываем страницу и добавляем кнопку для запуска обновления
function run_update_all_products_meta_with_fallback_attributes() {
    ?>
    <div class="wrap">
        <h1>Обновить мета-данные продуктов</h1>
        <form id="update-products-meta-form" method="post">
            <input type="button" id="update-products-meta-button" class="button-primary" value="Запустить обновление" />
            <div id="update-meta-status"></div>
        </form>
    </div>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('#update-products-meta-button').click(function(e) {
                e.preventDefault();
                var button = $(this);
                button.prop('disabled', true);
                $('#update-meta-status').text('Обновление запущено...');
                
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'update_products_meta'
                    },
                    success: function(response) {
                        $('#update-meta-status').html('<div class="updated"><p>' + response.data.message + '</p><ul>' + response.data.details + '</ul></div>');
                        button.prop('disabled', false);
                    },
                    error: function(response) {
                        $('#update-meta-status').html('<div class="error"><p>Ошибка обновления мета-данных.</p></div>');
                        button.prop('disabled', false);
                    }
                });
            });
        });
    </script>
    <?php
}

// 3. Обрабатываем AJAX-запрос и запускаем обновление мета-данных
add_action('wp_ajax_update_products_meta', 'update_all_products_meta_with_fallback_attributes_ajax');

function update_all_products_meta_with_fallback_attributes_ajax() {
    $result = update_all_products_meta_with_fallback_attributes(); // Возвращаем результат

    wp_send_json_success(array(
        'message' => 'Мета-данные продуктов обновлены!',
        'details' => implode('<li>', $result) // Возвращаем список результатов
    ));
}

function main_theme_update_single_product_catalog_sort_meta($product_id) {
    $product_id = absint($product_id);

    if (!$product_id || !function_exists('wc_get_product')) {
        return new WP_Error('invalid_product', 'Не удалось получить объект продукта.');
    }

    $product = wc_get_product($product_id);

    if (!$product || !is_a($product, 'WC_Product')) {
        return new WP_Error('invalid_product', 'Не удалось получить объект продукта.');
    }

    $priority_category_slugs = array('zaryadnye-ustrojstva-dlya-akkumulyatorov', 'bms-plata');
    $attribute_keys_priority = array('pa_napryazhenie');
    $attribute_keys_default = array('pa_emkost-ah');
    $product_categories = wp_get_post_terms($product_id, 'product_cat', array('fields' => 'slugs'));
    $is_priority_category = false;

    if (is_wp_error($product_categories)) {
        $product_categories = array();
    }

    foreach ($priority_category_slugs as $priority_slug) {
        if (in_array($priority_slug, $product_categories, true) || is_product_category_child_of_slug($product_id, $priority_slug)) {
            $is_priority_category = true;
            break;
        }
    }

    $attribute_keys = $is_priority_category ? $attribute_keys_priority : $attribute_keys_default;
    $meta_value = 0;
    $attribute_key = '';

    foreach ($attribute_keys as $key) {
        $attribute_value = $product->get_attribute($key);

        if ($attribute_value) {
            $meta_value = str_replace(',', '.', $attribute_value);
            $meta_value = (float) trim($meta_value);
            $attribute_key = $key;
            break;
        }
    }

    $priority = (bool) get_post_meta($product_id, 'new_product', true) ? 1 : 0;

    update_post_meta($product_id, 'product_sort_value', $meta_value);
    update_post_meta($product_id, 'new_product_sort_priority', $priority);

    return array(
        'sort_value'    => $meta_value,
        'attribute_key' => $attribute_key,
        'priority'      => $priority,
    );
}

// 4. Функция для обновления мета-данных с fallback на атрибуты и возвращение результатов
function update_all_products_meta_with_fallback_attributes() {
    $result_messages = array();

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'post_status' => 'publish',
    );
    $products = new WP_Query($args);

    if ($products->have_posts()) {
        while ($products->have_posts()) {
            $products->the_post();
            $product_id = get_the_ID();
            $sort_result = main_theme_update_single_product_catalog_sort_meta($product_id);

            if (!is_wp_error($sort_result)) {
                if (!empty($sort_result['attribute_key'])) {
                    $result_messages[] = "Продукт ID: $product_id обновлен с значением: {$sort_result['sort_value']} (атрибут найден в ключе: {$sort_result['attribute_key']})";
                } else {
                    $result_messages[] = "Продукт ID: $product_id не имеет атрибутов, установлено дефолтное значение: {$sort_result['sort_value']}";
                }
            } else {
                $result_messages[] = "Не удалось получить объект продукта для ID: $product_id";
            }
        }
        wp_reset_postdata();
    }

    return $result_messages;
}

// Проверяем дочерние категории
function is_product_category_child_of_slug($product_id, $parent_category_slug) {
    static $children_by_slug = array();
    static $product_terms_by_id = array();

    $product_id = absint($product_id);

    if (!$product_id) {
        return false;
    }

    if (!isset($children_by_slug[$parent_category_slug])) {
        $parent_term = get_term_by('slug', $parent_category_slug, 'product_cat');
        $children_by_slug[$parent_category_slug] = array();

        if ($parent_term) {
            $child_terms = get_term_children($parent_term->term_id, 'product_cat');
            $children_by_slug[$parent_category_slug] = is_wp_error($child_terms) ? array() : array_map('intval', $child_terms);
        }
    }

    if (!isset($product_terms_by_id[$product_id])) {
        $product_terms = wp_get_post_terms($product_id, 'product_cat', array('fields' => 'ids'));
        $product_terms_by_id[$product_id] = is_wp_error($product_terms) ? array() : array_map('intval', $product_terms);
    }

    if ($children_by_slug[$parent_category_slug] && $product_terms_by_id[$product_id]) {
        return (bool) array_intersect($product_terms_by_id[$product_id], $children_by_slug[$parent_category_slug]);
    }
    
    return false;
}
add_action('woocommerce_product_query', 'custom_sort_products_with_priority_and_fallback');
function custom_sort_products_with_priority_and_fallback($query) {
    if (is_admin() || !$query->is_main_query()) {
        return;
    }

    if (
        $query->is_post_type_archive('product') ||
        $query->is_tax('product_cat') ||
        $query->is_tax('product_tag')
    ) {
        $GLOBALS['main_theme_catalog_sort_query'] = $query;
        $query->set('main_theme_catalog_sort', true);
        $query->set('suppress_filters', false);
    }
}

function main_theme_should_apply_catalog_sort($query) {
    if (is_admin() || !($query instanceof WP_Query) || !$query->is_main_query()) {
        return false;
    }

    if (empty($GLOBALS['main_theme_catalog_sort_query'])) {
        return (bool) $query->get('main_theme_catalog_sort');
    }

    return $GLOBALS['main_theme_catalog_sort_query'] === $query || (bool) $query->get('main_theme_catalog_sort');
}

function main_theme_catalog_sort_posts_clauses($clauses, $query) {
    if (!main_theme_should_apply_catalog_sort($query)) {
        return $clauses;
    }

    global $wpdb;

    if (strpos($clauses['join'], 'AS catalog_sort_meta') === false) {
        $clauses['join'] .= $wpdb->prepare(
            " LEFT JOIN (
                SELECT
                    post_id,
                    MAX(CASE WHEN meta_key = %s THEN meta_value+0 END) AS catalog_new_priority,
                    MAX(CASE WHEN meta_key = %s THEN meta_value+0 END) AS catalog_sort_value
                FROM {$wpdb->postmeta}
                WHERE meta_key IN (%s, %s)
                GROUP BY post_id
            ) AS catalog_sort_meta ON ({$wpdb->posts}.ID = catalog_sort_meta.post_id) ",
            'new_product_sort_priority',
            'product_sort_value',
            'new_product_sort_priority',
            'product_sort_value'
        );
    }

    $clauses['orderby'] = "catalog_sort_meta.catalog_new_priority IS NULL ASC, catalog_sort_meta.catalog_new_priority DESC, catalog_sort_meta.catalog_sort_value IS NULL ASC, catalog_sort_meta.catalog_sort_value DESC";

    return $clauses;
}
add_filter('posts_clauses', 'main_theme_catalog_sort_posts_clauses', 20, 2);

if (!function_exists('main_theme_get_random_product_ids')) {
    function main_theme_get_random_product_ids($limit = 10, $ttl = 600) {
        $limit = max(1, (int) $limit);
        $cache_key = 'main_theme_random_products_' . $limit;
        $cached_ids = get_transient($cache_key);

        if (is_array($cached_ids) && !empty($cached_ids)) {
            return array_map('intval', $cached_ids);
        }

        $query = new WP_Query(array(
            'post_type'              => 'product',
            'post_status'            => 'publish',
            'posts_per_page'         => $limit,
            'orderby'                => 'rand',
            'fields'                 => 'ids',
            'no_found_rows'          => true,
            'ignore_sticky_posts'    => true,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
        ));

        $product_ids = array_map('intval', $query->posts);

        if (!empty($product_ids)) {
            set_transient($cache_key, $product_ids, max(60, (int) $ttl));
        }

        return $product_ids;
    }
}

add_filter('wpcf7_form_elements', function($content) {
    if (is_page(3)) {
        // Заменим ссылку на span
        $content = preg_replace(
            '#<a[^>]+href="[^"]*/privacy-policy[^"]*"[^>]*>(.*?)</a>#i',
            '<span>$1</span>',
            $content
        );
    }
    return $content;
});


add_filter('wp_insert_post_data', function($data, $postarr) {
    if ($data['post_type'] === 'product') {
        $product_id = $postarr['ID'] ?? 0;
        $sku = '';

        if ($product_id) {
            $sku = get_post_meta($product_id, '_sku', true);
        } elseif (!empty($postarr['_sku'])) {
            $sku = $postarr['_sku'];
        }

        if ($sku) {
            $data['post_name'] = sanitize_title('product-' . $sku);
        }
    }
    return $data;
}, 10, 2);

/* add_action('init', function() {
    if (!current_user_can('manage_options')) return;
    $args = [
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
    ];

    $query = new WP_Query($args);

    foreach ($query->posts as $product) {
        $sku = get_post_meta($product->ID, '_sku', true);
        if ($sku) {
            $new_slug = sanitize_title('product-' . $sku);
            // Только если slug другой
            if ($product->post_name !== $new_slug) {
                wp_update_post([
                    'ID'        => $product->ID,
                    'post_name' => $new_slug,
                ]);
            }
        }
    }
}); */
