<?php
$user = apply_filters( 'stm_get_user_custom_fields', $user_id );

if ( is_wp_error( $user ) ) {
	return;
}
$dealer = apply_filters( 'stm_get_user_role', false, $user['user_id'] );
if ( $dealer ) :
	$ratings = stm_get_dealer_marks( $user_id ); ?>

	<div class="stm-add-a-car-user">
		<div class="stm-add-a-car-user-wrapper">
			<div class="left-info left-dealer-info">
				<div class="stm-dealer-image-custom-view">
					<?php if ( ! empty( $user['logo'] ) ) : ?>
						<img src="<?php echo esc_url( $user['logo'] ); ?>"/>
					<?php else : ?>
						<img src="<?php stm_get_dealer_logo_placeholder(); ?>"/>
					<?php endif; ?>
				</div>
				<h4><?php echo wp_kses_post( apply_filters( 'stm_display_user_name', $user['user_id'], $user_login, $f_name, $l_name ) ); ?></h4>

				<?php if ( ! empty( $ratings['average'] ) ) : ?>
					<div class="stm-star-rating">
						<div class="inner">
							<div class="stm-star-rating-upper" style="width:<?php echo esc_attr( $ratings['average_width'] ); ?>"></div>
							<div class="stm-star-rating-lower"></div>
						</div>
						<div class="heading-font"><?php echo wp_kses_post( $ratings['average'] ); ?></div>
					</div>
				<?php endif; ?>

			</div>

			<ul class="add-car-btns-wrap">
				<?php
				if ( false === $restricted ) :
					$btnType = ( ! empty( $_id ) ) ? 'edit' : 'add';
					$btnType = ( ! empty( get_post_meta( $_id, 'pay_per_listing', true ) ) ) ? 'edit-ppl' : $btnType;
					?>
					<li class="btn-add-edit heading-font">
						<button type="submit" class="heading-font enabled" data-load="<?php echo esc_attr( $btnType ); ?>"
							<?php
							if ( empty( $_id ) ) {
								echo 'data-toggle="tooltip" data-placement="top" title="' . esc_html__( 'Add a Listing using Free or Paid Plan limits', 'motors-car-dealership-classified-listings-pro' ) . '"';
							}
							?>
						>
							<?php if ( ! empty( $_id ) ) : ?>
								<i class="motors-icons-add_check"></i><?php esc_html_e( 'Edit Listing', 'motors-car-dealership-classified-listings-pro' ); ?>
							<?php else : ?>
								<i class="motors-icons-add_check"></i><?php esc_html_e( 'Submit listing', 'motors-car-dealership-classified-listings-pro' ); ?>
							<?php endif; ?>
						</button>
						<span class="stm-add-a-car-loader add"><i class="motors-icons-load1"></i></span>
					</li>
				<?php endif; ?>
				<?php if ( apply_filters( 'motors_vl_get_nuxy_mod', false, 'dealer_pay_per_listing' ) && empty( $_id ) ) : ?>
					<li class="btn-ppl">
						<button type="submit" class="heading-font enabled" data-load="pay"
							<?php
							if ( empty( $_id ) ) {
								echo 'data-toggle="tooltip" data-placement="top" title="' . esc_html__( 'Pay for this Listing', 'motors-car-dealership-classified-listings-pro' ) . '"';
							}
							?>
						>
							<i class="motors-icons-payment_listing"></i><?php esc_html_e( 'Pay for Listing', 'motors-car-dealership-classified-listings-pro' ); ?>
						</button>
						<span class="stm-add-a-car-loader pay"><i class="motors-icons-load1"></i></span>
					</li>
				<?php endif; ?>
			</ul>

			<div class="right-info">

				<a target="_blank" href="<?php echo esc_url( add_query_arg( array( 'view-myself' => 1 ), get_author_posts_url( $user_id ) ) ); ?>">
					<i class="fas fa-external-link-alt"></i><?php esc_html_e( 'Show my Public Profile', 'motors-car-dealership-classified-listings-pro' ); ?>
				</a>

				<div class="stm_logout">
					<a href="#"><?php esc_html_e( 'Log out', 'motors-car-dealership-classified-listings-pro' ); ?></a>
					<?php esc_html_e( 'to choose a different account', 'motors-car-dealership-classified-listings-pro' ); ?>
				</div>

			</div>

		</div>
	</div>

