<?php
add_filter(
	'single_listing_conf',
	function ( $conf_for_merge ) {

		if ( in_array( 'motors-elementor-widgets/motors-elementor-widgets.php', (array) get_option( 'active_plugins', array() ), true ) ) {
			return $conf_for_merge;
		}

		$conf = array(
			'show_trade_in'         =>
				array(
					'label'       => esc_html__( 'Trade-In button', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'Enable a button to allow users to initiate trade-in inquiries for listed vehicles', 'stm_vehicles_listing' ),
					'type'        => 'checkbox',
					'submenu'     => esc_html__( 'Page layout', 'stm_vehicles_listing' ),
				),
			'show_compare'          =>
				array(
					'label'       => esc_html__( 'Compare Button', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'Activate a button for users to add vehicles to a comparison list for side-by-side evaluation', 'stm_vehicles_listing' ),
					'type'        => 'checkbox',
					'submenu'     => esc_html__( 'Page layout', 'stm_vehicles_listing' ),
				),
			'show_featured_btn'     =>
				array(
					'label'       => esc_html__( 'Add to favorites button', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'Enable a button for users to save vehicles as favorites', 'stm_vehicles_listing' ),
					'type'        => 'checkbox',
					'submenu'     => esc_html__( 'Page layout', 'stm_vehicles_listing' ),
				),
			'show_offer_price'      =>
				array(
					'label'       => esc_html__( 'Button to offer price', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'Enable a button for users to make offers or negotiate prices', 'stm_vehicles_listing' ),
					'type'        => 'checkbox',
					'submenu'     => esc_html__( 'Page layout', 'stm_vehicles_listing' ),
				),
			'show_share'            =>
				array(
					'label'       => esc_html__( 'Share button', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'Include a button to enable users to share vehicle listings', 'stm_vehicles_listing' ),
					'type'        => 'checkbox',
					'group'       => 'started',
					'submenu'     => esc_html__( 'Page layout', 'stm_vehicles_listing' ),
				),
			'show_notice_share'     => array(
				'type'        => 'group_title',
				'description' => sprintf( esc_html__( 'Install %s plugin for this setting to work', 'stm_vehicles_listing' ), '<a href="https://wordpress.org/plugins/add-to-any/" target="_blank">AddtoAny Share Buttons</a>' ),
				'group'       => 'ended',
				'dependency'  => array(
					'key'   => 'show_share',
					'value' => 'not_empty',
				),
				'submenu'     => esc_html__( 'Page layout', 'stm_vehicles_listing' ),
			),
			'show_pdf'              =>
				array(
					'label'       => esc_html__( 'PDF brochure button', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'Let users download vehicle brochures in PDF format for offline viewing', 'stm_vehicles_listing' ),
					'type'        => 'checkbox',
					'submenu'     => esc_html__( 'Page layout', 'stm_vehicles_listing' ),
				),
			'show_stock'            =>
				array(
					'label'       => esc_html__( 'Listing ID', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'Each vehicle listing will have an ID', 'stm_vehicles_listing' ),
					'type'        => 'checkbox',
					'submenu'     => esc_html__( 'Page layout', 'stm_vehicles_listing' ),
				),
			'show_test_drive'       =>
				array(
					'label'       => esc_html__( 'Test drive button', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'Add a button allowing users to request test drives for listed vehicles directly from the page', 'stm_vehicles_listing' ),
					'type'        => 'checkbox',
					'submenu'     => esc_html__( 'Page layout', 'stm_vehicles_listing' ),
				),
			'show_certified_logo_1' =>
				array(
					'label'       => esc_html__( 'Certified Logo 1', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'Show certification logos or badges to indicate that certain vehicles meet specific quality or inspection standards.', 'stm_vehicles_listing' ),
					'type'        => 'checkbox',
					'submenu'     => esc_html__( 'Page layout', 'stm_vehicles_listing' ),
				),
			'show_certified_logo_2' =>
				array(
					'label'       => esc_html__( 'Certified Logo 2', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'Show certification logos or badges to indicate that certain vehicles meet specific quality or inspection standards.', 'stm_vehicles_listing' ),
					'type'        => 'checkbox',
					'submenu'     => esc_html__( 'Page layout', 'stm_vehicles_listing' ),
				),
			'show_added_date'       =>
				array(
					'label'       => esc_html__( 'Listing publication date', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'Show when listings were published', 'stm_vehicles_listing' ),
					'type'        => 'checkbox',
					'submenu'     => esc_html__( 'Page layout', 'stm_vehicles_listing' ),
				),
			'show_vin'              =>
				array(
					'label'       => esc_html__( 'VIN Number', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'Show the unique VIN for each vehicle', 'stm_vehicles_listing' ),
					'type'        => 'checkbox',
					'submenu'     => esc_html__( 'Page layout', 'stm_vehicles_listing' ),
				),
			'show_search_results'   =>
				array(
					'label'       => esc_html__( 'Search results', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'Show the search results on the page', 'stm_vehicles_listing' ),
					'type'        => 'checkbox',
					'submenu'     => esc_html__( 'Page layout', 'stm_vehicles_listing' ),
				),
			'show_registered'       =>
				array(
					'label'       => esc_html__( 'Vehicle production date', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'Show when vehicles were manufactured', 'stm_vehicles_listing' ),
					'type'        => 'checkbox',
					'submenu'     => esc_html__( 'Page layout', 'stm_vehicles_listing' ),
				),
			'stm_show_number'       =>
				array(
					'label'       => esc_html__( 'Show full phone number', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'Choose whether to display the complete contact number', 'stm_vehicles_listing' ),
					'type'        => 'checkbox',
					'submenu'     => esc_html__( 'Page layout', 'stm_vehicles_listing' ),
				),
			'stm_show_seller_email' =>
				array(
					'label'       => esc_html__( 'Email button', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'Add a button for users to directly contact sellers', 'stm_vehicles_listing' ),
					'type'        => 'checkbox',
					'submenu'     => esc_html__( 'Page layout', 'stm_vehicles_listing' ),
				),
			'stm_similar_query'     =>
				array(
					'label'       => esc_html__( 'Similar listings configuration', 'stm_vehicles_listing' ),
					'type'        => 'text',
					'description' => esc_html__( 'Specify the criteria for displaying similar listings based on listing categories. Add several criteria by commas, for example: make,condition', 'stm_vehicles_listing' ),
					'submenu'     => esc_html__( 'Page layout', 'stm_vehicles_listing' ),
				),
		);

		$conf = apply_filters( 'single_listing_layout', $conf );

		$conf = array_merge(
			$conf,
			array(
				'enable_carguru'         => array(
					'label'       => esc_html__( 'Car Gurus', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'Configure settings to add Car Gurus integration', 'stm_vehicles_listing' ),
					'type'        => 'checkbox',
					'submenu'     => esc_html__( 'Page layout', 'stm_vehicles_listing' ),
				),
				'carguru_style'          =>
					array(
						'label'       => esc_html__( 'Car Gurus Style', 'stm_vehicles_listing' ),
						'description' => esc_html__( 'Choose from different styles for integrating Car Gurus functionality into your listings', 'stm_vehicles_listing' ),
						'type'        => 'select',
						'options'     =>
							array(
								'STYLE1'  => 'Style 1',
								'STYLE2'  => 'Style 2',
								'BANNER1' => 'Banner 1 - 900 x 60 pixels',
								'BANNER2' => 'Banner 2 - 900 x 42 pixels',
								'BANNER3' => 'Banner 3 - 748 x 42 pixels',
								'BANNER4' => 'Banner 4 - 550 x 42 pixels',
								'BANNER5' => 'Banner 5 - 374 x 42 pixels',
							),
						'value'       => 'STYLE1',
						'dependency'  => array(
							'key'   => 'enable_carguru',
							'value' => 'not_empty',
						),
						'submenu'     => esc_html__( 'Page layout', 'stm_vehicles_listing' ),
					),
				'carguru_min_rating'     =>
					array(
						'label'       => esc_html__( 'Minimum rating label', 'stm_vehicles_listing' ),
						'description' => esc_html__( 'Set the minimum rating threshold for vehicles to be labeled according to Car Gurus standards', 'stm_vehicles_listing' ),
						'type'        => 'select',
						'options'     =>
							array(
								'GREAT_PRICE' => 'Great Price',
								'GOOD_PRICE'  => 'Good Price',
								'FAIR_PRICE'  => 'Fair Price',
							),
						'value'       => 'GREAT_PRICE',
						'dependency'  => array(
							'key'   => 'enable_carguru',
							'value' => 'not_empty',
						),
						'submenu'     => esc_html__( 'Page layout', 'stm_vehicles_listing' ),
					),
				'carguru_default_height' =>
					array(
						'label'       => esc_html__( 'Car Gurus widget height', 'stm_vehicles_listing' ),
						'description' => esc_html__( 'Specify the height of the Car Gurus widget in pixels', 'stm_vehicles_listing' ),
						'type'        => 'text',
						'value'       => '42',
						'dependency'  => array(
							'key'   => 'enable_carguru',
							'value' => 'not_empty',
						),
						'submenu'     => esc_html__( 'Page layout', 'stm_vehicles_listing' ),
					),
			)
		);

		return array_merge( $conf_for_merge, $conf );
	},
	20,
	1
);
