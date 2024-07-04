<?php get_header(); ?>

<div class="page-top">
  <div class="container">
    <?php
      if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p class="breadcrumbs">', '</p>'); }
    ?>
  </div>
</div>

<section class="error-404 not-found">
	<div class="container">
		<div class="wrap">
			<div class="icon">
				<svg xmlns="http://www.w3.org/2000/svg" width="210" height="175" viewBox="0 0 210 175" fill="none">
					<path d="M69.593 40.5338C47.8646 40.5338 37.0003 40.5338 30.2502 47.284C23.5 54.0341 23.5 64.8983 23.5 86.6268C23.5 108.355 23.5 119.219 30.2502 125.97C34.6236 130.343 40.7241 131.883 50.3876 132.425M109 132.72H125.673C147.401 132.72 158.265 132.72 165.016 125.97C171.766 119.219 171.766 108.355 171.766 86.6268C171.766 64.8984 171.766 54.0341 165.016 47.284C159.582 41.8503 151.483 40.7905 137.196 40.5839" stroke="#9CA3AF" stroke-width="11.5233" stroke-linecap="round"/>
					<path d="M114.62 12L68.5 163.133" stroke="#F44336" stroke-width="11.5233" stroke-linecap="round"/>
					<path d="M171.766 67.4214L179.657 68.7366C184.891 69.6089 187.507 70.045 189.493 71.3139C191.446 72.5615 192.978 74.3691 193.887 76.5009C194.812 78.6681 194.812 81.3207 194.812 86.6268C194.812 91.9329 194.812 94.5856 193.887 96.7527C192.978 98.8845 191.446 100.692 189.493 101.94C187.507 103.209 184.891 103.645 179.657 104.517L171.766 105.832" stroke="#9CA3AF" stroke-width="11.5233" stroke-linecap="round"/>
				</svg>
			</div>
			<h1 class="page-title sub" style="text-align: center;">Страница не найдена</h1>
			<p class="subtitle" style="text-align: center;">
				Так уж получилось, что из множества страниц нашего сайта вы оказались как раз на той, которая уже не существует
			</p>
			<a href="/" class="button">На главную страницу</a>
		</div>
	</div>
</section><!-- .error-404 -->

<section class="related">
	<div class="container">
    <h2 class="title">
      Рекомендуем
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
  </div>
</section>

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



<?php get_footer(); ?>
