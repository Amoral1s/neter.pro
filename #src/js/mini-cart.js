jQuery(document).ready(function($) {
	let ajaxQueue = $({});
        const singlePage = document.querySelector('.single-product');
        // Управление доступностью страницы каталога во время AJAX-запросов
        $(document).ajaxStart(function() {
            if (!singlePage) {
                $('main.catalog-page').addClass('disabled');
            }
            $('.mini-cart-content').addClass('disabled');
        }).ajaxStop(function() {
            $('main.catalog-page').removeClass('disabled');
            $('.mini-cart-content').removeClass('disabled');
        });

        

  // Получаем данные корзины и обновляем состояние кнопок и cart-toggle
	function updateCartData() {
		ajaxQueue.queue(function(next) {
			$.ajax({
				url: '/wp-admin/admin-ajax.php',
				type: 'POST',
				data: { action: 'get_cart_data' },
				success: function(response) {
					try {
						window.WC_CART = typeof response === 'string' ? JSON.parse(response) : response;
					} catch (e) {
						console.error('Ошибка парсинга JSON:', e);
						window.WC_CART = [];
					}
					updateButtonStates();
					updateCartToggle();
				},
				error: function(error) {
					console.error('Ошибка при получении данных корзины:', error);
					window.WC_CART = [];
					updateButtonStates();
					updateCartToggle();
				},
				complete: function() {
					next();
				}
			});
		});
	}

  // Обновляем состояние кнопок
  function updateButtonStates() {
      $('li.table-product .button').each(function() {
          var $button = $(this);
          var productId = $button.data('product_id');
          var inCart = window.WC_CART.some(function(item) {
              return item.product_id == productId;
          });

          if (inCart) {
              $button.addClass('added').text('Убрать из корзины');
          } else {
              $button.removeClass('added').text('В корзину');
          }
      });
  }

  // Обновляем cart-toggle
  function updateCartToggle() {
      if (window.WC_CART.length === 0) {
          $('.cart-toggle').fadeOut(200);
      } else {
          $('.cart-count').text(window.WC_CART.length);
          $('.cart-toggle').fadeIn(200);
      }
  }

	// Обработчики для каталога
	function initializeProductHandlers() {
		$('main.catalog-page').on('click', 'li.table-product', function(event) {
			if ($(event.target).closest('.table-product-title').length || $(event.target).closest('.button').length) {
				return;
			}
			$(this).find('.button').trigger('click');
		});
	
		$('main.catalog-page').on('click', 'li.table-product .button', function(event) {
			event.preventDefault();
			var $button = $(this);
			var productId = $button.data('product_id');
			var $li = $button.closest('li.table-product');
	
			$li.addClass('loading');
			$('.cart-toggle').addClass('loading');
	
			if ($button.hasClass('added')) {
				removeFromCart(productId, function() {
					$button.removeClass('added').text('В корзину');
					$li.removeClass('loading');
					updateCartData();
				});
			} else {
				addToCart(productId, function() {
					$button.addClass('added').text('Убрать из корзины');
					$li.removeClass('loading');
					updateCartData();
				});
			}
		});
	
		updateCartData();
	}

  // Добавление товара в корзину
  function addToCart(productId, callback) {
      $.ajax({
          url: wc_add_to_cart_params.wc_ajax_url.toString().replace('%%endpoint%%', 'add_to_cart'),
          type: 'POST',
          data: {
              product_id: productId
          },
          success: function(response) {
              //console.log('Ответ сервера при добавлении:', response);
              if (callback) callback(response);
              $('.cart-toggle').removeClass('loading');
          },
          error: function() {
              $('.cart-toggle').removeClass('loading');
          }
      });
  }

  // Очистка корзины
	function clearCart(callback) {
			$.ajax({
							url: '/wp-admin/admin-ajax.php',
							type: 'POST',
							data: {
											action: 'clear_cart'
							},
							success: function(response) {
											//console.log('Корзина очищена:', response);
											if (callback) callback(response);
							},
							error: function(error) {
											console.error('Ошибка при очистке корзины:', error);
							}
			});
	}

	// Обработчик для отправки формы CF7
	document.addEventListener('wpcf7mailsent', function(event) {
			clearCart(function() {
					if (event.detail.contactFormId == '787') {
							//console.log('Корзина очищена после отправки формы');
							updateMiniCart();
							updateButtonStates();
							$('li.table-product .button').removeClass('added');
							$('button[type="submit"]').removeClass('added');
							$('.cart-toggle').fadeOut(200);
					}
			});
	}, false);

	$('.mini-cart .clear-cart').on('click', function() {
        clearCart(function() {
            updateMiniCart();
            updateButtonStates();
            $('li.table-product .button').removeClass('added');
            $('button[type="submit"]').removeClass('added');
            $('.cart-toggle').fadeOut(200);
        });
    }) 

  // Удаление товара из корзины
  function removeFromCart(productId, callback) {
      $.ajax({
          url: '/wp-admin/admin-ajax.php',
          type: 'POST',
          data: {
              action: 'remove_from_cart',
              product_id: productId
          },
          success: function(response) {
              //console.log('Ответ сервера при удалении:', response);
              if (callback) callback(response);
              $('.cart-toggle').removeClass('loading');
          },
          error: function() {
              $('.cart-toggle').removeClass('loading');
          }
      });
  }

  // Обновление мини-корзины при открытии
  function updateMiniCart() {
      $.ajax({
          url: '/wp-admin/admin-ajax.php',
          type: 'POST',
          data: {
              action: 'get_mini_cart_data'
          },
          success: function(response) {
              try {
                  if (typeof response === 'string') {
                      var cartData = JSON.parse(response);
                  } else {
                      var cartData = response;
                  }
                  renderMiniCart(cartData);
              } catch (e) {
                  console.error('Ошибка парсинга JSON:', e);
              }
              $('.cart-toggle').removeClass('loading');
          },
          error: function(error) {
              console.error('Ошибка при получении данных мини-корзины:', error);
          }
      });
  }

  function renderMiniCart(cartData) {
    var $miniCartContent = $('.mini-cart-content');
    $miniCartContent.empty();
    
    var placeholderImage = '/wp-content/uploads/woocommerce-placeholder-600x600.png'; // путь к изображению-заглушке

    if (cartData.length === 0) {
        $('.mini-cart').fadeOut(200);
        $('.overlay').fadeOut(200);
        return;
    }

    cartData.forEach(function(item) {
        var attributesHtml = '';
        if (item.napryazhenie) {
            attributesHtml += `
            <div class="attr">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M8.62814 12.6736H8.16918C6.68545 12.6736 5.94358 12.6736 5.62736 12.1844C5.31114 11.6953 5.61244 11.0138 6.21504 9.65083L8.02668 5.55323C8.57457 4.314 8.84852 3.69438 9.37997 3.34719C9.91142 3 10.5859 3 11.935 3H14.0244C15.6632 3 16.4826 3 16.7916 3.53535C17.1007 4.0707 16.6942 4.78588 15.8811 6.21623L14.8092 8.10188C14.405 8.81295 14.2029 9.16849 14.2057 9.45952C14.2094 9.83775 14.4105 10.1862 14.7354 10.377C14.9854 10.5239 15.3927 10.5239 16.2074 10.5239C17.2373 10.5239 17.7523 10.5239 18.0205 10.7022C18.3689 10.9338 18.5513 11.3482 18.4874 11.7632C18.4382 12.0826 18.0918 12.4656 17.399 13.2317L11.8639 19.3523C10.7767 20.5545 10.2331 21.1556 9.86807 20.9654C9.50303 20.7751 9.67833 19.9822 10.0289 18.3962L10.7157 15.2896C10.9826 14.082 11.1161 13.4782 10.7951 13.0759C10.4741 12.6736 9.85877 12.6736 8.62814 12.6736Z" stroke="#2CB4C2" stroke-width="1.5" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="attr-name">
                    ${item.napryazhenie}
                </div>
            </div>`;
        }
        if (item.emkost) {
            attributesHtml += `
            <div class="attr">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M2 12C2 9.17157 2 7.75736 2.87868 6.87868C3.75736 6 5.17157 6 8 6H13C15.8284 6 17.2426 6 18.1213 6.87868C19 7.75736 19 9.17157 19 12C19 14.8284 19 16.2426 18.1213 17.1213C17.2426 18 15.8284 18 13 18H8C5.17157 18 3.75736 18 2.87868 17.1213C2 16.2426 2 14.8284 2 12Z" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round"/>
                        <path d="M19 9.5L20.0272 9.6712C20.7085 9.78475 21.0491 9.84152 21.3076 10.0067C21.5618 10.1691 21.7612 10.4044 21.8796 10.6819C22 10.964 22 11.3093 22 12C22 12.6907 22 13.036 21.8796 13.3181C21.7612 13.5956 21.5618 13.8309 21.3076 13.9933C21.0491 14.1585 20.7085 14.2153 20.0272 14.3288L19 14.5" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round"/>
                        <path d="M6 10V14" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round"/>
                        <path d="M9 10V14" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round"/>
                        <path d="M12 10V14" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                </div>
                <div class="attr-name">
                    ${item.emkost}
                </div>
            </div>`;
        }

        var productImage = item.thumbnail ? item.thumbnail : placeholderImage;

        var productHtml = `
            <div class="item" data-product_id="${item.product_id}">
                <div class="thumb"><img src="${productImage}" alt="${item.product_name}"></div>
                <div class="meta">
                    <div class="load-circle"></div>
                    <a class="product-name" href="${item.product_link}">${item.product_name}</a>
                    <div class="product-attrs">${attributesHtml}</div>
                </div>
                <div class="quantity">
                    <div class="minus">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M20 12H4" stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <input type="number" value="${item.quantity}" min="1" />
                    <div class="plus">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M12 4V20M20 12H4" stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>
            </div>`;
        $miniCartContent.append(productHtml);
    });
    
    $('.cart-count').text(cartData.length);
    $('.mini-cart').fadeIn(200);
    $('.overlay').fadeIn(200);
}

  // Обработчики для мини-корзины
  $(document).on('click', '.quantity .plus', function() {
      var $item = $(this).closest('.item');
      var productId = $item.data('product_id');
      var $quantityInput = $item.find('input');
      var quantity = parseInt($quantityInput.val()) + 1;

      $item.addClass('loading');
      updateCartItem(productId, quantity, function() {
          $quantityInput.val(quantity);
          $item.removeClass('loading');
      });
  });

	// Обработчики для мини-корзины
	$(document).on('click', '.quantity .minus', function() {
		var $item = $(this).closest('.item');
		var productId = $item.data('product_id');
		var $quantityInput = $item.find('input');
		var quantity = parseInt($quantityInput.val()) - 1;

		$item.addClass('loading');
		if (quantity < 1) {
				removeCartItem(productId, function() {
						updateCartData(); // Обновляем данные корзины после удаления товара
						$item.remove();
						$('.cart-toggle').removeClass('loading');
				});
		} else {
				updateCartItem(productId, quantity, function() {
						$quantityInput.val(quantity);
						updateCartData(); // Обновляем данные корзины после изменения количества товара
						$item.removeClass('loading');
				});
		}
	});


	$(document).on('change', '.quantity input', function() {
		var $item = $(this).closest('.item');
		var productId = $item.data('product_id');
		var quantity = parseInt($(this).val());

		$item.addClass('loading');
		if (quantity < 1) {
				removeCartItem(productId, function() {
						updateCartData(); // Обновляем данные корзины после удаления товара
						$item.remove();
						$('.cart-toggle').removeClass('loading');
				});
		} else {
				updateCartItem(productId, quantity, function() {
						updateCartData(); // Обновляем данные корзины после изменения количества товара
						$item.removeClass('loading');
				});
		}
	});

  $(document).on('click', '.cart-toggle', function() {
      $(this).addClass('loading');
      updateMiniCart();
  });

  $(document).on('click', '.mini-cart .close', function() {
      $('.overlay').fadeOut(200);
      $('.mini-cart').fadeOut(200);
  });

  // Обновление количества товара в корзине
  function updateCartItem(productId, quantity, callback) {
      $.ajax({
          url: '/wp-admin/admin-ajax.php',
          type: 'POST',
          data: {
              action: 'update_mini_cart_item',
              product_id: productId,
              quantity: quantity
          },
          success: function(response) {
              if (callback) callback(response);
          }
      });
  }

	// Удаление товара из корзины
	function removeCartItem(productId, callback) {
		ajaxQueue.queue(function(next) {
			$.ajax({
				url: '/wp-admin/admin-ajax.php',
				type: 'POST',
				data: { action: 'remove_mini_cart_item', product_id: productId },
				success: function(response) {
					updateMiniCart(); // Обновляем мини-корзину после удаления товара
					if (callback) callback(response);
				},
				complete: function() {
					
					next();
				}
			});
		});
	}

  // Обработчик для single продукта
  $('form.cart').on('submit', function(event) {
    event.preventDefault();
    var $form = $(this);
    var $button = $form.find('button[type="submit"]');
    var productId = $button.val();

    $button.addClass('loading');
    $('.cart-toggle').addClass('loading');

    addToCart(productId, function() {
        $button.removeClass('loading').addClass('added');
        updateCartData();
        showMiniCart();
      });
  });

  // Показать мини-корзину
  function showMiniCart() {
      updateMiniCart();
      $('.overlay').fadeIn(200);
      $('.mini-cart').fadeIn(200);
  }

  // Инициализация
  updateCartData();
  initializeProductHandlers();

    $(document).ajaxComplete(function(event, xhr, settings) {
        if (settings.url.includes('some_specific_action')) {
            console.log('Reinitializing handlers after specific AJAX completion');
            initializeProductHandlers();
        }
    });

});