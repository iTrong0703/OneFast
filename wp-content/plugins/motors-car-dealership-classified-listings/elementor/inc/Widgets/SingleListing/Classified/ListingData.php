<?php

namespace Motors_Elementor_Widgets_Free\Widgets\SingleListing\Classified;

use Elementor\Controls_Manager;
use Motors_Elementor_Widgets_Free\MotorsElementorWidgetsFree;
use Motors_Elementor_Widgets_Free\Helpers\Helper;
use Motors_Elementor_Widgets_Free\Widgets\WidgetBase;

class ListingData extends WidgetBase {
	public function __construct( array $data = array(), array $args = null ) {
		parent::__construct( $data, $args );

		$this->stm_ew_admin_register_ss( $this->get_admin_name(), self::get_name(), STM_LISTINGS_PATH, STM_LISTINGS_URL, STM_LISTINGS_V );
		$this->stm_ew_enqueue( self::get_name(), STM_LISTINGS_PATH, STM_LISTINGS_URL, STM_LISTINGS_V, array( 'jquery' ) );
	}

	public function get_categories() {
		return array( MotorsElementorWidgetsFree::WIDGET_CATEGORY_SINGLE );
	}

	public function get_name() {
		return MotorsElementorWidgetsFree::STM_PREFIX . '-single-listing-classified-listing-data';
	}

	public function get_title() {
		return esc_html__( 'Data Classified', 'motors-car-dealership-classified-listings-pro' );
	}

	public function get_icon() {
		return 'stmew-stack';
	}

	protected function register_controls() {
		$this->stm_start_content_controls_section( 'cld_content', __( 'General', 'motors-car-dealership-classified-listings-pro' ) );

		$this->add_control(
			'show_vin',
			array(
				'label' => __( 'VIN Number', 'motors-car-dealership-classified-listings-pro' ),
				'type'  => \Elementor\Controls_Manager::SWITCHER,
			)
		);

		$this->add_control(
			'show_stock',
			array(
				'label' => __( 'Stock Number', 'motors-car-dealership-classified-listings-pro' ),
				'type'  => \Elementor\Controls_Manager::SWITCHER,
			)
		);

		$this->add_control(
			'show_registered',
			array(
				'label' => __( 'Registered Date', 'motors-car-dealership-classified-listings-pro' ),
				'type'  => \Elementor\Controls_Manager::SWITCHER,
			)
		);

		$this->add_control(
			'show_history',
			array(
				'label' => __( 'History', 'motors-car-dealership-classified-listings-pro' ),
				'type'  => \Elementor\Controls_Manager::SWITCHER,
			)
		);

		$this->add_responsive_control(
			'data_columns',
			array(
				'type'    => \Elementor\Controls_Manager::SELECT,
				'label'   => __( 'Columns', 'motors-car-dealership-classified-listings-pro' ),
				'default' => '3',
				'options' => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
				),
			)
		);

		$this->stm_end_control_section();

		$this->stm_start_style_controls_section( 'style_listing_data', esc_html__( 'Style', 'motors-car-dealership-classified-listings-pro' ) );

		$this->add_control(
			'icon_size',
			array(
				'label'      => esc_html__( 'Icon Size', 'motors-car-dealership-classified-listings-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
				),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 18,
				),
				'selectors'  => array(
					'{{WRAPPER}} .stm-single-car-listing-data .item-label > i'   => 'font-size: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .stm-single-car-listing-data .item-label > svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'icon_color',
			array(
				'label'     => esc_html__( 'Icon Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .stm-single-car-listing-data .item-label > i'   => 'color: {{VALUE}};fill: {{VALUE}};',
					'{{WRAPPER}} .stm-single-car-listing-data .item-label > svg' => 'color: {{VALUE}};fill: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'icon_line_height',
				'label'          => esc_html__( 'Icon&Label Wrapper Line Height', 'motors-car-dealership-classified-listings-pro' ),
				'exclude'        => array(
					'font_family',
					'font_style',
					'font_size',
					'font_weight',
					'text_decoration',
					'text_transform',
					'letter_spacing',
					'word_spacing',
				),
				'fields_options' => array(
					'line_height' => array(
						'size_units' => array(
							'px',
							'em',
						),
						'default'    => array(
							'unit' => 'px',
							'size' => 22,
						),
					),
				),
				'selector'       => '{{WRAPPER}} .stm-single-car-listing-data .item-label',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'label_typography',
				'label'          => esc_html__( 'Label Typography', 'motors-car-dealership-classified-listings-pro' ),
				'exclude'        => array(
					'font_family',
					'font_style',
					'text_decoration',
					'letter_spacing',
					'word_spacing',
					'line_height',
				),
				'fields_options' => array(
					'font_size'   => array(
						'size_units' => array(
							'px',
							'em',
						),
						'default'    => array(
							'unit' => 'px',
							'size' => 13,
						),
					),
					'font_weight' => array(
						'default' => '400',
					),
				),
				'selector'       => '{{WRAPPER}} .stm-single-car-listing-data .item-label',
			)
		);

		$this->add_control(
			'label_color',
			array(
				'label'     => esc_html__( 'Label Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#888888',
				'selectors' => array(
					'{{WRAPPER}} .stm-single-car-listing-data .item-label' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'value_typography',
				'label'          => esc_html__( 'Value Typography', 'motors-car-dealership-classified-listings-pro' ),
				'exclude'        => array(
					'font_family',
					'font_style',
					'text_decoration',
					'letter_spacing',
					'word_spacing',
				),
				'fields_options' => array(
					'font_size'   => array(
						'size_units' => array(
							'px',
							'em',
						),
						'default'    => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'line_height' => array(
						'size_units' => array(
							'px',
							'em',
						),
						'default'    => array(
							'unit' => 'px',
							'size' => 22,
						),
					),
					'font_weight' => array(
						'default' => '700',
					),
				),
				'selector'       => '{{WRAPPER}} .stm-single-car-listing-data .heading-font',
			)
		);

		$this->add_control(
			'value_color',
			array(
				'label'     => esc_html__( 'Value Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#222222',
				'selectors' => array(
					'{{WRAPPER}} .stm-single-car-listing-data .heading-font' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'value_align',
			array(
				'label'     => __( 'Value text alignment', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'  => array(
						'title' => __( 'Left', 'motors-car-dealership-classified-listings-pro' ),
						'icon'  => 'eicon-text-align-left',
					),
					'right' => array(
						'title' => __( 'Right', 'motors-car-dealership-classified-listings-pro' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'left',
				'selectors' => array(
					'{{WRAPPER}} .stm-single-car-listing-data .heading-font' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#d5d9e0',
				'selectors' => array(
					'{{WRAPPER}} .stm-single-car-listing-data .data-list-item:before' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->stm_end_control_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		Helper::stm_ew_load_template( 'elementor/Widgets/single-listing/classified/listing-data', STM_LISTINGS_PATH, $settings );
	}

	protected function content_template() {
	}
}
