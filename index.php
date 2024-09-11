<?php get_header(); ?>

<?php if (get_field('offer_title', 'options')) : ?>
<section class="offer" style="background-color: #0A3141; color: #fff; position: relative;">
  <?php 
    $offer_bg_video = get_field('offer_bg_video', 'options');
    $offer_bg_image = get_field('offer_bg', 'options');
  ?>

  <div class="offer-bg-image" style="background-image: url('<?php echo $offer_bg_image; ?>'); position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-size: cover; background-position: center;"></div>

  <?php if ($offer_bg_video): ?>
    <!-- Видеофон -->
    <video class="offer-bg-video" autoplay loop muted playsinline style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
      <source src="<?php echo $offer_bg_video; ?>" type="video/mp4">
    </video>

    <!-- Затемняющий слой для улучшения читаемости текста -->
    <div class="offer-bg-overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(10, 49, 65, 0.7); z-index: 1; display: block;"></div>
  <?php endif; ?>

  <div class="container" style="position: relative; z-index: 2;">
    <div class="wrap">
      <h1 style="color: #fff"><?php echo get_field('offer_title', 'options') ?></h1>
      <p style="color: #fff"><?php echo get_field('offer_subtitle', 'options'); ?></p>
      <div class="btns">
        <div class="button callback">
          Оставить заявку
        </div>
        <div target="blank" class="button button-transparent call-catalog">
          Скачать каталог
        </div>
      </div>
      <div class="russia">
        <svg xmlns="http://www.w3.org/2000/svg" width="148" height="44" viewBox="0 0 148 44" fill="none">
          <g opacity="0.68" clip-path="url(#clip0_87_116)">
          <path d="M22.2933 10.4086C22.2933 8.04284 21.1422 6.19026 17.7716 6.19026H6.18746V20.4234H9.40051V15.416H16.8186C18.4844 15.416 18.9211 15.8888 18.9211 17.5445V20.4234H22.1342V17.0329C22.1342 15.3416 21.5306 14.3494 20.1892 14.0114C21.5836 13.5432 22.2917 12.2022 22.2917 10.4086H22.2933ZM17.3349 12.4193H9.40207V9.18695H17.3349C18.525 9.18695 19.0802 9.81791 19.0802 10.7636C19.0802 11.7093 18.6045 12.4193 17.3349 12.4193ZM146.571 23.5766H147.761V37.8097H144.548V27.7159L137.924 37.8097H134.235V23.5766H137.448V33.317L142.288 25.8633C143.517 23.9704 144.589 23.5766 146.573 23.5766H146.571ZM83.8575 20.4218V17.3864C85.1661 17.3864 85.4843 16.5973 85.7619 13.9556L86.6354 6.18871H98.1384V20.4218H94.9254V9.18695H89.3852L88.8175 14.6284C88.3418 19.3196 87.0721 20.5815 83.8591 20.4249L83.8575 20.4218ZM0 44H28.3232V0H0V44ZM3.09451 3.07575H25.2287V40.9258H3.09451V3.07575ZM18.9211 23.5782H22.1342V37.8113H11.8602C7.73472 37.8113 6.18746 36.2734 6.18746 32.1729V23.5782H9.40051V32.252C9.40051 34.0658 10.1149 34.8146 11.7807 34.8146H18.9211V23.5782ZM104.365 15.6532H111.465V20.4234H114.678V6.19026H106.427C102.381 6.19026 101.15 7.29406 101.15 11.4333V20.4234H104.363V15.6532H104.365ZM106.427 9.18695H111.465V12.6952H104.365V11.4333C104.365 9.81636 104.563 9.1854 106.427 9.1854V9.18695ZM68.1073 15.1803V11.4349C68.1073 7.33437 69.2584 6.19181 73.3823 6.19181H81.7924V9.1885H73.2248C71.559 9.1885 71.3204 9.46445 71.3204 11.2783V11.7511H79.4528V14.7075H71.3204V15.3385C71.3204 17.1523 71.559 17.4282 73.2248 17.4282H81.9125V20.4249H73.3839C69.2584 20.4249 68.1089 19.2421 68.1089 15.1819L68.1073 15.1803ZM142.722 6.19026H139.192C135.106 6.19026 133.917 7.33437 133.917 11.4333V15.1788C133.917 19.2405 135.503 20.4218 139.59 20.4218H142.327C146.453 20.4218 148 19.239 148 15.1788V11.4333C148 7.33282 146.849 6.19026 142.725 6.19026H142.722ZM144.784 15.1803C144.784 16.9942 144.388 17.4282 142.722 17.4282H139.192C137.526 17.4282 137.13 16.9942 137.13 15.1803V11.4349C137.13 9.62103 137.526 9.18695 139.192 9.18695H142.722C144.388 9.18695 144.784 9.62103 144.784 11.4349V15.1803ZM89.7642 23.5782H98.5705V25.3517C98.5705 26.7718 98.4519 27.9546 98.1338 29.0181H95.3964V26.5733H89.7642C88.0984 26.5733 87.7023 27.0074 87.7023 28.8212V32.5667C87.7023 34.3805 88.0984 34.8146 89.7642 34.8146H98.5705V37.8113H89.7642C85.6777 37.8113 84.4892 36.6284 84.4892 32.5682V28.8228C84.4892 24.7223 85.6793 23.5797 89.7642 23.5797V23.5782ZM64.4965 6.19026H52.7939L52.0795 13.4053C51.7223 16.836 51.2061 17.3879 50.2546 17.3879H50.0565V21.7644H53.1105L53.229 19.9505H62.6701L62.7886 21.7644H65.8426V17.3492H64.4934V6.19026H64.4965ZM55.6185 9.18695H61.2835V16.9942H54.4113C54.8512 16.2314 55.0352 15.1679 55.1756 13.8006L55.6185 9.18695ZM76.9526 23.5782H73.1453C69.0588 23.5782 67.8702 24.7223 67.8702 28.8212V32.5667C67.8702 36.6284 69.0603 37.8097 73.1453 37.8097H76.9526C81.0781 37.8097 82.2276 36.6269 82.2276 32.5667V28.8212C82.2276 24.7207 81.0765 23.5782 76.9526 23.5782ZM79.0145 32.5682C79.0145 34.3821 78.6184 34.8162 76.9526 34.8162H73.1453C71.4795 34.8162 71.0833 34.3821 71.0833 32.5682V28.8228C71.0833 27.0089 71.4795 26.5749 73.1453 26.5749H76.9526C78.6184 26.5749 79.0145 27.0089 79.0145 28.8228V32.5682ZM106.107 23.5782H114.952V25.3517C114.952 26.7718 114.834 27.9546 114.516 29.0181H111.778V26.5733H106.106C104.44 26.5733 104.044 27.0074 104.044 28.8212V32.5667C104.044 34.3805 104.44 34.8146 106.106 34.8146H114.951V37.8113H106.106C102.019 37.8113 100.831 36.6284 100.831 32.5682V28.8228C100.831 24.7223 102.021 23.5797 106.106 23.5797L106.107 23.5782ZM45.9809 30.2893C46.7343 29.832 47.3598 28.8615 47.3598 27.3624C47.3598 25.4308 46.2492 23.5782 42.9566 23.5782H34.5465V37.8113H43.2733C46.4473 37.8113 47.993 36.1943 47.993 33.5527C47.993 31.7761 46.9667 30.7296 45.9794 30.2893H45.9809ZM44.1467 27.8352C44.1467 28.7034 43.71 29.1762 42.5994 29.1762H37.7596V26.6136H42.5994C43.71 26.6136 44.1467 27.0074 44.1467 27.8352ZM43.3138 34.8146H37.7596V32.0551H43.3138C44.3853 32.0551 44.7815 32.5682 44.7815 33.3961C44.7815 34.2239 44.3853 34.8162 43.3138 34.8162V34.8146ZM128.007 6.19026H131.22V20.4234H128.007V14.7059H120.907V20.4234H117.694V6.19026H120.907V11.7108H128.007V6.19026ZM39.3505 6.19026H48.1178V7.96378C48.1178 9.38383 47.9992 10.5667 47.6811 11.6302H44.9437V9.1854H39.3505C37.6847 9.1854 37.2886 9.61948 37.2886 11.4333V15.1788C37.2886 16.9926 37.6847 17.4267 39.3505 17.4267H48.1178V20.4234H39.3505C35.264 20.4234 34.0755 19.2405 34.0755 15.1803V11.4349C34.0755 7.33437 35.2656 6.19181 39.3505 6.19181V6.19026ZM130.03 23.5782H131.22V37.8113H128.007V27.7174L121.383 37.8113H117.694V23.5782H120.907V33.3186L125.747 25.8648C126.976 23.972 128.048 23.5782 130.032 23.5782H130.03ZM60.8889 23.5782H51.5274V26.378L53.1932 26.6152V37.8128H56.4062V34.1464H60.8889C64.5777 34.1464 65.8473 32.2938 65.8473 29.415V28.3112C65.8473 25.5904 64.6572 23.5797 60.8889 23.5797V23.5782ZM62.6732 29.2956C62.6732 30.6366 62.1569 31.1482 60.8889 31.1482H56.4062V26.5749H60.8889C62.1585 26.5749 62.6732 27.2058 62.6732 28.4275V29.2956Z" fill="white" fill-opacity="0.5"/>
          </g>
          <defs>
          <clipPath id="clip0_87_116">
          <rect width="148" height="44" fill="white"/>
          </clipPath>
          </defs>
        </svg>
      </div>
    </div>
  </div>

