<?php
/**
 Template Name: О компании
 */

get_header();
?>

<section class="about-offer page-top" style="color: #fff; background: linear-gradient(0deg, rgba(0, 0, 0, 0.20) 0%, rgba(0, 0, 0, 0.20) 100%), #0A3141">
  <div class="container">
    <?php
      if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p class="breadcrumbs dark-crumbs">', '</p>'); }
    ?>
    <div class="wrap">
      <h1 class="page-title sub"><?php the_title(); ?></h1>
      <p class="subtitle"><?php echo get_field('offer_subtitle'); ?></p>
      <div class="row">
        <?php if (have_rows('offer_feat')) : while(have_rows('offer_feat')) : the_row(); ?>
          <div class="item">
            <b><?php echo get_sub_field('num'); ?></b>
            <p><?php echo get_sub_field('text'); ?></p>
          </div>
        <?php endwhile; endif; ?>
      </div>
    </div>
  </div>
  <div class="about-offer-bg">
    <img src="<?php echo get_field('offer_bg'); ?>" alt="О компании">
  </div>
  <img class="bg-c" src="<?php echo get_template_directory_uri(); ?>/img/about-bg-circle.png" alt="О компании">
</section>

<?php if (get_field('about_feat_title')) : ?>
<section class="about-features">
  <div class="container">
    <h2 class="title"><?php echo get_field('about_feat_title') ?></h2>
    <div class="text-wrap">
      <div class="left">
        <?php echo get_field('about_feat_left'); ?>
      </div>
      <div class="right">
        <?php echo get_field('about_feat_right'); ?>
      </div>
    </div>
    <div class="wrap">
      <?php if (have_rows('about_feat')) : while(have_rows('about_feat')) : the_row(); ?>
        <div class="item">
          <div class="icon">
            <img src="<?php echo get_sub_field('img'); ?>" alt="<?php echo get_sub_field('text'); ?>">
          </div>
          <p><?php echo get_sub_field('text'); ?></p>
        </div>
      <?php endwhile; endif; ?>
    </div>
    <div class="about-video">
      <img src="<?php echo get_field('about_video_img'); ?>" alt="Видео о компании" class="view">
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
      <iframe data-link="<?php echo get_field('about_video'); ?>?rel=0" src="" frameborder="0"></iframe>
    </div>
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

<?php if (get_field('history_title')) : ?>
<section class="history">
  <div class="container">
    <div class="wrap">
      <h2 class="title"><?php echo get_field('history_title') ?></h2>
      <div class="arr arr-prev">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
          <path d="M14.9999 6L9.70703 11.2929C9.37369 11.6262 9.20703 11.7929 9.20703 12C9.20703 12.2071 9.37369 12.3738 9.70703 12.7071L14.9999 18" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
      <div class="arr arr-next">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
          <path d="M9.00008 6L14.293 11.2929C14.6263 11.6262 14.793 11.7929 14.793 12C14.793 12.2071 14.6263 12.3738 14.293 12.7071L9.00008 18" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
      <div class="swiper">
        <div class="swiper-wrapper">
          <?php if (have_rows('history')) : while(have_rows('history')) : the_row(); ?>
          <div class="item swiper-slide">
            <div class="left">
              <b><?php echo get_sub_field('year'); ?></b>
              <p><?php echo get_sub_field('text'); ?></p>
            </div>
            <div class="right">
              <?php $image = get_sub_field('img'); ?>
              <img src="<?php echo $image['sizes']['large']; ?>" alt="<?php echo get_sub_field('year'); ?>" />
            </div>
          </div>
          <?php endwhile; endif; ?>
        </div>
      </div>
    </div>
    <div class="line">
      <?php if (have_rows('history')) : while(have_rows('history')) : the_row(); ?>
        <div class="item">
          <span></span>
          <b><?php echo get_sub_field('year'); ?></b>
        </div>
      <?php endwhile; endif; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (get_field('mission_title')) : ?>
<section class="mission">
  <div class="container">
    <h2 class="title"><?php echo get_field('mission_title') ?></h2>
    <div class="wrap">
    <?php if (have_rows('mission')) : while(have_rows('mission')) : the_row(); ?>
      <div class="item">
        <b><?php echo get_sub_field('title'); ?></b>
        <?php if (get_sub_field('img')) : ?>
          <img src="<?php echo get_sub_field('img'); ?>" alt="<?php echo get_sub_field('title'); ?>">
        <?php else : ?>
          <p><?php echo get_sub_field('text'); ?></p>
        <?php endif; ?>
      </div>
    <?php endwhile; endif; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (get_field('about_feed_title')) : ?>
<div class="bg-dark">
  <section class="about-feed">
    <div class="container">
      <h2 class="title sub"><?php echo get_field('about_feed_title') ?></h2>
      <p class="subtitle"><?php echo get_field('about_feed_subtitle') ?></p>
      <div class="swiper">
        <div class="wrap magnific swiper-wrapper">
          <?php $gallery = get_field('about_feed_gallery'); if ($gallery) : ?>
          <?php foreach( $gallery as $img ): ?>
            <a href="<?php echo esc_url($img['url']); ?>" class="item swiper-slide">
              <?php if ($img['alt']) {
                echo '<img src="' . esc_url($img['sizes']['large']) . '" alt="' . esc_attr($img['alt']) . '">';
              } else {
                echo '<img src="' . esc_url($img['sizes']['large']) . '" alt="' . get_field('about_feed_title') . '">';
              } ?>
            </a>
          <?php endforeach; endif; ?>
        </div>
      </div>
    </div>
  </section>
  <?php if (get_field('text_feed', 'options')) : ?>
  <section class="text-feed feed-slider">
    <div class="container">
      <div class="title-row">
        <h2 class="title">
          Отзывы наших клиентов
          <a href="<?php the_permalink(420); ?>" class="all-news">
            <span>Смотреть все</span>
            <div class="icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M17 7L6 18" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round"/>
                <path d="M11 6H17C17.4714 6 17.7071 6 17.8536 6.14645C18 6.29289 18 6.5286 18 7V13" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </div>
          </a>
        </h2>
        <div class="arrows">
          <div class="arr arr-prev">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path d="M14.9999 6L9.70703 11.2929C9.37369 11.6262 9.20703 11.7929 9.20703 12C9.20703 12.2071 9.37369 12.3738 9.70703 12.7071L14.9999 18" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
          <div class="arr arr-next">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path d="M9.00008 6L14.293 11.2929C14.6263 11.6262 14.793 11.7929 14.793 12C14.793 12.2071 14.6263 12.3738 14.293 12.7071L9.00008 18" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
        </div>
      </div>
      <div class="wrap">
        <div class="swiper">
          <div class="swiper-wrapper">
            <?php if (have_rows('text_feed','options')) : while(have_rows('text_feed','options')) : the_row(); ?>
            <div class="item swiper-slide">
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
        </div>
        <div class="swiper-pagination dots"></div>
      </div>
    </div>
  </section>
  <?php endif; ?>
</div>
<?php endif; ?>


<?php if (get_field('new_title', 'options')) : ?>
<section class="news">
  <div class="container">
    <h2 class="title">
      <?php echo get_field('new_title', 'options'); ?>
      <a href="/news" class="all-news">
        <span>Все новости</span>
        <div class="icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path d="M17 7L6 18" stroke="#24B642" stroke-width="1.5" stroke-linecap="round"/>
            <path d="M11 6H17C17.4714 6 17.7071 6 17.8536 6.14645C18 6.29289 18 6.5286 18 7V13" stroke="#24B642" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
      </a>
    </h2>
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
