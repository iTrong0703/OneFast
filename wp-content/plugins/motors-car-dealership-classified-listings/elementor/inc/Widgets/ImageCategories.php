<?php

namespace Motors_Elementor_Widgets_Free\Widgets;

use Motors_Elementor_Widgets_Free\MotorsElementorWidgetsFree;
use Motors_Elementor_Widgets_Free\Helpers\Helper;
use Motors_Elementor_Widgets_Free\Widgets\WidgetBase;

class ImageCategories extends WidgetBase {

	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );

		$this->stm_ew_enqueue(
			$this->get_name(),
			STM_LISTINGS_PATH,
			STM_LISTINGS_URL,
			STM_LISTINGS_V,
			array(
				'swiper',
				'elementor-frontend',
			)
		);

		$this->stm_ew_enqueue(
			$this->get_name() . '-slider',
			STM_LISTINGS_PATH,
			STM_LISTINGS_URL,
			STM_LISTINGS_V,
			array(
				'swiper',
				'elementor-frontend',
			)
		);

		/**
		 * this script contains both slider and ordinary logic
		 * it is needed for the edit page
		 */
		$this->stm_ew_admin_register_ss(
			$this->get_name() . '-admin',
			$this->get_name() . '-admin',
			STM_LISTINGS_PATH,
			STM_LISTINGS_URL,
			STM_LISTINGS_V,
			array(
				'swiper',
				'elementor-frontend',
			)
		);

	}


	public function get_style_depends(): array {
		return array( $this->get_name() );
	}

	public function get_script_depends() {
		return array(
			$this->get_name(),
			$this->get_name() . '-slider',
			$this->get_name() . '-admin',
			'swiper',
		);
	}

	public function get_categories(): array {
		return array( MotorsElementorWidgetsFree::WIDGET_CATEGORY );
	}

	public function get_name(): string {
		return MotorsElementorWidgetsFree::STM_PREFIX . '-image-categories';
	}

	public function get_title(): string {
		return esc_html__( 'Image Categories', 'motors-car-dealership-classified-listings-pro' );
	}

	public function get_icon(): string {
		return 'stmew-image-categories';
	}

	protected function register_controls() {

		$this->stm_start_content_controls_section( 'section_content', esc_html__( 'General', 'motors-car-dealership-classified-listings-pro' ) );

		$listing_categories = stm_listings_attributes();

		if ( ! empty( $listing_categories ) ) {
			$listing_categories = array_column( $listing_categories, 'single_name', 'slug' );
		}

		$this->add_control(
			'taxonomy',
			array(
				'label'   => esc_html__( 'Select Category', 'motors-car-dealership-classified-listings-pro' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => $listing_categories,
			)
		);

		$this->add_control(
			'items_count',
			array(
				'label'   => esc_html__( 'Items Count', 'motors-car-dealership-classified-listings-pro' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => '',
			)
		);

		$this->add_control(
			'show_as_carousel',
			array(
				'label'   => esc_html__( 'Carousel', 'motors-car-dealership-classified-listings-pro' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => '',
			)
		);

		$this->add_control(
			'limit',
			array(
				'label'     => esc_html__( 'Visible Items', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'condition' => array(
					'show_as_carousel' => '',
				),
			)
		);

		$this->add_control(
			'items_align',
			array(
				'label'     => esc_html__( 'Items Align', 'motors-car-dealership-classified-listings-pro' ),
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
				'toggle'    => true,
				'selectors' => array(
					'{{WRAPPER}} .stm_listing_icon_filter' => 'text-align: {{VALUE}}',
					'{{WRAPPER}} .stm_listing_icon_filter .stm_listing_icon_filter_single .name' => 'text-align: {{VALUE}}',
				),
				'condition' => array(
					'show_as_carousel' => '',
				),
			)
		);

		$this->add_control(
			'items_margin_bottom',
			array(
				'label'          => esc_html__( 'Items Margin Bottom', 'motors-car-dealership-classified-listings-pro' ),
				'type'           => \Elementor\Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
				'range'          => array(
					'px' => array(
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					),
				),
				'default'        => array(
					'size' => 44,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 44,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 44,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .stm_listing_icon_filter .stm_listing_icon_filter_single' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
				'condition'      => array(
					'show_as_carousel' => '',
				),
			)
		);

		//px size is not used, it is needed only for the widget to work
		$this->add_responsive_control(
			'per_row',
			array(
				'label'          => esc_html__( 'Columns', 'motors-car-dealership-classified-listings-pro' ),
				'type'           => \Elementor\Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
				'range'          => array(
					'px' => array(
						'min'  => 1,
						'max'  => 12,
						'step' => 1,
					),
				),
				'default'        => array(
					'size' => 4,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 3,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 2,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .stm_listing_icon_filter .stm_listing_icon_filter_single' => 'width: calc(100% / {{SIZE}})',
				),
				'condition'      => array(
					'show_as_carousel' => '',
				),
			)
		);

		$this->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Title', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Browse by' ) . ' {{category}}',
				'default'     => __( 'Browse by' ) . ' {{category}}',
				'description' => __( 'Available replacement:' ) . ' {{category}}',
			)
		);

		$this->add_control(
			'show_all_text',
			array(
				'label'       => esc_html__( '"Show all" label', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Show all' ) . ' {{category}}',
				'default'     => __( 'Show all' ) . ' {{category}}',
				'description' => __( 'Available replacement:' ) . ' {{category}}',
				'condition'   => array(
					'show_as_carousel' => '',
				),
			)
		);

		//px size is not used, it is needed only for the widget to work
		$this->add_responsive_control(
			'slides_per_view',
			array(
				'label'      => esc_html__( 'Columns', 'motors-car-dealership-classified-listings-pro' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 1,
						'max'  => 12,
						'step' => 1,
					),
				),
				'default'    => array(
					'desktop' => 4,
					'tablet'  => 3,
					'mobile'  => 2,
				),
				'condition'  => array(
					'show_as_carousel' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'slides_per_transition',
			array(
				'label'      => esc_html__( 'Slides Per Transition', 'motors-car-dealership-classified-listings-pro' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 1,
						'max'  => 12,
						'step' => 1,
					),
				),
				'default'    => array(
					'desktop' => array(
						'size' => 4,
						'unit' => 'px',
					),
					'tablet'  => array(
						'size' => 3,
						'unit' => 'px',
					),
					'mobile'  => array(
						'size' => 2,
						'unit' => 'px',
					),
				),
				'condition'  => array(
					'show_as_carousel' => 'yes',
				),
			)
		);

		$this->add_control(
			'loop',
			array(
				'label'     => __( 'Infinite Loop', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'condition' => array(
					'show_as_carousel' => 'yes',
				),
			)
		);

		$this->add_control(
			'click_drag',
			array(
				'label'       => __( 'Click & Drag', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'description' => __( 'Accept mouse events like touch events (click and drag to change slides)', 'motors-car-dealership-classified-listings-pro' ),
				'condition'   => array(
					'show_as_carousel' => 'yes',
				),
			)
		);

		$this->add_control(
			'autoplay',
			array(
				'label'     => __( 'Autoplay', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'condition' => array(
					'show_as_carousel' => 'yes',
				),
			)
		);

		$this->add_control(
			'transition_speed',
			array(
				'label'       => __( 'Animation Speed', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'min'         => 100,
				'step'        => 100,
				'default'     => 300,
				'description' => __( 'Speed of slide animation in milliseconds', 'motors-car-dealership-classified-listings-pro' ),
				'condition'   => array(
					'show_as_carousel' => 'yes',
					'autoplay'         => 'yes',
				),
			)
		);

		$this->add_control(
			'delay',
			array(
				'label'       => __( 'Slide Duration', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'min'         => 100,
				'step'        => 100,
				'default'     => 3000,
				'condition'   => array(
					'autoplay'         => 'yes',
					'show_as_carousel' => 'yes',
				),
				'description' => __( 'Delay between transitions in milliseconds', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'pause_on_mouseover',
			array(
				'label'       => __( 'Pause on Mouseover', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'condition'   => array(
					'autoplay'         => 'yes',
					'show_as_carousel' => 'yes',
				),
				'description' => __( 'When enabled autoplay will be paused on mouse enter over carousel container', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'reverse',
			array(
				'label'       => __( 'Reverse Direction', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'condition'   => array(
					'autoplay'         => 'yes',
					'show_as_carousel' => 'yes',
				),
				'description' => __( 'Enables autoplay in reverse direction', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'navigation',
			array(
				'label'     => __( 'Navigation', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'condition' => array(
					'show_as_carousel' => 'yes',
				),
			)
		);

		$this->add_control(
			'navigation_style',
			array(
				'label'     => __( 'Navigation Style', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => array(
					'default'     => __( 'Default (On both sides)', 'motors-car-dealership-classified-listings-pro' ),
					'outstanding' => __( 'Outstanding', 'motors-car-dealership-classified-listings-pro' ),
					'in_heading'  => __( 'In Heading', 'motors-car-dealership-classified-listings-pro' ),
				),
				'default'   => 'default',
				'condition' => array(
					'navigation' => 'yes',
				),
			)
		);

		$this->stm_end_control_section();

		/*Start style section*/
		$this->stm_start_style_controls_section( 'section_color', esc_html__( 'General', 'motors-car-dealership-classified-listings-pro' ) );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'title_typography',
				'label'          => esc_html__( 'Title Typography', 'motors-car-dealership-classified-listings-pro' ),
				'selector'       => '{{WRAPPER}} .stm_icon_filter_title > h3',
				'fields_options' => array(
					'font_size'      => array(
						'size_units'     => array( 'px', 'em' ),
						'default'        => array(
							'unit' => 'px',
							'size' => 26,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 20,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 16,
						),
					),
					'line_height'    => array(
						'size_units'     => array( 'px', 'em' ),
						'default'        => array(
							'unit' => 'px',
							'size' => 32,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 22,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 18,
						),
					),
					'letter_spacing' => array(
						'size_units' => array( 'px', 'em' ),
						'default'    => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
				),
				'exclude'        => array(
					'font_family',
					'font_style',
					'text_transform',
					'text_decoration',
					'word_spacing',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'show_all_typography',
				'label'          => esc_html__( '"Show all" Label Typography', 'motors-car-dealership-classified-listings-pro' ),
				'selector'       => '{{WRAPPER}} .stm_icon_filter_label',
				'fields_options' => array(
					'font_size'      => array(
						'size_units'     => array( 'px', 'em' ),
						'default'        => array(
							'unit' => 'px',
							'size' => 14,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 12,
						),
					),
					'line_height'    => array(
						'size_units'     => array( 'px', 'em' ),
						'default'        => array(
							'unit' => 'px',
							'size' => 17,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 17,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 14,
						),
					),
					'letter_spacing' => array(
						'size_units' => array( 'px', 'em' ),
						'default'    => array(
							'unit' => 'px',
							'size' => 0,
						),
					),
				),
				'exclude'        => array(
					'font_family',
					'font_style',
					'word_spacing',
				),
				'condition'      => array(
					'show_as_carousel' => '',
				),
			)
		);

		$this->add_control(
			'show_all_color',
			array(
				'label'     => esc_html__( '"Show all" Label Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#777777',
				'selectors' => array(
					'{{WRAPPER}} .stm_icon_filter_label' => 'color: {{VALUE}}; border-bottom-color: {{VALUE}};',
				),
				'condition' => array(
					'show_as_carousel' => '',
				),
			)
		);

		$this->add_control(
			'show_all_color_hover',
			array(
				'label'     => esc_html__( '"Show all" Label Color On Hover', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#4e90cc',
				'selectors' => array(
					'{{WRAPPER}} .stm_icon_filter_label:hover'  => 'color: {{VALUE}}; border-bottom-color: {{VALUE}};',
					'{{WRAPPER}} .stm_icon_filter_label:active' => 'color: {{VALUE}}; border-bottom-color: {{VALUE}};',
				),
				'condition' => array(
					'show_as_carousel' => '',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'item_typography',
				'label'    => esc_html__( 'Item Typography', 'motors-car-dealership-classified-listings-pro' ),
				'selector' => '{{WRAPPER}} .stm_listing_icon_filter_single .name',
				'exclude'  => array(
					'font_family',
					'font_style',
					'word_spacing',
				),
			)
		);

		$this->add_control(
			'item_color',
			array(
				'label'     => esc_html__( 'Item Font Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#777777',
				'selectors' => array(
					'{{WRAPPER}} .stm_listing_icon_filter_single .name' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'item_color_hover',
			array(
				'label'     => esc_html__( 'Item Font Color on Hover', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#4e90cc',
				'selectors' => array(
					'{{WRAPPER}} .stm_listing_icon_filter_single:hover .name' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'navigation_background_color',
			array(
				'label'     => esc_html__( 'Navigation Background Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#dddddd',
				'selectors' => array(
					'{{WRAPPER}} .swiper-button-prev' => 'background: {{VALUE}}',
					'{{WRAPPER}} .swiper-button-next' => 'background: {{VALUE}}',
				),
				'condition' => array(
					'navigation' => 'yes',
				),
			)
		);

		$this->add_control(
			'navigation_background_color_hover',
			array(
				'label'     => esc_html__( 'Navigation Background Color On Hover', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#dddddd',
				'selectors' => array(
					'{{WRAPPER}} .swiper-button-prev:hover' => 'background: {{VALUE}}',
					'{{WRAPPER}} .swiper-button-next:hover' => 'background: {{VALUE}}',
				),
				'condition' => array(
					'navigation' => 'yes',
				),
			)
		);

		$this->add_control(
			'navigation_icon_color',
			array(
				'label'     => esc_html__( 'Navigation Icon Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .swiper-button-prev > i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .swiper-button-next > i' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'navigation' => 'yes',
				),
			)
		);

		$this->add_control(
			'navigation_icon_color_hover',
			array(
				'label'     => esc_html__( 'Navigation Icon Color On Hover', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .swiper-button-prev:hover > i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .swiper-button-next:hover > i' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'navigation' => 'yes',
				),
			)
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$is_edit = Helper::is_elementor_edit_mode();

		if ( 'yes' === $settings['show_as_carousel'] ) {
			if ( ! $is_edit ) {
				wp_deregister_script( 'motors-image-categories-admin' );
				wp_dequeue_script( 'motors-image-categories-admin' );
				wp_enqueue_script( 'motors-image-categories-slider' );
			}
			Helper::stm_ew_load_template( 'elementor/Widgets/image-categories/image-categories-slider', STM_LISTINGS_PATH, $settings );

			return;
		}

		if ( ! $is_edit ) {
			wp_deregister_script( 'motors-image-categories-admin' );
			wp_dequeue_script( 'motors-image-categories-admin' );
			wp_enqueue_script( 'motors-image-categories' );
		}
		Helper::stm_ew_load_template( 'elementor/Widgets/image-categories/image-categories', STM_LISTINGS_PATH, $settings );
	}

}