</section>
<?php endif; ?>

<?php if (get_field('cats_title','options')) : ?>
<section class="main-cats">
  <div class="container">
    <h2 class="title sub"><?php echo get_field('cats_title','options') ?></h2>
    <div class="subtitle">
      <span><?php echo get_field('cats_subtitle', 'options'); ?></span>
      <div class="arrows">
        <div class="arr-prev arr">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path d="M14.9999 6L9.70703 11.2929C9.37369 11.6262 9.20703 11.7929 9.20703 12C9.20703 12.2071 9.37369 12.3738 9.70703 12.7071L14.9999 18" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
        <div class="arr-next arr">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path d="M9.00008 6L14.293 11.2929C14.6263 11.6262 14.793 11.7929 14.793 12C14.793 12.2071 14.6263 12.3738 14.293 12.7071L9.00008 18" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
      </div>
    </div>
    <div class="wrap swiper">
      <div class="swiper-wrapper">
        <?php if (have_rows('cats','options')) : while(have_rows('cats','options')) : the_row(); ?>
          <?php if (get_sub_field('view') == 'double') : ?>
            <div class="item double swiper-slide">
              <?php if (have_rows('double')) : while(have_rows('double')) : the_row(); ?>
                <a href="<?php echo get_sub_field('link'); ?>" class="item-part" style="background-image: url(<?php echo get_sub_field('img'); ?>);">
                  <span><?php echo get_sub_field('subtitle'); ?></span>
                  <b <?php if (get_sub_field('img_place') == 'left') { echo 'class="left"'; } ?>>
                    <?php echo the_sub_field('title'); ?>
                  </b>
                </a>
              <?php endwhile; endif; ?>
            </div>
          <?php else : ?>
            <?php if (have_rows('onest')) : while(have_rows('onest')) : the_row(); ?>
            <a href="<?php echo get_sub_field('link'); ?>" class="item onest swiper-slide" style="background-image: url(<?php echo get_sub_field('img'); ?>);">
              <span><?php echo get_sub_field('subtitle'); ?></span>
              <b><?php the_sub_field('title'); ?></b>
              <p>
                <?php echo get_sub_field('content'); ?>
              </p>
            </a>
            <?php endwhile; endif; ?>
          <?php endif; ?>
        <?php endwhile; endif; ?>
      </div>
    </div>
    <div class="dots"></div>
  </div>
