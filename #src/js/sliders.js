jQuery(document).ready(function ($) {

  
	
	const mainCatsWrapper = document.querySelector('.main-cats');

	if (mainCatsWrapper) {
      const swiper = mainCatsWrapper.querySelector('.swiper');
      const pagination = mainCatsWrapper.querySelector('.dots');
      const arrNext = mainCatsWrapper.querySelector('.arr-next');
      const arrPrev = mainCatsWrapper.querySelector('.arr-prev');
    
      const swiperInstance = new Swiper(swiper, {
        spaceBetween: 20,
        lazy: false,
        loop: false,
        speed: 800,
        slidesPerView: 3,
        navigation: {
          nextEl: arrNext,
          prevEl: arrPrev
        },
        pagination: {
          el: pagination,
          clickable: true,
        },
        breakpoints: {
          300: {
            autoHeight: false,
            slidesPerView: 1,
            spaceBetween: 10,
          },
          578: {
            spaceBetween: 10,
            slidesPerView: 2,
          },
          767: {
            slidesPerView: 2,
            spaceBetween: 20,
          },
          992: {
            slidesPerView: 3,
            spaceBetween: 20,
          } 
        }
      });
      
      // Устанавливаем начальный слайд после инициализации
      if (window.screen.width > 992) {
       // swiperInstance.slideTo(1, 0);
      }
	}

  const newsSlider = document.querySelector('section.news');
	if (newsSlider) {
      const swiper = newsSlider.querySelector('.swiper');
      const arrNext = newsSlider.querySelector('.arr-next');
      const arrPrev = newsSlider.querySelector('.arr-prev');

      let newsSwiper = new Swiper(swiper, {
        spaceBetween: 20,
        autoHeight: false,
        navigation: {
          nextEl: arrNext,
          prevEl: arrPrev
        },
        breakpoints: {
          300: {
            slidesPerView: 1,
            spaceBetween: 8,
          },
          578: {
            slidesPerView: 1,
				    initialSlide: 0,
            spaceBetween: 0,
            
          },
          768: {
            slidesPerView: 2,
            spaceBetween: 20,

          },  
          992: {
            slidesPerView: 3,
            spaceBetween: 20,

          } 
        },
      });
     
	}

  const historySlider = document.querySelector('section.history');
  if (historySlider) {
    const swiper = historySlider.querySelector('.swiper');
    const arrNext = historySlider.querySelector('.arr-next');
    const arrPrev = historySlider.querySelector('.arr-prev');
  
    const items = document.querySelectorAll('.history .line .item');
  
    // Функция для обновления классов active
    function updateActiveClasses(swiperInstance) {
      const activeIndex = swiperInstance.activeIndex;
  
      items.forEach((item, index) => {
        if (index <= activeIndex) {
          item.classList.add('active');
        } else {
          item.classList.remove('active');
        }
      });
    }
  
    // Инициализация Swiper
    const historySwiper = new Swiper(swiper, {
      autoHeight: true,
      slidesPerView: 1,
      spaceBetween: 0,
      navigation: {
        nextEl: arrNext,
        prevEl: arrPrev
      },
      on: {
        init: function () {
          updateActiveClasses(this);
        },
        slideChange: function () {
          updateActiveClasses(this);
        }
      }
    });
  
    // Добавление обработчиков событий для элементов .line .item
    items.forEach((item, index) => {
      item.addEventListener('click', () => {
        historySwiper.slideTo(index);
      });
    });
  
    // Первоначальный вызов для установки правильных классов active
    updateActiveClasses(historySwiper);
  }

  const feedSlider = document.querySelector('.feed-slider');
	if (feedSlider) {
      const swiper = feedSlider.querySelector('.swiper');
      const arrNext = feedSlider.querySelector('.arr-next');
      const arrPrev = feedSlider.querySelector('.arr-prev');
      const pagination = feedSlider.querySelector('.dots');

      let feedSwiper = new Swiper(swiper, {
        spaceBetween: 0,
        slidesPerView: 1,
        autoHeight: true,
        navigation: {
          nextEl: arrNext,
          prevEl: arrPrev
        },
        pagination: {
          el: pagination,
          clickable: true,
        },
        breakpoints: {
          300: {
            spaceBetween: 8,
          },
          578: {
            spaceBetween: 0,
          }
        },
      });

	}

  const gallerySlider = document.querySelectorAll('.gallery-slider');

	if (gallerySlider.length > 0) {
    gallerySlider.forEach(section => {
        const wrapper = section.querySelector('.wrap');
        const swiper = section.querySelector('.swiper');
        const arrNext = section.querySelector('.arr-next');
        const arrPrev = section.querySelector('.arr-prev');
        const items = section.querySelectorAll('.item');
        function startSlider() {
          new Swiper(swiper, {
            spaceBetween: 8,
            lazy: false,
            autoHeight: false,
            navigation: {
              nextEl: arrNext,
              prevEl: arrPrev
            },
            breakpoints: {
              300: {
                slidesPerView: 1,
                spaceBetween: 8,
              },
              578: {
                spaceBetween: 8,
                slidesPerView: 2,
              },  
              992: {
                slidesPerView: 3,
                spaceBetween: 20,
              }
            },
          });
        }
        if (window.screen.width > 992 && items.length > 3) {
          startSlider();
        } else if (window.screen.width < 993 && items.length > 2) {
          startSlider();
        } else {
          wrapper.classList.add('disabled-slider');
        }
      });
      
      
	}

  const vacancySlider = document.querySelector('.vac-offer');
	if (vacancySlider) {
      const swiper = vacancySlider.querySelector('.swiper');
      const pagination = vacancySlider.querySelector('.dots');
      const arrNext = vacancySlider.querySelector('.arr-next');
      const arrPrev = vacancySlider.querySelector('.arr-prev');

      let feedSwiper = new Swiper(swiper, {
        spaceBetween: 0,
        slidesPerView: 1,
        autoHeight: false,
        pagination: {
          el: pagination,
          clickable: true,
        },
        navigation: {
          nextEl: arrNext,
          prevEl: arrPrev
        },
      });

	}

  const videoFeedSlider = document.querySelector('.feed-videos');

	if (videoFeedSlider) {
      const wrapper = videoFeedSlider.querySelector('.wrap');
      const swiper = videoFeedSlider.querySelector('.swiper');
      const arrNext = videoFeedSlider.querySelector('.arr-next');
      const arrPrev = videoFeedSlider.querySelector('.arr-prev');
      const items = videoFeedSlider.querySelectorAll('.item');
      const pagination = videoFeedSlider.querySelector('.dots')
      function startSlider() {
        new Swiper(swiper, {
          lazy: false,
          autoHeight: false,
          pagination: {
            el: pagination,
            clickable: true,
          },
          navigation: {
            nextEl: arrNext,
            prevEl: arrPrev
          },
          breakpoints: {
            300: {
              slidesPerView: 1,
              spaceBetween: 0,
            },
            578: {
              spaceBetween: 20,
              slidesPerView: 1,
            },  
            992: {
              slidesPerView: 2,
              spaceBetween: 20,
            }
          },
        });
      }
      if (window.screen.width > 992 && items.length > 2) {
        startSlider();
      } else if (window.screen.width < 993 && items.length > 1) {
        startSlider();
      } else {
        wrapper.classList.add('disabled-slider');
      }
	}


  const sertSlider = document.querySelector('.sertificates');
	if (sertSlider) {
      const wrapper = sertSlider.querySelector('.wrap');
      const swiper = sertSlider.querySelector('.swiper');
      const arrNext = sertSlider.querySelector('.arr-next');
      const arrPrev = sertSlider.querySelector('.arr-prev');
      const items = sertSlider.querySelectorAll('.item');
      function startSlider() {
        new Swiper(swiper, {
          lazy: false,
          autoHeight: false,
          navigation: {
            nextEl: arrNext,
            prevEl: arrPrev
          },
          breakpoints: {
            300: {
              slidesPerView: 2,
              spaceBetween: 0,
            },
            768: {
              spaceBetween: 10,
              slidesPerView: 3,
            },  
            992: {
              slidesPerView: 4,
              spaceBetween: 20,
            }
          },
        });
      }
      if (window.screen.width > 992 && items.length > 4) {
        startSlider();
      } else if (window.screen.width < 993 && items.length > 3) {
        startSlider();
      } else if (window.screen.width < 768 && items.length > 2) {
        startSlider();
      } else {
        wrapper.classList.add('disabled-slider');
      }
	}

  const relatedSlider = document.querySelector('.related');
	if (relatedSlider) {
      const wrapper = relatedSlider.querySelector('.wrap');
      const swiper = relatedSlider.querySelector('.swiper');
      const arrNext = relatedSlider.querySelector('.arr-next');
      const arrPrev = relatedSlider.querySelector('.arr-prev');
      const itemsWrap = relatedSlider.querySelector('ul.products');
      const items = relatedSlider.querySelectorAll('li.product');
      itemsWrap.classList.add('swiper-wrapper');
      function startSlider() {
        new Swiper(swiper, {
          lazy: false,
          autoHeight: false,
          navigation: {
            nextEl: arrNext,
            prevEl: arrPrev
          },
          breakpoints: {
            300: {
              slidesPerView: 2,
              spaceBetween: 8,
            },
            768: {
              spaceBetween: 10,
              slidesPerView: 2,
            },  
            992: {
              slidesPerView: 4,
              spaceBetween: 20,
            }
          },
        });
      }
      if (window.screen.width > 992 && items.length > 4) {
        startSlider();
      } else if (window.screen.width < 993 && items.length > 2) {
        startSlider();
      } else if (window.screen.width < 768 && items.length > 2) {
        startSlider();
      } else {
        wrapper.classList.add('disabled-slider');
      }
	}

	



  if (window.screen.width < 579) {
    const ourRow = document.querySelectorAll('.our-row');
    if (ourRow.length > 0) {
        ourRow.forEach(elem => {
          const swiper = elem.querySelector('.swiper');
          const pagination = elem.querySelector('.dots');
          new Swiper(swiper, {
            spaceBetween: 8,
            autoHeight: false,
            slidesPerView: 2,
            pagination: {
              el: pagination,
              clickable: false,
            }
          });
        })
    }
    const catSliderPost = document.querySelectorAll('.content .block_category');
    if (catSliderPost.length > 0) {
        catSliderPost.forEach(elem => {
          const swiper = elem.querySelector('.swiper');
          new Swiper(swiper, {
            spaceBetween: 8,
            autoHeight: false,
            slidesPerView: 2,
          });
        })
    }
    const gallContentSlider = document.querySelectorAll('.wp-block-gallery');
    if (gallContentSlider.length > 0) {
        gallContentSlider.forEach(elem => {
          const items = elem.querySelectorAll('.wp-block-image');
          const swiperWrapper = document.createElement('div');
          swiperWrapper.classList.add('swiper-wrapper');
          elem.appendChild(swiperWrapper);
          const newSwiperWrapper = elem.querySelector('.swiper-wrapper');
          items.forEach(img => {
            img.classList.add('swiper-slide');
            const clone = img.cloneNode(true);
            newSwiperWrapper.appendChild(clone);
            img.remove();
          });
          elem.classList.add('swiper');

          new Swiper(elem, {
            spaceBetween: 8,
            autoHeight: false,
            slidesPerView: 1,
          });
        })
    }

    const orderSlider = document.querySelectorAll('.order');
    if (orderSlider.length > 0) {
        orderSlider.forEach(elem => {
          const swiper = elem.querySelector('.swiper');

          if (swiper) {
            const pagination = elem.querySelector('.dots');
            new Swiper(swiper, {
              spaceBetween: 20,
              autoHeight: false,
              slidesPerView: 2,
              pagination: {
                el: pagination,
                clickable: false,
              }
            });
          }

        });
    }

    
    const aboutFeedGallSlider = document.querySelector('section.about-feed');
    if (aboutFeedGallSlider) {
      const swiper = aboutFeedGallSlider.querySelector('.swiper');
      new Swiper(swiper, {
        spaceBetween: 10,
        autoHeight: false,
        slidesPerView: 1,
        initialSlide: 1,
      });
    }

    
  } // mob end

  
 

 
}); //end