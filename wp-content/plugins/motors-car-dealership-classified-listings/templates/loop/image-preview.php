<?php
$view_type                 = ( ! empty( $view_type ) ) ? $view_type : apply_filters( 'motors_vl_get_nuxy_mod', 'list', 'listing_view_type' );
$image_size                = ( ! apply_filters( 'stm_is_motors_theme', false ) ) ? 'medium' : ( ( 'grid' === $view_type ) ? 'stm-img-255' : 'stm-img-280' );
$thumb_width               = ( 'grid' === $view_type ) ? 255 : 280;
$grid_col_w                = ( 'grid' === $view_type ) ? '(max-width: 1023px) 33vw, ' : '';
$placeholder_path          = ( apply_filters( 'stm_is_motors_theme', false ) ) ? get_stylesheet_directory_uri() . '/assets/images/plchldr255.png' : STM_LISTINGS_URL . '/assets/images/plchldr255.png';
$gallery_hover_interaction = apply_filters( 'motors_vl_get_nuxy_mod', false, 'gallery_hover_interaction' );
$thumbs                    = ( $gallery_hover_interaction ) ? apply_filters( 'stm_get_hoverable_thumbs', array(), get_the_ID(), $image_size ) : array();

?>

<?php if ( ! $gallery_hover_interaction || empty( $thumbs['gallery'] ) || 1 === count( $thumbs['gallery'] ) ) : ?>

	<img
		<?php if ( has_post_thumbnail() ) : ?>
			src="<?php echo esc_url( wp_get_attachment_image_url( get_post_thumbnail_id( get_the_ID() ), $image_size ) ); ?>"
			srcset="<?php echo esc_attr( wp_get_attachment_image_srcset( get_post_thumbnail_id( get_the_ID() ), $image_size ) ); ?>"
			sizes="(max-width: 767px) 100vw, <?php echo esc_attr( $grid_col_w ); ?> <?php echo esc_attr( $thumb_width ); ?>px"
			alt="<?php echo esc_attr( get_the_title() ); ?>"
		<?php else : ?>
			src="<?php echo esc_url( $placeholder_path ); ?>"
			alt="<?php esc_attr_e( 'Placeholder', 'stm_vehicles_listing' ); ?>"
		<?php endif; ?>
		class="img-responsive" loading="lazy"
	/>

<?php else : ?>

	<?php
	$array_keys    = array_keys( $thumbs['gallery'] );
	$last_item_key = array_pop( $array_keys );
	?>
	<div class="interactive-hoverable">
		<div class="hoverable-wrap">
			<?php foreach ( $thumbs['gallery'] as $key => $img_url ) : ?>
				<div class="hoverable-unit <?php echo ( 0 === $key ) ? 'active' : ''; ?>">
					<div class="thumb">
						<?php if ( $key === $last_item_key && 5 === count( $thumbs['gallery'] ) && 0 < $thumbs['remaining'] ) : ?>
							<div class="remaining">
								<i class="motors-icons-album"></i>
								<p>
									<?php
									echo esc_html(
										sprintf(
										/* translators: number of remaining photos */
											_n( '%d more photo', '%d more photos', $thumbs['remaining'], 'stm_vehicles_listing' ),
											$thumbs['remaining']
										)
									);
									?>
								</p>
							</div>
						<?php endif; ?>
						<img
								src="<?php echo esc_url( is_array( $img_url ) ? $img_url[0] : $img_url ); ?>"
								srcset="<?php echo esc_attr( wp_get_attachment_image_srcset( $thumbs['ids'][ $key ], $image_size ) ); ?>"
								sizes="(max-width: 767px) 100vw, <?php echo esc_attr( $grid_col_w ); ?> <?php echo esc_attr( $thumb_width ); ?>px"
								alt="<?php echo esc_attr( get_the_title() ); ?>" class="img-responsive" loading="lazy" />
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<div class="hoverable-indicators">
			<?php foreach ( $thumbs['gallery'] as $key => $thumb ) : ?>
				<div class="indicator <?php echo ( 0 === $key ) ? 'active' : ''; ?>"></div>
			<?php endforeach; ?>
		</div>
	</div>

<?php endif; ?>
