<?php
$val = ( '' !== get_option( 'password_recovery_template', '' ) ) ? stripslashes( get_option( 'password_recovery_template', '' ) ) :
	'<table>
        <tr>
            <td>Please, follow the link, to set new password:</td>
            <td><a href="[password_content]">[password_content]</a></td>
        </tr>
    </table>';

$subject = ( '' !== get_option( 'password_recovery_subject', '' ) ) ? get_option( 'password_recovery_subject', '' ) : 'Password recovery';
?>
<div class="etm-single-form">
	<h3>Password Recovery Template</h3>
	<input type="text" name="password_recovery_subject" value="<?php echo esc_html( $subject ); ?>" class="full_width"/>
	<div class="lr-wrap">
		<div class="left">
			<?php
			$sc_arg = array(
				'textarea_rows' => apply_filters( 'etm_aac_sce_row', 10 ),
				'wpautop'       => true,
				'media_buttons' => apply_filters( 'etm_aac_sce_media_buttons', false ),
				'tinymce'       => apply_filters( 'etm_aac_sce_tinymce', true ),
			);

			wp_editor( $val, 'password_recovery_template', $sc_arg );
			?>
		</div>
		<div class="right">
			<h4>Shortcodes</h4>
			<ul>
				<?php
				foreach ( getTemplateShortcodes( 'passwordRecovery' ) as $k => $val ) {
					echo wp_kses_post( "<li id='{$k}'><input type='text' value='{$val}' class='auto_select' /></li>" );
				}
				?>
			</ul>
		</div>
	</div>
</div>
