<?php
add_filter(
	'mvl_user_dealer_options',
	function ( $global_conf ) {

		if ( ! apply_filters( 'is_mvl_pro', false ) ) {
			$conf = array(
				'dealer_settings_banner' => array(
					'type'    => 'pro_banner',
					'label'   => esc_html__( 'Dealer Settings', 'stm_vehicles_listing' ),
					//'img'   => STM_LISTINGS_URL . '/assets/images/pro/payouts.png',
					'desc'    => esc_html__( 'Manage settings for users with the Dealer role', 'stm_vehicles_listing' ),
					'submenu' => esc_html__( 'Dealer', 'stm_vehicles_listing' ),
				),
			);
		} else {
			$conf = array(
				'dealer_free_listing_submission' => array(
					'label'       => esc_html__( 'Free listing submission', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'Enable dealers to submit listings for free', 'stm_vehicles_listing' ),
					'type'        => 'checkbox',
					'value'       => 'not_empty',
					'submenu'     => esc_html__( 'Dealer', 'stm_vehicles_listing' ),
				),
				'dealer_post_limit'              => array(
					'label'       => esc_html__( 'Listing publication limit', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'Set the maximum number of listings that can be published for free', 'stm_vehicles_listing' ),
					'type'        => 'text',
					'value'       => '50',
					'dependency'  => array(
						'key'   => 'dealer_free_listing_submission',
						'value' => 'not_empty',
					),
					'submenu'     => esc_html__( 'Dealer', 'stm_vehicles_listing' ),
				),
				'dealer_post_images_limit'       => array(
					'label'       => esc_html__( 'Image limit per listing:', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'Specify the maximum number of images that can be uploaded for each free listing', 'stm_vehicles_listing' ),
					'type'        => 'text',
					'value'       => '10',
					'dependency'  => array(
						'key'   => 'dealer_free_listing_submission',
						'value' => 'not_empty',
					),
					'submenu'     => esc_html__( 'Dealer', 'stm_vehicles_listing' ),
				),
				'dealer_premoderation'           => array(
					'label'       => esc_html__( 'Listing premoderation', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'The listing will need an admin approvement before publication', 'stm_vehicles_listing' ),
					'type'        => 'checkbox',
					'dependency'  => array(
						'key'   => 'dealer_free_listing_submission',
						'value' => 'not_empty',
					),
					'submenu'     => esc_html__( 'Dealer', 'stm_vehicles_listing' ),
				),
				'send_email_to_dealer'           => array(
					'label'        => esc_html__( 'Send confirmation email', 'stm_vehicles_listing' ),
					'type'         => 'checkbox',
					'description'  => 'Send approval notification email. The email will be sent to the dealer if his listing is approved',
					'dependency'   => array(
						array(
							'key'   => 'dealer_premoderation',
							'value' => 'not_empty',
						),
						array(
							'key'   => 'dealer_free_listing_submission',
							'value' => 'not_empty',
						),
					),
					'dependencies' => '&&',
					'submenu'      => esc_html__( 'Dealer', 'stm_vehicles_listing' ),
				),
				'dealer_rating_group_start'      => array(
					'type'    => 'group_title',
					'label'   => esc_html__( 'Dealer rating', 'stm_vehicles_listing' ),
					'submenu' => esc_html__( 'Dealer', 'stm_vehicles_listing' ),
					'group'   => 'started',
				),
				'dealer_rate_1'                  => array(
					'label'   => esc_html__( 'Customer service rating label', 'stm_vehicles_listing' ),
					'type'    => 'text',
					'value'   => 'Customer Service',
					'submenu' => esc_html__( 'Dealer', 'stm_vehicles_listing' ),
				),
				'dealer_rate_2'                  => array(
					'label'   => esc_html__( 'Buying process rating label', 'stm_vehicles_listing' ),
					'type'    => 'text',
					'value'   => 'Buying Process',
					'submenu' => esc_html__( 'Dealer', 'stm_vehicles_listing' ),
				),
				'dealer_rate_3'                  => array(
					'label'   => esc_html__( 'Overall experience rating label', 'stm_vehicles_listing' ),
					'type'    => 'text',
					'value'   => 'Overall Experience',
					'submenu' => esc_html__( 'Dealer', 'stm_vehicles_listing' ),
				),
				'dealer_review_moderation'       => array(
					'label'       => esc_html__( 'Dealer review moderation', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'Enable this option to review and approve dealer reviews before they are publicly visible on the website', 'stm_vehicles_listing' ),
					'type'        => 'checkbox',
					'submenu'     => esc_html__( 'Dealer', 'stm_vehicles_listing' ),
					'group'       => 'ended',
				),
			);
		}

		return array_merge( $global_conf, $conf );
	},
	50,
	1
);
