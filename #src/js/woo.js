jQuery(document).ready(function ($) {

  $('.product-tabs .tabs .item').on('click', function() {
      var index = $(this).index(); // Определяем индекс нажатого таба

      $('.product-tabs .tabs .item').removeClass('active');
      $(this).addClass('active');

      $('.product-tabs .wrapper').fadeOut(0, function() {
          $(this).css('display', 'none'); // Устанавливаем display: none после fadeOut
      }).eq(index).fadeIn(0, function() {
          $(this).css('display', 'flex'); // Устанавливаем display: flex после fadeIn
      });
  });

  const catalogPage = document.querySelector('.shop-catalog-wrapper');

  if (catalogPage) {
    const catalogViewCookieName = (window.mainThemeData && window.mainThemeData.catalog_view_cookie_name) || 'neter_catalog_view';
    const catalogViewUrlParam = (window.mainThemeData && window.mainThemeData.catalog_view_url_param) || 'view';
    const catalogCardsUrlValue = (window.mainThemeData && window.mainThemeData.catalog_cards_url_value) || 'card';
    const catalogScrollFlag = 'neterCatalogViewChanged';

    function setCookie(name, value, days) {
      const expires = new Date();
      expires.setDate(expires.getDate() + days);
      document.cookie = name + '=' + encodeURIComponent(value) + '; expires=' + expires.toUTCString() + '; path=/; SameSite=Lax';
    }

    function getCookie(name) {
      const match = document.cookie.match(new RegExp('(?:^|; )' + name.replace(/([.$?*|{}()\[\]\\/+^])/g, '\\$1') + '=([^;]*)'));
      return match ? decodeURIComponent(match[1]) : '';
    }

    function normalizeCatalogView(view) {
      if (view === catalogCardsUrlValue || view === 'cards') {
        return 'cards';
      }

      if (view === 'table') {
        return 'table';
      }

      return '';
    }

    function isValidCatalogView(view) {
      return normalizeCatalogView(view) !== '';
    }

    function getRenderedCatalogView() {
      const renderedCatalog = document.querySelector('[data-catalog-view]');
      return renderedCatalog ? normalizeCatalogView(renderedCatalog.getAttribute('data-catalog-view')) : '';
    }

    function getUrlCatalogView() {
      const url = new URL(window.location.href);
      return normalizeCatalogView(url.searchParams.get(catalogViewUrlParam));
    }

    function setCatalogToggleState(view) {
      if (!isValidCatalogView(view)) {
        return;
      }

      $('.catalog-view__toggle').each(function() {
        $(this).toggleClass('active', $(this).data('view') === view);
      });
    }

    function applyCatalogViewToUrl(url, view) {
      url.searchParams.delete(catalogViewCookieName);
      url.searchParams.delete('main_theme_catalog_ajax');
      url.searchParams.delete('_');

      if (view === 'cards') {
        url.searchParams.set(catalogViewUrlParam, catalogCardsUrlValue);
      } else {
        url.searchParams.delete(catalogViewUrlParam);
      }

      return url;
    }

    function buildCatalogPublicUrl(view) {
      return applyCatalogViewToUrl(new URL(window.location.href), view).toString();
    }

    function normalizeCatalogLocation() {
      const urlView = getUrlCatalogView();
      const savedView = normalizeCatalogView(getCookie(catalogViewCookieName));
      const targetView = urlView || savedView;

      if (targetView === 'cards') {
        const normalizedUrl = buildCatalogPublicUrl('cards');

        if (normalizedUrl !== window.location.href) {
          window.location.replace(normalizedUrl);
          return true;
        }
      } else if (targetView === 'table' && new URL(window.location.href).searchParams.has(catalogViewUrlParam)) {
        const normalizedUrl = buildCatalogPublicUrl('table');

        if (normalizedUrl !== window.location.href) {
          window.location.replace(normalizedUrl);
          return true;
        }
      }

      return false;
    }

    function scrollToCatalogAfterReload() {
      if (window.sessionStorage.getItem(catalogScrollFlag) !== '1') {
        return;
      }

      window.sessionStorage.removeItem(catalogScrollFlag);

      const catalog = document.querySelector('#catalog');

      if (!catalog) {
        return;
      }

      window.setTimeout(function() {
        const top = catalog.getBoundingClientRect().top + window.pageYOffset - 100;
        window.scrollTo({
          top: Math.max(0, top),
          behavior: 'smooth',
        });
      }, 120);
    }

    function reapplyWpfExistsTerms(root, attempt) {
      root = root || document;
      attempt = attempt || 0;

      if (
        !window.wpfFrontendPage ||
        typeof window.wpfShowHideFiltersAtts !== 'function' ||
        typeof window.wpfChangeFiltersCount !== 'function'
      ) {
        if (attempt < 20) {
          window.setTimeout(function() {
            reapplyWpfExistsTerms(root, attempt + 1);
          }, 100);
        }

        return;
      }

      const scripts = root.querySelectorAll('.wpfExistsTermsJS script');

      scripts.forEach(function(script) {
        const scriptCode = script.textContent || script.innerHTML || '';

        if (!scriptCode.trim()) {
          return;
        }

        try {
          window.Function(scriptCode)();
        } catch (error) {
          // The plugin already runs this generated code on normal loads.
        }
      });

      if (typeof window.wpfFrontendPage.disableLeerOptions === 'function') {
        window.wpfFrontendPage.disableLeerOptions();
      }
    }

    let catalogRefreshInProgress = false;

    function refreshCachedCatalogViewIfNeeded() {
      const urlView = getUrlCatalogView();
      const savedView = normalizeCatalogView(getCookie(catalogViewCookieName));
      const renderedView = getRenderedCatalogView();
      const targetView = urlView || savedView || 'table';

      if (!isValidCatalogView(targetView) || !isValidCatalogView(renderedView)) {
        setCatalogToggleState(renderedView || targetView);
        return false;
      }

      setCatalogToggleState(targetView);

      if (targetView === renderedView || catalogRefreshInProgress) {
        return false;
      }

      const targetUrl = buildCatalogPublicUrl(targetView);

      if (targetUrl !== window.location.href) {
        catalogRefreshInProgress = true;
        window.location.replace(targetUrl);
        return true;
      }

      return false;
    }

    function initCatalogViewSwitcher() {
      if (!document.querySelector('[data-catalog-view]')) {
        return;
      }

      $(document).off('click.mainCatalogViewSwitcher').on('click.mainCatalogViewSwitcher', '.catalog-view .catalog-view__toggle', function() {
        const view = normalizeCatalogView($(this).data('view'));

        if (!isValidCatalogView(view)) {
          return;
        }

        if ($(this).hasClass('active') && getRenderedCatalogView() === view) {
          return;
        }

        setCookie(catalogViewCookieName, view, 30);
        window.sessionStorage.setItem(catalogScrollFlag, '1');
        window.location.assign(buildCatalogPublicUrl(view));
      });
    }

    function moveCatalogCardFilters() {
      const sidebarFilters = document.querySelector('[data-catalog-sidebar-filters]');
      const popupFilters = document.querySelector('[data-catalog-popup-filters]');

      if (!sidebarFilters || !popupFilters) {
        return;
      }

      const usePopup = window.matchMedia('(max-width: 991px)').matches;
      const source = usePopup ? sidebarFilters : popupFilters;
      const target = usePopup ? popupFilters : sidebarFilters;

      if (!source.children.length || target.children.length) {
        return;
      }

      while (source.firstChild) {
        target.appendChild(source.firstChild);
      }
    }

    function renderFiltersBtns() {
      const filterRoot = document.querySelector('.filters-popup .wpfMainWrapper') || document.querySelector('[data-catalog-sidebar-filters] .wpfMainWrapper');
      const inputs = filterRoot ? filterRoot.querySelectorAll('input[type="checkbox"]') : [];
      const numberWrap = document.querySelector('.call-filters .numbers');
      const filterBtn = document.querySelector('.call-filters');
      const inputSLiders = filterRoot ? filterRoot.querySelectorAll('.wpfPriceInputs') : [];
      let count = 0;

      if (!numberWrap || !filterBtn) {
        return;
      }

      if (inputSLiders.length > 0) {
        inputSLiders.forEach(range => {
          const min = range.querySelector('#wpfMinPrice');
          const max = range.querySelector('#wpfMaxPrice');
          let minVal = min.min;
          let maxVal = min.max;
          if (min.value != minVal && max.value != maxVal) {
            count++;
          } else {
            if (count > 0) {
              count--;
            }
          }
        });
      }
      if (inputs.length > 0) {
        inputs.forEach(elem => {
          if (elem.checked) {
              count++;
          }
        });
        if (count == 0) {
          numberWrap.style.display = 'none';
          filterBtn.classList.remove('active');
          numberWrap.textContent = 0;
        } else {
          numberWrap.style.display = 'flex';
          filterBtn.classList.add('active');
          numberWrap.textContent = count;
        }
      }
    }

    function resetWpfFilters($filterWrapper) {
      if (!$filterWrapper || !$filterWrapper.length) {
        return false;
      }

      const $clearButton = $filterWrapper.find('.wpfClearButton').first();

      if ($clearButton.length) {
        $clearButton.trigger('click');
        return true;
      }

      const wpfPage = window.wpfFrontendPage;

      if (
        wpfPage &&
        typeof wpfPage.clearFilters === 'function' &&
        typeof wpfPage.filtering === 'function'
      ) {
        let settings = {};

        if (typeof wpfPage.getFilterMainSettings === 'function') {
          try {
            settings = wpfPage.getFilterMainSettings($filterWrapper) || {};
          } catch (error) {
            settings = {};
          }
        }

        const filterSettings = settings.settings || {};
        const resetAllFilters = typeof filterSettings.reset_all_filters !== 'undefined' ? filterSettings.reset_all_filters : '0';

        if (typeof wpfPage.setCurrentLocation === 'function') {
          wpfPage.setCurrentLocation();
        }

        if (resetAllFilters !== '0') {
          $('.wpfMainWrapper').each(function() {
            wpfPage.clearFilters($(this).find('.wpfFilterWrapper'), true);
          });
        } else {
          wpfPage.clearFilters($filterWrapper.find('.wpfFilterWrapper'), true);
        }

        if (Number(filterSettings.redirect_after_select) || Number(filterSettings.redirect_only_click)) {
          wpfPage.filterClick = false;
        }

        wpfPage.filtering($filterWrapper, true);

        if (typeof wpfPage.initOneByOne === 'function') {
          wpfPage.initOneByOne($filterWrapper);
        }

        return true;
      }

      const $globalClearButton = $('.wpfClearButton').first();

      if ($globalClearButton.length) {
        $globalClearButton.trigger('click');
        return true;
      }

      return false;
    }

    $(document).on('click', '.call-filters', function() {
      $('.overlay').fadeIn(200);
      $('.filters-popup').fadeIn(200);
      $('html').addClass('fixed');
      moveCatalogCardFilters();
      reapplyWpfExistsTerms(document);
    });

    $(document).on('click', '.filters-popup .close', function() {
      $('.overlay').fadeOut(200);
      $('.filters-popup').fadeOut(200);
      $('html').removeClass('fixed');
      renderFiltersBtns();
    });

    $(document).on('click', '.overlay', function() {
      $('.overlay').fadeOut(200);
      $('.filters-popup').fadeOut(200);
      $('html').removeClass('fixed');
      renderFiltersBtns();
    });

    $(document).on('click', '.filters-popup .wrap .buttons .filters-popup-reset', function() {
      const $filterWrapper = $('.filters-popup .wpfMainWrapper').first();

      $('.overlay').fadeOut(200);
      resetWpfFilters($filterWrapper.length ? $filterWrapper : $('.wpfMainWrapper').first());
      $('.filters-popup').fadeOut(200);
      $('html').removeClass('fixed');

      renderFiltersBtns();
      window.setTimeout(renderFiltersBtns, 300);
    });

    $(document).on('click', '[data-catalog-sidebar-reset]', function() {
      const $filterWrapper = $(this).closest('.catalog-cards__filters').find('.wpfMainWrapper').first();

      resetWpfFilters($filterWrapper);
      renderFiltersBtns();
      window.setTimeout(renderFiltersBtns, 300);
    });

    $(document).on('click', '.filters-popup .wrap .buttons .filers-popup-confirm', function() {
      $('.overlay').fadeOut(200);
      $('.filters-popup').fadeOut(200);
      $('html').removeClass('fixed');

      renderFiltersBtns();
    });

    // Функция debounce
    function debounce(func, delay) {
      let timeoutId;
      return function(...args) {
        const context = this;
        if (timeoutId) {
          clearTimeout(timeoutId);
        }
        timeoutId = setTimeout(() => {
          func.apply(context, args);
        }, delay);
      };
    }

    const debouncedRenderFiltersBtns = debounce(renderFiltersBtns, 250);
    const filterRootsSelector = '.filters-popup .wpfMainWrapper, [data-catalog-sidebar-filters] .wpfMainWrapper';

    $(window).on('resize', function() {
      moveCatalogCardFilters();
      renderFiltersBtns();
    });

    $(document).on('change input wpfPriceChange wpfAttrSliderChange', filterRootsSelector, debouncedRenderFiltersBtns);

    document.addEventListener('wpfAjaxSuccess', function() {
      window.setTimeout(function() {
        moveCatalogCardFilters();
        reapplyWpfExistsTerms(document);
        renderFiltersBtns();
        document.dispatchEvent(new Event('mainThemeCatalogUpdated'));
      }, 50);
    });

    const catalogLocationChanging = normalizeCatalogLocation();

    if (!catalogLocationChanging) {
      initCatalogViewSwitcher();
    }

    if (!catalogLocationChanging && !refreshCachedCatalogViewIfNeeded()) {
      moveCatalogCardFilters();
      reapplyWpfExistsTerms(document);
      scrollToCatalogAfterReload();
      renderFiltersBtns();
    }
  }


  const productLinks = document.querySelector('.product-links');

  if (productLinks && window.screen.width > 992) {
    const wrapper = productLinks.querySelector('.scroll-wrapper .wrap');
  
    if (wrapper) {
      const maxHeight = 210;
  
      // Проверка высоты элемента
      if (wrapper.offsetHeight > maxHeight) {
        // Ограничиваем высоту
        wrapper.style.maxHeight = maxHeight + 'px';
        wrapper.style.overflow = 'hidden';
        wrapper.style.transition = 'max-height 0.3s ease';
  
        // Создаем кнопку
        const toggleBtn = document.createElement('button');
        toggleBtn.textContent = 'Показать ещё';
        toggleBtn.classList.add('button');
        toggleBtn.style.marginTop = '10px'; // кастомизируй под себя
        toggleBtn.style.cursor = 'pointer';
  
        // Добавляем кнопку после .wrap
        productLinks.querySelector('.scroll-wrapper').appendChild(toggleBtn);
  
        // Слушаем клик
        toggleBtn.addEventListener('click', function() {
          if (wrapper.style.maxHeight !== 'none') {
            wrapper.style.maxHeight = 'none';
            toggleBtn.textContent = 'Скрыть';
          } else {
            wrapper.style.maxHeight = maxHeight + 'px';
            toggleBtn.textContent = 'Показать ещё';
          }
        });
      }
    }
  }
  

 


}); //end
