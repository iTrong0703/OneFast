<?php
/**
 * @var $car_price_form_label
 * */
?>
<div class="col-md-4 col-sm-12">
	<div class="stm_price_input">
		<div class="stm_label heading-font" id="motors-add-custom-label-field">
			<?php esc_html_e( 'Custom label instead of price', 'stm_vehicles_listing' ); ?>
		</div>
		<input
				type="text"
				class="heading-font"
				aria-labelledby="motors-add-custom-label-field"
				aria-label="<?php esc_attr_e( 'Custom label instead of price', 'stm_vehicles_listing' ); ?>"
				name="car_price_form_label"
				value="<?php echo esc_attr( $car_price_form_label ); ?>" />
	</div>
</div>
