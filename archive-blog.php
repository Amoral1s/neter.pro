<?php
get_header();
?> 
<div class="page-top">
  <div class="container">
    <?php
      if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p class="breadcrumbs">', '</p>'); }
    ?>
  </div>
</div>
<?php $current_page = get_query_var('paged') ? get_query_var('paged') : 1; ?>
<section  itemscope itemtype="http://schema.org/Blog" class="blog">
  <link itemprop="image" href="<?php echo get_template_directory_uri(); ?>/img/logo.svg">
	<link itemprop="url" href="<?php echo get_permalink(); ?>">
	<meta itemprop="description" content="<?php the_excerpt(); ?>">
	<meta itemprop="author" content="<?php the_author(); ?>">
	<meta itemprop="datePublished" content="<?php the_time('c'); ?>">
	<meta itemprop="dateModified" content="<?php the_modified_date('c'); ?>">
  <div class="container">
  <h1 class="page-title sub">
        <?php 
          if (get_field('arch_blog_title', 'options')) {
            echo get_field('arch_blog_title', 'options');
          } else {
            the_archive_title();
          }
        
				if ($current_page != 1 && !is_search()) {
					echo ' - страница ' . $current_page; 
				}
			?>
    </h1>
    <?php if (get_field('arch_blog_subtitle', 'options')) : ?>
      <p class="subtitle">
        <?php echo get_field('arch_blog_subtitle', 'options') ?>
      </p>
    <?php endif; ?>
    <div class="blog-wrap">
      <?php
      if (have_posts()) :
          while (have_posts()) : the_post();
              ?>
              <a itemprop="blogPosts" itemscope itemtype="http://schema.org/BlogPosting" itemprop="url" href="<?php the_permalink(); ?>" class="item">
                  <img itemprop="image" src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                  <div class="meta">
                    <b><?php the_title(); ?></b>
                    <div class="date"><?php echo get_the_date('d M Y') ?></div>
                  </div>
              </a>
          <?php endwhile;
      endif;
      ?>
    </div>
    <?php
      if (function_exists('wp_pagenavi')) {
          wp_pagenavi();
      }
    ?>
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


<?php
get_footer();
