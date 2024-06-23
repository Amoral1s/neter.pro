<?php

remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);


//summary
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);

//bototm
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);

function custom_display_product_attributes_SINGLE() {
    global $product;

    $kolichestvo_polzovatelej = $product->get_attribute('kolichestvo-polzovatelej');
    $obem_pererabotki_m3_sutki = $product->get_attribute('obem-pererabotki-m3-sutki');
    $otvod = $product->get_attribute('tip-sliva');
    $type = $product->get_attribute('tip-ustrojstva');
    $brand = $product->get_attribute('brand');
    

    echo '<div class="product-attributes">';

    // Проверка наличия атрибута "kolichestvo-polzovatelej"
    if (!empty($kolichestvo_polzovatelej)) {
        echo '<div class="attr">
        <div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path d="M20.774 18C21.5233 18 22.1193 17.5285 22.6545 16.8691C23.7499 15.5194 21.9513 14.4408 21.2654 13.9126C20.568 13.3756 19.7894 13.0714 19 13M18 11C19.3807 11 20.5 9.88071 20.5 8.5C20.5 7.11929 19.3807 6 18 6" stroke="#24B642" stroke-width="1.5" stroke-linecap="round"/>
              <path d="M3.22596 18C2.47666 18 1.88067 17.5285 1.34555 16.8691C0.250087 15.5194 2.04867 14.4408 2.73465 13.9126C3.43197 13.3756 4.21058 13.0714 5 13M5.5 11C4.11929 11 3 9.88071 3 8.5C3 7.11929 4.11929 6 5.5 6" stroke="#24B642" stroke-width="1.5" stroke-linecap="round"/>
              <path d="M8.0838 15.1112C7.06203 15.743 4.38299 17.0331 6.0147 18.6474C6.81178 19.436 7.69952 20 8.81563 20H15.1844C16.3005 20 17.1882 19.436 17.9853 18.6474C19.617 17.0331 16.938 15.743 15.9162 15.1112C13.5201 13.6296 10.4799 13.6296 8.0838 15.1112Z" stroke="#24B642" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M15.5 7.5C15.5 9.433 13.933 11 12 11C10.067 11 8.5 9.433 8.5 7.5C8.5 5.567 10.067 4 12 4C13.933 4 15.5 5.567 15.5 7.5Z" stroke="#24B642" stroke-width="1.5"/>
            </svg>
        </div>
          <div class="meta">
            <p class="max">Пользователи</p>
            <span>' . $kolichestvo_polzovatelej . ' чел</span>
          </div>
        
        </div>';
    } 

    // Проверка наличия атрибута "tip-sliva"
    if (!empty($otvod)) {
        echo '<div class="attr max">
          <div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path d="M2 10C2.77968 6.18409 5.66918 3.12932 9.40618 2.08977C9.71987 2.00251 9.87671 1.95888 9.96119 2.05236C10.0457 2.14584 9.98344 2.30042 9.85897 2.60956L9 4.5M14 2C17.8159 2.77968 20.8707 5.66918 21.9102 9.40618C21.9975 9.71987 22.0411 9.87671 21.9476 9.96119C21.8542 10.0457 21.6996 9.98344 21.3904 9.85897L19.5 9M22 14C21.2203 17.8159 18.3308 20.8707 14.5938 21.9102C14.2801 21.9975 14.1233 22.0411 14.0388 21.9476C13.9543 21.8542 14.0166 21.6996 14.141 21.3904L15 19.5M10 22C6.18409 21.2203 3.12932 18.3308 2.08977 14.5938C2.00251 14.2801 1.95888 14.1233 2.05236 14.0388C2.14584 13.9543 2.30042 14.0166 2.60956 14.141L4.5 15" stroke="#24B642" stroke-width="1.5" stroke-linecap="round"/>
            <path d="M8 12.7551C8 10.8722 9.68508 9.01158 10.8678 7.9375C11.5102 7.35417 12.4898 7.35417 13.1322 7.9375C14.3149 9.01158 16 10.8722 16 12.7551C16 14.6012 14.4853 16.5 12 16.5C9.51472 16.5 8 14.6012 8 12.7551Z" stroke="#24B642" stroke-width="1.5"/>
            </svg>
        
        </div>
          <div class="meta">
            <p class="max">Отвод очищенной воды</p>
            <span>' . $otvod . '</span>
          </div>
        </div>
        ';
    } 

    // Проверка наличия атрибута "obem-pererabotki-m3-sutki"
    if (!empty($obem_pererabotki_m3_sutki)) {
        echo '<div class="attr"><div class="icon">

        <svg class="max"  xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
          <path d="M3.5 13.678C3.5 9.49387 7.08079 5.35907 9.59413 2.97222C10.9591 1.67593 13.0409 1.67593 14.4059 2.97222C16.9192 5.35907 20.5 9.49387 20.5 13.678C20.5 17.7804 17.2812 22 12 22C6.71878 22 3.5 17.7804 3.5 13.678Z" stroke="#24B642" stroke-width="1.5"/>
          <path d="M16 14C16 16.2091 14.2091 18 12 18" stroke="#24B642" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        
        </div>
        <div class="meta">
          <p class="max">Производительность</p>
          <span>' . $obem_pererabotki_m3_sutki . ' л/сут</span>
        </div>
        </div>';
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
        
        </div>
        <div class="meta">
          <p class="max">Тип устройства</p>
          <span>' . $type . '</span>
        </div>
        </div>';
    } 
    echo '</div>';

    echo '<div class="single-links">';
     // Проверка наличия атрибута "brand"
     if (!empty($brand)) {
      $brandTerm = $product->get_attributes('brand');

      // Получаем ID изображения атрибута через ACF по названию атрибута 'brand'
      $brand_id = $brandTerm['pa_brand']['data']['options'][0];
      $brand_logo = get_field('brand_logo', 'pa_brand_'. $brand_id);
      $image = $brand_logo ? $brand_logo : get_template_directory_uri() . '/img/placeholder.png';
      echo '
      
      <a href="'.get_term_link($brand_id).'" class="brand-block">
        <div class="meta">
          <p>'.$brand.'</p>
          <span>Все товары бренда</span>
        </div>
        <div class="image">
          <img src="'.$image.'" alt="'.$brand.'"> 
        </div>
        <div class="icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path d="M17 7L6 18" stroke="#24B642" stroke-width="1.5" stroke-linecap="round"/>
            <path d="M11 6H17C17.4714 6 17.7071 6 17.8536 6.14645C18 6.29289 18 6.5286 18 7V13" stroke="#24B642" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
      </a>';
    } 

      // Получаем основную категорию через YOAST
      $main_cat_id =  yoast_get_primary_term_id( 'product_cat', $product->id );
      $category = get_term_by('id', $main_cat_id, 'product_cat');

      if($main_cat_id) {
        $cat_name = $category->name;
        $cat_link = get_term_link($main_cat_id, 'product_cat');
        echo '
        <a href="'.$cat_link.'" class="brand-block">
          <div class="meta">
            <p>'.$cat_name.'</p>
            <span>Все товары категории</span>
          </div>
          <div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path d="M17 7L6 18" stroke="#24B642" stroke-width="1.5" stroke-linecap="round"/>
              <path d="M11 6H17C17.4714 6 17.7071 6 17.8536 6.14645C18 6.29289 18 6.5286 18 7V13" stroke="#24B642" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
        </a>';
      } 
      


    

    echo '</div>';
}


// Изменяем количество связанных товаров, отображаемых на странице
add_filter( 'woocommerce_output_related_products_args', 'custom_related_products_args' );
function custom_related_products_args( $args ) {
    $args['posts_per_page'] = 6; // Устанавливаем количество связанных товаров для отображения
    return $args;
}









