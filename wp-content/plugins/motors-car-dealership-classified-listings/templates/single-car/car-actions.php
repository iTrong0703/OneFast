<?php
defined( 'ABSPATH' ) || exit; // Exit if accessed directly

$_listing_id = get_the_ID();

$stock_number          = get_post_meta( $_listing_id, 'stock_number', true );
$certified_logo_1      = get_post_meta( $_listing_id, 'certified_logo_1', true );
$certified_logo_1_link = get_post_meta( $_listing_id, 'history_link', true );
$certified_logo_2      = get_post_meta( $_listing_id, 'certified_logo_2', true );
$certified_logo_2_link = get_post_meta( $_listing_id, 'certified_logo_2_link', true );
$show_added_date       = apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_added_date' );
$show_stock            = apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_stock' );
$show_compare          = apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_compare' );
$show_pdf              = apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_pdf' );
$show_print_btn        = apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_print_btn' );
$show_certified_logo_1 = apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_certified_logo_1' );
$show_certified_logo_2 = apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_certified_logo_2' );
$show_trade_in         = apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_trade_in' );
$show_test_drive       = apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_test_drive' );
$show_share            = apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_share' );
?>

<div class="single-car-actions">
	<ul class="list-unstyled clearfix">
		<!--Added date-->
		<?php if ( $show_added_date ) : ?>
			<li class="added-date-action">
				<span class="added_date">
					<i class="far fa-clock"></i>
					<span class="added_date_info">
						<span class="added_date_info_text">
							<?php esc_html_e( 'ADDED: ', 'stm_vehicles_listing' ); ?>
						</span>
						<?php echo esc_html( get_the_modified_date( 'F d, Y' ) ); ?>
					</span>
				</span>
			</li>
		<?php endif; ?>
		<!--Stock num-->
		<?php if ( ! empty( $stock_number ) && ! empty( $show_stock ) ) : ?>
			<li>
				<div class="stock-num heading-font">
					<span>
						<?php esc_html_e( 'stock', 'stm_vehicles_listing' ); ?>
						#
					</span>
					<?php echo esc_attr( $stock_number ); ?>
				</div>
			</li>
		<?php endif; ?>

		<!--Compare-->
		<?php
		if ( ! empty( $show_compare ) ) :
			$_listing_type    = get_post_type( $_listing_id );
			$in_compare       = array_map( 'absint', apply_filters( 'stm_get_compared_items', array(), $_listing_type ) );
			$_compare_add     = __( 'Add to compare', 'stm_vehicles_listing' );
			$_compare_remove  = __( 'Remove from compare', 'stm_vehicles_listing' );
			$_compare_classes = 'car-action-unit add-to-compare';
			$_compare_title   = $_compare_add;
			$_compare_icon    = 'add';

			if ( in_array( $_listing_id, $in_compare, true ) ) {
				$_compare_classes .= ' active';
				$_compare_title    = $_compare_remove;
				$_compare_icon     = 'remove';
			}
			?>
			<li>
				<a
						href="#"
						class="<?php echo esc_attr( $_compare_classes ); ?>"
						title="<?php echo esc_attr( $_compare_title ); ?>"
						data-id="<?php echo esc_attr( $_listing_id ); ?>"
						data-title="<?php echo esc_attr( get_the_title() ); ?>"
						data-post-type="<?php echo esc_attr( $_listing_type ); ?>"
				>
					<i class="<?php printf( 'motors-icons-%s', esc_attr( $_compare_icon ) ); ?>"></i>
					<span><?php echo esc_html( $_compare_title ); ?></span>
				</a>
				<?php //phpcs:disable ?>
				<script type="text/javascript">
                    var stm_label_add    = "<?php echo esc_js( $_compare_add ); ?>";
                    var stm_label_remove = "<?php echo esc_js( $_compare_remove ); ?>";
				</script>
				<?php //phpcs:enable ?>
			</li>
		<?php endif; ?>

		<!--Print button-->
		<?php if ( $show_print_btn ) : ?>
			<li>
				<a href="javascript:window.print()" class="car-action-unit stm-car-print">
					<i class="fas fa-print"></i>
					<span class="stm-item-title">
						<?php esc_html_e( 'Print page', 'stm_vehicles_listing' ); ?>
					</span>
				</a>
			</li>
		<?php endif; ?>

		<!--Schedule-->
		<?php if ( $show_test_drive ) : ?>
			<li>
				<a href="#" class="car-action-unit stm-schedule" data-toggle="modal" data-target="#test-drive">
					<i class="motors-icons-steering_wheel"></i>
					<span class="stm-item-title">
						<?php esc_html_e( 'Schedule Test Drive', 'stm_vehicles_listing' ); ?>
					</span>
				</a>
			</li>
		<?php endif; ?>

		<!--PDF-->
		<?php
		if ( ! empty( $show_pdf ) ) :
			$_listing_brochure = get_post_meta( $_listing_id, 'car_brochure', true );
			if ( wp_attachment_is( 'pdf', $_listing_brochure ) ) :
				?>
				<li>
					<a
							href="<?php echo esc_url( wp_get_attachment_url( $_listing_brochure ) ); ?>"
							class="car-action-unit stm-brochure"
							title="<?php esc_attr_e( 'Download brochure', 'stm_vehicles_listing' ); ?>"
							download>
						<i class="motors-icons-brochure"></i>
						<?php esc_html_e( 'Car brochure', 'stm_vehicles_listing' ); ?>
					</a>
				</li>
				<?php
				endif;
		endif;
		?>

		<!--Share-->
		<?php if ( $show_share && function_exists( 'ADDTOANY_SHARE_SAVE_KIT' ) ) : ?>
			<li class="stm-shareble">
				<a
						href="#"
						class="car-action-unit stm-share"
						title="<?php esc_attr_e( 'Share this', 'stm_vehicles_listing' ); ?>">
					<i class="motors-icons-share"></i>
					<span class="stm-item-title">
						<?php esc_html_e( 'Share this', 'stm_vehicles_listing' ); ?>
					</span>
				</a>
				<div class="stm-a2a-popup">
					<?php echo wp_kses_post( apply_filters( 'stm_add_to_any_shortcode', $_listing_id ) ); ?>
				</div>
			</li>
		<?php endif; ?>

		<!--Certified Logo 1-->
		<?php if ( ! empty( $show_certified_logo_1 ) && wp_attachment_is_image( $certified_logo_1 ) ) : ?>
			<li class="certified-logo-1">
				<?php if ( ! empty( $certified_logo_1_link ) ) : ?>
				<a href="<?php echo esc_url( $certified_logo_1_link ); ?>" target="_blank">
					<?php endif; ?>
					<img src="<?php echo esc_url( wp_get_attachment_image_url( $certified_logo_1, 'full' ) ); ?>"
						alt="<?php esc_attr_e( 'Logo 1', 'stm_vehicles_listing' ); ?>"/>
					<?php if ( ! empty( $certified_logo_1_link ) ) : ?>
				</a>
			<?php endif; ?>
			</li>
		<?php endif; ?>

		<!--Certified Logo 2-->
		<?php if ( ! empty( $show_certified_logo_2 ) && wp_attachment_is_image( $certified_logo_2 ) ) : ?>
			<li class="certified-logo-2">
				<?php if ( ! empty( $certified_logo_2_link ) ) : ?>
				<a href="<?php echo esc_url( $certified_logo_2_link ); ?>" target="_blank">
					<?php endif; ?>
					<img src="<?php echo esc_url( wp_get_attachment_image_url( $certified_logo_2, 'full' ) ); ?>"
						alt="<?php esc_attr_e( 'Logo 2', 'stm_vehicles_listing' ); ?>"/>
					<?php if ( ! empty( $certified_logo_2_link ) ) : ?>
				</a>
			<?php endif; ?>
			</li>
		<?php endif; ?>

	</ul>
</div>
