<?php
$filter            = apply_filters( 'stm_listings_filter_func', null, true );
$show_sold         = apply_filters( 'stm_me_get_nuxy_mod', '', 'show_sold_listings' );
$selected_position = apply_filters( 'motors_vl_get_nuxy_mod', 'bottom', 'position_keywords_search', false );
?>
<form action="<?php echo esc_url( apply_filters( 'stm_listings_current_url', '' ) ); ?>" method="get" data-trigger="filter">
	<div class="filter filter-sidebar stm-horizontal-filter-sidebar">
		<?php
		/**
		 * Hook: stm_listings_filter_before.
		 *
		 * @hooked stm_listings_parent_list_response - 10
		 */
		do_action( 'stm_listings_filter_before' );
		?>
		<div class="row row-pad-top-24">
			<div class="stm-horizontal-shorten-filter clearfix">
				<?php
				if ( empty( $filter['filters'] ) ) :
					$post_type_name = __( 'Listings', 'stm_vehicles_listing' );
					if ( stm_is_multilisting() ) {
						$ml = new STMMultiListing();
						if ( ! empty( $ml->stm_get_current_listing() ) ) {
							$multitype      = $ml->stm_get_current_listing();
							$post_type_name = $multitype['label'];
						}
					}
					?>
					<div class="col-md-12 col-sm-12">
						<p class="text-muted text-center">
							<?php
							/* translators: post type name */
							echo sprintf( esc_html__( 'No categories created for %s', 'stm_vehicles_listing' ), esc_html( $post_type_name ) );
							?>
						</p>
					</div>
					<?php
				else :
					$parent_list = apply_filters( 'stm_listings_parent_list', false );
					if ( ! is_array( $parent_list ) ) {
						$parent_list = array();
					}
					$close_filter = 0;
					foreach ( $filter['filters'] as $attribute => $config ) :
						if ( ! empty( $filter['options'][ $attribute ] ) ) :
							if ( ! empty( $config['slider'] ) ) :
								do_action(
									'stm_listings_load_template',
									'filter/types/slider',
									array(
										'taxonomy' => $config,
										'options'  => $filter['options'][ $attribute ],
									)
								);
							else :
								?>
						<div class="col-md-12 col-sm-6 stm-filter_<?php echo esc_attr( $attribute ); ?>">
							<div class="form-group">
								<?php
								do_action(
									'stm_listings_load_template',
									'filter/types/select',
									array(
										'options'   => $filter['options'][ $attribute ],
										'name'      => $attribute,
										'is_parent' => in_array( $attribute, $parent_list, true ),
										'multiple'  => array_key_exists( 'is_multiple_select', $config ) ? $config['is_multiple_select'] : false,
									)
								);
								?>
							</div>
						</div>
								<?php
							endif;
					endif;

						$close_filter ++;

						if ( 3 === $close_filter ) :
							?>
			</div>
			<div class="stm-horizontal-expand-filter col-md-12">
				<span><?php esc_html_e( 'More options', 'stm_vehicles_listing' ); ?></span></div>
			<script type="text/javascript">
							var stm_filter_expand_close = '<?php esc_html_e( 'Less options', 'stm_vehicles_listing' ); ?>';
			</script>
			<div class="stm-horizontal-longer-filter clearfix">
					<?php endif; ?>
				<?php endforeach; ?>
				<?php endif; ?>

				<?php if ( $show_sold ) : ?>
					<div class="col-md-12 col-sm-12 stm-filter_listing_status">
						<div class="form-group">
							<select name="listing_status" class="form-control">
								<option value="">
									<?php esc_html_e( 'Listing status', 'stm_vehicles_listing' ); ?>
								</option>
								<option value="active" <?php echo ( isset( $_GET['listing_status'] ) && 'active' === $_GET['listing_status'] ) ? 'selected' : ''; ?>>
									<?php esc_html_e( 'Active', 'stm_vehicles_listing' ); ?>
								</option>
								<option value="sold" <?php echo ( isset( $_GET['listing_status'] ) && 'sold' === $_GET['listing_status'] ) ? 'selected' : ''; ?>>
									<?php esc_html_e( 'Sold', 'stm_vehicles_listing' ); ?>
								</option>
							</select>
						</div>
					</div>
				<?php endif; ?>

				<?php
				do_action( 'stm_listings_load_template', 'filter/types/location' );

				do_action(
					'stm_listings_load_template',
					'filter/types/keywords',
					array(
						'position' => $selected_position,
					)
				);
				?>
			</div>
		</div>

		<!--View type-->
		<input type="hidden" id="stm_view_type" name="view_type" value="<?php echo esc_attr( apply_filters( 'stm_listings_input', null, 'view_type' ) ); ?>"/>
		<!--Filter links-->
		<input type="hidden" id="stm-filter-links-input" name="stm_filter_link" value=""/>
		<!--Popular-->
		<input type="hidden" name="popular" value="<?php echo esc_attr( apply_filters( 'stm_listings_input', null, 'popular' ) ); ?>"/>

		<input type="hidden" name="s" value="<?php echo esc_attr( apply_filters( 'stm_listings_input', null, 's' ) ); ?>"/>
		<input type="hidden" name="sort_order" value="<?php echo esc_attr( apply_filters( 'stm_listings_input', null, 'sort_order' ) ); ?>"/>

		<button id="stm-classic-filter-submit" class="stm-classic-filter-submit-horizontal heading-font" type="submit">
			<i class="motors-icons-search"></i>
			<span><?php echo intval( $filter['total'] ); ?></span>
			<?php esc_html_e( 'Items', 'stm_vehicles_listing' ); ?>
		</button>

		<?php do_action( 'stm_listings_filter_after' ); ?>
	</div>

	<?php do_action( 'stm_listings_load_template', 'filter/types/checkboxes', array( 'filter' => $filter ) ); ?>

</form>

<?php do_action( 'stm_listings_load_template', 'filter/types/links', array( 'filter' => $filter ) ); ?>
