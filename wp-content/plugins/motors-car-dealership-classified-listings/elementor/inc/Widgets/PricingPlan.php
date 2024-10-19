<?php

namespace Motors_Elementor_Widgets_Free\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Motors_Elementor_Widgets_Free\MotorsElementorWidgetsFree;
use Motors_Elementor_Widgets_Free\Helpers\Helper;
use Motors_Elementor_Widgets_Free\Widgets\WidgetBase;

class PricingPlan extends WidgetBase {

	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );

		$this->stm_ew_enqueue( $this->get_name() );

	}

	public function get_categories(): array {
		return array( MotorsElementorWidgetsFree::WIDGET_CATEGORY_CLASSIFIED );
	}

	public function get_name(): string {
		return MotorsElementorWidgetsFree::STM_PREFIX . '-pricing-plan';
	}

	public function get_title(): string {
		return esc_html__( 'Pricing Plan', 'motors-car-dealership-classified-listings-pro' );
	}

	public function get_icon(): string {
		return 'stmew-pricing-plans';
	}

	protected function register_controls() {

		$this->stm_ew_general_controls();
		$this->stm_ew_style_general_controls();

	}

	protected function stm_ew_general_controls() {

		$this->stm_start_content_controls_section( 'section_general', esc_html__( 'General', 'motors-car-dealership-classified-listings-pro' ) );

		$this->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Plan Title', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter Title', 'motors-car-dealership-classified-listings-pro' ),
				'default'     => esc_html__( 'Business ', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'subtitle',
			array(
				'label'       => esc_html__( 'Subtitle', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter Subtitle', 'motors-car-dealership-classified-listings-pro' ),
				'default'     => esc_html__( 'for dealers', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'icon',
			array(
				'label'       => esc_html__( 'Icon', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::ICONS,
				'label_block' => false,
				'skin'        => 'inline',
			)
		);

		$this->add_control(
			'icon_position',
			array(
				'label'     => esc_html__( 'Icon Position', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::SELECT2,
				'default'   => 'above_title',
				'options'   => array(
					'left'        => esc_html__( 'Left', 'motors-car-dealership-classified-listings-pro' ),
					'above_title' => esc_html__( 'Above Title', 'motors-car-dealership-classified-listings-pro' ),
					'right'       => esc_html__( 'Right', 'motors-car-dealership-classified-listings-pro' ),
				),
				'condition' => array(
					'icon[value]!' => '',
				),
			)
		);

		$this->add_control(
			'title_separator',
			array(
				'label'   => esc_html__( 'Title Separator', 'motors-car-dealership-classified-listings-pro' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'title_separator_height',
			array(
				'label'      => esc_html__( 'Title Separator Height', 'motors-car-dealership-classified-listings-pro' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
				),
				'range'      => array(
					'px' => array(
						'min'  => 1,
						'max'  => 10,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 1,
				),
				'selectors'  => array(
					'{{WRAPPER}} .stm-pricing-plan__separator.stm-pricing-plan__separator__title .stm-pricing-plan__separator__element' => 'height: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'title_separator!' => '',
				),
			)
		);

		$this->add_control(
			'text_align',
			array(
				'label'   => esc_html__( 'Text Alignment', 'motors-car-dealership-classified-listings-pro' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'motors-car-dealership-classified-listings-pro' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'motors-car-dealership-classified-listings-pro' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'motors-car-dealership-classified-listings-pro' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default' => 'center',
				'toggle'  => true,
			)
		);

		$this->add_control(
			'badge_text',
			array(
				'label'       => esc_html__( 'Badge Text', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter Badge Text', 'motors-car-dealership-classified-listings-pro' ),
				'default'     => esc_html__( 'Popular', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'badge_position',
			array(
				'label'     => esc_html__( 'Badge Position', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::SELECT2,
				'default'   => 'top_left',
				'options'   => array(
					'top_left'     => esc_html__( 'Top Left', 'motors-car-dealership-classified-listings-pro' ),
					'top_right'    => esc_html__( 'Top Right', 'motors-car-dealership-classified-listings-pro' ),
					'left_middle'  => esc_html__( 'Left Middle', 'motors-car-dealership-classified-listings-pro' ),
					'right_middle' => esc_html__( 'Right Middle', 'motors-car-dealership-classified-listings-pro' ),
					'bottom_left'  => esc_html__( 'Bottom Left', 'motors-car-dealership-classified-listings-pro' ),
					'bottom_right' => esc_html__( 'Bottom Right', 'motors-car-dealership-classified-listings-pro' ),
				),
				'condition' => array(
					'badge_text!' => '',
				),
			)
		);

		$this->add_control(
			'price_separator',
			array(
				'label'     => esc_html__( 'Price Separator', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'default'   => '',
				'separator' => 'before',
			)
		);

		$this->add_control(
			'price_separator_height',
			array(
				'label'      => esc_html__( 'Price Separator Height', 'motors-car-dealership-classified-listings-pro' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
				),
				'range'      => array(
					'px' => array(
						'min'  => 1,
						'max'  => 10,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 1,
				),
				'selectors'  => array(
					'{{WRAPPER}} .stm-pricing-plan__separator.stm-pricing-plan__separator__price .stm-pricing-plan__separator__element' => 'height: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'price_separator!' => '',
				),
			)
		);

		$this->add_control(
			'currency',
			array(
				'label'       => esc_html__( 'Currency', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter Currency', 'motors-car-dealership-classified-listings-pro' ),
				'default'     => '$',
			)
		);

		$this->add_control(
			'currency_position',
			array(
				'label'     => esc_html__( 'Currency Position', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => array(
					'left'  => array(
						'title' => esc_html__( 'Left', 'motors-car-dealership-classified-listings-pro' ),
						'icon'  => 'eicon-text-align-left',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'motors-car-dealership-classified-listings-pro' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'left',
				'condition' => array(
					'currency!' => '',
				),
				'toggle'    => true,
			)
		);

		$this->add_control(
			'discount',
			array(
				'label'       => esc_html__( 'Price', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'placeholder' => esc_html__( 'Enter Price', 'motors-car-dealership-classified-listings-pro' ),
				'default'     => 9,
			)
		);

		$this->add_control(
			'price',
			array(
				'label'       => esc_html__( 'Discount Price', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'placeholder' => esc_html__( 'Enter Discount Price', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'period_text',
			array(
				'label'       => esc_html__( 'Period Text', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter Period Text', 'motors-car-dealership-classified-listings-pro' ),
				'default'     => esc_html__( '/ month', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'button_text',
			array(
				'label'       => esc_html__( 'Button Text', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter Button Text', 'motors-car-dealership-classified-listings-pro' ),
				'default'     => esc_html__( 'Get Started', 'motors-car-dealership-classified-listings-pro' ),
				'separator'   => 'before',
			)
		);

		$this->add_control(
			'pricing_plan',
			array(
				'label'   => esc_html__( 'Choose Plan', 'motors-car-dealership-classified-listings-pro' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => Helper::stm_get_pricing_plans(),
				'default' => 'custom_link',
			)
		);

		$this->add_control(
			'button_link',
			array(
				'label'       => esc_html__( 'Button Link', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'Enter Button Link', 'motors-car-dealership-classified-listings-pro' ),
				'condition'   => array(
					'pricing_plan' => 'custom_link',
				),
			)
		);

		$this->add_control(
			'button_position',
			array(
				'label'     => esc_html__( 'Button Position', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::SELECT2,
				'default'   => 'under_price',
				'options'   => array(
					'under_price' => esc_html__( 'Under Price', 'motors-car-dealership-classified-listings-pro' ),
					'bottom'      => esc_html__( 'Bottom', 'motors-car-dealership-classified-listings-pro' ),
				),
				'condition' => array(
					'button_text!' => '',
				),
			)
		);

		$this->add_control(
			'button_margin_top',
			array(
				'label'      => esc_html__( 'Button Margin Top', 'motors-car-dealership-classified-listings-pro' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
				),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 35,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 0,
				),
				'selectors'  => array(
					'{{WRAPPER}} .stm-pricing-plan__button' => 'margin-top: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'button_text!'    => '',
					'button_position' => 'under_price',
				),
			)
		);

		$this->add_control(
			'display_items',
			array(
				'label' => esc_html__( 'Display Items', 'motors-car-dealership-classified-listings-pro' ),
				'type'  => \Elementor\Controls_Manager::SWITCHER,
			)
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'item_title',
			array(
				'label'       => esc_html__( 'Title', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'Enter Title', 'motors-car-dealership-classified-listings-pro' ),
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'item_icon',
			array(
				'label'   => esc_html__( 'Icon', 'motors-car-dealership-classified-listings-pro' ),
				'type'    => \Elementor\Controls_Manager::ICONS,
				'skin'    => 'inline',
				'default' => array(
					'value'   => 'fas fa-check',
					'library' => 'fa-solid',
				),
			)
		);

		$repeater->add_control(
			'item_icon_size',
			array(
				'label'      => esc_html__( 'Icon Size', 'motors-car-dealership-classified-listings-pro' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
				),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 35,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} {{CURRENT_ITEM}} .stm-pricing-plan__items__item__icon'       => 'font-size: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} {{CURRENT_ITEM}} .stm-pricing-plan__items__item__icon > i'   => 'width: {{SIZE}}{{UNIT}};font-size: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} {{CURRENT_ITEM}} .stm-pricing-plan__items__item__icon > svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$repeater->add_control(
			'item_icon_color',
			array(
				'label'     => esc_html__( 'Icon Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} {{CURRENT_ITEM}} .stm-pricing-plan__items__item__icon'      => 'color: {{VALUE}};fill: {{VALUE}};stroke: {{VALUE}};',
					'{{WRAPPER}} {{CURRENT_ITEM}} .stm-pricing-plan__items__item__icon path' => 'color: {{VALUE}};fill: {{VALUE}};stroke: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'items',
			array(
				'label'         => esc_html__( 'Items', 'motors-car-dealership-classified-listings-pro' ),
				'fields'        => $repeater->get_controls(),
				'type'          => \Elementor\Controls_Manager::REPEATER,
				'title_field'   => '{{{ item_title }}}',
				'prevent_empty' => false,
				'default'       => array(
					array(
						'item_title' => esc_html__( '10 active listing quotas', 'motors-car-dealership-classified-listings-pro' ),
					),
					array(
						'item_title' => esc_html__( '7 days listing period', 'motors-car-dealership-classified-listings-pro' ),
					),
					array(
						'item_title'      => esc_html__( 'Premium Listing Credit', 'motors-car-dealership-classified-listings-pro' ),
						'item_icon'       => array(
							'value'   => 'fas fa-minus',
							'library' => 'fa-solid',
						),
						'item_icon_color' => '#000000',
					),
				),
				'condition'     => array(
					'display_items' => 'yes',
				),
			)
		);

		$this->add_control(
			'items_text_align',
			array(
				'label'     => esc_html__( 'Items Text Alignment', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'motors-car-dealership-classified-listings-pro' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'motors-car-dealership-classified-listings-pro' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'motors-car-dealership-classified-listings-pro' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'left',
				'selectors' => array(
					'{{WRAPPER}} .stm-pricing-plan__items .stm-pricing-plan__items__item .stm-pricing-plan__items__item__text' => 'text-align: {{VALUE}};',
				),
				'condition' => array(
					'display_items' => 'yes',
				),
				'toggle'    => true,
			)
		);

		$this->add_control(
			'items_margin_top',
			array(
				'label'      => esc_html__( 'Items Margin Top', 'motors-car-dealership-classified-listings-pro' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
				),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 35,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 0,
				),
				'selectors'  => array(
					'{{WRAPPER}} .stm-pricing-plan__items' => 'margin-top: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'display_items'   => 'yes',
					'button_position' => 'bottom',
				),
			)
		);

		$this->stm_end_control_section();

	}

	protected function stm_ew_style_general_controls() {

		$this->stm_start_style_controls_section( 'section_style_header', esc_html__( 'Header', 'motors-car-dealership-classified-listings-pro' ) );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'title_typography',
				'label'          => esc_html__( 'Title Typography', 'motors-car-dealership-classified-listings-pro' ),
				'exclude'        => array(
					'font_style',
					'text_decoration',
					'word_spacing',
				),
				'fields_options' => array(
					'font_size'      => array(
						'size_units' => array(
							'px',
							'em',
						),
						'default'    => array(
							'unit' => 'px',
							'size' => 24,
						),
					),
					'line_height'    => array(
						'size_units' => array(
							'px',
							'em',
						),
						'default'    => array(
							'unit' => 'em',
							'size' => 1,
						),
					),
					'font_weight'    => array(
						'default' => '700',
					),
					'letter_spacing' => array(
						'size_units' => array(
							'px',
							'em',
						),
						'default'    => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
				),
				'condition'      => array(
					'title!' => '',
				),
				'selector'       => '{{WRAPPER}} .stm-pricing-plan__header-text__title',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'subtitle_typography',
				'label'          => esc_html__( 'Subtitle Typography', 'motors-car-dealership-classified-listings-pro' ),
				'exclude'        => array(
					'font_style',
					'text_decoration',
					'word_spacing',
				),
				'fields_options' => array(
					'font_size'      => array(
						'size_units' => array(
							'px',
							'em',
						),
						'default'    => array(
							'unit' => 'px',
							'size' => 13,
						),
					),
					'line_height'    => array(
						'size_units' => array(
							'px',
							'em',
						),
						'default'    => array(
							'unit' => 'em',
							'size' => 1,
						),
					),
					'letter_spacing' => array(
						'size_units' => array(
							'px',
							'em',
						),
						'default'    => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
				),
				'condition'      => array(
					'subtitle!' => '',
				),
				'selector'       => '{{WRAPPER}} .stm-pricing-plan__header-text__subtitle',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'badge_typography',
				'label'          => esc_html__( 'Badge Typography', 'motors-car-dealership-classified-listings-pro' ),
				'exclude'        => array(
					'font_style',
					'text_decoration',
					'word_spacing',
				),
				'fields_options' => array(
					'font_size'      => array(
						'size_units' => array(
							'px',
							'em',
						),
						'default'    => array(
							'unit' => 'px',
							'size' => 11,
						),
					),
					'line_height'    => array(
						'size_units' => array(
							'px',
							'em',
						),
						'default'    => array(
							'unit' => 'px',
							'size' => 32,
						),
					),
					'letter_spacing' => array(
						'size_units' => array(
							'px',
							'em',
						),
						'default'    => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'font_weight'    => array(
						'default' => '600',
					),
				),
				'selector'       => '{{WRAPPER}} .stm-pricing-plan__header__badge > span',
				'condition'      => array(
					'badge_text!' => '',
				),
			)
		);

		$this->add_control(
			'header_typography_ends',
			array(
				'type'  => \Elementor\Controls_Manager::DIVIDER,
				'style' => 'solid',
			)
		);

		$this->add_control(
			'badge_color',
			array(
				'label'     => esc_html__( 'Badge Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#FFF',
				'selectors' => array(
					'{{WRAPPER}} .stm-pricing-plan__header__badge > span' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'badge_text!' => '',
				),
			)
		);

		$this->add_control(
			'badge_background_color',
			array(
				'label'     => esc_html__( 'Badge Background Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'selectors' => array(
					'{{WRAPPER}} .stm-pricing-plan__header__badge'        => 'background: {{VALUE}};',
					'{{WRAPPER}} .stm-pricing-plan__header__badge:before' => 'background: {{VALUE}};',
				),
				'condition' => array(
					'badge_text!' => '',
				),
			)
		);

		$this->add_control(
			'header_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .stm-pricing-plan__header'                                       => 'background: {{VALUE}};',
					'{{WRAPPER}} .stm-pricing-plan__separator.stm-pricing-plan__separator__title' => 'background: {{VALUE}};',
				),
			)
		);

		$this->stm_start_ctrl_tabs( 'title_style' );

		$this->stm_start_ctrl_tab(
			'title_normal',
			array(
				'label' => __( 'Normal', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Title Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .stm-pricing-plan .stm-pricing-plan__header-text__title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'subtitle_color',
			array(
				'label'     => esc_html__( 'Subtitle Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .stm-pricing-plan .stm-pricing-plan__header-text__subtitle' => 'color: {{VALUE}};',
				),
				'separator' => 'after',
			)
		);

		$this->stm_end_ctrl_tab();

		$this->stm_start_ctrl_tab(
			'title_hover',
			array(
				'label' => __( 'Hover', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'title_hover_color',
			array(
				'label'     => esc_html__( 'Title Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .stm-pricing-plan:hover .stm-pricing-plan__header-text__title' => 'color: {{VALUE}};',
				),
				'separator' => 'none',
			)
		);

		$this->add_control(
			'subtitle_hover_color',
			array(
				'label'     => esc_html__( 'Subtitle Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .stm-pricing-plan:hover .stm-pricing-plan__header-text__subtitle' => 'color: {{VALUE}};',
				),
				'separator' => 'after',
			)
		);

		$this->stm_end_ctrl_tab();

		$this->stm_end_ctrl_tabs();

		$this->add_control(
			'title_separator_color',
			array(
				'label'     => esc_html__( 'Title Separator Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#F1F4F8',
				'selectors' => array(
					'{{WRAPPER}} .stm-pricing-plan__separator.stm-pricing-plan__separator__title .stm-pricing-plan__separator__element' => 'background: {{VALUE}};',
				),
				'condition' => array(
					'title_separator!' => '',
				),
			)
		);

		$this->add_control(
			'title_separator_hover',
			array(
				'label'      => esc_html__( 'Separator Hover', 'motors-car-dealership-classified-listings-pro' ),
				'type'       => \Elementor\Controls_Manager::SWITCHER,
				'conditions' => array(
					'relation' => 'or',
					'terms'    => array(
						array(
							'name'     => 'title_separator',
							'operator' => '!==',
							'value'    => '',
						),
					),
				),
			)
		);

		$this->add_control(
			'title_separator_narrow_effect',
			array(
				'label'     => esc_html__( 'Separator Narrow Effect', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'condition' => array(
					'title_separator_hover' => 'yes',
					'title_separator!'      => '',
				),
			)
		);

		$this->add_control(
			'title_separator_color_hover',
			array(
				'label'     => esc_html__( 'Separator Title Color Hover', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .stm-pricing-plan:hover .stm-pricing-plan__separator.stm-pricing-plan__separator__title .stm-pricing-plan__separator__element' => 'background: {{VALUE}};',
				),
				'condition' => array(
					'title_separator'       => 'yes',
					'title_separator_hover' => 'yes',
				),
			)
		);

		$this->add_control(
			'icon_size',
			array(
				'label'      => esc_html__( 'Icon Size', 'motors-car-dealership-classified-listings-pro' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
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
					'size' => 48,
				),
				'selectors'  => array(
					'{{WRAPPER}} .stm-pricing-plan__header__wrapper__icon > i'   => 'font-size: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .stm-pricing-plan__header__wrapper__icon > svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'icon[value]!' => '',
				),
				'separator'  => 'before',
			)
		);

		$this->add_control(
			'icon_padding',
			array(
				'label'      => esc_html__( 'Icon Padding', 'motors-car-dealership-classified-listings-pro' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
				),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 35,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 0,
				),
				'selectors'  => array(
					'{{WRAPPER}} .stm-pricing-plan__header__wrapper__icon' => 'padding: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'icon[value]!' => '',
				),
			)
		);

		$this->add_control(
			'icon_color',
			array(
				'label'     => esc_html__( 'Icon Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'condition' => array(
					'icon[value]!' => '',
				),
				'selectors' => array(
					'{{WRAPPER}} .stm-pricing-plan__header__wrapper__icon'          => 'color: {{VALUE}};fill: {{VALUE}};',
					'{{WRAPPER}} .stm-pricing-plan__header__wrapper__icon svg path' => 'color: {{VALUE}};fill: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'icon_background',
			array(
				'label'     => esc_html__( 'Icon Background', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'condition' => array(
					'icon[value]!' => '',
				),
			)
		);

		$this->add_control(
			'icon_background_color',
			array(
				'label'     => esc_html__( 'Icon Background Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'condition' => array(
					'icon_background' => 'yes',
					'icon[value]!'    => '',
				),
				'selectors' => array(
					'{{WRAPPER}} .stm-pricing-plan__header__wrapper__icon' => 'background: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'icon_border_radius',
			array(
				'label'      => esc_html__( 'Icon Border Radius', 'motors-car-dealership-classified-listings-pro' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
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
					'size' => 100,
				),
				'selectors'  => array(
					'{{WRAPPER}} .stm-pricing-plan__header__wrapper__icon' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'icon_background!' => '',
					'icon[value]!'     => '',
				),
			)
		);

		$this->add_control(
			'icon_border',
			array(
				'label'     => esc_html__( 'Icon Border', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'condition' => array(
					'icon[value]!' => '',
				),
			)
		);

		$this->add_control(
			'icon_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'condition' => array(
					'icon_border' => 'yes',
				),
				'alpha'     => true,
				'selectors' => array(
					'{{WRAPPER}} .stm-pricing-plan__header .stm-pricing-plan__header__wrapper__icon' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'icon_border_width',
			array(
				'label'      => esc_html__( 'Icon Border Width', 'motors-car-dealership-classified-listings-pro' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
				),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 10,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 0,
				),
				'selectors'  => array(
					'{{WRAPPER}} .stm-pricing-plan__header__wrapper__icon' => 'border: {{SIZE}}{{UNIT}} solid',
				),
				'condition'  => array(
					'icon_border' => 'yes',
				),
			)
		);

		$this->add_control(
			'icon_align',
			array(
				'label'     => esc_html__( 'Icon Alignment', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => array(
					'flex-start' => array(
						'title' => esc_html__( 'Top', 'motors-car-dealership-classified-listings-pro' ),
						'icon'  => 'eicon-v-align-top',
					),
					'center'     => array(
						'title' => esc_html__( 'Middle', 'motors-car-dealership-classified-listings-pro' ),
						'icon'  => 'eicon-v-align-middle',
					),
					'flex-end'   => array(
						'title' => esc_html__( 'Bottom', 'motors-car-dealership-classified-listings-pro' ),
						'icon'  => 'eicon-v-align-bottom',
					),
				),
				'default'   => 'center',
				'selectors' => array(
					'{{WRAPPER}} .stm-pricing-plan__header__wrapper__icon' => 'align-self: {{VALUE}};',
				),
				'condition' => array(
					'icon[value]!'   => '',
					'icon_position!' => 'above_title',
				),
				'toggle'    => true,
			)
		);

		$this->end_controls_section();

		$this->stm_start_style_controls_section( 'section_style_price', esc_html__( 'Price', 'motors-car-dealership-classified-listings-pro' ) );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'price_typography',
				'label'          => esc_html__( 'Price Typography', 'motors-car-dealership-classified-listings-pro' ),
				'exclude'        => array(
					'font_style',
					'text_decoration',
					'word_spacing',
				),
				'fields_options' => array(
					'font_size'      => array(
						'size_units' => array(
							'px',
							'em',
						),
						'default'    => array(
							'unit' => 'px',
							'size' => 48,
						),
					),
					'line_height'    => array(
						'size_units' => array(
							'px',
							'em',
						),
						'default'    => array(
							'unit' => 'em',
							'size' => 1,
						),
					),
					'letter_spacing' => array(
						'size_units' => array(
							'px',
							'em',
						),
						'default'    => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'font_weight'    => array(
						'default' => '600',
					),
				),
				'selector'       => '{{WRAPPER}} .stm-pricing-plan__price',
				'condition'      => array(
					'price!' => '',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'currency_typography',
				'label'          => esc_html__( 'Currency Typography', 'motors-car-dealership-classified-listings-pro' ),
				'exclude'        => array(
					'font_style',
					'text_decoration',
					'word_spacing',
				),
				'fields_options' => array(
					'font_size'      => array(
						'size_units' => array(
							'px',
							'em',
						),
						'default'    => array(
							'unit' => 'px',
							'size' => 22,
						),
					),
					'line_height'    => array(
						'size_units' => array(
							'px',
							'em',
						),
						'default'    => array(
							'unit' => 'em',
							'size' => 1,
						),
					),
					'letter_spacing' => array(
						'size_units' => array(
							'px',
							'em',
						),
						'default'    => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
				),
				'selector'       => '{{WRAPPER}} .stm-pricing-plan__price > sup',
				'condition'      => array(
					'currency!' => '',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'discount_typography',
				'label'          => esc_html__( 'Discount Typography', 'motors-car-dealership-classified-listings-pro' ),
				'exclude'        => array(
					'font_style',
					'text_decoration',
					'word_spacing',
				),
				'fields_options' => array(
					'font_size'      => array(
						'size_units' => array(
							'px',
							'em',
						),
						'default'    => array(
							'unit' => 'px',
							'size' => 24,
						),
					),
					'line_height'    => array(
						'size_units' => array(
							'px',
							'em',
						),
						'default'    => array(
							'unit' => 'em',
							'size' => 1,
						),
					),
					'letter_spacing' => array(
						'size_units' => array(
							'px',
							'em',
						),
						'default'    => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'font_weight'    => array(
						'default' => '500',
					),
				),
				'selector'       => '{{WRAPPER}} .stm-pricing-plan__price__discount',
				'condition'      => array(
					'discount!' => '',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'period_typography',
				'label'          => esc_html__( 'Period Typography', 'motors-car-dealership-classified-listings-pro' ),
				'exclude'        => array(
					'font_style',
					'text_decoration',
					'word_spacing',
				),
				'fields_options' => array(
					'font_size'      => array(
						'size_units' => array(
							'px',
							'em',
						),
						'default'    => array(
							'unit' => 'px',
							'size' => 24,
						),
					),
					'line_height'    => array(
						'size_units' => array(
							'px',
							'em',
						),
						'default'    => array(
							'unit' => 'em',
							'size' => 1,
						),
					),
					'letter_spacing' => array(
						'size_units' => array(
							'px',
							'em',
						),
						'default'    => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'font_weight'    => array(
						'default' => '500',
					),
				),
				'selector'       => '{{WRAPPER}} .stm-pricing-plan__period_text',
				'condition'      => array(
					'period_text!' => '',
				),
			)
		);

		$this->add_control(
			'price_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .stm-pricing-plan__price-section'                                => 'background: {{VALUE}};',
					'{{WRAPPER}} .stm-pricing-plan__separator.stm-pricing-plan__separator__price' => 'background: {{VALUE}};',
				),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'price_separator_color',
			array(
				'label'     => esc_html__( 'Price Separator Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#F1F4F8',
				'selectors' => array(
					'{{WRAPPER}} .stm-pricing-plan__separator.stm-pricing-plan__separator__price .stm-pricing-plan__separator__element' => 'background: {{VALUE}};',
				),
				'condition' => array(
					'price_separator!' => '',
				),
			)
		);

		$this->add_control(
			'price_separator_hover',
			array(
				'label'      => esc_html__( 'Separator Hover', 'motors-car-dealership-classified-listings-pro' ),
				'type'       => \Elementor\Controls_Manager::SWITCHER,
				'conditions' => array(
					'relation' => 'or',
					'terms'    => array(
						array(
							'name'     => 'price_separator',
							'operator' => '!==',
							'value'    => '',
						),
					),
				),
			)
		);

		$this->add_control(
			'price_separator_narrow_effect',
			array(
				'label'     => esc_html__( 'Separator Narrow Effect', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'condition' => array(
					'price_separator_hover' => 'yes',
					'price_separator'       => 'yes',
				),
			)
		);

		$this->add_control(
			'price_separator_color_hover',
			array(
				'label'     => esc_html__( 'Separator Title Color Hover', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .stm-pricing-plan:hover .stm-pricing-plan__separator.stm-pricing-plan__separator__price .stm-pricing-plan__separator__element' => 'background: {{VALUE}};',
				),
				'condition' => array(
					'price_separator'       => 'yes',
					'price_separator_hover' => 'yes',
				),
				'separator' => 'after',
			)
		);

		$this->add_control(
			'price_typography_color',
			array(
				'label'     => esc_html__( 'Price Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'condition' => array(
					'price!' => '',
				),
				'selectors' => array(
					'{{WRAPPER}} .stm-pricing-plan__price' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'currency_typography_color',
			array(
				'label'     => esc_html__( 'Currency Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'condition' => array(
					'currency!' => '',
				),
				'selectors' => array(
					'{{WRAPPER}} .stm-pricing-plan__price > sup' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'discount_typography_color',
			array(
				'label'     => esc_html__( 'Discount Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'condition' => array(
					'discount!' => '',
				),
				'selectors' => array(
					'{{WRAPPER}} .stm-pricing-plan__price__discount' => 'color: {{VALUE}};-webkit-text-stroke-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'period_typography_color',
			array(
				'label'     => esc_html__( 'Period Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'condition' => array(
					'period_text!' => '',
				),
				'selectors' => array(
					'{{WRAPPER}} .stm-pricing-plan__period_text' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->stm_start_style_controls_section( 'section_style_content', esc_html__( 'Content', 'motors-car-dealership-classified-listings-pro' ) );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'items_typography',
				'label'          => esc_html__( 'Items Typography', 'motors-car-dealership-classified-listings-pro' ),
				'exclude'        => array(
					'font_style',
					'text_decoration',
					'word_spacing',
				),
				'fields_options' => array(
					'font_size'      => array(
						'size_units' => array(
							'px',
							'em',
						),
						'default'    => array(
							'unit' => 'px',
							'size' => 15,
						),
					),
					'line_height'    => array(
						'size_units' => array(
							'px',
							'em',
						),
						'default'    => array(
							'unit' => 'em',
							'size' => 1,
						),
					),
					'letter_spacing' => array(
						'size_units' => array(
							'px',
							'em',
						),
						'default'    => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'font_weight'    => array(
						'default' => '400',
					),
				),
				'selector'       => '{{WRAPPER}} .stm-pricing-plan__items__item .stm-pricing-plan__items__item__text',
				'condition'      => array(
					'display_items' => 'yes',
				),
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
				'fields_options' => array(
					'font_size'      => array(
						'size_units' => array(
							'px',
							'em',
						),
						'default'    => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'line_height'    => array(
						'size_units' => array(
							'px',
							'em',
						),
						'default'    => array(
							'unit' => 'em',
							'size' => 3.5,
						),
					),
					'letter_spacing' => array(
						'size_units' => array(
							'px',
							'em',
						),
						'default'    => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
					'font_weight'    => array(
						'default' => '700',
					),
				),
				'selector'       => '{{WRAPPER}} .stm-pricing-plan__button > a',
				'condition'      => array(
					'button_text!' => '',
				),
			)
		);

		$this->add_control(
			'plan_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#FFF',
				'selectors' => array(
					'{{WRAPPER}} .elementor-widget-container' => 'background: {{VALUE}};',
				),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'items_default_icon_size',
			array(
				'label'      => esc_html__( 'Items Default Icon Size', 'motors-car-dealership-classified-listings-pro' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
				),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 35,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 20,
				),
				'selectors'  => array(
					'{{WRAPPER}} .stm-pricing-plan__items__item__icon'       => 'font-size: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .stm-pricing-plan__items__item__icon > i'   => 'width: {{SIZE}}{{UNIT}};font-size: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .stm-pricing-plan__items__item__icon > svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'display_items' => 'yes',
				),
			)
		);

		$this->add_control(
			'items_default_icon_color',
			array(
				'label'     => esc_html__( 'Items Default Icon Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'condition' => array(
					'display_items' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} .stm-pricing-plan__items__item__icon'          => 'fill: {{VALUE}};color: {{VALUE}};',
					'{{WRAPPER}} .stm-pricing-plan__items__item__icon svg path' => 'fill: {{VALUE}};color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'items_text_color',
			array(
				'label'     => esc_html__( 'Items Text Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'condition' => array(
					'display_items' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} .stm-pricing-plan__items__item' => 'color: {{VALUE}};',
				),
			)
		);

		$this->stm_start_ctrl_tabs(
			'btns_style',
			array(
				'condition' => array(
					'button_text!' => '',
				),
			)
		);

		$this->stm_start_ctrl_tab(
			'btn_normal',
			array(
				'label' => __( 'Normal', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'button_typography_color',
			array(
				'label'     => esc_html__( 'Button Typography Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#FFF',
				'condition' => array(
					'button_text!' => '',
				),
				'selectors' => array(
					'{{WRAPPER}} .stm-pricing-plan__button > a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_background_color',
			array(
				'label'     => esc_html__( 'Button Background Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_SECONDARY,
				),
				'condition' => array(
					'button_text!' => '',
				),
				'selectors' => array(
					'{{WRAPPER}} .stm-pricing-plan__button > a' => 'background: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'      => 'button_border',
				'label'     => esc_html__( 'Button Border', 'motors-car-dealership-classified-listings-pro' ),
				'selector'  => '{{WRAPPER}} .stm-pricing-plan__button',
				'default'   => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'condition' => array(
					'button_text!' => '',
				),
			)
		);

		$this->add_control(
			'button_border_radius',
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
					'{{WRAPPER}} .stm-pricing-plan__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
			'button_typography_color_hover',
			array(
				'label'     => esc_html__( 'Button Typography Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#000',
				'condition' => array(
					'button_text!' => '',
				),
				'selectors' => array(
					'{{WRAPPER}} .stm-pricing-plan__button:hover > a' => 'color: {{VALUE}};',
				),
				'separator' => 'none',
			)
		);

		$this->add_control(
			'button_background_color_hover',
			array(
				'label'     => esc_html__( 'Button Background Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'condition' => array(
					'button_text!' => '',
				),
				'selectors' => array(
					'{{WRAPPER}} .stm-pricing-plan__button:hover > a' => 'background: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'      => 'button_border_hover',
				'label'     => esc_html__( 'Button Border', 'motors-car-dealership-classified-listings-pro' ),
				'selector'  => '{{WRAPPER}} .stm-pricing-plan__button:hover',
				'default'   => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'condition' => array(
					'button_text!' => '',
				),
			)
		);

		$this->add_control(
			'button_border_radius_hover',
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
					'{{WRAPPER}} .stm-pricing-plan__button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'   => 'after',
			)
		);

		$this->stm_end_ctrl_tab();

		$this->stm_end_ctrl_tabs();

		$this->stm_start_ctrl_tabs( 'bottom_line_style' );

		$this->stm_start_ctrl_tab(
			'bottom_line_normal',
			array(
				'label' => __( 'Normal', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'bottom_line_separator_height',
			array(
				'label'      => esc_html__( 'Bottom Line Height', 'motors-car-dealership-classified-listings-pro' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
				),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 10,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 0,
				),
				'selectors'  => array(
					'{{WRAPPER}} .stm-pricing-plan__separator.stm-pricing-plan__separator__bottom_line .stm-pricing-plan__separator__element' => 'height: {{SIZE}}{{UNIT}}',
				),
				'separator'  => 'none',
			)
		);

		$this->add_control(
			'bottom_line_separator_color',
			array(
				'label'     => esc_html__( 'Bottom Line Separator Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#F1F4F8',
				'selectors' => array(
					'{{WRAPPER}} .stm-pricing-plan__separator.stm-pricing-plan__separator__bottom_line .stm-pricing-plan__separator__element' => 'background: {{VALUE}};',
				),
			)
		);

		$this->stm_end_ctrl_tab();

		$this->stm_start_ctrl_tab(
			'bottom_line_hover',
			array(
				'label' => __( 'Hover', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'bottom_line_separator_height_hover',
			array(
				'label'      => esc_html__( 'Bottom Line Height', 'motors-car-dealership-classified-listings-pro' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
				),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 10,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 0,
				),
				'selectors'  => array(
					'{{WRAPPER}} .stm-pricing-plan:hover .stm-pricing-plan__separator.stm-pricing-plan__separator__bottom_line .stm-pricing-plan__separator__element' => 'height: {{SIZE}}{{UNIT}}',
				),
				'separator'  => 'none',
			)
		);

		$this->add_control(
			'bottom_line_separator_color_hover',
			array(
				'label'     => esc_html__( 'Bottom Line Separator Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#F1F4F8',
				'selectors' => array(
					'{{WRAPPER}} .stm-pricing-plan:hover .stm-pricing-plan__separator.stm-pricing-plan__separator__bottom_line .stm-pricing-plan__separator__element' => 'background: {{VALUE}};',
				),
			)
		);

		$this->stm_end_ctrl_tab();

		$this->stm_end_ctrl_tabs();

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		Helper::stm_ew_load_template( 'elementor/Widgets/pricing-plan', STM_LISTINGS_PATH, $settings );
	}
}
