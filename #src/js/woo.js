jQuery(document).ready(function ($) {
  console.log('woocommerce JS')

$('body').on('click', 'li.product .button.add_to_cart_button', function(event) {
  console.log()
  if (!event.target.closest('.button').classList.contains('br_compare_button')) {
    setTimeout(() => {
      var newElem = $(event.target).closest('.product').clone();
      $('.popup.woo-popup .wrap-product').html(newElem);
      $('.overlay').fadeIn(300);
      $('.popup.woo-popup').fadeIn(300);
    }, 500);
  }
});

$('body').on('click', '.add-cart-wrapper .single_add_to_cart_button', function(event) {
  if (!event.target.closest('.button').classList.contains('br_compare_button')) {
    setTimeout(() => {
      var newElem = $('.hidden-li li.product').clone();
      $('.popup.woo-popup .wrap-product').html(newElem);
      $('.overlay').fadeIn(300);
      $('.popup.woo-popup').fadeIn(300);
    }, 2000);
  }
});

$('body').on('click', '.button.order-btn', function(event) {
  setTimeout(() => {
    var newElem = $(event.target).closest('li.product').clone();
    console.log(newElem)
    if (newElem.length != 0) {
      $('.popup.order-popup .wrap-product').html(newElem);
      $('.overlay').fadeIn(300);
      $('.popup.order-popup').fadeIn(300);
  
      $('.popup.order-popup input.data-title').val($('.popup.order-popup .product-title').text().trim());
      $('.popup.order-popup input.data-sku').val($('.popup.order-popup .sku').text().trim());
      $('.popup.order-popup input.data-status').val($('.popup.order-popup .status span').text().trim());
      $('.popup.order-popup input.data-link').val($('.popup.order-popup a.woocommerce-LoopProduct-link').attr('href'));
    } else {
      console.log(123);
      newElem = $('.hidden-li li.product').clone();
      $('.popup.order-popup .wrap-product').html(newElem);
      $('.overlay').fadeIn(300);
      $('.popup.order-popup').fadeIn(300);
  
      $('.popup.order-popup input.data-title').val($('.popup.order-popup .product-title').text().trim());
      $('.popup.order-popup input.data-sku').val($('.popup.order-popup .sku').text().trim());
      $('.popup.order-popup input.data-status').val($('.popup.order-popup .status span').text().trim());
      $('.popup.order-popup input.data-link').val($('.popup.order-popup a.woocommerce-LoopProduct-link').attr('href'));
    }
    
  }, 500);
});

$('body').on('click', '.button.pre-order', function(event) {
  setTimeout(() => {
    var newElem = $(event.target).closest('li.product').clone();
    if (newElem.length != 0) {
      $('.popup.pre-order-popup .wrap-product').html(newElem);
      $('.overlay').fadeIn(300);
      $('.popup.pre-order-popup').fadeIn(300);
  
      $('.popup.pre-order-popup input.data-title').val($('.popup.pre-order-popup .product-title').text().trim());
      $('.popup.pre-order-popup input.data-sku').val($('.popup.pre-order-popup .sku').text().trim());
      $('.popup.pre-order-popup input.data-status').val($('.popup.pre-order-popup .status span').text().trim());
      $('.popup.pre-order-popup input.data-link').val($('.popup.pre-order-popup a.woocommerce-LoopProduct-link').attr('href'));
      
    } else {
      newElem = $('.hidden-li li.product').clone();
      $('.popup.pre-order-popup .wrap-product').html(newElem);
      $('.overlay').fadeIn(300);
      $('.popup.pre-order-popup').fadeIn(300);
      $('.popup.pre-order-popup input.data-title').val($('.popup.pre-order-popup .product-title').text().trim());
      $('.popup.pre-order-popup input.data-sku').val($('.popup.pre-order-popup .sku').text().trim());
      $('.popup.pre-order-popup input.data-status').val($('.popup.pre-order-popup .status span').text().trim());
      $('.popup.pre-order-popup input.data-link').val($('.popup.pre-order-popup a.woocommerce-LoopProduct-link').attr('href'));
      
    }
 
    
    
  }, 500);
});

