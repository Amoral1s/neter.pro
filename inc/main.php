<?php 

if ( ! function_exists( 'main_theme_setup' ) ) :
	function main_theme_setup() {
		load_theme_textdomain( 'main-theme', get_template_directory() . '/languages' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'editor-styles' );
		add_editor_style( 'css/acf-blocks-editor.css' );
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Main menu', 'main-theme' ),
				'menu-2' => esc_html__( 'Header secondary', 'main-theme' ),
				'menu-3' => esc_html__( 'mobile', 'main-theme' ),
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

if ( ! function_exists( 'main_theme_is_local_environment' ) ) {
	function main_theme_is_local_environment() {
		$host = isset( $_SERVER['HTTP_HOST'] ) ? (string) $_SERVER['HTTP_HOST'] : '';

		return in_array( $host, array( 'localhost', '127.0.0.1', 'neter.local', 'neter.local:8888', 'localhost:3000' ), true )
			|| strpos( $host, '.local' ) !== false;
	}
}

if ( ! function_exists( 'main_theme_should_enqueue_yandex_map' ) ) {
	function main_theme_should_enqueue_yandex_map() {
		if ( is_admin() ) {
			return false;
		}

		if ( is_front_page() ) {
			return true;
		}

		if (
			is_page_template( 'page-contacts.php' ) ||
			is_page_template( 'page-delivery.php' ) ||
			is_page( array( 'contacts', 'delivery', 'kontakty', 'dostavka' ) )
		) {
			return true;
		}

		return is_singular( 'product' );
	}
}

add_action( 'wp_enqueue_scripts', 'main_theme_enqueue_assets' );
function main_theme_enqueue_assets() {
	$template_uri  = get_template_directory_uri();
	$template_path = get_template_directory();
	$theme_version = wp_get_theme()->get( 'Version' );
	$should_enqueue_yandex_map = main_theme_should_enqueue_yandex_map();

	// Cache-bust assets when files change; fall back to theme version.
	$get_version = static function ( $relative_path ) use ( $template_path, $theme_version ) {
		$path = $template_path . $relative_path;
		return file_exists( $path ) ? filemtime( $path ) : $theme_version;
	};

	wp_enqueue_style( 'header', $template_uri . '/css/header.min.css', array(), $get_version( '/css/header.min.css' ) );
	wp_enqueue_style( 'main', $template_uri . '/css/main.min.css', array(), $get_version( '/css/main.min.css' ) );

	$style_path = get_stylesheet_directory() . '/style.css';
	wp_enqueue_style( 'stylecss', get_stylesheet_uri(), array(), file_exists( $style_path ) ? filemtime( $style_path ) : $theme_version );

	$header_menu_version = $get_version( '/js/header-menu.min.js' );
	$main_version        = $get_version( '/js/main.min.js' );
	$main_script_dependencies = array( 'jquery' );

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'header-menu', $template_uri . '/js/header-menu.min.js', array( 'jquery' ), $header_menu_version, false );
	wp_script_add_data( 'header-menu', 'strategy', 'defer' );

	wp_enqueue_script( 'main', $template_uri . '/js/main.min.js', $main_script_dependencies, $main_version, true );


	if ( $should_enqueue_yandex_map ) {
		wp_enqueue_script( 'yandex-api', 'https://api-maps.yandex.ru/2.1/?apikey=09db6a00-2892-4c98-9c87-7fd13a357553&lang=ru_RU', array( 'jquery' ), null, true );
		wp_script_add_data( 'yandex-api', 'strategy', 'defer' );
		$main_script_dependencies[] = 'yandex-api';
	}


	$placeholder_image = function_exists( 'wc_placeholder_img_src' ) ? wc_placeholder_img_src( 'woocommerce_thumbnail' ) : '';
	$comment_site_key  = isset( $GLOBALS['comment_RECAPTCHA_SITE_KEY'] ) ? (string) $GLOBALS['comment_RECAPTCHA_SITE_KEY'] : '';

	wp_localize_script(
		'main',
		'mainThemeData',
		array(
			'ajax_url'                    => admin_url( 'admin-ajax.php' ),
			'cart_cookie_name'            => 'neter_cart',
			'catalog_view_cookie_name'    => function_exists( 'main_theme_get_catalog_view_cookie_name' ) ? main_theme_get_catalog_view_cookie_name() : 'neter_catalog_view',
			'cookie_cart_products_action' => 'get_cookie_cart_products',
			'featured_cookie_name'        => function_exists( 'main_theme_get_featured_cookie_name' ) ? main_theme_get_featured_cookie_name() : 'neter_featured_products',
			'featured_validate_action'    => 'validate_featured_products',
			'compare_cookie_name'         => function_exists( 'main_theme_get_compare_cookie_name' ) ? main_theme_get_compare_cookie_name() : 'neter_compare_products',
			'compare_validate_action'     => 'validate_compare_products',
			'placeholder_image'           => $placeholder_image,
			'cart_form_id'                => 787,
			'is_local_comment'            => function_exists( 'is_local_comment' ) ? (bool) is_local_comment() : main_theme_is_local_environment(),
			'comment_recaptcha_site_key'  => $comment_site_key,
			'is_local_environment'        => main_theme_is_local_environment(),
			'review_recaptcha_site_key'   => '6LeZlf8pAAAAALIprB1_PfRBJBKPfwXhT2IV3SWw',
			'has_yandex_map'              => $should_enqueue_yandex_map,
		)
	);

}

