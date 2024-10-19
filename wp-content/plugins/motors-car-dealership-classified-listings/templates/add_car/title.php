<?php
/**
 * Shortcode attributes
 * @var $id
 * */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'WPB_VC_VERSION' ) ) {
	$show_car_title = apply_filters( 'motors_vl_get_nuxy_mod', false, 'addl_car_title' );
}

if ( ! empty( $show_car_title ) && 'no' !== $show_car_title ) :
	$value = '';
	if ( ! empty( $id ) ) {
		$value = get_the_title( $id );
	}
	?>

	<div class="stm-car-listing-data-single stm-border-top-unit">
		<div class="stm_add_car_title_form">
			<div class="title heading-font" id="listing_title">
				<?php esc_html_e( 'Listing Title', 'stm_vehicles_listing' ); ?>
			</div>
			<input
				type="text"
				name="stm_car_main_title"
				class="form-control"
				aria-label="<?php esc_attr_e( 'Listing Title', 'stm_vehicles_listing' ); ?>"
				aria-labelledby="listing_title"
				placeholder="<?php esc_attr_e( 'Title', 'stm_vehicles_listing' ); ?>"
				value="<?php echo esc_attr( $value ); ?>">
		</div>
	</div>
<?php endif; ?>
