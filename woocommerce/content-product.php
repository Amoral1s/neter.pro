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

$cell_shape_value = '';
$cell_shape_taxonomy = wc_attribute_taxonomy_name('forma-yachejki');

if (taxonomy_exists($cell_shape_taxonomy)) {
    $cell_shape_terms = wc_get_product_terms($product->get_id(), $cell_shape_taxonomy, array('fields' => 'slugs'));

    if (!is_wp_error($cell_shape_terms) && !empty($cell_shape_terms)) {
        $cell_shape_value = sanitize_title((string) reset($cell_shape_terms));
    }
}

if ($cell_shape_value === '') {
    $raw_cell_shape_value = trim((string) $product->get_attribute($cell_shape_taxonomy));

    if ($raw_cell_shape_value === '') {
        $raw_cell_shape_value = trim((string) $product->get_attribute('forma-yachejki'));
    }

    if ($raw_cell_shape_value !== '') {
        $cell_shape_value = sanitize_title($raw_cell_shape_value);
    }
}
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
	        <div class="icon">
	            <?php $value = $cell_shape_value; ?>
	            <?php if ($value == 'prizma') : ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="41" viewBox="0 0 24 41" fill="none">
                    <g clip-path="url(#clip0_4241_929)">
                        <path d="M21.9925 9.45898L16.3582 11.3993V40.056L21.9925 38.0784V9.45898Z" stroke="#9CA3AF" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M0.64917 3.19043L16.3581 11.3994V40.0561L0.64917 31.8471V3.19043Z" stroke="#9CA3AF" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M21.9927 9.45895L16.3584 11.3993L0.649414 3.1903L6.28374 1.25L21.9927 9.45895Z" stroke="#9CA3AF" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M10.3372 5.6355C10.6038 5.53296 10.8909 5.53296 11.1575 5.6355C11.3421 5.73805 11.3011 5.92263 11.0345 6.02518C10.7678 6.12772 10.4807 6.12772 10.2141 6.02518C10.0295 5.92263 10.0705 5.73805 10.3372 5.6355Z" stroke="#9CA3AF" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M5.53832 3.07935C5.80494 2.9768 6.09207 2.9768 6.35869 3.07935C6.54327 3.1819 6.50226 3.36648 6.23564 3.46903C5.96902 3.57157 5.68189 3.57157 5.41527 3.46903C5.23069 3.36648 5.2717 3.1819 5.53832 3.07935Z" stroke="#9CA3AF" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M16.1526 8.76978C16.4192 8.66723 16.7063 8.66723 16.9729 8.76978C17.1575 8.87233 17.1165 9.05691 16.8499 9.15945C16.5833 9.262 16.2961 9.262 16.0295 9.15945C15.8449 9.05691 15.886 8.87233 16.1526 8.76978Z" stroke="#9CA3AF" stroke-linecap="round" stroke-linejoin="round"/>
                    </g>
                    <defs>
                        <clipPath id="clip0_4241_929">
                        <rect width="24" height="41" fill="white"/>
                        </clipPath>
                    </defs>
                </svg>
            <?php elseif ($value == 'czilindr' ) : ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="41" viewBox="0 0 24 41" fill="none">
                    <path d="M11.9998 1.75464C13.8835 1.75464 15.5685 2.30053 16.7693 3.15796C17.971 4.01608 18.656 5.15659 18.656 6.36401C18.656 7.57143 17.9711 8.71196 16.7693 9.57007C15.5685 10.4275 13.8835 10.9734 11.9998 10.9734C10.1162 10.9733 8.43195 10.4273 7.2312 9.57007C6.02943 8.71196 5.34451 7.57143 5.34448 6.36401C5.34448 5.15658 6.02941 4.01608 7.2312 3.15796C8.43195 2.30068 10.1162 1.75469 11.9998 1.75464Z" stroke="#9CA3AF"/>
                    <path d="M12.0002 4.5293C12.8109 4.52932 13.5242 4.76485 14.0217 5.12012C14.5201 5.47606 14.7698 5.92316 14.7698 6.36426C14.7696 6.8052 14.5199 7.25161 14.0217 7.60742C13.5242 7.96269 12.8109 8.19822 12.0002 8.19824C11.1896 8.19824 10.4763 7.96271 9.97876 7.60742C9.48049 7.25159 9.23089 6.80525 9.23071 6.36426C9.23071 5.92311 9.48031 5.47608 9.97876 5.12012C10.4763 4.76483 11.1896 4.5293 12.0002 4.5293Z" stroke="#9CA3AF"/>
                    <path d="M5.38516 6.36401L5.38501 34.7587C5.38501 37.5126 8.34664 39.7451 12 39.7451C15.6534 39.7451 18.615 37.5126 18.615 34.7587L18.6151 6.36401" stroke="#9CA3AF"/>
                </svg>
            <?php elseif ($value == 'pauch' ) : ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="41" viewBox="0 0 24 41" fill="none">
                    <g clip-path="url(#clip0_4241_929)">
                        <path d="M21.9925 9.45898L16.3582 11.3993V40.056L21.9925 38.0784V9.45898Z" stroke="#9CA3AF" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M0.64917 3.19043L16.3581 11.3994V40.0561L0.64917 31.8471V3.19043Z" stroke="#9CA3AF" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M21.9927 9.45895L16.3584 11.3993L0.649414 3.1903L6.28374 1.25L21.9927 9.45895Z" stroke="#9CA3AF" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M10.3372 5.6355C10.6038 5.53296 10.8909 5.53296 11.1575 5.6355C11.3421 5.73805 11.3011 5.92263 11.0345 6.02518C10.7678 6.12772 10.4807 6.12772 10.2141 6.02518C10.0295 5.92263 10.0705 5.73805 10.3372 5.6355Z" stroke="#9CA3AF" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M5.53832 3.07935C5.80494 2.9768 6.09207 2.9768 6.35869 3.07935C6.54327 3.1819 6.50226 3.36648 6.23564 3.46903C5.96902 3.57157 5.68189 3.57157 5.41527 3.46903C5.23069 3.36648 5.2717 3.1819 5.53832 3.07935Z" stroke="#9CA3AF" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M16.1526 8.76978C16.4192 8.66723 16.7063 8.66723 16.9729 8.76978C17.1575 8.87233 17.1165 9.05691 16.8499 9.15945C16.5833 9.262 16.2961 9.262 16.0295 9.15945C15.8449 9.05691 15.886 8.87233 16.1526 8.76978Z" stroke="#9CA3AF" stroke-linecap="round" stroke-linejoin="round"/>
                    </g>
                    <defs>
                        <clipPath id="clip0_4241_929">
                        <rect width="24" height="41" fill="white"/>
                        </clipPath>
                    </defs>
                </svg>
            <?php endif; ?>
        </div>
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
