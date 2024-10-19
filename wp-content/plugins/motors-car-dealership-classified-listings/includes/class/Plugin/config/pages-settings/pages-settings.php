<?php
add_filter(
	'pages_settings_main',
	function ( $global_conf ) {
		$mvl_nuxy_pages_list = mvl_nuxy_pages_list();

		$one_conf = array(
			'listing_archive' => array(
				'label'       => esc_html__( 'Listings page', 'stm_vehicles_listing' ),
				'type'        => 'select',
				'description' => esc_html__( 'Choose the page where all listings are displayed', 'stm_vehicles_listing' ),
				'options'     => $mvl_nuxy_pages_list,
			),
			'compare_page'    => array(
				'label'       => esc_html__( 'Compare page', 'stm_vehicles_listing' ),
				'type'        => 'select',
				'description' => esc_html__( 'Select the page where users land when initiating vehicle comparisons', 'stm_vehicles_listing' ),
				'options'     => $mvl_nuxy_pages_list,
				'value'       => '',
			),
		);

		if ( apply_filters( 'motors_plugin_setting_classified_show', true ) ) {
			$classified_pages = array(
				'login_page'        => array(
					'label'       => esc_html__( 'Profile page', 'stm_vehicles_listing' ),
					'type'        => 'select',
					'description' => esc_html__( 'Choose the page where users can log in or register accounts', 'stm_vehicles_listing' ),
					'options'     => $mvl_nuxy_pages_list,
					'group'       => 'started',
				),
				'show_term_service' => array(
					'label' => esc_html__( 'Show checkbox Terms of Service', 'stm_vehicles_listing' ),
					'type'  => 'checkbox',
					'group' => 'ended',
				),
				'terms_service'     => array(
					'label'       => esc_html__( 'Terms of Service Page', 'stm_vehicles_listing' ),
					'type'        => 'select',
					'description' => esc_html__( 'Choose the page Terms of Service', 'stm_vehicles_listing' ),
					'options'     => $mvl_nuxy_pages_list,
				),
				'user_add_car_page' => array(
					'label'       => esc_html__( 'Listing creation page', 'stm_vehicles_listing' ),
					'type'        => 'select',
					'description' => esc_html__( 'Select the page where users can add new listings and edit existing ones', 'stm_vehicles_listing' ),
					'options'     => $mvl_nuxy_pages_list,
					'value'       => '',
				),
			);

			$one_conf = array_merge( $one_conf, $classified_pages );
		}

		return array_merge( $global_conf, $one_conf );
	},
	10,
	1
);

add_filter(
	'pages_settings_main',
	function ( $global_conf ) {
		$page_list = mvl_generate_pages_list();
		if ( ! mvl_has_generated_pages( $page_list ) ) {
			return array_merge(
				$global_conf,
				array(
					'page_generator' => array(
						'type'    => 'page_generator_field',
						'options' => $page_list,
						'label'   => esc_html__( 'Generate Pages', 'stm_vehicles_listing' ),
					),
				)
			);
		}

		return $global_conf;
	},
	20,
	1
);
