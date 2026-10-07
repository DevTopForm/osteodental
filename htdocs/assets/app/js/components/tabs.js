const KEYS = {
  end: 35,
  home: 36,
  left: 37,
  up: 38,
  right: 39,
  down: 40,
};

const DIRECTION = {
  37: -1,
  38: -1,
  39: 1,
  40: 1
};

export class Tabs {
  constructor({
    container,
    tabsClass = '[role="tab"]',
    panesClass = '[role="tabpanel"]',
    tablistClass = '[role="tablist"]',
    onChangeHandler,
  }) {
    this.container = container;
    this.tabsClass = tabsClass;
    this.tabs = this.container.querySelectorAll(tabsClass);
    this.panes = this.container.querySelectorAll(panesClass);
    this.tablist = this.container.querySelector(tablistClass);
    this.onChangeHandler = onChangeHandler;
    this.direction = DIRECTION;
    this.keys = KEYS;
    this.clickEventHandler = this.clickEventHandler.bind(this);
    this.keyupEventHandler = this.keyupEventHandler.bind(this);
    this.keydownEventHandler = this.keydownEventHandler.bind(this);
    this.activateTab = this.activateTab.bind(this);
    this.delay = 3000;
    this.init();
  }

  init() {
    if (!this.tabs.length || !this.panes.length || !this.tablist) return;
    this.activateTab(this.tabs[0], false);
    this.setListeners();
  }

  setListeners() {
    [...this.tabs].forEach((tab, index) => {
      tab.addEventListener('click', this.clickEventHandler);
      tab.addEventListener('keyup', this.keyupEventHandler);
      tab.addEventListener('keydown', this.keydownEventHandler);
      tab.index = index;
    });
  }

  clickEventHandler(evt) {
    evt.preventDefault();
    const tab = evt.target.closest(this.tabsClass);
    if (tab.tagName === 'LABEL') {
      const input = tab.querySelector('[type="radio"]');
      if (input) input.checked = true;
    }
    this.activateTab(tab, true);
  }

  keyupEventHandler(evt) {
    const key = evt.keyCode;
    if (key === this.keys.left || key === this.keys.right) {
      evt.preventDefault();
      this.determineOrientation(evt);
    }
  }

  keydownEventHandler(evt) {
    const key = evt.keyCode;
    switch (key) {
      case this.keys.end:
        evt.preventDefault();
        this.activateTab(this.tabs[this.tabs.length - 1]);
        break;
      case this.keys.home:
        evt.preventDefault();
        this.activateTab(this.tabs[0]);
        break;
      case this.keys.up:
      case this.keys.down:
        this.determineOrientation(evt);
        break;
    }
  }

  activateTab(tab, setFocus) {
    setFocus = setFocus || false;
    this.deactivateTabs();
    tab.setAttribute('aria-selected', 'true');
    const controls = tab.getAttribute('aria-controls');
    const activePanel = this.container.querySelector(`#${controls}`);
    activePanel.classList.remove('hidden');
    activePanel.setAttribute('aria-selected', 'true');
    if (this.onChangeHandler) this.onChangeHandler(tab, activePanel);
    if (setFocus) {
      tab.focus();
    }
  }

  deactivateTabs() {
    [...this.tabs].forEach((tab) => {
      tab.setAttribute('aria-selected', false);
      tab.removeEventListener('focus', this.focusEventHandler);
    });
    [...this.panes].forEach((pane) => {
      pane.classList.add('hidden');
      pane.setAttribute('aria-selected', 'false');
    });
  }

  determineOrientation(evt) {
    const key = evt.keyCode;
    const vertical = this.tablist.getAttribute('aria-orientation') == 'vertical';
    let proceed = false;
    if (vertical) {
      if (key === this.keys.up || key === this.keys.down) {
        evt.preventDefault();
        proceed = true;
      };
    }
    else {
      if (key === this.keys.left || key === this.keys.right) {
        proceed = true;
      };
    };
    if (proceed) {
      this.switchTabOnArrowPress(evt);
    }
  }

  switchTabOnArrowPress(evt) {
    const pressed = evt.keyCode;
    [...this.tabs].forEach((tab) => tab.addEventListener('focus', this.focusEventHandler));
    if (this.direction[pressed]) {
      const target = evt.target;
      if (target.index !== undefined) {
        if (this.tabs[target.index + this.direction[pressed]]) {
          this.tabs[target.index + this.direction[pressed]].focus();
        } else if (pressed === this.keys.left || pressed === this.keys.up) {
          this.focusLastTab();
        } else if (pressed === this.keys.right || pressed === this.keys.down) {
          this.focusFirstTab();
        }
      }
    }
  }

  focusLastTab() {
    this.tabs[this.tabs.length - 1].focus();
  }

  focusFirstTab() {
    this.tabs[0].focus();
  }

  focusEventHandler(evt) {
    const target = evt.target;
    setTimeout(this.checkTabFocus, this.delay, target);
  }

  checkTabFocus(target) {
    const focused = document.activeElement;
    if (target === focused) {
      this.activateTab(target, false);
    }
  }

  destroy() {

    [...this.tabs].forEach((tab, index) => {
      tab.removeEventListener('click', this.clickEventHandler);
      tab.removeEventListener('keyup', this.keyupEventHandler);
      tab.removeEventListener('keydown', this.keydownEventHandler);
    });
    this.tabs = [];
    this.panes = [];
    this.tablist = [];
  }
}
