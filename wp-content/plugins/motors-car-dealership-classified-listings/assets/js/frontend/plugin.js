(function($) {
	;('use strict')

	$(document).ready(function () {
		stm_ajax_add_test_drive()
		stm_ajax_add_trade_offer()

		let date_time_picker = $('.stm-date-timepicker')

		if (typeof $.datetimepicker === 'object' && date_time_picker.length) {
			date_time_picker.datetimepicker({
				timepicker: false,
				format: 'd/m/Y',
				lang: stm_lang_code,
				closeOnDateSelect: true,
			})
		}

		$('body').on('click', '.stm-show-number', function () {
			var parent = $(this).parent()
			var phone_owner_id = $(this).attr('data-id')
			var listing_id = $(this).attr('data-listing-id')

			if (typeof listing_id === 'undefined' || listing_id === false) {
				listing_id = '0'
			}

			parent.find('.stm-show-number').text('').addClass('load_number')
			$.ajax({
				url: ajaxurl,
				type: 'GET',
				dataType: 'json',
				context: this,
				data:
					'phone_owner_id=' +
					phone_owner_id +
					'&listing_id=' +
					listing_id +
					'&action=stm_ajax_get_seller_phone&security=' +
					stm_security_nonce,
				success: function (data) {
					parent.find('.stm-show-number').hide()
					parent
						.find('.phone')
						.html('<a href="tel:' + data + '">' + data + '</a>')
				},
			})
		})
	})

	$(document).ready(function () {
		let stm_cookies = $.cookie(),
			stm_car_compare = [],
			post_type = ''

		for (var key in stm_cookies) {
			if (stm_cookies.hasOwnProperty(key)) {
				if (key.indexOf(cc_prefix + post_type) > -1) {
					stm_car_compare.push(stm_cookies[key])
				}
			}
		}

		$('.car-action-unit.add-to-compare').each(function () {
			let $this = $(this),
				stm_car_add_to = $this.data('id')

			if ($.inArray(stm_car_add_to.toString(), stm_car_compare) !== -1) {
				$this.addClass('active')
				$this.addClass('stm-added')

				let compareHtml =
					'<i class="motors-icons-added stm-unhover"></i>\n' +
					'<span class="stm-unhover">' +
					stm_i18n.stm_label_in_compare +
					'</span>\n' +
					'<div class="stm-show-on-hover">\n' +
					'<i class="motors-icons-remove"></i>\n' +
					stm_i18n.stm_label_remove_list +
					'</div>'

				if (
					typeof stm_i18n.stm_label_remove !== 'undefined' &&
					$this.data('view') !== 'grid'
				) {
					$this.html(compareHtml)
					$this.attr('title', stm_i18n.stm_label_remove)
				}
				if ($this.data('view') === 'grid') {
					$this
						.find('i')
						.removeClass('motors-icons-remove, motors-icons-add')
						.addClass('motors-icons-added')
				}
			}
		})
	})

	$('.stm-gallery-action-unit.compare').each(function () {
		let $this = $(this),
			stm_car_add_to = $this.data('id'),
			post_type = $this.data('post-type'),
			stm_cookies = $.cookie(),
			stm_car_compare = []

		for (var key in stm_cookies) {
			if (stm_cookies.hasOwnProperty(key)) {
				if (key.indexOf(cc_prefix + post_type) > -1) {
					stm_car_compare.push(stm_cookies[key])
				}
			}
		}

		if ($.inArray(stm_car_add_to.toString(), stm_car_compare) !== -1) {
			$this.addClass('active')
			$this.addClass('stm-added')
		}
	})

	$(document).on('click', '.stm-gallery-action-unit.compare', function (e) {
		e.preventDefault()
		let $this = $(this),
			stm_cookies = $.cookie(),
			stm_car_compare = [],
			stm_car_add_to = $this.data('id'),
			post_type = $this.data('post-type'),
			car_title = $this.data('title')

		for (var key in stm_cookies) {
			if (stm_cookies.hasOwnProperty(key)) {
				if (key.indexOf(cc_prefix + post_type) > -1) {
					stm_car_compare.push(stm_cookies[key])
				}
			}
		}

		let stm_compare_cars_counter = stm_car_compare.length

		$.cookie.raw = true
		if ($.inArray(stm_car_add_to.toString(), stm_car_compare) === -1) {
			if (stm_car_compare.length < 3) {
				$.cookie(
					cc_prefix + post_type + '[' + stm_car_add_to + ']',
					stm_car_add_to,
					{ expires: 7, path: '/' }
				)
				stm_compare_cars_counter++

				let $compareButton = $(
					'.add-to-compare[data-id="' + stm_car_add_to + '"]'
				)
				if (!$compareButton.hasClass('active')) {
					$compareButton.addClass('active')
					$compareButton.addClass('stm-added')

					let compareHtml =
						'<i class="motors-icons-added stm-unhover"></i>\n' +
						'<span class="stm-unhover">' +
						stm_i18n.stm_label_in_compare +
						'</span>\n' +
						'<div class="stm-show-on-hover">\n' +
						'<i class="motors-icons-remove"></i>\n' +
						stm_i18n.stm_label_remove_list +
						'</div>'

					$compareButton.html(compareHtml)
					$compareButton.attr('title', stm_i18n.stm_label_remove)
				}

				$this.addClass('active')

				showCompareNotification('added', car_title)
			} else {
				showCompareNotification('filled', '', post_type)
			}
		} else {
			$.removeCookie(cc_prefix + post_type + '[' + stm_car_add_to + ']', {
				path: '/',
			})
			$this.removeClass('active')
			stm_compare_cars_counter--

			let $compareButton = $(
				'.add-to-compare[data-id="' + stm_car_add_to + '"]'
			)
			if ($compareButton.hasClass('active')) {
				$compareButton.removeClass('active')
				$compareButton.removeClass('stm-added')
				$compareButton.find('.stm-show-on-hover').remove()

				let addCompareHtml =
					'<i class="motors-icons-add"></i>\n' +
					'<span>' +
					stm_i18n.stm_label_add +
					'</span>'

				$compareButton.html(addCompareHtml)
				$compareButton.attr('title', stm_i18n.stm_label_add)
			}

			showCompareNotification('removed', car_title)
		}
	})

	$(document).on('click', '.add-to-compare', function (e) {
		e.preventDefault()
		let $this = $(this),
			stm_cookies = $.cookie(),
			stm_car_compare = [],
			stm_car_add_to = $this.data('id'),
			post_type = $this.data('post-type'),
			car_title = $this.data('title'),
			view = $this.data('view')

		for (var key in stm_cookies) {
			if (stm_cookies.hasOwnProperty(key)) {
				if (key.indexOf(cc_prefix + post_type) > -1) {
					stm_car_compare.push(stm_cookies[key])
				}
			}
		}

		let stm_compare_cars_counter = stm_car_compare.length

		$.cookie.raw = true
		if ($.inArray(stm_car_add_to.toString(), stm_car_compare) === -1) {
			if (stm_car_compare.length < 3) {
				$.cookie(
					cc_prefix + post_type + '[' + stm_car_add_to + ']',
					stm_car_add_to,
					{ expires: 7, path: '/' }
				)
				stm_compare_cars_counter++

				$('.stm-gallery-action-unit.compare').addClass('active')

				$this.addClass('active')
				$this.addClass('stm-added')

				let compareHtml =
					'<i class="motors-icons-added stm-unhover"></i>\n' +
					'<span class="stm-unhover">' +
					stm_i18n.stm_label_in_compare +
					'</span>\n' +
					'<div class="stm-show-on-hover">\n' +
					'<i class="motors-icons-remove"></i>\n' +
					stm_i18n.stm_label_remove_list +
					'</div>'

				if (
					typeof stm_i18n.stm_label_remove !== 'undefined' &&
					'grid' !== view
				) {
					$this.html(compareHtml)
					$this.attr('title', stm_i18n.stm_label_remove)
				}
				if ('grid' === view) {
					$this
						.find('i')
						.removeClass('motors-icons-remove, motors-icons-add')
						.addClass('motors-icons-added')
				}

				showCompareNotification('added', car_title)
			} else {
				// Already added 3 popup
				showCompareNotification('filled', '', post_type)
			}
		} else {
			$.removeCookie(cc_prefix + post_type + '[' + stm_car_add_to + ']', {
				path: '/',
			})
			$this.removeClass('active')
			$this.removeClass('stm-added')
			$this.find('.stm-show-on-hover').remove()
			stm_compare_cars_counter--

			$this.removeClass('active')

			if ($('.add-to-compare.active').length !== 0) {
				$('.stm-gallery-action-unit.compare').removeClass('active')
			}

			if (typeof stm_i18n.stm_label_add !== 'undefined') {
				$this
					.find('i')
					.removeClass('motors-icons-remove, motors-icons-added')
					.addClass('motors-icons-add')
				$this
					.find('span')
					.removeClass('stm-unhover')
					.html(stm_i18n.stm_label_add)
				$this.attr('title', stm_i18n.stm_label_add)
			}

			if ($this.hasClass('stm_remove_after')) {
				window.location.reload()
			}

			if ($this.hasClass('remove-from-compare')) {
				$('.car-listing-row .compare-col-stm-' + stm_car_add_to).hide(
					'slide',
					{ direction: 'left' },
					function () {
						$('.car-listing-row .compare-col-stm-' + stm_car_add_to).remove()
						$('.car-listing-row').append($('.compare-empty-car-top').html())
					}
				)

				$('.stm-compare-row .compare-col-stm-' + stm_car_add_to).hide(
					'slide',
					{ direction: 'left' },
					function () {
						$('.stm-compare-row .compare-col-stm-' + stm_car_add_to).remove()
						$('.stm-compare-row').append($('.compare-empty-car-bottom').html())
					}
				)

				$('.row-compare-features .compare-col-stm-' + stm_car_add_to).hide(
					'slide',
					{ direction: 'left' },
					function () {
						$(
							'.row-compare-features .compare-col-stm-' + stm_car_add_to
						).remove()
						if ($('.row-compare-features .col-md-3').length < 2) {
							$('.row-compare-features').slideUp()
						}
					}
				)
			} else {
				showCompareNotification('removed', car_title)
			}
		}
	})

	$(document).on('click', '.compare-remove-all', remove_all_compare)

	function showCompareNotification($status, $title, $post_type) {
		if ('filled' === $status) {
			$('.single-add-to-compare .stm-title').text(
				stm_already_added_to_compare_text
			)
			$('.single-add-to-compare').addClass('single-add-to-compare-visible')
			setTimeout(function () {
				$('.single-add-to-compare').removeClass('single-add-to-compare-visible')
				$('.single-add-to-compare').removeClass('overadded')
				$('.compare-remove-all').remove()
			}, 5000)
			$('.single-add-to-compare').addClass('overadded')
			$('.compare-remove-all').remove()
			$('.single-add-to-compare .compare-fixed-link').before(
				'<a href="#" style="margin-left: 15px;" data-post-type=' +
					$post_type +
					' class="compare-fixed-link compare-remove-all pull-right heading-font">' +
					reset_all_txt +
					'</a>'
			)
		}
		if ('added' === $status) {
			$('.single-add-to-compare .stm-title').text(
				$title + ' - ' + stm_added_to_compare_text
			)
			$('.single-add-to-compare').addClass('single-add-to-compare-visible')
			setTimeout(function () {
				$('.single-add-to-compare').removeClass('single-add-to-compare-visible')
			}, 5000)
		}
		if ('removed' === $status) {
			$('.single-add-to-compare .stm-title').text(
				$title + ' ' + stm_removed_from_compare_text
			)
			$('.single-add-to-compare').addClass('single-add-to-compare-visible')
			setTimeout(function () {
				$('.single-add-to-compare').removeClass('single-add-to-compare-visible')
			}, 5000)
			$('.single-add-to-compare').removeClass('overadded')
			$('.compare-remove-all').remove()
		}
	}

	function remove_all_compare(e) {
		e.preventDefault()

		var post_type = $(this).data('post-type')
		var ids = {}
		if (typeof compare_init_object !== 'undefined') {
			ids = compare_init_object
		}

		if (typeof post_type !== 'undefined') {
			$.each(ids[post_type], function (i, id) {
				$.removeCookie(cc_prefix + post_type + '[' + id + ']', { path: '/' })
			})

			location.reload()
		}
	}

	function stm_ajax_add_test_drive() {
		$('#test-drive form').on('submit', function (event) {
			event.preventDefault()
			$.ajax({
				url: ajaxurl,
				type: 'POST',
				dataType: 'json',
				context: this,
				data:
					$(this).serialize() +
					'&action=stm_ajax_add_test_drive&security=' +
					stm_add_test_drive_nonce,
				beforeSend: function () {
					$('.alert-modal').remove()
					$(this).closest('form').find('input').removeClass('form-error')
					$(this).closest('form').find('.stm-ajax-loader').addClass('loading')
				},
				success: function (data) {
					$(this)
						.closest('form')
						.find('.stm-ajax-loader')
						.removeClass('loading')
					$(this)
						.closest('form')
						.find('.modal-body-message')
						.append(
							'<div class="alert-modal alert alert-' +
								data.status +
								'">' +
								data.response +
								'</div>'
						)
					for (var key in data.errors) {
						$('#request-test-drive-form input[name="' + key + '"]').addClass(
							'form-error'
						)
					}
				},
			})
			$(this)
				.closest('form')
				.find('.form-error')
				.on('hover', function () {
					$(this).removeClass('form-error')
				})
		})
	}

	function stm_ajax_add_trade_offer() {
		$('#trade-offer form').on('submit', function (event) {
			event.preventDefault()
			$.ajax({
				url: ajaxurl,
				type: 'POST',
				dataType: 'json',
				context: this,
				data:
					$(this).serialize() +
					'&action=stm_ajax_add_trade_offer&security=' +
					stm_security_nonce,
				beforeSend: function () {
					$('.alert-modal').remove()
					$(this).closest('form').find('input').removeClass('form-error')
					$(this).closest('form').find('.stm-ajax-loader').addClass('loading')
				},
				success: function (data) {
					$(this)
						.closest('form')
						.find('.stm-ajax-loader')
						.removeClass('loading')
					$(this)
						.closest('form')
						.find('.modal-body')
						.append(
							'<div class="alert-modal alert alert-' +
								data.status +
								'">' +
								data.response +
								'</div>'
						)
					for (var key in data.errors) {
						$('#request-trade-offer-form input[name="' + key + '"]').addClass(
							'form-error'
						)
					}
				},
			})
			$(this)
				.closest('form')
				.find('.form-error')
				.on('hover', function () {
					$(this).removeClass('form-error')
				})
		})
	}

	function stm_test_drive_car_title(id, title) {
		var $ = jQuery

		$('.test-drive-car-name').text(title)
		$('input[name=vehicle_id]').val(id)
		$('input[name=vehicle_name]').val(title)
		$('.modal-body-fields').removeClass('hidden')
		$('#request-test-drive-form').find('.alert-modal').remove()
		$('#request-test-drive-form').find('.form-error').removeClass('form-error')
	}
})(jQuery)

function updateGridItemTitles() {
    var $ = jQuery;

    $('.car-title').each(function () {
        var $title = $(this);
        var maxChar = parseInt($title.attr('data-max-char'));
        var $labels = $title.find('.labels');

        if ($labels.length > 0 && ($(this).text().length > maxChar)) {
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
}