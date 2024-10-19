<?php

namespace MotorsVehiclesListing;

use _WP_Editors;
use STMMultiListing;

class SellerNoteMetaBoxes {
	public function __construct() {
		add_action( 'save_post', array( $this, 'save_metaboxes' ) );
		add_action( 'add_meta_boxes', array( $this, 'add_metaboxes' ) );
	}

	public function add_metaboxes() {
		$custom_post_types = ( class_exists( 'STMMultiListing' ) ) ? STMMultiListing::stm_get_listing_type_slugs() : array();
		$post_types        = array_merge( array( 'listings' ), $custom_post_types );

		add_meta_box(
			'listing_seller_note',
			esc_html__( 'Seller`s note', 'stm_vehicles_listing' ),
			array( $this, 'display_seller_notes' ),
			$post_types,
			'advanced',
			'high'
		);
	}

	public function display_seller_notes( $post, $metabox ) {
		$metabox_key = 'listing_seller_note';

		wp_nonce_field( plugin_basename( __FILE__ ), 'stm_custom_nonce' );

		$meta = get_post_meta( $post->ID, $metabox_key, true );

		_WP_Editors::editor(
			$meta,
			'editor_' . $metabox_key,
			array(
				'wpautop'       => false,
				'media_buttons' => false,
				'textarea_name' => $metabox_key,
				'textarea_rows' => 10,
				'tinymce'       => true,
				'quicktags'     => false,
			)
		);
		echo "<div style='clear:both; display:block;'></div>";
	}

	public function save_metaboxes( $post_id ) {

		if ( ! isset( $_POST['stm_custom_nonce'] ) ) { //phpcs:ignore
			return $post_id;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return $post_id;
		}

		$field = 'listing_seller_note';

		$old = get_post_meta( $post_id, $field, true );
		if ( isset( $_POST[ $field ] ) ) { //phpcs:ignore
			$new = wp_kses_post( $_POST[ $field ] );//phpcs:ignore

			if ( $new && $new != $old ) {//phpcs:ignore
				update_post_meta( $post_id, $field, $new );
			} elseif ( '' === $new && $old ) {
				delete_post_meta( $post_id, $field, $old );
			}
		} else {
			delete_post_meta( $post_id, $field, $old );
		}
	}
}
