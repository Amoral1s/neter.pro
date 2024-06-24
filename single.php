<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>


<div class="page-top">
  <div class="container">
    <a href="/news" class="back-btn"  onclick="history.back()">
      <div class="icon">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
					<path d="M5 12L20 11.9998" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M8.99992 6.99988L4.70703 11.2928C4.37369 11.6261 4.20703 11.7928 4.20703 11.9999C4.20703 12.207 4.37369 12.3737 4.70703 12.707L8.99992 16.9999" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
      </div>
      <span>Назад</span>
    </a>
    <?php
      if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p class="breadcrumbs">', '</p>'); }
    ?>
  </div>
</div>


<section itemid="<?php echo get_permalink(); ?>" itemscope itemtype="http://schema.org/BlogPosting" class="single only-single-page container">
		<meta itemprop="description" content="<?php the_excerpt(); ?>">
		<link itemprop="image" href="<?php the_post_thumbnail_url(); ?>">
		<meta itemprop="author" content="<?php echo get_field('imya'); ?>, <?php echo get_field('dolzhnost'); ?>">
		<meta itemprop="datePublished" content="<?php the_time('c'); ?>">
		<meta itemprop="dateModified" content="<?php the_modified_date('c'); ?>">
	
	<div class="single-top">
		<h1 itemprop="headline" class="page-title"><?php the_title(); ?></h1>
		<?php if (get_field('subtitle')) { ?>
		<p class="subtitle"><?php echo get_field('subtitle'); ?></p>
		<?php } ?>
		<div class="meta-wrap">
			<div class="author">
				<?php if (get_field('author_image')) : ?>
				<div class="avatar">
					<img src="<?php echo get_field('author_image'); ?>" alt="Автор статьи">
				</div>
				<div itemprop="author" class="name">
					<p><?php echo get_field('author_name'); ?></p>
					<span><?php echo get_field('author_place'); ?></span>
				</div>
				<?php else : ?>
				<div class="avatar">
					<svg xmlns="http://www.w3.org/2000/svg" width="43" height="44" viewBox="0 0 43 44" fill="none">
						<path d="M21.2861 1.50394L17.6719 5.17541L21.2922 8.84079L24.9063 5.16917L21.2861 1.50394Z" fill="#2CB4C2"/>
						<path d="M9.54214 6.47088L5.94336 10.1055L9.54214 13.7852L13.1855 10.1055L9.54214 6.47088Z" fill="#2CB4C2"/>
						<path d="M4.6884 18.3336L1.07422 22.0052L4.69453 25.6705L8.30871 21.999L4.6884 18.3336Z" fill="#2CB4C2"/>
						<path d="M9.54214 30.239L5.94336 33.9038L9.54214 37.5685L13.1855 33.9038L9.54214 30.239Z" fill="#2CB4C2"/>
						<path d="M21.2894 42.5L24.9031 38.8354L21.2894 35.1706L17.6758 38.8354L21.2894 42.5Z" fill="#2CB4C2"/>
						<path d="M33.0166 30.2386L29.4023 33.9101L33.0227 37.5753L36.6368 33.9038L33.0166 30.2386Z" fill="#2CB4C2"/>
						<path d="M37.8858 18.3352L34.2686 22.0036L37.8858 25.6719L41.503 22.0036L37.8858 18.3352Z" fill="#2CB4C2"/>
						<path d="M33.0215 6.43792L29.4043 10.1063L33.0215 13.7746L36.6387 10.1063L33.0215 6.43792Z" fill="#2CB4C2"/>
						<path d="M21.2148 1.5L17.5986 5.16989L21.2174 8.8373L24.8336 5.16742L21.2148 1.5Z" fill="#2CB4C2" stroke="#2CB4C2" stroke-miterlimit="10" stroke-linecap="round"/>
						<path d="M9.47122 6.44111L5.85449 10.11L9.47223 13.7778L13.089 10.109L9.47122 6.44111Z" fill="#2CB4C2" stroke="#2CB4C2" stroke-miterlimit="10" stroke-linecap="round"/>
						<path d="M4.6157 18.3313L1 22.0013L4.61877 25.6681L8.23448 21.9981L4.6157 18.3313Z" fill="#2CB4C2" stroke="#2CB4C2" stroke-miterlimit="10" stroke-linecap="round"/>
						<path d="M9.46485 30.2428L5.84863 33.9123L9.4669 37.5795L13.0831 33.9101L9.46485 30.2428Z" fill="#2CB4C2" stroke="#2CB4C2" stroke-miterlimit="10" stroke-linecap="round"/>
						<path d="M21.2152 42.5L24.8289 38.8354L21.2152 35.1706L17.6016 38.8354L21.2152 42.5Z" fill="#2CB4C2" stroke="#2CB4C2" stroke-miterlimit="10" stroke-linecap="round"/>
						<path d="M32.9443 30.2332L29.3281 33.9027L32.9465 37.5699L36.5627 33.9005L32.9443 30.2332Z" fill="#2CB4C2" stroke="#2CB4C2" stroke-miterlimit="10" stroke-linecap="round"/>
						<path d="M37.8096 18.3362L34.1934 22.0057L37.8116 25.6731L41.4278 22.0036L37.8096 18.3362Z" fill="#2CB4C2" stroke="#2CB4C2" stroke-miterlimit="10" stroke-linecap="round"/>
						<path d="M32.9498 6.43298L29.333 10.1018L32.9508 13.7697L36.5674 10.1008L32.9498 6.43298Z" fill="#2CB4C2" stroke="#2CB4C2" stroke-miterlimit="10" stroke-linecap="round"/>
						<path d="M21.2109 35.1629L17.5947 38.8323L21.2129 42.4996L24.8292 38.8301L21.2109 35.1629Z" fill="#2CB4C2" stroke="#2CB4C2" stroke-miterlimit="10" stroke-linecap="round"/>
					</svg>
				</div>
				<div itemprop="author" class="name">
					<p>Neter.pro</p>
					<span>Проиозводитель аккумуляторов</span>
				</div>
				<?php endif; ?>
			</div>
			<div class="meta-wrap-items">
				<div class="item date">
					<div class="icon">
						<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
							<path d="M17 1V3M5 1V3" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M1.5 11.2432C1.5 6.88594 1.5 4.70728 2.75212 3.35364C4.00424 2 6.01949 2 10.05 2H11.95C15.9805 2 17.9958 2 19.2479 3.35364C20.5 4.70728 20.5 6.88594 20.5 11.2432V11.7568C20.5 16.1141 20.5 18.2927 19.2479 19.6464C17.9958 21 15.9805 21 11.95 21H10.05C6.01949 21 4.00424 21 2.75212 19.6464C1.5 18.2927 1.5 16.1141 1.5 11.7568V11.2432Z" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M5 7H17" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</div>
					<time class="value" datetime="<?php echo get_the_date('d.m.Y') ?>"><?php echo get_the_date('d M Y') ?></time>
				</div>
				<div class="item read-time">
					<div class="icon">
						<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
							<path d="M17.952 7.60639L20.4622 7.45358C18.6629 2.70459 13.497 -0.000269146 8.4604 1.34456C3.09599 2.77692 -0.0903694 8.26089 1.34347 13.5933C2.77731 18.9258 8.28839 22.0874 13.6528 20.6551C17.6358 19.5916 20.4181 16.2945 21 12.4842" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M11 6.99982L11 10.9998L13 12.9998" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</div>
					<div class="value">
						~ <?php echo gp_read_time(); ?> мин.
					</div>
				</div>
				<div class="item views">
					<div class="icon">
						<svg xmlns="http://www.w3.org/2000/svg" width="22" height="20" viewBox="0 0 22 20" fill="none">
							<path d="M1 6C1 6 5.47715 1 11 1C16.5228 1 21 6 21 6" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round"/>
							<path d="M20.544 11.045C20.848 11.4713 21 11.6845 21 12C21 12.3155 20.848 12.5287 20.544 12.955C19.1779 14.8706 15.6892 19 11 19C6.31078 19 2.8221 14.8706 1.45604 12.955C1.15201 12.5287 1 12.3155 1 12C1 11.6845 1.15201 11.4713 1.45604 11.045C2.8221 9.12944 6.31078 5 11 5C15.6892 5 19.1779 9.12944 20.544 11.045Z" stroke="#2CB4C2" stroke-width="1.5"/>
							<path d="M14 12C14 10.3431 12.6569 9 11 9C9.34315 9 8 10.3431 8 12C8 13.6569 9.34315 15 11 15C12.6569 15 14 13.6569 14 12Z" stroke="#2CB4C2" stroke-width="1.5"/>
						</svg>
					</div>
					<div class="value">
						<?php setPostViews(get_the_ID()); ?>
						<?php echo getPostViews(get_the_ID()); ?>
					</div>
				</div>
				<div itemprop="aggregateRating" itemscope="" itemtype="http://schema.org/AggregateRating" class="rating top-rat">
					<meta itemprop="bestRating" content="5">
					<meta itemprop="ratingValue" content="5">
					<div class="new-rating">
					</div>
					<div itemprop="ratingCount" class="votes">
					</div>
				</div>
			</div>
		</div>
		<div class="thumb">
			<img src="<?php echo the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" >
		</div>
	</div>
	<?php if (get_field('nav_toggle') == false) : ?>
	<div class="single-nav">
		<b>Содержание статьи</b>
		<div class="single-nav-wrap">

		</div>
	</div>
	<?php endif; ?>

	<div class="content">
		<?php the_content(); ?>
	</div>
	
	<div  class="comments">
		<?php comments_template(); ?>
	</div>

	
