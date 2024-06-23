<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>


<div class="page-top">
  <div class="container">
    <a class="back-btn" href="/projects">
      <div class="icon">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
					<path d="M5 12L20 11.9998" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M8.99992 6.99988L4.70703 11.2928C4.37369 11.6261 4.20703 11.7928 4.20703 11.9999C4.20703 12.207 4.37369 12.3737 4.70703 12.707L8.99992 16.9999" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
      </div>
      <span>Все проекты</span>
    </a>
    <?php
      if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p class="breadcrumbs">', '</p>'); }
    ?>
  </div>
</div>


<section class="project">
	<div class="container">
		<h1 class="page-title sub"><?php the_title(); ?></h1>
		<div class="subtitle"><?php echo get_field('subtitle'); ?></div>
		<div class="thumb">
			<img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
		</div>
		<div class="wrap">
			<div class="left">
				<div class="item">
					<h2 class="mini-title">Задача</h2>
					<div class="content">
						<?php echo get_field('task'); ?>
					</div>
				</div>
				<div class="item">
					<h2 class="mini-title">Решение</h2>
					<div class="content">
						<?php echo get_field('decision'); ?>
					</div>
				</div>
			</div>
			<div class="right">
				<b class="mini-title">Характеристики</b>
				<?php if (have_rows('char')) : while(have_rows('char')) : the_row(); ?>
					<div class="item">
						<p><?php echo get_sub_field('name'); ?></p>
						<span></span>
						<b><?php echo get_sub_field('value'); ?></b>
					</div>
				<?php endwhile; endif; ?>
			</div>
		</div>
	</div>
</section>

<?php if (get_field('gallery')) : ?>
<section class="gallery-slider">
	<div class="container">
		<h2 class="title">Галерея проекта</h2>
		<div class="wrap slider-wrap">
			<div class="arr arr-prev">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
					<path d="M14.9999 6L9.70703 11.2929C9.37369 11.6262 9.20703 11.7929 9.20703 12C9.20703 12.2071 9.37369 12.3738 9.70703 12.7071L14.9999 18" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</div>
			<div class="swiper">
				<div class="swiper-wrapper magnific">
					<?php $gallery = get_field('gallery'); if ($gallery) : ?>
					<?php foreach( $gallery as $img ): ?>
						<a href="<?php echo esc_url($img['url']); ?>" class="swiper-slide item">
							<?php if ($img['alt']) {
								echo '<img src="' . esc_url($img['sizes']['large']) . '" alt="' . esc_attr($img['alt']) . '">';
							} else {
								echo '<img src="' . esc_url($img['sizes']['large']) . '" alt="' . get_the_title() . '">';
							} ?>
						</a>
					<?php endforeach; endif; ?>
				</div>
			</div>
			<div class="arr arr-next">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
					<path d="M9.00008 6L14.293 11.2929C14.6263 11.6262 14.793 11.7929 14.793 12C14.793 12.2071 14.6263 12.3738 14.293 12.7071L9.00008 18" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>

<?php endwhile; ?>

<section class="contacts-release" style="margin-bottom: 0">
  <div class="container">
    <div class="wrap">
      <b class="title">Поможем реализовать ваш проект</b>
      <p class="subtitle">
        Оставьте контактные данные и мы свяжемся с вами в ближайшее время и ответим на любые вопросы
      </p>
      <div class="form">
        <?php echo do_shortcode('[contact-form-7 id="f34c36e" title="Поможем реализовать проект"]'); ?>
      </div>
    </div>
  </div>
</section>




<?php get_footer();

