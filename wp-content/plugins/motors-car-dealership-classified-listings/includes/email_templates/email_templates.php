<?php
function motors_vl_get_default_subject( $template_name ) {
	$test_drive              = esc_html__( 'Request Test Drive [car]', 'stm_vehicles_listing' );
	$request_price           = esc_html__( 'Request car price [car]', 'stm_vehicles_listing' );
	$trade_offer             = esc_html__( 'Trade offer [car]', 'stm_vehicles_listing' );
	$trade_in                = esc_html__( 'Car Trade In', 'stm_vehicles_listing' );
	$sell_a_car              = esc_html__( 'Sell a car', 'stm_vehicles_listing' );
	$add_a_car               = esc_html__( 'Car Added', 'stm_vehicles_listing' );
	$pay_per_listing         = esc_html__( 'New Pay Per Listing', 'stm_vehicles_listing' );
	$report_review           = esc_html__( 'Report Review', 'stm_vehicles_listing' );
	$password_recovery       = esc_html__( 'Password recovery', 'stm_vehicles_listing' );
	$request_for_a_dealer    = esc_html__( 'Request for becoming a dealer', 'stm_vehicles_listing' );
	$welcome                 = esc_html__( 'Welcome', 'stm_vehicles_listing' );
	$new_user                = esc_html__( 'New user', 'stm_vehicles_listing' );
	$user_listing_wait       = esc_html__( 'Add a car', 'stm_vehicles_listing' );
	$user_listing_approved   = esc_html__( 'Car Approved', 'stm_vehicles_listing' );
	$user_email_confirmation = esc_html__( 'User Email Confirm', 'stm_vehicles_listing' );

	return ${'' . $template_name};
}

