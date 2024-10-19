<?php
function etm_load_template( $__template, $__vars = array() ) {
	extract( $__vars );
	include etm_locate_template( $__template );
}

add_action( 'etm_load_template', 'etm_load_template' );

function etm_locate_template( $templates ) {
	$located = false;

	foreach ( (array) $templates as $template ) {
		if ( substr( $template, - 4 ) !== '.php' ) {
			$template .= '.php';
		}

		if ( ! ( $located ) ) {
			$located = STM_LISTINGS_PATH . '/includes/class/Features/email_template_manager/templates/' . $template;
		}

		if ( file_exists( $located ) ) {
			break;
		}
	}

	return $located;
}
