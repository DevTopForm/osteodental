export const searchFormHandler = (container) => {
  if (!container) return;
  const nameContainer = container.querySelector('.js-search-form-name');
  const selectOptions = container.querySelectorAll('.select-block__radio');
  let activeElt = null;
  const btn = container.querySelector('.select-block__inside');
  const form = container.querySelector('.search-form')

  const changeHandler = (evt) => {
    const value = evt.target.value;
    activeElt = evt.target.closest('label');
    if (nameContainer) nameContainer.textContent = activeElt.textContent.toLowerCase();
    btn.querySelector('.select-block__content').replaceWith(activeElt.querySelector('.select-block__content').cloneNode(true));
    form.action = `${form.action}${value}&q=`
  }

  selectOptions.forEach((item) => item.addEventListener('change', changeHandler));
}