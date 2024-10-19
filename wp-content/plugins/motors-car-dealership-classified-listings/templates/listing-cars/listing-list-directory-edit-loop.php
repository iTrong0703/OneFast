<?php
$badge_text        = get_post_meta( get_the_ID(), 'badge_text', true );
$badge_bg_color    = get_post_meta( get_the_ID(), 'badge_bg_color', true );
$special_car       = get_post_meta( get_the_ID(), 'special_car', true );
$taxonomies        = apply_filters( 'stm_get_taxonomies', array() );
$categories        = wp_get_post_terms( get_the_ID(), array_values( $taxonomies ) );
$featured_listings = apply_filters( 'motors_vl_get_nuxy_mod', false, 'dealer_payments_for_featured_listing' );
$placeholder_path  = ( apply_filters( 'stm_is_motors_theme', false ) ) ? get_stylesheet_directory_uri() . '/assets/images/plchldr255.png' : STM_LISTINGS_URL . '/assets/images/plchldr255.png';

$classes = array( 'listing-list-loop-edit', get_post_status( get_the_ID() ) );
foreach ( $categories as $category ) {
	$classes[] = $category->slug . '-' . $category->term_id;
}

$car_media   = apply_filters( 'stm_get_car_medias', array(), get_the_ID() );
$hide_labels = apply_filters( 'motors_vl_get_nuxy_mod', false, 'hide_price_labels' );

if ( $hide_labels ) {
	$classes[] = 'stm-listing-no-price-labels';
}

$car_views = get_post_meta( get_the_ID(), 'stm_car_views', true );
if ( empty( $car_views ) ) {
	$car_views = 0;
}

$phone_reveals = get_post_meta( get_the_ID(), 'stm_phone_reveals', true );
if ( empty( $phone_reveals ) ) {
	$phone_reveals = 0;
}

$car_is_sold = get_post_meta( get_the_ID(), 'car_mark_as_sold', true );
if ( ! empty( $car_is_sold ) ) {
	$classes[] = 'as_sold';
}

$sell_online = false;

do_action(
	'stm_listings_load_template',
	'loop/list/start',
	array(
		'modern'          => true,
		'listing_classes' => $classes,
	)
);
?>
<div class="image">

	<!--Hover blocks-->
	<!---Media-->
	<div class="stm-car-medias">
		<?php if ( ! empty( $car_media['car_photos_count'] ) ) : ?>
			<div class="stm-listing-photos-unit stm-car-photos-<?php echo get_the_ID(); ?>">
				<i class="motors-icons-photo"></i>
				<span><?php echo esc_html( $car_media['car_photos_count'] ); ?></span>
			</div>
			<?php //phpcs:disable ?>
			<script>
                jQuery(document).ready(function () {

                    jQuery(".stm-car-photos-<?php echo get_the_ID(); ?>").on('click', function () {
                        jQuery(this).lightGallery({
                            dynamic: true,
                            dynamicEl: [
								<?php foreach ( $car_media['car_photos'] as $car_photo ) : ?>
                                {
                                    src: "<?php echo esc_url( $car_photo ); ?>",
                                    thumb: "<?php echo esc_url( $car_photo ); ?>"
                                },
								<?php endforeach; ?>
                            ],
                            download: false,
                            mode: 'lg-fade',
                        })
                    });
                });

			</script>
			<?php //phpcs:enable ?>
		<?php endif; ?>
		<?php if ( ! empty( $car_media['car_videos_count'] ) ) : ?>
			<div class="stm-listing-videos-unit stm-car-videos-<?php echo get_the_ID(); ?>">
				<i class="fas fa-film"></i>
				<span><?php echo esc_html( $car_media['car_videos_count'] ); ?></span>
			</div>
			<?php //phpcs:disable ?>
			<script>
                jQuery(document).ready(function () {

                    jQuery(".stm-car-videos-<?php echo get_the_ID(); ?>").on('click', function () {
                        jQuery(this).lightGallery({
                            dynamic: true,
                            dynamicEl: [
								<?php foreach ( $car_media['car_videos'] as $car_video ) : ?>
                                {
                                    src: "<?php echo esc_url( $car_video ); ?>"
                                },
								<?php endforeach; ?>
                            ],
                            download: false,
                            mode: 'lg-fade',
                        })
                    }); //click
                }); //ready

			</script>
			<?php //phpcs:enable ?>
		<?php endif; ?>
	</div>

	<div class="listing_stats_wrap">
		<div class="stm-phone-reveals" data-type="phone" data-id="<?php echo esc_attr( get_the_ID() ); ?>"
			data-title="<?php echo wp_kses_post( apply_filters( 'stm_generate_title_from_slugs', get_the_title( get_the_ID() ), get_the_ID(), false ) ); ?>">
			<i class="fas fa-phone"></i>
			<?php echo esc_html( $phone_reveals ); ?>
		</div>
		<div class="stm-car-views" data-type="listing" data-id="<?php echo esc_attr( get_the_ID() ); ?>"
			data-title="<?php echo wp_kses_post( apply_filters( 'stm_generate_title_from_slugs', get_the_title( get_the_ID() ), get_the_ID(), false ) ); ?>">
			<i class="fas fa-eye"></i>
			<?php echo esc_html( $car_views ); ?>
		</div>
	</div>

	<a href="<?php the_permalink(); ?>" class="rmv_txt_drctn">
		<div class="image-inner">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php
				$sizeImg    = 'stm-img-280';
				$sizeRetina = 'stm-img-280-x-2';
				$img        = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $sizeImg );
				$imgRetina  = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $sizeRetina );
				?>
				<img
						data-src="<?php echo esc_url( $img[0] ?? $placeholder_path ); ?>"
						src="<?php echo esc_url( $placeholder_path ); ?>"
						class="lazy img-responsive"
						srcset="<?php echo esc_url( $img[0] ?? $placeholder_path ); ?> 1x, <?php echo esc_url( ! empty( $imgRetina[0] ) ? $imgRetina[0] : $placeholder_path ); ?> 2x"
						alt="<?php the_title(); ?>"
				/>

			<?php else : ?>
				<img
						src="<?php echo esc_url( $placeholder_path ); ?>"
						class="img-responsive"
						alt="<?php esc_attr_e( 'Placeholder', 'stm_vehicles_listing' ); ?>"
				/>
			<?php endif; ?>
		</div>
	</a>
</div>

<div class="content">

	<?php do_action( 'stm_listings_load_template', 'loop/list/title_price', array( 'hide_labels' => $hide_labels ) ); ?>

	<div class="meta-middle">
		<?php do_action( 'stm_listings_load_template', 'loop/list/options' ); ?>
	</div>

	<div class="meta-bottom">
		<?php do_action( 'stm_listings_load_template', 'listing-cars/listing-list-owner-actions' ); ?>
	</div>

	<a href="<?php the_permalink(); ?>" class="stm-car-view-more button visible-xs"><?php esc_html_e( 'View more', 'stm_vehicles_listing' ); ?></a>
</div>

</div>
