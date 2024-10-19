<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/*Add taxonomies from listing categories*/
add_action( 'init', 'create_stm_listing_category', 0 );

function create_stm_listing_category() {
	$options = get_option( 'stm_vehicle_listing_options' );
	if ( ! empty( $options ) ) {
		foreach ( $options as $option ) {

			$show_admin_table = false;
			if ( ! empty( $option['show_in_admin_column'] ) && $option['show_in_admin_column'] ) {
				$show_admin_table = true;
			}

			if ( empty( $option['numeric'] ) ) {
				$numeric = true;
			} else {
				$numeric          = false;
				$show_admin_table = false;
			}

			register_taxonomy(
				$option['slug'],
				'listings',
				array(
					'labels'             => array(
						'name'                       => $option['plural_name'],
						'singular_name'              => $option['single_name'],
						'search_items'               => esc_html( sprintf( __( 'Search %s', 'stm_vehicles_listing' ), $option['single_name'] ) ),
						'popular_items'              => esc_html( sprintf( __( 'Popular %s', 'stm_vehicles_listing' ), $option['single_name'] ) ),
						'all_items'                  => esc_html( sprintf( __( 'All %s', 'stm_vehicles_listing' ), $option['single_name'] ) ),
						'parent_item'                => null,
						'parent_item_colon'          => null,
						'edit_item'                  => esc_html( sprintf( __( 'Edit %s', 'stm_vehicles_listing' ), $option['single_name'] ) ),
						'update_item'                => esc_html( sprintf( __( 'Update %s', 'stm_vehicles_listing' ), $option['single_name'] ) ),
						'add_new_item'               => esc_html( sprintf( __( 'Add New %s', 'stm_vehicles_listing' ), $option['single_name'] ) ),
						'new_item_name'              => esc_html( sprintf( __( 'New %s Name', 'stm_vehicles_listing' ), $option['single_name'] ) ),
						'separate_items_with_commas' => esc_html( sprintf( __( 'Separate %s with commas', 'stm_vehicles_listing' ), $option['single_name'] ) ),
						'add_or_remove_items'        => esc_html( sprintf( __( 'Add or remove %s', 'stm_vehicles_listing' ), $option['single_name'] ) ),
						'choose_from_most_used'      => esc_html( sprintf( __( 'Choose from the most used %s', 'stm_vehicles_listing' ), $option['single_name'] ) ),
						'not_found'                  => esc_html( sprintf( __( 'No %s found.', 'stm_vehicles_listing' ), $option['single_name'] ) ),
						'menu_name'                  => esc_html( $option['plural_name'] ),
					),
					'public'             => true,
					'hierarchical'       => $numeric,
					'show_ui'            => true,
					'show_in_menu'       => false,
					'show_admin_column'  => $show_admin_table,
					'show_in_nav_menus'  => false,
					'show_in_quick_edit' => false,
					'query_var'          => false,
					'rewrite'            => false,
				)
			);
		};
	}

	/*Register additional features hidden taxonomy*/
	$post_types = array( apply_filters( 'stm_listings_post_type', 'listings' ) );

	if ( stm_is_multilisting() ) {
		$slugs = STMMultiListing::stm_get_listing_type_slugs();
		if ( ! empty( $slugs ) ) {
			$post_types = array_merge( $post_types, $slugs );
		}
	}

	register_taxonomy(
		'stm_additional_features',
		$post_types,
		array(
			'labels'             => array(
				'name'                       => esc_html__( 'Additional features', 'stm_vehicles_listing' ),
				'singular_name'              => esc_html__( 'Additional features', 'stm_vehicles_listing' ),
				'search_items'               => esc_html__( 'Search Additional features', 'stm_vehicles_listing' ),
				'popular_items'              => esc_html__( 'Popular Additional features', 'stm_vehicles_listing' ),
				'all_items'                  => esc_html__( 'All  Additional features', 'stm_vehicles_listing' ),
				'parent_item'                => null,
				'parent_item_colon'          => null,
				'edit_item'                  => esc_html__( 'Edit Additional features', 'stm_vehicles_listing' ),
				'update_item'                => esc_html__( 'Update Additional features', 'stm_vehicles_listing' ),
				'add_new_item'               => esc_html__( 'Add New Additional features', 'stm_vehicles_listing' ),
				'new_item_name'              => esc_html__( 'New Additional features name', 'stm_vehicles_listing' ),
				'separate_items_with_commas' => esc_html__( 'Separate Additional features', 'stm_vehicles_listing' ),
				'add_or_remove_items'        => esc_html__( 'Add or remove Additional features', 'stm_vehicles_listing' ),
				'choose_from_most_used'      => esc_html__( 'Choose from the most used  Additional features', 'stm_vehicles_listing' ),
				'not_found'                  => esc_html__( 'No Additional features found', 'stm_vehicles_listing' ),
				'menu_name'                  => esc_html__( 'Additional features', 'stm_vehicles_listing' ),
			),
			'public'             => true,
			'hierarchical'       => false,
			'show_ui'            => true,
			'show_in_menu'       => false,
			'show_admin_column'  => false,
			'show_in_nav_menus'  => false,
			'show_in_quick_edit' => false,
			'query_var'          => false,
			'rewrite'            => false,
		)
	);
}

