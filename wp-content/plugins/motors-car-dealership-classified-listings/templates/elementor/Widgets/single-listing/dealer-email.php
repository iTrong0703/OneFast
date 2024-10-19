<?php
global $listing_id;

$listing_id    = ( is_null( $listing_id ) ) ? get_the_ID() : $listing_id;
$user_added_by = get_post_meta( $listing_id, 'stm_car_user', true );
$user_fields   = apply_filters( 'stm_get_user_custom_fields', $user_added_by );
?>
<div class="dealer-contact-unit mail">
	<a href="mailto:<?php echo esc_attr( $user_fields['email'] ); ?>">
		<div class="email-btn heading-font">
			<?php echo wp_kses( apply_filters( 'stm_dynamic_icon_output', $de_icon ), apply_filters( 'stm_ew_kses_svg', array() ) ); ?>
			<span>
				<?php echo esc_html( $de_label ); ?>
			</span>
		</div>
	</a>
</div>
