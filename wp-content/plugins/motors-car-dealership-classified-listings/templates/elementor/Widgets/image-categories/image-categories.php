<?php

/**
 * @var $items_align
 * @var $per_row
 * @var $show_as_carousel
 * @var $limit
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

	$terms_images = array();
	$terms_text   = array();
	if ( ! empty( $terms ) ) {
		foreach ( $terms as $stm_term ) {
			$image = get_term_meta( $stm_term->term_id, 'stm_image', true );
			if ( empty( $image ) ) {
				$terms_text[] = $stm_term;
			} else {
				if ( $taxonomy_info['use_on_car_modern_filter_view_images'] ) {
					$terms_images[] = $stm_term;
				}
			}
		}
	}

	if ( empty( $limit ) && empty( $show_as_carousel ) ) {
		$limit = 20;
	}

	if ( 'yes' === $show_as_carousel ) {
		$limit = 100;
	}

	if ( ! empty( $title ) ) {
		$title = str_replace( '{{category}}', '<span class="stm-secondary-color">' . $taxonomy_info['single_name'] . '</span>', $title );
	}

	if ( ! empty( $show_all_text ) ) {
		$show_all_text = str_replace( '{{category}}', $taxonomy_info['plural_name'], $show_all_text );
	}
	?>

	<div class="stm_icon_filter_unit">
		<div class="clearfix">
			<?php if ( ! empty( $show_all_text ) && 'yes' !== $show_as_carousel ) : ?>
				<div class="stm_icon_filter_label">
					<?php echo esc_attr( $show_all_text ); ?>
				</div>
			<?php endif; ?>
			<?php if ( ! empty( $title ) ) : ?>
				<div class="stm_icon_filter_title">
					<h3><?php echo wp_kses_post( $title ); ?></h3>
				</div>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $terms ) ) : ?>
			<div class="stm_listing_icon_filter stm_listing_icon_filter_<?php echo esc_attr( $per_row['size'] ); ?> filter_<?php echo esc_attr( $taxonomy ); ?>>">
				<?php
				$i = 0;
				foreach ( $terms_images as $stm_term ) :
					$image = get_term_meta( $stm_term->term_id, 'stm_image', true );

					// Getting limit for frontend without showing all.
					if ( $limit > $i ) :
						$image = wp_get_attachment_image_src( $image, 'stm-img-190-132' );
						if ( ! empty( $image[0] ) ) {
							$category_image = $image[0];
						} else {
							$category_image = '';
						}
						?>
						<a href="<?php echo esc_url( apply_filters( 'stm_filter_listing_link', '', array( $taxonomy => $stm_term->slug ) ) ); ?>"
								class="stm_listing_icon_filter_single"
								title="<?php echo esc_attr( $stm_term->name ); ?>">
							<div class="inner">
								<div class="image">
									<img src="<?php echo esc_url( $category_image ); ?>"
											alt="<?php echo esc_attr( $stm_term->name ); ?>"/>
								</div>
								<div class="name">
									<?php echo esc_attr( $stm_term->name ); ?>
									<?php if ( ! empty( $items_count ) ) : ?>
										<span class="count">(<?php echo esc_html( $stm_term->count ); ?>)</span>
									<?php endif; ?>
								</div>
							</div>
						</a>
					<?php else : ?>
						<a href="<?php echo esc_url( apply_filters( 'stm_filter_listing_link', '', array( $taxonomy => $stm_term->slug ) ) ); ?>"
								class="stm_listing_icon_filter_single non-visible"
								title="<?php echo esc_attr( $stm_term->name ); ?>">
							<div class="inner">
								<div class="name">
									<?php echo esc_attr( $stm_term->name ); ?>
									<?php if ( ! empty( $items_count ) ) : ?>
										<span class="count">(<?php echo esc_html( $stm_term->count ); ?>)</span>
									<?php endif; ?>
								</div>
							</div>
						</a>
					<?php endif; ?>
					<?php $i ++; ?>
				<?php endforeach; ?>
				<?php foreach ( $terms_text as $stm_term ) : ?>
					<a href="<?php echo esc_url( apply_filters( 'stm_filter_listing_link', '', array( $taxonomy => $stm_term->slug ) ) ); ?>"
							class="stm_listing_icon_filter_single non-visible"
							title="<?php echo esc_attr( $stm_term->name ); ?>">
						<div class="inner">
							<div class="name">
								<?php echo esc_attr( $stm_term->name ); ?>
								<?php if ( ! empty( $items_count ) ) : ?>
									<span class="count">(<?php echo esc_html( $stm_term->count ); ?>)</span>
								<?php endif; ?>
							</div>
						</div>
					</a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>

<?php endif; ?>
