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
                        $('#update-meta-status').html('<div class="updated"><p>' + response.data.message + '</p></div>');
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
    update_all_products_meta_with_fallback_attributes();

    wp_send_json_success(array('message' => 'Мета-данные продуктов обновлены!'));
}

// 4. Функция для обновления мета-данных с fallback на атрибуты
function update_all_products_meta_with_fallback_attributes() {
    // Определяем категории, для которых будем использовать `napryazhenie`
    $priority_category_slugs = array('zaryadnye-ustrojstva-dlya-akkumulyatorov', 'bms-plata');

    // Определяем ключи атрибутов для сортировки
    $attribute_keys_priority = array('pa_napryazhenie');  // Напряжение для приоритетных категорий
    $attribute_keys_default = array('pa_emkost-mah');     // Емкость для остальных категорий

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

            // Проверка на успешное получение объекта продукта
            if ($product && is_a($product, 'WC_Product')) {
                // Проверяем, находится ли товар в приоритетных категориях или их дочерних категориях
                $product_categories = wp_get_post_terms($product_id, 'product_cat', array('fields' => 'slugs'));
                $is_priority_category = false;

                foreach ($priority_category_slugs as $priority_slug) {
                    if (in_array($priority_slug, $product_categories) || is_product_category_child_of_slug($product_id, $priority_slug)) {
                        $is_priority_category = true;
                        break;
                    }
                }

                // Выбираем атрибуты для сортировки в зависимости от категории
                $attribute_keys = $is_priority_category ? $attribute_keys_priority : $attribute_keys_default;

                $meta_value = '';
                foreach ($attribute_keys as $key) {
                    $attribute_value = $product->get_attribute($key);

                    if ($attribute_value) {
                        // Преобразуем значение в десятичное число, заменив запятую на точку
                        $meta_value = str_replace(',', '.', $attribute_value);
                        break; // Если нашли значение, выходим из цикла
                    }
                }

                // Если нашли значение, обновляем мета-данные
                if ($meta_value) {
                    update_post_meta($product_id, 'product_sort_value', $meta_value);
                    error_log("Продукт ID: $product_id обновлен с значением: $meta_value");
                } else {
                    // Если ни один из атрибутов не задан, устанавливаем дефолтное значение
                    $default_value = 0;
                    update_post_meta($product_id, 'product_sort_value', $default_value);
                    error_log("Продукт ID: $product_id не имеет атрибутов, установлено дефолтное значение: $default_value");
                }
            } else {
                error_log("Не удалось получить объект продукта для ID: $product_id");
            }
        }
        wp_reset_postdata();
    }
}

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

// Сортировка товаров на основе обновленных мета-данных
add_action('pre_get_posts', 'custom_sort_products_by_product_sort_value', 99);

function custom_sort_products_by_product_sort_value($query) {
    if (!is_admin() && $query->is_main_query() && is_woocommerce()) {
        // Проверяем, находится ли запрос на категории `zaryadnye-ustrojstva-dlya-akkumulyatorov`, `bms-plata` или их дочерних категориях
        if (
            is_product_category('zaryadnye-ustrojstva-dlya-akkumulyatorov') || 
            is_product_category_child_of('zaryadnye-ustrojstva-dlya-akkumulyatorov') ||
            is_product_category('bms-plata') || 
            is_product_category_child_of('bms-plata')
        ) {
            // Сортируем от меньшего к большему для этих категорий и их дочерних категорий
            $query->set('meta_key', 'product_sort_value');
            $query->set('orderby', 'meta_value_num');
            $query->set('order', 'ASC');
        } else {
            // Сортируем от большего к меньшему для остальных категорий
            $query->set('meta_key', 'product_sort_value');
            $query->set('orderby', 'meta_value_num');
            $query->set('order', 'DESC');
        }
    }
}

function is_product_category_child_of($parent_category_slug) {
    $term = get_queried_object();

    if (is_a($term, 'WP_Term') && $term->taxonomy === 'product_cat') {
        $parent_term = get_term_by('slug', $parent_category_slug, 'product_cat');
        
        if ($parent_term && term_is_ancestor_of($parent_term->term_id, $term->term_id, 'product_cat')) {
            return true;
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



