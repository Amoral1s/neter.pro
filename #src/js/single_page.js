jQuery(document).ready(function ($) {

	const singlePageRef = document.querySelector('.only-single-page');
	if (!singlePageRef) {
	 return
	}
 

 
	 const starRatingFunc = () => {
		 const stars = document.querySelectorAll('.popup.review .form-stars img');
		 const starsWrap = stars[0].parentElement;
 
		 stars.forEach((e, i) => {
			 e.addEventListener('click', (event) => {
				 starsWrap.classList.add('selected');
				 $('.stars-input').val(i + 1)
				 stars.forEach(e => {
					 e.classList.remove('active')
				 })
				 for (let r = 0; r < i + 1; r++) {
					 stars[r].classList.add('active');
				 }
				 
			 })
		 })
		 
		 $(stars).hover(function() {
			 if (!starsWrap.classList.contains('selected')) {
				 $(this).addClass('active');
				 $(this).prev().addClass('active');
				 $(this).prev().prev().addClass('active');
				 $(this).prev().prev().prev().addClass('active');
				 $(this).prev().prev().prev().prev().addClass('active');
			 }
		 }, function() {
			 if (!starsWrap.classList.contains('selected')) {
				 $(this).removeClass('active');
				 $(this).prev().removeClass('active');
				 $(this).prev().prev().removeClass('active');
				 $(this).prev().prev().prev().removeClass('active');
				 $(this).prev().prev().prev().prev().removeClass('active');
			 }
 
			 
		 });
 
	 }
	 
 
	 const singlePage = document.querySelector('.only-single-page');
 
	 if (singlePage) {
		 $('.wpd-rating-title').text('Оцените статью');
		 $('.wpd-thread-info').text('Комментарии к статье');
		 const navWrap = document.querySelector('.single-nav-wrap');
		 if (!navWrap) {
			 return
		 }
		 const navWrapParent = navWrap.parentElement;
		 const content = document.querySelector('.single__main .content');
		 const headings = content ? content.querySelectorAll('h2') : [];
		 let elems = 0;

		 navWrap.innerHTML = '';
		 headings.forEach((heading) => {
			 const headingText = heading.textContent.trim();
			 if (!headingText) {
				 return
			 }

			 let headingId = `anchor-${elems + 1}`;
			 let idIndex = elems + 2;

			 while (document.getElementById(headingId) && document.getElementById(headingId) !== heading) {
				 headingId = `anchor-${idIndex}`;
				 idIndex++;
			 }

			 heading.id = headingId;

			 const navLink = document.createElement('a');
			 navLink.setAttribute('href', `#${headingId}`);
			 navLink.classList.add('anchor');
			 navLink.textContent = headingText;
			 navWrap.appendChild(navLink);
			 elems++;
		 });
		 $('.single-nav b').on('click', function() {
			$(this).toggleClass('active');
			$(this).next().slideToggle(200);
		 });

		$(".anchor").click(function () {
			var elementClick = $(this).attr("href");
			var target = document.getElementById(elementClick.replace('#', ''));
			if (!target) {
				return false;
			}
			var destination = $(target).offset().top - 100;
			$("html:not(:animated),body:not(:animated)").animate({scrollTop: destination}, 500);
			return false;
		});

		 if (elems === 0) {
			 navWrapParent.remove();
		 }
		 /* const rating = document.querySelector('.wpd-rating-stars').cloneNode(true);
		 const ratngTopWrap = document.querySelector('.new-rating');
		 const ratngVotes = document.querySelector('.wpd-rating-value .wpdrc').textContent;
		 const votes = document.querySelector('.votes');
 
		 ratngTopWrap.appendChild(rating);
		 votes.textContent = ratngVotes; */
	 }

	 


	
 
 }); //end
