<?php
$_id = apply_filters( 'stm_listings_input', null, 'item_id' );

if ( $custom_listing_type && $listing_types_options && isset( $listing_types_options[ $custom_listing_type . '_fs_user_features' ] ) ) {
	$feature_settings = $listing_types_options[ $custom_listing_type . '_fs_user_features' ];
} else {
	$feature_settings = apply_filters( 'motors_vl_get_nuxy_mod', array(), 'fs_user_features' );
}
?>
<div class="stm-form-2-features clearfix">
	<div class="stm-car-listing-data-single stm-border-top-unit ">
		<div class="title heading-font"><?php esc_html_e( 'Select Your Listing Features', 'motors-car-dealership-classified-listings-pro' ); ?></div>
	</div>
	<?php
	if ( is_array( $feature_settings ) ) {
		if ( ! empty( $_id ) ) {
			$features_car = get_post_meta( $_id, 'additional_features', true );
			$features_car = explode( ',', addslashes( $features_car ) );
		} else {
			$features_car = array();
		}

		foreach ( $feature_settings as $item ) {
			?>
			<?php if ( isset( $item['tab_title_single'] ) ) : ?>
				<div class="stm-single-feature">
					<div class="heading-font"><?php echo esc_html( $item['tab_title_single'] ); ?></div>
					<?php if ( ! empty( $item['tab_title_selected_labels'] ) ) : ?>
						<?php foreach ( $item['tab_title_selected_labels'] as $feature ) : ?>
							<?php
							$checked = '';

							if ( in_array( $feature['label'], $features_car, true ) ) {
								$checked = 'checked';
							}

							?>
							<div class="feature-single">
								<label>
									<input type="checkbox" value="<?php echo esc_attr( $feature['label'] ); ?>" name="stm_car_features_labels[]" <?php echo esc_attr( $checked ); ?>/>
									<span><?php echo esc_attr( $feature['label'] ); ?></span>
								</label>
							</div>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			<?php endif; ?>
			<?php
		}
	}
	?>
</div>
