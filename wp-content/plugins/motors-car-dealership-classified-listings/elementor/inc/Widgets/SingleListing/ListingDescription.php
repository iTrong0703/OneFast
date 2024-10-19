<?php

namespace Motors_Elementor_Widgets_Free\Widgets\SingleListing;

use Motors_Elementor_Widgets_Free\MotorsElementorWidgetsFree;
use Motors_Elementor_Widgets_Free\Helpers\Helper;
use Motors_Elementor_Widgets_Free\Widgets\WidgetBase;

class ListingDescription extends WidgetBase {

	public function __construct( array $data = array(), array $args = null ) {
		parent::__construct( $data, $args );

		$this->stm_ew_admin_register_ss( $this->get_admin_name(), self::get_name(), STM_LISTINGS_PATH, STM_LISTINGS_URL, STM_LISTINGS_V );
		$this->stm_ew_enqueue( self::get_name(), STM_LISTINGS_PATH, STM_LISTINGS_URL, STM_LISTINGS_V, array( 'jquery' ) );
	}

	public function get_categories() {
		return array( MotorsElementorWidgetsFree::WIDGET_CATEGORY_SINGLE );
	}

	public function get_name() {
		return MotorsElementorWidgetsFree::STM_PREFIX . '-single-listing-description';
	}

	public function get_title() {
		return esc_html__( 'Description', 'motors-car-dealership-classified-listings-pro' );
	}

	public function get_icon() {
		return 'stmew-list-sheet';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_description',
			array(
				'label' => esc_html__( 'Description', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'description_typo',
				'label'    => esc_html__( 'Typography', 'motors-car-dealership-classified-listings-pro' ),
				'default'  => '',
				'selector' => '{{WRAPPER}} .mvl-listing-description p',
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		Helper::stm_ew_load_template( 'elementor/Widgets/single-listing/description', STM_LISTINGS_PATH, $settings );
	}

	protected function content_template() {
	}
}
