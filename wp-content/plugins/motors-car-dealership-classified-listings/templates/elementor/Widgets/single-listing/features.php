<?php
global $listing_id;

$listing_id       = ( is_null( $listing_id ) ) ? get_the_ID() : $listing_id;
$features         = get_post_meta( $listing_id, 'additional_features', true );
$features         = explode( ',', $features );
$feature_settings = apply_filters( 'motors_vl_get_nuxy_mod', array(), 'fs_user_features' );
$grouped_list     = ( ! empty( $feature_settings ) ) ? 'grouped_features' : '';
$mlt_post_type    = get_post_type( get_the_ID() );

if ( 'listings' !== $mlt_post_type ) {
	$mlt_theme_options = get_option( 'stm_motors_listing_types', array() );

	if ( ! empty( $mlt_theme_options[ $mlt_post_type . '_fs_user_features' ] ) ) {
		$feature_settings = $mlt_theme_options[ $mlt_post_type . '_fs_user_features' ];
	} else {
		$features = array();
	}
}

?>
	<div class="stm-single-listing-car-features <?php echo esc_attr( $grouped_list ); ?>">
	<?php if ( ! empty( $features ) ) : ?>
		<div class="lists-<?php echo esc_attr( $features_type ); ?>">
			<?php if ( ! empty( $feature_settings ) ) : ?>
				<?php
				foreach ( $feature_settings as $k => $values ) :
					if ( count( $values['tab_title_selected_labels'] ) === 0 || count( array_intersect( $features, array_column( $values['tab_title_selected_labels'], 'label' ) ) ) === 0 ) {
						continue;
					}
					?>
					<div class="grouped_checkbox-<?php echo esc_attr( $features_rows ); ?>">
						<h4><?php echo ( ! empty( $values['tab_title_single'] ) ) ? esc_html( $values['tab_title_single'] ) : ''; ?></h4>
						<ul>
							<?php foreach ( $values['tab_title_selected_labels'] as $key => $feature ) : ?>
								<?php if ( in_array( $feature['label'], $features, true ) ) : ?>
									<li>
										<?php echo wp_kses( apply_filters( 'stm_dynamic_icon_output', $features_icon ), apply_filters( 'stm_ew_kses_svg', array() ) ); ?>
										<span><?php echo esc_html( apply_filters( 'stm_dynamic_string_translation', $feature['label'], 'Car feature ' . $feature['label'] ) ); ?></span>
									</li>
								<?php endif; ?>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endforeach; ?>
			<?php else : ?>
				<ul>
					<?php foreach ( $features as $key => $feature ) : ?>
						<?php
						if ( empty( $feature ) ) {
							continue;
						}
						?>
						<li class="row-<?php echo esc_attr( $features_rows ); ?>">
							<?php echo wp_kses( apply_filters( 'stm_dynamic_icon_output', $features_icon ), apply_filters( 'stm_ew_kses_svg', array() ) ); ?>
							<span><?php echo esc_html( apply_filters( 'stm_dynamic_string_translation', $feature, 'Car feature ' . $feature ) ); ?></span>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
	<?php endif; ?>
	</div>
