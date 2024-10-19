<?php

namespace MotorsVehiclesListing\Plugin;

require_once STM_LISTINGS_PATH . '/includes/class/Plugin/settings_patch.php';

class Settings {

	private $assets_url = STM_LISTINGS_URL . '/includes/class/Plugin/assets/img/';

	public static $disabled_pro_text = '';
	public static $pro_plans_url     = '';

	public function __construct() {

		self::$disabled_pro_text = esc_html__( 'Please enable Motors Pro Plugin', 'stm_vehicles_listing' );
		self::$pro_plans_url     = admin_url( 'admin.php?page=mvl-go-pro' );

		add_action( 'init', array( $this, 'mvl_plugin_conf_autoload' ) );
		if ( apply_filters( 'stm_disable_settings_setup', true ) ) {
			add_action( 'wpcfto_after_settings_saved', array( $this, 'mvl_save_featured_as_term' ), 50, 2 );
			add_filter( 'wpcfto_options_page_setup', array( $this, 'mvl_settings' ) );
			add_action( 'stm_importer_done', array( $this, 'mlv_save_settings' ), 20, 1 );
			add_filter( 'wpcfto_icons_set', array( $this, 'icons_set_icon_picker' ) );
			add_action( 'wpcfto_screen_motors_vehicles_listing_plugin_settings_added', array( $this, 'mvl_add_submenus' ) );
			add_action( 'wpcfto_screen_motors_vehicles_listing_plugin_settings_added', array( $this, 'mvl_add_submenu_settings' ), 1000, 1 );
			add_action( 'wpcfto_screen_motors_vehicles_listing_plugin_settings_added', array( $this, 'mvl_add_submenu_upgrade' ), 1001, 1 );
		}
	}

	public function icons_set_icon_picker( $icon_set ) {
		$_icons = stm_get_cat_icons( 'motors-icons', true );

		if ( ! empty( $_icons ) ) {
			return array_merge( $icon_set, $_icons );
		}

		return $icon_set;
	}

	public function mvl_plugin_conf_autoload() {
		$config_map = array(
			'listing-settings',
			'listing-settings/general',
			'listing-settings/currency',
			'listing-settings/listing-card',
			'listing-settings/listing-card-certified-logo',
			'search-settings',
			'search-settings/filter-position',
			'search-settings/sorting',
			'search-settings/filter-features',
			'search-settings/general',
			'single-listing',
			'single-listing/general',
			'single-listing/single-listing-layout',
			'user-main',
			'user-settings/user-settings',
			'monetization',
			'pages',
			'pages-settings/pages-settings',
			'google-services',
			'google-services/recaptcha-settings',
		);

		if ( ! defined( 'STM_MOTORS_EXTENDS_PLUGIN_VERSION' ) || version_compare( STM_MOTORS_EXTENDS_PLUGIN_VERSION, '2.3.7' ) > 0 ) {
			$config_map = array_merge(
				$config_map,
				array(
					'pro/listing-settings/general',
					'pro/listing-settings/currency',
					'pro/listing-settings/listing-card',
					'pro/search-settings/filter-position',
					'pro/search-settings/sorting',
					'pro/search-settings/search',
					'pro/search-settings/filter-location',
					'pro/single-listing/general',
					'pro/single-listing/single-listing-layout',
					'pro/single-listing/loan-calculator',
					'pro/user-settings/user-main',
					'pro/user-settings/become-a-dealer',
					'pro/user-settings/dealer-settings',
					'pro/pages-settings/pages-settings',
					'pro/monetization/subscription-model',
					'pro/monetization/paid-submission',
					'pro/monetization/featured-settings',
					'pro/monetization/paypal-options',
					'pro/monetization/sell-online',
					'pro/google-services/google-maps',
				)
			);
		}

		if ( ! stm_is_motors_theme() ) {
			$config_map = array_merge(
				$config_map,
				array(
					'shortcodes',
					'shortcodes/shortcodes-list',
				)
			);
		}

		foreach ( $config_map as $file_name ) {
			require_once STM_LISTINGS_PATH . '/includes/class/Plugin/config/' . $file_name . '.php';
		}
	}

