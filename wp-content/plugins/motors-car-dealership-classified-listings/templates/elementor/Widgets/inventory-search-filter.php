<?php
	/**
	 * Elementor settings
	 * @var $filter
	 * @var $api_data
	 * @var $isf_mobile_btn_icon_position
	 * @var $search_options_icon
	 * @var $isf_title
	 * @var $show_sold
	 * @var $isf_icon_position
	 * @var $reset_btn_label
	 * */
?>

<script type="text/javascript">
	var rest_url = '<?php echo esc_js( get_rest_url( null, $api_data['path'] ) ); ?>';
	var rest_key = '<?php echo esc_js( $api_data['key'] ); ?>';
</script>
<?php if ( ! empty( $filter_bg ) ) { ?>
	<style>
		.stm-template-listing .filter-sidebar:after {
			background-image: url("<?php echo esc_url( $filter_bg ); ?>");
		}
	</style>
	<?php
}

if ( empty( $action ) ) {
	$action = 'listings-result'; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
}
?>
<div class="sticky-mobile-filter">
	<div class="mobile-filter">
		<div class="mobile-search-btn icon-<?php echo esc_attr( $isf_mobile_btn_icon_position ); ?>">
			<?php echo wp_kses( apply_filters( 'stm_dynamic_icon_output', $search_options_icon ), apply_filters( 'stm_ew_kses_svg', array() ) ); ?>
			<span class="mobile-search-btn-text"><?php echo esc_html( $isf_title ); ?></span>
		</div>
	</div>
</div>

<div class="mobile-filter static-mobile-filter">
	<div class="mobile-search-btn icon-<?php echo esc_attr( $isf_mobile_btn_icon_position ); ?>">
		<?php echo wp_kses( apply_filters( 'stm_dynamic_icon_output', $search_options_icon ), apply_filters( 'stm_ew_kses_svg', array() ) ); ?>
		<span class="mobile-search-btn-text"><?php echo esc_html( $isf_title ); ?></span>
	</div>
