// Мобильное меню
$(document).ready(function () {
    $('.mobile-menu__item').click(function (event) {
        if ($(this).hasClass('fake-current')) {
            $(".mobile-menu__item").removeClass('hide-current');
            $(".mobile-menu__item").removeClass('fake-current');
        } else {
            $(".mobile-menu__item").removeClass('fake-current');
            $(".mobile-menu__item").addClass('hide-current');
            $(this).addClass('fake-current');
            $(this).removeClass('hide-current');
        }
    });

    $('.catalog-menu__close, .modal-menu__close').click(function (event) {
        $(".mobile-menu__item").removeClass('hide-current');
        $(".mobile-menu__item").removeClass('fake-current');
    });
});

// Каталог меню и модальное меню
$(document).ready(function () {
    $('.menu-catalog, .catalog-menu__close').click(function (event) {
        $('.catalog-menu').toggleClass('show');
        $('.modal-menu').removeClass('show');
        if ($('.catalog-menu').hasClass('show')) {
            $('html').addClass('lock')
        } else {
            $('html').removeClass('lock')
        }
    });
    $('.menu-list, .modal-menu__close').click(function (event) {
        $('.modal-menu').toggleClass('show');
        $('.catalog-menu').removeClass('show');
        if ($('.modal-menu').hasClass('show')) {
            $('html').addClass('lock')
        } else {
            $('html').removeClass('lock')
        }
    });
});

// Подменю
$(function () {
    $('.sub-menu__arrow').click(function () {
        $(this).toggleClass('active')
        $(this).siblings('.sub-menu').slideToggle();
    })
});

