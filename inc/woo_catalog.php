<?php 

function custom_image_sizes() {
    add_image_size('offer-size', 900, 0, false);
}
add_action('after_setup_theme', 'custom_image_sizes');

remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
remove_action('woocommerce_shop_loop_header', 'woocommerce_product_taxonomy_archive_header', 10);
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);

function enqueue_mini_cart_script() {
    wp_enqueue_script('mini-cart', get_template_directory_uri() . '/js/mini-cart.min.js', array('jquery'), null, true);
    wp_localize_script('mini-cart', 'wc_add_to_cart_params', array(
    'wc_ajax_url' => WC_AJAX::get_endpoint('%%endpoint%%')
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_mini_cart_script');

add_action('wp_ajax_nopriv_remove_from_cart', 'remove_from_cart');
add_action('wp_ajax_remove_from_cart', 'remove_from_cart');

function remove_from_cart() {
    $product_id = apply_filters('woocommerce_remove_cart_item', $_POST['product_id']);
    $removed = false;

    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
        if ($cart_item['product_id'] == $product_id) {
            WC()->cart->remove_cart_item($cart_item_key);
        $removed = true;
        break;
        }
    }

    $response = array(
        'removed' => $removed,
        'product_id' => $product_id
    );
    echo json_encode($response);
    wp_die();
}

add_action('wp_ajax_get_cart_data', 'get_cart_data');
add_action('wp_ajax_nopriv_get_cart_data', 'get_cart_data');

function get_cart_data() {
    $cart_data = array();
    foreach (WC()->cart->get_cart() as $cart_item) {
        $cart_data[] = array(
            'product_id' => $cart_item['product_id'],
            'quantity' => $cart_item['quantity']
        );
    }
    echo json_encode($cart_data);
    wp_die();
}


// Получение данных корзины для мини-корзины
function get_mini_cart_data() {
    $cart = WC()->cart->get_cart();
    $cart_data = [];

    foreach ($cart as $cart_item_key => $cart_item) {
        $product = $cart_item['data'];
        $product_id = $cart_item['product_id'];
        $product_name = $product->get_name();
        $sku = $product->get_sku();
        $product_link = get_permalink($product_id);
        $quantity = $cart_item['quantity'];
        $thumbnail = get_the_post_thumbnail_url($product_id, 'thumbnail');
        $napryazhenie = $product->get_attribute('pa_napryazhenie');
        $emkost = $product->get_attribute('pa_emkost-ah');

        // Получаем цену продукта
        $price = $product->get_price();

        $cart_data[] = [
            'product_id' => $product_id,
            'product_name' => $product_name,
            'sku' => $sku,
            'product_link' => $product_link,
            'quantity' => $quantity,
            'thumbnail' => $thumbnail,
            'napryazhenie' => $napryazhenie,
            'emkost' => $emkost,
            'price' => $price, // Добавляем цену
        ];
    }

    wp_send_json($cart_data);
}

add_action('wp_ajax_get_mini_cart_data', 'get_mini_cart_data');
add_action('wp_ajax_nopriv_get_mini_cart_data', 'get_mini_cart_data');

// Обработчик для обновления корзины при изменении количества товара
function update_mini_cart_item() {
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);
    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
        if ($cart_item['product_id'] == $product_id) {
            WC()->cart->set_quantity($cart_item_key, $quantity, true);
            break;
        }
    }

    wp_send_json_success();
}

add_action('wp_ajax_update_mini_cart_item', 'update_mini_cart_item');
add_action('wp_ajax_nopriv_update_mini_cart_item', 'update_mini_cart_item');

// Обработчик для удаления товара из корзины
function remove_mini_cart_item() {
    $product_id = intval($_POST['product_id']);
    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
        if ($cart_item['product_id'] == $product_id) {
            WC()->cart->remove_cart_item($cart_item_key);
            break;
        }
    }

    wp_send_json_success();
}

add_action('wp_ajax_remove_mini_cart_item', 'remove_mini_cart_item');
add_action('wp_ajax_nopriv_remove_mini_cart_item', 'remove_mini_cart_item');

// Заполнение поля ProductData перед отправкой формы CF7
// Инициализация корзины до обработки формы CF7
function init_wc_cart() {
    if (class_exists('WooCommerce')) {
        if (null === WC()->cart) {
            WC()->cart = new WC_Cart();
        }
        if (null === WC()->session) {
            WC()->session = new WC_Session_Handler();
            WC()->session->init();
        }
        WC()->cart->get_cart();
    }
}

add_action('woocommerce_before_calculate_totals', 'init_wc_cart', 10);

// Заполнение поля ProductData перед отправкой формы CF7
/* function fill_product_data_field($form) {
    if (isset($_POST['ProductData'])) {
        $product_data = '';
        $total_sum = 0;

        if (class_exists('WooCommerce') && WC()->cart) {
            $cart = WC()->cart->get_cart();

            if (!empty($cart)) {
                foreach ($cart as $cart_item) {
                    $product = $cart_item['data'];
                    $product_name = $product->get_name();
                    $sku = $product->get_sku();
                    $product_link = get_permalink($cart_item['product_id']);
                    $price = $product->get_price();
                    $quantity = $cart_item['quantity'];
                    $item_total = $price * $quantity;
                    $total_sum += $item_total;

                    $product_data .= "Товар:\nАртикул: $sku\nНазвание: $product_name\nСсылка: $product_link\nСтоимость 1 ед.: $price ₽\nКоличество: $quantity\nСумма этих товаров: $item_total ₽\n\n";
                }
                $product_data .= "Сумма корзины: $total_sum ₽\n";
            } else {
                error_log('Корзина пуста.');
            }
        } else {
            error_log('WooCommerce или WC()->cart недоступны.');
        }

        $_POST['ProductData'] = $product_data;
    }

    return $form;
}

add_filter('wpcf7_posted_data', 'fill_product_data_field'); */

// Очистка корзины после отправки формы CF7
function clear_cart_after_submission() {
    if (class_exists('WooCommerce') && WC()->cart) {
        WC()->cart->empty_cart();
        error_log('Корзина очищена после отправки формы.');
    } else {
        error_log('WC_Cart недоступна для очистки.');
    }
}

add_action('wpcf7_mail_sent', 'clear_cart_after_submission');

// Обработчик для очистки корзины
add_action('wp_ajax_clear_cart', 'clear_cart');
add_action('wp_ajax_nopriv_clear_cart', 'clear_cart');

function clear_cart() {
    if (WC()->cart) {
        WC()->cart->empty_cart();
        echo json_encode(array('success' => true));
    } else {
        echo json_encode(array('success' => false));
    }
    wp_die();
}