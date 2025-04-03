<?php
/**
 Template Name: Станьте реферером
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
    <p class="subtitle" style="text-align:left;margin-top:5px;">
      Рекомендуйте нашу компанию своим партнёрам, делитесь уникальной реферальной ссылкой и получайте скидки. После поступления оплаты вашим рефералом вы получаете скидку на следующий заказ — до 10%<br><br>
Программа действует с 9 января 2025 года, предоставляя вам и вашим партнёрам эксклюзивные условия сотрудничества. Делитесь ссылкой, приглашайте больше рефералов и получайте бонусы. Узнайте больше и присоединяйтесь уже сегодня.<br><br> 
<a href="/referal/polozhenie.pdf" style="color:#fff;text-decoration: underline;">Положение о реферальной программе.</a><br>
    </p>
    <div class="form form-white">
      <?php echo do_shortcode('[contact-form-7 id="f903b89" title="Стать рефералом"]'); ?>
    </div>
  </div>
  <img style="display: none" class="bg-pc" src="<?php echo get_template_directory_uri(); ?>/img/pages/dealer-bg.jpg" alt="bg">
  <img class="bg-mob" src="<?php echo get_template_directory_uri(); ?>/img/pages/dealer-bg-mob.jpg" alt="bg">
</section>


<?php
get_footer();