</section>
<?php endif; ?>

<?php if (get_field('features_title','options')) : ?>
<section class="features">
  <div class="container">
    <h2 class="title sub"><?php echo get_field('features_title','options') ?></h2>
    <p class="subtitle"><?php echo get_field('features_subtitle','options'); ?></p>
    <div class="wrap">
    <?php if (have_rows('features','options')) : while(have_rows('features','options')) : the_row(); ?>
      <div class="item">
        <img src="<?php echo get_sub_field('img'); ?>" alt="<?php echo get_sub_field('title'); ?>">
        <b><?php echo get_sub_field('title'); ?></b>
        <p><?php echo get_sub_field('content'); ?></p>
      </div>
    <?php endwhile; endif; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (get_field('our_title','options')) : ?>
<section class="our">
  <div class="container">
    <div class="wrap">
      <h2 class="title"><?php echo get_field('our_title','options') ?></h2>
      <p class="subtitle"><?php echo get_field('our_subtitle','options'); ?></p>
      <div class="our-feat">
        <?php if (have_rows('our_feat','options')) : while(have_rows('our_feat','options')) : the_row(); ?>
          <div class="item">
            <img src="<?php echo get_sub_field('img'); ?>" alt="<?php echo get_sub_field('text'); ?>">
            <b><?php echo get_sub_field('text'); ?></b>
          </div>
        <?php endwhile; endif; ?>
      </div>
      <div class="our-row">
        <div class="swiper">
          <div class="swiper-wrapper our-row-wrap">
            <?php if (have_rows('our_cats', 'options')) : while(have_rows('our_cats', 'options')) : the_row(); ?>
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
      <img src="<?php echo get_field('our_bg_img','options') ?>" alt="<?php echo get_field('our_title','options') ?>" class="our-bg">
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (get_field('consult_banner_title','options')) : ?>
<section class="consult-banner">
  <div class="container">
    <div class="wrap">
      <div class="left">
        <img src="<?php echo get_field('consult_banner_img','options') ?>" alt="<?php echo get_field('consult_banner_title','options') ?>">
      </div>
      <div class="right">
        <b class="title sub"><?php echo get_field('consult_banner_title','options') ?></b>
        <p class="subtitle"><?php echo get_field('consult_banner_subtitle','options') ?></p>
        <div class="form form-white">
          <?php echo do_shortcode('[contact-form-7 id="dda6cc4" title="Баннер консультации"]'); ?>
        </div>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

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

