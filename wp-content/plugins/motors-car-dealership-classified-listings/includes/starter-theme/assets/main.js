(function ($) {
    let adminAjaxUrl = null;
    $(document).ready(function () {
        /** Set ajax url value **/
        if (typeof mew_nonces.ajaxurl !== 'undefined'
            && mew_nonces.hasOwnProperty('ajaxurl')) {
            adminAjaxUrl = mew_nonces.ajaxurl;
        }
        /** show step 2 **/
        $('.starter_install_theme_btn').on('click', function () {
            $('.starter_install_theme_btn .installing').css('display', 'inline-block');
            $('.starter_install_theme_btn span').html('Installing ');
            if (null !== adminAjaxUrl) {
                $.ajax({
                    url: adminAjaxUrl,
                    dataType: 'json',
                    context: this,
                    method: 'POST',
                    data: {
                        action: 'stm_install_starter_theme',
                        slug: 'motors-starter-theme',
                        type: 'theme',
                        nonce: mew_nonces.stm_install_starter_theme,
                        is_last: false
                    },
                    complete: function (data) {
                        $('.starter_install_theme_btn .installing').css('display', 'none');
                        $('.starter_install_theme_btn .downloaded').css('display', 'inline-block');
                        $('.starter_install_theme_btn span').html('Successfully Installed');
                        setTimeout(
                            function () {
                                location.replace(location.origin + '/wp-admin/admin.php?page=motors_starter_demo_installer');
                            }, 2000
                        )
                    }
                });
            }
        });

    });
})(jQuery);