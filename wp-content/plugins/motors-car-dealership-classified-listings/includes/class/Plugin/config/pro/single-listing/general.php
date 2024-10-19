<?php
add_filter(
	'listing_img_settings',
	function ( $conf_for_merge ) {
		if ( ! apply_filters( 'is_mvl_pro', false ) ) {
			$conf = array(
				'optimize_image_settings_banner' => array(
					'type'    => 'pro_banner',
					'label'   => esc_html__( 'Optimizing Image Settings', 'stm_vehicles_listing' ),
					//'img'   => STM_LISTINGS_URL . '/assets/images/pro/payouts.png',
					'desc'    => esc_html__( 'Optimize the size of listing images uploaded by the user', 'stm_vehicles_listing' ),
					'submenu' => esc_html__( 'General', 'stm_vehicles_listing' ),
				),
			);
		} else {
			$conf = array(
				'user_image_crop_optimized' => array(
					'type'    => 'group_title',
					'label'   => esc_html__( 'Optimizing Image', 'stm_vehicles_listing' ),
					'submenu' => esc_html__( 'General', 'stm_vehicles_listing' ),
					'group'   => 'started',
				),
				'user_image_crop_checkbox'  => array(
					'label'       => esc_html__( 'Image cropping', 'stm_vehicles_listing' ),
					'description' => esc_html__( 'Customize the dimensions of uploaded images', 'stm_vehicles_listing' ),
					'type'        => 'checkbox',
					'value'       => false,
					'submenu'     => esc_html__( 'General', 'stm_vehicles_listing' ),
				),
				'user_image_crop_width'     =>
					array(
						'label'        => esc_html__( 'Width for cropped images', 'stm_vehicles_listing' ),
						'description'  => esc_html__( 'Set the desired width for cropped images', 'stm_vehicles_listing' ),
						'type'         => 'text',
						'value'        => '800',
						'dependency'   => array(
							array(
								'key'   => 'user_image_crop_checkbox',
								'value' => 'not_empty',
							),
						),
						'dependencies' => '&&',
						'submenu'      => esc_html__( 'General', 'stm_vehicles_listing' ),
					),
				'user_image_crop_height'    =>
					array(
						'label'        => esc_html__( 'Height for cropped images', 'stm_vehicles_listing' ),
						'description'  => esc_html__( 'Define the preferred height for cropped images', 'stm_vehicles_listing' ),
						'type'         => 'text',
						'value'        => '600',
						'dependency'   => array(
							array(
								'key'   => 'user_image_crop_checkbox',
								'value' => 'not_empty',
							),
						),
						'dependencies' => '&&',
						'submenu'      => esc_html__( 'General', 'stm_vehicles_listing' ),
						'group'        => 'ended',
					),
			);
		}

		return array_merge( $conf_for_merge, $conf );
	},
	14,
	1
);
