<?php
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'stm_admin_google_places_enable_script' ) ) {
	function stm_admin_google_places_enable_script( $status = 'registered', $only_google_load = false ) {
		$status         = empty( $status ) ? 'registered' : $status;
		$google_api_key = apply_filters( 'motors_vl_get_nuxy_mod', '', 'google_api_key' );

		if ( ! empty( $google_api_key ) ) {
			$google_api_map = 'https://maps.googleapis.com/maps/api/js';
			$google_api_map = add_query_arg(
				array(
					'key'       => $google_api_key,
					'libraries' => 'places',
					'loading'   => 'async',
					'language'  => get_bloginfo( 'language' ),
					'callback'  => 'stm_gmap_lib_loaded',
				),
				$google_api_map
			);

			if ( ! wp_script_is( 'stm_gmap', 'registered' ) ) {
				wp_register_script( 'stm_gmap', $google_api_map, array(), '1.0', true );

				wp_add_inline_script(
					'stm_gmap',
					'function stm_gmap_lib_loaded(){ var stmGmap = new CustomEvent( \'stm_gmap_api_loaded\', { bubbles: true } ); 
						jQuery( document ).ready( function(){
							document.body.dispatchEvent( stmGmap ); 
						} );
					}',
					'after'
				);
			}

			if ( ! wp_script_is( 'stm-google-places' ) && ! $only_google_load ) {
				wp_register_script(
					'stm-google-places',
					STM_LISTINGS_URL . '/assets/js/stm-admin-places.js',
					array(
						'jquery',
						'stm_gmap',
					),
					STM_LISTINGS_V,
					true
				);
			}

			if ( 'enqueue' === $status ) {
				wp_enqueue_script( 'stm_gmap' );

				if ( ! $only_google_load ) {
					wp_enqueue_script( 'stm-google-places' );
				}
			}
		}
	}
}

add_action( 'stm_admin_google_places_script', 'stm_admin_google_places_enable_script' );

function stm_listings_admin_enqueue( $hook ) {
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );

	wp_localize_script(
		'jquery',
		'mew_nonces',
		array(
			'ajaxurl'                   => admin_url( 'admin-ajax.php' ),
			'tm_nonce'                  => wp_create_nonce( 'motors_create_template' ),
			'tm_delete_nonce'           => wp_create_nonce( 'motors_delete_template' ),
			'close_after_click'         => wp_create_nonce( 'motors_close_after_click' ),
			'wpcfto_generate_pages'     => wp_create_nonce( 'wpcfto_generate_pages' ),
			'stm_add_review_nonce'      => wp_create_nonce( 'stm_add_review_nonce' ),
			'stm_install_starter_theme' => wp_create_nonce( 'stm_install_starter_theme' ),
		)
	);

	wp_enqueue_style( 'mvl-admin-sub-menu', STM_LISTINGS_URL . '/assets/css/admin.css', '', STM_LISTINGS_V );
	wp_enqueue_style( 'mvl-pricing-plans', STM_LISTINGS_URL . '/assets/css/admin-pricing-plans.css', '', STM_LISTINGS_V );
	wp_enqueue_script( 'mvl-admin-sub-menu', STM_LISTINGS_URL . '/assets/js/admin/sub_menu.js', array( 'jquery' ), STM_LISTINGS_V, true );

	wp_enqueue_style( 'stm-listings-datetimepicker', STM_LISTINGS_URL . '/assets/css/jquery.stmdatetimepicker.css', array(), STM_LISTINGS_V );
	wp_enqueue_script( 'stm-listings-datetimepicker', STM_LISTINGS_URL . '/assets/js/jquery.stmdatetimepicker.js', array( 'jquery' ), STM_LISTINGS_V, true );

	wp_enqueue_style( 'jquery-ui-datepicker-style', '//ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css', array(), STM_LISTINGS_V );

	wp_enqueue_style( 'motors_starter_theme', STM_LISTINGS_URL . '/includes/starter-theme/assets/main.css', array( 'wp-admin' ), STM_LISTINGS_V );
	wp_enqueue_script( 'motors_starter_theme', STM_LISTINGS_URL . '/includes/starter-theme/assets/main.js', array( 'jquery-core' ), STM_LISTINGS_V, true );

	wp_enqueue_media();

	if ( 'product' === get_post_type() || in_array( get_post_type(), apply_filters( 'stm_listings_multi_type', array( 'listings' ) ), true ) || 'page' === get_post_type() || 'listings_page_listing_categories' === $hook || 'motors-plugin_page_listing_categories' === $hook ) {
		wp_register_script( 'stm-theme-quicksearch', STM_LISTINGS_URL . '/assets/js/jquery.quicksearch.js', array( 'jquery' ), STM_LISTINGS_V, true );
		wp_register_script( 'stm-theme-multiselect', STM_LISTINGS_URL . '/assets/js/jquery.multi-select.js', array( 'jquery' ), STM_LISTINGS_V, true );
		wp_add_inline_script( 'stm-theme-multiselect', 'var myText = "' . esc_js( __( 'Search...', 'stm_vehicles_listing' ) ) . '";' );
		wp_register_script(
			'stm-listings-js',
			STM_LISTINGS_URL . '/assets/js/vehicles-listing.js',
			array(
				'jquery',
				'jquery-ui-droppable',
				'jquery-ui-datepicker',
				'jquery-ui-sortable',
			),
			STM_LISTINGS_V,
			true
		);

		/* Google places */
		do_action( 'stm_admin_google_places_script' );
	}

	wp_enqueue_style( 'stm_listings_listing_css', STM_LISTINGS_URL . '/assets/css/style.css', array(), STM_LISTINGS_V );
	wp_enqueue_style( 'motors-icons', STM_LISTINGS_URL . '/assets/css/frontend/icons.css', array(), STM_LISTINGS_V );
}

add_action( 'admin_enqueue_scripts', 'stm_listings_admin_enqueue' );
