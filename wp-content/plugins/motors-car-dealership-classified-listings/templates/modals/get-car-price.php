<div class="modal" id="get-car-price" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<form id="get-car-price-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="post">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header modal-header-iconed">
					<i class="motors-icons-steering_wheel"></i>
					<h3 class="modal-title" id="myModalLabel">
						<?php esc_html_e( 'Request car price', 'stm_vehicles_listing' ); ?>
					</h3>
					<div class="test-drive-car-name"><?php echo wp_kses_post( get_the_title( get_the_ID() ) ); ?></div>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<div class="form-modal-label"><?php esc_html_e( 'Name', 'stm_vehicles_listing' ); ?></div>
								<input name="name" type="text"/>
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<div class="form-modal-label"><?php esc_html_e( 'Email', 'stm_vehicles_listing' ); ?></div>
								<input name="email" type="email"/>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<div class="form-modal-label"><?php esc_html_e( 'Phone', 'stm_vehicles_listing' ); ?></div>
								<input name="phone" type="tel"/>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 col-sm-4">
							<button type="submit"
									class="stm-request-test-drive"><?php esc_html_e( 'Request', 'stm_vehicles_listing' ); ?></button>
							<div class="stm-ajax-loader" style="margin-top:10px;">
								<i class="fa fa-spinner"></i>
							</div>
						</div>
					</div>
					<div class="mg-bt-25px"></div>
					<input name="vehicle_id" type="hidden" value="<?php echo esc_attr( get_queried_object_id() ); ?>" />
				</div>
			</div>
		</div>
	</form>
</div>