</section>

<?php 
	$current_post_id = get_the_ID();
	$args = array(
		'post_type'      => 'post',
		'posts_per_page' => 10,
		'post__not_in' => array($current_post_id),
		'orderby' => 'rand'
	);
	$query = new WP_Query( $args );

	if ( $query->have_posts() ) {
?>
<section class="news">
  <div class="container">
    <h2 class="title">Читайте также</h2>
    <a href="<?php the_permalink(4452); ?>" class="all-news" style="display: none">
      <span>Все статьи</span>
      <div class="icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
          <path d="M17 7L6 18" stroke="#24B642" stroke-width="1.5" stroke-linecap="round"/>
          <path d="M11 6H17C17.4714 6 17.7071 6 17.8536 6.14645C18 6.29289 18 6.5286 18 7V13" stroke="#24B642" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
    </a>
    <div class="wrap slider-wrap">
      <div class="arr arr-prev">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
          <path d="M15 6.5L9.7071 11.7929C9.3738 12.1262 9.2071 12.2929 9.2071 12.5C9.2071 12.7071 9.3738 12.8738 9.7071 13.2071L15 18.5" stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
      <div class="swiper">
        <div class="swiper-wrapper">
					<?php
						$current_post_id = get_the_ID();
						// Получаем все записи
						$args_all = array(
							'post_type'      => 'post',
							'posts_per_page' => -1, // Получаем все записи
							'orderby' => 'date',
							'order' => 'DESC'
						);
						$all_posts = new WP_Query( $args_all );
						// Ищем индекс текущей записи
						$current_index = -1;
						if ( $all_posts->have_posts() ) {
								$posts_array = $all_posts->posts;
								foreach ( $posts_array as $index => $post ) {
										if ( $post->ID == $current_post_id ) {
												$current_index = $index;
												break;
										}
								}
						}
						// Выводим 10 записей после текущей и если недостаточно, то добавляем записи до текущей
						if ( $current_index != -1 ) {
							$related_posts = array();
							// Добавляем записи после текущей
							for ( $i = $current_index + 1; $i < $current_index + 11 && $i < count( $posts_array ); $i++ ) {
								if ($posts_array[$i]->ID != $current_post_id) {
									$related_posts[] = $posts_array[$i];
								}
							}
							// Если недостаточно, добавляем записи до текущей в обратном порядке
							if ( count( $related_posts ) < 10 ) {
								for ( $i = $current_index - 1; $i >= 0 && count( $related_posts ) < 10; $i-- ) {
									if ($posts_array[$i]->ID != $current_post_id) {
										$related_posts[] = $posts_array[$i];
									}
								}
							}
							// Если записей все равно меньше 10, добавляем сколько есть
							if ( count( $related_posts ) < 10 ) {
								for ( $i = 0; $i < count( $posts_array ); $i++ ) {
									if ($posts_array[$i]->ID != $current_post_id && !in_array($posts_array[$i], $related_posts)) {
										$related_posts[] = $posts_array[$i];
									}
									if ( count( $related_posts ) >= 10 ) {
										break;
									}
								}
							}
							// Выводим записи
							if ( !empty( $related_posts ) ) {
								foreach ( $related_posts as $post ) {
										setup_postdata( $post );
									?>
									<a href="<?php the_permalink(); ?>" class="item swiper-slide">
										<?php
											$news_image_alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);

											if (empty($news_image_alt)) {
													$news_image_alt = get_the_title();
											}

											echo wp_get_attachment_image(get_post_thumbnail_id(), 'medium', false, array('alt' => $news_image_alt));
										?>
										<div class="meta">
											<b><?php the_title(); ?></b>
											<div class="date"><?php echo get_the_date('d.m.Y') ?></div>
										</div>
          				</a>
									<?php
								}
								wp_reset_postdata();
							}
						}
					?>
        </div>
      </div>
      <div class="arr arr-next">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
          <path d="M9 18.5L14.2929 13.2071C14.6262 12.8738 14.7929 12.7071 14.7929 12.5C14.7929 12.2929 14.6262 12.1262 14.2929 11.7929L9 6.5" stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
    </div>
  </div>
</section>
<?php }  wp_reset_postdata(); ?>


<?php endwhile; ?>

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




<?php get_footer();

