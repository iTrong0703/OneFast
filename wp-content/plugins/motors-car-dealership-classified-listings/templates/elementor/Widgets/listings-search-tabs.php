<?php
/** Elementor settings in widget 'Listings Search Tabs'
 * @var $lst_taxonomies
 * @var $lst_amount
 * @var $lst_show_all_text
 * @var $lst_show_tabs
 * @var $lst_condition_tabs
 * @var $lst_enable_reviews
 * @var $lst_enable_value_my_car
 * @var string $lst_advanced_search
 * @var $lst_advanced_search_label
 * @var $__button_icon_html__
 * @var $lst_btn_postfix
 * @var $lst_reviews_taxonomies
 * @var $tab_prefix
 * @var $tab_suffix
 * @var $lst_show_all_tab
 * */

use Motors_Elementor_Widgets_Free\Helpers\Helper;

$args = array(
	'post_type'              => apply_filters( 'stm_listings_post_type', 'listings' ),
	'post_status'            => 'publish',
	'posts_per_page'         => 1,
	'suppress_filters'       => 0,
	'update_post_meta_cache' => false,
	'update_post_term_cache' => false,
);

if ( apply_filters( 'stm_sold_status_enabled', true ) ) {
	$args['meta_query'][] = array(
		'key'     => 'car_mark_as_sold',
		'value'   => '',
		'compare' => '=',
	);
}

if ( ! empty( $tab_prefix ) ) {
	$tab_prefix = $tab_prefix . ' ';
}

if ( ! empty( $tab_suffix ) ) {
	$tab_suffix = ' ' . $tab_suffix;
}

$uniq_id = uniqid();

$lst_advanced_search    = ( isset( $lst_advanced_search ) && 'yes' === $lst_advanced_search );
$selects_advanced_class = ( $lst_advanced_search ) ? ' hide-overflown-controls' : '';

$tab_activity_class      = 'active';
$tab_pane_activity_class = 'in active';

$nonce_field = apply_filters( 'stm_listings_filter_nonce', false );
?>
<div
	class="stm_dynamic_listing_filter filter-listing stm-vc-ajax-filter animated fadeIn"
	data-options="<?php echo esc_attr( wp_json_encode( apply_filters( 'stm_data_binding_func', array(), true ) ) ); ?>"
	data-show_amount="<?php echo esc_attr( wp_json_encode( 'yes' === $lst_amount ) ); ?>"
