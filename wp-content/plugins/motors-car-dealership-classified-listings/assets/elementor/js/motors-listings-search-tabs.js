class FilterListing extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				filter_listing: '.filter-listing',
				button: 'button[type=submit].search-submit ',
				show_more_fields: '.show-extra-fields',
			}
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings( 'selectors' );
		return {
			$filter_listing: this.$element.find( selectors.filter_listing ),
			$button: this.$element.find( selectors.button ),
			$show_more_fields: this.$element.find( selectors.show_more_fields ),
		};
	}

	onInit() {
		super.onInit();

		let data        = this.elements.$filter_listing.data(),
			options     = data.options,
			show_amount = data.show_amount,
			$           = jQuery;

		if (show_amount) {
			$.each(
				options,
				function (tax, data) {
					$.each(
						data.options,
						function (val, option) {
							option.label += ' (' + option.count + ')';
						}
					);
				}
			);
		}

		let $el = $( this.elements.$filter_listing )

		$el.find( '.stm-filter-tab-selects.filter' ).each(
			function () {
				new STMCascadingSelect( this, options );
			}
		);

		$el.find( "select[data-class='stm_select_overflowed']" ).on(
			"change",
			function () {
				let str;
				const sel      = $( this );
				const selValue = sel.val();
				const selType  = sel.attr( "data-sel-type" );
				const min      = 'min_' + selType;
				const max      = 'max_' + selType;

				if (selValue === null || selValue.length === 0) {
					return;
				}

				if (selValue.includes( "<" )) {
					str = selValue.replace( "<", "" ).trim();
					$( "input[name='" + min + "']" ).val( "" );
					$( "input[name='" + max + "']" ).val( str );
				} else if (selValue.includes( "-" )) {
					const strSplit = selValue.split( "-" );
					$( "input[name='" + min + "']" ).val( strSplit[0] );
					$( "input[name='" + max + "']" ).val( strSplit[1] );
				} else {
					str = selValue.replace( ">", "" ).trim();
					$( "input[name='" + min + "']" ).val( str );
					$( "input[name='" + max + "']" ).val( "" );
				}
			}
		);

		let $show_more_fields = $( this.elements.$show_more_fields )

		$show_more_fields.click(
			function(e) {
				e.preventDefault()
				let tab_id    = e.target.getAttribute( 'data-tab-id' ),
					targetTab = $( '#' + tab_id )

				$( '.stm-select-col.overflown', targetTab ).slideToggle();
				e.target.classList.toggle( 'open' )
			}
		)

		let $button = $( this.elements.$button )

		$button.click(
			function (e) {
				e.preventDefault();

				let form         = this.form,
					params       = new URLSearchParams( new FormData( form ) ).toString(),
					inventoryUrl = form.action + '?' + params;

				/* start if enable friendly urls */
				if ( motors_vl_config.enable_friendly_urls.length > 0 && form.hasAttribute('data-action') ) {
					inventoryUrl = form.getAttribute( 'data-action' );
				}
				/* end if enable friendly urls */

				window.location.href = inventoryUrl;
			}
		)

	}

}

jQuery( window ).on(
	'elementor/frontend/init',
	function() {
		const addHandler = function ($element) {
			elementorFrontend.elementsHandler.addHandler( FilterListing, {$element} );
		};

		elementorFrontend.hooks.addAction( 'frontend/element_ready/motors-listings-search-tabs.default', addHandler );
	}
);
