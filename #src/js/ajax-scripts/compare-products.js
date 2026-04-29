jQuery(document).ready(function($) {
    const settings = window.mainThemeData || {};
    const ajaxUrl = settings.ajax_url || '/wp-admin/admin-ajax.php';
    const compareCookieName = settings.compare_cookie_name || 'neter_compare_products';
    const validateAction = settings.compare_validate_action || 'validate_compare_products';
    const cookieMaxAgeDays = 365;
    const diffStorageKey = 'neter_compare_only_different';

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

    function normalizeCompare(rawItems) {
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

    function readCompare() {
        const cookieMatch = document.cookie.match(new RegExp('(?:^|; )' + compareCookieName.replace(/([.$?*|{}()\[\]\\/+^])/g, '\\$1') + '=([^;]*)'));

        if (!cookieMatch || !cookieMatch[1]) {
            return [];
        }

        try {
            const decoded = decodeURIComponent(cookieMatch[1]);
            const parsed = JSON.parse(decoded);
            return normalizeCompare(parsed);
        } catch (error) {
            return [];
        }
    }

    function writeCompare(productIds) {
        const normalizedIds = normalizeCompare(productIds);

        if (!normalizedIds.length) {
            clearCompareCookie();
            return;
        }

        const expiresAt = new Date();
        expiresAt.setDate(expiresAt.getDate() + cookieMaxAgeDays);

        document.cookie = compareCookieName + '=' + encodeURIComponent(JSON.stringify(normalizedIds)) + '; expires=' + expiresAt.toUTCString() + '; path=/; SameSite=Lax';
    }

    function clearCompareCookie() {
        document.cookie = compareCookieName + '=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/; SameSite=Lax';
    }

    function isProductCompared(productId) {
        const cleanProductId = toInt(productId);

        if (!cleanProductId) {
            return false;
        }

        return readCompare().includes(cleanProductId);
    }

    function addCompareProduct(productId) {
        const cleanProductId = toInt(productId);

        if (!cleanProductId) {
            return;
        }

        const productIds = readCompare();

        if (!productIds.includes(cleanProductId)) {
            productIds.push(cleanProductId);
            writeCompare(productIds);
        }
    }

    function removeCompareProduct(productId) {
        const cleanProductId = toInt(productId);

        if (!cleanProductId) {
            return;
        }

        writeCompare(readCompare().filter(function(savedProductId) {
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

        const productClass = $element.closest('.product').attr('class') || '';
        const productClassMatch = productClass.match(/(?:^|\s)post-(\d+)(?:\s|$)/);

        return productClassMatch ? toInt(productClassMatch[1]) : 0;
    }

    function syncCompareUi() {
        const compareIds = readCompare();

        window.NETER_COMPARE_PRODUCT_IDS = compareIds.slice();

        $('.add-compare').each(function() {
            const $icon = $(this);
            const productId = getProductIdFromElement(this);
            const isActive = productId && compareIds.includes(productId);

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

    function validateCompare() {
        const productIds = readCompare();

        if (!productIds.length) {
            syncCompareUi();
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
                const validIds = normalizeCompare(responseIds);

                if (!arraysEqual(productIds, validIds)) {
                    writeCompare(validIds);
                }

                syncCompareUi();
            },
            error: function() {
                syncCompareUi();
            },
        });
    }

    function isComparePage() {
        return $('[data-compare-products-page]').length > 0;
    }

    function reloadComparePage() {
        if (isComparePage()) {
            window.location.reload();
        }
    }

    function syncDiffToggle() {
        const $page = $('[data-compare-products-page]');
        const $toggle = $('[data-compare-diff-toggle]');

        if (!$page.length || !$toggle.length) {
            return;
        }

        const enabled = localStorage.getItem(diffStorageKey) === '1';

        $toggle.prop('checked', enabled);
        $page.toggleClass('only-different', enabled);
    }

    function resetCompareHeights($page) {
        $page.find('.compare-card__product, .compare-card__attr-row').css('height', '');
    }

    function equalizeCompareHeights() {
        const $page = $('[data-compare-products-page]');

        if (!$page.length) {
            return;
        }

        resetCompareHeights($page);

        let maxProductHeight = 0;

        $page.find('.compare-card__product:visible').each(function() {
            maxProductHeight = Math.max(maxProductHeight, this.offsetHeight);
        });

        if (maxProductHeight > 0) {
            $page.find('.compare-card__product:visible').css('height', maxProductHeight + 'px');
        }

        const rowHeights = {};

        $page.find('.compare-card__attr-row:visible').each(function() {
            const key = $(this).data('compare-row-key');

            if (!key) {
                return;
            }

            rowHeights[key] = Math.max(rowHeights[key] || 0, this.offsetHeight);
        });

        Object.keys(rowHeights).forEach(function(key) {
            $page.find('.compare-card__attr-row[data-compare-row-key="' + key + '"]:visible').css('height', rowHeights[key] + 'px');
        });
    }

    const debouncedSync = debounce(function() {
        syncCompareUi();
    }, 150);

    const debouncedValidate = debounce(function() {
        validateCompare();
    }, 300);

    const debouncedEqualize = debounce(function() {
        equalizeCompareHeights();
    }, 80);

    $(document).on('click', '.add-compare', function(event) {
        event.preventDefault();
        event.stopPropagation();

        const productId = getProductIdFromElement(this);

        if (!productId) {
            return;
        }

        if (isProductCompared(productId)) {
            removeCompareProduct(productId);
            syncCompareUi();
            debouncedValidate();
            $(document).trigger('main_theme_compare_updated', [readCompare()]);
            reloadComparePage();
            return;
        }

        addCompareProduct(productId);
        syncCompareUi();
        debouncedValidate();
        $(document).trigger('main_theme_compare_updated', [readCompare()]);
    });

    $(document).on('click', '[data-compare-clear]', function(event) {
        event.preventDefault();
        clearCompareCookie();
        syncCompareUi();
        window.location.reload();
    });

    $(document).on('change', '[data-compare-diff-toggle]', function() {
        const enabled = $(this).is(':checked');
        localStorage.setItem(diffStorageKey, enabled ? '1' : '0');
        $('[data-compare-products-page]').toggleClass('only-different', enabled);
        debouncedEqualize();
    });

    $(document).ajaxComplete(function() {
        debouncedSync();
        debouncedEqualize();
    });

    $(window).on('resize load', function() {
        debouncedEqualize();
    });

    $('.compare-page__slider img').each(function() {
        if (this.complete) {
            return;
        }

        $(this).one('load error', function() {
            debouncedEqualize();
        });
    });

    if (document.body && typeof MutationObserver !== 'undefined') {
        const observer = new MutationObserver(function() {
            debouncedSync();
            debouncedEqualize();
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true,
        });
    }

    syncCompareUi();
    syncDiffToggle();
    equalizeCompareHeights();
    validateCompare();
});
