<?php if (get_field('important_text')) : ?>
<div class="block_important-text">
  <div class="icon">
    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
      <circle cx="14" cy="14" r="12.5" stroke="#24B642" stroke-width="1.875"/>
      <path d="M13.9919 17.75H14.0032" stroke="#24B642" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
      <path d="M14 14L14 9" stroke="#24B642" stroke-width="1.875" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
  </div>
  <b><?php echo get_field('important_text'); ?></b>
</div>
<?php endif; ?>