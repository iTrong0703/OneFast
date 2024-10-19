<?php
global $listing_id;

$listing_id = ( is_null( $listing_id ) ) ? get_the_ID() : $listing_id;

$price                = get_post_meta( $listing_id, 'price', true );
$sale_price           = get_post_meta( $listing_id, 'sale_price', true );
$car_price_form_label = get_post_meta( $listing_id, 'car_price_form_label', true );

if ( ! empty( $show_custom_label ) && 'yes' === $show_custom_label ) {
	$regular_price_label = get_post_meta( $listing_id, 'regular_price_label', true );
	$special_price_label = get_post_meta( $listing_id, 'special_price_label', true );
}

if ( empty( $detailed_view ) && ! empty( $sale_price ) ) {
	$price = $sale_price;
}

$as_sold = get_post_meta( $listing_id, 'car_mark_as_sold', true );
?>

<div class="stm-listing-single-price-title heading-font clearfix">
	<?php if ( ! $as_sold ) : ?>
		<?php if ( ! empty( $car_price_form_label ) ) : ?>
			<a href="#" class="rmv_txt_drctn archive_request_price" data-toggle="modal" data-target="#get-car-price" data-title="<?php echo esc_attr( get_the_title( $listing_id ) ); ?>" data-id="<?php echo esc_attr( $listing_id ); ?>">
				<div class="price"><?php echo esc_attr( $car_price_form_label ); ?></div>
			</a>
		<?php else : ?>
			<?php if ( ! empty( $price ) && ! empty( $sale_price ) && 'yes' === $detailed_view ) : ?>
				<div class="price discounted-price">
					<div class="regular-price">
						<?php if ( ! empty( $special_price_label ) ) : ?>
							<span class="label-price"><?php echo esc_attr( $regular_price_label ); ?></span>
						<?php endif; ?>
						<span class="value"><?php echo esc_attr( apply_filters( 'stm_filter_price_view', '', $price ) ); ?></span>
					</div>
					<div class="sale-price">
						<?php if ( ! empty( $regular_price_label ) ) : ?>
							<span class="label-price"><?php echo esc_attr( $special_price_label ); ?></span>
						<?php endif; ?>
						<span class="value"><?php echo esc_attr( apply_filters( 'stm_filter_price_view', '', $sale_price ) ); ?></span>
					</div>
				</div>
			<?php elseif ( ! empty( $price ) ) : ?>
				<div class="price"><?php echo wp_kses_post( apply_filters( 'stm_filter_price_view', '', $price ) ); ?></div>
			<?php endif; ?>
		<?php endif; ?>
	<?php else : ?>
		<div class="price"><?php echo esc_html__( 'Sold', 'motors-car-dealership-classified-listings-pro' ); ?></div>
	<?php endif; ?>
</div>
