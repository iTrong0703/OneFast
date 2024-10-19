<?php

namespace Motors_Elementor_Widgets_Free\Widgets;

use Motors_Elementor_Widgets_Free\MotorsElementorWidgetsFree;
use Motors_Elementor_Widgets_Free\Helpers\Helper;
use Motors_Elementor_Widgets_Free\Widgets\WidgetBase;

class ListingSearchTabs extends WidgetBase {

	public function __construct( array $data = array(), array $args = null ) {
		parent::__construct( $data, $args );

		$this->stm_ew_admin_register_ss(
			'stm-dynamic-listing-filter-admin',
			'stm-dynamic-listing-filter-admin'
		);

		$this->stm_ew_admin_register_ss(
			'stm-dynamic-listing-filter',
			'stm-dynamic-listing-filter'
		);

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
				'listing-search',
			)
		);
	}

	public function get_style_depends(): array {
		$widget_styles   = parent::get_style_depends();
		$widget_styles[] = 'bootstrap';
		$widget_styles[] = 'stmselect2';
		$widget_styles[] = 'app-select2';
		$widget_styles[] = 'stm-dynamic-listing-filter';
		$widget_styles[] = 'stm-dynamic-listing-filter-admin';

		return $widget_styles;
	}

	public function get_categories(): array {
		return array( MotorsElementorWidgetsFree::WIDGET_CATEGORY );
	}

	public function get_name(): string {
		return MotorsElementorWidgetsFree::STM_PREFIX . '-listings-search-tabs';
	}

	public function get_title(): string {
		return esc_html__( 'Listings Search Tabs', 'motors-car-dealership-classified-listings-pro' );
	}

	public function get_icon(): string {
		return 'stmew-listing-search-tabs';
	}

	protected function register_controls() {
		$this->stm_start_content_controls_section( 'lst_fields_content', __( 'Form Fields', 'motors-car-dealership-classified-listings-pro' ) );

		$this->add_control(
			'lst_amount',
			array(
				'label' => esc_html__( 'Listings Amount of Category', 'motors-car-dealership-classified-listings-pro' ),
				'type'  => \Elementor\Controls_Manager::SWITCHER,
			)
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'lst_taxonomy',
			array(
				'label'   => esc_html__( 'Category', 'motors-car-dealership-classified-listings-pro' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => Helper::stm_ew_get_car_filter_fields(),
			)
		);

		$repeater->add_control(
			'lst_label',
			array(
				'label' => esc_html__( 'Label', 'motors-car-dealership-classified-listings-pro' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
			)
		);

		$repeater->add_control(
			'lst_placeholder',
			array(
				'label' => esc_html__( 'Placeholder', 'motors-car-dealership-classified-listings-pro' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
			)
		);

		$repeater->add_responsive_control(
			'lst_field_width',
			array(
				'label'           => esc_html__( 'Field width', 'motors-car-dealership-classified-listings-pro' ),
				'type'            => \Elementor\Controls_Manager::SELECT,
				'options'         => array(
					'10'  => '10%',
					'15'  => '15%',
					'20'  => '20%',
					'25'  => '25%',
					'30'  => '30%',
					'33'  => '33%',
					'35'  => '35%',
					'40'  => '40%',
					'45'  => '45%',
					'50'  => '50%',
					'55'  => '55%',
					'60'  => '60%',
					'65'  => '65%',
					'70'  => '70%',
					'75'  => '75%',
					'80'  => '80%',
					'85'  => '85%',
					'90'  => '90%',
					'100' => '100%',
				),
				'desktop_default' => '25',
				'tablet_default'  => '50',
				'mobile_default'  => '100',
				'selectors'       => array(
					'{{WRAPPER}} {{CURRENT_ITEM}}.stm-select-col' => 'width: {{VALUE}}%!important',
				),
			)
		);

		$this->add_control(
			'lst_taxonomies',
			array(
				'label'       => esc_html__( 'Fields', 'motors-car-dealership-classified-listings-pro' ),
				'fields'      => $repeater->get_controls(),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'title_field' => '{{{ lst_label }}}',
			)
		);

		$this->add_control(
			'lst_advanced_search',
			array(
				'label'       => esc_html__( 'Use Advanced Search Mode', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'default'     => 'no',
				'description' => __( 'Hide optional fields and show it by clicking on special link', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'lst_advanced_search_label',
			array(
				'label'     => esc_html__( 'Advanced Search toggle label', 'motors-car-dealership-classified-listings-pro' ),
				'default'   => esc_html__( 'Advanced Search', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'condition' => array(
					'lst_advanced_search' => 'yes',
				),
			)
		);

		$this->stm_end_control_section();

		$this->stm_start_content_controls_section( 'lst_tabs_content', __( 'Search Tabs', 'motors-car-dealership-classified-listings-pro' ) );

		$this->add_control(
			'lst_show_tabs',
			array(
				'label'   => esc_html__( 'Category Tabs', 'motors-car-dealership-classified-listings-pro' ),
				'default' => 'yes',
				'type'    => \Elementor\Controls_Manager::SWITCHER,
			)
		);

		$this->add_control(
			'lst_show_all_tab',
			array(
				'label'   => esc_html__( 'All Categories Tab', 'motors-car-dealership-classified-listings-pro' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'lst_show_all_text',
			array(
				'label'   => esc_html__( 'All Categories Tab Title', 'motors-car-dealership-classified-listings-pro' ),
				'default' => esc_html__( 'All', 'motors-car-dealership-classified-listings-pro' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
			)
		);

		$this->add_control(
			'lst_condition_tabs',
			array(
				'label'    => esc_html__( 'Categories', 'motors-car-dealership-classified-listings-pro' ),
				'type'     => \Elementor\Controls_Manager::SELECT2,
				'options'  => Helper::stm_ew_get_listing_taxonomies( true ),
				'multiple' => true,
			)
		);

		$this->add_control(
			'tab_prefix',
			array(
				'label'       => __( 'Tab Prefix', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'description' => __( 'This will appear before category name', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'tab_suffix',
			array(
				'label'       => __( 'Tab Suffix', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'description' => __( 'This will appear after category name', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->stm_end_control_section();

		if ( defined( 'STM_REVIEW' ) ) {

			$this->stm_start_content_controls_section( 'lst_section_reviews', esc_html__( 'Car Reviews Tab', 'motors-car-dealership-classified-listings-pro' ) );

			$this->add_control(
				'lst_enable_reviews',
				array(
					'label'   => esc_html__( 'Show Car Reviews Tab', 'motors-car-dealership-classified-listings-pro' ),
					'type'    => \Elementor\Controls_Manager::SWITCHER,
					'default' => 'yes',
				)
			);

			$reviews_repeater = new \Elementor\Repeater();

			$reviews_repeater->add_control(
				'lst_reviews_taxonomy',
				array(
					'label'   => esc_html__( 'Category', 'motors-car-dealership-classified-listings-pro' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => Helper::stm_ew_get_car_filter_fields(),
				)
			);

			$reviews_repeater->add_control(
				'lst_reviews_label',
				array(
					'label' => esc_html__( 'Label', 'motors-car-dealership-classified-listings-pro' ),
					'type'  => \Elementor\Controls_Manager::TEXT,
				)
			);

			$reviews_repeater->add_control(
				'lst_reviews_placeholder',
				array(
					'label' => esc_html__( 'Placeholder', 'motors-car-dealership-classified-listings-pro' ),
					'type'  => \Elementor\Controls_Manager::TEXT,
				)
			);

			$reviews_repeater->add_responsive_control(
				'lst_field_width',
				array(
					'label'           => esc_html__( 'Field width', 'motors-car-dealership-classified-listings-pro' ),
					'type'            => \Elementor\Controls_Manager::SELECT,
					'options'         => array(
						'10'  => '10%',
						'15'  => '15%',
						'20'  => '20%',
						'25'  => '25%',
						'30'  => '30%',
						'33'  => '33%',
						'35'  => '35%',
						'40'  => '40%',
						'45'  => '45%',
						'50'  => '50%',
						'55'  => '55%',
						'60'  => '60%',
						'65'  => '65%',
						'70'  => '70%',
						'75'  => '75%',
						'80'  => '80%',
						'85'  => '85%',
						'90'  => '90%',
						'100' => '100%',
					),
					'desktop_default' => '25',
					'tablet_default'  => '50',
					'mobile_default'  => '100',
					'selectors'       => array(
						'{{WRAPPER}} {{CURRENT_ITEM}}.stm-select-col' => 'width: {{VALUE}}%',
					),
				)
			);

			$this->add_control(
				'lst_reviews_taxonomies',
				array(
					'label'       => esc_html__( 'Fields', 'motors-car-dealership-classified-listings-pro' ),
					'fields'      => $reviews_repeater->get_controls(),
					'type'        => \Elementor\Controls_Manager::REPEATER,
					'title_field' => '{{{ lst_reviews_label }}}',
				)
			);

			$this->stm_end_control_section();

		}

		if ( defined( 'STM_VALUE_MY_CAR' ) ) {

			$this->stm_start_content_controls_section( 'lst_section_value_my_car', esc_html__( 'Value My Car Tab', 'motors-car-dealership-classified-listings-pro' ) );

			$this->add_control(
				'lst_enable_value_my_car',
				array(
					'label'   => esc_html__( 'Show Value My Car Tab', 'motors-car-dealership-classified-listings-pro' ),
					'type'    => \Elementor\Controls_Manager::SWITCHER,
					'default' => 'yes',
				)
			);

			$this->add_control(
				'lst_value_my_car_fields',
				array(
					'label'       => esc_html__( 'Fields', 'motors-car-dealership-classified-listings-pro' ),
					'type'        => \Elementor\Controls_Manager::SELECT2,
					'options'     => Helper::stm_ew_get_value_my_car_options(),
					'multiple'    => true,
					'default'     => array( 'email', 'phone', 'make', 'model' ),
					'description' => esc_html__( 'Required fields: Email, Phone, Make and Model', 'motors-car-dealership-classified-listings-pro' ),
				)
			);

			$this->stm_end_control_section();
		}

		$this->stm_start_content_controls_section( 'lst_btn_settings', esc_html__( 'Button', 'motors-car-dealership-classified-listings-pro' ) );

		$this->add_control(
			'lst_btn_postfix',
			array(
				'label'   => esc_html__( 'Search button postfix', 'motors-car-dealership-classified-listings-pro' ),
				'default' => esc_html__( 'Cars', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'lst_btn_icon',
			array(
				'label'            => esc_html__( 'Icon', 'motors-car-dealership-classified-listings-pro' ),
				'type'             => \Elementor\Controls_Manager::ICONS,
				'skin'             => 'inline',
				'fa4compatibility' => 'icon',
				'default'          => array(
					'value'   => 'fas fa-search',
					'library' => 'fa-solid',
				),
			)
		);

		$this->add_control(
			'lst_btn_icon_size',
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
					'{{WRAPPER}} form button[type="submit"] > svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'lst_btn_icon[value]!' => '',
				),
			)
		);

		$this->stm_end_control_section();

		$this->stm_start_style_controls_section( 'section_style_general', esc_html__( 'General', 'motors-car-dealership-classified-listings-pro' ) );

		$this->add_control(
			'background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .filter-listing .tab-content' => 'background: {{VALUE}};',
				),
				'separator' => 'after',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'           => 'tab_border',
				'label'          => __( 'Tab Border', 'motors-elementor-widgets' ),
				'fields_options' => array(
					'border' => array(
						'default' => 'solid',
					),
					'width'  => array(
						'default' => array(
							'top'      => '0',
							'right'    => '1',
							'bottom'   => '0',
							'left'     => '0',
							'isLinked' => false,
						),
					),
					'color'  => array(
						'default' => '#133340',
					),
				),
				'selector'       => '{{WRAPPER}} .stm_dynamic_listing_filter .stm_dynamic_listing_filter_nav li',
			)
		);

		$this->add_control(
			'fields_style_heading',
			array(
				'label' => esc_html__( 'Fields Style', 'motors-car-dealership-classified-listings-pro' ),
				'type'  => \Elementor\Controls_Manager::HEADING,
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'lst_fields_border',
				'label'    => esc_html__( 'Fields Border', 'motors-car-dealership-classified-listings-pro' ),
				'selector' => '{{WRAPPER}} .filter-listing .tab-content .stm-filter-tab-selects .stm-select-col input, {{WRAPPER}} .filter-listing .tab-content .stm-filter-tab-selects .stm-select-col select',
			)
		);

		$this->add_responsive_control(
			'lst_fields_border_radius',
			array(
				'label'      => esc_html__( 'Fields Border Radius', 'motors-car-dealership-classified-listings-pro' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .filter-listing .tab-content .stm-filter-tab-selects .stm-select-col input'         => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}!important;',
					'{{WRAPPER}} .filter-listing .tab-content .stm-filter-tab-selects .stm-select-col select'        => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}!important;',
					'{{WRAPPER}} .stm_dynamic_listing_filter .select2-container--default .select2-selection--single' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}!important;',
				),
			)
		);

		$this->add_control(
			'lst_border_divider',
			array(
				'type' => \Elementor\Controls_Manager::DIVIDER,
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'tab_typography',
				'label'          => esc_html__( 'Tab Typography', 'motors-car-dealership-classified-listings-pro' ),
				'exclude'        => array(
					'font_style',
					'text_decoration',
					'word_spacing',
				),
				'fields_options' => array(),
				'selector'       => '{{WRAPPER}} .stm_dynamic_listing_filter_nav li a',
			)
		);

		$this->stm_start_ctrl_tabs( 'tab_style' );

		$this->stm_start_ctrl_tab(
			'tab_normal',
			array(
				'label' => __( 'Normal', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'tab_background_color',
			array(
				'label'     => esc_html__( 'Tab Background Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .stm_dynamic_listing_filter_nav li:not(.active)' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'tab_text_color',
			array(
				'label'     => esc_html__( 'Tab Text Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .stm_dynamic_listing_filter_nav li a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->stm_end_ctrl_tab();

		$this->stm_start_ctrl_tab(
			'tab_active',
			array(
				'label' => __( 'Active', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'tab_background_color_active',
			array(
				'label'     => esc_html__( 'Tab Background Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .stm_dynamic_listing_filter_nav li.active' => 'background: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'tab_text_color_active',
			array(
				'label'     => esc_html__( 'Tab Text Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .stm_dynamic_listing_filter_nav li.active a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->stm_end_ctrl_tab();

		$this->stm_end_ctrl_tabs();

		$this->add_control(
			'lst_advanced_search_label_font_size',
			array(
				'label'      => esc_html__( 'Advanced Search Toggle Font Size', 'motors-car-dealership-classified-listings-pro' ),
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
					'size' => 13,
				),
				'selectors'  => array(
					'{{WRAPPER}} .filter-listing.stm_dynamic_listing_filter .tab-content .stm-filter-tab-selects .stm-show-more .show-extra-fields' => 'font-size: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'lst_advanced_search' => 'yes',
				),
			)
		);

		$this->stm_start_ctrl_tabs( 'lst_advanced_search_label_style' );

		$this->stm_start_ctrl_tab(
			'lst_advanced_search_label_normal',
			array(
				'label' => __( 'Normal', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'lst_advanced_search_label_color',
			array(
				'label'     => esc_html__( 'Advanced Search toggle label color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#888888',
				'selectors' => array(
					'{{WRAPPER}} .filter-listing.stm_dynamic_listing_filter .tab-content .stm-filter-tab-selects .stm-show-more .show-extra-fields' => 'color: {{VALUE}};',
				),
			)
		);

		$this->stm_end_ctrl_tab();

		$this->stm_start_ctrl_tab(
			'lst_advanced_search_label_hover',
			array(
				'label' => __( 'Hover', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'lst_advanced_search_label_color_hover',
			array(
				'label'     => esc_html__( 'Advanced Search toggle label color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .filter-listing.stm_dynamic_listing_filter .tab-content .stm-filter-tab-selects .stm-show-more .show-extra-fields:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->stm_end_ctrl_tab();

		$this->stm_end_ctrl_tabs();

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
					'{{WRAPPER}} .filter-listing .tab-content button[type=submit]' => 'background: {{VALUE}};box-shadow: 0 2px 0 {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_text_color',
			array(
				'label'     => esc_html__( 'Button Text Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .filter-listing .tab-content button[type=submit]' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .filter-listing .tab-content form button[type=submit]:hover' => 'background: {{VALUE}};box-shadow: 0 2px 0 {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_text_color_hover',
			array(
				'label'     => esc_html__( 'Button Text Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .filter-listing .tab-content form button[type=submit]:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->stm_end_ctrl_tab();

		$this->stm_end_ctrl_tabs();

		$this->add_control(
			'buttons_style_sep',
			array(
				'type' => \Elementor\Controls_Manager::DIVIDER,
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

		$this->add_control(
			'validation_issues_color',
			array(
				'label'     => esc_html__( 'Validation Issues Text Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .filter-listing.stm_dynamic_listing_filter .tab-content .stm-filter-tab-selects .vmc-file-wrap .file-wrap .error' => 'color: {{VALUE}};',
				),
			)
		);

		$this->stm_end_control_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$icon = ! empty( $settings['lst_btn_icon']['value'] ) ? $settings['lst_btn_icon']['value'] : '';

		$this->add_render_attribute( 'icon', 'class', $icon );

		$icon_html = '<i ' . $this->get_render_attribute_string( 'icon' ) . '></i>';

		$settings['__button_icon_html__'] = $icon_html;

		wp_deregister_style( 'stm-dynamic-listing-filter-admin' );

		Helper::stm_ew_load_template( '/elementor/Widgets/listings-search-tabs', STM_LISTINGS_PATH, $settings );
	}

}
