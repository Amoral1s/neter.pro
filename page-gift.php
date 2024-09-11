<?php
/**
 Template Name: Призы
 */

get_header();
?>

<section class="gift-offer page-top" style="color: #fff; background: linear-gradient(0deg, rgba(0, 0, 0, 0.20) 0%, rgba(0, 0, 0, 0.20) 100%), #0A3141">
  <div class="container">
    <?php
      if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p class="breadcrumbs dark-crumbs">', '</p>'); }
    ?>
    <div class="wrap">
      <div class="left">
        <h1 class="page-title sub"><?php the_title(); ?></h1>
        <p class="subtitle"><?php echo get_field('offer_subtitle'); ?></p>
        <div class="date"><?php echo get_field('offer_date'); ?></div>
        <div class="mob-gifts" style="display: none">
          <?php if (get_field('offer_coupon')) : ?>
          <div class="item first">
            <span><?php echo get_field('offer_coupon'); ?></span>
          </div>
          <?php endif; ?>
          <?php if (have_rows('offer_priz')) : while(have_rows('offer_priz')) : the_row(); ?>
            <div class="item">
              <img src="<?php echo get_sub_field('img'); ?>" alt="<?php echo get_sub_field('text'); ?>">
              <p><?php echo get_sub_field('text'); ?></p>
            </div>
          <?php endwhile; endif; ?>
        </div>
        <div class="row">
          <?php $i = 1; if (have_rows('offer_steps')) : while(have_rows('offer_steps')) : the_row(); ?>
            <div class="item">
              <b><?php echo $i; ?></b>
              <p><?php echo get_sub_field('step'); ?></p>
            </div>
          <?php $i++; endwhile; endif; ?>
        </div>
        <div class="btn-row">
          <div  class="button call-gift">
            <?php echo get_field('offer_btn_text'); ?>
          </div>
          <p>
            <?php echo get_field('offer_btn_subtitle'); ?>
          </p>
        </div>
      </div>
      <div class="right">
        <?php if (get_field('offer_coupon')) : ?>
        <div class="item first">
          <?php echo get_field('offer_coupon'); ?>
        </div>
        <?php endif; ?>
        <?php if (have_rows('offer_priz')) : while(have_rows('offer_priz')) : the_row(); ?>
          <div class="item">
            <img src="<?php echo get_sub_field('img'); ?>" alt="<?php echo get_sub_field('text'); ?>">
            <p><?php echo get_sub_field('text'); ?></p>
          </div>
        <?php endwhile; endif; ?>
      </div>
    </div>
  </div>
  <img class="bg-circle" src="<?php echo get_template_directory_uri(); ?>/img/pages/prize-circles.svg" alt="Розыгрыш">
  <img class="bg" src="<?php echo get_template_directory_uri(); ?>/img/pages/prize-bg.png" alt="Розыгрыш">
  <img style="display: none" class="bg-mob" src="<?php echo get_template_directory_uri(); ?>/img/pages/prize-bg-mob.png" alt="Розыгрыш">
</section>

<?php if (get_field('terms_title')) : ?>
<section class="gift-steps">
  <div class="container">
    <div class="title-row">
      <h2 class="title"><?php echo get_field('terms_title') ?></h2>
      <?php if (get_field('terms_file')) : ?>
        <a href="<?php echo get_field('terms_file'); ?>" target="blank">
          
          <span>Полные условия акции</span>
          <div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path d="M17 7.00012L6 18.0001" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round"/>
              <path d="M11 6H17C17.4714 6 17.7071 6 17.8536 6.14645C18 6.29289 18 6.5286 18 7V13" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
        </a>
      <?php endif; ?>
    </div>
    <div class="wrap">
    <?php if (have_rows('terms')) : while(have_rows('terms')) : the_row(); ?>
      <div class="item">
        <b><?php echo get_sub_field('title'); ?></b>
        <p><?php echo get_sub_field('text'); ?></p>
      </div>
    <?php endwhile; endif; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (get_field('gift_title')) : ?>
<section class="gift-fond">
  <div class="container">
    <h2 class="title"><?php echo get_field('gift_title') ?></h2>
    <div class="wrap">
      <?php if (have_rows('gifts')) : while(have_rows('gifts')) : the_row(); ?>
        <div class="item">
          <img src="<?php echo get_sub_field('img'); ?>" alt="Приз">
          <b><?php echo get_sub_field('text'); ?></b>
        </div>
      <?php endwhile; endif; ?>
    </div>
    <div class="button call-gift">
      Хочу приз
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (get_field('faq_title')) : ?>
<section itemscope itemtype="https://schema.org/FAQPage" class="faq">
  <div class="container">
    <div class="wrap">
      <div class="left">
        <h2 class="title sub"><?php echo get_field('faq_title') ?></h2>
        <p class="subtitle"><?php echo get_field('faq_subtitle') ?></p>
        <div class="btns">
          <a href="<?php echo get_field('faq_link'); ?>" target="blank" style="margin-left: 0; justify-content: flex-start;">
            <span>Полные условия</span>
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
        <?php if (have_rows('faq')) : while(have_rows('faq')) : the_row(); ?>
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

<section class="contacts-release gift-release" style="margin-bottom: 0">
  <div class="container">
    <b class="title">Остались вопросы? Поможем разобраться</b>
    <div class="wrap">
      <p class="subtitle">
        Оставьте контактные данные и мы свяжемся с вами в ближайшее время и ответим на любые вопросы
      </p>
      <div class="form">
        <?php echo do_shortcode('[contact-form-7 id="7bc3968" title="Вопрос по розыгрышу"]'); ?>
      </div>
    </div>
  </div>
</section>

<?php
get_footer();
