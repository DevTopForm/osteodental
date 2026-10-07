import { MenuHandler } from "./menu-opener.js";
import Swiper from "swiper";
import {
  Thumbs,
} from "swiper/modules";
Swiper.use([Thumbs]);

let menuRow = null;
let subMenuRow = null;
let imageBlock = null;
let allMenuElts = [];


const changeImage = (elt) => {
  const src = elt.dataset.img;
  imageBlock.src = src;
};

const mouseEnterHandler = (evt) => {
  const target = evt.target.closest('[data-img]');
  if (!target) return;
  changeImage(target)
}

const initHovers = ({ container, className = '[data-img]', activeIndex }) => {
  allMenuElts = container.querySelectorAll(className);
  changeImage(allMenuElts[0]);
  if (activeIndex === 1) {
    imageBlock.closest('div').classList.add('catalog-menu__img--prod');
  } else {
    imageBlock.closest('div').classList.remove('catalog-menu__img--prod');
  }
  if (allMenuElts.length) {
    allMenuElts.forEach((it) => {
      it.addEventListener('mouseenter', mouseEnterHandler);
    });
  }
}

const onMenuOpen = (menu) => {
  imageBlock = menu.querySelector('img');
  menuRow = new Swiper('.js-menu-thumb', {
    spaceBetween: 40,
    slidesPerView: 'auto',
  });

  subMenuRow = new Swiper('.js-menu-top', {
    slidesPerView: 1,
    thumbs: {
      swiper: menuRow,
    },
    on: {
      init: function () {
        if (allMenuElts.length) {
          allMenuElts.forEach((it) => {
            it.removeEventListener('mouseenter', mouseEnterHandler);
          });
        }
        initHovers({ container: this.slides[this.activeIndex], className: '[data-img]', activeIndex:this.activeIndex });
      },
      slideChange: function () {
        if (allMenuElts.length) {
          allMenuElts.forEach((it) => {
            it.removeEventListener('mouseenter', mouseEnterHandler);
          });
        }
        initHovers({ container: this.slides[this.activeIndex], className: '[data-img]', activeIndex:this.activeIndex });

      }
    }
  });



};

const onMenuClose = () => {
  menuRow.destroy(true, true);
  subMenuRow.destroy(true, true);
  menuRow = null;
  subMenuRow = null;

  if (allMenuElts.length) {
    allMenuElts.forEach((it) => {
      it.removeEventListener('mouseenter', mouseEnterHandler);
    });
  }
  allMenuElts = [];
};

export const menuInstance = new MenuHandler({
  togglerClass: '.js-menu-toggler',
  menuClass: '.js-menu',
  headerOpenClass: 'header--menu',
  onOpen: onMenuOpen,
  onClose: onMenuClose,
});