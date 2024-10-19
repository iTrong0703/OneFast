(function ($) {
    window.STMCascadingSelect = function STMCascadingSelect(container, relations) {
        let self = this;

        self.relations = relations;
        self.ctx       = container;
        self.options   = {
            selectBoxes: []
        };

        if ( self.relations && Object.keys( self.relations ).length ) {
            let selectBoxes = [];

            $.each(self.relations, function (slug, options) {
                let selectBox = self.selectbox(slug, options);

                if ( selectBox && typeof selectBox === 'object' ) {
                    selectBoxes.push( selectBox );
                }
            });

            if ( selectBoxes.length ) {
                self.options.selectBoxes = self.options.selectBoxes.concat( selectBoxes );
            }
        }

        $(container).cascadingDropdown( self.options );
    };

    STMCascadingSelect.prototype.selectbox = function (slug, config) {
        var parent = config.dependency;

        if (!$(this.selector(slug), this.ctx).length || (parent && !$(this.selector(parent), this.ctx).length)) {
            return null;
        }

        var $select = $(this.selector(slug), this.ctx);
        var selected = $select.data('selected');

        if ($select.prop('multiple')) {
            selected = selected ? selected.split(',') : [];
        }

        return {
            selector: this.selector(slug),
            paramName: slug,
            requires: parent ? [this.selector(parent)] : null,
            allowAll: config.allowAll,
            selected: selected,
            source: function (request, response) {
                var selected = request[parent];
                var options = [];
                $.each(config.options, function (i, option) {
                    if ((config.allowAll && !selected) || (option.deps && option.deps.indexOf(selected) >= 0)) {
                        options.push(option);
                    }
                });

                response(options);
            }
        };
    };

    STMCascadingSelect.prototype.selector = function (slug) {
        if (this.relations[slug].selector) {
            return this.relations[slug].selector;
        }

        return '[name="' + slug + '"]';
    }

})(jQuery);