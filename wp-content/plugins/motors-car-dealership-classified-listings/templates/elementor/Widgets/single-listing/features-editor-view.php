<?php
global $listing_id;

$features = array(
	'ABS',
	'Central locking',
	'Cruise Control',
	'Air Conditioning',
	'Bluetooth',
	'Power Windows',
	'Parking Sensors',
	'Keyless Entry',
	'Sunroof',
	'Alloy Wheels',
	'Navigation System',
	'Leather Seats',
	'Heated Seats',
	'Traction Control',
	'Rearview Camera',
	'Autopilot',
);

$feature_settings = apply_filters( 'motors_vl_get_nuxy_mod', array(), 'fs_user_features' );
$grouped_list     = ( ! empty( $feature_settings ) ) ? 'grouped_features' : '';

if ( ! empty( $features ) ) :
	?>
	<div class="stm-single-listing-car-features <?php echo esc_attr( $grouped_list ); ?>">
		<div class="lists-<?php echo esc_attr( $features_type ); ?>">
			<?php if ( ! empty( $feature_settings ) ) : ?>
				<?php foreach ( $feature_settings as $k => $values ) : ?>
					<div class="grouped_checkbox-<?php echo esc_attr( $features_rows ); ?>">
						<h4><?php echo esc_html( $values['tab_title_single'] ); ?></h4>
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
						<li class="row-<?php echo esc_attr( $features_rows ); ?>">
							<?php echo wp_kses( apply_filters( 'stm_dynamic_icon_output', $features_icon ), apply_filters( 'stm_ew_kses_svg', array() ) ); ?>
							<span><?php echo esc_html( apply_filters( 'stm_dynamic_string_translation', $feature, 'Car feature ' . $feature ) ); ?></span>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>
