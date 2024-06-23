<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>


<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'single-product', $product ); ?>>
	<div class="wrap">
		<div class="single-product-top" style="display: none">
			<h1 class="page-title sub"><?php the_title(); ?></h1>
			<div class="wrapper">
				<div class="wrapper-left">
					<?php echo do_shortcode('[ti_wishlists_addtowishlist]'); ?>
					<div class="item compare">
						<div class="icon">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
								<path d="M7 17V16C7 15.0572 7 14.5858 6.70711 14.2929C6.41421 14 5.94281 14 5 14C4.05719 14 3.58579 14 3.29289 14.2929C3 14.5858 3 15.0572 3 16V17C3 17.9428 3 18.4142 3.29289 18.7071C3.58579 19 4.05719 19 5 19C5.94281 19 6.41421 19 6.70711 18.7071C7 18.4142 7 17.9428 7 17Z" stroke="#24B642" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M14 17V12C14 11.0572 14 10.5858 13.7071 10.2929C13.4142 10 12.9428 10 12 10C11.0572 10 10.5858 10 10.2929 10.2929C10 10.5858 10 11.0572 10 12V17C10 17.9428 10 18.4142 10.2929 18.7071C10.5858 19 11.0572 19 12 19C12.9428 19 13.4142 19 13.7071 18.7071C14 18.4142 14 17.9428 14 17Z" stroke="#24B642" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M21 17V8C21 7.05719 21 6.58579 20.7071 6.29289C20.4142 6 19.9428 6 19 6C18.0572 6 17.5858 6 17.2929 6.29289C17 6.58579 17 7.05719 17 8V17C17 17.9428 17 18.4142 17.2929 18.7071C17.5858 19 18.0572 19 19 19C19.9428 19 20.4142 19 20.7071 18.7071C21 18.4142 21 17.9428 21 17Z" stroke="#24B642" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						</div>
					</div>
					<div class="item single-share">
						<div class="icon">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
								<path d="M18 7C18.7745 7.16058 19.3588 7.42859 19.8284 7.87589C21 8.99181 21 10.7879 21 14.38C21 17.9721 21 19.7681 19.8284 20.8841C18.6569 22 16.7712 22 13 22H11C7.22876 22 5.34315 22 4.17157 20.8841C3 19.7681 3 17.9721 3 14.38C3 10.7879 3 8.99181 4.17157 7.87589C4.64118 7.42859 5.2255 7.16058 6 7" stroke="#24B642" stroke-width="1.5" stroke-linecap="round"/>
								<path d="M12.0253 2.00052L12 14M12.0253 2.00052C11.8627 1.99379 11.6991 2.05191 11.5533 2.17492C10.6469 2.94006 9 4.92886 9 4.92886M12.0253 2.00052C12.1711 2.00657 12.3162 2.06476 12.4468 2.17508C13.3531 2.94037 15 4.92886 15 4.92886" stroke="#24B642" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						</div>
						<span>Поделиться</span>
						<div class="share">
							<script src="https://yastatic.net/share2/share.js"></script>
							<div class="wrapper">
								<div class="ya-share2 share-block" data-curtain data-shape="round" data-services="vkontakte,telegram,whatsapp"></div>
								<div class="share-link">
									<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
										<path fill-rule="evenodd" clip-rule="evenodd" d="M13.1727 9.32599C11.8822 8.03546 9.80945 8.00326 8.48045 9.22941C8.14215 9.54141 7.61494 9.52024 7.30287 9.18191C6.9908 8.84366 7.01203 8.31645 7.35031 8.00437C9.33403 6.17428 12.4258 6.22196 14.3513 8.14744C16.3256 10.1218 16.3256 13.3229 14.3513 15.2973L11.9627 17.6858C9.98828 19.6602 6.78721 19.6602 4.81282 17.6858C2.83843 15.7115 2.83843 12.5104 4.81282 10.536L5.19978 10.149C5.52522 9.82357 6.05285 9.82357 6.37829 10.1491C6.70373 10.4745 6.70372 11.0021 6.37828 11.3276L5.99133 11.7145C4.66783 13.038 4.66783 15.1838 5.99133 16.5073C7.31484 17.8308 9.4607 17.8308 10.7842 16.5073L13.1727 14.1188C14.4963 12.7953 14.4963 10.6495 13.1727 9.32599Z" fill="#9CA3AF"/>
										<path fill-rule="evenodd" clip-rule="evenodd" d="M14.0086 3.49264C12.6851 2.16913 10.5393 2.16913 9.2158 3.49264L6.82727 5.88118C5.50376 7.2047 5.50376 9.35051 6.82727 10.674C8.11776 11.9645 10.1906 11.9968 11.5196 10.7706C11.8579 10.4586 12.3851 10.4798 12.6971 10.8181C13.0092 11.1563 12.988 11.6835 12.6497 11.9956C10.666 13.8258 7.57424 13.778 5.64876 11.8526C3.67437 9.87818 3.67437 6.67706 5.64876 4.70268L8.0373 2.31413C10.0117 0.339747 13.2128 0.339747 15.1872 2.31413C17.1616 4.28852 17.1616 7.48963 15.1872 9.46401L14.8002 9.85093C14.4748 10.1764 13.9471 10.1764 13.6217 9.85093C13.2963 9.52551 13.2963 8.99793 13.6217 8.67243L14.0086 8.28549C15.3322 6.96198 15.3322 4.81615 14.0086 3.49264Z" fill="#9CA3AF"/>
									</svg>
								</div>
							</div>
						</div>
					</div>
					<div class="aviab">
						<?php 
							if ($product->is_in_stock()) {
								echo '<span class="in-stock">В наличии</span>';
							} else {
								echo '<span class="out-stock">Нет в наличии</span>';
							}
						?>
					</div>
				</div>
				<div class="wrapper-right">
					<p><?php echo 'Арт: ' . $product->get_sku(); ?></p>
				</div>
			</div>
		</div>
		<div class="left-single">
			<div class="mob-top">
				<div class="back-btn"  onclick="history.back()">
					<div class="icon">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
							<path d="M15 18L9.7071 12.7071C9.3738 12.3738 9.2071 12.2071 9.2071 12C9.2071 11.7929 9.3738 11.6262 9.7071 11.2929L15 6" stroke="#24B642" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</div>
					<span>Назад</span>
				</div>
				<div class="mob-share">
					<div class="share-icon">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
							<path d="M18 7C18.7745 7.16058 19.3588 7.42859 19.8284 7.87589C21 8.99181 21 10.7879 21 14.38C21 17.9721 21 19.7681 19.8284 20.8841C18.6569 22 16.7712 22 13 22H11C7.22876 22 5.34315 22 4.17157 20.8841C3 19.7681 3 17.9721 3 14.38C3 10.7879 3 8.99181 4.17157 7.87589C4.64118 7.42859 5.2255 7.16058 6 7" stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round"/>
							<path d="M12.0253 2.00052L12 14M12.0253 2.00052C11.8627 1.99379 11.6991 2.05191 11.5533 2.17492C10.6469 2.94006 9 4.92886 9 4.92886M12.0253 2.00052C12.1711 2.00657 12.3162 2.06476 12.4468 2.17508C13.3531 2.94037 15 4.92886 15 4.92886" stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</div>
					<div class="wrapper" style="display: none">
						<div class="ya-share2 share-block" data-curtain data-shape="round" data-services="vkontakte,telegram,whatsapp"></div>
						<div class="share-link">
							<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
								<path fill-rule="evenodd" clip-rule="evenodd" d="M13.1727 9.32599C11.8822 8.03546 9.80945 8.00326 8.48045 9.22941C8.14215 9.54141 7.61494 9.52024 7.30287 9.18191C6.9908 8.84366 7.01203 8.31645 7.35031 8.00437C9.33403 6.17428 12.4258 6.22196 14.3513 8.14744C16.3256 10.1218 16.3256 13.3229 14.3513 15.2973L11.9627 17.6858C9.98828 19.6602 6.78721 19.6602 4.81282 17.6858C2.83843 15.7115 2.83843 12.5104 4.81282 10.536L5.19978 10.149C5.52522 9.82357 6.05285 9.82357 6.37829 10.1491C6.70373 10.4745 6.70372 11.0021 6.37828 11.3276L5.99133 11.7145C4.66783 13.038 4.66783 15.1838 5.99133 16.5073C7.31484 17.8308 9.4607 17.8308 10.7842 16.5073L13.1727 14.1188C14.4963 12.7953 14.4963 10.6495 13.1727 9.32599Z" fill="#9CA3AF"/>
								<path fill-rule="evenodd" clip-rule="evenodd" d="M14.0086 3.49264C12.6851 2.16913 10.5393 2.16913 9.2158 3.49264L6.82727 5.88118C5.50376 7.2047 5.50376 9.35051 6.82727 10.674C8.11776 11.9645 10.1906 11.9968 11.5196 10.7706C11.8579 10.4586 12.3851 10.4798 12.6971 10.8181C13.0092 11.1563 12.988 11.6835 12.6497 11.9956C10.666 13.8258 7.57424 13.778 5.64876 11.8526C3.67437 9.87818 3.67437 6.67706 5.64876 4.70268L8.0373 2.31413C10.0117 0.339747 13.2128 0.339747 15.1872 2.31413C17.1616 4.28852 17.1616 7.48963 15.1872 9.46401L14.8002 9.85093C14.4748 10.1764 13.9471 10.1764 13.6217 9.85093C13.2963 9.52551 13.2963 8.99793 13.6217 8.67243L14.0086 8.28549C15.3322 6.96198 15.3322 4.81615 14.0086 3.49264Z" fill="#9CA3AF"/>
							</svg>
						</div>
					</div>
				</div>
				
			</div>
			
			<?php if (get_field('label')) : ?>
				<div class="label-row">
					<?php if (have_rows('label')) : while(have_rows('label')) : the_row(); ?>
						<div class="label">
							<?php echo get_sub_field('name'); ?>
						</div>
					<?php endwhile; endif; ?>
				</div>
				<?php else: ?>
					<?php if ($product->is_on_sale()) : ?>
					<div class="label-row">
						<div class="label">
							<?php woocommerce_show_product_sale_flash(); ?>
						</div>
					</div>
				<?php endif; ?>

			<?php endif; ?>
			
			<?php
			/**
			 * Hook: woocommerce_before_single_product_summary.
			 *
			 * @hooked woocommerce_show_product_sale_flash - 10
			 * @hooked woocommerce_show_product_images - 20
			 */
			do_action( 'woocommerce_before_single_product_summary' );
			?>
		</div>
		<div class="mob-wrap">
			<div class="aviab">
				<?php 
					if ($product->is_in_stock()) {
						echo '<span class="in-stock">В наличии</span>';
					} else {
						echo '<span class="out-stock">Нет в наличии</span>';
					}
				?>
			</div>
			<b class="title"><?php the_title(); ?></b>
			<div class="mob-wrap-icons">
				<?php echo do_shortcode('[ti_wishlists_addtowishlist]'); ?>
				<div class=" compare">
					<div class="icon">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
							<path d="M7 17V16C7 15.0572 7 14.5858 6.70711 14.2929C6.41421 14 5.94281 14 5 14C4.05719 14 3.58579 14 3.29289 14.2929C3 14.5858 3 15.0572 3 16V17C3 17.9428 3 18.4142 3.29289 18.7071C3.58579 19 4.05719 19 5 19C5.94281 19 6.41421 19 6.70711 18.7071C7 18.4142 7 17.9428 7 17Z" stroke="#24B642" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M14 17V12C14 11.0572 14 10.5858 13.7071 10.2929C13.4142 10 12.9428 10 12 10C11.0572 10 10.5858 10 10.2929 10.2929C10 10.5858 10 11.0572 10 12V17C10 17.9428 10 18.4142 10.2929 18.7071C10.5858 19 11.0572 19 12 19C12.9428 19 13.4142 19 13.7071 18.7071C14 18.4142 14 17.9428 14 17Z" stroke="#24B642" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M21 17V8C21 7.05719 21 6.58579 20.7071 6.29289C20.4142 6 19.9428 6 19 6C18.0572 6 17.5858 6 17.2929 6.29289C17 6.58579 17 7.05719 17 8V17C17 17.9428 17 18.4142 17.2929 18.7071C17.5858 19 18.0572 19 19 19C19.9428 19 20.4142 19 20.7071 18.7071C21 18.4142 21 17.9428 21 17Z" stroke="#24B642" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</div>
				</div>
			</div>
		</div>
		<div class="center">
			<b class="mini-title">
				Основные характеристики
			</b>
			<div class="center-wrapper">
				<?php custom_display_product_attributes_SINGLE(); ?>
			</div>
		</div>
		<div class="right-single summary entry-summary">
			<div class="right-single-top">
				<div class="price-wrapper">
					<?php 
						if ($product->is_on_sale()) {
							$regular_price = $product->get_regular_price();
							$sale_price = $product->get_sale_price();
			
							if ($regular_price > 0) {
									$discount_percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
									echo '<span class="product-price">';
										woocommerce_template_single_price();
									echo '<span class="discount-percentage">-' . $discount_percentage . '%</span>';
									echo '</span>';
							}
						} else {
								echo '<span class="product-price not-sale">';
								woocommerce_template_single_price();
								echo '</span>';
						}
					?>
				</div>
				<div class="add-cart-wrapper">
					<?php woocommerce_template_single_add_to_cart(); ?>
				</div>
			</div>
			<?php if (get_field('product_action')) : ?>
			<div class="product-text">
				<?php echo get_field('product_action'); ?>
			</div>
			<?php endif; ?>
			<?php if (get_field('action_date') && $product->is_in_stock()) : 
				$action_date = DateTime::createFromFormat('d/m/Y', get_field('action_date'));
				$current_date = new DateTime();
				
				// Проверяем, что дата акции находится в будущем
				if ($action_date >= $current_date) {
						$interval = $current_date->diff($action_date);
						$days_left = $interval->days;
						
						$days_word = 'день';
						
						// Склоняем слово "день" в зависимости от числа
						if ($days_left > 1 && $days_left < 5) {
								$days_word = 'дня';
						} elseif ($days_left >= 5) {
								$days_word = 'дней';
					}
					?>
					<div class="action-date">
						<div class="icon">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
								<path fill-rule="evenodd" clip-rule="evenodd" d="M12.45 1.40001C12.8831 1.72485 13.3601 2.13101 13.7439 2.46683C14.5104 3.13754 15.5343 4.09722 16.5606 5.25174C18.5779 7.5212 20.75 10.7037 20.75 14C20.75 18.8325 16.8325 22.75 12 22.75C7.16751 22.75 3.25 18.8325 3.25 14C3.25 10.7037 5.42215 7.5212 7.43944 5.25174C7.61213 5.05746 7.8731 4.96645 8.12915 5.01122C8.3852 5.05598 8.59982 5.23013 8.69636 5.47147C8.94564 6.09466 9.10783 6.41451 9.30773 6.64883C9.40619 6.76424 9.52614 6.87279 9.6987 6.98718C10.6012 5.26797 10.9217 4.04476 11.259 1.88432C11.2996 1.6242 11.4736 1.40442 11.7175 1.30525C11.9614 1.20608 12.2394 1.24205 12.45 1.40001ZM8.29289 18.7071C7.90237 18.3166 7.90237 17.6834 8.29289 17.2929L14.2929 11.2929C14.6834 10.9024 15.3166 10.9024 15.7071 11.2929C16.0976 11.6834 16.0976 12.3166 15.7071 12.7071L9.70711 18.7071C9.31658 19.0976 8.68342 19.0976 8.29289 18.7071ZM9.01076 11H9C8.44772 11 8 11.4477 8 12C8 12.5523 8.44772 13 9 13H9.01076C9.56304 13 10.0108 12.5523 10.0108 12C10.0108 11.4477 9.56304 11 9.01076 11ZM14.9892 17C14.437 17 13.9892 17.4477 13.9892 18C13.9892 18.5523 14.437 19 14.9892 19H15C15.5523 19 16 18.5523 16 18C16 17.4477 15.5523 17 15 17H14.9892Z" fill="#EB163C"/>
							</svg>
						</div>
						<p>Осталось <span><?php echo $days_left; ?></span> <?php echo $days_word; ?></p>
					</div>
				<?php 
						}
				endif; 
			?>
			<div class="big-btns">
				<?php
					if ($product->is_in_stock()) {
						//awooc_html_custom_add_to_cart();
						echo '
							<button type="button" data-value-product-id="' . $product->get_id() . '" class="order-btn button"><span>Купить в 1 клик</span></button>
						';
					} else {
						echo '<div class="button button-blue pre-order" data-id="' . $product->get_id() . '">Сообщить о поступлении</div>';
					}
				?>
				<?php if (!get_field('credit_off') && $product->is_in_stock()) : ?>
					<div class="credit-btn button button-blue">
						<div class="btn-wrap">
							<p>Купить в рассрочку</p>
							<span>от 10 000 ₽ / мес </span>
						</div>
					</div>
					<div class="hidden-price" style="display: none">
						<?php
							$regular_price = $product->get_regular_price();
							$sale_price = $product->get_sale_price();
							if ( $product->is_on_sale() && !empty($sale_price) ) {
									$current_price = $sale_price;
							} else {
									$current_price = $regular_price;
							}
							
							echo $current_price;
						?>
					</div>
				<?php endif; ?>
			</div>
			<?php if ($product->is_in_stock()) : ?>
			<div class="delivery">
				<div class="icon">
					<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
						<path d="M17.5 21C18.6046 21 19.5 20.1046 19.5 19C19.5 17.8954 18.6046 17 17.5 17C16.3954 17 15.5 17.8954 15.5 19C15.5 20.1046 16.3954 21 17.5 21Z" stroke="#24B642" stroke-width="1.5"/>
						<path d="M7.5 21C8.60457 21 9.5 20.1046 9.5 19C9.5 17.8954 8.60457 17 7.5 17C6.39543 17 5.5 17.8954 5.5 19C5.5 20.1046 6.39543 21 7.5 21Z" stroke="#24B642" stroke-width="1.5"/>
						<path d="M2.5 9V13.947C2.5 16.329 2.5 17.52 3.23223 18.26C3.7191 18.7521 4.40328 18.9169 5.5 18.9722M12.9271 5C13.8404 5.2999 14.5564 6.02354 14.8532 6.94654C15 7.40322 15 7.96753 15 9.09613C15 9.84853 15 10.2248 15.0979 10.5292C15.2957 11.1445 15.7731 11.627 16.382 11.8269C16.6832 11.9258 17.0555 11.9258 17.8 11.9258H22.5V13.947C22.5 16.329 22.5 17.52 21.7678 18.26C21.2809 18.7521 20.5967 18.9169 19.5 18.9722M9.5 19H15.5" stroke="#24B642" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						<path d="M15 7H16.8212C18.2766 7 19.0042 7 19.5964 7.35371C20.1886 7.70742 20.5336 8.34811 21.2236 9.6295L22.5 12" stroke="#24B642" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						<path d="M7.82653 8L9.31309 6.82583C10.1044 6.20083 10.5 5.88833 10.5 5.5M10.5 5.5C10.5 5.11168 10.1044 4.79918 9.31309 4.17418L7.82653 3M10.5 5.5H2.5" stroke="#24B642" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</div>
				<p>Доставка <a href="<?php the_permalink(4496); ?>" target="blank">от 2 дней</a></p>
			</div>
			<?php endif; ?>
			<div class="consult callback">
				<div class="icon">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
						<path opacity="0.4" d="M18.8346 8.75664C19.232 8.7245 19.6343 8.80935 19.9833 9.00526C20.2342 9.14608 20.4215 9.33505 20.5569 9.49009C20.6316 9.57569 20.7327 9.70386 20.8062 9.7971C21.2622 10.351 21.7284 10.9205 22.0021 11.3091C22.2848 11.7104 22.4989 12.0927 22.6173 12.5259C22.7919 13.1652 22.7919 13.8348 22.6173 14.4741C22.4542 15.0711 22.1259 15.5849 21.7982 16.0137C21.5998 16.2733 21.3593 16.552 21.1475 16.7975C21.0316 16.9318 20.8665 17.1265 20.7794 17.2323C20.5383 17.5265 20.3003 17.8168 19.9833 17.9947C19.6343 18.1906 19.232 18.2755 18.8346 18.2434C18.4769 18.2144 17.9862 17.9904 17.6232 17.8243C17.2671 17.6652 16.5955 17.3652 16.3398 16.6081C16.2467 16.3327 16.2475 16.0384 16.2481 15.7645V11.2355C16.2475 10.9616 16.2467 10.6672 16.3398 10.3919C16.5955 9.63482 17.2671 9.33478 17.6232 9.17566C17.9862 9.00958 18.4769 8.78557 18.8346 8.75664Z" fill="#24B642"/>
						<path opacity="0.4" d="M5.16167 8.75664C4.76431 8.7245 4.36201 8.80935 4.01296 9.00526C3.76207 9.14608 3.57478 9.33505 3.43944 9.49009C3.36471 9.57569 3.26364 9.70386 3.19012 9.7971C2.73411 10.351 2.26789 10.9205 1.99416 11.3091C1.7115 11.7104 1.49738 12.0927 1.37903 12.5259C1.20439 13.1652 1.20439 13.8348 1.37903 14.4741C1.54212 15.0711 1.87045 15.5849 2.19811 16.0137C2.39646 16.2733 2.63698 16.552 2.84886 16.7975C2.96475 16.9318 3.12976 17.1265 3.21693 17.2323C3.45798 17.5265 3.69597 17.8168 4.01296 17.9947C4.36201 18.1906 4.76431 18.2755 5.16167 18.2434C5.51938 18.2144 6.01016 17.9904 6.37306 17.8243C6.72922 17.6652 7.40077 17.3652 7.65655 16.6081C7.74957 16.3327 7.74884 16.0384 7.74817 15.7645V11.2355C7.74884 10.9616 7.74957 10.6672 7.65655 10.3919C7.40077 9.63482 6.72922 9.33478 6.37306 9.17566C6.01015 9.00958 5.51938 8.78557 5.16167 8.75664Z" fill="#24B642"/>
						<path d="M17.998 17.9931V18.3018C17.998 19.3201 16.8746 20.5018 14.998 20.5018H12.998C12.4457 20.5018 11.998 20.9495 11.998 21.5018C11.998 22.054 12.4457 22.5018 12.998 22.5018H14.998C17.5397 22.5018 19.998 20.8181 19.998 18.3018V17.9883C19.9932 17.991 19.9884 17.9938 19.9836 17.9965C19.6345 18.1924 19.2322 18.2773 18.8349 18.2451C18.5903 18.2253 18.2836 18.1144 17.998 17.9931Z" fill="#24B642"/>
						<path d="M6.0265 9.02053C6.31295 6.59481 8.74688 4.5 11.9982 4.5C15.2496 4.5 17.6836 6.59492 17.9699 9.02072C18.2634 8.89481 18.5824 8.77707 18.835 8.75664C19.2305 8.72465 19.6309 8.80855 19.9788 9.0025C19.6848 5.24945 16.0876 2.5 11.9982 2.5C7.90869 2.5 4.31143 5.24958 4.01758 9.00277C4.3656 8.80863 4.76616 8.72464 5.16184 8.75664C5.41435 8.77706 5.73316 8.89469 6.0265 9.02053Z" fill="#24B642"/>
					</svg>
				</div>
				<div class="meta">
					<b>Получить консультацию</b>
					<p>Ежедневно с 8:00 до 20:00</p>
				</div>
			</div>


			<?php
			/**
			 * Hook: woocommerce_single_product_summary.
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_rating - 10
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 * @hooked WC_Structured_Data::generate_product_data() - 60
			 */
			do_action( 'woocommerce_single_product_summary' );
			?>
		</div>
		<div class="mob-bottom">
			<?php custom_display_product_attributes_SINGLE(); ?>
		</div>
	</div>
