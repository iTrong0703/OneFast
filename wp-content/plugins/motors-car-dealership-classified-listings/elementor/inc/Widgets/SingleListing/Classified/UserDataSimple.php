<?php

namespace Motors_Elementor_Widgets_Free\Widgets\SingleListing\Classified;

use Motors_Elementor_Widgets_Free\MotorsElementorWidgetsFree;
use Motors_Elementor_Widgets_Free\Helpers\Helper;
use Motors_Elementor_Widgets_Free\Widgets\WidgetBase;

class UserDataSimple extends WidgetBase {

	public function __construct( array $data = array(), array $args = null ) {
		parent::__construct( $data, $args );

		$this->stm_ew_admin_register_ss( $this->get_admin_name(), self::get_name(), STM_LISTINGS_PATH, STM_LISTINGS_URL, STM_LISTINGS_V );
		$this->stm_ew_enqueue( self::get_name(), STM_LISTINGS_PATH, STM_LISTINGS_URL, STM_LISTINGS_V, array( 'jquery' ) );
	}

	public function get_categories() {
		return array( MotorsElementorWidgetsFree::WIDGET_CATEGORY_SINGLE );
	}

	public function get_name() {
		return MotorsElementorWidgetsFree::STM_PREFIX . '-single-listing-user-data-simple';
	}

	public function get_title() {
		return esc_html__( 'User Data Simple', 'motors-car-dealership-classified-listings-pro' );
	}

	public function get_icon() {
		return 'stmew-user-info';
	}

	protected function register_controls() {
		$this->get_general_settings();
	}

	private function get_general_settings() {
		$this->stm_start_style_controls_section( 'uds_general_styles', __( 'General', 'motors-car-dealership-classified-listings-pro' ) );

		$this->add_control(
			'uds_general_user_name_color',
			array(
				'label'     => __( 'User Name Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#232628',
				'selectors' => array(
					'{{WRAPPER}} .stm-listing-car-dealer-info-simple .title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'uds_general_user_name_typography',
				'label'          => __( 'User Name Typography', 'motors-car-dealership-classified-listings-pro' ),
				'separator'      => 'before',
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
							'size' => 16,
						),
					),
					'font_weight'    => array(
						'default' => '700',
					),
					'line_height'    => array(
						'default' => array(
							'unit' => 'px',
							'size' => 32,
						),
					),
					'text_transform' => array(
						'default' => 'capitalize',
					),
				),
				'selector'       => '{{WRAPPER}} .stm-listing-car-dealer-info-simple .title',
			)
		);

		$this->add_control(
			'uds_general_user_role_color',
			array(
				'label'       => __( 'User Role Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'description' => esc_html__( 'Only for User Role Subscriber', 'motors-car-dealership-classified-listings-pro' ),
				'default'     => '#888888',
				'selectors'   => array(
					'{{WRAPPER}} .stm-listing-car-dealer-info-simple .stm-user-main-info-c .stm-label' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'           => 'uds_general_user_role_typography',
				'label'          => __( 'User Role Typography', 'motors-car-dealership-classified-listings-pro' ),
				'description'    => esc_html__( 'Only for User Role Subscriber', 'motors-car-dealership-classified-listings-pro' ),
				'separator'      => 'before',
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
							'size' => 13,
						),
					),
					'font_weight'    => array(
						'default' => '400',
					),
					'line_height'    => array(
						'default' => array(
							'unit' => 'px',
							'size' => 22,
						),
					),
					'text_transform' => array(
						'default' => 'capitalize',
					),
				),
				'selector'       => '{{WRAPPER}} .stm-listing-car-dealer-info-simple .stm-user-main-info-c .stm-label',
			)
		);

		$this->add_control(
			'uds_review_amount_color',
			array(
				'label'       => __( 'Review Amount Color', 'motors-car-dealership-classified-listings-pro' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'description' => esc_html__( 'Only for User Role Dealer', 'motors-car-dealership-classified-listings-pro' ),
				'default'     => '#888888',
				'selectors'   => array(
					'{{WRAPPER}} .stm-listing-car-dealer-info-simple .dealer-rating .stm-rate-sum' => 'color: {{VALUE}};',
				),
			)
		);

		$this->stm_end_control_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		Helper::stm_ew_load_template( 'elementor/Widgets/single-listing/classified/user-data-simple', STM_LISTINGS_PATH, $settings );
	}

	protected function content_template() {
	}
}
