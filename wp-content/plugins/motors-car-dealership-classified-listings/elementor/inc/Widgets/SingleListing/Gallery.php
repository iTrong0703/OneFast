<?php

namespace Motors_Elementor_Widgets_Free\Widgets\SingleListing;

use Motors_Elementor_Widgets_Free\MotorsElementorWidgetsFree;
use Motors_Elementor_Widgets_Free\Helpers\Helper;
use Motors_Elementor_Widgets_Free\Widgets\WidgetBase;

class Gallery extends WidgetBase {
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
				'swiper',
				'elementor-frontend',
			)
		);
		if ( is_rtl() ) {
			$this->stm_ew_enqueue( self::get_name() . '-rtl', STM_LISTINGS_PATH, STM_LISTINGS_URL, STM_LISTINGS_V );
		}
	}

	public function get_style_depends(): array {
		$widget_styles   = parent::get_style_depends();
		$widget_styles[] = self::get_name() . '-rtl';
		$widget_styles[] = 'swiper';

		return $widget_styles;
	}

	public function get_script_depends(): array {
		$depends   = parent::get_script_depends();
		$depends[] = 'swiper';

		return $depends;
	}

	public function get_categories() {
		return array( MotorsElementorWidgetsFree::WIDGET_CATEGORY_SINGLE );
	}

	public function get_name() {
		return MotorsElementorWidgetsFree::STM_PREFIX . '-single-listing-gallery';
	}

	public function get_title() {
		return esc_html__( 'Gallery', 'motors-car-dealership-classified-listings-pro' );
	}

	public function get_icon() {
		return 'stmew-photo-gallery';
	}

	protected function register_controls() {

		$this->stm_start_content_controls_section( 'Action buttons', esc_html__( 'General', 'motors-car-dealership-classified-listings-pro' ) );

		$this->add_control(
			'use_slider',
			array(
				'label'   => esc_html__( 'Display Thumbnails', 'stm-elementor-widgets' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			),
		);

		$this->add_control(
			'actions_heading',
			array(
				'label' => esc_html__( 'Actions', 'stm-elementor-widgets' ),
				'type'  => \Elementor\Controls_Manager::HEADING,
			),
		);

		$this->add_control(
			'show_print',
			array(
				'label'   => esc_html__( 'Print', 'motors-car-dealership-classified-listings-pro' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => '',
			)
		);

		$this->add_control(
			'show_compare',
			array(
				'label'   => esc_html__( 'Compare', 'motors-car-dealership-classified-listings-pro' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => '',
			)
		);

		$this->add_control(
			'show_share',
			array(
				'label'   => esc_html__( 'Share', 'motors-car-dealership-classified-listings-pro' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => '',
			)
		);

		if ( boolval( apply_filters( 'is_listing', array() ) ) ) {
			$this->add_control(
				'show_featured',
				array(
					'label'   => esc_html__( 'Favorite', 'motors-car-dealership-classified-listings-pro' ),
					'type'    => \Elementor\Controls_Manager::SWITCHER,
					'default' => '',
				)
			);
		}

		$this->add_control(
			'show_test_drive',
			array(
				'label'   => esc_html__( 'Test Drive', 'motors-car-dealership-classified-listings-pro' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => '',
			)
		);

		$this->add_control(
			'show_pdf',
			array(
				'label'   => esc_html__( 'PDF', 'motors-car-dealership-classified-listings-pro' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => '',
			)
		);

		$this->stm_end_control_section();

		$this->stm_start_style_controls_section( 'section_styles', esc_html__( 'General', 'motors-car-dealership-classified-listings-pro' ) );

		$this->add_control(
			'badge_position',
			array(
				'label'       => esc_html__( 'Badge position', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'description' => esc_html__( '"Special", "Sold" etc.', 'motors-car-dealership-classified-listings-pro' ),
				'options'     => array(
					'left-top'     => esc_html__( 'Left top', 'motors-car-dealership-classified-listings-pro' ),
					'right-top'    => esc_html__( 'Right top', 'motors-car-dealership-classified-listings-pro' ),
					'left-bottom'  => esc_html__( 'Left bottom', 'motors-car-dealership-classified-listings-pro' ),
					'right-bottom' => esc_html__( 'Right bottom', 'motors-car-dealership-classified-listings-pro' ),
				),
				'default'     => 'left-top',
			),
		);

		$this->add_control(
			'onhover_heading',
			array(
				'label' => esc_html__( 'Onhover Effects', 'stm-elementor-widgets' ),
				'type'  => \Elementor\Controls_Manager::HEADING,
			),
		);

		$this->add_control(
			'show_actions_onhover',
			array(
				'label'       => esc_html__( 'Hide action buttons by default', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'description' => esc_html__( 'Show on hover', 'motors-car-dealership-classified-listings-pro' ),
				'default'     => '',
			)
		);

		$this->add_control(
			'show_zoom_icon',
			array(
				'label'   => esc_html__( 'Show zoom icon', 'motors-car-dealership-classified-listings-pro' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => '',
			)
		);

		$this->add_control(
			'zoom_icon_size',
			array(
				'label'      => esc_html__( 'Icon Size', 'motors-car-dealership-classified-listings-pro' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
				),
				'range'      => array(
					'px' => array(
						'min'  => 5,
						'max'  => 85,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 26,
				),
				'selectors'  => array(
					'{{WRAPPER}} .motors-elementor-single-listing-gallery .motors-elementor-big-gallery .stm-single-image a .image-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'show_zoom_icon' => 'yes',
				),
			),
		);

		$this->add_control(
			'zoom_icon_box_style',
			array(
				'label'     => esc_html__( 'Icon box style', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => array(
					'none'    => esc_html__( 'None', 'motors-car-dealership-classified-listings-pro' ),
					'circle'  => esc_html__( 'Circle', 'motors-car-dealership-classified-listings-pro' ),
					'hexagon' => esc_html__( 'Hexagon', 'motors-car-dealership-classified-listings-pro' ),
				),
				'default'   => 'none',
				'condition' => array(
					'show_zoom_icon' => 'yes',
				),
			),
		);

		$this->add_control(
			'zoom_icon_box_color',
			array(
				'label'     => esc_html__( 'Icon box background color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .motors-elementor-single-listing-gallery .motors-elementor-big-gallery .stm-single-image a .image-icon'        => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .motors-elementor-single-listing-gallery .motors-elementor-big-gallery .stm-single-image a .image-icon:before' => 'border-bottom-color: {{VALUE}};',
					'{{WRAPPER}} .motors-elementor-single-listing-gallery .motors-elementor-big-gallery .stm-single-image a .image-icon:after'  => 'border-top-color: {{VALUE}};',
				),
				'condition' => array(
					'show_zoom_icon' => 'yes',
				),
			),
		);

		$this->add_control(
			'show_overlay',
			array(
				'label'   => esc_html__( 'Show overlay', 'motors-car-dealership-classified-listings-pro' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => '',
			)
		);

		$this->add_control(
			'overlay_opacity',
			array(
				'label'      => esc_html__( 'Overlay opacity (%)', 'motors-car-dealership-classified-listings-pro' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'range'      => array(
					'%' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => '%',
					'size' => 40,
				),
				'selectors'  => array(
					'{{WRAPPER}} .motors-elementor-single-listing-gallery .motors-elementor-big-gallery .stm-single-image a .image-overlay' => 'background-color: rgba(10,10,10,.{{SIZE}});',
				),
				'condition'  => array(
					'show_overlay' => 'yes',
				),
			),
		);

		$this->stm_end_control_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		Helper::stm_ew_load_template( 'elementor/Widgets/single-listing/gallery', STM_LISTINGS_PATH, $settings );
	}

	protected function content_template() {
	}
}
