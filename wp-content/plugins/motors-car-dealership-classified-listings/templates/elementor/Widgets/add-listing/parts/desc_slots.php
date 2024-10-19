<?php
$user = wp_get_current_user();

if ( $custom_listing_type && $listing_types_options ) {
	$_title      = ( $listing_types_options[ $custom_listing_type . '_addl_title' ] ) ? $listing_types_options[ $custom_listing_type . '_addl_title' ] : '';
	$desc        = ( $listing_types_options[ $custom_listing_type . '_addl_description' ] ) ? $listing_types_options[ $custom_listing_type . '_addl_description' ] : '';
	$slots_title = ( $listing_types_options[ $custom_listing_type . '_addl_slots_title' ] ) ? $listing_types_options[ $custom_listing_type . '_addl_slots_title' ] : '';
	$show_slots  = ( $listing_types_options[ $custom_listing_type . '_addl_show_slots' ] ) ? $listing_types_options[ $custom_listing_type . '_addl_show_slots' ] : false;
} else {
	$_title      = apply_filters( 'motors_vl_get_nuxy_mod', '', 'addl_title' );
	$desc        = apply_filters( 'motors_vl_get_nuxy_mod', '', 'addl_description' );
	$slots_title = apply_filters( 'motors_vl_get_nuxy_mod', '', 'addl_slots_title' );
	$show_slots  = apply_filters( 'motors_vl_get_nuxy_mod', false, 'addl_show_slots' );
}
?>
<div class="motors-desc-slots-wrapper">
	<div class="mdsw-left">
		<?php if ( ! empty( $_title ) ) : ?>
			<h3><?php echo esc_html( apply_filters( 'stm_dynamic_string_translation', $_title, 'Add Listing title' ) ); ?></h3>
		<?php endif; ?>
		<?php
		if ( ! empty( $desc ) ) {
			echo wp_kses_post( $desc );
		}
		?>
	</div>
	<div class="mdsw-right">
		<?php
		if ( ! empty( $user->ID ) && $show_slots ) :
			$limits = apply_filters(
				'stm_get_post_limits',
				array(
					'premoderation' => true,
					'posts_allowed' => 0,
					'posts'         => 0,
					'images'        => 0,
					'role'          => 'user',
				),
				$user->ID
			);

			?>
			<div class="stm-posts-available-number heading-font">
				<?php echo esc_html( apply_filters( 'stm_dynamic_string_translation', $slots_title, 'Slots Available title' ) ); ?>:
				<span><?php echo esc_html( $limits['posts'] ); ?></span>
			</div>
			<?php
		endif;
		?>
	</div>
</div>

<?php if ( defined( 'STM_MOTORS_VIN_DECODERS' ) ) : ?>
	<div class="motors-vin-decoder-wrapper">
		<?php do_action( 'stm_vin_auto_complete_require_template' ); ?>
	</div>
<?php endif; ?>
