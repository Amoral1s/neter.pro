<?php
/**
 Template Name: Доставка
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

<section class="delivery">
  <div class="container">
    <h1 class="page-title sub"><?php the_title(); ?></h1>
    <p class="subtitle"><?php echo get_field('subtitle'); ?></p>
  </div>
</section>

<?php if (get_field('part_title')) : ?>
<section class="delivery-part">
  <div class="container">
    <h2 class="title sub"><?php echo get_field('part_title') ?></h2>
    <p class="subtitle"><?php echo get_field('part_subtitle'); ?></p>
    <div class="wrap">
      <?php $gallery = get_field('part'); if ($gallery) : ?>
      <?php foreach( $gallery as $img ): ?>
        <div class="item">
          <?php if ($img['alt']) {
            echo '<img src="' . esc_url($img['url']) . '" alt="' . esc_attr($img['alt']) . '">';
          } else {
            echo '<img src="' . esc_url($img['url']) . '" alt="' . get_field('part_title') . '">';
          } ?>
        </div>
      <?php endforeach; endif; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (get_field('del_title')) : ?>
<section class="delivery-map">
  <div class="container">
    <div class="wrap">
      <div class="left">
        <h2 class="title sub"><?php echo get_field('del_title') ?></h2>
        <div class="content">
          <?php echo get_field('del_content'); ?>
        </div>
        <address>
          <div class="top">
            <div class="icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.0015 1.25C8.17538 1.25 4.52505 3.51303 2.99714 7.08468C1.57518 10.4086 2.34496 13.2373 3.94771 15.6595C5.26177 17.6454 7.17835 19.4178 8.90742 21.0168L8.90824 21.0175C9.23768 21.3222 9.56031 21.6206 9.87066 21.9129L9.87231 21.9145C10.4473 22.4528 11.2112 22.75 12.0015 22.75C12.7919 22.75 13.5558 22.4528 14.1308 21.9144C14.4243 21.6396 14.7286 21.3592 15.039 21.0732C16.7869 19.4627 18.7304 17.672 20.0582 15.6609C21.6591 13.2362 22.4261 10.4045 21.0059 7.08468C19.478 3.51303 15.8277 1.25 12.0015 1.25ZM12 7C9.79086 7 8 8.79086 8 11C8 13.2091 9.79086 15 12 15C14.2091 15 16 13.2091 16 11C16 8.79086 14.2091 7 12 7Z" fill="#2CB4C2"/>
              </svg>
            </div>
            <span>Адрес для самовывоза</span>
          </div>
          <p><?php echo get_field('adres_samovyvoza'); ?></p>
        </address>
      </div>
      <div class="right">
        <div id="map"></div>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>


<?php
get_footer();
