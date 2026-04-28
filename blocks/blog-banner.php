<?php
  $title = get_field('blog_banner_title', 'options');
  $text = get_field('blog_banner_subtitle', 'options');
  $link = get_field('blog_banner_link', 'options');
  $btn = get_field('blog_banner_btn_text', 'options');
  $img = get_field('blog_banner_img', 'options');

?>
<?php if ($title) : ?>
<div class="blog-banner">
  <div class="blog-banner__wrap">
    <div class="blog-banner__thumb">
      <img src="<?php echo $img['sizes']['medium']; ?>" alt="<?php echo $title; ?>">
    </div>
    <div class="blog-banner__meta">
      <b class="blog-banner__title"><?php echo $title; ?></b>
      <p class="blog-banner__text"><?php echo $text; ?></p>
    </div>
    <a href="<?php echo $link; ?>" class="button blog-banner__button">
      <?php echo $btn; ?>
    </a>
  </div>
</div>
<?php endif; ?>