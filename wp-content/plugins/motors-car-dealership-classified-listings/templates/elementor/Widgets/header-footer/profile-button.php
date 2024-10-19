<?php
$profile_page_link = get_permalink( apply_filters( 'motors_vl_get_nuxy_mod', '', 'login_page' ) );
?>
<a href="<?php echo esc_url( $profile_page_link ); ?>" class="motors-profile-button">
	<span class="profile-icon-wrapper">
		<?php echo wp_kses( apply_filters( 'stm_dynamic_icon_output', $mvl_profile_btn_icon ), apply_filters( 'stm_ew_kses_svg', array() ) ); ?>
	</span>
	<span><?php echo esc_html( $mvl_profile_btn_text ); ?></span>
</a>
<?php do_action( 'stm_listings_load_template', 'account-dropdown' ); ?>
