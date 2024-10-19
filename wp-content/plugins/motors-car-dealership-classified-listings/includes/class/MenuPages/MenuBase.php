<?php


namespace MotorsVehiclesListing\MenuPages;

use MotorsVehiclesListing\MenuPages\MenuBuilder;

abstract class MenuBase {

	/**
	 * @var string
	 */
	private $assets_url = STM_LISTINGS_URL . '/includes/class/Plugin/assets/img/';

	/**
	 * @var string
	 */
	protected $parent_menu_slug = 'mvl_plugin_settings';

	/**
	 * @var string
	 */
	public static $disabled_pro_text = '';

	/**
	 * @var string
	 */
	public static $pro_plans_url = '';

	/**
	 * @var string
	 */
	public $motors_favicon;

	/**
	 * @var string
	 */
	public $motors_logo;

	/**
	 * @var string
	 */
	public $nuxy_option_name;

	/**
	 * @var string
	 */
	public $nuxy_title;

	/**
	 * @var string
	 */
	public $nuxy_subtitle;

	/**
	 * @var string
	 */
	public $nuxy_menu_slug;

	/**
	 * @var integer
	 */
	public $menu_position;

	/**
	 * @var array
	 */
	public $nuxy_opts;

	public function __construct() {

		self::$disabled_pro_text = esc_html__( 'Please enable Motors Pro Plugin', 'stm_vehicles_listing' );
		self::$pro_plans_url     = admin_url( 'admin.php?page=mvl-go-pro' );

		$this->motors_favicon = $this->assets_url . 'icon.png';
		$this->motors_logo    = $this->assets_url . 'logo.png';

		add_action( 'init', array( $this, 'mvl_init_page' ) );

		if ( apply_filters( 'stm_disable_settings_setup', true ) ) {
			add_filter( 'wpcfto_options_page_setup', array( $this, 'mvl_menu_settings' ), 20, 1 );
		}
	}

	public function mvl_init_page() {
	}

	/**
	 * @description Load plugin configuration
	 * @return array
	 */
	public function mvl_menu_settings( $setup ) {
		$setup[] = array(
			'option_name' => $this->nuxy_option_name,
			'title'       => $this->nuxy_title,
			'sub_title'   => $this->nuxy_subtitle,
			'logo'        => $this->motors_logo,
			'page'        => array(
				'parent_slug' => 'mvl_plugin_settings',
				'page_title'  => $this->nuxy_title,
				'menu_title'  => $this->nuxy_title,
				'menu_slug'   => $this->nuxy_menu_slug,
				'icon'        => '',
				'position'    => 4,
			),

			/*
			* And Our fields to display on a page. We use tabs to separate settings on groups.
			*/
			'fields'      => $this->nuxy_opts,
		);

		add_filter(
			'mvl_submenu_positions',
			function ( $positions ) {
				$positions[ $this->nuxy_menu_slug ] = $this->menu_position;

				return $positions;
			}
		);

		return $setup;
	}
}
