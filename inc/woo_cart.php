<?php

// Сохранение состояния галочки при обновлении корзины
add_action('woocommerce_before_calculate_totals', 'save_installation_state');
function save_installation_state($cart) {
    if (is_admin() && !defined('DOING_AJAX')) return;

    foreach ($cart->get_cart() as $cart_item_key =>
    $cart_item) {
      if (isset($_POST['installation'][$cart_item_key])) {
          $cart_item['installation'] = true;
      } else {
          unset($cart_item['installation']);
      }
  }
}

// Добавление стоимости монтажа в качестве fee
add_action('woocommerce_cart_calculate_fees', 'add_new_fees', 20);
function add_new_fees($cart) {
  if (is_admin() && !defined('DOING_AJAX')) return;

  $installation_total = 0;
  $discount_total = 0;

  foreach ($cart->get_cart() as $cart_item) {
    if (isset($cart_item['installation'])) {
        $installation_price = get_field('installation_price', $cart_item['product_id']);
        $installation_total += $installation_price * $cart_item['quantity'];
    }
      // Получаем цену товара
      $product = $cart_item['data'];
      $product_price = $product->get_regular_price();
      // Проверяем, есть ли скидка на товар
      if ( $product->is_on_sale() ) {
          // Вычисляем сумму скидки на товар
          $discount = $product_price - $product->get_sale_price();
          // Увеличиваем общую сумму скидки
          $discount_total += $discount * $cart_item['quantity'];
      }
  }

  if ($installation_total > 0) {
    WC()->cart->add_fee('Стоимость монтажа', $installation_total);
  }
  /* if ($discount_total > 0) {
    // Добавляем сумму скидки в корзину
    $cart->add_fee( 'Скидка на товары', -$discount_total );
  } */
}

// Сохранение информации о монтаже в заказе
add_action('woocommerce_checkout_create_order_line_item', 'save_installation_to_order', 10, 4);
function save_installation_to_order($item, $cart_item_key, $values, $order) {
  if (isset($values['installation'])) {
      $item->add_meta_data('installation', 'yes');
  }
}

// jQuery для обновления корзины при нажатии на галочку
add_action('wp_footer', 'installation_checkbox_script');
function installation_checkbox_script() {
  if (is_cart()) {
      ?>
      <script type="text/javascript">
          jQuery(document).ready(function($) {
              $('body').on('change', '.installation-checkbox', function() {
                    jQuery('.cart-wrap').addClass('loading');
                  var cart_item_key = $(this).data('cart-item-key');
                  var is_checked = $(this).is(':checked');
                  $.ajax({
                      type: 'POST',
                      url: wc_cart_params.ajax_url,
                      data: {
                          action: 'save_installation_state',
                          cart_item_key: cart_item_key,
                          is_checked: is_checked
                      },
                      success: function() {
                        jQuery('[name="update_cart"]').trigger('click');
                        jQuery('.cart-wrap').removeClass('loading');
                      },
                      error: function() {
                        jQuery('.cart-wrap').removeClass('loading');
                      }
                  });
              });
          });
      </script>
      <?php
  }
}

// Обработка AJAX-запроса для сохранения состояния галочки
add_action('wp_ajax_save_installation_state', 'save_installation_state_ajax');
add_action('wp_ajax_nopriv_save_installation_state', 'save_installation_state_ajax');
function save_installation_state_ajax() {
  $cart_item_key = $_POST['cart_item_key'];
  $is_checked = $_POST['is_checked'] === 'true';

  foreach (WC()->cart->get_cart() as $key => $cart_item) {
      if ($key === $cart_item_key) {
          if ($is_checked) {
              WC()->cart->cart_contents[$key]['installation'] = true;
          } else {
              unset(WC()->cart->cart_contents[$key]['installation']);
          }
          break;
      }
  }

  WC()->cart->calculate_totals();
  wp_die();
}



//Заказ в 1 клик
// Определяем параметры, которые нам понадобятся для передачи в JavaScript
wp_localize_script('woo-cart-script', 'wooCartAjax', array(
    'ajaxurl' => admin_url('admin-ajax.php'),
    'action' => 'buy_in_one_click'
));

// Функция отправки данных через AJAX
function sendDataToPopup() {
    ?>
    <script type="text/javascript">
      jQuery(document).on('click', '.button.cart-order', function() {
          jQuery('.button.cart-order').text('Загрузка...');
          jQuery.ajax({
              type: 'POST',
              url: '<?php echo admin_url('admin-ajax.php'); ?>',
              data: {
                  action: 'buy_in_one_click'
              },
              success: function(data) {
                  var jsonData = JSON.parse(data);

                  var productsText = '';
                  jsonData.products.forEach(function(product) {
                    productsText += '' + product.title + ': ' + product.quantity + ' x ' + product.price + ' руб. (Установка: ' + product.installation + ')\n\n';
                  });

                  var totalText = 'Итого: ' + jsonData.total + ' руб.';

                  var textWithLineBreaks = productsText + totalText;

                  jQuery('.popup.cart-order-popup textarea.data').val(''); // Очищаем поле input.data
                  jQuery('.popup.cart-order-popup textarea.data').val(textWithLineBreaks);
                  console.log(jQuery('.popup.cart-order-popup textarea.data').val());
                  jQuery('.popup.cart-order-popup').fadeIn(200);
                  jQuery('.overlay').fadeIn(200);
                  jQuery('.button.cart-order').text('Купить в 1 клик');
              }
          });
      });
   
    </script>
    <?php
}

add_action('wp_footer', 'sendDataToPopup');

// Обработчик AJAX запроса
add_action('wp_ajax_buy_in_one_click', 'buy_in_one_click');
add_action('wp_ajax_nopriv_buy_in_one_click', 'buy_in_one_click');

function buy_in_one_click() {
    global $woocommerce;

    $cart = $woocommerce->cart->get_cart();
    $order_summary = array();

    foreach ($cart as $cart_item_key => $cart_item) {
        $product = $cart_item['data'];
        $price = $product->get_price();
        $price = floatval($price);
        $price_formatted = number_format($price, 2, '.', ' ');
        $order_summary[] = array(
            'title' => $product->get_name(),
            'link' => get_permalink($product->get_id()),
            'quantity' => $cart_item['quantity'],
            'price' => $price_formatted,
            'installation' => $cart_item['installation'] ? 'Да' : 'Нет'
        );
    }

   
    
    $total_string = WC()->cart->get_total();
    // Удаление символа рубля и непечатных символов
    $total_without_currency = str_replace('₽', '', $total_string);
    $total_without_html = strip_tags($total_without_currency);
    $total_without_currency_last = str_replace('&nbsp;&#8381;', '', $total_without_html);

    
    $data_json = json_encode(array(
        'products' => $order_summary,
        'total' => $total_without_currency_last
    ));

    // Выводим JSON строку и завершаем выполнение
    echo $data_json;
    wp_die();
}

