// Логика времени в хедере
$(function () {
    $(document).on('click', '.time-more, .header_top-time__text, .header_top-time__ico', function () {
        $('.header_top-time__content').toggleClass('active')
    })
});

// Логика телефона в хедере
$(function () {
    $(document).on('click', '.phone-more', function () {
        $('.header_top-phone__additional').toggleClass('active')
    })
});

// Логика телефона в футере
$(function () {
    $(document).on('click', '.footer-phone__more', function () {
        $('.footer-phone__content').toggleClass('active')
    })
});

// Поиск в хедере
$(function () {
    $('.header-search__item').click(function () {
        $('.header-search__popup').fadeToggle();
    })
});

// Бургер меню
$(function () {
    $('.header-burger, .burger-menu__close').click(function (event) {
        $('.header-burger, .burger-menu').toggleClass('active');
        $('html').toggleClass('lock')
    });
    $('.burger-menu__shadow').click(function (event) {
        $('.burger-menu').removeClass('active');
        $('html').removeClass('lock');
        $('.header-burger').removeClass('active');
    });
});