</div>

<script>
	const compare = document.querySelector('.br_compare_button');
	if (compare) {
		if (window.screen.width > 578) {
			compare.classList.remove('add_to_cart_button');
			compare.classList.remove('button');
			const compareNewWrap = document.querySelector('.single-product-top .compare ');
			compareNewWrap.appendChild(compare.cloneNode(true));
			compare.remove();
		} else {
			compare.classList.remove('add_to_cart_button');
			compare.classList.remove('button');
			const compareNewWrap = document.querySelector('.single-product .mob-wrap .compare ');
			compareNewWrap.appendChild(compare.cloneNode(true));
			compare.remove();
		}
		
	}
</script>

<?php 
	$main_cat_id =  yoast_get_primary_term_id( 'product_cat', $product->id );
	$category = get_term_by('id', $main_cat_id, 'product_cat');
?>
<section class="single-product-bottom">
		<div class="single-tabs">
			<div class="item active">Описание</div>
			<div class="item">Характеристики</div>
			<?php if (get_field('installation_price_rows') || get_field('price_title', $category)) : ?>
			<div class="item">Монтаж</div>
			<?php endif; ?>
			<div class="item">Доставка</div>
			<div class="item">Оплата</div>
			<?php if (get_field('installation_file')) : ?>
			<div class="item">Документы</div>
			<?php endif; ?>
			<?php if (get_field('komplekt_postavki')) : ?>
			<div class="item">Комплект поставки</div>
			<?php endif; ?>
		</div>
		<div class="single-wrap active">
			<div class="description">
				<div class="description-left content">
					<h2 class="title">Описание товара</h2>
					<?php the_content(); ?>
				</div>
				<div class="description-right">
					<?php 
						$brandTerm = $product->get_attributes('brand');
						// Получаем ID изображения атрибута через ACF по названию атрибута 'brand'
						$brand_id = $brandTerm['pa_brand']['data']['options'][0];
						$brand_logo = get_field('brand_logo', 'pa_brand_'. $brand_id);
						$image = $brand_logo ? $brand_logo : get_template_directory_uri() . '/img/placeholder.png';
					?>
					<div class="image">
						<img src="<?php echo $image; ?>" alt="<?php echo $product->get_attribute('brand'); ?>"> 
					</div>
					<h3 class="mini-title"><?php echo $product->get_attribute('brand'); ?></h3>
					<div class="content">
						<p>
							<?php $args = [
								'taxonomy' => ['pa_brand' ], // название таксономии с WP 4.5
									];

								$terms = get_terms( $args );

								foreach( $terms as $term ){
									if ($term->name != $product->get_attribute('brand')) {
										continue;
									}
									echo $term->description;
								} 
							?>
						</p>
					</div>
					<a href="<?php echo get_term_link($brand_id); ?>" class="link">
						<span>Все товары бренда</span>
						<div class="icon">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
								<path d="M17 7L6 18" stroke="#24B642" stroke-width="1.5" stroke-linecap="round"/>
								<path d="M11 6H17C17.4714 6 17.7071 6 17.8536 6.14645C18 6.29289 18 6.5286 18 7V13" stroke="#24B642" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						</div>
					</a>
				</div>
			</div>
		</div>
		<div class="single-wrap">
			<h2 class="title">Характеристики товара</h2>
			<?php 
				global $product;

				if ( $product ) {
						$attributes = $product->get_attributes();
				
						if ( ! empty( $attributes ) ) {
								echo '<div class="attrs">';
				
								foreach ( $attributes as $attribute ) {
										$attribute_name = wc_attribute_label( $attribute->get_name() );
										$term = get_term_by('id', (int)$attribute->get_options()[0], $attribute->get_name());
            				$attribute_value = $term->name;
				
										if ( $attribute_value ) {
												echo '<div class="item">';
												echo '<p>' . $attribute_name . '</p>';
												echo '<div></div>';
												echo '<b>' . $attribute_value . '</b>';
												echo '</div>';
										}
								}
				
								echo '</div>';
						}
				}
			?>
		</div>
		<?php if (get_field('installation_price_rows')) : ?>
		<div class="single-wrap">
			<div class="price-rows">
				<h2 class="title">Монтаж</h2>
				<div class="price-row">
					<div class="row-wrap" style="display: block">
						<?php if (have_rows('installation_price_rows')) : while(have_rows('installation_price_rows' )) : the_row(); ?>
							<div class="item">
								<p><?php echo get_sub_field('name'); ?></p>
								<b><span>от</span> <?php echo get_sub_field('price'); ?> руб.</b>
							</div>
						<?php endwhile; endif; ?>
					</div>
				</div>
			</div>
		</div>
		<?php elseif (get_field('price_title', $category)) : ?>
		<div class="single-wrap ">
			<div class="price-rows">
				<h2 class="title"><?php echo get_field('price_title', $category); ?></h2>
				<div class="price-row">
					<div class="row-wrap" style="display: block">
						<?php if (have_rows('price_sec_link', $category)) : while(have_rows('price_sec_link', $category)) : the_row(); ?>
							<div class="item">
								<p><?php echo get_sub_field('name'); ?></p>
								<b><span>от</span> <?php echo get_sub_field('value'); ?></b>
							</div>
						<?php endwhile; endif; ?>
					</div>
				</div>
			</div>
		</div>
		<?php endif; ?>
		<?php 
			global $post;
			$post = get_post(4496);
		?>
		<div class="single-wrap">
			<h2 class="title">Доставка</h2>
			<div class="content page-content">
				<?php echo apply_filters( 'the_content', $post->post_content ); ?>
			</div>
		</div>
		<?php 
			global $post;

			$post = get_post(4494);
		?>
		<div class="single-wrap">
			<div class="pay-offer">
				<div class="wrap">
					<b class="title title-sub">Оплата</b>
					<p class="subtitle" style="max-width: 100%"><?php echo get_field('subtitle', 4494); ?></p>
					<div class="row">
						<?php if (have_rows('terms', 4494)) : while(have_rows('terms', 4494)) : the_row(); ?>
							<div class="item">
								<img src="<?php echo get_sub_field('icon'); ?>" alt="<?php echo get_sub_field('name'); ?>">
								<b><?php echo get_sub_field('name'); ?></b>
								<p><?php echo get_sub_field('text'); ?></p>
							</div>
						<?php endwhile; endif; ?>
					</div>
				</div>
			</div>
			<div class="content page-content">
				<?php echo apply_filters( 'the_content', $post->post_content ); ?>
			</div>
		</div>
		<?php wp_reset_postdata(); if (get_field('installation_file')) : ?>
		<div class="single-wrap ">
			<h2 class="title">Документы</h2>
			<div class="doc-row">
				<?php if (have_rows('installation_file')) : while(have_rows('installation_file')) : the_row(); ?>
					<a href="<?php echo get_sub_field('fajl'); ?>" download target="blank" class="item">
						<b><?php echo get_sub_field('imya'); ?></b>
						<div class="icon">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
								<path fill-rule="evenodd" clip-rule="evenodd" d="M8.25 17C8.25 16.5858 8.58579 16.25 9 16.25L15 16.25C15.4142 16.25 15.75 16.5858 15.75 17C15.75 17.4142 15.4142 17.75 15 17.75L9 17.75C8.58579 17.75 8.25 17.4142 8.25 17Z" fill="#1BB03A"/>
								<path fill-rule="evenodd" clip-rule="evenodd" d="M11.4697 13.5303C11.7626 13.8232 12.2374 13.8232 12.5303 13.5303L16.0303 10.0303C16.3232 9.73744 16.3232 9.26256 16.0303 8.96967C15.7374 8.67678 15.2626 8.67678 14.9697 8.96967L12.75 11.1893V6C12.75 5.58579 12.4142 5.25 12 5.25C11.5858 5.25 11.25 5.58579 11.25 6V11.1893L9.03033 8.96967C8.73744 8.67678 8.26256 8.67678 7.96967 8.96967C7.67678 9.26256 7.67678 9.73744 7.96967 10.0303L11.4697 13.5303Z" fill="#1BB03A"/>
								<path fill-rule="evenodd" clip-rule="evenodd" d="M12 2.75C6.89137 2.75 2.75 6.89137 2.75 12C2.75 17.1086 6.89137 21.25 12 21.25C17.1086 21.25 21.25 17.1086 21.25 12C21.25 6.89137 17.1086 2.75 12 2.75ZM1.25 12C1.25 6.06294 6.06294 1.25 12 1.25C17.9371 1.25 22.75 6.06294 22.75 12C22.75 17.9371 17.9371 22.75 12 22.75C6.06294 22.75 1.25 17.9371 1.25 12Z" fill="#1BB03A"/>
							</svg>
							<span>Скачать</span>
						</div>
					</a>
				<?php endwhile; endif; ?>
			</div>
		</div>
		<?php endif; ?>
		<?php if (get_field('komplekt_postavki')) : ?>
		<div class="single-wrap ">
			<h2 class="title title-sub">Комплект поставки</h2>
			<p class="subtitle">В комплект поставки Изделия входят следующие комплектующие:</p>
			<div class="complect-wrap">
				<div class="item head">
					<p>Название</p>
					<span>Кол-во</span>
				</div>
				<?php if (have_rows('komplekt_postavki')) : while(have_rows('komplekt_postavki')) : the_row(); ?>
					<div class="item">
						<p><?php echo get_sub_field('name'); ?></p>
						<span><?php echo get_sub_field('value'); ?></span>
					</div>
				<?php endwhile; endif; ?>
			</div>
		</div>
		<?php endif; ?>

