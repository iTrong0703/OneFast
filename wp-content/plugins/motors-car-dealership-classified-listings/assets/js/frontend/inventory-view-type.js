(function($) {
    $( document ).on(
        'click',
        '.stm-view-by a',
        function (e) {
            if ( $( this ).data( 'view' ) !== '') {
                e.preventDefault();
                var viewType = $( this ).data( 'view' );

                $( '.stm-view-by a' ).removeClass( 'active' );
                $( this ).addClass( 'active' );

                $( '#stm_view_type' ).val( viewType );

                var currentUrl = window.location.href;
                var updatedUrl = updateQueryStringParameter( currentUrl, 'view_type', viewType );
                window.history.replaceState( {}, '', updatedUrl );
                window.location.href = updatedUrl;
            }
        }
    );

    function updateQueryStringParameter(uri, key, value) {
        var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
        var separator = uri.indexOf('?') !== -1 ? "&" : "?";
        if (uri.match(re)) {
            return uri.replace(re, '$1' + key + "=" + value + '$2');
        } else {
            return uri + separator + key + "=" + value;
        }
    }
})(jQuery)