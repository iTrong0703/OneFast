<?php
add_filter(
	'mvl_get_all_nuxy_config',
	function ( $global_conf ) {

		$conf = apply_filters( 'monetization_settings', array() );

		if ( empty( $conf ) ) {
			return $global_conf;
		}

		$conf = array(
			'name'   => esc_html__( 'Monetization', 'stm_vehicles_listing' ),
			'fields' => $conf,
		);

		$global_conf['monetization'] = $conf;

		return $global_conf;
	},
	50,
	1
);
