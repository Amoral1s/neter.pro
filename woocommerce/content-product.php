<?php

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

// Массив атрибутов, которые нужно вывести
$attributes_to_display = array(
	'pa_emkost', 
	'pa_napryazhenie', 
	'pa_postoyannyy-tok', 
	'pa_pikovyy-tok', 
	'pa_tok-zaryada', 
	'pa_razmery' 
);

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