(function(window, document, $) {
  'use strict';

  if (!$) {
    return;
  }

  var catalogViewCookieName = 'neter_catalog_view';
  var snapshot = null;

  function normalizeCatalogView(view) {
    view = String(view || '').toLowerCase();

    if (view === 'card') {
      view = 'cards';
    }

    return view === 'cards' || view === 'table' ? view : '';
  }

  function getCookie(name) {
    var match = document.cookie.match(new RegExp('(?:^|; )' + name.replace(/([.$?*|{}()[\]\\/+^])/g, '\\$1') + '=([^;]*)'));
    return match ? decodeURIComponent(match[1]) : '';
  }

  function getSavedCatalogView() {
    var view = normalizeCatalogView(getCookie(catalogViewCookieName));

    if (!view) {
      try {
        view = normalizeCatalogView(window.localStorage.getItem(catalogViewCookieName));
      } catch (error) {
        view = '';
      }
    }

    return view || 'table';
  }

  function isCardsView() {
    return getSavedCatalogView() === 'cards' || document.documentElement.classList.contains('catalog-view-pref-cards');
  }

  function isDesktopSidebarMode() {
    return isCardsView() && window.matchMedia('(min-width: 992px)').matches;
  }

  function getFilterKey(filter) {
    return [
      filter.getAttribute('data-filter-type') || '',
      filter.getAttribute('data-display-type') || '',
      filter.getAttribute('data-get-attribute') || '',
      filter.getAttribute('data-taxonomy') || '',
      filter.getAttribute('data-slug') || '',
      filter.getAttribute('data-order-key') || ''
    ].join('|');
  }

  function attrEqualsSelector(name, value) {
    return '[' + name + '="' + String(value).replace(/\\/g, '\\\\').replace(/"/g, '\\"') + '"]';
  }

  function snapshotTermState() {
    var state = [];

    document.querySelectorAll('.wpfMainWrapper .wpfFilterWrapper').forEach(function(filter) {
      var filterKey = getFilterKey(filter);

      filter.querySelectorAll('[data-term-id]').forEach(function(term) {
        state.push({
          filterKey: filterKey,
          termId: term.getAttribute('data-term-id'),
          tagName: term.tagName,
          style: term.getAttribute('style'),
          dataCount: term.getAttribute('data-count'),
          html: term.tagName === 'OPTION' ? term.innerHTML : ''
        });
      });
    });

    return state;
  }

  function takeSnapshot() {
    var catalogProducts = document.querySelector('.shop-catalog-wrapper .catalog-products');

    if (!catalogProducts || !document.querySelector('.catalog-cards__filters .wpfMainWrapper')) {
      return;
    }

    snapshot = {
      pathname: window.location.pathname,
      catalogProductsHtml: catalogProducts.innerHTML,
      termState: snapshotTermState()
    };
  }

  function restoreTermState() {
    if (!snapshot || !Array.isArray(snapshot.termState)) {
      return;
    }

    var filters = {};

    document.querySelectorAll('.wpfMainWrapper .wpfFilterWrapper').forEach(function(filter) {
      filters[getFilterKey(filter)] = filter;
    });

    snapshot.termState.forEach(function(item) {
      var filter = filters[item.filterKey];

      if (!filter || !item.termId) {
        return;
      }

      filter.querySelectorAll(attrEqualsSelector('data-term-id', item.termId)).forEach(function(term) {
        if (item.style === null) {
          term.removeAttribute('style');
        } else {
          term.setAttribute('style', item.style);
        }

        if (item.dataCount === null) {
          term.removeAttribute('data-count');
        } else {
          term.setAttribute('data-count', item.dataCount);
        }

        if (item.tagName === 'OPTION' && item.html !== '') {
          term.innerHTML = item.html;
        }
      });
    });

    $('.wpfMainWrapper select.jqmsLoaded').each(function() {
      if (typeof $(this).multiselect === 'function') {
        $(this).multiselect('reload');
      }
    });
  }

  function stripWpfParams() {
    var url = new URL(window.location.href);
    var removeKeys = [];

    url.searchParams.forEach(function(value, key) {
      if (
        key.indexOf('wpf_') === 0 ||
        key === 'product-page' ||
        key === 'shopPage' ||
        key === 'all_products_filtering' ||
        key === 'redirect' ||
        /^query-\d+-page$/i.test(key) ||
        /^e-page-/i.test(key)
      ) {
        removeKeys.push(key);
      }
    });

    removeKeys.forEach(function(key) {
      url.searchParams.delete(key);
    });

    window.history.pushState({ state: 1, rand: Math.random(), wpf: true }, '', url.toString());

    if (window.app) {
      window.app.wpfNewUrl = url.toString();
    }

    window.wpfOldUrl = url.toString();
  }

  function clearWpfFilters($filterWrapper) {
    var wpfPage = window.wpfFrontendPage;

    if (!wpfPage || typeof wpfPage.clearFilters !== 'function') {
      return false;
    }

    if (typeof wpfPage.setCurrentLocation === 'function') {
      wpfPage.setCurrentLocation();
    }

    var resetAll = '1';

    if (typeof wpfPage.getFilterMainSettings === 'function' && $filterWrapper && $filterWrapper.length) {
      try {
        var settings = wpfPage.getFilterMainSettings($filterWrapper) || {};
        resetAll = settings.settings && typeof settings.settings.reset_all_filters !== 'undefined'
          ? settings.settings.reset_all_filters
          : resetAll;
      } catch (error) {}
    }

    if (resetAll !== '0') {
      $('.wpfMainWrapper').each(function() {
        wpfPage.clearFilters($(this).find('.wpfFilterWrapper'), true);
      });
    } else if ($filterWrapper && $filterWrapper.length) {
      wpfPage.clearFilters($filterWrapper.find('.wpfFilterWrapper'), true);
    }

    return true;
  }

  function closePopupIfNeeded() {
    if (isDesktopSidebarMode()) {
      return;
    }

    $('.filters-popup-overlay').hide();
    $('.filters-popup').hide();
    $('html').removeClass('fixed filters-popup-open');
  }

  function updateFilterButtonState() {
    var filterRoot = document.querySelector('.filters-popup .wpfMainWrapper');
    var numberWrap = document.querySelector('.call-filters .numbers');
    var filterButton = document.querySelector('.call-filters');
    var count = 0;

    if (!filterRoot || !numberWrap || !filterButton) {
      return;
    }

    filterRoot.querySelectorAll('input[type="checkbox"]:checked').forEach(function() {
      count++;
    });

    filterRoot.querySelectorAll('.wpfPriceInputs').forEach(function(range) {
      var min = range.querySelector('#wpfMinPrice');
      var max = range.querySelector('#wpfMaxPrice');

      if (min && max && (min.value !== min.min || max.value !== max.max)) {
        count++;
      }
    });

    if (count === 0) {
      numberWrap.style.display = 'none';
      numberWrap.textContent = '0';
      filterButton.classList.remove('active');
    } else {
      numberWrap.style.display = 'flex';
      numberWrap.textContent = String(count);
      filterButton.classList.add('active');
    }
  }

  function dispatchCatalogUpdated() {
    var event;

    try {
      event = new Event('mainThemeCatalogUpdated');
    } catch (error) {
      event = document.createEvent('Event');
      event.initEvent('mainThemeCatalogUpdated', false, true);
    }

    document.dispatchEvent(event);
  }

  function instantReset(resetButton) {
    if (!snapshot || !snapshot.catalogProductsHtml || snapshot.pathname !== window.location.pathname) {
      return false;
    }

    var catalogProducts = document.querySelector('.shop-catalog-wrapper .catalog-products');
    var $filterWrapper = $(resetButton).closest('.filters-popup, .catalog-cards__filters').find('.wpfMainWrapper').first();

    if (!catalogProducts || !$filterWrapper.length || !clearWpfFilters($filterWrapper)) {
      return false;
    }

    catalogProducts.innerHTML = snapshot.catalogProductsHtml;
    restoreTermState();
    stripWpfParams();

    $('.wpfLoaderLayout, .wpfOverlay').hide();
    $('.wpfMainWrapper .wpfAjaxJSBlock').empty();

    closePopupIfNeeded();
    updateFilterButtonState();
    dispatchCatalogUpdated();

    return true;
  }

  function shouldHandleReset(target) {
    return target && target.closest && target.closest('.filters-popup .wrap .buttons .filters-popup-reset, [data-catalog-sidebar-reset]');
  }

  document.addEventListener('click', function(event) {
    var resetButton = shouldHandleReset(event.target);

    if (!resetButton || !isCardsView() || !snapshot) {
      return;
    }

    if (!instantReset(resetButton)) {
      return;
    }

    event.preventDefault();
    event.stopPropagation();

    if (typeof event.stopImmediatePropagation === 'function') {
      event.stopImmediatePropagation();
    }
  }, true);

  $(takeSnapshot);
})(window, document, window.jQuery);
