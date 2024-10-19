<?php

namespace Motors_Elementor_Widgets_Free\Widgets;

use Motors_Elementor_Widgets_Free\MotorsElementorWidgetsFree;
use Motors_Elementor_Widgets_Free\Helpers\Helper;
use Motors_Elementor_Widgets_Free\Widgets\WidgetBase;

class ListingsCompare extends WidgetBase {

	protected $wpcfto_settings = '';

	public function __construct( array $data = array(), array $args = null ) {
		parent::__construct( $data, $args );

		$this->stm_ew_admin_register_ss( $this->get_admin_name(), self::get_name(), STM_LISTINGS_PATH, STM_LISTINGS_URL, STM_LISTINGS_V );
		$this->stm_ew_enqueue( self::get_name(), STM_LISTINGS_PATH, STM_LISTINGS_URL, STM_LISTINGS_V, array( 'jquery' ) );
		$this->stm_ew_enqueue( 'stm-colored-separator', STM_LISTINGS_PATH, STM_LISTINGS_URL, STM_LISTINGS_V );
		if ( is_rtl() ) {
			$this->stm_ew_enqueue( self::get_name() . '-rtl', STM_LISTINGS_PATH, STM_LISTINGS_URL, STM_LISTINGS_V );
		}
	}

	public function get_categories() {
		return array( MotorsElementorWidgetsFree::WIDGET_CATEGORY );
	}

	public function get_name() {
		return MotorsElementorWidgetsFree::STM_PREFIX . '-listings-compare';
	}

	public function get_title() {
		return esc_html__( 'Listings Compare', 'motors-car-dealership-classified-listings-pro' );
	}

	public function get_icon() {
		return 'stmew-inventory-sort';
	}

	public function get_script_depends() {
		return array( 'jquery-effects-slide', $this->get_admin_name() );
	}

	public function get_style_depends(): array {
		$widget_styles   = parent::get_style_depends();
		$widget_styles[] = self::get_name() . '-rtl';
		$widget_styles[] = self::get_admin_name() . 'jquery-effects-slide';
		$widget_styles[] = self::get_name() . 'stm-colored-separator';

		return $widget_styles;
	}

	protected function register_controls() {
		$this->stm_start_content_controls_section( 'compare_content', __( 'General', 'motors-car-dealership-classified-listings-pro' ) );

		if ( stm_is_multilisting() ) {

			$this->add_control(
				'listing_type_heading',
				array(
					'label'     => esc_html__( 'Default Listing type', 'motors-car-dealership-classified-listings-pro' ),
					'type'      => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

		}

		$this->add_control(
			'compare_title',
			array(
				'label'   => __( 'Title', 'motors-car-dealership-classified-listings-pro' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Compare vehicles', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'add_item_label',
			array(
				'label'   => __( 'Add Item Label', 'motors-car-dealership-classified-listings-pro' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Add Car To Compare', 'motors-car-dealership-classified-listings-pro' ),
			)
		);

		$this->add_control(
			'add_item_icon',
			array(
				'label'            => __( 'Add Item Icon', 'motors-car-dealership-classified-listings-pro' ),
				'type'             => \Elementor\Controls_Manager::ICONS,
				'skin'             => 'inline',
				'fa4compatibility' => 'icon',
				'default'          => array(
					'value' => 'motors-icons-add_car',
				),
			)
		);

		if ( stm_is_multilisting() ) {

			$listing_types = Helper::stm_ew_multi_listing_types();

			if ( $listing_types ) {
				foreach ( $listing_types as $slug => $typename ) {
					if ( apply_filters( 'stm_listings_post_type', 'listings' ) !== $slug ) {

						$this->add_control(
							'listing_type_' . $slug . '_heading',
							array(
								'label'     => esc_html( $typename ),
								'type'      => \Elementor\Controls_Manager::HEADING,
								'separator' => 'before',
							)
						);

						$this->add_control(
							'compare_title_' . $slug,
							array(
								'label'   => __( 'Title', 'motors-car-dealership-classified-listings-pro' ),
								'type'    => \Elementor\Controls_Manager::TEXT,
								'default' => __( 'Compare vehicles', 'motors-car-dealership-classified-listings-pro' ),
							)
						);

						$this->add_control(
							'add_item_label_' . $slug,
							array(
								'label'   => __( 'Add Item Label', 'motors-car-dealership-classified-listings-pro' ),
								'type'    => \Elementor\Controls_Manager::TEXT,
								'default' => __( 'Add Item To Compare', 'motors-car-dealership-classified-listings-pro' ),
							)
						);

						$this->add_control(
							'add_item_icon_' . $slug,
							array(
								'label'            => __( 'Add Item Icon', 'motors-car-dealership-classified-listings-pro' ),
								'type'             => \Elementor\Controls_Manager::ICONS,
								'skin'             => 'inline',
								'fa4compatibility' => 'icon',
								'default'          => array(
									'value'   => 'fas fa-plus-circle',
									'library' => 'fa-solid',
								),
							)
						);

					}
				}
			}
		}

		$this->stm_end_control_section();

		$this->stm_start_style_controls_section( 'compare_style', __( 'Style', 'motors-car-dealership-classified-listings-pro' ) );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'title_typography',
				'label'          => __( 'Title Typography', 'motors-car-dealership-classified-listings-pro' ),
				'exclude'        => array(
					'font_family',
					'font_style',
					'text_decoration',
					'letter_spacing',
					'word_spacing',
				),
				'fields_options' => array(
					'font_size'      => array(
						'default' => array(
							'unit' => 'px',
							'size' => 36,
						),
					),
					'font_weight'    => array(
						'default' => '700',
					),
					'line_height'    => array(
						'default' => array(
							'unit' => 'px',
							'size' => 36,
						),
					),
					'text_transform' => array(
						'default' => 'uppercase',
					),
				),
				'selector'       => '{{WRAPPER}} .car-listing-row.stm-car-compare-row .compare-title',
			)
		);

		$this->add_control(
			'title_line_color',
			array(
				'label'     => __( 'Title Line Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .colored-separator div' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'add_item_typography',
				'label'          => __( 'Add Item Label Typography', 'motors-car-dealership-classified-listings-pro' ),
				'exclude'        => array(
					'font_family',
					'font_style',
					'text_decoration',
					'letter_spacing',
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
						'default' => '400',
					),
					'line_height'    => array(
						'default' => array(
							'unit' => 'px',
							'size' => 20,
						),
					),
					'text_transform' => array(
						'default' => 'uppercase',
					),
				),
				'selector'       => '{{WRAPPER}} .compare-col-stm-empty .h5',
			)
		);

		$this->add_control(
			'add_item_icon_color',
			array(
				'label'     => __( 'Add Item Icon Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#d1d7dc',
				'selectors' => array(
					'{{WRAPPER}} .stm-icon-add-car-wrapper i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .stm-icon-add-car-wrapper svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'add_item_icon_size',
			array(
				'label'      => __( 'Add Item Icon Size', 'motors-car-dealership-classified-listings-pro' ),
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
					'size' => 52,
				),
				'selectors'  => array(
					'{{WRAPPER}} .compare-col-stm-empty .stm-icon-add-car-wrapper > i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .compare-col-stm-empty .stm-icon-add-car-wrapper > svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->stm_end_control_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		Helper::stm_ew_load_template( 'elementor/Widgets/listings-compare', STM_LISTINGS_PATH, $settings );
	}

	protected function content_template() {

	}
}