function stm_get_cat_icons( $font_pack = 'fa', $icon_picker = false ) {
	$_fonts_path = STM_LISTINGS_PATH . '/assets/';
	$fonts       = array();

	if ( 'fa' === $font_pack && ! $icon_picker ) {
		$_icons = wp_json_file_decode( $_fonts_path . 'font-awesome.json', array( 'associative' => true ) );

		if ( ! empty( $_icons ) ) {
			foreach ( $_icons as $key => $val ) {
				$fonts[] = array(
					'main_class' => 'fa' . $val['styles'][0][0],
					'icon_class' => $key,
				);
			}
		}
	} elseif ( 'external' === $font_pack ) {
		$fonts_pack = get_option( 'stm_fonts' );
		if ( ! empty( $fonts_pack ) ) {
			foreach ( $fonts_pack as $font => $info ) {

				if ( empty( $info['config'] ) || empty( $info['json'] ) ) {
					continue;
				}

				$icon_set   = array();
				$icons      = array();
				$upload_dir = wp_upload_dir();
				$path       = trailingslashit( $upload_dir['basedir'] );
				$config     = $path . $info['include'] . '/' . $info['config'];
				$json       = $path . $info['include'] . '/' . $info['json'];

				if ( file_exists( $config ) && file_exists( $json ) ) {
					include $config;

					$selection = json_decode( file_get_contents( $json ), true ); //phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents

					if ( ! empty( $selection ) ) {
						if ( ! empty( $selection['preferences'] ) && ! empty( $selection['preferences']['fontPref'] ) && ! empty( $selection['preferences']['fontPref']['prefix'] ) ) {
							$prefix = $selection['preferences']['fontPref']['prefix'];

							if ( ! empty( $icons ) ) {
								$icon_set = array_merge( $icon_set, $icons );
							}

							if ( ! empty( $icon_set ) ) {
								foreach ( $icon_set as $icons ) {
									foreach ( $icons as $icon ) {
										if ( $icon_picker ) {
											$fonts[] = array(
												'title' => $prefix . '-' . $icon['class'],
												'searchTerms' => array( $icon['class'] ),
											);
										} else {
											$fonts[] = $prefix . $icon['class'];
										}
									}
								}
							}
						}
					}
				}
			}
		}
	} elseif ( 'motors-icons' === $font_pack ) {
		$_icons = wp_json_file_decode( $_fonts_path . $font_pack . '.json', array( 'associative' => true ) );

		if ( ! empty( $_icons ) ) {
			foreach ( $_icons['icons'] as $icon ) {
				$attrs = array_filter( $icon['attrs'] );

				// Exclude icons with two or more colors
				if ( ! empty( $attrs ) ) {
					continue;
				}

				if ( $icon_picker ) {
					$fonts[] = array(
						'title'       => $font_pack . '-' . $icon['properties']['name'],
						'searchTerms' => array( $icon['properties']['name'] ),
					);
				} else {
					$fonts[] = $font_pack . '-' . $icon['properties']['name'];
				}
			}
		}
	}

	return $fonts;
}

function stm_get_car_listings() {
	return stm_listings_attributes( array( 'where' => array( 'use_on_car_listing_page' => true ) ) );
}
add_filter( 'stm_get_car_listings', 'stm_get_car_listings' );

function stm_get_car_archive_listings() {
	return stm_listings_attributes( array( 'where' => array( 'use_on_car_archive_listing_page' => true ) ) );
}
add_filter( 'stm_get_car_archive_listings', 'stm_get_car_archive_listings' );

function stm_get_single_car_listings() {
	return stm_listings_attributes( array( 'where' => array( 'use_on_single_car_page' => true ) ) );
}
add_filter( 'stm_get_single_car_listings', 'stm_get_single_car_listings' );

function stm_get_map_listings() {
	return stm_listings_attributes( array( 'where' => array( 'use_on_map_page' => true ) ) );
}
add_filter( 'stm_get_map_listings', 'stm_get_map_listings' );

function stm_get_car_filter() {
	return stm_listings_attributes( array( 'where' => array( 'use_on_car_filter' => true ) ) );
}
add_filter( 'stm_get_car_filter', 'stm_get_car_filter' );

