<?php
defined( 'ABSPATH' ) || exit;

$get_params = false;

if ( ! defined( 'WPB_VC_VERSION' ) ) {
	$histories    = apply_filters( 'motors_vl_get_nuxy_mod', false, 'addl_history_report' );
	$show_history = apply_filters( 'motors_vl_get_nuxy_mod', false, 'addl_show_history' );
} elseif ( ! empty( $histories ) ) {
	$show_history = true;
}
$show_registered = apply_filters( 'motors_vl_get_nuxy_mod', false, 'addl_show_registered' );
$show_vin        = apply_filters( 'motors_vl_get_nuxy_mod', false, 'addl_show_vin' );

$item_id = $id ?? 0;

if ( ! empty( apply_filters( 'stm_listings_input', null, 'item_id' ) ) ) {
	$item_id = apply_filters( 'stm_listings_input', null, 'item_id' );
}

if ( ! $get_params ) {
	if ( $show_registered ) {
		$data_value    = get_post_meta( $item_id, 'registration_date', true );
		$input_classes = 'form-control stm-years-datepicker';

		if ( ! empty( $data_value ) ) {
			$input_classes .= 'stm_has_value';
		}
		?>
		<div class="stm-form-1-quarter stm_registration_date">
			<input
				type="text"
				name="stm_registered"
				class="<?php echo esc_attr( $input_classes ); ?>"
				aria-label="<?php esc_attr_e( 'Enter date', 'stm_vehicles_listing' ); ?>"
				placeholder="<?php esc_attr_e( 'Enter date', 'stm_vehicles_listing' ); ?>"
				value="<?php echo esc_attr( $data_value ); ?>"/>
			<div class="stm-label">
				<i class="motors-icons-key"></i>
				<?php esc_html_e( 'Registered', 'stm_vehicles_listing' ); ?>
			</div>
		</div>
		<?php
	}
	if ( $show_vin ) {
		$data_value    = get_post_meta( $item_id, 'vin_number', true );
		$input_classes = 'form-control';

		if ( ! empty( $data_value ) ) {
			$input_classes .= 'stm_has_value';
		}
		?>
		<div class="stm-form-1-quarter stm_vin">
			<input
				type="text"
				name="stm_vin"
				class="<?php echo esc_attr( $input_classes ); ?>"
				value="<?php echo esc_attr( $data_value ); ?>"
				aria-label="<?php esc_attr_e( 'Enter VIN', 'stm_vehicles_listing' ); ?>"
				placeholder="<?php esc_attr_e( 'Enter VIN', 'stm_vehicles_listing' ); ?>"/>

			<div class="stm-label">
				<i class="motors-icons-vin_check"></i>
				<?php esc_html_e( 'VIN', 'stm_vehicles_listing' ); ?>
			</div>
		</div>
		<?php
	}
	if ( $show_history ) {
		$data_value      = get_post_meta( $item_id, 'history', true );
		$data_value_link = get_post_meta( $item_id, 'history_link', true );
		$input_classes   = 'form-control';

		if ( ! empty( $data_value ) ) {
			$input_classes .= 'stm_has_value';
		}
		?>
		<div class="stm-form-1-quarter stm_history">
			<input
				type="text"
				name="stm_history_label"
				class="<?php echo esc_attr( $input_classes ); ?>"
				value="<?php echo esc_attr( $data_value ); ?>"
				aria-label="<?php esc_attr_e( 'Vehicle History Report', 'stm_vehicles_listing' ); ?>"
				placeholder="<?php esc_attr_e( 'Vehicle History Report', 'stm_vehicles_listing' ); ?>"/>

			<div class="stm-label">
				<i class="motors-icons-time"></i>
				<?php esc_html_e( 'History', 'stm_vehicles_listing' ); ?>
			</div>

			<div class="stm-history-popup stm-invisible">
				<div class="inner">
					<i class="fas fa-times"></i>
					<h5><?php esc_html_e( 'Vehicle history', 'stm_vehicles_listing' ); ?></h5>
					<?php
					if ( ! empty( $histories ) ) :
						$histories = explode( ',', $histories );
						if ( ! empty( $histories ) ) :
							echo '<div class="labels-units">';
							foreach ( $histories as $history ) :
								?>
								<label>
									<input type="radio" name="stm_chosen_history" value="<?php echo esc_attr( $history ); ?>"/>
									<span><?php echo esc_attr( $history ); ?></span>
								</label>
								<?php
							endforeach;
							echo '</div>';
						endif;
					endif;
					?>
					<input
						type="text"
						class="form-control"
						name="stm_history_link"
						aria-label="<?php esc_attr_e( 'Insert link', 'stm_vehicles_listing' ); ?>"
						placeholder="<?php esc_attr_e( 'Insert link', 'stm_vehicles_listing' ); ?>"
						value="<?php echo esc_url( $data_value_link ); ?>"/>
					<a href="#" class="button">
						<?php esc_html_e( 'Apply', 'stm_vehicles_listing' ); ?>
					</a>
				</div>
			</div>
		</div>
		<?php //phpcs:disable ?>
		<script type="text/javascript">
            jQuery(document).ready(function () {
                var $ = jQuery;
                var $stm_handler = $('.stm-form-1-quarter.stm_history input[name="stm_history_label"]');
                $stm_handler.on('focus', function () {
                    $('.stm-history-popup').removeClass('stm-invisible');
                });

                $('.stm-history-popup .button').on('click', function (e) {
                    e.preventDefault();
                    $('.stm-history-popup').addClass('stm-invisible');

                    if ($('input[name=stm_chosen_history]:radio:checked').length > 0) {
                        $stm_checked = $('input[name=stm_chosen_history]:radio:checked').val();
                    } else {
                        $stm_checked = '';
                    }

                    $stm_handler.val($stm_checked);
                })

                $('.stm-history-popup .fa-remove').on('click', function () {
                    $('.stm-history-popup').addClass('stm-invisible');
                });
            });
		</script>
		<?php //phpcs:enable ?>
		<?php
	}
} else {

	$additional_fields = array();
	if ( $show_registered ) {
		$additional_fields[] = 'stm_registered';
	}
	if ( $show_vin ) {
		$additional_fields[] = 'stm_vin';
	}
	if ( $show_history ) {
		$additional_fields[] = 'stm_history';
	}

	return $additional_fields;
}
