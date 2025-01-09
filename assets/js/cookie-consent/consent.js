(() => {
  const accessBtns = document.querySelectorAll('.js-sub-cookie-access');

  const consentCategories = base['cookie-consent-categories'];
  const consentKeys = consentCategories.map(category => `base-cookie-consent-${category.id}`);

  const areCookiesNotSet = consentKeys.every(key => !Cookie.isset(key)) && !Cookie.isset('base-cookie-consent-denied');

  if (areCookiesNotSet) {
    const cookieNotification = `<div class="js-cookie-consent cookie-consent" tabindex="-1">
      <div class="cookie-consent__caption">${base['cookie-consent-description']}</div>
      <div class="cookie-consent__options">
        ${consentCategories.map(category => `
          <div class="cookie-consent__option">
            <label class="form-switch form-switch--block">
              <span class="form-label form-switch__label">${category.title}</span>
              <input class="form-switch__control" type="checkbox" id="${category.id}" name="${category.id}" class="js-category-option" ${category.id === 'necessary' ? 'checked disabled' : ''}>
            </label>
            <p>${category.description}</p>
          </div>
        `).join('')}
      </div>
      <div class="cookie-consent__btns">
        <button class="js-close-cookie-consent btn btn--outline-primary">
          ${base['cookie-consent-deny-caption']}
        </button>
        <button class="js-customize-cookies btn btn--outline-primary">
          ${base['cookie-consent-customize-caption']}
        </button>
        <button class="js-allow-selection btn btn--outline-primary" hidden>
          ${base['cookie-consent-selected-caption']}
        </button>
        <button class="js-accept-all-cookies btn btn--primary">
          ${base['cookie-consent-accept-caption']}
        </button>
      </div>
    </div>`;

    if (base['cookie-consent-description']) {
      document.body.insertAdjacentHTML('afterbegin', cookieNotification);
      document.querySelector('.js-cookie-consent').focus();
    }
  }

  document.addEventListener('click', (e) => {
    const target = e.target;

    if (target && target.classList.contains('js-accept-all-cookies')) {
      document.querySelector('.js-cookie-consent').classList.add('animate--out');

      consentCategories.forEach(category => {
        if (category.id !== 'necessary') {
          Cookie.set(`base-cookie-consent-${category.id}`, 'accepted', 365);
        }
      });

      setTimeout(() => window.location.reload(), 300);
    }

    if (target && target.classList.contains('js-customize-cookies')) {
      document.querySelector('.js-customize-cookies').setAttribute('hidden', true);
      document.querySelector('.js-allow-selection').removeAttribute('hidden');
      document.querySelector('.cookie-consent__options').classList.add('cookie-consent__options--visible');
    }

    if (target && target.classList.contains('js-allow-selection')) {
      document.querySelector('.js-cookie-consent').classList.add('animate--out');

      let hasChecked = false;
      const inputs = document.querySelectorAll('.cookie-consent__options input:not([disabled])');

      inputs.forEach((input) => {
        if (input.checked) {
          hasChecked = true;
          Cookie.set(`base-cookie-consent-${input.id}`, 'accepted', 365);
        }
      });

      if (!hasChecked) {
        Cookie.set('base-cookie-consent-denied', 'true');
      }

      setTimeout(() => window.location.reload(), 300);
    }

    if (target && target.classList.contains('js-close-cookie-consent')) {
      document.querySelector('.js-cookie-consent').classList.add('animate--out');
      Cookie.set('base-cookie-consent-denied', 'true');
    }
  });

  accessBtns.forEach((btn) => {
    const dataType = btn.getAttribute('data-type');
    const cookieKey = `base-cookie-consent-${dataType}`;

    if (Cookie.isset(cookieKey) && Cookie.get(cookieKey) === 'accepted') {
      btn.innerHTML = `${btn.getAttribute('data-on-text')} ${btn.innerHTML}`;
    } else {
      btn.innerHTML = `${btn.getAttribute('data-off-text')} ${btn.innerHTML}`;
    }

    btn.addEventListener('click', () => {
      if (Cookie.isset(cookieKey) && Cookie.get(cookieKey) === 'accepted') {
        Cookie.remove(cookieKey);
      } else {
        Cookie.set(cookieKey, 'accepted', 365);
      }

      window.location.reload();
    });
  });
})();
