<?php
	$compare_page_link = get_permalink( apply_filters( 'motors_vl_get_nuxy_mod', '', 'compare_page' ) );
?>
<a href="<?php echo esc_url( $compare_page_link ); ?>" class="motors-compare-button">
	<span class="compare-icon-wrapper">
		<?php echo wp_kses( apply_filters( 'stm_dynamic_icon_output', $compare_btn_icon ), apply_filters( 'stm_ew_kses_svg', array() ) ); ?>
	</span>
	<span><?php echo esc_html( $compare_btn_text ); ?></span>
</a>