function motors_vl_getDefaultTemplate( $template_name ) {
	$test_drive = '<table>
        <tr>
            <td>Name - </td>
            <td>[name]</td>
        </tr>
        <tr>
            <td>Email - </td>
            <td>[email]</td>
        </tr>
        <tr>
            <td>Phone - </td>
            <td>[phone]</td>
        </tr>
        <tr>
            <td>Date - </td>
            <td>[best_time]</td>
        </tr>
		<tr>
            <td>Car - </td>
            <td>[car]</td>
        </tr>
    </table>';

	$user_email_confirmation = '<table>
        <tr>
            <td>
            Howdy [user_login],

			Your new account is set up.
			
			Please confirm your account:
			
			<a href="[confirmation_link]">Confirmation</a>
			
			Thanks!
			</td>
        </tr>
    </table>';

	$request_price = '<table>
        <tr>
            <td>Name - </td>
            <td>[name]</td>
        </tr>
        <tr>
            <td>Email - </td>
            <td>[email]</td>
        </tr>
        <tr>
            <td>Phone - </td>
            <td>[phone]</td>
        </tr>
    </table>';

	$trade_offer = '<table>
        <tr>
            <td>Name - </td>
            <td>[name]</td>
        </tr>
        <tr>
            <td>Email - </td>
            <td>[email]</td>
        </tr>
        <tr>
            <td>Phone - </td>
            <td>[phone]</td>
        </tr>
        <tr>
            <td>Trade Offer - </td>
            <td>[price]</td>
        </tr>
    </table>';

	$trade_in = '<table>
        <tr>
            <td>First name - </td>
            <td>[first_name]</td>
        </tr>
        <tr>
            <td>Last Name - </td>
            <td>[last_name]</td>
        </tr>
        <tr>
            <td>Email - </td>
            <td>[email]</td>
        </tr>
        <tr>
            <td>Phone - </td>
            <td>[phone]</td>
        </tr>
        <tr>
            <td>Car - </td>
            <td>[car]</td>
        </tr>
        <tr>
            <td>Make - </td>
            <td>[make]</td>
        </tr>
        <tr>
            <td>Model - </td>
            <td>[model]</td>
        </tr>
        <tr>
            <td>Year - </td>
            <td>[stm_year]</td>
        </tr>
        <tr>
            <td>Transmission - </td>
            <td>[transmission]</td>
        </tr>
        <tr>
            <td>Mileage - </td>
            <td>[mileage]</td>
        </tr>
        <tr>
            <td>Vin - </td>
            <td>[vin]</td>
        </tr>
        <tr>
            <td>Exterior color</td>
            <td>[exterior_color]</td>
        </tr>
        <tr>
            <td>Interior color</td>
            <td>[interior_color]</td>
        </tr>
        <tr>
            <td>Exterior condition</td>
            <td>[exterior_condition]</td>
        </tr>
        <tr>
            <td>Interior condition</td>
            <td>[interior_condition]</td>
        </tr>
        <tr>
            <td>Owner</td>
            <td>[owner]</td>
        </tr>
        <tr>
            <td>Accident</td>
            <td>[accident]</td>
        </tr>
        <tr>
            <td>Comments</td>
            <td>[comments]</td>
        </tr>
    </table>';

	$add_a_car = '<table>
        <tr>
            <td>User Added car.</td>
            <td></td>
        </tr>
        <tr>
            <td>User id - </td>
            <td>[user_id]</td>
        </tr>
        <tr>
            <td>Car ID - </td>
            <td>[car_id]</td>
        </tr>
    </table>';

	$update_a_car_ppl = '<table>
        <tr>
            <td>User Updated car.</td>
            <td></td>
        </tr>
        <tr>
            <td>User id - </td>
            <td>[user_id]</td>
        </tr>
        <tr>
            <td>Car ID - </td>
            <td>[car_id]</td>
        </tr>
        <tr>
            <td>Revision Link - </td>
            <td>[revision_link]</td>
        </tr>
    </table>';

	$pay_per_listing = '<table>
        <tr>
            <td>New Pay Per Listing. Order id - </td>
            <td>[order_id]</td>
        </tr>
        <tr>
            <td>Order status - </td>
            <td>[order_status]</td>
        </tr>
        <tr>
            <td>User - </td>
            <td>[first_name] [last_name] [email]</td>
        </tr>
        <tr>
            <td>Car Title - </td>
            <td>[listing_title]</td>
        </tr>
        <tr>
            <td>Car Id - </td>
            <td>[car_id]</td>
        </tr>
    </table>';

	$report_review = '<table>
        <tr>
            <td colspan="2">Review with id: "[report_id]" was reported</td>
        </tr>
        <tr>
            <td>Report content</td>
            <td>[review_content]</td>
        </tr>
    </table>';

	$password_recovery = '<table>
        <tr>
            <td>Please, follow the link, to set new password:</td>
            <td><a href="[password_content]">[password_content]</a></td>
        </tr>
    </table>';

	$request_for_a_dealer = '<table>
        <tr>
            <td>User Login:</td>
            <td>[user_login]</td>
        </tr>
    </table>';

	$welcome = '<table>
        <tr>
            <td>Congratulations! You have been registered in our website with a username: </td>
            <td>[user_login]</td>
        </tr>
    </table>';

	$new_user = '<table>
        <tr>
            <td>New user Registered. Nickname: </td>
            <td>[user_login]</td>
        </tr>
    </table>';

	$user_listing_wait = '<table>
        <tr>
            <td>Your car [car_title] is waiting to approve.</td>
            <td></td>
        </tr>
    </table>';

	$user_listing_approved = '<table>
        <tr>
            <td>Your car [car_title] is approved.</td>
            <td></td>
        </tr>
    </table>';

	return ${'' . $template_name};
}

function motors_vl_generate_subject_view( $default, $subject_name, $args ) {
	$template = stripslashes( get_option( $subject_name . '_subject', motors_vl_get_default_subject( $subject_name ) ) );

	if ( '' !== $template ) {
		foreach ( $args as $k => $val ) {
			$template = str_replace( "[{$k}]", $val, $template );
		}

		return $template;
	}

	return $default;
}

add_filter( 'get_generate_subject_view', 'motors_vl_generate_subject_view', 10, 3 );

function motors_vl_generate_template_view( $default, $template_name, $args ) {
	$template = stripslashes( get_option( $template_name . '_template', motors_vl_getDefaultTemplate( $template_name ) ) );

	if ( ! empty( $template ) ) {
		foreach ( $args as $k => $val ) {
			$template = str_replace( "[{$k}]", $val, $template );
		}

		return $template;
	}

	return $default;
}

add_filter( 'get_generate_template_view', 'motors_vl_generate_template_view', 10, 3 );
