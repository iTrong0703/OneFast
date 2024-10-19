<?php
add_filter(
	'search_settings_conf',
	function ( $conf_for_merge ) {
		$conf = array(
			'default_sort_by' =>
				array(
					'label'       => esc_html__( 'Default sorting by', 'stm_vehicles_listing' ),
					'type'        => 'select',
					'value'       => 'date_high',
					'options'     => apply_filters( 'mvl_nuxy_sortby', array() ),
					'description' => esc_html__( 'Select how you want the listings to be sorted', 'stm_vehicles_listing' ),
				),
		);

		return array_merge( $conf_for_merge, $conf );
	},
	20,
	1
);
