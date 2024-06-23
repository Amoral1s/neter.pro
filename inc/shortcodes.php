<?php 


function services() {
  ob_start();
  get_template_part('shortcodes/services');
  return ob_get_clean();
}
add_shortcode('services', 'services');

function video() {
  ob_start();
  get_template_part('shortcodes/video');
  return ob_get_clean();
}
add_shortcode('video', 'video');

function product() {
  ob_start();
  get_template_part('shortcodes/product');
  return ob_get_clean();
}
add_shortcode('product', 'product');

