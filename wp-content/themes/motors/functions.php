<?php
$stm_token_option = get_site_option( 'stm_motors_token', [] );
$stm_token_option['token'] = 'activated';
update_site_option( 'stm_motors_token', $stm_token_option );
// Product Registration
define( 'MOTORS_THEME', true );
define( 'STM_THEME_NAME', 'Motors' );
define( 'STM_THEME_SLUG', 'motors' );
define( 'STM_THEME_CATEGORY', 'Car Dealer, Rental & Listing WordPress theme' );
define( 'STM_ENVATO_ID', '13987211' );
define( 'STM_TOKEN_OPTION', 'stm_motors_token' );
define( 'STM_TOKEN_CHECKED_OPTION', 'stm_motors_token_checked' );
define( 'STM_THEME_SETTINGS_URL', ( ! empty( get_option( 'stm_motors_chosen_template', '' ) ) ) ? 'wpcfto_motors_' . get_option( 'stm_motors_chosen_template', 'car_dealer' ) . '_settings' : 'stm-admin-demos' );
define( 'STM_GENERATE_TOKEN', 'https://docs.stylemixthemes.com/motors-theme-documentation/theme-activation' );
define( 'STM_SUBMIT_A_TICKET', 'https://support.stylemixthemes.com/tickets/new/support?item_id=12' );
define( 'STM_DEMO_SITE_URL', 'https://motors.stylemixthemes.com/' );
define( 'STM_DOCUMENTATION_URL', 'https://docs.stylemixthemes.com/motors-theme-documentation/' );
define( 'STM_CHANGELOG_URL', 'https://docs.stylemixthemes.com/motors-theme-documentation/changelog' );
define( 'STM_INSTRUCTIONS_URL', 'https://docs.stylemixthemes.com/motors-theme-documentation/theme-activation' );
define( 'STM_INSTALL_VIDEO_URL', 'https://www.youtube.com/watch?v=tJAVpV4l8wE&list=PL3Pyh_1kFGGD0Z7F5Ad7LT6xv5LLYFpWU&index=1&ab_channel=StylemixThemes' );
define( 'STM_VOTE_URL', 'https://stylemixthemes.cnflx.io/boards/motors-car-dealer-rental-classifieds' );
define( 'STM_BUY_ANOTHER_LICENSE', 'https://themeforest.net/item/motors-automotive-cars-vehicle-boat-dealership-classifieds-wordpress-theme/13987211' );
define( 'STM_VIDEO_TUTORIALS', 'https://www.youtube.com/playlist?list=PL3Pyh_1kFGGD0Z7F5Ad7LT6xv5LLYFpWU' );
define( 'STM_FACEBOOK_COMMUNITY', 'https://www.facebook.com/groups/motorstheme' );
define( 'STM_TEMPLATE_URI', get_template_directory_uri() );
define( 'STM_TEMPLATE_DIR', get_template_directory() );
define( 'STM_THEME_PREFIX', 'stm' );
define( 'STM_INC_PATH', get_template_directory() . '/inc' );
if ( ! defined( 'MOTORS_DEMO_SITE' ) ) {
	define( 'MOTORS_DEMO_SITE', false );
}

add_action(
	'current_screen',
	function () {
		$screen = get_current_screen();
		if ( stripos( $screen->base, 'page_transients-manager' ) !== false || stripos( $screen->base, 'page_stm-admin-system-status' ) !== false || stripos( $screen->base, 'page_tgmpa-install-plugins' ) !== false || 'themes' === $screen->base ) {
			return;
		}

		if ( is_admin() && class_exists( 'STM_Theme_Info' ) ) {
			$current_demo = apply_filters( 'stm_theme_demo_layout', '' );

			if ( ! empty( STM_Theme_Info::get_activation_token() ) && ! empty( $current_demo ) && class_exists( 'STM_TGM_Plugins' ) ) {
				$plugins = STM_TGM_Plugins::get_plugins_data( $current_demo );

				if ( is_array( $plugins ) && count( $plugins ) > 0 && array_key_exists( 'has_update', $plugins ) && count( $plugins['has_update'] ) > 0 ) {

					$pl = array_filter(
						$plugins['has_update'],
						function ( $plugin ) {
							if ( in_array( $plugin['slug'], array( 'motors-car-dealership-classified-listings', 'stm-motors-extends' ), true ) ) {
								return $plugin;
							}
						}
					);

					if ( count( $pl ) > 0 ) {
						set_transient( 'motors_check_core_plugin_update', true );
					} else {
						delete_transient( 'motors_check_core_plugin_update' );
					}
				}
			}
		}
	},
	10,
	1
);