	public function mvl_settings( $setup ) {
		$opts = apply_filters( 'mvl_get_all_nuxy_config', array() );

		$motors_favicon = $this->assets_url . 'icon.png';
		$motors_logo    = $this->assets_url . 'logo.png';

		$setup[] = array(
			'option_name' => \MotorsVehiclesListing\Plugin\MVL_Const::MVL_PLUGIN_OPT_NAME,
			'title'       => esc_html__( 'Motors Plugin', 'stm_vehicles_listing' ),
			'sub_title'   => esc_html__( 'by StylemixThemes', 'stm_vehicles_listing' ),
			'logo'        => $motors_logo,

			/*
			* Next we add a page to display our awesome settings.
			* All parameters are required and same as WordPress add_menu_page.
			*/
			'page'        => array(
				'page_title' => 'Motors Plugin',
				'menu_title' => 'Motors Plugin',
				'menu_slug'  => 'mvl_plugin_settings',
				'icon'       => $motors_favicon,
				'position'   => 4,
			),

			/*
			* And Our fields to display on a page. We use tabs to separate settings on groups.
			*/
			'fields'      => $opts,
		);

		return $setup;
	}

	public function mvl_add_submenus() {

		$options = get_option( 'stm_post_types_options' );

		$post_types = array(
			'listings',
		);

		foreach ( $post_types as $post_type ) {
			$post_type_data = get_post_type_object( $post_type );

			if ( empty( $post_type_data ) ) {
				continue;
			}

			add_submenu_page(
				'mvl_plugin_settings',
				$post_type_data->label,
				$post_type_data->label,
				'manage_options',
				'/edit.php?post_type=' . $post_type,
				'',
				3
			);

			add_filter(
				'mvl_submenu_positions',
				function ( $positions ) use ( $post_type_data ) {
					$positions[ '/edit.php?post_type=' . $post_type_data->name ] = 3;

					return $positions;
				}
			);
		}

		//Add submenu for test_drive_request

		$test_drive_data = get_post_type_object( 'test_drive_request' );
		if ( ! empty( $test_drive_data ) ) {
			add_submenu_page(
				'mvl_plugin_settings',
				ucwords( $test_drive_data->label ),
				ucwords( $test_drive_data->label ),
				'manage_options',
				'/edit.php?post_type=' . $test_drive_data->name,
				'',
				10
			);

			add_filter(
				'mvl_submenu_positions',
				function ( $positions ) use ( $test_drive_data ) {
					$positions[ 'edit.php?post_type=' . $test_drive_data->name ] = 20;

					return $positions;
				}
			);
		}
	}

	public function mvl_add_submenu_settings() {
		add_submenu_page(
			'mvl_plugin_settings',
			esc_html__( 'Settings', 'stm_vehicles_listing' ),
			'<span class="mvl-settings-menu-title">' . esc_html__( 'Settings', 'stm_vehicles_listing' ) . '</span>',
			'manage_options',
			'mvl_plugin_settings',
			'',
			100
		);

		/* phpcs:disable */
		/*add_submenu_page(
			'mvl_plugin_settings',
			__( 'Pro Addons', 'stm_vehicles_listing' ),
			'<span class="mvl-addons-menu"><span class="mvl-addons-pro">PRO</span> <span class="mvl-addons-text">'
			. __( 'Addons', 'stm_vehicles_listing' ) . '</span></span>',
			'manage_options',
			'stm-addons',
			array( $this, 'addons_page' ),
		);*/
		/* phpcs:enable */
	}

	public function mvl_add_submenu_upgrade() {
		if ( ! is_mvl_pro() && ! stm_is_motors_theme() ) {
			add_submenu_page(
				'mvl_plugin_settings',
				__( 'Upgrade', 'stm_vehicles_listing' ),
				'<span class="mvl-unlock-pro-btn"><span class="mvl-unlock-wrap-span">' . __( 'Unlock PRO', 'stm_vehicles_listing' ) . '</span></span>',
				'manage_options',
				'mvl-go-pro',
				array( $this, 'mvl_render_go_pro' ),
				5000
			);
		}
	}

