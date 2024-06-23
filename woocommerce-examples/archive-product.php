<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

defined( 'ABSPATH' ) || exit;

if (is_shop() && !is_search()) :

	get_template_part('page-catalog');

elseif (is_search()) :

  get_template_part('search-products');

else :

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );


/**
 * Hook: woocommerce_shop_loop_header.
 *
 * @since 8.6.0
 *
 * @hooked woocommerce_product_taxonomy_archive_header - 10
 */
do_action( 'woocommerce_shop_loop_header' );

?>
<?php
	$term = get_queried_object();
	$term_id = $term->term_id;
?>
<?php
$subcategories = get_terms( array(
    'taxonomy' => 'product_cat',
    'child_of' => get_queried_object_id(),
    'hide_empty' => 0,
) );

if ( !empty( $subcategories ) && !is_paged()) : ?>
    <div class="sub-cats">
        <?php
        foreach ( $subcategories as $subcategory ) {
            $thumbnail_id = get_term_meta( $subcategory->term_id, 'thumbnail_id', true );
            $image = $thumbnail_id ? wp_get_attachment_url( $thumbnail_id ) : wc_placeholder_img_src();
            $name = $subcategory->name;
            $link = get_term_link( $subcategory );
            ?>
            <a href="<?php echo esc_url( $link ); ?>" class="item">
                <img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $name ); ?>">
                <b><?php echo esc_html( $name ); ?></b>
            </a>
            <?php
        }
        ?>
    </div>
<?php endif; ?>
<?php if (get_field('links', 'product_cat_' . $term_id) && !is_paged()) : ?>
<div class="links">
	<?php if (have_rows('links', 'product_cat_' . $term_id)) : while(have_rows('links', 'product_cat_' . $term_id)) : the_row(); ?>
		<a href="<?php echo get_sub_field('link'); ?>">
			<?php echo get_sub_field('name'); ?>
		</a>
	<?php endwhile; endif; ?>
</div>
<?php endif; ?>

<div class="wrap">
	<div class="left">
    <div class="mob-filters" style="display: none">
      <b>Фильтры</b>
      <div class="close icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
          <path d="M15 1L1 15M1 1L15 15" stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
    </div>
		<?php echo do_shortcode('[wpf-filters id=1]') ?>
	</div>
	<div class="right">
	
	
<?php

if ( woocommerce_product_loop() ) {

	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @hooked woocommerce_output_all_notices - 10
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	do_action( 'woocommerce_before_shop_loop' ); 


	woocommerce_product_loop_start();

	if ( wc_get_loop_prop( 'total' ) ) {
		while ( have_posts() ) {
			the_post();

			/**
			 * Hook: woocommerce_shop_loop.
			 */
			do_action( 'woocommerce_shop_loop' );

			wc_get_template_part( 'content', 'product' );
		}
	}

	woocommerce_product_loop_end();

	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	do_action( 'woocommerce_after_shop_loop' );
} else {
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action( 'woocommerce_no_products_found' );
}

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
//do_action( 'woocommerce_sidebar' );



?>

</div> <!-- right end -->
<?php 
  $actions = false;
  // Функция для проверки, является ли категория дочерней категории другой категории
  function is_descendant_category( $parent, $term ) {
    $parent_term_id = get_term_by('slug', $parent, 'product_cat')->term_id;
    $descendants = get_term_children( $parent_term_id, 'product_cat' );

    foreach( $descendants as $child ) {
        if ( $term->term_id == $child ) {
            return true; // Найден потомок
        }
    }

    return false; // Не является потомком
  }
  if ($term->slug == 'actions' || is_descendant_category( 'actions', $term )) {
    $actions = true;
  }
  
?>


<?php if (get_field('links', 'product_cat_' . $term_id) && !is_paged()) : ?>
	<section class="container links-wrap">
		<div class="links">
			<?php if (have_rows('links', 'product_cat_' . $term_id)) : while(have_rows('links', 'product_cat_' . $term_id)) : the_row(); ?>
				<a href="<?php echo get_sub_field('link'); ?>">
					<?php echo get_sub_field('name'); ?>
				</a>
			<?php endwhile; endif; ?>
		</div>
	</section>
