<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$inventory_view = apply_filters( 'motors_vl_get_nuxy_mod', 'list', 'listing_view_type' );

if ( wp_is_mobile() ) {
	$inventory_view = apply_filters( 'motors_vl_get_nuxy_mod', 'grid', 'listing_view_type_mobile' );
}

if ( function_exists( 'stm_is_multilisting' ) && stm_is_multilisting() && wp_is_mobile() ) {
	$inventory_view = apply_filters( 'stm_me_get_nuxy_mod', 'grid', get_query_var( 'post_type' ) . '_view_type_mobile' );
}

$inventory_view = apply_filters( 'stm_listings_input', $inventory_view, 'view_type' );


if ( have_posts() ) :

	?>
	<div class="stm-isotope-sorting stm-isotope-sorting-<?php echo esc_attr( $inventory_view ); ?> motors-alignwide">

		<?php
		do_action( 'stm_listings_load_template', 'filter/featured' );

		do_action( 'stm_inventory_loop_items_before', $inventory_view );

		while ( have_posts() ) :
			the_post();
			do_action( 'stm_listings_load_template', 'listing-' . $inventory_view );
		endwhile;

		do_action( 'stm_inventory_loop_items_after', $inventory_view );
		?>

	</div>
<?php else : ?>
	<h3><?php esc_html_e( 'Sorry, No results', 'stm_vehicles_listing' ); ?></h3>
<?php endif; ?>

<?php stm_listings_load_pagination( $__vars['posts_per_page'] ); ?>
