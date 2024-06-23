<?php
/**
 * Product taxonomy archive header
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/header.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<header class="woocommerce-products-header">
	<div class="back-btn"  onclick="history.back()">
		<div class="icon">
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
				<path d="M15 18L9.7071 12.7071C9.3738 12.3738 9.2071 12.2071 9.2071 12C9.2071 11.7929 9.3738 11.6262 9.7071 11.2929L15 6" stroke="#24B642" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
			</svg>
		</div>
		<span>Назад</span>
	</div>
	<?php
	/**
	 * Hook: woocommerce_show_page_title.
	 *
	 * Allow developers to remove the product taxonomy archive page title.
	 *
	 * @since 2.0.6.
	 */
	
	if ( apply_filters( 'woocommerce_show_page_title', true ) ) :
	// Получаем номер текущей страницы
		$current_page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
		$term = get_queried_object();
		$term_id = $term->term_id;
	// Выводим название страницы
		?>
		
	<?php endif; ?>
	<div class="head-wrapper">
	<div class="left">
		<h1 class="page-title sub">
			<?php if (get_field('title', $term->taxonomy .'_'. $term->term_id)) : ?>
				<?php echo get_field('title', $term->taxonomy .'_'. $term->term_id); ?>
			<?php else : ?>
				<?php woocommerce_page_title(); ?>
			<?php endif; ?>
			<?php 
				if ($current_page != 1 && !is_search()) {
					echo ' - страница ' . $current_page; 
				}
			?>
		</h1>
		<?php
		/**
		 * Hook: woocommerce_archive_description.
		 *
		 * @since 1.6.2.
		 * @hooked woocommerce_taxonomy_archive_description - 10
		 * @hooked woocommerce_product_archive_description - 10
		 */
		do_action( 'woocommerce_archive_description' );
		?>
			<?php 
				if (!is_search()) {
					$term = get_queried_object();
					$term_id = $term->term_id;
					// Ваш код здесь, используя $term_id
				}
			?>

</div>

<?php if (!is_search()) {  if (get_field('brand_logo', $term->taxonomy .'_'. $term->term_id)) : ?>
    <div class="right">
        <img src="<?php echo get_field('brand_logo', $term->taxonomy .'_'. $term->term_id); ?>" alt="<?php woocommerce_page_title(); ?>">
    </div>
<?php endif; } ?>
	</div>

	
</header>