<?php endif; ?>

</div> <!-- wrap end -->


<?php if (get_field('calc_title', 'options') && !is_paged()) : ?>
<section class="calc calc-septik-wrap bg-gray " <?php if ($actions == true) { echo 'style="margin-bottom: 0px;"'; } ?> >
  <div class="container">
    <div class="wrap">
      <div class="left">
        <h2 class="title title-sub"><?php echo get_field('calc_title', 'options') ?></h2>
        <p class="subtitle"><?php echo get_field('calc_subtitle', 'options'); ?></p>
        <div class="wrap-row">
          <?php if (have_rows('calc_feat','options')) : while(have_rows('calc_feat','options')) : the_row(); ?>
            <div class="item">
              <div class="icon"><img src="<?php echo get_sub_field('ikonka'); ?>" alt="icon"></div>
              <div class="meta">
                <b><?php echo get_sub_field('zagolovok'); ?></b>
                <p><?php echo get_sub_field('tekst'); ?></p>
              </div>
            </div>
          <?php endwhile; endif; ?>
        </div>
      </div>
      <div class="right">
        <?php get_template_part('calc/calc', 'septik'); ?>
      </div>
    </div>
  </div>
  <div class="bg">
    <img src="<?php echo get_template_directory_uri(); ?>/img/calc-bg.svg" alt="bg">
  </div>
</section>
<?php endif; ?>


<?php if (get_field('features_title', 'options') && !is_paged() && $actions == false) : ?>
<section class="features">
  <div class="container">
    <div class="title-row">
      <h2 class="title"><?php echo get_field('features_title', 'options') ?></h2>
      <p class="subtitle"><?php echo get_field('features_subtitle', 'options'); ?></p>
    </div>
    <div class="wrap">
    <?php $i = 1; if (have_rows('features','options')) : while(have_rows('features','options')) : the_row(); ?>
      <div class="item" style="<?php the_sub_field('background'); ?>">
        <div class="top">
          <div class="icon">
            <img src="<?php the_sub_field('icon'); ?>" alt="icon">
          </div>
          <?php if ($i == 1) : ?>
            <div class="button buy-services" data-serv="Бесплатный замер">Записаться</div>
          <?php endif; ?>
        </div>
        <b><?php the_sub_field('title'); ?></b>
        <p><?php the_sub_field('kontent'); ?></p>
      </div>
    <?php $i++; endwhile; endif; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (get_field('consult_banner_title', 'options') && !is_paged() && $actions == false) : ?>
<section class="consult-banner">
  <div class="container">
    <div class="wrap">
      <div class="left">
        <b class="title"><?php echo get_field('consult_banner_title', 'options'); ?></b>
        <p class="subtitle"><?php echo get_field('consult_banner_subtitle', 'options'); ?></p>
      </div>
      <div class="right form">
        <?php echo do_shortcode('[contact-form-7 id="c246be1" title="Баннер консультации"]'); ?>
      </div>
      <div class="line">
        <svg xmlns="http://www.w3.org/2000/svg" width="1240" height="10" viewBox="0 0 1240 10" fill="none">
          <path d="M0 0H864.183L899 -1.05625e-05H1240V10H0V0Z" fill="url(#paint0_linear_252_382)"/>
          <defs>
          <linearGradient id="paint0_linear_252_382" x1="0.000360275" y1="-1.51656" x2="100.315" y2="341.178" gradientUnits="userSpaceOnUse">
          <stop stop-color="#00AA46"/>
          <stop offset="0.35138" stop-color="#009EC7"/>
          <stop offset="1" stop-color="#1652EB"/>
          </linearGradient>
          </defs>
        </svg>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<?php
