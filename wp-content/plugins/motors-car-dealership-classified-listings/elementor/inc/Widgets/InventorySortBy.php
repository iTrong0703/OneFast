<?php

namespace Motors_Elementor_Widgets_Free\Widgets;

use Motors_Elementor_Widgets_Free\MotorsElementorWidgetsFree;
use Motors_Elementor_Widgets_Free\Helpers\Helper;
use Motors_Elementor_Widgets_Free\Widgets\Controls\ContentControls\HeadingControl;
use Motors_Elementor_Widgets_Free\Widgets\WidgetBase;
use MotorsVehiclesListing\Plugin\MVL_Const;

class InventorySortBy extends WidgetBase {

	protected $wpcfto_settings = '';

	public function __construct( array $data = array(), array $args = null ) {
		parent::__construct( $data, $args );

		$this->wpcfto_settings = admin_url( '?page=' . \MotorsVehiclesListing\Plugin\MVL_Const::FILTER_OPT_NAME . '#inventory_settings' );

		$this->stm_ew_admin_register_ss( $this->get_admin_name(), self::get_name(), STM_LISTINGS_PATH, STM_LISTINGS_URL, STM_LISTINGS_V );
		$this->stm_ew_enqueue( self::get_name(), STM_LISTINGS_PATH, STM_LISTINGS_URL, STM_LISTINGS_V, array( 'jquery' ) );
		if ( is_rtl() ) {
			$this->stm_ew_enqueue( self::get_name() . '-rtl', STM_LISTINGS_PATH, STM_LISTINGS_URL, STM_LISTINGS_V );
		}
	}

	public function get_categories() {
		return array( MotorsElementorWidgetsFree::WIDGET_CATEGORY );
	}

	public function get_name() {
		return MotorsElementorWidgetsFree::STM_PREFIX . '-inventory-sort-by';
	}

	public function get_title() {
		return esc_html__( 'Sort By', 'motors-car-dealership-classified-listings-pro' );
	}

	public function get_icon() {
		return 'stmew-inventory-sort';
	}

	public function get_style_depends() {
		$widget_styles   = parent::get_style_depends();
		$widget_styles[] = 'motors-general-admin';
		$widget_styles[] = self::get_name() . '-rtl';

		return $widget_styles;
	}

	protected function register_controls() {
		$this->stm_start_content_controls_section( 'sb_content', __( 'General', 'motors-car-dealership-classified-listings-pro' ) );

		$this->add_control(
			'sb_heading',
			array(
				'label' => sprintf( '<a href="' . $this->wpcfto_settings . '" target="_blank">%s</a>', __( 'Themes Options Link', 'motors-car-dealership-classified-listings-pro' ) ),
				'type'  => \Elementor\Controls_Manager::HEADING,
			)
		);

		$this->stm_end_control_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		Helper::stm_ew_load_template( 'elementor/Widgets/inventory-sort-by', STM_LISTINGS_PATH, $settings );
	}

	protected function content_template() {

	}
}
