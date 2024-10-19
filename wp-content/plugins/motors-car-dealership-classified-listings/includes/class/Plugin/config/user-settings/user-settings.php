<?php
add_filter(
	'mvl_user_dealer_options',
	function ( $global_conf ) {
		$user_settings = array(
			'free_listing_submission' => array(
				'label'       => esc_html__( 'Free listing submission', 'stm_vehicles_listing' ),
				'description' => esc_html__( 'Enable users to submit listings for free', 'stm_vehicles_listing' ),
				'type'        => 'checkbox',
				'value'       => 'not_empty',
				'submenu'     => esc_html__( 'User', 'stm_vehicles_listing' ),
			),
			'user_post_limit'         =>
				array(
					'label'       => esc_html__( 'Listing publication limit', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'Set the maximum number of listings that can be published for free', 'stm_vehicles_listing' ),
					'type'        => 'text',
					'value'       => '3',
					'dependency'  => array(
						'key'   => 'free_listing_submission',
						'value' => 'not_empty',
					),
					'submenu'     => esc_html__( 'User', 'stm_vehicles_listing' ),
				),
			'user_post_images_limit'  =>
				array(
					'label'       => esc_html__( 'Image limit per listing:', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'Specify the maximum number of images that can be uploaded for each free listing', 'stm_vehicles_listing' ),
					'type'        => 'text',
					'value'       => '5',
					'dependency'  => array(
						'key'   => 'free_listing_submission',
						'value' => 'not_empty',
					),
					'submenu'     => esc_html__( 'User', 'stm_vehicles_listing' ),
				),
			'user_premoderation'      =>
				array(
					'label'       => esc_html__( 'Listing premoderation', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'The listing will need an admin approvement before publication', 'stm_vehicles_listing' ),
					'type'        => 'checkbox',
					'dependency'  => array(
						'key'   => 'free_listing_submission',
						'value' => 'not_empty',
					),
					'submenu'     => esc_html__( 'User', 'stm_vehicles_listing' ),
				),
			'send_email_to_user'      => array(
				'label'        => esc_html__( 'Send confirmation email', 'stm_vehicles_listing' ),
				'type'         => 'checkbox',
				'description'  => esc_html__( 'Send approval notification email. The email will be sent to the user if his listing is approved', 'stm_vehicles_listing' ),
				'submenu'      => esc_html__( 'User', 'stm_vehicles_listing' ),
				'dependency'   => array(
					array(
						'key'   => 'user_premoderation',
						'value' => 'not_empty',
					),
					array(
						'key'   => 'free_listing_submission',
						'value' => 'not_empty',
					),
				),
				'dependencies' => '&&',
			),
		);

		return array_merge( $global_conf, $user_settings );
	},
	10,
	1
);