<?php if (get_field('projects_title', 'options')) : ?>
<section class="projects-row">
  <div class="container">
    <div class="title-row">
      <h2 class="title"><?php echo get_field('projects_title', 'options') ?></h2>
      <p class="subtitle"><?php echo get_field('projects_subtitle', 'options') ?></p>
    </div>
    <div class="wrap">
      <div class="item first">
        <span><?php echo get_field('projects_years', 'options'); ?> лет опыта</span>
        <div class="num"><?php echo get_field('projects_years', 'options'); ?></div>
      </div>
      <?php
          $count_args = array(
            'post_type'      => 'projects',
            'posts_per_page' => -1
          );
          $count_query = new WP_Query( $count_args );
          $count_of_projects = 0;
          if ( $count_query->have_posts() ) {
            while ( $count_query->have_posts() ) {
              $count_query->the_post(); 
              $count_of_projects++;
            } 
          }
          wp_reset_postdata();
          //main query
          $args = array(
            'post_type'      => 'projects',
            'posts_per_page' => 3
          );
          $query = new WP_Query( $args );
          $post_index = 1;
          if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
              $query->the_post();
      ?>
        <a href="<?php the_permalink(); ?>" class="item <?php if ($post_index == 2) { echo 'full'; } ?>" style="background-image: url();">
          <?php
            // Получаем ID поста
            $post_id = get_the_ID();
            // Получаем заголовок поста для использования в атрибуте alt
            $alt_text = get_the_title($post_id);
            // Параметры для вывода изображения
            $thumbnail_attributes = array(
                'class' => 'img', // Ваш кастомный класс
                'alt'   => $alt_text, // Атрибут alt с заголовком поста
            );
            // Вывод изображения с указанными параметрами
            echo get_the_post_thumbnail($post_id, 'large', $thumbnail_attributes);
          ?>
          <?php if ($post_index == 2) : ?>
          <div class="meta">
            <b><?php the_title(); ?></b>
            <p><?php echo get_field('subtitle'); ?></p>
          </div>
          <?php endif; ?>
        </a>
      <?php $post_index++; } }  wp_reset_postdata(); ?>
      <a href="<?php echo get_field('project_link', 'options'); ?>" class="item last">
        <div class="last-row">
          <div class="count">
            <?php echo $count_of_projects; ?> +
          </div>
          <div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path d="M17 7L6 18" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round"/>
              <path d="M11 6H17C17.4714 6 17.7071 6 17.8536 6.14645C18 6.29289 18 6.5286 18 7V13" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
        </div>
        <div class="moar">
          Смотреть все проекты
        </div>
      </a>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (get_field('order_title', 'options')) : ?>
