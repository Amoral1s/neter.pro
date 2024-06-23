<div class="production content-production">
  <div class="production-wrap video-data" data-src="<?php the_field('ssylka_na_youtube_video'); ?>">
    <?php
      $team_img = get_field('prevyu_video'); // Получаем массив данных из поля ACF
      if ($team_img) {
          if ($team_img['alt']) {
            echo '<img src="' . esc_url($team_img['url']) . '" alt="' . esc_attr($team_img['alt']) . '">'; // Выводим изображение
          } else {
            echo '<img src="' . esc_url($team_img['url']) . '" alt="' . esc_attr(get_the_title($post->ID)) . '">'; // Выводим изображение
          }
      }
    ?>
    <div class="icon">
      <svg xmlns="http://www.w3.org/2000/svg" width="42" height="50" viewBox="0 0 42 50" fill="none">
        <path d="M42 25L-2.28386e-06 49.2487L-1.63974e-07 0.751288L42 25Z" fill="white"/>
      </svg>
    </div>
  </div>
</div>