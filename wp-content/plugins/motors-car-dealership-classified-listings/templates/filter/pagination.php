<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$listing_grid_choices = explode( ',', apply_filters( 'motors_vl_get_nuxy_mod', '9,12,18,27', 'listing_grid_choices' ) );
if ( ! empty( $_GET['post_per_page'] ) && empty( $__vars['post_per_page'] ) ) {//phpcs:ignore
	$listing_grid_choice = intval( $_GET['posts_per_page'] );//phpcs:ignore
} elseif ( ! empty( $listing_grid_choices ) && $listing_grid_choices[0] && empty( $__vars['post_per_page'] ) ) {
	$listing_grid_choice = intval( $listing_grid_choices[0] );
} elseif ( ! empty( $__vars['post_per_page'] ) ) {
	$listing_grid_choice = $__vars['post_per_page'];
}

$listing_per_page = array();
if ( ! empty( $listing_grid_choice ) ) {
	$listing_per_page = array(
		'add_args' => array(
			'posts_per_page' => $listing_grid_choice,
		),
	);
}

?>

<div class="stm_ajax_pagination">
	<?php
	$pagination_links = paginate_links(
		array_merge(
			array(
				'type'      => 'list',
				'prev_text' => '<i class="fas fa-angle-left"></i>',
				'next_text' => '<i class="fas fa-angle-right"></i>',
			),
			$listing_per_page
		)
	);
	echo $pagination_links;//phpcs:ignore
	?>
</div>
