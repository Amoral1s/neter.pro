<?php
/**
 Template Name: Вопрос - ответ
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

<section class="faq-page-offer">
  <div class="container">
    <h1 class="page-title sub"><?php the_title(); ?></h1>
    <p class="subtitle"><?php echo get_field('offer_subtitle'); ?></p>
    <div class="wrap">
      <div class="tabs">
        <?php $i = 0; if (have_rows('answers')) : while(have_rows('answers')) : the_row(); ?>
          <div class="item <?php if ($i == 0) { echo 'active'; } ?>">
            <?php echo get_sub_field('title'); ?>
          </div>
        <?php $i++; endwhile; endif; ?>
      </div>
      <?php $i = 0; if (have_rows('answers')) : while(have_rows('answers')) : the_row(); ?>
      <div class="answers <?php if ($i == 0) { echo 'active'; } ?>">
        <?php if (have_rows('rows')) : while(have_rows('rows')) : the_row(); ?>
          <div class="answer">
            <div class="answer-title">
              <span><?php echo get_sub_field('question'); ?></span>
              <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <path d="M18 9.00014L12.7071 14.293C12.3738 14.6264 12.2071 14.793 12 14.793C11.7929 14.793 11.6262 14.6264 11.2929 14.293L6 9.00014" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </div>
            </div>
            <div class="answer-content content">
              <?php echo get_sub_field('answer'); ?>
            </div>
          </div>
        <?php $i++; endwhile; endif; ?>
      </div>
      <?php endwhile; endif; ?>
    </div>
  </div>
</section>

<section class="faq-comments">
  <div class="container">
    <h2 class="title">
      Задайте ваш вопрос
    </h2>
    <div class="comments">
      <?php comments_template(); ?>
    </div>
  </div>
</section>



<?php
get_footer();
