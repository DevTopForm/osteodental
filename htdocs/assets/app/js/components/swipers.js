import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay, Virtual, Thumbs, EffectFade, EffectCreative } from 'swiper/modules'
Swiper.use([Navigation, Pagination, Autoplay, Virtual, Thumbs, EffectFade, EffectCreative]);


export const initializeMainSwiper = (className) => {
  if (!className) return;
  const swiperElts = document.querySelectorAll(className);
  if (!swiperElts.length) return null;
  swiperElts.forEach((swiperElt) => {
    const swiper = swiperElt.querySelector(`${className}__slider`);
    const dots = swiperElt.querySelector(`${className}__dots`);
    const prevEl = swiperElt.querySelector('.arr--left');
    const nextEl = swiperElt.querySelector('.arr--right');
    const gap = swiperElt.dataset.gap || 0;

    const navigation = Boolean(nextEl || prevEl)
      ? {
        nextEl: nextEl,
        prevEl: prevEl,
      }
      : false;

    const mainSwiper = new Swiper(swiper, {
      slidesPerView: 'auto',
      navigation: navigation,
      spaceBetween: Number(gap),
      effect: 'fade',
      fadeEffect: {
        crossFade: true
      },
      speed: 2000,
      pagination: dots
        ? {
          el: dots,
          type: 'bullets',
          clickable: true,
        }
        : false,
      autoplay: {
        delay: 5000,
      }

    });
    return mainSwiper;
  });
};

export const initializeAutoSwiper = (className) => {
  if (!className) return;
  const swiperElts = document.querySelectorAll(className);
  if (!swiperElts.length) return null;
  swiperElts.forEach((swiperElt) => {
    const swiper = swiperElt.querySelector(`${className}__slider`);
    const dots = swiperElt.querySelector(`${className}__dots`);
    const prevEl = swiperElt.querySelector('.arr--left');
    const nextEl = swiperElt.querySelector('.arr--right');
    const gap = swiperElt.dataset.gap || 0;
    const allowTouchMove = Boolean(swiperElt.dataset.allowtouchmove);
    console.log(allowTouchMove)
    const navigation = Boolean(nextEl || prevEl)
      ? {
        nextEl: nextEl,
        prevEl: prevEl,
      }
      : false;

    const mainSwiper = new Swiper(swiper, {
      slidesPerView: 'auto',
      navigation: navigation,
      spaceBetween: Number(gap),
      allowTouchMove: !allowTouchMove,
      pagination: dots
        ? {
          el: dots,
          type: 'bullets',
          clickable: true,
        }
        : false,

    });
    return mainSwiper;
  });
};


export const initializeWhySwiper = (className) => {
  if (!className) return;
  const swiperElts = document.querySelectorAll(className);
  if (!swiperElts.length) return null;
  swiperElts.forEach((swiperElt) => {
    const swiper = swiperElt.querySelector(`${className}__slider`);
    const dots = swiperElt.querySelector(`${className}__dots`);
    const prevEl = swiperElt.querySelector('.arr--left');
    const nextEl = swiperElt.querySelector('.arr--right');

    const navigation = Boolean(nextEl || prevEl)
      ? {
        nextEl: nextEl,
        prevEl: prevEl,
      }
      : false;

    const mainSwiper = new Swiper(swiper, {
      slidesPerView: 'auto',
      navigation: navigation,
      spaceBetween: 14,
      breakpoints: {
        768: {
          spaceBetween: 24,
        },
        1024: {
          spaceBetween: 40,
        }
      },
      pagination: dots
        ? {
          el: dots,
          type: 'bullets',
          clickable: true,
        }
        : false,

    });
    return mainSwiper;
  });
};


export const initializeCardsSwiper = (className) => {
  if (!className) return;
  const swiperElts = document.querySelectorAll(className);
  if (!swiperElts.length) return null;
  swiperElts.forEach((swiperElt) => {
    const swiper = swiperElt.querySelector(`${className}__slider`);

    const mainSwiper = new Swiper(swiper, {
      slidesPerView: 'auto',
      spaceBetween: 14,
      loop: true,
      autoplay: {
        delay: 5000,
        waitForTransition: false,
        disableOnInteraction: false,
      },
      snapToSlideEdge: true,
      on: {
        slideChange: function () {
          if (window.matchMedia('(min-width: 1300px)').matches) {
            this.slides.forEach((item, index) => {
              if (index < this.activeIndex) {
                item.style.zIndex = this.slides.length - this.activeIndex + index;
                item.style.paddingBlock = `${10 * (index - this.activeIndex)}px`;
              }
              if (index > this.activeIndex) {
                item.style.zIndex = this.slides.length - index + this.activeIndex;
                item.style.paddingBlock = `${10 * (index - this.activeIndex)}px`;
              }

              if (index == this.activeIndex) {
                item.style.zIndex = this.slides.length;
                item.style.paddingBlock = `0`;
              }
            })
          }
        },
        init: function () {
          console.log(this)
          if (window.matchMedia('(min-width: 1300px)').matches) {
            this.hostEl.style.height = `${this.height}px`;
            this.slides.forEach((item, index) => {
              item.style.zIndex = this.slides.length - index + 1;
              item.style.paddingBlock = `${10 * index}px`;
            })
          }
        }
      },
      breakpoints: {
        1300: {
          spaceBetween: -800,
          effect: "creative",
          creativeEffect: {
            prev: {
              shadow: true,
              translate: ["-125%", 0, -800],
              // rotate: [0, 0, -90],
            },
            next: {
              shadow: true,
              translate: ["125%", 0, -800],
              // rotate: [0, 0, 90],
            },
          },
        },
        1500: {
          spaceBetween: -1000,
        }
      }

    });
    return mainSwiper;
  });
};

