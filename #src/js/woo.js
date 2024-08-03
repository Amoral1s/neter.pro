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
      const inputSLiders = document.querySelectorAll('.filters-popup .wpfPriceInputs');
      let count = 0;

      if (inputSLiders.length > 0) {
        inputSLiders.forEach(range => {
          const min = range.querySelector('#wpfMinPrice');
          const max = range.querySelector('#wpfMaxPrice');
          let minVal = min.min;
          let maxVal = min.max;
          if (min.value != minVal && max.value != maxVal) {
            count++;
          } else {
            if (count > 0) {
              count--;
            }
          }
        });
      }
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
      }
      
      console.log('woo filters rendered')

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

    // Функция debounce
    function debounce(func, delay) {
      let timeoutId;
      return function(...args) {
        const context = this;
        if (timeoutId) {
          clearTimeout(timeoutId);
        }
        timeoutId = setTimeout(() => {
          func.apply(context, args);
        }, delay);
      };
    }

    // Обёртка renderFiltersBtns в debounce с задержкой 500ms
    const debouncedRenderFiltersBtns = debounce(renderFiltersBtns, 500);

    if (window.screen.width > 992) {
      $('.shop-catalog-wrapper').on('mousemove', debouncedRenderFiltersBtns);
    }


    renderFiltersBtns();
  }




  

 


}); //end
