jQuery(document).ready(function ($) {
  console.log('woocommerce JS')

  $('.product-tabs .tabs .item').on('click', function() {
      var index = $(this).index(); // Определяем индекс нажатого таба

      $('.product-tabs .tabs .item').removeClass('active');
      $(this).addClass('active');

      $('.product-tabs .wrapper').fadeOut(0, function() {
          $(this).css('display', 'none'); // Устанавливаем display: none после fadeOut
      }).eq(index).fadeIn(0, function() {
          $(this).css('display', 'flex'); // Устанавливаем display: flex после fadeIn
      });
  });

  const catalogPage = document.querySelector('.shop-catalog-wrapper');

  if (catalogPage) {

    function renderFiltersBtns() {
      const inputs = document.querySelectorAll('.filters-popup input[type="checkbox"');
      const numberWrap = document.querySelector('.call-filters .numbers');
      const filterBtn = document.querySelector('.call-filters');
      let count = 0;
      if (inputs.length > 0) {
        inputs.forEach(elem => {
          if (elem.checked) {
              count++;
          }
        });
        if (count == 0) {
          numberWrap.style.display = 'none';
          filterBtn.classList.remove('active');
          numberWrap.textContent = 0;
        } else {
          numberWrap.style.display = 'flex';
          filterBtn.classList.add('active');
          numberWrap.textContent = count;
        }
        console.log('woo filters rendered')
      }
    }

    $('.call-filters').on('click', function() {
      $('.overlay').fadeIn(200);
      $('.filters-popup').fadeIn(200);
      $('html').addClass('fixed');
    });

    $('.filters-popup .close').on('click', function() {
      $('.overlay').fadeOut(200);
      $('.filters-popup').fadeOut(200);
      $('html').removeClass('fixed');
      renderFiltersBtns();
    });

    $('.overlay').on('click', function() {
      $('.overlay').fadeOut(200);
      $('.filters-popup').fadeOut(200);
      $('html').removeClass('fixed');
      renderFiltersBtns();
    });

    $('.filters-popup .wrap .buttons .filters-popup-reset').on('click', function() {
      $('.overlay').fadeOut(200);
      $('.wpfClearButton').trigger('click');
      $('.filters-popup').fadeOut(200);
      $('html').removeClass('fixed');

      renderFiltersBtns();
    });
    $('.filters-popup .wrap .buttons .filers-popup-confirm').on('click', function() {
      $('.overlay').fadeOut(200);
      $('.filters-popup').fadeOut(200);
      $('html').removeClass('fixed');

      renderFiltersBtns();
    });

    if (window.screen.width > 992) {
      $('.shop-catalog-wrapper').on('mousemove', function() {
        renderFiltersBtns();
      });
    
    }
    renderFiltersBtns();
  }




  

 


}); //end
