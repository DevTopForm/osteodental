import { THROTTLE_TIME } from "./consts.js";
import { domElt } from "./dom.js";
import { MultiSelectBlockHandler, OptionItem } from "./js-multiselect-block.js";
import { ajaxSend } from "./sendData.js";
import { NewSelector } from "./statusSelect.js";
import { throttle } from "./throttle.js";


const url = '/adm/ajax/multiselect';


export class multiSelectSearch {
  constructor({ container }) {
    this.container = domElt(container);
    this.inputName = this.container.$el.dataset.name;
    this.input = null;
    this.dataTableName = null;
    this.optionsContainer = null;
    this.select = null;
    this.options = [];
    this.getListHandler = this.getListHandler.bind(this);
    this.appendElts = this.appendElts.bind(this);
    this.createSelect = this.createSelect.bind(this);
    this.onRemoveTag = this.onRemoveTag.bind(this);
    this.selectedOptions = [];
    this.addsContainer = null;
    this.multiSelectBlock = null;
    this.init();
  }


  init() {
    if (!this.container) return;
    this.input = this.container.find('input');
    if (!this.input) return;
    this.input.on('keyup', this.getListHandler);
    this.input.on('focusin', this.getListHandler);

    this.datasetObjects = Object.assign({}, this.container.data);
    this.addsContainer = this.container.find('.fast-search__block');
    this.getSelectedItems();

    if (this.multiSelectBlock) {
      this.multiSelectBlock.destroy();
      this.multiSelectBlock = null;
    }
    this.multiSelectBlock = new MultiSelectBlockHandler({
      container: this.addsContainer,
      list: this.selectedOptions,
      onRemove: this.onRemoveTag,
      inputName: this.inputName
    });
    
  }

  getListHandler(evt) {
    throttle(this.sendRequest(evt.target.value), THROTTLE_TIME);
  }

  sendRequest(text) {
    const urlText = Object.entries(this.datasetObjects)
      .map(([key, value]) => `${key}=${value}`)
      .join('&');

    const currentUrl = `${url}?${urlText}&title=${text}`;

    ajaxSend({
      url: currentUrl,
      successHandler: this.createSelect,
      failHandler: this.createSelect,
    })
  }

  destroyExistingSelect() {
    if (this.options.length) {
      this.options.forEach((item) => item.destroy());
      this.options = [];
    }
    if (this.select) {
      this.select.destroy();
      this.select = null;
    }
    this.optionsContainer.destroy();
  }

  async createSelect(result) {
    console.log(result);
    if (this.optionsContainer) this.destroyExistingSelect();
    if (!result.length) return;
    await this.appendElts(result);
    await this.initSelect();
  }

  getSelectedItems() {
    console.log(this.addsContainer)
    if (!this.addsContainer.$el) return;
    const selectedArr = this.addsContainer.findAll('.fast-item');
    console.log(selectedArr)
    if (selectedArr.length) {
      this.selectedOptions = [...selectedArr].map((item) => {
        const option = {
          name: item.querySelector('span').innerText,
          id: Number(item.querySelector('input').value),
        }
        item.remove();
        return option
      });
    }
    if (!this.multiSelectBlock) {
      this.multiSelectBlock = new MultiSelectBlockHandler({
        container: this.addsContainer,
        list: this.selectedOptions,
        onRemove: this.onRemoveTag,
        inputName: this.inputName
      }).createItems();
    } else {
      this.multiSelectBlock.createItems();
    }
  }

  async appendElts(result) {
    const fragment = new DocumentFragment();
    result.forEach((item) => {
      const isSelected = this.selectedOptions?.find((option) => {
        return Number(option.id) === Number(item.id)
      });
      const option = domElt.create('option', 'status-select__option');
      option.attr('value', item.id);
      option.attr('selected', isSelected);
      option.text(item.title);
      fragment.append(option.$el);
      this.options.push(option);
    });
    this.optionsContainer = domElt.create('select', 'status-select__select');
    this.optionsContainer.addClass('js-name')
    this.optionsContainer.attr('name', this.optionsContainer.$el.dataset.name)
    this.optionsContainer.attr('multiple', 'true')
    this.optionsContainer.css({ 'display': 'none' })
    this.optionsContainer.$el.append(fragment);
    this.container.append(this.optionsContainer);
  }

  async initSelect() {
    this.select = new NewSelector({
      envoker: this.container.$el,
      name: this.optionsContainer.$el.dataset.name,
      className: "status-select",
      activateElt: this.container.find('.label__wrapper').$el,
      focus: false,
      onChangeHandler: (option) => {
        if (this.addsContainer.$el) {
          this.addToSelectedBlock(option);
        }
      },
    });
    this.select.init();
  }

  onRemoveTag(elt) {
    let activeOption
    if (this.options.length) {
      activeOption = this.options.find((option) => Number(option.$el.value) === Number(elt.id));
    }
    if (activeOption) activeOption.attr('selected');
    this.selectedOptions = this.selectedOptions.filter((option) => Number(option.id) === Number(elt.id));
  }

  addToSelectedBlock(option) {
    this.selectedOptions.push(option);
    if (!this.multiSelectBlock) {
      this.multiSelectBlock = new MultiSelectBlockHandler({
        container: this.addsContainer,
        list: this.selectedOptions,
        onRemove: this.onRemoveTag,
        inputName: this.inputName
      }).init();
    } else {
      this.multiSelectBlock.createItem(option, this.inputName)
    }
  }
} 