<?php

require_once STM_LISTINGS_PATH . '/includes/admin/page_generator/api/page_generator.php';

add_filter(
	'wpcfto_field_page_generator_field',
	function () {
		return STM_LISTINGS_PATH . '/includes/admin/page_generator/field.php';
	}
);