if (get_field('sale_title', 'options') && !is_paged() && $actions == false) :
    $sale_products = new WP_Query(array(
        'posts_per_page' => -1,
        'post_type' => 'product',
        'meta_query' => array(
            array(
                'key' => '_sale_price',
                'value' => 0,
                'compare' => '>',
                'type' => 'NUMERIC'
            )
        )
    ));
    if ($sale_products->have_posts()) :
?>
<section class="popular">
  <div class="container">
    <h2 class="title"><?php echo get_field('sale_title', 'options'); ?></h2>
    <div class="wrap slider-wrap">
      <div class="arr arr-prev">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
          <path d="M15 6.5L9.7071 11.7929C9.3738 12.1262 9.2071 12.2929 9.2071 12.5C9.2071 12.7071 9.3738 12.8738 9.7071 13.2071L15 18.5" stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
      <div class="woocommerce">
				<ul class="products">
					<?php
							while ($sale_products->have_posts()) : $sale_products->the_post();
									wc_get_template_part('content', 'product');
							endwhile;
							wp_reset_postdata();
					?>
				</ul>
			</div>
      <div class="arr arr-next">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
          <path d="M9 18.5L14.2929 13.2071C14.6262 12.8738 14.7929 12.7071 14.7929 12.5C14.7929 12.2929 14.6262 12.1262 14.2929 11.7929L9 6.5" stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>
<?php endif; ?>

<?php if (get_field('brands_title', 'options') && !is_paged()) : ?>
<section class="brands <?php if ($actions == true) echo 'page-brands'; ?>">
  <div class="line"><img src="<?php echo get_template_directory_uri(); ?>/img/ethaps-line.svg" alt="line"></div>
  <div class="container">
    <h2 class="title title-sub"><?php echo get_field('brands_title', 'options') ?></h2>
    <p class="subtitle"><?php echo get_field('brands_subtitle', 'options'); ?></p>
    <div class="scroll">
      <div class="wrap">
        <?php if (have_rows('brands','options')) : while(have_rows('brands','options')) : the_row(); ?>
          <a href="<?php echo get_sub_field('ssylka'); ?>" class="item">
            <img src="<?php echo get_sub_field('logo'); ?>" alt="<?php echo get_sub_field('nvzvanie'); ?>">
            <b><?php echo get_sub_field('nvzvanie'); ?></b>
          </a>
        <?php endwhile; endif; ?>
      </div>
    </div>
    <a href="<?php the_permalink(4861) ?>" class="all-brands">
      Смотреть все бренды
    </a>
  </div>
</section>
<?php endif; ?>

