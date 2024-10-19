<?php
if ( ! function_exists( 'stm_mm_layout_name' ) ) {
	function stm_mm_layout_name() {
		$layout = get_option( 'current_layout', 'personal' );

		return $layout;
	}
}

if ( ! function_exists( 'stm_mm_get_featured_listings' ) ) {
	function stm_mm_get_featured_listings( $ppp = 2, $image_size = 'stm-img-350-x-2' ) {
		$args = array(
			'post_type'      => 'listings',
			'post_status'    => 'publish',
			'posts_per_page' => $ppp,
		);

		$args['meta_query'][] = array(
			'key'     => 'special_car',
			'value'   => 'on',
			'compare' => '=',
		);

		$args['orderby'] = 'rand';

		$featured_query = new WP_Query( $args );

		$featured = array();

		if ( $featured_query->have_posts() ) {
			while ( $featured_query->have_posts() ) {
				$featured_query->the_post();

				$id = get_the_ID();

				$price      = get_post_meta( $id, 'price', true );
				$sale_price = get_post_meta( $id, 'sale_price', true );

				$featured_image = wp_get_attachment_image_url( get_post_thumbnail_id( $id ), $image_size );

				if ( ! $featured_image ) {
					$plchldr_id     = get_option( 'plchldr_attachment_id', 0 );
					$featured_image = ( empty( $plchldr_id ) ) ? STM_MM_URL . '/assets/img/car_plchldr.png' : wp_get_attachment_image_url( $plchldr_id );
				}

				$featured[] = array(
					'ID'         => $id,
					'title'      => get_the_title(),
					'price'      => ( ! empty( $price ) ) ? str_replace( '   ', ' ', apply_filters( 'stm_filter_price_view', '', trim( $price ) ) ) : '',
					'sale_price' => ( ! empty( $sale_price ) ) ? str_replace( '   ', ' ', apply_filters( 'stm_filter_price_view', '', trim( $sale_price ) ) ) : '',
					'img'        => $featured_image,
				);

			}
		}

		wp_reset_postdata();

		return $featured;
	}
}

if ( ! function_exists( 'stm_mm_is_elementor_active' ) ) {
	function stm_mm_is_elementor_active() {
		return in_array( 'elementor/elementor.php', (array) get_option( 'active_plugins', array() ), true );
	}
}
