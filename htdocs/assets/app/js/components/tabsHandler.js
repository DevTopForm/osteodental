import { Tabs } from "./tabs.js";

export const tabsHandler = (tabElement) => {
  const tabsSelectBtn = tabElement.querySelector('.js-tabs-select-btn');
  const tabsSelectWrapper = tabElement.querySelector('.js-tabs-select-wrapper');

  const outOfAreaHandler = (e) => {
    if (!tabsSelectWrapper.contains(e.target) && e.target !== tabsSelectBtn) {
      tabsSelectBtn.closest('div').classList.remove('active');
      document.removeEventListener('click', closeHandler);
    }
  }

  const closeElts = () => {
    tabsSelectBtn.closest('div').classList.remove('active');
    tabsSelectBtn.removeEventListener('click', closeHandler);
    document.removeEventListener('click', outOfAreaHandler);
    tabsSelectBtn.addEventListener('click', openHandler);
  }

  const closeHandler = (evt) => {
    evt.preventDefault();
    closeElts();
  }

  const openHandler = (evt) => {
    evt.preventDefault();
    tabsSelectBtn.closest('div').classList.add('active');
    tabsSelectBtn.removeEventListener('click', openHandler);
    tabsSelectBtn.addEventListener('click', closeHandler);
    document.addEventListener('click', outOfAreaHandler);
  }

  const onChangeHandler = (activeTab) => {
    tabsSelectBtn.querySelector('span').textContent = activeTab.querySelector('.project-tabs__btn-inside').textContent;
    closeElts();
  }

  new Tabs({
    container: tabElement,
    onChangeHandler: onChangeHandler
  })

  tabsSelectBtn.addEventListener('click', openHandler);
};