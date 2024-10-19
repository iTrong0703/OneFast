<?php

namespace Motors_Elementor_Widgets_Free\Widgets;

use Motors_Elementor_Widgets_Free\MotorsElementorWidgetsFree;
use Motors_Elementor_Widgets_Free\Helpers\Helper;
use Motors_Elementor_Widgets_Free\Widgets\WidgetBase;

class DealersList extends WidgetBase {

	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );

		//common admin style
		$this->stm_ew_admin_register_ss(
			'stm-dynamic-listing-filter-admin',
			'stm-dynamic-listing-filter-admin'
		);

		//common style
		$this->stm_ew_admin_register_ss(
			'stm-dynamic-listing-filter',
			'stm-dynamic-listing-filter'
		);

		//widgets style/script
		$this->stm_ew_enqueue(
			$this->get_name(),
			STM_LISTINGS_PATH,
			STM_LISTINGS_URL,
			STM_LISTINGS_V,
			array(
				'elementor-frontend',
				'stmselect2',
				'app-select2',
				'stm-cascadingdropdown',
			)
		);
	}

	public function get_script_depends(): array {
		return array_merge( array( 'stmselect2', 'app-select2' ) );
	}

	public function get_style_depends(): array {
		$widget_styles = array(
			'stmselect2',
			'app-select2',
			'stm-dynamic-listing-filter',
			'stm-dynamic-listing-filter-admin',
		);
		$widget_styles = array_merge( $widget_styles, parent::get_style_depends() );

		return $widget_styles;
	}

	public function get_categories(): array {
		return array( MotorsElementorWidgetsFree::WIDGET_CATEGORY_CLASSIFIED );
	}

	public function get_name(): string {
		return MotorsElementorWidgetsFree::STM_PREFIX . '-dealers-list';
	}

	public function get_title(): string {
		return esc_html__( 'Dealers List', 'motors-car-dealership-classified-listings-pro' );
	}

	public function get_icon(): string {
		return 'stmew-dealer-list';
	}

	protected function register_controls() {
		$this->stm_start_content_controls_section( 'section_content', __( 'Content', 'motors-car-dealership-classified-listings-pro' ) );

		$listing_categories = stm_listings_attributes();

		if ( ! empty( $listing_categories ) ) {
			$listing_categories = array_column( $listing_categories, 'single_name', 'slug' );
		}

		if ( ! in_array( 'location', $listing_categories, true ) ) {
			$listing_categories['location'] = esc_html__( 'Location', 'motors-car-dealership-classified-listings-pro' );
		}

		$listing_categories['keyword'] = esc_html__( 'Keyword', 'motors-car-dealership-classified-listings-pro' );

		$this->add_control(
			'filter_categories',
			array(
				'label'    => esc_html__( 'Select Categories', 'motors-car-dealership-classified-listings-pro' ),
				'type'     => \Elementor\Controls_Manager::SELECT2,
				'options'  => $listing_categories,
				'multiple' => true,
			)
		);

		$this->add_control(
			'dealer_category_fields',
			array(
				'label'    => esc_html__( 'Dealer Fields', 'motors-car-dealership-classified-listings-pro' ),
				'type'     => \Elementor\Controls_Manager::SELECT2,
				'options'  => Helper::get_listing_options(),
				'multiple' => true,
			)
		);

		$this->add_control(
			'button_text',
			array(
				'label'       => __( 'Button Text', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Enter Button Text', 'motors-car-dealership-classified-listings-pro' ),
				'default'     => __( 'Find Dealer ', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'button_icon',
			array(
				'label'       => esc_html__( 'Button Icon', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'default'     => array(
					'value'   => 'fas fa-search',
					'library' => 'fa-solid',
				),
			)
		);

		$this->add_control(
			'button_icon_size',
			array(
				'label'      => esc_html__( 'Icon Size', 'motors-car-dealership-classified-listings-pro' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
				),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 16,
				),
				'selectors'  => array(
					'{{WRAPPER}} form button[type="submit"] > i'   => 'font-size: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} form button[type="submit"] > svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'button_icon[value]!' => '',
				),
			)
		);

		$this->end_controls_section();

		$this->stm_start_style_controls_section( 'section_style_general', esc_html__( 'General', 'motors-car-dealership-classified-listings-pro' ) );

		$this->add_control(
			'background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .stm_dynamic_listing_dealer_filter .tab-content' => 'background: {{VALUE}};',
				),
			)
		);

		$this->stm_start_ctrl_tabs( 'button_style' );

		$this->stm_start_ctrl_tab(
			'btn_normal',
			array(
				'label' => __( 'Normal', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'button_background_color',
			array(
				'label'     => esc_html__( 'Button Background Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .stm_dynamic_listing_dealer_filter .tab-content button[type=submit]' => 'background: {{VALUE}};box-shadow: 0 2px 0 {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_text_color',
			array(
				'label'     => esc_html__( 'Button Text Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .stm_dynamic_listing_dealer_filter .tab-content button[type=submit]' => 'color: {{VALUE}};',
				),
			)
		);

		$this->stm_end_ctrl_tab();

		$this->stm_start_ctrl_tab(
			'btn_hover',
			array(
				'label' => __( 'Hover', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'button_background_color_hover',
			array(
				'label'     => esc_html__( 'Button Background Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .stm_dynamic_listing_dealer_filter .tab-content form button[type=submit]:hover' => 'background: {{VALUE}};box-shadow: 0 2px 0 {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_text_color_hover',
			array(
				'label'     => esc_html__( 'Button Text Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .stm_dynamic_listing_dealer_filter .tab-content form button[type=submit]:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->stm_end_ctrl_tab();

		$this->stm_end_ctrl_tabs();

		$this->add_control(
			'buttons_style_sep',
			array(
				'type'  => \Elementor\Controls_Manager::DIVIDER,
				'style' => 'solid',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'button_typography',
				'label'          => esc_html__( 'Button Typography', 'motors-car-dealership-classified-listings-pro' ),
				'exclude'        => array(
					'font_style',
					'text_decoration',
					'word_spacing',
				),
				'fields_options' => array(),
				'selector'       => '{{WRAPPER}} form button[type=submit]',
			)
		);

		$this->add_control(
			'button_icon_margin',
			array(
				'label'     => __( 'Button Icon Margin', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::DIMENSIONS,
				'default'   => array(
					'top'      => '0',
					'right'    => '6',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => false,
				),
				'selectors' => array(
					'{{WRAPPER}} form button[type=submit] i'   => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} form button[type=submit] svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->stm_end_control_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		wp_deregister_style( 'stm-dynamic-listing-filter-admin' );

		Helper::stm_ew_load_template( 'elementor/Widgets/dealers-list', STM_LISTINGS_PATH, $settings );
	}
}
