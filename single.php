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
				<?php if (get_field('avatar')) : ?>
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
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
							<path d="M7 2C7 1.44772 6.55228 1 6 1C5.44772 1 5 1.44772 5 2V2.44885C5.38032 2.32821 5.78554 2.24208 6.21533 2.17961C6.46328 2.14357 6.72472 2.11476 7 2.09173V2Z" fill="#24B642"/>
							<path d="M19 2.44885C18.6197 2.32821 18.2145 2.24208 17.7847 2.17961C17.5367 2.14357 17.2753 2.11476 17 2.09173V2C17 1.44772 17.4477 1 18 1C18.5523 1 19 1.44772 19 2V2.44885Z" fill="#24B642"/>
							<path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M13.0288 2H10.9712C9.02294 1.99997 7.45141 1.99994 6.21533 2.17961C4.92535 2.3671 3.8568 2.76781 3.01802 3.6746C2.18949 4.57031 1.83279 5.69272 1.66416 7.04866C1.49997 8.36894 1.49998 10.0541 1.5 12.1739V12.8261C1.49998 14.9459 1.49997 16.6311 1.66416 17.9513C1.83279 19.3073 2.18949 20.4297 3.01802 21.3254C3.8568 22.2322 4.92535 22.6329 6.21533 22.8204C7.45142 23.0001 9.02293 23 10.9712 23H13.0288C14.9771 23 16.5486 23.0001 17.7847 22.8204C19.0747 22.6329 20.1432 22.2322 20.982 21.3254C21.8105 20.4297 22.1672 19.3073 22.3358 17.9513C22.5 16.6311 22.5 14.9459 22.5 12.8261V12.1739C22.5 10.0541 22.5 8.36895 22.3358 7.04866C22.1672 5.69272 21.8105 4.57031 20.982 3.6746C20.1432 2.76781 19.0747 2.3671 17.7847 2.17961C16.5486 1.99994 14.9771 1.99997 13.0288 2ZM4.49783 9C4.03921 9 3.8099 9 3.66385 9.14417C3.51781 9.28833 3.51487 9.51472 3.509 9.96751C3.50027 10.6407 3.5 11.3942 3.5 12.2432V12.7568C3.5 14.9616 3.50182 16.5221 3.64887 17.7045C3.79327 18.8656 4.06263 19.5094 4.48622 19.9673C4.89956 20.4142 5.4647 20.6903 6.503 20.8412C7.57858 20.9975 9.00425 21 11.05 21H12.95C14.9957 21 16.4214 20.9975 17.497 20.8412C18.5353 20.6903 19.1004 20.4142 19.5138 19.9673C19.9374 19.5094 20.2067 18.8656 20.3511 17.7045C20.4982 16.5221 20.5 14.9616 20.5 12.7568V12.2432C20.5 11.3942 20.4997 10.6407 20.491 9.96751C20.4851 9.51472 20.4822 9.28833 20.3362 9.14417C20.1901 9 19.9608 9 19.5022 9H4.49783Z" fill="#24B642"/>
							<path fill-rule="evenodd" clip-rule="evenodd" d="M6.75 13C6.75 12.3096 7.30964 11.75 8 11.75H8.00897C8.69933 11.75 9.25897 12.3096 9.25897 13C9.25897 13.6904 8.69933 14.25 8.00897 14.25H8C7.30964 14.25 6.75 13.6904 6.75 13ZM10.7455 13C10.7455 12.3096 11.3052 11.75 11.9955 11.75H12.0045C12.6948 11.75 13.2545 12.3096 13.2545 13C13.2545 13.6904 12.6948 14.25 12.0045 14.25H11.9955C11.3052 14.25 10.7455 13.6904 10.7455 13ZM14.741 13C14.741 12.3096 15.3007 11.75 15.991 11.75H16C16.6904 11.75 17.25 12.3096 17.25 13C17.25 13.6904 16.6904 14.25 16 14.25H15.991C15.3007 14.25 14.741 13.6904 14.741 13ZM6.75 17C6.75 16.3096 7.30964 15.75 8 15.75H8.00897C8.69933 15.75 9.25897 16.3096 9.25897 17C9.25897 17.6904 8.69933 18.25 8.00897 18.25H8C7.30964 18.25 6.75 17.6904 6.75 17ZM10.7455 17C10.7455 16.3096 11.3052 15.75 11.9955 15.75H12.0045C12.6948 15.75 13.2545 16.3096 13.2545 17C13.2545 17.6904 12.6948 18.25 12.0045 18.25H11.9955C11.3052 18.25 10.7455 17.6904 10.7455 17Z" fill="#24B642"/>
						</svg>
					</div>
					<time class="value" datetime="<?php echo get_the_date('d.m.Y') ?>"><?php echo get_the_date('d M Y') ?></time>
				</div>
				<div class="item read-time">
					<div class="icon">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
							<path opacity="0.3" d="M1.25 12C1.25 6.06294 6.06294 1.25 12 1.25C17.9371 1.25 22.75 6.06294 22.75 12C22.75 17.9371 17.9371 22.75 12 22.75C6.06294 22.75 1.25 17.9371 1.25 12Z" fill="#24B642"/>
							<path fill-rule="evenodd" clip-rule="evenodd" d="M16.7071 7.29289C17.0976 7.68342 17.0976 8.31658 16.7071 8.70711L13.4143 11.9999L13.707 12.2925C14.0975 12.683 14.0975 13.3162 13.707 13.7067C13.3165 14.0973 12.6833 14.0973 12.2928 13.7068L12.0001 13.4141L11.7071 13.7071C11.3166 14.0976 10.6834 14.0976 10.2929 13.7071C9.90237 13.3166 9.90237 12.6834 10.2929 12.2929L10.5858 11.9999L8.79292 10.2071C8.40238 9.81662 8.40236 9.18346 8.79287 8.79292C9.18338 8.40238 9.81654 8.40236 10.2071 8.79287L12.0001 10.5857L15.2929 7.29289C15.6834 6.90237 16.3166 6.90237 16.7071 7.29289Z" fill="#24B642"/>
						</svg>
					</div>
					<div class="value">
						~ <?php echo gp_read_time(); ?> мин.
					</div>
				</div>
				<div class="item views">
					<div class="icon">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
							<path opacity="0.3" d="M12 4.25C9.42944 4.25 7.22595 5.38141 5.52031 6.71298C3.81313 8.04576 2.55126 9.61974 1.84541 10.6095L1.79219 10.6837C1.53904 11.0358 1.25 11.4378 1.25 12C1.25 12.5622 1.53904 12.9642 1.79219 13.3163L1.84541 13.3905C2.55126 14.3803 3.81313 15.9542 5.52031 17.287C7.22595 18.6186 9.42944 19.75 12 19.75C14.5706 19.75 16.774 18.6186 18.4797 17.287C20.1869 15.9542 21.4487 14.3803 22.1546 13.3905L22.2078 13.3163C22.461 12.9642 22.75 12.5622 22.75 12C22.75 11.4378 22.461 11.0358 22.2078 10.6837L22.1546 10.6095C21.4487 9.61974 20.1869 8.04576 18.4797 6.71298C16.774 5.38141 14.5706 4.25 12 4.25Z" fill="#24B642"/>
							<path fill-rule="evenodd" clip-rule="evenodd" d="M12 15.5C10.067 15.5 8.5 13.933 8.5 12C8.5 10.067 10.067 8.5 12 8.5C13.933 8.5 15.5 10.067 15.5 12C15.5 13.933 13.933 15.5 12 15.5Z" fill="#24B642"/>
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
			<div class="share">
				<script src="https://yastatic.net/share2/share.js"></script>
				<div class="ya-share2 share-block" data-curtain data-shape="round" data-services="vkontakte,telegram,whatsapp"></div>
				<div class="share-link">
					<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M13.1727 9.32599C11.8822 8.03546 9.80945 8.00326 8.48045 9.22941C8.14215 9.54141 7.61494 9.52024 7.30287 9.18191C6.9908 8.84366 7.01203 8.31645 7.35031 8.00437C9.33403 6.17428 12.4258 6.22196 14.3513 8.14744C16.3256 10.1218 16.3256 13.3229 14.3513 15.2973L11.9627 17.6858C9.98828 19.6602 6.78721 19.6602 4.81282 17.6858C2.83843 15.7115 2.83843 12.5104 4.81282 10.536L5.19978 10.149C5.52522 9.82357 6.05285 9.82357 6.37829 10.1491C6.70373 10.4745 6.70372 11.0021 6.37828 11.3276L5.99133 11.7145C4.66783 13.038 4.66783 15.1838 5.99133 16.5073C7.31484 17.8308 9.4607 17.8308 10.7842 16.5073L13.1727 14.1188C14.4963 12.7953 14.4963 10.6495 13.1727 9.32599Z" fill="#9CA3AF"/>
						<path fill-rule="evenodd" clip-rule="evenodd" d="M14.0086 3.49264C12.6851 2.16913 10.5393 2.16913 9.2158 3.49264L6.82727 5.88118C5.50376 7.2047 5.50376 9.35051 6.82727 10.674C8.11776 11.9645 10.1906 11.9968 11.5196 10.7706C11.8579 10.4586 12.3851 10.4798 12.6971 10.8181C13.0092 11.1563 12.988 11.6835 12.6497 11.9956C10.666 13.8258 7.57424 13.778 5.64876 11.8526C3.67437 9.87818 3.67437 6.67706 5.64876 4.70268L8.0373 2.31413C10.0117 0.339747 13.2128 0.339747 15.1872 2.31413C17.1616 4.28852 17.1616 7.48963 15.1872 9.46401L14.8002 9.85093C14.4748 10.1764 13.9471 10.1764 13.6217 9.85093C13.2963 9.52551 13.2963 8.99793 13.6217 8.67243L14.0086 8.28549C15.3322 6.96198 15.3322 4.81615 14.0086 3.49264Z" fill="#9CA3AF"/>
					</svg>
				</div>
			</div>
		</div>
		<div class="thumb">
			<img src="<?php echo the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" >
		</div>
	</div>

	<div class="single-nav">
		<b>Содержание статьи</b>
		<div class="single-nav-wrap">

		</div>
	</div>

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
						while ( $query->have_posts() ) {
							$query->the_post();
				?>
          <a href="<?php the_permalink(); ?>" class="item swiper-slide">
            <?php
              $news_image_alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);

              if (empty($news_image_alt)) {
                  $news_image_alt = get_the_title();
              }

              echo wp_get_attachment_image(get_post_thumbnail_id(), 'medium', false, array('alt' => $news_image_alt));
            ?>
            <b><?php the_title(); ?></b>
            <div class="content">
              <?php the_excerpt(); ?>
            </div>
            <div class="date"><?php echo get_the_date('d.m.Y') ?></div>
          </a>
          <?php }  ?>
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




<?php get_footer();

