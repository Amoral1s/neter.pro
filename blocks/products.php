<?php if (get_field('products_id')) : ?>
<section class="block_product popular">
  <div class="wrap slider-wrap">
    <div class="arr arr-prev">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
        <path d="M15 6.5L9.7071 11.7929C9.3738 12.1262 9.2071 12.2929 9.2071 12.5C9.2071 12.7071 9.3738 12.8738 9.7071 13.2071L15 18.5" stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>
    <div class="woocommerce">
      <ul class="products">
        <?php
        $ids = get_field('products_id');
        
        $args = array(
            'post_type' => 'product',
            'post__in' => $ids,
            'posts_per_page' => -1,
        );

        $products = new WP_Query($args);

        if ($products->have_posts()) {
            while ($products->have_posts()) {
                $products->the_post();
                wc_get_template_part('content', 'product');
            }
        } 

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
</section>
<?php endif; ?>