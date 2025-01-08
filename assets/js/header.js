(() => {
  let previousPosition = 0;
  let scrollDownAmount = 0;
  let scrollUpAmount = 0;

  const scrollChange = 500;
  const header = document.querySelector('.site-header');

  function positionCheck() {
    if (window.scrollY > 10) {
      header.classList.add('site-header--small');
    } else {
      header.classList.remove('site-header--small');
      header.classList.remove('site-header--hidden');
    }

    if (window.scrollY > previousPosition) {
      scrollUpAmount = 0;
      scrollDownAmount = scrollDownAmount + (window.scrollY - previousPosition);

      if (scrollDownAmount > scrollChange) {
        header.classList.add('site-header--hidden');
      }
    } else {
      scrollDownAmount = 0;
      scrollUpAmount = scrollUpAmount + (previousPosition - window.scrollY);

      if (scrollUpAmount > scrollChange) {
        header.classList.remove('site-header--hidden');
      }
    }

    previousPosition = window.scrollY;
  }

  window.addEventListener('scroll', () => {
    positionCheck();
  });
})();
