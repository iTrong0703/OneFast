<?php

namespace Motors_Elementor_Widgets_Free\Widgets;

use Motors_Elementor_Widgets_Free\MotorsElementorWidgetsFree;
use Motors_Elementor_Widgets_Free\Helpers\Helper;
use Motors_Elementor_Widgets_Free\Widgets\WidgetBase;

class InventorySearchFilter extends WidgetBase {

	public function __construct( array $data = array(), array $args = null ) {
		parent::__construct( $data, $args );

		$this->stm_ew_admin_register_ss( $this->get_admin_name(), self::get_name(), STM_LISTINGS_PATH, STM_LISTINGS_URL, STM_LISTINGS_V );
		$this->stm_ew_enqueue(
			self::get_name(),
			STM_LISTINGS_PATH,
			STM_LISTINGS_URL,
			STM_LISTINGS_V,
			array(
				'jquery',
				'elementor-frontend',
			)
		);
		if ( is_rtl() ) {
			$this->stm_ew_enqueue( self::get_name() . '-rtl', STM_LISTINGS_PATH, STM_LISTINGS_URL, STM_LISTINGS_V );
		}

	}

	public function get_categories() {
		return array( MotorsElementorWidgetsFree::WIDGET_CATEGORY );
	}

	public function get_name() {
		return MotorsElementorWidgetsFree::STM_PREFIX . '-inventory-search-filter';
	}

	public function get_title() {
		return esc_html__( 'Search Filter', 'motors-car-dealership-classified-listings-pro' );
	}

	public function get_icon() {
		return 'stmew-inventory-filter';
	}

	public function get_script_depends() {
		$depends = array(
			'uniform',
			'uniform-init',
			'jquery-effects-slide',
			'stmselect2',
			'app-select2',
			$this->get_admin_name(),
			$this->get_name(),
		);

		if ( apply_filters( 'stm_enable_location', false ) ) {
			$depends[] = 'stm_gmap';
			$depends[] = 'stm-google-places';
		}

		return $depends;
	}

	public function get_style_depends() {
		$widget_styles   = parent::get_style_depends();
		$widget_styles[] = 'motors-general-admin';
		$widget_styles[] = self::get_name() . '-rtl';
		$widget_styles[] = 'uniform';
		$widget_styles[] = 'uniform-init';
		$widget_styles[] = 'jquery-effects-slide';
		$widget_styles[] = 'stmselect2';
		$widget_styles[] = 'app-select2';

		return $widget_styles;
	}

