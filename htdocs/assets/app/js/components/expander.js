import { FOCUSABLE_ELTS } from "./consts.js";
import { domElt } from "./dom.js";


export class Expander {
  constructor({
    expandClass,
    eltToExpandClass,
    isOut = false,
    openStateClass = "opened",
    onOpenCallback,
    onCloseCallback,
    closeClass,
    tabindex,
    onInitCallback,
  }) {
    if (!expandClass) return;
    this.expandClass = expandClass;
    this.toggler = domElt(expandClass);
    if (!this.toggler) return;
    this.eltToExpandClass = eltToExpandClass;
    this.openStateClass = openStateClass;
    this.closeClass = closeClass;
    this.tabindex = tabindex;
    this.closeBtn = null;
    this.isOut = isOut;
    this.openedBlock = null;
    this.blockForTabs = null;
    this.onOpenCallback = onOpenCallback;
    this.onCloseCallback = onCloseCallback;
    this.onInitCallback = onInitCallback;
    this.openHandler = this.openHandler.bind(this);
    this.closeHandler = this.closeHandler.bind(this);
    this.outOfAreaHandler = this.outOfAreaHandler.bind(this);
    this.keydownOpenHandler = this.keydownOpenHandler.bind(this);
    this.keydownOutOfAreaHandler = this.keydownOutOfAreaHandler.bind(this);
    this.closeEltKeydownHandler = this.closeEltKeydownHandler.bind(this);
    this.init();
  }

  init() {
    this.toggler.on("click", this.openHandler);
    this.toggler.on("keydown", this.keydownOpenHandler);
    if (this.tabindex) {
      this.blockForTabs = domElt(this.tabindex);
      if (this.blockForTabs) {
        const allFocusable = this.blockForTabs.findAll(FOCUSABLE_ELTS);
        allFocusable.forEach((item) => item.setAttribute('tabindex', '-1'));
      }
    }

    this.openedBlock = Boolean(this.toggler.closest(this.eltToExpandClass).$el)
      ? this.toggler.closest(this.eltToExpandClass)
      : domElt(this.eltToExpandClass);

    if (this.onInitCallback) this.onInitCallback(this);
  }

  keydownOpenHandler(evt) {
    if (evt.key === "Enter") {
      evt.preventDefault();
      this.openElt();
    }
  }

  keydownOutOfAreaHandler(evt) {
    if (evt.key === "Escape") {
      evt.preventDefault();
      this.closeElt();
    }
  }

  openHandler(evt) {
    evt.preventDefault();
    this.openElt();
  }

  openElt() {    
    this.openedBlock = Boolean(this.toggler.closest(this.eltToExpandClass).$el)
      ? this.toggler.closest(this.eltToExpandClass)
      : domElt(this.eltToExpandClass);
    if (!this.openedBlock)
      throw new Error("Проверьте класс блока, который нужно открыть");
    const isOpened = this.openedBlock.$el.classList.contains(this.openStateClass);
    if (!isOpened) this.openedBlock.addClass(this.openStateClass);
    this.toggler.off("click", this.openHandler);
    this.toggler.off("keydown", this.keydownOpenHandler);
    this.toggler.on("click", this.closeHandler);
    
    if (!this.toggler.$el.classList.contains('opened')) this.toggler.addClass('opened');
    if (this.closeClass) {
      this.closeBtn = this.openedBlock.find(this.closeClass);
      this.closeBtn.on("click", this.closeHandler);
      this.closeBtn.on("keydown", this.closeEltKeydownHandler);
    }
    if (this.isOut) {
      window.addEventListener("click", this.outOfAreaHandler);
      window.addEventListener("keydown", this.keydownOutOfAreaHandler);
    }

    if (this.onOpenCallback) {
      this.onOpenCallback();
    }

    if (this.tabindex) {
      const allFocusable = this.blockForTabs.findAll(FOCUSABLE_ELTS);
      allFocusable.forEach((item) => item.setAttribute('tabindex', '1'));
    }
  }

  outOfAreaHandler(evt) {
    if (
      this.openedBlock.$el.contains(evt.target) ||
      this.toggler.$el.contains(evt.target)
    )
      return;
    this.closeElt();
  }

  closeElt() {
    this.openedBlock.removeClass(this.openStateClass);
    this.toggler.off("click", this.closeHandler);
    this.toggler.on("click", this.openHandler);
    this.toggler.removeClass('opened');

    if (this.isOut) {
      window.removeEventListener("click", this.outOfAreaHandler);
      window.removeEventListener("keydown", this.keydownOutOfAreaHandler);
      this.toggler.on("keydown", this.keydownOpenHandler);
    }

    if (this.onCloseCallback) {
      this.onCloseCallback();
    }

    if (this.closeClass) {
      this.closeBtn.off("click", this.closeHandler);
      this.closeBtn.off("keydown", this.closeEltKeydownHandler);
    }

    if (this.tabindex) {
      const allFocusable = this.blockForTabs.findAll(FOCUSABLE_ELTS);
      allFocusable.forEach((item) => item.setAttribute('tabindex', '-1'));
    }

    this.openedBlock = null;
  }

  closeEltKeydownHandler(evt) {
    if (evt.key === "Enter") {
      evt.preventDefault();
      this.closeElt();
    }
  }

  closeHandler(evt) {
    evt.preventDefault();
    this.closeElt();
  }

  destroy() {
    this.closeElt();
    this.toggler.off("click", this.openHandler);
    this.toggler.off("keydown", this.keydownOpenHandler);
    if (this.isOut) window.removeEventListener("click", this.outOfAreaHandler);
  }
}
