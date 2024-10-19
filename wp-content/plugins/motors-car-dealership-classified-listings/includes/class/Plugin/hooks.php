<?php
add_filter(
	'motors_filter_position',
	function ( $filters ) {
		$filters['horizontal'] = 'Horizontal';

		return $filters;
	}
);

add_filter(
	'motors_get_category_by_slug_all',
	function ( $terms, $slug, $is_add_car = false, $show_count = false ) {
		if ( ! empty( $terms ) && $show_count ) {
			$show_sold = (bool) apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_sold_listings' );

			if ( function_exists( 'stm_is_multilisting' ) && stm_is_multilisting() ) {
				$taxonomy = get_taxonomy( $slug );

				if ( ! empty( $taxonomy ) && ! empty( $taxonomy->object_type ) && is_array( $taxonomy->object_type ) && 'listings' !== $taxonomy->object_type[0] ) {
					$ml        = new STMMultiListing();
					$show_sold = (bool) $ml->stm_get_listing_type_settings( 'show_sold_listings', $taxonomy->object_type[0] );
				}
			}

			if ( ! $show_sold && ! $is_add_car ) {
				foreach ( $terms as $key => $term ) {
					$count = apply_filters( 'stm_get_custom_taxonomy_count', 0, $term->slug, $slug );
					if ( ! empty( $count ) ) {
						$term->count = $count;
					} else {
						unset( $terms[ $key ] );
					}
				}
			}
		}

		if ( ! $is_add_car ) {
			foreach ( $terms as $key => $term ) {
				if ( empty( $term->count ) && 0 === $term->count ) {
					unset( $terms[ $key ] );
				}
			}
		}

		return $terms;
	},
	10,
	4
);

if ( ! function_exists( 'mvl_is_multiple_plans' ) ) {
	function mvl_is_multiple_plans() {
		if ( class_exists( 'MotorsVehiclesListing\Features\MultiplePlan' ) && MotorsVehiclesListing\Features\MultiplePlan::isMultiplePlans() ) {
			return true;
		}

		return false;
	}

	add_filter( 'stm_is_multiple_plans', 'mvl_is_multiple_plans' );
}

if ( ! function_exists( 'set_pro_butterbean_fields' ) ) {
	add_action( 'add_pro_butterbean_fields', 'set_pro_butterbean_fields' );
	function set_pro_butterbean_fields( $manager ) {
		$manager->register_control(
			'car_mark_as_sold',
			array(
				'type'        => 'checkbox',
				'section'     => 'stm_price',
				'value'       => 'on',
				'label'       => esc_html__( 'Mark as sold', 'stm_vehicles_listing' ),
				'description' => esc_html__( 'Enable/Disable \'Car sold\'', 'stm_vehicles_listing' ),
				'attr'        => array( 'class' => 'widefat' ),
			)
		);
	}
}

if ( ! function_exists( 'mvl_nuxy_sortby_pro' ) ) {
	function mvl_nuxy_sortby_pro( $sorts ) {
		$options = mvl_nuxy_sort_options();
		if ( ! empty( $options ) ) {
			foreach ( $options as $slug => $name ) {
				/* translators: option name */
				$sorts[ $slug . '_high' ] = sprintf( esc_html__( '%s: highest first', 'stm_vehicles_listing' ), $name );
				/* translators: option name */
				$sorts[ $slug . '_low' ] = sprintf( esc_html__( '%s: lowest first', 'stm_vehicles_listing' ), $name );
			}
		}

		return $sorts;
	}

	add_filter( 'mvl_nuxy_sortby', 'mvl_nuxy_sortby_pro', 50 );
}

function motors_vl_wpcfto_pages_list() {
	$post_types[] = __( '--- Default ---', 'stm_vehicles_listing' );
	$query        = get_posts(
		array(
			'post_type'      => 'page',
			'posts_per_page' => -1,
		)
	);

	if ( $query ) {
		foreach ( $query as $post ) {
			$post_types[ $post->ID ] = get_the_title( $post->ID );
		}
	}

	return $post_types;
}

add_filter( 'motors_vl_wpcfto_pages_list', 'motors_vl_wpcfto_pages_list' );
