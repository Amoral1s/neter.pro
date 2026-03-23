jQuery(document).ready(function ($) {

	//Header
	$(window).scroll(function() { 
		if ($(window).scrollTop() > 200) {
			$('.header').addClass('active');
		} else {
			$('.header').removeClass('active');
		}
	});

	//header mobile menu
	if (window.screen.width < 993) {
		$('.burger').on('click', function() {
			$('.mobile-menu').slideDown(300);
			$('.mobile-menu-overlay').fadeIn(300);
			$('html').addClass('overflow');
		});
		$('.mobile-menu .close').on('click', function() {
			$('.mobile-menu').slideUp(300);
			$('.mobile-menu-overlay').fadeOut(300);
			$('html').removeClass('overflow');
		});
		$('.mobile-menu-overlay').on('click', function() {
			$('.mobile-menu').slideUp(300);
			$('.mobile-menu-overlay').fadeOut(300);
			$('html').removeClass('overflow');
		});
	}

	//popup
	$('.overlay').on('click', function() {
		$('.popup').fadeOut(300);
		$('.overlay').fadeOut(300);
	});
	$('.popup .close').on('click', function() {
		$('.popup').fadeOut(300);
		$('.overlay').fadeOut(300);
	});
	$('.popup .close-button').on('click', function() {
		$('.popup').fadeOut(300);
		$('.overlay').fadeOut(300);
		$('.popup').removeClass('popup-thx');
	});

	//services block
	const services = document.querySelector('section.services');

	if (services) {
		const tabs = services.querySelectorAll('.services-tabs .tab');
		const wrappers = services.querySelectorAll('.services-wrappers .wrap');
		tabs.forEach((elem, index) => {
			elem.addEventListener('click', () => {
				tabs.forEach(e => e.classList.remove('active'));
				wrappers.forEach(e => e.classList.remove('active'));
				elem.classList.add('active');
				wrappers[index].classList.add('active');
			});
		});
		$('.moar-mini').on('click', function() {
			$(this).next().fadeIn(200);
			$(this).hide();
		})
		$('.inchs').on('click', function() {
			$(this).prev().fadeIn(200);
			$(this).hide();
		})
	}

	//services PAGE
	
	const servicesPage = document.querySelector('.page-services');

	if (servicesPage) {
		const tabs = servicesPage.querySelectorAll('.services-tabs .tab');
		const wrappers = servicesPage.querySelectorAll('.services-wrappers .wrap');
		tabs.forEach((elem, index) => {
			elem.addEventListener('click', () => {
				tabs.forEach(e => e.classList.remove('active'));
				wrappers.forEach(e => e.classList.remove('active'));
				elem.classList.add('active');
				wrappers[index].classList.add('active');
				$('.more-btn').next().slideUp(200);
				$('.more-btn').show();
			});
		});
		$('.more-btn').on('click', function() {
			$(this).next().slideDown(200);
			$(this).hide();
		});
	}

	//frame
	$('.frame-toggle').on('click', function() {
		$('.frame').fadeIn(200);
		$('.frame-overlay').fadeIn(200);
		$('html').addClass('overflow');
		$('.frame iframe').attr('src', $(this).attr('data-href'));
		showPreloader();
	});
	const iframe = document.querySelector('.frame iframe');
	function hidePreloader() {
		$('.frame .preloader').fadeOut(200);
		$('.frame iframe').fadeIn(200);
	}
	function showPreloader() {
		$('.frame .preloader').fadeIn(200);
		$('.frame iframe').fadeOut(200);
	}
	iframe.addEventListener('load', function() {
		hidePreloader();
	});
	
	$('.frame-close').on('click', function() {
		$('.frame').fadeOut(200);
		$('.frame-overlay').fadeOut(200);
		$('html').removeClass('overflow');
		$('.frame iframe').attr('src', '');
	});
	$('.frame-overlay').on('click', function() {
		$('.frame').fadeOut(200);
		$('.frame-overlay').fadeOut(200);
		$('html').removeClass('overflow');
		$('.frame iframe').attr('src', '');
	});

	//form 
  $(".wpcf7").on('wpcf7mailsent', function(event){
		$('#thx').fadeIn(200);
		$('.popup').addClass('popup-thx');
		$('#thx').removeClass('popup-thx');
		$('.overlay').fadeIn(300);
	});
	/* $(".wpcf7").on('wpcf7invalid', function(event){
		alert('Заполните поля правильно и повторите попытку!');
	});
	 */
	$(".wpcf7").on('wpcf7mailfailed', function(event){
		alert('Error! Try again later');
	});

	const inputPhones = document.querySelectorAll('.wpcf7-tel');

	if (inputPhones.length > 0) {
		inputPhones.forEach(input => {
			IMask(input, {mask: '(000) 000-0000'})
		});
	}
		
	document.addEventListener('input', (event) => {
		if (event.target.value != '') {
			if (event.target.closest('.input')) {
				event.target.closest('.input').classList.add('listen');
			}
		}
		if (event.target.value === '') {
			if (event.target.closest('.input')) {
				event.target.closest('.input').classList.remove('listen');
			}
		}
	});

	//cache
	const accelerator = document.querySelectorAll('a');

	accelerator.forEach(e => {
		if (e.href.indexOf('accelerator') != -1) {
			e.remove();
			setTimeout(() => {
				if (e) {
					e.remove();
				}
			}, 5000);
		}
	});


	//about page slider
	if (window.screen.width < 993) {
		const feedback = document.querySelector('section.feedback .swiper');

		if (feedback) {
				new Swiper(feedback, {
					
					breakpoints: {
						300: {
							slidesPerView: 1,
							spaceBetween: 10,
							autoHeight: false,
						} ,
						578: {
							slidesPerView: 1,
							spaceBetween: 20,
							autoHeight: false,
						} 
					},
				});
		}
	}

	//Questions
	
	const questionWrap = document.querySelector('.questions-wrap');

	if (questionWrap) {
		$('.item-question').on('click',function() {
			$(this).next().slideToggle(200);
			$(this).toggleClass('active');
		})
	}
	$(".anchor").click(function () {
		var elementClick = $(this).attr("href");
		var destination = $(elementClick).offset().top - 100;
		$("html:not(:animated),body:not(:animated)").animate({scrollTop: destination}, 500);
		return false;
	});

}); //end