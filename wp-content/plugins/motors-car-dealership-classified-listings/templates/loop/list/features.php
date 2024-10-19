<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$listing_id = get_the_ID();

$stock_number          = get_post_meta( $listing_id, 'stock_number', true );
$car_brochure          = get_post_meta( $listing_id, 'car_brochure', true );
$certified_logo_1      = get_post_meta( $listing_id, 'certified_logo_1', true );
$history_link_1        = get_post_meta( $listing_id, 'history_link', true );
$certified_logo_2      = get_post_meta( $listing_id, 'certified_logo_2', true );
$certified_logo_2_link = get_post_meta( $listing_id, 'certified_logo_2_link', true );

// Show car actions
$show_stock                           = apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_listing_stock' );
$show_test_drive                      = apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_listing_test_drive' );
$show_compare                         = apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_listing_compare' );
$show_listing_quote                   = apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_listing_quote' );
$show_listing_trade                   = apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_listing_trade' );
$show_listing_vin                     = apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_listing_vin' );
$show_share                           = apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_listing_share' );
$show_pdf                             = apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_listing_pdf' );
$show_certified_logo_1                = apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_listing_certified_logo_1' );
$show_certified_logo_2                = apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_listing_certified_logo_2' );
$listing_directory_enable_dealer_info = apply_filters( 'motors_vl_get_nuxy_mod', false, 'listing_directory_enable_dealer_info' );
$cars_in_compare                      = apply_filters( 'stm_get_compared_items', array(), apply_filters( 'stm_listings_post_type', 'listings' ) );

/*If automanager, and no image in admin, set default image carfax*/

if ( stm_check_if_car_imported( $listing_id ) && empty( $certified_logo_1 ) && ! empty( $history_link_1 ) ) {
	$certified_logo_1 = 'automanager_default';
}

if ( function_exists( 'get_post_id_by_meta_k_v' ) ) {

	$review_id = get_post_id_by_meta_k_v( 'review_car', $listing_id );

	if ( ! is_null( $review_id ) ) {
		$performance = (int) get_post_meta( $review_id, 'performance', true );
		$comfort     = (int) get_post_meta( $review_id, 'comfort', true );
		$interior    = (int) get_post_meta( $review_id, 'interior', true );
		$exterior    = (int) get_post_meta( $review_id, 'exterior', true );

		$rating_sum = ( ( $performance + $comfort + $interior + $exterior ) / 4 );
	}
}

$price      = get_post_meta( $listing_id, 'price', true );
$sale_price = get_post_meta( $listing_id, 'sale_price', true );

if ( ! empty( $sale_price ) ) {
	$price = $sale_price;
}
?>

