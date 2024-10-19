<?php
defined( 'ABSPATH' ) || exit; // Exit if accessed directly

	$show_trade_in    = apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_trade_in' );
	$show_offer_price = apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_offer_price' );

if ( $show_offer_price || $show_trade_in ) :
	?>

		<div class="stm-car_dealer-buttons heading-font">

			<?php if ( $show_trade_in ) : ?>
				<a href="#trade-in" data-toggle="modal" data-target="#trade-in">
					<?php esc_html_e( 'Trade in form', 'stm_vehicles_listing' ); ?>
					<i class="motors-icons-trade"></i>
				</a>
			<?php endif; ?>

			<?php if ( $show_offer_price ) : ?>
				<a href="#trade-offer" data-toggle="modal" data-target="#trade-offer">
					<?php esc_html_e( 'Make an offer price', 'stm_vehicles_listing' ); ?>
					<i class="motors-icons-cash"></i>
				</a>
			<?php endif; ?>

		</div>

<?php endif; ?>
