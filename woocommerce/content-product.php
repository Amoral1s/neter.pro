<?php

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

static $catalog_context = null;

if ($catalog_context === null) {
    $current_category = '';
    $queried_object = get_queried_object();

    if ($queried_object && is_a($queried_object, 'WP_Term')) {
        if ($queried_object->parent) {
            $parent_category = get_term($queried_object->parent, 'product_cat');
            $current_category = $parent_category ? $parent_category->slug : '';
        } else {
            $current_category = $queried_object->slug;
        }
    }

    if (empty($current_category)) {
        $request_url = '';

        if (!empty($_SERVER['REQUEST_URI'])) {
            $request_url = (string) $_SERVER['REQUEST_URI'];
        } elseif (!empty($_SERVER['HTTP_REFERER'])) {
            $request_url = (string) $_SERVER['HTTP_REFERER'];
        }

        if (strpos($request_url, 'akkumulyatornye-batarei') !== false) {
            $current_category = 'akkumulyatornye-batarei';
        } elseif (strpos($request_url, 'bms-plata') !== false) {
            $current_category = 'bms-plata';
        } elseif (strpos($request_url, 'akkumulyatornye-yacheyki') !== false) {
            $current_category = 'akkumulyatornye-yacheyki';
        } elseif (strpos($request_url, 'zaryadnye-ustrojstva-dlya-akkumulyatorov') !== false) {
            $current_category = 'zaryadnye-ustrojstva-dlya-akkumulyatorov';
        }
    }

    $catalog_context = array(
        'current_category' => $current_category,
        'attributes_map'   => array(
            'default'                               => array('pa_tip-himii', 'pa_napryazhenie', 'pa_emkost-ah', 'pa_maks-tok-razryada-ab', 'pa_gabarity-mm', 'pa_ves-kg'),
            'akkumulyatornye-batarei'              => array('pa_tip-himii', 'pa_emkost-ah', 'pa_maks-tok-razryada-ab', 'pa_napryazhenie', 'pa_gabarity-mm', 'pa_ves-kg'),
            'bms-plata'                            => array('pa_tip-himii', 'pa_napryazhenie', 'pa_seriya', 'pa_tok-zaryada', 'pa_tok-razryada', 'pa_ves-kg'),
            'specials'                             => array('pa_tip-himii', 'pa_emkost-ah', 'pa_napryazhenie', 'pa_tokootdacha', 'pa_gabarity-mm', 'pa_ves-kg'),
            'akkumulyatornye-yacheyki'             => array('pa_tip-himii', 'pa_emkost-ah', 'pa_tokootdacha', 'pa_napryazhenie', 'pa_gabarity-mm', 'pa_ves-kg'),
            'zaryadnye-ustrojstva-dlya-akkumulyatorov' => array('pa_tip-himii', 'pa_napryazhenie-zaryada', 'pa_seriya', 'pa_tok-zaryada', 'pa_ves-kg'),
        ),
    );
}

$current_category = $catalog_context['current_category'];
$attributes_map = $catalog_context['attributes_map'];
$attributes_to_display = isset($attributes_map[$current_category]) ? $attributes_map[$current_category] : $attributes_map['default'];
$attributes = $product->get_attributes();
$new_product = get_post_meta($product->get_id(), 'new_product', true);
static $attribute_labels = array();
?>
<li <?php wc_product_class( 'table-product', $product ); ?>>
	<?php
		if ($new_product == true) {
			echo '<div class="label">Новинка</div>';
		}
	?>
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
			$attribute_label = isset($attribute_labels[$attribute_slug]) ? $attribute_labels[$attribute_slug] : wc_attribute_label($attribute_slug);
			$attribute_labels[$attribute_slug] = $attribute_label;

			if ( isset( $attributes[ $attribute_slug ] ) ) {
				$attribute_value = trim((string) $product->get_attribute($attribute_slug));
				if ($attribute_value !== '') {
					echo '<span class="attribute-name">' . esc_html( $attribute_label ) . ': </span>';
					echo '<span class="attribute-value">' . esc_html( $attribute_value ) . '</span>';
				} else {
					echo '-';
				}
			} else {
				echo '-';
			}
			echo '</div>';
		}
		?>
	</div>
</li>
