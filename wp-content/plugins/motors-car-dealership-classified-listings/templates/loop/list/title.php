<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$as_label = apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_generated_title_as_label' );
?>

<div class="title">
	<a href="<?php the_permalink() ?>" class="rmv_txt_drctn">
		<?php echo apply_filters( 'stm_generate_title_from_slugs', get_the_title(), get_the_ID(), $as_label ); ?>
	</a>
</div>