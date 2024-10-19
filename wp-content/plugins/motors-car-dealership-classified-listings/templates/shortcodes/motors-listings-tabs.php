<?php
// Set active from category if no recent and popular included.
$set_active_category = true;
if ( ( ! empty( $recent_tab ) && 'yes' === $recent_tab ) || ( ! empty( $popular_tab ) && 'yes' === $popular_tab ) || ( ! empty( $featured_tab ) && 'yes' === $featured_tab ) ) {
	$set_active_category = false;
}

if ( ! empty( $popular_tab ) && 'yes' === $popular_tab ) {
	$set_popular_active      = 'active';
	$set_popular_active_fade = 'in';
}

if ( ! empty( $recent_tab ) && 'yes' === $recent_tab ) {
	$set_popular_active      = '';
	$set_popular_active_fade = '';
	$set_recent_active       = 'active';
	$set_recent_active_fade  = 'in';
}

if ( ! empty( $featured_tab ) && 'yes' === $featured_tab ) {
	$set_popular_active       = '';
	$set_popular_active_fade  = '';
	$set_recent_active        = '';
	$set_recent_active_fade   = '';
	$set_featured_active      = 'active';
	$set_featured_active_fade = 'in';
}

$per_row  = ( ! empty( $columns ) ) ? $columns : 4;
$per_page = 8;
?>

