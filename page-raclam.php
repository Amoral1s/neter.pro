<?php
/**
 Template Name: Отравить рекламацию
 */

get_header();
?>
<div class="reclam-offer page-top">
  <div class="container">
    <?php
      if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p class="breadcrumbs">', '</p>'); }
    ?>
    <h1 class="page-title sub">
      <?php the_title(); ?>
    </h1>
    <p class="subtitle">
      Если вы столкнулись с любыми проблемами с нашей продукцией, пожалуйста, заполните форму ниже и мы свяжемся с вами и обязательно всё решим
    </p>
    <div class="form-tabs">
      <div class="item active">Физическое лицо</div>
      <div class="item ">Юридическое лицо</div>
    </div>
    <div class="forms-wrap">
      <div class="form active">
        <?php echo do_shortcode('[contact-form-7 id="5590074" title="Рекламация от физ. лица"]'); ?>
      </div>
      <div class="form ">
        <?php echo do_shortcode('[contact-form-7 id="5a7e803" title="Рекламация от юр. лица"]'); ?>
      </div>
    </div>
  </div>
</div>

<section class="page">
  <div class="container">
    
    <div class="wrap">
    <?php if (have_rows('row','options')) : while(have_rows('row','options')) : the_row(); ?>
      <div class="item">
        <?php echo get_sub_field('field'); ?>
      </div>
    <?php endwhile; endif; ?>
    </div>
  </div>
</section>


<?php
get_footer();
