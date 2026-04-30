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
    const filtersOverlaySelector = '.filters-popup-overlay';

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
      if (view === 'card' || view === 'cards') {
        return 'cards';
      }

      if (view === 'table') {
        return 'table';
      }

      return '';
    }

    function getSavedCatalogView() {
      let view = normalizeCatalogView(getCookie(catalogViewCookieName));

      if (!view) {
        try {
          view = normalizeCatalogView(window.localStorage.getItem(catalogViewCookieName));
        } catch (error) {
          view = '';
        }
      }

      return view || 'table';
    }

    function saveCatalogView(view) {
      setCookie(catalogViewCookieName, view, 30);

      try {
        window.localStorage.setItem(catalogViewCookieName, view);
      } catch (error) {}
    }

    function setCatalogToggleState(view) {
      $('.catalog-view__toggle').each(function() {
        $(this).toggleClass('active', normalizeCatalogView($(this).data('view')) === view);
      });
    }

    function applyCatalogView(view) {
      view = normalizeCatalogView(view) || 'table';

      document.documentElement.classList.remove('catalog-view-pref-table', 'catalog-view-pref-cards');
      document.documentElement.classList.add('catalog-view-pref-' + view);
      document.documentElement.setAttribute('data-catalog-view', view);

      $('.shop-catalog-wrapper, [data-catalog-view-controls], [data-catalog-layout]')
        .removeClass('catalog-view--table catalog-view--cards')
        .addClass('catalog-view--' + view);

      $('[data-catalog-view]').attr('data-catalog-view', view);
      setCatalogToggleState(view);
    }

    function isDesktopSidebarMode() {
      return getSavedCatalogView() === 'cards' && window.matchMedia('(min-width: 992px)').matches;
    }

    function closeFiltersPopup() {
      $(filtersOverlaySelector).fadeOut(200);
      $('html').removeClass('fixed filters-popup-open');

      if (!isDesktopSidebarMode()) {
        $('.filters-popup').fadeOut(200);
      }
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

    function initCatalogViewSwitcher() {
      $(document).off('click.mainCatalogViewSwitcher').on('click.mainCatalogViewSwitcher', '.catalog-view .catalog-view__toggle', function() {
        const view = normalizeCatalogView($(this).data('view'));

        if (!view) {
          return;
        }

        saveCatalogView(view);
        applyCatalogView(view);
        renderFiltersBtns();
        document.dispatchEvent(new Event('mainThemeCatalogUpdated'));
      });
    }

    function renderFiltersBtns() {
      const filterRoot = document.querySelector('.filters-popup .wpfMainWrapper');
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

          if (!min || !max) {
            return;
          }

          if (min.value != min.min || max.value != max.max) {
            count++;
          }
        });
      }

      if (inputs.length > 0) {
        inputs.forEach(elem => {
          if (elem.checked) {
            count++;
          }
        });
      }

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
      $(filtersOverlaySelector).fadeIn(200);
      $('.filters-popup').fadeIn(200);
      $('html').addClass('fixed filters-popup-open');
      reapplyWpfExistsTerms(document);
    });

    $(document).on('click', '.filters-popup .close', function() {
      closeFiltersPopup();
      renderFiltersBtns();
    });

    $(document).on('click', filtersOverlaySelector, function() {
      closeFiltersPopup();
      renderFiltersBtns();
    });

    $(document).on('click', '.filters-popup .wrap .buttons .filters-popup-reset, [data-catalog-sidebar-reset]', function() {
      const $filterWrapper = $(this).closest('.filters-popup, .catalog-cards__filters').find('.wpfMainWrapper').first();

      if (!isDesktopSidebarMode()) {
        closeFiltersPopup();
      }

      resetWpfFilters($filterWrapper.length ? $filterWrapper : $('.wpfMainWrapper').first());
      renderFiltersBtns();
      window.setTimeout(renderFiltersBtns, 300);
    });

    $(document).on('click', '.filters-popup .wrap .buttons .filers-popup-confirm', function() {
      closeFiltersPopup();
      renderFiltersBtns();
    });

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
    const filterRootsSelector = '.filters-popup .wpfMainWrapper';

    $(window).on('resize', function() {
      applyCatalogView(getSavedCatalogView());
      renderFiltersBtns();
    });

    $(document).on('change input wpfPriceChange wpfAttrSliderChange', filterRootsSelector, debouncedRenderFiltersBtns);

    document.addEventListener('wpfAjaxSuccess', function() {
      window.setTimeout(function() {
        applyCatalogView(getSavedCatalogView());
        reapplyWpfExistsTerms(document);
        renderFiltersBtns();
        document.dispatchEvent(new Event('mainThemeCatalogUpdated'));
      }, 50);
    });

    initCatalogViewSwitcher();
    applyCatalogView(getSavedCatalogView());
    reapplyWpfExistsTerms(document);
    renderFiltersBtns();
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
