<?php
/**
 * @var $user_login
 * @var $f_name
 * @var $l_name
 * @var $user_id
 * @var $restricted
 * */

$user_login = $user_login ?? '';

if ( empty( $user_id ) ) {
	$user_id = get_current_user_id();
}

$user = apply_filters( 'stm_get_user_custom_fields', $user_id );

if ( empty( $f_name ) ) {
	$f_name = $user['name'];
}

if ( empty( $l_name ) ) {
	$l_name = $user['last_name'];
}

$_id          = apply_filters( 'stm_listings_input', null, 'item_id' );
$restricted   = false;
$restrictions = apply_filters(
	'stm_get_post_limits',
	array(
		'premoderation' => true,
		'posts_allowed' => 0,
		'posts'         => 0,
		'images'        => 0,
		'role'          => 'user',
	),
	$user_id
);

if ( $restrictions['posts'] < 1 && apply_filters( 'motors_vl_get_nuxy_mod', false, 'dealer_pay_per_listing' ) ) {
	$restricted = true;
}

if ( get_post_meta( $_id, 'pay_per_listing', true ) && apply_filters( 'motors_vl_get_nuxy_mod', false, 'dealer_pay_per_listing' ) ) {
	$restricted = false;
}

if ( ! empty( $_id ) && get_post_status( $_id ) === 'publish' ) {
	$restricted = false;
}

