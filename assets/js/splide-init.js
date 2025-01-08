document.addEventListener('DOMContentLoaded', () => {
  if (document.querySelector('.splide-author')) {
    const splideAuthor = new Splide('.splide-author', {
      type: 'carousel',
      autoplay: true,
      loop: true,
      perPage: 4,
      perMove: 1,
      rewind : false,
      gap: '2rem',
      speed: 1500,
      interval: 3500,
      pagination: false,
      pauseOnHover: false,
      pauseOnFocus: false,
      arrowPath: 'M12.541,39.384l17.895,-17.895c0.822,-0.822 0.822,-2.156 0,-2.978l-17.895,-17.895c-0.822,-0.821 -2.156,-0.821 -2.977,0c-0.822,0.822 -0.822,2.156 -0,2.978l16.406,16.406c-0,0 -16.406,16.406 -16.406,16.406c-0.822,0.822 -0.822,2.156 -0,2.978c0.821,0.821 2.155,0.821 2.977,-0Z',
      breakpoints: {
        1300: {
          perPage: 3,
        },
        1000: {
          perPage: 2,
        },
        800: {
          perPage: 1,
        },
      },
    });

    splideAuthor.mount();
  }
});
