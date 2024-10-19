<?php
/*Inventory*/
function motors_listing_inventory( $atts ) {
	mvl_enqueue_header_scripts_styles( 'stmselect2' );
	mvl_enqueue_header_scripts_styles( 'app-select2' );
	mvl_enqueue_header_scripts_styles( 'motors-datetimepicker' );
	mvl_enqueue_header_scripts_styles( 'items-per-page' );
	mvl_enqueue_header_scripts_styles( 'inventory' );
	mvl_enqueue_header_scripts_styles( 'inventory-view-type' );
	mvl_enqueue_header_scripts_styles( 'loop-list' );
	mvl_enqueue_header_scripts_styles( 'loop-grid' );

	ob_start();
	do_action( 'stm_listings_load_template', 'filter/inventory/main' );

	return ob_get_clean();
}

add_shortcode( 'motors_listing_inventory', 'motors_listing_inventory' );

//Add a car
/**
 * Add Listing
 * [motors_add_listing_form]
 * */
function motors_add_listing_form( $atts ) {
	if ( apply_filters( 'motors_vl_get_nuxy_mod', false, 'addl_show_registered' ) ) {
		mvl_enqueue_header_scripts_styles( 'motors-datetimepicker' );
	}
	mvl_enqueue_header_scripts_styles( 'motors-add-listing' );
	mvl_enqueue_header_scripts_styles( 'stmselect2' );
	mvl_enqueue_header_scripts_styles( 'app-select2' );
	mvl_enqueue_header_scripts_styles( 'uniform' );
	mvl_enqueue_header_scripts_styles( 'stm-cascadingdropdown' );
	mvl_enqueue_header_scripts_styles( 'listing-search' );

	$atts['taxonomies'] = apply_filters( 'motors_vl_get_nuxy_mod', false, 'addl_required_fields' );

	ob_start();
	stm_listings_load_template( 'add-a-car', $atts );

	return ob_get_clean();
}

add_shortcode( 'motors_add_listing_form', 'motors_add_listing_form' );

//Login Register
function motors_login_page( $atts ) {

	$user = wp_get_current_user();
	if ( ! is_wp_error( $user ) && ! empty( $user->ID ) && is_page() ) {
		wp_safe_redirect( get_author_posts_url( $user->data->ID ) );
		exit;
	}

	ob_start();
	stm_listings_load_template( 'login' );

	return ob_get_clean();
}

add_shortcode( 'motors_login_page', 'motors_login_page' );

//Compare page
function motors_compare_page( $atts ) {
	mvl_enqueue_header_scripts_styles( 'uniform' );
	mvl_enqueue_header_scripts_styles( 'uniform-init' );
	mvl_enqueue_header_scripts_styles( 'jquery-effects-slide' );

	ob_start();
	stm_listings_load_template( 'compare/compare' );

	return ob_get_clean();
}

add_shortcode( 'motors_compare_page', 'motors_compare_page' );

/**
 * Listing Search Tabs
 * atts:
 * $show_amount: yes
 * $filter_fields: make, model ...
 * [motors_listing_search show_amount='yes' filter_fields='make,serie,ca-year']
*/
function motors_listing_search( $atts ) {
	mvl_enqueue_header_scripts_styles( 'stmselect2' );
	mvl_enqueue_header_scripts_styles( 'app-select2' );
	mvl_enqueue_header_scripts_styles( 'stm-cascadingdropdown' );
	mvl_enqueue_header_scripts_styles( 'listing-search' );

	ob_start();
	stm_listings_load_template( 'shortcodes/motors-listing-search', $atts );

	return ob_get_clean();
}
add_shortcode( 'motors_listing_search', 'motors_listing_search' );

/**
 * Listing Icon Filter
 * atts:
 * $title
 * $columns: 1,2,3,4,6,9,12
 * $filter_selected: make, model ...
 * $as_carousel: yes
 * $visible_items: 4
 *
 * [motors_listing_icon_filter as_carousel='yes' filter_selected='make' title='Browse by Make' columns='6' visible_items='5']
 */
function motors_listing_icon_filter( $atts ) {
	mvl_enqueue_header_scripts_styles( 'swiper' );
	mvl_enqueue_header_scripts_styles( 'listing-icon-filter' );

	ob_start();
	stm_listings_load_template( 'shortcodes/motors-listing-icon-filter', $atts );

	return ob_get_clean();
}
add_shortcode( 'motors_listing_icon_filter', 'motors_listing_icon_filter' );

/**
 * atts:
 * $title: New/Used Cars
 * $columns: 2,3,4,6
 * $popular_tab: yes - To disable the tab, do not add this parameter
 * $recent_tab: yes - To disable the tab, do not add this parameter
 * $featured_tab: yes - To disable the tab, do not add this parameter
 * [motors_listings_tabs title='New/Used Cars' columns='3' popular_tab='yes' recent_tab='yes' featured_tab='yes']
*/
function motors_listings_tabs( $atts ) {
	mvl_enqueue_header_scripts_styles( 'bootstrap-tab' );
	mvl_enqueue_header_scripts_styles( 'bootstrap' );
	mvl_enqueue_header_scripts_styles( 'listings-tabs' );
	ob_start();
	stm_listings_load_template( 'shortcodes/motors-listings-tabs', $atts );

	return ob_get_clean();
}
add_shortcode( 'motors_listings_tabs', 'motors_listings_tabs' );