function stm_get_car_modern_filter() {
	return stm_listings_attributes( array( 'where' => array( 'use_on_car_modern_filter' => true ) ) );
}
add_filter( 'stm_get_car_modern_filter', 'stm_get_car_modern_filter' );

function stm_get_car_modern_filter_view_images() {
	return stm_listings_attributes( array( 'where' => array( 'use_on_car_modern_filter_view_images' => true ) ) );
}
add_filter( 'stm_get_car_modern_filter_view_images', 'stm_get_car_modern_filter_view_images' );

function stm_get_car_parent_exist() {
	$car_listing      = array();
	$listings_options = get_option( 'stm_vehicle_listing_options' );

	// add each custom listing type options (categories), if multilisting is active and listing types have categories
	// add filter is in Motors Listing Types plugin
	$options = apply_filters( 'stm_include_multilisting_options', $listings_options );

	if ( ! empty( $options ) ) {
		foreach ( $options as $key => $option ) {
			if ( ! empty( $options[ $key ]['listing_taxonomy_parent'] ) ) {
				$car_listing[] = $option;
			}
		}
	}

	return $car_listing;
}

add_filter( 'stm_get_car_parent_exist', 'stm_get_car_parent_exist' );

function stm_get_car_filter_links() {
	return stm_listings_attributes( array( 'where' => array( 'use_on_car_filter_links' => true ) ) );
}

function stm_get_footer_taxonomies() {
	return stm_listings_attributes( array( 'where' => array( 'use_in_footer_search' => true ) ) );
}
add_filter( 'stm_get_footer_taxonomies', 'stm_get_footer_taxonomies' );

function stm_get_car_filter_checkboxes( $post_type = '' ) {
	$car_listing = array();
	$options     = get_option( 'stm_vehicle_listing_options' );

	// if multilisting
	if ( ! empty( $post_type ) ) {
		$options = get_option( "stm_{$post_type}_options" );
	}

	if ( ! empty( $options ) ) {
		foreach ( $options as $key => $option ) {
			if ( ! empty( $options[ $key ]['listing_rows_numbers'] ) ) {
				$car_listing[] = $option;
			}
		}
	}

	return $car_listing;
}

function get_value_from_listing_category( $default, $cat_name, $opt_name ) {
	$cats_conf = apply_filters( 'stm_get_car_filter', array() );

	foreach ( $cats_conf as $k => $v ) {
		if ( $v['slug'] === $cat_name ) {
			return $v[ $opt_name ];
		}
	}
}

add_filter( 'get_value_from_listing_category', 'get_value_from_listing_category', 10, 3 );

function stm_get_filter_title() {
	return stm_listings_attributes( array( 'where' => array( 'use_on_directory_filter_title' => true ) ) );
}

function stm_get_taxonomies() {
	//Get all filter options from STM listing plugin - Listing - listing categories
	$filter_options = get_option( 'stm_vehicle_listing_options' );

	$taxonomies = array();

	if ( ! empty( $filter_options ) ) {
		$i = 0;
		foreach ( $filter_options as $filter_option ) {
			$taxonomies[ $filter_option['single_name'] ] = $filter_option['slug'];
		}
	}

	return $taxonomies;
}
add_filter( 'stm_get_taxonomies', 'stm_get_taxonomies' );

function stm_get_taxonomies_with_type( $taxonomy_slug ) {
	if ( ! empty( $taxonomy_slug ) ) {
		//Get all filter options from STM listing plugin - Listing - listing categories
		$filter_options = get_option( 'stm_vehicle_listing_options' );

		$taxonomies = array();

		if ( ! empty( $filter_options ) ) {
			foreach ( $filter_options as $filter_option ) {
				if ( $filter_option['slug'] === $taxonomy_slug ) {
					$taxonomies = $filter_option;
				}
			}
		}

		return $taxonomies;
	}

}

function stm_get_taxonomies_as_div() {
	//Get all filter options from STM listing plugin - Listing - listing categories
	$filter_options = get_option( 'stm_vehicle_listing_options' );

	$taxonomies = array();

	if ( ! empty( $filter_options ) ) {
		foreach ( $filter_options as $filter_option ) {
			if ( ! $filter_option['numeric'] ) {
				$taxonomies[ $filter_option['single_name'] ] = $filter_option['slug'] . 'div';
			} else {
				$taxonomies[ $filter_option['single_name'] ] = 'tagsdiv-' . $filter_option['slug'];
			}
		}
	}

	return $taxonomies;

}

function stm_get_categories( $include_label = false ) {
	// Get all filter options from STM listing plugin - Listing - listing categories
	$filter_options = get_option( 'stm_vehicle_listing_options' );
	//Creating new array for tax query && meta query
	$categories = array();

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
					if ( $include_label ) {
						$categories[ $term->slug ] = $term->slug . ' | ' . $filter_option['slug'] . ' | ' . $term->name;
					} else {
						$categories[ $term->slug ] = $term->slug . ' | ' . $filter_option['slug'];
					}
				}
			}
		}
	}

	return $categories;
}

