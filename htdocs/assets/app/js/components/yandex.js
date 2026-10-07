import { CreateNewElement } from "./createNewElt.js";

const coords = {
  coords: [60.014410, 30.321348],
  name: 'HERMES TOOLS',
  description: "Санкт-Петербург, Ярославский проспект, дом 31",
};

const ZOOM_RANGE = { min: 2, max: 20 };

const getCoordsMinMax = (arr, position) =>
  arr.map((item) => Number(item[position])).sort((a, b) => a - b);


export class YmapsInitializer {
  constructor(container, placeCoords = coords) {
    this.container = container;
    this.coords = placeCoords;
    this.url = 'https://api-maps.yandex.ru/2.1/?lang=ru_RU';
    this.myMap = null;
    this.mapContainer = null;
    this.mapBounds = null;
    this.center = null;
    this.mapItems = [];
    this.apiScript = null;
    this.myPlacemark = null;
    this.pinSize = 20;
    this.loadMap = this.loadMap.bind(this);
    this.getElementPosition(this.container);
  }

  addMapDetails(mapCoords) {
    const location = this.mapBounds
      ? {
        bounds: this.mapBounds,
        center: this.center,
        zoomRange: ZOOM_RANGE,
      }
      : {
        center: this.center,
        zoom: 9,
      };
    const init = () => {
      this.myMap = new ymaps.Map("map", {
        location,
      });
      this.myPlacemark = new ymaps.Placemark(this.myMap.getCenter(), {
        hintContent: this.coords.name,
        balloonContent: mapCoords.description
      }, {
        iconLayout: 'default#image',
        iconImageHref: '/local/templates/topform/assets/build/img/pin.svg',
        iconImageSize: [this.pinSize, this.pinSize],
        iconImageOffset: [-10, -10]
      });
      this.myMap.geoObjects.add(this.myPlacemark);
    }
    ymaps.ready(init);
  }

  getBounds() {
    this.mapItems = this.container.querySelectorAll('.map-block__elt');
    if (this.mapItems.length === 1) return null;
    const square = [...this.mapItems].map((item) =>
      item.dataset.coords.split(",")
    );
    const langs = getCoordsMinMax(square, 0);
    const lats = getCoordsMinMax(square, 1);
    return [
      [Number(langs[0]) - 1.5, Number(lats[0]) - 1.5],
      [
        Number(langs[langs.length - 1]) + 1.5,
        Number(lats[lats.length - 1]) + 1.5,
      ],
    ];
  }

  getCenter() {
    if (this.mapItems.length === 1)
      return this.mapItems[0].dataset.coords
        .split(",")
        .map((item) => Number(item));
    return this.mapBounds.reduce((curr, acc) => {
      if (!curr) {
        curr = acc;
      } else {
        curr[0] = Number(((curr[0] + acc[0]) / 2).toFixed(6));
        curr[1] = Number(((curr[1] + acc[1]) / 2).toFixed(6));
      }
      return curr;
    });
  }

  changeCenter(newCoords) {
    this.myMap.setCenter(newCoords.coords);
    if (this.myPlacemark) this.myPlacemark = null;
    this.myPlacemark = new ymaps.Placemark(this.myMap.getCenter(), {
      hintContent: newCoords.name,
      balloonContent: newCoords.description
    }, {
      iconLayout: 'default#image',
      iconImageHref: '/local/templates/topform/assets/build/img/pin.svg',
      iconImageSize: [this.pinSize, this.pinSize],
      iconImageOffset: [-10, -10]
    });
    this.myMap.geoObjects.add(this.myPlacemark);
  }

  loadApikey(url) {
    if (this.apiScript) return;
    this.apiScript = document.createElement('script');
    this.apiScript.src = url;
    this.container.prepend(this.apiScript);
    this.apiScript.onload = () => this.addMapDetails(this.coords);
  }

  getElementPosition(elem) {
    const observer = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          this.loadMap();
          observer.unobserve(entry.target);
        }
      });
    });
    observer.observe(elem);
  }

  loadMap() {
    this.createMapContainer();
    this.loadApikey(this.url);
    this.getPinSize();
    this.mapBounds = this.getBounds();
    this.center = this.getCenter();
  }

  createMapContainer() {
    if (this.mapContainer) return;
    this.mapContainer = new CreateNewElement(this.container, 'div', 'map-container');
    this.mapContainer.createElmt();
    this.mapContainer.setAttribute('id', 'map');
  }

  getPinSize() {
    this.pinSize = window.matchMedia('(max-width: 752px)').matches ? 20 : 30;
  }
};

