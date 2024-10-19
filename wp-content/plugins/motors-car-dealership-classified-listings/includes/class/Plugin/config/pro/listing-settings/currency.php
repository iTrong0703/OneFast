<?php

add_filter(
	'listing_settings_conf',
	function ( $conf_for_merge ) {
		$conf = array(
			'currency_list' =>
				array(
					'label'       => esc_html__( 'Multiple Currencies', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'Conversion Rate should be delimited by dot (example: 1.2)', 'stm_vehicles_listing' ),
					'pro'         => true,
					'pro_url'     => \MotorsVehiclesListing\Plugin\Settings::$pro_plans_url,
					'type'        => 'repeater',
					'load_labels' => array(
						'add_label' => esc_html__( 'Add Currency', 'stm_vehicles_listing' ),
					),
					'fields'      =>
						array(
							'currency' =>
								array(
									'type'  => 'text',
									'label' => esc_html__( 'Currency Name', 'stm_vehicles_listing' ),
								),
							'symbol'   =>
								array(
									'type'  => 'text',
									'label' => esc_html__( 'Currency Symbol', 'stm_vehicles_listing' ),
								),
							'to'       =>
								array(
									'type'  => 'text',
									'label' => esc_html__( 'Conversion Rate', 'stm_vehicles_listing' ),
								),
						),
					'submenu'     => esc_html__( 'Currency', 'stm_vehicles_listing' ),
				),
		);

		return array_merge( $conf_for_merge, $conf );
	},
	32,
	1
);
