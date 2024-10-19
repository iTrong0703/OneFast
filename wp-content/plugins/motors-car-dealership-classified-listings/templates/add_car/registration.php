<?php
	defined( 'ABSPATH' ) || exit;

	$stm_title_user = apply_filters( 'motors_vl_get_nuxy_mod', '', 'addl_reg_log_title' );
	$stm_text_user  = apply_filters( 'motors_vl_get_nuxy_mod', '', 'addl_reg_log_desc' );
	$_link          = apply_filters( 'motors_vl_get_nuxy_mod', '', 'addl_reg_log_link' );
?>

<div class="stm-user-registration-unit">
	<div class="clearfix stm_register_title">
		<h3><?php esc_html_e( 'Sign Up', 'stm_vehicles_listing' ); ?></h3>
		<div class="stm_login_me">
			<?php esc_html_e( 'Already Registered? Members', 'stm_vehicles_listing' ); ?>
			<a href="#">
				<?php esc_html_e( 'Login Here', 'stm_vehicles_listing' ); ?>
			</a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3 col-sm-3 col-md-push-9 col-sm-push-9 col-xs-push-0">
			<div class="heading-font stm-title"><?php echo esc_html( $stm_title_user ); ?></div>
			<div class="stm-text"><?php echo esc_html( $stm_text_user ); ?></div>
		</div>

		<div class="col-md-9 col-sm-9 col-md-pull-3 col-sm-pull-3 col-xs-pull-0">
			<div class="stm-login-register-form">
				<div class="stm-register-form">
					<form method="post">
						<input type="hidden" name="redirect" value="disable">

						<div class="row form-group">
							<div class="col-md-6">
								<h4><?php esc_html_e( 'First Name', 'stm_vehicles_listing' ); ?></h4>
								<input class="form-control user_validated_field" type="text" name="stm_user_first_name" placeholder="<?php esc_attr_e( 'Enter First name', 'stm_vehicles_listing' ); ?>"/>
							</div>
							<div class="col-md-6">
								<h4><?php esc_html_e( 'Last Name', 'stm_vehicles_listing' ); ?></h4>
								<input class="form-control user_validated_field" type="text" name="stm_user_last_name" placeholder="<?php esc_attr_e( 'Enter Last name', 'stm_vehicles_listing' ); ?>"/>
							</div>
						</div>

						<div class="row form-group">
							<div class="col-md-6">
								<h4><?php esc_html_e( 'Phone number', 'stm_vehicles_listing' ); ?></h4>
								<input type="tel" class="form-control user_validated_field" name="stm_user_phone" placeholder="<?php esc_attr_e( 'Enter Phone', 'stm_vehicles_listing' ); ?>"/>
								<label for="whatsapp-checker">
									<input type="checkbox" name="stm_whatsapp_number" id="whatsapp-checker" />
									<span>
										<small class="text-muted">
											<?php esc_html_e( 'I have a WhatsApp account with this number', 'stm_vehicles_listing' ); ?>
										</small>
									</span>
								</label>
							</div>
							<div class="col-md-6">
								<h4><?php esc_html_e( 'Email *', 'stm_vehicles_listing' ); ?></h4>
								<input type="email" class="form-control user_validated_field" name="stm_user_mail" placeholder="<?php esc_attr_e( 'Enter E-mail', 'stm_vehicles_listing' ); ?>"/>
							</div>
						</div>

						<div class="row form-group">
							<div class="col-md-6">
								<h4><?php esc_html_e( 'Login *', 'stm_vehicles_listing' ); ?></h4>
								<input type="text" class="form-control user_validated_field" name="stm_nickname" placeholder="<?php esc_attr_e( 'Enter Login', 'stm_vehicles_listing' ); ?>"/>
							</div>
							<div class="col-md-6">
								<h4><?php esc_html_e( 'Password *', 'stm_vehicles_listing' ); ?></h4>
								<div class="stm-show-password">
									<i class="fas fa-eye-slash"></i>
									<input type="password" class="form-control user_validated_field" name="stm_user_password" placeholder="<?php esc_attr_e( 'Enter Password', 'stm_vehicles_listing' ); ?>"/>
								</div>
							</div>
						</div>

						<div class="form-group form-checker">
							<label>
								<input type="checkbox" name="stm_accept_terms"/>
								<span>
									<?php
										esc_html_e( 'I accept the terms of the', 'stm_vehicles_listing' );

									if ( ! empty( $_link ) ) :
										?>
										<a href="<?php echo esc_url( get_the_permalink( $_link ) ); ?>" target="_blank">
											<?php echo wp_kses_post( get_the_title( $_link ) ); ?>
										</a>
									<?php endif; ?>
								</span>
							</label>
						</div>

						<div class="form-group form-group-submit">
							<input type="submit" class="button" value="<?php esc_attr_e( 'Sign up now!', 'stm_vehicles_listing' ); ?>"/>
							<span class="stm-listing-loader">
								<i class="fas fa-spinner"></i>
							</span>
						</div>

						<div class="stm-validation-message"></div>

					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php //phpcs:disable ?>
<script type="text/javascript">
    jQuery(document).ready(function () {
        var $ = jQuery;
        $('.stm-show-password .fa').mousedown(function () {
            $(this).closest('.stm-show-password').find('input').attr('type', 'text');
            $(this).addClass('fa-eye');
            $(this).removeClass('fa-eye-slash');
        });

        $(document).mouseup(function () {
            $('.stm-show-password').find('input').attr('type', 'password');
            $('.stm-show-password .fa').addClass('fa-eye-slash');
            $('.stm-show-password .fa').removeClass('fa-eye');
        });

        $("body").on('touchstart', '.stm-show-password .fa', function () {
            $(this).closest('.stm-show-password').find('input').attr('type', 'text');
            $(this).addClass('fa-eye');
            $(this).removeClass('fa-eye-slash');
        });
    });
</script>
<?php //phpcs:enable ?>
