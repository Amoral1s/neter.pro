<div class="block_category">
<?php
  $categories = get_field('category');

  if ($categories) {
      foreach ($categories as $category_id) {
          $category = get_term($category_id, 'product_cat');

          if ($category && !is_wp_error($category) && !empty($category->term_id)) {
              $category_image = get_term_meta($category->term_id, 'thumbnail_id', true);
              
              if ($category_image) {
                  $image = wp_get_attachment_image_url($category_image, 'full');
              } else {
                  $image = ''; // Если у категории нет картинки
              }

              $category_link = get_term_link($category);
              $category_title = $category->name;
            ?>
              <a href="<?php echo $category_link; ?>" class="item">
                <img src="<?php echo $image; ?>" alt="<?php echo $category_title; ?>">
                <b><?php echo $category_title; ?></b>
              </a>
            <?php
            
          } 
      }
  } 
?>
</div>