function stm_get_name_by_slug( $slug = '', $listing_type = '' ) {
	//Get all filter options from STM listing plugin - Listing - listing categories
	$filter_options = get_option( 'stm_vehicle_listing_options' );
	if ( class_exists( 'STMMultiListing' ) && $listing_type && ! in_array( $listing_type, array( 'listings', 'cars' ) ) ) {
		$filter_options = get_option( 'stm_' . $listing_type . '_options' );
	}

	$name = '';
	if ( ! empty( $filter_options ) && ! empty( $slug ) ) {
		foreach ( $filter_options as $filter_option ) {
			if ( $filter_option['slug'] === $slug && ! empty( $filter_option['single_name'] ) ) {
				$name = stm_listings_dynamic_string_translation( 'Option - ' . $filter_option['single_name'], $filter_option['single_name'] );
			}
		}
	}

	return $name;
}

/***
 * @depreacted since 7.0.9
 * function 'stm_get_all_by_slug' and filter 'stm_get_all_by_slug' is deprecated
 * use filter 'stm_vl_get_all_by_slug' instead
 **/
function stm_get_all_by_slug( $slug = '' ) {
	return stm_listings_attribute( $slug );
}

function stm_vl_get_all_by_slug( $atts, $slug = '' ) {
	return stm_listings_attribute( $slug );
}
add_filter( 'stm_get_all_by_slug', 'stm_vl_get_all_by_slug', 10, 2 );
add_filter( 'stm_vl_get_all_by_slug', 'stm_vl_get_all_by_slug', 10, 2 );

function stm_get_custom_taxonomy_count( $total, $slug, $taxonomy = '' ) {
	$total      = 0;
	$post_types = array( apply_filters( 'stm_listings_post_type', 'listings' ) );

	if ( stm_is_multilisting() ) {
		$ml         = new STMMultiListing();
		$post_types = array_merge( $post_types, $ml->stm_get_listing_type_slugs() );
	}

	$args = array(
		'post_type'        => $post_types,
		'post_status'      => 'publish',
		'posts_per_page'   => -1,
		'suppress_filters' => 0,
		'tax_query'        => array(
			array(
				'taxonomy' => $taxonomy,
				'terms'    => $slug,
				'field'    => 'slug',
			),
		),
		'meta_query'       => array(
			array(
				'key'     => 'car_mark_as_sold',
				'value'   => '',
				'compare' => '=',
			),
		),
	);

	$count_posts = new WP_Query( $args );

	if ( ! is_wp_error( $count_posts ) ) {
		$total = $count_posts->found_posts;
	}

	if ( empty( $slug ) && empty( $taxonomy ) ) {
		$total = 0;
		foreach ( $post_types as $post_type ) {
			$counts = wp_count_posts( $post_type );
			if ( isset( $counts->publish ) ) {
				$total = $counts->publish;
			}
		}
	}

	return $total;
}
add_filter( 'stm_get_custom_taxonomy_count', 'stm_get_custom_taxonomy_count', 10, 3 );

function stm_get_category_by_slug( $slug ) {
	$result = null;

	if ( ! empty( $slug ) ) {
		$terms_args = array(
			'orderby'    => 'name',
			'order'      => 'ASC',
			'hide_empty' => true,
			'fields'     => 'all',
			'pad_counts' => true,
		);

		$terms = get_terms( $slug, $terms_args );

		if ( ! is_wp_error( $terms ) ) {
			$result = $terms;
		}
	}

	return apply_filters( 'stm_get_category_by_slug', $result, $slug );
}

function stm_get_category_by_slug_all( $result, $slug = false, $is_add_car = false, $show_count = false ) {
	$result = null;

	if ( ! empty( $slug ) ) {
		$terms_args = array(
			'orderby'    => 'name',
			'order'      => 'ASC',
			'hide_empty' => ( ! $is_add_car ) ? true : false,
			'fields'     => 'all',
			'pad_counts' => apply_filters( 'stm_get_term_pad_counts', true ),
		);

		$terms = get_terms( $slug, $terms_args );

		if ( ! is_wp_error( $terms ) ) {
			$result = apply_filters( 'motors_get_category_by_slug_all', $terms, $slug, $is_add_car, $show_count );
		}
	}

	return $result;
}

add_filter( 'stm_get_category_by_slug_all', 'stm_get_category_by_slug_all', 10, 4 );

