<?php
if ( stm_is_multilisting() ) {
	$multilisting       = new STMMultiListing();
	$slugs              = array( apply_filters( 'stm_listings_post_type', 'listings' ) );
	$multilisting_slugs = $multilisting::stm_get_listing_type_slugs();

	if ( ! empty( $multilisting_slugs ) ) {
		$slugs = array_merge( $slugs, $multilisting_slugs );
	}
}

$post_type    = apply_filters( 'stm_listings_post_type', 'listings' );
$widget_title = $compare_title;
$add_to_text  = $add_item_label;
$add_icon     = $add_item_icon;

if ( ! empty( $slugs ) ) {
	foreach ( $slugs as $slug ) {
		if ( ! empty( $slug ) ) {
			$add_icon = $add_item_icon . '_' . $slug;
		} else {
			$add_icon = $add_item_icon;
		}
	}
}


if ( stm_is_multilisting() && isset( $_GET['compare_type'] ) && ! empty( $_GET['compare_type'] ) && $_GET['compare_type'] !== $post_type ) {
	$post_type = $_GET['compare_type'];
	set_query_var( 'post_type', $post_type );
	HooksMultiListing::stm_listings_attributes_filter( array( 'slug' => $post_type ) );

	if ( isset( ${'compare_title_' . $post_type} ) && ! empty( ${'compare_title_' . $post_type} ) ) {
		$widget_title = ${'compare_title_' . $post_type};
	}

	if ( isset( ${'add_item_label_' . $post_type} ) && ! empty( ${'add_item_label_' . $post_type} ) ) {
		$add_to_text = ${'add_item_label_' . $post_type};
	}

	if ( isset( ${'add_item_icon_' . $post_type} ) && ! empty( ${'add_item_icon_' . $post_type} ) ) {
		$add_icon = ${'add_item_icon_' . $post_type};
	}
}

$compared_items = apply_filters( 'stm_get_compared_items', array(), $post_type );
$filter_options = apply_filters( 'stm_get_single_car_listings', array() );
$empty_cars     = 3 - count( $compared_items );
$counter        = 0;

$compare_empty_placeholder = 'compare-empty.jpg';

