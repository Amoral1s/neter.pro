<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible,
 * but it does happen. When this occurs the version of the template file will
 * be bumped and the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}

// Массив атрибутов для отображения
$attributes = [
    'pa_napryazhenie' => '
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
				<path d="M8.62814 12.6736H8.16918C6.68545 12.6736 5.94358 12.6736 5.62736 12.1844C5.31114 11.6953 5.61244 11.0138 6.21504 9.65083L8.02668 5.55323C8.57457 4.314 8.84852 3.69438 9.37997 3.34719C9.91142 3 10.5859 3 11.935 3H14.0244C15.6632 3 16.4826 3 16.7916 3.53535C17.1007 4.0707 16.6942 4.78588 15.8811 6.21623L14.8092 8.10188C14.405 8.81295 14.2029 9.16849 14.2057 9.45952C14.2094 9.83775 14.4105 10.1862 14.7354 10.377C14.9854 10.5239 15.3927 10.5239 16.2074 10.5239C17.2373 10.5239 17.7523 10.5239 18.0205 10.7022C18.3689 10.9338 18.5513 11.3482 18.4874 11.7632C18.4382 12.0826 18.0918 12.4656 17.399 13.2317L11.8639 19.3523C10.7767 20.5545 10.2331 21.1556 9.86807 20.9654C9.50303 20.7751 9.67833 19.9822 10.0289 18.3962L10.7157 15.2896C10.9826 14.082 11.1161 13.4782 10.7951 13.0759C10.4741 12.6736 9.85877 12.6736 8.62814 12.6736Z" stroke="#2CB4C2" stroke-width="1.5" stroke-linejoin="round"/>
			</svg>
		',
    'pa_emkost-mah' => '
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
				<path d="M2 12C2 9.17157 2 7.75736 2.87868 6.87868C3.75736 6 5.17157 6 8 6H13C15.8284 6 17.2426 6 18.1213 6.87868C19 7.75736 19 9.17157 19 12C19 14.8284 19 16.2426 18.1213 17.1213C17.2426 18 15.8284 18 13 18H8C5.17157 18 3.75736 18 2.87868 17.1213C2 16.2426 2 14.8284 2 12Z" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round"/>
				<path d="M19 9.5L20.0272 9.6712C20.7085 9.78475 21.0491 9.84152 21.3076 10.0067C21.5618 10.1691 21.7612 10.4044 21.8796 10.6819C22 10.964 22 11.3093 22 12C22 12.6907 22 13.036 21.8796 13.3181C21.7612 13.5956 21.5618 13.8309 21.3076 13.9933C21.0491 14.1585 20.7085 14.2153 20.0272 14.3288L19 14.5" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round"/>
				<path d="M6 10V14" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round"/>
				<path d="M9 10V14" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round"/>
				<path d="M12 10V14" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round"/>
			</svg>
		',
];

?>

<li <?php wc_product_class( 'swiper-slide', $product ); ?>>
    <a class="product-top" href="<?php the_permalink(); ?>">
        <div class="product-thumb">
            <?php 
            if ( has_post_thumbnail( $product->get_id() ) ) {
                echo get_the_post_thumbnail( $product->get_id(), 'woocommerce_thumbnail' );
            } else {
                echo wc_placeholder_img( 'woocommerce_thumbnail' );
            }
            ?>
        </div>
        <div class="product-rating">
            <?php 
            $average = $product->get_average_rating();
            if ( $average ) {
                echo wc_get_rating_html( $average );
            } else {
                echo '<div class="star-rating"><span style="width:0%"></span></div>';
            }
            ?>
            <div class="aviable <?php echo $product->is_in_stock() ? 'aviable-true' : 'aviable-false'; ?>">
                <?php echo $product->is_in_stock() ? 'В наличии' : 'Нет в наличии'; ?>
            </div>
        </div>
        <b class="product-title">
            <?php echo $product->get_name(); ?>
        </b>
    </a>
		<div class="product-bottom">
            <?php if ((float)$product->get_price() != 1) : ?>
			<div class="product-price">
					<?php echo $product->get_price_html(); ?>
			</div>
            <?php endif; ?>
			<?php
				$attrs_output = '';
				foreach ( $attributes as $attribute_slug => $icon_html ) {
						$terms = wc_get_product_terms( $product->get_id(), $attribute_slug, array( 'fields' => 'names' ) );
						if ( ! empty( $terms ) ) {
								foreach ( $terms as $term ) {
										$attrs_output .= '<div class="item">';
										$attrs_output .= '<div class="icon">' . $icon_html . '</div>';
										$attrs_output .= '<p>' . esc_html( $term ) . '</p>';
										$attrs_output .= '</div>';
								}
						}
				}
				if ( ! empty( $attrs_output ) ) {
						echo '<div class="product-attrs">' . $attrs_output . '</div>';
				}
			?>
		</div>
    <?php
    do_action( 'woocommerce_before_shop_loop_item' );
    do_action( 'woocommerce_before_shop_loop_item_title' );
    do_action( 'woocommerce_shop_loop_item_title' );
    do_action( 'woocommerce_after_shop_loop_item_title' );
    do_action( 'woocommerce_after_shop_loop_item' );
    ?>
</li>