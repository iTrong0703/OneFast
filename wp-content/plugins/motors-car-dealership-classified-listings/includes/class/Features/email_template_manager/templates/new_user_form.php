<?php
$val = ( '' !== get_option( 'new_user_template', '' ) ) ? stripslashes( get_option( 'new_user_template', '' ) ) :
	'<table>
        <tr>
            <td>New user Registered. Nickname: </td>
            <td>[user_login]</td>
        </tr>
    </table>';

$subject = ( '' !== get_option( 'new_user_subject', '' ) ) ? get_option( 'new_user_subject', '' ) : 'New user';
?>
<div class="etm-single-form">
	<h3>New User Template</h3>
	<input type="text" name="new_user_subject" value="<?php echo esc_html( $subject ); ?>" class="full_width"/>
	<div class="lr-wrap">
		<div class="left">
			<?php
			$sc_arg = array(
				'textarea_rows' => apply_filters( 'etm_aac_sce_row', 10 ),
				'wpautop'       => true,
				'media_buttons' => apply_filters( 'etm_aac_sce_media_buttons', false ),
				'tinymce'       => apply_filters( 'etm_aac_sce_tinymce', true ),
			);

			wp_editor( $val, 'new_user_template', $sc_arg );
			?>
		</div>
		<div class="right">
			<h4>Shortcodes</h4>
			<ul>
				<?php
				foreach ( getTemplateShortcodes( 'newUser' ) as $k => $val ) {
					echo wp_kses_post( "<li id='{$k}'><input type='text' value='{$val}' class='auto_select' /></li>" );
				}
				?>
			</ul>
		</div>
	</div>
</div>
