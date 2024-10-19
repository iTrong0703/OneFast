<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<div class="image">
	<!--Favourite-->
	<?php do_action( 'stm_listings_load_template', 'loop/favorite' ); ?>

	<!--Video-->
	<?php do_action( 'stm_listings_load_template', 'loop/video' ); ?>

	<div class="image-inner">
		<!--Badge-->
		<?php do_action( 'stm_listings_load_template', 'loop/badge' ); ?>

		<?php do_action( 'stm_listings_load_template', 'loop/image-preview', array( 'view_type' => 'grid' ) ); ?>

		<?php
		$tooltip_position = 'left';

		do_action( 'stm_listings_load_template', 'loop/grid/compare' );
		?>
	</div>
</div>
