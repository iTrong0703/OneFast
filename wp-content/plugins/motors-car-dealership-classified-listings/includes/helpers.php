<?php
/**
 * Use for get value by option key
 **/
add_filter( 'motors_vl_get_nuxy_mod', 'motors_vl_get_nuxy_mod', 10, 3 );
function motors_vl_get_nuxy_mod( $default = '', $opt_name = '', $return_default = false ) {
	$options = \MotorsVehiclesListing\Plugin\PluginOptions::getInstance();
	$options = $options::$options_map;

	$value_or_false = ( isset( $options[ $opt_name ] ) ) ? $options[ $opt_name ] : $default;

	if ( has_filter( 'wpcfto_motors_' . $opt_name ) ) {
		return apply_filters( 'wpcfto_motors_' . $opt_name, $value_or_false, $opt_name );
	}

	if ( is_bool( $value_or_false ) || ! empty( $value_or_false ) ) {
		return $value_or_false;
	}

	if ( $return_default ) {
		return $default;
	}

	return false;
}

/**
 * Needed for demo import set content
 */
function mvl_set_wpcfto_mod( $opt_name, $value ) {
	$settings_name = \MotorsVehiclesListing\Plugin\MVL_Const::MVL_PLUGIN_OPT_NAME;
	$options       = get_option( $settings_name, array() );

	if ( ! empty( $options[ $opt_name ] ) ) {
		$options[ $opt_name ] = apply_filters( 'mvl_set_option_' . $opt_name, $value );
	}

	update_option( $settings_name, $options );
}

add_filter( 'mvl_get_nuxy_img_src', 'mvl_get_nuxy_img_src', 10, 3 );
function mvl_get_nuxy_img_src( $default, $opt_name, $size = 'full' ) {
	$image = motors_vl_get_nuxy_mod( $default, $opt_name, true );
	if ( is_numeric( $image ) && $image > 0 ) {
		$image = wp_get_attachment_image_url( $image, $size );

		// always return original full size image for logo.
		if ( 'logo' === $opt_name && is_string( $image ) && preg_match( '/-\d+[Xx]\d+\./', $image ) ) {
			$image = preg_replace( '/-\d+[Xx]\d+\./', '.', $image );
		}
	}

	return $image;
}

if ( ! function_exists( 'stm_add_to_any_shortcode' ) ) {
	function stm_add_to_any_shortcode( $postId ) {
		return do_shortcode( '[addtoany]' );
	}

	add_filter( 'stm_add_to_any_shortcode', 'stm_add_to_any_shortcode' );
}

function mvl_nuxy_sidebars() {
	$sidebars = array(
		'no_sidebar' => esc_html__( 'Without sidebar', 'stm_vehicles_listing' ),
		'default'    => esc_html__( 'Primary sidebar', 'stm_vehicles_listing' ),
	);

	$query = get_posts(
		array(
			'post_type'      => 'sidebar',
			'posts_per_page' => - 1,
		)
	);

	if ( $query ) {
		foreach ( $query as $post ) {
			$sidebars[ $post->ID ] = get_the_title( $post->ID );
		}
	}

	$sidebars = apply_filters( 'mvl_nuxy_sidebars_list', $sidebars );

	return $sidebars;
}

function mvl_nuxy_pages_list() {
	$post_types[] = __( 'Choose page', 'stm_vehicles_listing' );
	$query        = get_posts(
		array(
			'post_type'      => 'page',
			'posts_per_page' => - 1,
		)
	);

	if ( $query ) {
		foreach ( $query as $post ) {
			$post_types[ $post->ID ] = get_the_title( $post->ID );
		}
	}

	return $post_types;
}

function mvl_nuxy_positions() {
	$positions = array(
		'left'  => esc_html__( 'Left', 'stm_vehicles_listing' ),
		'right' => esc_html__( 'Right', 'stm_vehicles_listing' ),
	);

	return apply_filters( 'motors_filter_position', $positions );
}

function mvl_nuxy_sort_options() {
	$options = array();

	if ( function_exists( 'stm_listings_attributes' ) ) {
		$numeric_filters = array_keys(
			stm_listings_attributes(
				array(
					'where'  => array(
						'numeric' => true,
					),
					'key_by' => 'slug',
				)
			)
		);

		if ( ! empty( $numeric_filters ) ) {
			foreach ( $numeric_filters as $tax_name ) {
				$tax = get_taxonomy( $tax_name );
				if ( $tax ) {
					$options[ $tax->name ] = $tax->labels->singular_name;
				}
			}
		}
	}

	return $options;
}

function mvl_nuxy_sortby() {
	$sorts = array(
		'date_high' => esc_html__( 'Date: newest first', 'stm_vehicles_listing' ),
		'date_low'  => esc_html__( 'Date: oldest first', 'stm_vehicles_listing' ),
	);

	return $sorts;
}

add_filter( 'mvl_nuxy_sortby', 'mvl_nuxy_sortby' );

function mvl_print_settings( $settings_name = null ) {
	if ( empty( $settings_name ) ) {
		$settings_name = \MotorsVehiclesListing\Plugin\MVL_Const::MVL_PLUGIN_OPT_NAME;
	}

	echo wp_json_encode( get_option( $settings_name ), true );
	exit;
}