<section class="order">
  <div class="container">
    <div class="row">
      <div class="left">
        <h2 class="title sub"><?php echo get_field('order_title', 'options') ?></h2>
        <p class="subtitle"><?php echo get_field('order_title', 'options') ?></p>
      </div>
      <div class="right">
        <div class="icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36" fill="none">
            <path d="M12.5634 4.5C12.2426 4.6199 11.927 4.75068 11.6172 4.89189M31.0764 24.4516C31.2297 24.1198 31.371 23.7813 31.4998 23.4368M27.748 29.0471C28.0056 28.8066 28.2546 28.5571 28.4943 28.299M22.9032 32.0584C23.1943 31.9486 23.481 31.83 23.763 31.7026M18.2338 32.9909C17.8875 33.0029 17.5387 33.0029 17.1922 32.9909M11.6808 31.7106C11.952 31.8325 12.2276 31.9467 12.5072 32.0524M7.00866 28.3812C7.2137 28.5985 7.42527 28.8096 7.64308 29.0142M3.94888 23.4968C4.0612 23.7933 4.18284 24.0854 4.31341 24.3725M3.00729 18.7579C2.99756 18.4458 2.99759 18.1317 3.00729 17.8191M3.93801 13.1057C4.04835 12.8125 4.16779 12.5237 4.29598 12.2397M6.98387 8.21884C7.20086 7.98771 7.42521 7.76359 7.65658 7.54686" stroke="#2CB4C2" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M20.25 18C20.25 19.2426 19.2426 20.25 18 20.25C16.7574 20.25 15.75 19.2426 15.75 18C15.75 16.7574 16.7574 15.75 18 15.75M20.25 18C20.25 16.7574 19.2426 15.75 18 15.75M20.25 18H24M18 15.75V9" stroke="#2CB4C2" stroke-width="2.25" stroke-linecap="round"/>
            <path d="M33 18.0005C33 9.71621 26.2842 3.00049 18 3.00049" stroke="#2CB4C2" stroke-width="2.25" stroke-linecap="round"/>
          </svg>
        </div>
        <div class="meta">
          <b><?php echo get_field('order_time', 'options'); ?></b>
          <p>Минимальный срок изготовления</p>
        </div>
      </div>
    </div>
    <div class="wrap">
      <div class="swiper">
        <div class="swiper-wrapper">
          <?php if (have_rows('order_feat','options')) : while(have_rows('order_feat','options')) : the_row(); ?>
          <div class="item swiper-slide">
            <div class="icon">
              <img src="<?php echo get_sub_field('img'); ?>" alt="<?php echo get_sub_field('title'); ?>">
            </div>
            <b><?php echo get_sub_field('title'); ?></b>
          </div>
          <?php endwhile; endif; ?>
        </div>
      </div>
      <div class="swiper-pagination dots"></div>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (get_field('tech_title','options')) : ?>
<section class="tech-banner">
  <div class="container">
    <div class="wrap">
      <div class="left">
        <b class="title sub"><?php echo get_field('tech_title','options') ?></b>
        <p class="subtitle"><?php echo get_field('tech_subtitle', 'options'); ?></p>
        <div class="form form-white">
          <?php echo do_shortcode('[contact-form-7 id="b534b37" title="Баннер изготовления по вашему ТЗ"]'); ?>
        </div>
      </div>
      <div class="right">
        <img src="<?php echo get_field('tech_bg','options'); ?>" alt="<?php echo get_field('tech_title','options') ?>">
      </div>
    </div>
   
  </div>
</section>
<?php endif; ?>

