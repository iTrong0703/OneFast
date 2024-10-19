<?php
$_id = apply_filters( 'stm_listings_input', null, 'item_id' );

if ( $custom_listing_type && $listing_types_options && isset( $listing_types_options[ $custom_listing_type . '_addl_user_features' ] ) ) {
	$user_features = $listing_types_options[ $custom_listing_type . '_addl_user_features' ];
} else {
	$user_features = apply_filters( 'motors_vl_get_nuxy_mod', array(), 'addl_user_features' );
}

?>
<div class="stm-form-2-features clearfix">
	<div class="stm-car-listing-data-single stm-border-top-unit ">
		<div class="title heading-font"><?php esc_html_e( 'Select Your Listing Features', 'motors-car-dealership-classified-listings-pro' ); ?></div>
	</div>
	<?php
	if ( is_array( $user_features ) ) {
		if ( ! empty( $_id ) ) {
			$features_car = get_post_meta( $_id, 'additional_features', true );
			$features_car = explode( ',', addslashes( $features_car ) );
		} else {
			$features_car = array();
		}

		foreach ( $user_features as $item ) {
			?>
			<?php if ( isset( $item['tab_title_single'] ) ) : ?>
				<div class="stm-single-feature">
					<div class="heading-font"><?php echo esc_html( $item['tab_title_single'] ); ?></div>
					<?php
					$features = array();

					if ( isset( $item['tab_title_labels'] ) && ! empty( $item['tab_title_labels'] ) ) {
						$features = explode( ',', $item['tab_title_labels'] );
					}
					?>
					<?php if ( ! empty( $features ) ) : ?>
						<?php foreach ( $features as $feature ) : ?>
							<?php
							$checked = '';

							if ( in_array( $feature, $features_car, true ) ) {
								$checked = 'checked';
							}

							?>
							<div class="feature-single">
								<label>
									<input type="checkbox" value="<?php echo esc_attr( $feature ); ?>" name="stm_car_features_labels[]" <?php echo esc_attr( $checked ); ?>/>
									<span><?php echo esc_attr( $feature ); ?></span>
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
