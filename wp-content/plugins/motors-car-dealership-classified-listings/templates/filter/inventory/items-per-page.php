<?php
global $wp_query;
$listing_grid_choices_option = apply_filters( 'motors_vl_get_nuxy_mod', '', 'listing_grid_choices' );
$listing_grid_choices        = explode( ',', $listing_grid_choices_option );
$view_type                   = sanitize_file_name( apply_filters( 'stm_listings_input', apply_filters( 'motors_vl_get_nuxy_mod', 'list', 'listing_view_type' ), 'view_type' ) );
$listing_grid_choice         = ( ! empty( get_post_meta( apply_filters( 'stm_listings_user_defined_filter_page', '' ), ( 'grid' === $view_type ) ? 'ppp_on_grid' : 'ppp_on_list', true ) ) ) ? get_post_meta( apply_filters( 'stm_listings_user_defined_filter_page', '' ), ( 'grid' === $view_type ) ? 'ppp_on_grid' : 'ppp_on_list', true ) : get_option( 'posts_per_page' );
$horizontal_filter           = apply_filters( 'motors_vl_get_nuxy_mod', false, 'listing_horizontal_filter' );

if ( ! empty( $_GET['posts_per_page'] ) ) {//phpcs:ignore
	$listing_grid_choice = intval( $_GET['posts_per_page'] );//phpcs:ignore
} elseif ( ! empty( $listing_grid_choices ) && $listing_grid_choices[0] ) {
	$listing_grid_choice = intval( $listing_grid_choices[0] );
}

if ( ! in_array( $listing_grid_choice, $listing_grid_choices, true ) ) {
	$listing_grid_choices[] = intval( $listing_grid_choice );
}


$style = ( ! $listing_grid_choices_option ) ? 'display:none;' : '';

if ( ! empty( $listing_grid_choices ) ) : ?>
	<div class="stm-inventory-items-per-page-wrap" style="<?php echo esc_attr( $style ); ?>">
		<?php if ( ! $horizontal_filter ) : ?>
			<span class="stm_label heading-font"><?php esc_html_e( 'Vehicles per page:', 'stm_vehicles_listing' ); ?></span>
		<?php else : ?>
			<span class="first"><?php esc_html_e( 'Show', 'stm_vehicles_listing' ); ?></span>
		<?php endif; ?>
		<?php if ( ! $horizontal_filter ) : ?>
		<div class="stm_per_page">
			<?php endif; ?>
			<ul>
				<?php foreach ( $listing_grid_choices as $listing_grid_choice_single ) : ?>
					<?php
					if ( 0 === (int) $listing_grid_choice_single ) {
						continue;
					}
					if ( (int) $listing_grid_choice_single === (int) $listing_grid_choice ) {
						$active = 'active';
					} else {
						$active = '';
					}

					$link = add_query_arg( array( 'posts_per_page' => intval( $listing_grid_choice_single ) ) );//phpcs:ignore
					$link = preg_replace( '/\/page\/\d+/', '', remove_query_arg( array( 'paged', 'ajax_action' ), $link ) );
					?>

					<li class="<?php echo esc_attr( $active ); ?>">
						<span>
							<a href="<?php echo esc_url( $link ); ?>">
								<?php echo intval( $listing_grid_choice_single ); ?>
							</a>
						</span>
					</li>

				<?php endforeach; ?>
			</ul>
			<?php if ( ! $horizontal_filter ) : ?>
		</div>
	<?php endif; ?>
		<?php if ( $horizontal_filter ) : ?>
			<span class="last"><?php esc_html_e( 'items per page', 'stm_vehicles_listing' ); ?></span>
		<?php endif; ?>
	</div>
<?php endif; ?>
<script>
	var items_per_page = <?php echo esc_js( $listing_grid_choice ); ?>;
</script>