<?php if (get_field('about_title', 'options')) : ?>
<section class="about bg-dark">
  <div class="container">
    <div class="about-top">
      <div class="left">
        <h2 class="title sub"><?php echo get_field('about_title', 'options') ?></h2>
        <div class="content">
          <?php echo get_field('about_content', 'options'); ?>
        </div>
      </div>
      <div class="right">
        <div class="image">
          <img src="<?php echo get_field('about_img', 'options'); ?>" alt="<?php echo get_field('about_title', 'options'); ?>">
        </div>
        <div class="meta">
          <div class="meta-projects">
            <b><?php echo get_field('about_count', 'options'); ?></b>
            <p>Реализованных проектов</p>
          </div>
          <div class="meta-team">
            <div class="meta-team-top">
              <?php $about_avatars = get_field('about_avatars', 'options'); if ($about_avatars) : ?>
              <?php foreach( $about_avatars as $avatar ): ?>
                <div class="item">
                  <?php 
                    echo '<img src="' . esc_url($avatar['url']) . '" alt="Специалист">';
                  ?>
                </div>
              <?php endforeach; endif; ?>
              <div class="item num">
                <?php echo get_field('about_persons','options'); ?>+
              </div>
            </div>
            <b><?php echo get_field('about_persons','options'); ?> специалистов</b>
          </div>
        </div>
      </div>
    </div>
    <div class="about-feat">
      <?php if (have_rows('about_feat','options')) : while(have_rows('about_feat','options')) : the_row(); ?>
        <div class="item">
          <img src="<?php echo get_sub_field('img'); ?>" alt="<?php echo get_sub_field('title'); ?>">
          <p><?php echo get_sub_field('title'); ?></p>
        </div>
      <?php endwhile; endif; ?>
    </div>
    <div class="about-video">
      <img src="<?php echo get_field('about_video_img', 'options'); ?>" alt="Видео о компании" class="view">
      <div class="play">
        <svg xmlns="http://www.w3.org/2000/svg" width="134" height="134" viewBox="0 0 134 134" fill="none">
          <g filter="url(#filter0_b_131_77)">
          <rect width="134" height="134" rx="67" fill="#2CB4C2" fill-opacity="0.2"/>
          <path d="M90.5 64.4019C92.5 65.5566 92.5 68.4434 90.5 69.5981L57.5 88.6506C55.5 89.8053 53 88.362 53 86.0526L53 47.9474C53 45.638 55.5 44.1947 57.5 45.3494L90.5 64.4019Z" fill="white"/>
          </g>
          <defs>
          <filter id="filter0_b_131_77" x="-50" y="-50" width="234" height="234" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
          <feFlood flood-opacity="0" result="BackgroundImageFix"/>
          <feGaussianBlur in="BackgroundImageFix" stdDeviation="25"/>
          <feComposite in2="SourceAlpha" operator="in" result="effect1_backgroundBlur_131_77"/>
          <feBlend mode="normal" in="SourceGraphic" in2="effect1_backgroundBlur_131_77" result="shape"/>
          </filter>
          </defs>
        </svg>
      </div>
      <iframe data-link="<?php echo get_field('about_video', 'options'); ?>?rel=0" src="" frameborder="0"></iframe>
    </div>
    <div class="about-circle">
      <h3 class="title center"><?php echo get_field('about_circle_title', 'options'); ?></h3>
      <div class="wrap">
        <div class="circle-bg">
          <img class="bg" src="<?php echo get_template_directory_uri(); ?>/img/bg-about.svg" alt="Круги">
          <img class="image" src="<?php echo get_field('about_circle_bg', 'options'); ?>" alt="<?php echo get_field('about_circle_title', 'options'); ?>">
        </div>
        <?php if (have_rows('about_circle', 'options')) : while(have_rows('about_circle', 'options')) : the_row(); ?>
          <div class="item">
            <div class="icon"><img src="<?php echo get_sub_field('img'); ?>" alt="<?php echo get_sub_field('title'); ?>"></div>
            <div class="meta">
              <b><?php echo get_sub_field('title'); ?></b>
              <span><?php echo get_sub_field('text'); ?></span>
            </div>
          </div>
        <?php endwhile; endif; ?>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (get_field('faq_title', 'options')) : ?>
<section itemscope itemtype="https://schema.org/FAQPage" class="faq">
  <div class="container">
    <div class="wrap">
      <div class="left">
        <h2 class="title sub"><?php echo get_field('faq_title', 'options') ?></h2>
        <p class="subtitle"><?php echo get_field('faq_subtitle', 'options') ?></p>
        <div class="btns">
          <div class="button call-faq">
            Задать вопрос
          </div>
          <a href="<?php echo get_field('faq_link', 'options'); ?>">
            <span>Смотреть все</span>
            <div class="icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M17 7L6 18" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round"/>
                <path d="M11 6H17C17.4714 6 17.7071 6 17.8536 6.14645C18 6.29289 18 6.5286 18 7V13" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </div>
          </a>
        </div>
      </div>
      <div class="right">
        <?php if (have_rows('faq','options')) : while(have_rows('faq','options')) : the_row(); ?>
          <div itemscope itemprop="mainEntity" itemtype="https://schema.org/Question" class="item">
            <h3 itemprop="name"  class="item-title">
              <?php echo get_sub_field('title'); ?>
              <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <path d="M18 9.00008L12.7071 14.293C12.3738 14.6263 12.2071 14.793 12 14.793C11.7929 14.793 11.6262 14.6263 11.2929 14.293L6 9.00008" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </div>
            </h3>
            <div itemscope itemprop="acceptedAnswer" class="item-content content">
              <?php echo get_sub_field('text'); ?>
            </div>
          </div>
        <?php endwhile; endif; ?>
      </div>
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

