<?php
/**
 Template Name: Избранное
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
            <path d="M13.8137 11.1838C23.7503 5.08874 32.6644 7.51791 38.0494 11.562C38.9354 12.2273 39.5434 12.6827 39.9961 12.9901C40.4487 12.6827 41.0567 12.2273 41.9427 11.562C47.3277 7.51791 56.2421 5.08874 66.1784 11.1838C73.0494 15.3984 76.9154 24.202 75.5587 34.317C74.1957 44.481 67.6171 55.9763 53.6851 66.2883C48.8471 69.8713 45.2964 72.501 39.9961 72.501C34.6957 72.501 31.1452 69.8713 26.3072 66.2883C12.3752 55.9763 5.79659 44.481 4.43343 34.317C3.07681 24.202 6.94289 15.3984 13.8137 11.1838Z" fill="#2CB4C2"/>
          </svg>
        </div>
        <h1 class="page-title sub">В избранном пусто</h1>
        <p class="subtitle">Добавляйте товары из каталога, чтобы не потерять важное</p>
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
