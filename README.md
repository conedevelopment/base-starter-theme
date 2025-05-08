<p>
  <a href="https://github.com/conedevelopment/base-starter-theme">
    <br>
    <img src="./.github/base-logo-dark.svg" alt="Base" width="136" height="25">
    <br>
  </a>
</p>

> ⚠️ **This project is a Work in Progress (WIP).** Expect ongoing updates and improvements.

**Base** is a WordPress starter theme built with our proven methodology for developing custom WordPress themes. It leverages **Advanced Custom Fields PRO (ACF PRO)** for flexible content management and rapid development.

## 1. Required Plugins

Ensure the following plugin is installed and activated:

- **Advanced Custom Fields PRO**

## 2. Recommended Plugins

For an enhanced development experience, we recommend the following plugins:

- [**Breadcrumb NavXT**](https://wordpress.org/plugins/breadcrumb-navxt/) – Manage breadcrumbs easily
- [**Classic Editor**](https://wordpress.org/plugins/classic-editor/) – Revert to the classic WordPress editor
- [**Contact Form 7**](https://wordpress.org/plugins/contact-form-7/) – Simple, customizable contact forms
- [**Modern Image Formats**](https://wordpress.org/plugins/modern-image-formats/) – Enable next-gen image formats (e.g., WebP)
- [**Safe SVG**](https://wordpress.org/plugins/safe-svg/) – Secure SVG uploads
- [**The SEO Framework**](https://wordpress.org/plugins/autodescription/) – Lightweight and reliable SEO solution


## 3. Preferred Settings

### 3.1. The SEO Framework Configuration
- Navigate to **Settings → Title Settings → Prefixes**
- Enable: **"Remove term type prefixes from generated archive titles"**

### 3.2. Image Sizes

- Thumbnail: 600x600 (no hard-crop)
- Medium: 900x900
- Large: 1400x1400

## 4. Development environment

The project uses npm script to compile Sass. For more details, see: `package.json`.

To compile the `.scss` files, do the following:

- run `npm install` to install the node dependencies,
- run `npm start` to start the development compilation and watch.

Before release run `npm run prod`-t to compress the files.

### 4.1. Linters

The project uses [Stylelint](https://stylelint.io/) and [Semistandard](https://github.com/standard/semistandard). For more information, check out the config files.