</section>


<?php if (get_field('installation_gallery')) : ?>
<section class="single-prod-cases">
		<h2 class="title">Примеры установки</h2>
		<div class="wrap slider-wrap">
			<div class="arr arr-prev">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
					<path d="M15 18L9.7071 12.7071C9.3738 12.3738 9.2071 12.2071 9.2071 12C9.2071 11.7929 9.3738 11.6262 9.7071 11.2929L15 6" stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</div>
			<div class="swiper">
				<div class="swiper-wrapper magnific">
					<?php $gallery = get_field('installation_gallery'); if ($gallery) : ?>
					<?php foreach( $gallery as $img ): ?>
						<a href="<?php echo esc_url($img['url']); ?>" class="swiper-slide item">
							<?php if ($img['alt']) {
								echo '<img src="' . esc_url($img['sizes']['large']) . '" alt="' . esc_attr($img['alt']) . '">';
							} else {
								echo '<img src="' . esc_url($img['sizes']['large']) . '" alt="Монтаж <?php the_title(); ?>">';
							} ?>
						</a>
					<?php endforeach; endif; ?>
				</div>
			</div>
			<div class="arr arr-next">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
					<path d="M9 18L14.2929 12.7071C14.6262 12.3738 14.7929 12.2071 14.7929 12C14.7929 11.7929 14.6262 11.6262 14.2929 11.2929L9 6" stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</div>
			<div class="swiper-pagination dots"></div>
		</div>
</section>
<?php endif; ?>

<div class="hidden-li" style="display: none">
	<?php
		// Получаем ID продукта
		$product_idLI = $product->id; // Замените 123 на нужный вам ID продукта
		echo $product_idLI;
		// Создаем объект продукта
		$productLI = wc_get_product($product_idLI);

		// Проверяем, что продукт существует
		if ($productLI) {
				// Запускаем цикл для установки контекста

				// Выводим содержимое продукта, используя шаблон content-product.php
				wc_get_template_part('content', 'product');
				
				// Сбрасываем контекст
		}
	?>
</div>
<?php do_action( 'woocommerce_after_single_product' ); ?>
