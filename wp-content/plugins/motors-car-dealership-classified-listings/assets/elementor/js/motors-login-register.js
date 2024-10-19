function onSubmitPageRegister(token) {
	let $ = jQuery
	var form = $('#page-register-form');
	$.ajax({
		type: "POST",
		url: ajaxurl,
		dataType: 'json',
		context: this,
		data: form.serialize() + '&action=stm_custom_register',
		beforeSend: function () {
			form.find('input').removeClass('form-error');
			form.find('.stm-listing-loader').addClass('visible');
			$('.stm-validation-message').empty();
		},
		success: function (data) {
			if (data.user_html) {
				$('#stm_user_info').append(data.user_html);

				$('.stm-not-disabled, .stm-not-enabled').slideUp('fast', function () {
					$('#stm_user_info').slideDown('fast');
				});
				$("html, body").animate({scrollTop: $('.stm-form-checking-user').offset().top}, "slow");

				$('.stm-form-checking-user button[type="submit"]').removeClass('disabled').addClass('enabled');
			}

			if (data.restricted && data.restricted) {
				$('.btn-add-edit').remove();
			}

			form.find('.stm-listing-loader').removeClass('visible');
			for (var err in data.errors) {
				form.find('input[name=' + err + ']').addClass('form-error');
			}

			// insert plans select
			if (data.plans_select && $('#user_plans_select_wrap').length > 0) {
				$('#user_plans_select_wrap').html(data.plans_select);
				$('#user_plans_select_wrap select').select2();
			}

			if (data.redirect_url) {
				window.location = data.redirect_url;
			}

			if (data.message) {
				var message = $('<div class="stm-message-ajax-validation heading-font">' + data.message + '</div>').hide();

				form.find('.stm-validation-message').append(message);
				message.slideDown('fast');
			}
		}
	});
}

jQuery(document).ready(function ($) {

	$('.stm-show-password .fas').mousedown(function () {
		$(this).closest('.stm-show-password').find('input').attr('type', 'text');
		$(this).addClass('fa-eye');
		$(this).removeClass('fa-eye-slash');
	});

	$(document).mouseup(function () {
		$('.stm-show-password').find('input').attr('type', 'password');
		$('.stm-show-password .fas').addClass('fa-eye-slash');
		$('.stm-show-password .fas').removeClass('fa-eye');
	});

	$("body").on('touchstart', '.stm-show-password .fas', function () {
		$(this).closest('.stm-show-password').find('input').attr('type', 'text');
		$(this).addClass('fa-eye');
		$(this).removeClass('fa-eye-slash');
	});

	$( '.stm-forgot-password a' ).on(
		'click',
		function (e) {
			e.preventDefault();
			$( '.stm_forgot_password_send' ).slideToggle();
			$( '.stm_forgot_password_send input[type=text]' ).trigger( 'focus' );
			$( this ).toggleClass( 'active' );
		}
	)

	$('input[name="stm_accept_terms"]').on('click', function () {
		if ($(this).is(':checked')) {
			$(
				'.stm-login-register-form .stm-register-form form input[type="submit"]'
			).removeAttr('disabled')
		} else {
			$(
				'.stm-login-register-form .stm-register-form form input[type="submit"]'
			).attr('disabled', '1')
		}
	});
});

