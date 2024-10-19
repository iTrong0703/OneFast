(function ($) {
	var errorFields = {
		firstStep: {},
		secondStep: {},
		thirdStep: {}
	};

	function stm_validateFirstStep(form_id) {
		errorFields.firstStep = {};
		var widget_selector   = (typeof form_id !== "undefined") ? '.stm-sell-a-car-form-' + form_id + ' ' : '';
		$( widget_selector + '#step-one input[type="text"]' ).each(
			function(){
				var required = $( this ).data( 'need' );
				if (typeof required !== 'undefined') {
					if ($( this ).attr( 'name' ) != 'video_url') {
						if ($( this ).val() == '') {
							$( this ).addClass( 'form-error' );

							errorFields.firstStep[$( this ).attr( 'name' )] = $( this ).closest( '.form-group' ).find( '.contact-us-label' ).text();
						} else {
							$( this ).removeClass( 'form-error' );
						}
					}
				}
			}
		);
		var errorsLength = Object.keys( errorFields.firstStep ).length;
		if (errorsLength == 0) {
			$( widget_selector + 'a[href="#step-one"]' ).addClass( 'validated' );
		} else {
			$( widget_selector + 'a[href="#step-one"]' ).removeClass( 'validated' );
		}
	}

	function stm_validateThirdStep(form_id) {
		errorFields.thirdStep = {};
		var widget_selector   = (typeof form_id !== "undefined") ? '.stm-sell-a-car-form-' + form_id + ' ' : '';
		$( widget_selector + '.contact-details input[type="text"],' + widget_selector + '.contact-details input[type="email"]' ).each(
			function(){
				if ($( this ).val() == '') {
					$( this ).addClass( 'form-error' );

					errorFields.thirdStep[$( this ).attr( 'name' )] = $( this ).closest( '.form-group' ).find( '.contact-us-label' ).text();
				} else {
					$( this ).removeClass( 'form-error' );
				}
			}
		)
	}

	$( document ).on(
		'ready',
		function () {

			$( '.sell-a-car-proceed' ).on(
				'click',
				function(e){
					e.preventDefault();
					var step            = $( this ).data( step );
					step                = step.step;
					var form_id         = $( this ).closest( '.stm-sell-a-car-form' ).data( 'form-id' );
					var widget_selector = (typeof form_id !== "undefined") ? '.stm-sell-a-car-form-' + form_id + ' ' : '';

					if (step == '2') {
						stm_validateFirstStep( form_id );
						var errorsLength = Object.keys( errorFields.firstStep ).length;
						if (errorsLength == 0) {
							$( widget_selector + 'a[href="#step-one"]' ).removeClass( 'active' );
							$( widget_selector + 'a[href="#step-two"]' ).addClass( 'active' );
							$( widget_selector + '.form-content-unit' ).slideUp();
							$( widget_selector + '#step-two' ).slideDown();
						}
					}
					if (step == '3') {
						$( widget_selector + 'a[href="#step-two"]' ).removeClass( 'active' );
						$( widget_selector + 'a[href="#step-three"]' ).addClass( 'active' );
						$( widget_selector + '.form-content-unit' ).slideUp();
						$( widget_selector + '#step-three' ).slideDown();
						$( widget_selector + 'a[href="#step-two"]' ).addClass( 'validated' );
					}
				}
			);

			$( '.stm-sell-a-car-form input[type="submit"]' ).on(
				'click',
				function(e){
					var form_id         = $( this ).closest( '.stm-sell-a-car-form' ).data( 'form-id' );
					var widget_selector = (typeof form_id !== "undefined") ? '.stm-sell-a-car-form-' + form_id + ' ' : '';
					stm_validateFirstStep( form_id );
					stm_validateThirdStep( form_id );

					$( widget_selector + 'a[href="#step-two"]' ).addClass( 'validated' );

					var errorsLength  = Object.keys( errorFields.firstStep ).length;
					var errorsLength2 = Object.keys( errorFields.thirdStep ).length;
					if (errorsLength != 0) {
						e.preventDefault();
						$( widget_selector + '.form-navigation-unit' ).removeClass( 'active' );
						$( widget_selector + 'a[href="#step-one"]' ).addClass( 'active' );
						$( widget_selector + '#step-three' ).slideUp();
						$( widget_selector + '#step-one' ).slideDown();
					}

					if (errorsLength2 != 0) {
						e.preventDefault();
					} else {
						$( widget_selector + 'a[href="#step-three"]' ).addClass( 'validated' );
					}
				}
			);

			$( '.stm-sell-a-car-form .form-navigation-unit' ).on(
				'click',
				function (e) {
					e.preventDefault();
					var form_id         = $( this ).closest( '.stm-sell-a-car-form' ).data( 'form-id' );
					var widget_selector = (typeof form_id !== "undefined") ? '.stm-sell-a-car-form-' + form_id + ' ' : '';
					stm_validateFirstStep( form_id );
					if ( ! $( this ).hasClass( 'active' )) {
						$( widget_selector + '.form-navigation-unit' ).removeClass( 'active' );
						$( this ).addClass( 'active' );

						var tab = $( this ).data( 'tab' );

						$( widget_selector + '.form-content-unit' ).slideUp();

						$( widget_selector + '#' + tab ).slideDown();
					}
				}
			);

			var i = 1;

			$( '.stm-sell-a-car-form .stm-plus' ).on(
				'click',
				function (e) {
					e.preventDefault();
					var filesnum = $( this ).closest( '.stm-sell-a-car-form' ).find( '.upload-photos .stm-pseudo-file-input' ).length;
					if (filesnum < 5) {
						var input_label = $( this ).closest( '.stm-sell-a-car-form' ).find( '.upload-photos .stm-pseudo-file-input:first-of-type' ).data( 'placeholder' );
						$( this ).closest( '.stm-sell-a-car-form' ).find( '.upload-photos' ).append( '<div class="stm-pseudo-file-input generated"><div class="stm-filename">' + input_label + '</div><div class="stm-plus"></div><input class="stm-file-realfield" type="file" name="gallery_images_' + (filesnum + 1) + '"/></div>' );
					}
				}
			);

			$( 'body' ).on(
				'change',
				'.stm-file-realfield',
				function() {
					var length = $( this )[0].files.length;

					if (length == 1) {
						var uploadVal = $( this ).val();
						$( this ).closest( '.stm-pseudo-file-input' ).find( ".stm-filename" ).text( uploadVal );
					} else if (length == 0) {
						$( this ).closest( '.stm-pseudo-file-input' ).find( ".stm-filename" ).text( 'Choose file...' );
					} else if (length > 1) {
						$( this ).closest( '.stm-pseudo-file-input' ).find( ".stm-filename" ).text( length + ' files chosen' );
					}
				}
			);

			$( 'body' ).on(
				'click',
				'.generated .stm-plus',
				function () {
					i--;
					$( this ).closest( '.stm-pseudo-file-input' ).remove();
				}
			);
		}
	);
})( jQuery );
