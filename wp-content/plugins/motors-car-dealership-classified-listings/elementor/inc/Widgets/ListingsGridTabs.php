<?php

namespace Motors_Elementor_Widgets_Free\Widgets;

use Motors_Elementor_Widgets_Free\MotorsElementorWidgetsFree;
use Motors_Elementor_Widgets_Free\Helpers\Helper;
use Motors_Elementor_Widgets_Free\Widgets\WidgetBase;

class ListingsGridTabs extends WidgetBase {

	public function __construct( array $data = array(), array $args = null ) {
		parent::__construct( $data, $args );

		$this->stm_ew_enqueue( $this->get_name() );

	}

	public function get_style_depends(): array {
		return array( 'bootstrap', $this->get_name() );
	}

	public function get_script_depends(): array {
		return array( 'bootstrap', $this->get_name() );
	}

	public function get_categories() {
		return array( MotorsElementorWidgetsFree::WIDGET_CATEGORY );
	}

	public function get_name() {
		return MotorsElementorWidgetsFree::STM_PREFIX . '-listings-grid-tabs';
	}

	public function get_title() {
		return esc_html__( 'Listings Grid Tabs', 'motors-car-dealership-classified-listings-pro' );
	}

	public function get_icon() {
		return 'stmew-grid-view';
	}

