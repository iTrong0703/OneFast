<?php
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'stm_google_places_enable_script' ) ) {
	function stm_google_places_enable_script( $status = 'registered', $only_google_load = false ) {
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
				wp_register_script( 'stm_gmap', $google_api_map, null, '1.0', true );
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
				wp_register_script( 'stm-google-places', STM_LISTINGS_URL . '/assets/js/frontend/stm-google-places.js', array( 'jquery', 'stm_gmap', 'listings-filter' ), STM_LISTINGS_V, true );
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

add_action( 'stm_google_places_script', 'stm_google_places_enable_script' );

function stm_listings_add_car_script() {
	wp_register_style( 'motors-add-listing', STM_LISTINGS_URL . '/assets/css/frontend/add-listing.css', null, STM_LISTINGS_V );
	wp_register_script( 'motors-add-listing', STM_LISTINGS_URL . '/assets/js/frontend/add-listing.js', array( 'jquery', 'jquery-ui-droppable' ), STM_LISTINGS_V, true );

	$max_file_size = apply_filters( 'stm_listing_media_upload_size', 1024 * 4000 ); /* 4mb is the highest media upload here */
	$limits        = apply_filters(
		'stm_get_post_limits',
		array(
			'premoderation' => true,
			'posts_allowed' => 0,
			'posts'         => 0,
			'images'        => 0,
			'role'          => 'user',
		),
		get_current_user_id()
	);
	$crop          = apply_filters( 'motors_vl_get_nuxy_mod', false, 'user_image_crop_checkbox' );
	$width         = apply_filters( 'motors_vl_get_nuxy_mod', 800, 'user_image_crop_width' );
	$height        = apply_filters( 'motors_vl_get_nuxy_mod', 600, 'user_image_crop_height' );

	$_image_upload_script = "
        var stm_image_upload_settings = {
            messages: {
                ajax_error: '" . esc_html__( 'Some error occurred, try again later', 'stm_vehicles_listing' ) . "',
                wait_upload: '" . sprintf(
					/* translators: %s: uploading image dotted */
					esc_html__( 'Wait, uploading image%s', 'stm_vehicles_listing' ),
					'<strong class="stm-progress-bar__dotted"><span>.</span><span>.</span><span>.</span></strong>'
				) . "',
                format: '" . esc_html__( 'Sorry, you are trying to upload the wrong image format:', 'stm_vehicles_listing' ) . "',
                large: '" . esc_html__( 'Sorry, image is too large:', 'stm_vehicles_listing' ) . "',
                rendering: '" . sprintf(
					/* translators: %s: rendering image dotted */
					esc_html__( 'Wait, rendering image%s', 'stm_vehicles_listing' ),
					'<strong class="stm-progress-bar__dotted"><span>.</span><span>.</span><span>.</span></strong>'
				) . "',
                optimizing_image: '" . sprintf(
					/* translators: %s: optimized image dotted */
					esc_html__( 'Wait, the image is being optimized%s', 'stm_vehicles_listing' ),
					'<strong class="stm-progress-bar__dotted"><span>.</span><span>.</span><span>.</span></strong>'
				) . "',
                limit: '" . sprintf(
					/* translators: %d: images limit */
					esc_html__( 'Sorry, you can upload only %d images per add', 'stm_vehicles_listing' ),
					$limits['images']
				) . "'
            },
            size: '" . $max_file_size . "',
            upload_limit: {
                max: '" . absint( $limits['images'] ) . "',
            },
            cropping: {
                enable: '" . $crop . "',
                width: '" . $width . "',
                height: '" . $height . "',
            }
        }
    ";

	wp_add_inline_script( 'motors-add-listing', $_image_upload_script, 'before' );

	//Progressbar
	wp_register_style( 'progress', STM_LISTINGS_URL . '/assets/css/progress.css', array( 'motors-add-listing' ), STM_LISTINGS_V );
	wp_register_script( 'progressbar-layui', STM_LISTINGS_URL . '/assets/js/progressbar/layui.min.js', array( 'jquery', 'motors-add-listing' ), STM_LISTINGS_V, true );
	wp_register_script( 'progressbar', STM_LISTINGS_URL . '/assets/js/progressbar/jquery-progress-lgh.js', array( 'progressbar-layui' ), STM_LISTINGS_V, true );
}

add_action( 'stm_listings_add_car_script', 'stm_listings_add_car_script' );

