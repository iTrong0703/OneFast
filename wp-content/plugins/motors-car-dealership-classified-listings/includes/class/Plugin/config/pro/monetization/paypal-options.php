<?php
add_filter(
	'monetization_settings',
	function ( $conf_for_merge ) {

		if ( apply_filters( 'disable_monetization_paypal', false ) || ! apply_filters( 'is_mvl_pro', false ) ) {
			return $conf_for_merge;
		}

		$conf = array(
			'become_dealer_monetization' => array(
				'type'        => 'group_title',
				'label'       => esc_html__( 'Monetize dealer registrations', 'stm_vehicles_listing' ),
				'description' => esc_html__( 'Implement monetization for dealerships', 'stm_vehicles_listing' ),
				'submenu'     => esc_html__( 'Monetization', 'stm_vehicles_listing' ),
				'group'       => 'started',
			),
			'paypal_email'               => array(
				'label'       => esc_html__( 'Paypal email', 'stm_vehicles_listing' ),
				'description' => esc_html__( 'Enter the PayPal email address where payments for dealer memberships will be received.', 'stm_vehicles_listing' ),
				'type'        => 'text',
				'submenu'     => esc_html__( 'Monetization', 'stm_vehicles_listing' ),
			),
			'paypal_mode'                => array(
				'label'       => esc_html__( 'Paypal mode', 'stm_vehicles_listing' ),
				'description' => esc_html__( 'Select the PayPal mode, either \'Sandbox\' for testing or \'Live\' for production transactions.', 'stm_vehicles_listing' ),
				'type'        => 'select',
				'options'     =>
					array(
						'sandbox' => 'Sandbox',
						'live'    => 'Live',
					),
				'value'       => 'sandbox',
				'submenu'     => esc_html__( 'Monetization', 'stm_vehicles_listing' ),
			),
			'paypal_currency'            => array(
				'label'       => esc_html__( 'Currency name', 'stm_vehicles_listing' ),
				'type'        => 'text',
				'value'       => 'USD',
				'description' => esc_html__( 'Define the currency used for transactions, such as USD', 'stm_vehicles_listing' ),
				'submenu'     => esc_html__( 'Monetization', 'stm_vehicles_listing' ),
			),
			'membership_cost'            => array(
				'label'       => esc_html__( 'Price', 'stm_vehicles_listing' ),
				'type'        => 'text',
				'description' => esc_html__( 'Set the price for dealership membership submission', 'stm_vehicles_listing' ),
				'submenu'     => esc_html__( 'Monetization', 'stm_vehicles_listing' ),
				'group'       => 'ended',
			),
		);

		return array_merge( $conf_for_merge, $conf );
	},
	40,
	1
);
