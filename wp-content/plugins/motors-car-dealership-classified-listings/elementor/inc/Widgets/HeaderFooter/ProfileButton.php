<?php

namespace Motors_Elementor_Widgets_Free\Widgets\HeaderFooter;

use Motors_Elementor_Widgets_Free\MotorsElementorWidgetsFree;
use Motors_Elementor_Widgets_Free\Helpers\Helper;
use Motors_Elementor_Widgets_Free\Widgets\WidgetBase;

class ProfileButton extends WidgetBase {

	public function __construct( array $data = array(), array $args = null ) {
		parent::__construct( $data, $args );

		$this->stm_ew_admin_register_ss( $this->get_admin_name(), self::get_name(), STM_LISTINGS_PATH, STM_LISTINGS_URL, STM_LISTINGS_V );
		$this->stm_ew_enqueue( self::get_name(), STM_LISTINGS_PATH, STM_LISTINGS_URL, STM_LISTINGS_V, array( 'jquery' ) );
	}

	public function get_categories() {
		return array( MotorsElementorWidgetsFree::WIDGET_CATEGORY_HEADER_FOOTER );
	}

	public function get_name() {
		return MotorsElementorWidgetsFree::STM_PREFIX . '-profile-button';
	}

	public function get_title() {
		return esc_html__( 'Profile Button', 'motors-car-dealership-classified-listings-pro' );
	}

	public function get_icon() {
		return 'eicon-user-circle-o';
	}

	protected function register_controls() {

		$this->stm_start_content_controls_section( 'mvl_profile_btn_content', __( 'General', 'motors-car-dealership-classified-listings-pro' ) );

		$this->add_control(
			'mvl_profile_btn_text',
			array(
				'label'   => __( 'Button Text', 'motors-car-dealership-classified-listings-pro' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Profile', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'mvl_profile_btn_icon',
			array(
				'label'       => __( 'Icon', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::ICONS,
				'default'     => array(
					'value' => 'fa-solid fa-circle-user',
				),
				'skin'        => 'inline',
				'label_block' => false,
			)
		);

		$this->stm_end_control_section();

		$this->stm_start_style_controls_section( 'mvl_profile_btn_style', __( 'Style', 'motors-car-dealership-classified-listings-pro' ) );

		$this->start_controls_tabs( 'tabs_mvl_profile_btn_style' );

		$this->start_controls_tab(
			'tab_mvl_profile_btn_normal',
			array(
				'label' => __( 'Normal', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'mvl_profile_btn_background_color',
			array(
				'label'     => __( 'Background Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .motors-profile-button' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'mvl_profile_btn_text_color',
			array(
				'label'     => __( 'Text Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .motors-profile-button' => 'color: {{VALUE}};',
					'{{WRAPPER}} .motors-profile-button span' => 'color: {{VALUE}};',
					'{{WRAPPER}} .motors-profile-button svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_mvl_profile_btn_hover',
			array(
				'label' => __( 'Hover', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'mvl_profile_btn_background_hover_color',
			array(
				'label'     => __( 'Background Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .motors-profile-button:hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'mvl_profile_btn_text_hover_color',
			array(
				'label'     => __( 'Text Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .motors-profile-button' => 'color: {{VALUE}};',
					'{{WRAPPER}} .motors-profile-button span' => 'color: {{VALUE}};',
					'{{WRAPPER}} .motors-profile-button svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'mvl_profile_btn_style_divider',
			array(
				'type'  => \Elementor\Controls_Manager::DIVIDER,
				'style' => 'thick',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'mvl_profile_btn_typography',
				'label'    => __( 'Typography', 'motors-car-dealership-classified-listings-pro' ),
				'selector' => '{{WRAPPER}} .motors-profile-button',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'mvl_profile_btn_border',
				'label'    => __( 'Border', 'motors-car-dealership-classified-listings-pro' ),
				'selector' => '{{WRAPPER}} .motors-profile-button',
			)
		);

		$this->add_control(
			'mvl_profile_btn_border_radius',
			array(
				'label'      => __( 'Border Radius', 'motors-car-dealership-classified-listings-pro' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .motors-profile-button' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'mvl_profile_btn_padding',
			array(
				'label'      => __( 'Padding', 'motors-car-dealership-classified-listings-pro' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .motors-profile-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'mvl_profile_btn_icon_margin',
			array(
				'label'      => __( 'Icon Margin', 'motors-car-dealership-classified-listings-pro' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .motors-profile-button i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .motors-profile-button svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'mvl_profile_btn_icon_size',
			array(
				'label'      => __( 'Icon Size', 'motors-car-dealership-classified-listings-pro' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem' ),
				'range'      => array(
					'px'  => array(
						'min' => 10,
						'max' => 100,
					),
					'em'  => array(
						'min' => 1,
						'max' => 10,
					),
					'rem' => array(
						'min' => 1,
						'max' => 10,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 24,
				),
				'selectors'  => array(
					'{{WRAPPER}} .motors-profile-button i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .motors-profile-button svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'mvl_profile_btn_box_shadow',
				'label'    => __( 'Box Shadow', 'motors-car-dealership-classified-listings-pro' ),
				'selector' => '{{WRAPPER}} .motors-profile-button',
			)
		);

		$this->stm_end_control_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		Helper::stm_ew_load_template( 'elementor/Widgets/header-footer/profile-button', STM_LISTINGS_PATH, $settings );
	}

}
