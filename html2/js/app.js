const btn = document.querySelector('button.mobile-menu-button');
const menu = document.querySelector('.mobile-menu');

btn.addEventListener('click', () => {
  menu.classList.toggle('hidden');
});

const mainSlider = new Swiper('#main-slider', {
  loop: true,
  speed: 500,
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
});

const servicesSlider = new Swiper('#services-slider', {
  loop: true,
  speed: 500,
  slidesPerView: 4,
  spaceBetween: 36,
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
    renderBullet: (index, className) => {
      return '<span class="' + className + '">' + (index + 1) + "</span>";
    },
  },
  navigation: {
    nextEl: '.services-button-next',
    prevEl: '.services-button-prev',
  },
  breakpoints: {
    0:{
      slidePerViiew: 1,
    },
    360: {
      slidesPerView: 1,
    },
    580: {
      slidesPerView: 2,
    },
    678: {
      slidesPerView: 3,
    },
    // 695: {
    //   slidesPerView: 2,
    // },
    // 900: {
    //   slidesPerView: 4,
    // },
    1024: {
      slidesPerView: 4,
    },
    // 1100: {
    //   slidesPerView: 4,
    // },
  },
});

function toggleLoginForm() {
  // console.log('click');
  document.querySelector('.login-forms').classList.toggle('hidden');
  
}