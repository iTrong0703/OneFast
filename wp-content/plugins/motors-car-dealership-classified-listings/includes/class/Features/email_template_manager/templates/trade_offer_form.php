<?php
$val = ( '' !== get_option( 'trade_offer_template', '' ) ) ? stripslashes( get_option( 'trade_offer_template', '' ) ) :
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
            <td>Trade Offer - </td>
            <td>[price]</td>
        </tr>
    </table>';

$subject = ( '' !== get_option( 'trade_offer_subject', '' ) ) ? get_option( 'trade_offer_subject', '' ) : 'Request for a trade offer [car]';
?>
<div class="etm-single-form">
	<h3>Trade Offer Template</h3>
	<input type="text" name="trade_offer_subject" value="<?php echo esc_attr( $subject ); ?>" class="full_width"/>
	<div class="lr-wrap">
		<div class="left">
			<?php
			$sc_arg = array(
				'textarea_rows' => apply_filters( 'etm_to_sce_row', 10 ),
				'wpautop'       => true,
				'media_buttons' => apply_filters( 'etm_to_sce_media_buttons', false ),
				'tinymce'       => apply_filters( 'etm_to_sce_tinymce', true ),
			);

			wp_editor( $val, 'trade_offer_template', $sc_arg );
			?>
		</div>
		<div class="right">
			<h4>Shortcodes</h4>
			<ul>
				<?php
				foreach ( getTemplateShortcodes( 'tradeOffer' ) as $k => $val ) {
					echo wp_kses_post( "<li id='{$k}'><input type='text' value='{$val}' class='auto_select' /></li>" );
				}
				?>
			</ul>
		</div>
	</div>
</div>
