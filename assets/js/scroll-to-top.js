(() => {
  const button = document.querySelector('[data-action="scroll-to-top"]');

  button.addEventListener('click', () => {
    window.scrollTo({
      top: 0,
      left: 0,
      behavior: 'smooth',
    });
  });
})();
