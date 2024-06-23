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
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $related_products ) : ?>

<section class="related popular">
	<div class="container">
		<?php
		$heading = apply_filters( 'woocommerce_product_related_products_heading', __( 'Похожие товары', 'woocommerce' ) );

		if ( $heading ) :
			?>
			<h2 class="title"><?php echo esc_html( $heading ); ?></h2>
			
		<?php endif; ?>
		<div class="wrap slider-wrap">
      <div class="arr arr-prev">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
          <path d="M15 6.5L9.7071 11.7929C9.3738 12.1262 9.2071 12.2929 9.2071 12.5C9.2071 12.7071 9.3738 12.8738 9.7071 13.2071L15 18.5" stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
			<div class="woocommerce">
			<?php woocommerce_product_loop_start(); ?>

				
				<?php foreach ( $related_products as $related_product ) : ?>

						<?php
						$post_object = get_post( $related_product->get_id() );

						setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

						wc_get_template_part( 'content', 'product' );
						?>

				<?php endforeach; ?>

			<?php woocommerce_product_loop_end(); ?>
			</div>
			<div class="arr arr-next">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
          <path d="M9 18.5L14.2929 13.2071C14.6262 12.8738 14.7929 12.7071 14.7929 12.5C14.7929 12.2929 14.6262 12.1262 14.2929 11.7929L9 6.5" stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
    </div>
	</div>
</section>
	<?php
endif;


wp_reset_postdata();
