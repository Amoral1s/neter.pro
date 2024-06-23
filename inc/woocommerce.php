<?php 


function mytheme_add_woocommerce_support() {
    add_theme_support( 'woocommerce', array(
        'pagination' => array(
            'type' => 'plain',
        ),
    ) );
}
add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );

//Слайдер в товаре
add_action( 'after_setup_theme', 'yourtheme_setup' );
function yourtheme_setup() {
 // add_theme_support( 'wc-product-gallery-zoom' ); // увеличение 
  add_theme_support( 'wc-product-gallery-lightbox' ); //лайтбокс
  add_theme_support( 'wc-product-gallery-slider' ); // слайдер
}	 

remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);


/* add_filter('woocommerce_breadcrumb_defaults', 'jk_change_breadcrumb_delimiter');
function jk_change_breadcrumb_delimiter( $defaults ) {
// разделитель изменится с ‘/’ на ‘>’
$defaults['delimiter'] = '<del></del>';
return $defaults;
} 
 */

 // Установка количества товаров на странице в цикле
function custom_wc_products_per_page( $query ) {
  if ( is_shop() || is_archive() ) {
      $query->set( 'posts_per_page', 12 ); // Укажите здесь желаемое количество товаров для отображения
  }
}
add_action( 'pre_get_posts', 'custom_wc_products_per_page' );



add_action( 'woocommerce_before_shop_loop_item_title', 'thumb_start', 9 );
add_action( 'woocommerce_before_shop_loop_item_title', 'sale_badge', 11 );

add_action( 'woocommerce_before_shop_loop_item_title', 'thumb_end', 12 );

function thumb_start() {
  echo '<div class="product-thumb">';
}
function sale_badge() {
    global $product;

    if ($product->is_on_sale()) {
        $regular_price = $product->get_regular_price();
        $sale_price = $product->get_sale_price();

        if ($regular_price > 0) {
            $discount_percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
            echo '<span class="discount-percentage">-' . $discount_percentage . '%</span>';
        }
    } 
}
function thumb_end() {
  echo '</div>';
}

remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);

add_action('woocommerce_shop_loop_item_title', 'custom_change_product_title_tag', 4);

function custom_change_product_title_tag() {
  global $product;

  // Получаем информацию о наличии товара и артикуле
  $availability = $product->is_in_stock() ? '<div class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
  <path fill-rule="evenodd" clip-rule="evenodd" d="M1.04166 10.0001C1.04166 14.9477 5.05245 18.9584 10 18.9584C14.9476 18.9584 18.9583 14.9477 18.9583 10.0001C18.9583 5.05253 14.9476 1.04175 10 1.04175C5.05245 1.04175 1.04166 5.05253 1.04166 10.0001ZM13.8964 6.88579C14.2357 7.19678 14.2586 7.72392 13.9477 8.06319L9.36433 13.0632C9.21066 13.2307 8.99533 13.3282 8.76808 13.3332C8.54083 13.3382 8.32146 13.2501 8.16074 13.0893L6.07741 11.006C5.75197 10.6806 5.75197 10.1529 6.07741 9.8275C6.40285 9.50208 6.93048 9.50208 7.25592 9.8275L8.72383 11.2954L12.719 6.93698C13.03 6.59771 13.5572 6.5748 13.8964 6.88579Z" fill="#24B642"/>
  </svg></div><span>В наличии</span>' : '<div class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
  <path fill-rule="evenodd" clip-rule="evenodd" d="M10.0001 18.9582C5.05253 18.9582 1.04175 14.9474 1.04175 9.99984C1.04175 5.05229 5.05253 1.0415 10.0001 1.0415C14.9477 1.0415 18.9584 5.05229 18.9584 9.99984C18.9584 14.9474 14.9477 18.9582 10.0001 18.9582ZM13.0893 8.08911C13.4147 7.76369 13.4147 7.23605 13.0893 6.9106C12.7639 6.58515 12.2363 6.58514 11.9108 6.91056L9.99991 8.82134L8.08931 6.91089C7.76387 6.58546 7.23623 6.58548 6.91081 6.91093C6.58538 7.23638 6.5854 7.76401 6.91085 8.08944L8.82133 9.99984L6.91085 11.9103C6.5854 12.2357 6.58538 12.7633 6.91081 13.0888C7.23623 13.4142 7.76387 13.4142 8.08931 13.0888L9.99991 11.1783L11.9108 13.0891C12.2363 13.4145 12.7639 13.4145 13.0893 13.0891C13.4147 12.7636 13.4147 12.236 13.0893 11.9106L11.1785 9.99984L13.0893 8.08911Z" fill="#EB163C"/>
  </svg></div><span>Нет в наличии</span>';
  $sku = 'Арт: ' . $product->get_sku();
  
  // Выводим обертку с классом "product-art" и блоки с информацией
  echo '<div class="product-art">';
  echo '<div class="status">' . $availability . '</div>';
  echo '<div class="sku">' . $sku . '</div>';
  echo '</div>';

  // Выводим заголовок товара в теге <h3>
  $title = '<h3 class="product-title">' . $product->get_title() . '</h3>';
  echo $title;
}

remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

function custom_display_discount_percentage() {
    global $product;

    if ($product->is_on_sale()) {
        $regular_price = $product->get_regular_price();
        $sale_price = $product->get_sale_price();

        if ($regular_price > 0) {
            $discount_percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
            echo '<span class="product-price">';
            woocommerce_template_loop_price();
            echo '<span class="discount-percentage">-' . $discount_percentage . '%</span>';
            echo '</span>';
        }
    } else {
        echo '<span class="product-price">';
        woocommerce_template_loop_price();
        echo '</span>';
    }
}
add_filter('woocommerce_sale_flash', 'custom_sale_flash_text', 10, 3);

function custom_sale_flash_text($text, $post, $product) {
    if ($product->is_on_sale()) {
        $text = '<span class="onsale">' . __('Акция!', 'woocommerce') . '</span>';
    }
    return $text;
}


add_filter( 'woocommerce_after_shop_loop_item', 'cardButtons', 12 );


function custom_display_product_attributes() {
    global $product;

    $action_text = get_field('product_action');

    if ($action_text) {
      echo '<div class="product-text">' . $action_text . '</div>';
    }
    

    $kolichestvo_polzovatelej = $product->get_attribute('kolichestvo-polzovatelej');
    $obem_pererabotki_m3_sutki = $product->get_attribute('obem-pererabotki-m3-sutki');
    $otvod = $product->get_attribute('tip-sliva');
    $type = $product->get_attribute('tip-ustrojstva');

    echo '<div class="product-attributes">';

    // Проверка наличия атрибута "kolichestvo-polzovatelej"
    if (!empty($kolichestvo_polzovatelej)) {
        echo '<div class="attr"><div class="icon">
            <svg class="mini" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path d="M20.774 18C21.5233 18 22.1193 17.5285 22.6545 16.8691C23.7499 15.5194 21.9513 14.4408 21.2654 13.9126C20.568 13.3756 19.7894 13.0714 19 13M18 11C19.3807 11 20.5 9.88071 20.5 8.5C20.5 7.11929 19.3807 6 18 6" stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round"/>
            <path d="M3.22596 18C2.47666 18 1.88067 17.5285 1.34555 16.8691C0.250087 15.5194 2.04867 14.4408 2.73465 13.9126C3.43197 13.3756 4.21058 13.0714 5 13M5.5 11C4.11929 11 3 9.88071 3 8.5C3 7.11929 4.11929 6 5.5 6" stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round"/>
            <path d="M8.0838 15.1112C7.06203 15.743 4.38299 17.0331 6.0147 18.6474C6.81178 19.436 7.69952 20 8.81563 20H15.1844C16.3005 20 17.1882 19.436 17.9853 18.6474C19.617 17.0331 16.938 15.743 15.9162 15.1112C13.5201 13.6296 10.4799 13.6296 8.0838 15.1112Z" stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M15.5 7.5C15.5 9.433 13.933 11 12 11C10.067 11 8.5 9.433 8.5 7.5C8.5 5.567 10.067 4 12 4C13.933 4 15.5 5.567 15.5 7.5Z" stroke="#9CA3AF" stroke-width="1.5"/>
            </svg>

            <svg class="max" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path d="M20.774 18C21.5233 18 22.1193 17.5285 22.6545 16.8691C23.7499 15.5194 21.9513 14.4408 21.2654 13.9126C20.568 13.3756 19.7894 13.0714 19 13M18 11C19.3807 11 20.5 9.88071 20.5 8.5C20.5 7.11929 19.3807 6 18 6" stroke="#24B642" stroke-width="1.5" stroke-linecap="round"/>
              <path d="M3.22596 18C2.47666 18 1.88067 17.5285 1.34555 16.8691C0.250087 15.5194 2.04867 14.4408 2.73465 13.9126C3.43197 13.3756 4.21058 13.0714 5 13M5.5 11C4.11929 11 3 9.88071 3 8.5C3 7.11929 4.11929 6 5.5 6" stroke="#24B642" stroke-width="1.5" stroke-linecap="round"/>
              <path d="M8.0838 15.1112C7.06203 15.743 4.38299 17.0331 6.0147 18.6474C6.81178 19.436 7.69952 20 8.81563 20H15.1844C16.3005 20 17.1882 19.436 17.9853 18.6474C19.617 17.0331 16.938 15.743 15.9162 15.1112C13.5201 13.6296 10.4799 13.6296 8.0838 15.1112Z" stroke="#24B642" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M15.5 7.5C15.5 9.433 13.933 11 12 11C10.067 11 8.5 9.433 8.5 7.5C8.5 5.567 10.067 4 12 4C13.933 4 15.5 5.567 15.5 7.5Z" stroke="#24B642" stroke-width="1.5"/>
            </svg>
        
        </div>
          <p class="max">Пользователи</p>
          <span>' . $kolichestvo_polzovatelej . ' чел</span>
        
        </div>';
    } 

    // Проверка наличия атрибута "tip-sliva"
    if (!empty($otvod)) {
        echo '<div class="attr max"><div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path d="M2 10C2.77968 6.18409 5.66918 3.12932 9.40618 2.08977C9.71987 2.00251 9.87671 1.95888 9.96119 2.05236C10.0457 2.14584 9.98344 2.30042 9.85897 2.60956L9 4.5M14 2C17.8159 2.77968 20.8707 5.66918 21.9102 9.40618C21.9975 9.71987 22.0411 9.87671 21.9476 9.96119C21.8542 10.0457 21.6996 9.98344 21.3904 9.85897L19.5 9M22 14C21.2203 17.8159 18.3308 20.8707 14.5938 21.9102C14.2801 21.9975 14.1233 22.0411 14.0388 21.9476C13.9543 21.8542 14.0166 21.6996 14.141 21.3904L15 19.5M10 22C6.18409 21.2203 3.12932 18.3308 2.08977 14.5938C2.00251 14.2801 1.95888 14.1233 2.05236 14.0388C2.14584 13.9543 2.30042 14.0166 2.60956 14.141L4.5 15" stroke="#24B642" stroke-width="1.5" stroke-linecap="round"/>
            <path d="M8 12.7551C8 10.8722 9.68508 9.01158 10.8678 7.9375C11.5102 7.35417 12.4898 7.35417 13.1322 7.9375C14.3149 9.01158 16 10.8722 16 12.7551C16 14.6012 14.4853 16.5 12 16.5C9.51472 16.5 8 14.6012 8 12.7551Z" stroke="#24B642" stroke-width="1.5"/>
            </svg>
        
        </div><p class="max">Отвод очищенной воды</p><span>' . $otvod . ' чел</span></div>';
    } 

    // Проверка наличия атрибута "obem-pererabotki-m3-sutki"
    if (!empty($obem_pererabotki_m3_sutki)) {
        echo '<div class="attr"><div class="icon">
        
        <svg class="mini" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
        <path d="M3.5 13.678C3.5 9.49387 7.08079 5.35907 9.59413 2.97222C10.9591 1.67593 13.0409 1.67593 14.4059 2.97222C16.9192 5.35907 20.5 9.49387 20.5 13.678C20.5 17.7804 17.2812 22 12 22C6.71878 22 3.5 17.7804 3.5 13.678Z" stroke="#9CA3AF" stroke-width="1.5"/>
        <path d="M16 14C16 16.2091 14.2091 18 12 18" stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>

        <svg class="max" style="display: none" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
          <path d="M3.5 13.678C3.5 9.49387 7.08079 5.35907 9.59413 2.97222C10.9591 1.67593 13.0409 1.67593 14.4059 2.97222C16.9192 5.35907 20.5 9.49387 20.5 13.678C20.5 17.7804 17.2812 22 12 22C6.71878 22 3.5 17.7804 3.5 13.678Z" stroke="#24B642" stroke-width="1.5"/>
          <path d="M16 14C16 16.2091 14.2091 18 12 18" stroke="#24B642" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        
        </div><p class="max">Производительность</p><span>' . $obem_pererabotki_m3_sutki . ' л/сут</span></div>';
    } 

    // Проверка наличия атрибута "tip-ustrojstva"
    if (!empty($type)) {
        echo '<div class="attr max"><div class="icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
        <path d="M10 6C10 3.79086 8.20914 2 6 2C3.79086 2 2 3.79086 2 6C2 8.20914 3.79086 10 6 10C8.20914 10 10 8.20914 10 6Z" stroke="#24B642" stroke-width="1.5"/>
        <path d="M10 18C10 15.7909 8.20914 14 6 14C3.79086 14 2 15.7909 2 18C2 20.2091 3.79086 22 6 22C8.20914 22 10 20.2091 10 18Z" stroke="#24B642" stroke-width="1.5"/>
        <path d="M22 6C22 3.79086 20.2091 2 18 2C15.7909 2 14 3.79086 14 6C14 8.20914 15.7909 10 18 10C20.2091 10 22 8.20914 22 6Z" stroke="#24B642" stroke-width="1.5"/>
        <path d="M22 18C22 15.7909 20.2091 14 18 14C15.7909 14 14 15.7909 14 18C14 20.2091 15.7909 22 18 22C20.2091 22 22 20.2091 22 18Z" stroke="#24B642" stroke-width="1.5"/>
        </svg>
        
        </div><p class="max">Тип устройства</p><span>' . $type . ' чел</span></div>';
    } 
    

    echo '</div>';
}



