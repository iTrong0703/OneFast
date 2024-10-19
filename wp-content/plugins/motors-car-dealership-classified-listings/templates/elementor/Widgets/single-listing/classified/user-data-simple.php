<?php
global $listing_id;

$listing_id = ( is_null( $listing_id ) ) ? get_the_ID() : $listing_id;
?>
<div>
	<?php
	$user_added_by = get_post_meta( $listing_id, 'stm_car_user', true );

	if ( ! empty( $user_added_by ) ) :

		$user_data = get_userdata( $user_added_by );

		if ( $user_data ) :

			$user_fields = apply_filters( 'stm_get_user_custom_fields', $user_added_by );
			$is_dealer   = apply_filters( 'stm_get_user_role', false, $user_added_by );

			if ( $is_dealer ) :
				$ratings = stm_get_dealer_marks( $user_added_by );
				?>
				<div class="stm-listing-car-dealer-info-simple">
					<a class="stm-no-text-decoration" href="<?php echo ( boolval( apply_filters( 'is_listing', array() ) ) || apply_filters( 'stm_is_aircrafts', false ) ) ? esc_url( apply_filters( 'stm_get_author_link', $user_added_by ) ) : '#!'; ?>">
						<h3 class="title">
							<?php echo wp_kses_post( apply_filters( 'stm_display_user_name', $user_added_by, '', '', '' ) ); ?>
						</h3>
					</a>
					<div class="clearfix">
						<div class="dealer-image">
							<div class="stm-dealer-image-custom-view">
								<a href="<?php echo ( boolval( apply_filters( 'is_listing', array() ) ) || apply_filters( 'stm_is_aircrafts', false ) ) ? esc_url( apply_filters( 'stm_get_author_link', $user_added_by ) ) : '#!'; ?>">
									<?php if ( ! empty( $user_fields['logo'] ) ) : ?>
										<img src="<?php echo esc_url( $user_fields['logo'] ); ?>"/>
									<?php else : ?>
										<img src="<?php stm_get_dealer_logo_placeholder(); ?>"/>
									<?php endif; ?>
								</a>
							</div>
						</div>
						<?php if ( ! empty( $ratings['average'] ) ) : ?>
							<div class="dealer-rating">
								<div class="stm-rate-unit">
									<div class="stm-rate-inner">
										<div class="stm-rate-not-filled"></div>
										<div class="stm-rate-filled" style="width:<?php echo esc_attr( $ratings['average_width'] ); ?>"></div>
									</div>
								</div>
								<div class="stm-rate-sum">
									(<?php esc_html_e( 'Reviews', 'motors-car-dealership-classified-listings-pro' ); ?> <?php echo esc_attr( $ratings['count'] ); ?>
									)
								</div>
							</div>
						<?php endif; ?>
					</div>
				</div>
			<?php else : ?>
				<div class="stm-listing-car-dealer-info-simple stm-common-user">
					<div class="clearfix stm-user-main-info-c">
						<div class="image">
							<a href="<?php echo ( boolval( apply_filters( 'is_listing', array() ) ) || apply_filters( 'stm_is_aircrafts', false ) ) ? esc_url( apply_filters( 'stm_get_author_link', $user_added_by ) ) : '#!'; ?>">
								<?php if ( ! empty( $user_fields['image'] ) ) : ?>
									<img src="<?php echo esc_url( $user_fields['image'] ); ?>"/>
								<?php else : ?>
									<div class="no-avatar">
										<i class="motors-icons-user"></i>
									</div>
								<?php endif; ?>
							</a>
						</div>
						<a class="stm-no-text-decoration" href="<?php echo ( boolval( apply_filters( 'is_listing', array() ) ) || apply_filters( 'stm_is_aircrafts', false ) ) ? esc_url( apply_filters( 'stm_get_author_link', $user_added_by ) ) : '#!'; ?>">
							<h3 class="title"><?php echo wp_kses_post( apply_filters( 'stm_display_user_name', $user_added_by, '', '', '' ) ); ?></h3>
							<div class="stm-label"><?php esc_html_e( 'Private Seller', 'motors-car-dealership-classified-listings-pro' ); ?></div>
						</a>
					</div>
				</div>
				<?php
			endif;
		endif;
	endif;
	?>
</div>