<?php else : ?>

	<div class="stm-add-a-car-user">
		<div class="stm-add-a-car-user-wrapper">
			<div class="left-info">
				<div class="avatar">
					<?php if ( ! empty( $user['image'] ) ) : ?>
						<img src="<?php echo esc_url( $user['image'] ); ?>"/>
					<?php else : ?>
						<i class="motors-icons-user"></i>
					<?php endif; ?>
				</div>
				<div class="user-info">
					<h4><?php echo wp_kses_post( apply_filters( 'stm_display_user_name', $user['user_id'], $user_login, $f_name, $l_name ) ); ?></h4>
					<div class="stm-label"><?php esc_html_e( 'Private Seller', 'motors-car-dealership-classified-listings-pro' ); ?></div>
				</div>
			</div>

			<ul class="add-car-btns-wrap">
				<?php
				if ( false === $restricted ) :
					$btn_type = ( ! empty( $_id ) ) ? 'edit' : 'add';
					$btn_type = ( ! empty( get_post_meta( $_id, 'pay_per_listing', true ) ) ) ? 'edit-ppl' : $btn_type;
					?>
					<li class="btn-add-edit">
						<button type="submit" class="heading-font enabled" data-load="<?php echo esc_attr( $btn_type ); ?>"
							<?php
							if ( empty( $_id ) ) {
								echo 'data-toggle="tooltip" data-placement="top" title="' . esc_html__( 'Add a Listing using Free or Paid Plan limits', 'motors-car-dealership-classified-listings-pro' ) . '"';
							}
							?>
						>
							<?php if ( ! empty( $_id ) ) : ?>
								<i class="motors-icons-add_check"></i><?php esc_html_e( 'Edit Listing', 'motors-car-dealership-classified-listings-pro' ); ?>
							<?php else : ?>
								<i class="motors-icons-add_check"></i><?php esc_html_e( 'Submit listing', 'motors-car-dealership-classified-listings-pro' ); ?>
							<?php endif; ?>
						</button>
						<span class="stm-add-a-car-loader add"><i class="motors-icons-load1"></i></span>
					</li>
				<?php endif; ?>
				<?php if ( $dealer_ppl && empty( $_id ) ) : ?>
					<li class="btn-ppl">
						<button type="submit" class="heading-font enabled"
								data-load="pay"
							<?php
							if ( empty( $_id ) ) {
								echo 'data-toggle="tooltip" data-placement="top" title="' . esc_html__( 'Pay for this Listing', 'motors-car-dealership-classified-listings-pro' ) . '"';
							}
							?>
						>
							<i class="motors-icons-payment_listing"></i><?php esc_html_e( 'Pay for Listing', 'motors-car-dealership-classified-listings-pro' ); ?>
						</button>
						<span class="stm-add-a-car-loader pay"><i class="motors-icons-load1"></i></span>
					</li>
				<?php endif; ?>
			</ul>

			<div class="right-info">
				<a target="_blank" href="<?php echo esc_url( add_query_arg( array( 'view-myself' => 1 ), get_author_posts_url( $user_id ) ) ); ?>">
					<i class="fas fa-external-link-alt"></i><?php esc_html_e( 'Show my Public Profile', 'motors-car-dealership-classified-listings-pro' ); ?>
				</a>
				<div class="stm_logout">
					<a href="#"><?php esc_html_e( 'Log out', 'motors-car-dealership-classified-listings-pro' ); ?></a>
					<?php esc_html_e( 'to choose a different account', 'motors-car-dealership-classified-listings-pro' ); ?>
				</div>
			</div>
		</div>
	</div>
	<?php
endif;
