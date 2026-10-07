const ColorSchemes = {
  normal: "html--normal",
  blue: "html--blue",
  green: "html--green",
  white: "html--white",
  dark: "html--dark"
};

const PicturesOn = {
  on: 'picture',
  off: 'no-picture',
};

let storage = JSON.parse(sessionStorage.getItem('stopamerSight'));
let storageHandler;

const sightBlockHandler = () => {
  document.querySelector('header').classList.add('sight-opened');
  new SightCorrector();
}

export function sightSwitcher(switcher) {
  if (storage) {
    storageHandler = new SightCorrector();
  }
  if (!switcher) return;

  switcher.addEventListener('click', sightBlockHandler);

};

class SightCorrector {
  constructor() {
    this.currSize = null;
    this.currColorScheme = null;
    this.currentPictures = null;
    this.htmlElt = document.querySelector('html');
    this.defaultFontSize = window.getComputedStyle(this.htmlElt).fontSize;
    this.storage = JSON.parse(sessionStorage.getItem('stopamerSight'));
    this.form = document.querySelector('.sight__form');
    this.minusFont = this.form.querySelector('.sight__label--font');
    this.colorChangers = this.form.querySelectorAll('[name="color"]');
    this.pictureChangers = this.form.querySelectorAll('[name="img"]');
    this.defaultChanger = this.form.querySelector('.sight__default');
    this.closer = this.form.querySelector('.sight__close');
    this.sightInput = this.form.querySelector('.sight__input');
    this.pictureHandler = this.pictureHandler.bind(this);
    this.colorHandler = this.colorHandler.bind(this);
    this.fontHandler = this.fontHandler.bind(this);
    this.defaultHandler = this.defaultHandler.bind(this);
    this.closeHandler = this.closeHandler.bind(this);
    this.keyFontHandler = this.keyFontHandler.bind(this);
    this.keyDefaultHandler = this.keyDefaultHandler.bind(this);
    this.keyCloseHandler = this.keyCloseHandler.bind(this);
    this.init();
  }

  init() {
    if (this.storage) {
      this.currSize = this.storage.font;
      this.currColorScheme = this.storage.color;
      this.currentPictures = this.storage.pictures;
      this.attrHandler({ color: this.currColorScheme, picture: this.currentPictures })
      this.htmlElt.style.fontSize = `${this.currSize}px`;
    } else {
      this.currSize = parseInt(this.defaultFontSize.slice(0, this.defaultFontSize.length - 2));
      this.currColorScheme = ColorSchemes.normal;
      this.currentPictures = PicturesOn.on;
      this.updateStorage();
    }

    this.pictureChangers.forEach(picture => picture.addEventListener('click', this.pictureHandler));
    this.colorChangers.forEach(color => color.addEventListener('click', this.colorHandler));
    this.minusFont.addEventListener('click', this.fontHandler);
    this.minusFont.addEventListener('keyup', this.keyFontHandler);
    this.defaultChanger.addEventListener('click', this.defaultHandler);
    this.defaultChanger.addEventListener('keyup', this.keyDefaultHandler);
    this.closer.addEventListener('click', this.closeHandler);
    this.closer.addEventListener('keyup', this.keyCloseHandler);
    this.form.addEventListener('submit', (evt) => evt.preventDefault());
  }

  closeHandler(evt) {
    document.querySelector('header').classList.remove('sight-opened');
    this.pictureChangers.forEach(picture => picture.removeEventListener('click', this.pictureHandler));
    this.colorChangers.forEach(color => color.removeEventListener('click', this.colorHandler));
    this.minusFont.removeEventListener('click', this.fontHandler);
    this.defaultChanger.removeEventListener('click', this.defaultHandler);
    this.closer.removeEventListener('click', this.closeHandler);
    this.minusFont.removeEventListener('keyup', this.keyFontHandler);
  }

  keyCloseHandler(evt) {
    if (evt.key === 'Enter') {
      this.closeHandler(evt);
    }
  }

  attrHandler({ color = this.currColorScheme, picture = this.currentPictures }) {
    return this.htmlElt.setAttribute("class", `${color} ${picture}`);
  }

  defaultHandler() {
    this.defaultFontSize = 16;
    this.currColorScheme = ColorSchemes.normal;
    this.currentPictures = PicturesOn.on;
    this.currSize = parseInt(this.defaultFontSize);
    this.sightInput.value = this.currSize;
    this.htmlElt.style.fontSize = `${this.defaultFontSize}px`;
    this.updateStorage();
    this.htmlElt.setAttribute("class", `${this.currColorScheme} ${this.currentPictures}`);
  }

  keyDefaultHandler(evt) {
    if (evt.key === 'Enter') {
      this.defaultHandler(evt);
    }
  }

  updateStorage() {
    return sessionStorage.setItem('stopamerSight', JSON.stringify({
      font: this.currSize,
      color: this.currColorScheme,
      pictures: this.currentPictures
    }));
  }

  fontHandler(evt) {
    if (evt.target.closest('.switcher')) {
      evt.preventDefault();
      if (evt.target.dataset.font === 'minus') {
        this.currSize -= 1;
      } else {
        this.currSize += 1;
      }
      this.sightInput.value = this.currSize;
      this.updateStorage();
      this.htmlElt.style.fontSize = `${this.currSize}px`;
    }
  }

  keyFontHandler(evt) {
    if (evt.key === 'Enter') {
      this.fontHandler(evt);
    }
  }

  pictureHandler(evt) {
    this.currentPictures = evt.target.value === 'yes'
      ? PicturesOn.on
      : PicturesOn.off;
    this.updateStorage();
    return this.attrHandler({ picture: this.currentPictures });
  }


  colorHandler(evt) {
    const colorScheme = evt.target.value;
    switch (colorScheme) {
      case 'white':
        this.currColorScheme = ColorSchemes.white;
        break;
      case 'green':
        this.currColorScheme = ColorSchemes.green;
        break;
      case 'blue':
        this.currColorScheme = ColorSchemes.blue;
        break;
      case 'dark':
        this.currColorScheme = ColorSchemes.dark;
        break;
      case 'normal':
        this.currColorScheme = ColorSchemes.normal;
        break;
    }

    this.updateStorage();
    return this.attrHandler({ color: this.currColorScheme });
  };
}
