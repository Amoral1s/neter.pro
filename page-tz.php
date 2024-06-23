<?php
/**
 Template Name: Аккумуляторы на заказ
 */

get_header();
?>

<section class="calc-offer page-top" style="color: #fff; background: linear-gradient(0deg, rgba(0, 0, 0, 0.20) 0%, rgba(0, 0, 0, 0.20) 100%), #0A3141">
  <div class="container">
    <?php
      if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p class="breadcrumbs dark-crumbs">', '</p>'); }
    ?>
    <div class="wrap">
      <h1 class="page-title sub"><?php the_title(); ?></h1>
      <p class="subtitle"><?php echo get_field('offer_subtitle'); ?></p>
      <a href="#calc" class="button link">
        Оставить заявку на разработку
      </a>
      <div class="row">
        <?php if (have_rows('offer_feat')) : while(have_rows('offer_feat')) : the_row(); ?>
          <div class="item">
            <img src="<?php echo get_sub_field('img'); ?>" alt="<?php echo get_sub_field('text'); ?>">
            <p><?php echo get_sub_field('text'); ?></p>
          </div>
        <?php endwhile; endif; ?>
      </div>
    </div>
  </div>
  <div class="bg">
    <img src="<?php echo get_field('offer_img'); ?>" alt="<?php the_title(); ?>">
  </div>
  
</section>

<?php if (get_field('calc_title')) : ?>
<section class="calc">
  <div class="container">
    <div class="wrap">
      <h2 class="title sub"><?php echo get_field('calc_title') ?></h2>
      <p class="subtitle"><?php echo get_field('calc_subtitle'); ?></p>
      <div class="calc-wrapper">
        <div class="left">
          <?php get_template_part('blocks/calc') ?>
        </div>
        <div class="right ">
          <b class="mini-title">Рассчитать стоимость</b>
          <p class="sub">Мы отправим расчет на указанный электронный адрес и позвоним для уточнения деталей поставки</p>
          <div class="form">
            <?php echo do_shortcode('[contact-form-7 id="4e95e5f" title="Калькулятор"]'); ?>
          </div>
        </div>
      </div>
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
<section class="tech-banner calc-banner">
  <div class="container">
    <div class="wrap">
      <div class="left">
        <b class="title sub"><?php echo get_field('tech_title','options') ?></b>
        <p class="subtitle"><?php echo get_field('tech_subtitle', 'options'); ?></p>
        <div class="form form-white">
          <?php echo do_shortcode('[contact-form-7 id="49d215f" title="Баннер изготовления по вашему ТЗ (Страница калькулятор)"]'); ?>
        </div>
      </div>
      <div class="right">
        <img src="<?php echo get_template_directory_uri(); ?>/img/icons/email.png" alt="icon">
        <div class="met">
          <p>Или отправьте ваше техзадание нам на почту</p>
          <a target="blank" href="meilto:<?php echo get_field('email', 'options'); ?>">
            <?php echo get_field('email', 'options'); ?>
          </a>
        </div>
      </div>
    </div>
   
  </div>
</section>
<?php endif; ?>


<?php
get_footer();
