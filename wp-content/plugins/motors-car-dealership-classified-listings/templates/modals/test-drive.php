<div class="modal" id="test-drive" tabindex="-1" role="dialog" aria-labelledby="myModalLabelTestDrive">
	<form id="request-test-drive-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="post">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header modal-header-iconed">
					<i class="motors-icons-steering_wheel"></i>
					<h3 class="modal-title"
						id="myModalLabelTestDrive"><?php esc_html_e( 'Schedule a Test Drive', 'stm_vehicles_listing' ); ?></h3>
					<div class="test-drive-car-name"><?php echo wp_kses_post( apply_filters( 'stm_generate_title_from_slugs', get_the_title( get_the_ID() ), get_the_ID(), false ) ); ?></div>
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
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<div class="form-modal-label" id="motors-best-time"><?php esc_html_e( 'Best time', 'stm_vehicles_listing' ); ?></div>
								<div class="stm-datepicker-input-icon">
									<input type="text" name="date" aria-label="<?php esc_attr_e( 'Best time', 'stm_vehicles_listing' ); ?>" aria-labelledby="motors-best-time" class="stm-date-timepicker" autocomplete="Off"/>
								</div>
							</div>
						</div>
					</div>
					<div class="mg-bt-25px"></div>
					<div class="row">
						<div class="col-md-7 col-sm-7"></div>
						<div class="col-md-5 col-sm-5">
							<button type="submit" class="stm-request-test-drive">
								<?php esc_html_e( 'Request', 'stm_vehicles_listing' ); ?>
							</button>
							<div class="stm-ajax-loader" style="margin-top:10px;">
								<i class="motors-icons-load1"></i>
							</div>
						</div>
					</div>
					<div class="mg-bt-25px"></div>
					<input name="vehicle_id" type="hidden" value="<?php echo esc_attr( get_queried_object_id() ); ?>" />
					<input name="vehicle_name" type="hidden" value="<?php echo esc_attr( get_the_title( get_queried_object_id() ) ); ?>" />
					<div class="modal-body-message"></div>
				</div>
			</div>
		</div>
	</form>
</div>
