<?php
$show_favorite = apply_filters( 'motors_vl_get_nuxy_mod', false, 'enable_favorite_items' );
if ( ! empty( $show_favorite ) && $show_favorite ) :
	?>
	<div
			class="stm-listing-favorite"
			data-id="<?php echo esc_attr( get_the_ID() ); ?>"
			data-toggle="tooltip" data-placement="right"
			title="<?php esc_attr_e( 'Add to favorites', 'stm_vehicles_listing' ); ?>">
		<i class="fa-regular fa-star"></i>
	</div>
<?php endif; ?>