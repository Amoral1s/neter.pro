
<?php $service_ids = get_field('service'); ?>
<div class="block_services">
  <?php
    foreach ($service_ids as $service_id) {
      $permalink = get_permalink($service_id);
      $thumbnail = get_the_post_thumbnail_url($service_id);
      $title = get_the_title($service_id);
      $subtitle = get_field('subtitle', $service_id);
      ?>
        <a href="<?php echo $permalink; ?>" class="item">
          <img src="<?php echo $thumbnail; ?>" alt="<?php echo $title; ?>">
          <div class="meta">
            <b><?php echo $title; ?></b>
            <p><?php echo $subtitle; ?></p>
          </div>
          <div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path d="M17 7L6 18" stroke="#24B642" stroke-width="1.5" stroke-linecap="round"/>
              <path d="M11 6H17C17.4714 6 17.7071 6 17.8536 6.14645C18 6.29289 18 6.5286 18 7V13" stroke="#24B642" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
        </a>
      <?php
    }
  ?>
</div>