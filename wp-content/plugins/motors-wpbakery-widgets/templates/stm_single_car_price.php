<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );

$template = ( apply_filters( 'stm_is_aircrafts', false ) ) ? 'aircraft' : 'car';
do_action( 'stm_listings_load_template', 'single-car/' . $template . '-price' );