<div class="motors_listings_tabs motors-alignwide">
	<div class="clearfix">
		<?php if ( ! empty( $title ) ) : ?>
			<h3 class="hidden-md hidden-lg hidden-sm"><?php echo esc_attr( $title ); ?></h3>
		<?php endif; ?>

		<!-- Nav tabs -->
		<ul class="stm_listing_nav_list heading-font" role="tablist">
			<?php if ( ! empty( $popular_tab ) && 'yes' === $popular_tab ) : ?>
				<li role="presentation" class="nav-item <?php echo esc_attr( $set_popular_active ); ?>">
					<a href="#popular" aria-controls="popular" data-bs-target="popular" role="tab"
						data-toggle="tab"><span><?php echo esc_html__( 'Popular', 'stm_vehicles_listing' ); ?></span></a>
				</li>
			<?php endif; ?>

			<?php if ( ! empty( $recent_tab ) && 'yes' === $recent_tab ) : ?>
				<li role="presentation" class="nav-item <?php echo esc_attr( $set_recent_active ); ?>">
					<a href="#recent" aria-controls="recent" data-bs-target="recent" role="tab"
						data-toggle="tab"><span><?php echo esc_html__( 'Recent', 'stm_vehicles_listing' ); ?></span></a>
				</li>
			<?php endif; ?>

			<?php if ( ! empty( $featured_tab ) && 'yes' === $featured_tab ) : ?>
				<li role="presentation" class="nav-item <?php echo esc_attr( $set_featured_active ); ?>">
					<a href="#featured" aria-controls="featured" data-bs-target="featured" role="tab" data-toggle="tab"><span><?php echo esc_html__( 'Featured', 'stm_vehicles_listing' ); ?></span></a>
				</li>
			<?php endif; ?>

		</ul>

		<?php if ( ! empty( $title ) ) : ?>
			<h3 class="hidden-xs"><?php echo esc_attr( $title ); ?></h3>
		<?php endif; ?>

	</div>

	<!-- Tab panes -->
	<div class="tab-content">
		<?php if ( ! empty( $popular_tab ) && 'yes' === $popular_tab ) : ?>
			<div role="tabpanel"
				class="tab-pane fade <?php echo esc_attr( $set_popular_active_fade . ' ' . $set_popular_active ); ?>"
				id="popular" >
				<?php
				$args = array(
					'post_type'      => apply_filters( 'stm_listings_post_type', 'listings' ),
					'post_status'    => 'publish',
					'posts_per_page' => $per_page,
					'orderby'        => 'meta_value_num',
					'meta_key'       => 'stm_car_views', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
					'order'          => 'DESC',
				);

				$args['meta_query'][] = array(
					'key'     => 'car_mark_as_sold',
					'value'   => '',
					'compare' => '=',
				);

				$recent_query = new WP_Query( $args );

				if ( $recent_query->have_posts() ) :
					?>
					<div class="row row-<?php echo intval( $per_row ); ?> car-listing-row">
						<?php
						while ( $recent_query->have_posts() ) :
							$recent_query->the_post();
							?>
							<?php stm_listings_load_template( 'listing-grid' ); ?>
						<?php endwhile; ?>
					</div>
					<?php if ( ! empty( $show_more ) && 'yes' === $show_more ) : ?>
					<div class="row">
						<div class="col-xs-12 text-center">
							<div class="dp-in">
								<a class="load-more-btn"
									href="<?php echo esc_url( apply_filters( 'stm_filter_listing_link', '' ) . '?popular=true' ); ?>">
									<?php esc_html_e( 'Show all', 'motors-wpbakery-widgets' ); ?>
								</a>
							</div>
						</div>
					</div>
				<?php endif; ?>
					<?php wp_reset_postdata(); ?>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $recent_tab ) && 'yes' === $recent_tab ) : ?>
			<div role="tabpanel"
				class="tab-pane fade <?php echo esc_attr( $set_recent_active_fade . ' ' . $set_recent_active ); ?>"
				id="recent">
				<?php
				$args = array(
					'post_type'      => apply_filters( 'stm_listings_post_type', 'listings' ),
					'post_status'    => 'publish',
					'posts_per_page' => $per_page,
				);

				$args['meta_query'][] = array(
					'key'     => 'car_mark_as_sold',
					'value'   => '',
					'compare' => '=',
				);

				$recent_query = new WP_Query( $args );

				if ( $recent_query->have_posts() ) :
					?>
					<div class="row row-<?php echo intval( $per_row ); ?> car-listing-row">
						<?php
						while ( $recent_query->have_posts() ) :
							$recent_query->the_post();
							?>
							<?php stm_listings_load_template( 'listing-grid' ); ?>
						<?php endwhile; ?>
					</div>

					<?php if ( ! empty( $show_more ) && 'yes' === $show_more ) : ?>
					<div class="row">
						<div class="col-xs-12 text-center">
							<div class="dp-in">
								<a class="load-more-btn"
									href="<?php echo esc_url( apply_filters( 'stm_filter_listing_link', '' ) ); ?>">
									<?php esc_html_e( 'Show all', 'motors-wpbakery-widgets' ); ?>
								</a>
							</div>
						</div>
					</div>
				<?php endif; ?>
					<?php wp_reset_postdata(); ?>
				<?php endif; ?>

			</div>
		<?php endif; ?>

		<?php if ( ! empty( $featured_tab ) && 'yes' === $featured_tab ) : ?>
			<div role="tabpanel"
				class="tab-pane <?php echo esc_attr( $set_featured_active_fade . ' ' . $set_featured_active ); ?>"
				id="featured">
				<?php
				$args = array(
					'post_type'      => apply_filters( 'stm_listings_post_type', 'listings' ),
					'post_status'    => 'publish',
					'posts_per_page' => $per_page,
					'order'          => 'rand',
					'meta_query'     => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
						array(
							'key'     => 'special_car',
							'value'   => 'on',
							'compare' => '=',
						),
						array(
							'key'     => 'car_mark_as_sold',
							'value'   => '',
							'compare' => '=',
						),
					),
				);

				$featured_query = new WP_Query( $args );

				if ( $featured_query->have_posts() ) :
					?>
					<div class="row row-<?php echo intval( $per_row ); ?> car-listing-row">
						<?php
						while ( $featured_query->have_posts() ) :
							$featured_query->the_post();
							?>
							<?php stm_listings_load_template( 'listing-grid' ); ?>
						<?php endwhile; ?>
					</div>
					<?php if ( ! empty( $show_more ) && 'yes' === $show_more ) : ?>
					<div class="row">
						<div class="col-xs-12 text-center">
							<div class="dp-in">
								<a class="load-more-btn"
									href="<?php echo esc_url( apply_filters( 'stm_filter_listing_link', '' ) . '?featured_top=true' ); ?>">
									<?php esc_html_e( 'Show all', 'motors-wpbakery-widgets' ); ?>
								</a>
							</div>
						</div>
					</div>
				<?php endif; ?>
					<?php wp_reset_postdata(); ?>
				<?php endif; ?>
			</div>
		<?php endif; ?>

	</div>
</div>
