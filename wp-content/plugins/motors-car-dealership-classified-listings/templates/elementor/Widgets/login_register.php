<?php

/**
 * @var $__link_of_terms__
 * @var $__social_login_html__
 */

$can_register = apply_filters( 'motors_vl_get_nuxy_mod', false, 'new_user_registration' );
?>
<div class="stm-login-register-form">
	<?php if ( ! empty( $_GET['user_id'] ) && ! empty( $_GET['hash_check'] ) ) : // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>
		<?php do_action( 'stm_listings_load_template', 'user/private/password-recovery' ); ?>
	<?php endif; ?>

	<div class="row">

		<div class="col-md-4">
			<h3><?php esc_html_e( 'Sign In', 'motors-car-dealership-classified-listings-pro' ); ?></h3>
			<?php if ( apply_filters( 'motors_vl_get_nuxy_mod', false, 'site_demo_mode' ) ) : ?>
				<div style="background: #FFF; padding: 15px; margin-bottom: 15px;">
					<span style="width: 100%;">You can use these credentials for demo testing:</span>

					<div style="display: flex; flex-direction: row; margin-top: 10px;">
					<span style="width: 40%;">
						<b>Dealer:</b><br/>
						dealer<br/>
						dealer
					</span>

						<span style="width: 40%;">
						<b>User:</b><br/>
						demo<br/>
						demo
					</span>
					</div>
				</div>
			<?php endif; ?>
			<div class="stm-login-form">
				<form method="post">
					<?php do_action( 'stm_before_signin_form' ); ?>
					<div class="form-group">
						<h4><?php esc_html_e( 'Login or E-mail', 'motors-car-dealership-classified-listings-pro' ); ?></h4>
						<input type="text" name="stm_user_login"
								placeholder="<?php esc_attr_e( 'Enter login or E-mail', 'motors-car-dealership-classified-listings-pro' ); ?>"/>
					</div>
					<div class="form-group">
						<h4><?php esc_html_e( 'Password', 'motors-car-dealership-classified-listings-pro' ); ?></h4>
						<input type="password" name="stm_user_password"
								placeholder="<?php esc_attr_e( 'Enter password', 'motors-car-dealership-classified-listings-pro' ); ?>"/>
					</div>
					<div class="form-group form-checker">
						<label>
							<input type="checkbox" name="stm_remember_me"/>
							<span><?php esc_html_e( 'Remember me', 'motors-car-dealership-classified-listings-pro' ); ?></span>
						</label>
						<div class="stm-forgot-password">
							<a href="#">
								<?php esc_html_e( 'Forgot Password', 'motors-car-dealership-classified-listings-pro' ); ?>
							</a>
						</div>
					</div>
					<?php if ( class_exists( 'SitePress' ) && defined( 'ICL_LANGUAGE_CODE' ) ) : ?>
						<input type="hidden" name="current_lang"
						value="<?php echo esc_attr( ICL_LANGUAGE_CODE ); ?>"/><?php endif; ?>
					<input class="heading-font" type="submit" value="<?php esc_html_e( 'Login', 'motors-car-dealership-classified-listings-pro' ); ?>"/>
					<span class="stm-listing-loader"><i class="motors-icons-load1"></i></span>
					<div class="stm-validation-message"></div>
					<?php do_action( 'stm_after_signin_form' ); ?>
				</form>
				<form method="post" class="stm_forgot_password_send">
					<div class="form-group">
						<h4><?php esc_html_e( 'Login or E-mail', 'motors-car-dealership-classified-listings-pro' ); ?></h4>
						<input type="hidden" name="stm_link_send_to"
								value="<?php echo esc_attr( get_permalink() ); ?>"
								readonly/>
						<input type="text" name="stm_user_login"
								placeholder="<?php esc_attr_e( 'Enter login or E-mail', 'motors-car-dealership-classified-listings-pro' ); ?>"/>
						<input type="submit"
								value="<?php esc_attr_e( 'Send password', 'motors-car-dealership-classified-listings-pro' ); ?>"/>
						<span class="stm-listing-loader"><i class="motors-icons-load1"></i></span>
						<div class="stm-validation-message"></div>
					</div>
				</form>
			</div>
			<?php if ( boolval( apply_filters( 'is_listing', array() ) ) && defined( 'WORDPRESS_SOCIAL_LOGIN_ABS_PATH' ) && is_user_logged_in() ) : ?>
				<div class="stm-social-login-wrap">
					<?php echo wp_kses_post( $__social_login_html__ ); ?>
				</div>
			<?php elseif ( boolval( apply_filters( 'is_listing', array() ) ) && defined( 'WORDPRESS_SOCIAL_LOGIN_ABS_PATH' ) ) : ?>
				<div class="stm-social-login-wrap">
					<?php do_action( 'wordpress_social_login' ); ?>
				</div>
			<?php endif; ?>
		</div>

		<div class="col-md-8">
			<?php if ( $can_register ) : ?>
			<h3><?php esc_html_e( 'Sign Up', 'motors-car-dealership-classified-listings-pro' ); ?></h3>
			<div class="stm-register-form">
				<form id="page-register-form" method="post">
					<?php do_action( 'stm_before_signup_form' ); ?>
					<div class="row form-group">
						<div class="col-md-6">
							<h4><?php esc_html_e( 'First Name', 'motors-car-dealership-classified-listings-pro' ); ?></h4>
							<input class="user_validated_field" type="text" name="stm_user_first_name"
									placeholder="<?php esc_attr_e( 'Enter First name', 'motors-car-dealership-classified-listings-pro' ); ?>"/>
						</div>
						<div class="col-md-6">
							<h4><?php esc_html_e( 'Last Name', 'motors-car-dealership-classified-listings-pro' ); ?></h4>
							<input class="user_validated_field" type="text" name="stm_user_last_name"
									placeholder="<?php esc_attr_e( 'Enter Last name', 'motors-car-dealership-classified-listings-pro' ); ?>"/>
						</div>
					</div>

					<div class="row form-group">
						<div class="col-md-6">
							<h4><?php esc_html_e( 'Phone number', 'motors-car-dealership-classified-listings-pro' ); ?></h4>
							<input class="user_validated_field" type="tel" name="stm_user_phone"
									placeholder="<?php esc_attr_e( 'Enter Phone', 'motors-car-dealership-classified-listings-pro' ); ?>"/>
							<label for="whatsapp-checker">
								<input type="checkbox" name="stm_whatsapp_number" id="whatsapp-checker"/>
								<span><small
											class="text-muted"><?php esc_html_e( 'I have a WhatsApp account with this number', 'motors-car-dealership-classified-listings-pro' ); ?></small></span>
							</label>
						</div>
						<div class="col-md-6">
							<h4><?php esc_html_e( 'Email *', 'motors-car-dealership-classified-listings-pro' ); ?></h4>
							<input class="user_validated_field" type="email" name="stm_user_mail"
									placeholder="<?php esc_attr_e( 'Enter E-mail', 'motors-car-dealership-classified-listings-pro' ); ?>"/>
						</div>
					</div>

					<div class="row form-group">
						<div class="col-md-6">
							<h4><?php esc_html_e( 'Login *', 'motors-car-dealership-classified-listings-pro' ); ?></h4>
							<input class="user_validated_field" type="text" name="stm_nickname"
									placeholder="<?php esc_attr_e( 'Enter Login', 'motors-car-dealership-classified-listings-pro' ); ?>"/>
						</div>
						<div class="col-md-6">
							<h4><?php esc_html_e( 'Password *', 'motors-car-dealership-classified-listings-pro' ); ?></h4>
							<div class="stm-show-password">
								<i class="fas fa-eye-slash"></i>
								<input class="user_validated_field" type="password" name="stm_user_password"
										placeholder="<?php esc_attr_e( 'Enter Password', 'motors-car-dealership-classified-listings-pro' ); ?>"/>
							</div>
						</div>
					</div>
					<?php
					if ( apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_term_service' ) ) :
						$link = apply_filters( 'motors_vl_get_nuxy_mod', '', 'terms_service' );
						?>
						<div class="form-group form-checker">
							<label>
								<input type="checkbox" name="stm_accept_terms"/>
								<span>
									<?php echo wp_kses_post( $__link_of_terms__ ); ?>
								</span>
							</label>
						</div>
					<?php endif; ?>
					<?php if ( apply_filters( 'motors_vl_get_nuxy_mod', false, 'allow_user_register_as_dealer' ) ) : ?>
						<div class="stm-register-as-dealer form-group form-checker">
							<label>
								<input type="checkbox" name="register_as_dealer" value="1"/>
								<span><?php esc_html_e( 'As Dealer', 'stm_vehicles_listing' ); ?></span>
							</label>
						</div>
					<?php endif; ?>
					<div class="form-group form-group-submit clearfix">
						<?php
						$recaptcha_enabled    = apply_filters( 'motors_vl_get_nuxy_mod', 0, 'enable_recaptcha' );
						$recaptcha_public_key = apply_filters( 'motors_vl_get_nuxy_mod', '', 'recaptcha_public_key' );
						$recaptcha_secret_key = apply_filters( 'motors_vl_get_nuxy_mod', '', 'recaptcha_secret_key' );
						?>
						<?php // @codingStandardsIgnoreStart ?>
						<?php if ( ! empty( $recaptcha_enabled ) && $recaptcha_enabled && ! empty( $recaptcha_public_key ) && ! empty( $recaptcha_secret_key ) ) : ?>
							<script type="text/javascript" src="https://www.google.com/recaptcha/api.js"></script>
							<script>
                                function onSubmitPageRegister(token) {
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

                                            if ( data.restricted && data.restricted ) {
                                                $('.btn-add-edit').remove();
                                            }

                                            form.find('.stm-listing-loader').removeClass('visible');
                                            for (var err in data.errors) {
                                                form.find('input[name=' + err + ']').addClass('form-error');
                                            }

                                            // insert plans select
                                            if ( data.plans_select && $('#user_plans_select_wrap').length > 0 ) {
                                                $('#user_plans_select_wrap').html(data.plans_select);
                                                $( '#user_plans_select_wrap select' ).select2();
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
							</script>
						<?php // @codingStandardsIgnoreEnd ?>
							<input class="g-recaptcha heading-font" data-sitekey="<?php echo esc_attr( $recaptcha_public_key ); ?>"
									data-callback='onSubmitPageRegister' type="submit"
									value="<?php esc_html_e( 'Sign up now!', 'motors-car-dealership-classified-listings-pro' ); ?>"
									disabled/>
						<?php else : ?>
							<input class="heading-font" type="submit"
									value="<?php esc_html_e( 'Sign up now!', 'motors-car-dealership-classified-listings-pro' ); ?>"
									<?php echo ( apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_term_service' ) ) ? 'disabled=1' : ''; ?> />
						<?php endif; ?>
						<span class="stm-listing-loader"><i class="motors-icons-load1"></i></span>
					</div>

					<div class="stm-validation-message"></div>

					<?php do_action( 'stm_after_signup_form' ); ?>

				</form>
			</div>
			<?php endif; ?>
		</div>
	</div>
</div>
