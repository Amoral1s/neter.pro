<?php
/**
 Template Name: Вакансии
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

<section class="vac-offer">
  <div class="container">
    <div class="wrap">
      <div class="left">
        <h1 class="page-title sub"><?php the_title(); ?></h1>
        <p class="subtitle"><?php echo get_field('subtitle'); ?></p>
        <div class="button call-vacancy" data-title="Общая кнопка страницы вакансий">
          Заполнить анкету
        </div>
        <div class="vac-offer-feat">
          <?php if (have_rows('features')) : while(have_rows('features')) : the_row(); ?>
          <div class="item">
            <div class="icon">
              <img src="<?php echo get_sub_field('img'); ?>" alt="<?php echo get_sub_field('text'); ?>">
            </div>
            <span><?php echo get_sub_field('text'); ?></span>
          </div>
          <?php endwhile; endif; ?>
        </div>
      </div>
      <div class="right slider-wrap">
        <div class="arr arr-prev">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path d="M14.9999 6L9.70703 11.2929C9.37369 11.6262 9.20703 11.7929 9.20703 12C9.20703 12.2071 9.37369 12.3738 9.70703 12.7071L14.9999 18" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
        <div class="swiper">
          <div class="swiper-wrapper magnific">
            <?php $gallery = get_field('gallery'); if ($gallery) : ?>
            <?php foreach( $gallery as $img ): ?>
              <a href="<?php echo esc_url($img['url']); ?>" class="swiper-slide item">
                <?php if ($img['alt']) {
                  echo '<img width="100%" height="293px" src="' . esc_url($img['sizes']['large']) . '" alt="' . esc_attr($img['alt']) . '">';
                } else {
                  echo '<img width="100%" height="293px" src="' . esc_url($img['sizes']['large']) . '" alt="' . get_the_title() . '">';
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
        <div class="dots"></div>
      </div>
    </div>
  </div>
</section>

<?php if (get_field('vac')) : ?>
<section class="vacancy">
  <div class="container">
    <h2 class="title"><?php echo get_field('vac_title') ?></h2>
    <div class="wrap">
    <?php if (have_rows('vac')) : while(have_rows('vac')) : the_row(); ?>
      <div class="vacancy-wrapper">
        <div class="city">
          <div>
            <div class="icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.0015 1.25C8.17538 1.25 4.52505 3.51303 2.99714 7.08468C1.57518 10.4086 2.34496 13.2373 3.94771 15.6595C5.26177 17.6454 7.17835 19.4178 8.90742 21.0168L8.90824 21.0175C9.23768 21.3222 9.56031 21.6206 9.87066 21.9129L9.87231 21.9145C10.4473 22.4528 11.2112 22.75 12.0015 22.75C12.7919 22.75 13.5558 22.4528 14.1308 21.9144C14.4243 21.6396 14.7286 21.3592 15.039 21.0732C16.7869 19.4627 18.7304 17.672 20.0582 15.6609C21.6591 13.2362 22.4261 10.4045 21.0059 7.08468C19.478 3.51303 15.8277 1.25 12.0015 1.25ZM12 7C9.79086 7 8 8.79086 8 11C8 13.2091 9.79086 15 12 15C14.2091 15 16 13.2091 16 11C16 8.79086 14.2091 7 12 7Z" fill="#2CB4C2"/>
              </svg>
            </div>
            <span><?php echo get_sub_field('city'); ?></span>
          </div>
        </div>
        <b class="title">
          <?php echo get_sub_field('title'); ?>
          <div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
              <path d="M24 12.0003L16.9428 19.0575C16.4984 19.5019 16.2761 19.7241 16 19.7241C15.7239 19.7241 15.5016 19.5019 15.0572 19.0575L8 12.0003" stroke="#2CB4C2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
        </b>
        <div class="wrapper">
          <p class="mini-text"><?php echo get_sub_field('text'); ?></p>
          <?php if (get_sub_field('trebovaniya')) : ?>
          <div class="list">
            <b class="mini-title">Требования:</b>
            <ul>
              <?php if (have_rows('trebovaniya')) : while(have_rows('trebovaniya')) : the_row(); ?>
                <li><?php echo get_sub_field('trebovanie'); ?></li>
              <?php endwhile; endif; ?>
            </ul>
          </div>
          <?php endif; ?>
          <?php if (get_sub_field('obyazannosti')) : ?>
          <div class="list">
            <b class="mini-title">Обязанности:</b>
            <ul>
              <?php if (have_rows('obyazannosti')) : while(have_rows('obyazannosti')) : the_row(); ?>
                <li><?php echo get_sub_field('obyazannost'); ?></li>
              <?php endwhile; endif; ?>
            </ul>
          </div>
          <?php endif; ?>
          <div class="button call-vacancy" data-title="<?php echo get_sub_field('title'); ?>">
            Заполнить анкету
          </div>
        </div>
        
      </div>
    <?php endwhile; endif; ?>
    </div>
  </div>
</section>
<?php else : ?>
<section class="no-vac">
  <div class="container">
    <div class="wrap">
      <b class="mini-title"><?php echo get_field('no_vac_title'); ?></b>
      <div class="content">
        <?php echo get_field('no_vac_text'); ?>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>



<?php
get_footer();
