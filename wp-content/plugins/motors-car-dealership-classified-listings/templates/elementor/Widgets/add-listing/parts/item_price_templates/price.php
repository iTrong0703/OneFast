<div class="col-md-4 col-sm-6">
	<div class="stm_price_input">
		<div class="stm_label heading-font"><?php esc_html_e( 'Price', 'motors-car-dealership-classified-listings-pro' ); ?>*
			(<?php echo wp_kses_post( apply_filters( 'stm_get_price_currency', apply_filters( 'motors_vl_get_nuxy_mod', '$', 'price_currency' ) ) ); ?>)
		</div>
		<input type="number" class="heading-font" name="stm_car_price" value="<?php echo esc_attr( $price ); ?>" required/>
	</div>
</div>
<?php if ( empty( $show_sale_price_label ) && empty( $show_custom_label ) ) : ?>
<div class="col-md-8 col-sm-6">
	<?php if ( ! empty( $stm_title_price ) ) : ?>
		<h4><?php echo esc_attr( $stm_title_price ); ?></h4>
	<?php endif; ?>
	<?php if ( ! empty( $stm_title_desc ) ) : ?>
		<p><?php echo wp_kses_post( $stm_title_desc ); ?></p>
	<?php endif; ?>
</div>
<?php endif; ?>
