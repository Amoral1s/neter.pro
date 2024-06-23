<?php
/**
 Template Name: Инструкции
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

<section class="instructions">
  <div class="container">
    <h1 class="page-title"><?php the_title(); ?></h1>
    <div class="wrap">
      <?php if (have_rows('instructions')) : while(have_rows('instructions')) : the_row(); ?>
        <a class="item" href="<?php echo get_sub_field('link'); ?>" target="blank" download>
          <b><?php echo get_sub_field('name'); ?></b>
          <div class="btn">
            <div class="icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.25 17C8.25 16.5858 8.58579 16.25 9 16.25L15 16.25C15.4142 16.25 15.75 16.5858 15.75 17C15.75 17.4142 15.4142 17.75 15 17.75L9 17.75C8.58579 17.75 8.25 17.4142 8.25 17Z" fill="#2CB4C2"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.4697 13.5303C11.7626 13.8232 12.2374 13.8232 12.5303 13.5303L16.0303 10.0303C16.3232 9.73744 16.3232 9.26256 16.0303 8.96967C15.7374 8.67678 15.2626 8.67678 14.9697 8.96967L12.75 11.1893V6C12.75 5.58579 12.4142 5.25 12 5.25C11.5858 5.25 11.25 5.58579 11.25 6V11.1893L9.03033 8.96967C8.73744 8.67678 8.26256 8.67678 7.96967 8.96967C7.67678 9.26256 7.67678 9.73744 7.96967 10.0303L11.4697 13.5303Z" fill="#2CB4C2"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2.75C6.89137 2.75 2.75 6.89137 2.75 12C2.75 17.1086 6.89137 21.25 12 21.25C17.1086 21.25 21.25 17.1086 21.25 12C21.25 6.89137 17.1086 2.75 12 2.75ZM1.25 12C1.25 6.06294 6.06294 1.25 12 1.25C17.9371 1.25 22.75 6.06294 22.75 12C22.75 17.9371 17.9371 22.75 12 22.75C6.06294 22.75 1.25 17.9371 1.25 12Z" fill="#2CB4C2"/>
              </svg>
            </div>
            <span>Скачать</span>
          </div>
        </a>
      <?php endwhile; endif; ?>
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
