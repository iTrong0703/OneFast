<?php
add_filter(
	'listing_settings_conf',
	function ( $conf_for_merge ) {
		$conf = array(
			'show_listing_certified_logo_1' =>
				array(
					'label'      => esc_html__( 'Show Certified Logo 1', 'stm_vehicles_listing' ),
					'type'       => 'checkbox',
					'dependency' => array(
						'key'   => 'listing_view_type',
						'value' => 'list',
					),
					'submenu'    => esc_html__( 'Listing info card', 'stm_vehicles_listing' ),
				),
			'show_listing_certified_logo_2' =>
				array(
					'label'      => esc_html__( 'Show Certified Logo 2', 'stm_vehicles_listing' ),
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
	46,
	1
);
