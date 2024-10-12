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
<?php
// Проверяем, находится ли пользователь на странице товара WooCommerce
if (is_singular('product')) {
    // Для страниц товаров выводим крошки с "Главная", категорией и подкатегорией (если есть)
    if (function_exists('yoast_breadcrumb')) {
        // Получаем хлебные крошки от Yoast
        ob_start();
        yoast_breadcrumb('<p class="breadcrumbs">', '</p>');
        $breadcrumb = ob_get_clean();

        // Получаем основную категорию товара
        $product_id = get_the_ID();
        $categories = wp_get_post_terms($product_id, 'product_cat');

        // Найти основную категорию (первая категория в списке)
        $main_category = !empty($categories) ? $categories[0] : null;

        // Получаем подкатегорию, если она есть (вторая категория в списке)
        $sub_category = !empty($categories[1]) ? $categories[1] : null;

        // Создаем ссылки на основную категорию и подкатегорию, если они есть
        $main_category_link = $main_category ? get_term_link($main_category) : '';
        $sub_category_link = $sub_category ? get_term_link($sub_category) : '';

        // Удаляем возможные дублирующие ссылки на "Главная" из хлебных крошек
        $breadcrumb = preg_replace('/<a href="'.esc_url(home_url('/')).'">Главная<\/a>\s*\/?\s*/i', '', $breadcrumb);

        // Получаем название товара
        $product_name = get_the_title();

        // Формируем новые хлебные крошки
        $new_breadcrumbs = '<p class="breadcrumbs">'
            . '<a href="' . esc_url(home_url('/')) . '">Главная</a> / '
            . ($main_category_link ? '<a href="' . esc_url($main_category_link) . '">' . esc_html($main_category->name) . '</a> / ' : '')
            . ($sub_category_link ? '<a href="' . esc_url($sub_category_link) . '">' . esc_html($sub_category->name) . '</a> / ' : '')
            . esc_html($product_name)
            . '</p>';

        // Выводим модифицированные хлебные крошки
        echo $new_breadcrumbs;
    }
} else {
    // Для всех остальных страниц выводим стандартные крошки
    if (function_exists('yoast_breadcrumb')) {
        yoast_breadcrumb('<p class="breadcrumbs">', '</p>');
    }
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'single-product', $product ); ?>>
	<div class="back-btn"  onclick="history.back()">
		<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
			<path d="M5 12L20 11.9998" stroke="#141B34" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
			<path d="M8.99992 6.99988L4.70703 11.2928C4.37369 11.6261 4.20703 11.7928 4.20703 11.9999C4.20703 12.207 4.37369 12.3737 4.70703 12.707L8.99992 16.9999" stroke="#141B34" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
		</svg>
	</div>
	<div class="single-product-left">
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

	<div class="summary entry-summary single-product-right">
		<div class="sku">
			Артикул: <?php echo $product->get_sku(); ?>
		</div>
		<h1 class="title"><?php the_title(); ?></h1>
		<div class="rating-row">
			<?php if (comments_open()) { ?>
			<div class="star-rating">
				<?php 
					// Функция для склонения слова "отзыв"
					function get_review_word($count) {
						$cases = [2, 0, 1, 1, 1, 2];
						return $count . ' ' . ['отзыв', 'отзыва', 'отзывов'][($count % 100 > 4 && $count % 100 < 20) ? 2 : $cases[min($count % 10, 5)]];
					}
					// Получаем средний рейтинг
					$average = $product->get_average_rating();
					$rating_count = $product->get_rating_count();
					// Если рейтинг отсутствует, задаем значение по умолчанию (например, 0)
					if (empty($average)) {
							$average = 0;
					}

					// Выводим рейтинг
					echo wc_get_star_rating_html($average);
				?>
				
			</div>
			<span class="rating-count"><?php echo get_review_word($rating_count); ?></span>
			<?php } ?>
			<div class="aviable">
				<?php if ($product->is_in_stock()) : ?>
					<div class="aviable-true" <?php if (!comments_open()) { echo 'style="margin-left: 0"'; } ?>>
						В наличии
					</div>
				<?php else : ?>
					<div class="aviable-false" <?php if (!comments_open()) { echo 'style="margin-left: 0"'; } ?>>
						Нет в наличии
					</div>
				<?php endif; ?>
			</div>
		</div>
		<?php
			// Список slug атрибутов, которые нужно отобразить
			$attributes_to_display = [
					'pa_model', 
					'pa_tip-himii',
					'pa_napryazhenie', 
					'pa_emkost-ah', 
					'pa_material-korpusa', 
					'pa_zashhita-ot-perezaryada', 
					//'pa_sfery-primeneniya'
			];

			global $product;
			$attributes = $product->get_attributes();

			// Отфильтровываем и сортируем атрибуты по заданному порядку
			$sorted_attributes = [];
			foreach ( $attributes_to_display as $slug ) {
					if ( isset( $attributes[$slug] ) ) {
							$sorted_attributes[$slug] = $attributes[$slug];
					}
			}

			if ( ! empty( $sorted_attributes ) ) {
					echo '<div class="attrs">';
					echo '<b class="mini-title">Основные характеристики</b>';
					echo '<ul>';

					foreach ( $sorted_attributes as $attribute ) {
							$name = wc_attribute_label( $attribute->get_name() );

							// Получаем термы для атрибута
							$terms = wc_get_product_terms( $product->get_id(), $attribute->get_name(), array( 'fields' => 'names' ) );
							$value = implode( ', ', $terms );

							echo '<li>';
							echo '<p>' . esc_html( $name ) . '</p>';
							echo '<div class="line"></div>';
							echo '<b>' . esc_html( $value ) . '</b>';
							echo '</li>';
					}

					echo '</ul>';
					echo '</div>';
			}
		?>
		<?php if ((float)$product->get_price() != 1) : ?>
    <div class="single-price">
        <?php woocommerce_template_single_price(); ?>
        <div class="nds">Стоимость с НДС</div>
    </div>
		<?php endif; ?>
		<div class="single-btns">
			<?php woocommerce_template_single_add_to_cart(); ?>
			<div class="button button-white callback">
				Консультация
			</div>
		</div>
		<?php if (get_field('delivery') || get_field('garanty')) : ?>
		<div class="single-fields">
			<?php if (get_field('delivery')) : ?>
			<div class="item">
				<div class="icon">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
						<path d="M21 7V12M3 7C3 10.0645 3 16.7742 3 17.1613C3 18.5438 4.94564 19.3657 8.83693 21.0095C10.4002 21.6698 11.1818 22 12 22V11.3548" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						<path d="M15 19C15 19 15.875 19 16.75 21C16.75 21 19.5294 16 22 15" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						<path d="M8.32592 9.69138L5.40472 8.27785C3.80157 7.5021 3 7.11423 3 6.5C3 5.88577 3.80157 5.4979 5.40472 4.72215L8.32592 3.30862C10.1288 2.43621 11.0303 2 12 2C12.9697 2 13.8712 2.4362 15.6741 3.30862L18.5953 4.72215C20.1984 5.4979 21 5.88577 21 6.5C21 7.11423 20.1984 7.5021 18.5953 8.27785L15.6741 9.69138C13.8712 10.5638 12.9697 11 12 11C11.0303 11 10.1288 10.5638 8.32592 9.69138Z" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						<path d="M6 12L8 13" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						<path d="M17 4L7 9" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</div>
				<div class="meta">
					<p>Срок отгрузки</p>
					<b><?php echo get_field('delivery'); ?></b>
				</div>
			</div>
			<?php endif; ?>
			<?php if (get_field('garanty')) : ?>
			<div class="item">
				<div class="icon">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
						<path d="M11.9982 2C8.99043 2 7.04018 4.01899 4.73371 4.7549C3.79589 5.05413 3.32697 5.20374 3.1372 5.41465C2.94743 5.62556 2.89186 5.93375 2.78072 6.55013C1.59143 13.146 4.1909 19.244 10.3903 21.6175C11.0564 21.8725 11.3894 22 12.0015 22C12.6135 22 12.9466 21.8725 13.6126 21.6175C19.8116 19.2439 22.4086 13.146 21.219 6.55013C21.1078 5.93364 21.0522 5.6254 20.8624 5.41449C20.6726 5.20358 20.2037 5.05405 19.2659 4.75499C16.9585 4.01915 15.0061 2 11.9982 2Z" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						<path d="M9 13C9 13 10 13 11 15C11 15 14.1765 10 17 9" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</div>
				<div class="meta">
					<p>Гарантия</p>
					<b><?php echo get_field('garanty'); ?></b>
				</div>
			</div>
			<?php endif; ?>
		</div>
		<?php endif; ?>
		<?php
			/**
			 * Hook: woocommerce_single_product_summary.
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_rating - 1030
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
	<?php
		/**
		 * Hook: woocommerce_after_single_product_summary.
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_upsell_display - 15
		 * @hooked woocommerce_output_related_products - 20
		 */
		do_action( 'woocommerce_after_single_product_summary' );
	?>
	<section class="product-tabs">
			<h2 class="title"><?php echo get_field('title') ?></h2>
			<div class="tabs">
				<?php if (get_the_content()) : ?>
				<div class="item active">
					Описание
				</div>
				<div class="item">
					Характеристики
				</div>
				<?php else : ?>
				<div class="item active">
					Характеристики
				</div>
				<?php endif; ?>
				
				<?php if (comments_open()) { ?>
				<div class="item ">
					Отзывы
				</div>
				<?php } ?>

				<?php if (get_field('how_buy_title', 'options')) : ?>
				<div class="item ">
					Как купить
				</div>
				<?php endif; ?>
				<div class="item">
					Доставка
				</div>
			</div>
			<?php if (get_the_content()) : ?>
			<div class="wrapper active wrapper-content content">
				<?php if (get_field('content_title')) : ?>
					<h2 class="title sub"><?php echo get_field('content_title'); ?></h2>
				<?php endif; ?>
				<div class="left">
					<div class="content">
						<?php the_content(); ?>
					</div>
				</div>
				<?php if (get_field('feat')) : ?>
				<ul class="right">
					<?php if (have_rows('feat')) : while(have_rows('feat')) : the_row(); ?>
						<li>
							<?php echo get_sub_field('name'); ?>
						</li>
					<?php endwhile; endif; ?>
				</ul>
				<?php endif; ?>
			</div>
			<div class="wrapper wrapper-attrs">
			<?php else : ?>
			<div class="wrapper wrapper-attrs active">
			<?php endif; ?>
			
				<h2 class="title sub">
					Характеристики
				</h2>
				<?php 
					global $product;

					if ( $product ) {
							$attributes = $product->get_attributes();

							if ( ! empty( $attributes ) ) {
									echo '<div class="attrs">';

									foreach ( $attributes as $attribute ) {
											$attribute_name = wc_attribute_label( $attribute->get_name() );
											$term = get_term_by('id', (int)$attribute->get_options()[0], $attribute->get_name());

											// Проверяем, что в имени атрибута НЕТ "(переклиновка)"
											if ( $term && strpos($attribute_name, '(переклиновка)') === false ) {
													$attribute_value = $term->name;

													if ( $attribute_value ) {
															echo '<div class="item">';
															echo '<p>' . $attribute_name . '</p>';
															echo '<b>' . $attribute_value . '</b>';
															echo '</div>';
													}
											}
									}

									echo '</div>';
							}
					}
				?>
			</div>
			<?php comments_template('/woocommerce/single-product-reviews.php'); ?>
			<?php if (get_field('how_buy_title', 'options')) : ?>
			<div class="wrapper wrapper-buy ">
				<h2 class="title"><?php echo get_field('how_buy_title', 'options'); ?></h2>
				<div class="buy-wrap">
					<?php $i = 1; if (have_rows('how_buy', 'options')) : while(have_rows('how_buy', 'options')) : the_row(); ?>
						<div class="buy-item">
							<div class="num"><?php echo $i; ?></div>
							<p>
								<?php echo get_sub_field('content'); ?>
							</p>
						</div>
					<?php $i++; endwhile; endif; ?>
				</div>
				<?php if (get_field('how_buy_form_toggle', 'options') == false) : ?>
				<div class="order">
					<div class="row">
						<div class="left">
							<h2 class="title sub"><?php echo get_field('order_title', 'options') ?></h2>
							<p class="subtitle"><?php echo get_field('order_title', 'options') ?></p>
						</div>
						<div class="right">
							<div class="icon">
								<svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36" fill="none">
									<path d="M12.5634 4.5C12.2426 4.6199 11.927 4.75068 11.6172 4.89189M31.0764 24.4516C31.2297 24.1198 31.371 23.7813 31.4998 23.4368M27.748 29.0471C28.0056 28.8066 28.2546 28.5571 28.4943 28.299M22.9032 32.0584C23.1943 31.9486 23.481 31.83 23.763 31.7026M18.2338 32.9909C17.8875 33.0029 17.5387 33.0029 17.1922 32.9909M11.6808 31.7106C11.952 31.8325 12.2276 31.9467 12.5072 32.0524M7.00866 28.3812C7.2137 28.5985 7.42527 28.8096 7.64308 29.0142M3.94888 23.4968C4.0612 23.7933 4.18284 24.0854 4.31341 24.3725M3.00729 18.7579C2.99756 18.4458 2.99759 18.1317 3.00729 17.8191M3.93801 13.1057C4.04835 12.8125 4.16779 12.5237 4.29598 12.2397M6.98387 8.21884C7.20086 7.98771 7.42521 7.76359 7.65658 7.54686" stroke="#2CB4C2" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round"/>
									<path d="M20.25 18C20.25 19.2426 19.2426 20.25 18 20.25C16.7574 20.25 15.75 19.2426 15.75 18C15.75 16.7574 16.7574 15.75 18 15.75M20.25 18C20.25 16.7574 19.2426 15.75 18 15.75M20.25 18H24M18 15.75V9" stroke="#2CB4C2" stroke-width="2.25" stroke-linecap="round"/>
									<path d="M33 18.0005C33 9.71621 26.2842 3.00049 18 3.00049" stroke="#2CB4C2" stroke-width="2.25" stroke-linecap="round"/>
								</svg>
							</div>
							<div class="meta">
								<b><?php echo get_field('order_time', 'options'); ?></b>
								<p>Минимальный срок изготовления</p>
							</div>
						</div>
					</div>
					<div class="wrap">
						<div class="swiper">
							<div class="swiper-wrapper">
								<?php if (have_rows('order_feat','options')) : while(have_rows('order_feat','options')) : the_row(); ?>
								<div class="item swiper-slide">
									<div class="icon">
										<img src="<?php echo get_sub_field('img'); ?>" alt="<?php echo get_sub_field('title'); ?>">
									</div>
									<b><?php echo get_sub_field('title'); ?></b>
								</div>
								<?php endwhile; endif; ?>
							</div>
						</div>
						<div class="swiper-pagination dots"></div>
					</div>
				</div>
				<?php endif; ?>

				<?php if (get_field('how_buy_form_toggle','options') == false) : ?>
				<div class="tech-banner">
					<div class="wrap">
						<div class="left">
							<b class="title sub"><?php echo get_field('tech_title','options') ?></b>
							<p class="subtitle"><?php echo get_field('tech_subtitle', 'options'); ?></p>
							<div class="form form-white">
								<?php echo do_shortcode('[contact-form-7 id="b534b37" title="Баннер изготовления по вашему ТЗ"]'); ?>
							</div>
						</div>
						<div class="right">
							<img src="<?php echo get_field('tech_bg','options'); ?>" alt="<?php echo get_field('tech_title','options') ?>">
						</div>
					</div>
				</div>
				<?php endif; ?>

			</div>
			<?php endif; ?>
			<div class="wrapper wrapper-delivery ">
				<div class="delivery">
					<h2 class="title sub"><?php echo get_the_title(535); ?></h2>
					<p class="subtitle"><?php echo get_field('subtitle', 535); ?></p>
				</div>

				<?php if (get_field('part_title', 535)) : ?>
				<div class="delivery-part">
					<h3 class="title sub"><?php echo get_field('part_title', 535) ?></h3>
					<p class="subtitle"><?php echo get_field('part_subtitle', 535); ?></p>
					<div class="wrap">
						<?php $gallery = get_field('part', 535); if ($gallery) : ?>
						<?php foreach( $gallery as $img ): ?>
							<div class="item">
								<?php if ($img['alt']) {
									echo '<img src="' . esc_url($img['url']) . '" alt="' . esc_attr($img['alt']) . '">';
								} else {
									echo '<img src="' . esc_url($img['url']) . '" alt="' . get_field('part_title') . '">';
								} ?>
							</div>
						<?php endforeach; endif; ?>
					</div>
				</div>
				<?php endif; ?>

				<?php if (get_field('del_title', 535)) : ?>
				<div class="delivery-map">
					<div class="wrap">
						<div class="left">
							<h3 class="title sub"><?php echo get_field('del_title', 535) ?></h3>
							<div class="content">
								<?php echo get_field('del_content', 535); ?>
							</div>
							<address>
								<div class="top">
									<div class="icon">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
											<path fill-rule="evenodd" clip-rule="evenodd" d="M12.0015 1.25C8.17538 1.25 4.52505 3.51303 2.99714 7.08468C1.57518 10.4086 2.34496 13.2373 3.94771 15.6595C5.26177 17.6454 7.17835 19.4178 8.90742 21.0168L8.90824 21.0175C9.23768 21.3222 9.56031 21.6206 9.87066 21.9129L9.87231 21.9145C10.4473 22.4528 11.2112 22.75 12.0015 22.75C12.7919 22.75 13.5558 22.4528 14.1308 21.9144C14.4243 21.6396 14.7286 21.3592 15.039 21.0732C16.7869 19.4627 18.7304 17.672 20.0582 15.6609C21.6591 13.2362 22.4261 10.4045 21.0059 7.08468C19.478 3.51303 15.8277 1.25 12.0015 1.25ZM12 7C9.79086 7 8 8.79086 8 11C8 13.2091 9.79086 15 12 15C14.2091 15 16 13.2091 16 11C16 8.79086 14.2091 7 12 7Z" fill="#2CB4C2"/>
										</svg>
									</div>
									<span>Адрес для самовывоза</span>
								</div>
								<p><?php echo get_field('adres_samovyvoza', 535); ?></p>
							</address>
						</div>
						<div class="right">
							<div id="map"></div>
						</div>
					</div>
				</div>
				<?php endif; ?>
			</div>
	</section>

	<?php if (get_field('sfery_on') == true) : ?>
	<section class="product-links">
		<?php if (get_field('toggle_sfery') == true) : ?>
			<div class="scroll-wrapper">
				<div class="wrap">
					<?php if (have_rows('sfery_hand')) : while(have_rows('sfery_hand')) : the_row(); ?>
						<a href="<?php echo get_sub_field('ssylka'); ?>" class="item">
							<?php if (get_sub_field('ikonka')) : ?>
							<div class="icon">
								<img src="<?php echo get_sub_field('ikonka'); ?>" alt="<?php echo get_sub_field('imya'); ?>">
							</div>
							<?php endif; ?>
							<p><?php echo get_sub_field('imya'); ?></p>
						</a>
					<?php endwhile; endif; ?>
				</div>
			</div>
		<?php else : ?>
		<div class="scroll-wrapper">
			<div class="wrap">
				<?php 
					$taxonomy_ids = get_field('sfery'); // Получаем массив ID таксономий

					if ($taxonomy_ids) {
							foreach ($taxonomy_ids as $taxonomy_id) {
									// Получаем данные поля ACF для таксономии
									$icon = get_field('attr_img', 'term_' . $taxonomy_id);
									$title = get_field('attr_title', 'term_' . $taxonomy_id);
									$link = get_term_link($taxonomy_id);

									// Если заголовок таксономии пустой, используем название таксономии
									if (empty($title)) {
											$taxonomy = get_term($taxonomy_id);
											$title = $taxonomy->name;
									}

									// Проверяем, существует ли заголовок, и выводим элемент
									if ($title) {
											?>
											<a href="<?php echo esc_url($link); ?>" class="item">
													<?php if ($icon) : ?>
															<div class="icon">
																	<img src="<?php echo esc_url($icon); ?>" alt="<?php echo esc_attr($title); ?>">
															</div>
													<?php endif; ?>
													<p><?php echo esc_html($title); ?></p>
											</a>
											<?php
									}
							}
					}
				?>
			</div>
		</div>
		<?php endif; ?>
	</section>
	<?php endif; ?>

	<?php
	// Получаем категории товара
	$product_categories = get_the_terms(get_the_ID(), 'product_cat');

	if ($product_categories && !is_wp_error($product_categories)) : ?>
		<section class="product-cats">
				<div class="wrap">
						<?php foreach ($product_categories as $category) :
								// Получаем изображение категории
								$thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
								$image = wp_get_attachment_url($thumbnail_id);
								$link = get_term_link($category);
								$title = $category->name;
						?>
							<a href="<?php echo esc_url($link); ?>" class="item">
								<?php if ($image) : ?>
								<div class="icon">
										<img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($title); ?>">
								</div>
								<?php endif; ?>
								<p><?php echo esc_html($title); ?></p>
								<div class="svg">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
										<path d="M17 7.50012L6 18.5001" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round"/>
										<path d="M11 6.5H17C17.4714 6.5 17.7071 6.5 17.8536 6.64645C18 6.79289 18 7.0286 18 7.5V13.5" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
								</div>
							</a>
						<?php endforeach; ?>
				</div>
		</section>
	<?php endif; ?>

	<?php woocommerce_output_related_products(); ?>

	<?php if (get_field('cat_row_title','options')) : ?>
	<section class="cat-row">
			<h2 class="title"><?php echo get_field('cat_row_title','options') ?></h2>
			<div class="our-row">
				<div class="swiper">
					<div class="swiper-wrapper our-row-wrap">
						<?php if (have_rows('cat_row', 'options')) : while(have_rows('cat_row', 'options')) : the_row(); ?>
							<a href="<?php echo get_sub_field('link'); ?>" class="item swiper-slide">
								<div class="icon">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
										<path d="M17 7L6 18" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round"/>
										<path d="M11 6H17C17.4714 6 17.7071 6 17.8536 6.14645C18 6.29289 18 6.5286 18 7V13" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
								</div>
								<b><?php echo get_sub_field('title'); ?></b>
								<img src="<?php echo get_sub_field('img'); ?>" alt="<?php echo get_sub_field('title'); ?>">
							</a>
						<?php endwhile; endif; ?>
					</div>
				</div>
				<div class="dots"></div>
			</div>
	</section>
	<?php endif; ?>

	<?php if (get_field('catalog_banner_title', 'options')) : ?>
	<section class="catalog-banner">
			<div class="wrap">
				<div class="left">
					<b class="title sub"><?php echo get_field('catalog_banner_title', 'options'); ?></b>
					<p class="subtitle"><?php echo get_field('catalog_banner_subtitle', 'options'); ?></p>
					<div class="form">
						<?php echo do_shortcode('[contact-form-7 id="7dc5478" title="Отправка каталога"]'); ?>
					</div>
				</div>
				<div class="right">
					<img src="<?php echo get_field('catalog_banner_bg', 'options'); ?>" alt="<?php echo get_field('catalog_banner_title', 'options'); ?>">
				</div>
			</div>
	</section>
	<?php endif; ?>

</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