add_action( 'wp_head', 'main_theme_preload_header_menu_script', 1 );
add_action( 'wp_head', 'main_theme_catalog_view_early_class_script', 0 );
function main_theme_catalog_view_early_class_script() {
	if ( is_admin() || is_search() ) {
		return;
	}

	$is_catalog_archive = false;

	if ( function_exists( 'is_shop' ) && is_shop() ) {
		$is_catalog_archive = true;
	}

	if ( function_exists( 'is_product_taxonomy' ) && is_product_taxonomy() ) {
		$is_catalog_archive = true;
	}

	if ( is_post_type_archive( 'product' ) ) {
		$is_catalog_archive = true;
	}

	if ( ! $is_catalog_archive ) {
		return;
	}

	$cookie_name = function_exists( 'main_theme_get_catalog_view_cookie_name' ) ? main_theme_get_catalog_view_cookie_name() : 'neter_catalog_view';
	?>
<script id="main-theme-catalog-view-early-class">
(function(){var c=<?php echo wp_json_encode( $cookie_name ); ?>;function g(n){var m=document.cookie.match(new RegExp("(?:^|; )"+n.replace(/([.$?*|{}()\[\]\\/+^])/g,"\\$1")+"=([^;]*)"));return m?decodeURIComponent(m[1]):""}function n(v){return v==="card"||v==="cards"?"cards":v==="table"?"table":""}try{var v=n(g(c))||n(window.localStorage&&window.localStorage.getItem(c))||"table";document.documentElement.classList.remove("catalog-view-pref-table","catalog-view-pref-cards");document.documentElement.classList.add("catalog-view-pref-"+v);document.documentElement.setAttribute("data-catalog-view",v)}catch(e){}})();
</script>
	<?php
}

function main_theme_preload_header_menu_script() {
	if ( is_admin() ) {
		return;
	}

	$template_uri  = get_template_directory_uri();
	$template_path = get_template_directory();
	$theme_version = wp_get_theme()->get( 'Version' );
	$file_path     = '/js/header-menu.min.js';
	$full_path     = $template_path . $file_path;
	$version       = file_exists( $full_path ) ? filemtime( $full_path ) : $theme_version;

	printf(
		'<link rel="preload" as="script" href="%s" />' . "\n",
		esc_url( add_query_arg( 'ver', $version, $template_uri . $file_path ) )
	);
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
