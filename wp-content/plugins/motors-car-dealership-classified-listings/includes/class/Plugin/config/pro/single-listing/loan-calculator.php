<?php
add_filter(
	'single_listing_conf',
	function ( $conf_for_merge ) {
		if ( ! apply_filters( 'is_mvl_pro', false ) ) {
			$conf = array(
				'loan_calculator_settings_banner' => array(
					'type'    => 'pro_banner',
					'label'   => esc_html__( 'Loan Calculator Settings', 'stm_vehicles_listing' ),
					//'img'   => STM_LISTINGS_URL . '/assets/images/pro/payouts.png',
					'desc'    => esc_html__( 'Calculate auto loans by entering the item price and loan conditions', 'stm_vehicles_listing' ),
					'submenu' => esc_html__( 'Loan calculator', 'stm_vehicles_listing' ),
				),
			);
		} else {
			$conf = array(
				'default_interest_rate'        =>
					array(
						'label'       => esc_html__( 'Default interest rate', 'stm_vehicles_listing' ),
						'description' => esc_html__( 'Set the default interest rate to be used in the loan calculations', 'stm_vehicles_listing' ),
						'type'        => 'text',
						'submenu'     => esc_html__( 'Loan calculator', 'stm_vehicles_listing' ),
					),
				'default_month_period'         =>
					array(
						'label'       => esc_html__( 'Default loan term', 'stm_vehicles_listing' ),
						'description' => esc_html__( 'Define the default loan term in months', 'stm_vehicles_listing' ),
						'type'        => 'text',
						'submenu'     => esc_html__( 'Loan calculator', 'stm_vehicles_listing' ),
					),
				'default_down_payment_type'    =>
					array(
						'label'       => esc_html__( 'Default down payment method', 'stm_vehicles_listing' ),
						'description' => esc_html__( 'Choose the default type for down payments: a static amount or a percentage of the vehicle\'s price.', 'stm_vehicles_listing' ),
						'type'        => 'radio',
						'options'     =>
							array(
								'static'  => 'Static',
								'percent' => 'Percent',
							),
						'value'       => 'static',
						'submenu'     => esc_html__( 'Loan calculator', 'stm_vehicles_listing' ),
					),
				'default_down_payment'         =>
					array(
						'label'       => esc_html__( 'Down payment amount', 'stm_vehicles_listing' ),
						'description' => esc_html__( 'Specify the down payment amount', 'stm_vehicles_listing' ),
						'type'        => 'number',
						'submenu'     => esc_html__( 'Loan calculator', 'stm_vehicles_listing' ),
					),
				'default_down_payment_percent' =>
					array(
						'label'       => esc_html__( 'Down payment percent', 'stm_vehicles_listing' ),
						'description' => esc_html__( 'Enter the desired percentage to be paid upfront as a down payment', 'stm_vehicles_listing' ),
						'type'        => 'number',
						'value'       => '0',
						'submenu'     => esc_html__( 'Loan calculator', 'stm_vehicles_listing' ),
					),
			);
		}

		return array_merge( $conf_for_merge, $conf );
	},
	30,
	1
);
