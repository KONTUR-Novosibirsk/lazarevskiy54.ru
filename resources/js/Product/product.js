// Табы продукта
$(function () {
    $('.product-tabs__item:first-child').addClass('active')
    $('.product-description').addClass('active')
    $('.product-tabs__item').click(function () {
        $('.product-tabs__item').removeClass('active');
        $('.product-tabs__content').removeClass('active');
        $(this).addClass('active');
        $(`.product-tabs__content[data-tab="${this.dataset.tab}"]`).addClass('active');
    });
});

