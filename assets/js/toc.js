(() => {
  const items = document.querySelectorAll('.toc a');
  const scrollItems = [];

  if (!items.length) {
    return;
  }

  items.forEach((item) => {
    const targetId = item.getAttribute('href').substring(1);
    const targetElement = document.getElementById(targetId);

    if (targetElement) {
      scrollItems.push({
        offset: targetElement.getBoundingClientRect().top + document.documentElement.scrollTop - 70,
        element: item
      });
    }
  });

  function updateActiveItems () {
    const scrollPosition = window.scrollY;

    const activeItem = scrollItems.reduce((closestItem, currentItem) => {
      if (scrollPosition >= currentItem.offset) {
        return currentItem;
      }
      return closestItem;
    }, scrollItems[0]);

    items.forEach((item) => {
      item.classList.remove('active');
    });

    if (activeItem) {
      activeItem.element.classList.add('active');
    }
  }

  window.addEventListener('scroll', updateActiveItems);
  updateActiveItems();
})();
