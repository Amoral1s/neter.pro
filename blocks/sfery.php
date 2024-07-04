<section class="product-links">
  <h2 class="title"><?php echo get_field('block_links_title'); ?></h2>
  <?php if (get_field('block_links_toggle') == true) : ?>
    <div class="scroll-wrapper">
      <div class="wrap">
        <?php if (have_rows('sfery_hand')) : while(have_rows('sfery_hand')) : the_row(); ?>
          <a href="<?php echo get_sub_field('ssylka'); ?>" class="item">
            <?php if (get_sub_field('ikonka')) : ?>
            <div class="icon">
              <img src="<?php echo get_sub_field('ikonka'); ?>" alt="<?php echo get_sub_field('imya'); ?>">
            </div>
            <?php endif; ?>
            <p><?php echo get_sub_field('imya'); ?></p>
          </a>
        <?php endwhile; endif; ?>
      </div>
    </div>
  <?php else : ?>
    <div class="scroll-wrapper">
      <div class="wrap">
        <?php 
          $taxonomy_ids = get_field('sfery'); // Получаем массив ID таксономий

          if ($taxonomy_ids) {
              foreach ($taxonomy_ids as $taxonomy_id) {
                  // Получаем данные поля ACF для таксономии
                  $icon = get_field('attr_img', 'term_' . $taxonomy_id);
                  $title = get_field('attr_title', 'term_' . $taxonomy_id);
                  $link = get_term_link($taxonomy_id);

                  // Если заголовок таксономии пустой, используем название таксономии
                  if (empty($title)) {
                      $taxonomy = get_term($taxonomy_id);
                      $title = $taxonomy->name;
                  }

                  // Проверяем, существует ли заголовок, и выводим элемент
                  if ($title) {
                      ?>
                      <a href="<?php echo esc_url($link); ?>" class="item">
                          <?php if ($icon) : ?>
                              <div class="icon">
                                  <img src="<?php echo esc_url($icon); ?>" alt="<?php echo esc_attr($title); ?>">
                              </div>
                          <?php endif; ?>
                          <p><?php echo esc_html($title); ?></p>
                      </a>
                      <?php
                  }
              }
          }
        ?>
      </div>
    </div>
  <?php endif; ?>
</section>