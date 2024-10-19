<?php
/**
 * Atts
 * $title
 * $filter_selected
 * $columns
 * $as_carousel
 * $visible_items
 */

if ( ! empty( $filter_selected ) ) :
	$args = array(
		'orderby'    => 'name',
		'order'      => 'ASC',
		'hide_empty' => true,
		'pad_counts' => true,
	);

	$terms = get_terms( $filter_selected, $args );

	$terms_images = array();
	$terms_text   = array();
	if ( ! is_wp_error( $terms ) ) {
		foreach ( $terms as $stm_term ) {
			$image = get_term_meta( $stm_term->term_id, 'stm_image', true );
			if ( empty( $image ) ) {
				$terms_text[] = $stm_term;
			} else {
				$terms_images[] = $stm_term;
			}
		}
	}

	$show_all = ( ! empty( $terms_images ) || ! empty( $terms_text ) ) ? esc_html__( 'Show All', 'stm_vehicles_listing' ) : '';

	$visible_items = $visible_items ?? 5;
	$random_id     = 'motors-' . wp_rand();
	$non_visible   = 'non-visible';
	$swiper        = '';
	?>
	<div class="stm_icon_filter_unit motors-alignwide">
		<div class="clearfix">
			<?php if ( ! empty( $show_all ) && empty( $as_carousel ) ) : ?>
				<div class="stm_icon_filter_label">
					<?php echo esc_html( $show_all ); ?>
				</div>
			<?php endif; ?>
			<?php if ( ! empty( $title ) ) : ?>
				<div class="stm_icon_filter_title">
					<?php echo wp_kses_post( $title ); ?>
				</div>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $terms ) ) : ?>
			<div id="<?php echo esc_attr( $random_id ); ?>"
				class="swiper swiper-container stm_listing_icon_filter stm_listing_icon_filter_<?php echo esc_attr( $columns ); ?> text-center filter_<?php echo esc_attr( $filter_selected ); ?>">
				<?php
				if ( ! empty( $as_carousel ) ) :
					$non_visible = 'swiper-slide';
					$swiper      = 'swiper-slide';
					?>
				<div class="swiper-wrapper">
					<?php endif; ?>
					<?php
					$i = 0;
					foreach ( $terms_images as $stm_term ) {
						?>
						<?php
						$image = get_term_meta( $stm_term->term_id, 'stm_image', true );

						// Getting limit for frontend without showing all.
						if ( $visible_items > $i ) :
							$image          = wp_get_attachment_image_src( $image, 'stm-img-190-132' );
							$category_image = $image[0];
							?>
							<a href="<?php echo esc_url( apply_filters( 'stm_filter_listing_link', '', array( $filter_selected => $stm_term->slug ) ) ); ?>"
							class="stm_listing_icon_filter_single <?php echo esc_attr( $swiper ); ?>"
							title="<?php echo esc_attr( $stm_term->name ); ?>">
								<div class="inner">
									<div class="image">
										<img src="<?php echo esc_url( $category_image ); ?>"
											alt="<?php echo esc_attr( $stm_term->name ); ?>"/>
									</div>
									<div class="name"><?php echo esc_attr( $stm_term->name ); ?>
										<span class="count">(<?php echo esc_html( $stm_term->count ); ?>)</span>
									</div>
								</div>
							</a>
						<?php else : ?>
							<a href="<?php echo esc_url( apply_filters( 'stm_filter_listing_link', '', array( $filter_selected => $stm_term->slug ) ) ); ?>"
								class="stm_listing_icon_filter_single <?php echo esc_attr( $non_visible ); ?>"
								title="<?php echo esc_attr( $stm_term->name ); ?>">
								<div class="inner">
									<?php if ( ! empty( $as_carousel ) && 'yes' === $as_carousel ) : ?>
									<div class="image">
										<img src="<?php echo esc_url( $category_image ); ?>"
											 alt="<?php echo esc_attr( $stm_term->name ); ?>"/>
									</div>
									<?php endif; ?>
									<div class="name">
										<?php echo esc_attr( $stm_term->name ); ?>
										<span class="count">(<?php echo esc_html( $stm_term->count ); ?>)</span>
									</div>
								</div>
							</a>
						<?php endif; ?>
						<?php $i ++; ?>
					<?php } ?>
					<?php foreach ( $terms_text as $stm_term ) : ?>
						<a href="<?php echo esc_url( apply_filters( 'stm_filter_listing_link', '', array( $filter_selected => $stm_term->slug ) ) ); ?>"
						class="stm_listing_icon_filter_single <?php echo esc_attr( $non_visible ); ?>"
						title="<?php echo esc_attr( $stm_term->name ); ?>">
							<div class="inner">
								<div class="name">
									<?php echo esc_attr( $stm_term->name ); ?>
									<span class="count">(<?php echo esc_html( $stm_term->count ); ?>)</span>
								</div>
							</div>
						</a>
					<?php endforeach; ?>
					<?php if ( ! empty( $as_carousel ) ) : ?>
				</div>
			<?php endif; ?>
				<?php if ( ! empty( $as_carousel ) && 'yes' === $as_carousel ) : ?>
					<div class="swiper-button-next"></div>
					<div class="swiper-button-prev"></div>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
	<?php if ( ! empty( $as_carousel ) && $as_carousel == 'yes' ) : //phpcs:disable ?>
	<script>
        (function ($) {
            $(document).ready(function () {
                var swiper = new Swiper('#<?php echo esc_js($random_id); ?>', {
                    slidesPerView: <?php echo esc_js( $visible_items ); ?>,
                    direction: getDirection(),
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    on: {
                        resize: function () {},
                    },
                });
                function getDirection() {
                    var direction = window.innerWidth <= 760 ? 'vertical' : 'horizontal';

                    return direction;
                }
            });
        })(jQuery);
	</script>
<?php
//phpcs:enable
endif;
endif;
