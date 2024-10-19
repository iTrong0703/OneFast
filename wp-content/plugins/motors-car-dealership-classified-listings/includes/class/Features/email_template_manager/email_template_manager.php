<?php
require_once STM_LISTINGS_PATH . '/includes/class/Features/email_template_manager/etm-helper.php';

if ( ! function_exists( 'add_email_template_view' ) ) {
	add_action( 'wpcfto_screen_motors_vehicles_listing_plugin_settings_added', 'add_email_template_view', 15, 1 );

	function add_email_template_view() {
		$title = esc_html__( 'Email Template Manager', 'stm_vehicles_listing' );
		add_submenu_page( 'mvl_plugin_settings', $title, $title, 'administrator', 'email-templaet-manager', 'email_template_view' );

		add_filter(
			'mvl_submenu_positions',
			function ( $positions ) {
				$positions['email-templaet-manager'] = 16;

				return $positions;
			}
		);
	}
}

if ( ! function_exists( 'email_template_view' ) ) {
	function email_template_view() {
		include STM_LISTINGS_PATH . '/includes/class/Features/email_template_manager/main.php';
	}
}

if ( ! function_exists( 'get_default_subject' ) ) {
	function get_default_subject( $template_name ) {
		$test_drive              = esc_html__(
			'Request Tes.stm-sell-a-car-form {
	.form-navigation {
		.form-navigation-unit {
			display: block;
			text-decoration: none !important;
			padding-bottom: 17px;
			border-bottom: 6px solid #eaedf0;
			&.validated {
				.number {
					text-indent: -200px !important;
					&:before {
						right: 0%;
					}
				}
			}
			&[href="#step-two"] {
				.number {
					text-indent: 2px;
				}
			}
			.number {
				position: relative;
				margin-bottom: 13px;
				width: 31px;
				height: 31px;
				border: 3px solid $orange-dk;
				border-radius: 50%;
				line-height: 25px;
				font-weight: 700;
				text-align: center;
				color: $orange-dk;
				font-size: 16px;
				text-indent: 3px;
				overflow: hidden;
				&:before {
					@include pseudo();
					@include fa();
					width: 100%;
					height: 100%;
					position: absolute;
					top: 0;
					right: -100%;
					line-height: 25px;
					content: "\f00c";
					font-size: 16px;
					text-indent: 0 !important;
				}
			}
			.title {
				margin: 0 0 -1px 3px;
				font-weight: 700;
				font-size: 16px;
				text-transform: uppercase;
			}
			.sub-title {
				margin-left: 4px;
				color: rgba(35, 38, 40, 0.5);
				font-size: 13px;
			}
			// Active
			&.active {
				border-bottom-color: $orange-dk;
				.number {
					background-color: $orange-dk;
					color: $white;
				}
			}
		}
	}
	.form-content {
		padding-top: 44px;
		.form-content-unit {
			display: none;
			&.active {
				display: block;
			}
			.contact-us-label {
				color: #555;
			}
		}
		.vehicle-condition {
			padding-top: 6px;
			.vehicle-condition-unit {
				padding-bottom: 33px;
				margin-bottom: 34px;
				border-bottom: 1px solid #e2e5e8;
				.icon {
					margin-bottom: 13px;
					font-size: 30px;
					color: $black-near;
					&.buoy {
						font-size: 34px;
					}
					&.buoy-2 {
						font-size: 35px;
					}
				}
				.title {
					margin-bottom: 16px;
				}
				label {
					margin-right: 40px;
					&:last-child {
						margin-right: 0;
					}
				}
			}
		}
		.contact-details {
			margin: 6px 0 43px;
			padding: 40px 41px 36px;
			background-color: #ebedef;
			textarea {
				height: 106px;
			}
			.form-group {
				margin-bottom: 24px;
			}
			.contact-us-label {
				margin-bottom: 2px;
			}
		}
	}
	.form-upload-files {
		.stm-unit-photos {
			float: left;
			width: 38.48%;
			margin-right: 54px;
		}
		.stm-unit-url {
			overflow: hidden;
		}
	}
	input[type="submit"] {
		width: 220px;
		margin-right: 48px;
	}
	.disclaimer {
		padding-right: 20px;
		margin-top: 2px;
		line-height: 22px;
		overflow: hidden;
		color: #555;
	}
}

.sell-a-car-proceed {
	margin-top: 27px;
	max-width: 220px;
}

.form-upload-files {
	padding: 30px 30px 35px;
	margin: 15px 0 5px;
	border: 3px solid #ebedef;
}

.stm-pseudo-file-input {
	position: relative;
	z-index: 20;
	&.generated {
		margin-top: 15px;
		.stm-plus:after {
			display: none;
		}
	}
	&:hover {
		cursor: pointer;
	}
	&:before {
		@include pseudo();
		@include stm_font();
		color: #c0c1c3;
		content: "\e932";
		position: absolute;
		top: 10px;
		left: 15px;
		font-size: 20px;
	}
	.stm-plus {
		position: absolute;
		width: 42px;
		height: 42px;
		top: 0;
		right: 0;
		background-color: #ebedef;
		z-index: 20;
		&:after {
			@include pseudo();
			position: absolute;
			top: 50%;
			left: 50%;
			margin: -4px 0 0 -1px;
			width: 3px;
			height: 9px;
			background-color: #aaa;
		}
		&:before {
			@include pseudo();
			position: absolute;
			top: 50%;
			left: 50%;
			margin: -1px 0 0 -4px;
			width: 9px;
			height: 3px;
			background-color: #aaa;
		}
	}
	.stm-filename {
		padding: 10px 10px 10px 40px;
		margin-right: 56px;
		background-color: #ebedef;
		color: #888888;
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
	}
	.stm-file-realfield {
		position: absolute;
		width: 100%;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		opacity: 0;
		z-index: 15;
		&:hover {
			cursor: pointer;
		}
	}
}

#error-fields {
	margin-top: 20px !important;
}t Drive [car]',
			'stm_vehicles_listing'
		); //phpcs:ignore
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
}

