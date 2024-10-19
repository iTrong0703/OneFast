<?php
namespace MotorsVehiclesListing\Features;

class MultiplePlan {

	public static $currentUser;
	private static $wpdbObj;
	private static $plansMeta;
	private static $isMultiple = false;

	public function __construct() {
		global $wpdb;

		/*
		* TODO
		* 'Subscriptio_User' will be removed
		 */

		$subscription_option = ( class_exists( 'Subscriptio' ) ) ? get_option( 'subscriptio_options', '' ) : get_option( 'rp_sub_settings', '' );

		if ( ( class_exists( 'Subscriptio' ) && ! empty( $subscription_option['subscriptio_multiproduct_subscription'] ) && $subscription_option['subscriptio_multiproduct_subscription'] ) || ( ! empty( $subscription_option[1] ) && 'multiple_subscriptions' === $subscription_option[1]['multiple_product_checkout'] ) ) {
			self::$isMultiple = true;
		}

		self::$currentUser = get_current_user_id();

		self::$wpdbObj = $wpdb;
		self::createTable();

		add_action( 'init', array( $this, 'buildPlansMeta' ) );
		add_action( 'init', array( $this, 'disableExpiredListings' ) );

		add_filter( 'stm_user_restrictions', array( $this, 'user_restrictions' ), 10, 2 );
	}

