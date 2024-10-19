<?php
add_filter(
	'search_settings_conf',
	function ( $conf_for_merge ) {
		$conf = array(
			'listing_grid_choices' =>
				array(
					'label'       => esc_html__( 'Dropdown for listings per page', 'stm_vehicles_listing' ),
					'type'        => 'text',
					'value'       => '9,12,18,27',
					'description' => esc_html__( 'Put the number of listings to choose for displaying per page, for example, 9,12,18,27', 'stm_vehicles_listing' ),
				),
		);

		return array_merge( $conf_for_merge, $conf );
	},
	50,
	1
);
