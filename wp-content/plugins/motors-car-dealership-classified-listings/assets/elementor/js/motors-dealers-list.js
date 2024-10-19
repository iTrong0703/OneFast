class DealersList extends elementorModules.frontend.handlers.Base {
    getDefaultSettings() {
        return {
            selectors: {
                filter_dealer: '.stm_dynamic_listing_dealer_filter_form',
            }
        };
    }

    getDefaultElements() {
        const selectors = this.getSettings('selectors');
        return {
            $filter_dealer: this.$element.find(selectors.filter_dealer),
        };
    }

    onInit() {
        super.onInit();

        let data = this.elements.$filter_dealer.data(),
            options = data.options,
            $ = jQuery

        let $el = $(this.elements.$filter_dealer);

        var selects = [];

        $el.find('.stm-filter-tab-selects.dealer-filter .row').each(function () {
            $(this).find('select').each(function () {
                selects.push($(this).attr('name'));
            });

            new STMCascadingSelect(this, options);
        });

        selects.forEach(function (sel) {
            const urlParams = new URLSearchParams(window.location.search);
            const myParam = urlParams.get(sel);

            if (myParam != null) {
                $el.find('.stm-filter-tab-selects.dealer-filter .row select[name=' + sel + ']').select2().val(myParam).trigger('change');
            }
        });
    }

}

jQuery(window).on('elementor/frontend/init', () => {
    const addHandler = ($element) => {
        elementorFrontend.elementsHandler.addHandler(DealersList, {
            $element,
        });
    };
    elementorFrontend.hooks.addAction('frontend/element_ready/motors-dealers-list.default', addHandler);
});