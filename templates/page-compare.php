<?php
/**
 Template Name: Сравнение
 */

get_header();
?>
<section class="feat-page page-top">
  <div class="container">
    <?php
      if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p class="breadcrumbs dark-crumbs">', '</p>'); }
    ?>
    <?php
      $featured_product_ids = array();

      if (function_exists('main_theme_get_featured_product_ids_from_cookie') && function_exists('main_theme_get_valid_featured_product_ids')) {
        $featured_product_ids = main_theme_get_valid_featured_product_ids(main_theme_get_featured_product_ids_from_cookie());
      }

      $featured_products_query = null;

      if (!empty($featured_product_ids)) {
        $featured_products_query = new WP_Query(array(
          'post_type'           => 'product',
          'post_status'         => 'publish',
          'posts_per_page'      => count($featured_product_ids),
          'post__in'            => $featured_product_ids,
          'orderby'             => 'post__in',
          'no_found_rows'       => true,
          'ignore_sticky_posts' => true,
        ));
      }

      $has_featured_products = $featured_products_query instanceof WP_Query && $featured_products_query->have_posts();
    ?>
    <?php if ($has_featured_products) : ?>
      <div class="wrap">
        <h1 class="page-title sub"><?php the_title(); ?></h1>
        <div class="feat-page__wrap related" data-featured-products-wrap>
          <?php woocommerce_product_loop_start(); ?>
            <?php while ($featured_products_query->have_posts()) : $featured_products_query->the_post(); ?>
              <?php
                global $product;
                $product = wc_get_product(get_the_ID());

                if ($product) {
                  wc_get_template_part('content', 'related');
                }
              ?>
            <?php endwhile; ?>
          <?php woocommerce_product_loop_end(); ?>
          <?php wp_reset_postdata(); ?>
        </div>
      </div>
    <?php else : ?>
      <div class="feat-page__no-products">
        <div class="icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M16.5175 44.1667C16.5671 44.1667 16.6168 44.1667 16.6667 44.1667C16.7165 44.1667 16.7663 44.1667 16.8159 44.1667C18.2586 44.1667 19.5813 44.1664 20.6574 44.3111C21.8423 44.4704 23.0947 44.8451 24.1248 45.8754C25.1549 46.9054 25.5297 48.1577 25.689 49.3427C25.8337 50.4187 25.8335 51.7414 25.8334 53.1844C25.8334 53.2337 25.8334 53.2837 25.8334 53.3334V56.6667C25.8334 56.7167 25.8334 56.7664 25.8334 56.8161C25.8335 58.2587 25.8337 59.5814 25.689 60.6574C25.5297 61.8424 25.1549 63.0947 24.1248 64.1247C23.0947 65.1551 21.8423 65.5297 20.6574 65.6891C19.5813 65.8337 18.2586 65.8337 16.8158 65.8334C16.7663 65.8334 16.7165 65.8334 16.6667 65.8334C16.6168 65.8334 16.5671 65.8334 16.5175 65.8334C15.0748 65.8337 13.752 65.8337 12.676 65.6891C11.4911 65.5297 10.2386 65.1551 9.20858 64.1247C8.17851 63.0947 7.80368 61.8424 7.64438 60.6574C7.49971 59.5814 7.49984 58.2587 7.50001 56.8161C7.50004 56.7664 7.50004 56.7167 7.50004 56.6667V53.3334C7.50004 53.2834 7.50004 53.2337 7.50001 53.1844C7.49984 51.7414 7.49971 50.4187 7.64438 49.3427C7.80368 48.1577 8.17851 46.9054 9.20858 45.8754C10.2386 44.8451 11.4911 44.4704 12.676 44.3111C13.752 44.1664 15.0748 44.1667 16.5175 44.1667Z" fill="#2CB4C2"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M39.8517 30.8333C39.901 30.8333 39.9507 30.8333 40.0007 30.8333C40.0507 30.8333 40.1003 30.8333 40.15 30.8333C41.5927 30.8331 42.9153 30.833 43.9913 30.9776C45.1763 31.1369 46.4287 31.5118 47.4587 32.5418C48.489 33.5719 48.8637 34.8243 49.023 36.0093C49.1677 37.0853 49.1677 38.4079 49.1673 39.8509C49.1673 39.9003 49.1673 39.9503 49.1673 39.9999V56.6666C49.1673 56.7166 49.1673 56.7663 49.1673 56.8159C49.1677 58.2586 49.1677 59.5813 49.023 60.6573C48.8637 61.8423 48.489 63.0946 47.4587 64.1246C46.4287 65.1549 45.1763 65.5296 43.9913 65.6889C42.9153 65.8336 41.5927 65.8336 40.15 65.8333C40.1003 65.8333 40.0507 65.8333 40.0007 65.8333C39.951 65.8333 39.901 65.8333 39.8517 65.8333C38.4087 65.8336 37.086 65.8336 36.01 65.6889C34.825 65.5296 33.5727 65.1549 32.5426 64.1246C31.5125 63.0946 31.1377 61.8423 30.9784 60.6573C30.8337 59.5813 30.8338 58.2586 30.834 56.8159C30.834 56.7663 30.834 56.7166 30.834 56.6666V39.9999C30.834 39.9499 30.834 39.9003 30.834 39.8509C30.8338 38.4079 30.8337 37.0853 30.9784 36.0093C31.1377 34.8243 31.5125 33.5719 32.5426 32.5418C33.5727 31.5118 34.825 31.1369 36.01 30.9776C37.086 30.833 38.4087 30.8331 39.8517 30.8333Z" fill="#2CB4C2"/>
            <path d="M63.1837 17.5L63.3327 17.5L63.482 17.5C64.9247 17.4998 66.2474 17.4997 67.3234 17.6444C68.5084 17.8037 69.7607 18.1785 70.7907 19.2086C71.821 20.2386 72.1957 21.4911 72.355 22.676C72.4997 23.752 72.4997 25.0748 72.4993 26.5175V26.6667V56.816C72.4997 58.2587 72.4997 59.5813 72.355 60.6573C72.1957 61.8423 71.821 63.0947 70.7907 64.1247C69.7607 65.155 68.5084 65.5297 67.3234 65.689C66.2474 65.8337 64.9247 65.8337 63.482 65.8333H63.1837C61.7407 65.8337 60.418 65.8337 59.342 65.689C58.157 65.5297 56.9047 65.155 55.8747 64.1247C54.8443 63.0947 54.4697 61.8423 54.3104 60.6573C54.1657 59.5813 54.166 58.2587 54.166 56.816V26.6667V26.5175C54.166 25.0748 54.1657 23.752 54.3104 22.676C54.4697 21.4911 54.8443 20.2386 55.8747 19.2086C56.9047 18.1785 58.157 17.8037 59.342 17.6444C60.418 17.4997 61.7407 17.4998 63.1837 17.5Z" fill="#2CB4C2"/>
          </svg>
        </div>
        <h1 class="page-title sub">Нет товаров для сравнения</h1>
        <p class="subtitle">Сравнивайте товары из каталога по ключевым характеристикам</p>
        <a href="/akkumulyatornye-batarei" class="button">
          Перейти в каталог
        </a>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php if (get_field('cat_row_title','options')) : ?>
