<?php
$listing_id = get_the_ID();
?>

<div class="post-content">
	<h4><?php esc_html_e( 'Seller note\'s', 'stm_vehicles_listing' ); ?></h4>
	<?php
	echo wp_kses_post( apply_filters( 'stm_get_listing_seller_note', $listing_id ) );
	?>
</div>
