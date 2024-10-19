<?php
add_filter(
	'mvl_get_all_nuxy_config',
	function ( $global_conf ) {

		if ( ! apply_filters( 'motors_plugin_setting_classified_show', true ) ) {
			return $global_conf;
		}

		$user_settings = array(
			'new_user_registration' => array(
				'label'       => esc_html__( 'New User Registration', 'stm_vehicles_listing' ),
				'description' => esc_html__( 'There will be a form to sign up for new users', 'stm_vehicles_listing' ),
				'type'        => 'checkbox',
				'value'       => true,
				'submenu'     => esc_html__( 'General', 'stm_vehicles_listing' ),
			),
		);

		$user_settings = apply_filters( 'user_settings_main', $user_settings );

		$user_settings['enable_email_confirmation'] = array(
			'label'       => esc_html__( 'Email Confirmation', 'stm_vehicles_listing' ),
			'description' => esc_html__( 'All new registered users will get an e-mail for account verification', 'stm_vehicles_listing' ),
			'type'        => 'checkbox',
			'submenu'     => esc_html__( 'General', 'stm_vehicles_listing' ),
		);

		$conf = apply_filters( 'mvl_user_dealer_options', $user_settings );

		$conf = array(
			'name'   => esc_html__( 'Profile', 'stm_vehicles_listing' ),
			'fields' => $conf,
		);

		$global_conf[ mvl_modify_key( $conf['name'] ) ] = $conf;

		return $global_conf;
	},
	40,
	1
);
