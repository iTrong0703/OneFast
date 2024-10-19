<?php
global $listing_id;

$listing_id = ( is_null( $listing_id ) ) ? get_the_ID() : $listing_id;
?>
<div class="post-content mvl-listing-description">
	<?php
	if ( function_exists( 'stm_get_listing_seller_note' ) ) {
		echo wp_kses_post( apply_filters( 'stm_get_listing_seller_note', $listing_id ) );
	} else {
		echo wp_kses_post( get_the_content( null, null, $listing_id ) );
	}
	?>
</div>
