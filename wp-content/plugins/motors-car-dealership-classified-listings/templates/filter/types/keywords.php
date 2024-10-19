<?php
/**
 * @var $position
 * */

$enable_keywords_search = apply_filters( 'motors_vl_get_nuxy_mod', true, 'enable_keywords_search', false );
if ( $enable_keywords_search ) :

	$selected_position = apply_filters( 'motors_vl_get_nuxy_mod', 'bottom', 'position_keywords_search', false );
	$position          = $position ?? '';

	if ( $selected_position !== $position ) {
		return;
	}

	$searched = apply_filters( 'stm_listings_input', null, 'stm_keywords' );
	if ( ! empty( $searched ) ) {
		$searched = sanitize_text_field( $searched );
	}
	?>
	<div class="col-md-12 col-sm-12 stm-search_keywords">
		<div class="form-group type-text">
			<?php $placeholder = __( 'Search...', 'stm_vehicles_listing' ); ?>
			<h5><?php esc_html_e( 'Search by keywords', 'stm_vehicles_listing' ); ?></h5>
			<input type="text" class="form-control" name="stm_keywords" placeholder="<?php echo esc_attr( $placeholder ); ?>" id="stm_keywords" value="<?php echo esc_attr( $searched ); ?>" aria-label="<?php esc_attr_e( 'Search by keywords in listings', 'stm_vehicles_listing' ); ?>">
		</div>
	</div>
<?php endif; ?>