<?php if (get_field('new_title', 'options')) : ?>
<section class="news">
  <div class="container">
    <h2 class="title"><?php echo get_field('new_title', 'options'); ?></h2>
    <div class="wrap slider-wrap">
      <div class="arr arr-prev">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
          <path d="M14.9999 6L9.70703 11.2929C9.37369 11.6262 9.20703 11.7929 9.20703 12C9.20703 12.2071 9.37369 12.3738 9.70703 12.7071L14.9999 18" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
      <div class="swiper">
        <div class="swiper-wrapper">
          <?php
            $args = array(
              'post_type'      => 'post',
              'posts_per_page' => 10
            );
            $query = new WP_Query( $args );

            if ( $query->have_posts() ) {
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
            <div class="meta">
              <b><?php the_title(); ?></b>
              <div class="date"><?php echo get_the_date('d.m.Y') ?></div>
            </div>
          </a>
          <?php } }  wp_reset_postdata(); ?>
        </div>
      </div>
      <div class="arr arr-next">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
          <path d="M9.00008 6L14.293 11.2929C14.6263 11.6262 14.793 11.7929 14.793 12C14.793 12.2071 14.6263 12.3738 14.293 12.7071L9.00008 18" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (get_field('seo_title', 'options')) : ?>
<section class="seo">
  <div class="container">
    <h2 class="title"><?php echo get_field('seo_title', 'options') ?></h2>
    <div class="content">
      <?php echo get_field('seo_content', 'options'); ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (get_field('map_title', 'options')) : ?>
<section class="map">
  <div class="container">
    <div class="wrap">
      <b class="title"><?php echo get_field('map_title', 'options'); ?></b>
      <div class="item">
        <p>Производство</p>
        <address><?php echo get_field('addr_prod', 'options'); ?></address>
      </div>
      <div class="item">
        <p>Офис</p>
        <address><?php echo get_field('addr_office', 'options'); ?></address>
      </div>
      <div class="item-last">
        <div class="row">
          <a target="blank" href="tel:<?php echo get_field('phone','options'); ?>" class="phone">
            <?php echo get_field('phone','options'); ?>
          </a>
          <a target="blank" href="mailto:<?php echo get_field('email','options'); ?>" class="email">
            <?php echo get_field('email','options'); ?>
          </a>
        </div>
        <span><?php echo get_field('work_time', 'options'); ?></span>
      </div>
      <div class="button callback">
        Заказать звонок
      </div>
    </div>
  </div>
  <div id="map"></div>
</section>
<?php endif; ?>

<?php get_footer(); ?>

<!-- Schema org -->
<div itemscope itemtype="http://schema.org/Organization" style="display: none;">
  <span itemprop="name">ООО «Источники питания»</span>
  <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
    <span itemprop="streetAddress">ул. Сибгата Хакима, д. 51, помещ. 1029, офис 2</span>,
    <span itemprop="addressLocality">г. Казань</span>,
    <span itemprop="postalCode">421001</span>
  </div>
  Телефон: <span itemprop="telephone"><?php the_field('phone','options'); ?></span>
</div>
<div itemscope itemtype="http://schema.org/LocalBusiness" style="display: none;">
  <span itemprop="name">ООО «Источники питания»</span>
  <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
    <span itemprop="streetAddress">ул. Сибгата Хакима, д. 51, помещ. 1029, офис 2</span>,
    <span itemprop="addressLocality">г. Казань</span>,
    <span itemprop="postalCode">421001</span>
  </div>
  Телефон: <span itemprop="telephone"><?php the_field('phone','options'); ?></span><br>
  Часы работы: <span itemprop="openingHours">09:00 - 18:00</span><br>
  <span itemprop="description">Аккумуляторы от производителя</span>
</div>
<!-- Schema end -->