<?php if (get_field('serv_title')) : ?>

<section class="services" id="Предлагаемые-услуги">
    <h2 class=" title-sub title"><?php the_field('serv_title'); ?></h2>
    <p class="subtitle" style="margin-bottom: 15px"><?php the_field('serv_subtitle'); ?></p>
    <div class="services-wrap service-block">
      <?php
       $slider_posts_id = get_field('serv_ids');
        $args = array(
          'post_type'      => 'service',
          'post__in'       => $slider_posts_id,
          'orderby'        => 'post__in',
          'posts_per_page' => -1
        );
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) {
          while ( $query->have_posts() ) {
            $query->the_post();
      ?>
      <a href="<?php the_permalink(); ?>" class="item">
        <b><?php the_title(); ?></b>
        <div class="icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
            <path d="M22.0711 7.92884L7.92894 22.071M22.0711 7.92884L22.0711 16.7677M22.0711 7.92884L13.2323 7.92888" stroke="#181818" stroke-width="1.875"/>
          </svg>
        </div>
      </a>
      <?php } }  wp_reset_postdata(); ?>
    </div>
</section>

<?php endif; ?>