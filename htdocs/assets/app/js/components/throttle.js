// Объяснение работы https://doka.guide/js/throttle/

export function throttle(callback, timeout) {
  let timer = null;

  return  function perform(...args) {
    if (timer) return;

    timer = setTimeout(() => {
      callback(...args);
      clearTimeout(timeout)
      timer = null;
    }, timeout);
  }
};