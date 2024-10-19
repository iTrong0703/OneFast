<?php
add_filter(
	'mvl_get_all_nuxy_config',
	function ( $global_conf ) {

		$conf = apply_filters( 'pages_settings_main', array() );

		$conf = array(
			'name'   => esc_html__( 'Pages', 'stm_vehicles_listing' ),
			'fields' => $conf,
		);

		$global_conf['pages_settings'] = $conf;

		return $global_conf;
	},
	50,
	1
);
