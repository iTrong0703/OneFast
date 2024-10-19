<?php
defined( 'ABSPATH' ) || exit;

$item_id = $id ?? 0;

if ( ! empty( apply_filters( 'stm_listings_input', null, 'item_id' ) ) ) {
	$item_id = apply_filters( 'stm_listings_input', null, 'item_id' );
}

$car_price_form_label = '';
$price                = '';
$price_label          = $price_label ?? '';
$sale_price_label     = $sale_price_label ?? '';
$sale_price           = '';
if ( ! empty( $item_id ) ) {
	$car_price_form_label = get_post_meta( $item_id, 'car_price_form_label', true );
	$price                = (int) getConverPrice( get_post_meta( $item_id, 'price', true ) );
	$sale_price           = ( ! empty( get_post_meta( $item_id, 'sale_price', true ) ) ) ? (int) getConverPrice( get_post_meta( $item_id, 'sale_price', true ) ) : '';
}

$show_sale_price_label = apply_filters( 'motors_vl_get_nuxy_mod', false, 'addl_sale_price' );
$show_custom_label     = apply_filters( 'motors_vl_get_nuxy_mod', false, 'addl_custom_label' );
?>

<div class="stm-form-price-edit">
	<?php
		$vars['step_title']  = __( 'Set Your Asking Price', 'stm_vehicles_listing' );
		$vars['step_number'] = 6;
		do_action( 'stm_listings_load_template', 'add_car/step-title', $vars );
	?>
	<div class="row stm-relative">
		<?php
		$vars = array(
			'stm_title_desc'        => apply_filters( 'motors_vl_get_nuxy_mod', false, 'addl_price_desc' ),
			'stm_title_price'       => apply_filters( 'motors_vl_get_nuxy_mod', false, 'addl_price_title' ),
			'show_sale_price_label' => $show_sale_price_label,
			'show_custom_label'     => $show_custom_label,
			'price'                 => $price,
			'car_price_form_label'  => $car_price_form_label,
			'sale_price'            => $sale_price,
		);

		do_action( 'stm_listings_load_template', 'add_car/price_templates/price', $vars );

		if ( $show_sale_price_label ) {
			do_action( 'stm_listings_load_template', 'add_car/price_templates/sale_price', $vars );
		}

		if ( $show_custom_label ) {
			do_action( 'stm_listings_load_template', 'add_car/price_templates/custom_label', $vars );
		}
		?>
	</div>
	<input type="hidden" name="btn-type" />
	<input type="hidden" name="price_label" value="<?php echo esc_attr( $price_label ); ?>" />
	<input type="hidden" name="sale_price_label" value="<?php echo esc_attr( $sale_price_label ); ?>" />
</div>
