<?php
$val = ( '' !== get_option( 'request_price_template', '' ) ) ? stripslashes( get_option( 'request_price_template', '' ) ) :
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
    </table>';

$subject = ( '' !== get_option( 'request_price_subject', '' ) ) ? get_option( 'request_price_subject', '' ) : 'Request car price [car]';
?>
<div class="etm-single-form">
	<h3>Request Price Template</h3>
	<input type="text" name="request_price_subject" value="<?php echo esc_html( $subject ); ?>" class="full_width"/>
	<div class="lr-wrap">
		<div class="left">
			<?php
			$sc_arg = array(
				'textarea_rows' => apply_filters( 'etm_rp_sce_row', 10 ),
				'wpautop'       => true,
				'media_buttons' => apply_filters( 'etm_rp_sce_media_buttons', false ),
				'tinymce'       => apply_filters( 'etm_rp_sce_tinymce', true ),
			);

			wp_editor( $val, 'request_price_template', $sc_arg );
			?>
		</div>
		<div class="right">
			<h4>Shortcodes</h4>
			<ul>
				<?php
				foreach ( getTemplateShortcodes( 'requestPrice' ) as $k => $val ) {
					echo wp_kses_post( "<li id='{$k}'><input type='text' value='{$val}' class='auto_select' /></li>" );
				}
				?>
			</ul>
		</div>
	</div>
</div>
