export class MenuOpener {
  constructor({
    menuTogglerClass,
    menuClass,
    subMenuClass,
    subMenuTogglerClass,
    closeMenuTogglerClass,
    headerClass = '.header',
    openedClass = 'opened',
    openedSubClass = 'opened',
    closeOnClick = false
  }) {
    this.menuTogglerClass = menuTogglerClass;
    this.headerClass = headerClass;
    this.menuClass = menuClass;
    this.subMenuClass = subMenuClass || 'li';
    this.openedClass = openedClass;
    this.openedSubClass = openedSubClass;
    this.subMenuTogglerClass = subMenuTogglerClass;
    this.closeMenuTogglerClass = closeMenuTogglerClass;
    this.menuToggler = null;
    this.menuCloser = null;
    this.header = null;
    this.menu = null;
    this.closeOnClick = closeOnClick;
    this.links = [];
    this.openMenuHandler = this.openMenuHandler.bind(this);
    this.closeMenuHandler = this.closeMenuHandler.bind(this);
    this.openSubMenuHandler = this.openSubMenuHandler.bind(this);
    this.outOfAreaHandler = this.outOfAreaHandler.bind(this)
    this.clickHandler = this.clickHandler.bind(this);
    this.init();
  }

  init() {
    this.menuToggler = document.querySelector(this.menuTogglerClass);
    this.menu = document.querySelector(this.menuClass);
    this.header = document.querySelector(this.headerClass);
    if (!this.menuToggler || !this.menu) {
      return;
    }

    this.closer = this.closeMenuTogglerClass
      ? document.querySelector(this.closeMenuTogglerClass)
      : this.menuToggler;

    this.setListener();
  }

  setListener() {
    this.menuToggler.addEventListener('click', this.openMenuHandler);
  }

  openMenuHandler(evt) {
    evt.preventDefault();
    this.openMenu();
  }

  closeMenuHandler(evt) {
    evt.preventDefault();
    this.closeMenu();
  }

  outOfAreaHandler(evt) {
    const currentArea = window.matchMedia('(min-width:1024px)').matches
      ? this.menu 
      : this.header;
    if (!currentArea.contains(evt.target) && !this.menuToggler.contains(evt.target)) {
      this.closeMenu();
    }
  }

  openSubMenuHandler(evt) {
    const target = evt.target.closest(this.subMenuTogglerClass);
    if (!target) return;
    this.openSubMenu(target);
  }

  openSubMenu(target) {
    const subItem = target.closest(this.subMenuClass);
    if (!subItem) return;

    if (!subItem.classList.contains(this.openedSubClass)) {
      if (subItem.classList.contains('top-menu__item')) this.closeAllSubs(this.menu);
      subItem.classList.add(this.openedSubClass);
    } else {
      subItem.classList.remove(this.openedSubClass);
      this.closeAllSubs(subItem);
    }

  }

  closeAllSubs(subItem) {
    const openedSubs = subItem.querySelectorAll(`.${this.openedSubClass}`);
    if (openedSubs.length) {
      openedSubs.forEach(item => item.classList.remove(this.openedSubClass));
    }
  }

  clickHandler(evt) {
    this.closeMenu();
  }

  closeMenu() {
    this.closer.removeEventListener('click', this.closeMenuHandler)
    this.menu.removeEventListener('click', this.openSubMenuHandler);
    document.removeEventListener('click', this.outOfAreaHandler)
    this.menu.classList.remove(this.openedClass);
    this.menuToggler.classList.remove(this.openedClass);
    if (this.header) this.header.classList.remove(this.openedClass);
    if (this.closeOnClick) {
      this.links.forEach((item) =>removeEventListener('click', this.clickHandler));
      this.links = [];
    }
    this.setListener();
  }

  openMenu() {
    this.menuToggler.removeEventListener('click', this.openMenuHandler);
    this.menu.classList.add(this.openedClass);
    this.menuToggler.classList.add(this.openedClass);
    if (this.header) this.header.classList.add(this.openedClass);
    if (this.closeOnClick) {
      this.links = this.menu.querySelectorAll('a');
      this.links.forEach((item) => item.addEventListener('click', this.clickHandler));
    }
    this.closer.addEventListener('click', this.closeMenuHandler)
    this.menu.addEventListener('click', this.openSubMenuHandler)
    document.addEventListener('click', this.outOfAreaHandler)
  }
}