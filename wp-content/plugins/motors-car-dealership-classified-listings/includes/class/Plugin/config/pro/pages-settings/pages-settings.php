<?php
add_filter(
	'pages_settings_main',
	function ( $global_conf ) {
		$mvl_nuxy_pages_list = mvl_nuxy_pages_list();

		return array_merge(
			$global_conf,
			array(
				'pricing_link'     => array(
					'label'       => esc_html__( 'Pricing plans page', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'Choose the page where pricing plans for users or dealers are displayed', 'stm_vehicles_listing' ),
					'type'        => 'select',
					'options'     => $mvl_nuxy_pages_list,
					'pro'         => true,
					'pro_url'     => \MotorsVehiclesListing\Plugin\Settings::$pro_plans_url,
				),
				'dealer_list_page' => array(
					'label'       => esc_html__( 'Page for dealer list', 'stm_vehicles_listing' ),
					'type'        => 'select',
					'description' => esc_html__( 'Select the page where a comprehensive list of dealers is displayed', 'stm_vehicles_listing' ),
					'options'     => $mvl_nuxy_pages_list,
					'pro'         => true,
					'pro_url'     => \MotorsVehiclesListing\Plugin\Settings::$pro_plans_url,
				),
			)
		);
	},
	20,
	1
);