function mvl_modify_key( $key ) {
	return strtolower( str_replace( array( ' ', '/' ), '_', $key ) );
}

add_filter( 'wp_kses_allowed_html', 'mvl_wp_kses_allowed_html' );
function mvl_wp_kses_allowed_html( $allowed_html ) {
	$allowed_atts = array(
		'align'       => array(),
		'class'       => array(),
		'type'        => array(),
		'id'          => array(),
		'dir'         => array(),
		'lang'        => array(),
		'style'       => array(),
		'xml:lang'    => array(),
		'src'         => array(),
		'alt'         => array(),
		'href'        => array(),
		'rel'         => array(),
		'rev'         => array(),
		'target'      => array(),
		'novalidate'  => array(),
		'value'       => array(),
		'name'        => array(),
		'tabindex'    => array(),
		'action'      => array(),
		'method'      => array(),
		'for'         => array(),
		'width'       => array(),
		'height'      => array(),
		'data'        => array(),
		'title'       => array(),
		'placeholder' => array(),
		'selected'    => array(),
	);

	$allowed_html['select']             = $allowed_atts;
	$allowed_html['input']              = $allowed_atts;
	$allowed_html['option']             = $allowed_atts;
	$allowed_html['option']['selected'] = array();

	return $allowed_html;
}

if ( ! function_exists( 'stm_get_sort_options_array' ) ) {
	function stm_get_sort_options_array() {

		$display_multilisting_sorts = false;

		if ( stm_is_multilisting() ) {
			$current_slug = STMMultiListing::stm_get_current_listing_slug();
			if ( ! empty( $current_slug ) ) {
				$display_multilisting_sorts = true;
			}
		}

		if ( $display_multilisting_sorts ) {
			$ml        = new STMMultiListing();
			$sort_args = multilisting_default_sortby( $current_slug );

			$custom_inventory = $ml->stm_get_listing_type_settings( 'inventory_custom_settings', $current_slug );

			if ( false === $custom_inventory ) {
				$enabled_options = array( 'date_high', 'date_low' );
			} else {
				$enabled_options = apply_filters( 'stm_prefix_given_sort_options', $ml->stm_get_listing_type_settings( 'multilisting_sort_options', $current_slug ) );
			}
		} else {
			$sort_args       = apply_filters( 'mvl_nuxy_sortby', array() );
			$sort_options    = apply_filters( 'motors_vl_get_nuxy_mod', array(), 'sort_options' );
			$enabled_options = apply_filters( 'stm_prefix_given_sort_options', $sort_options );
		}

		if ( ! empty( $enabled_options ) ) {
			foreach ( $sort_args as $slug => $label ) {
				if ( ! in_array( $slug, $enabled_options, true ) ) {
					unset( $sort_args[ $slug ] );
				}
			}
		}

		return $sort_args ?? array();
	}

	add_filter( 'stm_get_sort_options_array', 'stm_get_sort_options_array' );
}

if ( ! function_exists( 'stm_get_sort_options_html' ) ) {
	function stm_get_sort_options_html() {

		$html = '';

		$default_sort       = apply_filters( 'stm_get_default_sort_option', 'date_high' );
		$currently_selected = apply_filters( 'stm_listings_input', $default_sort, 'sort_order' );
		$sort_args          = apply_filters( 'stm_get_sort_options_array', array() );

		if ( sort_distance_nearby() ) {
			$sort_args['distance_nearby'] = esc_html__( 'Distance : nearby', 'stm_vehicles_listing' );
			$currently_selected           = 'distance_nearby';
		}

		foreach ( $sort_args as $slug => $label ) {
			$selected = ( $slug === $currently_selected ) ? ' selected' : '';
			$html    .= '<option value="' . $slug . '" ' . $selected . '>' . $label . '</option>';

		}

		return $html;
	}

	add_filter( 'stm_get_sort_options_html', 'stm_get_sort_options_html' );
}

// get compare listings.
if ( ! function_exists( 'stm_get_compared_items' ) ) {
	function stm_get_compared_items( $listing_type = null ) {
		$post_types     = apply_filters( 'stm_listings_multi_type', array( 'listings' ) );
		$compared_items = array();
		$prefix         = apply_filters( 'stm_compare_cookie_name_prefix', '' );

		if ( empty( $listing_type ) ) {
			foreach ( $post_types as $post_type ) {
				if ( ! empty( $_COOKIE[ $prefix . $post_type ] ) && is_array( $_COOKIE[ $prefix . $post_type ] ) ) {
					foreach ( $_COOKIE[ $prefix . $post_type ] as $key => $listing_id ) {
						if ( 'publish' !== get_post_status( $listing_id ) ) {
							do_action( 'stm_remove_compared_item', $listing_id );
						}
					}

					$compared_items = array_merge( $compared_items, $_COOKIE[ $prefix . $post_type ] );
				}
			}
		} elseif ( ! empty( $listing_type ) && in_array( $listing_type, $post_types, true ) ) {
			if ( ! empty( $_COOKIE[ $prefix . $listing_type ] ) && is_array( $_COOKIE[ $prefix . $listing_type ] ) ) {
				foreach ( $_COOKIE[ $prefix . $listing_type ] as $key => $listing_id ) {
					if ( 'publish' !== get_post_status( $listing_id ) ) {
						do_action( 'stm_remove_compared_item', $listing_id );
					}
				}

				$compared_items = $_COOKIE[ $prefix . $listing_type ];
			}
		}

		return array_values( $compared_items );
	}

	function stm_motors_get_compared_items( $compared_items, $listing_type = null ) {
		return stm_get_compared_items( $listing_type );
	}

	add_filter( 'stm_get_compared_items', 'stm_motors_get_compared_items', 10, 2 );
}

