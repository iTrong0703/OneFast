<?php

/**
 * @var $title
 * @var $subtitle
 * @var $icon array
 * @var $icon_position
 * @var $title_separator
 * @var $price_separator
 * @var $badge_text
 * @var $badge_position
 * @var $currency
 * @var $price
 * @var $discount
 * @var $period_text
 * @var $button_position
 * @var $display_items
 * @var $items
 * @var $button_text
 * @var $pricing_plan
 * @var $button_link
 * @var $text_align
 * @var $items_align
 * @var $icon_html
 * @var $currency_position
 * @var $bottom_line_animation_hover
 * @var $title_separator_hover
 * @var $title_separator_narrow_effect
 * @var $price_separator_narrow_effect
 */

use Elementor\Icons_Manager;

if ( empty( $icon_position ) ) {
	$icon_position = 'none';
}

$plan_classes = array( 'stm-pricing-plan' );

if ( 'yes' === $title_separator_narrow_effect ) {
	$plan_classes[] = 'title_separator_narrow_effect';
}

if ( 'yes' === $price_separator_narrow_effect ) {
	$plan_classes[] = 'price_separator_narrow_effect';
}

if ( 'custom_link' !== $pricing_plan && is_numeric( $pricing_plan ) ) {
	$button_link = 'href="' . wc_get_checkout_url() . '?add-to-cart=' . $pricing_plan . '"';
} else {
	$button_link = 'href="' . esc_url( $button_link['url'] ) . '" target="' . esc_attr( $button_link['is_external'] ? '_blank' : '_self' ) . '"';
}
?>

<?php ob_start(); ?>
<div class="stm-pricing-plan__button">
	<a <?php echo wp_kses_post( $button_link ); ?>>
		<?php echo esc_html( $button_text ); ?>
	</a>
</div>
<?php $button_html = ob_get_clean(); ?>
<div class="<?php echo esc_html( join( ' ', $plan_classes ) ); ?>">
	<div class="stm-pricing-plan__wrapper text-align-<?php echo esc_html( $text_align ); ?>">
		<div class="stm-pricing-plan__header">
			<div class="stm-pricing-plan__header__wrapper icon-position-<?php echo esc_html( $icon_position ); ?>">
				<?php if ( $icon['value'] ) : ?>
					<div class="stm-pricing-plan__header__wrapper__icon">
						<?php echo wp_kses( apply_filters( 'stm_dynamic_icon_output', $icon_html ), apply_filters( 'stm_ew_kses_svg', array() ) ); ?>
					</div>
				<?php endif; ?>
				<div class="stm-pricing-plan__header-text">
					<div class="stm-pricing-plan__header-text__title">
						<?php echo esc_html( $title ); ?>
					</div>
					<div class="stm-pricing-plan__header-text__subtitle">
						<?php echo esc_html( $subtitle ); ?>
					</div>
				</div>
				<?php if ( ! empty( $badge_text ) ) : ?>
					<div class="stm-pricing-plan__header__badge badge-position-<?php echo esc_html( $badge_position ); ?>">
						<span><?php echo esc_html( $badge_text ); ?></span>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<?php if ( 'yes' === $title_separator ) : ?>
			<div class="stm-pricing-plan__separator stm-pricing-plan__separator__title">
				<div class="stm-pricing-plan__separator__element"></div>
			</div>
		<?php endif; ?>
		<div class="stm-pricing-plan__price-section">
			<div class="stm-pricing-plan__price">
				<?php if ( 'left' === $currency_position || empty( $currency_position ) ) : ?>
					<sup class="stm-pricing-plan__price__position-left"><?php echo esc_html( $currency ); ?></sup>
				<?php endif; ?>
				<span class="stm-pricing-plan__price__text"><?php echo esc_html( $price ); ?></span>
				<?php if ( ! empty( $discount ) ) : ?>
					<span class="stm-pricing-plan__price__discount">
						<s><?php echo esc_html( $discount ); ?></s>
					</span>
				<?php endif; ?>
				<?php if ( 'right' === $currency_position ) : ?>
					<sup class="stm-pricing-plan__price__position-right"><?php echo esc_html( $currency ); ?></sup>
				<?php endif; ?>
			</div>
			<?php if ( ! empty( $period_text ) ) : ?>
				<div class="stm-pricing-plan__period_text">
					<?php echo esc_html( $period_text ); ?>
				</div>
			<?php endif; ?>
		</div>
		<?php if ( 'yes' === $price_separator ) : ?>
			<div class="stm-pricing-plan__separator stm-pricing-plan__separator__price">
				<div class="stm-pricing-plan__separator__element"></div>
			</div>
		<?php endif; ?>
		<?php if ( 'under_price' === $button_position ) : ?>
			<?php echo wp_kses_post( $button_html ); ?>
		<?php endif; ?>
		<?php if ( 'yes' === $display_items && is_array( $items ) && count( $items ) ) : ?>
			<div class="stm-pricing-plan__items">
				<?php foreach ( $items as $item ) : ?>
					<p class="stm-pricing-plan__items__item elementor-repeater-item-<?php echo esc_html( $item['_id'] ); ?>">
						<?php if ( is_array( $item['item_icon'] ) && isset( $item['item_icon']['value'] ) && isset( $item['item_icon']['library'] ) ) : ?>
							<span class="stm-pricing-plan__items__item__icon">
								<?php Icons_Manager::render_icon( $item['item_icon'], array( 'aria-hidden' => 'true' ) ); ?>
							</span>
						<?php endif; ?>
						<span class="stm-pricing-plan__items__item__text">
							<?php echo $item['item_title'] ? esc_html( $item['item_title'] ) : esc_html__( '10 active listing quotas', 'motors-car-dealership-classified-listings-pro' ); ?>
						</span>
					</p>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		<?php if ( 'bottom' === $button_position ) : ?>
			<?php echo wp_kses_post( $button_html ); ?>
		<?php endif; ?>
		<div class="stm-pricing-plan__separator stm-pricing-plan__separator__bottom_line">
			<div class="stm-pricing-plan__separator__element"></div>
		</div>
	</div>
</div>
