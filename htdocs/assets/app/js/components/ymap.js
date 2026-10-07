/* <script src="https://api-maps.yandex.ru/v3/?apikey=77738d13-2db6-45e5-b348-0e92b490f417&lang=ru_RU"
  data-skip-moving="true"></script> */

const ZOOM_RANGE = { min: 2, max: 40 };

const getCoordsMinMax = (arr, position) =>
  arr.map((item) => Number(item[position])).sort((a, b) => a - b);


export class MapInitializer {
  constructor({ apiKey, mapItemsContainerClass, mapWrapperClass, onPointClick }) {
    this.apiKey = apiKey;
    this.apiScript = null;
    this.ymaps3 = null;
    this.map = null;
    this.onPointClick = onPointClick;
    this.mapWrapperClass = mapWrapperClass;
    this.mapItemsContainerClass = mapItemsContainerClass;
    this.init();
  }

  async loadScript() {
    this.ymaps3 = ymaps3;
    await this.ymaps3.ready;
    this.map = await mainMap({
      mapClass: this.mapWrapperClass,
      mapItemsContainerClass: this.mapItemsContainerClass,
      onPointClick: this.onPointClick
    });
  }

  async init() {
    const scriptExists = document.querySelector(
      `[href="https://api-maps.yandex.ru/v3/?apikey=${this.apiKey}&lang=ru_RU"]`
    );
    if (scriptExists) {
      await mainMap({
        mapClass: this.mapWrapperClass,
        mapItemsContainerClass: this.mapItemsContainerClass,
        onPointClick: this.onPointClick
      });
      return
    }
    await this.appendScript();
    this.apiScript.onload = async () => await this.loadScript();

  }

  async appendScript() {
    if (this.apiScript) return;
    this.apiScript = document.createElement("script");
    this.apiScript.src = `https://api-maps.yandex.ru/v3/?apikey=${this.apiKey}&lang=ru_RU`;
    document.querySelector("head").append(this.apiScript);

  }
}

function isValidCoordinateString(value) {
  if (typeof value !== 'string') return false;
  const parts = value.trim().split(',').map((part) => part.trim());
  if (parts.length !== 2) return false;

  const [lng, lat] = parts;
  if (!lng || !lat) return false;

  const lngNum = Number(lng);
  const latNum = Number(lat);
  if (!Number.isFinite(lngNum) || !Number.isFinite(latNum)) return false;

  if (lngNum < -180 || lngNum > 180) return false;
  if (latNum < -90 || latNum > 90) return false;

  return true;
}

