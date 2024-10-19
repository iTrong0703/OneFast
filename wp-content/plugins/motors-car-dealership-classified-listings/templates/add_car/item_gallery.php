<?php
defined( 'ABSPATH' ) || exit;

$item_id = $id ?? 0;

if ( ! empty( apply_filters( 'stm_listings_input', null, 'item_id' ) ) ) {
	$item_id = apply_filters( 'stm_listings_input', null, 'item_id' );
}

$content = apply_filters( 'motors_vl_get_nuxy_mod', '', 'addl_gallery_content' );
?>

<div class="stm-form-3-photos clearfix">
	<?php
		$vars['step_title']  = __( 'Upload photo', 'stm_vehicles_listing' );
		$vars['step_number'] = 3;
		do_action( 'stm_listings_load_template', 'add_car/step-title', $vars );
	?>
	<div class="stm-media-car-add-nitofication">
		<?php
		if ( ! empty( $content ) ) {
			echo wp_kses_post( $content );
		}
		?>
	</div>

	<input
			type="file"
			id="stm_car_gallery_add"
			accept="image/*"
			name="stm_car_gallery_add"
			multiple>

	<!--Check if user not editing existing images-->
	<div class="stm-add-media-car">
		<div class="stm-media-car-gallery clearfix">
			<?php
			if ( empty( $item_id ) ) :
				do_action( 'stm_listings_load_template', 'add_car/image-gallery' );
			else :
				$_thumbnail_id = get_post_thumbnail_id( $item_id );
				$gallery       = get_post_meta( $item_id, 'gallery', true );

				if ( empty( $gallery ) || ! is_array( $gallery ) ) {
					$gallery = array();
				}

				if ( ! empty( $_thumbnail_id ) ) {
					array_unshift( $gallery, $_thumbnail_id );
				}

				$images_js = array();

				if ( ! empty( $gallery ) ) :
					$gallery   = array_values( array_unique( $gallery ) );
					$increment = 0;

					foreach ( $gallery as $gallery_key => $gallery_id ) :
						if ( ! wp_attachment_is_image( $gallery_id ) ) {
							continue;
						}

						$images_js[] = intval( $gallery_id );

						do_action(
							'stm_listings_load_template',
							'add_car/image-gallery',
							array(
								'attachment_id' => $gallery_id,
								'item_id'       => $increment,
							)
						);

						$increment ++;
					endforeach;
				endif;

				do_action( 'stm_listings_load_template', 'add_car/image-gallery' );
				?>

				<?php // phpcs:disable ?>
				<script type="text/javascript">
                    var stmUserFilesLoaded = [
						<?php echo implode( ',', $images_js ); ?>
                    ]
				</script>
				<?php // phpcs:enable ?>
			<?php endif; ?>
		</div>
	</div>
</div>
