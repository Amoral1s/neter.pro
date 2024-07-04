<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.3.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! comments_open() ) {
	return;
}

?>
<div id="reviews" class="woocommerce-Reviews wrapper  wrapper-feed">
	<div class="left">
		
		<div id="comments">
			<?php if ( have_comments() ) : ?>
				<h2 class="title">Отзывы о товаре</h2>	
				<div class="button call-review">
					Оставить отзыв
				</div>
				<ul class="comments">
					<?php
						wp_list_comments(apply_filters('woocommerce_product_review_list_args', array('callback' => 'custom_woocommerce_comments')));
					?>
				</ul>
			<?php else : ?>
				<div class="no-rew">
					<h2 class="title sub">Отзывов пока нет</h2>	
					<p>К этому товару пока нет отзывов, но вы можете стать первым!</p>
					<div class="button call-review">
						Оставить отзыв
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<div class="right">
		<div class="close">
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
				<path d="M19 5L5 19M5 5L19 19" stroke="#141B34" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
			</svg>
		</div>
		<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>
			<div id="review_form_wrapper">
				<div id="review_form" class="form">
					<?php
					$commenter    = wp_get_current_commenter();
					$comment_form = array(
						/* translators: %s is product title */
						'title_reply'         => '<b class="mini-title">Оставить отзыв</b>',
						/* translators: %s is product title */
						'title_reply_to'      => esc_html__( 'Leave a Reply to %s', 'woocommerce' ),
						'title_reply_before'  => '<span id="reply-title" class="comment-reply-title">',
						'title_reply_after'   => '</span>',
						'comment_notes_after' => '',
						'label_submit'        => esc_html__( 'Отправить', 'woocommerce' ),
						'logged_in_as'        => '',
						'comment_field'       => '',
					);
					$name_email_required = (bool) get_option( 'require_name_email', 1 );
					$fields              = array(
						'email'  => array(
							'label'    => __( 'Электронная почта', 'woocommerce' ),
							'type'     => 'email',
							'value'    => $commenter['comment_author_email'],
							'required' => $name_email_required,
						),
						'author' => array(
							'label'    => __( 'Ваше имя', 'woocommerce' ),
							'type'     => 'text',
							'value'    => $commenter['comment_author'],
							'required' => $name_email_required,
						),
					);

					$comment_form['fields'] = array();

					foreach ( $fields as $key => $field ) {
						$field_html  = '<div class="input">';
						$field_html .= '<p>' . esc_html( $field['label'] );
						if ( $field['required'] ) {
							$field_html .= '&nbsp;*';
						}
						$field_html .= '</p>';
						
						$field_html .= '<input placeholder="'.esc_html( $field['label'] ).'" id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" type="' . esc_attr( $field['type'] ) . '" value="' . esc_attr( $field['value'] ) . '" size="30" ' . ( $field['required'] ? 'required' : '' ) . ' /></div>';

						$comment_form['fields'][ $key ] = $field_html;
					}
					

					if ( wc_review_ratings_enabled() ) {
						$comment_form['comment_field'] = '
							<div class="comment-form-rating">
								<p class="rew-label">
									Ваша оценка
								</p>
								<select name="rating" id="rating" required>
									<option value="">' . esc_html__( 'Rate&hellip;', 'woocommerce' ) . '</option>
									<option value="5">' . esc_html__( 'Perfect', 'woocommerce' ) . '</option>
									<option value="4">' . esc_html__( 'Good', 'woocommerce' ) . '</option>
									<option value="3">' . esc_html__( 'Average', 'woocommerce' ) . '</option>
									<option value="2">' . esc_html__( 'Not that bad', 'woocommerce' ) . '</option>
									<option value="1">' . esc_html__( 'Very poor', 'woocommerce' ) . '</option>
								</select>
							</div>';
					}

					$comment_form['comment_field'] .= '
						<div class="input">
							<p>
								Текст отзыва
							</p>
							<textarea placeholder="Текст отзыва" id="comment" name="comment" cols="45" rows="8" required></textarea>
						</div>';

					comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
					?>
					<small class="form-text">
						Оставляя свои контакты, вы даёте согласие на обработку <a href="<?php the_permalink(3); ?>" target="blank">персональных данных</a> и получение рекламных сообщений
					</small>
				</div>
			</div>
		<?php else : ?>
			<p class="woocommerce-verification-required"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'woocommerce' ); ?></p>
		<?php endif; ?>
		<div class="clear"></div>
	</div>
</div>