function stm_listings_enqueue_scripts_styles() {

	if ( defined( 'STM_WPCFTO_URL' ) ) {
		$v      = time();
		$assets = STM_WPCFTO_URL . 'metaboxes/assets';

		wp_enqueue_style( 'font-awesome-min', $assets . '/vendors/font-awesome.min.css', null, $v );
		wp_enqueue_script( 'wpcfto_metaboxes.js', $assets . 'js/metaboxes.js', array( 'vue.js' ), $v, true );
	}

	wp_enqueue_style( 'motors-icons', STM_LISTINGS_URL . '/assets/css/frontend/icons.css', array(), STM_LISTINGS_V );
	wp_enqueue_style( 'owl.carousel', STM_LISTINGS_URL . '/assets/css/frontend/owl.carousel.min.css', array(), STM_LISTINGS_V );
	wp_enqueue_style( 'bootstrap-grid', STM_LISTINGS_URL . '/assets/css/frontend/grid.css', array(), STM_LISTINGS_V );
	wp_enqueue_style( 'listings-frontend', STM_LISTINGS_URL . '/assets/css/frontend/frontend_styles.css', array(), STM_LISTINGS_V );
	wp_enqueue_style( 'light-gallery', STM_LISTINGS_URL . '/assets/css/frontend/lightgallery.min.css', array(), STM_LISTINGS_V );
	wp_enqueue_style( 'modal-bootstrap', STM_LISTINGS_URL . '/assets/css/bootstrap/bootstrap.min.css', array(), STM_LISTINGS_V );
	wp_register_style( 'motors-datetimepicker', STM_LISTINGS_URL . '/assets/css/motors-datetimepicker.css', null, STM_LISTINGS_V );
	wp_enqueue_style( 'jquery-ui', STM_LISTINGS_URL . '/assets/css/jquery-ui.css', null, STM_LISTINGS_V );
	wp_enqueue_style( 'modal-style', STM_LISTINGS_URL . '/assets/css/modal-style.css', array(), STM_LISTINGS_V );
	wp_enqueue_style( 'stm-icon-font', STM_LISTINGS_URL . '/assets/css/frontend/stm-ico-style.css', array(), STM_LISTINGS_V );
	wp_enqueue_style( 'horizontal-filter', STM_LISTINGS_URL . '/assets/css/frontend/horizontal-filter.css', null, STM_LISTINGS_V );
	wp_enqueue_style( 'motors-style', STM_LISTINGS_URL . '/assets/css/style.css', null, STM_LISTINGS_V );
	wp_register_style( 'stmselect2', STM_LISTINGS_URL . '/assets/css/frontend/select2.min.css', null, STM_LISTINGS_V );
	wp_register_style( 'bootstrap', STM_LISTINGS_URL . '/assets/css/bootstrap/main.css', null, STM_LISTINGS_V );
	wp_register_style( 'swiper', STM_LISTINGS_URL . '/assets/css/swiper-carousel/swiper-bundle.min.css', null, STM_LISTINGS_V );
	wp_register_style( 'app-select2', STM_LISTINGS_URL . '/assets/css/frontend/app-select2.css', null, STM_LISTINGS_V );
	wp_register_style( 'items-per-page', STM_LISTINGS_URL . '/assets/css/frontend/items-per-page.css', null, STM_LISTINGS_V );
	wp_register_style( 'inventory-view-type', STM_LISTINGS_URL . '/assets/css/frontend/inventory-view-type.css', null, STM_LISTINGS_V );
	wp_register_style( 'loop-list', STM_LISTINGS_URL . '/assets/css/frontend/loop-list.css', null, STM_LISTINGS_V );
	wp_register_style( 'loop-grid', STM_LISTINGS_URL . '/assets/css/frontend/loop-grid.css', null, STM_LISTINGS_V );
	wp_register_style( 'sell-a-car-form', STM_LISTINGS_URL . '/assets/css/frontend/sell-a-car-form.css', null, STM_LISTINGS_V );
	wp_register_style( 'listing-icon-filter', STM_LISTINGS_URL . '/assets/css/frontend/listing_icon_filter.css', null, STM_LISTINGS_V );
	wp_register_style( 'listings-tabs', STM_LISTINGS_URL . '/assets/css/frontend/listings-tabs.css', null, STM_LISTINGS_V );
	wp_register_style( 'listing-search', STM_LISTINGS_URL . '/assets/css/frontend/listing-search.css', null, STM_LISTINGS_V );
	wp_register_style( 'motors-single-listing', STM_LISTINGS_URL . '/assets/css/frontend/single-listing.css', null, STM_LISTINGS_V );
	wp_register_style( 'inventory', STM_LISTINGS_URL . '/assets/css/frontend/inventory.css', null, STM_LISTINGS_V );

	wp_enqueue_script( 'jquery', false, array(), STM_LISTINGS_V, false );
	wp_enqueue_script( 'jquery-migrate', false, array(), STM_LISTINGS_V, false );
	wp_enqueue_script( 'jquery-ui-effect', STM_LISTINGS_URL . '/assets/js/jquery-ui-effect.min.js', array(), STM_LISTINGS_V, false );
	wp_register_script( 'stm-cascadingdropdown', STM_LISTINGS_URL . '/assets/js/frontend/jquery.cascadingdropdown.js', array(), STM_LISTINGS_V, false );
	wp_enqueue_script( 'bootstrap-tab', STM_LISTINGS_URL . '/assets/js/bootstrap/tab.js', array( 'jquery' ), STM_LISTINGS_V, true );
	wp_enqueue_script( 'bootstrap', STM_LISTINGS_URL . '/assets/js/bootstrap/bootstrap.min.js', array( 'jquery' ), STM_LISTINGS_V, true );
	wp_enqueue_script( 'jquery-cookie', STM_LISTINGS_URL . '/assets/js/frontend/jquery.cookie.js', array( 'jquery' ), STM_LISTINGS_V, true );
	wp_register_script( 'lazyload', STM_LISTINGS_URL . '/assets/js/frontend/lazyload.js', array( 'jquery' ), STM_LISTINGS_V, true );
	wp_register_script( 'swiper', STM_LISTINGS_URL . '/assets/js/swiper-carousel/swiper-bundle.min.js', array( 'jquery' ), STM_LISTINGS_V, true );
	wp_register_script( 'stmselect2', STM_LISTINGS_URL . '/assets/js/frontend/select2.full.min.js', array( 'jquery' ), STM_LISTINGS_V, true );
	wp_register_script( 'app-select2', STM_LISTINGS_URL . '/assets/js/frontend/app-select2.js', 'stmselect2', STM_LISTINGS_V, true );
	wp_register_script( 'listing-icon-filter', STM_LISTINGS_URL . '/assets/js/frontend/listing_icon_filter.js', array( 'jquery' ), STM_LISTINGS_V, true );
	wp_register_script( 'listings-tabs', STM_LISTINGS_URL . '/assets/js/frontend/listings-tabs.js', array( 'jquery' ), STM_LISTINGS_V, true );
	wp_register_script( 'listing-search', STM_LISTINGS_URL . '/assets/js/frontend/listing-search.js', array( 'jquery' ), STM_LISTINGS_V, true );
	wp_enqueue_script( 'owl.carousel', STM_LISTINGS_URL . '/assets/js/frontend/owl.carousel.js', array( 'jquery' ), STM_LISTINGS_V, true );
	wp_enqueue_script( 'light-gallery', STM_LISTINGS_URL . '/assets/js/frontend/lightgallery-all.js', array( 'jquery' ), STM_LISTINGS_V, true );
	wp_enqueue_script( 'chart-js', STM_LISTINGS_URL . '/assets/js/frontend/chart.min.js', array( 'jquery' ), STM_LISTINGS_V, true );
	wp_register_script( 'uniform', STM_LISTINGS_URL . '/assets/js/frontend/jquery.uniform.min.js', array( 'jquery' ), STM_LISTINGS_V, true );
	wp_register_script( 'motors-datetimepicker', STM_LISTINGS_URL . '/assets/js/motors-datetimepicker.js', array( 'jquery' ), STM_LISTINGS_V, true );

	wp_enqueue_script(
		'listings-init',
		STM_LISTINGS_URL . '/assets/js/frontend/init.js',
		array(
			'jquery',
			'jquery-ui-slider',
		),
		STM_LISTINGS_V,
		true
	);
	wp_enqueue_script( 'mlv-plugin-scripts', STM_LISTINGS_URL . '/assets/js/frontend/plugin.js', array( 'listings-init' ), STM_LISTINGS_V, true );
	wp_enqueue_script( 'listings-filter', STM_LISTINGS_URL . '/assets/js/frontend/filter.js', array( 'listings-init', 'stmselect2' ), STM_LISTINGS_V, true );
	wp_enqueue_script( 'app-ajax', STM_LISTINGS_URL . '/assets/js/frontend/app-ajax.js', array( 'jquery' ), STM_LISTINGS_V, true );
	$inline_script_recaptcha = "var onloadRecaptchaCallback = function() {
        var submitButton = document.querySelector('.stm-login-register-form .stm-register-form form input[type=\"submit\"]');
        if (submitButton) {
            submitButton.setAttribute('disabled', '1');
        }
    };";
	wp_add_inline_script( 'app-ajax', $inline_script_recaptcha );
	wp_enqueue_script( 'isotope', STM_LISTINGS_URL . '/assets/js/isotope.pkgd.min.js', array( 'jquery', 'imagesloaded' ), STM_LISTINGS_V, true );
	wp_register_script( 'items-per-page', STM_LISTINGS_URL . '/assets/js/frontend/items-per-page.js', array( 'jquery' ), STM_LISTINGS_V, true );
	wp_register_script( 'inventory-view-type', STM_LISTINGS_URL . '/assets/js/frontend/inventory-view-type.js', array( 'jquery' ), STM_LISTINGS_V, true );
	wp_register_script( 'sell-a-car-form', STM_LISTINGS_URL . '/assets/js/sell-a-car-form.js', array( 'jquery' ), STM_LISTINGS_V, true );
	wp_register_script( 'motors-single-listing', STM_LISTINGS_URL . '/assets/js/frontend/single-listing.js', null, STM_LISTINGS_V, true );

	if ( apply_filters( 'motors_vl_get_nuxy_mod', false, 'gallery_hover_interaction' ) ) {
		wp_enqueue_style( 'brazzers-carousel', STM_LISTINGS_URL . '/assets/css/frontend/brazzers-carousel.min.css', array(), STM_LISTINGS_V );
		wp_enqueue_script( 'brazzers-carousel', STM_LISTINGS_URL . '/assets/js/frontend/brazzers-carousel.min.js', array( 'jquery' ), STM_LISTINGS_V, true );
		wp_enqueue_script( 'hoverable-gallery', STM_LISTINGS_URL . '/assets/js/frontend/hoverable-gallery.js', array( 'jquery' ), STM_LISTINGS_V, true );
		wp_enqueue_style( 'hoverable-gallery', STM_LISTINGS_URL . '/assets/css/frontend/hoverable-gallery.css', array(), STM_LISTINGS_V );
	}

	wp_localize_script(
		'listings-init',
		'stm_i18n',
		array(
			'stm_label_add'                     => __( 'Add to compare', 'stm_vehicles_listing' ),
			'stm_label_remove'                  => __( 'Remove from compare', 'stm_vehicles_listing' ),
			'stm_label_remove_list'             => __( 'Remove from list', 'stm_vehicles_listing' ),
			'stm_label_in_compare'              => __( 'In compare list', 'stm_vehicles_listing' ),
			'remove_from_compare'               => __( 'Remove from compare', 'stm_vehicles_listing' ),
			'stm_already_added_to_compare_text' => __( 'You have already added 3 cars', 'stm_vehicles_listing' ),
			'remove_from_favorites'             => __( 'Remove from favorites', 'stm_vehicles_listing' ),
			'add_to_favorites'                  => __( 'Add to favorites', 'stm_vehicles_listing' ),
			'motors_vl_config'                  => array(
				'enable_friendly_urls' => apply_filters( 'motors_vl_get_nuxy_mod', false, 'friendly_url' ),
			),
		)
	);

	/* Add a car */
	do_action( 'stm_listings_add_car_script' );

	/* Google places */
	do_action( 'stm_google_places_script' );

	if ( defined( 'ELEMENTOR_VERSION' ) ) {
		if ( Elementor\Plugin::$instance->editor->is_edit_mode() || Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			wp_add_inline_script( 'listings-init', 'var stm_elementor_editor_mode = true' );
		}
	}
}

