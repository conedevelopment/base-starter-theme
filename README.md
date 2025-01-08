<p>
  <a href="https://github.com/conedevelopment/base-starter-theme">
    <br>
    <img src="./.github/base-logo-dark.svg" alt="Base" width="226" height="40">
    <br>
  </a>
</p>

WordPress theme for Base.

## Required WordPress plugins

- Advanced Custom Field PRO
- Breadcrumb NavXT
- Classic Editor
- Contact Form 7
- Modern Image Formats
- Safe SVG
- SEO Framework

## Image Sizes

- Thumbnail: 600x600 (no hard-crop)
- Medium: 900x900
- Large: 1400x1400

## Development environment

The project uses npm script to compile Sass. For more details, see: `package.json`.

To compile the  `.scss` files, do the following:

- run `npm install` to install the node dependencies,
- run `npm start` to start the development compilation and watch.

Before release run `npm run prod`-t to compress the files.

## Linters

The project uses [Stylelint](https://stylelint.io/) and [Semistandard](https://github.com/standard/semistandard). For more information, check out the config files.
