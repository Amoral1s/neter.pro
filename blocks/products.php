<?php if (get_field('block_product_toggle') == true) : ?>
<section class="related">
  <h2 class="title">
    <?php echo get_field('block_product_title'); ?>
  </h2>
  <div class="wrap slider-wrap">
    <div class="arr arr-prev">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
        <path d="M14.9999 6L9.70703 11.2929C9.37369 11.6262 9.20703 11.7929 9.20703 12C9.20703 12.2071 9.37369 12.3738 9.70703 12.7071L14.9999 18" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>
    <div class="swiper">
      <?php
        $ids = get_field('products_id');
        $args = array(
            'post_type' => 'product',
            'post__in' => $ids,
            'posts_per_page' => -1,
        );
        $random_products = new WP_Query( $args );

        if ( $random_products->have_posts() ) : ?>

            <ul class="products">
                <?php while ( $random_products->have_posts() ) : $random_products->the_post(); ?>
                    <?php wc_get_template_part( 'content', 'related' ); ?>
                <?php endwhile; // end of the loop. ?>
            </ul>

        <?php endif;

        wp_reset_postdata();
      ?>
    </div>
    <div class="arr arr-next">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
        <path d="M9.00008 6L14.293 11.2929C14.6263 11.6262 14.793 11.7929 14.793 12C14.793 12.2071 14.6263 12.3738 14.293 12.7071L9.00008 18" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>
  </div> 
</section>
<?php else : ?>
<section class="related">
  <h2 class="title">
    <?php echo get_field('block_product_title'); ?>
  </h2>
  <div class="wrap slider-wrap">
    <div class="arr arr-prev">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
        <path d="M14.9999 6L9.70703 11.2929C9.37369 11.6262 9.20703 11.7929 9.20703 12C9.20703 12.2071 9.37369 12.3738 9.70703 12.7071L14.9999 18" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>
    <div class="swiper">
      <?php
        // Получаем случайные продукты
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => 10,
            'orderby' => 'rand'
        );
        $random_products = new WP_Query( $args );

        if ( $random_products->have_posts() ) : ?>

            <ul class="products">
                <?php while ( $random_products->have_posts() ) : $random_products->the_post(); ?>
                    <?php wc_get_template_part( 'content', 'related' ); ?>
                <?php endwhile; // end of the loop. ?>
            </ul>

        <?php endif;

        wp_reset_postdata();
      ?>
    </div>
    <div class="arr arr-next">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
        <path d="M9.00008 6L14.293 11.2929C14.6263 11.6262 14.793 11.7929 14.793 12C14.793 12.2071 14.6263 12.3738 14.293 12.7071L9.00008 18" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>
  </div> 
</section>
<?php endif; ?>