<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$horizontal_filter = apply_filters( 'motors_vl_get_nuxy_mod', false, 'listing_horizontal_filter' );

$listing_grid_choices = apply_filters( 'motors_vl_get_nuxy_mod', '9,12,18,27', 'listing_grid_choices' );
$listing_grid_choices = array_map( 'intval', explode( ',', $listing_grid_choices ) );
$default_grid_choice  = intval( get_option( 'posts_per_page' ) );

$posts_per_page = ! empty( $listing_grid_choices ) && $listing_grid_choices[0] ? $listing_grid_choices[0] : $default_grid_choice;

if ( ! empty( $_GET['posts_per_page'] ) ) {//phpcs:ignore
	$posts_per_page = intval( $_GET['posts_per_page'] );//phpcs:ignore
}

$sidebar_position = apply_filters( 'motors_vl_get_nuxy_mod', 'left', 'listing_filter_position' );

?>
<div class="container">
	<div class="archive-listing-page">
		<div class="archive-listing-page_row">
			<div class="archive-listing-page_side <?php echo $horizontal_filter ? esc_attr( 'horizontal_filter' ) : ''; ?> <?php echo esc_attr( $sidebar_position ); ?>">
				<?php if ( $horizontal_filter ) : ?>
					<?php do_action( 'stm_listings_load_template', 'filter/horizontal-filter/horizontal-filter' ); ?>
					<?php do_action( 'stm_listings_load_template', 'filter/horizontal-filter/horizontal-filter-actions' ); ?>
				<?php else : ?>
					<?php do_action( 'stm_listings_load_template', 'filter/sidebar' ); ?>
				<?php endif; ?>
			</div>
			<div class="archive-listing-page_content <?php echo $horizontal_filter ? esc_attr( 'horizontal_filter' ) : ''; ?>">
				<?php
				if ( ! $horizontal_filter ) {
					do_action( 'stm_listings_load_template', 'filter/actions' );
				}
				?>
				<div id="listings-result">
					<?php do_action( 'stm_listings_load_results', array( 'posts_per_page' => $posts_per_page ) ); ?>
				</div>
				<?php
				if ( ! $horizontal_filter ) {
					do_action( 'stm_listings_load_template', 'filter/inventory/items-per-page' );
				}
				?>
			</div>
		</div>
	</div>
</div>
<?php if ( $horizontal_filter ) {
	do_action( 'stm_listings_load_template', 'filter/horizontal-filter/horizontal-binding' );
}
?>
