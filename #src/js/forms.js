jQuery(document).ready(function ($) {


		
  $(".wpcf7").on('wpcf7mailsent', function(event){

		if (event.detail.contactFormId == '203' || event.detail.contactFormId == '326') {
			$('#thx-catalog').fadeIn(200);
			$('.popup').addClass('popup-thx');
			$('#thx-catalog').removeClass('popup-thx');
			$('#thx').removeClass('popup-thx');
			$('.overlay').fadeIn(300);
		}  else if (event.detail.contactFormId == '327') {
			$('#thx-sub').fadeIn(200);
			$('.popup').addClass('popup-thx');
			$('#thx').removeClass('popup-thx');
			$('#thx-catalog').removeClass('popup-thx');
			$('#thx-sub').removeClass('popup-thx');
			$('.overlay').fadeIn(300);
		} else {
			$('#thx').fadeIn(200);
			$('.popup').addClass('popup-thx');
			$('#thx').removeClass('popup-thx');
			$('#thx-catalog').removeClass('popup-thx');
			$('.overlay').fadeIn(300);
		}
		$('.input.listen').removeClass('listen')
  });
  $(".wpcf7").on('wpcf7invalid', function(event){
    alert('Заполните поля правильно и повторите попытку!');
  });
  $(".wpcf7").on('wpcf7mailfailed', function(event){
    alert('Ошибка отправки! Попробуйте еще раз!');
  });
	
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

	const inputPhones = document.querySelectorAll('.wpcf7-tel');

	if (inputPhones.length > 0) {
		inputPhones.forEach(input => {
			IMask(input, {mask: '+{0} (000) 000-00-00'})
		});
	}


	$('.callback').on('click', function() {
		console.log()
		if ($(this).closest('#thx-catalog').length == 1) {
			$('.popup').fadeOut(300);
			$('#thx-catalog').fadeOut(300);
			$('.popup.popup-callback').fadeIn(300);
			$('.popup').removeClass('popup-thx');
			$('.overlay').fadeIn(300);
			$('html').addClass('fixed');
		} else {
			$('.popup.popup-callback').fadeIn(300);
			$('.popup').removeClass('popup-thx');
			$('.overlay').fadeIn(300);
			$('html').addClass('fixed');
		}
		
	});



	$('.call-tender').on('click', function() {
		$('.popup.popup-tender').fadeIn(300);
		$('.popup').removeClass('popup-thx');
		$('.overlay').fadeIn(300);
		$('html').addClass('fixed');
	});
	$('.call-faq').on('click', function() {
		$('.popup.popup-faq').fadeIn(300);
		$('.popup').removeClass('popup-thx');
		$('.overlay').fadeIn(300);
		$('html').addClass('fixed');
	});
	$('.call-catalog').on('click', function() {
		$('.popup.popup-catalog').fadeIn(300);
		$('.popup').removeClass('popup-thx');
		$('.overlay').fadeIn(300);
		$('html').addClass('fixed');
	});
	$('.call-vacancy').on('click', function() {
		$('.popup.popup-vacancy').fadeIn(300);
		$('.popup.popup-vacancy input[name="Vacancy"]').val($(this).attr('data-title'));
		$('.popup').removeClass('popup-thx');
		$('.overlay').fadeIn(300);
		$('html').addClass('fixed');
	});
	$('.video-data').on('click', function() {
		$('.popup.popup-video').fadeIn(200);
		$('.overlay').fadeIn(200);
		$('.popup.popup-video iframe').attr('src', $(this).attr('data-src'));
		$('html').addClass('fixed');
	});


	$('.overlay').on('click', function() {
		$('.popup').fadeOut(300);
		$('.mini-cart').fadeOut(300);
		$('.overlay').fadeOut(300);
		$('html').removeClass('fixed');
		$('.popup').removeClass('popup-thx');
    $('.product-tabs .wrapper-feed .right').fadeOut(200);
		$('.popup.popup-video iframe').attr('src', '');
		$('.popup.popup-service .service-pop-name').val('');
		$('.popup.popup-service .serv-name').text('');
	});
	$('.popup .close').on('click', function() {
		$('.popup').fadeOut(300);
		$('.overlay').fadeOut(300);
		$('html').removeClass('fixed');
		$('.popup').removeClass('popup-thx');
		$('.popup.popup-video iframe').attr('src', '');
	});
	$('.popup .close-button').on('click', function() {
		$('.popup').fadeOut(300);
		$('.overlay').fadeOut(300);
		$('html').removeClass('fixed');
		$('.popup').removeClass('popup-thx');
		$('.popup.popup-video iframe').attr('src', '');
	});

	$('.call-review').on('click', function() {
    $('.product-tabs .wrapper-feed .right').fadeIn(200);
    $('.overlay').fadeIn(200);
    $('html').addClass('fixed');
  });

  $('.product-tabs .wrapper-feed .right .close').on('click', function() {
    $('.product-tabs .wrapper-feed .right').fadeOut(200);
    $('.overlay').fadeOut(200);
    $('html').removeClass('fixed');
  });



	// Функция для скрытия окна cookie и установки cookie на 1 месяц
	function hideCookieWindow() {
		document.querySelector('.cookie').style.display = 'none';
		
		// Установка cookie на 1 месяц с помощью JavaScript
		let now = new Date();
		let monthLater = new Date(now.getTime() + 30 * 24 * 60 * 60 * 1000);
		document.cookie = 'acceptedCookie=true; expires=' + monthLater.toUTCString() + '; path=/';
	}

	document.querySelector('.cookie .button').addEventListener('click', hideCookieWindow);

	// Проверка, показывать ли окно cookie при загрузке страницы
	if (document.cookie.split(';').some((item) => item.trim().startsWith('acceptedCookie='))) {
		document.querySelector('.cookie').style.display = 'none';
	} else {
		document.querySelector('.cookie').style.display = 'block';
	}

	
	const ratingFeed = document.querySelectorAll('input[name="rating"]');

	if (ratingFeed.length > 0) {
		let rating = 5;
		function checkRating() {
			ratingFeed.forEach((elem, index) => {
				if (elem.checked) {
					rating = index + 1;
					ratingFeed.forEach(e => e.closest('label').classList.remove('active'));

					elem.closest('label').classList.add('active');
					ratingFeed.forEach((e, i) => {
						if (i <= index) {
							e.closest('label').classList.add('active');
						}
					})
				} 
			})
		}
		ratingFeed.forEach((elem, index) => {
			elem.closest('label').classList.add('active');
			elem.addEventListener('change', () => {
				checkRating();
			});
		});
		
	}

	$('input[type="file"]').change(function() {
    var fileInput = $(this);
    var fileName = fileInput.val().split('\\').pop();
    var fileTextDiv = $(this).closest('.input-file').find('.input-file-text');
		console.log(fileTextDiv)
    if (fileName) {
      fileTextDiv.text('Загружен файл: "' + fileName + '"');
      fileTextDiv.show();
    } else {
      fileTextDiv.hide();
    }
  });

	


}); //end
