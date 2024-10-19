<?php // phpcs:disable ?>
<script type="text/javascript">
	jQuery(function ($) {
		let options = <?php echo wp_json_encode( apply_filters( 'stm_data_binding_func', array(), true, true ) ); ?>;

		$.each(options, function (slug, config) {
			config.selector = '.add_a_car-select-' + slug;
		});

		$('.stm_add_car_form .stm_add_car_form_1').each(function () {
			new STMCascadingSelect(this, options);
		});
	});
</script>
<?php // phpcs:enable ?>
