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
		 const content = document.querySelector('.content');
		 const contentBlocks = content.querySelectorAll('*');
		 let elems = 0;
		 contentBlocks.forEach((elem, index) => {
			 if (elem.id) {
				 if (
							elem.closest('.line') || 
							elem.closest('.product') || 
							elem.classList.contains('wpcf7') || 
							elem.classList.contains('awooc-custom-order') || 
							elem.classList.contains('swiper-wrapper') 
						) 
					{
					 return
				 }
				 const navLink = document.createElement('a');
				 navLink.href = `#${elem.id}`;
				 navLink.classList.add('anchor');
				 navLink.textContent = elem.id.replace(/\-/g, ' ');
				 navWrap.appendChild(navLink);
				 elems++;
			 }
		 });
		 if (elems === 0) {
			 navWrapParent.remove();
		 }
		 const rating = document.querySelector('.wpd-rating-stars').cloneNode(true);
		 const ratngTopWrap = document.querySelector('.new-rating');
		 const ratngVotes = document.querySelector('.wpd-rating-value .wpdrc').textContent;
		 const votes = document.querySelector('.votes');
 
		 ratngTopWrap.appendChild(rating);
		 votes.textContent = ratngVotes;
	 }

	 


	
 
 }); //end