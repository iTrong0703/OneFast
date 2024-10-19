<?php
global $listing_id;

$listing_id = ( is_null( $listing_id ) ) ? get_the_ID() : $listing_id;

$listing_title = apply_filters( 'stm_generate_title_from_slugs', get_the_title( $listing_id ), $listing_id, false );
?>
<<?php echo esc_attr( $title_tag ); ?> class="title stm_listing_title">
<?php echo wp_kses_post( $listing_title ); ?>
</<?php echo esc_attr( $title_tag ); ?>>
