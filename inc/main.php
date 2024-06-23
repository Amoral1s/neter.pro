<?php 

if ( ! function_exists( 'main_theme_setup' ) ) :
	function main_theme_setup() {
		load_theme_textdomain( 'main-theme', get_template_directory() . '/languages' );
		add_theme_support( 'post-thumbnails' );
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Main menu', 'main-theme' ),
				'menu-2' => esc_html__( 'Header secondary', 'main-theme' ),
				'menu-3' => esc_html__( 'Footer 1', 'main-theme' ),
				'menu-4' => esc_html__( 'Footer 2', 'main-theme' ),
				'menu-5' => esc_html__( 'Footer 3', 'main-theme' ),
				'menu-6' => esc_html__( 'Mobile menu', 'main-theme' )
			)
		);
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'main_theme_setup' );

function main_theme_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'main-theme' ),
			'id'            => 'sidebar-1',
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '',
			'after_title'   => '',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar 2', 'main-theme' ),
			'id'            => 'sidebar-2',
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '',
			'after_title'   => '',
		)
	);
}
add_action( 'widgets_init', 'main_theme_widgets_init' );



//Удаление стилизации CF7
add_action( 'wpcf7_autop_or_not', '__return_false' );
add_filter('wpcf7_form_elements', function($content) {
	$content = preg_replace('/<(span)>/i', '\2', $content);
	return $content;
});

// Маска телефона для Contact Form 7
add_filter('wpcf7_validate_tel*', 'dco_wpcf7_validate', 10, 2);

function dco_wpcf7_validate($result, $tag) {
    // Получаем объект тега
    $tag = new WPCF7_FormTag($tag);

    // Получаем значение поля
    $value = isset($_POST[$tag->name]) ? trim(wp_unslash(strtr((string) $_POST[$tag->name], "\n", " "))) : '';

    // Указываем правила для тега с типом "tel"
    if ('tel' == $tag->basetype) {
        // Если тег обязателен и имеет пустое значение — выводим сообщение об ошибке
        if ($tag->is_required() && 18 != strlen($value)) {
            $result->invalidate($tag, 'Укажите верный телефон');
        // Если значение не пустое и не является корректным телефонным номером — выводим сообщение об ошибке
        } elseif ('' != $value && !wpcf7_is_tel($value)) {
            // Функция "wpcf7_get_message" выводит сообщения с вкладки "Уведомления при отправке формы" настроек формы
            $result->invalidate($tag, wpcf7_get_message('invalid_tel'));
        }
    }

    return $result;
}

if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> 'Основные',
		'menu_title'	=> 'Основные',
		'menu_slug' 	=> 'options'
	));
}

function remove_plugin_updates_ACF($value) {
  unset($value->response['advanced-custom-fields-pro/acf.php']);
  return $value; 
}
add_filter('site_transient_update_plugins', 'remove_plugin_updates_ACF'); 

function remove_plugin_updates_DUPLICATOR($value) {
  unset($value->response['duplicator-pro/index.php']);
  return $value; 
}
add_filter('site_transient_update_plugins', 'remove_plugin_updates_DUPLICATOR'); 

function remove_plugin_updates_ACC($value) {
  unset($value->response['seraphinite-accelerator-ext/plugin_root.php']);
  return $value; 
}
add_filter('site_transient_update_plugins', 'remove_plugin_updates_ACC'); 

function remove_plugin_updates_WISHLIST($value) {
  unset($value->response['ti-woocommerce-wishlist/ti-woocommerce-wishlist.php']);
  return $value; 
}
add_filter('site_transient_update_plugins', 'remove_plugin_updates_WISHLIST'); 

function remove_plugin_updates_COMPARE($value) {
  unset($value->response['products-compare-for-woocommerce/products-compare.php']);
  return $value; 
}
add_filter('site_transient_update_plugins', 'remove_plugin_updates_COMPARE'); 


function remove_plugin_updates_PERMALINK($value) {
  unset($value->response['permalink-manager-pro/permalink-manager.php']);
  return $value; 
}
add_filter('site_transient_update_plugins', 'remove_plugin_updates_PERMALINK'); 

function remove_plugin_updates_SEARCHPRO($value) {
  unset($value->response['ajax-search-pro/ajax-search-pro.php']);
  return $value; 
}
add_filter('site_transient_update_plugins', 'remove_plugin_updates_SEARCHPRO'); 

function remove_plugin_updates_WBWPRO($value) {
  unset($value->response['woofilter-pro/woofilter-pro.php']);
  return $value; 
}
add_filter('site_transient_update_plugins', 'remove_plugin_updates_WBWPRO'); 


 



add_action( 'wp_head', 'my_styles' );
function my_styles() {
		/* wp_enqueue_style( $handle, $src, $deps, $ver, $media ); */
		/* wp_enqueue_style( 'header', get_template_directory_uri() . '/css/header.min.css' ); */
		wp_enqueue_style( 'main', get_template_directory_uri() . '/css/main.min.css' );
		wp_enqueue_style( 'pages', get_template_directory_uri() . '/css/pages.min.css' );
		wp_enqueue_style( 'stylecss', get_stylesheet_uri() ); 
}
//wp_register_script( 'jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js', array(), '1.0', true );

add_action( 'wp_footer', 'my_scripts' );
function my_scripts() {
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', get_template_directory_uri() . '/js/jquery-3.2.1.js', array(), '1.0', true );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'main', get_template_directory_uri() . '/js/main.js', array('jquery'), null, true );
	wp_enqueue_script( 'yandex-api', 'https://api-maps.yandex.ru/2.1/?apikey=09db6a00-2892-4c98-9c87-7fd13a357553&lang=ru_RU', array('jquery'), null, true );
}

@ini_set( 'upload_max_size' , '1164M' );
@ini_set( 'post_max_size', '1164M');
@ini_set( 'max_execution_time', '3000' );

add_filter( 'upload_mimes', 'svg_upload_allow' );
function svg_upload_allow( $mimes ) {
	$mimes['svg']  = 'image/svg+xml';
	return $mimes;
}

add_filter( 'wp_check_filetype_and_ext', 'fix_svg_mime_type', 10, 5 );

function fix_svg_mime_type( $data, $file, $filename, $mimes, $real_mime = '' ){
	// WP 5.1 +
	if( version_compare( $GLOBALS['wp_version'], '5.1.0', '>=' ) )
		$dosvg = in_array( $real_mime, [ 'image/svg', 'image/svg+xml' ] );
	else
		$dosvg = ( '.svg' === strtolower( substr($filename, -4) ) );
	// mime тип был обнулен, поправим его
	// а также проверим право пользователя
	if( $dosvg ){
		// разрешим
		if( current_user_can('manage_options') ){
			$data['ext']  = 'svg';
			$data['type'] = 'image/svg+xml';
		}
		// запретим
		else {
			$data['ext'] = $type_and_ext['type'] = false;
		}
	}
	return $data;
}


