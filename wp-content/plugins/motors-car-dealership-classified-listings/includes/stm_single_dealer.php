<?php if ( ! function_exists( 'stm_get_single_dealer' ) ) {
	function stm_get_single_dealer( $default, $dealer_info, $taxonomy = '' ) {
		if ( empty( $dealer_info->ID ) ) {
			return;
		}

		$dealer_cars_count = count( $dealer_info->listings );
		$cars_count_text   = esc_html__( 'Cars in stock', 'motors' );
		if ( 1 === $dealer_cars_count ) {
			$cars_count_text = esc_html__( 'Car in stock', 'motors' );
		}

		if ( ! empty( $taxonomy ) ) {
			$taxonomy = $taxonomy;
		} elseif ( ! empty( $_GET['stm_dealer_show_taxonomies'] ) ) {
			$taxonomy = sanitize_text_field( $_GET['stm_dealer_show_taxonomies'] );
		} else {
			$taxonomy = '';
		}

		$ratings  = $dealer_info->ratings;
		$tax_term = array();

		$taxonomy = array_filter( explode( ', ', $taxonomy ) );
		if ( ! empty( $taxonomy ) ) {
			foreach ( $taxonomy as $tax ) {
				$term_tax                 = explode( ' | ', $tax );
				$tax_term[ $term_tax[0] ] = sanitize_title( $term_tax[1] );
			}
		}

		$dealer_category_labels = '';
		$dealer_cars            = $dealer_info->listings;
		$car_ids                = array_column( $dealer_cars, 'ID' );

		if ( ! empty( $dealer_cars ) ) {
			$dealer_category_labels = \MotorsVehiclesListing\User\UserListingsController::get_terms_title( $car_ids, array_unique( array_values( $tax_term ) ), array_unique( array_keys( $tax_term ) ) );
		}
		?>
			<tr class="stm-single-dealer animated fadeIn">

				<td class="image">
					<a href="<?php echo esc_url( apply_filters( 'stm_get_author_link', $dealer_info->ID ) ); ?>" target="_blank">
						<?php if ( ! empty( $dealer_info->stm_dealer_logo ) ) : ?>
							<img src="<?php echo esc_url( $dealer_info->stm_dealer_logo ); ?>" class="img-responsive" />
						<?php else : ?>
							<img src="<?php echo esc_url( apply_filters( 'motors_vl_dealer_logo_placeholder', '' ) ); ?>" class="no-logo" />
						<?php endif; ?>
					</a>
				</td>

				<td class="dealer-info">
					<div class="title">
						<a class="h4" href="<?php echo esc_url( apply_filters( 'stm_get_author_link', $dealer_info->ID ) ); ?>" target="_blank"><?php echo esc_html( \MotorsVehiclesListing\User\UserMetaController::get_dealer_display_name( $dealer_info ) ); ?></a>
					</div>
					<div class="rating">
						<div class="dealer-rating">
							<div class="stm-rate-unit">
								<div class="stm-rate-inner">
									<div class="stm-rate-not-filled"></div>
									<?php if ( ! empty( $ratings['average_width'] ) ) : ?>
										<div class="stm-rate-filled" style="width:<?php echo esc_attr( $ratings['average_width'] ); ?>"></div>
									<?php else : ?>
										<div class="stm-rate-filled" style="width:0%"></div>
									<?php endif; ?>
								</div>
							</div>
							<div class="stm-rate-sum">(<?php esc_html_e( 'Reviews', 'motors' ); ?> <?php echo esc_attr( $ratings['count'] ); ?>)</div>
						</div>
					</div>
				</td>

				<td class="dealer-cars">
					<div class="inner">
						<a href="<?php echo esc_url( apply_filters( 'stm_get_author_link', $dealer_info->ID ) ); ?>#stm_d_inv" target="_blank">
							<div class="dealer-labels heading-font">
								<?php echo intval( $dealer_cars_count ); ?>
								<?php echo esc_html( $dealer_category_labels ); ?>
							</div>
							<div class="dealer-cars-count">
								<i class="stm-service-icon-body_type"></i>
								<?php echo esc_attr( $cars_count_text ); ?>
							</div>
						</a>
					</div>
				</td>

				<td class="dealer-phone">
					<div class="inner">
						<?php if ( ! empty( $dealer_info->stm_phone ) ) : ?>
							<?php $showNumber = apply_filters( 'motors_vl_get_nuxy_mod', false, 'stm_show_number' ); ?>
							<?php if ( $showNumber ) : ?>
								<div class="phone heading-font">
									<i class="stm-service-icon-phone_2"></i>
									<?php echo esc_attr( $dealer_info->stm_phone ); ?>
								</div>
							<?php else : ?>
								<i class="stm-service-icon-phone_2"></i>
								<div class="phone heading-font">
									<?php echo substr_replace( $dealer_info->stm_phone, '*******', 3, strlen( $dealer_info->stm_phone ) );//phpcs:ignore ?>
								</div>
								<span class="stm-show-number" data-id="<?php echo esc_attr( $dealer_info->ID ); ?>"><?php echo esc_html__( 'Show number', 'motors' ); ?></span>
							<?php endif; ?>
						<?php endif; ?>
					</div>
				</td>


				<td class="dealer-location">
					<div class="clearfix">
						<?php if ( ! empty( $dealer_info->stm_dealer_location ) && ! empty( $dealer_info->stm_dealer_location_lat ) && ! empty( $dealer_info->stm_dealer_location_lng ) ) : ?>
							<a
								href="https://maps.google.com?q=<?php echo esc_attr( $dealer_info->stm_dealer_location ); ?>"
								target="_blank"
								class="map_link"
							>
								<i class="fas fa-external-link-alt"></i>
								<?php esc_html_e( 'See map', 'motors' ); ?>
							</a>
						<?php endif; ?>
						<div class="dealer-location-label">
							<?php if ( ! empty( $dealer_info->distance ) ) : ?>
								<div class="inner">
									<i class="stm-service-icon-pin_big"></i>
									<span class="heading-font"><?php echo esc_attr( $dealer_info->distance ); ?></span>
									<?php if ( ! empty( $dealer_info->user_location ) ) : ?>
										<div class="stm-label">
										<?php
										// translators: %s is user location
										echo sprintf( esc_html__( 'From %s', 'motors' ), $dealer_info->user_location );//phpcs:ignore
										?>
										</div>
									<?php endif; ?>
								</div>
							<?php elseif ( ! empty( $dealer_info->stm_dealer_location ) ) : ?>
								<div class="inner">
									<i class="stm-service-icon-pin_big"></i>
									<span class="heading-font"><?php echo esc_attr( $dealer_info->stm_dealer_location ); ?></span>
								</div>
							<?php else : ?>
								<?php esc_html_e( 'N/A', 'motors' ); ?>
							<?php endif; ?>
						</div>
					</div>
				</td>

			</tr>
			<tr class="dealer-single-divider"><td colspan="5"></td></tr>
		<?php
	}

	add_filter( 'stm_get_single_dealer', 'stm_get_single_dealer', 10, 3 );
} ?>
