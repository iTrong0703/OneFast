<?php

namespace Motors_Elementor_Widgets_Free\Widgets\SingleListing;

use Motors_Elementor_Widgets_Free\MotorsElementorWidgetsFree;
use Motors_Elementor_Widgets_Free\Helpers\Helper;
use Motors_Elementor_Widgets_Free\Widgets\WidgetBase;

class OfferPriceButton extends WidgetBase {

	public function __construct( array $data = array(), array $args = null ) {
		parent::__construct( $data, $args );

		add_filter(
			'mew_include_offer_price_modal',
			function () {
				return true;
			}
		);

		$this->stm_ew_admin_register_ss( $this->get_admin_name(), self::get_name(), STM_LISTINGS_PATH, STM_LISTINGS_URL, STM_LISTINGS_V );
		$this->stm_ew_enqueue( self::get_name(), STM_LISTINGS_PATH, STM_LISTINGS_URL, STM_LISTINGS_V, array( 'jquery' ) );
	}

	public function get_categories() {
		return array( MotorsElementorWidgetsFree::WIDGET_CATEGORY_SINGLE );
	}

	public function get_name() {
		return MotorsElementorWidgetsFree::STM_PREFIX . '-single-listing-offer-price';
	}

	public function get_title() {
		return esc_html__( 'Offer Price Button', 'motors-car-dealership-classified-listings-pro' );
	}

	public function get_icon() {
		return 'stmew-currency-usd';
	}

	protected function register_controls() {
		$this->stm_start_content_controls_section( 'opb_content', __( 'General', 'motors-car-dealership-classified-listings-pro' ) );

		$this->add_control(
			'opb_btn_label',
			array(
				'label'   => __( 'Label', 'motors-car-dealership-classified-listings-pro' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Make an Offer Price', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->stm_end_control_section();

		$this->stm_start_style_controls_section( 'opb_styles', __( 'Style', 'motors-car-dealership-classified-listings-pro' ) );

		$this->stm_start_ctrl_tabs( 'opb_btn_bg_style' );

		$this->stm_start_ctrl_tab(
			'opb_bg_normal',
			array(
				'label' => __( 'Normal', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'opb_btn_bg',
			array(
				'label'     => __( 'Background', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .stm-car_dealer-buttons a' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'opb_icon_color',
			array(
				'label'     => __( 'Icon Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .stm-car_dealer-buttons a i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .stm-car_dealer-buttons a svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'opb_text_color',
			array(
				'label'     => __( 'Text Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .stm-car_dealer-buttons a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'opb_border_color',
			array(
				'label'     => __( 'Border Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .stm-car_dealer-buttons a' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'opb_box_shadow',
				'label'    => __( 'Box Shadow', 'motors-car-dealership-classified-listings-pro' ),
				'selector' => '{{WRAPPER}} .stm-car_dealer-buttons a',
			)
		);

		$this->stm_end_ctrl_tab();

		$this->stm_start_ctrl_tab(
			'opb_bg_hover',
			array(
				'label' => __( 'Hover', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'opb_btn_bg_hover',
			array(
				'label'     => __( 'Background', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .stm-car_dealer-buttons a:hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'opb_icon_color_hover',
			array(
				'label'     => __( 'Icon Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .stm-car_dealer-buttons a:hover i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .stm-car_dealer-buttons a:hover svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'opb_text_color_hover',
			array(
				'label'     => __( 'Text Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .stm-car_dealer-buttons a:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'opb_border_color_hover',
			array(
				'label'     => __( 'Border Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .stm-car_dealer-buttons a:hover' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'opb_box_shadow_hover',
				'label'    => __( 'Box Shadow', 'motors-car-dealership-classified-listings-pro' ),
				'selector' => '{{WRAPPER}} .stm-car_dealer-buttons a:hover',
			)
		);

		$this->stm_end_ctrl_tab();

		$this->stm_end_ctrl_tabs();

		$this->add_control(
			'opb_btn_bg_after',
			array(
				'type'  => \Elementor\Controls_Manager::DIVIDER,
				'style' => 'solid',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'opb_typography',
				'label'     => __( 'Typography', 'motors-car-dealership-classified-listings-pro' ),
				'separator' => 'before',
				'exclude'   => array(
					'font_family',
					'font_style',
					'text_decoration',
					'letter_spacing',
					'word_spacing',
				),
				'selector'  => '{{WRAPPER}} .stm-car_dealer-buttons a',
			)
		);

		$this->add_control(
			'border_before',
			array(
				'type'  => \Elementor\Controls_Manager::DIVIDER,
				'style' => 'solid',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'opb_border',
				'label'    => __( 'Border', 'motors-car-dealership-classified-listings-pro' ),
				'exclude'  => array( 'color' ),
				'selector' => '{{WRAPPER}} .stm-car_dealer-buttons a',
			)
		);

		$this->add_control(
			'opb_btn_border_radius',
			array(
				'label'     => __( 'Border Radius', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::DIMENSIONS,
				'default'   => array(
					'top'      => '',
					'right'    => '',
					'bottom'   => '',
					'left'     => '',
					'isLinked' => true,
				),
				'selectors' => array(
					'{{WRAPPER}} .stm-car_dealer-buttons a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'border_after',
			array(
				'type'  => \Elementor\Controls_Manager::DIVIDER,
				'style' => 'solid',
			)
		);

		$this->add_control(
			'opb_btn_padding',
			array(
				'label'     => __( 'Padding', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::DIMENSIONS,
				'default'   => array(
					'top'      => '17',
					'right'    => '25',
					'bottom'   => '17',
					'left'     => '25',
					'isLinked' => false,
				),
				'selectors' => array(
					'{{WRAPPER}} .stm-car_dealer-buttons a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'icon_styles',
			array(
				'label'     => __( 'Icon', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'opb_icon_size',
			array(
				'label'      => __( 'Icon Size', 'motors-car-dealership-classified-listings-pro' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
				),
				'range'      => array(
					'px' => array(
						'min'  => 8,
						'max'  => 40,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 16,
				),
				'selectors'  => array(
					'{{WRAPPER}} .stm-car_dealer-buttons a i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .stm-car_dealer-buttons a svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'opb_icon_position',
			array(
				'label'     => __( 'Icon Position', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => array(
					'row-reverse' => __( 'Left', 'motors-car-dealership-classified-listings-pro' ),
					'row'         => __( 'Right', 'motors-car-dealership-classified-listings-pro' ),
				),
				'default'   => 'row',
				'selectors' => array(
					'{{WRAPPER}} .stm-car_dealer-buttons a' => 'flex-direction: {{VALUE}};',
				),
			),
		);

		$this->add_control(
			'opb_icon_margin',
			array(
				'label'     => __( 'Icon Margin', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::DIMENSIONS,
				'default'   => array(
					'top'      => '',
					'right'    => '',
					'bottom'   => '',
					'left'     => '',
					'isLinked' => true,
				),
				'selectors' => array(
					'{{WRAPPER}} .stm-car_dealer-buttons a i'   => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .stm-car_dealer-buttons a img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->stm_end_control_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		Helper::stm_ew_load_template( 'elementor/Widgets/single-listing/offer-price', STM_LISTINGS_PATH, $settings );
	}

	protected function content_template() {
	}

	public function motors_add_modal() {
		do_action( 'stm_listings_load_template', 'listings/modals/trade-offer' );
	}
}