<section class="cat-row">
  <div class="container">
    <h2 class="title"><?php echo get_field('cat_row_title','options') ?></h2>
    <div class="our-row">
      <div class="swiper">
        <div class="swiper-wrapper our-row-wrap">
          <?php if (have_rows('cat_row', 'options')) : while(have_rows('cat_row', 'options')) : the_row(); ?>
            <a href="<?php echo get_sub_field('link'); ?>" class="item swiper-slide">
              <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <path d="M17 7L6 18" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round"/>
                  <path d="M11 6H17C17.4714 6 17.7071 6 17.8536 6.14645C18 6.29289 18 6.5286 18 7V13" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </div>
              <b><?php echo get_sub_field('title'); ?></b>
              <img src="<?php echo get_sub_field('img'); ?>" alt="<?php echo get_sub_field('title'); ?>">
            </a>
          <?php endwhile; endif; ?>
        </div>
      </div>
      <div class="dots"></div>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (get_field('catalog_banner_title', 'options')) : ?>
<section class="catalog-banner">
  <div class="container">
    <div class="wrap">
      <div class="left">
        <b class="title sub"><?php echo get_field('catalog_banner_title', 'options'); ?></b>
        <p class="subtitle"><?php echo get_field('catalog_banner_subtitle', 'options'); ?></p>
        <div class="form">
          <?php echo do_shortcode('[contact-form-7 id="7dc5478" title="Отправка каталога"]'); ?>
        </div>
      </div>
      <div class="right">
        <img src="<?php echo get_field('catalog_banner_bg', 'options'); ?>" alt="<?php echo get_field('catalog_banner_title', 'options'); ?>">
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<?php
get_footer();
