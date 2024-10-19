<?php
add_filter(
	'mvl_google_services_config',
	function ( $conf ) {
		$recaptcha_conf = array(
			'enable_recaptcha'     => array(
				'label'       => esc_html__( 'reCaptcha', 'stm_vehicles_listing' ),
				'type'        => 'checkbox',
				'description' => sprintf( esc_html__( 'Get the keys from this %s and integrate reCaptcha', 'stm_vehicles_listing' ), '<a href="https://www.google.com/recaptcha/admin" target="_blank">site</a>' ),
				'submenu'     => esc_html__( 'reCaptcha', 'stm_vehicles_listing' ),
				'group'       => 'started',
			),
			'recaptcha_public_key' => array(
				'label'      => esc_html__( 'Public key', 'stm_vehicles_listing' ),
				'type'       => 'text',
				'submenu'    => esc_html__( 'reCaptcha', 'stm_vehicles_listing' ),
				'dependency' => array(
					'key'   => 'enable_recaptcha',
					'value' => 'not_empty',
				),
			),
			'recaptcha_secret_key' => array(
				'label'      => esc_html__( 'Secret key', 'stm_vehicles_listing' ),
				'type'       => 'text',
				'submenu'    => esc_html__( 'reCaptcha', 'stm_vehicles_listing' ),
				'dependency' => array(
					'key'   => 'enable_recaptcha',
					'value' => 'not_empty',
				),
				'group'      => 'ended',
			),
		);

		return array_merge( $conf, $recaptcha_conf );
	},
	20,
	1
);
