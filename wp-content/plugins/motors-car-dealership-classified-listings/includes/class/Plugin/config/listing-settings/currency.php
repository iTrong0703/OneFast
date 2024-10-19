<?php

add_filter(
	'listing_settings_conf',
	function ( $conf_for_merge ) {
		$conf = array(
			'price_currency_name'     =>
				array(
					'label'       => esc_html__( 'Currency Name', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'Put the currency you want to add', 'stm_vehicles_listing' ),
					'type'        => 'text',
					'value'       => 'USD',
					'submenu'     => esc_html__( 'Currency', 'stm_vehicles_listing' ),
				),
			'price_currency'          =>
				array(
					'label'       => esc_html__( 'Currency Symbol', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'Add a symbol to the currency', 'stm_vehicles_listing' ),
					'type'        => 'text',
					'value'       => '$',
					'submenu'     => esc_html__( 'Currency', 'stm_vehicles_listing' ),
				),
			'price_currency_position' =>
				array(
					'label'       => esc_html__( 'Currency Position', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'Define where you want to place the currency', 'stm_vehicles_listing' ),
					'type'        => 'select',
					'options'     =>
						array(
							'left'  => 'Left',
							'right' => 'Right',
						),
					'value'       => 'left',
					'submenu'     => esc_html__( 'Currency', 'stm_vehicles_listing' ),
				),
			'price_delimeter'         =>
				array(
					'label'       => sprintf( esc_html__( 'Decimal %s thousands separators', 'stm_vehicles_listing' ), '&' ),
					'description' => esc_html__( 'Add a separator for thousands and decimals', 'stm_vehicles_listing' ),
					'type'        => 'text',
					'value'       => ' ',
					'submenu'     => esc_html__( 'Currency', 'stm_vehicles_listing' ),
				),
		);

		return array_merge( $conf_for_merge, $conf );
	},
	30,
	1
);
