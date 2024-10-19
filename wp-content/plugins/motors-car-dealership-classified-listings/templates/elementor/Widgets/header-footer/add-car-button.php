<?php
$header_listing_btn_link = get_permalink( apply_filters( 'motors_vl_get_nuxy_mod', '', 'user_add_car_page' ) );
?>
<a href="<?php echo esc_url( $header_listing_btn_link ); ?>" class="motors-add-car-button listing_add_cart heading-font">
	<div>
		<?php echo wp_kses( apply_filters( 'stm_dynamic_icon_output', $add_car_btn_icon ), apply_filters( 'stm_ew_kses_svg', array() ) ); ?>
		<span><?php echo esc_html( $add_car_btn_text ); ?></span>
	</div>
</a>
