<?php
$view_type = apply_filters( 'motors_vl_get_nuxy_mod', 'grid', 'listing_view_type' );

if ( ! empty( $_GET['view_type'] ) && in_array( $_GET['view_type'], array( 'grid', 'list' ), true ) ) {
	$view_type = sanitize_text_field( $_GET['view_type'] );
}

$ppp             = ${'ppp_on_' . $view_type};
$custom_img_size = ${$view_type . '_thumb_img_size'};

if ( ! isset( $post_type ) || empty( $post_type ) ) {
	$post_type = 'listings';
}
?>
<div class="motors-elementor-inventory-search-results" id="listings-result">
	<?php
	do_action(
		'stm_listings_load_results',
		array(
			'posts_per_page'  => $ppp,
			'post_type'       => $post_type,
			'custom_img_size' => ( ! empty( $custom_img_size ) ) ? $custom_img_size : null,
		)
	);

	wp_reset_query(); //phpcs:ignore
	?>
</div>
