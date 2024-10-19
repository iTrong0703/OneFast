<?php

namespace Motors_Elementor_Widgets_Free\Helpers;

use Elementor\Plugin;

class Helper {

	public static function stm_ew_log( $message ) {
		error_log( $message . PHP_EOL, 3, STM_LISTINGS_PATH . '/error.log' ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
	}

	/**
	 * Load template
	 *
	 * @param $__template
	 * @param array $__vars
	 */
	public static function stm_ew_load_template( $__template, $plugin_path = STM_LISTINGS_PATH, $__vars = array() ) {
		global $listing_id, $wpdb;
		extract( $__vars ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract

		if ( ( 'listing_template' === get_post_type( get_the_ID() ) ) ) {
			$listing_row = $wpdb->get_results( "SELECT ID FROM {$wpdb->prefix}posts WHERE post_status='publish' AND post_type='listings' ORDER BY ID ASC LIMIT 1 OFFSET 0" ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery
			$listing_id  = $listing_row[0]->ID;
		}

		do_action( 'stm_listings_load_template', $__template, $__vars );
	}

	public static function stm_ew_get_image_sizes( $include_default = false, $include_default_blank = false, $show_resolutions = false ) {
		$sizes = array();

		if ( $include_default_blank ) {
			$sizes = array(
				'' => __( 'Theme Default', 'motors-car-dealership-classified-listings-pro' ),
			);
		}

		$custom_sizes = wp_get_additional_image_sizes();
		if ( ! empty( $custom_sizes ) ) {
			foreach ( $custom_sizes as $name => $data ) {
				// if starts with 'stm-img' and does NOT end in '-x-2'.
				if ( 'stm-img' === substr( $name, 0, 7 ) && '-x-2' !== substr( $name, - 4, 4 ) ) {
					if ( $show_resolutions ) {
						$sizes[ $name ] = $data['width'] . ' x ' . $data['height'];
					} else {
						$sizes[ $name ] = $name;
					}
				}
			}
		}

		if ( $include_default ) {
			$sizes = array_merge(
				$sizes,
				array(
					'medium' => __( 'Medium', 'motors-car-dealership-classified-listings-pro' ),
					'large'  => __( 'Large', 'motors-car-dealership-classified-listings-pro' ),
					'full'   => __( 'Full', 'motors-car-dealership-classified-listings-pro' ),
				)
			);
		}

		return $sizes;
	}

	public static function stm_ew_get_listing_taxonomies( $include_label = false ) {

		if ( function_exists( 'stm_get_categories' ) ) {
			$filter_options = stm_get_categories( $include_label );

			return array_flip( $filter_options );
		}

		return array();
	}

	public static function stm_ew_get_listing_taxonomy_terms( $slug = array() ) {
		$terms   = get_terms(
			array(
				'taxonomy'   => $slug,
				'hide_empty' => false,
			)
		);
		$options = array();
		foreach ( $terms as $term ) {
			$options[ $term->slug ] = $term->name;
		}

		return $options;
	}

	public static function stm_ew_get_value_my_car_options() {
		$stm_value_my_car_options = array(
			'email'   => esc_html__( 'Email', 'motors-car-dealership-classified-listings-pro' ),
			'phone'   => esc_html__( 'Phone', 'motors-car-dealership-classified-listings-pro' ),
			'make'    => esc_html__( 'Make', 'motors-car-dealership-classified-listings-pro' ),
			'model'   => esc_html__( 'Model', 'motors-car-dealership-classified-listings-pro' ),
			'year'    => esc_html__( 'Year', 'motors-car-dealership-classified-listings-pro' ),
			'mileage' => esc_html__( 'Mileage', 'motors-car-dealership-classified-listings-pro' ),
			'vin'     => esc_html__( 'VIN', 'motors-car-dealership-classified-listings-pro' ),
			'photo'   => esc_html__( 'Photo', 'motors-car-dealership-classified-listings-pro' ),
		);

		return $stm_value_my_car_options;
	}

	public static function stm_ew_get_car_filter_fields() {
		if ( function_exists( 'stm_get_car_filter' ) ) {
			$filter_options = apply_filters( 'stm_get_car_filter', array() );

			$only_use_on_car_filter_options = array();

			if ( ! empty( $filter_options ) ) {
				foreach ( $filter_options as $filter_option ) {
					$only_use_on_car_filter_options[ $filter_option['slug'] ] = $filter_option['single_name'];
				}
			}

			if ( ! in_array( 'location', $only_use_on_car_filter_options, true ) ) {
				$only_use_on_car_filter_options['location'] = esc_html__( 'Location', 'motors-car-dealership-classified-listings-pro' );
			}

			return $only_use_on_car_filter_options;
		}

		return array();
	}

	public static function stm_ew_get_multilisting_types( $include_default = false ) {
		$listing_types = array();

		if ( $include_default ) {
			$listing_types = array(
				'listings' => __( 'Listings (default)', 'motors-car-dealership-classified-listings-pro' ),
			);
		}

		if ( is_plugin_active( 'motors-listing-types/motors-listing-types.php' ) ) {
			$options = get_option( 'stm_motors_listing_types' );

			if ( isset( $options['multilisting_repeater'] ) && ! empty( $options['multilisting_repeater'] ) ) {
				foreach ( $options['multilisting_repeater'] as $key => $listing ) {
					$listing_types[ $listing['slug'] ] = $listing['label'];
				}
			}
		}

		return $listing_types;
	}

	public static function stm_ew_resize_image( $attach_id, $img_url, $width, $height, $crop = true ) {
		// this is an attachment, so we have the ID.
		$image_src = array();
		if ( $attach_id ) {
			$image_src        = wp_get_attachment_image_src( $attach_id, 'full' );
			$actual_file_path = get_attached_file( $attach_id );
			// this is not an attachment, let's use the image url.
		} elseif ( $img_url ) {
			$file_path        = wp_parse_url( $img_url );
			$actual_file_path = rtrim( ABSPATH, '/' ) . $file_path['path'];
			$orig_size        = getimagesize( $actual_file_path );
			$image_src[0]     = $img_url;
			$image_src[1]     = $orig_size[0];
			$image_src[2]     = $orig_size[1];
		}
		if ( ! empty( $actual_file_path ) ) {
			$file_info = pathinfo( $actual_file_path );
			$extension = '.' . $file_info['extension'];

			// the image path without the extension.
			$no_ext_path = $file_info['dirname'] . '/' . $file_info['filename'];

			$cropped_img_path = $no_ext_path . '-' . $width . 'x' . $height . $extension;

			// checking if the file size is larger than the target size.
			// if it is smaller or the same size, stop right here and return.
			if ( $image_src[1] > $width || $image_src[2] > $height ) {

				// the file is larger, check if the resized version already exists (for $crop = true but will also work for $crop = false if the sizes match).
				if ( file_exists( $cropped_img_path ) ) {
					$cropped_img_url = str_replace( basename( $image_src[0] ), basename( $cropped_img_path ), $image_src[0] );
					$vt_image        = array( $cropped_img_url, $width, $height, false );

					return $vt_image;
				}

				if ( ! $crop ) {
					// calculate the size proportionaly.
					$proportional_size = wp_constrain_dimensions( $image_src[1], $image_src[2], $width, $height );
					$resized_img_path  = $no_ext_path . '-' . $proportional_size[0] . 'x' . $proportional_size[1] . $extension;

					// checking if the file already exists.
					if ( file_exists( $resized_img_path ) ) {
						$resized_img_url = str_replace( basename( $image_src[0] ), basename( $resized_img_path ), $image_src[0] );

						$vt_image = array( $resized_img_url, $proportional_size[0], $proportional_size[1], false );

						return $vt_image;
					}
				}

				// no cache files - let's finally resize it.
				$img_editor = wp_get_image_editor( $actual_file_path );

				if ( is_wp_error( $img_editor ) || is_wp_error( $img_editor->resize( $width, $height, $crop ) ) ) {
					return array( null, null, null, false );
				}

				$new_img_path = $img_editor->generate_filename();

				if ( is_wp_error( $img_editor->save( $new_img_path ) ) ) {
					return array( null, null, null, false );
				}
				if ( ! is_string( $new_img_path ) ) {
					return array( null, null, null, false );
				}

				$new_img_size = getimagesize( $new_img_path );
				$new_img      = str_replace( basename( $image_src[0] ), basename( $new_img_path ), $image_src[0] );

				// resized output.
				$vt_image = array( $new_img, $new_img_size[0], $new_img_size[1], true );

				return $vt_image;
			}

			// default output - without resizing.
			$vt_image = array( $image_src[0], $image_src[1], $image_src[2], false );

			return $vt_image;
		}

		return false;
	}

	public static function stm_ew_get_cf7_select() {
		$response = array();

		if ( ! defined( 'WPCF7_VERSION' ) ) {
			return $response;
		}

		$forms = get_posts(
			array(
				'post_type'      => 'wpcf7_contact_form',
				'posts_per_page' => - 1,
			)
		);

		if ( ! empty( $forms ) ) {
			foreach ( $forms as $form ) {
				$response[ $form->ID ] = $form->post_title;
			}
		}

		return $response;
	}

	public static function stm_ew_has_overflown_fields( $fields = array() ) {
		$summary_width = 0;
		foreach ( $fields as $field ) {
			$summary_width = $summary_width + ( ! empty( $field['lst_field_width'] ) ? $field['lst_field_width'] : 25 );
		}
		return ( $summary_width > 100 );
	}

	public static function get_terms_names_numeric( $selected_taxonomy ) {
		$values = array();
		$args   = array(
			'taxonomy'               => $selected_taxonomy,
			'orderby'                => 'name',
			'order'                  => 'ASC',
			'hide_empty'             => false,
			'fields'                 => 'names',
			'update_term_meta_cache' => false,
		);

		$terms = get_terms( $args );

		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			$values = array_map( 'intval', $terms );
		}

		return $values;
	}

	public static function stm_ew_listing_filter_get_selects( $fields, $tab_name = '', $show_amount = false ) {
		if ( ! empty( $fields ) ) {
			$output = '';

			$added_slugs = array();

			$summary_width = 0;

			foreach ( $fields as $field ) {

				$summary_width   = $summary_width + ( ! empty( $field['lst_field_width'] ) ? $field['lst_field_width'] : 25 );
				$overflown_class = ( $summary_width > 100 ) ? ' overflown' : '';

				$selected_taxonomy = ( isset( $field['lst_taxonomy'] ) ) ? $field['lst_taxonomy'] : $field['lst_reviews_taxonomy'];

				$is_edit = self::is_elementor_edit_mode();

				if ( in_array( $selected_taxonomy, $added_slugs, true ) || empty( $selected_taxonomy ) && ! $is_edit ) {
					continue;
				}

				$added_slugs[] = $selected_taxonomy;

				$taxonomy_info = stm_get_taxonomies_with_type( $selected_taxonomy );

				$output .= '<div class="stm-select-col elementor-repeater-item-' . esc_html( $field['_id'] ) . $overflown_class . '">';

				$numbers        = array();
				$sel_tax_name   = '';
				$number_string  = '';
				$is_price_field = apply_filters( 'stm_is_listing_price_field', false, $selected_taxonomy );

				if ( $is_price_field || ! empty( $taxonomy_info['numeric'] ) || ! empty( $taxonomy_info['slider_in_tabs'] ) ) {
					$numbers = self::get_terms_names_numeric( $selected_taxonomy );

					if ( ! empty( $numbers ) ) {
						sort( $numbers );
					}
				}

				if ( $is_price_field || ! empty( $taxonomy_info['numeric'] ) ) {
					if ( ! empty( $field['lst_label'] ) ) {
						$sel_tax_name = $field['lst_label'];
					} elseif ( ! empty( $field['lst_reviews_label'] ) ) {
						$sel_tax_name = $field['lst_reviews_label'];
					} else {
						$sel_tax_name = stm_get_name_by_slug( $selected_taxonomy );
					}

					if ( ! empty( $field['lst_placeholder'] ) ) {
						$number_string = $field['lst_placeholder'];
					} elseif ( ! empty( $field['lst_reviews_placeholder'] ) ) {
						$number_string = $field['lst_reviews_placeholder'];
					} else {
						$number_string = esc_html__( 'Max', 'motors-car-dealership-classified-listings-pro' ) . ' ' . $sel_tax_name;
					}
				}

				if ( ! empty( $taxonomy_info['slider_in_tabs'] ) ) {
					ob_start();
					do_action(
						'stm_listings_load_template',
						'filter/types/vc_price',
						array(
							'taxonomy'    => $selected_taxonomy,
							'options'     => $numbers,
							'tab_name'    => $tab_name,
							'label'       => $taxonomy_info['single_name'],
							'slider_step' => ( ! empty( $taxonomy_info['slider_step'] ) ) ? $taxonomy_info['slider_step'] : 10,
						)
					);

					$output .= ob_get_clean();
				} elseif ( $is_price_field ) {
					// Display price field
					$number_string = apply_filters( 'stm_dynamic_string_translation', $number_string, 'Select Text' );

					$output .= '<div class="stm-ajax-isnot-reloadable">';
					$output .= '<select class="stm-filter-ajax-disabled-field" name="max_' . $selected_taxonomy . '" data-class="stm_select_overflowed">';
					$output .= '<option value="">' . $number_string . '</option>';
					if ( ! empty( $numbers ) ) {
						foreach ( $numbers as $price ) {
							$output .= '<option value="' . esc_attr( $price ) . '" ' . selected( apply_filters( 'stm_listings_input', '', $selected_taxonomy ), $price ) . '>' . apply_filters( 'stm_filter_price_view', '', $price ) . '</option>';
						}
					}
					$output .= '</select>';
					$output .= '</div>';
				} else {
					// If numeric.
					if ( ! empty( $taxonomy_info['numeric'] ) ) {
						$select_main = apply_filters( 'stm_dynamic_string_translation', $number_string, 'Option text' );

						if ( ! empty( $numbers ) ) {
							$output .= '<select name="' . $selected_taxonomy . '" data-class="stm_select_overflowed" data-sel-type="' . esc_attr( $selected_taxonomy ) . '">';
							$output .= '<option value="">' . $select_main . '</option>';
							foreach ( $numbers as $number_key => $number_value ) {

								$selected = apply_filters( 'stm_listings_input', '', $selected_taxonomy );
								if ( 0 === $number_key ) {
									$number_value = sprintf( '< %s', esc_attr( $number_value ) );
									$selected     = selected( $selected, $number_value, false );

									$output .= '<option value="' . $number_value . '" ' . $selected . '>' . $number_value . '</option>';
								} elseif ( count( $numbers ) - 1 === $number_key ) {
									$number_value = sprintf( '> %s', esc_attr( $number_value ) );
									$selected     = selected( $selected, sprintf( '> %s', esc_attr( $number_value ) ), false );

									$output .= '<option value="' . $number_value . '" ' . $selected . '>' . $number_value . '</option>';
								} else {
									$option_value = $numbers[ ( $number_key - 1 ) ] . '-' . $number_value;
									$option_name  = $numbers[ ( $number_key - 1 ) ] . '-' . $number_value;

									$output .= '<option value="' . esc_attr( $option_value ) . '" ' . selected( $selected, $option_value, false ) . '> ' . $option_name . '</option>';
								}
							}
							$output .= '<input type="hidden" name="min_' . $selected_taxonomy . '"/>';
							$output .= '<input type="hidden" name="max_' . $selected_taxonomy . '"/>';
							$output .= '</select>';
						}
						// other default values.
					} else {
						if ( 'location' === $selected_taxonomy ) {
							do_action( 'stm_google_places_script', 'enqueue' );

							$output .= '<div class="stm-location-search-unit">';

							$_placeholder = '';

							if ( isset( $field['lst_placeholder'] ) ) {
								$_placeholder = $field['lst_placeholder'];
							} elseif ( $field['lst_reviews_placeholder'] ) {
								$_placeholder = $field['lst_reviews_placeholder'];
							}

							if ( self::is_elementor_edit_mode() ) {
								$output .= '<input type="text" value="' . $_placeholder . '" class="stm_listing_filter_text stm_listing_search_location" id="stm-car-location-' . $tab_name . '"/>';
							} else {
								$output .= '<input type="text" placeholder="' . $_placeholder . '" class="stm_listing_filter_text stm_listing_search_location" id="stm-car-location-' . $tab_name . '" name="ca_location" />';
							}

							$output .= '<input type="hidden" name="stm_lat"/>';
							$output .= '<input type="hidden" name="stm_lng"/>';

							if ( apply_filters( 'motors_vl_get_nuxy_mod', true, 'enable_distance_search' ) ) {
								$radius  = apply_filters( 'motors_vl_get_nuxy_mod', 100, 'distance_search' );
								$radius  = ( ! empty( $radius ) ) ? $radius : 100;
								$output .= '<input type="hidden" name="max_search_radius" value="' . $radius . '"/>';
							}

							$output .= '</div>';
						} else {
							if ( ! empty( $taxonomy_info['listing_taxonomy_parent'] ) ) {
								$terms = array();
							} else {
								$terms = apply_filters( 'stm_get_category_by_slug_all', array(), $selected_taxonomy, false, ( 'yes' === $show_amount ) );
							}

							if ( ! empty( $field['lst_placeholder'] ) ) {
								$select_main = $field['lst_placeholder'];
							} elseif ( ! empty( $field['lst_reviews_placeholder'] ) ) {
								$select_main = $field['lst_reviews_placeholder'];
							} else {
								$select_main = esc_html__( 'Choose', 'motors-car-dealership-classified-listings-pro' ) . ' ' . $sel_tax_name;
							}

							$select_main = apply_filters( 'stm_dynamic_string_translation', $select_main, 'Select Text' );

							$output .= '<div class="stm-ajax-reloadable">';
							$output .= '<select name="' . esc_attr( $selected_taxonomy ) . '" data-class="stm_select_overflowed">';
							$output .= '<option value="">' . $select_main . '</option>';
							if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
								foreach ( $terms as $term ) {

									if ( ! $term || is_array( $term ) && ! empty( $term['invalid_taxonomy'] ) ) {
										continue;
									}

									$selected = apply_filters( 'stm_listings_input', '', $selected_taxonomy );

									if ( 'yes' === $show_amount ) {
										$output .= '<option value="' . esc_attr( $term->slug ) . '" ' . selected( $selected, $term->slug ) . '>' . $term->name . ' (' . $term->count . ') </option>';
									} else {
										$output .= '<option value="' . esc_attr( $term->slug ) . '" ' . selected( $selected, $term->slug ) . '>' . $term->name . ' </option>';
									}
								}
							}
							$output .= '</select>';
							$output .= '</div>';
						}
					}
				}
				$output .= '</div>';
			}

			if ( ! empty( $output ) ) {
				echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}
	}

	public static function is_elementor_edit_mode(): bool {
		return Plugin::$instance->editor->is_edit_mode();
	}

	public static function get_listing_options(): array {
		$filter_options = get_option( 'stm_vehicle_listing_options' );
		$categories     = array();

		$terms_args = array(
			'orderby'    => 'name',
			'order'      => 'ASC',
			'hide_empty' => false,
			'fields'     => 'all',
			'pad_counts' => false,
		);

		if ( ! empty( $filter_options ) ) {
			foreach ( $filter_options as $filter_option ) {
				if ( empty( $filter_option['numeric'] ) ) {

					$terms = get_terms( $filter_option['slug'], $terms_args );

					foreach ( $terms as $term ) {
						$categories[ $term->slug . ' | ' . $filter_option['slug'] ] = $term->name . ' | ' . $filter_option['single_name'];
					}
				}
			}
		}

		return $categories;
	}

	public static function stm_get_pricing_plans(): array {

		$plans = array();

		if ( class_exists( 'WooCommerce' ) && function_exists( 'wc_get_products' ) ) {
			$products = wc_get_products(
				array(
					'status'     => 'published',
					'meta_key'   => '_rp_sub:subscription_product',
					'meta_value' => 'yes',
				)
			);
			foreach ( $products as $product ) {
				$plans[ $product->get_id() ] = $product->get_name();
			}
		}

		$plans['custom_link'] = esc_html__( 'Use Custom Link', 'motors-car-dealership-classified-listings-pro' );

		return $plans;
	}
}