// compare cookie name
if ( ! function_exists( 'stm_compare_cookie_name_prefix' ) ) {
	function stm_compare_cookie_name_prefix() {
		return 'stm' . get_current_blog_id() . '_compare_';
	}

	add_filter( 'stm_compare_cookie_name_prefix', 'stm_compare_cookie_name_prefix' );
}

// remove listing from compare list.
if ( ! function_exists( 'stm_remove_compared_item' ) ) {
	function stm_remove_compared_item( $item_id = null ) {
		if ( ! empty( $item_id ) && is_numeric( $item_id ) ) {
			$post_types = apply_filters( 'stm_listings_multi_type', array( 'listings' ) );
			$post_type  = get_post_type( $item_id );

			if ( in_array( $post_type, $post_types, true ) ) {
				$prefix = apply_filters( 'stm_compare_cookie_name_prefix', '' );
				if ( ! empty( $_COOKIE[ $prefix . $post_type ] ) && is_array( $_COOKIE[ $prefix . $post_type ] ) && in_array( strval( $item_id ), $_COOKIE[ $prefix . $post_type ], true ) ) {
					$status = setcookie( $prefix . $post_type . '[' . $item_id . ']', '', time() - 3600, '/' );
					unset( $_COOKIE[ $prefix . $post_type ][ $item_id ] );

					return $status;
				}
			}
		}

		return false;
	}

	add_action( 'stm_remove_compared_item', 'stm_remove_compared_item', 10, 1 );
}

// we've made the listing price field dynamic, this function checks if the given option is the price field.
if ( ! function_exists( 'stm_is_listing_price_field' ) ) {
	add_filter( 'stm_is_listing_price_field', 'stm_is_listing_price_field', 10, 2 );
	function stm_is_listing_price_field( $default, $field = false ) {

		if ( false === $field ) {
			return false;
		}

		// check the default listing type price field.
		if ( 'price' === $field ) {
			return true;
		}

		// check for multilisting fields.
		if ( stm_is_multilisting() ) {
			$opts  = array();
			$slugs = STMMultiListing::stm_get_listing_type_slugs();
			if ( ! empty( $slugs ) ) {
				foreach ( $slugs as $slug ) {
					$type_options = get_option( "stm_{$slug}_options", array() );
					if ( ! empty( $type_options ) ) {
						$opts = array_merge( $opts, $type_options );
					}
				}

				if ( ! empty( $opts ) ) {
					$arr_key = array_search( $field, array_column( $opts, 'slug' ), true );
					if ( false !== $arr_key ) {
						if ( ! empty( $opts[ $arr_key ]['listing_price_field'] ) && 1 === $opts[ $arr_key ]['listing_price_field'] ) {
							return true;
						}
					}
				}
			}
		}

		return false;
	}
}

// check if Motors Theme is active
if ( ! function_exists( 'stm_is_motors_theme' ) ) {
	function stm_is_motors_theme() {
		if ( defined( 'STM_THEME_NAME' ) && 'Motors' === STM_THEME_NAME ) {
			return true;
		}

		return wp_get_theme()->get( 'Name' ) === 'Motors' || wp_get_theme()->get( 'Name' ) === 'Motors Child' || wp_get_theme()->get( 'Name' ) === 'Motors - Child Theme';
	}

	add_filter( 'stm_is_motors_theme', 'stm_is_motors_theme', 1000, 1 );
}

// get gallery image URLs for interactive hoverable gallery
if ( ! function_exists( 'stm_get_hoverable_thumbs' ) ) {
	function stm_get_hoverable_thumbs( $returned_value, $listing_id, $thumb_size = 'thumbnail' ) {
		$ids   = array_unique( (array) get_post_meta( $listing_id, 'gallery', true ) );
		$count = 0;

		// push featured image id
		if ( has_post_thumbnail( $listing_id ) && ! in_array( get_post_thumbnail_id( $listing_id ), $ids, true ) ) {
			array_unshift( $ids, get_post_thumbnail_id( $listing_id ) );
		}

		$returned_value = array(
			'gallery'   => array(),
			'ids'       => array(),
			'remaining' => 0,
		);

		$ids = array_filter( $ids );

		if ( ! empty( $ids ) ) {
			foreach ( $ids as $attachment_id ) {
				// only first five images!
				if ( $count >= 5 ) {
					continue;
				}

				$img = wp_get_attachment_image_url( $attachment_id, $thumb_size );

				if ( ! empty( $img ) ) {
					if ( has_image_size( $thumb_size . '-x-2' ) ) {
						$imgs   = array();
						$imgs[] = $img;
						$imgs[] = wp_get_attachment_image_url( $attachment_id, $thumb_size . '-x-2' );
						$img    = $imgs;
					}

					array_push( $returned_value['gallery'], $img );
					array_push( $returned_value['ids'], $attachment_id );
					$count ++;
				}
			}
		}

		// get remaining count of gallery images
		$remaining                   = count( $ids ) - count( $returned_value['gallery'] );
		$returned_value['remaining'] = ( 0 <= $remaining ) ? $remaining : 0;

		return $returned_value;
	}

	add_filter( 'stm_get_hoverable_thumbs', 'stm_get_hoverable_thumbs', 10, 3 );
}