if ( is_wp_error( $user ) ) {
	return;
}
$dealer = apply_filters( 'mvl_get_user_role', false, $user['user_id'] );
if ( $dealer ) :
	$ratings = stm_get_dealer_marks( $user_id ); ?>

	<div class="stm-add-a-car-user">
		<div class="stm-add-a-car-user-wrapper">
			<div class="left-info left-dealer-info">
				<div class="stm-dealer-image-custom-view">
					<?php if ( ! empty( $user['logo'] ) ) : ?>
						<img src="<?php echo esc_url( $user['logo'] ); ?>" alt="<?php echo esc_attr( $user_login ); ?>"/>
					<?php else : ?>
						<img src="<?php echo esc_url( apply_filters( 'motors_vl_dealer_logo_placeholder', '' ) ); ?>" alt="<?php echo esc_attr( $user_login ); ?>"/>
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
					$btn_type = ( ! empty( $_id ) ) ? 'edit' : 'add';
					$btn_type = ( ! empty( get_post_meta( $_id, 'pay_per_listing', true ) ) ) ? 'edit-ppl' : $btn_type;
					?>
					<li class="btn-add-edit heading-font">
						<button type="submit" class="heading-font enabled" data-load="<?php echo esc_attr( $btn_type ); ?>"
							<?php
							if ( empty( $_id ) ) {
								echo 'data-toggle="tooltip" data-placement="top" title="' . esc_html__( 'Add a Listing using Free or Paid Plan limits', 'stm_vehicles_listing' ) . '"';
							}
							?>
						>
							<?php if ( ! empty( $_id ) ) : ?>
								<i class="motors-icons-add_check"></i><?php esc_html_e( 'Update Listing', 'stm_vehicles_listing' ); ?>
							<?php else : ?>
								<i class="motors-icons-add_check"></i><?php esc_html_e( 'Submit listing', 'stm_vehicles_listing' ); ?>
							<?php endif; ?>
						</button>
						<span class="stm-add-a-car-loader add"><i class="motors-icons-load1"></i></span>
					</li>
				<?php endif; ?>
				<?php if ( apply_filters( 'motors_vl_get_nuxy_mod', false, 'dealer_pay_per_listing' ) && empty( $_id ) ) : ?>
					<li class="btn-ppl">
						<button type="submit" class="heading-font enabled" data-load="pay" data-toggle="tooltip" data-placement="top" title="<?php esc_attr_e( 'Pay for this Listing', 'stm_vehicles_listing' ); ?>">
							<i class="motors-icons-payment_listing"></i>
							<?php esc_html_e( 'Pay for Listing', 'stm_vehicles_listing' ); ?>
						</button>
						<span class="stm-add-a-car-loader pay">
							<i class="motors-icons-load1"></i>
						</span>
					</li>
				<?php endif; ?>
			</ul>

			<div class="right-info">

				<a target="_blank" href="<?php echo esc_url( add_query_arg( array( 'view-myself' => 1 ), get_author_posts_url( $user_id ) ) ); ?>">
					<i class="fas fa-external-link-alt"></i><?php esc_html_e( 'Show my Public Profile', 'stm_vehicles_listing' ); ?>
				</a>

				<div class="stm_logout">
					<a href="#"><?php esc_html_e( 'Log out', 'stm_vehicles_listing' ); ?></a>
					<?php esc_html_e( 'to choose a different account', 'stm_vehicles_listing' ); ?>
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
						<img src="<?php echo esc_url( $user['image'] ); ?>" alt="<?php echo esc_attr( $user_login ); ?>"/>
					<?php else : ?>
						<i class="motors-icons-user"></i>
					<?php endif; ?>
				</div>
				<div class="user-info">
					<h4><?php echo wp_kses_post( apply_filters( 'stm_display_user_name', $user['user_id'], $user_login, $f_name, $l_name ) ); ?></h4>
					<div class="stm-label"><?php esc_html_e( 'Private Seller', 'stm_vehicles_listing' ); ?></div>
				</div>
			</div>

			<ul class="add-car-btns-wrap">
				<?php
				if ( false === $restricted ) :
					$btn_type = ( ! empty( $_id ) ) ? 'edit' : 'add';
					$btn_type = ( ! empty( get_post_meta( $_id, 'pay_per_listing', true ) ) ) ? 'edit-ppl' : $btn_type;
					?>
					<li class="btn-add-edit heading-font">
						<button type="submit" class="heading-font enabled" data-load="<?php echo esc_attr( $btn_type ); ?>"
							<?php
							if ( empty( $_id ) ) {
								echo 'data-toggle="tooltip" data-placement="top" title="' . esc_attr__( 'Add a Listing using Free or Paid Plan limits', 'stm_vehicles_listing' ) . '"';
							}
							?>
						>
							<?php if ( ! empty( $_id ) ) : ?>
								<i class="motors-icons-add_check"></i>
								<?php esc_html_e( 'Update Listing', 'stm_vehicles_listing' ); ?>
							<?php else : ?>
								<i class="motors-icons-add_check"></i>
								<?php esc_html_e( 'Submit listing', 'stm_vehicles_listing' ); ?>
							<?php endif; ?>
						</button>
						<span class="stm-add-a-car-loader add"><i class="motors-icons-load1"></i></span>
					</li>
				<?php endif; ?>
				<?php if ( apply_filters( 'motors_vl_get_nuxy_mod', false, 'dealer_pay_per_listing' ) && empty( $_id ) ) : ?>
					<li class="btn-ppl">
						<button type="submit" class="heading-font enabled" data-load="pay" data-toggle="tooltip" data-placement="top" title="<?php esc_attr_e( 'Pay for this Listing', 'stm_vehicles_listing' ); ?>">
							<i class="motors-icons-payment_listing"></i>
							<?php esc_html_e( 'Pay for Listing', 'stm_vehicles_listing' ); ?>
						</button>
						<span class="stm-add-a-car-loader pay">
							<i class="motors-icons-load1"></i>
						</span>
					</li>
				<?php endif; ?>
			</ul>

			<div class="right-info">
				<a target="_blank" href="<?php echo esc_url( add_query_arg( array( 'view-myself' => 1 ), get_author_posts_url( $user_id ) ) ); ?>">
					<i class="fas fa-external-link-alt"></i><?php esc_html_e( 'Show my Public Profile', 'stm_vehicles_listing' ); ?>
				</a>
				<div class="stm_logout">
					<a href="#"><?php esc_html_e( 'Log out', 'stm_vehicles_listing' ); ?></a>
					<?php esc_html_e( 'to choose a different account', 'stm_vehicles_listing' ); ?>
				</div>
			</div>
		</div>
	</div>
	<?php
endif;
