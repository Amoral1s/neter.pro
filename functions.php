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

// 4. Функция для обновления мета-данных с fallback на атрибуты и возвращение результатов
function update_all_products_meta_with_fallback_attributes() {
    $priority_category_slugs = array('zaryadnye-ustrojstva-dlya-akkumulyatorov', 'bms-plata');
    $attribute_keys_priority = array('pa_napryazhenie');  // Напряжение для приоритетных категорий
    $attribute_keys_default = array('pa_emkost-ah');     // Емкость для остальных категорий

    $result_messages = array(); // Массив для хранения сообщений

    // Получаем все продукты
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
            
            // Получаем объект продукта
            $product = wc_get_product($product_id);

            if ($product && is_a($product, 'WC_Product')) {
                $product_categories = wp_get_post_terms($product_id, 'product_cat', array('fields' => 'slugs'));
                $is_priority_category = false;

                foreach ($priority_category_slugs as $priority_slug) {
                    if (in_array($priority_slug, $product_categories) || is_product_category_child_of_slug($product_id, $priority_slug)) {
                        $is_priority_category = true;
                        break;
                    }
                }

                $attribute_keys = $is_priority_category ? $attribute_keys_priority : $attribute_keys_default;
                $meta_value = '';

                foreach ($attribute_keys as $key) {
                    $attribute_value = $product->get_attribute($key);

                    if ($attribute_value) {
                        $meta_value = str_replace(',', '.', $attribute_value);
                        break;
                    }
                }

                if ($meta_value) {
                    update_post_meta($product_id, 'product_sort_value', $meta_value);
                    $result_messages[] = "Продукт ID: $product_id обновлен с значением: $meta_value";
                } else {
                    $default_value = 0;
                    update_post_meta($product_id, 'product_sort_value', $default_value);
                    $result_messages[] = "Продукт ID: $product_id не имеет атрибутов, установлено дефолтное значение: $default_value";
                }
            } else {
                $result_messages[] = "Не удалось получить объект продукта для ID: $product_id";
            }
        }
        wp_reset_postdata();
    }

    return $result_messages; // Возвращаем результат
}

// Проверяем дочерние категории
function is_product_category_child_of_slug($product_id, $parent_category_slug) {
    $parent_term = get_term_by('slug', $parent_category_slug, 'product_cat');
    
    if ($parent_term) {
        $product_categories = wp_get_post_terms($product_id, 'product_cat', array('fields' => 'ids'));
        foreach ($product_categories as $category_id) {
            if (term_is_ancestor_of($parent_term->term_id, $category_id, 'product_cat')) {
                return true;
            }
        }
    }
    
    return false;
}

// Добавить код в футер

function code_insert_footer() {
    ?>

    <!-- сюда перенесем код аналитики-->    

    <?php
}
add_action( 'wp_head', 'code_insert_footer' );



