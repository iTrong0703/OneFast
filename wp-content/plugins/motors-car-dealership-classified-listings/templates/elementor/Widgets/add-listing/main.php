<?php
$terms_args = array(
	'orderby'    => 'name',
	'order'      => 'ASC',
	'hide_empty' => false,
	'fields'     => 'all',
	'pad_counts' => true,
);

$data = apply_filters( 'stm_get_single_car_listings', array() );

$_id = apply_filters( 'stm_listings_input', null, 'item_id' );

if ( is_user_logged_in() ) {
	$user    = wp_get_current_user();
	$user_id = $user->ID;
}

$stm_edit_car_form = '';
$car_edit          = false;
if ( ! empty( $_GET['edit_car'] ) && $_GET['edit_car'] ) {
	$car_edit          = true;
	$stm_edit_car_form = 'stm_edit_car_form';
}

$custom_listing_type = false;
$lt_options          = false;
if ( stm_is_multilisting() && 'listings' !== $post_type ) {
	set_query_var( 'listings_type', $post_type );
	$custom_listing_type = $post_type;
	$lt_options          = get_option( 'stm_motors_listing_types' );
}

$lt_args = array(
	'custom_listing_type'   => $custom_listing_type,
	'listing_types_options' => $lt_options,
);

Motors_Elementor_Widgets_Free\Helpers\Helper::stm_ew_load_template( 'elementor/Widgets/add-listing/parts/restricted-popup', STM_LISTINGS_PATH, array() );
Motors_Elementor_Widgets_Free\Helpers\Helper::stm_ew_load_template( 'elementor/Widgets/add-listing/parts/binding', STM_LISTINGS_PATH, array() );
?>

<div class="stm_add_car_form <?php echo esc_attr( $stm_edit_car_form ); ?>">
	<?php
	if ( $car_edit ) {
		if ( ! is_user_logged_in() ) {
			echo '<h4>' . esc_html__( 'Please login.', 'motors-car-dealership-classified-listings-pro' ) . '</h4></div>';

			return false;
		}

		if ( ! empty( $_GET['item_id'] ) ) {
			$item_id = intval( $_GET['item_id'] );

			$car_user = get_post_meta( $item_id, 'stm_car_user', true );

			if ( intval( $user_id ) !== intval( $car_user ) ) {
				echo '<h4>' . esc_html__( 'You are not the owner of this car.', 'motors-car-dealership-classified-listings-pro' ) . '</h4></div>';

				return false;
			}
		} else {
			echo '<h4>' . esc_html__( 'No car to edit.', 'motors-car-dealership-classified-listings-pro' ) . '</h4></div>';

			return false;
		}
	}
	?>

	<form method="POST" action="" enctype="multipart/form-data" id="stm_sell_a_car_form">
		<?php wp_nonce_field(); ?>
		<?php if ( $car_edit ) { ?>
			<input type="hidden" value="<?php echo intval( $_id ); ?>" name="stm_current_car_id"/>
			<input type="hidden" value="update" name="stm_edit"/>
		<?php } else { ?>
			<input type="hidden" value="adding" name="stm_edit"/>
		<?php } ?>
		<?php if ( $custom_listing_type ) : ?>
			<input type="hidden" value="<?php echo esc_attr( $custom_listing_type ); ?>" name="custom_listing_type"/>
		<?php endif; ?>

		<?php

		Motors_Elementor_Widgets_Free\Helpers\Helper::stm_ew_load_template( 'elementor/Widgets/add-listing/parts/desc_slots', STM_LISTINGS_PATH, $lt_args );
		Motors_Elementor_Widgets_Free\Helpers\Helper::stm_ew_load_template( 'elementor/Widgets/add-listing/parts/title', STM_LISTINGS_PATH, $lt_args );

		$steps = apply_filters( 'motors_vl_get_nuxy_mod', '', 'sorted_steps' );

		if ( ! empty( $steps ) ) {
			foreach ( $steps[0]['options'] as $step ) {
				$template = $step['id'];

				if ( 'item_features' === $template && ! empty( apply_filters( 'motors_vl_get_nuxy_mod', array(), 'fs_user_features' ) ) ) {
					$template = 'item_grouped_features';
				}

				Motors_Elementor_Widgets_Free\Helpers\Helper::stm_ew_load_template( 'elementor/Widgets/add-listing/parts/' . $template, STM_LISTINGS_PATH, $lt_args );
			}
		}
		?>
	</form>

	<?php do_action( 'stm_listings_load_template', 'add_car/progress-bar', array() ); ?>

	<?php
	Motors_Elementor_Widgets_Free\Helpers\Helper::stm_ew_load_template( 'elementor/Widgets/add-listing/parts/check_user', STM_LISTINGS_PATH, $lt_args );
	?>
</div>
