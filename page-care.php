<?php
/**
 Template Name: Бережливое производство
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

<section class="care-offer">
  <div class="container">
    <h1 class="page-title sub">
      <?php the_title(); ?>
    </h1>
    <p class="subtitle">
      <?php echo get_field('subtitle'); ?>
    </p>
    <div class="thumb">
      <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php echo get_the_title(); ?>">
    </div>
  </div>
</section>

<?php if (get_field('ethaps_title')) : ?>
<section class="care-ethaps">
  <div class="container">
    <h2 class="title sub"><?php echo get_field('ethaps_title') ?></h2>
    <p class="subtitle"><?php echo get_field('ethaps_subtitle'); ?></p>
    <div class="wrap slider-wrap">
      <div class="swiper">
        <div class="swiper-wrapper">
          <?php $i = 1; if (have_rows('ethaps')) : while(have_rows('ethaps')) : the_row(); ?>
          <div class="item swiper-slide">
            <div class="num"><?php echo $i; ?></div>
            <b><?php echo get_sub_field('title'); ?></b>
            <p><?php echo get_sub_field('text'); ?></p>
          </div>
          <?php $i++; endwhile; endif; ?>
        </div>
      </div>
      <div class="dots" style="display: none"></div>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (get_field('process_title')) : ?>
<section class="care-process">
  <div class="container">
    <h2 class="title"><?php echo get_field('process_title') ?></h2>
    <div class="wrap slider-wrap">
      <div class="arr arr-prev">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
          <path d="M14.9999 6L9.70703 11.2929C9.37369 11.6262 9.20703 11.7929 9.20703 12C9.20703 12.2071 9.37369 12.3738 9.70703 12.7071L14.9999 18" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
      <div class="swiper">
        <div class="swiper-wrapper mag-toggle">
          <?php $gallery = get_field('process'); if ($gallery) : ?>
          <?php foreach( $gallery as $img ): ?>
            <a href="<?php echo esc_url($img['url']); ?>" class="swiper-slide item">
              <?php if ($img['title']) {
                echo '<img src="' . esc_url($img['url']) . '" alt="' . esc_attr($img['title']) . '">';
                echo '<p>'.esc_attr($img['title']).'</p>';
              } else {
                echo '<img src="' . esc_url($img['url']) . '" alt="Процесс">';
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
      <div class="dots circles" style="display: none"></div>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (get_field('result_title')) : ?>
<section class="care-result">
  <div class="container">
    <div class="wrap">
      <div class="left">
        <h2 class="title sub"><?php echo get_field('result_title') ?></h2>
        <div class="content">
          <?php echo get_field('result_content'); ?>
        </div>
      </div>
      <div class="right">
        <?php if (have_rows('result_list')) : while(have_rows('result_list')) : the_row(); ?>
          <?php
            $class = '';
            if (get_sub_field('arr_toggle') == true) {
              $class = 'up';
            }
          ?>
          <div class="item">
            <div class="icon <?php echo $class; ?>">
              <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                <path d="M20 31.6668V6.66675" stroke="#0FBA00" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M11.6641 25L18.8189 32.1548C19.3744 32.7103 19.6522 32.9882 19.9974 32.9882C20.3426 32.9882 20.6204 32.7103 21.1759 32.1548L28.3307 25" stroke="#0FBA00" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </div>
            <b><?php echo get_sub_field('num'); ?></b>
            <p><?php echo get_sub_field('text'); ?></p>
          </div>
        <?php endwhile; endif; ?>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (get_field('blag_title')) : ?>
<section class="care-blag">
  <div class="container">
    <div class="title-row">
      <h2 class="title"><?php echo get_field('blag_title') ?></h2>
      <div class="icon">
        <img src="<?php echo get_field('blag_logo'); ?>" alt="<?php echo get_field('blag_title'); ?>">
      </div>
    </div>
    <p class="subtitle">
      <?php echo get_field('blag_subtitle'); ?>
    </p>
  </div>
</section>
<?php endif; ?>

<?php
get_footer();
