<?php
if ( file_exists( STM_LISTINGS_PATH . '/includes/lib/stm-mailchimp-integration/stm-mailchimp.php' ) ) {
	require_once STM_LISTINGS_PATH . '/includes/lib/stm-mailchimp-integration/stm-mailchimp.php';
	$plugin_pages   = array(
		'mvl_plugin_settings',
	);
	$post_types     = array(
		'listings',
		'test_drive_request',
	);
	$plugin_actions = array(
		'stm_mailchimp_integration_add_stm_vehicles_listing',
		'stm_mailchimp_integration_remove_stm_vehicles_listing',
		'stm_mailchimp_integration_not_allowed_stm_vehicles_listing',
	);
	if ( stm_mailchimp_is_show_page( $plugin_actions, $plugin_pages, $post_types ) !== false ) {
		if ( ! function_exists( 'is_plugin_active' ) ) {
			include_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		add_action( 'plugins_loaded', 'init_mvl_mailchimp', 10, 1 );
		function init_mvl_mailchimp() {
			$is_pro_exist = false;
			$init_data    = array(
				'plugin_title' => 'Motors – Car Dealer, Classifieds & Listing',
				'plugin_name'  => 'stm_vehicles_listing',
				'is_pro'       => $is_pro_exist,
			);
			if ( function_exists( 'wp_get_current_user' ) ) {
				stm_mailchimp_admin_init( $init_data );
			}
		}
	}
}