function stm_remove_meta_boxes() {
	$taxonomies_style = stm_get_taxonomies_as_div();

	if ( ! empty( $taxonomies_style ) ) {
		foreach ( $taxonomies_style as $taxonomy_style ) {
			remove_meta_box( $taxonomy_style, 'listings', 'side' );
		}
	}

}

add_action( 'admin_init', 'stm_remove_meta_boxes' );

function stm_listings_get_my_options_list() {
	return get_option( 'stm_vehicle_listing_options', array() );
}

function stm_listings_parent_choice() {
	$select_options = array(
		'' => esc_html__( 'No parent', 'stm_vehicles_listing' ),
	);

	$options = stm_listings_get_my_options_list();
	foreach ( $options as $key => $option ) {
		$slug                    = $option['slug'];
		$select_options[ $slug ] = $option['single_name'];
	}

	return $select_options;
}

function stm_listings_reserved_terms() {
	$reserved_terms = array(
		'attachment',
		'attachment_id',
		'author',
		'author_name',
		'calendar',
		'cat',
		'category',
		'category__and',
		'category__in',
		'category__not_in',
		'category_name',
		'comments_per_page',
		'comments_popup',
		'cpage',
		'day',
		'debug',
		'error',
		'exact',
		'feed',
		'hour',
		'link_category',
		'm',
		'minute',
		'monthnum',
		'more',
		'name',
		'nav_menu',
		'nopaging',
		'offset',
		'order',
		'orderby',
		'p',
		'page',
		'page_id',
		'paged',
		'pagename',
		'pb',
		'perm',
		'post',
		'post__in',
		'post__not_in',
		'post_format',
		'post_mime_type',
		'post_status',
		'post_tag',
		'post_type',
		'posts',
		'posts_per_archive_page',
		'posts_per_page',
		'preview',
		'robots',
		's',
		'search',
		'second',
		'sentence',
		'showposts',
		'static',
		'subpost',
		'subpost_id',
		'tag',
		'tag__and',
		'tag__in',
		'tag__not_in',
		'tag_id',
		'tag_slug__and',
		'tag_slug__in',
		'taxonomy',
		'tb',
		'term',
		'type',
		'w',
		'withcomments',
		'withoutcomments',
		'year',
	);

	return apply_filters( 'stm_listings_reserved_terms_filter', $reserved_terms );
}

function stm_vehicles_listing_get_icons_html() {
	$fa_icons         = stm_get_cat_icons( 'fa' );
	$custom_icons     = stm_get_cat_icons( 'external' );
	$motors_icons_set = stm_get_cat_icons( 'motors-icons' );

	if ( ! empty( $default_icons_set ) ) {
		$custom_icons = array_merge( $custom_icons, $default_icons_set );
	}

	if ( ! empty( $motors_icons_set ) ) {
		$custom_icons = array_merge( $custom_icons, $motors_icons_set );
	}
	?>

	<div class="stm_vehicles_listing_icons">
		<div class="overlay"></div>
		<div class="inner">
			<!--Nav-->
			<div class="stm_font_nav">
				<div>
					<a href="#stm_font-awesome" class="active"><?php esc_html_e( 'Font Awesome', 'stm_vehicles_listing' ); ?></a>
				</div>
				<div>
					<a href="#stm_font-motors"><?php esc_html_e( 'Motors Pack', 'stm_vehicles_listing' ); ?></a>
				</div>
			</div>
			<div class="scrollable-content">
				<!--Content-->
				<div id="stm_font-awesome" class="stm_theme_font active">
					<table class="form-table">
						<tr>
							<?php
							$counter = 0;
							foreach ( $fa_icons as $fa_icon ) :
								$counter++;
								?>
							<td class="stm-listings-pick-icon">
								<i class="<?php echo esc_attr( $fa_icon['main_class'] ); ?> fa-<?php echo esc_attr( $fa_icon['icon_class'] ); ?>"></i>
								<i class="<?php echo esc_attr( $fa_icon['main_class'] ); ?> fa-<?php echo esc_attr( $fa_icon['icon_class'] ); ?> big_icon"></i>
							</td>
								<?php if ( 0 === $counter % 15 ) : ?>
						</tr>
						<tr>
							<?php endif; ?>
							<?php endforeach; ?>
						</tr>
					</table>
				</div>

				<div id="stm_font-motors" class="stm_theme_font">
					<table class="form-table">
						<tr>
							<?php
							$counter = 0;
							foreach ( $custom_icons as $custom_icon ) :
								$counter++;
								?>
								<td class="stm-listings-pick-icon stm-listings-<?php echo esc_attr( $custom_icon ); ?>">
									<i class="<?php echo esc_attr( $custom_icon ); ?>"></i>
									<i class="<?php echo esc_attr( $custom_icon ); ?> big_icon"></i>
								</td>
									<?php
									if ( 0 === $counter % 15 ) :
										$counter = 0;
										?>
										</tr>
										<tr>
									<?php endif; ?>
							<?php endforeach; ?>
						</tr>
					</table>
				</div>
			</div>
			<div class="stm_how_to_add">
				<a href="https://stylemixthemes.com/manuals/consulting/#custom_icons" target="_blank">
					<?php esc_html_e( 'How to add new icon pack', 'stm_vehicles_listing' ); ?><i
						class="fas fa-external-link-alt"></i>
				</a>
			</div>
		</div>
	</div>
	<?php
}

