<?php
$val = ( '' !== get_option( 'trade_in_template', '' ) ) ? stripslashes( get_option( 'trade_in_template', '' ) ) :
	'<table>
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

$subject         = ( '' !== get_option( 'trade_in_subject', '' ) ) ? get_option( 'trade_in_subject', '' ) : 'Car trade in request';
$subjectSellACar = ( '' !== get_option( 'sell_a_car_subject', '' ) ) ? get_option( 'sell_a_car_subject', '' ) : 'Sell a car request';
?>
<div class="etm-single-form">
	<h3>Trade In Template</h3>
	<input type="text" name="trade_in_subject" value="<?php echo esc_attr( $subject ); ?>" class="full_width"/>
	<input type="text" name="sell_a_car_subject" value="<?php echo esc_attr( $subjectSellACar ); ?>" class="full_width"/>
	<div class="lr-wrap">
		<div class="left">
			<?php
			$sc_arg = array(
				'textarea_rows' => apply_filters( 'etm-ti-sce-row', 10 ), //phpcs:ignore
				'wpautop'       => true,
				'media_buttons' => apply_filters( 'etm-ti-sce-media_buttons', false ), //phpcs:ignore
				'tinymce'       => apply_filters( 'etm-ti-sce-tinymce', true ), //phpcs:ignore
			);

			wp_editor( $val, 'trade_in_template', $sc_arg );
			?>
		</div>
		<div class="right">
			<h4>Shortcodes</h4>
			<ul>
				<?php
				foreach ( getTemplateShortcodes( 'tradeIn' ) as $k => $val ) {
					echo wp_kses_post( "<li id='{$k}'><input type='text' value='{$val}' class='auto_select' /></li>" );
				}
				?>
			</ul>
		</div>
	</div>
</div>
