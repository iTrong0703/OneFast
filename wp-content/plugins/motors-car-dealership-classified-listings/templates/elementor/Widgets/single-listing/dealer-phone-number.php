<?php
global $listing_id;

$listing_id = ( is_null( $listing_id ) ) ? get_the_ID() : $listing_id;

$user_added_by = get_post_meta( $listing_id, 'stm_car_user', true );
$user_id       = $user_added_by;
$user          = apply_filters( 'stm_get_user_custom_fields', $user_id );

?>
<div class="stm-dealer-info-unit phone">
	<?php echo wp_kses( apply_filters( 'stm_dynamic_icon_output', $dpn_icon ), apply_filters( 'stm_ew_kses_svg', array() ) ); ?>
	<div class="inner">
		<?php if ( ! empty( $dpn_label ) ) : ?>
			<h5><?php echo esc_html( $dpn_label ); ?></h5>
		<?php endif; ?>
		<?php if ( empty( $show_number ) ) : ?>
			<?php if ( ! empty( $user['phone'] ) ) : ?>
				<span class="phone"><?php echo esc_attr( $user['phone'] ); ?></span>
			<?php endif; ?>
		<?php else : ?>
			<span class="phone"><?php echo wp_kses_post( substr_replace( $user['phone'], '*******', 3, strlen( $user['phone'] ) ) ); ?></span>
			<span class="stm-show-number" data-listing-id="<?php echo intval( $listing_id ); ?>" data-id="<?php echo esc_attr( $user['user_id'] ); ?>"><?php echo esc_html( $dpn_show_number ); ?></span>
		<?php endif; ?>
	</div>
</div>
