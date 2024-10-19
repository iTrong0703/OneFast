<?php
add_filter(
	'monetization_settings',
	function ( $conf_for_merge ) {

		if ( apply_filters( 'disable_monetization_sell_online', false ) || ! apply_filters( 'is_mvl_pro', false ) || ! apply_filters( 'stm_is_motors_theme', false ) ) {
			return $conf_for_merge;
		}

		$conf = array(
			'enable_woo_online' => array(
				'label'       => esc_html__( 'Enable online listing sales', 'stm_vehicles_listing' ),
				'description' => esc_html__( 'Offer the option for users to sell their listings online. WooCommerce should be set up for this setting', 'stm_vehicles_listing' ),
				'type'        => 'checkbox',
				'submenu'     => esc_html__( 'Monetization', 'stm_vehicles_listing' ),
			),
		);

		return array_merge( $conf_for_merge, $conf );
	},
	50,
	1
);