<?php if (get_field('any_title', 'options') && !is_paged() && $actions == false) : ?>
<section class="any page-any">
  <div class="container">
    <div class="wrap">
      <div class="left">
        <h2 class="title title-sub"><?php echo get_field('any_title', 'options') ?></h2>
        <p class="subtitle"><?php echo get_field('any_subtitle', 'options'); ?></p>
        <div class="phone">
          <div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path d="M3.77762 11.9424C2.8296 10.2893 2.37185 8.93948 2.09584 7.57121C1.68762 5.54758 2.62181 3.57081 4.16938 2.30947C4.82345 1.77638 5.57323 1.95852 5.96 2.6524L6.83318 4.21891C7.52529 5.46057 7.87134 6.08139 7.8027 6.73959C7.73407 7.39779 7.26737 7.93386 6.33397 9.00601L3.77762 11.9424ZM3.77762 11.9424C5.69651 15.2883 8.70784 18.3013 12.0576 20.2224M12.0576 20.2224C13.7107 21.1704 15.0605 21.6282 16.4288 21.9042C18.4524 22.3124 20.4292 21.3782 21.6905 19.8306C22.2236 19.1766 22.0415 18.4268 21.3476 18.04L19.7811 17.1668C18.5394 16.4747 17.9186 16.1287 17.2604 16.1973C16.6022 16.2659 16.0661 16.7326 14.994 17.666L12.0576 20.2224Z" stroke="#24B642" stroke-width="1.5" stroke-linejoin="round"/>
              <path d="M14 6.83185C15.4232 7.43624 16.5638 8.57677 17.1682 10M14.654 2C18.1912 3.02076 20.9791 5.80852 22 9.34563" stroke="#24B642" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </div>
          <div class="meta">
            <span>Или позвоните, сразу все обсудим</span>
            <a data-city="phone" target="blank" href="tel:<?php echo get_field('phone', 'options'); ?>">
              <?php echo get_field('phone', 'options'); ?>
            </a>
          </div>
        </div>
      </div>
      <div class="right">
        <b>Где с вами связаться?</b>
        <div class="social-btns">
          <label for="social-btn-1" class="radio-social">
            <input checked type="radio" value="Позвонить" name="social-btn" id="social-btn-1">
            <div class="btn">
              <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                  <path d="M5.85632 1.41157C6.42301 1.52869 6.8743 1.90943 7.1547 2.41246L8.04791 4.01491C8.37692 4.60511 8.65379 5.1018 8.8346 5.53357C9.02641 5.99158 9.14032 6.44324 9.08825 6.9426C9.03617 7.44196 8.83152 7.8604 8.54935 8.26899C8.28334 8.65417 7.90994 9.08304 7.46624 9.59267L6.15323 11.1009C5.91795 11.3711 5.8003 11.5062 5.78955 11.6751C5.7788 11.844 5.87522 11.9883 6.06806 12.2768C7.71165 14.7359 9.92679 16.9518 12.3879 18.5968C12.6765 18.7897 12.8207 18.8861 12.9896 18.8753C13.1585 18.8646 13.2937 18.7469 13.5639 18.5116L15.0722 17.1986C15.5818 16.7549 16.0107 16.3815 16.3959 16.1155C16.8044 15.8333 17.2229 15.6286 17.7222 15.5766C18.2216 15.5245 18.6733 15.6384 19.1313 15.8302C19.563 16.011 20.0597 16.2879 20.6498 16.6168L22.2524 17.5101C22.7554 17.7905 23.1362 18.2418 23.2533 18.8085C23.3716 19.3811 23.1971 19.9566 22.8115 20.4297C21.4126 22.146 19.1713 23.2389 16.8201 22.7646C15.3749 22.473 13.9489 21.9873 12.2242 20.9982C8.75876 19.0108 5.65169 15.902 3.66661 12.4407C2.67749 10.716 2.19178 9.29 1.90024 7.84474C1.42594 5.49352 2.51877 3.25224 4.23514 1.85333C4.70817 1.46779 5.28372 1.29322 5.85632 1.41157Z" fill="#111827"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M14.2326 1.84799C14.3857 1.31736 14.94 1.01134 15.4706 1.16447C19.338 2.28049 22.384 5.32634 23.5001 9.19358C23.6533 9.72421 23.3473 10.2785 22.8167 10.4317C22.286 10.5848 21.7317 10.2788 21.5786 9.74819C20.653 6.54122 18.1232 4.01154 14.9161 3.08605C14.3855 2.93292 14.0795 2.37863 14.2326 1.84799ZM13.6189 6.56624C13.8348 6.05789 14.4219 5.82079 14.9302 6.03666C16.5919 6.74231 17.9223 8.07269 18.628 9.73438C18.8439 10.2427 18.6068 10.8298 18.0984 11.0457C17.5901 11.2616 17.003 11.0245 16.7871 10.5161C16.284 9.33137 15.3333 8.38068 14.1485 7.87756C13.6401 7.66169 13.403 7.07459 13.6189 6.56624Z" fill="#111827"/>
                </svg>
              </div>
              <span>Позвонить</span>
            </div>
          </label>
          <label for="social-btn-2" class="radio-social">
            <input type="radio" value="Telegram" name="social-btn" id="social-btn-2">
            <div class="btn">
              <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <path d="M14.7041 19.6345L12.0442 16.6103C10.7274 15.1131 10.5714 14.4552 10.6581 14.3134L11.6564 13.5094L15.7027 10.3444C16.029 10.0892 16.0866 9.61786 15.8314 9.29159C15.5762 8.96533 15.1048 8.90772 14.7785 9.16292L10.728 12.3311L9.50989 13.3253C9.22553 13.6305 9.04418 14.1524 9.24197 14.8946C9.42654 15.5872 9.94427 16.5026 11.0466 17.7593L10.6395 18.5622C10.3765 18.9277 10.1324 19.2671 9.90771 19.4997C9.68445 19.7308 9.27877 20.0705 8.71374 19.9581C8.15614 19.8472 7.90592 19.3862 7.78203 19.0904C7.65621 18.7899 7.54964 18.3824 7.43402 17.9404L6.93252 16.0239C6.65396 14.9594 6.55777 14.6534 6.37651 14.4282C6.35363 14.3998 6.3298 14.3723 6.30509 14.3459C6.11372 14.141 5.84345 14.0149 4.8535 13.6181L4.79927 13.5963C3.82368 13.2053 3.02006 12.8832 2.45798 12.5667C1.91344 12.2601 1.3254 11.8144 1.25775 11.0623C1.24724 10.9454 1.24742 10.8278 1.25829 10.7109C1.32825 9.95901 1.91775 9.51516 2.46325 9.21037C3.02632 8.89576 3.83094 8.57633 4.80773 8.18854L16.7918 3.43052C18.0177 2.94379 19.02 2.54579 19.8076 2.36434C20.6106 2.17935 21.4401 2.15976 22.0901 2.76101C22.7273 3.35039 22.8036 4.18068 22.7242 5.01747C22.6454 5.8477 22.3864 6.92742 22.0669 8.2593L19.6472 18.3463C19.4436 19.1953 19.2717 19.9121 19.0655 20.4321C18.8573 20.9575 18.5233 21.5216 17.8484 21.7001C17.1654 21.8807 16.6009 21.544 16.1719 21.1809C15.7505 20.8243 15.2699 20.2779 14.7041 19.6345Z" fill="#009EC7"/>
                </svg>
              </div>
              <span>Telegram</span>
            </div>
          </label>
          <label for="social-btn-3" class="radio-social">
            <input type="radio" value="Whatsapp" name="social-btn" id="social-btn-3">
            <div class="btn">
              <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M12.3281 1.25C6.39109 1.25 1.57815 6.06294 1.57815 12C1.57815 13.4809 1.87802 14.8937 2.42106 16.1794C2.56352 16.5167 2.65955 16.7447 2.7237 16.9198C2.78912 17.0985 2.79831 17.1631 2.79947 17.1797C2.80596 17.2736 2.7822 17.4013 2.62005 18.0074L1.60363 21.8061C1.5344 22.0649 1.60842 22.3409 1.79782 22.5303C1.98722 22.7197 2.26325 22.7937 2.522 22.7245L6.32077 21.7081C6.9268 21.5459 7.05448 21.5222 7.14839 21.5287C7.16505 21.5298 7.22967 21.539 7.40832 21.6044C7.58347 21.6686 7.81139 21.7646 8.14869 21.9071C9.43447 22.4501 10.8472 22.75 12.3281 22.75C18.2652 22.75 23.0781 17.937 23.0781 12C23.0781 6.06294 18.2652 1.25 12.3281 1.25ZM9.30103 6.25003L9.20838 6.24992C8.72871 6.24911 8.28622 6.24836 7.85104 6.44714C7.53489 6.59156 7.26588 6.83691 7.06999 7.08196C6.8741 7.32701 6.69403 7.64346 6.6228 7.98366C6.52516 8.45 6.60568 8.80483 6.69182 9.18441L6.70371 9.23691C7.13823 11.1612 8.15405 13.048 9.71686 14.6109C11.2796 16.1737 13.1665 17.1895 15.0908 17.624L15.1433 17.6359C15.5229 17.722 15.8777 17.8026 16.344 17.7049C16.6842 17.6337 17.0007 17.4536 17.2457 17.2577C17.4908 17.0618 17.7361 16.7928 17.8806 16.4767C18.0793 16.0415 18.0786 15.599 18.0778 15.1193L18.0777 15.0267C18.0777 14.8063 18.0709 14.4352 17.9279 14.0922C17.7572 13.6824 17.4054 13.3447 16.8539 13.2583L16.8482 13.2574C16.1649 13.1503 15.6451 13.0688 15.2777 13.0154C15.0938 12.9887 14.9412 12.9679 14.8218 12.9544C14.7236 12.9432 14.5886 12.9292 14.4756 12.9358C13.986 12.9645 13.5967 13.1631 13.2951 13.3697C13.1032 13.5013 12.8946 13.6774 12.7306 13.8159C12.6662 13.8703 12.6086 13.9189 12.5617 13.9567L12.4843 14.019C12.1891 14.2567 12.0414 14.3756 11.8594 14.3719C11.6774 14.3681 11.5438 14.2512 11.2767 14.0174C11.1068 13.8687 10.9402 13.7129 10.7775 13.5502C10.6147 13.3874 10.459 13.2209 10.3103 13.051C10.0765 12.7839 9.95959 12.6503 9.95584 12.4683C9.9521 12.2863 10.0709 12.1386 10.3087 11.8434L10.3709 11.766C10.4088 11.719 10.4574 11.6615 10.5118 11.5971C10.6503 11.4331 10.8264 11.2245 10.958 11.0326C11.1646 10.731 11.3632 10.3416 11.3919 9.8521C11.3985 9.73913 11.3845 9.60408 11.3733 9.50593C11.3597 9.38651 11.339 9.23387 11.3123 9.04997C11.2589 8.68248 11.1774 8.16301 11.0703 7.47946L11.0694 7.47377C10.983 6.92233 10.6453 6.57053 10.2355 6.39977C9.89253 6.25683 9.5214 6.25003 9.30103 6.25003Z" fill="#24B642"/>
                </svg>
              </div>
              <span>Whatsapp</span>
            </div>
          </label>
        </div>
        <div class="form form-white">
          <?php echo do_shortcode('[contact-form-7 id="c930d78" title="Есть вопросы?"]'); ?>
        </div>
      </div>
      <img style="display: none" class="bg-mob" src="<?php echo get_template_directory_uri(); ?>/img/any-mob.png" alt="Есть вопросы?">
      <img class="bg" src="<?php echo get_template_directory_uri(); ?>/img/any.png" alt="Есть вопросы?">
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (get_field('seo_title', 'product_cat_' . $term_id) && !is_paged() && $actions == false) : ?>
<section class="seo seo-page">
  <div class="container">
    <h2 class="title"><?php echo get_field('seo_title', 'product_cat_' . $term_id) ?></h2>
    <div class="content">
      <?php echo get_field('seo', 'product_cat_' . $term_id); ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (get_field('city_title', 'options') && !is_paged() && $actions == false) : ?>
<section class="city">
  <div class="container">
    <h2 class="title"><?php the_field('city_title', 'options'); ?></h2>
    <div class="city-wrap ">
    <?php if(have_rows('city', 'options')) : while(have_rows('city', 'options')) : the_row(); ?>
    <ul>
      <?php if(have_rows('columns')) : while(have_rows('columns')) : the_row(); ?>
      <li>
        <?php if (get_sub_field('link')) { ?>
        <a href="<?php the_sub_field('link'); ?>"><?php the_sub_field('name'); ?></a>
        <?php } else { ?>
        <div><?php the_sub_field('name'); ?></div>
        <?php } ?>
      </li>
      <?php endwhile; endif; ?>
    </ul>
    <?php endwhile; endif; ?>
    </div>
  </div>
</section>
<?php endif; ?>
 

<?php


get_footer( 'shop' );

endif;