function motors_vl_body_class( $classes ) {
	global $wp_query;

	if ( apply_filters( 'motors_vl_get_nuxy_mod', '', 'gallery_hover_interaction' ) ) {
		$classes[] = 'stm-hoverable-interactive-galleries';
	}

	if ( ! apply_filters( 'stm_is_motors_theme', false ) ) {
		$classes[] = 'stm-vl-plugin-pure';
	}

	if ( ! is_user_logged_in() ) {
		$classes[] = 'stm-user-not-logged-in';
	}

	return $classes;
}

add_filter( 'body_class', 'motors_vl_body_class' );

if ( ! function_exists( 'stm_check_if_car_imported' ) ) {
	function stm_check_if_car_imported( $id ) {
		$return = false;
		if ( ! empty( $id ) ) {
			$has_id = get_post_meta( $id, 'automanager_id', true );
			if ( ! empty( $has_id ) ) {
				$return = true;
			} else {
				$return = false;
			}
		}

		return $return;
	}
}

if ( ! function_exists( 'stm_display_script_sort' ) ) {
	function stm_display_script_sort( $tax_info ) {
		?>
		case '<?php echo esc_attr( $tax_info['slug'] . '_low' ); ?>':
		<?php
		$slug      = sanitize_title( str_replace( '-', '_', $tax_info['slug'] ) );
		$sort_asc  = 'true';
		$sort_desc = 'false';
		if ( ! empty( $tax_info['numeric'] ) && $tax_info['numeric'] ) {
			$sort_asc  = 'false';
			$sort_desc = 'true';
		}
		?>
		$container.isotope({
		getSortData: {
		<?php echo esc_attr( $slug ); ?>: function( itemElem ) {
		<?php if ( ! empty( $tax_info['numeric'] ) && $tax_info['numeric'] ) : ?>
			var <?php echo esc_attr( $slug ); ?> = $(itemElem).data('<?php echo esc_attr( $tax_info['slug'] ); ?>');
			if(typeof(<?php echo esc_attr( $slug ); ?>) == 'undefined') {
			<?php echo esc_attr( $slug ); ?> = '0';
			}
			return parseFloat(<?php echo esc_attr( $slug ); ?>);
		<?php else : ?>
			var <?php echo esc_attr( $slug ); ?> = $(itemElem).data('<?php echo esc_attr( $tax_info['slug'] ); ?>');
			if(typeof(<?php echo esc_attr( $slug ); ?>) == 'undefined') {
			<?php echo esc_attr( $slug ); ?> = 'n/a';
			}
			return <?php echo esc_attr( $slug ); ?>;
		<?php endif; ?>

		}
		},
		sortBy: '<?php echo esc_attr( $slug ); ?>',
		sortAscending: <?php echo esc_attr( $sort_asc ); ?>
		});
		break
		case '<?php echo esc_attr( $tax_info['slug'] . '_high' ); ?>':
		$container.isotope({
		getSortData: {
		<?php echo esc_attr( $slug ); ?>: function( itemElem ) {
		<?php if ( ! empty( $tax_info['numeric'] ) && $tax_info['numeric'] ) : ?>
			var <?php echo esc_attr( $slug ); ?> = $(itemElem).data('<?php echo esc_attr( $tax_info['slug'] ); ?>');
			if(typeof(<?php echo esc_attr( $slug ); ?>) == 'undefined') {
			<?php echo esc_attr( $slug ); ?> = '0';
			}
			return parseFloat(<?php echo esc_attr( $slug ); ?>);
		<?php else : ?>
			var <?php echo esc_attr( $slug ); ?> = $(itemElem).data('<?php echo esc_attr( $tax_info['slug'] ); ?>');
			if(typeof(<?php echo esc_attr( $slug ); ?>) == 'undefined') {
			<?php echo esc_attr( $slug ); ?> = 'n/a';
			}
			return <?php echo esc_attr( $slug ); ?>;
		<?php endif; ?>

		}
		},
		sortBy: '<?php echo esc_attr( $tax_info['slug'] ); ?>',
		sortAscending: <?php echo esc_attr( $sort_desc ); ?>
		});
		break
		<?php
	}
}

