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

	<a href="<?php the_permalink(); ?>" class="rmv_txt_drctn">
		<div class="image-inner">
			<!--Badge-->
			<?php do_action( 'stm_listings_load_template', 'loop/badge' ); ?>

			<?php do_action( 'stm_listings_load_template', 'loop/image-preview', array( 'view_type' => 'list' ) ); ?>

		</div>
	</a>
</div>
