<?php
$args = apply_filters(
	'stm_listings_query',
	array(
		'enable_distance_search' => true,
		'stm_location_address'   => null,
	)
);
$args = ( is_object( $args ) ) ? $args->query : array();

$args['posts_per_page'] = 3;

$listings = new WP_Query( $args );

$nuxy_mod_option = apply_filters( 'motors_vl_get_nuxy_mod', 'list', 'listing_view_type' );
if ( wp_is_mobile() ) {
	$nuxy_mod_option = apply_filters( 'motors_vl_get_nuxy_mod', 'grid', 'listing_view_type_mobile' );
}
$view_type     = apply_filters( 'stm_listings_input', $nuxy_mod_option, 'view_type' );
$template_args = array();
if ( ! empty( $args['custom_img_size'] ) ) {
	$template_args['custom_img_size'] = $args['custom_img_size'];
}

if ( $listings->have_posts() ) : ?>

	<div class="stm-location-top-listings-title">
		<div class="heading-font">
			<span class="motors-icons-search-items"></span>
			<?php esc_html_e( 'Cars found in other locations', 'stm_vehicles_listing' ); ?>
		</div>
	</div>

	<?php if ( ! apply_filters( 'stm_listings_input', null, 'featured_top' ) ) : ?>
		<?php if ( 'grid' === $view_type ) : ?>
			<div class="row row-3 car-listing-row car-listing-modern-grid">
		<?php endif; ?>

		<div class="stm-isotope-sorting stm-isotope-sorting-featured-top">

			<?php
			while ( $listings->have_posts() ) :
				$listings->the_post();
				do_action( 'stm_listings_load_template', 'listing-cars/listing-' . $view_type . '-directory-loop', $template_args );
			endwhile;
			?>

		</div>

		<?php if ( 'grid' === $view_type ) : ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>
	<?php
endif;
