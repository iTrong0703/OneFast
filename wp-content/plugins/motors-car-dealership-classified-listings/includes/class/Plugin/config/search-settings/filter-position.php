<?php
add_filter(
	'search_settings_conf',
	function ( $conf_for_merge ) {
		$conf = array(
			'listing_filter_position' =>
				array(
					'label'       => esc_html__( 'Filter bar position', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'Choose where you want to place the filter bar', 'stm_vehicles_listing' ),
					'type'        => 'select',
					'value'       => 'left',
					'options'     => mvl_nuxy_positions(),
				),
		);

		return array_merge( $conf_for_merge, $conf );
	},
	10,
	1
);
