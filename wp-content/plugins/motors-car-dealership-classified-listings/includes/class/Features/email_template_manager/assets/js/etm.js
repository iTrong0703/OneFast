(function($) {
    $(document).ready(function () {
        var copyText = '';

        $(".auto_select").each(function () {
            var width = $(this).val().length;
            $(this).attr('size', width);
        });

        $(".auto_select").on({
            mouseenter: function(){
                copyText = $(this).val();
                this.trigger('focus');
                this.select();
            },
            mouseleave: function () {
                $(this).val(copyText);
                this.blur();
            }
        });

    });

})(jQuery);