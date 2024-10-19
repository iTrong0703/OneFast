<?php
/**
 * @var $field
 * @var $field_name
 * @var $section_name
 */

$is_enable   = $field_data['is_enable'] ?? false;
$is_pro_plus = $field_data['is_pro_plus'] ?? false;
$is_pro      = apply_filters( 'is_mvl_pro', false );

if ( $is_pro && ! $is_enable && ! $is_pro_plus ) {
	return;
}

$version = ( WP_DEBUG ) ? time() : STM_LISTINGS_V;
wp_enqueue_style( 'stm_lms_unlock_addons', STM_LISTINGS_URL . '/assets/css/nuxy/nuxy_unlock_addons.css', null, $version );

$label         = $field_data['label'] ?? '';
$img           = $field_data['img'] ?? '';
$description   = $field_data['desc'] ?? '';
$search_addon  = $field_data['search'] ?? '';
$utm_url       = $field_data['utm_url'] ?? '';
$slug          = str_replace( ' ', '-', mb_strtolower( $label ) );
$redirect_link = admin_url( 'admin.php?page=' . ( $is_enable ? "stm-addons&search={$search_addon}" : "motors-vl-go-pro&source=button-{$slug}-settings" ) );
$redirect_link = ! $is_enable && $is_pro_plus && $utm_url && $is_pro ? $utm_url : $redirect_link;
$link_text     = $is_enable ? esc_html__( 'Enable addon', 'stm_vehicles_listing' ) : esc_html__( 'Upgrade to PRO', 'stm_vehicles_listing' );
?>
<div class="motors-vl-unlock-pro-banner<?php echo esc_attr( $is_enable || ! $is_enable && $is_pro_plus ? ' addon_disabled' : '' ); ?>">
	<div class="motors-vl-unlock-banner-wrapper">
		<?php if ( ! empty( $img ) ) : ?>
			<div class="unlock-banner-image">
				<img src="<?php echo esc_url( $img ); ?>">
			</div>
		<?php endif; ?>
		<div class="unlock-wrapper-content">
			<h2>
				<?php
					echo $is_enable ? esc_html__( 'Enable', 'stm_vehicles_listing' ) : esc_html__( 'Unlock', 'stm_vehicles_listing' );
				?>
				<span class="unlock-addon-name">
					<?php
						echo esc_html( $label );
					?>
				</span>
				<?php
					echo esc_html__( 'with', 'stm_vehicles_listing' );
				?>
				<div class="unlock-pro-logo-wrapper">
					<span class="unlock-pro-logo"><?php echo esc_html__( 'Motors', 'stm_vehicles_listing' ); ?></span>
					<img src="<?php echo esc_url( STM_LISTINGS_URL . '/assets/images/pro/unlock-pro-logo.svg' ); ?>">
				</div>
			</h2>
			<p><?php echo esc_html( $description ); ?> </p>
			<div class="unlock-pro-banner-footer">
				<div class="unlock-addons-buttons">
					<a href="<?php echo esc_url( $redirect_link ); ?>" target="_blank" class="primary button btn">
						<?php echo esc_html( $link_text ); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
