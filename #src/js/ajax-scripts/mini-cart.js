jQuery(document).ready(function($) {
    const settings = window.mainThemeData || {};
    const ajaxUrl = settings.ajax_url || '/wp-admin/admin-ajax.php';
    const cartCookieName = settings.cart_cookie_name || 'neter_cart';
    const cartProductsAction = settings.cookie_cart_products_action || 'get_cookie_cart_products';
    const placeholderImage = settings.placeholder_image || '/wp-content/uploads/woocommerce-placeholder-600x600.png';
    const cartFormId = parseInt(settings.cart_form_id || '787', 10);

    let cartProductsCache = [];

    function toInt(value) {
        const parsed = parseInt(value, 10);
        return Number.isFinite(parsed) ? parsed : 0;
    }

    function debounce(fn, wait) {
        let timeout = null;

        return function() {
            const args = arguments;
            const context = this;
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                fn.apply(context, args);
            }, wait);
        };
    }

    function readCart() {
        const cookieMatch = document.cookie.match(new RegExp('(?:^|; )' + cartCookieName.replace(/([.$?*|{}()\[\]\\/+^])/g, '\\$1') + '=([^;]*)'));

        if (!cookieMatch || !cookieMatch[1]) {
            return [];
        }

        try {
            const decoded = decodeURIComponent(cookieMatch[1]);
            const parsed = JSON.parse(decoded);
            return normalizeCart(parsed);
        } catch (error) {
            return [];
        }
    }

    function normalizeCart(rawCart) {
        if (!Array.isArray(rawCart)) {
            return [];
        }

        const uniqueItems = [];
        const existsMap = {};

        rawCart.forEach(function(item) {
            const productId = toInt(item && item.product_id);
            const quantity = Math.max(1, toInt(item && item.quantity));

            if (!productId) {
                return;
            }

            if (existsMap[productId]) {
                existsMap[productId].quantity = quantity;
                return;
            }

            const normalizedItem = {
                product_id: productId,
                quantity: quantity,
            };

            uniqueItems.push(normalizedItem);
            existsMap[productId] = normalizedItem;
        });

        return uniqueItems;
    }

    function writeCart(cart) {
        const normalizedCart = normalizeCart(cart);

        if (!normalizedCart.length) {
            clearCartCookie();
            return;
        }

        const payload = encodeURIComponent(JSON.stringify(normalizedCart));
        document.cookie = cartCookieName + '=' + payload + '; path=/; SameSite=Lax';
    }

    function clearCartCookie() {
        document.cookie = cartCookieName + '=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/; SameSite=Lax';
    }

    function getCartIds() {
        return readCart().map(function(item) {
            return item.product_id;
        });
    }

    function isProductInCart(productId) {
        const cleanProductId = toInt(productId);

        if (!cleanProductId) {
            return false;
        }

        return readCart().some(function(item) {
            return item.product_id === cleanProductId;
        });
    }

    function setCartItem(productId, quantity) {
        const cleanProductId = toInt(productId);
        const cleanQuantity = Math.max(1, toInt(quantity));

        if (!cleanProductId) {
            return;
        }

        const cart = readCart();
        const existingItem = cart.find(function(item) {
            return item.product_id === cleanProductId;
        });

        if (existingItem) {
            existingItem.quantity = cleanQuantity;
        } else {
            cart.push({
                product_id: cleanProductId,
                quantity: cleanQuantity,
            });
        }

        writeCart(cart);
    }

    function removeCartItem(productId) {
        const cleanProductId = toInt(productId);

        if (!cleanProductId) {
            return;
        }

        const cart = readCart().filter(function(item) {
            return item.product_id !== cleanProductId;
        });

        writeCart(cart);
    }

    function clearCart() {
        clearCartCookie();
        cartProductsCache = [];
        syncCartUi();
        renderMiniCart([], false);
    }

    function syncWindowCart() {
        window.WC_CART = readCart().map(function(item) {
            return {
                product_id: item.product_id,
                quantity: item.quantity,
            };
        });
    }

    function updateButtonStates() {
        const cartIds = getCartIds();

        $('li.table-product .button').each(function() {
            const $button = $(this);
            const productId = toInt($button.data('product_id') || $button.val());
            const $product = $button.closest('li.table-product');
            const isAdded = cartIds.includes(productId);
            const buttonText = isAdded ? 'Убрать из корзины' : 'В корзину';

            if (!productId) {
                return;
            }

            if ($button.text() !== buttonText) {
                $button.text(buttonText);
            }

            if (isAdded) {
                $button.addClass('added');
                $product.addClass('added-product');
            } else {
                $button.removeClass('added');
                $product.removeClass('added-product');
            }
        });

        $('form.cart button.single_add_to_cart_button').each(function() {
            const $button = $(this);
            const productId = toInt($button.val() || $button.data('product_id'));

            if (!productId) {
                return;
            }

            $button.toggleClass('added', cartIds.includes(productId));
        });
    }

    function updateCartToggle() {
        const itemsCount = readCart().length;

        if (!itemsCount) {
            $('.cart-count').text('0');
            $('.cart-toggle').stop(true, true).fadeOut(200);
            return;
        }

        $('.cart-count').text(itemsCount);
        $('.cart-toggle').stop(true, true).fadeIn(200);
    }

    function syncCartUi() {
        syncWindowCart();
        updateButtonStates();
        updateCartToggle();
    }

    function normalizeCartProducts(productRows) {
        const byId = {};
        const hasProductRows = Array.isArray(productRows) && productRows.length > 0;

        if (!hasProductRows) {
            return [];
        }

        productRows.forEach(function(item) {
            const productId = toInt(item && item.product_id);

            if (!productId) {
                return;
            }

            byId[productId] = item;
        });

        const cart = readCart();
        const validCart = [];
        const result = [];

        cart.forEach(function(cartItem) {
            if (!byId[cartItem.product_id]) {
                return;
            }

            validCart.push(cartItem);
            result.push(Object.assign({}, byId[cartItem.product_id], {
                quantity: cartItem.quantity,
            }));
        });

        if (validCart.length !== cart.length) {
            writeCart(validCart);
            syncCartUi();
        }

        return result;
    }

    function updateProductDataField(cartItems) {
        const productDataField = document.querySelector('.mini-cart textarea[name="ProductData"]');

        if (!productDataField) {
            return;
        }

        if (!cartItems.length) {
            productDataField.value = '';
            return;
        }

        let productData = '';

        cartItems.forEach(function(item) {
            productData += 'Товар: ' + (item.product_name || '') + '\n';
            productData += 'Артикул: ' + (item.sku || '') + '\n';
            productData += 'Ссылка: ' + (item.product_link || '') + '\n';
            productData += 'Количество: ' + (item.quantity || 1) + '\n\n';
        });

        productDataField.value = productData;
    }

    function renderMiniCart(cartItems, shouldOpen) {
        const $miniCartContent = $('.mini-cart-content');
        $miniCartContent.empty();

        if (!cartItems.length) {
            updateProductDataField([]);

            if (shouldOpen) {
                $('.overlay').fadeOut(200);
                $('.mini-cart').fadeOut(200);
            }

            return;
        }

        cartItems.forEach(function(item) {
            let attributesHtml = '';

            if (item.napryazhenie) {
                attributesHtml += '\n                <div class="attr">\n                    <div class="icon">\n                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">\n                            <path d="M8.62814 12.6736H8.16918C6.68545 12.6736 5.94358 12.6736 5.62736 12.1844C5.31114 11.6953 5.61244 11.0138 6.21504 9.65083L8.02668 5.55323C8.57457 4.314 8.84852 3.69438 9.37997 3.34719C9.91142 3 10.5859 3 11.935 3H14.0244C15.6632 3 16.4826 3 16.7916 3.53535C17.1007 4.0707 16.6942 4.78588 15.8811 6.21623L14.8092 8.10188C14.405 8.81295 14.2029 9.16849 14.2057 9.45952C14.2094 9.83775 14.4105 10.1862 14.7354 10.377C14.9854 10.5239 15.3927 10.5239 16.2074 10.5239C17.2373 10.5239 17.7523 10.5239 18.0205 10.7022C18.3689 10.9338 18.5513 11.3482 18.4874 11.7632C18.4382 12.0826 18.0918 12.4656 17.399 13.2317L11.8639 19.3523C10.7767 20.5545 10.2331 21.1556 9.86807 20.9654C9.50303 20.7751 9.67833 19.9822 10.0289 18.3962L10.7157 15.2896C10.9826 14.082 11.1161 13.4782 10.7951 13.0759C10.4741 12.6736 9.85877 12.6736 8.62814 12.6736Z" stroke="#2CB4C2" stroke-width="1.5" stroke-linejoin="round"/>\n                        </svg>\n                    </div>\n                    <div class="attr-name">\n                        ' + item.napryazhenie + '\n                    </div>\n                </div>';
            }

            if (item.emkost) {
                attributesHtml += '\n                <div class="attr">\n                    <div class="icon">\n                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">\n                            <path d="M2 12C2 9.17157 2 7.75736 2.87868 6.87868C3.75736 6 5.17157 6 8 6H13C15.8284 6 17.2426 6 18.1213 6.87868C19 7.75736 19 9.17157 19 12C19 14.8284 19 16.2426 18.1213 17.1213C17.2426 18 15.8284 18 13 18H8C5.17157 18 3.75736 18 2.87868 17.1213C2 16.2426 2 14.8284 2 12Z" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round"/>\n                            <path d="M19 9.5L20.0272 9.6712C20.7085 9.78475 21.0491 9.84152 21.3076 10.0067C21.5618 10.1691 21.7612 10.4044 21.8796 10.6819C22 10.964 22 11.3093 22 12C22 12.6907 22 13.036 21.8796 13.3181C21.7612 13.5956 21.5618 13.8309 21.3076 13.9933C21.0491 14.1585 20.7085 14.2153 20.0272 14.3288L19 14.5" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round"/>\n                            <path d="M6 10V14" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round"/>\n                            <path d="M9 10V14" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round"/>\n                            <path d="M12 10V14" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round"/>\n                        </svg>\n                    </div>\n                    <div class="attr-name">\n                        ' + item.emkost + '\n                    </div>\n                </div>';
            }

            const productImage = item.thumbnail ? item.thumbnail : placeholderImage;

            const productHtml = '\n                <div class="item" data-product_id="' + item.product_id + '">\n                    <div class="thumb"><img src="' + productImage + '" alt="' + (item.product_name || '') + '"></div>\n                    <div class="meta">\n                        <div class="load-circle"></div>\n                        <a class="product-name" href="' + (item.product_link || '#') + '">' + (item.product_name || '') + '</a>\n                        <div class="product-attrs">' + attributesHtml + '</div>\n                    </div>\n                    <div class="quantity">\n                        <div class="minus">\n                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">\n                                <path d="M20 12H4" stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>\n                            </svg>\n                        </div>\n                        <input type="number" value="' + item.quantity + '" min="1" />\n                        <div class="plus">\n                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">\n                                <path d="M12 4V20M20 12H4" stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>\n                            </svg>\n                        </div>\n                    </div>\n                </div>';

            $miniCartContent.append(productHtml);
        });

        updateProductDataField(cartItems);

        if (shouldOpen) {
            $('.overlay').fadeIn(200);
            $('.mini-cart').fadeIn(200);
        }
    }

    function fetchCartProducts(callback) {
        const productIds = getCartIds();

        if (!productIds.length) {
            callback([]);
            return;
        }

        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            dataType: 'json',
            data: {
                action: cartProductsAction,
                product_ids: productIds,
            },
            success: function(response) {
                let payload = response;

                if (typeof payload === 'string') {
                    try {
                        payload = JSON.parse(payload);
                    } catch (error) {
                        payload = [];
                    }
                }

                callback(Array.isArray(payload) ? payload : []);
            },
            error: function() {
                callback([]);
            },
        });
    }

    function refreshMiniCart(shouldOpen, callback) {
        fetchCartProducts(function(products) {
            cartProductsCache = products;
            const cartItems = normalizeCartProducts(products);
            renderMiniCart(cartItems, shouldOpen);
            syncCartUi();

            if (typeof callback === 'function') {
                callback(cartItems);
            }
        });
    }

    function renderMiniCartFromCache(shouldOpen) {
        const cartItems = normalizeCartProducts(cartProductsCache);
        renderMiniCart(cartItems, shouldOpen);
        syncCartUi();
    }

    function updateMiniCartIfOpened() {
        if ($('.mini-cart').is(':visible')) {
            refreshMiniCart(true);
        }
    }

    $('main.catalog-page').on('click', 'li.table-product', function(event) {
        if ($(event.target).closest('.table-product-title').length || $(event.target).closest('.button').length) {
            return;
        }

        if ($(event.target).closest('li.table-product').hasClass('instock')) {
            $(this).find('.button').trigger('click');
        }
    });

    $(document).on('click', 'main.catalog-page li.table-product .button', function(event) {
        event.preventDefault();

        const $button = $(this);
        const productId = toInt($button.data('product_id') || $button.val());
        const $item = $button.closest('li.table-product');

        if (!productId) {
            return;
        }

        $item.addClass('loading');
        $('.cart-toggle').addClass('loading');
        $('li.table-product .button').prop('disabled', true);

        if (isProductInCart(productId)) {
            removeCartItem(productId);
        } else {
            setCartItem(productId, 1);
        }

        syncCartUi();
        updateMiniCartIfOpened();

        $item.removeClass('loading');
        $('.cart-toggle').removeClass('loading');
        $('li.table-product .button').prop('disabled', false);
    });

    $('form.cart').on('submit', function(event) {
        event.preventDefault();

        const $form = $(this);
        const $button = $form.find('button.single_add_to_cart_button, button[type="submit"]');
        const productId = toInt($button.val() || $button.data('product_id'));
        const quantityInputValue = toInt($form.find('input.qty').val());
        const quantity = quantityInputValue > 0 ? quantityInputValue : 1;

        if (!productId) {
            return;
        }

        $button.addClass('loading');

        if (isProductInCart(productId)) {
            removeCartItem(productId);
            syncCartUi();
            updateMiniCartIfOpened();
            $button.removeClass('loading');
            return;
        }

        setCartItem(productId, quantity);
        syncCartUi();

        refreshMiniCart(true, function() {
            $button.removeClass('loading');
        });
    });

    $(document).on('click', '.cart-toggle', function() {
        const $toggle = $(this);
        $toggle.addClass('loading');

        refreshMiniCart(true, function() {
            $toggle.removeClass('loading');
        });
    });

    $(document).on('click', '.mini-cart .close', function() {
        $('.overlay').fadeOut(200);
        $('.mini-cart').fadeOut(200);
    });

    $('.mini-cart .clear-cart').on('click', function() {
        clearCart();
        $('.overlay').fadeOut(200);
        $('.mini-cart').fadeOut(200);
    });

    $(document).on('click', '.mini-cart .quantity .plus', function() {
        const $item = $(this).closest('.item');
        const productId = toInt($item.data('product_id'));

        if (!productId) {
            return;
        }

        const currentItem = readCart().find(function(cartItem) {
            return cartItem.product_id === productId;
        });

        const nextQuantity = (currentItem ? currentItem.quantity : 1) + 1;
        setCartItem(productId, nextQuantity);

        renderMiniCartFromCache(true);
    });

    $(document).on('click', '.mini-cart .quantity .minus', function() {
        const $item = $(this).closest('.item');
        const productId = toInt($item.data('product_id'));

        if (!productId) {
            return;
        }

        const currentItem = readCart().find(function(cartItem) {
            return cartItem.product_id === productId;
        });

        if (!currentItem) {
            return;
        }

        const nextQuantity = currentItem.quantity - 1;

        if (nextQuantity < 1) {
            removeCartItem(productId);
        } else {
            setCartItem(productId, nextQuantity);
        }

        renderMiniCartFromCache(true);
    });

    $(document).on('change', '.mini-cart .quantity input', function() {
        const $input = $(this);
        const $item = $input.closest('.item');
        const productId = toInt($item.data('product_id'));
        const nextQuantity = toInt($input.val());

        if (!productId) {
            return;
        }

        if (nextQuantity < 1) {
            removeCartItem(productId);
        } else {
            setCartItem(productId, nextQuantity);
        }

        renderMiniCartFromCache(true);
    });

    document.addEventListener('wpcf7mailsent', function(event) {
        const sentFormId = toInt(event && event.detail && event.detail.contactFormId);

        if (sentFormId && sentFormId === cartFormId) {
            clearCart();
            $('.overlay').fadeOut(200);
            $('.mini-cart').fadeOut(200);
        }
    }, false);

    const debouncedSync = debounce(function() {
        updateButtonStates();
    }, 150);

    $(document).ajaxComplete(function() {
        debouncedSync();
    });

    const catalogWrapper = document.querySelector('.shop-catalog-wrapper');

    if (catalogWrapper && typeof MutationObserver !== 'undefined') {
        const observer = new MutationObserver(function() {
            debouncedSync();
        });

        observer.observe(catalogWrapper, {
            childList: true,
            subtree: true,
        });
    }

    syncCartUi();
});
