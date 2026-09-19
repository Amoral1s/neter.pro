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







add_filter('woocommerce_pagination_args', 'change_pagination_text');
function change_pagination_text($args){
    global $wp_rewrite;

    $args['prev_text'] = 'Назад';
    $args['next_text'] = 'Дальше';

    // Первая страница каталога должна вести на архив, без /page/1.
    $pagination_format = '/' . user_trailingslashit($wp_rewrite->pagination_base . '/%#%', 'paged');

    if (strpos($args['base'], $pagination_format) !== false) {
        $args['base'] = str_replace($pagination_format, $wp_rewrite->use_trailing_slashes ? '%_%/' : '%_%', $args['base']);
        $args['format'] = rtrim($pagination_format, '/');
    }

    return $args;
}
