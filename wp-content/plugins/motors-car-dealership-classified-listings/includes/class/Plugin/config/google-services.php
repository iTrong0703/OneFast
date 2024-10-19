<?php
add_filter(
	'mvl_get_all_nuxy_config',
	function ( $global_conf ) {
		$google_conf = apply_filters( 'mvl_google_services_config', array() );

		$google_conf = array(
			'name'   => 'Google Services',
			'fields' => $google_conf,
		);

		$global_conf['google_services_tab'] = $google_conf;

		return $global_conf;
	},
	60,
	1
);
