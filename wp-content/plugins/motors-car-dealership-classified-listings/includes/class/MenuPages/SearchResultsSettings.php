<?php


namespace MotorsVehiclesListing\MenuPages;

use MotorsVehiclesListing\Plugin\MVL_Const;

class SearchResultsSettings extends MenuBase {

	public function __construct() {
		$this->nuxy_option_name = MVL_Const::SEARCH_RESULTS_OPT_NAME;
		$this->nuxy_title       = esc_html__( 'Search Results Page', 'stm_vehicles_listing' );
		$this->nuxy_subtitle    = esc_html__( 'Search Results Page', 'stm_vehicles_listing' );
		$this->nuxy_title       = esc_html__( 'Search Results Page', 'stm_vehicles_listing' );
		$this->nuxy_menu_slug   = MVL_Const::SEARCH_RESULTS_OPT_NAME;
		$this->menu_position    = 13;

		parent::__construct();
	}

	public function mvl_init_page() {
		$this->nuxy_opts = apply_filters( 'me_search_results_settings_conf', array() );
		parent::mvl_init_page();
	}
}
