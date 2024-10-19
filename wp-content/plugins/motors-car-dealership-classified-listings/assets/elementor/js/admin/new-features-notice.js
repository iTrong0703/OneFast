(function($) {
    $(document).ready(function() {
        $('.close-after-click').on('click', function() {
            $.ajax({
                type: "POST",
                url: ajaxurl,
                dataType: 'json',
                context: this,
                data: 'action=close_after_click&nonce=' + mew_nonces.close_after_click,
                success: function (data) {
                    console.log(data);
                }
            });
        });
    });
}(jQuery));