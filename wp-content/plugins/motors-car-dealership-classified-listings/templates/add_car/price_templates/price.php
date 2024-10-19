<?php
	/**
	 * @var $price
	 * @var $show_sale_price_label
	 * @var $show_custom_label
	 * @var $stm_title_price
	 * @var $stm_title_desc
	 * */

	$_currency = apply_filters( 'stm_get_price_currency', '' );
?>

<div class="col-md-4 col-sm-6">
	<div class="stm_price_input">
		<div class="stm_label heading-font" id="motors-add-price-field">
			<?php esc_html_e( 'Price', 'stm_vehicles_listing' ); ?>*
			(<?php echo esc_html( $_currency ); ?>)
		</div>
		<input
				type="number"
				aria-labelledby="motors-add-price-field"
				aria-label="<?php esc_attr_e( 'Price', 'stm_vehicles_listing' ); ?>"
				class="heading-font"
				name="stm_car_price"
				value="<?php echo esc_attr( $price ); ?>"
				required/>
	</div>
</div>
<?php if ( empty( $show_sale_price_label ) && empty( $show_custom_label ) ) : ?>
	<div class="col-md-8 col-sm-6">
		<?php if ( ! empty( $stm_title_price ) ) : ?>
			<h4><?php echo esc_html( $stm_title_price ); ?></h4>
		<?php endif; ?>
		<?php if ( ! empty( $stm_title_desc ) ) : ?>
			<p><?php echo wp_kses_post( $stm_title_desc ); ?></p>
		<?php endif; ?>
	</div>
<?php endif; ?>
