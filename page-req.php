<?php
/**
 Template Name: Реквизиты
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


<?php if (get_field('req_title', 'options')) : ?>
<section class="req">
  <div class="container">
    <h1 class="page-title"><?php echo get_field('req_title', 'options') ?></h1>
    <div class="wrap">
      <div class="left">
        <?php if (have_rows('req', 'options')) : while(have_rows('req', 'options')) : the_row(); ?>
          <div class="item">
            <p><?php echo get_sub_field('name'); ?></p>
            <b><?php echo get_sub_field('value'); ?></b>
          </div>
        <?php endwhile; endif; ?>
      </div>
      <div class="right">
        <?php if (get_field('req_team', 'options')) : ?>
        <div class="persons">
          <?php if (have_rows('req_team', 'options')) : while(have_rows('req_team', 'options')) : the_row(); ?>
            <div class="item">
              <span><?php echo get_sub_field('place'); ?></span>
              <b><?php echo get_sub_field('name'); ?></b>
              <?php if (get_sub_field('email')) : ?>
              <a target="blank" href="mailto:<?php echo get_sub_field('email'); ?>"><?php echo get_sub_field('email'); ?></a>
              <?php endif; ?>
            </div>
          <?php endwhile; endif; ?>
        </div>
        <?php endif; ?>
        <?php if (have_rows('req_doc', 'options')) : while(have_rows('req_doc', 'options')) : the_row(); ?>
          <a target="blank" download href="<?php echo get_sub_field('dokument'); ?>" class="doc">
            <div class="icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.25 17.5C8.25 17.0858 8.58579 16.75 9 16.75L15 16.75C15.4142 16.75 15.75 17.0858 15.75 17.5C15.75 17.9142 15.4142 18.25 15 18.25L9 18.25C8.58579 18.25 8.25 17.9142 8.25 17.5Z" fill="#2CB4C2"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.4697 14.0303C11.7626 14.3232 12.2374 14.3232 12.5303 14.0303L16.0303 10.5303C16.3232 10.2374 16.3232 9.76256 16.0303 9.46967C15.7374 9.17678 15.2626 9.17678 14.9697 9.46967L12.75 11.6893V6.5C12.75 6.08579 12.4142 5.75 12 5.75C11.5858 5.75 11.25 6.08579 11.25 6.5V11.6893L9.03033 9.46967C8.73744 9.17678 8.26256 9.17678 7.96967 9.46967C7.67678 9.76256 7.67678 10.2374 7.96967 10.5303L11.4697 14.0303Z" fill="#2CB4C2"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 3.25C6.89137 3.25 2.75 7.39137 2.75 12.5C2.75 17.6086 6.89137 21.75 12 21.75C17.1086 21.75 21.25 17.6086 21.25 12.5C21.25 7.39137 17.1086 3.25 12 3.25ZM1.25 12.5C1.25 6.56294 6.06294 1.75 12 1.75C17.9371 1.75 22.75 6.56294 22.75 12.5C22.75 18.4371 17.9371 23.25 12 23.25C6.06294 23.25 1.25 18.4371 1.25 12.5Z" fill="#2CB4C2"/>
              </svg>
            </div>
            <div class="meta">
              <b><?php echo get_sub_field('imya_dokumenta'); ?></b>
              <span><?php echo get_sub_field('format_i_ves'); ?></span>
            </div>
          </a>
        <?php endwhile; endif; ?>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

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
