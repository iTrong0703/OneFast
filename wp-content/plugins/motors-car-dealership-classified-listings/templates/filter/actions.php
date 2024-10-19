<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$title_default = apply_filters( 'motors_vl_get_nuxy_mod', esc_html__( 'Cars for sale', 'stm_vehicles_listing' ), 'listing_directory_title_default', );
?>

<div class="stm-filter-top-wrap">
	<div class="stm-listing-directory-title">
		<h3 class="title"><?php echo esc_html( $title_default ); ?></h3>
	</div>

	<div class="stm-directory-listing-top__right clearfix">

		<div class="stm-sort-by-options clearfix">
			<span><?php esc_html_e( 'Sort by:', 'stm_vehicles_listing' ); ?></span>
			<div class="stm-select-sorting">
				<select name="sort_order">
					<?php echo wp_kses_post( apply_filters( 'stm_get_sort_options_html', '' ) ); ?>
				</select>
			</div>
		</div>

		<?php
		$nuxy_mod_option = apply_filters( 'motors_vl_get_nuxy_mod', 'list', 'listing_view_type' );

		if ( wp_is_mobile() ) {
			$nuxy_mod_option = apply_filters( 'motors_vl_get_nuxy_mod', 'grid', 'listing_view_type_mobile' );
		}
		$view_type = apply_filters( 'stm_listings_input', $nuxy_mod_option, 'view_type' );

		$view_list = ( 'list' === $view_type ) ? 'active' : '';
		$view_grid = ( 'list' !== $view_type ) ? 'active' : '';

		?>

		<div class="stm-view-by">
			<a href="#" class="view-grid view-type <?php echo esc_attr( $view_grid ); ?>" data-view="grid">
				<i class="motors-icons-grid"></i>
			</a>
			<a href="#" class="view-list view-type <?php echo esc_attr( $view_list ); ?>" data-view="list">
				<i class="motors-icons-list"></i>
			</a>
		</div>

	</div>
</div>
