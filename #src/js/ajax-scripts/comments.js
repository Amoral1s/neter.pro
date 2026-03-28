jQuery(document).ready(function($) {
	const mainThemeData = window.mainThemeData || {};
	const ajaxUrl = mainThemeData.ajax_url || '/wp-admin/admin-ajax.php';
	const isLocalComment = Boolean(mainThemeData.is_local_comment);
	const commentRecaptchaSiteKey = mainThemeData.comment_recaptcha_site_key || '';

	$('.faq-comments .comment-respond .mini-title').text('Задать вопрос');
	$('.faq-comments .comment-respond #comment').attr('placeholder', 'Ваш вопрос');


	$(document).on('click', '.comment-reply-link', function(e) {
		e.preventDefault();

		const commentId = $(this).data('commentid');
		const authorName = $(this).data('replyto') || 'комментатору';

		$('#comment_parent').val(commentId);

		const $replyWrap = $('.reply-to-wrap');
		if ($replyWrap.length) {
			$replyWrap.html(`
				Ответ на комментарий — <span class="reply-to">${authorName}. </span>
				<span class="cancel-reply">Отменить</span>
			`);
			$replyWrap.addClass('active');
		}

		const $form = $('#respond');
		if ($form.length) {
			$('html, body').animate({ scrollTop: $form.offset().top - 100 }, 500);
		}
	});

	// Обработка клика на "Отменить"
	$(document).on('click', '.cancel-reply', function() {
		$('#comment_parent').val(0);
		$('.reply-to-wrap').html('');
		$('.reply-to-wrap').removeClass('active');
	});


	function loadRecaptcha(callback) {
		if (typeof grecaptcha !== 'undefined') {
			console.log("✅ reCAPTCHA уже загружена.");
			callback();
		} else {
			console.log("🔄 Загружаем reCAPTCHA...");
			$.getScript("https://www.google.com/recaptcha/api.js?render=" + commentRecaptchaSiteKey)
				.done(function() {
					console.log("✅ reCAPTCHA загружена.");
					callback();
				})
				.fail(function(jqxhr, settings, exception) {
					console.error("❌ Ошибка загрузки reCAPTCHA:", exception);
			});
		}
	} 

	function handleCommentFormSubmission(formSelector, action) {
			const form = $(formSelector);
			if (!form.length) return;

			form.on('submit', function(e) {
					e.preventDefault();
					var $form = $(this);
					$('.comment-error, .comment-success').remove();

					if (isLocalComment || !commentRecaptchaSiteKey || commentRecaptchaSiteKey === 'YOUR_SITE_KEY') {
							console.warn("⚠️ reCAPTCHA отключена (локальный сервер или отсутствует ключ).");
							submitCommentForm($form, action);
							return;
					}

					loadRecaptcha(function() {
							grecaptcha.ready(function() {
									grecaptcha.execute(commentRecaptchaSiteKey, { action: 'submit' }).then(function(token) {
											console.log("✅ reCAPTCHA выполнена. Токен:", token);
											$form.prepend('<input type="hidden" name="recaptcha_response" value="' + token + '">');
											submitCommentForm($form, action);
									}).catch(function(error) {
											console.error("❌ Ошибка reCAPTCHA:", error);
											submitCommentForm($form, action);
									});
							});
					});
			}); 
	}

	function submitCommentForm($form, action) {
			var formData = $form.serialize();
			$('input#submit').addClass('disabled');

			$.ajax({
					url: ajaxUrl,
					type: 'POST',
					data: formData + '&action=' + action,
					success: function(response) {
							console.log('form-data', formData);
							console.log('response', response);

							if (response.success) {
									$form.before('<div class="comment-success">' + response.data.message + '</div>');
									$form[0].reset();
									console.log(action + ' успешно отправлено');
							} else {
									var errorMessage = '<div class="comment-error">';
									errorMessage += response.data && response.data.error ? response.data.error : 'Произошла неизвестная ошибка. Пожалуйста, попробуйте еще раз.';
									errorMessage += '</div>';
									$form.before(errorMessage);
							}
							$('input#submit').removeClass('disabled');
							$('.input').removeClass('listen');
					},
					error: function(xhr, status, error) {
							console.log('❌ AJAX ошибка:', error);
							$('input#submit').removeClass('disabled');
					}
			});
	}

	// Инициализируем обработчик только для формы комментария
	handleCommentFormSubmission('#commentform', 'submit_comment');

});
