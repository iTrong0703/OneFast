<?php

namespace MotorsVehiclesListing\Plugin;

use MotorsVehiclesListing\Plugin\MVL_Const;

class PluginOptions {
	private static $instance   = null;
	public static $options_map = array();

	private function __construct() {
		$plugin_opts           = get_option( MVL_Const::MVL_PLUGIN_OPT_NAME, array() );
		$add_car_fomr_opts     = get_option( MVL_Const::ADD_CAR_FORM_OPT_NAME, array() );
		$filter_opts           = get_option( MVL_Const::FILTER_OPT_NAME, array() );
		$listing_details_opts  = get_option( MVL_Const::LISTING_DETAILS_OPT_NAME, array() );
		$search_results_opts   = get_option( MVL_Const::SEARCH_RESULTS_OPT_NAME, array() );
		$listing_template_opts = get_option( MVL_Const::LISTING_TEMPLATE_OPT_NAME, array() );

		self::$options_map = array_merge( $plugin_opts, $add_car_fomr_opts, $filter_opts, $listing_details_opts, $search_results_opts, $listing_template_opts );
	}

	public static function getInstance() {
		if ( null === self::$instance ) {
			self::$instance = new PluginOptions();
		}

		return self::$instance;
	}
}
