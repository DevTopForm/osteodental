import { initializeAutoSwiper, initializeWhySwiper, initializeHistorySwiper, initThumsSwiper, initializeCardsSwiper, initializeMainSwiper, initMobileSlider } from "./components/swipers.js";
import GLightbox from "glightbox";
import { VideosInitializer } from "./components/videos.js";
import { setCookiesSession } from "../html/ui/cookies/cookie.js";
import { Popup } from "./components/popups.js";
import { addAnimations, simpleParalax } from "./components/addAnimations.js";
import { Expander } from "./components/expander.js";
import { MapInitializer } from "./components/ymap.js";
import { Tabs } from "./components/tabs.js";
import { compareBeforeAfter } from "../html/ui/before/comparison.js";
import { setTgSession } from "../html/ui/tg-ban/tg-ban.js";



const checkJs = () => {
  document.body.classList.add('js-exists')
}

checkJs();

// Menu opener
const menuOpener = new Expander({
  expandClass: ".js-menu-opener",
  eltToExpandClass: ".js-menu",
  isOut: true,
  openStateClass: "opened",
});

initializeAutoSwiper('.js-auto-swiper');
initializeWhySwiper('.js-why');
initializeHistorySwiper('.history');
initThumsSwiper('.js-thumb-swiper');
initializeCardsSwiper('.js-cards');
initializeMainSwiper('.js-main-swiper');
initMobileSlider('.js-mobile-swiper')

const lightbox = GLightbox({
  touchNavigation: true,
  loop: true,
  autoplayVideos: true,
  selector: `.glightbox`
});

const allGalleries = document.querySelectorAll('[data-glightbox]');
if (allGalleries.length) {
  allGalleries.forEach((item) => {
    let id = item.dataset.glightbox;
    const lightbox = GLightbox({
      touchNavigation: true,
      loop: true,
      autoplayVideos: true,
      selector: `.glightbox-${id}`
    });
  })
}

const videoContainers = document.querySelectorAll('.js-video-block');

if (videoContainers.length) {
  videoContainers.forEach((item) => {
    let video = new VideosInitializer({
      container: item,
      videoClass: '[data-video]',
      clicked: Boolean(item.dataset.clicked)
    })

  });
}

setCookiesSession('link'); 
try {
  const popupsClass = '[data-action]';
  let popupInstance = null;
  let popupOpeners = document.querySelectorAll(popupsClass);


  const onOpenCallback = async (popup) => {
  
  };

  const onCloseCallback = (popup) => {

  }

  if (popupOpeners.length > 0) {
    const popupHandler = (evt) => {
      evt.preventDefault();
      if (popupInstance) {
        popupInstance.close();
      }
      const opener = evt.target.closest(popupsClass)
      const actionType = opener.dataset.action;
      const popupElement = document.querySelector(`[data-target=${actionType}]`);
      if (!popupElement) return;
      popupInstance = new Popup ({
        openElt: opener,
        popupClass: `[data-target=${actionType}]`, //класс попапа
        onOpenCallback: onOpenCallback,
        onCloseCallback: onCloseCallback,
      });
      popupInstance.open();
    };

    popupOpeners.forEach((opener) => opener.addEventListener('click', popupHandler));
  };
} catch (e) {
  console.log(e)
}

const animationBlock = document.querySelectorAll('.anim-block');
if (animationBlock.length) {
  animationBlock.forEach((item) => addAnimations(item));
}

if (window.matchMedia('(min-width: 1024px)').matches) {
  simpleParalax()
}

const mapContainer = document.querySelector('.map__inside');
if (mapContainer) {
  map = new MapInitializer({
    apiKey: mapContainer.dataset.api,
    mapItemsContainerClass: '.map',
    mapWrapperClass: '.map',
  });
}

const tabElements = document.querySelectorAll(".js-tabs");
if (tabElements.length) {
  tabElements.forEach((tabElement) => {
    const tab = new Tabs({
      container: tabElement,
    });
  });
}

compareBeforeAfter();

const topElement = document.querySelector('.js-top');
const header = document.querySelector('.header');

if (topElement && header) {
  const observer = new IntersectionObserver(([entry]) => {
    const isFixed = !entry.isIntersecting;

    header.classList.toggle('header--fixed', isFixed);
    topElement.style.marginBottom = isFixed
      ? `${header.offsetHeight}px`
      : '';
  });

  observer.observe(topElement);
};

setTgSession();