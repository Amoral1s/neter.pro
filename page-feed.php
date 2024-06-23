<?php
/**
 Template Name: Отзывы
 */

get_header();
?>

<div class="page-top">
  <div class="container">
    <?php
      if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p class="breadcrumbs">', '</p>'); }
    ?>
  </div>
</div>

<section class="feed-videos page-feed">
  <div class="container">
    <h1 class="page-title sub"><?php the_title(); ?></h1>
    <p class="subtitle"><?php echo get_field('subtitle'); ?></p>
    <?php if (get_field('vyklyuchit_video_otzyvy') == false) : ?>
    <div class="wrap slider-wrap">
      <div class="arr arr-prev">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
          <path d="M14.9999 6L9.70703 11.2929C9.37369 11.6262 9.20703 11.7929 9.20703 12C9.20703 12.2071 9.37369 12.3738 9.70703 12.7071L14.9999 18" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
      <div class="swiper">
        <div class="swiper-wrapper">
          <?php if (have_rows('video_feed', 'options')) : while(have_rows('video_feed', 'options')) : the_row(); ?>
          <div class="item swiper-slide video-data" data-src="<?php echo get_sub_field('link'); ?>" style="background-image: url(<?php echo get_sub_field('img'); ?>)">
            <div class="play">
              <svg xmlns="http://www.w3.org/2000/svg" width="46" height="52" viewBox="0 0 46 52" fill="none">
                <path d="M43.5 21.6699C46.8333 23.5944 46.8333 28.4056 43.5 30.3301L7.49999 51.1147C4.16666 53.0392 -2.56296e-06 50.6336 -2.39471e-06 46.7846L-5.77663e-07 5.21538C-4.09417e-07 1.36638 4.16667 -1.03924 7.5 0.885261L43.5 21.6699Z" fill="white"/>
              </svg>
            </div>
            <div class="meta">
              <b><?php echo get_sub_field('name'); ?></b>
              <p><?php echo get_sub_field('place'); ?></p>
            </div>
          </div>
          <?php endwhile; endif; ?>
        </div>
      </div>
      <div class="arr arr-next">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
          <path d="M9.00008 6L14.293 11.2929C14.6263 11.6262 14.793 11.7929 14.793 12C14.793 12.2071 14.6263 12.3738 14.293 12.7071L9.00008 18" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
      <div class="swiper-pagination dots"></div>
    </div>
    <?php endif; ?>
  </div>
</section>

<?php if (get_field('vyklyuchit_video_otzyvy') == false) : ?>
<section class="text-feed page-feed">
  <div class="container">
    <h2 class="title">
      Текстовые отзывы
    </h2>
    <div class="wrap">
      <?php if (have_rows('text_feed','options')) : while(have_rows('text_feed','options')) : the_row(); ?>
      <div class="item">
        <div class="top">
          <div class="avatar">
            <?php if (!get_sub_field('avatar')) : ?>
              <img src="<?php echo get_template_directory_uri(); ?>/img/icons/avatar-fill.svg" alt="<?php echo get_sub_field('name'); ?>">
            <?php else : ?>
              <img src="<?php echo get_sub_field('avatar'); ?>" alt="<?php echo get_sub_field('name'); ?>">
            <?php endif; ?>
          </div>
          <div class="meta">
            <b><?php echo get_sub_field('name'); ?></b>
            <p><?php echo get_sub_field('place'); ?></p>
          </div>
        </div>
        <div class="content">
          <?php echo get_sub_field('content'); ?>
        </div>
        <div class="date"><?php echo get_sub_field('date'); ?></div>
      </div>
      <?php endwhile; endif; ?>
    </div>
    <div class="moar-btn">Показать ещё</div>
  </div>
</section>
<?php endif; ?>

<?php if (get_field('vyklyuchit_blagodarnosti') == false) : ?>
<section class="sertificates">
  <div class="container">
    <h2 class="title">Благодарности</h2>
    <div class="wrap slider-wrap">
      <div class="arr arr-prev">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
          <path d="M14.9999 6L9.70703 11.2929C9.37369 11.6262 9.20703 11.7929 9.20703 12C9.20703 12.2071 9.37369 12.3738 9.70703 12.7071L14.9999 18" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
      <div class="swiper">
        <div class="swiper-wrapper magnific">
          <?php $gallery = get_field('sertificates', 'options'); if ($gallery) : ?>
          <?php foreach( $gallery as $img ): ?>
            <a href="<?php echo esc_url($img['url']); ?>" class="swiper-slide item">
              <?php if ($img['alt']) {
                echo '<img src="' . esc_url($img['sizes']['large']) . '" alt="' . esc_attr($img['alt']) . '">';
              } else {
                echo '<img src="' . esc_url($img['sizes']['large']) . '" alt="Благодарность">';
              } ?>
            </a>
          <?php endforeach; endif; ?>
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




<section class="contacts-release" style="margin-bottom: 0">
  <div class="container">
    <div class="wrap">
      <b class="title">Поможем реализовать ваш проект</b>
      <p class="subtitle">
        Оставьте контактные данные и мы свяжемся с вами в ближайшее время и ответим на любые вопросы
      </p>
      <div class="form">
        <?php echo do_shortcode('[contact-form-7 id="f34c36e" title="Поможем реализовать проект"]'); ?>
      </div>
    </div>
  </div>
</section>

<?php
get_footer();
