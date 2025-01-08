(() => {
  document.querySelectorAll('.accordion-card').forEach((accordion) => {
    const heading = accordion.querySelector('.accordion-card__title');
    const isClose = accordion.getAttribute('data-type') === 'open' ? true : false;
    const button = document.createElement('button');
    const icon = document.createElement('span');

    button.classList.add('accordion-card__toggle');
    button.setAttribute('aria-expanded', 'false');

    icon.classList.add('accordion-card__icon');
    icon.innerHTML = `
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <line class="vertical-line" x1="12" y1="5" x2="12" y2="19"></line>
        <line class="horizontal-line" x1="5" y1="12" x2="19" y2="12"></line>
      </svg>
    `;

    button.innerHTML = `${heading.textContent} ${icon.outerHTML}`;
    heading.innerHTML = '';
    heading.appendChild(button);

    button.addEventListener('click', () => {
      if (! isClose) {
        accordion.closest('.accordion-list').querySelectorAll('.accordion-card').forEach((otherAccordion) => {
          const otherButton = otherAccordion.querySelector('button');
          const otherContent = otherAccordion.querySelector('.accordion-card__content');

          if (otherButton !== button) {
            otherButton.setAttribute('aria-expanded', 'false');
            otherContent.setAttribute('aria-hidden', 'true');
          }
        });
      }

      const expanded = button.getAttribute('aria-expanded') === 'true';

      button.setAttribute('aria-expanded', !expanded);
      heading.nextElementSibling.setAttribute('aria-hidden', expanded);
    });
  });
})();
