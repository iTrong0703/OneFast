<?php

namespace Motors_Elementor_Widgets_Free\Widgets\SingleListing\Classified;

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
		return MotorsElementorWidgetsFree::STM_PREFIX . '-single-listing-classified-title';
	}

	public function get_title() {
		return esc_html__( 'Title Classified', 'motors-car-dealership-classified-listings-pro' );
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

		$this->add_control(
			'added_date',
			array(
				'label'   => __( 'Added Date', 'motors-car-dealership-classified-listings-pro' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'date_added_icon',
			array(
				'label'            => __( 'Icon', 'motors-car-dealership-classified-listings-pro' ),
				'type'             => \Elementor\Controls_Manager::ICONS,
				'skin'             => 'inline',
				'fa4compatibility' => 'icon',
				'default'          => array(
					'value' => 'far fa-clock',
				),
				'condition'        => array( 'added_date' => 'yes' ),
			)
		);

		$this->stm_end_control_section();

		$this->stm_start_style_controls_section( 'title_style', __( 'Style', 'motors-car-dealership-classified-listings-pro' ) );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'title_typography',
				'label'          => __( 'Title Typography', 'motors-car-dealership-classified-listings-pro' ),
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
				'selector'       => '{{WRAPPER}} .title',
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => __( 'Title Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#232628',
				'selectors' => array(
					'{{WRAPPER}} .title' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'label_typography',
				'label'          => __( 'Label Typography', 'motors-car-dealership-classified-listings-pro' ),
				'exclude'        => array(
					'font_family',
					'font_style',
					'font_weight',
					'text_transform',
					'text_decoration',
					'letter_spacing',
					'word_spacing',
				),
				'fields_options' => array(
					'font_size'   => array(
						'default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'line_height' => array(
						'default' => array(
							'unit' => 'px',
							'size' => 15,
						),
					),
				),
				'selector'       => '{{WRAPPER}} .title .labels',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'date_added_typography',
				'label'          => __( 'Added Date Typography', 'motors-car-dealership-classified-listings-pro' ),
				'exclude'        => array(
					'font_family',
					'font_style',
					'font_weight',
					'text_transform',
					'text_decoration',
					'letter_spacing',
					'word_spacing',
				),
				'fields_options' => array(
					'font_size'   => array(
						'default' => array(
							'unit' => 'px',
							'size' => 11,
						),
					),
					'line_height' => array(
						'default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
				),
				'selector'       => '{{WRAPPER}} .normal_font',
				'condition'      => array( 'added_date' => 'yes' ),
			)
		);

		$this->add_control(
			'added_date_icon_size',
			array(
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'label'      => __( 'Added Date Icon Size', 'motors-car-dealership-classified-listings-pro' ),
				'size_units' => array(
					'px',
				),
				'range'      => array(
					'px' => array(
						'min'  => 8,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 13,
				),
				'selectors'  => array(
					'{{WRAPPER}} .stm-single-title-wrap .normal_font i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .stm-single-title-wrap .normal_font svg' => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array( 'added_date' => 'yes' ),
			)
		);

		$this->add_control(
			'added_date_icon_color',
			array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Added Date Icon Color', 'stm-elementor-widgets' ),
				'selectors' => array(
					'{{WRAPPER}} .stm-single-title-wrap .normal_font i'   => 'color: {{VALUE}}',
					'{{WRAPPER}} .stm-single-title-wrap .normal_font svg' => 'fill: {{VALUE}}',
				),
				'condition' => array( 'added_date' => 'yes' ),
			)
		);

		$this->add_control(
			'added_date_color',
			array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Added Date Text Color', 'stm-elementor-widgets' ),
				'selectors' => array(
					'{{WRAPPER}} .stm-single-title-wrap .normal_font' => 'color: {{VALUE}}',
				),
				'condition' => array( 'added_date' => 'yes' ),
			)
		);

		$this->stm_end_control_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		Helper::stm_ew_load_template( 'elementor/Widgets/single-listing/classified/title', STM_LISTINGS_PATH, $settings );
	}

	protected function content_template() {
	}
}
