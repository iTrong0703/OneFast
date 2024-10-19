<?php
global $listing_id;

$listing_id    = ( is_null( $listing_id ) ) ? get_the_ID() : $listing_id;
$as_label      = apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_generated_title_as_label' );
$listing_title = apply_filters( 'stm_generate_title_from_slugs', get_the_title( $listing_id ), $listing_id, $as_label );

?>

<div class="stm-listing-single-price-title heading-font clearfix">
	<div class="stm-single-title-wrap">
		<<?php echo esc_attr( $title_tag ); ?> class="title">
			<?php echo wp_kses_post( $listing_title ); ?>
		</<?php echo esc_attr( $title_tag ); ?>>
		<?php if ( $added_date ) : ?>
			<span class="normal_font">
				<?php echo wp_kses( apply_filters( 'stm_dynamic_icon_output', $date_added_icon ), apply_filters( 'stm_ew_kses_svg', array() ) ); ?>
				<?php
					// translators: %s: Added date.
					printf( esc_html__( 'ADDED: %s', 'motors-car-dealership-classified-listings-pro' ), wp_kses_post( get_the_date( 'F d, Y' ) ) );
				?>
			</span>
		<?php endif; ?>
	</div>
</div>
