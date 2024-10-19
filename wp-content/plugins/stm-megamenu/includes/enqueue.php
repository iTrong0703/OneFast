<?php
add_action( 'wp_enqueue_scripts', 'stm_megamenu_front_scripts_method' );
function stm_megamenu_front_scripts_method() {
	$front_css = STM_MM_URL . 'assets/css/';
	$front_js  = STM_MM_URL . 'assets/js/';

	if ( ! function_exists( 'stm_me_get_nuxy_mod' ) ) {
		wp_enqueue_style( 'stm_megamenu', $front_css . 'megamenu.css', array(), STM_MM_VER );
	} else {
		$site_color_style = apply_filters( 'stm_me_get_nuxy_mod', 'site_style_default', 'site_style' );
		if ( 'site_style_default' === $site_color_style ) {

			$deps = array();

			if ( stm_mm_is_elementor_active() ) {
				$deps[] = 'elementor-frontend';
			}

			wp_enqueue_style( 'stm_megamenu', $front_css . 'megamenu.css', $deps, STM_MM_VER );

			if ( function_exists( 'stm_get_default_color' ) ) {
				wp_enqueue_style( 'stm_megamenu_colors', $front_css . 'megamenu_colors.css', array( 'stm_megamenu' ), STM_MM_VER );
			}
		}
	}

	if ( function_exists( 'is_rtl' ) && is_rtl() ) {
		wp_enqueue_style( 'stm_megamenu_rtl', $front_css . 'rtl.css', array(), STM_MM_VER );
	}

	wp_enqueue_script( 'stm_megamenu', $front_js . 'megamenu.js', array( 'jquery' ), STM_MM_VER, true );
}
