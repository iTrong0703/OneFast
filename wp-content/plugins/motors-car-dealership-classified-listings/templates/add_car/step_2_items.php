<?php
/**
 * @var $user_features
 * */

defined( 'ABSPATH' ) || exit;

$_id = apply_filters( 'stm_listings_input', null, 'item_id' );

if ( ! empty( $user_features ) && is_array( $user_features ) ) :
	if ( ! empty( $id ) ) {
		$features_car = get_post_meta( $id, 'additional_features', true );
		$features_car = explode( ',', addslashes( $features_car ) );
	} else {
		$features_car = array();
	}

	foreach ( $user_features as $item ) :
		?>
		<?php if ( isset( $item['tab_title_single'] ) ) : ?>
			<div class="stm-single-feature">
				<div class="heading-font"><?php echo esc_html( $item['tab_title_single'] ); ?></div>
				<?php
				$features = $item['tab_title_selected_labels'];

				if ( ! empty( $features ) ) :
					foreach ( $features as $feature ) :
						?>
						<div class="feature-single">
							<label>
								<input
									type="checkbox"
									value="<?php echo esc_attr( $feature['value'] ); ?>"
									name="stm_car_features_labels[]"
									<?php checked( in_array( $feature['value'], $features_car, true ) ); ?>
								>
								<span><?php echo esc_attr( $feature['label'] ); ?></span>
							</label>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		<?php endif; ?>
		<?php
	endforeach;
endif;
