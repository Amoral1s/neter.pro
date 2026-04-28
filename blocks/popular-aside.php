<?php
  $popular_post_types = array('post');

  if (post_type_exists('blog')) {
    $popular_post_types[] = 'blog';
  }

  $popular_args = array(
    'post_type' => $popular_post_types,
    'post_status' => 'publish',
    'posts_per_page' => 6,
    'ignore_sticky_posts' => true,
    'meta_query' => array(
      'relation' => 'OR',
      'views_clause' => array(
        'key' => 'post_views_count',
        'compare' => 'EXISTS',
        'type' => 'NUMERIC',
      ),
      'no_views_clause' => array(
        'key' => 'post_views_count',
        'compare' => 'NOT EXISTS',
      ),
    ),
    'orderby' => array(
      'views_clause' => 'DESC',
      'date' => 'DESC',
    ),
  );

  if (is_category() || is_tax('blog-category')) {
    $current_term = get_queried_object();

    if ($current_term instanceof WP_Term) {
      $popular_args['tax_query'] = array(
        array(
          'taxonomy' => $current_term->taxonomy,
          'field' => 'term_id',
          'terms' => $current_term->term_id,
        ),
      );
    }
  }

  if (is_singular($popular_post_types)) {
    $popular_args['post__not_in'] = array(get_queried_object_id());
  }

  $popular_query = new WP_Query($popular_args);

  if (!$popular_query->have_posts()) {
    wp_reset_postdata();
    return;
  }
?>
<aside class="aside-popular">
  <b class="mini-title">Популярное</b>
  <div class="aside-popular__wrap">
    <?php while ($popular_query->have_posts()) : $popular_query->the_post(); ?>
      <?php
        $post_author_id = (int) get_post_field('post_author', get_the_ID());
        $user_id = 'user_' . $post_author_id;
        $author_name = get_field('author_name', $user_id) ?: get_the_author_meta('display_name', $post_author_id);
        $author_avatar = get_field('author_avatar', $user_id);
        $author_place = get_field('author_place', $user_id);
        $avatar_url = get_template_directory_uri() . '/img/admin.jpg';

        if (is_array($author_avatar) && !empty($author_avatar['url'])) {
          $avatar_url = $author_avatar['url'];
        } elseif (is_numeric($author_avatar)) {
          $avatar_url = wp_get_attachment_image_url($author_avatar, 'thumbnail') ?: $avatar_url;
        } elseif (!empty($author_avatar)) {
          $avatar_url = $author_avatar;
        }
      ?>
      <a href="<?php the_permalink(); ?>" class="aside-popular__item">
        <h2 class="aside-popular__title">
          <?php the_title(); ?>
        </h2>
        <div class="aside-popular__date"><?php echo esc_html(get_the_date('d M Y')); ?></div>
        <div class="bottom">
          <?php if ($post_author_id) : ?>
            <div class="aside-popular__author">
              <span class="avatar">
                <img src="<?php echo esc_url($avatar_url); ?>" alt="<?php echo esc_attr($author_name); ?>">
              </span>
              <span class="meta">
                <b><?php echo esc_html($author_name); ?></b>
                <?php if ($author_place) : ?>
                  <p><?php echo esc_html($author_place); ?></p>
                <?php endif; ?>
              </span>
            </div>
          <?php endif; ?>
          <div class="aside-popular__info">
            <div class="aside-popular__info-item">
              <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <path d="M18.952 8.60633L21.4622 8.45352C19.6629 3.70453 14.497 0.99967 9.4604 2.3445C4.09599 3.77686 0.909631 9.26083 2.34347 14.5933C3.77731 19.9257 9.28839 23.0874 14.6528 21.655C18.6358 20.5915 21.4181 17.2944 22 13.4841" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M12 7.99976L12 11.9998L14 13.9998" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </div>
              ~ <?php echo esc_html(gp_read_time()); ?> мин.
            </div>
            <div class="aside-popular__info-item">
              <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <path d="M2 8C2 8 6.47715 3 12 3C17.5228 3 22 8 22 8" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round"/>
                  <path d="M21.544 13.045C21.848 13.4713 22 13.6845 22 14C22 14.3155 21.848 14.5287 21.544 14.955C20.1779 16.8706 16.6892 21 12 21C7.31078 21 3.8221 16.8706 2.45604 14.955C2.15201 14.5287 2 14.3155 2 14C2 13.6845 2.15201 13.4713 2.45604 13.045C3.8221 11.1294 7.31078 7 12 7C16.6892 7 20.1779 11.1294 21.544 13.045Z" stroke="#2CB4C2" stroke-width="1.5"/>
                  <path d="M15 14C15 12.3431 13.6569 11 12 11C10.3431 11 9 12.3431 9 14C9 15.6569 10.3431 17 12 17C13.6569 17 15 15.6569 15 14Z" stroke="#2CB4C2" stroke-width="1.5"/>
                </svg>
              </div>
              <?php echo esc_html(getPostViews(get_the_ID())); ?>
            </div>
          </div>
        </div>
      </a>
    <?php endwhile; ?>
  </div>
</aside>
<?php wp_reset_postdata(); ?>
