<?php
/**
 * Product quantity inputs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/quantity-input.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.8.0
 *
 * @var bool   $readonly If the input should be set to readonly mode.
 * @var string $type     The input type attribute.
 */

defined( 'ABSPATH' ) || exit;

/* translators: %s: Quantity. */
$label = ! empty( $args['product_name'] ) ? sprintf( esc_html__( '%s quantity', 'woocommerce' ), wp_strip_all_tags( $args['product_name'] ) ) : esc_html__( 'Quantity', 'woocommerce' );

?>
<div class="quantity">
	<div class="minus qty_button quantity-button.inc">	
		<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
			<path d="M20 12H4" stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
		</svg>
	</div>
	<?php
	/**
	 * Hook to output something before the quantity input field.
	 *
	 * @since 7.2.0
	 */
	do_action( 'woocommerce_before_quantity_input_field' );
	?>
	<input
		type="<?php echo esc_attr( $type ); ?>"
		<?php echo $readonly ? 'readonly="readonly"' : ''; ?>
		id="<?php echo esc_attr( $input_id ); ?>"
		class="<?php echo esc_attr( join( ' ', (array) $classes ) ); ?>"
		name="<?php echo esc_attr( $input_name ); ?>"
		value="<?php echo esc_attr( $input_value ); ?>"
		aria-label="<?php esc_attr_e( 'Product quantity', 'woocommerce' ); ?>"
		size="1"
		min="<?php echo esc_attr( $min_value ); ?>"
		max="<?php echo esc_attr( 0 < $max_value ? $max_value : '' ); ?>"
		<?php if ( ! $readonly ) : ?>
			step="1"
			placeholder="<?php echo esc_attr( $placeholder ); ?>"
			inputmode="<?php echo esc_attr( $inputmode ); ?>"
			autocomplete="<?php echo esc_attr( isset( $autocomplete ) ? $autocomplete : 'on' ); ?>"
		<?php endif; ?>
	/>
	<?php
	/**
	 * Hook to output something after quantity input field
	 *
	 * @since 3.6.0
	 */
	do_action( 'woocommerce_after_quantity_input_field' );
	?>
	<div class="plus qty_button quantity-button.dec">
		<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
			<path d="M12 4V20M20 12H4" stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
		</svg>
	</div>
	
</div>
<?php
