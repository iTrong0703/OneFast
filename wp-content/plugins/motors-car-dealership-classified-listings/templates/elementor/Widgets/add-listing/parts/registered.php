<?php

$user    = wp_get_current_user();
$user_id = $user->ID;

$user_login = '';
$f_name     = '';
$l_name     = '';
$user_id    = '';

$user = apply_filters( 'stm_get_user_custom_fields', $user_id );
if ( ! is_wp_error( $user ) ) { ?>

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
}
