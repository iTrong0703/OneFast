<?php

namespace Motors_Elementor_Widgets_Free;

use \Elementor\Plugin;
use Motors_Elementor_Widgets_Free\Helpers\RegisterActions;

use Motors_Elementor_Widgets_Free\Widgets\WidgetManager\MotorsWidgetsManagerFree;


class MotorsElementorWidgetsFree {
	const WIDGET_CATEGORY                     = 'motors';
	const WIDGET_CATEGORY_TITLE               = 'Motors';
	const WIDGET_CATEGORY_SINGLE              = 'motors_single';
	const WIDGET_CATEGORY_TITLE_SINGLE        = 'Motors Single Listing';
	const WIDGET_CATEGORY_CLASSIFIED          = 'motors_classified';
	const WIDGET_CATEGORY_TITLE_CLASSIFIED    = 'Motors Classified';
	const WIDGET_CATEGORY_HEADER_FOOTER       = 'motors_header_footer';
	const WIDGET_CATEGORY_TITLE_HEADER_FOOTER = 'Motors Header Footer';
	const STM_PREFIX                          = 'motors';

	private static $widgets = array();

	private $modal;

	public function __construct() {
		self::$widgets = MotorsWidgetsManagerFree::getInstance()->stm_ew_get_all_registered_widgets();

		RegisterActions::init();

		add_action( 'elementor/widgets/register', array( self::class, 'motors_ew_register_elementor_widgets' ) );

		add_action( 'elementor/widget/before_render_content', array( $this, 'before_render_content' ) );

		add_action( 'elementor/elements/categories_registered', array( self::class, 'motors_ew_register_elementor_widget_categories' ) );

		add_filter( 'stm_ew_register_icons_tab', array( self::class, 'motors_ew_register_icons_tab' ), 20, 1 );

		add_action( 'admin_init', array( self::class, 'motors_ew_enqueue_scripts' ) );

		add_action( 'elementor/editor/before_enqueue_scripts', array( self::class, 'motors_ew_editor_enqueue_scripts' ) );

		if ( ! empty( $_REQUEST['action'] ) && 'elementor' === $_REQUEST['action'] && is_admin() ) {
			add_action( 'admin_action_elementor', array( self::class, 'motors_woocommerce_frontend_includes' ), 5 );
		}

		add_filter( 'elementor/document/urls/edit', array( $this, 'listing_template_edit_url' ) );
	}

	public function listing_template_edit_url( $url ) {
		if ( ! is_admin() ) {
			return $url;
		}

		$template_id = apply_filters( 'motors_vl_get_nuxy_mod', false, 'single_listing_template' );
		$template    = get_post( $template_id );
		$screen      = get_current_screen();

		if ( $template && is_a( $screen, 'WP_Screen' ) && in_array( $screen->post_type, apply_filters( 'stm_listings_multi_type', array( 'listings' ) ), true ) && current_user_can( 'edit_post', $template_id ) ) {
			$url = get_admin_url( null, 'post.php?post=' . $template->ID . '&action=elementor' );
		}

		return $url;
	}

	public function before_render_content( $widget ) {
		global $wp_query;

		$prefix = self::STM_PREFIX . '-single-listing-';

		$test_drive_controls = array(
			$prefix . 'gallery-carousel',
			$prefix . 'gallery',
			$prefix . 'gallery-mosaic',
		);

		if ( $prefix . 'trade-in' === $widget->get_name() ) {
			$wp_query->set( 'show_trade_in', true );
		} elseif ( in_array( $widget->get_name(), $test_drive_controls, true ) && 'yes' === $widget->get_settings( 'show_test_drive' ) ) {
			$wp_query->set( 'show_test_drive', true );
		} elseif ( $prefix . 'offer-price' === $widget->get_name() ) {
			$wp_query->set( 'show_offer_price', true );
		} elseif ( $prefix . 'actions' === $widget->get_name() ) {
			if ( 'yes' === $widget->get_settings( 'show_calculator' ) ) {
				$wp_query->set( 'show_calculator', true );
			}

			if ( 'yes' === $widget->get_settings( 'show_test_drive' ) ) {
				$wp_query->set( 'show_test_drive', true );
			}
		}
	}

