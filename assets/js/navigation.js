(() => {
  const header = document.querySelector('.site-header');
  const button = document.querySelector('[data-action="navigation-toggle"]');
  const menu = document.querySelector('.navigation-menu');
  const mq = window.matchMedia('(max-width: 63.99em)');
  const dropdown = document.querySelectorAll('.menu-item-has-children > a');
  const blockedLinks = document.querySelectorAll('.prevent-default > a');

  if (!menu || typeof button === 'undefined') return;

  function close() {
    button.setAttribute('aria-expanded', false);
    header.classList.remove('site-header--open');
  }

  function widthChange(query) {
    button.setAttribute('aria-expanded', !query.matches);
    header.classList.remove('site-header--open');
  }

  button.addEventListener('click', () => {
    if (button.getAttribute('aria-expanded') === 'true') {
      header.classList.remove('site-header--open');
      button.setAttribute('aria-expanded', 'false');
    } else {
      header.classList.add('site-header--open');
      button.setAttribute('aria-expanded', 'true');
    }
  });

  document.querySelectorAll('.sub-menu').forEach(subMenu => {
    const prevSibling = subMenu.previousElementSibling;
    if (prevSibling && prevSibling.tagName.toLowerCase() === 'a') {
      const button = document.createElement('button');
      button.classList.add('dropdown-btn');
      button.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
      `;
      prevSibling.appendChild(button);
    }
  });

  dropdown.forEach((item) => {
    item.setAttribute('aria-expanded', 'false');

    item.addEventListener('keypress', function (e) {
      e.preventDefault();

      const _self = item;

      dropdown.forEach((item) => {
        if (_self === item) {
          item.setAttribute('aria-expanded', item.getAttribute('aria-expanded') === 'true' ? 'false' : 'true');
        } else {
          item.setAttribute('aria-expanded', 'false');
        }
      });
    }, false);

    item.addEventListener('click', (e) => {
      const _self = item;

      if (e.target.tagName === 'BUTTON') {
        e.preventDefault();
      }

      dropdown.forEach((item) => {
        if (_self === item) {
          item.setAttribute('aria-expanded', item.getAttribute('aria-expanded') === 'true' ? 'false' : 'true');
        } else {
          item.setAttribute('aria-expanded', 'false');
        }
      });
    });

    if (! mq.matches) {
      item.addEventListener('mouseenter', () => {
        item.setAttribute('aria-expanded', 'true');
      });

      item.addEventListener('mouseleave', (e) => {
        if (e.relatedTarget.parentNode !== item.parentNode) {
          item.setAttribute('aria-expanded', 'false');
        }
      });

      item.parentNode.querySelector('.sub-menu').addEventListener('mouseleave', (e) => {
        if (e.relatedTarget.parentNode !== item.parentNode) {
          item.setAttribute('aria-expanded', 'false');
        }
      });
    }
  });

  document.addEventListener('resize', () => {
    widthChange();
  });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
      close();

      dropdown.forEach((item) => {
        item.setAttribute('aria-expanded', 'false');
      });
    }
  });

  document.addEventListener('click', (e) => {
    if (!e.target.closest('.menu-item-has-children')) {
      dropdown.forEach((item) => {
        item.setAttribute('aria-expanded', 'false');
      });
    }
  });

  blockedLinks.forEach((item) => {
    item.addEventListener('click', (e) => {
      e.preventDefault();
    });
  });
})();
