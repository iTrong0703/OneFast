<?php

namespace Motors_Elementor_Widgets_Free\Widgets;

use Motors_Elementor_Widgets_Free\MotorsElementorWidgetsFree;
use Motors_Elementor_Widgets_Free\Helpers\Helper;
use Motors_Elementor_Widgets_Free\Widgets\WidgetBase;

class InventorySearchResults extends WidgetBase {

	public function __construct( array $data = array(), array $args = null ) {
		parent::__construct( $data, $args );

		$this->stm_ew_admin_register_ss( $this->get_admin_name(), self::get_name(), STM_LISTINGS_PATH, STM_LISTINGS_URL, STM_LISTINGS_V );
		$this->stm_ew_enqueue( self::get_name(), STM_LISTINGS_PATH, STM_LISTINGS_URL, STM_LISTINGS_V, array( 'jquery' ) );
		if ( is_rtl() ) {
			$this->stm_ew_enqueue( self::get_name() . '-rtl', STM_LISTINGS_PATH, STM_LISTINGS_URL, STM_LISTINGS_V );
		}
	}

	public function get_script_depends() {
		return array(
			$this->get_name(),
			'addtoany-core',
		);
	}

	public function get_style_depends(): array {
		$widget_styles   = parent::get_style_depends();
		$widget_styles[] = self::get_name() . '-rtl';

		return $widget_styles;
	}

	public function get_categories() {
		return array( MotorsElementorWidgetsFree::WIDGET_CATEGORY );
	}

	public function get_name() {
		return MotorsElementorWidgetsFree::STM_PREFIX . '-inventory-search-results';
	}

	public function get_title() {
		return esc_html__( 'Search Result', 'motors-car-dealership-classified-listings-pro' );
	}

	public function get_icon() {
		return 'stmew-inventory-search';
	}

	protected function register_controls() {
		$this->stm_start_content_controls_section( 'isr_content', __( 'General', 'motors-car-dealership-classified-listings-pro' ) );

		if ( stm_is_multilisting() ) {

			$this->add_control(
				'post_type',
				array(
					'label'   => __( 'Listing Type', 'motors-car-dealership-classified-listings-pro' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => Helper::stm_ew_multi_listing_types(),
					'default' => 'listings',
				),
			);

		}

		$this->add_control(
			'ppp_on_list',
			array(
				'label'   => __( 'Posts Per Page on List View', 'motors-car-dealership-classified-listings-pro' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => '10',
			)
		);

		$this->add_control(
			'ppp_on_grid',
			array(
				'label'   => __( 'Posts Per Page on Grid View', 'motors-car-dealership-classified-listings-pro' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => '9',
			)
		);

		$this->add_control(
			'quant_grid_items',
			array(
				'label'       => __( 'Quantity of Listing Per Row on Grid View', 'motors-car-dealership-classified-listings-pro' ),
				'description' => __( 'Reload the page to apply the settings.', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'options'     => array(
					'2' => '2',
					'3' => '3',
				),
				'default'     => '3',
			)
		);

		$this->add_control(
			'grid_thumb_img_size',
			array(
				'label'   => __( 'Image size on Grid View', 'motors-car-dealership-classified-listings-pro' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => Helper::stm_ew_get_image_sizes( true, true, true ),
			),
		);

		$this->add_control(
			'list_thumb_img_size',
			array(
				'label'   => __( 'Image size on List View', 'motors-car-dealership-classified-listings-pro' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => Helper::stm_ew_get_image_sizes( true, true, true ),
			),
		);

		$this->stm_end_control_section();

		$this->stm_start_style_controls_section( 'isr_styles', __( 'Styles', 'motors-car-dealership-classified-listings-pro' ) );

		$this->add_control(
			'grid_thumb_height',
			array(
				'label'      => __( 'Image Height', 'motors-car-dealership-classified-listings-pro' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
				),
				'range'      => array(
					'px' => array(
						'min'  => 100,
						'max'  => 300,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .stm-isotope-sorting-grid .image img, {{WRAPPER}} .car-listing-modern-grid .image img'                                 => 'height: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .stm-isotope-sorting-grid .interactive-hoverable, {{WRAPPER}} .car-listing-modern-grid .interactive-hoverable'         => 'min-height: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .stm-isotope-sorting-grid .interactive-hoverable img, {{WRAPPER}} .car-listing-modern-grid .interactive-hoverable img' => 'height: 100%',
					'{{WRAPPER}} .stm-isotope-sorting .listing-list-loop.stm-listing-directory-list-loop .image'                                        => 'min-height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .stm-isotope-sorting .listing-list-loop.stm-listing-directory-list-loop .image img'                                    => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .stm-isotope-sorting .listing-list-loop.stm-listing-directory-list-loop .interactive-hoverable'                        => 'height:{{SIZE}}{{UNIT}};min-height: {{SIZE}}{{UNIT}} !important;',
					'{{WRAPPER}} .stm-isotope-sorting .listing-list-loop.stm-listing-directory-list-loop .interactive-hoverable img'                    => 'height: 100%; width: 100%; object-fit: cover;',
				),
			)
		);

		$this->add_control(
			'isr_pagination_styles',
			array(
				'label'     => __( 'Pagination', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->stm_start_ctrl_tabs( 'pagination_style' );

		$this->stm_start_ctrl_tab(
			'pagination_normal',
			array(
				'label' => __( 'Normal', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'isr_pagination_item_bg',
			array(
				'label'     => __( 'Background', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .motors-elementor-inventory-search-results#listings-result ul.page-numbers li > a' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->stm_end_ctrl_tab();

		$this->stm_start_ctrl_tab(
			'pagination_active',
			array(
				'label' => __( 'Active', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'isr_pagination_active_item_bg',
			array(
				'label'     => __( 'Background', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .motors-elementor-inventory-search-results#listings-result ul.page-numbers li .current' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->stm_end_ctrl_tab();

		$this->stm_end_control_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		Helper::stm_ew_load_template( 'elementor/Widgets/inventory-search-results', STM_LISTINGS_PATH, $settings );
	}

	protected function content_template() {

	}
}
