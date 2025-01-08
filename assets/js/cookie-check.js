(() => {
  const consentCategories = base['cookie-consent-categories'];

  consentCategories.forEach(category => {
    if (category.id !== 'necessary') {
      if(Cookie.isset(`base-cookie-consent-${category.id}`)) {

        const styleElement = document.createElement('style');

        const cssRule = `
          .restriction[data-type="${category.id}"] .restriction__caption {
              display: none !important;
          }
        `;

        styleElement.appendChild(document.createTextNode(cssRule));
        document.head.appendChild(styleElement);

        const restrictionElements = document.querySelectorAll(`.restriction[data-type="${category.id}"]`);
        restrictionElements.forEach(restrictionElement => {
          const iframe = restrictionElement.querySelector('iframe');

          if (iframe && iframe.hasAttribute('data-src')) {
            iframe.setAttribute('src', iframe.getAttribute('data-src'));
          }
        });
      }
    }
  });

  document.documentElement.classList.add('consent-ready');
})();
