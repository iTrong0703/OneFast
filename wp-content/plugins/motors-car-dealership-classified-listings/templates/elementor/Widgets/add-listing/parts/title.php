<?php
$_id = apply_filters( 'stm_listings_input', null, 'item_id' );

if ( $custom_listing_type && $listing_types_options && isset( $listing_types_options[ $custom_listing_type . '_addl_car_title' ] ) ) {
	$show_car_title = $listing_types_options[ $custom_listing_type . '_addl_car_title' ];
} else {
	$show_car_title = apply_filters( 'motors_vl_get_nuxy_mod', true, 'addl_car_title' );
}

if ( ! empty( $show_car_title ) && $show_car_title ) :
	$value = '';
	if ( ! empty( $_id ) ) {
		$value = get_the_title( $_id );
	} ?>
	<div class="stm-car-listing-data-single stm-border-top-unit ">
		<div class="stm_add_car_title_form">
			<div class="title heading-font"><?php esc_html_e( 'Listing Title', 'motors-car-dealership-classified-listings-pro' ); ?></div>
			<input type="text" name="stm_car_main_title" value="<?php echo esc_attr( $value ); ?>" placeholder="<?php esc_attr_e( 'Title', 'motors-car-dealership-classified-listings-pro' ); ?>">
		</div>
	</div>
<?php endif; ?>
