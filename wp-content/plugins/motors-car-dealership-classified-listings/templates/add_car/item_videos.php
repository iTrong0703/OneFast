<?php
defined( 'ABSPATH' ) || exit;

$item_id = $id ?? 0;

if ( ! empty( apply_filters( 'stm_listings_input', null, 'item_id' ) ) ) {
	$item_id = apply_filters( 'stm_listings_input', null, 'item_id' );
}

$content = apply_filters( 'motors_vl_get_nuxy_mod', '', 'addl_video_content' );
?>
<div class="stm-form-4-videos clearfix">
	<?php
	$vars['step_title']  = __( 'Add Videos', 'stm_vehicles_listing' );
	$vars['step_number'] = 4;
	do_action( 'stm_listings_load_template', 'add_car/step-title', $vars );

	if ( empty( $id ) ) :
		?>
		<div class="stm-add-videos-unit">
			<div class="row">
				<div class="col-md-6 col-sm-12">
					<div class="stm-video-units">
						<div class="stm-video-link-unit-wrap">
							<div class="heading-font">
								<span class="video-label">
									<?php esc_html_e( 'Video link', 'stm_vehicles_listing' ); ?>
								</span>
								<span class="count">1</span>
							</div>
							<div class="stm-video-link-unit">
								<input
									type="text"
									aria-label="<?php esc_attr_e( 'Video link', 'stm_vehicles_listing' ); ?>"
									name="stm_video[]"/>
								<div class="stm-after-video"></div>
							</div>
						</div>
					</div>
				</div>
				<?php if ( ! empty( $content ) ) : ?>
					<div class="col-md-6 col-sm-12">
						<div class="stm-simple-notice">
							<i class="fas fa-info-circle"></i>
							<?php echo wp_kses_post( $content ); ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<?php
	else :
		$video      = get_post_meta( $item_id, 'gallery_video', true );
		$has_videos = ( ! empty( $video ) );
		?>
		<div class="stm-add-videos-unit">
			<div class="row">
				<div class="col-md-6 col-sm-12">
					<div class="stm-video-units">
						<div class="stm-video-link-unit-wrap">
							<div class="heading-font">
								<span class="video-label">
									<?php esc_html_e( 'Video link', 'stm_vehicles_listing' ); ?>
								</span>
								<span class="count">1</span>
							</div>
							<div class="stm-video-link-unit">
								<input
									type="text"
									aria-label="<?php esc_attr_e( 'Video link', 'stm_vehicles_listing' ); ?>"
									name="stm_video[]"
									value="<?php echo esc_url( $video ); ?>"/>
								<div class="stm-after-video active"></div>
							</div>
							<?php
							if ( $has_videos ) :
								$gallery_videos = get_post_meta( $item_id, 'gallery_videos', true );
								if ( ! empty( $gallery_videos ) ) :
									foreach ( $gallery_videos as $gallery_video ) :
										?>
										<div class="stm-video-link-unit">
											<input
												type="text"
												aria-label="<?php esc_attr_e( 'Video link', 'stm_vehicles_listing' ); ?>"
												name="stm_video[]"
												value="<?php echo esc_url( $gallery_video ); ?>"/>
											<div class="stm-after-video active"></div>
										</div>
										<?php
									endforeach;
								endif;
							endif;
							?>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-sm-12">
					<div class="stm-simple-notice">
						<i class="fas fa-info-circle"></i>
						<?php echo wp_kses_post( $content ); ?>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
</div>
