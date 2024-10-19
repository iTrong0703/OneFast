<?php

namespace Motors_Elementor_Widgets_Free\Widgets;

use \Elementor\Controls_Manager;
use \Elementor\Widget_Base;
use Motors_Elementor_Widgets_Free\MotorsElementorWidgetsFree;

abstract class WidgetBase extends Widget_Base {

	public function get_categories() {
		return array( MotorsElementorWidgetsFree::WIDGET_CATEGORY );
	}

	public function get_name() {
		return 'stm_widget';
	}

	public function get_admin_name() {
		return $this->get_name() . '-admin';
	}

	public function get_script_depends() {
		return array( $this->get_admin_name(), $this->get_name() );
	}

	public function get_style_depends() {
		return array( $this->get_admin_name(), $this->get_name() );
	}

	public function stm_ew_admin_register_ss( $script_id, $file_name, $path = STM_LISTINGS_PATH, $url = STM_LISTINGS_URL, $version = STM_LISTINGS_V, $deps = array( 'elementor-frontend' ) ) {

		wp_register_style( 'motors-general-admin', $url . '/assets/elementor/css/widget/admin/motors-general.css', $deps, $version, 'all' );
		wp_register_script( 'motors-general-admin', $url . '/assets/elementor/js/admin/motors-general.js', $deps, $version, true );

		if ( ! wp_style_is( $script_id, 'enqueued' ) && file_exists( $path . '/assets/elementor/css/widget/admin/' . $file_name . '.css' ) ) {
			wp_register_style( $script_id, $url . '/assets/elementor/css/widget/admin/' . $file_name . '.css', $deps, $version, 'all' );
		}
		if ( ! wp_script_is( $script_id, 'enqueued' ) && file_exists( $path . '/assets/elementor/js/admin/' . $file_name . '.js' ) ) {
			wp_register_script( $script_id, $url . '/assets/elementor/js/admin/' . $file_name . '.js', $deps, $version, true );
		}
	}

	public function stm_ew_enqueue( $file_name, $path = STM_LISTINGS_PATH, $url = STM_LISTINGS_URL, $version = STM_LISTINGS_V, $deps = array( 'jquery' ) ) {

		if ( is_admin() ) {
			return;
		}

		$enqueue_style = true;
		if ( true === $enqueue_style && ! wp_style_is( $file_name, 'enqueued' ) && file_exists( $path . '/assets/elementor/css/widget/' . $file_name . '.css' ) ) {
			wp_register_style( $file_name, $url . '/assets/elementor/css/widget/' . $file_name . '.css', null, $version, 'all' );
		}

		if ( ! wp_script_is( $file_name, 'enqueued' ) && file_exists( $path . '/assets/elementor/js/' . $file_name . '.js' ) ) {
			wp_register_script( $file_name, $url . '/assets/elementor/js/' . $file_name . '.js', $deps, $version, true );
		}
	}

	protected function stm_start_content_controls_section( $section_id, $label ) {
		$this->stm_ew_scs( $section_id, $label, Controls_Manager::TAB_CONTENT );
	}

	protected function stm_start_style_controls_section( $section_id, $label ) {
		$this->stm_ew_scs( $section_id, $label, Controls_Manager::TAB_STYLE );
	}

	protected function stm_start_advanced_controls_section( $section_id, $label ) {
		$this->stm_ew_scs( $section_id, $label, Controls_Manager::TAB_ADVANCED );
	}

	protected function stm_end_control_section() {
		$this->end_controls_section();
	}

	protected function stm_ew_scs( $section_id, $label, $tab ) {
		$this->start_controls_section(
			$section_id,
			array(
				'label' => $label,
				'tab'   => $tab,
			)
		);
	}

	protected function stm_start_ctrl_tabs( $id, $args = array() ) {
		$this->start_controls_tabs(
			$id,
			$args
		);
	}

	protected function stm_start_ctrl_tab( $id, $args ) {
		$this->start_controls_tab(
			$id,
			$args
		);
	}

	protected function stm_end_ctrl_tabs() {
		$this->end_controls_tabs();
	}

	protected function stm_end_ctrl_tab() {
		$this->end_controls_tab();
	}
}
