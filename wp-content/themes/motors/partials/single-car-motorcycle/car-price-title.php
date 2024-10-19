<?php
$price                = get_post_meta( get_the_ID(), 'price', true );
$sale_price           = get_post_meta( get_the_ID(), 'sale_price', true );
$car_price_form_label = get_post_meta( get_the_ID(), 'car_price_form_label', true );

$regular_price_label = get_post_meta( get_the_ID(), 'regular_price_label', true );
$special_price_label = get_post_meta( get_the_ID(), 'special_price_label', true );
?>

<div class="stm-listing-single-price-title heading-font clearfix">
	<?php if ( ! empty( $car_price_form_label ) ) : ?>
		<div class="price_unit">
			<div class="price">
				<div class="inner">
					<?php echo esc_attr( $car_price_form_label ); ?>
				</div>
			</div>
		</div>
	<?php else : ?>
		<div class="price_unit">
			<?php if ( ! empty( $sale_price ) ) : ?>
				<div class="sale-price">
					<div class="inner">
						<?php if ( ! empty( $regular_price_label ) ) : ?>
							<div class="stm_label"><?php echo esc_attr( $regular_price_label ); ?></div>
						<?php endif; ?>
						<del><?php echo wp_kses_post( apply_filters( 'stm_filter_price_view', '', $price ) ); ?></del>
					</div>
				</div>
				<div class="price">
					<div class="inner">
						<?php if ( ! empty( $special_price_label ) ) : ?>
							<div class="stm_label"><?php echo esc_attr( $special_price_label ); ?></div>
						<?php endif; ?>
						<?php echo wp_kses_post( apply_filters( 'stm_filter_price_view', '', $sale_price ) ); ?>
					</div>
				</div>
			<?php elseif ( ! empty( $price ) ) : ?>
				<div class="price">
					<div class="inner">
						<?php if ( ! empty( $regular_price_label ) ) : ?>
							<div class="stm_label"><?php echo wp_kses_post( $regular_price_label ); ?></div>
						<?php endif; ?>
						<?php echo wp_kses_post( apply_filters( 'stm_filter_price_view', '', $price ) ); ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	<?php endif; ?>
	<h1 class="title">
		<?php echo wp_kses_post( apply_filters( 'stm_generate_title_from_slugs', get_the_title( get_the_ID() ), get_the_ID(), true ) ); ?>
	</h1>
</div>
