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
    <h1 class="page-title sub"><?php the_archive_title() ?><?php  
				if ($current_page != 1 && !is_search()) {
					echo ' - страница ' . $current_page; 
				}
			?></h1>
    <div class="blog-cats">
      <?php
      class Custom_Walker_Category extends Walker_Category {
        function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
          $cat_name = esc_attr( $category->name );
          $cat_name = apply_filters( 'list_cats', $cat_name, $category );
          $link = '<a href="' . esc_url( get_term_link( $category ) ) . '" ';
          if ( $args['use_desc_for_title'] && ! empty( $category->description ) ) {
            $link .= 'title="' . esc_attr( strip_tags( apply_filters( 'category_description', $category->description, $category ) ) ) . '"';
          }
          $link .= '>';
          $link .= $cat_name . '</a>';

          if ( isset( $args['current_category'] ) && $category->term_id == $args['current_category'] ) {
            $link = '<span class="current-cat">' . $cat_name . '</span>';
          }

          if ( 'list' == $args['style'] ) {
            $output .= "\t<li";
            $class = 'cat-item cat-item-' . $category->term_id;
            if ( isset( $args['current_category'] ) && $category->term_id == $args['current_category'] ) {
              $class .= ' current-cat';
            }
            $output .= ' class="' . $class . '"';
            $output .= ">$link\n";
          } else {
            $output .= "\t$link<br />\n";
          }
        }
      }

      $args = array(
        'show_option_all'    => '',
        'show_option_none'   => __('No categories'),
        'orderby'            => 'date',
        'order'              => 'DESC',
        'style'              => 'list',
        'show_count'         => 0,
        'hide_empty'         => 1,
        'use_desc_for_title' => 0,
        'child_of'           => 0,
        'feed'               => '',
        'feed_type'          => '',
        'feed_image'         => '',
        'exclude'            => '',
        'exclude_tree'       => '',
        'include'            => '',
        'hierarchical'       => false,
        'title_li'           => '',
        'number'             => NULL,
        'echo'               => 1,
        'depth'              => 0,
        'current_category'   => get_queried_object_id(),
        'pad_counts'         => 0,
        'taxonomy'           => 'category',
        'walker'             => new Custom_Walker_Category(),
        'hide_title_if_empty' => false,
        'separator'          => '',
      );
      echo '<ul>';
      wp_list_categories($args);
      echo '</ul>';
      ?>
    </div>
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
