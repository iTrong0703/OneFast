<?php

/**
 * @var $items_align
 * @var $per_row
 * @var $show_as_carousel
 * @var $limit
 * @var $slides_per_view
 * @var $slides_per_view_tablet
 * @var $slides_per_view_mobile
 * @var $slides_per_transition
 * @var $slides_per_transition_tablet
 * @var $slides_per_transition_mobile
 * @var $loop
 * @var $click_drag
 * @var $autoplay
 * @var $transition_speed
 * @var $delay
 * @var $pause_on_mouseover
 * @var $reverse
 * @var $navigation
 * @var $navigation_style
 */

if ( ! empty( $taxonomy ) ) :

	$taxonomy_info = apply_filters( 'stm_vl_get_all_by_slug', array(), $taxonomy );

	$args = array(
		'orderby'    => 'name',
		'order'      => 'ASC',
		'hide_empty' => true,
		'pad_counts' => true,
	);

	$terms = get_terms( $taxonomy, $args );

	if ( ! empty( $title ) ) {
		$title = str_replace( '{{category}}', '<span class="stm-secondary-color">' . $taxonomy_info['single_name'] . '</span>', $title );
	}

	$per_row_responsive = array(
		'desktop' => isset( $slides_per_view ) && $slides_per_view['size'] ? $slides_per_view['size'] : 5,
		'tablet'  => isset( $slides_per_view_tablet ) && $slides_per_view_tablet['size'] ? $slides_per_view_tablet['size'] : 4,
		'mobile'  => isset( $slides_per_view_mobile ) && $slides_per_view_mobile['size'] ? $slides_per_view_mobile['size'] : 2,
	);

	$per_row_responsive = wp_json_encode( $per_row_responsive );

	$slider_options = compact(
		'loop',
		'click_drag',
		'autoplay',
		'transition_speed',
		'delay',
		'pause_on_mouseover',
		'reverse',
		'navigation'
	);

	$slides_per_transition_responsive = array(
		'desktop' => isset( $slides_per_transition ) && $slides_per_transition['size'] ? $slides_per_transition['size'] : 5,
		'tablet'  => isset( $slides_per_transition_tablet ) && $slides_per_transition_tablet['size'] ? $slides_per_transition_tablet['size'] : 4,
		'mobile'  => isset( $slides_per_transition_mobile ) && $slides_per_transition_mobile['size'] ? $slides_per_transition_mobile['size'] : 2,
	);

	$slider_options['slides_per_transition'] = $slides_per_transition_responsive;

	if ( ! isset( $navigation_style ) || empty( $navigation_style ) ) {
		$navigation_style = 'default';
	}

	$navigation_class = '';
	if ( 'yes' === $navigation ) {
		$navigation_class = 'navigation-init';
	}
	if ( 'outstanding' === $navigation_style ) {
		$navigation_class .= ' navigation-outstanding';
	}
	if ( 'in_heading' === $navigation_style ) {
		$navigation_class .= ' navigation-in-header';
	}

	$unique_id = wp_rand( 1, 99999 );
	?>

	<?php $nav_style_class = ( 'in_heading' === $navigation_style ) ? ' nav-in-header' : ''; ?>
	<div class="stm_icon_filter_unit<?php echo esc_attr( $nav_style_class ); ?>" id="image-categories_<?php echo esc_attr( $unique_id ); ?>">
		<div class="clearfix">
			<?php if ( ! empty( $title ) ) : ?>
				<div class="stm_icon_filter_title">
					<h3><?php echo wp_kses_post( $title ); ?></h3>
				</div>
			<?php endif; ?>
			<?php if ( 'in_heading' === $navigation_style ) : ?>
				<div class="header-nav">
					<div class="swiper-button-next">
						<i class="fa fa-angle-right"></i>
					</div>
					<div class="swiper-button-prev">
						<i class="fa fa-angle-left"></i>
					</div>
				</div>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $terms ) ) : ?>
			<div class="stm_listing_icon_filter swiper filter_<?php echo esc_attr( $taxonomy ); ?> <?php echo esc_attr( $navigation_class ); ?>"
					data-per_row_responsive="<?php echo esc_attr( $per_row_responsive ); ?>"
					data-options="<?php echo esc_attr( wp_json_encode( $slider_options ) ); ?>"
					data-widget_id="<?php echo esc_attr( 'image-categories_' . $unique_id ); ?>"
			>
				<div class="swiper-container">
					<div class="swiper-wrapper">
						<?php foreach ( $terms as $stm_term ) : ?>
							<div class="swiper-slide">
								<a href="<?php echo esc_url( apply_filters( 'stm_filter_listing_link', '', array( $taxonomy => $stm_term->slug ) ) ); ?>"
										class="stm_listing_icon_filter_single"
										title="<?php echo esc_attr( $stm_term->name ); ?>">
									<div class="inner">
										<?php
										$image          = get_term_meta( $stm_term->term_id, 'stm_image', true );
										$image          = wp_get_attachment_image_src( $image, 'stm-img-190-132' );
										$category_image = null;
										if ( is_array( $image ) && isset( $image[0] ) && $image[0] ) {
											$category_image = $image[0];
										}
										?>
										<?php if ( ! empty( $category_image && $taxonomy_info['use_on_car_modern_filter_view_images'] ) ) : ?>
											<div class="image">
												<img src="<?php echo esc_url( $category_image ); ?>"
														alt="<?php echo esc_attr( $stm_term->name ); ?>"/>
											</div>
										<?php endif; ?>
										<div class="name">
											<?php echo esc_attr( $stm_term->name ); ?>
											<?php if ( ! empty( $items_count ) ) : ?>
												<span class="count">(<?php echo esc_html( $stm_term->count ); ?>)</span>
											<?php endif; ?>
										</div>
									</div>
								</a>
							</div>
						<?php endforeach; ?>
					</div>
				</div>

				<?php if ( 'yes' === $navigation && 'in_heading' !== $navigation_style ) : ?>
					<div class="swiper-button-next">
						<i class="fa fa-angle-right"></i>
					</div>
					<div class="swiper-button-prev">
						<i class="fa fa-angle-left"></i>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>

<?php endif; ?>
