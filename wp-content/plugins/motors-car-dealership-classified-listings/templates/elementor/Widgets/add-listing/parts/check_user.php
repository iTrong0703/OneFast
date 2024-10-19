<?php
$restricted = false;
$_id        = apply_filters( 'stm_listings_input', null, 'item_id' );

$user_id = '';
if ( is_user_logged_in() ) {
	$user    = wp_get_current_user();
	$user_id = $user->ID;
}

$restrictions = apply_filters(
	'stm_get_post_limits',
	array(
		'premoderation' => true,
		'posts_allowed' => 0,
		'posts'         => 0,
		'images'        => 0,
		'role'          => 'user',
	),
	$user_id
);

if ( $restrictions['posts'] < 1 && apply_filters( 'motors_vl_get_nuxy_mod', false, 'dealer_pay_per_listing' ) ) {
	$restricted = true;
}

if ( get_post_meta( $_id, 'pay_per_listing', true ) && apply_filters( 'motors_vl_get_nuxy_mod', false, 'dealer_pay_per_listing' ) ) {
	$restricted = false;
}

if ( ! empty( $_id ) && 'publish' === get_post_status( $_id ) ) {
	$restricted = false;
}

if ( $custom_listing_type && $listing_types_options ) {
	$dealer_pay_per_listing = ( $listing_types_options[ $custom_listing_type . '_dealer_pay_per_listing' ] ) ? $listing_types_options[ $custom_listing_type . '_dealer_pay_per_listing' ] : false;
} else {
	$dealer_pay_per_listing = apply_filters( 'motors_vl_get_nuxy_mod', false, 'dealer_pay_per_listing' );
}

$can_register = apply_filters( 'motors_vl_get_nuxy_mod', false, 'new_user_registration' );
?>
<div class="stm-form-checking-user">
	<div class="stm-form-inner">
		<i class="motors-icons-load1"></i>
		<?php
		if ( is_user_logged_in() ) :
			$disabled = 'enabled';
			$user     = wp_get_current_user();
			$user_id  = $user->ID;
			?>
			<div id="stm_user_info">
				<?php
				Motors_Elementor_Widgets_Free\Helpers\Helper::stm_ew_load_template(
					'elementor/Widgets/add-listing/parts/user_info',
					STM_LISTINGS_PATH,
					array(
						'user_login' => '',
						'f_name'     => '',
						'l_name'     => '',
						'user_id'    => $user_id,
						'_id'        => $_id,
						'restricted' => $restricted,
						'dealer_ppl' => $dealer_pay_per_listing,
					)
				);
				?>
			</div>
			<?php
		else :
			$disabled = 'disabled';
			?>
			<div id="stm_user_info" style="display:none;"></div>
			<?php
		endif;
		?>

		<div class="stm-not-<?php echo esc_attr( $disabled ); ?>">
			<?php
			if ( $can_register ) :
				Motors_Elementor_Widgets_Free\Helpers\Helper::stm_ew_load_template( 'elementor/Widgets/add-listing/parts/registration', STM_LISTINGS_PATH );
				?>
				<div class="stm-add-a-car-login-overlay"></div>
			<?php else : ?>
				<h3 class="sign-in-only"><?php esc_html_e( 'Sign In', 'motors-car-dealership-classified-listings-pro' ); ?></h3>
			<?php endif; ?>
			<div class="stm-add-a-car-login <?php echo ( ! $can_register ) ? esc_attr( ' without-register-form' ) : ''; ?>">
				<div class="stm-login-form">
					<form method="post">
						<input type="hidden" name="redirect" value="disable">
						<input type="hidden" name="fetch_plans" value="true">
						<div class="form-group">
							<h4><?php esc_html_e( 'Login or E-mail', 'motors-car-dealership-classified-listings-pro' ); ?></h4>
							<input type="text" name="stm_user_login"
								placeholder="<?php esc_attr_e( 'Enter login or E-mail', 'motors-car-dealership-classified-listings-pro' ); ?>">
						</div>

						<div class="form-group">
							<h4><?php esc_html_e( 'Password', 'motors-car-dealership-classified-listings-pro' ); ?></h4>
							<input type="password" name="stm_user_password"
								placeholder="<?php esc_attr_e( 'Enter password', 'motors-car-dealership-classified-listings-pro' ); ?>">
						</div>

						<div class="form-group form-checker">
							<label>
								<input type="checkbox" name="stm_remember_me">
								<span><?php esc_attr_e( 'Remember me', 'motors-car-dealership-classified-listings-pro' ); ?></span>
							</label>
						</div>
						<input type="submit" value="Login">
						<span class="stm-listing-loader"><i class="motors-icons-load1"></i></span>
						<div class="stm-validation-message"></div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="stm-add-a-car-message heading-font"></div>
