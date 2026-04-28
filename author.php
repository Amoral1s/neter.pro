<?php get_header(); ?>

<?php
  // Получаем URL профиля автора
  $author_id = get_queried_object_id() ?: get_the_author_meta('ID');
  $author_url = get_author_posts_url($author_id);
  $user_id = 'user_' . $author_id;
  $author_name = get_field('author_name', $user_id) ?: get_the_author_meta('display_name', $author_id) ?: 'Neter.pro';
  $author_avatar = get_field('author_avatar', $user_id);
  $author_avatar_url = get_template_directory_uri() . '/img/admin.jpg';
  $author_position = get_field('author_place', $user_id) ?: 'Автор';
  $author_post_types = array('post');

  if (is_array($author_avatar) && !empty($author_avatar['url'])) {
    $author_avatar_url = $author_avatar['url'];
  } elseif (is_numeric($author_avatar)) {
    $author_avatar_url = wp_get_attachment_image_url($author_avatar, 'thumbnail') ?: $author_avatar_url;
  } elseif (!empty($author_avatar)) {
    $author_avatar_url = $author_avatar;
  }

  if (post_type_exists('blog')) {
    $author_post_types[] = 'blog';
  }

  $count_author_publications = function($author_id, $post_types) {
    $count = 0;

    foreach ($post_types as $post_type) {
      $count += count_user_posts($author_id, $post_type, true);
    }

    return $count;
  };

  $publications_word = function($count) {
    $count = absint($count);
    $last = $count % 10;
    $last_two = $count % 100;

    if ($last === 1 && $last_two !== 11) {
      return 'публикация';
    }

    if ($last >= 2 && $last <= 4 && ($last_two < 12 || $last_two > 14)) {
      return 'публикации';
    }

    return 'публикаций';
  };

  $author_posts_count = $count_author_publications($author_id, $author_post_types);
?>

<div class="page-top">
  <div class="container">
    <p class="breadcrumbs">
      <span>
        <span><a href="<?php echo esc_url(home_url('/')); ?>">Главная</a></span>
        <span> / </span>
        <span class="breadcrumb_last" aria-current="page"><?php echo esc_html($author_name); ?></span>
      </span>
    </p>
  </div>
</div>
<section class="author-page">
  <div class="container">
    <div class="wrap">
      <div class="author-page__wrap">
        <div class="author">
          <div class="avatar">
            <img src="<?php echo esc_url($author_avatar_url); ?>" alt="<?php echo esc_attr($author_name); ?>">
          </div>
          <div class="meta">
            <div itemprop="author" class="name">
              <h1 class="page-title"><?php echo esc_html($author_name); ?></h1>
              <span><?php echo esc_html($author_position); ?></span>
              <div class="count"><?php echo esc_html($author_posts_count . ' ' . $publications_word($author_posts_count)); ?></div>
            </div>
            
          </div>
        </div>

        <?php if (get_field('author_text', $user_id)) : ?>
          <div class="author-page__content">
            <h2 class="title">Об авторе</h2>
            <div class="content">
              <?php echo get_field('author_text', $user_id); ?>
            </div>
          </div>
        <?php endif; ?>

        <?php if (have_rows('author_contacts', $user_id)) : ?>
          <div class="author-page__contacts">
            <?php while (have_rows('author_contacts', $user_id)) : the_row(); ?>
              <?php
                $text = get_sub_field('title');
                $link_text = get_sub_field('link_title');
                $link = get_sub_field('link');
              ?>
              <div class="author-page__contacts-item">
                <p><?php echo $text; ?></p>
                <a target="_blank" rel="nofollow" href="<?php echo $link; ?>">
                  <?php echo $link_text; ?>
                </a>
              </div>
            <?php endwhile; ?>
          </div>
        <?php endif; ?>

      </div>
      <?php get_template_part('blocks/blog-aside'); ?>
    </div>
    
    
  </div>
</section>