/*Update option*/
function stm_vehicle_listings_save_options( $options ) {
	$settings = stm_listings_page_options();

	foreach ( $options as $key => $option ) {
		foreach ( $option as $name => $item ) {
			if ( ! empty( $settings[ $name ] ) && 'checkbox' === $settings[ $name ]['type'] && ! empty( $item ) && $item ) {
				$options[ $key ][ $name ] = 1;
			}
		}
	}

	if ( current_user_can( 'administrator' ) || current_user_can( 'editor' ) ) {
		return update_option( 'stm_vehicle_listing_options', $options );
	}

	return false;
}

/*Ajax saving single option*/
function stm_listings_save_single_option_row() {
	check_ajax_referer( 'stm_listings_save_single_option_row', 'security' );

	$data = array(
		'error'   => false,
		'message' => '',
	);

	$options = stm_listings_get_my_options_list();

	/*Check number of setting*/
	if ( ! isset( $_POST['stm_vehicle_listing_row_position'] ) ) {
		$data['error']   = true;
		$data['message'] = esc_html__( 'Some error occurred', 'stm_vehicles_listing' );
	} else {
		$option_key = intval( $_POST['stm_vehicle_listing_row_position'] );
	}

	/*Check if setting exists*/
	if ( empty( $options[ $option_key ] ) ) {
		$data['error']   = true;
		$data['message'] = esc_html__( 'Some error occurred', 'stm_vehicles_listing' );
	} else {
		$current_option = $options[ $option_key ];
	}

	/*Check POST*/
	if ( empty( $_POST ) ) {
		$data['error']   = true;
		$data['message'] = esc_html__( 'Some error occurred', 'stm_vehicles_listing' );
	} else {
		$user_choice = $_POST;
	}

	if ( ! $data['error'] ) {

		$settings = stm_listings_page_options();

		foreach ( $settings as $setting_name => $setting ) {
			if ( strpos( $setting_name, 'divider' ) === false ) {
				if ( ! empty( $user_choice[ $setting_name ] ) ) {
					$current_option[ $setting_name ] = ( 'number_field_affix' === $setting_name ) ? esc_html( $user_choice[ $setting_name ] ) : sanitize_text_field( $user_choice[ $setting_name ] );
				} else {
					$current_option[ $setting_name ] = '';
				}
			}
		}

		if ( empty( $current_option['listing_rows_numbers_enable'] ) ) {
			$current_option['enable_checkbox_button'] = '';
			$current_option['listing_rows_numbers']   = '';
		}

		$options[ $option_key ] = $current_option;

		stm_vehicle_listings_save_options( $options );

		$data['error']   = false;
		$data['message'] = esc_html__( 'Settings saved', 'stm_vehicles_listing' );
		$data['data']    = $current_option;
	}

	wp_send_json( $data );
}

add_action( 'wp_ajax_stm_listings_save_single_option_row', 'stm_listings_save_single_option_row' );

/*Deleting row*/
function stm_listings_delete_single_option_row() {
	check_ajax_referer( 'stm_listings_delete_single_option_row', 'security' );
	if ( isset( $_POST['number'] ) ) {
		$options    = stm_listings_get_my_options_list();
		$option_key = intval( $_POST['number'] );
		if ( ! empty( $options[ $option_key ] ) ) {
			unset( $options[ $option_key ] );
			if ( stm_vehicle_listings_save_options( $options ) ) {
				wp_send_json(
					array(
						'status' => 200,
						'msg'    => 'Updated',
					)
				);
			}
		}
	}
	wp_send_json(
		array(
			'status' => 400,
			'msg'    => 'Error',
		)
	);
}

add_action( 'wp_ajax_stm_listings_delete_single_option_row', 'stm_listings_delete_single_option_row' );

/*Save new order*/
function stm_listings_save_option_order() {
	check_ajax_referer( 'stm_listings_save_option_order', 'security' );

	if ( isset( $_POST['order'] ) ) {
		$options     = stm_listings_get_my_options_list();
		$new_options = explode( ',', sanitize_text_field( $_POST['order'] ) );

		$new_order = array();

		foreach ( $new_options as $option ) {
			if ( ! empty( $options[ $option ] ) ) {
				$new_order[] = $options[ $option ];
			}
		}

		if ( stm_vehicle_listings_save_options( $new_order ) ) {
			wp_send_json(
				array(
					'status' => 200,
					'msg'    => 'Updated',
				)
			);
		}
	}

	wp_send_json(
		array(
			'status' => 400,
			'msg'    => 'Error',
		)
	);
}

