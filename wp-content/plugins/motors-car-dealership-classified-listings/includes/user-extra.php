<?php
// Adding fields
add_action( 'show_user_profile', 'stm_show_user_extra_fields' );
add_action( 'edit_user_profile', 'stm_show_user_extra_fields' );

if ( ! function_exists( 'stm_show_user_extra_fields' ) ) {
	function stm_show_user_extra_fields( $user ) { ?>

		<h3><?php esc_html_e( 'STM User/Dealer additional fields', 'stm_vehicles_listing' ); ?></h3>

		<table class="form-table">

			<tr>
				<th><label for="stm_show_email"><?php esc_html_e( 'Email visibility', 'stm_vehicles_listing' ); ?></label></th>
				
				<td>
					<label for="stm_show_email">
						<input type="checkbox" name="stm_show_email" id="stm_show_email" <?php echo ( ! empty( get_the_author_meta( 'stm_show_email', $user->ID ) ) ) ? 'checked="checked"' : ''; ?> />
						<?php esc_html_e( 'Email address is visible to anyone', 'stm_vehicles_listing' ); ?>
					</label>
				</td>
			</tr>

			<tr>
				<th><label for="stm_phone"><?php esc_html_e( 'Phone', 'stm_vehicles_listing' ); ?></label></th>

				<td>
					<input type="text" name="stm_phone" id="stm_phone"
						   value="<?php echo esc_attr( get_the_author_meta( 'stm_phone', $user->ID ) ); ?>"
						   class="regular-text"/><br/>
					<span class="description"><?php esc_html_e( 'User phone', 'stm_vehicles_listing' ); ?></span>
				</td>
			</tr>

			<tr>
				<th><label for="stm_whatsapp_number"><?php esc_html_e( 'WhatsApp Account', 'stm_vehicles_listing' ); ?></label></th>

				<td>
					<label for="stm_whatsapp_number">
						<input type="checkbox" name="stm_whatsapp_number" id="stm_whatsapp_number" <?php echo ( ! empty( get_the_author_meta( 'stm_whatsapp_number', $user->ID ) ) ) ? 'checked="checked"' : ''; ?> />
						<?php esc_html_e( 'User has WhatApp account with this number', 'stm_vehicles_listing' ); ?>
					</label>
				</td>
			</tr>

			<tr>
				<th><label for="stm_user_avatar"><?php esc_html_e( 'User Avatar', 'stm_vehicles_listing' ); ?></label></th>

				<td>
					<input type="text" name="stm_user_avatar" id="stm_user_avatar"
						   value="<?php echo esc_attr( get_the_author_meta( 'stm_user_avatar', $user->ID ) ); ?>"
						   class="regular-text"/><br/>
					<input type="text" name="stm_user_avatar_path" id="stm_user_avatar_path"
						   value="<?php echo esc_attr( get_the_author_meta( 'stm_user_avatar_path', $user->ID ) ); ?>"
						   class="regular-text"/><br/>
					<span class="description"><?php esc_html_e( 'User avatar(stores URL and path to image)', 'stm_vehicles_listing' ); ?></span>
				</td>
			</tr>

			<tr>
				<h4><?php esc_html_e( 'STM User/Dealer additional fields (socials)', 'stm_vehicles_listing' ); ?></h4>
			</tr>

			<!--Socials-->
			<tr>
				<th><label for="stm_user_facebook"><?php esc_html_e( 'Facebook', 'stm_vehicles_listing' ); ?></label></th>

				<td>
					<input type="text" name="stm_user_facebook" id="stm_user_facebook"
						   value="<?php echo esc_attr( get_the_author_meta( 'stm_user_facebook', $user->ID ) ); ?>"
						   class="regular-text"/>
				</td>
			</tr>

			<tr>
				<th><label for="stm_user_twitter"><?php esc_html_e( 'Twitter', 'stm_vehicles_listing' ); ?></label></th>

				<td>
					<input type="text" name="stm_user_twitter" id="stm_user_twitter"
						   value="<?php echo esc_attr( get_the_author_meta( 'stm_user_twitter', $user->ID ) ); ?>"
						   class="regular-text"/>
				</td>
			</tr>

			<tr>
				<th><label for="stm_user_linkedin"><?php esc_html_e( 'Linked In', 'stm_vehicles_listing' ); ?></label></th>

				<td>
					<input type="text" name="stm_user_linkedin" id="stm_user_linkedin"
						   value="<?php echo esc_attr( get_the_author_meta( 'stm_user_linkedin', $user->ID ) ); ?>"
						   class="regular-text"/>
				</td>
			</tr>

			<tr>
				<th><label for="stm_user_youtube"><?php esc_html_e( 'Youtube', 'stm_vehicles_listing' ); ?></label></th>

				<td>
					<input type="text" name="stm_user_youtube" id="stm_user_youtube"
						   value="<?php echo esc_attr( get_the_author_meta( 'stm_user_youtube', $user->ID ) ); ?>"
						   class="regular-text"/>
				</td>
			</tr>

			<tr>
				<th><label for="stm_user_favourites"><?php esc_html_e( 'User favorite car ids', 'stm_vehicles_listing' ); ?></label></th>

				<td>
					<input type="text" name="stm_user_favourites" id="stm_user_favourites"
						   value="<?php echo esc_attr( get_the_author_meta( 'stm_user_favourites', $user->ID ) ); ?>"
						   class="regular-text"/>
				</td>
			</tr>


			<!--Dealer-->
			<tr>
				<th><h2><?php esc_html_e( 'Dealer Settings', 'stm_vehicles_listing' ); ?></h2></th>
				<td><h3><?php esc_html_e( 'This settings will only be filled by dealers, and shown only on dealer page.', 'stm_vehicles_listing' ); ?></h3></td>
			</tr>

			<tr>
				<th><label for="stm_message_to_user"><?php esc_html_e( 'Message to pending user', 'stm_vehicles_listing' ); ?></label></th>

				<td>
					<input type="text" name="stm_message_to_user" id="stm_message_to_user"
						   value="<?php echo esc_attr( get_the_author_meta( 'stm_message_to_user', $user->ID ) ); ?>"
						   class="regular-text"/>
					<div>
					<span class="description"><?php esc_html_e( 'In case a user has entered incorrect details in Dealer submission, you can reject the request and add a notice.', 'stm_vehicles_listing' ); ?></span>
					</div>
				</td>
			</tr>

			<tr>
				<th><label for="stm_company_name"><?php esc_html_e( 'Company name', 'stm_vehicles_listing' ); ?></label></th>

				<td>
					<input type="text" name="stm_company_name" id="stm_company_name"
						   value="<?php echo esc_attr( get_the_author_meta( 'stm_company_name', $user->ID ) ); ?>"
						   class="regular-text"/>
				</td>
			</tr>

			<tr>
				<th><label for="stm_website_url"><?php esc_html_e( 'Website URL', 'stm_vehicles_listing' ); ?></label></th>

				<td>
					<input type="text" name="stm_website_url" id="stm_website_url"
						   value="<?php echo esc_attr( get_the_author_meta( 'stm_website_url', $user->ID ) ); ?>"
						   class="regular-text"/>
				</td>
			</tr>

			<tr>
				<th><label for="stm_company_license"><?php esc_html_e( 'License', 'stm_vehicles_listing' ); ?></label></th>

				<td>
					<input type="text" name="stm_company_license" id="stm_company_license"
						   value="<?php echo esc_attr( get_the_author_meta( 'stm_company_license', $user->ID ) ); ?>"
						   class="regular-text"/>
				</td>
			</tr>

			<tr>
				<th><label for="stm_dealer_logo"><?php esc_html_e( 'Dealer Logo', 'stm_vehicles_listing' ); ?></label></th>

				<td>
					<input type="text" name="stm_dealer_logo" id="stm_dealer_logo"
						   value="<?php echo esc_attr( get_the_author_meta( 'stm_dealer_logo', $user->ID ) ); ?>"
						   class="regular-text"/><br/>
					<input type="text" name="stm_dealer_logo_path" id="stm_dealer_logo_path"
						   value="<?php echo esc_attr( get_the_author_meta( 'stm_dealer_logo_path', $user->ID ) ); ?>"
						   class="regular-text"/><br/>
					<span class="description"><?php esc_html_e( 'Dealer logo(stores URL and path to image)', 'stm_vehicles_listing' ); ?></span>
				</td>
			</tr>

			<tr>
				<th><label for="stm_dealer_image"><?php esc_html_e( 'Dealer Image', 'stm_vehicles_listing' ); ?></label></th>

				<td>
					<input type="text" name="stm_dealer_image" id="stm_dealer_image"
						   value="<?php echo esc_attr( get_the_author_meta( 'stm_dealer_image', $user->ID ) ); ?>"
						   class="regular-text"/><br/>
					<input type="text" name="stm_dealer_image_path" id="stm_dealer_image_path"
						   value="<?php echo esc_attr( get_the_author_meta( 'stm_dealer_image_path', $user->ID ) ); ?>"
						   class="regular-text"/><br/>
					<span class="description"><?php esc_html_e( 'Dealer image(stores URL and path to image)', 'stm_vehicles_listing' ); ?></span>
				</td>
			</tr>

			<tr>
				<th><label for="stm_dealer_location"><?php esc_html_e( 'Dealer Location', 'stm_vehicles_listing' ); ?></label></th>

				<td>
					<input type="text" name="stm_dealer_location" id="stm_dealer_location"
						   value="<?php echo esc_attr( get_the_author_meta( 'stm_dealer_location', $user->ID ) ); ?>"
						   class="regular-text"/>
					<div class="description"><?php esc_html_e( 'Dealer location address', 'stm_vehicles_listing' ); ?></div>
					<input type="text" name="stm_dealer_location_lat" id="stm_dealer_location_lat"
						   value="<?php echo esc_attr( get_the_author_meta( 'stm_dealer_location_lat', $user->ID ) ); ?>"
						   class="regular-text"/>
					<div class="description"><?php esc_html_e( 'Dealer location latitude', 'stm_vehicles_listing' ); ?></div>
					<input type="text" name="stm_dealer_location_lng" id="stm_dealer_location_lng"
						   value="<?php echo esc_attr( get_the_author_meta( 'stm_dealer_location_lng', $user->ID ) ); ?>"
						   class="regular-text"/>
					<div class="description"><?php esc_html_e( 'Dealer location longitude', 'stm_vehicles_listing' ); ?></div>
				</td>
			</tr>

			<tr>
				<th><label for="stm_sales_hours"><?php esc_html_e( 'Sales Hours', 'stm_vehicles_listing' ); ?></label></th>

				<td>
					<input type="text" name="stm_sales_hours" id="stm_sales_hours"
						   value="<?php echo esc_attr( get_the_author_meta( 'stm_sales_hours', $user->ID ) ); ?>"
						   class="regular-text"/>
				</td>
			</tr>

			<tr>
				<th><label for="stm_seller_notes"><?php esc_html_e( 'Seller Notes', 'stm_vehicles_listing' ); ?></label></th>

				<td>
					<textarea name="stm_seller_notes" id="stm_seller_notes"><?php echo esc_attr( get_the_author_meta( 'stm_seller_notes', $user->ID ) ); ?></textarea>
				</td>
			</tr>

			<tr>
				<th><label for="stm_payment_status"><?php esc_html_e( 'Payment status', 'stm_vehicles_listing' ); ?></label></th>

				<td>
					<input type="text" name="stm_payment_status" id="stm_payment_status"
						   value="<?php echo esc_attr( get_the_author_meta( 'stm_payment_status', $user->ID ) ); ?>"
						   class="regular-text"/>
				</td>
			</tr>

			<tr>
				<td>
					<input type="hidden" name="stm_lost_password_hash" id="stm_lost_password_hash"
						   value="<?php echo esc_attr( get_the_author_meta( 'stm_lost_password_hash', $user->ID ) ); ?>"
						   class="regular-text"/>
				</td>
			</tr>

		</table>
		<?php
	}
}

