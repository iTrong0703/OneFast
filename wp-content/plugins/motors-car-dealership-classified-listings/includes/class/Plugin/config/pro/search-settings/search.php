<?php
add_filter(
	'search_settings_conf',
	function ( $conf_for_merge ) {
		$dependencies = apply_filters( 'features_search_dependencies', array() );

		if ( empty( $dependencies ) ) {
			$dependencies = array(
				'dependency' => array(
					'key'   => 'enable_keywords_search',
					'value' => 'not_empty',
				),
			);
		} else {
			$dependencies = array_merge(
				$dependencies,
				array(
					'dependency'   => array(
						array(
							'key'   => 'enable_keywords_search',
							'value' => 'not_empty',
						),
					),
					'dependencies' => '||',
				)
			);
		}

		if ( ! apply_filters( 'is_mvl_pro', false ) ) {
			$search = array(
				'search_by_key_settings_banner' => array(
					'type'  => 'pro_banner',
					'label' => esc_html__( 'Search by keywords', 'stm_vehicles_listing' ),
					//'img'   => STM_LISTINGS_URL . '/assets/images/pro/payouts.png',
					'desc'  => esc_html__( 'Users can make a search based on the keywords through all listings', 'stm_vehicles_listing' ),
				),
			);
		} else {
			$search = array(
				'enable_keywords_search'   =>
					array(
						'label'       => esc_html__( 'Search by keywords', 'stm_vehicles_listing' ),
						'description' => esc_html__( 'Users can make a search based on the keywords through all listings', 'stm_vehicles_listing' ),
						'type'        => 'checkbox',
						'group'       => 'started',
						'value'       => true,
					),
				'position_keywords_search' =>
					array_merge(
						array(
							'label'       => esc_html__( 'Position', 'stm_vehicles_listing' ),
							'description' => esc_html__( 'Choose where you want to show the field to search by keywords', 'stm_vehicles_listing' ),
							'type'        => 'select',
							'value'       => 'bottom',
							'options'     => array(
								'bottom' => esc_html__( 'Bottom', 'stm_vehicles_listing' ),
								'top'    => esc_html__( 'Top', 'stm_vehicles_listing' ),
							),
						),
						$dependencies
					),
				'search_settings_ending'   =>
					array(
						'label' => '',
						'type'  => 'nuxy-hidden',
						'value' => '',
						'group' => 'ended',
					),
			);
		}

		$conf = array(
			'enable_search' =>
				array(
					'label'       => esc_html__( 'Use WordPress search for listings', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'By enabling this button, your site will use WordPress search for listings', 'stm_vehicles_listing' ),
					'type'        => 'checkbox',
				),
		);

		$conf = array_merge( $conf, $search );

		return array_merge( $conf_for_merge, $conf );
	},
	26,
	1
);
