<?php
/**
 * @var $custom_listing_type
 * @var $listing_types_options
 * */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( empty( $item_id ) ) {
	$item_id = 0;
}

if ( ! empty( apply_filters( 'stm_listings_input', null, 'item_id' ) ) ) {
	$item_id = apply_filters( 'stm_listings_input', null, 'item_id' );
}

if ( $custom_listing_type && $listing_types_options && isset( $listing_types_options[ $custom_listing_type . '_addl_gallery_content' ] ) ) {
	$content = $listing_types_options[ $custom_listing_type . '_addl_gallery_content' ];
} else {
	$content = apply_filters( 'motors_vl_get_nuxy_mod', '', 'addl_gallery_content' );
}

$max_file_size = apply_filters( 'stm_listing_media_upload_size', 1024 * 4000 ); /*4mb is the highest media upload here*/

$user_id = get_current_user_id();
$limits  = apply_filters(
	'stm_get_post_limits',
	array(
		'premoderation' => true,
		'posts_allowed' => 0,
		'posts'         => 0,
		'images'        => 0,
		'role'          => 'user',
	),
	$user_id
);

$crop                  = apply_filters( 'motors_vl_get_nuxy_mod', false, 'user_image_crop_checkbox' );
$width                 = apply_filters( 'motors_vl_get_nuxy_mod', 800, 'gallery_image_width' );
$height                = apply_filters( 'motors_vl_get_nuxy_mod', 600, 'gallery_image_height' );
$jsonMultiPlanImgLimit = ! empty( $limits['multi_plans_images_limit'] ) ? array() : 0;

if ( ! empty( $limits['multi_plans_images_limit'] ) ) {
	foreach ( $limits['multi_plans_images_limit'] as $key => $limit ) {
		$jsonMultiPlanImgLimit[ $key ] = array(
			'limit' => $limit['limit'],
			'text'  => sprintf(
			/* translators: %d: images limit */
				esc_html__( 'Sorry, you can upload only %d images per add', 'motors-car-dealership-classified-listings-pro' ),
				$limit['limit']
			),
		);
	}
}

if ( ! empty( $jsonMultiPlanImgLimit ) ) {
	$jsonMultiPlanImgLimit = wp_json_encode( $jsonMultiPlanImgLimit );
}
?>

<div class="stm-form-3-photos clearfix">
	<div class="stm-car-listing-data-single stm-border-top-unit">
		<div class="title heading-font"><?php esc_html_e( 'Upload photo', 'motors-car-dealership-classified-listings-pro' ); ?></div>
	</div>
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
				Motors_Elementor_Widgets_Free\Helpers\Helper::stm_ew_load_template(
					'elementor/Widgets/add-listing/parts/image-gallery',
					STM_LISTINGS_PATH
				);
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

						Motors_Elementor_Widgets_Free\Helpers\Helper::stm_ew_load_template(
							'elementor/Widgets/add-listing/parts/image-gallery',
							STM_LISTINGS_PATH,
							array(
								'attachment_id' => $gallery_id,
								'item_id'       => $increment,
							)
						);

						$increment ++;
					endforeach;
				endif;

				Motors_Elementor_Widgets_Free\Helpers\Helper::stm_ew_load_template(
					'elementor/Widgets/add-listing/parts/image-gallery',
					STM_LISTINGS_PATH
				);
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
