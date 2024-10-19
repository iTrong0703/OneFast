<?php
$val = ( '' !== get_option( 'user_listing_approved_template', '' ) ) ? stripslashes( get_option( 'user_listing_approved_template', '' ) ) :
	'<table>
        <tr>
            <td>Your car is Approved.</td>
            <td></td>
        </tr>
    </table>';

$subject = ( '' !== get_option( 'user_listing_approved_subject', '' ) ) ? get_option( 'user_listing_approved_subject', '' ) : 'Car Added';
?>
<div class="etm-single-form">
	<h3>User car is approved Template</h3>
	<input type="text" name="user_listing_approved_subject" value="<?php echo esc_html( $subject ); ?>" class="full_width"/>
	<div class="lr-wrap">
		<div class="left">
			<?php
			$sc_arg = array(
				'textarea_rows' => apply_filters( 'etm_aac_sce_row', 10 ),
				'wpautop'       => true,
				'media_buttons' => apply_filters( 'etm_aac_sce_media_buttons', false ),
				'tinymce'       => apply_filters( 'etm_aac_sce_tinymce', true ),
			);

			wp_editor( $val, 'user_listing_approved_template', $sc_arg );
			?>
		</div>
		<div class="right">
			<h4>Shortcodes</h4>
			<ul>
				<?php
				foreach ( getTemplateShortcodes( 'userCar' ) as $k => $val ) {
					echo wp_kses_post( "<li id='{$k}'><input type='text' value='{$val}' class='auto_select' /></li>" );
				}
				?>
			</ul>
		</div>
	</div>
</div>
