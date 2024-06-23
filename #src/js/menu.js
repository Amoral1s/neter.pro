jQuery(document).ready(function ($) {
  function topScroll(time) {
    var destination = $('#top').offset().top;
    $("html:not(:animated),body:not(:animated)").animate({scrollTop: destination}, time);
    return false;
  }
if (window.screen.width > 992) {
  var timer;
  var timerLi;
  var menuHovered = false;
  var timerServ;
  var menuHoveredServ = false;

  
  $('#up-arr').on('click', function() {
    topScroll(500);
  })
  $(window).scroll(function() { 
    if ($(window).scrollTop() > 200) {
      $('.header').addClass('scrolled');
      $('.pc-catalog').addClass('scrolled');
      $('#up-arr').fadeIn(200);
    } else {
      $('.header').removeClass('scrolled');
      $('.pc-catalog').removeClass('scrolled');
      $('#up-arr').fadeOut(200);
    }
  });
  $('.header .search-toggle').on('click', function() {
    $(this).parent().addClass('active')
  });
  $('.dgwt-wcas-preloader').on('click', function() {
    $('.header .search').removeClass('active');
  });
  $('li.menu-item-has-children').hover(function(ev) {
    clearTimeout(timerLi);
    let _this = ev.target.closest('.menu-item-has-children');
    timerLi = setTimeout(function() {
        $(_this).children('ul').slideDown(200);
        $(_this).addClass('opened');
        $('html').removeClass('fixed');
    }, 500);
  }, function(ev) {
      let _this = ev.target.closest('.menu-item-has-children');
      clearTimeout(timerLi);
      $(_this).children('ul').slideUp(200);
      $(_this).removeClass('opened');
      $('html').removeClass('fixed');
  });

  $('.catalog-toggle').hover(function(ev) {
    if ($(window).scrollTop() != 0 &&  $(window).scrollTop() < 200) {
      topScroll(100);
    }
    clearTimeout(timer);
    timer = setTimeout(function() {
        if ($('.header').hasClass('scrolled')) {
          $('.pc-catalog').addClass('scrolled');
        }
        $('html').addClass('fixed');
        $('.header').addClass('header-open-menu');
        $('.catalog-toggle').addClass('active');
        if (!menuHovered) {
            $('.pc-catalog').slideDown(300);
        }
    }, 500);
  }, function() {
      clearTimeout(timer);
      if (!menuHovered) {
          timer = setTimeout(function() {
              $('.pc-catalog').slideUp(300);
              $('.pc-catalog').removeClass('scrolled');
              setTimeout(() => {
                $('html').removeClass('fixed');
                $('.header').removeClass('header-open-menu');
                $('.catalog-toggle').removeClass('active');
              }, 200);
          }, 200);
      }
  });

  $('.pc-catalog').hover(function() {
    clearTimeout(timer);
    menuHovered = true;
    $('html').addClass('fixed');
}, function() {
    clearTimeout(timer);
    menuHovered = false;
    $('.pc-catalog').slideUp(300);
    setTimeout(() => {
    $('html').removeClass('fixed');
    $('.header').removeClass('header-open-menu');
    $('.catalog-toggle').removeClass('active');
  }, 320);
});

  $('.pc-catalog .wrap .wrapper .item').hover(function(ev) {
    if ($(this).next().length == 1) {
        $('.pc-catalog .sub-menu').slideUp(0);
        $('.pc-catalog .sub-menu').css('display', 'none');
        $('.pc-catalog .wrap .wrapper .item').removeClass('active');
        $(this).next().slideDown(0);
        $(this).next().css('display', 'flex');
        $(this).addClass('active');
    } else {
      $('.pc-catalog .sub-menu').slideUp(0);
      $('.pc-catalog .sub-menu').css('display', 'none');
      $('.pc-catalog .wrap .wrapper .item').removeClass('active');
    }
    
  }, function(ev) {
    
  });
 
  //services-menu


} else {
  
  $(window).scroll(function() { 
    if ($(window).scrollTop() > 200) {
      $('.mob-header').addClass('scrolled');
      $('#up-arr').fadeIn(200);
    } else {
      $('.mob-header').removeClass('scrolled');
      $('#up-arr').fadeOut(200);
    }
  });

  $('.mob-header .burger').on('click', function() {
      $('.mob-menu').slideDown(200);
  });
  $('.mob-menu .close').on('click', function() {
      $('.mob-menu').slideUp(200);
      $('.sub-menu').slideUp(200);
      $('.menu_sublist').slideUp(200);
  });
  $('.mob-menu .back-btn').on('click', function() {
      $('.sub-menu').slideUp(200);
  });
  $('.mob-cats .item').on('click', function(event) {
    if ($(this).next().length == 1) {
      event.preventDefault();
      $(this).next().slideDown(200);
    }
  });
  $('.mob-nav .menu-item-has-children > span').on('click', function(event) {
    event.preventDefault();
    $(this).next().next().slideDown(200);
  });
  const mobNavChildrens = document.querySelectorAll('.mob-nav .menu-item-has-children ul');
  if (mobNavChildrens.length > 0) {
    mobNavChildrens.forEach(el => {
      const newBackBtn = document.querySelector('.mob-menu .back-btn.main-btn').cloneNode(true);
      newBackBtn.style.display = 'flex';
      const navTitle = el.parentElement.querySelector('.main-nav-item').cloneNode(true);
      const allLi = el.querySelectorAll('li');
      el.insertBefore(newBackBtn, allLi[0]);
      el.insertBefore(navTitle, allLi[0]);

    })
  }
  $('.mob-menu .back-btn.main-btn').on('click', function() {
    $('.menu_sublist').slideUp(200);
  });
  $('#up-arr').on('click', function() {
    topScroll(500);
  })


} //endif screen width

}); //end
