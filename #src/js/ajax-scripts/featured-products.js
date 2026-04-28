jQuery(document).ready(function($) {
    const settings = window.mainThemeData || {};
    const ajaxUrl = settings.ajax_url || '/wp-admin/admin-ajax.php';
    const featuredCookieName = settings.featured_cookie_name || 'neter_featured_products';
    const validateAction = settings.featured_validate_action || 'validate_featured_products';
    const cookieMaxAgeDays = 365;

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

    function normalizeFavorites(rawItems) {
        if (!Array.isArray(rawItems)) {
            return [];
        }

        const result = [];
        const existsMap = {};

        rawItems.forEach(function(item) {
            const productId = toInt(item && typeof item === 'object' ? item.product_id : item);

            if (!productId || existsMap[productId]) {
                return;
            }

            result.push(productId);
            existsMap[productId] = true;
        });

        return result;
    }

    function readFavorites() {
        const cookieMatch = document.cookie.match(new RegExp('(?:^|; )' + featuredCookieName.replace(/([.$?*|{}()\[\]\\/+^])/g, '\\$1') + '=([^;]*)'));

        if (!cookieMatch || !cookieMatch[1]) {
            return [];
        }

        try {
            const decoded = decodeURIComponent(cookieMatch[1]);
            const parsed = JSON.parse(decoded);
            return normalizeFavorites(parsed);
        } catch (error) {
            return [];
        }
    }

    function writeFavorites(productIds) {
        const normalizedIds = normalizeFavorites(productIds);

        if (!normalizedIds.length) {
            clearFavoritesCookie();
            return;
        }

        const expiresAt = new Date();
        expiresAt.setDate(expiresAt.getDate() + cookieMaxAgeDays);

        document.cookie = featuredCookieName + '=' + encodeURIComponent(JSON.stringify(normalizedIds)) + '; expires=' + expiresAt.toUTCString() + '; path=/; SameSite=Lax';
    }

    function clearFavoritesCookie() {
        document.cookie = featuredCookieName + '=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/; SameSite=Lax';
    }

    function isProductFeatured(productId) {
        const cleanProductId = toInt(productId);

        if (!cleanProductId) {
            return false;
        }

        return readFavorites().includes(cleanProductId);
    }

    function addFeaturedProduct(productId) {
        const cleanProductId = toInt(productId);

        if (!cleanProductId) {
            return;
        }

        const productIds = readFavorites();

        if (!productIds.includes(cleanProductId)) {
            productIds.push(cleanProductId);
            writeFavorites(productIds);
        }
    }

    function removeFeaturedProduct(productId) {
        const cleanProductId = toInt(productId);

        if (!cleanProductId) {
            return;
        }

        writeFavorites(readFavorites().filter(function(savedProductId) {
            return savedProductId !== cleanProductId;
        }));
    }

    function getProductIdFromElement(element) {
        const $element = $(element);
        const directProductId = toInt($element.data('product-id') || $element.data('product_id') || $element.attr('data-product-id'));

        if (directProductId) {
            return directProductId;
        }

        const $closestDataElement = $element.closest('[data-product-id]');
        const closestProductId = toInt($closestDataElement.data('product-id') || $closestDataElement.attr('data-product-id'));

        if (closestProductId) {
            return closestProductId;
        }

        const productClass = $element.closest('li.product').attr('class') || '';
        const productClassMatch = productClass.match(/(?:^|\s)post-(\d+)(?:\s|$)/);

        return productClassMatch ? toInt(productClassMatch[1]) : 0;
    }

    function syncFeaturedUi() {
        const featuredIds = readFavorites();

        window.NETER_FEATURED_PRODUCT_IDS = featuredIds.slice();

        $('.add-feat, .add-featured').each(function() {
            const $icon = $(this);
            const productId = getProductIdFromElement(this);
            const isActive = productId && featuredIds.includes(productId);

            $icon.toggleClass('active', Boolean(isActive));
            $icon.attr('aria-pressed', isActive ? 'true' : 'false');
        });
    }

    function arraysEqual(first, second) {
        if (first.length !== second.length) {
            return false;
        }

        return first.every(function(item, index) {
            return item === second[index];
        });
    }

    function validateFavorites() {
        const productIds = readFavorites();

        if (!productIds.length) {
            syncFeaturedUi();
            return;
        }

        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            dataType: 'json',
            data: {
                action: validateAction,
                product_ids: productIds,
            },
            success: function(response) {
                const responseIds = response && response.success && response.data ? response.data.product_ids : [];
                const validIds = normalizeFavorites(responseIds);

                if (!arraysEqual(productIds, validIds)) {
                    writeFavorites(validIds);
                }

                syncFeaturedUi();
            },
            error: function() {
                syncFeaturedUi();
            },
        });
    }

    function removeProductFromFeaturedPage(productId) {
        const $wrap = $('[data-featured-products-wrap]');

        if (!$wrap.length) {
            return;
        }

        let $productItem = $wrap.find('li[data-product-id="' + productId + '"]');

        if (!$productItem.length) {
            $productItem = $wrap
                .find('.add-feat[data-product-id="' + productId + '"], .add-featured[data-product-id="' + productId + '"]')
                .closest('li.product');
        }

        $productItem.remove();

        if (!$wrap.find('li.product').length) {
            window.location.reload();
        }
    }

    const debouncedSync = debounce(function() {
        syncFeaturedUi();
    }, 150);

    const debouncedValidate = debounce(function() {
        validateFavorites();
    }, 300);

    $(document).on('click', '.add-feat, .add-featured', function(event) {
        event.preventDefault();
        event.stopPropagation();

        const productId = getProductIdFromElement(this);

        if (!productId) {
            return;
        }

        if (isProductFeatured(productId)) {
            removeFeaturedProduct(productId);
            removeProductFromFeaturedPage(productId);
        } else {
            addFeaturedProduct(productId);
        }

        syncFeaturedUi();
        debouncedValidate();
        $(document).trigger('main_theme_featured_updated', [readFavorites()]);
    });

    $(document).ajaxComplete(function() {
        debouncedSync();
    });

    if (document.body && typeof MutationObserver !== 'undefined') {
        const observer = new MutationObserver(function() {
            debouncedSync();
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true,
        });
    }

    syncFeaturedUi();
    validateFavorites();
});
