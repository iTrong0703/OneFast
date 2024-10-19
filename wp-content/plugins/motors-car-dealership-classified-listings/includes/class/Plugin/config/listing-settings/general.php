<?php
add_filter(
	'listing_settings_conf',
	function ( $conf_for_merge ) {
		$conf = array(
			'listing_directory_title_default' =>
				array(
					'label'       => esc_html__( 'Search result heading', 'stm_vehicles_listing' ),
					'type'        => 'text',
					'value'       => 'Cars for sale',
					'description' => esc_html__( 'The heading will be shown on the Listings page before the search results', 'stm_vehicles_listing' ),
					'submenu'     => esc_html__( 'General', 'stm_vehicles_listing' ),
				),
			'featured_listings_list_amount'   =>
				array(
					'label'   => esc_html__( 'Number of Featured Listings List', 'stm_vehicles_listing' ),
					'group'   => 'started',
					'type'    => 'number',
					'value'   => '3',
					'submenu' => esc_html__( 'General', 'stm_vehicles_listing' ),
				),
			'featured_listings_grid_amount'   =>
				array(
					'label'   => esc_html__( 'Number of Featured Listings Grid', 'stm_vehicles_listing' ),
					'type'    => 'number',
					'value'   => '3',
					'submenu' => esc_html__( 'General', 'stm_vehicles_listing' ),
					'group'   => 'ended',
				),
		);

		return array_merge( $conf_for_merge, $conf );
	},
	20,
	1
);
