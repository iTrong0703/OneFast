<?php


namespace MotorsVehiclesListing\MenuPages;

use MotorsVehiclesListing\Plugin\MVL_Const;

class FilterSettings extends MenuBase {

	public function __construct() {
		$this->nuxy_option_name = MVL_Const::FILTER_OPT_NAME;
		$this->nuxy_title       = esc_html__( 'Search Filters', 'stm_vehicles_listing' );
		$this->nuxy_subtitle    = esc_html__( 'Search Filters', 'stm_vehicles_listing' );
		$this->nuxy_title       = esc_html__( 'Search Filters', 'stm_vehicles_listing' );
		$this->nuxy_menu_slug   = MVL_Const::FILTER_OPT_NAME;
		$this->menu_position    = 14;

		parent::__construct();
	}

	public function mvl_init_page() {
		$this->nuxy_opts = apply_filters( 'me_search_and_filter_settings_conf', array() );

		parent::mvl_init_page();
	}
}
