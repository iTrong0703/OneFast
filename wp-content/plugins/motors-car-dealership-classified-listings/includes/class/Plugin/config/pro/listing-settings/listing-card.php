<?php
add_filter(
	'listing_settings_conf',
	function ( $conf_for_merge ) {

		if ( ! stm_is_motors_theme() && ! apply_filters( 'enable_loan_calculator', false ) ) {
			return $conf_for_merge;
		}

		$conf = array(
			'show_listing_calculate' =>
				array(
					'label'                => esc_html__( 'Loan Calculator Popup', 'stm_vehicles_listing' ),
					'type'                 => 'checkbox',
					'description'          => ( 'yes' === apply_filters( 'motors_vl_disabled_pro', 'yes' ) ) ? \MotorsVehiclesListing\Plugin\Settings::$disabled_pro_text : '',
					'field_disabled_force' => apply_filters( 'motors_vl_disabled_pro', 'yes' ),
					'dependency'           => array(
						'key'   => 'listing_view_type',
						'value' => 'list',
					),
					'submenu'              => esc_html__( 'Listing info card', 'stm_vehicles_listing' ),
				),
		);

		return array_merge( $conf_for_merge, $conf );
	},
	42,
	1
);
