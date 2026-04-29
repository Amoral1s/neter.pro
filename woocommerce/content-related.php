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

 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}

$product_id = $product->get_id();
static $featured_product_ids = null;
static $compare_product_ids = null;

if ($featured_product_ids === null) {
    $featured_product_ids = function_exists('main_theme_get_featured_product_ids_from_cookie')
        ? main_theme_get_featured_product_ids_from_cookie()
        : array();
}

if ($compare_product_ids === null) {
    $compare_product_ids = function_exists('main_theme_get_compare_product_ids_from_cookie')
        ? main_theme_get_compare_product_ids_from_cookie()
        : array();
}

$is_featured_product = in_array($product_id, $featured_product_ids, true);
$is_compare_product = in_array($product_id, $compare_product_ids, true);

// Массив атрибутов для отображения
$attributes = [
    'pa_napryazhenie' => '
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
				<path d="M8.62814 12.6736H8.16918C6.68545 12.6736 5.94358 12.6736 5.62736 12.1844C5.31114 11.6953 5.61244 11.0138 6.21504 9.65083L8.02668 5.55323C8.57457 4.314 8.84852 3.69438 9.37997 3.34719C9.91142 3 10.5859 3 11.935 3H14.0244C15.6632 3 16.4826 3 16.7916 3.53535C17.1007 4.0707 16.6942 4.78588 15.8811 6.21623L14.8092 8.10188C14.405 8.81295 14.2029 9.16849 14.2057 9.45952C14.2094 9.83775 14.4105 10.1862 14.7354 10.377C14.9854 10.5239 15.3927 10.5239 16.2074 10.5239C17.2373 10.5239 17.7523 10.5239 18.0205 10.7022C18.3689 10.9338 18.5513 11.3482 18.4874 11.7632C18.4382 12.0826 18.0918 12.4656 17.399 13.2317L11.8639 19.3523C10.7767 20.5545 10.2331 21.1556 9.86807 20.9654C9.50303 20.7751 9.67833 19.9822 10.0289 18.3962L10.7157 15.2896C10.9826 14.082 11.1161 13.4782 10.7951 13.0759C10.4741 12.6736 9.85877 12.6736 8.62814 12.6736Z" stroke="#2CB4C2" stroke-width="1.5" stroke-linejoin="round"/>
			</svg>
		',
    'pa_emkost-ah' => '
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

<li <?php wc_product_class( 'swiper-slide', $product ); ?> data-product-id="<?php echo esc_attr($product_id); ?>">
    <div class="product-icons">
        <div class="icon add-feat add-featured <?php echo $is_featured_product ? 'active' : ''; ?>" data-product-id="<?php echo esc_attr($product_id); ?>" role="button" aria-pressed="<?php echo $is_featured_product ? 'true' : 'false'; ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M4.1449 3.35515C7.12587 1.52662 9.8001 2.25537 11.4156 3.46861C11.6814 3.6682 11.8638 3.8048 11.9996 3.89704C12.1354 3.8048 12.3178 3.6682 12.5836 3.46861C14.1991 2.25537 16.8734 1.52662 19.8543 3.35515C21.9156 4.61952 23.0754 7.2606 22.6684 10.2951C22.2595 13.3443 20.2859 16.7929 16.1063 19.8865C14.6549 20.9614 13.5897 21.7503 11.9996 21.7503C10.4095 21.7503 9.34433 20.9614 7.89294 19.8865C3.71334 16.7929 1.73976 13.3443 1.33081 10.2951C0.923823 7.2606 2.08365 4.61952 4.1449 3.35515Z" fill="#E5E7EB"/>
            </svg>
        </div>
        <div class="icon add-compare <?php echo $is_compare_product ? 'active' : ''; ?>" data-product-id="<?php echo esc_attr($product_id); ?>" role="button" aria-pressed="<?php echo $is_compare_product ? 'true' : 'false'; ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.95526 13.25C4.97013 13.25 4.98505 13.25 5.00001 13.25C5.01496 13.25 5.02988 13.25 5.04476 13.25C5.47757 13.25 5.8744 13.2499 6.19721 13.2933C6.55269 13.3411 6.92842 13.4535 7.23744 13.7626C7.54647 14.0716 7.65891 14.4473 7.70671 14.8028C7.75011 15.1256 7.75006 15.5224 7.75001 15.9553C7.75001 15.9701 7.75001 15.9851 7.75001 16V17C7.75001 17.015 7.75001 17.0299 7.75001 17.0448C7.75006 17.4776 7.75011 17.8744 7.70671 18.1972C7.65891 18.5527 7.54647 18.9284 7.23744 19.2374C6.92842 19.5465 6.55269 19.6589 6.19721 19.7067C5.8744 19.7501 5.47757 19.7501 5.04475 19.75C5.02988 19.75 5.01496 19.75 5.00001 19.75C4.98505 19.75 4.97014 19.75 4.95526 19.75C4.52245 19.7501 4.12561 19.7501 3.8028 19.7067C3.44732 19.6589 3.07159 19.5465 2.76257 19.2374C2.45355 18.9284 2.3411 18.5527 2.29331 18.1972C2.24991 17.8744 2.24995 17.4776 2.25 17.0448C2.25001 17.0299 2.25001 17.015 2.25001 17V16C2.25001 15.985 2.25001 15.9701 2.25 15.9553C2.24995 15.5224 2.24991 15.1256 2.29331 14.8028C2.3411 14.4473 2.45355 14.0716 2.76257 13.7626C3.07159 13.4535 3.44732 13.3411 3.8028 13.2933C4.12561 13.2499 4.52244 13.25 4.95526 13.25Z" fill="#E5E7EB"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9553 9.25C11.9701 9.25001 11.985 9.25001 12 9.25001C12.015 9.25001 12.0299 9.25001 12.0448 9.25C12.4776 9.24995 12.8744 9.24991 13.1972 9.29331C13.5527 9.3411 13.9284 9.45355 14.2374 9.76257C14.5465 10.0716 14.6589 10.4473 14.7067 10.8028C14.7501 11.1256 14.7501 11.5224 14.75 11.9553C14.75 11.9701 14.75 11.9851 14.75 12V17C14.75 17.015 14.75 17.0299 14.75 17.0448C14.7501 17.4776 14.7501 17.8744 14.7067 18.1972C14.6589 18.5527 14.5465 18.9284 14.2374 19.2374C13.9284 19.5465 13.5527 19.6589 13.1972 19.7067C12.8744 19.7501 12.4776 19.7501 12.0448 19.75C12.0299 19.75 12.015 19.75 12 19.75C11.9851 19.75 11.9701 19.75 11.9553 19.75C11.5224 19.7501 11.1256 19.7501 10.8028 19.7067C10.4473 19.6589 10.0716 19.5465 9.76257 19.2374C9.45355 18.9284 9.3411 18.5527 9.29331 18.1972C9.24991 17.8744 9.24995 17.4776 9.25 17.0448C9.25001 17.0299 9.25001 17.015 9.25001 17V12C9.25001 11.985 9.25001 11.9701 9.25 11.9553C9.24995 11.5224 9.24991 11.1256 9.29331 10.8028C9.3411 10.4473 9.45355 10.0716 9.76257 9.76257C10.0716 9.45355 10.4473 9.3411 10.8028 9.29331C11.1256 9.24991 11.5224 9.24995 11.9553 9.25Z" fill="#E5E7EB"/>
                <path d="M18.9553 5.25L19 5.25001L19.0448 5.25C19.4776 5.24995 19.8744 5.24991 20.1972 5.29331C20.5527 5.3411 20.9284 5.45355 21.2374 5.76257C21.5465 6.07159 21.6589 6.44732 21.7067 6.8028C21.7501 7.12561 21.7501 7.52244 21.75 7.95525V8.00001V17.0448C21.7501 17.4776 21.7501 17.8744 21.7067 18.1972C21.6589 18.5527 21.5465 18.9284 21.2374 19.2374C20.9284 19.5465 20.5527 19.6589 20.1972 19.7067C19.8744 19.7501 19.4776 19.7501 19.0448 19.75H18.9553C18.5224 19.7501 18.1256 19.7501 17.8028 19.7067C17.4473 19.6589 17.0716 19.5465 16.7626 19.2374C16.4535 18.9284 16.3411 18.5527 16.2933 18.1972C16.2499 17.8744 16.25 17.4776 16.25 17.0448V8.00001V7.95526C16.25 7.52244 16.2499 7.12561 16.2933 6.8028C16.3411 6.44732 16.4535 6.07159 16.7626 5.76257C17.0716 5.45355 17.4473 5.3411 17.8028 5.29331C18.1256 5.24991 18.5224 5.24995 18.9553 5.25Z" fill="#E5E7EB"/>
            </svg>
        </div>
    </div>
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
            <div class="aviable <?php echo $product->is_in_stock() && ! $product->is_on_backorder() ? 'aviable-true' : 'aviable-false'; ?>">
                <?php
                if ( $product->is_in_stock() && ! $product->is_on_backorder() ) {
                    echo 'В наличии';
                } elseif ( $product->is_on_backorder() ) {
                    echo 'Предзаказ';
                } else {
                    echo 'Нет в наличии';
                }
                ?>
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
						$attribute_values = function_exists('main_theme_get_product_attribute_values')
							? main_theme_get_product_attribute_values($product, $attribute_slug, 'names')
							: array_filter(array_map('trim', explode(',', (string) $product->get_attribute($attribute_slug))));

						if ( ! empty( $attribute_values ) ) {
							foreach ( $attribute_values as $term ) {
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
