<?php
$regular_price_label = get_post_meta( get_the_ID(), 'regular_price_label', true );
$special_price_label = get_post_meta( get_the_ID(), 'special_price_label', true );

$price      = get_post_meta( get_the_id(), 'price', true );
$sale_price = get_post_meta( get_the_id(), 'sale_price', true );

$car_price_form_label = get_post_meta( get_the_ID(), 'car_price_form_label', true );

$data = array(
	'data_price'   => 0,
	'data_mileage' => 0,
);

if ( ! empty( $price ) ) {
	$data['data_price'] = $price;
}

if ( ! empty( $sale_price ) ) {
	$data['data_price'] = $sale_price;
}

if ( empty( $price ) && ! empty( $sale_price ) ) {
	$price = $sale_price;
}

$mileage = get_post_meta( get_the_id(), 'mileage', true );

if ( ! empty( $mileage ) ) {
	$data['data_mileage'] = $mileage;
}

if ( ! empty( $args['custom_img_size'] ) ) {
	$data['custom_img_size'] = $args['custom_img_size'];
}

$data['class'] = array( 'col-md-4 col-sm-4 col-xs-12 col-xxs-12 stm-directory-grid-loop stm-isotope-listing-item all' );

$data['is_cars_on_top'] = true;

?>

<?php do_action( 'stm_listings_load_template', 'loop/grid/start', $data ); ?>

<?php do_action( 'stm_listings_load_template', 'loop/grid/image', $data ); ?>

<div class="listing-car-item-meta">
	<?php
	do_action(
		'stm_listings_load_template',
		'loop/grid/title_price',
		array(
			'price'                => $price,
			'sale_price'           => $sale_price,
			'car_price_form_label' => $car_price_form_label,
			'title_max_length'     => ! empty( $args['title_max_length'] ) ? $args['title_max_length'] : null,
		)
	);

	do_action( 'stm_listings_load_template', 'loop/grid/data' );
	?>

</div>
</a>
</div>
