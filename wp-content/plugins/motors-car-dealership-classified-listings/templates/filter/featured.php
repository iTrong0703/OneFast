<?php
$nuxy_mod_option = apply_filters( 'motors_vl_get_nuxy_mod', 'list', 'listing_view_type' );

if ( wp_is_mobile() ) {
	$nuxy_mod_option = apply_filters( 'motors_vl_get_nuxy_mod', 'grid', 'listing_view_type_mobile' );
}

$view_type              = apply_filters( 'stm_listings_input', $nuxy_mod_option, 'view_type' );
$args                   = ( is_object( apply_filters( 'stm_listings_query', null ) ) ) ? apply_filters( 'stm_listings_query', null )->query : array();
$args['posts_per_page'] = apply_filters( 'motors_vl_get_nuxy_mod', 3, 'list' === $view_type ? 'featured_listings_list_amount' : 'featured_listings_grid_amount' );
$args['meta_query'][]   = array(
	'key'     => 'special_car',
	'value'   => 'on',
	'compare' => '=',
);

if ( sort_distance_nearby() ) {
	$args['orderby'] = 'stm_distance';
} else {
	$args['orderby'] = 'rand';
}

$featured = new WP_Query( $args );
$url_args = $_GET; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

if ( isset( $url_args['ajax_action'] ) ) {
	unset( $url_args['ajax_action'] );
}
if ( isset( $url_args['posttype'] ) && 'undefined' === $url_args['posttype'] ) {
	unset( $url_args['posttype'] );
}

if ( isset( $url_args['featured_top'] ) && $url_args['featured_top'] ) {
	$inventory_link = false;
} elseif ( stm_is_multilisting() ) {
	$inventory_link = add_query_arg( array_merge( $url_args, array( 'featured_top' => 'true' ) ), apply_filters( 'stm_inventory_page_url', '', $args['post_type'] ) );
} else {
	$inventory_link = add_query_arg( array_merge( $url_args, array( 'featured_top' => 'true' ) ), apply_filters( 'stm_listings_user_defined_filter_page', '' ) );
}

$template_args = array();
if ( ! empty( $args['custom_img_size'] ) && has_image_size( $args['custom_img_size'] ) ) {
	$template_args['custom_img_size'] = $args['custom_img_size'];
}

if ( $featured->have_posts() ) : ?>
	<div class="stm-featured-top-cars-title">
		<div class="heading-font"><?php esc_html_e( 'Featured Listings', 'stm_vehicles_listing' ); ?></div>
		<?php if ( $inventory_link ) : ?>
			<a href="<?php echo esc_url( $inventory_link ); ?>">
				<?php esc_html_e( 'Show all', 'stm_vehicles_listing' ); ?>
			</a>
		<?php endif; ?>
	</div>

	<?php if ( ! apply_filters( 'stm_listings_input', null, 'featured_top' ) ) : ?>
		<div class="stm-isotope-sorting stm-isotope-sorting-featured-top">
			<?php if ( 'grid' === $view_type ) : ?>
				<div class="row row-3 car-listing-row car-listing-modern-grid">
			<?php endif; ?>
			<?php
			while ( $featured->have_posts() ) :
				$featured->the_post();
				do_action( 'stm_listings_load_template', 'listing-' . $view_type );
			endwhile;
			?>
			<?php if ( 'grid' === $view_type ) : ?>
				</div>
			<?php endif; ?>
		</div>
	<?php endif; ?>
<?php endif; ?>