>
	<!-- Nav tabs -->
	<ul class="stm_dynamic_listing_filter_nav clearfix heading-font" role="tablist">
		<?php if ( ! empty( $lst_show_all_tab ) ) : ?>
			<li role="presentation" class="<?php echo esc_attr( $tab_activity_class ); ?>">
				<a href="<?php echo esc_attr( sprintf( '#stm_all_listing_tab-%s', $uniq_id ) ); ?>" aria-controls="stm_all_listing_tab" role="tab" data-toggle="tab">
					<?php echo wp_kses_post( $tab_prefix . $lst_show_all_text . $tab_suffix ); ?>
				</a>
			</li>
			<?php $tab_activity_class = ''; ?>
		<?php endif; ?>

		<?php
		if ( 'yes' === $lst_show_tabs && is_array( $lst_condition_tabs ) && count( $lst_condition_tabs ) > 0 ) :
			foreach ( $lst_condition_tabs as $item ) :

				$data   = explode( '|', $item );
				$_value = trim( current( $data ) );
				$_slug  = trim( next( $data ) );
				?>

				<li class="<?php echo esc_attr( $tab_activity_class ); ?>">
					<a
						href="<?php echo esc_attr( sprintf( '#%s-%s', $_value, $uniq_id ) ); ?>"
						aria-controls="<?php echo esc_attr( $_value ); ?>"
						role="tab"
						data-toggle="tab"
						data-value="<?php echo esc_attr( $_value ); ?>"
						data-slug="<?php echo esc_attr( $_slug ); ?>">
						<?php echo esc_html( $tab_prefix . next( $data ) . $tab_suffix ); ?>
					</a>
				</li>
				<?php $tab_activity_class = ''; ?>
				<?php
			endforeach;
		endif;
		?>

		<?php if ( defined( 'STM_REVIEW' ) && 'yes' === $lst_enable_reviews ) : ?>
			<li class="<?php echo esc_attr( $tab_activity_class ); ?>">
				<a href="<?php echo esc_attr( sprintf( '#car-reviews-tab-%s', $uniq_id ) ); ?>" role="tab" data-toggle="tab" aria-expanded="false">
					<?php esc_html_e( 'Car reviews', 'motors-car-dealership-classified-listings-pro' ); ?>
				</a>
			</li>
			<?php $tab_activity_class = ''; ?>
		<?php endif; ?>

		<?php if ( defined( 'STM_VALUE_MY_CAR' ) && 'yes' === $lst_enable_value_my_car ) : ?>
			<li class="<?php echo esc_attr( $tab_activity_class ); ?>">
				<a href="<?php echo esc_attr( sprintf( '#value-my-car-%s', $uniq_id ) ); ?>" role="tab" data-toggle="tab" aria-expanded="false">
					<?php esc_html_e( 'Value my car', 'motors-car-dealership-classified-listings-pro' ); ?>
				</a>
			</li>
			<?php $tab_activity_class = ''; ?>
		<?php endif; ?>

	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<?php if ( ! empty( $lst_show_all_tab ) ) : ?>
			<div role="tabpanel" class="tab-pane fade <?php echo esc_attr( $tab_pane_activity_class ); ?>" id="<?php echo esc_attr( sprintf( 'stm_all_listing_tab-%s', $uniq_id ) ); ?>">
				<form action="<?php echo esc_url( apply_filters( 'stm_filter_listing_link', '' ) ); ?>" method="GET">
					<?php echo wp_kses_post( $nonce_field ); ?>
					<div class="stm-filter-tab-selects filter stm-vc-ajax-filter<?php echo esc_attr( $selects_advanced_class ); ?>">
						<?php Helper::stm_ew_listing_filter_get_selects( $lst_taxonomies, 'stm_all_listing_tab', $lst_amount ); ?>
						<?php if ( $lst_advanced_search && Helper::stm_ew_has_overflown_fields( $lst_taxonomies ) ) : ?>
							<div class="stm-show-more">
								<span class="show-extra-fields" data-tab-id="<?php echo esc_attr( sprintf( 'stm_all_listing_tab-%s', $uniq_id ) ); ?>">
									<?php echo esc_html( $lst_advanced_search_label ); ?>
									<i class="fas fa-angle-down"></i>
								</span>
							</div>
						<?php endif; ?>
						<button type="submit" class="search-submit heading-font">
							<i class="fas fa-search"></i>
							<?php
								$all = new WP_Query( $args );

								printf( '<span> %s </span> %s', esc_html( $all->found_posts ), esc_html( $lst_btn_postfix ) );
							?>
						</button>
					</div>
				</form>
			</div>
			<?php $tab_pane_activity_class = ''; ?>
		<?php endif; ?>

		<?php
		if ( 'yes' === $lst_show_tabs && is_array( $lst_condition_tabs ) && count( $lst_condition_tabs ) > 0 ) :
			foreach ( $lst_condition_tabs as $key => $item ) :

				$data  = explode( '|', $item );
				$_term = trim( current( $data ) );
				$_tax  = trim( next( $data ) );

				?>
				<div role="tabpanel" class="tab-pane fade <?php echo esc_attr( $tab_pane_activity_class ); ?>"
						id="<?php echo esc_attr( sprintf( '%s-%s', $_term, $uniq_id ) ); ?>">
					<?php $taxonomy_count = apply_filters( 'stm_get_custom_taxonomy_count', 0, $_term, $_tax ); ?>
					<form action="<?php echo esc_url( apply_filters( 'stm_filter_listing_link', '' ) ); ?>" method="GET">
						<?php echo wp_kses_post( $nonce_field ); ?>
						<div class="stm-filter-tab-selects filter stm-vc-ajax-filter<?php echo esc_attr( $selects_advanced_class ); ?>">
							<?php Helper::stm_ew_listing_filter_get_selects( $lst_taxonomies, $_term, $lst_amount ); ?>
							<?php if ( $lst_advanced_search && Helper::stm_ew_has_overflown_fields( $lst_taxonomies ) ) : ?>
								<div class="stm-show-more">
									<span class="show-extra-fields" data-tab-id="<?php echo esc_attr( $_term ); ?>-<?php echo esc_attr( $uniq_id ); ?>">
										<?php echo esc_html( $lst_advanced_search_label ); ?>
										<i class="fas fa-angle-down"></i>
									</span>
								</div>
							<?php endif; ?>
							<input type="hidden"
									name="<?php echo esc_attr( $_tax ); ?>"
									data-name="<?php echo esc_attr( $_tax ); ?>"
									data-val="<?php echo esc_attr( $_term ); ?>"
									value="<?php echo esc_attr( $_term ); ?>" class="no-cascading hidden_tax"/>
							<button type="submit" class="search-submit heading-font">
								<i class="fas fa-search"></i>
								<?php printf( '<span> %s </span> %s', esc_html( $all->found_posts ), esc_html( $lst_btn_postfix ) ); ?>
							</button>
						</div>
					</form>
				</div>
				<?php $tab_pane_activity_class = ''; ?>
				<?php
			endforeach;
		endif;
		?>

		<?php if ( defined( 'STM_REVIEW' ) && 'yes' === $lst_enable_reviews ) : ?>
			<div role="tabpanel" class="tab-pane fade <?php echo esc_attr( $tab_pane_activity_class ); ?>" id="<?php echo esc_attr( sprintf( 'car-reviews-tab-%s', $uniq_id ) ); ?>">
				<form action="<?php echo esc_url( stm_review_archive_link() ); ?>" method="GET" class="stm-review-search-form">
					<?php echo wp_kses_post( $nonce_field ); ?>
					<div class="stm-filter-tab-selects stm-filter-tab-selects-second filter stm-vc-ajax-filter<?php echo esc_attr( $selects_advanced_class ); ?>">
						<?php
						Helper::stm_ew_listing_filter_get_selects( $lst_reviews_taxonomies, 'reviews' );

						if ( $lst_advanced_search && Helper::stm_ew_has_overflown_fields( $lst_reviews_taxonomies ) ) :
							?>
							<div class="stm-show-more">
								<span class="show-extra-fields" data-tab-id="car-reviews-tab-<?php echo esc_attr( $uniq_id ); ?>">
									<?php echo esc_html( $lst_advanced_search_label ); ?>
									<i class="fas fa-angle-down"></i>
								</span>
							</div>
						<?php endif; ?>
						<input type="hidden" name="listing_type" value="with_review" />
						<button type="submit" class="search-submit heading-font">
							<i class="fas fa-search"></i>
							<?php
								$args = wp_parse_args(
									array(
										'post_type'      => stm_review_post_type(),
										'posts_per_page' => -1,
										'meta_query'     => array(),
									),
									$args
								);

								$all = new WP_Query( $args );

								printf( '<span> %s </span> %s', esc_html( $all->found_posts ), esc_html( $lst_btn_postfix ) );
							?>
						</button>
					</div>
				</form>
				<?php
				$review_cars = array();
				foreach ( $all->posts as $review ) {
					if ( ! empty( get_post_meta( $review->ID, 'review_car', true ) ) ) {
						$review_cars[] = (int) get_post_meta( $review->ID, 'review_car', true );
					}
				}
				?>
				<script>
					var listings_with_reviews = '<?php echo wp_json_encode( $review_cars ); ?>';
				</script>
			</div>
			<?php $tab_pane_activity_class = ''; ?>
		<?php endif; ?>

		<?php if ( defined( 'STM_VALUE_MY_CAR' ) && 'yes' === $lst_enable_value_my_car ) : ?>
			<div role="tabpanel" class="tab-pane fade <?php echo esc_attr( $tab_pane_activity_class ); ?>" id="<?php echo esc_attr( sprintf( 'value-my-car-%s', $uniq_id ) ); ?>">
				<form method="post" name="vmc-form" type="multipart/formdata">
					<?php echo wp_kses_post( $nonce_field ); ?>
					<div class="stm-filter-tab-selects stm-filter-tab-selects-second filter stm-vc-ajax-filter">
						<?php
						$vmc_fields_all = Helper::stm_ew_get_value_my_car_options();
						if ( ! empty( $lst_value_my_car_fields ) && is_array( $lst_value_my_car_fields ) ) {
							foreach ( $lst_value_my_car_fields as $vmc_field ) :
								if ( 'photo' === $vmc_field ) {
									?>
								<div class="col-md-3 col-sm-6 col-xs-12 stm-select-col vmc-file-wrap">
									<div class="file-wrap">
										<div class="input-file-holder">
											<span><?php echo esc_attr( $vmc_fields_all[ $vmc_field ] ); ?></span>
											<i class="fas fa-plus"></i>
											<input type="file" name="<?php echo esc_attr( $vmc_field ); ?>" />
										</div>
										<span class="error"></span>
									</div>
								</div>
									<?php
								} elseif ( 'year' === $vmc_field || 'mileage' === $vmc_field ) {
									?>
									<div class="col-md-3 col-sm-6 col-xs-12 stm-select-col">
										<input type="number" name="<?php echo esc_attr( $vmc_field ); ?>" placeholder="<?php echo esc_attr( $vmc_fields_all[ $vmc_field ] ); ?>" />
									</div>
									<?php
								} else {
									?>
									<div class="col-md-3 col-sm-6 col-xs-12 stm-select-col">
										<input type="text" name="<?php echo esc_attr( $vmc_field ); ?>" placeholder="<?php echo esc_attr( $vmc_fields_all[ $vmc_field ] ); ?>" />
									</div>
									<?php
								}
							endforeach;
						}
						?>

						<button type="submit" class="vmc-btn-submit heading-font" data-widget-id="value-my-car-<?php echo esc_attr( $uniq_id ); ?>">
							<?php esc_html_e( 'Value my Car', 'motors-car-dealership-classified-listings-pro' ); ?>
							<i class="fas fa-spinner"></i>
						</button>
					</div>
				</form>
			</div>
			<?php $tab_pane_activity_class = ''; ?>
		<?php endif; ?>

	</div>
</div>
