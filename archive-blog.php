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
  <link itemprop="image" href="<?php echo get_template_directory_uri(); ?>/img/logo-dark.svg">
	<link itemprop="url" href="<?php echo get_permalink(); ?>">
	<meta itemprop="description" content="<?php echo get_the_archive_title(); ?>">
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
      'taxonomy'           => 'blog-category',
      'walker'             => new Custom_Walker_Category(),
      'hide_title_if_empty' => false,
      'separator'          => '',
    );
    echo '<ul>'; ?>
    <li class="cat-item">
      <a href="/projects">Наши проекты</a>
    </li>
    <li class="cat-item">
      <a href="/news">Новости компании</a>
    </li>
    <?php
    wp_list_categories($args);
    echo '</ul>';
    ?>
  </div>
  <div class="blog__row">
    <main class="blog__main">
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
                    <meta itemprop="description" content="<?php echo get_the_title(); ?>">
                </a>
            <?php endwhile;
        endif;
        ?>
      </div>
    </main>
    <?php get_template_part('blocks/popular-aside'); ?>
  </div>
  <?php
    if (function_exists('wp_pagenavi')) {
        wp_pagenavi();
    }
  ?>
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