$('.mob-filters .close').on('click', function() {
  $('.catalog-main .wrap .left').slideUp(200);
})
$('.right .mobi-sort-right').on('click', function() {
  $('.catalog-main .wrap .left').slideDown(200);
})

const creditBtn = document.querySelector('.credit-btn.button'); 

if (creditBtn) {
  function formatNumberWithSpaces(number) {
    return Math.floor(number).toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
  }
  const price = +document.querySelector('.hidden-price').textContent.trim();
  const creditBtnText = creditBtn.querySelector('span');
  
  let month = {
    3 : price / 3,
    6 : price / 6,
    12 : price / 12
  }

  console.log(month);

  const maxMonths = Object.keys(month).pop(); // Получаем максимальное значение месяцев из объекта
  
  creditBtnText.textContent = `от ${formatNumberWithSpaces(month[maxMonths])} ₽ / мес`;

  const creditWrap = document.querySelector('.credit-wrap');

  function getMonthWord(num) {
    const cases = [2, 0, 1, 1, 1, 2];
    return ['месяц', 'месяца', 'месяцев'][(num % 100 > 4 && num % 100 < 20) ? 2 : cases[Math.min(num % 10, 5)]];
  }

  Object.keys(month).forEach((key, index) => { // Создаем элементы в соответствии с данными из объекта
    const div = document.createElement('div');
    div.classList.add('btn');
    if (index == 0) {
      div.classList.add('active');
    }
    const p = document.createElement('p');
    const span = document.createElement('span');

    p.textContent = `${key} ${getMonthWord(key)}`;
    span.textContent = `от ${formatNumberWithSpaces(month[key])} ₽ / мес`;

    div.appendChild(p);
    div.appendChild(span);
    creditWrap.appendChild(div);
  });

  const creditBTNSpopup = document.querySelectorAll('.credit-popup .credit-wrap .btn');

  if (creditBTNSpopup.length > 0) {
    creditBTNSpopup.forEach(el => {
      el.addEventListener('click', () => {
        creditBTNSpopup.forEach(e => e.classList.remove('active'));
        el.classList.add('active');
         $('.popup.credit-popup input.data-credit').val($('.popup.credit-popup .btn.active p').text());
      })
    })
  }
  $('body').on('click', '.button.credit-btn', function(event) {
    setTimeout(() => {
		  $('html').addClass('fixed');
      
      var newElem = $('.hidden-li li.product').clone();
        $('.popup.credit-popup .wrap-product').html(newElem);
        $('.overlay').fadeIn(300);
        $('.popup.credit-popup').fadeIn(300);
    
        $('.popup.credit-popup input.data-title').val($('.popup.credit-popup .product-title').text().trim());
        $('.popup.credit-popup input.data-sku').val($('.popup.credit-popup .sku').text().trim());
        $('.popup.credit-popup input.data-status').val($('.popup.credit-popup .status span').text().trim());
        $('.popup.credit-popup input.data-link').val($('.popup.credit-popup a.woocommerce-LoopProduct-link').attr('href'));

        $('.popup.credit-popup input.data-credit').val($('.popup.credit-popup .btn.active p').text());
      
    }, 500);
  });
}

const productTabs = document.querySelectorAll('.single-product-bottom .single-tabs .item');

if (productTabs.length > 0) {
  const productWrappers = document.querySelectorAll('.single-product-bottom .single-wrap');
  productTabs.forEach((el, i) => {
    el.addEventListener('click', () => {
      productTabs.forEach(e => e.classList.remove('active'));
      productWrappers.forEach(e => e.classList.remove('active'));
      el.classList.add('active');
      productWrappers[i].classList.add('active');
    })
  })
}

}); //end
