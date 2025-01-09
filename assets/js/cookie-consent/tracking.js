if (
  Cookie.isset('base-cookie-consent-statistics')
  && Cookie.get('base-cookie-consent-statistics') === 'accepted'
) {
  console.log('Cookie consent: statistic accepted!');
}

if (
  Cookie.isset('base-cookie-consent-marketing')
  && Cookie.get('base-cookie-consent-marketing') === 'accepted'
) {
  console.log('Cookie consent: marketing accepted!');
}
