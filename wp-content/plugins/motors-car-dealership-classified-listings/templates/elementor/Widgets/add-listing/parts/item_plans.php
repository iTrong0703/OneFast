<?php

if ( false === apply_filters( 'motors_vl_get_nuxy_mod', false, 'enable_plans' ) || false === apply_filters( 'stm_is_multiple_plans', false ) ) {
	return;
}

$_id = apply_filters( 'stm_listings_input', null, 'item_id' );

$plans         = \MotorsVehiclesListing\Features\MultiplePlan::getPlans();
$selected_plan = \MotorsVehiclesListing\Features\MultiplePlan::getCurrentPlan( $_id );
$is_editing    = ( ! empty( $_GET['edit_car'] ) && ! empty( $_GET['item_id'] ) ) ? true : false;

?>
<div class="stm-form-plans">
	<div class="stm-car-listing-data-single stm-border-top-unit ">
		<div class="title heading-font"><?php esc_html_e( 'Choose plan', 'motors-car-dealership-classified-listings-pro' ); ?></div>
	</div>
	<div id="user_plans_select_wrap">
		<?php if ( is_user_logged_in() ) { ?>
			<div class="user-plans-list" >
				<select name="selectedPlan">
					<option value=""><?php echo esc_html__( 'Select Plan', 'motors-car-dealership-classified-listings-pro' ); ?></option>
					<?php
					$count = 0;
					foreach ( $plans['plans'] as $plan ) :
						$selected = '';
						if ( 1 === count( $plans['plans'] ) - $count ) {
							$selected = 'selected';
						}
						if ( (string) $plan['plan_id'] === (string) $selected_plan && $plan['used_quota'] < $plan['total_quota'] ) {
							$selected = 'selected';
						} elseif ( (string) $plan['used_quota'] >= (string) $plan['total_quota'] ) {
							$selected = 'disabled';
							$count++;
						}

						if ( $is_editing && (string) $plan['plan_id'] === (string) $selected_plan && $plan['used_quota'] <= $plan['total_quota'] ) {
							$selected = 'selected';
						}
						?>

						<option value="<?php echo esc_attr( $plan['plan_id'] ); ?>" <?php echo esc_attr( $selected ); ?>>
							<?php echo wp_kses_post( sprintf( ( '%s %s / %s' ), $plan['label'], $plan['used_quota'], $plan['total_quota'] ) ); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>
		<?php } else { ?>
			<p style="color: #888888; font-size: 13px;"><?php echo esc_html__( 'Please, log in to view your available plans', 'motors-car-dealership-classified-listings-pro' ); ?></p>
		<?php } ?>
	</div>
</div>
