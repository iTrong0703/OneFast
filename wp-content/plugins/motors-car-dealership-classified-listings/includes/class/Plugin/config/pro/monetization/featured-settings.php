<?php
add_filter(
	'monetization_settings',
	function ( $conf_for_merge ) {

		if ( apply_filters( 'disable_monetization_featured', false ) ) {
			return $conf_for_merge;
		}

		if ( ! apply_filters( 'is_mvl_pro', false ) ) {
			$conf = array(
				'monetization_settings_banner' => array(
					'type'    => 'pro_banner',
					'label'   => esc_html__( 'Monetize Settings', 'stm_vehicles_listing' ),
					//'img'   => STM_LISTINGS_URL . '/assets/images/pro/payouts.png',
					'desc'    => esc_html__( 'Generate revenue by setting listing fees, charging for submissions, and offering featured listings for increased visibility', 'stm_vehicles_listing' ),
					'submenu' => esc_html__( 'Monetization', 'stm_vehicles_listing' ),
				),
			);
		} else {
			$conf = array(
				'dealer_payments_for_featured_listing' => array(
					'label'       => esc_html__( 'Monetize featured listings', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'Offer featured listing options to users to appear at the top of search results and highlight', 'stm_vehicles_listing' ),
					'type'        => 'checkbox',
					'submenu'     => esc_html__( 'Monetization', 'stm_vehicles_listing' ),
				),
				'featured_listing_default_badge'       => array(
					'label'       => esc_html__( 'Featured listing label', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'Define the label applied to featured listings', 'stm_vehicles_listing' ),
					'type'        => 'text',
					'value'       => '0',
					'dependency'  => array(
						'key'   => 'dealer_payments_for_featured_listing',
						'value' => 'not_empty',
					),
					'submenu'     => esc_html__( 'Monetization', 'stm_vehicles_listing' ),
				),
				'featured_listing_price'               => array(
					'label'       => esc_html__( 'Price', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'Set the price for featuring a listing', 'stm_vehicles_listing' ),
					'type'        => 'text',
					'value'       => '0',
					'dependency'  => array(
						'key'   => 'dealer_payments_for_featured_listing',
						'value' => 'not_empty',
					),
					'submenu'     => esc_html__( 'Monetization', 'stm_vehicles_listing' ),
				),
				'featured_listing_period'              => array(
					'label'       => esc_html__( 'Duration', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'Specify the duration for which a listing will be featured in days.', 'stm_vehicles_listing' ),
					'type'        => 'text',
					'value'       => '30',
					'dependency'  => array(
						'key'   => 'dealer_payments_for_featured_listing',
						'value' => 'not_empty',
					),
					'submenu'     => esc_html__( 'Monetization', 'stm_vehicles_listing' ),
				),
			);
		}

		return array_merge( $conf_for_merge, $conf );
	},
	30,
	1
);
