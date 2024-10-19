<?php
$stm_title_user = apply_filters( 'motors_vl_get_nuxy_mod', '', 'addl_reg_log_title' );
$stm_text_user  = apply_filters( 'motors_vl_get_nuxy_mod', '', 'addl_reg_log_desc' );
$_link          = apply_filters( 'motors_vl_get_nuxy_mod', '', 'addl_reg_log_link' );

?>
<div class="stm-user-registration-unit">
	<div class="clearfix stm_register_title">
		<h3><?php esc_html_e( 'Sign Up', 'motors-car-dealership-classified-listings-pro' ); ?></h3>
		<div class="stm_login_me"><?php esc_html_e( 'Already Registered? Members', 'motors-car-dealership-classified-listings-pro' ); ?>
			<a href="#"><?php esc_html_e( 'Login Here', 'motors-car-dealership-classified-listings-pro' ); ?></a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3 col-sm-3 col-md-push-9 col-sm-push-9 col-xs-push-0">
			<?php if ( apply_filters( 'stm_is_listing', false ) && defined( 'WORDPRESS_SOCIAL_LOGIN_ABS_PATH' ) ) : ?>
				<div class="stm-social-login-wrap">
					<?php do_action( 'wordpress_social_login' ); ?>
				</div>
			<?php endif; ?>
			<div class="heading-font stm-title"><?php echo esc_html( $stm_title_user ); ?></div>
			<div class="stm-text"><?php echo esc_html( $stm_text_user ); ?></div>
		</div>

		<div class="col-md-9 col-sm-9 col-md-pull-3 col-sm-pull-3 col-xs-pull-0">
			<div class="stm-login-register-form">
				<div class="stm-register-form">
					<form id="add-car-register-form" method="post">
						<input type="hidden" name="redirect" value="disable">

						<div class="row form-group">
							<div class="col-md-6">
								<h4><?php esc_html_e( 'First Name', 'motors-car-dealership-classified-listings-pro' ); ?></h4>
								<input class="user_validated_field" type="text" name="stm_user_first_name" placeholder="<?php esc_attr_e( 'Enter First name', 'motors-car-dealership-classified-listings-pro' ); ?>"/>
							</div>
							<div class="col-md-6">
								<h4><?php esc_html_e( 'Last Name', 'motors-car-dealership-classified-listings-pro' ); ?></h4>
								<input class="user_validated_field" type="text" name="stm_user_last_name" placeholder="<?php esc_attr_e( 'Enter Last name', 'motors-car-dealership-classified-listings-pro' ); ?>"/>
							</div>
						</div>

						<div class="row form-group">
							<div class="col-md-6">
								<h4><?php esc_html_e( 'Phone number', 'motors-car-dealership-classified-listings-pro' ); ?></h4>
								<input class="user_validated_field" type="tel" name="stm_user_phone" placeholder="<?php esc_attr_e( 'Enter Phone', 'motors-car-dealership-classified-listings-pro' ); ?>"/>
								<label for="whatsapp-checker">
									<input type="checkbox" name="stm_whatsapp_number" id="whatsapp-checker"/>
									<span><small
												class="text-muted"><?php esc_html_e( 'I have a WhatsApp account with this number', 'motors-car-dealership-classified-listings-pro' ); ?></small></span>
								</label>
							</div>
							<div class="col-md-6">
								<h4><?php esc_html_e( 'Email *', 'motors-car-dealership-classified-listings-pro' ); ?></h4>
								<input class="user_validated_field" type="email" name="stm_user_mail" placeholder="<?php esc_attr_e( 'Enter E-mail', 'motors-car-dealership-classified-listings-pro' ); ?>"/>
							</div>
						</div>

						<div class="row form-group">
							<div class="col-md-6">
								<h4><?php esc_html_e( 'Login *', 'motors-car-dealership-classified-listings-pro' ); ?></h4>
								<input class="user_validated_field" type="text" name="stm_nickname" placeholder="<?php esc_attr_e( 'Enter Login', 'motors-car-dealership-classified-listings-pro' ); ?>"/>
							</div>
							<div class="col-md-6">
								<h4><?php esc_html_e( 'Password *', 'motors-car-dealership-classified-listings-pro' ); ?></h4>
								<div class="stm-show-password">
									<i class="fas fa-eye-slash"></i>
									<input class="user_validated_field" type="password" name="stm_user_password" placeholder="<?php esc_attr_e( 'Enter Password', 'motors-car-dealership-classified-listings-pro' ); ?>"/>
								</div>
							</div>
						</div>

						<div class="form-group form-checker">
							<label>
								<input type="checkbox" name="stm_accept_terms"/>
								<span>
								<?php esc_html_e( 'I accept the terms of the', 'motors-car-dealership-classified-listings-pro' ); ?>
									<?php
									if ( ! empty( $_link ) ) :
										?>
										<a href="<?php echo get_the_permalink($_link); ?>" target="_blank"><?php echo get_the_title($_link); ?></a><?php //phpcs:ignore?>
									<?php endif; ?>
							</span>
							</label>
						</div>

						<div class="form-group form-group-submit">
							<?php
							$recaptcha_enabled    = apply_filters( 'motors_vl_get_nuxy_mod', 0, 'enable_recaptcha' );
							$recaptcha_public_key = apply_filters( 'motors_vl_get_nuxy_mod', '', 'recaptcha_public_key' );
							$recaptcha_secret_key = apply_filters( 'motors_vl_get_nuxy_mod', '', 'recaptcha_secret_key' );

							if ( ! empty( $recaptcha_enabled ) && $recaptcha_enabled && ! empty( $recaptcha_public_key ) && ! empty( $recaptcha_secret_key ) ) :
								//// phpcs:disable
								?>
								<script type="text/javascript" src="https://www.google.com/recaptcha/api.js"></script>
								<script type="text/javascript">
                                    function onSubmitACRegister() {
                                        var form = jQuery('#add-car-register-form');

										jQuery.ajax({
                                            type: "POST",
                                            url: ajaxurl,
                                            dataType: 'json',
                                            context: this,
                                            data: form.serialize() + '&action=stm_custom_register',
                                            beforeSend: function () {
                                                form.find('input').removeClass('form-error');
                                                form.find('.stm-listing-loader').addClass('visible');
												jQuery('.stm-validation-message').empty();
                                            },
                                            success: function (data) {
                                                if (data.user_html) {
                                                    var $user_html = jQuery(data.user_html).appendTo('#stm_user_info');
													jQuery('.stm-not-disabled, .stm-not-enabled').slideUp('fast', function () {
														jQuery('#stm_user_info').slideDown('fast');
                                                    });
													jQuery("html, body").animate({scrollTop: jQuery('.stm-form-checking-user').offset().top}, "slow");

													jQuery('.stm-form-checking-user button[type="submit"]').removeClass('disabled').addClass('enabled');

                                                    if (data.plans_select && $('#user_plans_select_wrap').length > 0) {
														jQuery('#user_plans_select_wrap').html(data.plans_select);
														jQuery('#user_plans_select_wrap select').select2();
                                                    }

                                                }

                                                if (data.restricted && data.restricted) {
													jQuery('.btn-add-edit').remove();
                                                }

                                                form.find('.stm-listing-loader').removeClass('visible');
                                                for (var err in data.errors) {
                                                    form.find('input[name=' + err + ']').addClass('form-error');
                                                }

                                                if (data.redirect_url) {
                                                    window.location = data.redirect_url;
                                                }

                                                if (data.message) {
                                                    var message = jQuery('<div class="stm-message-ajax-validation heading-font">' + data.message + '</div>').hide();

                                                    form.find('.stm-validation-message').append(message);
                                                    message.slideDown('fast');
                                                }
                                            }
                                        });
                                    }
								</script>
								<?php // phpcs:enable?>
							<input class="g-recaptcha heading-font" data-sitekey="<?php echo esc_attr( $recaptcha_public_key ); ?>" data-callback='onSubmitACRegister' type="submit" value="<?php esc_html_e( 'Sign up now!', 'motors-car-dealership-classified-listings-pro' ); ?>" disabled/>
							<?php else : ?>
							<input class="heading-font" type="submit" value="<?php esc_html_e( 'Sign up now!', 'motors-car-dealership-classified-listings-pro' ); ?>" disabled/>
							<?php endif; ?>
							<span class="stm-listing-loader"><i class="motors-icons-load1"></i></span>
						</div>

						<div class="stm-validation-message"></div>

					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php // phpcs:disable ?>
<script type="text/javascript">
    jQuery(document).ready(function () {
        var $ = jQuery;
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
    });
</script>
<?php // phpcs:enable ?>
