<div class="stm-sort-by-options clearfix">
	<span><?php esc_html_e( 'Sort by:', 'motors-car-dealership-classified-listings-pro' ); ?></span>
	<div class="stm-select-sorting">
		<select>
			<?php echo wp_kses_post( apply_filters( 'stm_get_sort_options_html', '' ) ); ?>
		</select>
	</div>
</div>
