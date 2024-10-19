<div class="stm-listing-fav-loop">
	<?php if ( 'draft' === get_post_status( get_the_ID() ) ) { ?>
		<div class="stm-car-overlay-disabled"></div>
		<div class="stm_edit_pending_car">
			<h4><?php esc_html_e( 'Disabled', 'stm_vehicles_listing' ); ?></h4>
			<div class="stm-dots"><span></span><span></span><span></span></div>
		</div>
		<?php
	} elseif ( 'pending' === get_post_status( get_the_ID() ) ) {
		?>
		<div class="stm-car-overlay-disabled"></div>
		<div class="stm_edit_pending_car">
			<h4><?php esc_html_e( 'Under review', 'stm_vehicles_listing' ); ?></h4>
			<div class="stm-dots"><span></span><span></span><span></span></div>
		</div>
	<?php } do_action( 'stm_listings_load_template', 'listing-list' ); ?>
</div>
