<?php
add_filter(
	'mvl_user_dealer_options',
	function ( $global_conf ) {
		return array_merge(
			$global_conf,
			array(
				'become_a_dealer' => array(
					'label'       => esc_html__( 'Become a dealer button', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'Add a button for users to sign up and become registered dealers', 'stm_vehicles_listing' ),
					'type'        => 'checkbox',
					'pro'         => true,
					'pro_url'     => \MotorsVehiclesListing\Plugin\Settings::$pro_plans_url,
					'submenu'     => esc_html__( 'User', 'stm_vehicles_listing' ),
				),
			)
		);
	},
	20,
	1
);
