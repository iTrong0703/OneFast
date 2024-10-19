<?php
add_filter(
	'mvl_get_all_nuxy_config',
	function ( $global_conf ) {
		$shortcodes_conf = apply_filters( 'mvl_shortcodes_config', array() );

		$shortcodes_conf = array(
			'name'   => 'Shortcodes',
			'fields' => $shortcodes_conf,
		);

		$global_conf['shortcodes_tab'] = $shortcodes_conf;

		return $global_conf;
	},
	70,
	1
);
