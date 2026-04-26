<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *

 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $product;

$current_product_id = $product->get_id();
$product_categories = wp_get_post_terms( $current_product_id, 'product_cat' );
$category_ids = array();

foreach ( $product_categories as $category ) {
    $category_ids[] = $category->term_id;
    if ( $category->parent != 0 && !in_array($category->parent, $category_ids) ) {
        $category_ids[] = $category->parent;
    }
}

$args_all = array(
    'post_type'           => 'product',
    'posts_per_page'      => 30,
    'orderby'             => 'date',
    'order'               => 'DESC',
    'post__not_in'        => array($current_product_id),
    'no_found_rows'       => true,
    'ignore_sticky_posts' => true,
);

if (!empty($category_ids)) {
    $args_all['tax_query'] = array(
        array(
            'taxonomy' => 'product_cat',
            'field'    => 'term_id',
            'terms'    => $category_ids,
            'operator' => 'IN',
        ),
    );
}

$all_products = new WP_Query($args_all);
$related_products = $all_products->posts;

if ( !empty( $related_products ) ) : ?>

<section class="related">
	<?php
	$heading = apply_filters( 'woocommerce_product_related_products_heading', __( 'Смотрите также', 'woocommerce' ) );

	if ( $heading ) :
			?>
	<h2 class="title"><?php echo esc_html( $heading ); ?></h2>
	<?php endif; ?>
	<div class="wrap slider-wrap">
		<div class="arr arr-prev">
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
				<path d="M14.9999 6L9.70703 11.2929C9.37369 11.6262 9.20703 11.7929 9.20703 12C9.20703 12.2071 9.37369 12.3738 9.70703 12.7071L14.9999 18" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
			</svg>
		</div>
		<div class="swiper">
			<?php woocommerce_product_loop_start(); ?>
				<?php foreach ( $related_products as $related_product ) : ?>
						<?php
								$post_object = get_post( $related_product->ID );
								setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found
								wc_get_template_part( 'content', 'related' );
						?>
				<?php endforeach; ?>
			<?php woocommerce_product_loop_end(); ?>
		</div>
		<div class="arr arr-next">
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
				<path d="M9.00008 6L14.293 11.2929C14.6263 11.6262 14.793 11.7929 14.793 12C14.793 12.2071 14.6263 12.3738 14.293 12.7071L9.00008 18" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
			</svg>
		</div>
	</div> 
</section>
<?php
endif;

wp_reset_postdata();
?>