?>
<div class="stm-compare-cars-module">
	<div class="container">

		<?php if ( stm_is_multilisting() && isset( $slugs ) && ! empty( $slugs ) ) : ?>

		<div class="multilisting_compare_type_buttons">

			<?php foreach ( $slugs as $slug ) : ?>
				<?php
				$type_label = ( apply_filters( 'stm_listings_post_type', 'listings' ) === $slug ) ? __( 'Listings', 'motors_listing_types' ) : $multilisting->stm_get_listing_name_by_slug( $slug );
				$btn_class  = ( $post_type === $slug ) ? 'btn-primary' : 'btn-default';
				?>
				<a class="btn btn-lg heading-font <?php echo esc_attr( $btn_class ); ?>" href="?compare_type=<?php echo esc_attr( $slug ); ?>">
					<?php echo esc_html( $type_label ); ?> <span class="badge"><?php echo count( apply_filters( 'stm_get_compared_items', array(), $slug ) ); ?></span>
				</a>
			<?php endforeach; ?>

		</div>

		<?php endif; ?>

		<?php if ( ! empty( $compared_items ) || count( $compared_items ) !== 0 ) : ?>
			<?php
			$args = array(
				'post_type'      => $post_type,
				'post_status'    => 'publish',
				'posts_per_page' => 3,
				'post__in'       => $compared_items,
			);

			$compares = new WP_Query( $args );

			if ( $compares->have_posts() ) :
				?>
				<div class="row row-4 car-listing-row stm-car-compare-row">
					<div class="col-md-3 col-sm-3 col-xs-12">
						<h2 class="compare-title">
							<?php echo esc_html( $widget_title ); ?>
						</h2>
						<div class="colored-separator text-left">
							<?php if ( apply_filters( 'stm_is_boats', false ) ) : ?>
								<div><i class="motors-icons-wave stm-base-color"></i></div>
							<?php else : ?>
								<div class="first-long"></div>
								<div class="last-short"></div>
							<?php endif; ?>
						</div>
					</div>
					<?php
					while ( $compares->have_posts() ) :
						$compares->the_post();
						$counter++;
						?>
						<!--Compare car description-->
						<div
							class="col-md-3 col-sm-3 col-xs-4 compare-col-stm compare-col-stm-<?php echo esc_attr( get_the_ID() ); ?>">
							<a href="<?php the_permalink(); ?>" class="rmv_txt_drctn">
								<div class="compare-col-stm-empty">
									<div class="image">
										<?php if ( has_post_thumbnail() ) { ?>
											<div class="stm-compare-car-img">
												<?php the_post_thumbnail( 'stm-img-255', array( 'class' => 'img-responsive ' ) ); ?>
											</div>
										<?php } else { ?>
											<span class="stm-icon-add-car-wrapper">
												<?php echo wp_kses( apply_filters( 'stm_dynamic_icon_output', $add_icon ), apply_filters( 'stm_ew_kses_svg', array() ) ); ?>
											</span>
											<img class="stm-compare-empty"
													src="<?php echo esc_url( STM_LISTINGS_URL . '/assets/elementor/img/' . $compare_empty_placeholder ); ?>"
													alt="<?php esc_attr_e( 'Empty', 'motors-car-dealership-classified-listings-pro' ); ?>"/>
										<?php }; ?>
									</div>
								</div>
							</a>
							<div class="remove-compare-unlinkable">
							<span
								class="remove-from-compare add-to-compare"
								data-action="remove"
								data-id="<?php echo esc_attr( get_the_ID() ); ?>"
								data-post-type="<?php echo esc_attr( get_post_type( get_the_ID() ) ); ?>">
								<i class="motors-icons-remove"></i>
								<span><?php esc_html_e( 'Remove from list', 'motors-car-dealership-classified-listings-pro' ); ?></span>
							</span>
							</div>
							<a href="<?php the_permalink(); ?>" class="rmv_txt_drctn">
								<div class="listing-car-item-meta">
									<div class="car-meta-top heading-font clearfix">
										<?php $price = get_post_meta( get_the_ID(), 'price', true ); ?>
										<?php $sale_price = get_post_meta( get_the_ID(), 'sale_price', true ); ?>
										<?php $car_price_form_label = get_post_meta( get_the_ID(), 'car_price_form_label', true ); ?>
										<?php if ( empty( $car_price_form_label ) ) : ?>
											<?php if ( ! empty( $price ) && ! empty( $sale_price ) ) : ?>
												<div class="price discounted-price">
													<div
														class="regular-price"><?php echo esc_attr( apply_filters( 'stm_filter_price_view', '', $price ) ); ?></div>
													<div
														class="sale-price"><?php echo esc_attr( apply_filters( 'stm_filter_price_view', '', $sale_price ) ); ?></div>
												</div>
											<?php elseif ( ! empty( $price ) ) : ?>
												<div class="price">
													<div
														class="normal-price"><?php echo esc_attr( apply_filters( 'stm_filter_price_view', '', $price ) ); ?></div>
												</div>
											<?php endif; ?>
										<?php else : ?>
											<div class="price">
												<div
													class="normal-price"><?php echo esc_attr( $car_price_form_label ); ?></div>
											</div>
										<?php endif; ?>
										<div class="car-title"><?php the_title(); ?></div>
									</div>
								</div>
							</a>

							<span class="btn btn-default add-to-compare hidden" data-action="remove"
									data-id="<?php echo esc_js( get_the_ID() ); ?>">
							<?php esc_html_e( 'Remove from compare', 'motors-car-dealership-classified-listings-pro' ); ?>
						</span>
						</div> <!--md-3-->
					<?php endwhile; ?>
					<?php for ( $i = 0; $i < $empty_cars; $i++ ) { ?>
						<div class="col-md-3 col-sm-3 col-xs-4 compare-col-stm-empty">
							<a href="<?php echo esc_url( apply_filters( 'stm_inventory_page_url', '', $post_type ) ); ?>">
								<div class="image">
									<span class="stm-icon-add-car-wrapper">
										<?php echo wp_kses( apply_filters( 'stm_dynamic_icon_output', $add_icon ), apply_filters( 'stm_ew_kses_svg', array() ) ); ?>
									</span>
									<img class="stm-compare-empty"
											src="<?php echo esc_url( STM_LISTINGS_URL . '/assets/elementor/img/' . $compare_empty_placeholder ); ?>"
											alt="<?php esc_attr_e( 'Empty', 'motors-car-dealership-classified-listings-pro' ); ?>"/>
								</div>
								<div class="h5"><?php echo esc_html( $add_to_text ); ?></div>
							</a>
						</div>
					<?php } ?>
				</div> <!--row-->
			<?php endif; ?>
			<?php if ( $compares->have_posts() ) : ?>
				<div class="row row-4 stm-compare-row">
					<div class="col-md-3 col-sm-3 hidden-xs">
						<?php if ( ! empty( $filter_options ) ) : ?>
							<div class="compare-options">
								<table>
									<?php foreach ( $filter_options as $filter_option ) : ?>
										<?php if ( ! apply_filters( 'stm_is_listing_price_field', true, $filter_option['slug'] ) ) { ?>
											<tr>
												<?php $compare_option = get_post_meta( get_the_ID(), $filter_option['slug'], true ); ?>
												<td class="compare-value-hover <?php echo esc_attr( 'compare-value-' . $filter_option['slug'] ); ?>"
													data-value="<?php echo esc_attr( 'compare-value-' . $filter_option['slug'] ); ?>">
													<?php echo esc_html( apply_filters( 'stm_dynamic_string_translation', $filter_option['single_name'], 'Compare page ' . $filter_option['single_name'] ) ); ?>
												</td>
											</tr>
										<?php }; ?>
									<?php endforeach; ?>
								</table>
							</div>
						<?php endif; ?>
					</div>
					<?php
					while ( $compares->have_posts() ) :
						$compares->the_post();
						?>
						<div class="col-md-3 col-sm-3 col-xs-4 compare-col-stm-<?php echo esc_attr( get_the_ID() ); ?>">
							<?php if ( ! empty( $filter_options ) ) : ?>
								<div class="compare-values">
									<?php if ( has_post_thumbnail( get_the_ID() ) ) : ?>
										<div class="compare-car-visible">
											<?php the_post_thumbnail( 'stm-img-398-x-2', array( 'class' => 'img-responsive stm-img-mobile-compare' ) ); ?>
										</div>
									<?php endif; ?>
									<div class="remove-compare-unlinkable">
									<span class="remove-from-compare"
											data-id="<?php echo esc_attr( get_the_ID() ); ?>"
											data-action="remove"
											data-id="<?php echo esc_attr( get_the_ID() ); ?>"
											data-post-type="<?php echo esc_attr( get_post_type( get_the_ID() ) ); ?>">
										<i class="motors-icons-remove"></i>
										<span><?php esc_html_e( 'Remove from list', 'motors-car-dealership-classified-listings-pro' ); ?></span>
									</span>
									</div>
									<h4 class="text-transform compare-car-visible"><?php the_title(); ?></h4>
									<table>
										<?php if ( wp_is_mobile() ) : ?>
											<tr>
												<td class="compare-value-hover">
													<div class="h5" data-option="<?php esc_html_e( 'Price', 'motors-car-dealership-classified-listings-pro' ); ?>">&nbsp;
														<?php $price = get_post_meta( get_the_ID(), 'price', true ); ?>
														<?php $sale_price = get_post_meta( get_the_ID(), 'sale_price', true ); ?>
														<?php $car_price_form_label = get_post_meta( get_the_ID(), 'car_price_form_label', true ); ?>
														<?php if ( empty( $car_price_form_label ) ) : ?>
															<?php if ( ! empty( $price ) && ! empty( $sale_price ) ) : ?>
																<span class="regular-price"><?php echo esc_attr( apply_filters( 'stm_filter_price_view', '', $price ) ); ?></span>
																<span class="sale-price"><?php echo esc_attr( apply_filters( 'stm_filter_price_view', '', $sale_price ) ); ?></span>
															<?php elseif ( ! empty( $price ) ) : ?>
																<span class="normal-price"><?php echo esc_attr( apply_filters( 'stm_filter_price_view', '', $price ) ); ?></span>
															<?php endif; ?>
														<?php else : ?>
															<span class="normal-price"><?php echo esc_attr( $car_price_form_label ); ?></span>
														<?php endif; ?>
													</div>
												</td>
											</tr>
										<?php endif; ?>
										<?php foreach ( $filter_options as $filter_option ) : ?>
											<?php if ( ! apply_filters( 'stm_is_listing_price_field', true, $filter_option['slug'] ) ) { ?>
												<tr>
													<?php $compare_option = get_post_meta( get_the_ID(), $filter_option['slug'], true ); ?>
													<td class="compare-value-hover <?php echo esc_attr( 'compare-value-' . $filter_option['slug'] ); ?>"
														data-value="<?php echo esc_attr( 'compare-value-' . $filter_option['slug'] ); ?>">
														<div class="h5" data-option="<?php echo esc_attr( $filter_option['single_name'] ); ?>">
															<?php
															if ( ! empty( $compare_option ) ) {
																// if numeric get value from meta.
																if ( ! empty( $filter_option['numeric'] ) && $filter_option['numeric'] ) {
																	echo esc_attr( $compare_option );
																} else {
																	// not numeric, get category name by meta.
																	$data_meta_array = explode( ',', $compare_option );
																	$datas           = array();

																	if ( ! empty( $data_meta_array ) ) {
																		foreach ( $data_meta_array as $data_meta_single ) {
																			$data_meta = get_term_by( 'slug', $data_meta_single, $filter_option['slug'] );
																			if ( ! empty( $data_meta->name ) ) {
																				$datas[] = esc_attr( $data_meta->name );
																			}
																		}
																	}
																	if ( ! empty( $datas ) ) {
																		echo esc_html( implode( ', ', $datas ) );

																	} else {
																		esc_html_e( 'None', 'motors-car-dealership-classified-listings-pro' );
																	}
																}
															} else {
																esc_html_e( 'None', 'motors-car-dealership-classified-listings-pro' );
															}
															?>
														</div>
													</td>
												</tr>
											<?php } ?>
										<?php endforeach; ?>
									</table>
								</div>
							<?php endif; ?>
						</div> <!--md-3-->
					<?php endwhile; ?>
					<?php for ( $i = 0; $i < $empty_cars; $i++ ) { ?>
						<?php if ( ! empty( $filter_options ) ) : ?>
							<div class="col-md-3 col-sm-3 hidden-xs">
								<div class="compare-options">
									<table>
										<?php foreach ( $filter_options as $filter_option ) : ?>
											<?php if ( ! apply_filters( 'stm_is_listing_price_field', true, $filter_option['slug'] ) ) { ?>
												<tr>
													<td class="compare-value-hover">&nbsp;</td>
												</tr>
											<?php }; ?>
										<?php endforeach; ?>
									</table>
								</div>
							</div>
						<?php endif; ?>
					<?php } ?>
				</div> <!--row-->

				<?php $add_compare_mobile_class = ( $compares->post_count < 3 ) ? ' add-compare-mobile-show' : ''; ?>

					<div class="add-compare-mobile <?php echo esc_attr( $add_compare_mobile_class ); ?>">
						<a href="<?php echo esc_url( apply_filters( 'stm_inventory_page_url', '', $post_type ) ); ?>">
							<div class="image">
								<?php echo wp_kses( apply_filters( 'stm_dynamic_icon_output', $add_icon ), apply_filters( 'stm_ew_kses_svg', array() ) ); ?>
								<img
										src="<?php echo esc_url( STM_LISTINGS_URL . '/assets/elementor/img/' . $compare_empty_placeholder ); ?>"
										alt="<?php esc_attr_e( 'Empty', 'motors-car-dealership-classified-listings-pro' ); ?>"/>
							</div>
							<div class="add-compare-mobile-label"><?php echo esc_html( $add_to_text ); ?></div>
						</a>
					</div>

				<?php
			endif;

			wp_reset_postdata();

		else : // show empty placeholders if compare is empty.
			?>
			<div class="row row-4 car-listing-row stm-car-compare-row stm-no-cars">
				<div class="col-md-3 col-sm-3">
					<h2 class="compare-title">
						<?php echo esc_html( $widget_title ); ?>
					</h2>
					<div class="colored-separator text-left">
						<?php if ( apply_filters( 'stm_is_boats', false ) ) : ?>
							<div><i class="motors-icons-wave stm-base-color"></i></div>
						<?php else : ?>
							<div class="first-long"></div>
							<div class="last-short"></div>
						<?php endif; ?>
					</div>
				</div>
				<?php for ( $i = 0; $i < $empty_cars; $i++ ) { ?>
					<div class="col-md-3 col-sm-3 col-xs-4 compare-col-stm-empty">
						<a href="<?php echo esc_url( apply_filters( 'stm_inventory_page_url', '', $post_type ) ); ?>">
							<div class="image">
								<span class="stm-icon-add-car-wrapper">
									<?php echo wp_kses( apply_filters( 'stm_dynamic_icon_output', $add_icon ), apply_filters( 'stm_ew_kses_svg', array() ) ); ?>
								</span>
								<img class="stm-compare-empty"
										src="<?php echo esc_url( STM_LISTINGS_URL . '/assets/elementor/img/' . $compare_empty_placeholder ); ?>"
										alt="<?php esc_attr_e( 'Empty', 'motors-car-dealership-classified-listings-pro' ); ?>"/>
							</div>
							<div class="h5"><?php echo esc_html( $add_to_text ); ?></div>
						</a>
					</div>
				<?php } ?>
			</div> <!--row-->
			<div class="row row-4 stm-compare-row hidden-xs">
				<div class="col-md-3 col-sm-3 col-xs-4 hidden-xs">
					<?php if ( ! empty( $filter_options ) ) : ?>
						<div class="compare-options">
							<table>
								<?php foreach ( $filter_options as $filter_option ) : ?>
									<?php if ( ! apply_filters( 'stm_is_listing_price_field', true, $filter_option['slug'] ) ) { ?>
										<tr>
											<?php $compare_option = get_post_meta( get_the_ID(), $filter_option['slug'], true ); ?>
											<td class="compare-value-hover <?php echo esc_attr( 'compare-value-' . $filter_option['slug'] ); ?>"
												data-value="<?php echo esc_attr( 'compare-value-' . $filter_option['slug'] ); ?>">
												<?php echo esc_html( apply_filters( 'stm_dynamic_string_translation', $filter_option['single_name'], 'Compare page ' . $filter_option['single_name'] ) ); ?>
											</td>
										</tr>
									<?php }; ?>
								<?php endforeach; ?>
							</table>
						</div>
					<?php endif; ?>
				</div>
				<?php for ( $i = 0; $i < $empty_cars; $i++ ) { ?>
					<?php if ( ! empty( $filter_options ) ) : ?>
						<div class="col-md-3 col-sm-3 col-xs-4">
							<div class="compare-options">
								<table>
									<?php foreach ( $filter_options as $filter_option ) : ?>
										<?php if ( ! apply_filters( 'stm_is_listing_price_field', true, $filter_option['slug'] ) ) { ?>
											<tr>
												<td>&nbsp;</td>
											</tr>
										<?php }; ?>
									<?php endforeach; ?>
								</table>
							</div>
						</div>
					<?php endif; ?>
				<?php } ?>
			</div> <!--row-->
		<?php endif; ?>

		<!--Additional features-->
		<?php if ( ! empty( $compares ) ) : ?>
			<?php if ( $compares->have_posts() ) : ?>
				<div class="row row-4 row-compare-features hidden-xs">
					<div class="col-md-3 col-sm-3">
						<h4 class="stm-compare-features"><?php esc_html_e( 'Additional features', 'motors-car-dealership-classified-listings-pro' ); ?></h4>
					</div>
					<?php
					while ( $compares->have_posts() ) :
						$compares->the_post();
						?>
						<?php $features = get_post_meta( get_the_ID(), 'additional_features', true ); ?>
						<?php if ( ! empty( $features ) ) : ?>
						<div class="col-md-3 col-sm-3 compare-col-stm-<?php echo esc_attr( get_the_ID() ); ?>">
							<?php $features = explode( ',', $features ); ?>
							<ul class="list-style-2">
								<?php foreach ( $features as $feature ) : ?>
									<li><?php echo esc_attr( $feature ); ?></li>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php else : ?>
						<div class="col-md-3 col-sm-3 compare-col-stm-<?php echo esc_attr( get_the_ID() ); ?>"></div>
					<?php endif; ?>
					<?php endwhile; ?>

				</div>
			<?php endif; ?>
		<?php endif; ?>
	</div>

	<div class="compare-empty-car-top">
		<div class="col-md-3 col-sm-3 col-xs-4 compare-col-stm-empty">
			<a href="<?php echo esc_url( apply_filters( 'stm_inventory_page_url', '', $post_type ) ); ?>">
				<div class="image">
					<span class="stm-icon-add-car-wrapper">
						<?php echo wp_kses( apply_filters( 'stm_dynamic_icon_output', $add_icon ), apply_filters( 'stm_ew_kses_svg', array() ) ); ?>
					</span>
					<img class="stm-compare-empty"
							src="<?php echo esc_url( STM_LISTINGS_URL . '/assets/elementor/img/' . $compare_empty_placeholder ); ?>"
							alt="<?php esc_attr_e( 'Empty', 'motors-car-dealership-classified-listings-pro' ); ?>"/>
				</div>
				<div class="h5"><?php echo esc_html( $add_to_text ); ?></div>
			</a>
		</div>
	</div>

	<div class="compare-empty-car-bottom">
		<?php if ( ! empty( $filter_options ) ) : ?>
			<div class="col-md-3 col-sm-3 col-xs-4 hidden-xs">
				<div class="compare-options">
					<table>
						<?php foreach ( $filter_options as $filter_option ) : ?>
							<?php if ( ! apply_filters( 'stm_is_listing_price_field', true, $filter_option['slug'] ) ) { ?>
								<tr>
									<td class="compare-value-hover">&nbsp;</td>
								</tr>
							<?php }; ?>
						<?php endforeach; ?>
					</table>
				</div>
			</div>
		<?php endif; ?>
	</div>

	<script>
		jQuery(document).ready(function ($) {

			var heigth = 0;
			$('.compare-values table tbody tr td').each(function(){
				heigth = $(this).height();

				$('.' + $(this).attr('data-value')).each(function () {
					if($(this).height() > heigth || heigth > 0) {
						heigth = $(this).height() + 18;
						$('.' + $(this).attr('data-value')).css('height', heigth + 'px');
					}
				});
			});

			$('.compare-value-hover').on({
				mouseenter: function () {
					var dataValue = $(this).data('value');
					$('.compare-value-hover[data-value = ' + dataValue + ']').addClass('hovered');
				},
				mouseleave: function () {
					$('.compare-value-hover').removeClass('hovered');
				}
			});
		})
	</script>
</div>