	public function mvl_render_go_pro() {
		wp_enqueue_style( 'mvl_go_pro', STM_LISTINGS_URL . 'assets/css/admin_button_gopro.css', null, STM_LISTINGS_V );

		require_once STM_LISTINGS_PATH . '/templates/button-go-pro.php';
	}

	public function addons_page() {

	}

	public function mvl_save_featured_as_term( $id, $settings ) {

		if ( array_key_exists( 'addl_user_features', $settings ) ) {
			foreach ( $settings['addl_user_features'] as $addl_user_feature ) {
				if ( ! empty( $addl_user_feature['tab_title_labels'] ) ) {
					$feature_list = explode( ',', $addl_user_feature['tab_title_labels'] );

					foreach ( $feature_list as $item ) {
						wp_insert_term( trim( $item ), 'stm_additional_features' );
					}
				}
			}
		}
	}

	public function mlv_save_settings() {
		$layout         = get_option( 'stm_motors_chosen_template', '' );
		$theme_settings = get_option( 'wpcfto_motors_' . $layout . '_settings', array() );

		update_option( 'motors_vehicles_listing_plugin_settings_updated', true );
		update_option( 'motors_vehicles_listing_section_settings_updated', true );
		update_option( \MotorsVehiclesListing\Plugin\MVL_Const::MVL_PLUGIN_OPT_NAME, $theme_settings );

		if ( ! empty( $theme_settings ) ) {
			$add_car_form_settings_map     = wpcfto_get_settings_map( 'settings', \MotorsVehiclesListing\Plugin\MVL_Const::ADD_CAR_FORM_OPT_NAME );
			$filter_settings_map           = wpcfto_get_settings_map( 'settings', \MotorsVehiclesListing\Plugin\MVL_Const::FILTER_OPT_NAME );
			$listing_details_settings_map  = wpcfto_get_settings_map( 'settings', \MotorsVehiclesListing\Plugin\MVL_Const::LISTING_DETAILS_OPT_NAME );
			$search_result_settings_map    = wpcfto_get_settings_map( 'settings', \MotorsVehiclesListing\Plugin\MVL_Const::SEARCH_RESULTS_OPT_NAME );
			$listing_template_settings_map = wpcfto_get_settings_map( 'settings', \MotorsVehiclesListing\Plugin\MVL_Const::LISTING_TEMPLATE_OPT_NAME );

			if ( ! empty( $add_car_form_settings_map ) ) {
				update_option( \MotorsVehiclesListing\Plugin\MVL_Const::ADD_CAR_FORM_OPT_NAME, array_intersect_key( $theme_settings, $add_car_form_settings_map['add_listing']['fields'] ) );
			}

			if ( ! empty( $filter_settings_map ) ) {
				update_option( \MotorsVehiclesListing\Plugin\MVL_Const::FILTER_OPT_NAME, array_intersect_key( $theme_settings, $filter_settings_map['search_settings']['fields'] ) );
			}

			if ( ! empty( $listing_details_settings_map ) ) {
				update_option( \MotorsVehiclesListing\Plugin\MVL_Const::LISTING_DETAILS_OPT_NAME, array_intersect_key( $theme_settings, $listing_details_settings_map['single_listing']['fields'] ) );
			}

			if ( ! empty( $search_result_settings_map ) ) {
				update_option( \MotorsVehiclesListing\Plugin\MVL_Const::SEARCH_RESULTS_OPT_NAME, array_intersect_key( $theme_settings, $search_result_settings_map['listing_settings']['fields'] ) );
			}

			if ( ! empty( $listing_template_settings_map ) ) {
				update_option( \MotorsVehiclesListing\Plugin\MVL_Const::LISTING_TEMPLATE_OPT_NAME, array_intersect_key( $theme_settings, $listing_template_settings_map['single_listing_template']['fields'] ) );
			}

			update_option( 'motors_vehicles_listing_section_settings_updated', true );
		}
	}
}
