jQuery(document).ready(function($) {
  const map = document.querySelector('section.map');
  if (map && !map.classList.contains('contacts-map')) {
    setTimeout(() => {
      ymaps.ready(init);
      function init(){
        let center;
        if (window.screen.width > 992) {
          center = [55.816793, 49.146452];
        } else {
          center = [55.817793, 49.146452]
        }
        var myMap = new ymaps.Map("map", {
            center: center, // Центр карты (Казань)
            zoom: 17,
            controls: [],
            theme: "islands#dark"
        });

        var myPlacemark = new ymaps.Placemark([55.816265, 49.145723], {
            balloonContent: 'Офис "НЭТEР"'
        }, {
            iconLayout: 'default#image',
            iconImageHref: '/wp-content/themes/main/img/icons/yandex.svg', // Замените на путь к вашей иконке
            iconImageSize: [45, 56], // Размер иконки
        });

        myPlacemark.events.add('click', function (e) {
          if (confirm("Открыть Яндекс.Навигатор для построения маршрута?")) {
            if (navigator.geolocation) {
              navigator.geolocation.getCurrentPosition(function(position) {
                const userCoords = [position.coords.latitude, position.coords.longitude];
                const destination = [55.816793, 49.146452];
                const navigatorUrl = `https://yandex.ru/maps/?rtext=${userCoords[0]},${userCoords[1]}~${destination[0]},${destination[1]}&rtt=auto`;
                window.open(navigatorUrl, '_blank');
              });
            } else {
              alert("Геолокация не поддерживается вашим браузером");
            }
          }
        });

        myMap.geoObjects.add(myPlacemark);
      }
    }, 5000);
  }

  const mapDelivery = document.querySelector('section.delivery-map');
  if (mapDelivery) {
    setTimeout(() => {
      ymaps.ready(init);
      function init(){
        var myMap = new ymaps.Map("map", {
            center: [55.833424, 49.040046], // Центр карты (Казань)
            zoom: 14,
            controls: [],
            theme: "islands#dark"
        });

        var myPlacemark = new ymaps.Placemark([55.833424, 49.040046], {
            balloonContent: 'Офис самовывоза'
        }, {
            iconLayout: 'default#image',
            iconImageHref: '/wp-content/themes/main/img/icons/yandex.svg', // Замените на путь к вашей иконке
            iconImageSize: [45, 56], // Размер иконки
        });

        myPlacemark.events.add('click', function (e) {
          if (confirm("Открыть Яндекс.Навигатор для построения маршрута?")) {
            if (navigator.geolocation) {
              navigator.geolocation.getCurrentPosition(function(position) {
                const userCoords = [position.coords.latitude, position.coords.longitude];
                const destination = [55.834637, 49.041699];
                const navigatorUrl = `https://yandex.ru/maps/?rtext=${userCoords[0]},${userCoords[1]}~${destination[0]},${destination[1]}&rtt=auto`;
                window.open(navigatorUrl, '_blank');
              });
            } else {
              alert("Геолокация не поддерживается вашим браузером");
            }
          }
        });

        myMap.geoObjects.add(myPlacemark);
      }
    }, 5000);
  }

  const mapContacts = document.querySelector('section.contacts-map');
  if (mapContacts) {
    setTimeout(() => {
      ymaps.ready(init);
      function init(){
        var myMap = new ymaps.Map("map", {
            center: [55.833651, 39.051288], // Центр карты (Казань)
            zoom: 6,
            controls: [],
            theme: "islands#dark"
        });

        var myPlacemark = new ymaps.Placemark([55.833424, 49.040046], {
            balloonContent: 'Производство'
        }, {
            iconLayout: 'default#image',
            iconImageHref: '/wp-content/themes/main/img/icons/yandex.svg', // Замените на путь к вашей иконке
            iconImageSize: [45, 56], // Размер иконки
        });

        var myPlacemark2 = new ymaps.Placemark([55.816265, 49.145723], {
          balloonContent: 'Офис продаж в Казани'
        }, {
            iconLayout: 'default#image',
            iconImageHref: '/wp-content/themes/main/img/icons/yandex.svg', // Замените на путь к вашей иконке
            iconImageSize: [45, 56], // Размер иконки
        });

        var myPlacemark3 = new ymaps.Placemark([55.766233, 37.581101], {
            balloonContent: 'Офис продаж в Москве'
        }, {
            iconLayout: 'default#image',
            iconImageHref: '/wp-content/themes/main/img/icons/yandex.svg', // Замените на путь к вашей иконке
            iconImageSize: [45, 56], // Размер иконки
        });

        function addRouteEvent(placemark, coords) {
          placemark.events.add('click', function (e) {
            if (confirm("Открыть Яндекс.Навигатор для построения маршрута?")) {
              if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                  const userCoords = [position.coords.latitude, position.coords.longitude];
                  const navigatorUrl = `https://yandex.ru/maps/?rtext=${userCoords[0]},${userCoords[1]}~${coords[0]},${coords[1]}&rtt=auto`;
                  window.open(navigatorUrl, '_blank');
                });
              } else {
                alert("Геолокация не поддерживается вашим браузером");
              }
            }
          });
        }

        addRouteEvent(myPlacemark, [55.833651, 49.051288]);
        addRouteEvent(myPlacemark2, [55.816793, 49.146452]);
        addRouteEvent(myPlacemark3, [55.766233, 37.581101]);

        myMap.geoObjects.add(myPlacemark);
        myMap.geoObjects.add(myPlacemark2);
        myMap.geoObjects.add(myPlacemark3);

        // Добавление обработчиков событий для изменения центра карты
        $('.item').on('click', function() {
          const coords = $(this).data('coords');
          myMap.setCenter(coords, 17, {
            checkZoomRange: true
          });
        });
      }
    }, 5000);
  }
});