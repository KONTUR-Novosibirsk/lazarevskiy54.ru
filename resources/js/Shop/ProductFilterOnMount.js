export const productFilterOnMount = () => {
    $('.products-filter-item__arrow').click(function () {
        $(this).toggleClass('active')
        $('.products-filter__body').slideToggle();
    })

/*    $('.products-filter__arrow').click(function () {
        $(this).toggleClass('active')
        $(this).parent().siblings('.products-filter__content').slideToggle();
    })*/
}
