<?php
$gallery_hover_interaction = apply_filters( 'motors_vl_get_nuxy_mod', false, 'gallery_hover_interaction' );
$car_price_form_label      = get_post_meta( get_the_ID(), 'car_price_form_label', true );

$img_size        = 'stm-img-255';
$img_size_retina = 'stm-img-398-x-2';

if ( ! empty( $args['custom_img_size'] ) ) {
	$img_size        = $args['custom_img_size'];
	$img_size_retina = ( has_image_size( $args['custom_img_size'] . '-x-2' ) ) ? $args['custom_img_size'] . '-x-2' : null;
}
?>

<div class="stm-template-front-loop <?php echo ( intval( $current_vehicle_id ) === get_the_ID() ) ? 'current' : ''; ?>">
	<a href="<?php the_permalink(); ?>" class="rmv_txt_drctn xx">
		<div class="image <?php echo ( ! has_post_thumbnail() ) ? esc_attr( 'empty-image' ) : ''; ?>">
			<?php
			if ( has_post_thumbnail() ) :
				$img_2x = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $img_size_retina );

				if ( true === $gallery_hover_interaction && ! wp_is_mobile() ) {
					?>
					<div class="image-wrap">
						<?php do_action( 'stm_listings_load_template', '/loop/badge' ); ?>
						<?php do_action( 'stm_listings_load_template', '/loop/image-preview' ); ?>
						<div class="listing-car-item-meta">
							<?php do_action( 'stm_listings_load_template', '/loop/list/price' ); ?>
						</div>
					</div>
					<?php
				} else {
					if ( get_post_thumbnail_id( get_the_ID() ) ) {
						echo wp_get_attachment_image(
							get_post_thumbnail_id( get_the_ID() ),
							$img_size,
							false,
							array(
								'data-retina' => $img_2x[0],
								'alt'         => get_the_title(),
							)
						);
					}

					do_action( 'stm_listings_load_template', '/loop/badge' );

					?>
					<div class="listing-car-item-meta">
						<?php do_action( 'stm_listings_load_template', 'loop/list/price' ); ?>
					</div>
					<?php
				}
			else :
				if ( stm_check_if_car_imported( get_the_id() ) ) :
					?>
					<img
							src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/Car.jpg' ); ?>"
							class="img-responsive placeholder"
							alt="<?php esc_attr_e( 'Placeholder', 'stm_vehicles_listing' ); ?>"
					/>
					<?php
				else :
					?>
					<img
							src="<?php echo esc_url( STM_LISTINGS_URL . '/assets/images/plchldr350.png' ); ?>"
							class="img-responsive"
							alt="<?php esc_attr_e( 'Placeholder', 'stm_vehicles_listing' ); ?>"
					/>
					<?php
				endif;
				do_action( 'stm_listings_load_template', '/loop/badge' );
				?>
				<div class="listing-car-item-meta">
					<?php do_action( 'stm_listings_load_template', 'loop/list/price' ); ?>
				</div>
			<?php endif; ?>
		</div>
		<div class="listing-car-item-meta">
			<div class="car-meta-top heading-font clearfix">
				<div class="car-title">
					<?php
					echo esc_attr( trim( preg_replace( '/\s+/', ' ', substr( apply_filters( 'stm_generate_title_from_slugs', get_the_title( get_the_ID() ), get_the_ID() ), 0, 35 ) ) ) );

					if ( strlen( apply_filters( 'stm_generate_title_from_slugs', get_the_title( get_the_ID() ), get_the_ID() ) ) > 35 ) {
						echo esc_attr( '...' );
					}
					?>
				</div>
			</div>
		</div>
	</a>
</div>
