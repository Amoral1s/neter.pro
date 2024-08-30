<?php
/**
 Template Name: Бережливое производство
 */

get_header();
?>

<section class="page">
  <div class="container">
    <h1 class="page-title sub">
      <?php the_title(); ?>
    </h1>
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
