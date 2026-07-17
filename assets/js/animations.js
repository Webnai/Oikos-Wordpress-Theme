(function () {
  const animatedElements = document.querySelectorAll(
    '.oikos-animate, .oikos-section, .oikos-image-reveal, [data-animate]'
  );
  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  if (prefersReducedMotion) {
    animatedElements.forEach((element) => {
      element.classList.add('is-visible');
      element.classList.remove('is-exiting');
    });

    return;
  }

  if (!animatedElements.length) {
    return;
  }

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        const target = entry.target;

        if (entry.isIntersecting) {
          target.classList.add('is-visible');
          target.classList.remove('is-exiting');
          return;
        }

        if (target.classList.contains('is-visible')) {
          target.classList.add('is-exiting');
          window.setTimeout(() => {
            target.classList.remove('is-visible');
          }, 220);
        }
      });
    },
    {
      threshold: 0.2,
      rootMargin: '0px 0px -8% 0px'
    }
  );

  animatedElements.forEach((element) => {
    if (element.dataset.animateDelay) {
      element.style.transitionDelay = element.dataset.animateDelay;
    }

    if (element.dataset.animateType) {
      element.classList.add('animate-' + element.dataset.animateType);
    }

    observer.observe(element);
  });
})();