export const initializeHistorySwiper = (className) => {
  if (!className) return;
  const swiperElts = document.querySelectorAll(className);
  if (!swiperElts.length) return null;
  swiperElts.forEach((swiperElt) => {
    const swiper = swiperElt.querySelector(`${className}__slider`);
    const prevEl = swiperElt.querySelector('.arr--left');
    const nextEl = swiperElt.querySelector('.arr--right');

    const navigation = Boolean(nextEl || prevEl)
      ? {
        nextEl: nextEl,
        prevEl: prevEl,
      }
      : false;

    const mainSwiper = new Swiper(swiper, {
      slidesPerView: 1,
      navigation: navigation,
      spaceBetween: 0,
      slideClass: 'history__it',
      breakpoints: {
        768: {
          spaceBetween: 20,
          slidesPerView: 2,
        },
        1024: {
          spaceBetween: 20,
          slidesPerView: 3,
        },
      },
      on: {
        slideChange: function (swiper) {
          const active = swiper.slidesEl.querySelector('.active');
          if (active) active.classList.remove('active');
          swiper.slides[swiper.activeIndex].classList.add('active')
        },
        click: function (swiper, event) {
          const target = event.target.closest('.swiper-slide');
          if (target) {
            const active = swiper.slidesEl.querySelector('.active')
            if (active) active.classList.remove('active');
            target.classList.add('active')
          }
        },

      },
      // loop: true,
    });
    console.log(mainSwiper)
    return mainSwiper;
  });
};

export const initThumsSwiper = (className) => {
  const swipers = document.querySelectorAll(className);
  if (swipers.length) {
    swipers.forEach((item) => {
      const swiperThumbs = item.querySelector(`${className}__thumbs`)
      const swiperMain = item.querySelector(`${className}__slider`)

      const thumbs = new Swiper(swiperThumbs, {
        spaceBetween: 10,
        slidesPerView: 'auto',
        freeMode: true,
        watchSlidesProgress: true,
        breakpoints: {
          1200: {
            spaceBetween: 20,
          }
        }
      });

      const galleryTop = new Swiper(swiperMain, {
        slidesPerView: 1,
        thumbs: {
          swiper: thumbs,
        },
      });
    })

  }
}

let mobileSlider = null;
export const initMobileSlider = (className) => {
  const swiperElt = document.querySelector(className);
  if (swiperElt) {

    const initSlider = () => {
      const swiper = swiperElt.querySelector(`${className}__slider`);
      const dots = swiperElt.querySelector(`${className}__dots`);
      const prevEl = swiperElt.querySelector('.arr--left');
      const nextEl = swiperElt.querySelector('.arr--right');

      const navigation = Boolean(nextEl || prevEl)
        ? {
          nextEl: nextEl,
          prevEl: prevEl,
        }
        : false;
      mobileSlider = new Swiper(swiper, {
        slidesPerView: 'auto',
        navigation: navigation,
        spaceBetween: 10,
        pagination: dots
          ? {
            el: dots,
            type: 'bullets',
            clickable: true,
          }
          : false,
      });

    }

    const destroySlider = () => {
      if (mobileSlider) {
        mobileSlider.destroy(true, true)
      }
    }

    let isMobile = document.documentElement.clientWidth < 1024;
    if (isMobile) initSlider();

    const resizeObserver = new ResizeObserver(([entry]) => {
      const isMobileNow = entry.contentRect.width < 1024;
      if (isMobileNow === isMobile) return;

      isMobile = isMobileNow;
      if (isMobile) {
        initSlider();
      } else {
        destroySlider();
        mobileSlider = null;
      }
    });

    resizeObserver.observe(document.documentElement);
    return resizeObserver;

  }
}