if ( ! function_exists( 'stm_data_binding' ) ) {
	function stm_data_binding( $data = array(), $allowAll = false, $is_add_car = false ) {
		$attributes = apply_filters( 'stm_get_car_parent_exist', array() );
		$bind_tax   = array();
		$depends    = array();
		foreach ( $attributes as $attr ) {

			$parent = $attr['listing_taxonomy_parent'];
			$slug   = $attr['slug'];

			$depends[] = array(
				'parent' => $parent,
				'dep'    => $slug,
			);

			if ( ! isset( $bind_tax[ $parent ] ) ) {
				$bind_tax[ $parent ] = array();
			}

			$bind_tax[ $slug ] = array(
				'dependency' => $parent,
				'allowAll'   => $allowAll,
				'options'    => array(),
			);

			/** @var WP_Term $term */

			$terms = apply_filters( 'stm_get_category_by_slug_all', array(), $slug, $is_add_car, true );

			if ( ! empty( $attr['listing_taxonomy_parent'] ) ) {
				$field = 'name';
				$order = 'ASC';

				if ( ! empty( $attr['terms_filters_sort_by'] ) ) {
					if ( str_contains( $attr['terms_filters_sort_by'], 'count' ) ) {
						$field = 'count';
					}
					if ( str_contains( $attr['terms_filters_sort_by'], 'desc' ) ) {
						$order = 'DESC';
					}
				}

				$terms = wp_list_sort( $terms, $field, $order );
			}

			foreach ( $terms as $term ) {
				$deps = array_values( array_filter( (array) get_term_meta( $term->term_id, 'stm_parent' ) ) );

				$bind_tax[ $slug ]['options'][] = array(
					'value' => $term->slug,
					'label' => $term->name,
					'count' => $term->count,
					'deps'  => $deps,
				);
			}
		}

		$sort_dependencies = array();
		$dependency_count  = count( $depends );
		for ( $q = 0; $q < $dependency_count; $q ++ ) {
			if ( 0 === $q ) {
				$sort_dependencies[] = $depends[ $q ]['parent'];
				$sort_dependencies[] = $depends[ $q ]['dep'];
			} else {
				if ( in_array( $depends[ $q ]['dep'], $sort_dependencies, true ) ) {
					array_splice( $sort_dependencies, array_search( $depends[ $q ]['dep'], $sort_dependencies, true ), 0, $depends[ $q ]['parent'] );
				} elseif ( in_array( $depends[ $q ]['parent'], $sort_dependencies, true ) ) {
					array_splice( $sort_dependencies, array_search( $depends[ $q ]['parent'], $sort_dependencies, true ) + 1, 0, $depends[ $q ]['dep'] );
				} elseif ( ! in_array( $depends[ $q ]['parent'], $sort_dependencies, true ) ) {
					array_splice( $sort_dependencies, 0, 0, $depends[ $q ]['parent'] );
					array_splice( $sort_dependencies, count( $sort_dependencies ), 0, $depends[ $q ]['dep'] );
				}
			}
		}

		$new_tax_bind = array();

		foreach ( $sort_dependencies as $val ) {
			$new_tax_bind[ $val ] = $bind_tax[ $val ];
		}

		return apply_filters( 'stm_data_binding', $new_tax_bind );
	}

	add_filter( 'stm_data_binding_func', 'stm_data_binding', 10, 3 );
}

if ( ! function_exists( 'stm_get_all_listing_attributes' ) ) {
	function stm_get_all_listing_attributes( $default, $filter = 'all' ) {
		$multilisting_attrs = array();
		$attributes         = array();

		// default attributes
		$default_attrs = get_option( 'stm_vehicle_listing_options', array() );

		// get multilisting attributes, if MLT is active
		if ( stm_is_multilisting() && ( 'all' === $filter || 'multilisting' === $filter ) ) {
			$slugs = STMMultiListing::stm_get_listing_type_slugs();
			if ( ! empty( $slugs ) ) {
				foreach ( $slugs as $slug ) {
					$type_options = get_option( "stm_{$slug}_options", array() );
					if ( ! empty( $type_options ) ) {
						$multilisting_attrs = array_merge( $multilisting_attrs, $type_options );
					}
				}
			}
		}

		if ( 'all' === $filter ) {
			$attributes = array_merge( $default_attrs, $multilisting_attrs );
		} elseif ( 'multilisting' === $filter ) {
			$attributes = $multilisting_attrs;
		} else {
			$attributes = $default_attrs;
		}

		return $attributes;
	}

	add_filter( 'stm_get_all_listing_attributes', 'stm_get_all_listing_attributes' );
}

