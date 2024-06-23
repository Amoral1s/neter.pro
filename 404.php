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

<section class="container">
	<h2 class="title">
		Добавить блок "рекомендуем"
	</h2>
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
