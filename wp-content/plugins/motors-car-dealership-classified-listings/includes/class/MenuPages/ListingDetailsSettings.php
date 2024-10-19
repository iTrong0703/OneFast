<?php


namespace MotorsVehiclesListing\MenuPages;

use MotorsVehiclesListing\Plugin\MVL_Const;

class ListingDetailsSettings extends MenuBase {

	public function __construct() {
		$this->nuxy_option_name = MVL_Const::LISTING_DETAILS_OPT_NAME;
		$this->nuxy_title       = esc_html__( 'Listing Page Details', 'stm_vehicles_listing' );
		$this->nuxy_subtitle    = esc_html__( 'Listing Page Details', 'stm_vehicles_listing' );
		$this->nuxy_title       = esc_html__( 'Listing Page Details', 'stm_vehicles_listing' );
		$this->nuxy_menu_slug   = MVL_Const::LISTING_DETAILS_OPT_NAME;
		$this->menu_position    = 11;

		parent::__construct();
	}

	public function mvl_init_page() {
		$this->nuxy_opts = apply_filters( 'mvl_get_all_nuxy_listing_details_config', array() );
		parent::mvl_init_page();
	}
}
