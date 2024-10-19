<?php
$listing_list_sort_slug = apply_filters( 'motors_vl_get_nuxy_mod', 'make', 'listing_list_sort_slug' );
if ( ! empty( $listing_list_sort_slug ) ) {
	$listing_list_sort_slug = apply_filters( 'stm_vl_get_all_by_slug', array(), $listing_list_sort_slug );
}
$data = apply_filters( 'stm_get_car_archive_listings', array() );
?>
<div class="stm-sort-list-params">
	<ul class="heading-font clearfix">
		<?php if ( ! empty( $listing_list_sort_slug ) ) : ?>
			<li class="main" data-sort="none" data-filter="<?php echo esc_attr( $listing_list_sort_slug['slug'] ); ?>">
				<span><?php echo esc_html( apply_filters( 'stm_dynamic_string_translation', $listing_list_sort_slug['single_name'], 'Sort param ' . $listing_list_sort_slug['single_name'] ) ); ?></span>
			</li>
		<?php endif; ?>
		<?php if ( ! empty( $data ) ) : ?>
			<?php foreach ( $data as $single_data ) : ?>
				<li class="<?php echo esc_html__( $single_data['slug'], 'stm_vehicles_listing' ); ?>" data-sort="none" data-filter="<?php echo esc_html_e( $single_data['slug'], 'stm_vehicles_listing' );//phpcs:ignore ?>">
					<span><?php echo esc_html( apply_filters( 'stm_dynamic_string_translation', $single_data['single_name'], 'Sort param ' . $single_data['single_name'] ) ); ?></span>
				</li>
			<?php endforeach; ?>
			<li class="location" data-sort="none" data-filter="stm_car_location">
				<span><?php esc_html_e( 'Location', 'stm_vehicles_listing' ); ?></span>
			</li>
		<?php endif; ?>
		<li class="price-main" data-sort="none" data-filter="price">
			<span><?php esc_html_e( 'Price', 'stm_vehicles_listing' ); ?></span>
		</li>
	</ul>
</div>
<?php // @codingStandardsIgnoreStart ?>
<script>
	(function ($) {
		"use strict";
		$(document).ready(function () {
			$('body').on('click', '.stm-sort-list-params ul li', function (e) {
				var $sort = $(this).attr('data-sort');
				
				if ($sort == 'none' || $sort == 'high') {
					stm_isotope_sort_function_horizontal($(this).attr('data-filter') + '_low');
					$('.stm-sort-list-params ul li').attr('data-sort', 'none');
					$(this).attr('data-sort', 'low');
				}
				
				if ($sort == 'low') {
					stm_isotope_sort_function_horizontal($(this).attr('data-filter') + '_high');
					$('.stm-sort-list-params ul li').attr('data-sort', 'none');
					$(this).attr('data-sort', 'high');
				}
			});
		});
		
	})(jQuery);
	
	function stm_isotope_sort_function_horizontal(currentChoice) {
		var $ = jQuery;
		var stm_choice = currentChoice;
		var $container = $('.stm-isotope-sorting');
		switch (stm_choice) {
	
	<?php
		if ( ! empty( $listing_list_sort_slug ) ) {
			stm_display_script_sort( $listing_list_sort_slug );
		};
		if ( ! empty( $data ) ) {
			foreach ( $data as $single_data ) {
				stm_display_script_sort( $single_data );
			}
		}
		stm_display_script_sort( array( 'slug' => 'price', 'numeric' => 1 ) );
		?>
			default:
			
		}
		
		// $container.isotope('updateSortData').isotope();
		$('img').trigger('appear');
	}
</script>
<?php // @codingStandardsIgnoreEnd ?>
