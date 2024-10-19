<?php


namespace MotorsVehiclesListing\MenuPages;

use MotorsVehiclesListing\Plugin\MVL_Const;

class AddCarFormSettings extends MenuBase {

	public function __construct() {
		$this->nuxy_option_name = MVL_Const::ADD_CAR_FORM_OPT_NAME;
		$this->nuxy_title       = esc_html__( 'Add Listing Form', 'stm_vehicles_listing' );
		$this->nuxy_subtitle    = esc_html__( 'Add Listing Form', 'stm_vehicles_listing' );
		$this->nuxy_title       = esc_html__( 'Add Listing Form', 'stm_vehicles_listing' );
		$this->nuxy_menu_slug   = MVL_Const::ADD_CAR_FORM_OPT_NAME;
		$this->menu_position    = 12;

		parent::__construct();
	}

	public function mvl_init_page() {
		parent::mvl_init_page();
		$this->nuxy_opts = apply_filters( 'me_add_car_form_settings_conf', array() );
	}
}
