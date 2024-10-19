<?php
$val = ( '' !== get_option( 'pay_per_listing_template', '' ) ) ? stripslashes( get_option( 'pay_per_listing_template', '' ) ) :
	'<table>
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

$subject = ( '' !== get_option( 'pay_per_listing_subject', '' ) ) ? get_option( 'pay_per_listing_subject', '' ) : 'New Pay Per Listing';
?>
<div class="etm-single-form">
	<h3>Pay Per Listing Template</h3>
	<input type="text" name="pay_per_listing_subject" value="<?php echo esc_html( $subject ); ?>" class="full_width"/>
	<div class="lr-wrap">
		<div class="left">
			<?php
			$sc_arg = array(
				'textarea_rows' => apply_filters( 'etm_aac_sce_row', 10 ),
				'wpautop'       => true,
				'media_buttons' => apply_filters( 'etm_aac_sce_media_buttons', false ),
				'tinymce'       => apply_filters( 'etm_aac_sce_tinymce', true ),
			);

			wp_editor( $val, 'pay_per_listing_template', $sc_arg );
			?>
		</div>
		<div class="right">
			<h4>Shortcodes</h4>
			<ul>
				<?php
				foreach ( getTemplateShortcodes( 'perPayListing' ) as $k => $val ) {
					echo wp_kses_post( "<li id='{$k}'><input type='text' value='{$val}' class='auto_select' /></li>" );
				}
				?>
			</ul>
		</div>
	</div>
</div>
