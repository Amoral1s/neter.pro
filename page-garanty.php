<?php
/**
 Template Name: Гарантии
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

<section class="faq page-garanty">
  <div class="container">
    <h1 class="page-title "><?php the_title(); ?></h1>
    <div class="wrap">
      <div class="right">
        <?php if (have_rows('garanty')) : while(have_rows('garanty')) : the_row(); ?>
          <div class="item">
            <b class="item-title">
              <?php echo get_sub_field('title'); ?>
              <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <path d="M18 9.00008L12.7071 14.293C12.3738 14.6263 12.2071 14.793 12 14.793C11.7929 14.793 11.6262 14.6263 11.2929 14.293L6 9.00008" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </div>
            </b>
            <div class="item-content content">
              <?php echo get_sub_field('text'); ?>
            </div>
          </div>
        <?php endwhile; endif; ?>
      </div>
    </div>
  </div>
</section>

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
