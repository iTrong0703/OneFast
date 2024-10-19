if (typeof (STMListings) == 'undefined') {
    var STMListings = {};
}

(function ($) {
    "use strict";

    function Filter(form) {
        this.form = form;
        this.ajax_action = ($(this.form).data('action')) ? $(this.form).data('action') : 'listings-result';
        this.init();
    }

    Filter.prototype.init = function () {
        $(this.form).on("submit", $.proxy(this.submit, this));
        this.getTarget().on('click', 'a.page-numbers', $.proxy(this.paginationClick, this));
    };

	Filter.prototype.getFormParams = function () {
		let url = new URL( $( this.form ).attr( 'action' ) );

		$.each(
			$( this.form ).serializeArray(),
			function (i, field) {
				if ( field.value !== '' ) {
					if ( ['stm_lat', 'stm_lng'].includes( field.name ) ) {
						if ( field.value !== 0 ) {
							url.searchParams.set( field.name, field.value );
						}
					} else {
						url.searchParams.set( field.name, field.value );
					}
				}
			}
		);

		return url;
	};

    Filter.prototype.submit = function (event) {
		event.preventDefault();

		if ( typeof stm_elementor_editor_mode === "undefined" ) {
			this.performAjax( this.getFormParams() );
		}
	};

    Filter.prototype.paginationClick = function (event) {
        event.preventDefault();
        let url = new URL( $(event.target).closest('a').attr('href') );

        url.searchParams.set('security', stm_security_nonce);
        this.performAjax(url.toString());
    };

    Filter.prototype.pushState = function (url) {
        window.history.pushState('', '', decodeURI(url));
    };

    Filter.prototype.performAjax = function (url) {
        $.ajax({
            url: url,
            dataType: 'json',
            context: this,
            data: 'ajax_action=' + this.ajax_action,
            beforeSend: this.ajaxBefore,
            success: this.ajaxSuccess,
            complete: this.ajaxComplete,
        });
    };

    Filter.prototype.ajaxBefore = function () {
        this.getTarget().addClass('stm-loading');
    };

    Filter.prototype.ajaxSuccess = function (res) {
        if( res.total == 0 || ( typeof items_per_page != 'undefined' && res.total <= items_per_page ) ) {
            $('.stm-inventory-items-per-page-wrap').hide();
        } else {
            $('.stm-inventory-items-per-page-wrap').show();
        }

        this.getTarget().html(res.html);
        this.disableOptions(res);
        if (res.url) {
            this.pushState(res.url);
        }
    };

    Filter.prototype.ajaxComplete = function () {
        this.getTarget().removeClass('stm-loading');

        $('.car-title').each(function () {
			let $title  = $( this ),
				maxChar = parseInt( $title.attr( 'data-max-char' ) ),
				$labels = $title.find( '.labels' );

            if ($labels.length > 0 && ($(this).text().length > maxChar)) {
                let originalLabels = $labels.clone();
                $labels.remove();
                let originalText = $title.contents().filter(function () {
                    return this.nodeType === 3;
                }).text().trim();

                if (originalText.length > maxChar) {
                    var truncatedText = originalText.substr(0, maxChar) + '...';

                    $title.html('').append(originalLabels).append(truncatedText);
                } else {
                    $title.html(originalText).prepend($labels)
                }
            } else {
                if ($(this).attr('data-max-char') != 'undefined' && $(this).text().length > $(this).attr('data-max-char')) {
                    $(this).text($(this).text().trim().substr(0, $(this).attr('data-max-char')) + '...');
                }
            }
        });

        // hoverable interactive gallery preview swiper
        this.reInitSwipeEvents();
    };

    Filter.prototype.disableOptions = function (res) {
        if (typeof res.options != 'undefined') {
            $.each(res.options, function (key, options) {
                $('select[name=' + key + '] > option', this.form).each(function () {
                    var slug = $(this).val();
                    if (options.hasOwnProperty(slug)) {
                        $(this).prop('disabled', options[slug].disabled);
                    }
                });
            });
        }
    };

    Filter.prototype.getTarget = function () {
        var target = $(this.form).data('target');
        if (!target) {
            target = '#listings-result';
        }
        return $(target);
    };

    Filter.prototype.reInitSwipeEvents = function () {
        if ($('.stm-hoverable-interactive-galleries .interactive-hoverable .hoverable-wrap').length > 0) {
            $('.stm-hoverable-interactive-galleries .interactive-hoverable .hoverable-wrap').each((index, el) => {
                let galleryPreviewSwiper = new SwipeEvent(el);

                galleryPreviewSwiper.onRight(function () {
                    let active_index = $(this.element).find('.hoverable-unit.active').index();
                    $(this.element).find('.hoverable-unit').removeClass('active');
                    $(this.element).siblings('.hoverable-indicators').find('.indicator.active').removeClass('active');
                    if (active_index === 0) {
                        $(this.element).find('.hoverable-unit:last-child').addClass('active');
                        $(this.element).siblings('.hoverable-indicators').find('.indicator:last-child').addClass('active');
                    } else {
                        $(this.element).find('.hoverable-unit').eq(active_index - 1).addClass('active');
                        $(this.element).siblings('.hoverable-indicators').find('.indicator').eq(active_index - 1).addClass('active');
                    }
                });

                galleryPreviewSwiper.onLeft(function () {
                    let active_index = $(this.element).find('.hoverable-unit.active').index();
                    let total_items = $(this.element).find('.hoverable-unit');
                    $(this.element).find('.hoverable-unit').removeClass('active');
                    $(this.element).siblings('.hoverable-indicators').find('.indicator.active').removeClass('active');
                    if (active_index === parseInt(total_items.length - 1)) {
                        $(this.element).find('.hoverable-unit:first-child').addClass('active');
                        $(this.element).siblings('.hoverable-indicators').find('.indicator:first-child').addClass('active');
                    } else {
                        $(this.element).find('.hoverable-unit').eq(active_index + 1).addClass('active');
                        $(this.element).siblings('.hoverable-indicators').find('.indicator').eq(active_index + 1).addClass('active');
                    }
                });

                galleryPreviewSwiper.run();
            });
        }
    };

    STMListings.Filter = Filter;

    $(function () {
			
        $('form[data-trigger=filter]').each(function () {
            $(this).data('Filter', new Filter(this));
        });

        $('.car-title').each(function () {
            var $title = $(this);
            var maxChar = parseInt($title.attr('data-max-char'));
            var $labels = $title.find('.labels');

            if ($labels.length > 0 && $(this).text().length > maxChar) {
                var originalLabels = $labels.clone();
                $labels.remove();
                var originalText = $title.contents().filter(function () {
                    return this.nodeType === 3;
                }).text().trim();

                if (originalText.length > maxChar) {
                    var truncatedText = originalText.substr(0, maxChar) + '...';
                    $title.html('').append(originalLabels).append(truncatedText);
                } else {
                    $title.html(originalText).prepend($labels)
                }
            } else {
                if ($(this).attr('data-max-char') != 'undefined' && $(this).text().length > $(this).attr('data-max-char')) {
                    $(this).text($(this).text().trim().substr(0, $(this).attr('data-max-char')) + '...');
                }
            }
        });
    });

	// swipe events using vanilla js
	var  SwipeEvent  = (function () {
		function  SwipeEvent(element) {
			this.xDown  =  null;
			this.yDown  =  null;
			this.element  =  typeof (element) === 'string' ? document.querySelector(element) : element;
			this.element.addEventListener('touchstart', function (evt) {
				this.xDown  =  evt.touches[0].clientX;
				this.yDown  =  evt.touches[0].clientY;
			}.bind(this), false);
		}

		SwipeEvent.prototype.onLeft  =  function (callback) {
			this.onLeft  =  callback;
			return this;
		};
		SwipeEvent.prototype.onRight  =  function (callback) {
			this.onRight  =  callback;
			return this;
		};
		SwipeEvent.prototype.onUp  =  function (callback) {
			this.onUp  =  callback;
			return this;
		};
		SwipeEvent.prototype.onDown  =  function (callback) {
			this.onDown  =  callback;
			return this;
		};

		SwipeEvent.prototype.handleTouchMove  =  function (evt) {
			if (!this.xDown  ||  !this.yDown) {
				return;
			}
			var  xUp  =  evt.touches[0].clientX;
			var  yUp  =  evt.touches[0].clientY;
			this.xDiff  = this.xDown  -  xUp;
			this.yDiff  = this.yDown  -  yUp;

			if (Math.abs(this.xDiff) !==  0) {
				if (this.xDiff  >  2) {
					typeof (this.onLeft) ===  "function"  && this.onLeft();
				} else  if (this.xDiff  <  -2) {
					typeof (this.onRight) ===  "function"  && this.onRight();
				}
			}

			if (Math.abs(this.yDiff) !==  0) {
				if (this.yDiff  >  2) {
					typeof (this.onUp) ===  "function"  && this.onUp();
				} else  if (this.yDiff  <  -2) {
					typeof (this.onDown) ===  "function"  && this.onDown();
				}
			}
			// Reset values.
			this.xDown  =  null;
			this.yDown  =  null;
		};

		SwipeEvent.prototype.run  =  function () {
			this.element.addEventListener('touchmove', function (evt) {
				this.handleTouchMove(evt);
			}.bind(this), false);
		};

		return  SwipeEvent;
	}());

	STMListings.clean_select_child_if_parent_changed = function( changed_item ) {
		let list = $('#stm_parent_slug_list');
		if ( 0 === list.length ) {
			return;
		}
		let stm_parent_slug_list = list.attr('data-value');
		let name                 = changed_item.attr('name');
		if ( $( changed_item ).length && name && name.length > 0 ) {
			let name = changed_item.attr('name').replace(/[\[\]']+/g,'');
			
			if ( stm_parent_slug_list.split(',').includes( name ) ) {
				var child_select = $('.filter-select option[data-parent="' + name + '"]').parent();
				child_select.val('');
			}
		}
	}

	STMListings.stm_disable_rest_filters = function ($_this, action, tabs_filter) {
		var $_form = $_this.closest( 'form' );
		
		var data = [],
				url  = $_form.attr( 'action' ),
				sign = url.indexOf( '?' ) < 0 ? '?' : '&';
		
		$.each(
				$_form.serializeArray(),
				function (i, field) {
					if (field.value != '') {
						data.push( field.name + '=' + field.value )
					}
				}
		);
		
		url = url + sign + data.join( '&' );
		
		$.ajax(
				{
					url: url,
					dataType: 'json',
					context: this,
					data: '&ajax_action=' + action + '&security=' + stm_security_nonce,
					beforeSend: function () {
						if (action == 'listings-items') {
							$( '.stm-ajax-row' ).addClass( 'stm-loading' );
						} else {
							$( '.classic-filter-row .filter-sidebar .select2-container--default .select2-selection--single .select2-selection__arrow b' ).addClass( 'stm-preloader' );
							$( '.mobile-search-filter .filter-sidebar .select2-container--default .select2-selection--single .select2-selection__arrow b' ).addClass( 'stm-preloader' );
							$( '.mobile-search-filter .filter-sidebar .select2-container--default .selection' ).addClass( 'stm-overlay' );
							$( '.search-filter-form .filter-sidebar .select2-container--default .selection' ).addClass( 'stm-overlay' );
							$( '.stm-listing-directory-total-matches' ).hide();
						}
					},
					success: function (res) {
						if (action == 'listings-items') {
							$( '.stm-ajax-row' ).removeClass( 'stm-loading' );
							$( '#listings-result' ).html( res.html );
							if( res.total == 0 || ( typeof items_per_page != 'undefined' && res.total <= items_per_page ) ) {
							    $('.stm-inventory-items-per-page-wrap').hide();
                            }
							$( "img.lazy" ).lazyload();
							$( '.stm-tooltip-link, div[data-toggle="tooltip"]' ).tooltip();
							window.history.pushState( '', '', decodeURI( url ) );
						} else {
							/*Remove select preloaders*/
							$( '.classic-filter-row .filter-sidebar .select2-container--default .select2-selection--single .select2-selection__arrow b' ).removeClass( 'stm-preloader' );
							$( '.classic-filter-row .filter-sidebar select' ).prop( "disabled", false );
							/*Disable options*/
							if (typeof res.options != 'undefined') {
								$.each(
										res.options,
										function (key, options) {
											$( 'select[name=' + key + '] > option', $_form ).each(
													function () {
														var slug = $( this ).val();
														if (options.hasOwnProperty( slug )) {
															$( this ).prop( 'disabled', options[slug].disabled );
														}
													}
											);
										}
								);
							}

							if( !tabs_filter ) {
								$( 'select', $_form ).select2( 'destroy' );
								$( 'select', $_form ).select2(
									{
										dropdownParent: $( 'body' ),
									}
								);
							}
							
							/*Change total*/
							$( '.stm-horizontal-filter-sidebar #stm-classic-filter-submit span' ).text( res.total );
							$( '.search-filter-form #show-car-btn-mobile span' ).text( res.total );
							$( '.mobile-search-filter #show-car-btn-mobile span' ).text( res.total );
							$( '.filter-listing.motors_dynamic_listing_filter .stm-filter-tab-selects .search-submit span' ).text( res.total );

							$( '.stm-listing-directory-total-matches' ).show();
						}
					}
				}
		);
	};
	
	$( document ).on(
			'change',
			'.archive-listing-page form input, .archive-listing-page form select',
			function () {
				if ( typeof STMListings.clean_select_child_if_parent_changed === "function" ) {
					STMListings.clean_select_child_if_parent_changed( $( this ) );
				}
				STMListings.stm_disable_rest_filters( $( this ), 'listings-binding' );
			}
	);

	$( '.filter-listing select:not(.hide)' ).select2().on(
		'select2:select',
		function ( event ) {
			STMListings.stm_disable_rest_filters( $( this ), 'listings-binding', true );
		}
	);
	
	$( document ).on(
			'click',
			'.stm-ajax-checkbox-button .button, .stm-ajax-checkbox-instant .stm-option-label input',
			function (e) {
				
				if ($( this )[0].className == 'button') {
					e.preventDefault();
				}
				
				$( this ).closest( 'form' ).trigger( 'submit' );
				
			}
	);
})(jQuery);