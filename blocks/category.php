<div class="block_category">
  <div class="swiper">
    <div class="swiper-wrapper">
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
                    <a href="<?php echo $category_link; ?>" class="item swiper-slide">
                      <div class="top">
                        <b><?php echo $category_title; ?></b>
                        <div class="icon">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M17 7L6 18" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M11 6H17C17.4714 6 17.7071 6 17.8536 6.14645C18 6.29289 18 6.5286 18 7V13" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                          </svg>
                        </div>
                      </div>
                      <img src="<?php echo $image; ?>" alt="<?php echo $category_title; ?>">
                    </a>
                  <?php
                  
                } 
            }
        } 
      ?>
    </div>
  </div>
</div>