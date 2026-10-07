import { CreateNewElement } from "./createNewElt.js";

export class FilesUploader {
  constructor({ container, uploadRowClass, fileClass, type }) {
    this.container = container;
    if (!this.container) return;
    this.uploadRowClass = uploadRowClass || 'form__files-row';
    this.fileClass = fileClass || 'file-item';
    this.fileUploader = null;
    this.filesContainer = null;
    this.files = [];
    this.file = null;
    this.icoContainer = null;
    this.reader = null;
    this.type = type;
    this.uploadFileHandler = this.uploadFileHandler.bind(this);
    this.removeFileHandler = this.removeFileHandler.bind(this)
    this.loadStartHandler = this.loadStartHandler.bind(this);
    this.onloadHandler = this.onloadHandler.bind(this);
    this.init();
  }

  init() {
    this.fileUploader = this.container.querySelector('[type="file"]');
    if (!this.fileUploader) return;
    this.setListeners();
  }

  setListeners() {
    this.fileUploader.addEventListener('change', this.uploadFileHandler);
  }

  uploadFileHandler(evt) {
    this.files = evt.target.files;
    if (this.type === 'ico') {
      this.file = this.files[0];
      this.uploadIco()
    } else {
      this.createFilesRow(this.files);
    }
  }

  createFileItem(file, id) {
    return `<span class="file-item" data-id="${id}">${file.name}</span>`
  }

  createFilesRow(files) {
    if (files.length > 0) {
      if (!this.filesContainer) {
        this.createFilesContainer();
      }
      const filesRow = [...files].map((item, id) => this.createFileItem(item, id)).join('');
      this.filesContainer.insertText(filesRow);
    } else {
      this.removeFilesContainer();
    }
  }

  uploadIco() {
    this.reader = new FileReader();
    this.reader.addEventListener("loadstart", this.loadStartHandler);
    this.reader.readAsDataURL(this.file);
  }

  loadStartHandler(evt) {
    this.reader.removeEventListener("loadstart", this.loadStartHandler);
    this.reader.addEventListener("loadend", this.onloadHandler);
  }

  onloadHandler(evt) {
    this.reader.removeEventListener("loadend", this.onloadHandler);
    this.icoContainer= this.container.querySelector('.form__ico');
    let img = this.icoContainer.querySelector('img');

    if (!img) {
      img = new CreateNewElement(this.icoContainer, 'img', 'form__ico-img').createElmt();
    }
    img.src = evt.srcElement.result;
  }

  createFilesContainer() {
    this.filesContainer = new CreateNewElement(this.container, 'div', this.uploadRowClass);
    this.filesContainer.createElmt();
    this.filesContainer.elmnt.addEventListener('click', this.removeFileHandler);
  }

  removeFileHandler(evt) {
    const target = evt.target.closest(`.${this.fileClass}`);
    if (target) {
      evt.preventDefault();
      const currFile = target.dataset.id;
      this.files = [...this.files].filter((item, id) => id !== Number(currFile))
      this.createFilesRow(this.files);
    }
  }

  removeFilesContainer() {
    if (this.filesContainer) {
      this.filesContainer.elmnt.removeEventListener('click', this.removeFileHandler);
      this.filesContainer.destroyElmt();
      this.filesContainer = null;
    }
  }

  destroy() {
    this.removeFilesContainer();
    this.fileUploader.removeEventListener('change', this.uploadFileHandler);
    this.fileUploader = null;
    this.filesContainer = null;
    this.files = [];
  }
}