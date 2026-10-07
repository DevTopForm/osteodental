export const addAnimations = (container) => {
  const allNames = container.querySelectorAll('.anim');

  const animationEndHandler = (evt) => {
    evt.target.classList.add('animated');
  };

  const toggleAnimations = (item) => {
    const anim = item.dataset.animation;
    let delay = item.dataset.delay;
    if (anim) {
      item.classList.add(anim);
      if (delay) item.style.animationDelay = `${delay}s`;
    }
    item.addEventListener('animationend', animationEndHandler);
  }

  const startAnimations = () => {
    if (allNames.length) {
      allNames.forEach((item) => {
        toggleAnimations(item)
      })
    } else {
      toggleAnimations(container)
    }

  };

  const intersectionCallback = (entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        startAnimations();
        observer.unobserve(entry.target);
      }
    });
  };

  const observer = new IntersectionObserver(intersectionCallback);
  observer.observe(container, { threshold: 0.5, trackVisibility: true });
}


export const simpleParalax = () => {
  const parallaxElts = document.querySelectorAll('[data-parallax]');
  if (!parallaxElts.length) return;
  window.addEventListener('scroll', () => {
    parallaxElts.forEach(el => {
      const rect = el.getBoundingClientRect();
      const inView = rect.top < window.innerHeight && rect.bottom > 0;

      if (inView) {
        const speed = el.dataset.parallax || 0.3;
        const offset = (window.innerHeight / 2 - rect.top ) * speed;
        if (offset > 100) return;
        el.style.transform = `translate3d(0,${-offset}px, 0)`;
      }
    });
  });
  

}