<?php

namespace Motors_Elementor_Widgets_Free\Widgets\SingleListing;

use Motors_Elementor_Widgets_Free\MotorsElementorWidgetsFree;
use Motors_Elementor_Widgets_Free\Helpers\Helper;
use Motors_Elementor_Widgets_Free\Widgets\WidgetBase;

class Title extends WidgetBase {

	public function __construct( array $data = array(), array $args = null ) {
		parent::__construct( $data, $args );

		$this->stm_ew_admin_register_ss( $this->get_admin_name(), self::get_name(), STM_LISTINGS_PATH, STM_LISTINGS_URL, STM_LISTINGS_V );
		$this->stm_ew_enqueue( self::get_name(), STM_LISTINGS_PATH, STM_LISTINGS_URL, STM_LISTINGS_V, array( 'jquery' ) );
	}

	public function get_categories() {
		return array( MotorsElementorWidgetsFree::WIDGET_CATEGORY_SINGLE );
	}

	public function get_name() {
		return MotorsElementorWidgetsFree::STM_PREFIX . '-single-listing-title';
	}

	public function get_title() {
		return esc_html__( 'Title', 'motors-car-dealership-classified-listings-pro' );
	}

	public function get_icon() {
		return 'stmew-letter-t';
	}

	protected function register_controls() {
		$this->stm_start_content_controls_section( 'title_content', __( 'General', 'motors-car-dealership-classified-listings-pro' ) );

		$this->add_control(
			'title_tag',
			array(
				'label'   => __( 'Heading Tag', 'motors-car-dealership-classified-listings-pro' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'h1',
				'options' => array(
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'title_typography',
				'label'          => __( 'Typography', 'motors-car-dealership-classified-listings-pro' ),
				'exclude'        => array(
					'font_family',
					'font_style',
					'text_transform',
					'text_decoration',
					'letter_spacing',
					'word_spacing',
				),
				'fields_options' => array(
					'font_size'   => array(
						'default' => array(
							'unit' => 'px',
							'size' => 36,
						),
					),
					'font_weight' => array(
						'default' => '700',
					),
					'line_height' => array(
						'default' => array(
							'unit' => 'px',
							'size' => 42,
						),
					),
				),
				'selector'       => '{{WRAPPER}} .stm_listing_title',
			)
		);

		$this->add_control(
			'title_color',
			array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Color', 'motors-car-dealership-classified-listings-pro' ),
				'default'   => '#232628',
				'selectors' => array(
					'{{WRAPPER}} .stm_listing_title' => 'color: {{VALUE}}',
				),
			)
		);

		$this->stm_end_control_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		Helper::stm_ew_load_template( 'elementor/Widgets/single-listing/title', STM_LISTINGS_PATH, $settings );
	}

	protected function content_template() {
	}
}
