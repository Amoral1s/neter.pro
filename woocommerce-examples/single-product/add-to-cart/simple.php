<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product->is_purchasable() ) {
	return;
}

echo wc_get_stock_html( $product ); // WPCS: XSS ok.

if ( $product->is_in_stock() ) : ?>

	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

	<form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<?php
		/* do_action( 'woocommerce_before_add_to_cart_quantity' );

		woocommerce_quantity_input(
			array(
				'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
				'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
				'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
			)
		);

		do_action( 'woocommerce_after_add_to_cart_quantity' ); */
		?>

		<button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button button alt<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>">
			<svg class="normal" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
				<path d="M8 16L16.7201 15.2733C19.4486 15.046 20.0611 14.45 20.3635 11.7289L21 6" stroke="#304872" stroke-width="1.5" stroke-linecap="round"/>
				<path d="M6 6H6.5M22 6H19.5" stroke="#304872" stroke-width="1.5" stroke-linecap="round"/>
				<path d="M9.5 6H16.5M13 9.5V2.5" stroke="#304872" stroke-width="1.5" stroke-linecap="round"/>
				<path d="M6 22C7.10457 22 8 21.1046 8 20C8 18.8954 7.10457 18 6 18C4.89543 18 4 18.8954 4 20C4 21.1046 4.89543 22 6 22Z" stroke="#304872" stroke-width="1.5"/>
				<path d="M17 22C18.1046 22 19 21.1046 19 20C19 18.8954 18.1046 18 17 18C15.8954 18 15 18.8954 15 20C15 21.1046 15.8954 22 17 22Z" stroke="#304872" stroke-width="1.5"/>
				<path d="M8 20H15" stroke="#304872" stroke-width="1.5" stroke-linecap="round"/>
				<path d="M2 2H2.966C3.91068 2 4.73414 2.62459 4.96326 3.51493L7.93852 15.0765C8.08887 15.6608 7.9602 16.2797 7.58824 16.7616L6.63213 18" stroke="#304872" stroke-width="1.5" stroke-linecap="round"/>
			</svg>
			<svg class="added" style="display: none" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M1.04102 9.99999C1.04102 14.9476 5.0518 18.9583 9.99935 18.9583C14.9469 18.9583 18.9577 14.9476 18.9577 9.99999C18.9577 5.05244 14.9469 1.04166 9.99935 1.04166C5.0518 1.04166 1.04102 5.05244 1.04102 9.99999ZM13.8958 6.8857C14.235 7.19669 14.2579 7.72383 13.947 8.0631L9.36368 13.0631C9.21002 13.2307 8.99468 13.3282 8.76743 13.3332C8.54018 13.3381 8.32082 13.25 8.16009 13.0892L6.07676 11.0059C5.75132 10.6805 5.75132 10.1528 6.07676 9.82741C6.4022 9.50199 6.92983 9.50199 7.25527 9.82741L8.72318 11.2953L12.7183 6.93689C13.0293 6.59762 13.5565 6.57471 13.8958 6.8857Z" fill="#24B642"/>
			</svg>
		</button>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	</form>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif; ?>