	protected function register_controls() {

		$this->stm_start_content_controls_section( 'isf_content', __( 'General', 'motors-car-dealership-classified-listings-pro' ) );

		if ( function_exists( 'stm_is_multilisting' ) && stm_is_multilisting() ) {

			$this->add_control(
				'post_type',
				array(
					'label'   => __( 'Listing Type', 'motors-car-dealership-classified-listings-pro' ),
					'type'    => 'select',
					'options' => Helper::stm_ew_multi_listing_types(),
					'default' => 'listings',
				),
			);

		}
		if ( ! stm_is_multilisting() ) {

			$this->add_control(
				'sb_heading',
				array(
					'label' => $this->motors_selected_filters(),
					'type'  => \Elementor\Controls_Manager::HEADING,
				)
			);

		} else {
			$listing_types = Helper::stm_ew_multi_listing_types();

			if ( $listing_types ) {
				foreach ( $listing_types as $slug => $typename ) {

					$this->add_control(
						'sb_heading_' . $slug,
						array(
							'label'     => $this->motors_selected_filters( $slug ),
							'type'      => \Elementor\Controls_Manager::HEADING,
							'condition' => array(
								'post_type' => $slug,
							),
						)
					);

				}
			}
		}

		$this->add_control(
			'search_options_icon',
			array(
				'label'            => __( 'Title Icon', 'motors-car-dealership-classified-listings-pro' ),
				'type'             => \Elementor\Controls_Manager::ICONS,
				'skin'             => 'inline',
				'label_block'      => false,
				'fa4compatibility' => 'icon',
				'default'          => array(
					'value'   => 'motors-icons-car_search',
					'library' => 'svg',
				),
			)
		);

		$this->add_control(
			'isf_title',
			array(
				'label'   => __( 'Title', 'motors-car-dealership-classified-listings-pro' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Search Options', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'isf_icon_position',
			array(
				'label'   => esc_html__( 'Icon Position', 'motors-car-dealership-classified-listings-pro' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'left'  => 'Left',
					'right' => 'Right',
				),
				'default' => 'left',
			)
		);

		$this->add_control(
			'isf_price_single',
			array(
				'label'     => __( 'Price As Single Block', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'On', 'motors-car-dealership-classified-listings-pro' ),
				'label_off' => esc_html__( 'Off', 'motors-car-dealership-classified-listings-pro' ),
				'default'   => '',
			)
		);

		$this->add_control(
			'reset_btn_heading',
			array(
				'label' => __( 'Reset Button', 'motors-car-dealership-classified-listings-pro' ),
				'type'  => \Elementor\Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'reset_btn_icon',
			array(
				'label'            => __( 'Icon', 'motors-car-dealership-classified-listings-pro' ),
				'type'             => \Elementor\Controls_Manager::ICONS,
				'skin'             => 'inline',
				'label_block'      => false,
				'fa4compatibility' => 'icon',
				'default'          => array(
					'value' => 'motors-icons-reset',
				),
			)
		);

		$this->add_control(
			'reset_btn_label',
			array(
				'label'   => __( 'Label', 'motors-car-dealership-classified-listings-pro' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Reset All', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'isf_mobile_btn_results_text_heading',
			array(
				'label' => __( 'Mobile Result Button', 'motors-car-dealership-classified-listings-pro' ),
				'type'  => \Elementor\Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'isf_mobile_results_btn_text',
			array(
				'label'       => esc_html__( 'Button text', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Show' ) . ' {{total}}',
				'default'     => __( 'Show' ) . ' {{total}}' . __( ' Cars' ),
				'description' => __( 'Available replacement:' ) . ' {{total}}',
			)
		);

		$this->stm_end_control_section();

		$this->stm_start_style_controls_section( 'isf_general_section', __( 'General', 'motors-car-dealership-classified-listings-pro' ) );

		$this->add_control(
			'isf_slider_range-color',
			array(
				'label'     => esc_html__( 'Range Slider Control Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .classic-filter-row .ui-slider .ui-slider-range'                                               => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .classic-filter-row .ui-slider .ui-slider-handle:after'                                        => 'background-color: {{VALUE}};',
					'.classic-filter-row.mobile-filter-row .ui-slider .ui-slider-range'                                         => 'background-color: {{VALUE}};',
					'.classic-filter-row.mobile-filter-row .ui-slider .ui-slider-handle:after'                                  => 'background-color: {{VALUE}};',
					'.stm-template-car_dealer_two_elementor {{WRAPPER}} .classic-filter-row .ui-slider .ui-slider-range'        => 'background-color: {{VALUE}}!important;',
					'.stm-template-car_dealer_two_elementor {{WRAPPER}} .classic-filter-row .ui-slider .ui-slider-handle:after' => 'background-color: {{VALUE}}!important;',
				),
			)
		);

		$this->stm_end_control_section();

		$this->stm_start_style_controls_section( 'isf_main_section', __( 'Main', 'motors-car-dealership-classified-listings-pro' ) );

		$this->add_control(
			'isf_general_block',
			array(
				'label' => __( 'General', 'motors-car-dealership-classified-listings-pro' ),
				'type'  => \Elementor\Controls_Manager::HEADING,
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'isf_general_box_shadow',
				'label'    => __( 'Box Shadow', 'motors-car-dealership-classified-listings-pro' ),
				'selector' => '{{WRAPPER}} .classic-filter-row.motors-elementor-widget form > .filter-sidebar',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'isf_general_bg',
				'label'    => __( 'Background', 'motors-car-dealership-classified-listings-pro' ),
				'types'    => array( 'classic', 'gradient', 'image' ),
				'selector' => '{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar',
			)
		);

		$this->add_responsive_control(
			'isf_main_box_padding',
			array(
				'type'      => \Elementor\Controls_Manager::DIMENSIONS,
				'label'     => __( 'Box Padding', 'motors-car-dealership-classified-listings-pro' ),
				'default'   => array(
					'top'    => '',
					'right'  => '',
					'bottom' => '',
					'left'   => '',
				),
				'selectors' => array(
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar'                       => 'padding: 0 {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar .row-pad-top-24'       => 'padding-top: {{TOP}}{{UNIT}};',
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar .sidebar-entry-header' => 'margin-right: -{{RIGHT}}{{UNIT}}; margin-left: -{{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'isf_select_heading',
			array(
				'label'     => __( 'Field', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->stm_start_ctrl_tabs(
			'isf_fields_style',
		);

		$this->stm_start_ctrl_tab(
			'isf_field_normal',
			array(
				'label' => __( 'Normal', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'isf_general_select_color',
			array(
				'label'     => esc_html__( 'Background color', 'motors-elementor-settings' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#eceff3',
				'selectors' => array(
					'{{WRAPPER}} .filter-sidebar select' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .filter-sidebar input'  => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .filter-sidebar .select2-container--default .select2-selection--single .select2-selection__rendered' => 'background-color: {{VALUE}};',
					'.stm-template-car_dealer_two_elementor.no_margin {{WRAPPER}} .classic-filter-row .search-filter-form .filter-sidebar .row-pad-top-24 .stm-slider-filter-type-unit' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .filter-sidebar .select2-container--focus' => 'background-color: {{VALUE}};',
					'.select2-container--default .filter-select .select2-results__option--highlighted[aria-selected]' => 'background-color: {{VALUE}} !important;',
					'.select2-container--default .filter-select .select2-results__option[aria-selected=true]' => 'background-color: {{VALUE}} !important;',
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar' => '--location-field-bg-color: {{VALUE}};',
					'{{WRAPPER}} .filter-sidebar .select2-container--default .select2-selection--multiple' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'isf_general_input_color',
			array(
				'label'     => esc_html__( 'Input Background color', 'motors-elementor-settings' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#eceff3',
				'selectors' => array(
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar input[type=text]' => 'background-color: {{VALUE}}!important;',
				),
			)
		);

		$this->add_control(
			'isf_select_text_color',
			array(
				'label'     => __( 'Text Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'.stm-template-car_dealer_two_elementor.no_margin {{WRAPPER}} .classic-filter-row .filter-sidebar .row-pad-top-24 .stm-slider-filter-type-unit .clearfix .stm-current-slider-labels' => 'color: {{VALUE}};',
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar .select2-container--default .select2-selection--single .select2-selection__rendered'                        => 'color: {{VALUE}};',
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar .select2-container--default .select2-selection--multiple .select2-selection__rendered'                      => 'color: {{VALUE}};',
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar .select2-container--default .select2-selection--single .select2-selection__arrow b'                         => 'color: {{VALUE}};',
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar .select2-container--default .select2-selection--multiple'                                                   => 'color: {{VALUE}};',
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar select'                                                                                                     => 'color: {{VALUE}};',
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar input[type=text]'                                                                                           => 'color: {{VALUE}};',
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar input[type=text]::placeholder'                                                                              => 'color: {{VALUE}};',
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar input[type=number]'                                                                                         => 'color: {{VALUE}};',
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar input[type=search]'                                                                                         => 'color: {{VALUE}};',
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar input[type=search]::placeholder'                                                                            => 'color: {{VALUE}};',
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar .stm-location-search-unit:before'                                                                           => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'isf_slider_text_color',
			array(
				'label'     => __( 'Field Title Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar h5.pull-left'                                            => 'color: {{VALUE}};',
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar h5'                                                      => 'color: {{VALUE}};',
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar .stm-slider-filter-type-unit .pull-left'                 => 'color: {{VALUE}};',
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar .stm-slider-filter-type-unit .stm-current-slider-labels' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'isf_field_border',
				'label'    => esc_html__( 'Button Border', 'motors-car-dealership-classified-listings-pro' ),
				'selector' => '
					{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar .select2-container--default .select2-selection--single .select2-selection__rendered,
					{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar .select2-container--default .select2-selection--multiple,
					{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar select,
					{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar input[type=text],
					{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar input[type=number],
					{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar input[type=search]
				',
				'default'  => array(
					'border' => array(
						'width' => array(
							'top'    => '0',
							'right'  => '0',
							'bottom' => '0',
							'left'   => '0',
						),
						'color' => '',
						'style' => 'solid',
					),
				),
			)
		);

		$this->add_responsive_control(
			'isf_field_border_radius',
			array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => esc_html__( 'Border Radius', 'motors-car-dealership-classified-listings-pro' ),
				'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
				'selectors'  => array(
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar .select2-container--default'                                                         => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar .select2-container--default .select2-selection--single'                              => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar .select2-container--default .select2-selection--single .select2-selection__rendered' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar .select2-container--default .select2-selection--multiple'                            => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar select'                                                                              => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar input[type=text]'                                                                    => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar input[type=number]'                                                                  => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar input[type=search]'                                                                  => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->stm_end_ctrl_tab();

		$this->stm_start_ctrl_tab(
			'isf_field_active',
			array(
				'label' => __( 'Active', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'isf_general_select_color_active',
			array(
				'label'     => esc_html__( 'Background color', 'motors-elementor-settings' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#eceff3',
				'selectors' => array(
					'{{WRAPPER}} .filter-sidebar select:focus'                                                                                                 => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .filter-sidebar input:focus'                                                                                                  => 'background-color: {{VALUE}} !important;',
					'{{WRAPPER}} .filter-sidebar .select2-container--default.select2-container--focus .select2-selection--single .select2-selection__rendered' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .filter-sidebar .select2-container--default.select2-container--focus .select2-selection--multiple'                            => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'isf_general_input_color_active',
			array(
				'label'     => esc_html__( 'Input Background color', 'motors-elementor-settings' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#eceff3',
				'selectors' => array(
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar input[type=text]:focus' => 'background-color: {{VALUE}}!important;',
				),
			)
		);

		$this->add_control(
			'isf_select_text_color_active',
			array(
				'label'     => __( 'Text Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar .select2-container--default.select2-container--focus .select2-selection--single .select2-selection__rendered' => 'color: {{VALUE}};',
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar .select2-container--default.select2-container--focus .select2-selection--multiple'                            => 'color: {{VALUE}};',
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar select:focus'                                                                                                 => 'color: {{VALUE}};',
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar input[type=text]:focus'                                                                                       => 'color: {{VALUE}};',
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar input[type=number]:focus'                                                                                     => 'color: {{VALUE}};',
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar input[type=search]:focus'                                                                                     => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'isf_field_border_active',
				'label'    => esc_html__( 'Button Border', 'motors-car-dealership-classified-listings-pro' ),
				'selector' => '{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar input:focus',
			)
		);

		$this->add_control(
			'isf_field_border_radius_active',
			array(
				'label'      => esc_html__( 'Border Radius', 'motors-car-dealership-classified-listings-pro' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'default'    => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .stm-pricing-plan__button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'after',
			)
		);

		$this->stm_end_ctrl_tab();

		$this->stm_end_ctrl_tabs();

		$this->add_control(
			'isf_title_block',
			array(
				'label'     => __( 'Title Block', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'isf_box_padding',
			array(
				'label'     => __( 'Box Padding', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::DIMENSIONS,
				'default'   => array(
					'top'      => '26',
					'right'    => '22',
					'bottom'   => '21',
					'left'     => '22',
					'unit'     => 'px',
					'isLinked' => false,
				),
				'selectors' => array(
					'{{WRAPPER}} .classic-filter-row .sidebar-entry-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'isf_bg',
			array(
				'label'     => __( 'Background', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#232628',
				'selectors' => array(
					'{{WRAPPER}} .classic-filter-row .sidebar-entry-header'                          => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .classic-filter-row .stm-accordion-single-unit > a:not(.collapsed)' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .stm-filter-links .stm-accordion-single-unit > a:not(.collapsed)'   => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'isf_icon_size',
			array(
				'label'      => __( 'Icon Size', 'motors-car-dealership-classified-listings-pro' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 8,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 29,
				),
				'selectors'  => array(
					'{{WRAPPER}} .classic-filter-row .sidebar-entry-header i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .classic-filter-row .sidebar-entry-header svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'isf_icon_color',
			array(
				'label'     => __( 'Icon Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .classic-filter-row .sidebar-entry-header i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .classic-filter-row .sidebar-entry-header svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'isf_title_text_color',
			array(
				'label'     => __( 'Title Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .classic-filter-row .sidebar-entry-header .h4'        => 'color: {{VALUE}};',
					'{{WRAPPER}} .classic-filter-row .sidebar-entry-header-mobile .h4' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'isf_title_typography',
				'label'    => __( 'Title Text Style', 'stm_elementor_widgets' ),
				'selector' => '{{WRAPPER}} .classic-filter-row .sidebar-entry-header .h4',
			)
		);

		$this->add_control(
			'isf_btn_heading',
			array(
				'label'     => __( 'Reset Button', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->stm_start_ctrl_tabs( 'isf_btn_tabs' );

		$this->stm_start_ctrl_tab(
			'isf_btn_normal',
			array(
				'label' => __( 'Normal', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'isf_btn_border',
				'label'    => esc_html__( 'Button Border', 'motors-car-dealership-classified-listings-pro' ),
				'selector' => '{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar .sidebar-action-units a.button',
				'default'  => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
			)
		);

		$this->add_control(
			'isf_btn_border_radius',
			array(
				'label'     => esc_html__( 'Border Radius', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::DIMENSIONS,
				'default'   => array(
					'top'      => '3',
					'right'    => '3',
					'bottom'   => '3',
					'left'     => '3',
					'unit'     => 'px',
					'isLinked' => true,
				),
				'selectors' => array(
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar .sidebar-action-units a.button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'isf_btn_bg',
			array(
				'label'     => __( 'Background', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#6c98e1',
				'selectors' => array(
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar .sidebar-action-units a.button' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'isf_btn_box_shadow',
				'selector' => '{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar .sidebar-action-units a.button',
				'label'    => __( 'Box Shadow', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'isf_btn_text_color',
			array(
				'label'     => __( 'Text Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar .sidebar-action-units a.button' => 'color: {{VALUE}};',
				),
			)
		);

		$this->stm_end_ctrl_tab();

		$this->stm_start_ctrl_tab(
			'isf_btn_hover',
			array(
				'label' => __( 'Hover', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'isf_btn_border_hover',
				'label'    => esc_html__( 'Button Border', 'motors-car-dealership-classified-listings-pro' ),
				'selector' => '{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar .sidebar-action-units a.button:hover',
				'default'  => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
			)
		);

		$this->add_control(
			'isf_btn_border_radius_hover',
			array(
				'label'      => esc_html__( 'Border Radius', 'motors-car-dealership-classified-listings-pro' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'default'    => array(
					'top'      => '3',
					'right'    => '3',
					'bottom'   => '3',
					'left'     => '3',
					'unit'     => 'px',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar .sidebar-action-units a.button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'isf_btn_bg_hover',
			array(
				'label'     => __( 'Background', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#6c98e1',
				'selectors' => array(
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar .sidebar-action-units a.button:hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'isf_btn_box_shadow_hover',
				'label'    => __( 'Box Shadow', 'motors-car-dealership-classified-listings-pro' ),
				'selector' => '{{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar .sidebar-action-units a.button:hover',
			)
		);

		$this->add_control(
			'isf_btn_text_color_hover',
			array(
				'label'     => __( 'Text Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'#main {{WRAPPER}} .classic-filter-row.motors-elementor-widget .filter-sidebar .sidebar-action-units a.button:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->stm_end_ctrl_tab();

		$this->stm_end_ctrl_tabs();

		$this->add_control(
			'isf_reset_icon_size',
			array(
				'label'      => __( 'Icon Size', 'motors-car-dealership-classified-listings-pro' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 8,
						'max'  => 30,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 17,
				),
				'selectors'  => array(
					'{{WRAPPER}} .sidebar-action-units .button i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .sidebar-action-units .button svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'isf_reset_icon_margin',
			array(
				'label'      => __( 'Icon Margin', 'motors-car-dealership-classified-listings-pro' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em', 'rem' ),
				'default'    => array(
					'top'      => '0',
					'right'    => '6',
					'bottom'   => '0',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => false,
				),
				'selectors'  => array(
					'{{WRAPPER}} .sidebar-action-units .button i'   => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}!important;',
					'{{WRAPPER}} .sidebar-action-units .button svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}!important;',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'isf_btn_typography',
				'label'          => __( 'Text Style', 'stm_elementor_widgets' ),
				'selector'       => '{{WRAPPER}} .sidebar-action-units .button span',
				'exclude'        => array(
					'font_family',
					'font_style',
					'text_decoration',
					'word_spacing',
				),
				'fields_options' => array(
					'font_size'      => array(
						'default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'font_weight'    => array(
						'default' => '700',
					),
					'line_height'    => array(
						'default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'text_transform' => array(
						'default' => 'uppercase',
					),
				),
			)
		);

		$this->add_control(
			'text_align',
			array(
				'label'     => esc_html__( 'Text Alignment', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => __( 'Left', 'motors-car-dealership-classified-listings-pro' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'motors-car-dealership-classified-listings-pro' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'motors-car-dealership-classified-listings-pro' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'center',
				'selectors' => array(
					'{{WRAPPER}} .sidebar-action-units .button' => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'isf_button_padding',
			array(
				'label'      => __( 'Box Padding', 'motors-car-dealership-classified-listings-pro' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em', 'rem' ),
				'default'    => array(
					'top'    => '17',
					'right'  => '28',
					'bottom' => '15',
					'left'   => '28',
					'unit'   => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .sidebar-action-units .button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->stm_end_control_section();
		//secondary

		$this->stm_start_style_controls_section( 'isf_secondary_block_style', __( 'Secondary', 'motors-car-dealership-classified-listings-pro' ) );

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'isf_secondary_box_shadow',
				'label'    => __( 'Box Shadow', 'motors-car-dealership-classified-listings-pro' ),
				'selector' => '{{WRAPPER}} .stm-accordion-single-unit',
			)
		);

		$this->add_control(
			'isf_second_filter_border_color',
			array(
				'label'     => __( 'Top Border Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#232628',
				'selectors' => array(
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget form > div:not(.filter-sidebar) a.title' => 'border-top-color: {{VALUE}};',
					'{{WRAPPER}} .stm-filter-links .stm-accordion-single-unit a.title'                                => 'border-top-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'isf_second_label_color',
			array(
				'label'     => __( 'Label Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget form > div:not(.filter-sidebar) a.title h5' => 'color: {{VALUE}};',
					'{{WRAPPER}} .stm-filter-links .stm-accordion-single-unit a.title h5'                                => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'isf_second_label_bg_color',
			array(
				'label'     => __( 'Label Background Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget form > div:not(.filter-sidebar) a.title' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .stm-filter-links .stm-accordion-single-unit a.title'                                => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'isf_collapse_heading',
			array(
				'label'     => __( 'Collapse Indicatior Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->stm_start_ctrl_tabs( 'isf_collapse_indicator' );

		$this->stm_start_ctrl_tab(
			'isf_collapse_indicator_normal',
			array(
				'label' => __( 'Normal', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'isf_collapse_indicator_bg',
			array(
				'label'     => __( 'Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#cccccc',
				'selectors' => array(
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget form > div:not(.filter-sidebar) a.title span'       => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget form > div:not(.filter-sidebar) a.title span:after' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .stm-filter-links .stm-accordion-single-unit a.title span'                                      => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .stm-filter-links .stm-accordion-single-unit a.title span:after'                                => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->stm_end_ctrl_tab();

		$this->stm_start_ctrl_tab(
			'isf_collapse_indicator_hover',
			array(
				'label' => __( 'Hover', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'isf_collapse_indicator_hover_bg',
			array(
				'label'     => __( 'Background', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#6c98e1',
				'selectors' => array(
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget form > div:not(.filter-sidebar) a.title:hover span'       => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget form > div:not(.filter-sidebar) a.title:hover span:after' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .stm-filter-links .stm-accordion-single-unit a.title:hover span'                                      => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .stm-filter-links .stm-accordion-single-unit a.title:hover span:after'                                => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->stm_end_ctrl_tab();

		$this->stm_end_ctrl_tabs();

		$this->add_control(
			'isf_checkbox_label_color',
			array(
				'label'       => __( 'Checkbox Label Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'description' => 'Used only if checked option in listing category (Use on listing archive as checkboxes)',
				'default'     => '#232628',
				'separator'   => 'before',
				'selectors'   => array(
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget form > div:not(.filter-sidebar) .stm-accordion-content .stm-option-label span' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'isf_second_bg',
				'label'    => __( 'Background', 'motors-car-dealership-classified-listings-pro' ),
				'types'    => array(
					'classic',
					'gradient',
				),
				'exclude'  => array(
					'image',
				),
				'selector' => '{{WRAPPER}} .classic-filter-row.motors-elementor-widget form > div:not(.filter-sidebar), {{WRAPPER}} .classic-filter-row.motors-elementor-widget .stm-filter-links .stm-accordion-single-unit .stm-accordion-content',
			)
		);

		$this->add_control(
			'isf_pal_heading',
			array(
				'label'     => __( 'Params as Links', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->stm_start_ctrl_tabs( 'isf_pal' );

		$this->stm_start_ctrl_tab(
			'isf_pal_normal',
			array(
				'label' => __( 'Normal', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'isf_pal_icon_color',
			array(
				'label'     => __( 'Icon Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#cc6119',
				'selectors' => array(
					'{{WRAPPER}} .stm-filter-links .stm-accordion-content .list-style-3 li:before' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'isf_pal_link_color',
			array(
				'label'     => __( 'Link Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#232628',
				'selectors' => array(
					'{{WRAPPER}} .stm-filter-links .stm-accordion-content .list-style-3 li a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'isf_pal_amount_color',
			array(
				'label'     => __( 'Amount Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#232628',
				'selectors' => array(
					'{{WRAPPER}} .stm-filter-links .stm-accordion-content .list-style-3 li a span' => 'color: {{VALUE}};',
				),
			)
		);

		$this->stm_end_ctrl_tab();

		$this->stm_start_ctrl_tab(
			'isf_pal_hover',
			array(
				'label' => __( 'Hover', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'isf_pal_icon_color_hover',
			array(
				'label'     => __( 'Icon Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#cc6119',
				'selectors' => array(
					'{{WRAPPER}} .stm-filter-links .stm-accordion-content .list-style-3 li:hover:before' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'isf_pal_link_color_hover',
			array(
				'label'     => __( 'Link Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#232628',
				'selectors' => array(
					'{{WRAPPER}} .stm-filter-links .stm-accordion-content .list-style-3 li a:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'isf_pal_amount_color_hover',
			array(
				'label'     => __( 'Amount Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#232628',
				'selectors' => array(
					'{{WRAPPER}} .stm-filter-links .stm-accordion-content .list-style-3 li a:hover span' => 'color: {{VALUE}};',
				),
			)
		);

		$this->stm_end_ctrl_tab();

		$this->stm_end_ctrl_tabs();

		$this->add_control(
			'isf_secondary_field_heading',
			array(
				'label'     => __( 'Field', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->stm_start_ctrl_tabs(
			'isf_secondary_field_style',
		);

		$this->stm_start_ctrl_tab(
			'isf_secondary_field_normal',
			array(
				'label' => __( 'Normal', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'      => 'isf_secondary_field_color',
				'label'     => esc_html__( 'Background color', 'motors-elementor-settings' ),
				'default'   => '#eceff3',
				'selectors' => array(
					'{{WRAPPER}} .stm-accordion-single-unit select' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .stm-accordion-single-unit input'  => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'isf_secondary_field_text_color',
			array(
				'label'     => __( 'Text Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .stm-accordion-single-unit select'             => 'color: {{VALUE}};',
					'{{WRAPPER}} .stm-accordion-single-unit input[type=text]'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .stm-accordion-single-unit input[type=number]' => 'color: {{VALUE}};',
					'{{WRAPPER}} .stm-accordion-single-unit input[type=search]' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'isf_secondary_field_border',
				'label'    => esc_html__( 'Button Border', 'motors-car-dealership-classified-listings-pro' ),
				'selector' => '{{WRAPPER}} .stm-accordion-single-unit select, {{WRAPPER}} .stm-accordion-single-unit input[type=text]',
				'default'  => array(
					'border' => '1px solid #000',
				),
			)
		);

		$this->add_control(
			'isf_secondary_field_border_radius',
			array(
				'label'       => esc_html__( 'Border Radius', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units'  => array( 'px', 'em', '%' ),
				'default'     => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => true,
				),
				'selectors'   => array(
					'{{WRAPPER}} .stm-accordion-single-unit select'             => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .stm-accordion-single-unit input[type=text]'   => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .stm-accordion-single-unit input[type=number]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .stm-accordion-single-unit input[type=search]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'label_block' => true,
			)
		);

		$this->stm_end_ctrl_tab();

		$this->stm_start_ctrl_tab(
			'isf_secondary_field_active',
			array(
				'label' => __( 'Active', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'isf_secondary_field_color_active',
			array(
				'label'     => esc_html__( 'Background color', 'motors-elementor-settings' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#eceff3',
				'selectors' => array(
					'{{WRAPPER}} .stm-accordion-single-unit select:focus' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .stm-accordion-single-unit input:focus'  => 'background-color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_control(
			'isf_secondary_field_text_color_active',
			array(
				'label'     => __( 'Text Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .stm-accordion-single-unit select:focus'             => 'color: {{VALUE}};',
					'{{WRAPPER}} .stm-accordion-single-unit input[type=text]:focus'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .stm-accordion-single-unit input[type=number]:focus' => 'color: {{VALUE}};',
					'{{WRAPPER}} .stm-accordion-single-unit input[type=search]:focus' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'isf_secondary_field_border_active',
				'label'    => esc_html__( 'Button Border', 'motors-car-dealership-classified-listings-pro' ),
				'selector' => '{{WRAPPER}} .stm-accordion-single-unit select:focus, {{WRAPPER}} .stm-accordion-single-unit input[type=text]:focus',
			)
		);

		$this->add_control(
			'secondary_field_border_radius_active',
			array(
				'label'       => esc_html__( 'Border Radius', 'motors-car-dealership-classified-listings-pro' ),
				'label_block' => true,
				'type'        => \Elementor\Controls_Manager::DIMENSIONS,
				'default'     => array(
					'top'    => '',
					'right'  => '',
					'bottom' => '',
					'left'   => '',
					'unit'   => 'px',
				),
				'selectors'   => array(
					'{{WRAPPER}} .stm-accordion-single-unit select:focus'             => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .stm-accordion-single-unit input[type=text]:focus'   => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .stm-accordion-single-unit input[type=number]:focus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .stm-accordion-single-unit input[type=search]:focus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'   => 'after',
			)
		);

		$this->stm_end_ctrl_tab();

		$this->stm_end_ctrl_tabs();
		//here
		$this->second_apply_btn_settings();

		$this->stm_end_control_section();

		$this->stm_start_style_controls_section( 'isf_mobile_filter', __( 'Mobile Settings', 'motors-car-dealership-classified-listings-pro' ) );

		$this->add_control(
			'isf_mobile_search_tbn_divider',
			array(
				'type'      => \Elementor\Controls_Manager::DIVIDER,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'isf_mobile_btn',
			array(
				'label' => __( 'Search Button', 'motors-car-dealership-classified-listings-pro' ),
				'type'  => \Elementor\Controls_Manager::HEADING,
			)
		);

		$this->stm_start_ctrl_tabs( 'isf_mobile_btn_tabs' );

		$this->add_control(
			'isf_mobile_btn_bg',
			array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Background', 'motors-car-dealership-classified-listings-pro' ),
				'selectors' => array(
					'{{WRAPPER}} .mobile-filter .mobile-search-btn'                      => 'background-color: {{VALUE}};',
					'.sticky-mobile-filter.make-fixed .mobile-filter .mobile-search-btn' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'isf_mobile_btn_box_shadow',
				'label'    => __( 'Box Shadow', 'motors-car-dealership-classified-listings-pro' ),
				'selector' => '.mobile-filter .mobile-search-btn',
			)
		);

		$this->add_control(
			'isf_mobile_btn_text_color',
			array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Text Color', 'motors-car-dealership-classified-listings-pro' ),
				'selectors' => array(
					'{{WRAPPER}} .mobile-filter .mobile-search-btn .mobile-search-btn-text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .mobile-filter .mobile-search-btn i'                       => 'color: {{VALUE}};',
					'.sticky-mobile-filter.make-fixed .mobile-filter .mobile-search-btn'    => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'isf_mobile_btn_icon_position',
			array(
				'label'   => esc_html__( 'Icon Position', 'motors-car-dealership-classified-listings-pro' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'left'  => 'Left',
					'right' => 'Right',
				),
				'default' => 'left',
			)
		);

		$this->add_control(
			'isf_mobile_btn_icon_size',
			array(
				'label'      => __( 'Icon Size', 'motors-car-dealership-classified-listings-pro' ),
				'size_units' => array(
					'px',
				),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'range'      => array(
					'px' => array(
						'min'  => 8,
						'max'  => 30,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 17,
				),
				'selectors'  => array(
					'{{WRAPPER}} .mobile-filter .mobile-search-btn i'                        => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .mobile-filter .mobile-search-btn svg'                      => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
					'.sticky-mobile-filter.make-fixed .mobile-filter .mobile-search-btn i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'.sticky-mobile-filter.make-fixed .mobile-filter .mobile-search-btn svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'isf_mobile_btn_typography',
				'label'    => __( 'Text Style', 'stm_elementor_widgets' ),
				'selector' => '.mobile-search-btn .mobile-search-btn-text',
				'default'  => array(
					'font_size'      => array(
						'unit' => 'px',
						'size' => 14,
					),
					'font_weight'    => '700',
					'line_height'    => array(
						'unit' => 'px',
						'size' => 14,
					),
					'text_transform' => 'uppercase',
				),
				'fields'   => array(
					'typography' => array(
						'font_family'     => false,
						'font_style'      => false,
						'text_decoration' => false,
						'word_spacing'    => false,
					),
				),
			)
		);

		$this->add_control(
			'isf_mobile_btn_padding',
			array(
				'label'     => __( 'Box Padding', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::DIMENSIONS,
				'default'   => array(
					'top'    => '17',
					'right'  => '28',
					'bottom' => '15',
					'left'   => '28',
				),
				'selectors' => array(
					'{{WRAPPER}} .mobile-filter .mobile-search-btn'                      => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.sticky-mobile-filter.make-fixed .mobile-filter .mobile-search-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'isf_mobile_sticky_wrapper_divider',
			array(
				'type' => \Elementor\Controls_Manager::DIVIDER,
			)
		);

		$this->add_control(
			'isf_mobile_sticky_wrapper_heading',
			array(
				'label' => __( 'Sticky Search', 'motors-car-dealership-classified-listings-pro' ),
				'type'  => \Elementor\Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'isf_mobile_sticky_wrapper_bg',
			array(
				'label'     => __( 'Background', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'.sticky-mobile-filter.make-fixed' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'isf_mobile_sticky_wrapper_paddings',
			array(
				'label'     => __( 'Box Padding', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::DIMENSIONS,
				'default'   => array(
					'top'    => '10',
					'right'  => '10',
					'bottom' => '10',
					'left'   => '10',
				),
				'selectors' => array(
					'.sticky-mobile-filter.make-fixed' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'isf_mobile_sticky_wrapper_box_shadow',
				'label'    => __( 'Box Shadow', 'motors-car-dealership-classified-listings-pro' ),
				'selector' => '.sticky-mobile-filter.make-fixed',
			)
		);

		$this->stm_end_ctrl_tabs();

		$this->add_control(
			'isf_mobile_search_filter_header_divider',
			array(
				'type' => \Elementor\Controls_Manager::DIVIDER,
			)
		);

		$this->add_control(
			'isf_mobile_filter_heading',
			array(
				'label' => __( 'Search Filter Header', 'motors-car-dealership-classified-listings-pro' ),
				'type'  => \Elementor\Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'isf_mobile_filter_heading_text_color',
			array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Search Heading Color', 'motors-car-dealership-classified-listings-pro' ),
				'selectors' => array(
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .search-filter-form.mobile .sidebar-entry-header-mobile .h4' => 'color: {{VALUE}};',
				),
				'default'   => '#232628',
			)
		);

		$this->add_control(
			'isf_mobile_filter_close_btn',
			array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Close Button Color', 'motors-car-dealership-classified-listings-pro' ),
				'default'   => '#6c98e1',
				'selectors' => array(
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .search-filter-form.mobile .sidebar-entry-header-mobile .close-btn span.close-btn-item' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'isf_mobile_search_filter_header_bgr_divider',
			array(
				'type' => \Elementor\Controls_Manager::DIVIDER,
			)
		);

		$this->add_control(
			'isf_mobile_bgr',
			array(
				'label' => __( 'Filter Background', 'motors-car-dealership-classified-listings-pro' ),
				'type'  => \Elementor\Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'isf_mobile_filter_bg',
			array(
				'label'     => __( 'Background', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .search-filter-form.mobile .filter.filter-sidebar'                                                                               => 'background-color: {{VALUE}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row form.mobile'                                                                                                                     => 'background-color: {{VALUE}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row form.mobile > div:not(.filter-sidebar), {{WRAPPER}} .mobile .stm-filter-links .stm-accordion-single-unit .stm-accordion-content' => 'background-color: {{VALUE}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .search-filter-form.mobile .stm-filter-listing-directory-price .stm-accordion-single-unit.price'                                 => 'background-color: {{VALUE}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .search-filter-form.mobile .stm-filter-links .stm-accordion-single-unit'                                                         => 'background-color: {{VALUE}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .search-filter-form.mobile .stm-filter-links .stm-accordion-single-unit .stm-accordion-content'                                  => 'background-color: {{VALUE}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row form.search-filter-form.mobile'                                                                                                  => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'isf_mobile_field_divider',
			array(
				'type' => \Elementor\Controls_Manager::DIVIDER,
			)
		);

		$this->add_control(
			'isf_mobile_select_heading',
			array(
				'label'     => __( 'Fields settings', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'after',
			)
		);
		$this->stm_start_ctrl_tabs(
			'isf_mobile_fields_style',
		);

		$this->stm_start_ctrl_tab(
			'isf_mobile_field_normal',
			array(
				'label' => __( 'Normal', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'isf_mobile_general_select_color',
			array(
				'label'     => esc_html__( 'Background color', 'motors-elementor-settings' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .search-filter-form.mobile .filter-sidebar select'                                                                              => 'background-color: {{VALUE}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .search-filter-form.mobile .filter-sidebar input'                                                                               => 'background-color: {{VALUE}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .search-filter-form.mobile .filter-sidebar .select2-container--default .select2-selection--single .select2-selection__rendered' => 'background-color: {{VALUE}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .search-filter-form.mobile .filter-sidebar .select2-container--default .select2-selection--multiple'                            => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'isf_mobile_select_text_color',
			array(
				'label'     => __( 'Text Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .search-filter-form.mobile .filter-sidebar .select2-container--default .select2-selection--single .select2-selection__rendered' => 'color: {{VALUE}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .search-filter-form.mobile .filter-sidebar .select2-container--default .select2-selection--single .select2-selection__arrow b'  => 'color: {{VALUE}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .search-filter-form.mobile .filter-sidebar .select2-container--default .select2-selection--multiple'                            => 'color: {{VALUE}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .search-filter-form.mobile .filter-sidebar select'                                                                              => 'color: {{VALUE}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .search-filter-form.mobile .filter-sidebar input[type=text]'                                                                    => 'color: {{VALUE}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .search-filter-form.mobile .filter-sidebar input[type=number]'                                                                  => 'color: {{VALUE}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .search-filter-form.mobile .filter-sidebar input[type=search]'                                                                  => 'color: {{VALUE}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .search-filter-form.mobile .filter-sidebar h5.pull-left'                                                                        => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'isf_mobile_slider_text_color',
			array(
				'label'     => __( 'Field Title Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .search-filter-form.mobile .filter-sidebar .stm-slider-filter-type-unit h5.pull-left'       => 'color: {{VALUE}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .search-filter-form.mobile .filter-sidebar .stm-multiple-select.stm_additional_features h5' => 'color: {{VALUE}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .search-filter-form.mobile .filter-sidebar .stm-search_keywords h5'                         => 'color: {{VALUE}};',
				),
				'separator' => 'after',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'isf_mobile_field_border',
				'label'    => esc_html__( 'Button Border', 'motors-car-dealership-classified-listings-pro' ),
				'selector' => '.classic-filter-row.motors-elementor-widget.mobile-filter-row form.search-filter-form.mobile .filter-sidebar .select2-container--default .select2-selection--single .select2-selection__rendered, .classic-filter-row.motors-elementor-widget.mobile-filter-row form.search-filter-form.mobile .filter-sidebar .select2-container--default .select2-selection--multiple, .classic-filter-row.motors-elementor-widget.mobile-filter-row form.search-filter-form.mobile .filter-sidebar select, .classic-filter-row.motors-elementor-widget.mobile-filter-row form.search-filter-form.mobile .filter-sidebar input[type=text]',
				'default'  => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
			)
		);

		$this->add_control(
			'isf_mobile_field_border_radius',
			array(
				'label'       => esc_html__( 'Border Radius', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::DIMENSIONS,
				'label_block' => true,
				'default'     => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'selectors'   => array(
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row form.search-filter-form.mobile .filter.filter-sidebar .select2-container--default'                                                         => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row form.search-filter-form.mobile .filter.filter-sidebar .select2-container--default .select2-selection--single'                              => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row form.search-filter-form.mobile .filter.filter-sidebar .select2-container--default .select2-selection--single .select2-selection__rendered' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row form.search-filter-form.mobile .filter.filter-sidebar .select2-container--default .select2-selection--multiple'                            => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row form.search-filter-form.mobile .filter.filter-sidebar select'                                                                              => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row form.search-filter-form.mobile .filter.filter-sidebar input[type=text]'                                                                    => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row form.search-filter-form.mobile .filter.filter-sidebar input[type=number]'                                                                  => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row form.search-filter-form.mobile .filter.filter-sidebar input[type=search]'                                                                  => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->stm_end_ctrl_tab();

		$this->stm_start_ctrl_tab(
			'isf_mobile_field_active',
			array(
				'label' => __( 'Active', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'isf_mobile_general_select_color_active',
			array(
				'label'     => esc_html__( 'Background color', 'motors-elementor-settings' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#eceff3',
				'selectors' => array(
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row form.search-filter-form.mobile.mobile .filter-sidebar select:focus'                                                                                                 => 'background-color: {{VALUE}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row form.search-filter-form.mobile.mobile .filter-sidebar input:focus'                                                                                                  => 'background-color: {{VALUE}} !important;',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row form.search-filter-form.mobile.mobile .filter-sidebar .select2-container--default.select2-container--focus .select2-selection--single .select2-selection__rendered' => 'background-color: {{VALUE}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row form.search-filter-form.mobile.mobile .filter-sidebar .select2-container--default.select2-container--focus .select2-selection--multiple'                            => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'isf_mobile_select_text_color_active',
			array(
				'label'     => __( 'Text Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .filter-sidebar .select2-container--default.select2-container--focus .select2-selection--single .select2-selection__rendered' => 'color: {{VALUE}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .filter-sidebar .select2-container--default.select2-container--focus .select2-selection--multiple'                            => 'color: {{VALUE}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .filter-sidebar select:focus'                                                                                                 => 'color: {{VALUE}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .filter-sidebar input[type=text]:focus'                                                                                       => 'color: {{VALUE}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .filter-sidebar input[type=number]:focus'                                                                                     => 'color: {{VALUE}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .filter-sidebar input[type=search]:focus'                                                                                     => 'color: {{VALUE}};',
				),
			)
		);

		$this->stm_end_ctrl_tab();

		$this->stm_end_ctrl_tabs();

		$this->stm_end_ctrl_tabs();

		$this->add_control(
			'isf_mobile_reset_btn_divider',
			array(
				'type' => \Elementor\Controls_Manager::DIVIDER,
			)
		);

		$this->add_control(
			'isf_mobile_secondary_divider',
			array(
				'type' => \Elementor\Controls_Manager::DIVIDER,
			)
		);

		$this->add_control(
			'isf_mobile_secondary_heading',
			array(
				'label' => __( 'Secondary Block Settings', 'motors-car-dealership-classified-listings-pro' ),
				'type'  => \Elementor\Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'isf_mobile_secondary_filter_bg',
			array(
				'label'     => __( 'Background', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .search-filter-form.mobile .stm-accordion-content' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'isf_mobile_second_filter_border_color',
			array(
				'label'     => __( 'Top Border Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#232628',
				'selectors' => array(
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row form.mobile > div:not(.filter-sidebar) a.title'               => 'border-top-color: {{VALUE}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .stm-filter-links .stm-accordion-single-unit a.title' => 'border-top-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'isf_mobile_second_label_color',
			array(
				'label'     => __( 'Label Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row form.mobile > div:not(.filter-sidebar) a.title h5'               => 'color: {{VALUE}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .stm-filter-links .stm-accordion-single-unit a.title h5' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'isf_mobile_second_label_bg_color',
			array(
				'label'     => __( 'Label Background Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row form.mobile > div:not(.filter-sidebar) a.title'               => 'background-color: {{VALUE}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .stm-filter-links .stm-accordion-single-unit a.title' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'isf_mobile_collapse_divider',
			array(
				'type' => \Elementor\Controls_Manager::DIVIDER,
			)
		);

		$this->add_control(
			'isf_mobile_collapse_heading',
			array(
				'label' => __( 'Collapse Indicator', 'motors-car-dealership-classified-listings-pro' ),
				'type'  => \Elementor\Controls_Manager::HEADING,
			)
		);

		$this->stm_start_ctrl_tabs( 'isf_mobile_collapse_indicator' );

		$this->add_control(
			'isf_mobile_collapse_indicator_bg',
			array(
				'label'     => __( 'Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#cccccc',
				'selectors' => array(
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row form.mobile > div:not(.filter-sidebar) a.title span'                     => 'background-color: {{VALUE}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row form.mobile > div:not(.filter-sidebar) a.title span:after'               => 'background-color: {{VALUE}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .stm-filter-links .stm-accordion-single-unit a.title span'       => 'background-color: {{VALUE}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .stm-filter-links .stm-accordion-single-unit a.title span:after' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->stm_end_ctrl_tab();

		$this->stm_end_ctrl_tabs();

		$this->add_control(
			'isf_mobile_checkbox_divider',
			array(
				'type' => \Elementor\Controls_Manager::DIVIDER,
			)
		);
		//start

		$this->add_control(
			'isf_mobile_checkbox_label_heading',
			array(
				'label' => __( 'Checkbox Label', 'motors-car-dealership-classified-listings-pro' ),
				'type'  => \Elementor\Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'isf_mobile_checkbox_label_color',
			array(
				'label'       => __( 'Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'description' => 'Used only if checked option in listing category (Use on listing archive as checkboxes)',
				'default'     => '#232628',
				'selectors'   => array(
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row form.mobile > div:not(.filter-sidebar) .stm-accordion-content .stm-option-label span' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'isf_mobile_pal_divider',
			array(
				'type' => \Elementor\Controls_Manager::DIVIDER,
			)
		);

		$this->add_control(
			'isf_mobile_pal_heading',
			array(
				'label' => __( 'Params as Links', 'motors-car-dealership-classified-listings-pro' ),
				'type'  => \Elementor\Controls_Manager::HEADING,
			)
		);

		$this->stm_start_ctrl_tabs( 'isf_mobile_pal' );

		$this->add_control(
			'isf_mobile_pal_icon_color',
			array(
				'label'     => __( 'Icon Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#cc6119',
				'selectors' => array(
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .stm-filter-links .stm-accordion-content .list-style-3 li:before' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'isf_mobile_pal_link_color',
			array(
				'label'     => __( 'Link Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#232628',
				'selectors' => array(
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .stm-filter-links .stm-accordion-content .list-style-3 li a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'isf_mobile_pal_amount_color',
			array(
				'label'     => __( 'Amount Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#232628',
				'selectors' => array(
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .stm-filter-links .stm-accordion-content .list-style-3 li a span' => 'color: {{VALUE}};',
				),
			)
		);

		$this->stm_end_ctrl_tab();

		$this->stm_end_ctrl_tabs();

		$this->add_control(
			'isf_mobile_secondary_field_divider',
			array(
				'type' => \Elementor\Controls_Manager::DIVIDER,
			)
		);

		$this->add_control(
			'isf_mobile_secondary_field_heading',
			array(
				'label' => __( 'Fields Settings', 'motors-car-dealership-classified-listings-pro' ),
				'type'  => \Elementor\Controls_Manager::HEADING,
			)
		);

		$this->stm_start_ctrl_tabs(
			'isf_mobile_secondary_field_style',
		);

		$this->stm_start_ctrl_tab(
			'isf_mobile_secondary_field_normal',
			array(
				'label' => __( 'Normal', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'isf_mobile_secondary_field_color',
			array(
				'label'     => esc_html__( 'Background color', 'motors-elementor-settings' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#eceff3',
				'selectors' => array(
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .stm-accordion-single-unit select' => 'background-color: {{VALUE}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .stm-accordion-single-unit input'  => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'isf_mobile_secondary_field_text_color',
			array(
				'label'     => __( 'Text Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .stm-accordion-single-unit select'             => 'color: {{VALUE}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .stm-accordion-single-unit input[type=text]'   => 'color: {{VALUE}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .stm-accordion-single-unit input[type=number]' => 'color: {{VALUE}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .stm-accordion-single-unit input[type=search]' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'      => 'isf_mobile_secondary_field_border',
				'label'     => esc_html__( 'Button Border', 'motors-car-dealership-classified-listings-pro' ),
				'selector'  => '.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .stm-accordion-single-unit select, .classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .stm-accordion-single-unit input[type=text]',
				'separator' => 'before',
			)
		);

		$this->add_control(
			'isf_mobile_secondary_field_border_radius',
			array(
				'label'       => esc_html__( 'Border Radius', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::DIMENSIONS,
				'label_block' => true,
				'default'     => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'selectors'   => array(
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .stm-accordion-single-unit select'             => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .stm-accordion-single-unit input[type=text]'   => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .stm-accordion-single-unit input[type=number]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .stm-accordion-single-unit input[type=search]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->stm_end_ctrl_tab();

		$this->stm_start_ctrl_tab(
			'isf_mobile_secondary_field_active',
			array(
				'label' => __( 'Active', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'isf_mobile_secondary_field_color_active',
			array(
				'label'     => esc_html__( 'Background color', 'motors-elementor-settings' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#eceff3',
				'selectors' => array(
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .stm-accordion-single-unit select:focus' => 'background-color: {{VALUE}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .stm-accordion-single-unit input:focus'          => 'background-color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_control(
			'isf_mobile_secondary_field_text_color_active',
			array(
				'label'     => __( 'Text Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .stm-accordion-single-unit select:focus'             => 'color: {{VALUE}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .stm-accordion-single-unit input[type=text]:focus'   => 'color: {{VALUE}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .stm-accordion-single-unit input[type=number]:focus' => 'color: {{VALUE}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .stm-accordion-single-unit input[type=search]:focus' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'      => 'isf_mobile_secondary_field_border_active',
				'label'     => esc_html__( 'Button Border', 'motors-car-dealership-classified-listings-pro' ),
				'selector'  => '.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .stm-accordion-single-unit select:focus, .classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .stm-accordion-single-unit input[type=text]:focus',
				'default'   => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'isf_mobile_secondary_field_border_radius_active',
			array(
				'label'       => esc_html__( 'Border Radius', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::DIMENSIONS,
				'label_block' => true,
				'default'     => array(
					'top'      => '',
					'right'    => '',
					'bottom'   => '',
					'left'     => '',
					'isLinked' => true,
				),
				'selectors'   => array(
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .stm-accordion-single-unit select:focus'             => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .stm-accordion-single-unit input[type=text]:focus'   => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .stm-accordion-single-unit input[type=number]:focus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .stm-accordion-single-unit input[type=search]:focus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->stm_end_ctrl_tab();

		$this->stm_end_ctrl_tabs();

		$this->add_control(
			'isf_mobile_apply_tbn_divider',
			array(
				'type' => \Elementor\Controls_Manager::DIVIDER,
			)
		);

		$this->add_control(
			'isf_mobile_second_btn_heading',
			array(
				'label' => __( 'Apply Button', 'motors-car-dealership-classified-listings-pro' ),
				'type'  => \Elementor\Controls_Manager::HEADING,
			)
		);

		$this->stm_start_ctrl_tabs( 'isf_mobile_second_btn_tabs' );

		$this->add_control(
			'isf_mobile_second_btn_bg',
			array(
				'label'     => __( 'Background', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#6c98e1',
				'selectors' => array(
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row form.mobile > div:not(.filter-sidebar) .stm-accordion-content .stm-accordion-inner a.button' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'isf_mobile_second_btn_border',
				'label'    => esc_html__( 'Button Border', 'motors-car-dealership-classified-listings-pro' ),
				'selector' => '.classic-filter-row.motors-elementor-widget.mobile-filter-row form.mobile > div:not(.filter-sidebar) .stm-accordion-content .stm-accordion-inner a.button',
				'default'  => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
			)
		);

		$this->add_control(
			'isf_mobile_second_btn_border_radius',
			array(
				'label'       => esc_html__( 'Border Radius', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::DIMENSIONS,
				'label_block' => true,
				'selectors'   => array(
					'.classic-filter-row.motors-elementor-widget .search-filter-form .stm-accordion-single-unit.stm-listing-directory-checkboxes .stm-accordion-content .stm-accordion-content-wrapper .stm-accordion-inner .stm-checkbox-submit a.button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'isf_mobile_second_btn_box_shadow',
				'label'    => __( 'Box Shadow', 'motors-car-dealership-classified-listings-pro' ),
				'selector' => '.classic-filter-row.motors-elementor-widget.mobile-filter-row form.mobile > div:not(.filter-sidebar) .stm-accordion-content .stm-accordion-inner a.button',
			)
		);

		$this->add_control(
			'isf_mobile_second_btn_text_color',
			array(
				'label'     => __( 'Text Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row form.mobile > div:not(.filter-sidebar) .stm-accordion-content .stm-accordion-inner a.button' => 'color: {{VALUE}};',
				),
			)
		);

		$this->stm_end_ctrl_tab();

		$this->stm_end_ctrl_tabs();

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'isf_mobile_second_btn_typography',
				'label'     => __( 'Text Style', 'stm_elementor_widgets' ),
				'exclude'   => array(
					'font_family',
					'font_style',
					'text_decoration',
					'word_spacing',
				),
				'default'   => array(
					'typography' => array(
						'font_size'      => array(
							'unit' => 'px',
							'size' => 14,
						),
						'font_weight'    => '700',
						'line_height'    => array(
							'unit' => 'px',
							'size' => 14,
						),
						'text_transform' => 'uppercase',
					),
				),
				'selectors' => array(
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row form.mobile > div:not(.filter-sidebar) .stm-accordion-content .stm-accordion-inner a.button' => 'font-size: {{SIZE}}{{UNIT}}; font-weight: {{FONT_WEIGHT}}; line-height: {{LINE_HEIGHT}}{{UNIT}}; text-transform: {{TEXT_TRANSFORM}};',
				),
			)
		);

		$this->add_control(
			'isf_mobile_second_button_padding',
			array(
				'label'     => __( 'Box Padding', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::DIMENSIONS,
				'default'   => array(
					'top'    => '17',
					'right'  => '28',
					'bottom' => '15',
					'left'   => '28',
				),
				'selectors' => array(
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row form.mobile > div:not(.filter-sidebar) .stm-accordion-content .stm-accordion-inner a.button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'isf_mobile_sticky_panel',
			array(
				'type' => \Elementor\Controls_Manager::DIVIDER,
			)
		);

		$this->add_control(
			'isf_mobile_sticky_panel_heading',
			array(
				'label' => __( 'Result buttons', 'motors-car-dealership-classified-listings-pro' ),
				'type'  => \Elementor\Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'isf_mobile_sticky_panel_btn_bg',
			array(
				'label'     => __( 'Background', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'.classic-filter-row.motors-elementor-widget .search-filter-form.mobile .sticky-filter-actions' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'isf_mobile_show_cars_btn',
			array(
				'type' => \Elementor\Controls_Manager::DIVIDER,
			)
		);

		$this->add_control(
			'isf_mobile_show_cars_btn_heading',
			array(
				'label' => __( 'Show Results Button', 'motors-car-dealership-classified-listings-pro' ),
				'type'  => \Elementor\Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'isf_mobile_show_cars_btn_bg',
			array(
				'label'     => __( 'Background', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#fffff',
				'selectors' => array(
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .sticky-filter-actions .filter-show-cars .show-car-btn' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'isf_mobile_show_cars_btn_border',
				'label'    => esc_html__( 'Button Border', 'motors-car-dealership-classified-listings-pro' ),
				'selector' => '.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .sticky-filter-actions .filter-show-cars .show-car-btn',
				'default'  => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
			)
		);

		$this->add_control(
			'isf_mobile_show_cars_border_radius',
			array(
				'label'       => esc_html__( 'Border Radius', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::DIMENSIONS,
				'label_block' => true,
				'selectors'   => array(
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .sticky-filter-actions .filter-show-cars .show-car-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'isf_show_cars_btn_box_shadow',
				'label'    => __( 'Box Shadow', 'motors-car-dealership-classified-listings-pro' ),
				'selector' => '.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .sticky-filter-actions .filter-show-cars .show-car-btn',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'isf_show_cars_typography',
				'label'          => __( 'Text Style', 'stm_elementor_widgets' ),
				'exclude'        => array(
					'font_family',
					'font_style',
					'text_decoration',
					'word_spacing',
				),
				'fields_options' => array(
					'font_size'      => array(
						'default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'font_weight'    => array(
						'default' => '700',
					),
					'line_height'    => array(
						'default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'text_transform' => array(
						'default' => 'uppercase',
					),
				),
				'selector'       => '.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .sticky-filter-actions .filter-show-cars .show-car-btn',
			)
		);

		$this->add_control(
			'isf_show_cars_text_color',
			array(
				'label'     => __( 'Text Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .sticky-filter-actions .filter-show-cars .show-car-btn' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'isf_show_cars_button_padding',
			array(
				'label'     => __( 'Box Padding', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::DIMENSIONS,
				'default'   => array(
					'top'    => '13',
					'right'  => '28',
					'bottom' => '13',
					'left'   => '28',
					'unit'   => 'px',
				),
				'selectors' => array(
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .sticky-filter-actions .filter-show-cars .show-car-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'isf_mobile_reset_btn',
			array(
				'type' => \Elementor\Controls_Manager::DIVIDER,
			)
		);

		$this->add_control(
			'isf_mobile_reset_btn_heading',
			array(
				'label'     => __( 'Reset Button', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'after',
			)
		);

		$this->stm_start_ctrl_tabs( 'isf_mobile_reset_btn_tabs' );

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'isf_mobile_reset_btn_border',
				'label'    => esc_html__( 'Button Border', 'motors-car-dealership-classified-listings-pro' ),
				'selector' => '.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .sticky-filter-actions .reset-btn-mobile a.button',
				'default'  => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
			)
		);

		$this->add_control(
			'isf_mobile_reset_border_radius',
			array(
				'label'       => esc_html__( 'Border Radius', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::DIMENSIONS,
				'label_block' => true,
				'default'     => array(
					'top'      => '3',
					'right'    => '3',
					'bottom'   => '3',
					'left'     => '3',
					'isLinked' => true,
				),
				'selectors'   => array(
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .sticky-filter-actions .reset-btn-mobile a.button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'   => 'after',
			)
		);

		$this->add_control(
			'isf_mobile_reset_btn_bg',
			array(
				'label'     => __( 'Background', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#fffff',
				'selectors' => array(
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .sticky-filter-actions .reset-btn-mobile a.button' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'isf_mobile_reset_btn_box_shadow',
				'label'    => __( 'Box Shadow', 'motors-car-dealership-classified-listings-pro' ),
				'selector' => '.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .sticky-filter-actions .reset-btn-mobile a.button',
			)
		);

		$this->add_control(
			'isf_mobile_reset_btn_text_color',
			array(
				'label'     => __( 'Icon Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .mobile .sticky-filter-actions .reset-btn-mobile a.button' => 'color: {{VALUE}};',
				),
			)
		);

		$this->stm_end_ctrl_tab();

		$this->stm_end_ctrl_tabs();

		$this->add_control(
			'isf_mobile_reset_icon_size',
			array(
				'label'      => __( 'Icon Size', 'motors-car-dealership-classified-listings-pro' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
				),
				'range'      => array(
					'px' => array(
						'min'  => 8,
						'max'  => 30,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 17,
				),
				'selectors'  => array(
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .sticky-filter-actions .reset-btn-mobile .button i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'.classic-filter-row.motors-elementor-widget.mobile-filter-row .sticky-filter-actions .reset-btn-mobile .button svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->stm_end_ctrl_tab();

		$this->stm_end_ctrl_tabs();

		$this->stm_end_control_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$settings['filter_bg'] = apply_filters( 'motors_vl_get_nuxy_mod', STM_LISTINGS_URL . '/assets/elementor/img/listing-directory-filter-bg.jpg', 'sidebar_filter_bg' );
		if ( is_int( $settings['filter_bg'] ) ) {
			$settings['filter_bg'] = wp_get_attachment_image_url( $settings['filter_bg'], 'full' );
		}

		$settings['show_sold'] = apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_sold_listings' );

		$api_posts            = new \MotorsVehiclesListing\Api\ApiPosts();
		$settings['api_data'] = $api_posts->get_rest_data();

		$settings['filter'] = apply_filters( 'stm_listings_filter_func', null );

		$post_type = ! empty( $settings['post_type'] ) ? $settings['post_type'] : 'listings';

		if ( stm_is_multilisting() && 'listings' !== $post_type ) {
			set_query_var( 'listings_type', $post_type );
			\HooksMultiListing::stm_listings_attributes_filter( array( 'slug' => $post_type ) );
			$settings['filter'] = apply_filters( 'stm_listings_filter_func', array( 'post_type' => $post_type ) );
		}

		Helper::stm_ew_load_template( 'elementor/Widgets/inventory-search-filter', STM_LISTINGS_PATH, $settings );
	}

	protected function content_template() {

	}

	private function second_apply_btn_settings() {
		$this->add_control(
			'isf_second_btn_heading',
			array(
				'label'     => __( 'Apply Button', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->stm_start_ctrl_tabs( 'isf_second_btn_tabs' );

		$this->stm_start_ctrl_tab(
			'isf_second_btn_normal',
			array(
				'label' => __( 'Normal', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'isf_second_btn_bg',
			array(
				'label'     => __( 'Background', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#6c98e1',
				'selectors' => array(
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget form > div:not(.filter-sidebar) .stm-accordion-content .stm-accordion-inner a.button' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'isf_second_btn_border',
				'label'    => esc_html__( 'Button Border', 'motors-car-dealership-classified-listings-pro' ),
				'selector' => '{{WRAPPER}} .classic-filter-row.motors-elementor-widget form > div:not(.filter-sidebar) .stm-accordion-content .stm-accordion-inner a.button',
				'default'  => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
			)
		);

		$this->add_control(
			'isf_second_btn_border_radius',
			array(
				'label'       => esc_html__( 'Border Radius', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::DIMENSIONS,
				'label_block' => true,
				'selectors'   => array(
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget form > div:not(.filter-sidebar) .stm-accordion-content .stm-accordion-inner a.button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'second_btn_box_shadow',
				'label'    => __( 'Box Shadow', 'motors-car-dealership-classified-listings-pro' ),
				'selector' => '{{WRAPPER}} .classic-filter-row.motors-elementor-widget form > div:not(.filter-sidebar) .stm-accordion-content .stm-accordion-inner a.button',
			)
		);

		$this->add_control(
			'isf_second_btn_text_color',
			array(
				'label'     => __( 'Text Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget form > div:not(.filter-sidebar) .stm-accordion-content .stm-accordion-inner a.button' => 'color: {{VALUE}};',
				),
			)
		);

		$this->stm_end_ctrl_tab();

		$this->stm_start_ctrl_tab(
			'isf_second_btn_hover',
			array(
				'label' => __( 'Hover', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'isf_second_btn_bg_hover',
			array(
				'label'     => __( 'Background', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#6c98e1',
				'selectors' => array(
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget form > div:not(.filter-sidebar) .stm-accordion-content .stm-accordion-inner a.button:hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'isf_second_btn_border_hover',
				'label'    => esc_html__( 'Button Border', 'motors-car-dealership-classified-listings-pro' ),
				'selector' => '{{WRAPPER}} .classic-filter-row.motors-elementor-widget form > div:not(.filter-sidebar) .stm-accordion-content .stm-accordion-inner a.button:hover',
				'default'  => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
			)
		);

		$this->add_control(
			'isf_second_btn_border_radius_hover',
			array(
				'label'       => esc_html__( 'Border Radius', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::DIMENSIONS,
				'label_block' => true,
				'selectors'   => array(
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget form > div:not(.filter-sidebar) .stm-accordion-content .stm-accordion-inner a.button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'second_btn_box_shadow_hover',
				'label'    => __( 'Box Shadow Hover', 'motors-car-dealership-classified-listings-pro' ),
				'selector' => '{{WRAPPER}} .classic-filter-row.motors-elementor-widget form > div:not(.filter-sidebar) .stm-accordion-content .stm-accordion-inner a.button:hover',
			)
		);

		$this->add_control(
			'isf_second_btn_text_color_hover',
			array(
				'label'     => __( 'Text Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget form > div:not(.filter-sidebar) .stm-accordion-content .stm-accordion-inner a.button:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->stm_end_ctrl_tab();

		$this->stm_end_ctrl_tabs();

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'isf_second_btn_typography',
				'label'          => __( 'Text Style', 'stm_elementor_widgets' ),
				'exclude'        => array(
					'font_family',
					'font_style',
					'text_decoration',
					'word_spacing',
				),
				'fields_options' => array(
					'font_size'      => array(
						'default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'font_weight'    => array(
						'default' => '700',
					),
					'line_height'    => array(
						'default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'text_transform' => array(
						'default' => 'uppercase',
					),
				),
				'selector'       => '{{WRAPPER}} .classic-filter-row.motors-elementor-widget form > div:not(.filter-sidebar) .stm-accordion-content .stm-accordion-inner a.button',
			)
		);

		$this->add_control(
			'second_button_padding',
			array(
				'label'     => __( 'Box Padding', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::DIMENSIONS,
				'default'   => array(
					'top'    => '17',
					'right'  => '28',
					'bottom' => '15',
					'left'   => '28',
					'unit'   => 'px',
				),
				'selectors' => array(
					'{{WRAPPER}} .classic-filter-row.motors-elementor-widget form > div:not(.filter-sidebar) .stm-accordion-content .stm-accordion-inner a.button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
	}

	private function motors_selected_filters( $listing_type = null ) {

		$filter_fields  = 'Fields for filter:';
		$filter_fields .= '<br /><br />';
		$filter_fields .= '<ul style="font-weight: 400;">';

		if ( is_null( $listing_type ) || 'listings' === $listing_type ) {

			$filters = apply_filters(
				'mvl_listings_attributes',
				array(
					'where'  => array( 'use_on_car_filter' => true ),
					'key_by' => 'slug',
				)
			);

			foreach ( $filters as $filter ) {
				$filter_fields .= '<li>&nbsp;- ' . $filter['single_name'] . '</li>';
			}
			$filter_fields .= '</ul>';

			$filter_fields .= '<br /><a href="' . admin_url( 'edit.php?post_type=listings&page=listing_categories' ) . '" target="_blank">' . esc_html__( 'Edit Listing Categories', 'motors-car-dealership-classified-listings-pro' ) . '</a>';

		} else {

			$filters = Helper::stm_ew_multi_listing_search_filter_fields( $listing_type );

			foreach ( $filters as $key => $filter ) {
				$filter_fields .= '<li>&nbsp;- ' . $filter . '</li>';
			}
			$filter_fields .= '</ul>';

			$filter_fields .= '<br /><a href="' . admin_url( 'edit.php?post_type=' . $listing_type . '&page=' . $listing_type . '_categories' ) . '" target="_blank">' . esc_html__( 'Edit Listing Categories', 'motors-car-dealership-classified-listings-pro' ) . '</a>';
		}

		return $filter_fields;
	}
}
