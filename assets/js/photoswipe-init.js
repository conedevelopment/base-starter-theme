import PhotoSwipeLightbox from './plugin/photoswipe-lightbox.min.js'; // eslint-disable-line

// Single images in post content
const single = new PhotoSwipeLightbox({
  gallery: '.post-content :not(.gallery-icon) > a[data-pswp-width]',
  showHideAnimationType: 'zoom',
  pswpModule: () => import('./plugin/photoswipe.min.js'), // eslint-disable-line
});

single.on('uiRegister', () => {
  single.pswp.ui.registerElement({
    name: 'custom-caption',
    order: 9,
    isButton: false,
    appendTo: 'root',
    onInit: (el) => {
      single.pswp.on('change', () => {
        const currSlideElement = single.pswp.currSlide.data.element;
        let captionHTML = '';
        if (currSlideElement) {
          const hiddenCaption = currSlideElement.parentElement.querySelector('.wp-caption-text');
          if (hiddenCaption) {
            captionHTML = hiddenCaption.innerHTML;
          }
        }
        el.innerHTML = captionHTML || '';
      });
    },
  });
});

single.init();

// Gallery in post content
const gallery = new PhotoSwipeLightbox({
  gallery: '.gallery',
  children: 'a',
  showHideAnimationType: 'zoom',
  pswpModule: () => import('./plugin/photoswipe.min.js'), // eslint-disable-line
});

gallery.on('uiRegister', () => {
  gallery.pswp.ui.registerElement({
    name: 'custom-caption',
    order: 9,
    isButton: false,
    appendTo: 'root',
    onInit: (el) => {
      gallery.pswp.on('change', () => {
        const currSlideElement = gallery.pswp.currSlide.data.element;
        let captionHTML = '';
        if (currSlideElement) {
          const hiddenCaption = currSlideElement.parentElement.parentElement.querySelector('.wp-caption-text');
          if (hiddenCaption) {
            captionHTML = hiddenCaption.innerHTML;
          }
        }
        el.innerHTML = captionHTML || '';
      });
    },
  });
});

gallery.init();

// Product gallery in post content
const productGallery = new PhotoSwipeLightbox({
  gallery: '.product-gallery',
  children: 'a',
  showHideAnimationType: 'zoom',
  pswpModule: () => import('./plugin/photoswipe.min.js'), // eslint-disable-line
});

productGallery.on('uiRegister', () => {
  productGallery.pswp.ui.registerElement({
    name: 'custom-caption',
    order: 9,
    isButton: false,
    appendTo: 'root',
    onInit: (el) => {
      productGallery.pswp.on('change', () => {
        const currSlideElement = productGallery.pswp.currSlide.data.element;
        let captionHTML = '';
        if (currSlideElement) {
          const hiddenCaption = currSlideElement.parentElement.parentElement.querySelector('.wp-caption-text');
          if (hiddenCaption) {
            captionHTML = hiddenCaption.innerHTML;
          }
        }
        el.innerHTML = captionHTML || '';
      });
    },
  });
});

productGallery.init();

// Video
const video = new PhotoSwipeLightbox({
  gallery: '[data-pswp-type="video"]',
  showHideAnimationType: 'fade',
  pswpModule: () => import('./plugin/photoswipe.min.js'), // eslint-disable-line
});

// parse data-video-url attribute
video.addFilter('itemData', (itemData) => {
  const { videoUrl, videoType } = itemData.element.dataset;
  if (videoUrl) {
    itemData.videoUrl = videoUrl;
  }

  if (videoType) {
    itemData.videoType = videoType;
  }
  console.log(itemData);
  return itemData;
});

// override slide content
video.on('contentLoad', (e) => {
  const { content } = e;
  e.preventDefault();

  content.element = document.createElement('div');
  content.element.className = 'pswp__video-container';


  if (content.data.videoType === 'youtube') {
    const iframe = document.createElement('iframe');
    iframe.src = `https://www.youtube.com/embed/${content.data.videoUrl}`;
    iframe.width = '560';
    iframe.height = '315';
    iframe.allowFullscreen = true;
    iframe.allow = 'accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture';
    content.element.appendChild(iframe);
  } else if (content.data.videoType === 'vimeo') {
    const iframe = document.createElement('iframe');
    iframe.src = content.data.videoUrl;

    console.log(iframe);
    iframe.width = '560';
    iframe.height = '315';
    iframe.allowFullscreen = true;
    iframe.allow = 'accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture';
    content.element.appendChild(iframe);
  } else {
    const video = document.createElement('video');
    video.src = content.data.videoUrl;
    video.controls = true;
    content.element.appendChild(video);
  }
});

video.init();