add_action( 'wp_ajax_stm_listings_save_option_order', 'stm_listings_save_option_order' );

function stm_listings_add_new_option() {
	check_ajax_referer( 'stm_listings_add_new_option', 'security' );

	$data = array(
		'error'   => false,
		'message' => '',
	);

	$options = stm_listings_get_my_options_list();

	/*Get reserved terms*/
	$reserved_terms = stm_listings_reserved_terms();

	$new_option = $_POST;

	if ( empty( $new_option['slug'] ) && ! empty( $new_option['single_name'] ) ) {
		$new_option['slug'] = sanitize_title( $new_option['single_name'] );
	}

	if ( empty( $new_option['single_name'] ) || empty( $new_option['plural_name'] ) || empty( $new_option['slug'] ) ) {
		$data['error']   = true;
		$data['message'] = esc_html__( 'Singular, Plural names and Slug are required', 'stm_vehicles_listing' );
	} else {
		$new_option['slug'] = sanitize_title( $new_option['slug'] );

		if ( in_array( $new_option['slug'], $reserved_terms, true ) || taxonomy_exists( $new_option['slug'] ) ) {
			$data['error']   = true;
			$data['message'] = esc_html__( 'Slug name is already in use. Please choose another slug name.', 'stm_vehicles_listing' );
		}
	}

	if ( ! $data['error'] ) {

		$settings = stm_listings_page_options();

		foreach ( $settings as $setting_name => $setting ) {

			if ( ! empty( $new_option[ $setting_name ] ) ) {
				$current_option[ $setting_name ] = sanitize_text_field( $new_option[ $setting_name ] );
			} else {
				if ( strpos( $setting_name, 'divider' ) === false ) {
					$current_option[ $setting_name ] = '';
				}
			}
		}

		if ( empty( $current_option['listing_rows_numbers_enable'] ) ) {
			$current_option['enable_checkbox_button'] = '';
			$current_option['listing_rows_numbers']   = '';
		}

		$numeric = ( $new_option['numeric'] ) ? esc_html__( 'Yes', 'stm_vehicles_listing' ) : esc_html__( 'No', 'stm_vehicles_listing' );
		$link    = get_site_url() . '/wp-admin/edit-tags.php?taxonomy=' . esc_attr( $new_option['slug'] ) . '&post_type=listings';

		$options[] = $current_option;

		$data['option'] = array(
			'key'     => max( array_keys( $options ) ),
			'name'    => $new_option['single_name'],
			'plural'  => $new_option['plural_name'],
			'slug'    => $new_option['slug'],
			'numeric' => $numeric,
			'link'    => $link,
		);

		stm_vehicle_listings_save_options( $options );
	}

	wp_send_json( $data );
	exit;
}

add_action( 'wp_ajax_stm_listings_add_new_option', 'stm_listings_add_new_option' );

