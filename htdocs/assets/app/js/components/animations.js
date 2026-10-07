const startAnimations = (item) => {
  const animType = item.dataset.animType;
  const animStart = item.dataset.animStart;
  const opacityStart = item.dataset.animOpacityStart ? item.dataset.animOpacityStart : 0;
  let additionalAnimStyle = '';
  if (animType !== 'opacity') {
    additionalAnimStyle = `opacity: ${opacityStart};`;
  }
  const currentStyles = item.getAttribute('style');
  console.log(currentStyles)
  item.setAttribute('style', `${currentStyles}${animType}: ${animStart};${additionalAnimStyle}`);
};


const continueAnimations = (item) => {
  const animType = item.dataset.animType;
  const animEnd = item.dataset.animEnd;
  const animDuration = item.dataset.animDuration || '0.3s';
  const animDelay = item.dataset.animDelay || 0;

  let additionalAnimStyle = '';
  let additionalTransitionStyle = '';
  if (animType !== 'opacity') {
    additionalAnimStyle = `;opacity: 1`;
    additionalTransitionStyle = `,opacity ${animDuration} linear ${animDelay}`;
  }
  const currentStyles = item.getAttribute('style');
  item.setAttribute('style', `${currentStyles};${animType}: ${animEnd}${additionalAnimStyle}; transition: ${animType} ${animDuration} linear ${animDelay}${additionalTransitionStyle}`);
};

const animated = document.querySelectorAll('.anim');
if (animated.length) {
  animated.forEach((item) => {
    startAnimations(item);
  });
}

export const firstScreenAnimation = () => {
  commonAnimations('.anim')
};

const commonAnimations = () => {
  const intersectionCallback = (entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        continueAnimations(entry.target);
        // observer.unobserve(item);
      }
    },
      {
        threshold: 0.95, // Trigger when 50% of the slider is visible
      });
  };

  const observer = new IntersectionObserver(intersectionCallback);
  animated.forEach((item) => {
    observer.observe(item);
  });
};

export const roundOnScrollAnimation = (containerClass, elementClass) => {
  const containers = document.querySelectorAll(containerClass)
  if (!containers.length) return;

  const animationStart = (container, round) => {
    if (!container || !round) return;
    window.addEventListener(
      "scroll",
      () => {
        document.body.style.setProperty(
          "--scroll",
          window.pageYOffset / (document.body.offsetHeight - window.innerHeight)
        );
      },
      false
    );
  };

  const intersectionCallback = (entries) => {
    entries.forEach((entry) => {
      const round = entry.target.querySelector(elementClass)
      if (entry.isIntersecting) {
        animationStart(entry.target, round);
        // observer.unobserve(entry.target);
      }
    });
  };

  const observer = new IntersectionObserver(intersectionCallback);
  containers.forEach((item) => {
    observer.observe(item);
  });

}