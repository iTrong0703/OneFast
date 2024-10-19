<?php
add_filter(
	'me_search_results_settings_conf',
	function ( $global_conf ) {
		$conf = apply_filters( 'listing_settings_conf', array() );

		$conf = array(
			'name'   => esc_html__( 'Search results page', 'stm_vehicles_listing' ),
			'fields' => apply_filters( 'me_listing_settings_conf', $conf ),
		);

		$global_conf['listing_settings'] = $conf;

		return $global_conf;
	},
	10,
	1
);
