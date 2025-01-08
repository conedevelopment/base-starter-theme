/* eslint-disable no-unused-vars */
const Cookie = (() => {
  /**
   * Set a cookie value for the given key.
   *
   * @param  {string}  key
   * @param  {string}  value
   * @param  {number|null}  expires
   * @param  {string}  path
   * @param  {object}  options
   * @return {void}
   */
  function set(key, value, expires = null, path = '/', options = {}) {
    const defaults = {
      [key]: value,
      expires,
      path,
      SameSite: 'Lax',
      Secure: true,
    };

    const pairs = { ...defaults, ...options };

    pairs.expires = pairs.expires ? new Date(Date.now() + 86400 * 1000 * pairs.expires)
      .toUTCString() : null;

    document.cookie = Object.entries(pairs)
      .reduce((stack, entry) => stack.concat(entry.join('=')), [])
      .join('; ');
  }

  /**
   * Get the cookie with the given key.
   *
   * @param  {string}  key
   * @param  {*}       value
   * @return {*}
   */
  function get(key, value = null) {
    const cookie = document.cookie.match(new RegExp(`(^| )${key}=([^;]+)`));

    return (cookie && cookie[2]) ? cookie[2] : value;
  }

  /**
   * Determine if the given cookie exists.
   *
   * @param  {string}  key
   * @return {bool}
   */
  function isset(key) {
    return document.cookie.match(new RegExp(`(^| )${key}=([^;]+)`)) !== null;
  }

  /**
   * Remove the given cookie.
   *
   * @param  {string}  key
   * @return {void}
   */
  function remove(key) {
    this.set(key, '', new Date(null));
  }

  return {
    set,
    get,
    isset,
    remove,
  };
})();
/* eslint-enable no-unused-vars */
