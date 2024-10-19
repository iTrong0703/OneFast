<?php
	/**
	 * @var $step_title
	 * @var $step_number
	 * */
?>
<div class="stm-car-listing-data-single stm-border-top-unit">
	<div class="title heading-font"><?php echo esc_html( $step_title ); ?></div>
	<?php if ( defined( 'WPB_VC_VERSION' ) ) : ?>
		<span class="step_number heading-font <?php /* translators: %d step number */ printf( 'step_number_%d', esc_attr( $step_number ) ); ?>">
			<?php
			/* translators: %d step number */
			printf( esc_html__( 'step %d', 'stm_vehicles_listing' ), esc_html( $step_number ) );
			?>
		</span>
	<?php endif; ?>
</div>
