jQuery(document).ready(function ($) {


	

	
	//SINGLE POST SHARE
	$('.share-link').click(function() {
		var currentLink = window.location.href;
		var $temp = $("<input>");
		$("body").append($temp);
		$temp.val(currentLink).select();
		document.execCommand("copy");
		$temp.remove();
		alert("Ссылка скопирована: " + currentLink);
	});
	//ABOUT BLOCK INDEX
	$('.about-video .play').on('click', function() {
		$(this).closest('.about-video').find('iframe').fadeIn(1200);
		$(this).closest('.about-video').find('iframe').attr('src', $(this).closest('.about-video').find('iframe').attr('data-link'));
		$(this).fadeOut(1200);
		$(this).closest('.about-video').find('.view').fadeOut(1200);
	});
	//FAQ INDEX
	$('.faq .item-title').on('click', function() {
		$(this).next().slideToggle(200);
		$(this).toggleClass('active');
		$(this).parent().toggleClass('active');
	})
	//FAQ PAGE
	$('.faq-page-offer .answers .answer-title').on('click', function() {
		$(this).next().slideToggle(200);
		$(this).toggleClass('active');
	});
	$('.faq-page-offer .tabs .item').on('click', function() {
    $('.faq-page-offer .tabs .item').removeClass('active');
    $(this).addClass('active');
    var index = $(this).index(); 
    $('.faq-page-offer .answers').fadeOut(200, function() {
			$('.faq-page-offer .answers').eq(index).fadeIn(200);
    });
	});
	//MAG GALLERYS
	const elemGallery = document.querySelectorAll('.magnific');
	if (elemGallery.length > 0) {
		elemGallery.forEach(elem => {
			// Добавление атрибута data-src для каждого элемента галереи
			const links = elem.querySelectorAll('a');
			links.forEach(link => {
					const imgSrc = link.getAttribute('href');
					link.setAttribute('data-src', imgSrc);
			});
			console.log('Initializing LightGallery');
			// Инициализация LightGallery
			const gallery = lightGallery(elem, {
					thumbnail: true,
					animateThumb: false,
					showThumbByDefault: false,
					plugins: [lgThumbnail],
					selector: 'a',
					swipeThreshold: 50,
					mode: 'lg-fade',
					download: false,
					mobileSettings: {
							controls: true,
							showCloseIcon: true
					}
			});
		});
	}
	const contentGallery = document.querySelectorAll('.content .wp-block-gallery');
	if (contentGallery.length > 0) {
			contentGallery.forEach(elem => {
				// Добавление атрибута data-src для каждого элемента галереи
				const links = elem.querySelectorAll('a');
				links.forEach(link => {
						const imgSrc = link.getAttribute('href');
						link.setAttribute('data-src', imgSrc);
				});
				console.log('Initializing LightGallery');
				// Инициализация LightGallery
				const gallery = lightGallery(elem, {
						thumbnail: true,
						animateThumb: false,
						showThumbByDefault: false,
						plugins: [lgThumbnail],
						selector: 'a',
						swipeThreshold: 50,
						mode: 'lg-fade',
						download: false,
						mobileSettings: {
								controls: true,
								showCloseIcon: true
						}
				});
			});
	}

	const pageTextFeed = document.querySelector('.text-feed.page-feed');

	if (pageTextFeed) {
		const items = pageTextFeed.querySelectorAll('.item');
		if (items.length > 3) {
			const btn = pageTextFeed.querySelector('.moar-btn');
			btn.style.display = 'flex';
			btn.addEventListener('click', () => {
				$(items).fadeIn(200);
				btn.remove();
			})
		}
	}

	
}); //end