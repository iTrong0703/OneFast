<?php
add_filter(
	'mvl_get_all_nuxy_listing_details_config',
	function ( $global_conf ) {
		$conf = apply_filters( 'single_listing_conf', array() );

		$conf_name = 'Listing page details';
		$conf_key  = 'single_listing';

		$conf = array(
			'name'   => $conf_name,
			'fields' => apply_filters( 'me_car_settings_conf', $conf ),
		);

		$global_conf[ $conf_key ] = $conf;

		return $global_conf;
	},
	30,
	1
);