function cardButtons() {
  global $product;

  echo '<div class="product-bottom">';
    custom_display_discount_percentage();
    custom_display_product_attributes();
    echo '<div class="product-btns">';
      if ($product->is_in_stock()) {
        //awooc_html_custom_add_to_cart();
        echo '
        <button type="button" data-value-product-id="' . $product->get_id() . '" class="order-btn button">
			Купить в 1 клик		</button>
        ';
        woocommerce_template_loop_add_to_cart();
      } else {
        echo '<div class="button button-blue pre-order" data-id="' . $product->get_id() . '">Сообщить о поступлении</div>';
      }
      
    echo '</div>';
  echo '</div>';

}



// Функция для обновления вида карточек товаров
function update_product_view() {
    $view = $_POST['view'];
    set_transient('product_view', $view); // Сохраняем выбранный вид в кэше
    echo 'success';
    wp_die(); // Завершаем выполнение скрипта
}

// Добавляем обработчик Ajax
/* add_action('wp_ajax_update_product_view', 'update_product_view');
add_action('wp_ajax_nopriv_update_product_view', 'update_product_view'); */

// Локализируем путь к административной части WordPress и передаем его в скрипт
/* function add_ajax_url() {
   wp_enqueue_script('woo-listing', get_template_directory_uri() . '/js/woo-listing.js', array('jquery'), null, true);
    wp_localize_script( 'woo-listing', 'ajaxurl', admin_url( 'admin-ajax.php' ) );
}
add_action('wp_enqueue_scripts', 'add_ajax_url'); */

// Проверяем выбранный вид в кэше при загрузке страницы
/* function get_product_view() {
    $view = get_transient('product_view');
    if ($view) {
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() { 
              const catMainWrap = document.querySelector(".catalog-main .wrap .right ul.products");
                if (catMainWrap) {
                  catMainWrap.classList.add("' . $view . '"); 
                }
              });
            </script>';
    }
}
add_action('wp_footer', 'get_product_view'); */


add_filter('woocommerce_pagination_args', 'change_pagination_text');
function change_pagination_text($args){
    $args['prev_text'] = 'Назад';
    $args['next_text'] = 'Дальше';
    return $args;
}