if ( ! function_exists( 'stm_upload_user_file' ) ) {
	function stm_upload_user_file( $default, $file = array() ) {
		require_once ABSPATH . 'wp-admin/includes/admin.php';

		if ( ! function_exists( 'wp_handle_upload' ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}

		$file_return = wp_handle_upload( $file, array( 'test_form' => false ) );

		if ( isset( $file_return['error'] ) || isset( $file_return['upload_error_handler'] ) ) {
			return $default;
		} else {
			$filename   = $file_return['file'];
			$attachment = array(
				'post_mime_type' => $file_return['type'],
				'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
				'post_content'   => '',
				'post_status'    => 'inherit',
				'guid'           => $file_return['url'],
			);

			$attachment_id = wp_insert_attachment( $attachment, $file_return['file'] );
			require_once ABSPATH . 'wp-admin/includes/image.php';
			$attachment_data = wp_generate_attachment_metadata( $attachment_id, $filename );
			wp_update_attachment_metadata( $attachment_id, $attachment_data );
			if ( 0 < intval( $attachment_id ) ) {
				return $attachment_id;
			}
		}

		return $default;
	}

	add_filter( 'stm_upload_user_file', 'stm_upload_user_file', 10, 2 );
}

if ( ! function_exists( 'stm_similar_cars' ) ) {
	function stm_similar_cars( $default, $similar_taxonomies = array() ) {
		$tax_query = array();
		$taxes     = ( count( $similar_taxonomies ) === 0 ) ? apply_filters( 'stm_me_get_nuxy_mod', '', 'stm_similar_query' ) : $similar_taxonomies;
		$query     = array(
			'post_type'      => apply_filters( 'stm_listings_post_type', 'listings' ),
			'post_status'    => 'publish',
			'posts_per_page' => '3',
			'post__not_in'   => array( get_the_ID() ),
		);

		if ( ! empty( $taxes ) ) {
			if ( count( $similar_taxonomies ) === 0 ) {
				$taxes = array_filter( array_map( 'trim', explode( ',', $taxes ) ) );
			}

			$attributes = stm_listings_attributes( array( 'key_by' => 'slug' ) );

			foreach ( $taxes as $tax ) {
				if ( ! isset( $attributes[ $tax ] ) || ! empty( $attributes[ $tax ]['numeric'] ) ) {
					continue;
				}

				$terms = get_the_terms( get_the_ID(), $tax );
				if ( ! is_array( $terms ) ) {
					continue;
				}

				$tax_query[] = array(
					'taxonomy' => esc_attr( $tax ),
					'field'    => 'slug',
					'terms'    => wp_list_pluck( $terms, 'slug' ),
				);
			}
		}

		if ( ! empty( $tax_query ) ) {
			$query['tax_query'] = array( 'relation' => 'OR' ) + $tax_query; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
		}

		return new WP_Query( apply_filters( 'stm_similar_cars_query', $query ) );
	}

	add_filter( 'stm_similar_cars', 'stm_similar_cars', 10, 2 );
}

if ( ! function_exists( 'stm_set_html_content_type_mail' ) ) {
	function stm_set_html_content_type_mail() {
		return 'text/html';
	}
}

if ( ! function_exists( 'motors_listing_filter_get_selects' ) && defined( 'STM_LISTINGS' ) ) {
	function motors_listing_filter_get_selects( $select_strings, $tab_name = '', $words = array(), $show_amount = 'yes' ) {
		if ( ! empty( $select_strings ) ) {
			$select_strings = explode( ',', $select_strings );

			if ( ! empty( $select_strings ) ) {
				$i       = 0;
				$output  = '';
				$output .= '<div class="row">';
				foreach ( $select_strings as $select_string ) {

					if ( empty( $select_string ) ) {
						continue;
					}

					$select_string = trim( $select_string );

					$taxonomy_info = stm_get_taxonomies_with_type( $select_string );

					$output .= '<div class="stm-select-col">';
					if ( ! empty( $taxonomy_info['slider_in_tabs'] ) && $taxonomy_info['slider_in_tabs'] ) {
						$args = array(
							'orderby'    => 'name',
							'order'      => 'ASC',
							'hide_empty' => false,
							'fields'     => 'all',
						);

						$for_range = array();

						$terms = get_terms( $select_string, $args );

						if ( ! empty( $terms ) ) {
							foreach ( $terms as $term ) {
								$for_range[] = intval( $term->name );
							}

							sort( $for_range );
						}

						ob_start();
						do_action(
							'stm_listings_load_template',
							'filter/types/vc_price',
							array(
								'taxonomy'    => $select_string,
								'options'     => $for_range,
								'tab_name'    => 'all',
								'label'       => $taxonomy_info['single_name'],
								'slider_step' => ( ! empty( $taxonomy_info['slider_step'] ) ) ? $taxonomy_info['slider_step'] : 10,
							)
						);

						$output .= ob_get_clean();

						// price.
					} elseif ( 'price' === $select_string ) {
						$args = array(
							'orderby'    => 'name',
							'order'      => 'ASC',
							'hide_empty' => false,
							'fields'     => 'all',
						);

						$prices = array();

						$terms = get_terms( $select_string, $args );

						if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
							foreach ( $terms as $term ) {
								$prices[] = intval( $term->name );
							}

							sort( $prices );
						}

						$number_string = '';

						if ( ! empty( $words['number_prefix'] ) ) {
							$number_string .= $words['number_prefix'] . ' ';
						} else {
							$number_string = esc_html__( 'Max', 'stm_vehicles_listing' ) . ' ';
						}

						$number_string .= apply_filters( 'stm_dynamic_string_translation', stm_get_name_by_slug( $select_string ), 'Select Text' );

						if ( ! empty( $words['number_affix'] ) ) {
							$number_string .= ' ' . $words['number_affix'];
						}

						$output .= '<select class="stm-filter-ajax-disabled-field" name="max_' . $select_string . '" data-class="stm_select_overflowed price">';
						$output .= '<option value="">' . $number_string . '</option>';
						if ( ! empty( $terms ) ) {
							foreach ( $prices as $price ) {
								$selected = '';
								if ( apply_filters( 'stm_is_equipment', false ) ) {
									$selected = ( isset( $_GET[ $select_string ] ) && $_GET[ $select_string ] === $price ) ? 'selected' : '';
								}

								$output .= '<option value="' . esc_attr( $price ) . '" ' . $selected . '>' . apply_filters( 'stm_filter_price_view', '', $price ) . '</option>';
							}
						}
						$output .= '</select>';
					} else {
						// If numeric.
						if ( ! empty( $taxonomy_info['numeric'] ) && $taxonomy_info['numeric'] ) {
							$args    = array(
								'orderby'    => 'name',
								'order'      => 'ASC',
								'hide_empty' => false,
								'fields'     => 'all',
							);
							$numbers = array();

							$terms = get_terms( $select_string, $args );

							$select_main = '';
							if ( ! empty( $words['number_prefix'] ) ) {
								$select_main .= $words['number_prefix'] . ' ';
							} else {
								$select_main .= esc_html__( 'Choose', 'stm_vehicles_listing' ) . ' ';
							}

							$select_main .= apply_filters( 'stm_dynamic_string_translation', stm_get_name_by_slug( $select_string ), 'Option text' );

							if ( ! empty( $words['number_affix'] ) ) {
								$select_main .= ' ' . $words['number_affix'];
							}

							if ( ! empty( $terms ) ) {
								foreach ( $terms as $term ) {
									$numbers[] = intval( $term->name );
								}
							}
							sort( $numbers );

							if ( ! empty( $numbers ) ) {
								$output .= '<select name="' . $select_string . '" data-class="stm_select_overflowed numeric" data-sel-type="' . esc_attr( $select_string ) . '">';
								$output .= '<option value="">' . $select_main . '</option>';
								foreach ( $numbers as $number_key => $number_value ) {

									$selected = '';

									if ( 0 === $number_key ) {
										if ( apply_filters( 'stm_is_equipment', false ) ) {
											$selected = ( isset( $_GET[ $select_string ] ) && sprintf( '< %s', esc_attr( $number_value ) ) === $_GET[ $select_string ] ) ? 'selected' : '';
										}

										$output .= '<option value="' . sprintf( '< %s', esc_attr( $number_value ) ) . '" ' . $selected . '>< ' . $number_value . '</option>';
									} elseif ( count( $numbers ) - 1 === $number_key ) {
										if ( apply_filters( 'stm_is_equipment', false ) ) {
											$selected = ( isset( $_GET[ $select_string ] ) && sprintf( '> %s', esc_attr( $number_value ) ) === $_GET[ $select_string ] ) ? 'selected' : '';
										}

										$output .= '<option value="' . sprintf( '> %s', esc_attr( $number_value ) ) . '" ' . $selected . '>> ' . $number_value . '</option>';
									} else {
										$option_value = $numbers[ ( $number_key - 1 ) ] . '-' . $number_value;
										$option_name  = $numbers[ ( $number_key - 1 ) ] . '-' . $number_value;

										if ( apply_filters( 'stm_is_equipment', false ) ) {
											$selected = ( isset( $_GET[ $select_string ] ) && $_GET[ $select_string ] === $option_value ) ? 'selected' : '';
										}

										$output .= '<option value="' . esc_attr( $option_value ) . '" ' . $selected . '> ' . $option_name . '</option>';
									}
								}
								$output .= '<input type="hidden" name="min_' . $select_string . '"/>';
								$output .= '<input type="hidden" name="max_' . $select_string . '"/>';
								$output .= '</select>';
							}
							// other default values.
						} else {
							if ( ! empty( $taxonomy_info['listing_taxonomy_parent'] ) ) {
								$terms = array();
							} else {
								$terms = apply_filters( 'stm_get_category_by_slug_all', array(), $select_string, false );
							}

							$select_main = '';
							if ( ! empty( $words['select_prefix'] ) ) {
								$select_main .= $words['select_prefix'] . ' ';
							} else {
								$select_main .= esc_html__( 'Choose', 'stm_vehicles_listing' ) . ' ';
							}

							$select_main .= apply_filters( 'stm_dynamic_string_translation', stm_get_name_by_slug( $select_string ), 'Option select text' );

							if ( ! empty( $words['select_affix'] ) ) {
								$select_main .= ' ' . $words['select_affix'];
							}

							$output .= '<div class="stm-ajax-reloadable">';
							$output .= '<select name="' . esc_attr( $select_string ) . '" data-class="stm_select_overflowed other">';
							$output .= '<option value="">' . $select_main . '</option>';
							if ( ! empty( $terms ) ) {
								foreach ( $terms as $term ) {

									if ( ! $term || is_array( $term ) && ! empty( $term['invalid_taxonomy'] ) ) {
										continue;
									}

									$selected = '';
									if ( apply_filters( 'stm_is_equipment', false ) ) {
										$selected = ( isset( $_GET[ $select_string ] ) && $_GET[ $select_string ] === $term->slug ) ? 'selected' : '';
									}

									if ( 'yes' === $show_amount ) {
										$output .= '<option value="' . esc_attr( $term->slug ) . '" ' . $selected . '>' . $term->name . ' (' . $term->count . ') </option>';
									} else {
										$output .= '<option value="' . esc_attr( $term->slug ) . '" ' . $selected . '>' . $term->name . ' </option>';
									}
								}
							}
							$output .= '</select>';
							$output .= '</div>';
						}
					}
					$output .= '</div>';
					$i ++;
				}

				$output .= '</div>'; // row.

				if ( ! empty( $output ) ) {
					echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
			}
		}
	}

	add_filter( 'motors_listing_filter_get_selects', 'motors_listing_filter_get_selects', 10, 6 );
}

if ( ! function_exists( 'stm_get_car_medias' ) ) {
	function stm_get_car_medias( $default, $post_id = '' ) {
		if ( ! empty( $post_id ) ) {

			$image_limit = '';

			if ( apply_filters( 'stm_pricing_enabled', false ) ) {
				$user_added = get_post_meta( $post_id, 'stm_car_user', true );
				if ( ! empty( $user_added ) ) {
					$limits      = apply_filters(
						'stm_get_post_limits',
						array(
							'premoderation' => true,
							'posts_allowed' => 0,
							'posts'         => 0,
							'images'        => 0,
							'role'          => 'user',
						),
						$user_added
					);
					$image_limit = $limits['images'];
				}
			}
			$car_media = array();

			// Photo.
			$car_photos         = array();
			$car_gallery        = get_post_meta( $post_id, 'gallery', true );
			$car_videos_posters = get_post_meta( $post_id, 'gallery_videos_posters', true );

			if ( has_post_thumbnail( $post_id ) ) {
				$car_photos[] = wp_get_attachment_url( get_post_thumbnail_id( $post_id ) );
			}

			if ( ! empty( $car_gallery ) ) {
				$i = 0;
				foreach ( $car_gallery as $car_gallery_image ) {
					if ( empty( $image_limit ) ) {
						if ( wp_get_attachment_url( $car_gallery_image ) ) {
							$car_photos[] = wp_get_attachment_url( $car_gallery_image );
						}
					} else {
						$i ++;
						if ( $i < $image_limit ) {
							if ( wp_get_attachment_url( $car_gallery_image ) ) {
								$car_photos[] = wp_get_attachment_url( $car_gallery_image );
							}
						}
					}
				}
			}

			$car_photos = array_unique( $car_photos );

			$car_media['car_photos']       = $car_photos;
			$car_media['car_photos_count'] = count( $car_photos );

			// Video.
			$car_video      = array();
			$car_video_main = get_post_meta( $post_id, 'gallery_video', true );
			$car_videos     = get_post_meta( $post_id, 'gallery_videos', true );

			if ( ! empty( $car_video_main ) ) {
				$car_video[] = $car_video_main;
			}

			if ( ! empty( $car_videos ) ) {
				foreach ( $car_videos as $car_video_single ) {
					if ( ! empty( $car_video_single ) ) {
						$car_video[] = $car_video_single;
					}
				}
			}

			$car_media['car_videos']         = $car_video;
			$car_media['car_videos_posters'] = $car_videos_posters;
			$car_media['car_videos_count']   = count( $car_video );

			return $car_media;
		}
	}

	add_filter( 'stm_get_car_medias', 'stm_get_car_medias', 10, 2 );
}

if ( ! function_exists( 'motors_vl_dealer_logo_placeholder' ) ) {
	function motors_vl_dealer_logo_placeholder() {
		return STM_LISTINGS_URL . '/assets/images/empty_dealer_logo.png';
	}

	add_filter( 'motors_vl_dealer_logo_placeholder', 'motors_vl_dealer_logo_placeholder' );
}

if ( ! function_exists( 'stm_account_current_page' ) ) {
	function stm_account_current_page() {
		$page = 'inventory';

		if ( isset( $_GET['page'] ) ) {
			$page = sanitize_text_field( $_GET['page'] );
		}

		if ( ! empty( $_GET['my_favourites'] ) ) {
			$page = 'favourite';
		}

		if ( ! empty( $_GET['my_settings'] ) ) {
			$page = 'settings';
		}

		if ( ! empty( $_GET['become_dealer'] ) ) {
			$page = 'become-dealer';
		}

		return $page;
	}

	add_filter( 'stm_account_current_page', 'stm_account_current_page' );
}

//this function is used to check if the value is empty except zero
add_filter( 'is_empty_value', 'is_empty_value' );
function is_empty_value( $value ) {
	$value = floatval( $value );
	if ( 0 === $value ) {
		return false;
	}
}

// Disable the regeneration of fonts
add_filter(
	'wpcfto_enable_regenerate_fonts',
	function () {
		return false;
	},
	99
);
