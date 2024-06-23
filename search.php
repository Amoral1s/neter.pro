<?php get_header(); ?>

<div class="page-top">
  <div class="container">
    <?php
      if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p class="breadcrumbs">', '</p>'); }
    ?>
  </div>
</div>
<section class="page blog page-search">
	<div class="container">
		<?php if ( have_posts() ) : ?>
		<h1 class="page-title">
			<?php printf( esc_html__( 'Результаты поиска: %s', 'main-theme' ), ' <span>' . get_search_query() . '</span>' ); ?>
		</h1>
		<div class="blog-search">
      <?php echo do_shortcode('[wpdreams_ajaxsearchpro id=2]'); ?>
    </div>
		<div class="news">
			<div class="wrap">
				<?php while ( have_posts() ) : the_post(); ?>
				<a href="<?php the_permalink(); ?>" id="post-<?php the_ID(); ?>" class="item">
						<?php if (get_the_post_thumbnail_url()) : ?>
							<img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
						<?php elseif (get_field('offer_img')) : ?>
							<img src="<?php the_field('offer_img'); ?>" alt="<?php the_title(); ?>">
						<?php else : ?>
							<img style="border: 1px solid #E5E7EB" src="<?php echo get_template_directory_uri(); ?>/img/placeholder.png" alt="<?php the_title(); ?>">
						<?php endif; ?>
						<b><?php the_title(); ?></b>
					
				</a><!-- #post-<?php the_ID(); ?> -->

				<?php	endwhile; ?>
			</div>
		</div>
		<?php if( function_exists('wp_pagenavi') ) wp_pagenavi();?>
		<?php else : ?>

		<h1 class="page-title">
			По вашему запросу ничего не найдено
		</h1>
		<?php endif; ?>
	</div>
</section><!-- #main -->

<?php get_footer(); ?>


<?php
get_header();
?> 


<section class="blog">
  <div class="container">
    <h1 class="page-title sub"></h1>
		<div class="blog-search">
      <?php echo do_shortcode('[wpdreams_ajaxsearchpro id=2]'); ?>
    </div>
    <div class="news">
      <div class="wrap">
        <?php
       
        if (have_posts()) :
            while (have_posts()) : the_post();
                ?>
                <a href="<?php the_permalink(); ?>" class="item">
                    <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                    <b><?php the_title(); ?></b>
                    <div class="content">
                        <?php the_excerpt(); ?>
                    </div>
                    <div class="date"><?php echo get_the_date('d M Y') ?></div>
                </a>
            <?php endwhile;
        endif;
        ?>
      </div>
    </div>
    <?php
      if (function_exists('wp_pagenavi')) {
          wp_pagenavi();
      }
    ?>
    
  </div>
</section>




<?php
get_footer();

