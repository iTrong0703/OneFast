<?php
add_filter(
	'monetization_settings',
	function ( $conf_for_merge ) {

		if ( ! apply_filters( 'stm_is_motors_theme', false ) || apply_filters( 'disable_monetization_subscription', false ) || ! apply_filters( 'is_mvl_pro', false ) ) {
			return $conf_for_merge;
		}

		$conf = array(
			'enable_plans' =>
				array(
					'label'       => esc_html__( 'Subscription model', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'Enable subscription-based access. Subscription and WooCommerce should be set up for this setting', 'stm_vehicles_listing' ),
					'type'        => 'checkbox',
					'submenu'     => esc_html__( 'Monetization', 'stm_vehicles_listing' ),
				),
		);

		return array_merge( $conf_for_merge, $conf );
	},
	10,
	1
);
