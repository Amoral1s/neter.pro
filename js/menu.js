  function topScroll(time) {
    var destination = jQuery('#top').offset().top;
    jQuery("html:not(:animated),body:not(:animated)").animate({scrollTop: destination}, time);
    return false;
  }
if (window.screen.width > 992) {
  var timer;
  var timerLi;
  var menuHovered = false;
  var timerServ;
  var menuHoveredServ = false;

  
  jQuery('#up-arr').on('click', function() {
    topScroll(500);
  })
  jQuery(window).scroll(function() { 
    if (jQuery(window).scrollTop() > 200) {
      jQuery('.header').addClass('scrolled');
      jQuery('.pc-catalog').addClass('scrolled');
      jQuery('#up-arr').fadeIn(200);
    } else {
      jQuery('.header').removeClass('scrolled');
      jQuery('.pc-catalog').removeClass('scrolled');
      jQuery('#up-arr').fadeOut(200);
    }
  });
  jQuery('.header .search-toggle').on('click', function() {
    jQuery(this).parent().addClass('active')
  });
  jQuery('.dgwt-wcas-preloader').on('click', function() {
    jQuery('.header .search').removeClass('active');
  });
  jQuery('li.menu-item-has-children').hover(function(ev) {
    clearTimeout(timerLi);
    let _this = ev.target.closest('.menu-item-has-children');
    timerLi = setTimeout(function() {
        jQuery(_this).children('ul').slideDown(200);
        jQuery(_this).addClass('opened');
        jQuery('html').removeClass('fixed');
    }, 500);
  }, function(ev) {
      let _this = ev.target.closest('.menu-item-has-children');
      clearTimeout(timerLi);
      jQuery(_this).children('ul').slideUp(200);
      jQuery(_this).removeClass('opened');
      jQuery('html').removeClass('fixed');
  });

  jQuery('.catalog-toggle').hover(function(ev) {
    if (jQuery(window).scrollTop() != 0 &&  jQuery(window).scrollTop() < 200) {
      topScroll(100);
    }
    clearTimeout(timer);
    timer = setTimeout(function() {
        if (jQuery('.header').hasClass('scrolled')) {
          jQuery('.pc-catalog').addClass('scrolled');
        }
        jQuery('html').addClass('fixed');
        jQuery('.header').addClass('header-open-menu');
        jQuery('.catalog-toggle').addClass('active');
        if (!menuHovered) {
            jQuery('.pc-catalog').slideDown(300);
        }
    }, 500);
  }, function() {
      clearTimeout(timer);
      if (!menuHovered) {
          timer = setTimeout(function() {
              jQuery('.pc-catalog').slideUp(300);
              jQuery('.pc-catalog').removeClass('scrolled');
              setTimeout(() => {
                jQuery('html').removeClass('fixed');
                jQuery('.header').removeClass('header-open-menu');
                jQuery('.catalog-toggle').removeClass('active');
              }, 200);
          }, 200);
      }
  });

  jQuery('.pc-catalog').hover(function() {
    clearTimeout(timer);
    menuHovered = true;
    jQuery('html').addClass('fixed');
}, function() {
    clearTimeout(timer);
    menuHovered = false;
    jQuery('.pc-catalog').slideUp(300);
    setTimeout(() => {
    jQuery('html').removeClass('fixed');
    jQuery('.header').removeClass('header-open-menu');
    jQuery('.catalog-toggle').removeClass('active');
  }, 320);
  });

  jQuery('.pc-catalog .wrap .wrapper .item').hover(function(ev) {
    if (jQuery(this).next().length == 1) {
        jQuery('.pc-catalog .sub-menu').slideUp(0);
        jQuery('.pc-catalog .sub-menu').css('display', 'none');
        jQuery('.pc-catalog .wrap .wrapper .item').removeClass('active');
        jQuery(this).next().slideDown(0);
        jQuery(this).next().css('display', 'flex');
        jQuery(this).addClass('active');
    } else {
      jQuery('.pc-catalog .sub-menu').slideUp(0);
      jQuery('.pc-catalog .sub-menu').css('display', 'none');
      jQuery('.pc-catalog .wrap .wrapper .item').removeClass('active');
    }
    
  }, function(ev) {
    
  });
 
  //services-menu


} else {
  
  jQuery(window).scroll(function() { 
    if (jQuery(window).scrollTop() > 200) {
      jQuery('.mob-header').addClass('scrolled');
      jQuery('#up-arr').fadeIn(200);
    } else {
      jQuery('.mob-header').removeClass('scrolled');
      jQuery('#up-arr').fadeOut(200);
    }
  });

  jQuery('.mob-header .burger').on('click', function() {
      jQuery('.mob-menu').slideDown(200);
  });
  jQuery('.mob-menu .close').on('click', function() {
      jQuery('.mob-menu').slideUp(200);
      jQuery('.sub-menu').slideUp(200);
      jQuery('.menu_sublist').slideUp(200);
  });
  jQuery('.mob-menu .back-btn').on('click', function() {
      jQuery('.sub-menu').slideUp(200);
  });
  jQuery('.mob-cats .item').on('click', function(event) {
    if (jQuery(this).next().length == 1) {
      event.preventDefault();
      jQuery(this).next().slideDown(200);
    }
  });
  jQuery('.mob-nav .menu-item-has-children > span').on('click', function(event) {
    event.preventDefault();
    jQuery(this).next().next().slideDown(200);
  });
  jQuery('.mob-nav .menu-item-has-children > a').on('click', function(event) {
    event.preventDefault();
    jQuery(this).next().next().slideDown(200);
  });
  const mobNavChildrens = document.querySelectorAll('.mob-nav .menu-item-has-children ul');
  if (mobNavChildrens.length > 0) {
    mobNavChildrens.forEach(el => {
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
      jQuery(newBackBtn).on('click', function() {
        jQuery('.mob-nav .menu-item-has-children ul').slideUp(200);
      });
      const allLi = el.querySelectorAll('li');
      el.insertBefore(newBackBtn, allLi[0]);

    })
  }
  jQuery('.mob-menu .back-btn.main-btn').on('click', function() {
    jQuery('.menu_sublist').slideUp(200);
  });
  jQuery('#up-arr').on('click', function() {
    topScroll(500);
  })


} //endif screen width

