<?php
$val = ( '' !== get_option( 'value_my_car_template', '' ) ) ? stripslashes( get_option( 'value_my_car_template', '' ) ) :
	'<table>
        <tr>
            <td>Hi!
According to our check you car can cost up to [price] USD.
Thank you!
 </td>
        </tr>
    </table>';

$valReject = ( '' !== get_option( 'value_my_car_reject_template', '' ) ) ? stripslashes( get_option( 'value_my_car_reject_template', '' ) ) :
	'<table>
        <tr>
            <td>Hi! 
Unfortunatelly we canno\'t estimate value of your car.
Thank you!</td>
        </tr>
    </table>';

$subject       = ( '' !== get_option( 'value_my_car_subject', '' ) ) ? get_option( 'value_my_car_subject', '' ) : 'Reply';
$subjectReject = ( '' !== get_option( 'value_my_car_reject_subject', '' ) ) ? get_option( 'value_my_car_reject_subject', '' ) : 'Reject';
?>
<div class="etm-single-form">
	<h3>Value My Car Template</h3>
	<label>Reply subject</label>
	<input type="text" name="value_my_car_subject" value="<?php echo esc_html( $subject ); ?>" class="full_width"/>
	<label>Reject subject</label>
	<input type="text" name="value_my_car_reject_subject" value="<?php echo esc_html( $subjectReject ); ?>" class="full_width"/>
	<div class="lr-wrap">
		<div class="left">
			<label>Reply text</label>
			<?php
			$sc_arg = array(
				'textarea_rows' => apply_filters( 'etm_aac_sce_row', 10 ),
				'wpautop'       => true,
				'media_buttons' => apply_filters( 'etm_aac_sce_media_buttons', false ),
				'tinymce'       => apply_filters( 'etm_aac_sce_tinymce', true ),
			);

			wp_editor( $val, 'value_my_car_template', $sc_arg );
			?>
		</div>
		<div class="left">
			<label>Reject text</label>
			<?php
			wp_editor( $valReject, 'value_my_car_reject_template', $sc_arg );
			?>
		</div>
		<div class="right">
			<h4>Shortcodes</h4>
			<ul>
				<?php
				foreach ( getTemplateShortcodes( 'valueMyCar' ) as $k => $val ) {
					echo wp_kses_post( "<li id='{$k}'><input type='text' value='{$val}' class='auto_select' /></li>" );
				}
				?>
			</ul>
		</div>
	</div>
</div>
