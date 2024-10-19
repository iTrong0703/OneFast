<?php
$filter_badges = stm_get_filter_badges();
if ( ! empty( $filter_badges ) ) : ?>
	<div class="stm-filter-chosen-units">
		<ul class="stm-filter-chosen-units-list">
			<?php foreach ( $filter_badges as $badge => $badge_info ) : ?>
				<li>
					<?php if ( ! empty( $badge_info['name'] ) ) : ?>
						<span><?php echo esc_html( apply_filters( 'stm_dynamic_string_translation', $badge_info['name'], 'Filter Badge Name' ) ); ?>: </span>
					<?php endif; ?>
					<?php echo wp_kses_post( str_replace( '\\', '', $badge_info['value'] ) ); ?>
					<i data-url="<?php echo esc_url( $badge_info['url'] ); ?>"
					data-type="<?php echo esc_attr( $badge_info['type'] ); ?>"
					data-slug="<?php echo esc_attr( $badge_info['slug'] ); ?>"
					data-multiple="<?php echo ! empty( $badge_info['multiple'] ) ? esc_attr( $badge_info['multiple'] ) : ''; ?>"
					class="fas fa-times stm-clear-listing-one-unit stm-clear-listing-one-unit-classic"></i>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
<?php endif; ?>
