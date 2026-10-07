import { domElt } from "./dom.js";

export class MultiSelectBlockHandler {
  constructor({container, list, onRemove, inputName}) {
    this.container = domElt(container);
    this.inputName = inputName;
    this.list = list || [];
    this.createdElts = [];
    this.onRemove = onRemove;
    this.removeItemHandler = this.removeItemHandler.bind(this);
  }

  init() {
    if (this.list.length) {
      this.createItems();
    }
  }

  createItems() {
    this.createdElts = this.list.map((item) => this.createItem(item, this.inputName));
  }

  createItem(option, inputName = '') {
    return new OptionItem({
      option,
      onRemoveItem: this.removeItemHandler,
      container: this.container,
      inputName: inputName
    });
  }

  removeItemHandler(elt) {
    console.log(elt,1, this.createdElts)
    if (this.createdElts.length) this.createdElts = this.createdElts.filter((item) => item.option.id !== elt.id);
    if (this.list.length) this.list = this.list.filter((item) => item.id !== elt.id);
    this.onRemove(elt)
  }

  destroy() {
    this.createdElts.forEach((item) => item.destroy());
    this.createdElts = [];
    this.container.destroy();
  }
}

export class OptionItem {
  constructor({option, onRemoveItem, container, inputName}) {
    this.option = option;
    this.tag = null;
    this.container = container;
    this.onRemoveItem = onRemoveItem;
    this.inputName = inputName;
    this.removeItemHandler = this.removeItemHandler.bind(this);
    this.createItem(this.option)
  }

  createItem(option) {
    this.tag = domElt.create('label', 'fast-item');
    const span = domElt.create('span');
    const input = domElt.create('input');
    input.attr('value', option.id);
    input.attr('name', this.inputName + '[]');
    input.attr('type', 'checkbox');
    span.text(option.name);
    this.tag.append(input);
    this.tag.append(span);
    this.container.append(this.tag);
    this.tag.on('change', this.removeItemHandler);
    input.attr('checked', true);
  }

  removeItemHandler(evt) {
    evt.preventDefault();
    this.onRemoveItem(this.option);
    this.destroy();
  }

  destroy() {
    this.tag.off('change', this.removeItemHandler);
    this.tag.destroy();
  }
}