<?php
  $get_query_page = function($page_var) {
    $raw_page = isset($_GET[$page_var]) ? $_GET[$page_var] : 1;
    $page = is_scalar($raw_page) ? absint(wp_unslash($raw_page)) : 1;

    return max(1, $page);
  };

  $render_pagenavi = function($query, $current_page, $page_var) use ($author_id, $get_query_page) {
    $total_pages = (int) $query->max_num_pages;

    if ($total_pages <= 1) {
      return;
    }

    $page_url = function($page) use ($author_id, $page_var, $get_query_page) {
      $url = get_author_posts_url($author_id);

      foreach (array('blog_page', 'news_page') as $var) {
        if ($var === $page_var || !isset($_GET[$var])) {
          continue;
        }

        $var_page = $get_query_page($var);

        if ($var_page > 1) {
          $url = add_query_arg($var, $var_page, $url);
        }
      }

      if ($page > 1) {
        $url = add_query_arg($page_var, $page, $url);
      }

      return $url;
    };

    $range = 2;
    $pages = array();

    for ($page = 1; $page <= $total_pages; $page++) {
      if ($page === 1 || $page === $total_pages || abs($page - $current_page) <= $range) {
        $pages[] = $page;
      }
    }
?>
<div class="wp-pagenavi" role="navigation">
  <span class="pages"><?php echo esc_html('Страница ' . $current_page . ' из ' . $total_pages); ?></span>
  <?php if ($current_page > 1) : ?>
    <a class="previouspostslink" rel="prev" href="<?php echo esc_url($page_url($current_page - 1)); ?>">Назад</a>
  <?php endif; ?>
  <?php $last_page = 0; ?>
  <?php foreach ($pages as $page) : ?>
    <?php if ($last_page && $page > $last_page + 1) : ?>
      <span class="extend">...</span>
    <?php endif; ?>
    <?php if ($page === $current_page) : ?>
      <span aria-current="page" class="current"><?php echo esc_html($page); ?></span>
    <?php else : ?>
      <a class="page <?php echo $page < $current_page ? 'smaller' : 'larger'; ?>" href="<?php echo esc_url($page_url($page)); ?>"><?php echo esc_html($page); ?></a>
    <?php endif; ?>
    <?php $last_page = $page; ?>
  <?php endforeach; ?>
  <?php if ($current_page < $total_pages) : ?>
    <a class="nextpostslink" rel="next" href="<?php echo esc_url($page_url($current_page + 1)); ?>">Далее</a>
  <?php endif; ?>
</div>
<?php
  };

  $render_author_posts_section = function($post_type, $title, $page_var) use ($author_id, $get_query_page, $render_pagenavi) {
    if (!post_type_exists($post_type)) {
      return;
    }

    $current_section_page = $get_query_page($page_var);

    $author_posts = new WP_Query(array(
      'post_type' => $post_type,
      'post_status' => 'publish',
      'author' => $author_id,
      'posts_per_page' => 6,
      'paged' => $current_section_page,
      'orderby' => 'date',
      'order' => 'DESC',
    ));

    if (!$author_posts->have_posts()) {
      wp_reset_postdata();
      return;
    }
?>
<section class="blog author-blog">
  <div class="container">
    <h2 class="title"><?php echo esc_html($title); ?></h2>
    <div class="blog-wrap">
      <?php while ($author_posts->have_posts()) : $author_posts->the_post(); ?>
        <a itemprop="blogPosts" itemscope itemtype="http://schema.org/BlogPosting" itemprop="url" href="<?php the_permalink(); ?>" class="item">
          <img itemprop="image" src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
          <div class="meta">
            <b><?php the_title(); ?></b>
            <div class="date"><?php echo get_the_date('d M Y') ?></div>
          </div>
          <meta itemprop="description" content="<?php echo get_the_title(); ?>">
        </a>
      <?php endwhile; ?>
    </div>
    <?php $render_pagenavi($author_posts, $current_section_page, $page_var); ?>
  </div>
</section>
<?php
    wp_reset_postdata();
  };

  $render_author_posts_section('blog', 'Публикации автора', 'blog_page');
  $render_author_posts_section('post', 'Новости от автора', 'news_page');
?>

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
