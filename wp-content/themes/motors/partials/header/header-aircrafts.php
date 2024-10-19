<?php
$logo_url     = apply_filters( 'stm_me_get_nuxy_img_src', '', 'logo' );
$logo_width   = apply_filters( 'stm_me_get_nuxy_mod', '160', 'logo_width' );
$fixed_header = apply_filters( 'stm_me_get_nuxy_mod', false, 'header_sticky' );

$fixed_header_class = '';
if ( ! empty( $fixed_header ) && $fixed_header ) {
	$fixed_header_class = 'header-listing-fixed';
}

if ( boolval( apply_filters( 'is_listing', array() ) ) ) {
	$fixed_header_class .= ' is-listing';
}

$transparent_header = get_post_meta( get_the_id(), 'transparent_header', true );

$transparent_header_class = '';

if ( empty( $transparent_header ) ) {
	$transparent_header_class = 'listing-nontransparent-header';
}

$fixed_body_class = ( is_front_page() || get_the_ID() === intval( apply_filters( 'motors_vl_get_nuxy_mod', 0, 'listing_archive' ) ) ) ? 'stm-body-fixed' : '';

$logo_margin_top      = apply_filters( 'stm_me_get_nuxy_mod', array( 'top' => '0' ), 'logo_margin_top' );
$menu_icon_top_margin = apply_filters( 'stm_me_get_nuxy_mod', array( 'top' => '0' ), 'menu_icon_top_margin' );
$menu_top_margin      = apply_filters( 'stm_me_get_nuxy_mod', array( 'top' => '0' ), 'menu_top_margin' );
?>

<div class="header-listing <?php echo esc_attr( $fixed_header_class . ' ' . $transparent_header_class ); ?> <?php echo ( wp_is_mobile() ) ? 'header-main-mobile' : ''; ?>">

	<div class="container header-inner-content">
		<!--Logo-->
		<div class="listing-logo-main"
				style="<?php echo esc_attr( apply_filters( 'stm_me_wpcfto_parse_spacing', '', $logo_margin_top ) ); ?>">
			<?php if ( stm_img_exists_by_url( $logo_url ) ) : ?>
				<a class="bloglogo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<img
							src="<?php echo esc_url( $logo_url ); ?>"
							style="width: <?php echo esc_attr( $logo_width ); ?>px;"
							title="<?php esc_attr_e( 'Home', 'motors' ); ?>"
							alt="<?php esc_attr_e( 'Logo', 'motors' ); ?>"
					/>
				</a>
			<?php else : ?>
				<a class="blogname" href="<?php echo esc_url( home_url( '/' ) ); ?>"
						title="<?php esc_attr_e( 'Home', 'motors' ); ?>">
					<h1><?php echo esc_attr( get_bloginfo( 'name' ) ); ?></h1>
				</a>
			<?php endif; ?>
		</div>

		<div class="listing-service-right clearfix"
				style="<?php echo esc_attr( apply_filters( 'stm_me_wpcfto_parse_spacing', '', $menu_icon_top_margin ) ); ?>">

			<div class="listing-right-actions">

				<?php get_template_part( 'partials/header/parts/add_a_car' ); ?>

				<?php get_template_part( 'partials/header/parts/profile' ); ?>

				<?php get_template_part( 'partials/header/parts/cart' ); ?>

				<?php get_template_part( 'partials/header/parts/compare' ); ?>

				<div class="listing-menu-mobile-wrapper">
					<div class="stm-menu-trigger <?php echo esc_attr( $fixed_body_class ); ?>">
						<span></span>
						<span></span>
						<span></span>
					</div>
					<div class="stm-opened-menu-listing">
						<ul class="listing-menu-mobile heading-font visible-xs visible-sm clearfix">
							<?php
							$location = ( has_nav_menu( 'primary' ) ) ? 'primary' : '';

							wp_nav_menu(
								array(
									'menu'           => $location,
									'theme_location' => $location,
									'depth'          => 3,
									'container'      => false,
									'menu_class'     => 'service-header-menu clearfix',
									'items_wrap'     => '%3$s',
									'fallback_cb'    => false,
								)
							);

							get_template_part( 'partials/header/parts/mobile_menu_items' );
							?>

						</ul>
						<?php get_template_part( 'partials/top', 'bar' ); ?>
					</div>
				</div>

			</div>

			<ul class="listing-menu clearfix"
					style="<?php echo esc_attr( apply_filters( 'stm_me_wpcfto_parse_spacing', '', $menu_top_margin ) ); ?>">
				<?php
				$location = ( has_nav_menu( 'primary' ) ) ? 'primary' : '';
				wp_nav_menu(
					array(
						'menu'           => $location,
						'theme_location' => $location,
						'depth'          => 3,
						'container'      => false,
						'menu_class'     => 'service-header-menu clearfix',
						'items_wrap'     => '%3$s',
						'fallback_cb'    => false,
					)
				);

				?>
			</ul>
		</div>
	</div>
</div>

<?php
if ( is_single() && apply_filters( 'stm_listings_post_type', 'listings' ) === get_post_type( get_the_ID() ) ) {
	get_template_part( 'partials/single-aircrafts/header-search' );
}
?>
