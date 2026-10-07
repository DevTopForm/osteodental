import { domElt } from "./dom.js";

export class TooltipActivator {
  constructor({ container, activatorClass }) {
    if (!container || !activatorClass) return;
    this.container = container;
    this.activatorClass = activatorClass;
    this.tooltips = [];
    this.activeTooltip = null;
    this.prevTooltip = null;
    this.tooltipElt = null;
    this.position = { bottom: 0, left: 0, 'max-width': 200 };
    this.mooveTooltip = this.mooveTooltip.bind(this);
    this.mouseenterTooltipHandler = this.mouseenterTooltipHandler.bind(this);
    this.mouseleaveTooltipHandler = this.mouseleaveTooltipHandler.bind(this);
    this.outOfAreaHndler = this.outOfAreaHndler.bind(this);
    this.isMObile = false;
    this.setListeners();
  }

  setListeners() {
    this.isMObile = window.matchMedia("(max-width:768px)").matches;
    this.tooltips = this.container.querySelectorAll(this.activatorClass);
    this.tooltips.forEach((tooltip) => {
      if (!this.isMObile) {
        tooltip.addEventListener("mouseenter", this.mouseenterTooltipHandler);
        tooltip.addEventListener("focusin", this.mouseenterTooltipHandler);
      } else {
        tooltip.addEventListener("click", this.mouseenterTooltipHandler);
      }
    });
  }

  createStyleRow(obj) {
    return Object.entries(obj)
      .map((key) => {
        return `${key[0]}:${key[1]}px`
      })
      .join(";");
  }

  getPosition() {
    const containerPosition = this.container.getBoundingClientRect();
   
    const eltPosition = this.activeTooltip.getBoundingClientRect();

    let tooltipPosition = this.tooltipElt.$el.getBoundingClientRect();
    let left = Math.round(eltPosition.left + eltPosition.width / 2 - tooltipPosition.width / 2);
    console.log(containerPosition.width)
    this.position['max-width'] = Math.floor(containerPosition.width);
    this.position.bottom = Math.round(window.innerHeight - eltPosition.top + 10);
    
    if (left - containerPosition.left < 0) {
      left = containerPosition.left;
    } else if (left + tooltipPosition.width > containerPosition.left + containerPosition.width) {
      left = containerPosition.left + containerPosition.width - tooltipPosition.width;
    }

    this.position.left = left;
    this.position.visibility = 'visible'
    return this.position;
  }

  createTooltip() {
    this.tooltipElt = domElt.create('div', 'tooltip');
   
    const tooltipContent = this.activeTooltip.dataset.tooltip === 'content' 
    ? this.activeTooltip.querySelector('.js-tooltip-content').innerHTML
    : `<span>${this.activeTooltip.dataset.tooltip}</span>`;

    const addsStyle = this.activeTooltip.dataset.tooltipStyle;
    if (addsStyle) {
      this.tooltipElt.addClass(addsStyle);
    } 
    this.tooltipElt.html(`<div class="tooltip__wrapper">
      <div class="tooltip__inside">
        ${tooltipContent}
      </div>
    </div>`);

    this.container.append(this.tooltipElt.$el);
    this.mooveTooltip();
    window.addEventListener("scroll", this.mooveTooltip, { passive: true });
  }

  mooveTooltip(evt) {
    const position = this.createStyleRow(this.getPosition());
    this.tooltipElt.attr("style", position);
  }

  mouseenterTooltipHandler(evt) {
    this.activeTooltip = evt.target.closest(this.activatorClass);
    if (!this.activeTooltip) return;
    if (!this.isMObile) {
      this.activeTooltip.removeEventListener(
        "mouseenter",
        this.mouseenterTooltipHandler
      );
      this.activeTooltip.removeEventListener(
        "focusin",
        this.mouseenterTooltipHandler
      );
      this.activeTooltip.addEventListener(
        "mouseleave",
        this.mouseleaveTooltipHandler
      );
      this.activeTooltip.addEventListener(
        "focusout",
        this.mouseleaveTooltipHandler
      );
      this.createTooltip();
    } else {
      if (this.prevTooltip !== this.activeTooltip) {
        if (this.tooltipElt) this.mouseleaveTooltipHandler();
        this.prevTooltip = this.activeTooltip;
        document.addEventListener("click", this.outOfAreaHndler);
        this.createTooltip();
      }
    }
  }

  mouseleaveTooltipHandler(evt) {
    this.tooltipElt.destroy();
    this.tooltipElt = null;
    if (!this.isMObile) {
      this.activeTooltip.removeEventListener(
        "mouseleave",
        this.mouseleaveTooltipHandler
      );
      this.activeTooltip.removeEventListener(
        "focusout",
        this.mouseleaveTooltipHandler
      );
      this.activeTooltip.addEventListener(
        "mouseenter",
        this.mouseenterTooltipHandler
      );
      this.activeTooltip.addEventListener(
        "focusin",
        this.mouseenterTooltipHandler
      );
      this.activeTooltip = null;
    } else {
      document.removeEventListener("click", this.outOfAreaHndler);
      // this.prevTooltip = null;
    }
    window.removeEventListener("scroll", this.mooveTooltip, { passive: true });
  }

  outOfAreaHndler(evt) {
    if (!this.activeTooltip.contains(evt.target)) {
      this.mouseleaveTooltipHandler();
      this.activeTooltip = null;
      this.prevTooltip = null;
    }
  }

  destroy() {
    this.tooltips.forEach((tooltip) => {
      if (!this.isMObile) {
        tooltip.removeEventListener(
          "mouseenter",
          this.mouseenterTooltipHandler
        );
        tooltip.removeEventListener("focusin", this.mouseenterTooltipHandler);
      } else {
        tooltip.removeEventListener("click", this.mouseenterTooltipHandler);
        document.removeEventListener("click", this.outOfAreaHndler);
      }
    });
    this.tooltips = [];
    this.activeTooltip = null;
    this.prevTooltip = null;
    this.tooltipElt = null;
  }
}
