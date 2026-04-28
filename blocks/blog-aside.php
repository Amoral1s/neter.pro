<aside class="blog-aside">
  <div class="blog-aside__authors">
    <b class="mini-title">Другие авторы</b>
    <div class="blog-aside__authors-wrap">
      <?php
        $excluded_author_id = 0;
        $excluded_author_name = '';

        if (is_author()) {
          $excluded_author_id = (int) get_queried_object_id();
        } elseif (is_single()) {
          $excluded_author_id = (int) get_post_field('post_author', get_queried_object_id());
          $excluded_author_name = trim(wp_strip_all_tags((string) get_field('author_name', get_queried_object_id())));
        }

        $authors = get_users(array(
          'role__in' => array('author', 'editor'),
          'exclude' => $excluded_author_id ? array($excluded_author_id) : array(),
          'orderby' => 'display_name',
          'order' => 'ASC',
        ));

        $authors = array_filter($authors, function($author) {
          return !in_array('administrator', (array) $author->roles, true);
        });

        $post_types = array('post');
        if (post_type_exists('blog')) {
          $post_types[] = 'blog';
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
      ?>
      <?php foreach ($authors as $author) : ?>
        <?php
          $user_id = 'user_' . $author->ID;
          $author_name = get_field('author_name', $user_id) ?: $author->display_name;
          $author_avatar = get_field('author_avatar', $user_id);
          $author_place = get_field('author_place', $user_id);
          $avatar_url = get_template_directory_uri() . '/img/admin.jpg';
          $posts_count = $count_author_publications($author->ID, $post_types);

          if ($excluded_author_name && trim(wp_strip_all_tags((string) $author_name)) === $excluded_author_name) {
            continue;
          }

          if (is_array($author_avatar) && !empty($author_avatar['url'])) {
            $avatar_url = $author_avatar['url'];
          } elseif (is_numeric($author_avatar)) {
            $avatar_url = wp_get_attachment_image_url($author_avatar, 'thumbnail') ?: $avatar_url;
          } elseif (!empty($author_avatar)) {
            $avatar_url = $author_avatar;
          }
        ?>
        <a href="<?php echo esc_url(get_author_posts_url($author->ID)); ?>" class="blog-aside__author">
          <div class="avatar">
            <img src="<?php echo esc_url($avatar_url); ?>" alt="<?php echo esc_attr($author_name); ?>">
          </div>
          <div class="meta">
            <b class="name"><?php echo esc_html($author_name); ?></b>
            <?php if ($author_place) : ?>
              <p class="place"><?php echo esc_html($author_place); ?></p>
            <?php endif; ?>
            <span><?php echo esc_html($posts_count . ' ' . $publications_word($posts_count)); ?></span>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="blog-aside__categories">
    <b class="mini-title">Популярные категории</b>
    <div class="blog-aside__cetegories-wrap">
      <?php if (have_rows('cat_row', 'options')) : while(have_rows('cat_row', 'options')) : the_row(); ?>
        <a href="<?php echo get_sub_field('link'); ?>" class="item">
          <img src="<?php echo get_sub_field('img'); ?>" alt="<?php echo get_sub_field('title'); ?>">
          <b><?php echo get_sub_field('title'); ?></b>
          <div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path d="M17 7L6 18" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round"/>
              <path d="M11 6H17C17.4714 6 17.7071 6 17.8536 6.14645C18 6.29289 18 6.5286 18 7V13" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
        </a>
      <?php endwhile; endif; ?>
    </div>
  </div>
</aside>
