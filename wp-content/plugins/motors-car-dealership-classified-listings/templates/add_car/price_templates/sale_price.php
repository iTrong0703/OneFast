<?php
	/**
	 * @var $sale_price
	 * */

	$_currency = apply_filters( 'stm_get_price_currency', '' );
?>

<div class="col-md-4 col-sm-12">
	<div class="stm_price_input">
		<div class="stm_label heading-font" id="motors-add-sale-price-field">
			<?php esc_html_e( 'Sale Price', 'stm_vehicles_listing' ); ?>
			(<?php echo esc_html( $_currency ); ?>)
		</div>
		<input
				type="number"
				aria-labelledby="motors-add-sale-price-field"
				aria-label="<?php esc_attr_e( 'Sale Price', 'stm_vehicles_listing' ); ?>"
				min="0"
				class="heading-font"
				name="stm_car_sale_price"
				value="<?php echo esc_attr( $sale_price ); ?>"
				required/>
	</div>
</div>
