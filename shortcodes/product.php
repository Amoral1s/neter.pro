<?php if (get_field('product_title')) : ?>
<section class="tax-catalog cat-slider" id="Предлагаемые-товары">
    <h2 class="title title-sub"><?php the_field('product_title'); ?></h2>
    <p class="subtitle"><?php the_field('product_subtitle'); ?></p>
    <div class="swiper">
      <div class="wrap swiper-wrapper">
        <?php
        $slider_posts_id = get_field('product_ids');
          $args = array(
            'post_type'      => 'produkt',
            'post__in'       => $slider_posts_id,
            'orderby'        => 'post__in',
            'posts_per_page' => -1
          );
          $query = new WP_Query( $args );
          if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
              $query->the_post();
        ?>
          <a href="<?php the_permalink(); ?>" class="item swiper-slide">
            <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
            <?php if (get_field('offer_title')) : ?>
            <b><?php the_field('offer_title'); ?></b>
            <?php else : ?>
            <b><?php the_title(); ?></b>
            <?php endif; ?>
            <div class="meta">
              <?php if (get_field('time')) : ?>
              <div class="meta-item">
                <span>Срок реализации</span>
                <strong><?php the_field('time'); ?></strong>
              </div>
              <?php endif; ?>
              <?php if (get_field('price')) : ?>
              <div class="meta-item">
                <span>Стоимость от</span>
                <strong><?php the_field('price'); ?></strong>
              </div>
              <?php endif; ?>
            </div>
            <div class="btns">
              <div class="button buy" data-title="<?php the_field('offer_title'); ?>">
                Заказать
              </div>
              <div class="moar">
                <span>Подробнее</span>
                <div class="icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M17.6568 6.34325L6.34315 17.657M17.6568 6.34325L17.6569 13.4143M17.6568 6.34325L10.5858 6.34327" stroke="#FFB530" stroke-width="1.5"/>
                  </svg>
                </div>
              </div>
            </div>
          </a>
        <?php } }  wp_reset_postdata(); ?>
      </div>
    </div>
    
</section>

<?php endif; ?>