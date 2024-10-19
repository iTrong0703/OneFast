<?php
$val = ( '' !== get_option( 'test_drive_template', '' ) ) ? stripslashes( get_option( 'test_drive_template', '' ) ) :
	'<table>
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

$subject = ( '' !== get_option( 'test_drive_subject', '' ) ) ? get_option( 'test_drive_subject', '' ) : 'Request for a test drive [car]';
?>
<div class="etm-single-form">
	<h3>Test Drive template</h3>
	<input type="text" name="test_drive_subject" value="<?php echo esc_html( $subject ); ?>" class="full_width"/>
	<div class="lr-wrap">
		<div class="left">
			<?php
			$sc_arg = array(
				'textarea_rows' => apply_filters( 'etm_sce_row', 10 ),
				'wpautop'       => true,
				'media_buttons' => apply_filters( 'etm_sce_media_buttons', false ),
				'tinymce'       => apply_filters( 'etm_sce_tinymce', true ),
			);

			wp_editor( $val, 'test_drive_template', $sc_arg );
			?>
		</div>
		<div class="right">
			<h4>Shortcodes</h4>
			<ul>
				<?php
				foreach ( getTemplateShortcodes( 'testDrive' ) as $k => $val ) {
					echo wp_kses_post( "<li id='{$k}'><input type='text' value='{$val}' class='auto_select' /></li>" );
				}
				?>
			</ul>
		</div>
	</div>
</div>
