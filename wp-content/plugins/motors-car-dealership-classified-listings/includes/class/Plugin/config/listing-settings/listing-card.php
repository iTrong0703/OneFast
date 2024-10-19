<?php
add_filter(
	'listing_settings_conf',
	function ( $conf_for_merge ) {
		$grid_title_dependency = apply_filters(
			'grid_title_dependency',
			array(
				'dependency' => array(
					'key'   => 'listing_view_type',
					'value' => 'grid',
				),
			)
		);
		$conf                  = array(
			'listing_directory_title_frontend'     =>
				array(
					'label'       => esc_html__( 'Autogenerate a listing title', 'stm_vehicles_listing' ),
					'type'        => 'text',
					'value'       => '{make} {serie} {ca-year}',
					'description' => esc_html__( 'The title will be generated based on the listing categories. Put the category in curly brackets, for example, {make} {serie} {ca-year}. Leave this field empty if you want a custom title to be added to each listing', 'stm_vehicles_listing' ),
					'submenu'     => esc_html__( 'Listing info card', 'stm_vehicles_listing' ),
				),
			'listing_view_type'                    =>
				array(
					'label'       => esc_html__( 'Default  desktop view for the listing page', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'Choose how you want to display your listing page by default on desktop', 'stm_vehicles_listing' ),
					'type'        => 'radio',
					'options'     =>
						array(
							'grid' => 'Grid',
							'list' => 'List',
						),
					'value'       => 'list',
					'submenu'     => esc_html__( 'Listing info card', 'stm_vehicles_listing' ),
				),
			'show_generated_title_as_label'        =>
				array(
					'label'       => esc_html__( 'Show the First Two Words of the Listing Title as a Badge', 'stm_vehicles_listing' ),
					'type'        => 'checkbox',
					'description' => esc_html__( 'Listings Page and Listing Detail Page', 'stm_vehicles_listing' ),
					'dependency'  =>
						array(
							'key'   => 'listing_view_type',
							'value' => 'list',
						),
					'submenu'     => esc_html__( 'Listing info card', 'stm_vehicles_listing' ),
				),
			'listing_view_type_mobile'             =>
				array(
					'label'       => esc_html__( 'Default mobile view for the listing page', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'Choose how you want to display your listing page by default on mobile devices', 'stm_vehicles_listing' ),
					'type'        => 'radio',
					'options'     =>
						array(
							'grid' => 'Grid',
							'list' => 'List',
						),
					'value'       => 'grid',
					'submenu'     => esc_html__( 'Listing info card', 'stm_vehicles_listing' ),
				),
			'grid_title_max_length'                =>
				array_merge(
					array(
						'label'       => esc_html__( 'Listing title max length', 'stm_vehicles_listing' ),
						'description' => esc_html__( 'If the title will exceed the max length for symbols they\'ll be cropped with three dots displayed', 'stm_vehicles_listing' ),
						'type'        => 'text',
						'value'       => '44',
						'submenu'     => esc_html__( 'Listing info card', 'stm_vehicles_listing' ),
					),
					$grid_title_dependency,
				),
			'listing_directory_enable_dealer_info' =>
				array(
					'label'      => esc_html__( 'Author Details', 'stm_vehicles_listing' ),
					'type'       => 'checkbox',
					'dependency' => array(
						'key'   => 'listing_view_type',
						'value' => 'list',
					),
					'submenu'    => esc_html__( 'Listing info card', 'stm_vehicles_listing' ),
				),
			'show_listing_stock'                   =>
				array(
					'label'      => esc_html__( 'Listing ID', 'stm_vehicles_listing' ),
					'type'       => 'checkbox',
					'dependency' => array(
						'key'   => 'listing_view_type',
						'value' => 'list',
					),
					'submenu'    => esc_html__( 'Listing info card', 'stm_vehicles_listing' ),
				),
			'show_listing_test_drive'              =>
				array(
					'label'      => esc_html__( 'Test Drive Button', 'stm_vehicles_listing' ),
					'type'       => 'checkbox',
					'dependency' => array(
						'key'   => 'listing_view_type',
						'value' => 'list',
					),
					'submenu'    => esc_html__( 'Listing info card', 'stm_vehicles_listing' ),
				),
			'show_listing_compare'                 =>
				array(
					'label'       => esc_html__( 'Compare button', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'The listing will have a separate button so that users can compare the separate vehicles', 'stm_vehicles_listing' ),
					'type'        => 'checkbox',
					'submenu'     => esc_html__( 'Listing info card', 'stm_vehicles_listing' ),
				),
			'enable_favorite_items'                =>
				array(
					'label'       => esc_html__( 'Add to favorites button', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'When hovering over the listing image users will have the option to save the listing to their favorites', 'stm_vehicles_listing' ),
					'type'        => 'checkbox',
					'submenu'     => esc_html__( 'Listing info card', 'stm_vehicles_listing' ),
				),
			'show_listing_share'                   =>
				array(
					'label'      => esc_html__( 'Share Listing Button', 'stm_vehicles_listing' ),
					'type'       => 'checkbox',
					'dependency' => array(
						'key'   => 'listing_view_type',
						'value' => 'list',
					),
					'submenu'    => esc_html__( 'Listing info card', 'stm_vehicles_listing' ),
				),
			'show_listing_pdf'                     =>
				array(
					'label'      => esc_html__( 'PDF Brochure Button', 'stm_vehicles_listing' ),
					'type'       => 'checkbox',
					'dependency' => array(
						'key'   => 'listing_view_type',
						'value' => 'list',
					),
					'submenu'    => esc_html__( 'Listing info card', 'stm_vehicles_listing' ),
				),
			'show_listing_quote'                   =>
				array(
					'label'      => esc_html__( 'Request Listing Price Button', 'stm_vehicles_listing' ),
					'type'       => 'checkbox',
					'dependency' => array(
						'key'   => 'listing_view_type',
						'value' => 'list',
					),
					'submenu'    => esc_html__( 'Listing info card', 'stm_vehicles_listing' ),
				),
			'show_listing_trade'                   =>
				array(
					'label'      => esc_html__( 'Trade-In Button', 'stm_vehicles_listing' ),
					'type'       => 'checkbox',
					'dependency' => array(
						'key'   => 'listing_view_type',
						'value' => 'list',
					),
					'submenu'    => esc_html__( 'Listing info card', 'stm_vehicles_listing' ),
				),
		);

		return array_merge( $conf_for_merge, $conf );
	},
	40,
	1
);
