jQuery(document).ready(function ($) {
  console.log('woocommerce JS')

  $('.product-tabs .tabs .item').on('click', function() {
      var index = $(this).index(); // Определяем индекс нажатого таба

      $('.product-tabs .tabs .item').removeClass('active');
      $('.product-tabs .wrap').fadeOut(200).eq(index).fadeIn(200); // Используем индекс для выбора соответствующего контента

      $(this).addClass('active');
  });

 


}); //end
