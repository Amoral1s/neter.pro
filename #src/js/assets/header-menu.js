jQuery(function($) {
  function topScroll(time) {
    const $top = $('#top');

    if (!$top.length) {
      return false;
    }

    const destination = $top.offset().top;
    $('html:not(:animated),body:not(:animated)').animate({ scrollTop: destination }, time);
    return false;
  }

  if (window.screen.width > 992) {
    let timerLi;
    let isCatalogOpen = false;

    function openCatalog() {
      if ($(window).scrollTop() !== 0 && $(window).scrollTop() < 200) {
        topScroll(100);
      }

      if ($('.header').hasClass('scrolled')) {
        $('.pc-catalog').addClass('scrolled');
      }

      $('html').addClass('fixed');
      $('.header').addClass('header-open-menu');
      $('.catalog-toggle').addClass('active');
      $('.pc-catalog').stop(true, true).slideDown(250);
      isCatalogOpen = true;
    }

    function closeCatalog() {
      $('.pc-catalog').stop(true, true).slideUp(250);
      $('.pc-catalog').removeClass('scrolled');
      $('html').removeClass('fixed');
      $('.header').removeClass('header-open-menu');
      $('.catalog-toggle').removeClass('active');
      isCatalogOpen = false;
    }

    $('#up-arr').on('click', function() {
      topScroll(500);
    });

    $(window).on('scroll', function() {
      if ($(window).scrollTop() > 200) {
        $('.header').addClass('scrolled');
        if (isCatalogOpen) {
          $('.pc-catalog').addClass('scrolled');
        }
        $('#up-arr').fadeIn(200);
      } else {
        $('.header').removeClass('scrolled');
        if (!isCatalogOpen) {
          $('.pc-catalog').removeClass('scrolled');
        }
        $('#up-arr').fadeOut(200);
      }
    });

    $('.header .search-toggle').on('click', function() {
      $(this).parent().addClass('active');
    });

    $('.dgwt-wcas-preloader').on('click', function() {
      $('.header .search').removeClass('active');
    });

    $('li.menu-item-has-children').hover(function(ev) {
      clearTimeout(timerLi);
      const current = ev.target.closest('.menu-item-has-children');
      timerLi = setTimeout(function() {
        $(current).children('ul').stop(true, true).slideDown(200);
        $(current).addClass('opened');
      }, 300);
    }, function(ev) {
      const current = ev.target.closest('.menu-item-has-children');
      clearTimeout(timerLi);
      $(current).children('ul').stop(true, true).slideUp(200);
      $(current).removeClass('opened');
    });

    $('.catalog-toggle').on('click', function(event) {
      event.preventDefault();
      event.stopPropagation();

      if (isCatalogOpen) {
        closeCatalog();
      } else {
        openCatalog();
      }
    });

    $('.pc-catalog').on('click', function(event) {
      event.stopPropagation();
    });

    $('.header nav.menu, .header nav.menu ul').on('mouseenter', function() {
      if (isCatalogOpen) {
        closeCatalog();
      }
    });

    $(document).on('click', function() {
      if (isCatalogOpen) {
        closeCatalog();
      }
    });

    $(document).on('keydown', function(event) {
      if (event.key === 'Escape' && isCatalogOpen) {
        closeCatalog();
      }
    });

    $('.pc-catalog .wrap .wrapper .item').hover(function() {
      if ($(this).next().length === 1) {
        $('.pc-catalog .sub-menu').stop(true, true).slideUp(0).css('display', 'none');
        $('.pc-catalog .wrap .wrapper .item').removeClass('active');
        $(this).next().stop(true, true).slideDown(0).css('display', 'flex');
        $(this).addClass('active');
      } else {
        $('.pc-catalog .sub-menu').stop(true, true).slideUp(0).css('display', 'none');
        $('.pc-catalog .wrap .wrapper .item').removeClass('active');
      }
    }, function() {});
  } else {
    $(window).on('scroll', function() {
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
      if ($(this).next().length === 1) {
        event.preventDefault();
        $(this).next().slideDown(200);
      }
    });

    $('.mob-nav .menu-item-has-children > span').on('click', function(event) {
      event.preventDefault();
      $(this).next().next().slideDown(200);
    });

    $('.mob-nav .menu-item-has-children > a').on('click', function(event) {
      event.preventDefault();
      $(this).next().next().slideDown(200);
    });

    const mobNavChildrens = document.querySelectorAll('.mob-nav .menu-item-has-children ul');

    if (mobNavChildrens.length > 0) {
      mobNavChildrens.forEach((el) => {
        const newBackBtn = document.createElement('div');
        newBackBtn.innerHTML = `
          <div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path d="M5 12L20 11.9998" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M9.00001 7L4.70712 11.2929C4.37378 11.6262 4.20712 11.7929 4.20712 12C4.20712 12.2071 4.37378 12.3738 4.70712 12.7071L9.00001 17" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
          <span>Назад</span>
        `;
        newBackBtn.classList.add('back-btn');
        newBackBtn.style.display = 'flex';

        $(newBackBtn).on('click', function() {
          $('.mob-nav .menu-item-has-children ul').slideUp(200);
        });

        const allLi = el.querySelectorAll('li');
        el.insertBefore(newBackBtn, allLi[0]);
      });
    }

    $('.mob-menu .back-btn.main-btn').on('click', function() {
      $('.menu_sublist').slideUp(200);
    });

    $('#up-arr').on('click', function() {
      topScroll(500);
    });
  }
});
