<?php
/**
 Template Name: Станьте дилером
 */

get_header();
?>

<section class="dealer-offer page-top" style="color: #fff; background: linear-gradient(0deg, rgba(0, 0, 0, 0.20) 0%, rgba(0, 0, 0, 0.20) 100%), #0A3141">
  <div class="container">
    <?php
      if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p class="breadcrumbs dark-crumbs">', '</p>'); }
    ?>
    <h1 class="page-title sub">
      <?php the_title(); ?>
    </h1>
    <p class="subtitle">
      Если вы заинтересованы в реализации нашей продукции пожалуйста заполните форму
    </p>
    <div class="form form-white">
      <?php echo do_shortcode('[contact-form-7 id="84e402c" title="Стать дилером компании"]'); ?>
    </div>
  </div>
  <img style="display: none" class="bg-pc" src="<?php echo get_template_directory_uri(); ?>/img/pages/dealer-bg.jpg" alt="bg">
  <img class="bg-mob" src="<?php echo get_template_directory_uri(); ?>/img/pages/dealer-bg-mob.jpg" alt="bg">
</section>


<?php
get_footer();
