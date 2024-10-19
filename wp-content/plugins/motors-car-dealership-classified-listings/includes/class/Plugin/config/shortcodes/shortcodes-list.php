<?php
add_filter(
	'mvl_shortcodes_config',
	function ( $conf_for_merge ) {
		$one_step = array(
			'sc_group_title' => array(
				'type'        => 'group_title',
				'label'       => esc_html__( 'Shortcodes', 'stm_vehicles_listing' ),
				'description' => esc_html__( 'Click on shortcode for copy', 'stm_vehicles_listing' ),
				'group'       => 'started',
			),
			'sc_inventory'   => array(
				'label'    => esc_html__( 'Listings Page', 'stm_vehicles_listing' ),
				'type'     => 'text',
				'readonly' => 'false',
				'value'    => '[motors_listing_inventory]',
			),
			'sc_add_car'     => array(
				'label'    => esc_html__( 'Listing creation', 'stm_vehicles_listing' ),
				'type'     => 'text',
				'readonly' => 'false',
				'value'    => '[motors_add_listing_form]',
			),
			'sc_login'       => array(
				'label'    => esc_html__( 'Profile', 'stm_vehicles_listing' ),
				'type'     => 'text',
				'readonly' => 'false',
				'value'    => '[motors_login_page]',
			),
		);

		if ( apply_filters( 'motors_plugin_setting_classified_show', true ) ) {
			$shortcodes = array(
				'sc_add_car' => array(
					'label'    => esc_html__( 'Listing creation', 'stm_vehicles_listing' ),
					'type'     => 'text',
					'readonly' => 'false',
					'value'    => '[motors_add_listing_form]',
				),
				'sc_login'   => array(
					'label'    => esc_html__( 'Profile', 'stm_vehicles_listing' ),
					'type'     => 'text',
					'readonly' => 'false',
					'value'    => '[motors_login_page]',
				),
			);

			$one_step = array_merge( $one_step, $shortcodes );
		}

		$conf = array(
			'sc_compare'        => array(
				'label'    => esc_html__( 'Compare', 'stm_vehicles_listing' ),
				'type'     => 'text',
				'readonly' => 'false',
				'value'    => '[motors_compare_page]',
			),
			'sc_listing_search' => array(
				'label'       => esc_html__( 'Listing Search', 'stm_vehicles_listing' ),
				'type'        => 'text',
				'readonly'    => 'false',
				'value'       => "[motors_listing_search show_amount='yes' filter_fields='make,serie,ca-year']",
				'description' => '<ul><li>"show_amount" - used for showing amount listings in each category </li><li>"filter_fields" - write category slug by comma separator for show filter fields </li></ul>',
			),
			'sc_icon_filter'    => array(
				'label'       => esc_html__( 'Icon Filter', 'stm_vehicles_listing' ),
				'type'        => 'text',
				'readonly'    => 'false',
				'value'       => "[motors_listing_icon_filter title='Browse by Make' as_carousel='yes' filter_selected='make' columns='6' visible_items='5']",
				'description' => '<ul>
					<li>"title" - Widget Title</li>
					<li>"as_carousel" - Showing widget as carousel. Remove param for default view</li>
					<li>"filter_selected" - Use slug for select category</li>
					<li>"columns" - Used for default view</li>
					<li>"visible_items" - Visible items</li>
				</ul>',
			),
			'sc_listing_tabs'   => array(
				'label'       => esc_html__( 'Listing Tabs', 'stm_vehicles_listing' ),
				'type'        => 'text',
				'readonly'    => 'false',
				'value'       => "[motors_listings_tabs title='New/Used Cars' columns='3' popular_tab='yes' recent_tab='yes' featured_tab='yes']",
				'description' => '<ul>
					<li>"title" - Widget Title</li>
					<li>"columns" - Columns for view (2,3,4,6)</li>
					<li>"popular_tab" - Use "yes" for showing tab, remove param for hidden tab</li>
					<li>"recent_tab" - Use "yes" for showing tab, remove param for hidden tab</li>
					<li>"featured_tab" - Use "yes" for showing tab, remove param for hidden tab</li>
				</ul>',
				'group'       => 'ended',
			),
		);

		return array_merge( $one_step, $conf );
	},
	10,
	1
);