function stm_test_force_update() {
	$stm_listings = array(
		1  => array(
			'single_name'                          => 'Condition',
			'plural_name'                          => 'Conditions',
			'slug'                                 => 'condition',
			'font'                                 => '',
			'numeric'                              => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => false,
			'use_on_car_filter'                    => true,
			'use_on_car_modern_filter'             => true,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => true,
		),
		2  => array(
			'single_name'                          => 'Body',
			'plural_name'                          => 'Bodies',
			'slug'                                 => 'body',
			'font'                                 => 'motors-icons-body_type',
			'numeric'                              => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => true,
			'use_on_car_filter'                    => false,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => true,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => false,
			'listing_rows_numbers'                 => 'two_cols',
			'enable_checkbox_button'               => false,
		),
		3  => array(
			'single_name'                          => 'Make',
			'plural_name'                          => 'Makes',
			'slug'                                 => 'make',
			'font'                                 => '',
			'numeric'                              => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => false,
			'use_on_car_filter'                    => true,
			'use_on_car_modern_filter'             => true,
			'use_on_car_modern_filter_view_images' => true,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => true,
			'enable_checkbox_button'               => false,
			'use_in_footer_search'                 => true,
		),
		5  => array(
			'single_name'                          => 'Model',
			'plural_name'                          => 'Models',
			'slug'                                 => 'serie',
			'font'                                 => '',
			'numeric'                              => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => false,
			'use_on_car_filter'                    => true,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => true,
			'enable_checkbox_button'               => false,
			'use_in_footer_search'                 => true,
		),
		6  => array(
			'single_name'                          => 'Mileage',
			'plural_name'                          => 'Mileages',
			'slug'                                 => 'mileage',
			'font'                                 => 'motors-icons-road',
			'numeric'                              => true,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => true,
			'use_on_car_archive_listing_page'      => true,
			'use_on_single_car_page'               => true,
			'use_on_car_filter'                    => true,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => false,
			'number_field_affix'                   => 'mi',
			'enable_checkbox_button'               => false,
		),
		7  => array(
			'single_name'                          => 'Fuel type',
			'plural_name'                          => 'Fuel types',
			'slug'                                 => 'fuel',
			'font'                                 => 'motors-icons-fuel',
			'numeric'                              => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => true,
			'use_on_single_car_page'               => true,
			'use_on_car_filter'                    => false,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => false,
		),
		8  => array(
			'single_name'                          => 'Engine',
			'plural_name'                          => 'Engines',
			'slug'                                 => 'engine',
			'font'                                 => 'motors-icons-engine_fill',
			'numeric'                              => true,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => true,
			'use_on_single_car_page'               => true,
			'use_on_car_filter'                    => false,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => false,
			'enable_checkbox_button'               => false,
			'use_in_footer_search'                 => false,
		),
		9  => array(
			'single_name'                          => 'Year',
			'plural_name'                          => 'Years',
			'slug'                                 => 'ca-year',
			'font'                                 => 'motors-icons-road',
			'numeric'                              => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => false,
			'use_on_car_filter'                    => true,
			'use_on_car_modern_filter'             => true,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => false,
			'enable_checkbox_button'               => false,
		),
		10 => array(
			'single_name'                          => 'Price',
			'plural_name'                          => 'Prices',
			'slug'                                 => 'price',
			'font'                                 => 'motors-icons-road',
			'numeric'                              => true,
			'slider'                               => true,
			'use_on_single_listing_page'           => true,
			'use_on_car_listing_page'              => true,
			'use_on_car_archive_listing_page'      => true,
			'use_on_single_car_page'               => false,
			'use_on_car_filter'                    => true,
			'use_on_car_modern_filter'             => true,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => false,
			'enable_checkbox_button'               => false,
		),
		11 => array(
			'single_name'                          => 'Fuel consumption',
			'plural_name'                          => 'Fuel consumptions',
			'slug'                                 => 'fuel-consumption',
			'font'                                 => 'motors-icons-fuel',
			'numeric'                              => true,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => true,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => false,
			'use_on_car_filter'                    => false,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
		),
		12 => array(
			'single_name'                          => 'Transmission',
			'plural_name'                          => 'Transmission',
			'slug'                                 => 'transmission',
			'font'                                 => 'motors-icons-transmission_fill',
			'numeric'                              => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => true,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => true,
			'use_on_car_filter'                    => true,
			'use_on_car_modern_filter'             => true,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => false,
		),
		13 => array(
			'single_name'                          => 'Drive',
			'plural_name'                          => 'Drives',
			'slug'                                 => 'drive',
			'font'                                 => 'motors-icons-drive_2',
			'numeric'                              => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => true,
			'use_on_car_filter'                    => false,
			'use_on_car_modern_filter'             => true,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => false,
		),
		14 => array(
			'single_name'                          => 'Fuel economy',
			'plural_name'                          => 'Fuel economy',
			'slug'                                 => 'fuel-economy',
			'font'                                 => '',
			'numeric'                              => true,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => false,
			'use_on_car_filter'                    => false,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => false,
			'enable_checkbox_button'               => false,
		),
		15 => array(
			'single_name'                          => 'Exterior Color',
			'plural_name'                          => 'Exterior Colors',
			'slug'                                 => 'exterior-color',
			'font'                                 => 'motors-icons-color_type',
			'numeric'                              => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => true,
			'use_on_car_filter'                    => false,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => false,
			'enable_checkbox_button'               => false,
		),
		16 => array(
			'single_name'                          => 'Interior Color',
			'plural_name'                          => 'Interior Colors',
			'slug'                                 => 'interior-color',
			'font'                                 => 'motors-icons-color_type',
			'numeric'                              => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => true,
			'use_on_car_filter'                    => false,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => false,
			'enable_checkbox_button'               => false,
		),
		17 => array(
			'single_name'                          => 'Features',
			'plural_name'                          => 'Features',
			'slug'                                 => 'features',
			'font'                                 => '',
			'numeric'                              => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => false,
			'use_on_car_filter'                    => false,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => true,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => false,
			'listing_rows_numbers'                 => 'one_col',
			'enable_checkbox_button'               => true,
		),
	);

	update_option( 'stm_vehicle_listing_options', $stm_listings );
}
