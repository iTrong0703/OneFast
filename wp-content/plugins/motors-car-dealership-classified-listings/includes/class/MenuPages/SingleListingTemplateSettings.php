<?php


namespace MotorsVehiclesListing\MenuPages;

use MotorsVehiclesListing\Plugin\MVL_Const;

class SingleListingTemplateSettings extends MenuBase {

	public function __construct() {
		$this->nuxy_option_name = MVL_Const::LISTING_TEMPLATE_OPT_NAME;
		$this->nuxy_title       = esc_html__( 'Listing Templates', 'stm_vehicles_listing' );
		$this->nuxy_subtitle    = esc_html__( 'Listing Templates', 'stm_vehicles_listing' );
		$this->nuxy_title       = esc_html__( 'Listing Templates', 'stm_vehicles_listing' );
		$this->nuxy_menu_slug   = MVL_Const::LISTING_TEMPLATE_OPT_NAME;
		$this->menu_position    = 10;

		parent::__construct();
	}

	public function mvl_init_page() {

		$conf_name = 'Listing templates';
		$conf_key  = 'single_listing_template';

		$conf = array(
			'name'   => $conf_name,
			'fields' => apply_filters( 'me_single_listing_template_settings_conf', array() ),
		);

		$this->nuxy_opts = array( $conf_key => $conf );
		parent::mvl_init_page();
	}
}
