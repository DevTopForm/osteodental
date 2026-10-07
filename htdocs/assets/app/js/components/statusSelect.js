import { THROTTLE_TIME } from "./consts.js";
import { domElt } from "./dom.js";
import { MultiSelectBlockHandler } from "./js-multiselect-block.js";
import { throttle } from "./throttle.js";

export class NewSelector {
  constructor({ envoker, name, className, onChangeHandler, activateElt, onCloseHandler, focus = true }) {
    this.envoker = domElt(envoker);
    this.activateElt = domElt(activateElt);
    this.listener = activateElt ? this.activateElt : this.envoker;
    this.name = name;
    this.className = className;
    this.onChangeHandler = onChangeHandler;
    this.onCloseHandler = onCloseHandler;
    this.customSelect = null;
    this.selesctedBlock = null;
    this.selectedInstance = null;
    this.focus = focus;
    this.clickHandler = this.clickHandler.bind(this);
    this.keydownHandler = this.keydownHandler.bind(this);
    this.outOfAreaHandler = this.outOfAreaHandler.bind(this);
    this.onRemoveTag = this.onRemoveTag.bind(this);
    this.start();
    // this.init();
  }

  start() {
    this.selesctedBlock = document.querySelector('.js-selected');
    const selectedOptions = [...this.envoker.findAll('option')]
      .filter((item) => item.selected)
      .map((item) => ({
        id: item.value,
        name: item.innerText,
      }));

    this.multiSelectBlock = new MultiSelectBlockHandler({
      container: this.selesctedBlock,
      list: selectedOptions,
      onRemove: this.onRemoveTag,
      inputName: "metro-input"
    });

    this.multiSelectBlock.init();
  }

  onRemoveTag(option){
    let id  = option.id || option.option.id;
    const selectedOption = this.envoker.$el.querySelector(`[value=${id}]`);
    console.log(this.envoker, option)
    if (selectedOption) selectedOption.selected = false;
  }

  init() {
    this.customSelect = new StatusSelect({
      envoker: this.envoker.$el,
      name: this.name,
      className: this.className,
      focus: this.focus,
      create: true,
      onChangeHandler: (option) => {
        if (option.selected) {
          this.multiSelectBlock.createItem(option)
        } else {
          
          let elt = this.multiSelectBlock.createdElts.find((opt) => opt.option.id === option.id);
          this.multiSelectBlock.removeItemHandler(elt)
          elt.destroy();
        }
        if (this.onChangeHandler) this.onChangeHandler(option);
        this.close();
      },
    });
    document.addEventListener("click", this.outOfAreaHandler);
  }

  setListeners() {
    this.listener.on("click", this.clickHandler);
    this.listener.on("keydown", this.keydownHandler);
  }

  clickHandler(evt) {
    if (!evt.target.closest('.fast-item')) {
      evt.preventDefault();
      this.open();
    }
  }

  keydownHandler(evt) {
    if (evt.key === "Enter") {
      this.open();
    }
    if (evt.key === "ArrowUp" || evt.key === "ArrowDown") {
      evt.preventDefault();
      this.customSelect = new StatusSelect({
        envoker: this.envoker.$el,
        name: this.name,
        focus: this.focus,
        className: this.className,
        create: false,
      });
      this.customSelect.moveUpDown(evt.key);
    }
  }

  open() {
    this.listener.off("click", this.clickHandler);
    this.listener.off("keydown", this.keydownHandler);
    this.init();
  }

  outOfAreaHandler(evt) {
    if (
      this.listener.$el.contains(evt.target) ||
      (this.customSelect && this.customSelect.statusBlock.$el.contains(evt.target))
    )
      return;
    if (this.customSelect) {
      this.customSelect.close();
    }

    this.close();
  }

  createFakeOption(option) {
    this.customSelect.createElt(option, this.customSelect.statusBlock)
  }

  close() {
    document.removeEventListener("click", this.outOfAreaHandler);
    if (this.listener.$el) {
      this.listener.on("click", this.clickHandler);
      this.listener.on("keydown", this.keydownHandler);
    }
    if (this.onCloseHandler) this.onCloseHandler()
  }

  destroy() {
    if (this.customSelect) {
      this.customSelect.close();
      this.customSelect = null;
    }
    this.listener.off("click", this.clickHandler);
    this.listener.off("keydown", this.keydownHandler);
  }
}

export class StatusSelect {
  constructor({ envoker, name, className, onChangeHandler, onOpenHandler, create = false, focus = true }) {
    this.envoker = domElt(envoker);
    this.name = name;
    this.className = className;
    this.select = null;
    this.isMultiple = false;
    this.options = null;
    this.statusBlock = null;
    this.fakeElt = null;
    this.optionsElts = [];
    this.eltHeight = 24;
    this.optionsLength = 6;
    this.activeIndex = 0;
    this.width = 150;
    this.create = create;
    this.focus = focus;
    this.onChangeHandler = onChangeHandler;
    this.onOpenHandler = onOpenHandler;
    this.keyHandler = this.keyHandler.bind(this);
    this.changeOptionHandler = this.changeOptionHandler.bind(this);
    this.optimizeMoveSelect = this.optimizeMoveSelect.bind(this);
    this.getStartingPosition = this.getStartingPosition.bind(this);
    this.init();
  }

