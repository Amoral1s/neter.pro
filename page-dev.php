<?php
/**
 Template Name: Производство
 */

get_header();
?>

<section class="dev-offer page-top" style="background-image: url(<?php echo get_field('offer_bg'); ?>)">
  <div class="container">
    <?php
      if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p class="breadcrumbs dark-crumbs">', '</p>'); }
    ?>
    <div class="wrap">
      <div class="left">
        <h1 class="page-title sub"><?php the_title(); ?></h1>
        <div class="row">
          <address>
            <div class="icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.0015 1.25C8.17538 1.25 4.52505 3.51303 2.99714 7.08468C1.57518 10.4086 2.34496 13.2373 3.94771 15.6595C5.26177 17.6454 7.17835 19.4178 8.90742 21.0168L8.90824 21.0175C9.23768 21.3222 9.56031 21.6206 9.87066 21.9129L9.87231 21.9145C10.4473 22.4528 11.2112 22.75 12.0015 22.75C12.7919 22.75 13.5558 22.4528 14.1308 21.9144C14.4243 21.6396 14.7286 21.3592 15.039 21.0732C16.7869 19.4627 18.7304 17.672 20.0582 15.6609C21.6591 13.2362 22.4261 10.4045 21.0059 7.08468C19.478 3.51303 15.8277 1.25 12.0015 1.25ZM12 7C9.79086 7 8 8.79086 8 11C8 13.2091 9.79086 15 12 15C14.2091 15 16 13.2091 16 11C16 8.79086 14.2091 7 12 7Z" fill="#2CB4C2"/>
              </svg>
            </div>
            <p>
              <?php echo get_field('offer_address'); ?>
            </p>
          </address>
          <div class="date">
            <span>Запуск серийного производства: </span>
            <p><?php echo get_field('offer_date'); ?></p>
          </div>
        </div>
        
      </div>
      <div class="right">
        <p class="subtitle"><?php echo get_field('offer_subtitle'); ?></p>
        <div class="dev-offer-feat">
          <?php if (have_rows('offer_feat')) : while(have_rows('offer_feat')) : the_row(); ?>
            <div class="item">
              <b><?php echo get_sub_field('num'); ?></b>
              <p><?php echo get_sub_field('text'); ?></p>
            </div>
          <?php endwhile; endif; ?>
        </div>
      </div>
      
    </div>
  </div>
</section>

<?php if (get_field('ethaps_title')) : ?>
<section class="dev-ethaps">
  <div class="container">
    <div class="wrap">
      <div class="left">
        <h2 class="title sub"><?php echo get_field('ethaps_title') ?></h2>
        <div class="content">
          <?php echo get_field('ethaps_content'); ?>
        </div>
      </div>
      <div class="right">
        <?php $i = 1; if (have_rows('ethaps')) : while(have_rows('ethaps')) : the_row(); ?>
          <div class="item">
            <div class="num"><?php echo $i; ?></div>
            <div class="meta">
              <b><?php echo get_sub_field('title'); ?></b>
              <p><?php echo get_sub_field('text'); ?></p>
            </div>
          </div>
        <?php $i++; endwhile; endif; ?>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (get_field('gallery')) : ?>
<section class="dev-gallery">
  <div class="container">
    <div class="wrap slider-wrap">
      <div class="arr arr-prev">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
          <path d="M14.9999 6L9.70703 11.2929C9.37369 11.6262 9.20703 11.7929 9.20703 12C9.20703 12.2071 9.37369 12.3738 9.70703 12.7071L14.9999 18" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
      <div class="swiper">
        <div class="swiper-wrapper mag-toggle">
          <?php $gallery = get_field('gallery'); if ($gallery) : ?>
          <?php foreach( $gallery as $img ): ?>
            <a href="<?php echo esc_url($img['url']); ?>" class="swiper-slide item">
              <?php if ($img['alt']) {
                echo '<img src="' . esc_url($img['url']) . '" alt="' . esc_attr($img['alt']) . '">';
              } else {
                echo '<img src="' . esc_url($img['url']) . '" alt="Галерея производства">';
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


<?php
get_footer();
