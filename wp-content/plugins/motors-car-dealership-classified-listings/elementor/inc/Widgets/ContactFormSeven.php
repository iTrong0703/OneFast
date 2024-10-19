<?php

namespace Motors_Elementor_Widgets_Free\Widgets;

use Motors_Elementor_Widgets_Free\MotorsElementorWidgetsFree;
use Motors_Elementor_Widgets_Free\Helpers\Helper;
use Motors_Elementor_Widgets_Free\Widgets\WidgetBase;

class ContactFormSeven extends WidgetBase {

	public function __construct( array $data = array(), array $args = null ) {
		parent::__construct( $data, $args );

		$this->stm_ew_enqueue( self::get_name() );
		if ( is_rtl() ) {
			$this->stm_ew_enqueue( self::get_name() . '-rtl', STM_LISTINGS_PATH, STM_LISTINGS_URL, STM_LISTINGS_V );
		}
	}

	public function get_name() {
		return MotorsElementorWidgetsFree::STM_PREFIX . '-contact-form-seven';
	}

	public function get_title() {
		return esc_html__( 'Contact form 7', 'motors-elementor-widgets' );
	}

	public function get_icon() {
		return 'stmew-mountain';
	}

	public function get_script_depends() {
		return array( 'uniform', 'uniform-init', 'stmselect2', 'app-select2', $this->get_admin_name() );
	}

	public function get_style_depends() {
		$widget_styles   = parent::get_style_depends();
		$widget_styles[] = 'uniform';
		$widget_styles[] = 'uniform-init';
		$widget_styles[] = 'stmselect2';
		$widget_styles[] = 'app-select2';
		$widget_styles[] = self::get_name() . '-rtl';

		return $widget_styles;
	}

	protected function register_controls() {

		$this->stm_start_content_controls_section( 'section_content', __( 'General', 'motors-elementor-widgets' ) );

		$this->add_control(
			'title',
			array(
				'label' => esc_html__( 'Title', 'motors-elementor-widgets' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
			)
		);

		$this->add_control(
			'title_heading',
			array(
				'label'   => __( 'Title Heading', 'motors-elementor-widgets' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'h4',
				'options' => array(
					'h1' => __( 'Heading 1', 'motors-elementor-widgets' ),
					'h2' => __( 'Heading 2', 'motors-elementor-widgets' ),
					'h3' => __( 'Heading 3', 'motors-elementor-widgets' ),
					'h4' => __( 'Heading 4', 'motors-elementor-widgets' ),
					'h5' => __( 'Heading 5', 'motors-elementor-widgets' ),
					'h6' => __( 'Heading 6', 'motors-elementor-widgets' ),
				),
			)
		);

		$this->add_control(
			'icon',
			array(
				'label'       => esc_html__( 'Icon', 'motors-elementor-widgets' ),
				'type'        => \Elementor\Controls_Manager::ICONS,
				'label_block' => false,
				'skin'        => 'inline',
			)
		);

		$this->add_control(
			'form_id',
			array(
				'label'   => __( 'Contact Form', 'motors-elementor-widgets' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => Helper::stm_ew_get_cf7_select(),
			)
		);

		$this->add_control(
			'form_wide',
			array(
				'label'   => esc_html__( 'Wide', 'motors-elementor-widgets' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => '',
			)
		);

		$this->stm_end_control_section();

		/*Start style section*/
		$this->stm_start_style_controls_section( 'section_styles', __( 'Styles', 'motors-elementor-widgets' ) );

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'content_box_shadow',
				'label'    => __( 'Box Shadow', 'motors-elementor-widgets' ),
				'selector' => '{{WRAPPER}}',
			)
		);

		$this->add_control(
			'svg_width',
			array(
				'label'      => __( 'Icon Size', 'motors-elementor-widgets' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
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
					'size' => 27,
				),
				'selectors'  => array(
					'{{WRAPPER}} .stm-elementor-contact-form-seven .icon-title i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .stm-elementor-contact-form-seven .icon-title svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'label'    => __( 'Title Text Style', 'motors-elementor-widgets' ),
				'selector' => '{{WRAPPER}} .stm-elementor-contact-form-seven .icon-title .title',
			)
		);

		$this->stm_end_control_section();

		$this->stm_start_style_controls_section( 'section_colors', __( 'Colors', 'motors-elementor-widgets' ) );

		$this->add_control(
			'icon_color',
			array(
				'label'     => __( 'Icon Color', 'motors-elementor-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .stm-elementor-contact-form-seven .icon-title i'   => 'color: {{VALUE}}',
					'{{WRAPPER}} .stm-elementor-contact-form-seven .icon-title svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => __( 'Title Color', 'motors-elementor-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#232628',
				'selectors' => array(
					'{{WRAPPER}} .stm-elementor-contact-form-seven .icon-title .title' => 'color: {{VALUE}}',
				),
			)
		);

		$this->stm_end_control_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		Helper::stm_ew_load_template( 'elementor/Widgets/contact-form-seven', STM_LISTINGS_PATH, $settings );
	}

	protected function content_template() {
	}
}
