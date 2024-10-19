(function ($) {
    $(document).on('click', '.stm_per_page', function () {
        $(this).toggleClass('active');
        $(this).find('ul').toggleClass('activated');
    });
})(jQuery)