async function mainMap({ mapClass, mapItemsContainerClass, onPointClick }) {
  console.log('Внимание! Не забудьте заменить ссылку яндекса с корректным апи!! Сейчас там мтоит вариант с камкабеля')
  const mapContainer = document.querySelector(mapClass);
  if (!mapContainer) return;

  await ymaps3.ready;
  const {
    YMap,
    YMapDefaultSchemeLayer,
    YMapDefaultFeaturesLayer,
    YMapMarker,
  } = ymaps3;

  class NewMap {
    constructor(mapContainer, mapItems) {
      this.mapItems = mapItems;
      this.bounds = [];
      this.center = [];
      this.map = null;
      this.container = mapContainer;
      this.init();
    }

    init() {
      this.bounds = this.getBounds();
      this.center = this.getCenter();

      this.map = new YMapsHandler({
        mapBounds: this.bounds,
        center: this.center,
        markers: this.mapItems,
        container: this.container,
      });

      this.map.init();
    }

    updateMarkers(markers) {
      this.mapItems = markers;
      this.map.resetMarkers(markers);
    }

    showMapHandler() {
      if (this.map) return;
      this.init();
    }

    hideMapHandler() {
      if (!this.map) return;
      this.map.destroyMap();
      this.map = null;
    }

    getBounds() {
      if (this.mapItems.length <= 1) return null;
      const square = [...this.mapItems].map((item) => item.dataset.coords.split(","));
      const langs = getCoordsMinMax(square, 1);
      const lats = getCoordsMinMax(square, 0);
      return [
        [Number(langs[0]) - 0.1, Number(lats[0]) - 0.1],
        [
          Number(langs[langs.length - 1]) + 0.1,
          Number(lats[lats.length - 1]) + 0.1,
        ],
      ];
    }

    getCenter() {
      if (this.mapItems.length <= 1) {
        let val = Boolean(this.mapItems[0].dataset.coords)
          ? this.mapItems[0].dataset.coords
          : '55.755864,37.617698'
        return val
          .split(",")
          .map((item) => Number(item));
      }
      return JSON.parse(JSON.stringify(this.bounds)).reduce((curr, acc) => {
        if (!curr) {
          curr = acc;
        } else {
          curr[0] = Number(((curr[0] + acc[0]) / 2).toFixed(6));
          curr[1] = Number(((curr[1] + acc[1]) / 2).toFixed(6));
        }
        return curr;
      });
    }
  };


  class YMapsHandler {
    constructor({
      mapBounds = null,
      center,
      markers = [],
      container,
    }) {
      this.mapBounds = mapBounds;
      this.map = null;
      this.center = center;
      this.container = container;
      this.markers = markers;
      this.YMapMarker = null;
      this.activePoint = null;
      this.zoomRange = null;
      this.markersPopups = [];
      this.changeCenterHandler = this.changeCenterHandler.bind(this);
      this.activatePopup = this.activatePopup.bind(this);
      this.setSingleMarker = this.setSingleMarker.bind(this);
      this.clickCallback = this.clickCallback.bind(this);
      this.setActivePopup = this.setActivePopup.bind(this);
    }

    async init() {
      this.container = this.container;
      if (!this.container)
        throw new Error("Укажите валидный контейнер для карты");
      this.createMap();
    }

    clickCallback(object, evt) {
      let coords = evt.coordinates;
    }

    changeCenterHandler(center) {
      this.map.update({
        location: {
          center: center,
          duration: 1000,
        },
      });
    }

    activatePopup({ coords }) {
      this.changeCenterHandler(coords);
    }

    setActivePopup(popup) {
      if (this.activePoint) this.activePoint.closePopup();
      this.activePoint = popup;
    }

    async createMap() {
      const location = this.mapBounds
        ? {
          bounds: this.mapBounds,
          center: this.center.reverse(),
        }
        : {
          center: this.center,
          zoom: 15,
        };

      this.map = await new YMap(
        this.container,
        { location: location },
        [new YMapDefaultSchemeLayer({}), new YMapDefaultFeaturesLayer({})]
      );
      if (this.mapBounds) {
        await this.setMarkers();
      } else {
        if (this.markers.length === 1 && this.markers[0].value !== '') {
          await this.setSingleMarker(this.markers[0].dataset.coords.split(','), this.markers[0].dataset.address);
        }
      }
    }

    async setSingleMarker(coords, props) {
      if (coords.length < 2) return;
      let currPopup = this.createPopupContent(props)
      // this.map.addChild(popup);
      const markerPoint = new CustomMapsMarker({
        coords: coords.reverse(),
        props: currPopup,
        onClick: (args) => {
          onPointClick(coords);
          let curCoords = Number(coords[0]) > Number(coords[1]) ? coords.reverse() : coords;
          this.changeCenterHandler(curCoords);
          args.marker.element.classList.remove('hidden')
        }
      }).init();
      this.markersPopups.push(markerPoint);
      this.map.addChild(markerPoint);

    }

    createPopupContent(address) {
      const content = document.createElement('div');
      content.classList.add('balloon');
      content.innerHTML = `
      <p class="balloon__description" style="position: absolute; top: 0; left: 50%;width:200px; background-color: #fff; padding: 10px;border-radius: 12px;transform: translate(-100%, -100%)">
        ${address}
      </p>
    `;
      return content;
    };

    async setMarkers() {
      if (!this.markers.length) return;

      this.markers.forEach((marker, id) => {
        const coords = marker.dataset.coords
          .split(",")
          .map((item) => Number(item));
        if (coords.length < 2) return;

        this.setSingleMarker(coords, marker.dataset.address)
      });
    }

    resetMarkers(markers) {
      this.markersPopups.forEach((item) => this.map.removeChild(item));
      this.markersPopups = [];
      this.markers = markers;
      this.setMarkers();
    }

    removeMarker(point) {
      this.map.removeChild(point)
    }

    destroyMap() {
      this.map.destroy();
      this.map = null;
    }
  }
  // https://yandex.ru/maps-api/docs/js-api/examples/cases/marker-popup.html

  class CustomMapsMarker {
    constructor({ coords, props, onPopupOpen, onClick, draggable = false }) {
      this.marker = null;
      this.coords = coords;
      this.props = props;
      this.draggable = draggable;
      this.onClickElt = onClick;
      this.popup = null;
      this.onPopupOpen = this.onPopupOpen;
      this.onClickElt = this.onClickElt.bind(this);
    }

    createElement() {
      const elt = document.createElement('div')
      elt.style.position = 'relative';
      elt.classList.add('baloon-wrapper');
      elt.classList.add('hidden');
      const imageElement = document.createElement('img');
      imageElement.src = '/img/pin.svg';
      imageElement.alt = 'адрес компании';
      imageElement.classList.add('pin');
      imageElement.width = 88;
      imageElement.height = 88;
      imageElement.style.width = '88px';
      imageElement.style.height = '88px';
      elt.appendChild(imageElement)
      elt.appendChild(this.props)
      console.log(elt)
      return elt;
    }

    init() {
      this.marker = new YMapMarker(
        {
          coordinates: this.coords.reverse(),
          draggable: this.draggable,
          mapFollowsOnDrag: true,
          onClick: () => {
            this.onClickElt(this)
            this.marker.update({ zIndex: 1000 })
          },
          // popup: { content: this.props }
        },
        this.createElement()
      );
      return this.marker;
    }

  }


  class MapPageHandler {
    constructor({
      containerClass = ".js-map-its",
      mapContainerClass = "#map",
    }) {
      this.containerClass = containerClass;
      this.container = document.querySelector(this.containerClass);
      this.mapItems = [];
      this.map = null;
      this.mapContainerClass = mapContainerClass;
      this.mapContainer = null;
      this.init();
    }

    init() {
      this.mapContainer = this.container.querySelector(this.mapContainerClass);
      this.mapItems = this.getMapItems();
      if (!this.mapContainer) throw new Error("Где блок для карты?");
      this.map = new NewMap(this.mapContainer, this.mapItems);
    }

    getMapItems() {
      return this.container.querySelectorAll('[data-coords]');
    }
  }

  let map = new MapPageHandler({
    containerClass: mapClass,
    mapContainerClass: '#map',
  });

  return map;
}
