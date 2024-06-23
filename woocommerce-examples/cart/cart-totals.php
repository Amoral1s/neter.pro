<?php
/**
 * Cart totals
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-totals.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.3.6
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="cart_totals <?php echo ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : ''; ?>">

	<?php do_action( 'woocommerce_before_cart_totals' ); ?>
	<?php // Получаем количество товаров в корзине
		function get_cart_item_count_text($count) {
			$forms = ['товар', 'товара', 'товаров'];
			$form = 0;
			if ($count % 10 == 1 && $count % 100 != 11) {
					$form = 0;
			} elseif ($count % 10 >= 2 && $count % 10 <= 4 && ($count % 100 < 10 || $count % 100 >= 20)) {
					$form = 1;
			} else {
					$form = 2;
			}
			return $count . ' ' . $forms[$form] . ' в корзине';
		}
		
		// Получаем количество товаров в корзине
		$cart_count = WC()->cart->get_cart_contents_count();
	?>
	
	<div class="cart-total-items">
		<?php echo get_cart_item_count_text($cart_count); ?>
	</div>
	<div class="cart-total-price">
			<?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>
		<div class="order-total">
			<?php wc_cart_totals_order_total_html(); ?>
		</div>
		<?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>
	</div>
	<div class="meta">
		<div class="meta-item">
			<p>Стоимость товаров</p>
			<div class="line"></div>
			<b><?php wc_cart_totals_subtotal_html(); ?></b>
		</div>
		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
				<th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
				<td data-title="<?php echo esc_attr( wc_cart_totals_coupon_label( $coupon, false ) ); ?>"><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<div class="meta-item">
				<p><?php echo esc_html( $fee->name ); ?></p>
				<div class="line"></div>
				<b><?php wc_cart_totals_fee_html( $fee ); ?></b>
			</div>
		<?php endforeach; ?>
		<?php 
			$discount_total = 0;
			foreach (WC()->cart->get_cart() as $cart_item) {
					// Получаем цену товара
					$product = $cart_item['data'];
					$product_price = $product->get_regular_price();
					// Проверяем, есть ли скидка на товар
					if ( $product->is_on_sale() ) {
							// Вычисляем сумму скидки на товар
							$discount = $product_price - $product->get_sale_price();
							// Увеличиваем общую сумму скидки
							$discount_total += $discount * $cart_item['quantity'];
					}
			}

			if ($discount_total > 0) { 
				$number = $discount_total;
				$formatted_number = number_format($number, 0, '.', ' ');
			?>
			<div class="meta-item">
				<p>Скидка на товары</p>
				<div class="line"></div>
				<b><?php echo $formatted_number; ?> ₽</b>
			</div>

		<?php }

		?>
		
		<div class="meta-item">
			<p>Доставка</p>
			<div class="line"></div>
			<b>Оплачивается отдельно</b>
		</div>
		
		

	</div>

	<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>

	<div class="button button-blue cart-order">
		<span>Купить в 1 клик</span>
	</div>

	<?php do_action( 'woocommerce_after_cart_totals' ); ?>

</div>