if ( ! function_exists( 'getDefaultTemplate' ) ) {
	function getDefaultTemplate( $template_name ) {
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
}

if ( ! function_exists( 'getTemplateShortcodes' ) ) {
	function getTemplateShortcodes( $template_name ) {
		$testDrive = array(
			'car'       => '[car]',
			'f_name'    => '[name]',
			'email'     => '[email]',
			'phone'     => '[phone]',
			'best_time' => '[best_time]',
		);

		$requestPrice = array(
			'car'    => '[car]',
			'f_name' => '[name]',
			'email'  => '[email]',
			'phone'  => '[phone]',
		);

		$tradeOffer = array(
			'car'    => '[car]',
			'f_name' => '[name]',
			'email'  => '[email]',
			'phone'  => '[phone]',
			'price'  => '[price]',
		);

		$tradeIn = array(
			'car'                => '[car]',
			'first_name'         => '[first_name]',
			'last_name'          => '[last_name]',
			'email'              => '[email]',
			'phone'              => '[phone]',
			'make'               => '[make]',
			'model'              => '[model]',
			'stm_year'           => '[stm_year]',
			'transmission'       => '[transmission]',
			'mileage'            => '[mileage]',
			'vin'                => '[vin]',
			'exterior_color'     => '[exterior_color]',
			'interior_color'     => '[interior_color]',
			'owner'              => '[owner]',
			'exterior_condition' => '[exterior_condition]',
			'interior_condition' => '[interior_condition]',
			'accident'           => '[accident]',
			'comments'           => '[comments]',
			'video_url'          => '[video_url]',
			'image_urls'         => '[image_urls]',
		);

		$addACar = array(
			'user_id' => '[user_id]',
			'car_id'  => '[car_id]',
		);

		$userCar = array(
			'car_id'    => '[car_id]',
			'car_title' => '[car_title]',
		);

		$updateACarPPL = array(
			'user_id'       => '[user_id]',
			'car_id'        => '[car_id]',
			'revision_link' => '[revision_link]',
		);

		$perPayListing = array(
			'first_name'    => '[first_name]',
			'last_name'     => '[last_name]',
			'email'         => '[email]',
			'order_id'      => '[order_id]',
			'order_status'  => '[order_status]',
			'listing_title' => '[listing_title]',
			'car_id'        => '[car_id]',
		);

		$reportReview = array(
			'report_id'      => '[report_id]',
			'review_content' => '[review_content]',
		);

		$passwordRecovery = array(
			'password_content' => '[password_content]',
		);

		$requestForADealer = array(
			'user_login' => '[user_login]',
		);

		$welcome = array(
			'user_login' => '[user_login]',
		);

		$valueMyCar = array(
			'car'   => '[car]',
			'email' => '[email]',
			'price' => '[price]',
		);

		$newUser = array(
			'user_login' => '[user_login]',
		);

		$userConfirmationEmail = array(
			'user_login'        => '[user_login]',
			'confirmation_link' => '[confirmation_link]',
			'site_name'         => '[site_name]',
		);

		return ${'' . $template_name};
	}
}

if ( ! function_exists( 'updateTemplates' ) ) {
	function updateTemplates() {
		$opt = array(
			'add_a_car_',
			'user_listing_wait_',
			'user_listing_approved_',
			'update_a_car_ppl_',
			'trade_in_',
			'trade_offer_',
			'request_price_',
			'test_drive_',
			'update_a_car_',
			'report_review_',
			'password_recovery_',
			'request_for_a_dealer_',
			'welcome_',
			'new_user_',
			'pay_per_listing_',
			'value_my_car_',
			'user_email_confirmation_',
		);

		foreach ( $opt as $key ) {
			update_option( $key . 'template', $_POST[ $key . 'template' ] ); // todo sanitize
			update_option( $key . 'subject', $_POST[ $key . 'subject' ] ); // todo sanitize
			if ( 'trade_in_' === $key ) {
				update_option( 'sell_a_car_subject', $_POST['sell_a_car_subject'] ); // todo sanitize
			} elseif ( 'value_my_car_' === $key ) {
				update_option( 'value_my_car_reject_subject', $_POST['value_my_car_reject_subject'] ); // todo sanitize
				update_option( 'value_my_car_reject_template', $_POST['value_my_car_reject_template'] ); // todo sanitize
			}
		}
	}
}

if ( isset( $_POST['update_email_templates'] ) ) {
	updateTemplates();
}

if ( ! function_exists( 'stm_generate_subject_view' ) ) {
	function stm_generate_subject_view( $default, $subject_name, $args ) {
		$template = stripslashes( get_option( $subject_name . '_subject', get_default_subject( $subject_name ) ) );

		if ( '' !== $template ) {
			foreach ( $args as $k => $val ) {
				$template = str_replace( "[{$k}]", $val, $template );
			}

			return $template;
		}

		return $default;
	}

	add_filter( 'get_generate_subject_view', 'stm_generate_subject_view', 20, 3 );
}

if ( ! function_exists( 'stm_generate_template_view' ) ) {
	function stm_generate_template_view( $default, $template_name, $args ) {
		$template = stripslashes( get_option( $template_name . '_template', getDefaultTemplate( $template_name ) ) );

		if ( ! empty( $template ) ) {
			foreach ( $args as $k => $val ) {
				$template = str_replace( "[{$k}]", $val, $template );
			}

			return $template;
		}

		return $default;
	}

	add_filter( 'get_generate_template_view', 'stm_generate_template_view', 20, 3 );
}
