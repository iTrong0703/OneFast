<?php
add_filter(
	'user_settings_main',
	function ( $conf ) {
		return array_merge(
			$conf,
			array(
				'allow_user_register_as_dealer' => array(
					'label'       => esc_html__( 'Dealer Registration', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'A registration form will have an option for dealer to sign up', 'stm_vehicles_listing' ),
					'type'        => 'checkbox',
					'value'       => true,
					'pro'         => true,
					'pro_url'     => \MotorsVehiclesListing\Plugin\Settings::$pro_plans_url,
					'submenu'     => esc_html__( 'General', 'stm_vehicles_listing' ),
				),
			)
		);
	}
);
