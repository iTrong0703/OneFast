<?php
global $listing_id;

$listing_id = ( is_null( $listing_id ) ) ? get_the_ID() : $listing_id;

$filter_opt = apply_filters( 'stm_get_single_car_listings', array() );
$data       = apply_filters( 'stm_single_car_data', $filter_opt );

$vin_num           = get_post_meta( $listing_id, 'vin_number', true );
$stock_number      = get_post_meta( $listing_id, 'stock_number', true );
$registration_date = get_post_meta( $listing_id, 'registration_date', true );
$history           = get_post_meta( $listing_id, 'history', true );
$history_link      = '';
$history_link      = get_post_meta( $listing_id, 'history_link', true );

//Registration
if ( ! empty( $registration_date ) && $show_registered ) {
	$data[] = array(
		'single_name' => esc_html__( 'Registered', 'motors-car-dealership-classified-listings-pro' ),
		'value'       => $registration_date,
		'font'        => 'motors-icons-key',
		'standart'    => false,
	);
}

if ( empty( $registration_date ) && $show_registered ) {
	$data[] = array(
		'single_name' => esc_html__( 'Registered', 'motors-car-dealership-classified-listings-pro' ),
		'value'       => esc_html__( 'N/A', 'motors-car-dealership-classified-listings-pro' ),
		'font'        => 'motors-icons-key',
		'standart'    => false,
	);
}

//History
if ( ! empty( $history ) && $show_history ) {
	$data[] = array(
		'single_name' => esc_html__( 'History', 'motors-car-dealership-classified-listings-pro' ),
		'value'       => $history,
		'link'        => $history_link,
		'font'        => 'motors-icons-time',
		'standart'    => false,
	);
}

if ( empty( $history ) && $show_history ) {
	$data[] = array(
		'single_name' => esc_html__( 'History', 'motors-car-dealership-classified-listings-pro' ),
		'value'       => esc_html__( 'N/A', 'motors-car-dealership-classified-listings-pro' ),
		'font'        => 'motors-icons-time',
		'standart'    => false,
	);
}

//Stock
if ( ! empty( $stock_number ) && $show_stock ) {
	$data[] = array(
		'single_name' => esc_html__( 'Stock id', 'motors-car-dealership-classified-listings-pro' ),
		'value'       => $stock_number,
		'font'        => 'motors-icons-hashtag',
		'standart'    => false,
	);
}

if ( empty( $stock_number ) && $show_stock ) {
	$data[] = array(
		'single_name' => esc_html__( 'Stock id', 'motors-car-dealership-classified-listings-pro' ),
		'value'       => esc_html__( 'N/A', 'motors-car-dealership-classified-listings-pro' ),
		'font'        => 'motors-icons-hashtag',
		'standart'    => false,
	);
}


//VIN
if ( ! empty( $vin_num ) && $show_vin ) {
	$data[] = array(
		'single_name' => esc_html__( 'VIN:', 'motors-car-dealership-classified-listings-pro' ),
		'value'       => $vin_num,
		'font'        => 'motors-icons-vin_check',
		'standart'    => false,
		'vin'         => true,
	);
}

if ( empty( $vin_num ) && $show_vin ) {
	$data[] = array(
		'single_name' => esc_html__( 'VIN:', 'motors-car-dealership-classified-listings-pro' ),
		'value'       => $vin_num,
		'font'        => 'motors-icons-vin_check',
		'standart'    => false,
		'vin'         => true,
	);
}

$cols_class  = ( isset( $data_columns ) && $data_columns ) ? 'cols-' . $data_columns : '';
$cols_class .= ( isset( $data_columns_tablet ) && $data_columns_tablet ) ? ' tablet-cols-' . $data_columns_tablet : '';
$cols_class .= ( isset( $data_columns_mobile ) && $data_columns_mobile ) ? ' mobile-cols-' . $data_columns_mobile : '';
?>

<?php if ( ! empty( $data ) ) : ?>
	<div class="stm-single-car-listing-data">
		<ul class="data-list-wrap <?php echo esc_attr( $cols_class ); ?>">
			<?php
			foreach ( $data as $data_key => $data_single ) :
				if ( ! empty( $data_single['slug'] ) ) {
					$value = get_post_meta( $listing_id, $data_single['slug'], true );
					if ( '' !== $value ) {
						if ( ! empty( $data_single['numeric'] ) && $data_single['numeric'] ) {
							if ( ! empty( $data_single['use_delimiter'] ) ) {
								$value = number_format( abs( $value ), 0, '', ' ' );
							}

							if ( ! empty( $data_single['number_field_affix'] ) ) {
								$value .= ' ' . $data_single['number_field_affix'];
							}
						} else {
							$term_slugs = explode( ',', $value );
							$values     = array();

							foreach ( $term_slugs as $term_slug ) {
								$_term = get_term_by( 'slug', $term_slug, $data_single['slug'] );
								if ( ! empty( $_term->name ) ) {
									$values[] = $_term->name;
								}
							}

							$value = implode( ', ', $values );
						}
					} else {
						$value = esc_html__( 'N/A', 'motors-car-dealership-classified-listings-pro' );
					}
				} else {
					$value = $data_single['value'];
				}
				?>
				<li class="data-list-item">
					<?php if ( ! empty( $data_single['vin'] ) ) : ?>
						<span class="item-label">
							<?php if ( ! empty( $data_single['font'] ) ) : ?>
								<i class="<?php echo esc_attr( $data_single['font'] ); ?>"></i>
							<?php endif; ?>
							<?php echo esc_html( $data_single['single_name'] . ' ' . $value ); ?>
						</span>
					<?php else : ?>
						<span class="item-label">
							<?php if ( ! empty( $data_single['font'] ) ) : ?>
								<i class="<?php echo esc_attr( $data_single['font'] ); ?>"></i>
							<?php endif; ?>
							<?php echo esc_html( apply_filters( 'stm_dynamic_string_translation', $data_single['single_name'], 'Listing Category ' . $data_single['single_name'] ) ); ?>
						</span>
						<span class="heading-font" title="<?php echo esc_attr( apply_filters( 'stm_dynamic_string_translation', $value, 'Listing Term ' . $value ) ); ?>">
							<?php if ( ! empty( $data_single['link'] ) ) : ?>
								<a href="<?php echo esc_url( $data_single['link'] ); ?>" target="_blank">
							<?php endif; ?>
							<?php echo esc_html( apply_filters( 'stm_dynamic_string_translation', $value, 'Listing Term ' . $value ) ); ?>
							<?php if ( ! empty( $data_single['link'] ) ) : ?>
								</a>
							<?php endif; ?>
						</span>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
<?php endif; ?>
