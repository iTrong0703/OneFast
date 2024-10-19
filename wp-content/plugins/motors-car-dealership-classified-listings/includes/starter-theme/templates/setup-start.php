<div class="motors-starter-theme-setup">
	<div class="motors-starter-theme-back-to-dashboard">
		<a href="<?php echo esc_url( admin_url( '/' ) ); ?>">
			<i class="stm-mvl-left-arrow-icon"></i>
			<?php esc_html_e( 'Back to Dashboard', 'stm_vehicles_listing' ); ?>
		</a>
	</div>
	<div class="motors-starter-theme-setup-wrapper">

		<div class="motors-starter-theme-content step-1">
			<div class="stm-mvl-theme-preview">
				<img src="<?php echo esc_url( STM_LISTINGS_URL . '/assets/images/wizard-cover.jpg' ); ?>">
			</div>
			<div class="stm-mvl-theme-pre-install-info">
				<ul>
						<?php esc_html_e( 'A free ready-to-use starter theme for Motors Plugin. View how it works in life or install it for free. Get started now!', 'stm_vehicles_listing' ); ?>
				</ul>
				<div class="stm-mvl-attention">
					<div class="stm-mvl-attention-info">
						<span>
							<?php esc_html_e( 'If you continue with the installation, all previous data may be lost or displayed incorrectly.', 'stm_vehicles_listing' ); ?>
						</span>
					</div>
				</div>
			</div>
			<div class="motors-actions">
				<a target="_blank" class="motors-button default-btn" href="https://motors-plugin.stylemixthemes.com/">
					<?php esc_html_e( 'Live Demo', 'stm_vehicles_listing' ); ?>
				</a>
				<button class="motors-button main-btn buttonload button starter_install_theme_btn" name="starter_install_theme_btn">
					<span class="ui-button-text"> <?php echo esc_html( __( 'Install Now', 'stm_vehicles_listing' ) ); ?></span>
					<i class="fa fa-refresh fa-spin installing"></i>
					<i class="fa fa-check downloaded" aria-hidden="true"></i>
				</button>
			</div>
		</div>
	</div>
</div>
