<?php
$selling_online_global = apply_filters( 'motors_vl_get_nuxy_mod', false, 'enable_woo_online' );
$sell_online           = ( $selling_online_global ) ? ! empty( get_post_meta( get_the_ID(), 'car_mark_woo_online', true ) ) : false;

$as_label = apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_generated_title_as_label' );
?>
<div class="car-meta-top heading-font clearfix">
	<?php if ( $sell_online && empty( $car_price_form_label ) ) : ?>
		<?php
		if ( ! empty( $sale_price ) ) {
			$price = $sale_price;
		}
		?>
		<div class="sell-online-wrap price">
			<div class="normal-price">
				<span class="normal_font"><?php echo esc_html__( 'BUY ONLINE', 'stm_vehicles_listing' ); ?></span>
				<span class="heading-font"><?php echo esc_attr( apply_filters( 'stm_filter_price_view', '', $price ) ); ?></span>
			</div>
		</div>
	<?php else : ?>
		<?php if ( empty( $car_price_form_label ) ) : ?>
			<?php if ( ! empty( $price ) && ! empty( $sale_price ) && $price !== $sale_price ) : ?>
				<div class="price discounted-price">
					<div class="regular-price"><?php echo esc_attr( apply_filters( 'stm_filter_price_view', '', $price ) ); ?></div>
					<div class="sale-price"><?php echo esc_attr( apply_filters( 'stm_filter_price_view', '', $sale_price ) ); ?></div>
				</div>
			<?php elseif ( ! empty( $price ) ) : ?>
				<div class="price">
					<div class="normal-price"><?php echo esc_attr( apply_filters( 'stm_filter_price_view', '', $price ) ); ?></div>
				</div>
			<?php endif; ?>
		<?php else : ?>
			<div class="price">
				<div class="normal-price"><?php echo esc_attr( $car_price_form_label ); ?></div>
			</div>
		<?php endif; ?>
	<?php endif; ?>
	<div class="car-title" data-max-char="<?php echo esc_attr( apply_filters( 'motors_vl_get_nuxy_mod', 44, 'grid_title_max_length' ) ); ?>">
		<?php echo wp_kses_post( trim( apply_filters( 'stm_generate_title_from_slugs', get_the_title( get_the_ID() ), get_the_ID(), $as_label ) ) ); ?>
	</div>
</div>