	protected function register_controls() {
		$this->stm_start_content_controls_section( 'section_content', esc_html__( 'Content', 'motors-car-dealership-classified-listings-pro' ) );

		$this->add_control(
			'grid_title',
			array(
				'label'       => esc_html__( 'Title', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Grid Title', 'motors-car-dealership-classified-listings-pro' ),
				'default'     => esc_html__( 'New/Used Cars', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'listing_types',
			array(
				'label'    => esc_html__( 'Listing Types', 'motors-car-dealership-classified-listings-pro' ),
				'type'     => \Elementor\Controls_Manager::SELECT2,
				'default'  => 'listings',
				'multiple' => true,
				'options'  => Helper::stm_ew_get_multilisting_types( true ),
			)
		);

		$this->add_control(
			'listings_number',
			array(
				'label'       => esc_html__( 'Number Of Listings Per Tab', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'min'         => 1,
				'step'        => 1,
				'default'     => 8,
				'description' => esc_html__( 'Leave empty to show default number of listings', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'listings_number_per_row',
			array(
				'label'       => esc_html__( 'Number Of Listings Per Row', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'min'         => 3,
				'max'         => 4,
				'step'        => 1,
				'default'     => 4,
				'description' => esc_html__( 'Leave empty to show default number of listings', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'show_all_link',
			array(
				'label'     => esc_html__( '"Show All" Button', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'motors-car-dealership-classified-listings-pro' ),
				'label_off' => esc_html__( 'No', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'show_all_link_text',
			array(
				'label'     => esc_html__( '"Show All" Button Text', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => esc_html__( 'Show All', 'motors-car-dealership-classified-listings-pro' ),
				'condition' => array( 'show_all_link' => 'yes' ),
			)
		);

		$this->add_control(
			'include_popular',
			array(
				'label'     => esc_html__( 'Include Popular Listings', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'motors-car-dealership-classified-listings-pro' ),
				'label_off' => esc_html__( 'No', 'motors-car-dealership-classified-listings-pro' ),
				'default'   => 'yes',
			)
		);

		$this->add_control(
			'popular_label',
			array(
				'label'     => esc_html__( 'Popular Tab Label', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => esc_html__( 'Popular items', 'motors-car-dealership-classified-listings-pro' ),
				'condition' => array( 'include_popular' => 'yes' ),
			)
		);

		$this->add_control(
			'include_recent',
			array(
				'label'     => esc_html__( 'Include Recent Listings', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'motors-car-dealership-classified-listings-pro' ),
				'label_off' => esc_html__( 'No', 'motors-car-dealership-classified-listings-pro' ),
				'default'   => 'yes',
			)
		);

		$this->add_control(
			'recent_label',
			array(
				'label'     => esc_html__( 'Recent Tab Label', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => esc_html__( 'Recent items', 'motors-car-dealership-classified-listings-pro' ),
				'condition' => array( 'include_recent' => 'yes' ),
			)
		);

		$this->add_control(
			'include_featured',
			array(
				'label'     => esc_html__( 'Include Featured Listings', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'motors-car-dealership-classified-listings-pro' ),
				'label_off' => esc_html__( 'No', 'motors-car-dealership-classified-listings-pro' ),
				'default'   => 'yes',
			)
		);

		$this->add_control(
			'featured_label',
			array(
				'label'     => esc_html__( 'Featured Tab Label', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => esc_html__( 'Featured items', 'motors-car-dealership-classified-listings-pro' ),
				'condition' => array( 'include_featured' => 'yes' ),
			)
		);

		$this->add_control(
			'include_sale',
			array(
				'label'     => esc_html__( 'Include Sale Listings', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'motors-car-dealership-classified-listings-pro' ),
				'label_off' => esc_html__( 'No', 'motors-car-dealership-classified-listings-pro' ),
				'default'   => 'yes',
			)
		);

		$this->add_control(
			'sale_label',
			array(
				'label'     => esc_html__( 'Sale Tab Label', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => esc_html__( 'Sale items', 'motors-car-dealership-classified-listings-pro' ),
				'condition' => array( 'include_sale' => 'yes' ),
			)
		);

		$this->add_control(
			'grid_thumb_img_size',
			array(
				'label'   => __( 'Image size', 'motors-car-dealership-classified-listings-pro' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => Helper::stm_ew_get_image_sizes( true, true, true ),
			),
		);

		$this->stm_end_control_section();

		$this->stm_start_style_controls_section( 'style_general', esc_html__( 'General', 'motors-car-dealership-classified-listings-pro' ) );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Title Typography', 'motors-car-dealership-classified-listings-pro' ),
				'exclude'  => array(
					'font_family',
					'font_style',
					'word_spacing',
				),
				'selector' => '{{WRAPPER}} .stm_elementor_listings_grid_tabs_wrap h3',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'tab_typography',
				'label'    => esc_html__( 'Tab Typography', 'motors-car-dealership-classified-listings-pro' ),
				'exclude'  => array(
					'font_family',
					'font_style',
					'word_spacing',
				),
				'selector' => '{{WRAPPER}} .stm_elementor_listings_grid_tabs_wrap .stm_listing_nav_list li a',
			)
		);

		$this->add_control(
			'tab_margin',
			array(
				'label'     => __( 'Margin', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::DIMENSIONS,
				'default'   => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '7',
					'isLinked' => false,
				),
				'selectors' => array(
					'{{WRAPPER}} .stm_elementor_listings_grid_tabs_wrap .stm_listing_nav_list li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'           => 'tab_border',
				'label'          => esc_html__( 'Tab Border', 'motors-car-dealership-classified-listings-pro' ),
				'fields_options' => array(
					'border' => array(
						'default' => 'dashed',
					),
					'width'  => array(
						'default' => array(
							'top'      => '0',
							'right'    => '0',
							'bottom'   => '1',
							'left'     => '0',
							'isLinked' => false,
						),
					),
					'color'  => array(
						'default' => '#153e4d',
					),
				),
				'selector'       => '{{WRAPPER}} .stm_elementor_listings_grid_tabs_wrap .stm_listing_nav_list li:not(.active) a span',
			)
		);

		$this->add_control(
			'border_padding',
			array(
				'label'     => __( 'Padding', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::DIMENSIONS,
				'default'   => array(
					'top'    => '0',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0',
				),
				'selectors' => array(
					'{{WRAPPER}} .stm_elementor_listings_grid_tabs_wrap .stm_listing_nav_list li a span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition' => array(
					'tab_border_border!' => '',
				),
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Title Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .stm_elementor_listings_grid_tabs_wrap h3' => 'color: {{VALUE}};',
				),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'border_top_color',
			array(
				'label'     => esc_html__( 'Border Top Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'#wrapper {{WRAPPER}} .stm_elementor_listings_grid_tabs_wrap' => 'border-top-color: {{VALUE}};',
				),
			)
		);

		$this->stm_start_ctrl_tabs( 'tabs_style' );

		$this->stm_start_ctrl_tab(
			'tabs_normal',
			array(
				'label' => __( 'Normal', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'tab_text_color',
			array(
				'label'     => esc_html__( 'Tab Text Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .stm_elementor_listings_grid_tabs_wrap .stm_listing_nav_list li:not(.active) a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'tab_background_color',
			array(
				'label'     => esc_html__( 'Tab Background Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .stm_elementor_listings_grid_tabs_wrap .stm_listing_nav_list li:not(.active) a' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'tab_border_radius',
			array(
				'label'     => esc_html__( 'Tab Border Radius', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::DIMENSIONS,
				'selectors' => array(
					'{{WRAPPER}} .stm_elementor_listings_grid_tabs_wrap .stm_listing_nav_list li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->stm_end_ctrl_tab();

		$this->stm_start_ctrl_tab(
			'tabs_active',
			array(
				'label' => __( 'Active', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'tab_text_color_active',
			array(
				'label'     => esc_html__( 'Tab Text Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .stm_elementor_listings_grid_tabs_wrap .stm_listing_nav_list li.active a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'tab_background_color_active',
			array(
				'label'     => esc_html__( 'Tab Background Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .stm_elementor_listings_grid_tabs_wrap .stm_listing_nav_list li.active a'       => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .stm_elementor_listings_grid_tabs_wrap .stm_listing_nav_list li.active a:after' => 'border-top-color: {{VALUE}};',
				),
			)
		);

		$this->stm_end_ctrl_tab();

		$this->stm_end_ctrl_tabs();

		$this->stm_start_ctrl_tabs(
			'button_style',
			array(
				'condition' => array(
					'show_all_link' => 'yes',
				),
			)
		);

		$this->stm_start_ctrl_tab(
			'button_normal',
			array(
				'label' => __( 'Normal', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'button_text_color',
			array(
				'label'     => esc_html__( 'Button Text Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .load-more-btn' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_background_color',
			array(
				'label'     => esc_html__( 'Button Background Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .load-more-btn' => 'background-color: {{VALUE}};box-shadow: 0 2px 0 {{VALUE}};',
				),
			)
		);

		$this->stm_end_ctrl_tab();

		$this->stm_start_ctrl_tab(
			'button_hover',
			array(
				'label' => __( 'Hover', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'button_text_color_hover',
			array(
				'label'     => esc_html__( 'Button Text Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .load-more-btn:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_background_color_hover',
			array(
				'label'     => esc_html__( 'Button Background Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .load-more-btn:hover' => 'background-color: {{VALUE}};box-shadow: 0 2px 0 {{VALUE}};',
				),
			)
		);

		$this->stm_end_ctrl_tab();

		$this->stm_end_ctrl_tabs();

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
					'{{WRAPPER}} .stm_listing_tabs_style_2 .image img'                        => 'height: {{SIZE}}{{UNIT}}; object-fit: cover;',
					'{{WRAPPER}} .stm_listing_tabs_style_2 .image .interactive-hoverable'     => 'min-height: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .stm_listing_tabs_style_2 .image .interactive-hoverable img' => 'height: 100%',
				),
			)
		);

		$this->stm_end_control_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		Helper::stm_ew_load_template( 'elementor/Widgets/listings-grid-tabs', STM_LISTINGS_PATH, $settings );
	}

}
