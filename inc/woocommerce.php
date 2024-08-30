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

 // Установка количества товаров на странице в цикле
function custom_wc_products_per_page( $query ) {
  if ( is_shop() || is_archive() ) {
      $query->set( 'posts_per_page', 100 ); // Укажите здесь желаемое количество товаров для отображения
  }
}
add_action( 'pre_get_posts', 'custom_wc_products_per_page' );





add_filter('woocommerce_pagination_args', 'change_pagination_text');
function change_pagination_text($args){
    $args['prev_text'] = 'Назад';
    $args['next_text'] = 'Дальше';
    return $args;
}
