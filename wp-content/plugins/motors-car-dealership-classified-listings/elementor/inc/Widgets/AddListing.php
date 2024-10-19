<?php

namespace Motors_Elementor_Widgets_Free\Widgets;

use Motors_Elementor_Widgets_Free\MotorsElementorWidgetsFree;
use Motors_Elementor_Widgets_Free\Helpers\Helper;
use Motors_Elementor_Widgets_Free\Widgets\WidgetBase;

class AddListing extends WidgetBase {

	public function __construct( array $data = array(), array $args = null ) {
		parent::__construct( $data, $args );

		$this->stm_ew_admin_register_ss( $this->get_admin_name(), self::get_name(), STM_LISTINGS_PATH, STM_LISTINGS_URL, STM_LISTINGS_V );
		$this->stm_ew_enqueue( self::get_name() );
	}

	public function get_script_depends() {
		$depends = array(
			'load-image',
			'stm-cascadingdropdown',
			'uniform',
			'uniform-init',
			'jquery-ui-droppable',
			'stmselect2',
			'app-select2',
			'progressbar-layui',
			'progressbar',
			$this->get_admin_name(),
		);

		if ( apply_filters( 'motors_vl_get_nuxy_mod', false, 'addl_details_location' ) ) {
			$depends[] = 'stm_gmap';
			$depends[] = 'stm-google-places';
		}

		return $depends;
	}

	public function get_style_depends(): array {
		$widget_styles   = parent::get_style_depends();
		$widget_styles[] = 'load-image';
		$widget_styles[] = 'stm-cascadingdropdown';
		$widget_styles[] = 'uniform';
		$widget_styles[] = 'uniform-init';
		$widget_styles[] = 'jquery-ui-droppable';
		$widget_styles[] = 'stmselect2';
		$widget_styles[] = 'app-select2';
		$widget_styles[] = 'progress';
		$widget_styles[] = 'progressbar-layui';

		return $widget_styles;
	}

	public function get_categories() {
		return array( MotorsElementorWidgetsFree::WIDGET_CATEGORY_CLASSIFIED );
	}

	public function get_name() {
		return MotorsElementorWidgetsFree::STM_PREFIX . '-add-listing';
	}

	public function get_title() {
		return esc_html__( 'Add Listing', 'motors-car-dealership-classified-listings-pro' );
	}

	public function get_icon() {
		return 'stmew-add-listing';
	}

	public function register_controls() {
		$this->stm_start_content_controls_section( 'general', __( 'General', 'motors-car-dealership-classified-listings-pro' ) );

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

			$listing_types = Helper::stm_ew_multi_listing_types();

			if ( $listing_types ) {
				foreach ( $listing_types as $slug => $typename ) {
					if ( apply_filters( 'stm_listings_post_type', 'listings' ) !== $slug ) {
						$this->add_control(
							'add_listing_hint_' . $slug,
							array(
								'label'     => 'Move To <a href="' . admin_url( 'admin.php?page=stm_motors_listing_types#' . $slug ) . '" target="_blank">' . $typename . ' listing type Settings</a>',
								'type'      => 'heading',
								'condition' => array( 'post_type' => $slug ),
							)
						);
					} else {
						$this->add_control(
							'add_listing_hint',
							array(
								'label'     => 'Move To <a href="' . admin_url( 'admin.php?page=mvl_plugin_settings#single_listing' ) . '" target="_blank">Add Listing Settings</a>',
								'type'      => 'heading',
								'condition' => array( 'post_type' => apply_filters( 'stm_listings_post_type', 'listings' ) ),
							)
						);
					}
				}
			}
		} else {

			$this->add_control(
				'add_listing_hint',
				array(
					'label' => 'Move To <a href="' . admin_url( 'admin.php?page=mvl_plugin_settings#single_listing' ) . '" target="_blank">Add Listing Settings</a>',
					'type'  => 'heading',
				)
			);

		}
	}

	public function render() {
		$settings = $this->get_settings_for_display();
		Helper::stm_ew_load_template( 'elementor/Widgets/add-listing/main', STM_LISTINGS_PATH, $settings );
	}
}
