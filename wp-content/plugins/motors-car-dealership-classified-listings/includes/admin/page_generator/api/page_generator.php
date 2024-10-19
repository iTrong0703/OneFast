<?php

add_action( 'wp_ajax_wpcfto_generate_pages', 'wpcfto_generate_pages' );
function wpcfto_generate_pages() {
	if ( ! current_user_can( 'manage_options' ) ) {
		die;
	}

	$pages = json_decode( file_get_contents( 'php://input' ), true );
	mvl_create_pages( $pages );

	wp_send_json( 'OK' );
}

function mvl_create_pages( $pages ) {
	$options_update = array();

	foreach ( $pages as $page_option => $page_title ) {
		$page_id = apply_filters( 'motors_vl_get_nuxy_mod', '', $page_option );

		if ( ! empty( $page_id ) && get_post_status( $page_id ) === 'publish' ) {
			continue;
		}

		$shortcode = mvl_get_shortcode_for_page( $page_option );

		if ( $shortcode ) {
			$page_id = mvl_create_and_publish_page( $page_title, $shortcode );
			if ( $page_id ) {
				$options_update[ $page_option ] = $page_id;
			}
		}
	}

	if ( ! empty( $options_update ) ) {
		$options = get_option( \MotorsVehiclesListing\Plugin\MVL_Const::MVL_PLUGIN_OPT_NAME, array() );

		foreach ( $options_update as $option => $page_id ) {
			$options[ $option ] = $page_id;
		}

		update_option( \MotorsVehiclesListing\Plugin\MVL_Const::MVL_PLUGIN_OPT_NAME, $options );
	}
}

function mvl_get_shortcode_for_page( $pageOption ) {
	switch ( $pageOption ) {
		case 'listing_archive':
			return '[motors_listing_inventory]';
		case 'compare_page':
			return '[motors_compare_page]';
		case 'login_page':
			return '[motors_login_page]';
		case 'user_add_car_page':
			return '[motors_add_listing_form]';
		default:
			return '';
	}
}

function mvl_create_and_publish_page( $title, $shortcode ) {
	$page_data = array(
		'post_title'   => $title,
		'post_content' => $shortcode,
		'post_status'  => 'publish',
		'post_type'    => 'page',
		'post_author'  => 1,
		'post_name'    => sanitize_title( $title ),
	);

	$page_id = wp_insert_post( $page_data );

	return $page_id ? $page_id : false;
}

function mvl_generate_pages_list() {
	return array(
		'listing_archive'   => esc_html__( 'Listings page', 'stm_vehicles_listing' ),
		'compare_page'      => esc_html__( 'Compare page', 'stm_vehicles_listing' ),
		'login_page'        => esc_html__( 'Profile page', 'stm_vehicles_listing' ),
		'user_add_car_page' => esc_html__( 'Listing creation page', 'stm_vehicles_listing' ),
	);
}

function mvl_has_generated_pages( $pages ) {
	$generated_pages = mvl_get_generated_pages( $pages );

	return count( $generated_pages ) >= count( $pages );
}

function mvl_get_generated_pages( $pages ) {
	$generated_pages = array();
	foreach ( $pages as $page_slug => $page_name ) {
		$page_id = apply_filters( 'motors_vl_get_nuxy_mod', '', $page_slug );

		if ( ! empty( $page_id ) && get_post_status( $page_id ) === 'publish' ) {
			$generated_pages[ $page_slug ] = array(
				'id'   => $page_id,
				'name' => $page_name,
			);
		}
	}

	return $generated_pages;
}
