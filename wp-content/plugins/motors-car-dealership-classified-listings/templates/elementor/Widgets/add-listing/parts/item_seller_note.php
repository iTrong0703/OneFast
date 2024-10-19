<?php

$_id = apply_filters( 'stm_listings_input', null, 'item_id' );

$note = '';
if ( ! empty( $_id ) ) {
	$note = apply_filters( 'stm_get_listing_seller_note', $_id );
}

if ( $custom_listing_type && $listing_types_options && isset( $listing_types_options[ $custom_listing_type . '_addl_seller_note_content' ] ) ) {
	$stm_phrases = $listing_types_options[ $custom_listing_type . '_addl_seller_note_content' ];
} else {
	$stm_phrases = apply_filters( 'motors_vl_get_nuxy_mod', '', 'addl_seller_note_content' );
}

?>

<div class="stm-form-5-notes clearfix">
	<div class="stm-car-listing-data-single stm-border-top-unit ">
		<div class="title heading-font"><?php esc_html_e( 'Enter Seller\'s notes', 'motors-car-dealership-classified-listings-pro' ); ?></div>
	</div>
	<div class="row stm-relative">
		<div class="col-md-9 col-sm-9 stm-non-relative">
			<div class="stm-phrases-unit">
				<?php
				if ( ! empty( $stm_phrases ) ) :
					$stm_phrases = explode( ',', wp_strip_all_tags( $stm_phrases ) );
					?>
					<div class="stm_phrases">
						<div class="inner">
							<i class="fas fa-times"></i>
							<h5><?php esc_html_e( 'Select all the phrases that apply to your vehicle.', 'motors-car-dealership-classified-listings-pro' ); ?></h5>
							<?php if ( ! empty( $stm_phrases ) ) : ?>
								<div class="clearfix">
									<?php foreach ( $stm_phrases as $phrase ) : ?>
										<label>
											<input type="checkbox" name="stm_phrase" value="<?php echo esc_attr( $phrase ); ?>"/>
											<span><?php echo wp_kses_post( $phrase ); ?></span>
										</label>
									<?php endforeach; ?>
								</div>
								<a href="#" class="button"><?php esc_html_e( 'Apply', 'motors-car-dealership-classified-listings-pro' ); ?></a>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>
				<?php
				wp_editor(
					$note,
					'stm_seller_notes',
					array(
						'wpautop'       => true,
						'media_buttons' => false,
						'textarea_name' => 'stm_seller_notes',
						'textarea_rows' => 10,
						'teeny'         => true,
						'quicktags'     => false,
						'editor_css'    => '<style>.mce-btn button {background-color: #ccc; box-shadow: 0 2px 0 #ddd;}</style>',
						'tinymce'       => array(
							'init_instance_callback' => 'function(editor) {
                                editor.on("change", function(){
                                    jQuery("#stm_seller_notes").text(this.getBody().innerHTML);
                            });
                        }',
						),
					)
				);
				?>
			</div>
		</div>
		<?php if ( ! empty( $stm_phrases ) ) : ?>
			<div class="col-md-3 col-sm-3 hidden-xs">
				<div class="stm-seller-notes-phrases heading-font">
					<span><?php esc_html_e( 'Add the Template Phrases', 'motors-car-dealership-classified-listings-pro' ); ?></span>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>
