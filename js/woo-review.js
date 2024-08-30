jQuery(document).ready(function($) {
  var isLocal = ['localhost', '127.0.0.1', 'neter.local', 'localhost:3000'].includes(window.location.hostname) || window.location.hostname.endsWith('.local');

  $('#review_form').on('submit', 'form', function(e) {
      e.preventDefault();

      var $form = $(this);

      // Сброс сообщений об ошибках
      $('.woocommerce-error, .woocommerce-message').remove();

      if (typeof grecaptcha !== 'undefined' && !isLocal) {
          grecaptcha.ready(function() {
              grecaptcha.execute('6LeZlf8pAAAAALIprB1_PfRBJBKPfwXhT2IV3SWw', { action: 'submit' }).then(function(token) {
                  console.log('reCAPTCHA token received:', token); // Отладочный вывод
                  $form.prepend('<input type="hidden" name="recaptcha_response" value="' + token + '">');
                  submitForm($form);
              });
          });
      } else {
          console.log('reCAPTCHA not loaded or local environment'); // Отладочный вывод
          submitForm($form);
      }
  });
  function submitForm($form) {
      var formData = $form.serialize();
      $('input.submit').addClass('disabled');
      $.ajax({
          url: woocommerce_params.ajax_url,
          type: 'POST',
          data: formData + '&action=submit_review',
          success: function(response) {
            console.log(formData);
            console.log(response)
              if (response.success) {
                  $form.before('<div class="woocommerce-message">' + response.data.message + '</div>');
                  $form.find('textarea, input[type="text"], input[type="email"]').val('');
                  $form.find('input[name="rating"]').prop('checked', false);
                  console.log('Отзыв успешно отправлен'); // Отладочный вывод
                  $('.input').removeClass('listen');
              } else {
                  var errorMessage = '<div class="woocommerce-error">';
                  if (response.data && response.data.error) {
                      errorMessage += response.data.error;
                  } else {
                      errorMessage += 'Произошла неизвестная ошибка. Пожалуйста, попробуйте еще раз.';
                  }
                  errorMessage += '</div>';
                  $form.before(errorMessage);
              }
            $('input.submit').removeClass('disabled');
          },
          error: function(xhr, status, error) {
              console.log('AJAX ошибка:', error); // Отладочный вывод
                $('input.submit').removeClass('disabled');
          }
      });
  }

    const comments = document.querySelectorAll('.wrapper-feed .comments > li');
    const childrenClass = 'children';
    const maxVisibleComments = 3;
    let visibleComments = 0;

    comments.forEach((comment, index) => {
        if (visibleComments >= maxVisibleComments) {
            comment.style.display = 'none';
        } else {
            visibleComments++;
        }
    });

    if (comments.length > maxVisibleComments) {
        const btn = document.createElement('div');
        btn.classList.add('moar-btn');
        btn.textContent = 'Показать ещё';
        comments[0].parentElement.appendChild(btn);

        btn.addEventListener('click', function () {
            const hiddenComments = Array.from(comments).filter(comment => comment.style.display === 'none');

            if (hiddenComments.length > 0) {
                hiddenComments.forEach(comment => comment.style.display = 'block');
                btn.textContent = 'Скрыть';
            } else {
                comments.forEach((comment, index) => {
                    if (index >= maxVisibleComments) {
                        comment.style.display = 'none';
                    }
                });
                btn.textContent = 'Показать ещё';
            }
        });
    }
});