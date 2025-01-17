<?php

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}



// Инициализируем переменную для хранения текущей категории
$current_category = ''; 

// Получаем текущий объект категории
$queried_object = get_queried_object();

// Проверяем, определена ли категория на основе текущего URL
if ($queried_object && is_a($queried_object, 'WP_Term')) {
    // Проверяем, есть ли родительская категория
    if ($queried_object->parent) {
        // Получаем основную (родительскую) категорию
        $parent_category = get_term($queried_object->parent, 'product_cat');
        $current_category = $parent_category->slug;
    } else {
        // Если родительской категории нет, используем текущую
        $current_category = $queried_object->slug;
    }
}

// Если категория не определена через текущий объект (например, при AJAX-запросе), проверяем HTTP_REFERER
if (empty($current_category)) {
    $current_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

    if (strpos($current_url, 'akkumulyatornye-batarei') !== false) {
        $current_category = 'akkumulyatornye-batarei';
    } elseif (strpos($current_url, 'bms-plata') !== false) {
        $current_category = 'bms-plata';
    } elseif (strpos($current_url, 'akkumulyatornye-yacheyki') !== false) {
        $current_category = 'akkumulyatornye-yacheyki';
    } elseif (strpos($current_url, 'zaryadnye-ustrojstva-dlya-akkumulyatorov') !== false) {
        $current_category = 'zaryadnye-ustrojstva-dlya-akkumulyatorov';
    }
}

// Определяем атрибуты для отображения на основе текущей категории
$attributes_to_display = array(
    'pa_tip-himii', 
    'pa_napryazhenie', 
    'pa_emkost-ah', 
    'pa_maks-tok-razryada-ab', 
    'pa_gabarity-mm', 
    'pa_ves-kg'  
);

if ($current_category) {
    if ($current_category == 'akkumulyatornye-batarei') {
        $attributes_to_display = array(
            'pa_tip-himii', 
            'pa_napryazhenie', 
            'pa_emkost-ah', 
            'pa_maks-tok-razryada-ab', 
            'pa_gabarity-mm', 
            'pa_ves-kg' 
        );
    } elseif ($current_category == 'bms-plata') {
        $attributes_to_display = array(
            'pa_tip-himii', 
            'pa_napryazhenie', 
            'pa_seriya', 
            'pa_tok-zaryada', 
            'pa_tok-razryada', 
            'pa_ves-kg' 
        );
    } elseif ($current_category == 'akkumulyatornye-yacheyki') {
        $attributes_to_display = array(
            'pa_tip-himii', 
            'pa_emkost-ah', 
            'pa_napryazhenie', 
            'pa_tokootdacha', 
            'pa_gabarity-mm', 
            'pa_ves-kg' 
        );
    } elseif ($current_category == 'zaryadnye-ustrojstva-dlya-akkumulyatorov') {
        $attributes_to_display = array(
            'pa_tip-himii', 
            'pa_napryazhenie-zaryada', 
            'pa_seriya', 
            'pa_tok-zaryada', 
            'pa_ves-kg' 
        );
    }
}




// Получаем все атрибуты продукта
$attributes = $product->get_attributes();

// Получаем цены
$regular_price = $product->get_regular_price();
$sale_price = $product->get_sale_price();
$price_to_display = $sale_price ? $sale_price : $regular_price;
 
// Форматирование цены и удаление HTML-тегов
$price_formatted = wp_strip_all_tags( wc_price( $price_to_display ) );

?>
<li <?php wc_product_class( 'table-product', $product ); ?>>
	<div class="table-product-cart">
		<?php woocommerce_template_loop_add_to_cart(); ?>
		<div class="load-circle"></div>
	</div>
	<a class="table-product-title" href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>">
		<?php echo esc_html( $product->get_name() ); ?>
	</a>
	<div class="table-product-attributes">
		<?php
		foreach ( $attributes_to_display as $attribute_slug ) {
			echo '<div class="product-attribute">';
			if ( isset( $attributes[ $attribute_slug ] ) ) {
				$attribute = $attributes[ $attribute_slug ];

				if ( $attribute->is_taxonomy() ) {
					$terms = wc_get_product_terms( $product->get_id(), $attribute_slug, array( 'fields' => 'names' ) );
					echo '<span class="attribute-name">' . esc_html( wc_attribute_label( $attribute_slug ) ) . ': </span>';
					echo '<span class="attribute-value">' . esc_html( implode( ', ', $terms ) ) . '</span>';
				} else {
					// Если это не таксономия, получаем значение атрибута напрямую
					echo '<span class="attribute-name">' . esc_html( wc_attribute_label( $attribute_slug ) ) . ': </span>';
					echo '<span class="attribute-value">' . esc_html( implode( ', ', $attribute->get_options() ) ) . '</span>';
				}
			} else {
				echo '-';
			}
			echo '</div>';
		}
		?>
		<!-- <div class="product-attribute price">
			<span class="attribute-name"><?php esc_html_e( 'Price', 'woocommerce' ); ?>: </span>
			<span class="attribute-value"><?php echo esc_html( $price_formatted ); ?></span>
		</div> -->
	</div>
</li>