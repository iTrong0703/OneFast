(function($) {
    $(document).on('click', '#buy-car-online', function(e) {
        e.preventDefault();

        var thisBtn = $(this);

        var carId = $(this).data('id');
        var price = $(this).data('price');

        $.ajax({
            url: ajaxurl,
            type: "POST",
            dataType: 'json',
            context: this,
            data: 'car_id=' + carId + '&price=' + price + '&action=stm_ajax_buy_car_online&security=' + stm_security_nonce,
            beforeSend: function () {
                thisBtn.addClass('buy-online-load');
            },
            success: function (data) {

                thisBtn.removeClass('buy-online-load');

                if (data.status == 'success') {
                    window.location = data.redirect_url;
                }
            }
        });
    });
    if (window.location.search.includes('add-to-cart')) {
        var newUrl = window.location.origin + window.location.pathname;
        window.history.replaceState({}, document.title, newUrl);
    }
})(jQuery)