</div>
<div class="classic-filter-row motors-elementor-widget">
	<form class="search-filter-form v8-inventory-form" action="<?php echo esc_url( apply_filters( 'stm_listings_current_url', '' ) ); ?>" method="get" data-trigger="filter"
		data-action="<?php echo esc_attr( $action ); ?>">
		<div class="filter filter-sidebar ajax-filter">
			<?php
			/**
			 * Hook: stm_listings_filter_before.
			 *
			 * @hooked stm_listings_parent_list_response - 10
			 * @hooked stm_listings_filter_nonce_response - 15
			 */
			do_action( 'stm_listings_filter_before' );
			?>
			<div class="sidebar-entry-header icon-<?php echo esc_attr( $isf_icon_position ); ?>">
				<?php
				if ( ! is_null( $search_options_icon ) ) :
					?>
					<i class="<?php echo wp_kses_post( $search_options_icon['value'] ); ?>"></i>
				<?php endif; ?>
				<span class="h4"><?php echo esc_html( $isf_title ); ?></span>
			</div>
			<div class="sidebar-entry-header-mobile">
				<span class="h4"><?php echo esc_html( $isf_title ); ?></span>
				<div class="close-btn">
					<span class="close-btn-item"></span>
					<span class="close-btn-item"></span>
				</div>
			</div>
			<div class="row row-pad-top-24">
				<?php
				if ( empty( $filter['filters'] ) ) :
					$post_type_name = __( 'Listings', 'motors-car-dealership-classified-listings-pro' );
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
							printf(
								/* translators: %s post type name */
								esc_html__( 'No categories created for %s', 'motors-car-dealership-classified-listings-pro' ),
								esc_html( $post_type_name )
							);
							?>
						</p>
					</div>
					<?php
				else :
					do_action(
						'stm_listings_load_template',
						'filter/types/keywords',
						array(
							'position' => 'top',
						)
					);
					$parent_list = apply_filters( 'stm_listings_parent_list', false );
					if ( ! is_array( $parent_list ) ) {
						$parent_list = array();
					}
					foreach ( $filter['filters'] as $attribute => $config ) :
						if ( ! array_key_exists( 'is_multiple_select', $config ) ) {
							$config['is_multiple_select'] = false;
						}

						if ( ! empty( $isf_price_single ) && 'price' === $attribute && ! empty( $config['slider'] ) && ! empty( $config['numeric'] ) ) {
							continue;
						}

						if ( ! empty( $filter['options'][ $attribute ] ) ) :
							if ( ! empty( $config['slider'] ) && ! empty( $config['numeric'] ) ) :
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
									<div class="form-group type-select">
										<?php
										do_action(
											'stm_listings_load_template',
											'filter/types/select',
											array(
												'options'  => $filter['options'][ $attribute ],
												'name'     => $attribute,
												'is_parent' => in_array( $attribute, $parent_list, true ),
												'multiple' => array_key_exists( 'is_multiple_select', $config ) ? $config['is_multiple_select'] : false,
											)
										);
										?>
									</div>
								</div>
							<?php endif; ?>
						<?php endif; ?>
					<?php endforeach; ?>

					<?php
					if ( $show_sold && 'listings-sold' !== $action ) :
						$listing_status = apply_filters( 'stm_listings_input', '', 'listing_status' );
						?>
						<div class="col-md-12 col-sm-12 stm-filter_listing_status">
							<div class="form-group">
								<select name="listing_status" aria-label="<?php esc_attr_e( 'Select listing status', 'motors-car-dealership-classified-listings-pro' ); ?>" class="form-control">
									<option value="">
										<?php esc_html_e( 'Listing status', 'motors-car-dealership-classified-listings-pro' ); ?>
									</option>
									<option value="active" <?php selected( $listing_status, 'active' ); ?>>
										<?php esc_html_e( 'Active', 'motors-car-dealership-classified-listings-pro' ); ?>
									</option>
									<option value="sold" <?php selected( $listing_status, 'sold' ); ?>>
										<?php esc_html_e( 'Sold', 'motors-car-dealership-classified-listings-pro' ); ?>
									</option>
								</select>
							</div>
						</div>
					<?php endif; ?>

					<?php
					do_action( 'stm_listings_load_template', 'filter/types/location' );

					do_action(
						'stm_listings_load_template',
						'filter/types/features',
						array(
							'taxonomy' => 'stm_additional_features',
						)
					);

					do_action(
						'stm_listings_load_template',
						'filter/types/keywords',
						array(
							'position' => 'bottom',
						)
					);
				endif;
				?>

			</div>
			<!--View type-->
			<input type="hidden" id="stm_view_type" name="view_type"
				value="<?php echo esc_attr( apply_filters( 'stm_listings_input', null, 'view_type' ) ); ?>"/>
			<!--Filter links-->
			<input type="hidden" id="stm-filter-links-input" name="stm_filter_link" value=""/>
			<!--Popular-->
			<input type="hidden" name="popular" value="<?php echo esc_attr( apply_filters( 'stm_listings_input', null, 'popular' ) ); ?>"/>

			<input type="hidden" name="s" value="<?php echo esc_attr( apply_filters( 'stm_listings_input', null, 's' ) ); ?>"/>
			<input type="hidden" name="sort_order"
				value="<?php echo esc_attr( apply_filters( 'stm_listings_input', null, 'sort_order' ) ); ?>"/>

			<div class="sidebar-action-units">
				<input id="stm-classic-filter-submit" class="hidden" type="submit"
					value="<?php esc_html_e( 'Show cars', 'stm_vehicles_listing' ); ?>"/>

				<a href="<?php echo esc_url( apply_filters( 'stm_filter_listing_link', '' ) ); ?>" class="button">
					<?php
					if ( ! empty( $reset_btn_icon ) ) :
						?>
						<?php echo wp_kses( apply_filters( 'stm_dynamic_icon_output', $reset_btn_icon ), apply_filters( 'stm_ew_kses_svg', array() ) ); ?>
						<?php
						endif;
					?>
					<span><?php echo esc_html( $reset_btn_label ); ?></span>
				</a>
			</div>
			<?php do_action( 'stm_listings_filter_after' ); ?>
		</div>

		<!--Classified price-->
		<?php
		if ( ! empty( $isf_price_single ) && ! empty( $filter['options']['price'] ) && ! empty( $filter['filters']['price']['slider'] ) && ! empty( $filter['filters']['price']['numeric'] ) ) {
			do_action(
				'stm_listings_load_template',
				'filter/types/price',
				array(
					'taxonomy' => 'price',
					'options'  => $filter['options']['price'],
				)
			);
		}
		?>
		<?php do_action( 'stm_listings_load_template', 'filter/types/checkboxes', array( 'filter' => $filter ) ); ?>
		<?php do_action( 'stm_listings_load_template', 'filter/types/links', array( 'filter' => $filter ) ); ?>
		<div class="grow-wrapper"></div>
		<div class="sticky-filter-actions">
			<div class="filter-show-cars">
				<button id="show-car-btn-mobile" class="show-car-btn">
					<?php
					if ( ! empty( $isf_mobile_results_btn_text ) ) {
						$total_cars                  = $filter['total'];
						$isf_mobile_results_btn_text = str_replace( '{{total}}', '<span>' . $total_cars . '</span>', $isf_mobile_results_btn_text );
						echo wp_kses_post( $isf_mobile_results_btn_text );
					}
					?>
					</button>
			</div>
			<div class="reset-btn-mobile">
				<a href="<?php echo esc_url( apply_filters( 'stm_filter_listing_link', '' ) ); ?>" class="button">
					<?php
					if ( ! empty( $reset_btn_icon ) ) :
						?>
						<?php echo wp_kses( apply_filters( 'stm_dynamic_icon_output', $reset_btn_icon ), apply_filters( 'stm_ew_kses_svg', array() ) ); ?>
						<?php
						endif;
					?>
					<span><?php echo esc_html( $reset_btn_label ); ?></span>
				</a>
			</div>
		</div>
	</form>
</div>
