import { domElt } from "./dom.js";

export class SeparateSelect {
  constructor({ container, openerEltClass, eltToOpenClass, onOpen, onChange, onClose }) {
    this.container = container;
    this.openerEltClass = openerEltClass;
    this.openerElt = null;
    this.eltToOpenClass = eltToOpenClass;
    this.eltToOpen = null;
    this.onChange = onChange;
    this.onOpen = onOpen;
    this.onClose = onClose;
    this.fakeElt = null;
    this.openHandler = this.openHandler.bind(this);
    this.clickFakeHandler = this.clickFakeHandler.bind(this);
    this.closeHandler = this.closeHandler.bind(this);
    this.keyDownHandler = this.keyDownHandler.bind(this);
    this.outOfAreaHandler = this.outOfAreaHandler.bind(this);
    this.escapeHandler = this.escapeHandler.bind(this);
    this.init();
  }

  init() {
    this.openerElt = this.container.querySelector(this.openerEltClass);
    this.eltToOpen = this.container.querySelector(this.eltToOpenClass);
    this.openerElt.addEventListener('click', this.openHandler);
    this.openerElt.addEventListener('keydown', this.keyDownHandler);
  }

  openHandler(evt) {
    evt.preventDefault();
    this.open();
  }

  open() {
    this.fakeElt = domElt.create("div");
    const cloned = this.eltToOpen.cloneNode(true);
    document.body.append(this.fakeElt.$el);
    const openerSquare = this.openerElt.getBoundingClientRect();

    const top = () => {
      return height < window.innerHeight - openerSquare.bottom
        ? openerSquare.top + openerSquare.height
        : openerSquare.top - height - 10;
    };

    this.fakeElt
      .css({
        position: "fixed",
        top: `${Math.floor(openerSquare.bottom)}px`,
        left: `${Math.floor(openerSquare.left)}px`,
        width: `${Math.floor(openerSquare.width)}px`,
        display: "flex",
        zIndex: "10",
      })
      .append(cloned);

    this.fakeElt.on('click', this.clickFakeHandler);
    this.openerElt.removeEventListener('click', this.openHandler);
    this.openerElt.removeEventListener('keydown', this.keyDownHandler);
    document.addEventListener('click', this.outOfAreaHandler);
    document.addEventListener('keyDown', this.escapeHandler);
    this.openerElt.addEventListener('click', this.closeHandler);
    if (this.onOpen) this.onOpen();
  }

  moveHandler(evt) {

  }

  clickFakeHandler(evt) {
    if (this.onChange) this.onChange(evt.taget);
    this.openerElt.addEventListener('click', this.closeHandler);
  }

  keyDownHandler(evt) {
    if (evt.key === 'Tab' || evt.key === 'Enter') {
      evt.preventDefault();
      this.open();
    }
  }

  escapeHandler(evt) {
    if (evt.key === 'Escape') {
      evt.preventDefault();
      this.close();
    }
  }

  closeHandler(evt) {
    evt.preventDefault();
    this.close();
  }

  

  outOfAreaHandler(evt) {
    console.log(this.fakeElt.$el.contains(evt.tagret), this.eltToOpen.contains(evt.target), evt.target.closest(this.openerEltClass))
    if (!this.fakeElt.$el.contains(evt.tagret) && !evt.target.closest(this.openerEltClass)) {
      this.close()
    }
  }

  close() {
    this.fakeElt.off('click', this.clickFakeHandler);
    this.fakeElt.destroy();
    this.fakeElt = null;
    if (this.onClose) this.onClose();
    document.removeEventListener('click', this.outOfAreaHandler);
    document.removeEventListener('keyDown', this.escapeHandler);
    this.openerElt.removeEventListener('click', this.closeHandler);
    this.openerElt.addEventListener('click', this.openHandler);
    this.openerElt.addEventListener('keydown', this.keyDownHandler);
  }
}  