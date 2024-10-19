<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$post_type        = apply_filters( 'stm_listings_post_type', 'listings' );
$compare_ids      = apply_filters( 'stm_get_compared_items', array(), $post_type );
$filter_options   = stm_get_single_car_listings();
$compareLink      = apply_filters( 'motors_vl_get_nuxy_mod', '156', 'compare_page' );
$empty_cars       = 3 - count( $compare_ids );
$counter          = 0;
$compare_page_url = get_home_url();
$compare_page_id  = apply_filters( 'motors_vl_get_nuxy_mod', 0, 'compare_page' );
if ( $compare_page_id > 0 && ! is_null( get_post( $compare_page_id ) ) ) {
	$compare_page_url = get_permalink( $compare_page_id );
}
?>

<div class="single-add-to-compare">
	<div class="container">
		<div class="row">
			<div class="col-md-9 col-sm-9">
				<div class="single-add-to-compare-left">
					<i class="add-to-compare-icon stm-icon-speedometr2"></i>
					<span class="stm-title h5"></span>
				</div>
			</div>
			<div class="col-md-3 col-sm-3">
				<a href="<?php echo esc_url( $compare_page_url ); ?>" class="compare-fixed-link pull-right heading-font">
					<?php echo esc_html__( 'Compare', 'stm_vehicles_listing' ); ?>
				</a>
			</div>
		</div>
	</div>
</div>
