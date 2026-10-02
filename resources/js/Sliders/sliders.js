import Swiper from 'swiper';
import {Navigation, Pagination, Controller, EffectFade, Autoplay, Thumbs} from 'swiper/modules';

Swiper.use([Navigation, Pagination, Controller, EffectFade, Autoplay, Thumbs]);

import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

// Главный слайдер
$(function () {
    const mainSlider = new Swiper('.main-slider__content', {
        speed: 400,
        loop: true,
        navigation: {
            nextEl: '.main-slider__next',
            prevEl: '.main-slider__perv',
        },
        pagination: {
            el: '.main-slider__pagination',
            type: 'fraction',
        },
    });
});

// Слайдер акций
$(function () {
    const promotionSlider = new Swiper('.promotion-list', {
        slidesPerView: 2,
        spaceBetween: 40,
        speed: 400,
        loop: true,
        autoplay: {
            delay: 3000,
        },
        breakpoints: {
            // when window width is >= 320px
            320: {
                slidesPerView: 1,
            },
            // when window width is >= 480px
            1200: {
                slidesPerView: 1,
            },
            // when window width is >= 640px
            1400: {
                slidesPerView: 2,
            }
        }
    });
});

// Слайдер брендов
$(function () {
    const brandsSlider = new Swiper('.brands-list', {
        slidesPerView: 7,
        spaceBetween: 22,
        grid: {
            rows: 2,
        },
        breakpoints: {
            // when window width is >= 320px
            320: {
                slidesPerView: 2,
            },
            576: {
                slidesPerView: 4,
            },
            // when window width is >= 480px
            1200: {
                slidesPerView: 6,
            },
            // when window width is >= 640px
            1400: {
                slidesPerView: 7,
            }
        },
    });
});

// Слайдеры продукта (навигация и основной)
$(function () {
    const productSliderNav = new Swiper('.product-slider_navigate', {
        slidesPerView: 4,
        spaceBetween: 24,
        speed: 400,
        touchRatio: 0.2,
        loop: true,
        loopedSlides: 4,
        freeMode: true,
        direction: 'horizontal',
        watchSlidesProgress: true,
        breakpoints: {
            // when window width is >= 320px
            320: {
                slidesPerView: 3,
            },
            576: {
                slidesPerView: 4,
            }
        }
    });

    const productSliderMain = new Swiper('.product-slider_main', {
        speed: 400,
        spaceBetween: 15,
        loop: true,
        loopedSlides: 4,
        navigation: {
            nextEl: '.product-next',
            prevEl: '.product-prev',
        },
        thumbs: {
          swiper: productSliderNav,
        },
    });
});

// Слайдер похожих товаров
$(function () {
    const similarSlider = new Swiper('.product-similar__slider', {
        slidesPerView: 5,
        spaceBetween: 14,
        speed: 400,
        loop: true,
        breakpoints: {
            // when window width is >= 320px
            320: {
                slidesPerView: 1,
            },
            576: {
                slidesPerView: 2,
            },
            768: {
                slidesPerView: 3,
            },
            // when window width is >= 480px
            1200: {
                slidesPerView: 4,
            },
            // when window width is >= 640px
            1400: {
                slidesPerView: 5,
            }
        }
    });
});

// Слайдер просмотренных товаров
$(function () {
    const watchedSlider = new Swiper('.product-watched__slider', {
        slidesPerView: 5,
        spaceBetween: 14,
        speed: 400,
        loop: true,
        breakpoints: {
            // when window width is >= 320px
            320: {
                slidesPerView: 1,
            },
            576: {
                slidesPerView: 2,
            },
            768: {
                slidesPerView: 3,
            },
            // when window width is >= 480px
            1200: {
                slidesPerView: 4,
            },
            // when window width is >= 640px
            1400: {
                slidesPerView: 5,
            }
        }
    });
});

