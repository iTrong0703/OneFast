<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Compare
$show_compare    = apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_listing_compare' );
$cars_in_compare = apply_filters( 'stm_get_compared_items', array(), apply_filters( 'stm_listings_post_type', 'listings' ) );

if ( ! empty( $show_compare ) && $show_compare ) :
	?>
	<div class="stm_compare_unit">
		<?php if ( in_array( (string) get_the_ID(), $cars_in_compare, true ) ) : ?>
			<span
				href="#"
				class="add-to-compare active"
				data-view="grid"
				title="<?php esc_html_e( 'Remove from compare', 'stm_vehicles_listing' ); ?>"
				data-id="<?php echo esc_attr( get_the_ID() ); ?>"
				data-title="<?php echo esc_attr( get_the_title() ); ?>"
				data-post-type="<?php echo esc_attr( get_post_type( get_the_ID() ) ); ?>">
				<i class="motors-icons-added"></i>
			</span>
		<?php else : ?>
			<span
				href="#"
				class="add-to-compare"
				data-view="grid"
				data-post-type="<?php echo esc_attr( get_post_type( get_the_ID() ) ); ?>"
				title="<?php esc_html_e( 'Add to compare', 'stm_vehicles_listing' ); ?>"
				data-id="<?php echo esc_attr( get_the_ID() ); ?>"
				data-title="<?php echo esc_attr( get_the_title() ); ?>"
				data-post-type="<?php echo esc_attr( get_post_type( get_the_ID() ) ); ?>">
				<i class="motors-icons-add"></i>
			</span>
		<?php endif; ?>
	</div>
<?php endif; ?>