<div class="single-car-actions">
	<ul class="list-unstyled clearfix">

		<?php if ( ! empty( $listing_directory_enable_dealer_info ) && ! empty( $listing_directory_enable_dealer_info ) && $listing_directory_enable_dealer_info ) : ?>
			<?php do_action( 'stm_listings_load_template', 'partials/user/listing-list-user-info' ); ?>
		<?php endif; ?>

		<!--Stock num-->
		<?php if ( ! empty( $stock_number ) && ! empty( $show_stock ) && $show_stock ) : ?>
			<li>
				<div class="stock-num heading-font">
					<span><?php esc_html_e( 'stock', 'stm_vehicles_listing' ); ?># </span><?php echo esc_attr( $stock_number ); ?>
				</div>
			</li>
		<?php endif; ?>

		<!--Schedule-->
		<?php if ( ! empty( $show_test_drive ) && $show_test_drive ) : ?>
			<li>
				<a href="#" class="car-action-unit stm-schedule" data-toggle="modal" data-target="#test-drive" onclick="stm_test_drive_car_title(<?php echo esc_js( $listing_id ); ?>, '<?php echo esc_js( get_the_title( $listing_id ) ); ?>')">
					<i class="motors-icons-steering_wheel"></i>
					<?php esc_html_e( 'Schedule Test Drive', 'stm_vehicles_listing' ); ?>
				</a>
			</li>
		<?php endif; ?>

		<!--Compare-->
		<?php if ( ! empty( $show_compare ) && $show_compare ) : ?>
			<li data-compare-id="<?php echo esc_attr( $listing_id ); ?>">
				<?php if ( in_array( (string) $listing_id, $cars_in_compare, true ) ) : ?>
				<a href="#" class="car-action-unit add-to-compare stm-added" data-title="<?php echo esc_attr( get_the_title( $listing_id ) ); ?>" data-id="<?php echo esc_attr( $listing_id ); ?>" data-post-type="<?php echo esc_attr( get_post_type( $listing_id ) ); ?>" data-action="remove">
					<i class="motors-icons-added stm-unhover"></i>
					<span class="stm-unhover"><?php esc_html_e( 'in compare list', 'stm_vehicles_listing' ); ?></span>
					<div class="stm-show-on-hover">
						<i class="motors-icons-remove"></i>
						<?php esc_html_e( 'Remove from list', 'stm_vehicles_listing' ); ?>
					</div>
				</a>
				<?php else : ?>
				<a href="#" class="car-action-unit add-to-compare" data-title="<?php echo esc_attr( get_the_title( $listing_id ) ); ?>" data-id="<?php echo esc_attr( $listing_id ); ?>" data-action="add" data-post-type="<?php echo esc_attr( get_post_type( $listing_id ) ); ?>">
					<i class="motors-icons-add"></i>
					<span><?php esc_html_e( 'Add to compare', 'stm_vehicles_listing' ); ?></span>
				</a>
				<?php endif; ?>
			</li>
		<?php endif; ?>

		<!--PDF-->
		<?php if ( ! empty( $show_pdf ) && $show_pdf ) : ?>
			<?php if ( ! empty( $car_brochure ) ) : ?>
				<li>
					<a
							href="<?php echo esc_url( wp_get_attachment_url( $car_brochure ) ); ?>"
							class="car-action-unit stm-brochure"
							title="<?php esc_attr_e( 'Download brochure', 'stm_vehicles_listing' ); ?>"
							download>
						<i class="motors-icons-brochure"></i>
						<?php esc_html_e( 'Car brochure', 'stm_vehicles_listing' ); ?>
					</a>
				</li>
			<?php endif; ?>
		<?php endif; ?>

		<!--Request quote-->
		<?php if ( $show_listing_quote ) : ?>
			<li>
				<a href="" class="car-action-unit set-vehicle-info" data-toggle="modal" data-target="#get-car-price" data-id="<?php echo esc_attr( $listing_id ); ?>" data-title="<?php echo esc_attr( apply_filters( 'stm_generate_title_from_slugs', get_the_title( $listing_id ), $listing_id, false ) ); ?>" data-price="<?php echo esc_attr( $price ); ?>">
					<i class="motors-icons-phone-chat"></i>
					<?php esc_html_e( 'Quote by Phone', 'stm_vehicles_listing' ); ?>
				</a>
			</li>
		<?php endif; ?>

		<!--Trade Value-->
		<?php if ( $show_listing_trade ) : ?>
			<li>
				<a href="#trade-offer" class="car-action-unit set-vehicle-info" data-toggle="modal" data-target="#trade-offer" data-id="<?php echo esc_attr( $listing_id ); ?>" data-title="<?php echo esc_attr( apply_filters( 'stm_generate_title_from_slugs', get_the_title( $listing_id ), $listing_id, false ) ); ?>">
					<i class="motors-icons-trade"></i>
					<?php esc_html_e( 'Trade-In', 'stm_vehicles_listing' ); ?>
				</a>
			</li>
		<?php endif; ?>

		<!--History Link-->
		<?php
		if ( $show_listing_vin ) :
			$history_link = get_post_meta( $listing_id, 'history_link', true );
			?>
			<li>
				<a href="<?php esc_url( $history_link ); ?>" class="car-action-unit" target="_blank">
					<i class="motors-icons-report"></i>
					<?php esc_html_e( 'History report', 'stm_vehicles_listing' ); ?>
				</a>
			</li>
		<?php endif; ?>

		<!--Share-->
		<?php if ( ! empty( $show_share ) && $show_share ) : ?>
			<li class="stm-shareble">
				<a
						href="#"
						class="car-action-unit stm-share"
						data-url="<?php echo esc_url( get_the_permalink( $listing_id ) ); ?>"
						title="<?php esc_attr_e( 'Share this', 'stm_vehicles_listing' ); ?>">
					<i class="motors-icons-share"></i>
					<?php esc_html_e( 'Share this', 'stm_vehicles_listing' ); ?>
				</a>
				<?php if ( function_exists( 'ADDTOANY_SHARE_SAVE_KIT' ) && ! get_post_meta( $listing_id, 'sharing_disabled', true ) ) : ?>
					<div class="stm-a2a-popup">
						<?php echo do_shortcode( '[addtoany url="' . get_the_permalink( $listing_id ) . '" title="' . get_the_title( $listing_id ) . '"]' ); ?>
					</div>
				<?php endif; ?>
			</li>
		<?php endif; ?>

		<!--Certified Logo 1-->
		<?php
		if ( ! empty( $certified_logo_1 ) && ! empty( $show_certified_logo_1 ) && $show_certified_logo_1 ) :
			if ( 'automanager_default' === $certified_logo_1 ) {
				$certified_logo_1    = array();
				$certified_logo_1[0] = STM_LISTINGS_URL . '/assets/images/carfax.png';
			} else {
				$certified_logo_1 = wp_get_attachment_image_src( $certified_logo_1, 'full' );
			}
			if ( ! empty( $certified_logo_1[0] ) ) {
				$certified_logo_1 = $certified_logo_1[0];

				?>

				<li class="certified-logo-1">
					<?php if ( ! empty( $history_link_1 ) ) : ?>
					<a href="<?php echo esc_url( $history_link_1 ); ?>" target="_blank">
						<?php endif; ?>
						<img src="<?php echo esc_url( $certified_logo_1 ); ?>" alt="<?php esc_attr_e( 'Logo 1', 'stm_vehicles_listing' ); ?>"/>
						<?php if ( ! empty( $history_link_1 ) ) : ?>
					</a>
				<?php endif; ?>
				</li>


			<?php } ?>
		<?php endif; ?>

		<!--Certified Logo 2-->
		<?php if ( ! empty( $certified_logo_2 ) && ! empty( $show_certified_logo_2 ) && $show_certified_logo_2 ) : ?>
			<?php
			$certified_logo_2 = wp_get_attachment_image_src( $certified_logo_2, 'full' );
			if ( ! empty( $certified_logo_2[0] ) ) {
				$certified_logo_2 = $certified_logo_2[0];
				?>


				<li class="certified-logo-2">
					<?php if ( ! empty( $certified_logo_2_link ) ) : ?>
					<a href="<?php echo esc_url( $certified_logo_2_link ); ?>" target="_blank">
						<?php endif; ?>
						<img src="<?php echo esc_url( $certified_logo_2 ); ?>" alt="<?php esc_attr_e( 'Logo 2', 'stm_vehicles_listing' ); ?>"/>
						<?php if ( ! empty( $certified_logo_2_link ) ) : ?>
					</a>
				<?php endif; ?>
				</li>

			<?php } ?>
		<?php endif; ?>

		<?php if ( isset( $review_id ) && ! is_null( $review_id ) ) : ?>
			<li class="listing-features">
				<div class="rating">
					<div class="rating-stars">
						<i class="rating-empty"></i>
						<?php $rate_sum = $rating_sum * 20; ?>
						<i class="rating-color" style="width: <?php echo esc_attr( $rate_sum ); ?>%;"></i>
					</div>
					<div class="rating-text heading-font">
						<?php
							printf(
								/* translators: %s rating sum */
								esc_html__( '%s out of 5.0', 'stm_vehicles_listing' ),
								esc_html( $rating_sum )
							);
						?>
					</div>
				</div>
			</li>
		<?php endif; ?>

	</ul>
</div>

<script>
	jQuery(document).ready(function () {
		var $ = jQuery;
		$('.set-vehicle-info').on('click', function () {
			var $popup = $($(this).data('target'));
			var stm_price = $(this).data('price');
			var stm_id = $(this).data('id');
			var stm_title = $(this).data('title');

			$popup.find('.test-drive-car-name').text(stm_title);
			$popup.find('.vehicle_price').val(stm_price);
			$popup.find('input[name="vehicle_id"]').val(stm_id);
		});
	})
</script>