	private function createTable() {
		$charset_collate = self::$wpdbObj->get_charset_collate();
		$table_name      = self::$wpdbObj->prefix . 'multiple_plans_meta';

		if ( self::$wpdbObj->get_var( "SHOW TABLES LIKE '$table_name'" ) !== $table_name ) {

			$sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            starttime TIMESTAMP,
            endtime TIMESTAMP,
            user_id INT NOT NULL,
            plan_id TEXT NOT NULL,
            listing_id INT NOT NULL,
            listing_status TEXT NOT NULL,
            PRIMARY KEY  (id)
          ) $charset_collate;";

			require_once ABSPATH . 'wp-admin/includes/upgrade.php';
			dbDelta( $sql );
		}
	}

	public function buildPlansMeta() {
		$defaultUserQuota    = ( ! apply_filters( 'motors_vl_get_nuxy_mod', false, 'free_listing_submission' ) ) ? 0 : intval( apply_filters( 'motors_vl_get_nuxy_mod', 3, 'user_post_limit' ) );
		$defaultUserImgQuota = ( ! apply_filters( 'motors_vl_get_nuxy_mod', false, 'free_listing_submission' ) ) ? 0 : intval( apply_filters( 'motors_vl_get_nuxy_mod', 5, 'user_post_images_limit' ) );
		$dealer              = apply_filters( 'mvl_get_user_role', false, self::$currentUser );

		if ( $dealer ) {
			$defaultUserQuota    = ( ! apply_filters( 'motors_vl_get_nuxy_mod', false, 'dealer_free_listing_submission' ) ) ? 0 : intval( apply_filters( 'motors_vl_get_nuxy_mod', 50, 'dealer_post_limit' ) );
			$defaultUserImgQuota = ( ! apply_filters( 'motors_vl_get_nuxy_mod', false, 'dealer_free_listing_submission' ) ) ? 0 : intval( apply_filters( 'motors_vl_get_nuxy_mod', 10, 'dealer_post_images_limit' ) );
		}

		$totalQuota = $defaultUserQuota;

		self::$plansMeta = array(
			'plans' => array(
				array(
					'plan_id'     => 'free',
					'label'       => esc_html__( 'Free', 'stm_vehicles_listing' ),
					'total_quota' => $defaultUserQuota,
					'used_quota'  => self::getUsedQuotaByPlanId( 'free' ),
					'img_quota'   => $defaultUserImgQuota,
				),
			),
		);

		if ( self::$currentUser && ( class_exists( 'Subscriptio_User' ) || class_exists( 'RP_SUB' ) ) ) {
			/*
			 * TODO
			 * 'Subscriptio_User' will be removed
			 */
			$user_subscriptions = ( class_exists( 'Subscriptio_User' ) ) ? \Subscriptio_User::find_subscriptions( true, self::$currentUser ) : subscriptio_get_customer_subscriptions( self::$currentUser );

			if ( $user_subscriptions ) {

				$statuses = array( 'active', 'trial' );

				foreach ( $user_subscriptions as $user_subscription ) {

					if ( ! $user_subscription || ( ! class_exists( 'Subscriptio_User' ) && empty( $user_subscription->get_initial_order() ) ) ) {
						continue;
					}

					$status = ( class_exists( 'Subscriptio_User' ) ) ? $user_subscription->status : $user_subscription->get_status();

					if ( ! in_array( $status, $statuses, true ) ) {
						continue;
					}

					if ( class_exists( 'Subscriptio_User' ) ) {
						$plan_name  = ( ! empty( $user_subscription->products_multiple ) ) ? $user_subscription->products_multiple[0]['product_name'] : $user_subscription->product_name;
						$subs_id    = $user_subscription->id;
						$product_id = $user_subscription->product_id;

						if ( empty( $product_id ) && ! empty( $user_subscription->products_multiple ) && is_array( $user_subscription->products_multiple ) ) {
							$products = $user_subscription->products_multiple;
							if ( ! empty( $products[0] ) && ! empty( $products[0]['product_id'] ) ) {
								$product_id = $products[0]['product_id'];
							}
						}
					} else {
						$initialOrder = $user_subscription->get_initial_order()->get_data();
						$key          = key( $initialOrder['line_items'] );
						$orderData    = $initialOrder['line_items'][ $key ]->get_data();
						$plan_name    = $orderData['name'];
						$subs_id      = $user_subscription->get_id();
						$product_id   = $orderData['product_id'];
					}

					$post_limit  = intval( get_post_meta( $product_id, 'stm_price_plan_quota', true ) );
					$image_limit = intval( get_post_meta( $product_id, 'stm_price_plan_media_quota', true ) );
					$totalQuota  = $totalQuota + $post_limit;

					self::$plansMeta['plans'][] = array(
						'plan_id'     => $subs_id,
						'label'       => $plan_name,
						'total_quota' => $post_limit,
						'used_quota'  => self::getUsedQuotaByPlanId( $subs_id ),
						'img_quota'   => $image_limit,
					);
				}
			}
		}

		self::$plansMeta['total_quota'] = $totalQuota;
	}

	public function disableExpiredListings() {
		// NOTE: listings are being expired by stm_move_draft_over_limit() hooked to
		// 'subscriptio_status_changed' and 'subscriptio_subscription_status_changed' actions.
	}

	private function getUsedQuotaByPlanId( $plan_id ) {
		if ( 'free' === $plan_id ) {
			$plan_id = 0;
		}

		$user_id = intval( self::$currentUser );
		$result  = self::$wpdbObj->get_results( self::$wpdbObj->prepare( 'SELECT count(id) as usedQuota FROM ' . self::$wpdbObj->prefix . "multiple_plans_meta WHERE `plan_id` = %d AND `user_id` = %d AND `listing_status` = 'active' ", array( $plan_id, $user_id ) ) );

		return $result[0]->usedQuota;
	}

	public function existSlotByPlanId( $listing_id, $user_id ) {
		$table_name = self::$wpdbObj->prefix . 'multiple_plans_meta';
		$query      = self::$wpdbObj->prepare( "SELECT plan_id FROM $table_name WHERE listing_id = %d AND user_id = %d", $listing_id, $user_id );
		$result     = self::$wpdbObj->get_results( $query );

		$can_update = true;
		$plan_id    = ( ! empty( $result ) && count( $result ) > 0 ) ? intval( $result[0]->plan_id ) : null;

		if ( is_null( $plan_id ) ) {
			return true;
		}

		$active_listings    = intval( self::getUsedQuotaByPlanId( $plan_id ) );
		$user_subscriptions = self::getUserSubscriptions( $user_id );
		$user_free_posts    = ( ! apply_filters( 'motors_vl_get_nuxy_mod', false, 'free_listing_submission' ) ) ? 0 : intval( apply_filters( 'motors_vl_get_nuxy_mod', 3, 'user_post_limit' ) );
		$dealer             = apply_filters( 'mvl_get_user_role', false, $user_id );

		if ( $dealer ) {
			$user_free_posts = ( ! apply_filters( 'motors_vl_get_nuxy_mod', false, 'dealer_free_listing_submission' ) ) ? 0 : intval( apply_filters( 'motors_vl_get_nuxy_mod', 50, 'dealer_post_limit' ) );
		}

		if ( ! $plan_id && $user_free_posts === $active_listings ) {
			$can_update = false;
		} elseif ( ! empty( $user_subscriptions ) ) {
			$can_update = self::canUpdateBasedOnSubscriptions( $user_subscriptions, $plan_id, $active_listings );
		}

		return $can_update;
	}

	private function getUserSubscriptions( $user_id ) {
		if ( class_exists( 'Subscriptio_User' ) ) {
			return \Subscriptio_User::find_subscriptions( true, $user_id );
		} else {
			return subscriptio_get_customer_subscriptions( $user_id, false, 'active' );
		}
	}

	private function canUpdateBasedOnSubscriptions( $user_subscriptions, $plan_id, $active_listings ) {
		foreach ( $user_subscriptions as $subs ) {
			if ( $plan_id === $subs->get_id() ) {
				$initial_order = $subs->get_initial_order()->get_data();
				$key           = key( $initial_order['line_items'] );
				$order_data    = $initial_order['line_items'][ $key ]->get_data();
				$product_id    = $order_data['product_id'];
				$post_limit    = intval( get_post_meta( $product_id, 'stm_price_plan_quota', true ) );

				if ( $active_listings === $post_limit ) {
					return false;
				}
			}
		}

		return true;
	}

	public static function getListingIdsByPlanId( $plan_id, $user_id ) {
		global $wpdb;

		if ( 'free' === $plan_id ) {
			$plan_id = 0;
		}

		$user_id = ( empty( $user_id ) ) ? intval( self::$currentUser ) : $user_id;
		$result  = $wpdb->get_results( $wpdb->prepare( 'SELECT listing_id FROM ' . $wpdb->prefix . "multiple_plans_meta WHERE `plan_id` = %d AND `user_id` = %d AND `listing_status` != 'trash' ", array( $plan_id, $user_id ) ) );

		return $result;
	}

	public static function getCurrentPlan( $listing_id ) {
		global $wpdb;

		$result = $wpdb->get_var( $wpdb->prepare( 'SELECT plan_id FROM ' . $wpdb->prefix . 'multiple_plans_meta WHERE `user_id` = %d AND `listing_id` = %d', array( self::$currentUser, $listing_id ) ) );

		if ( ! empty( $result ) ) {
			return $result;
		}

		return null;
	}

	public static function deletePlanMeta( $ids ) {
		global $wpdb;

		$table_name = $wpdb->prefix . 'multiple_plans_meta';
		foreach ( explode( ',', $ids ) as $item ) {
			$wpdb->delete( $table_name, array( 'id' => $item ) );
		}
	}

	public static function checkPlanMeta( $userId, $listing_id ) {
		global $wpdb;

		$result = $wpdb->get_var( $wpdb->prepare( 'SELECT id FROM ' . $wpdb->prefix . 'multiple_plans_meta WHERE `user_id` = %d AND `listing_id` = %d', array( $userId, $listing_id ) ) );

		if ( ! empty( $result ) ) {
			return $result;
		}

		return null;
	}

	public static function addPlanMeta( $plan_id, $listing_id, $listingStatus ) {
		global $wpdb;

		$table_name = $wpdb->prefix . 'multiple_plans_meta';

		$wpdb->insert(
			$table_name,
			array(
				'starttime'      => strtotime( gmdate( 'Y-m-d H:i:s' ) ),
				'endtime'        => strtotime( gmdate( 'Y-m-d H:i:s' ) ),
				'user_id'        => self::$currentUser,
				'plan_id'        => $plan_id,
				'listing_id'     => $listing_id,
				'listing_status' => $listingStatus,
			),
			array( '%d', '%d', '%d', '%d', '%d', '%s' )
		);
	}

	public static function updatePlanMeta( $plan_id, $listing_id, $listingStatus ) {
		global $wpdb;
		$table_name = $wpdb->prefix . 'multiple_plans_meta';

		if ( self::checkPlanMeta( self::$currentUser, $listing_id ) ) {
			$wpdb->update(
				$table_name,
				array(
					'plan_id'        => $plan_id,
					'listing_status' => $listingStatus,
				),
				array(
					'user_id'    => self::$currentUser,
					'listing_id' => $listing_id,
				),
				array( '%s', '%s' ),
				array( '%d', '%d' )
			);
		} else {
			self::addPlanMeta( $plan_id, $listing_id, $listingStatus );
		}
	}

	public static function updateListingStatus( $listing_id, $listingStatus ) {
		global $wpdb;

		$table_name = $wpdb->prefix . 'multiple_plans_meta';

		if ( self::checkPlanMeta( self::$currentUser, $listing_id ) ) {

			$wpdb->update(
				$table_name,
				array(
					'listing_status' => $listingStatus,
				),
				array(
					'user_id'    => self::$currentUser,
					'listing_id' => $listing_id,
				),
				array( '%s', '%s' ),
				array( '%d', '%d' )
			);

		}
	}

	public function user_restrictions( $restriction, $userId ) {

		if ( self::$isMultiple ) {
			$restriction['posts_allowed'] = self::$plansMeta['total_quota'];
		}

		return $restriction;
	}

	public static function getUsedQuota( $plan_id ) {
		global $wpdb;

		$result = $wpdb->get_results( $wpdb->prepare( 'SELECT count(id) as usedQuota FROM ' . $wpdb->prefix . "multiple_plans_meta WHERE `plan_id` = %d AND `listing_status` = 'active' ", array( $plan_id ) ) );

		return $result[0]->usedQuota;
	}

	public static function isMultiplePlans() {
		return self::$isMultiple;
	}

	public static function getPlans() {
		return self::$plansMeta;
	}
}