  init() {
    this.select = this.envoker.find("select");
    this.isMultiple = Boolean(this.select.attr('multiple'));
    this.fakeElt = this.envoker.find(`.${this.className}__fake`);
    this.options = this.select.findAll("option");
    const optionsArray = [...this.options].map((option, id) => {
      if (option.selected) {
        this.activeIndex = id;
      }
      return {
        value: option.value,
        selected: option.selected,
        text: option.innerText,
      };
    });
    if (this.create) {
      this.createElement(optionsArray);
      if (this.onOpenHandler) this.onOpenHandler;
    }
    if (!this.create) this.moveUpDown();
  }

  createElement(arr) {
    if (this.statusBlock) this.statusBlock.destroy();
    this.createBlock(arr);
    this.getStartingPosition();
    if (this.activeIndex && this.focus) this.optionsElts[this.activeIndex].focus();
    this.statusBlock.on("keydown", this.keyHandler);
    this.optionsElts.forEach((opt) =>
      opt.on("change", this.changeOptionHandler)
    );
    document.addEventListener("scroll", this.optimizeMoveSelect, {
      passive: true,
    });
  }

  changeOptionHandler(evt) {
    if (evt.target.checked) {
      evt.target.removeAttribute('checked');
    }
    const target = evt.target.closest("label");
    const optionValue = target.querySelector("input").value;
    const targetText = target.querySelector("span").innerText;
    this.changeOption(optionValue, targetText);
    this.select.css().dispatchEvent(new Event('change'))
  }

  changeOption(optionValue, targetText) {

    // if (this.fakeElt.$el) this.fakeElt.find(`span`).text(targetText);
    const selectedOption = [...this.options].find(
      (item) => item.value === optionValue
    );
    let selected = selectedOption.selected ? false : true;
    selectedOption.selected = selected;
    if (this.onChangeHandler) this.onChangeHandler({ name: targetText, id: optionValue, selected: selected });
    if (this.create) this.close();
  }

  keyHandler(evt) {
    if (evt.key === "ArrowUp" || evt.key === "ArrowDown") {
      evt.preventDefault();
      this.keyUpDown(evt.key);
      this.optionsElts[this.activeIndex].focus();
    }
    if (evt.key === "Enter" || evt.key === "Tab") {
      const optionValue = this.options[this.activeIndex].value;
      const targetText = this.options[this.activeIndex].innerText;
      this.changeOption(optionValue, targetText);
    }
  }

  moveUpDown(key) {
    this.keyUpDown(key);
    const optionValue = this.options[this.activeIndex].value;
    const targetText = this.options[this.activeIndex].innerText;
    this.changeOption(optionValue, targetText);
  }

  keyUpDown(key) {
    if (key === "ArrowUp") {
      this.activeIndex =
        this.activeIndex === 0 ? this.options.length - 1 : this.activeIndex - 1;
    } else {
      this.activeIndex =
        this.activeIndex === this.options.length - 1 ? 0 : this.activeIndex + 1;
    }
  }

  close() {
    document.removeEventListener("scroll", this.optimizeMoveSelect, {
      passive: true,
    });

    if (this.optionsElts.length) {
      this.optionsElts.forEach((opt) => {
        if (opt.$el) {
          opt.off("change", this.changeOptionHandler);
          opt.destroy();
        }
      });
    }

    if (this.statusBlock.$el) {
      this.statusBlock.off("keyup", this.keyHandler);
      this.statusBlock.destroy();
    }
    if (this.focus) this.envoker.focus();
  }

  createLiElement(elt) {
    const option = domElt.create("label", `${this.className}__label`);
    const spanElt = domElt.create("span");
    spanElt.text(elt.text);
    const input = domElt.create("input", `${this.className}__radio`);
    input.$el.name = this.name;
    input.attr("value", elt.value || "all");
    if (elt.selected) {
      input.attr("checked", true);
    }
    input.$el.type = this.isMultiple ? 'checkbox' : 'radio';
    option.append(input);
    option.append(spanElt);
    return option;
  }

  optimizeMoveSelect() {
    return throttle(this.getStartingPosition, THROTTLE_TIME)();
  }

  getStartingPosition() {
    const positions = this.envoker.getCoords();
    const height = Math.floor(this.eltHeight * this.optionsLength);
    const top = () => {
      return height < window.innerHeight - positions.bottom
        ? positions.top + positions.height
        : positions.top - height - 10;
    };
    const el = this.statusBlock.find(
      `.${this.className}__label`
    ).$el
    this.eltHeight = el ? el.offsetHeight : 24;
    this.statusBlock.attr(
      "style",
      `top:${Math.floor(top())}px;
      left:${Math.floor(positions.right) - 300}px;
      height:${height}px;
      position: fixed;
      min-width: ${this.width}px;`
    );
  }

  createBlock(array) {
    let block;
    if (array.length) {
      block = document.createDocumentFragment();
      array.forEach((it) => {
        this.createElt(it, block)
      });
    }
    this.statusBlock = domElt.create("div", `${this.className}__fields`);
    if (block) this.statusBlock.append(block);
    document.body.append(this.statusBlock.$el);
  }

  createElt(it, container) {
    const elt = this.createLiElement(it);
    container.append(elt.$el);
    this.optionsElts.push(elt);
  }

  removeChecked(option) {
    [...this.options].find(
      (item) => item.value === option.id
    ).selected = false;
  }
}
