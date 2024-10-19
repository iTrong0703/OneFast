<?php
add_filter(
	'search_settings_conf',
	function ( $conf_for_merge ) {
		$conf = array(
			'sort_options' =>
				array(
					'label'   => esc_html__( 'Filter by listing categories', 'stm_vehicles_listing' ),
					'type'    => 'multi_checkbox',
					'options' => mvl_nuxy_sort_options(),
				),
		);

		return array_merge( $conf_for_merge, $conf );
	},
	23,
	1
);
