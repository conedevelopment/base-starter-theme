(() => {
  const themeSwitcher = document.querySelector('#theme-switcher');
  const preferredTheme = localStorage.getItem('preferred-theme') || 'system';

  if (!themeSwitcher) {
    return;
  }

  const handleThemeSwitch = (theme) => {
    const systemMode = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';

    document.documentElement.classList.add('no-transition');

    localStorage.setItem('preferred-theme', theme);
    document.documentElement.setAttribute('data-theme-mode', theme === 'system' ? systemMode : theme);

    themeSwitcher.setAttribute('data-theme-mode', theme);

    themeSwitcher.querySelector(`.theme-switcher__${theme}-mode`).focus();

    document.documentElement.classList.remove('no-transition');
  };

  themeSwitcher.addEventListener('click', (e) => {
    if (e.target.matches('[data-action]')) {
      const theme = e.target.getAttribute('data-action');
      handleThemeSwitch(theme);
    }
  });

  themeSwitcher.setAttribute('data-theme-mode', preferredTheme);
})();
