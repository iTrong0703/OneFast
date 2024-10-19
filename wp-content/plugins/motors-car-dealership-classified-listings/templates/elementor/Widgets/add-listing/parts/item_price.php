<?php
$_id = apply_filters( 'stm_listings_input', null, 'item_id' );

if ( $custom_listing_type && $listing_types_options ) {
	$stm_title_price       = ( ! empty( $listing_types_options[ $custom_listing_type . '_addl_price_title' ] ) ) ? $listing_types_options[ $custom_listing_type . '_addl_price_title' ] : '';
	$stm_title_desc        = ( ! empty( $listing_types_options[ $custom_listing_type . '_addl_price_desc' ] ) ) ? $listing_types_options[ $custom_listing_type . '_addl_price_desc' ] : '';
	$show_sale_price_label = ( ! empty( $listing_types_options[ $custom_listing_type . '_addl_show_sale_price_label' ] ) ) ? $listing_types_options[ $custom_listing_type . '_addl_show_sale_price_label' ] : '';
	$show_custom_label     = ( ! empty( $listing_types_options[ $custom_listing_type . '_addl_show_custom_label' ] ) ) ? $listing_types_options[ $custom_listing_type . '_addl_show_custom_label' ] : '';
} else {
	$show_price_label      = apply_filters( 'motors_vl_get_nuxy_mod', '', 'addl_price_label' );
	$stm_title_price       = apply_filters( 'motors_vl_get_nuxy_mod', '', 'addl_price_title' );
	$stm_title_desc        = apply_filters( 'motors_vl_get_nuxy_mod', '', 'addl_price_desc' );
	$show_sale_price_label = apply_filters( 'motors_vl_get_nuxy_mod', '', 'addl_sale_price' );
	$show_custom_label     = apply_filters( 'motors_vl_get_nuxy_mod', '', 'addl_custom_label' );
}

$car_price_form_label = '';
$price                = '';
$sale_price           = '';

if ( ! empty( $_id ) ) {
	$car_price_form_label = get_post_meta( $_id, 'car_price_form_label', true );
	$price                = (int) apply_filters( 'get_conver_price', get_post_meta( $_id, 'price', true ) );
	$sale_price           = ( ! empty( get_post_meta( $_id, 'sale_price', true ) ) ) ? (int) apply_filters( 'get_conver_price', get_post_meta( $_id, 'sale_price', true ) ) : '';
}

$vars = array(
	'price'                 => $price,
	'sale_price'            => $sale_price,
	'stm_title_price'       => $stm_title_price,
	'stm_title_desc'        => $stm_title_desc,
	'show_sale_price_label' => $show_sale_price_label,
	'show_custom_label'     => $show_custom_label,
	'car_price_form_label'  => $car_price_form_label,
);
?>

<div class="stm-form-price-edit">
	<div class="stm-car-listing-data-single stm-border-top-unit ">
		<div class="title heading-font"><?php esc_html_e( 'Set Your Asking Price', 'motors-car-dealership-classified-listings-pro' ); ?></div>
	</div>
	<div class="row stm-relative">
		<?php
		Motors_Elementor_Widgets_Free\Helpers\Helper::stm_ew_load_template( 'elementor/Widgets/add-listing/parts/item_price_templates/price', STM_LISTINGS_PATH, $vars );
		if ( ! empty( $show_sale_price_label ) ) {
			Motors_Elementor_Widgets_Free\Helpers\Helper::stm_ew_load_template( 'elementor/Widgets/add-listing/parts/item_price_templates/sale_price', STM_LISTINGS_PATH, $vars );
		}
		if ( ! empty( $show_custom_label ) ) {
			Motors_Elementor_Widgets_Free\Helpers\Helper::stm_ew_load_template( 'elementor/Widgets/add-listing/parts/item_price_templates/custom_label', STM_LISTINGS_PATH, $vars );
		}
		?>
	</div>
	<input type="hidden" name="btn-type"/>
</div>
