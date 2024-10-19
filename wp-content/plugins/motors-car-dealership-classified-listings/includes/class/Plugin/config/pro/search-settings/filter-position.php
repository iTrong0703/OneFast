<?php
add_filter(
	'search_settings_conf',
	function ( $conf_for_merge ) {
		$conf = array(
			'listing_list_sort_slug' =>
				array(
					'label'      => esc_html__( 'Sort by Category', 'stm_vehicles_listing' ),
					'type'       => 'text',
					'value'      => 'make',
					'dependency' => array(
						'key'   => 'listing_filter_position',
						'value' => 'horizontal',
					),
				),
		);

		return array_merge( $conf_for_merge, $conf );
	},
	11,
	1
);
