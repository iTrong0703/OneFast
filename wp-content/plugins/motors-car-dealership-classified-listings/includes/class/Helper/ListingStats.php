<?php


namespace MotorsVehiclesListing\Helper;

class ListingStats {
	public function __construct() {
		add_action( 'wp', array( $this, 'stm_single_car_counter' ), 10, 1 );
	}

	public function stm_single_car_counter() {
		if ( is_singular( apply_filters( 'stm_listings_multi_type', array( 'listings' ) ) ) || is_singular( 'post' ) ) {
			$cookies = '';
			$post_id = get_the_ID();

			if ( empty( $_COOKIE['stm_car_watched'] ) ) {
				$cookies = $post_id;
				setcookie( 'stm_car_watched', $cookies, time() + ( 86400 * 30 ), '/' );
				$this->stm_increase_rating( $post_id );
			}

			if ( ! empty( $_COOKIE['stm_car_watched'] ) ) {
				$cookies = sanitize_text_field( $_COOKIE['stm_car_watched'] );
				$cookies = explode( ',', $cookies );

				if ( ! in_array( $post_id, $cookies ) ) { //phpcs:ignore
					$cookies[] = $post_id;

					$cookies = implode( ',', $cookies );

					$this->stm_increase_rating( $post_id );
					setcookie( 'stm_car_watched', $cookies, time() + ( 86400 * 30 ), '/' );
				}
			}
		}
	}

	public function stm_increase_rating( $post_id ) {
		// total views counter.
		$current_rating = intval( get_post_meta( $post_id, 'stm_car_views', true ) );
		if ( empty( $current_rating ) ) {
			update_post_meta( $post_id, 'stm_car_views', 1 );
		} else {
			$current_rating ++;
			update_post_meta( $post_id, 'stm_car_views', $current_rating );
		}

		// counter for statistics.
		$views_today = intval( get_post_meta( $post_id, 'car_views_stat_' . gmdate( 'Y-m-d' ), true ) );
		if ( empty( $views_today ) ) {
			update_post_meta( $post_id, 'car_views_stat_' . gmdate( 'Y-m-d' ), 1 );
		} else {
			$views_today ++;
			update_post_meta( $post_id, 'car_views_stat_' . gmdate( 'Y-m-d' ), $views_today );
		}
	}
}