add_action(
	'admin_notices',
	function () {
		$screen = get_current_screen();
		$check  = get_transient( 'motors_check_core_plugin_update' );

		if ( $check && 'motors_page_stm-admin-plugins' === $screen->base ) {
			echo '<div class="notice notice-warning __envato-market"><p>';
			echo sprintf( '<span class="dashicons dashicons-warning"></span><b style="padding-left: 10px;">%s</b>', esc_html__( 'Please update the plugins right below as well! It is essential to update these plugins for the theme to work properly.', 'motors' ) );
			echo '</p></div>';
		}
	},
	100,
	1
);

add_filter( 'stm_theme_enable_elementor', 'get_motors_theme_enable_elementor' );

function get_motors_theme_enable_elementor() {
	return true;
}

add_filter( 'stm_theme_default_layout', 'get_stm_theme_default_layout' );
function get_stm_theme_default_layout() {
	return 'car_dealer';
}

add_filter( 'stm_theme_default_layout_name', 'get_stm_theme_default_layout_name' );
function get_stm_theme_default_layout_name() {
	return 'car_dealer';
}

add_filter( 'stm_theme_demos', 'motors_get_demos' );
add_filter( 'stm_theme_demo_layout', 'get_stm_theme_demo_layout' );
add_filter( 'stm_theme_plugins', 'get_stm_theme_plugins' );
add_filter( 'stm_theme_layout_plugins', 'get_stm_theme_layout_plugins', 10, 1 );

function get_stm_theme_plugins() {
	return stm_require_plugins_popup( true );
}

function get_stm_theme_demo_layout( $default = '' ) {
	return get_option( 'stm_motors_chosen_template', $default );
}

if ( is_admin() && file_exists( get_template_directory() . '/admin/admin.php' ) ) {
	require_once get_template_directory() . '/admin/admin.php';
}

// Include path.
$inc_path = get_template_directory() . '/inc';

// Widgets path
$widgets_path = $inc_path . '/widgets';

require_once $inc_path . '/mixpanel/init.php';

require_once $inc_path . '/classes/STM_Custom_Colors_Helper.php';
// Custom code and theme main setups
require_once $inc_path . '/setup.php';

// will be removed from theme since 5.4.23
require_once $inc_path . '/deprecated-functions.php';

// Helpers
require_once $inc_path . '/helpers.php';

// Cron Settings
require_once $inc_path . '/cron.php';

// Enqueue scripts and styles for theme
require_once $inc_path . '/scripts_styles.php';

// Custom code for any outputs modifying
require_once $inc_path . '/custom.php';

// Required plugins for theme
require_once $inc_path . '/tgm/tgm-plugin-registration.php';

// Custom code for any outputs modifying with ajax relation
require_once $inc_path . '/stm-ajax.php';

// Custom code for filter output
require_once $inc_path . '/user-filter.php';

// modals
require_once $inc_path . '/modals.php';

// elementor-pro compatibility
require_once $inc_path . '/theme-builder-elementor-compatibility.php';

// value my car
if ( boolval( apply_filters( 'is_listing', array( 'listing', 'listing_two', 'listing_two_elementor', 'listing_three', 'listing_one_elementor', 'listing_three_elementor', 'listing_four_elementor' ) ) ) ) {
	require_once $inc_path . '/value_my_car/value_my_car.php';
}

// Custom code for woocommerce modifying

if ( stm_is_woocommerce_activated() ) {
	require_once $inc_path . '/woocommerce_setups.php';
}

if ( in_array( get_stm_theme_demo_layout(), array( 'car_rental', 'rental_two', 'car_rental_elementor' ), true ) ) {
	require_once $inc_path . '/woocommerce_setups_rental.php';
}

if ( class_exists( '\ANP\Popup\DefaultHooks' ) ) {
	add_action( 'anp_popup_items', array( \ANP\Popup\DefaultHooks::class, 'checkEnvatoPlugin' ), 10, 1 );
}

add_filter( 'wpcf7_autop_or_not', '__return_false' );

add_action( 'template_redirect', 'stm_redirect_from_loginregister' );
function stm_redirect_from_loginregister() {
	if ( is_user_logged_in() &&
		is_page() &&
		( get_the_ID() === intval( apply_filters( 'motors_vl_get_nuxy_mod', false, 'login_page' ) ) ) &&
		! user_can( get_current_user_id(), 'manage_options' ) ) {

		wp_safe_redirect( add_query_arg( array( 'page' => 'settings' ), stm_get_author_link( '' ) ) );
		exit;
	}
}
