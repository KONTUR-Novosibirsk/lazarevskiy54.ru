import * as isvek from "bvi";

// Пагинация списка хитов
$(document).ready(function () {
    let page = 1; // текущая страница
    let perPage = 5; // количество блоков на странице
    let totalPages = Math.ceil($('.hit-item').length / perPage); // общее количество страниц
    let totalItems = $('.hit-item').length; // общее количество блоков
    let shownItems = perPage; // количество показанных блоков

    // показать только первые 10 блоков
    $('.hit-item').slice(0, perPage).show();

    // добавить обработчик события click на кнопку "Показать еще"
    $('.hit-list__more').click(function () {
        if (page < totalPages) {
            $('.hit-item').slice(page * perPage, (page + 1) * perPage).hide();
            page++;
            $('.hit-item').slice(page * perPage - perPage, page * perPage).show();
            shownItems += perPage;
            if (shownItems >= totalItems) {
                $('.hit-list__more').hide();
            }
        }
    });
});

// Доступность (BVI)
$(function () {
    if (document.querySelector('.eye')) {
        new isvek.Bvi({
            target: '.eye',
            fontSize: 24,
            theme: 'brown',
        });
    }
});

// Cookie уведомление
document.addEventListener('DOMContentLoaded', function() {
    const container = document.querySelector("#cookieee");
    if (!container) return;
    if (!document.cookie.includes("cookieee")) {
        container.classList.add("cookieee-show");
    }
    const applyButton = container.querySelector("#cookieee__apply");
    if (applyButton) {
        applyButton.addEventListener("click", function() {
            container.classList.remove("cookieee-show");
            document.cookie = "cookieee=true; max-age=2592000; path=/";
        });
    }
});