add_action( 'wp_enqueue_scripts', 'stm_listings_enqueue_scripts_styles' );

if ( ! function_exists( 'init_motors_root_colors' ) ) {
	function init_motors_root_colors() {
		$primary_color        = '#cc6119';
		$secondary_color      = '#6c98e1';
		$secondary_color_dark = '#5a7db6';
		$third_color          = '#232628'; //'#153e4d';
		$fourth_color         = '#153e4d';

		$colors_css = '
			:root{
				--motors-default-base-color: #cc6119;
				--motors-default-secondary-color: #6c98e1;
				--motors-base-color: #cc6119;
				--motors-secondary-color: #6c98e1;
				--mvl-primary-color: ' . $primary_color . ';
				--mvl-secondary-color: ' . $secondary_color . ';
				--mvl-secondary-color-dark: ' . $secondary_color_dark . ';
				--mvl-third-color: ' . $third_color . ';
				--mvl-fourth-color: ' . $fourth_color . ';
			}
		';

		wp_add_inline_style( 'motors-style', $colors_css );
	}
}

add_action( 'wp_enqueue_scripts', 'init_motors_root_colors' );

if ( ! function_exists( 'mvl_enqueue_header_scripts_styles' ) ) {
	function mvl_enqueue_header_scripts_styles( $file_name ) {
		if ( ! wp_style_is( $file_name, 'enqueued' ) ) {
			wp_enqueue_style( $file_name );
		}

		if ( ! wp_script_is( $file_name, 'enqueued' ) ) {
			wp_enqueue_script( $file_name );
		}
	}
}