// Updating fields
add_action( 'personal_options_update', 'stm_save_user_extra_fields' );
add_action( 'edit_user_profile_update', 'stm_save_user_extra_fields' );

if ( ! function_exists( 'stm_save_user_extra_fields' ) ) {
	function stm_save_user_extra_fields( $user_id ) {

		if ( ! current_user_can( 'edit_user', $user_id ) ) {
			return false;
		}

		update_user_meta( $user_id, 'stm_phone', sanitize_text_field( $_POST['stm_phone'] ) );
		update_user_meta( $user_id, 'stm_whatsapp_number', sanitize_text_field( $_POST['stm_whatsapp_number'] ) );

		// remove 'has whatsapp account' if no number is provided
		if ( empty( $_POST['stm_phone'] ) ) {
			update_user_meta( $user_id, 'stm_whatsapp_number', '' );
		}

		/*Socials*/
		update_user_meta( $user_id, 'stm_show_email', sanitize_text_field( $_POST['stm_show_email'] ) );
		update_user_meta( $user_id, 'stm_user_avatar', sanitize_text_field( $_POST['stm_user_avatar'] ) );
		update_user_meta( $user_id, 'stm_user_avatar_path', sanitize_text_field( $_POST['stm_user_avatar_path'] ) );
		update_user_meta( $user_id, 'stm_user_facebook', sanitize_text_field( $_POST['stm_user_facebook'] ) );
		update_user_meta( $user_id, 'stm_user_twitter', sanitize_text_field( $_POST['stm_user_twitter'] ) );
		update_user_meta( $user_id, 'stm_user_linkedin', sanitize_text_field( $_POST['stm_user_linkedin'] ) );
		update_user_meta( $user_id, 'stm_user_youtube', sanitize_text_field( $_POST['stm_user_youtube'] ) );
		update_user_meta( $user_id, 'stm_user_favourites', sanitize_text_field( $_POST['stm_user_favourites'] ) );
		update_user_meta( $user_id, 'stm_company_name', sanitize_text_field( $_POST['stm_company_name'] ) );
		update_user_meta( $user_id, 'stm_website_url', sanitize_text_field( $_POST['stm_website_url'] ) );
		update_user_meta( $user_id, 'stm_company_license', sanitize_text_field( $_POST['stm_company_license'] ) );
		update_user_meta( $user_id, 'stm_message_to_user', sanitize_text_field( $_POST['stm_message_to_user'] ) );
		update_user_meta( $user_id, 'stm_dealer_logo', sanitize_text_field( $_POST['stm_dealer_logo'] ) );
		update_user_meta( $user_id, 'stm_dealer_logo_path', sanitize_text_field( $_POST['stm_dealer_logo_path'] ) );
		update_user_meta( $user_id, 'stm_dealer_image', sanitize_text_field( $_POST['stm_dealer_image'] ) );
		update_user_meta( $user_id, 'stm_dealer_image_path', sanitize_text_field( $_POST['stm_dealer_image_path'] ) );
		update_user_meta( $user_id, 'stm_dealer_location', sanitize_text_field( $_POST['stm_dealer_location'] ) );
		update_user_meta( $user_id, 'stm_dealer_location_lat', sanitize_text_field( $_POST['stm_dealer_location_lat'] ) );
		update_user_meta( $user_id, 'stm_dealer_location_lng', sanitize_text_field( $_POST['stm_dealer_location_lng'] ) );
		update_user_meta( $user_id, 'stm_sales_hours', sanitize_text_field( $_POST['stm_sales_hours'] ) );
		update_user_meta( $user_id, 'stm_seller_notes', sanitize_text_field( $_POST['stm_seller_notes'] ) );
		update_user_meta( $user_id, 'stm_payment_status', sanitize_text_field( $_POST['stm_payment_status'] ) );
		update_user_meta( $user_id, 'stm_lost_password_hash', $_POST['stm_lost_password_hash'] ); // no need to sanitize password
	}
}

if ( ! function_exists( 'stm_stop_access_profile' ) ) {
	add_action( 'admin_menu', 'stm_stop_access_profile' );
	function stm_stop_access_profile() {
		remove_menu_page( 'profile.php' );
		remove_submenu_page( 'users.php', 'profile.php' );
	}
}