	public static function motors_ew_enqueue_scripts() {
		wp_enqueue_style( 'motors-nuxy-general', STM_LISTINGS_URL . '/assets/elementor/css/wpcfto/wpcfto-general.css', array( 'stm-theme-admin-css' ), STM_LISTINGS_V, 'all' );
	}

	public static function motors_ew_editor_enqueue_scripts() {
		wp_enqueue_style( 'stm-elementor-icons', STM_LISTINGS_URL . '/assets/elementor/icons/style.css', array(), STM_LISTINGS_V );
		wp_enqueue_style( 'motors-elementor-editor', STM_LISTINGS_URL . '/assets/elementor/css/editor.css', array(), STM_LISTINGS_V );
	}

	public static function motors_ew_register_elementor_widget_categories() {
		Plugin::instance()->elements_manager->add_category(
			self::WIDGET_CATEGORY,
			array(
				'title' => self::WIDGET_CATEGORY_TITLE,
				'icon'  => '',
			)
		);

		Plugin::instance()->elements_manager->add_category(
			self::WIDGET_CATEGORY_SINGLE,
			array(
				'title' => self::WIDGET_CATEGORY_TITLE_SINGLE,
				'icon'  => '',
			)
		);

		Plugin::instance()->elements_manager->add_category(
			self::WIDGET_CATEGORY_CLASSIFIED,
			array(
				'title' => self::WIDGET_CATEGORY_TITLE_CLASSIFIED,
				'icon'  => '',
			)
		);

		Plugin::instance()->elements_manager->add_category(
			self::WIDGET_CATEGORY_HEADER_FOOTER,
			array(
				'title' => self::WIDGET_CATEGORY_TITLE_HEADER_FOOTER,
				'icon'  => '',
			)
		);
	}

	public static function motors_ew_register_elementor_widgets() {
		if ( count( self::$widgets ) > 0 ) {
			foreach ( self::$widgets as $widget_class ) {
				Plugin::instance()->widgets_manager->register( new $widget_class() );
			}
		}
	}

	public static function motors_ew_register_icons_tab( $tabs ) {
		$icon_conf = apply_filters( 'stm_motors_all_default_icons', array() );

		if ( ! empty( $icon_conf ) ) {
			foreach ( $icon_conf as $icons ) {
				$tabs[ $icons['handle'] ] = array(
					'name'          => $icons['handle'],
					'label'         => $icons['name'],
					'url'           => '',
					'enqueue'       => array( $icons['style_url'] ),
					'prefix'        => $icons['prefix'],
					'displayPrefix' => '',
					'labelIcon'     => $icons['label_icon'],
					'ver'           => $icons['v'],
					'fetchJson'     => $icons['charmap'],
				);
			}
		}

		return $tabs;
	}

	public static function motors_woocommerce_frontend_includes() {
		if ( class_exists( 'WooCommerce' ) ) {
			\WC()->frontend_includes();
			if ( is_null( \WC()->cart ) ) {
				global $woocommerce;
				$session_class        = apply_filters( 'woocommerce_session_handler', 'WC_Session_Handler' );
				$woocommerce->session = new $session_class();
				$woocommerce->session->init();
				$woocommerce->cart     = new \WC_Cart();
				$woocommerce->customer = new \WC_Customer( get_current_user_id(), true );
			}
		}
	}

	public static function motors_ew_plugin_activation() {

	}

	public static function motors_ew_plugin_deactivation() {

	}

	public static function motors_ew_plugin_uninstall() {

	}

	public static function motors_ew_get_all_pages() {
		$pages = get_pages();
		$pages = wp_list_pluck( $pages, 'post_title', 'ID' );

		return $pages;
	}
}
