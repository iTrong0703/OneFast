<?php
add_action( 'add_classified_fields', 'set_classified_fields' );
function set_classified_fields( $manager ) {
	$manager->register_control(
		'vin_number',
		array(
			'type'    => 'text',
			'section' => 'stm_options',
			'preview' => 'vin',
			'label'   => esc_html__( 'VIN number', 'stm_vehicles_listing' ),
			'attr'    => array( 'class' => 'widefat' ),
		)
	);

	$manager->register_control(
		'city_mpg',
		array(
			'type'    => 'text',
			'section' => 'stm_options',
			'label'   => esc_html__( 'City MPG', 'stm_vehicles_listing' ),
			'attr'    => array( 'class' => 'widefat' ),
			'preview' => 'mpg',
		)
	);

	$manager->register_control(
		'highway_mpg',
		array(
			'type'    => 'text',
			'section' => 'stm_options',
			'label'   => esc_html__( 'Highway MPG', 'stm_vehicles_listing' ),
			'attr'    => array( 'class' => 'widefat' ),
			'preview' => 'mpg',
		)
	);
}

if ( ! has_action( 'listing_stock_number_register_control' ) ) {
	add_action( 'listing_stock_number_register_control', 'set_listing_stock_number_register_control' );
	function set_listing_stock_number_register_control( $manager ) {
		$manager->register_control(
			'stock_number',
			array(
				'type'    => 'text',
				'section' => 'stm_options',
				'preview' => 'stockid',
				'label'   => esc_html__( 'Stock number', 'stm_vehicles_listing' ),
				'attr'    => array( 'class' => 'widefat' ),
			)
		);
	}
}
