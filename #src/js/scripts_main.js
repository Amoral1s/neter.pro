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

	 
	$(".anchor").click(function () {
		var elementClick = $(this).attr("href");
		var destination = $(elementClick).offset().top - 100;
		$("html:not(:animated),body:not(:animated)").animate({scrollTop: destination}, 500);
		return false;
	});

	const html = document.querySelector('html');
function disableScroll() {
	html.classList.add('fixed');
}
function enableScroll() {
	html.classList.remove('fixed');
}
// Инициализация LightGallery для всех элементов галереи
function initializeGallery(selector) {
const galleryElements = document.querySelectorAll(selector);
if (galleryElements.length > 0) {
		galleryElements.forEach(elem => {
				// Добавление атрибута data-src для каждого элемента галереи
				const links = elem.querySelectorAll('a');
				if (links.length > 0) {
						links.forEach(link => {
								const imgSrc = link.getAttribute('href');
								link.setAttribute('data-src', imgSrc);
						});
				}
				const figures = elem.querySelectorAll('figure');
				if (figures.length > 0) {
						figures.forEach(figure => {
							const imgSrc = figure.querySelector('a').getAttribute('href');
							if (imgSrc) {
								figure.setAttribute('data-src', imgSrc);
							}
						});
				}
				const divs = elem.querySelectorAll('div');
				if (divs.length > 0) {
						divs.forEach(div => {
								const imgSrc = div.getAttribute('href');
								div.setAttribute('data-src', imgSrc);
						});
				}
				lightGallery(elem, {
						thumbnail: true,
						animateThumb: false,
						showThumbByDefault: false,
						plugins: [lgThumbnail],
						swipeThreshold: 50,
						mode: 'lg-fade',
						download: false,
						mobileSettings: {
								controls: true,
								showCloseIcon: true
						}
				});
				// Добавление обработчиков событий для открытия и закрытия галереи
				elem.addEventListener('lgBeforeOpen', () => {
						disableScroll();
				});
				elem.addEventListener('lgAfterClose', () => {
						enableScroll();
				});
				console.log('Initialized LightGallery for', selector);
		});
	}
}
// Инициализация
initializeGallery('.mag-toggle');
initializeGallery('.magnific');
initializeGallery('.content .gallery');
initializeGallery('.content .wp-block-gallery');

const commLinks = document.querySelectorAll('.wpd-reply-to');
if (commLinks.length > 0) {
	commLinks.forEach(el => {
		const link = el.querySelector('a');
		if (link) {
			link.remove();
		}
	})
}
const commLinks2 = document.querySelectorAll('.comment-reply-title');
if (commLinks2.length > 0) {
	commLinks2.forEach(el => {
		const link = el.querySelector('a');
		if (link) {
			link.remove();
		}
	})
}
const props = document.querySelectorAll('.req .left .item b');
if (props.length > 0) {
	function copytext(el) {
		var $tmp = $("<textarea>");
		$("body").append($tmp);
		$tmp.val($(el).text()).select();
		document.execCommand("copy");
		$tmp.remove();
	}
	props.forEach(e => {
		e.addEventListener('click', () => {
			copytext(e);
			e.classList.add('active');
			setTimeout(() => {
				e.classList.remove('active');
			}, 1500);
		})
	})
}

}); //end