jQuery(document).ready(function($) {
  const settings = window.mainThemeData || {};

  if (!settings.has_yandex_map) {
    return;
  }

  if (typeof window.ymaps === 'undefined' || typeof window.ymaps.ready !== 'function') {
    return;
  }

  const mapTargets = [];
  const officeMapSection = document.querySelector('section.map:not(.contacts-map)');
  const deliveryMapSection = document.querySelector('section.delivery-map');
  const contactsMapSection = document.querySelector('section.contacts-map');

  if (officeMapSection) {
    mapTargets.push({ section: officeMapSection, type: 'office' });
  }

  if (deliveryMapSection) {
    mapTargets.push({ section: deliveryMapSection, type: 'delivery' });
  }

  if (contactsMapSection) {
    mapTargets.push({ section: contactsMapSection, type: 'contacts' });
  }

  if (!mapTargets.length) {
    return;
  }

  function openNavigatorRoute(destinationCoords) {
    if (!confirm("Открыть Яндекс.Навигатор для построения маршрута?")) {
      return;
    }

    if (!navigator.geolocation) {
      alert("Геолокация не поддерживается вашим браузером");
      return;
    }

    navigator.geolocation.getCurrentPosition(function(position) {
      const userCoords = [position.coords.latitude, position.coords.longitude];
      const navigatorUrl = 'https://yandex.ru/maps/?rtext=' +
        userCoords[0] + ',' + userCoords[1] + '~' +
        destinationCoords[0] + ',' + destinationCoords[1] +
        '&rtt=auto';
      window.open(navigatorUrl, '_blank');
    });
  }

  function createPlacemark(coords, balloonContent) {
    return new ymaps.Placemark(coords, {
      balloonContent: balloonContent,
    }, {
      iconLayout: 'default#image',
      iconImageHref: '/wp-content/themes/main/img/icons/yandex.svg',
      iconImageSize: [45, 56],
    });
  }

  function initOfficeMap() {
    const center = window.screen.width > 992 ? [55.816793, 49.146452] : [55.817793, 49.146452];
    const myMap = new ymaps.Map('map', {
      center: center,
      zoom: 17,
      controls: [],
      theme: 'islands#dark',
    });

    const officePlacemark = createPlacemark([55.816265, 49.145723], 'Офис "НЭТEР"');
    officePlacemark.events.add('click', function() {
      openNavigatorRoute([55.816793, 49.146452]);
    });

    myMap.geoObjects.add(officePlacemark);
  }

  function initDeliveryMap() {
    const myMap = new ymaps.Map('map', {
      center: [55.402468, 49.543532],
      zoom: 14,
      controls: [],
      theme: 'islands#dark',
    });

    const deliveryPlacemark = createPlacemark([55.402468, 49.543532], 'Офис самовывоза');
    deliveryPlacemark.events.add('click', function() {
      openNavigatorRoute([55.834637, 49.041699]);
    });

    myMap.geoObjects.add(deliveryPlacemark);
  }

  function normalizeCoords(value) {
    if (Array.isArray(value)) {
      return value;
    }

    if (typeof value === 'string') {
      try {
        const parsed = JSON.parse(value);
        if (Array.isArray(parsed)) {
          return parsed;
        }
      } catch (error) {
        const parts = value.split(',').map(function(item) {
          return parseFloat(item.trim());
        });

        if (parts.length === 2 && parts.every(Number.isFinite)) {
          return parts;
        }
      }
    }

    return null;
  }

  function initContactsMap(section) {
    const myMap = new ymaps.Map('map', {
      center: [55.833651, 39.051288],
      zoom: 6,
      controls: [],
      theme: 'islands#dark',
    });

    const productionPlacemark = createPlacemark([55.402468, 49.543532], 'Производство');
    const kazanPlacemark = createPlacemark([55.816265, 49.145723], 'Офис продаж в Казани');
    const moscowPlacemark = createPlacemark([55.749792, 37.541889], 'Офис продаж в Москве');

    productionPlacemark.events.add('click', function() {
      openNavigatorRoute([55.833651, 49.051288]);
    });
    kazanPlacemark.events.add('click', function() {
      openNavigatorRoute([55.402468, 49.543532]);
    });
    moscowPlacemark.events.add('click', function() {
      openNavigatorRoute([55.749792, 37.541889]);
    });

    myMap.geoObjects.add(productionPlacemark);
    myMap.geoObjects.add(kazanPlacemark);
    myMap.geoObjects.add(moscowPlacemark);

    $(section).find('.item').on('click', function() {
      const coords = normalizeCoords($(this).data('coords'));

      if (!coords) {
        return;
      }

      myMap.setCenter(coords, 17, {
        checkZoomRange: true,
      });
    });
  }

  function initMapByType(target) {
    if (target.type === 'office') {
      initOfficeMap();
      return;
    }

    if (target.type === 'delivery') {
      initDeliveryMap();
      return;
    }

    initContactsMap(target.section);
  }

  const initializedSections = new WeakSet();

  function initTarget(target) {
    if (initializedSections.has(target.section)) {
      return;
    }

    initializedSections.add(target.section);

    window.ymaps.ready(function() {
      initMapByType(target);
    });
  }

  function addInteractionFallback(target) {
    const initOnInteraction = function() {
      initTarget(target);
    };

    window.addEventListener('scroll', initOnInteraction, { passive: true, once: true });
    window.addEventListener('touchstart', initOnInteraction, { passive: true, once: true });
    window.addEventListener('mousemove', initOnInteraction, { passive: true, once: true });
  }

  if (typeof IntersectionObserver === 'undefined') {
    setTimeout(function() {
      mapTargets.forEach(function(target) {
        initTarget(target);
      });
    }, 800);
    return;
  }

  const observer = new IntersectionObserver(function(entries) {
    entries.forEach(function(entry) {
      if (!entry.isIntersecting) {
        return;
      }

      const target = mapTargets.find(function(item) {
        return item.section === entry.target;
      });

      if (!target) {
        return;
      }

      initTarget(target);
      observer.unobserve(entry.target);
    });
  }, {
    rootMargin: '300px 0px',
    threshold: 0.01,
  });

  mapTargets.forEach(function(target) {
    observer.observe(target.section);
    addInteractionFallback(target);
  });
});
