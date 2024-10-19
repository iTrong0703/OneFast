<?php
$nuxy_mod_option = apply_filters( 'motors_vl_get_nuxy_mod', 'list', 'listing_view_type' );
if ( wp_is_mobile() ) {
	$nuxy_mod_option = apply_filters( 'motors_vl_get_nuxy_mod', 'grid', 'listing_view_type_mobile' );
}
$view_type = apply_filters( 'stm_listings_input', $nuxy_mod_option, 'view_type' );

if ( 'list' === $view_type ) {
	$view_list = 'active';
	$view_grid = '';
} else {
	$view_grid = 'active';
	$view_list = '';
}

?>
<div class="stm-view-by">
	<a href="#" class="view-grid view-type <?php echo esc_attr( $view_grid ); ?>" data-view="grid">
		<i class="motors-icons-grid"></i>
	</a>
	<a href="#" class="view-list view-type <?php echo esc_attr( $view_list ); ?>" data-view="list">
		<i class="motors-icons-list"></i>
	</a>
</div>
