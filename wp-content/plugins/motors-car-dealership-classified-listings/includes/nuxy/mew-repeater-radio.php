<?php
wp_enqueue_script( 'mew-button-component', STM_LISTINGS_URL . '/assets/js/elementor/nuxy/mew-repeater-radio.js' );
wp_enqueue_style( 'mew-button', STM_LISTINGS_URL . '/assets/css/elementor/nuxy/mew-repeater-radio.css' );
?>
<wpcfto_mew_repeater_radio v-bind:fields="<?php echo esc_attr( $field ); ?>"
						   v-bind:parent_repeater="'parent'"
						   v-bind:field_label="<?php echo esc_attr( $field_label ); ?>"
						   v-bind:field_name="'<?php echo esc_attr( $field_name ); ?>'"
						   v-bind:field_id="'<?php echo esc_attr( $field_id ); ?>'"
						   v-bind:field_value="<?php echo esc_attr( $field_value ); ?>"
						   v-bind:field_data='<?php echo esc_attr( str_replace( "'", '', wp_json_encode( $field_data ) ) ); ?>'
						   @wpcfto-get-value="$set(<?php echo esc_attr( $field ); ?>, 'value', $event)"
>
</wpcfto_mew_repeater_radio>

<input type="hidden"
	   :style="{'width' : '100%'}"
	   name="<?php echo esc_attr( $field_name ); ?>"
	   v-bind:id="'<?php echo esc_attr( $field_id ); ?>'"
	   v-model="JSON.stringify(<?php echo esc_attr( wp_unslash( $field_value ) ); ?>)"/>
