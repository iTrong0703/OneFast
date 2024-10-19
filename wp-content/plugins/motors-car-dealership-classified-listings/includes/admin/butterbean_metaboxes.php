<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

require_once STM_LISTINGS_PATH . '/includes/admin/butterbean_helpers.php';
do_action( 'stm_add_new_auto_complete' );
add_action( 'butterbean_register', 'stm_listings_register_manager', 10, 2 );

function stm_listings_register_manager( $butterbean, $post_type ) {
	$listings = apply_filters( 'stm_listings_post_type', 'listings' );

	// Register managers, sections, controls, and settings here.
	if ( $post_type !== $listings ) {
		return;
	}

	$butterbean->register_manager(
		'stm_car_manager',
		array(
			'label'     => esc_html__( 'Listing manager', 'stm_vehicles_listing' ),
			'post_type' => $listings,
			'context'   => 'normal',
			'priority'  => 'high',
		)
	);

	$manager = $butterbean->get_manager( 'stm_car_manager' );

	/*Register sections*/
	$manager->register_section(
		'stm_options',
		array(
			'label' => esc_html__( 'Details', 'stm_vehicles_listing' ),
			'icon'  => 'fas fa-list-ul',
		)
	);

	$manager->register_section(
		'stm_features',
		array(
			'label' => esc_html__( 'Options', 'stm_vehicles_listing' ),
			'icon'  => 'fa fa-dashboard',
		)
	);

	$manager->register_section(
		'stm_additional_features',
		array(
			'label' => esc_html__( 'Features', 'stm_vehicles_listing' ),
			'icon'  => 'fa-regular fa-square-check',
		)
	);

	$manager->register_section(
		'stm_price',
		array(
			'label' => esc_html__( 'Prices', 'stm_vehicles_listing' ),
			'icon'  => 'fa fa-dollar',
		)
	);

	$manager->register_section(
		'special_offers',
		array(
			'label' => esc_html__( 'Specials', 'stm_vehicles_listing' ),
			'icon'  => 'fa fa-bookmark',
		)
	);

	$manager->register_section(
		'stm_media',
		array(
			'label' => esc_html__( 'Images', 'stm_vehicles_listing' ),
			'icon'  => 'fa fa-image',
		)
	);

	$manager->register_section(
		'stm_video',
		array(
			'label' => esc_html__( 'Videos', 'stm_vehicles_listing' ),
			'icon'  => 'fa fa-video-camera',
		)
	);

	$manager->register_section(
		'motors_listing_info',
		array(
			'label' => esc_html__( 'Specifications', 'stm_vehicles_listing' ),
			'icon'  => 'fa fa-th-list',
		)
	);

	/**
	 * Register settings from selected demo
	 */
	do_action( 'listing_settings_register_section', $manager );

	/*Registering controls*/

	/*Special Cars*/

	$manager->register_control(
		'special_car',
		array(
			'type'        => 'checkbox',
			'section'     => 'special_offers',
			'value'       => 'on',
			'label'       => esc_html__( 'Special offer', 'stm_vehicles_listing' ),
			'preview'     => 'special',
			'description' => esc_html__( 'Show this item in \'special offers carousel\' module and Featured Listing', 'stm_vehicles_listing' ),
			'attr'        => array( 'class' => 'widefat' ),
		)
	);

	$manager->register_control(
		'badge_text',
		array(
			'type'    => 'text',
			'section' => 'special_offers',
			'preview' => 'special_label',
			'label'   => esc_html__( 'Enable badge', 'stm_vehicles_listing' ),
			'attr'    => array(
				'data-dep'    => 'special_car',
				'data-value'  => 'true',
				'placeholder' => esc_html__( 'Enter badge text', 'stm_vehicles_listing' ),
				'class'       => 'widefat',
			),
		)
	);

	$manager->register_control(
		'badge_bg_color',
		array(
			'type'    => 'color',
			'section' => 'special_offers',
			'label'   => esc_html__( 'Badge background color', 'stm_vehicles_listing' ),
		)
	);

	do_action( 'special_tab_options', $manager );

	/*Media*/
	$manager->register_control(
		'gallery',
		array(
			'type'        => 'gallery',
			'section'     => 'stm_media',
			'label'       => 'Image Gallery',
			'description' => esc_html__( 'Create photo gallery for listing item here', 'stm_vehicles_listing' ),
			'size'        => 'stm-img-398-x-2',
		)
	);

	/*Video*/

	$manager->register_control(
		'video_preview',
		array(
			'type'        => 'image',
			'section'     => 'stm_video',
			'label'       => 'Video Preview',
			'description' => esc_html__( 'Image for video preview. Please note that video will start playing in a pop-up window.', 'stm_vehicles_listing' ),
			'size'        => 'stm-img-398-x-2',
		)
	);

	$manager->register_control(
		'gallery_video',
		array(
			'type'    => 'text',
			'section' => 'stm_video',
			'label'   => esc_html__( 'Gallery Video (Embed video URL)', 'stm_vehicles_listing' ),
			'attr'    => array(
				'class' => 'widefat',
			),
		)
	);

	$manager->register_control(
		'gallery_videos',
		array(
			'type'    => 'repeater',
			'section' => 'stm_video',
			'label'   => esc_html__( 'Additional videos (Embed video URL)', 'stm_vehicles_listing' ),
			'attr'    => array(
				'class' => 'widefat',
			),
		)
	);

	$manager->register_control(
		'gallery_videos_posters',
		array(
			'type'        => 'gallery',
			'section'     => 'stm_video',
			'label'       => 'Additional video posters',
			'description' => esc_html__( 'Used in STM Boat Videos module', 'stm_vehicles_listing' ),
			'size'        => 'stm-img-398-x-2',
		)
	);

	/*Additional features*/
	$manager->register_control(
		'additional_features',
		array(
			'type'    => ( ! empty( apply_filters( 'motors_vl_get_nuxy_mod', array(), 'fs_user_features' ) ) ) ? 'grouped_checkboxes' : 'checkbox_repeater',
			'section' => 'stm_additional_features',
			'label'   => esc_html__( 'Additional features', 'stm_vehicles_listing' ),
			'preview' => 'features',
		)
	);

	/*Price*/
	$manager->register_control(
		'price',
		array(
			'type'    => 'number',
			'section' => 'stm_price',
			'label'   => esc_html__( 'Price', 'stm_vehicles_listing' ),
			'preview' => 'price_msrp',
			'attr'    => array(
				'class' => 'widefat',
			),
		)
	);

	$manager->register_control(
		'sale_price',
		array(
			'type'    => 'number',
			'section' => 'stm_price',
			'preview' => 'price',
			'label'   => esc_html__( 'Sale Price', 'stm_vehicles_listing' ),
			'attr'    => array(
				'class' => 'widefat',
			),
		)
	);

	/**
	 * Register price controls from selected demo
	 */
	do_action( 'listing_price_register_control', $manager );

	$manager->register_control(
		'stm_genuine_price',
		array(
			'type'    => 'hidden',
			'section' => 'stm_price',
			'preview' => 'price',
			'label'   => esc_html__( 'Genuine Price', 'stm_vehicles_listing' ),
			'attr'    => array(
				'class' => 'widefat',
			),
		)
	);

	$manager->register_control(
		'regular_price_label',
		array(
			'type'    => 'text',
			'section' => 'stm_price',
			'label'   => esc_html__( 'Regular price label', 'stm_vehicles_listing' ),
			'attr'    => array(
				'class' => 'widefat',
			),
		)
	);

	$manager->register_control(
		'regular_price_description',
		array(
			'type'    => 'text',
			'section' => 'stm_price',
			'label'   => esc_html__( 'Regular price description', 'stm_vehicles_listing' ),
			'attr'    => array(
				'class' => 'widefat',
			),
		)
	);

	$manager->register_control(
		'special_price_label',
		array(
			'type'    => 'text',
			'section' => 'stm_price',
			'label'   => esc_html__( 'Special price label', 'stm_vehicles_listing' ),
			'attr'    => array(
				'class' => 'widefat',
			),
		)
	);

	$manager->register_control(
		'instant_savings_label',
		array(
			'type'    => 'text',
			'section' => 'stm_price',
			'label'   => esc_html__( 'Instant savings label', 'stm_vehicles_listing' ),
			'preview' => 'price_instant',
			'attr'    => array(
				'class' => 'widefat',
			),
		)
	);

	$manager->register_control(
		'car_price_form_label',
		array(
			'type'        => 'text',
			'section'     => 'stm_price',
			'label'       => esc_html__( 'Custom label', 'stm_vehicles_listing' ),
			'preview'     => 'price_request',
			'description' => esc_html__( 'This text will appear instead of price', 'stm_vehicles_listing' ),
			'attr'        => array(
				'class' => 'widefat',
			),
		)
	);

	$manager->register_control(
		'car_price_form',
		array(
			'type'        => 'checkbox',
			'section'     => 'stm_price',
			'value'       => 'on',
			'label'       => esc_html__( 'Listing price form', 'stm_vehicles_listing' ),
			'description' => esc_html__( 'Enable/Disable \'Request a price\' form', 'stm_vehicles_listing' ),
			'attr'        => array( 'class' => 'widefat' ),
		)
	);

	do_action( 'add_pro_butterbean_fields', $manager );

	if ( apply_filters( 'motors_vl_get_nuxy_mod', false, 'enable_woo_online' ) ) {
		$manager->register_control(
			'car_mark_woo_online',
			array(
				'type'        => 'checkbox',
				'section'     => 'stm_price',
				'value'       => 'on',
				'label'       => esc_html__( 'Sell a car Online', 'stm_vehicles_listing' ),
				'description' => esc_html__( 'Enable/Disable Sell a car Online', 'stm_vehicles_listing' ),
				'attr'        => array(
					'data-dep'   => 'car_mark_as_sold',
					'data-value' => 'false',
					'class'      => 'widefat',
				),
			)
		);

		$manager->register_control(
			'stm_car_stock',
			array(
				'type'    => 'number',
				'section' => 'stm_price',
				'value'   => '1',
				'label'   => esc_html__( 'Car Stock', 'stm_vehicles_listing' ),
				'attr'    => array(
					'data-dep'    => 'car_mark_woo_online',
					'data-value'  => 'true',
					'placeholder' => esc_html__( 'Enter amount in stock', 'stm_vehicles_listing' ),
					'class'       => 'widefat',
				),
			)
		);
	}

	/*Options*/
	$manager->register_control(
		'automanager_id',
		array(
			'type'    => 'hidden',
			'section' => 'stm_options',
			'label'   => esc_html__( 'Listing ID', 'stm_vehicles_listing' ),
			'attr'    => array( 'class' => 'widefat' ),
		)
	);

	/**
	 * Register stock/serial number controls from selected demo
	 */
	do_action( 'listing_stock_number_register_control', $manager );

	$manager->register_control(
		'stm_car_location',
		array(
			'type'    => 'location',
			'section' => 'stm_options',
			'label'   => esc_html__( 'Listing location', 'stm_vehicles_listing' ),
			'attr'    => array(
				'class' => 'widefat',
				'id'    => 'stm_car_location',
			),
		)
	);

	$manager->register_control(
		'stm_lat_car_admin',
		array(
			'type'    => 'text',
			'section' => 'stm_options',
			'label'   => esc_html__( 'Latitude', 'stm_vehicles_listing' ),
			'attr'    => array(
				'class' => 'widefat',
				'id'    => 'stm_lat_car_admin',
			),
		)
	);

	$manager->register_control(
		'stm_lng_car_admin',
		array(
			'type'    => 'text',
			'section' => 'stm_options',
			'label'   => esc_html__( 'Longitude', 'stm_vehicles_listing' ),
			'attr'    => array(
				'class' => 'widefat',
				'id'    => 'stm_lng_car_admin',
			),
		)
	);

	$manager->register_control(
		'stm_location_address',
		array(
			'type'    => 'hidden',
			'section' => 'stm_options',
			'label'   => esc_html__( 'Address Components', 'stm_vehicles_listing' ),
			'attr'    => array(
				'class' => 'widefat',
				'id'    => 'stm_location_address',
			),
		)
	);

	do_action( 'add_classified_fields', $manager );

	do_action( 'listing_settings_register_controls', $manager );

	$manager->register_control(
		'registration_date',
		array(
			'type'    => 'datepicker',
			'section' => 'stm_options',
			'label'   => esc_html__( 'Vehicle Production Date', 'stm_vehicles_listing' ),
			'preview' => 'regist',
			'attr'    => array( 'class' => 'widefat' ),
		)
	);

	$manager->register_control(
		'history',
		array(
			'type'    => 'text',
			'section' => 'stm_options',
			'label'   => esc_html__( 'Certificate name', 'stm_vehicles_listing' ),
			'attr'    => array( 'class' => 'widefat' ),
			'preview' => 'history-txt',
		)
	);

	$manager->register_control(
		'history_link',
		array(
			'type'    => 'text',
			'section' => 'stm_options',
			'label'   => esc_html__( 'Certificate 1 Link', 'stm_vehicles_listing' ),
			'attr'    => array( 'class' => 'widefat' ),
		)
	);

	$manager->register_control(
		'certified_logo_1',
		array(
			'type'    => 'image',
			'section' => 'stm_options',
			'label'   => esc_html__( 'Certified 1 Logo', 'stm_vehicles_listing' ),
			'size'    => 'thumbnail',
			'preview' => 'CERT1',
		)
	);

	$manager->register_control(
		'certified_logo_2_link',
		array(
			'type'    => 'text',
			'section' => 'stm_options',
			'label'   => esc_html__( 'Certificate 2 Link', 'stm_vehicles_listing' ),
			'attr'    => array( 'class' => 'widefat' ),
		)
	);

	$manager->register_control(
		'certified_logo_2',
		array(
			'type'    => 'image',
			'section' => 'stm_options',
			'label'   => esc_html__( 'Certified 2 Logo', 'stm_vehicles_listing' ),
			'size'    => 'thumbnail',
			'preview' => 'CERT2',
		)
	);

	$manager->register_control(
		'car_brochure',
		array(
			'type'    => 'file',
			'section' => 'stm_options',
			'label'   => esc_html__( 'Brochure (.pdf)', 'stm_vehicles_listing' ),
			'preview' => 'pdf',
			'attr'    => array(
				'class'     => 'widefat',
				'data-type' => 'application/pdf',
			),
		)
	);

	$manager->register_control(
		'stm_car_user',
		array(
			'type'    => 'select',
			'section' => 'stm_options',
			'label'   => __( 'Created by', 'stm_vehicles_listing' ),
			'choices' => stm_listings_get_user_list(),
			'attr'    => array( 'class' => 'widefat' ),
		)
	);

	$manager->register_control(
		'stm_car_views',
		array(
			'type'        => 'text',
			'section'     => 'stm_options',
			'label'       => esc_html__( 'Amount of Car Views', 'stm_vehicles_listing' ),
			'description' => __( 'Visible for item author', 'stm_vehicles_listing' ),
			'attr'        => array(
				'class'    => 'widefat',
				'readonly' => 'readonly',
				'reset'    => 'all',
			),
		)
	);

	$manager->register_control(
		'stm_phone_reveals',
		array(
			'type'        => 'text',
			'section'     => 'stm_options',
			'label'       => esc_html__( 'Amount of Phone Views', 'stm_vehicles_listing' ),
			'description' => __( 'Visible for item author', 'stm_vehicles_listing' ),
			'attr'        => array(
				'class'    => 'widefat',
				'readonly' => 'readonly',
				'reset'    => 'all',
			),
		)
	);

	do_action( 'listing_settings_register_controls_end', $manager );

	/*Registering Setting*/

	/*Special Cars*/

	$manager->register_setting(
		'special_car',
		array(
			'sanitize_callback' => 'stm_listings_validate_checkbox',
		)
	);

	$manager->register_setting(
		'special_text',
		array(
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		)
	);

	$manager->register_setting(
		'special_image',
		array( 'sanitize_callback' => 'stm_listings_validate_image' )
	);

	$manager->register_setting(
		'badge_text',
		array(
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		)
	);

	$manager->register_setting(
		'badge_bg_color',
		array( 'sanitize_callback' => 'wp_filter_nohtml_kses' )
	);

	/*Media*/

	$manager->register_setting(
		'gallery',
		array( 'sanitize_callback' => 'stm_listings_validate_gallery' )
	);

	/*Video*/
	$manager->register_setting(
		'video_preview',
		array( 'sanitize_callback' => 'stm_listings_validate_image' )
	);

	$manager->register_setting(
		'gallery_video',
		array( 'sanitize_callback' => 'wp_filter_nohtml_kses' )
	);

	$manager->register_setting(
		'gallery_videos',
		array( 'sanitize_callback' => 'stm_listings_validate_repeater_videos' )
	);

	$manager->register_setting(
		'gallery_videos_posters',
		array( 'sanitize_callback' => 'stm_gallery_videos_posters' )
	);

	/*Price*/
	$manager->register_setting(
		'price',
		array(
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		)
	);

	$manager->register_setting(
		'sale_price',
		array(
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		)
	);

	$manager->register_setting(
		'stm_genuine_price',
		array(
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		)
	);

	$manager->register_setting(
		'regular_price_label',
		array(
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		)
	);

	$manager->register_setting(
		'regular_price_description',
		array(
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		)
	);

	$manager->register_setting(
		'special_price_label',
		array(
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		)
	);

	$manager->register_setting(
		'instant_savings_label',
		array(
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		)
	);

	$manager->register_setting(
		'car_price_form',
		array(
			'sanitize_callback' => 'stm_listings_validate_checkbox',
		)
	);

	$manager->register_setting(
		'car_mark_woo_online',
		array(
			'sanitize_callback' => 'stm_listings_validate_checkbox',
		)
	);

	$manager->register_setting(
		'stm_car_stock',
		array(
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		)
	);

	$manager->register_setting(
		'car_mark_as_sold',
		array(
			'sanitize_callback' => 'stm_listings_validate_checkbox',
		)
	);

	$manager->register_setting(
		'car_price_form_label',
		array(
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		)
	);

	/*Options*/
	$manager->register_setting(
		'automanager_id',
		array(
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		)
	);

	$manager->register_setting(
		'stm_car_user',
		array( 'sanitize_callback' => 'sanitize_key' )
	);

	$manager->register_setting(
		'stm_car_views',
		array( 'sanitize_callback' => 'sanitize_key' )
	);

	$manager->register_setting(
		'stm_phone_reveals',
		array( 'sanitize_callback' => 'sanitize_key' )
	);

	$manager->register_setting(
		'stock_number',
		array( 'sanitize_callback' => 'wp_filter_nohtml_kses' )
	);

	$manager->register_setting(
		'serial_number',
		array( 'sanitize_callback' => 'wp_filter_nohtml_kses' )
	);

	$manager->register_setting(
		'registration_number',
		array( 'sanitize_callback' => 'wp_filter_nohtml_kses' )
	);

	$manager->register_setting(
		'stm_car_location',
		array( 'sanitize_callback' => 'wp_filter_nohtml_kses' )
	);

	$manager->register_setting(
		'stm_lat_car_admin',
		array( 'sanitize_callback' => 'wp_filter_nohtml_kses' )
	);

	$manager->register_setting(
		'stm_lng_car_admin',
		array( 'sanitize_callback' => 'wp_filter_nohtml_kses' )
	);

	$manager->register_setting(
		'stm_location_address',
		array( 'sanitize_callback' => 'wp_filter_nohtml_kses' )
	);

	$manager->register_setting(
		'vin_number',
		array( 'sanitize_callback' => 'wp_filter_nohtml_kses' )
	);

	$manager->register_setting(
		'city_mpg',
		array( 'sanitize_callback' => 'wp_filter_nohtml_kses' )
	);

	$manager->register_setting(
		'highway_mpg',
		array( 'sanitize_callback' => 'wp_filter_nohtml_kses' )
	);

	$manager->register_setting(
		'home_charge_time',
		array( 'sanitize_callback' => 'wp_filter_nohtml_kses' )
	);

	$manager->register_setting(
		'fast_charge_time',
		array( 'sanitize_callback' => 'wp_filter_nohtml_kses' )
	);

	$manager->register_setting(
		'registration_date',
		array( 'sanitize_callback' => 'wp_filter_nohtml_kses' )
	);

	$manager->register_setting(
		'history',
		array(
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		)
	);

	$manager->register_setting(
		'history_link',
		array(
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		)
	);

	$manager->register_setting(
		'certified_logo_1',
		array( 'sanitize_callback' => 'stm_listings_validate_image' )
	);

	$manager->register_setting(
		'certified_logo_2_link',
		array(
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		)
	);

	$manager->register_setting(
		'certified_logo_2',
		array( 'sanitize_callback' => 'stm_listings_validate_image' )
	);

	$manager->register_setting(
		'car_brochure',
		array( 'sanitize_callback' => 'stm_listings_validate_image' )
	);

	$manager->register_setting(
		'additional_features',
		array( 'sanitize_callback' => 'stm_listings_validate_repeater' )
	);

	$manager->register_setting(
		'listing_specifications',
		array( 'sanitize_callback' => 'stm_listings_validate_repeater_specifications' )
	);

	/*Features*/
	$options = get_option( 'stm_vehicle_listing_options' );

	if ( ! empty( $options ) ) {
		$args = array(
			'orderby'    => 'name',
			'order'      => 'ASC',
			'hide_empty' => false,
			'fields'     => 'all',
			'pad_counts' => false,
		);

		/*Add multiselects*/
		foreach ( $options as $key => $option ) {

			if ( 'price' === $option['slug'] || ( stm_is_multilisting() && isset( $option['listing_price_field'] ) && true === $option['listing_price_field'] ) ) {
				continue;
			}

			$terms       = get_terms( $option['slug'], $args );
			$single_term = array();

			foreach ( $terms as $tax_key => $taxonomy ) {
				if ( ! empty( $taxonomy ) ) {
					unset( $single_term[''] );
					$single_term[ $taxonomy->slug ] = $taxonomy->name;
				}
			}

			if ( empty( $option['numeric'] ) ) {
				$parent = array_key_exists( 'listing_taxonomy_parent', $option ) ? $option['listing_taxonomy_parent'] : '';
				$manager->register_control(
					$option['slug'],
					array(
						'type'    => 'multiselect',
						'section' => 'stm_features',
						'label'   => $option['plural_name'],
						'choices' => $single_term,
						'attr'    => array( 'data-parent' => $parent ),
					)
				);

				$manager->register_setting(
					$option['slug'],
					array(
						'sanitize_callback' => 'stm_listings_multiselect',
					)
				);
			} else { /*Add number fields*/
				$manager->register_control(
					$option['slug'],
					array(
						'type'    => 'text',
						'section' => 'stm_features',
						'label'   => $option['single_name'],
						'attr'    => array( 'class' => 'widefat' ),
					)
				);

				$manager->register_setting(
					$option['slug'],
					array(
						'sanitize_callback' => 'wp_filter_nohtml_kses',
					)
				);
			}
		}
	}
}

function stm_listings_sanitize_location_address( $value, $settings ) {
	stm_sanitize_location_address_update( $value, $settings->manager->post_id );

	return $value;
}

add_filter( 'butterbean_stm_car_manager_sanitize_stm_location_address', 'stm_listings_sanitize_location_address', 10, 2 );
