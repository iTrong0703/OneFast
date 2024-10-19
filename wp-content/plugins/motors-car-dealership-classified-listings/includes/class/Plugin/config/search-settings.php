<?php
add_filter(
	'me_search_and_filter_settings_conf',
	function ( $global_conf ) {
		$conf = apply_filters( 'search_settings_conf', array() );

		$conf = array(
			'name'   => esc_html__( 'Search filters', 'stm_vehicles_listing' ),
			'fields' => $conf,
		);

		$global_conf['search_settings'] = $conf;

		return $global_conf;
	},
	20,
	1
);
