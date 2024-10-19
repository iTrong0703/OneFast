<?php
add_filter( 'nav_menu_css_class', 'stm_nav_menu_css_class', 10, 4 );

function stm_nav_menu_css_class( $classes, $item, $args, $depth = 0 ) {

	$id = $item->ID;

	// MEGAMENU ONLY ON FIRST LVL
	if ( ! $depth ) {
		$mega = get_post_meta( $id, stm_menu_meta( 'stm_mega' ), true );
		if ( ! empty( $mega ) && 'disabled' !== $mega ) {
			$classes[] = 'stm_megamenu stm_megamenu__' . $mega;
		}

		$menu_use_logo = get_post_meta( $id, '_menu_item_stm_menu_logo', true );
		if ( 'checked' === $menu_use_logo ) {
			$classes[] = ' stm_menu_item_logo';
		}

		$child_use_post = get_post_meta( $item->ID, stm_menu_meta( 'stm_child_menu_use_post' ), true );
		if ( 'checked' === $child_use_post ) {
			$classes[] = ' stm_menu_child_use_post';
		}
	} elseif ( 1 === $depth ) {
		$child_use_post = get_post_meta( $item->menu_item_parent, stm_menu_meta( 'stm_child_menu_use_post' ), true );
		if ( 'checked' === $child_use_post ) {
			$classes[] = ' stm_menu_use_post';
		}
	} elseif ( 2 === $depth ) {
		$mega_second_col_width = get_post_meta( $id, stm_menu_meta( 'stm_mega_second_col_width' ), true );
		if ( ! empty( $mega_second_col_width ) ) {
			$classes[] = 'stm_mega_second_col_width_' . $mega_second_col_width;
		}

		$special_offers = get_post_meta( $id, '_menu_item_stm_menu_show_special_offer', true );
		if ( ! empty( $special_offers ) ) {
			$classes[] = 'stm_mega_cols_inside_has_special_offers';
		}

		$image          = get_post_meta( $id, stm_menu_meta( 'stm_menu_image' ), true );
		$menu_text_data = get_post_meta( $id, '_menu_item_stm_menu_text_repeater' );
		$textarea       = get_post_meta( $id, stm_menu_meta( 'stm_mega_textarea' ), true );
		if ( ! empty( $image ) || ! empty( $menu_text_data ) || ! empty( $textarea ) ) {
			$classes[] = 'stm_mega_second_col_width_' . $mega_second_col_width . ' stm_mega_has_info';
		}
	}

	return $classes;
}

add_filter( 'nav_menu_item_title', 'stm_nav_menu_item_title', 10, 4 );

function stm_nav_menu_item_title( $title, $item, $args, $depth ) {
	$id = $item->ID;

	// MEGAMENU ONLY ON 2 AND 3
	$menu_use_logo  = get_post_meta( $id, '_menu_item_stm_menu_logo', true );
	$special_offers = get_post_meta( $id, '_menu_item_stm_menu_show_special_offer', true );
	$menu_text_data = get_post_meta( $id, '_menu_item_stm_menu_text_repeater' );

	if ( ! $depth && ! empty( $menu_use_logo ) ) {
		return $title;
	}

	/*IMAGE BANNER THIRD LVL ONLY*/
	$image = get_post_meta( $id, stm_menu_meta( 'stm_menu_image' ), true );
	if ( 1 === $depth || 2 === $depth ) {
		if ( ! empty( $image ) ) {
			$image = wp_get_attachment_image_src( $image, 'full' );

			if ( ! empty( $image[0] ) ) {
				$img   = '<img alt="' . $title . '" src="' . $image[0] . '" />';
				$title = $img;
			}
		} else {
			if ( 2 === $depth ) {
				if ( ! empty( $menu_text_data ) ) {
					$menu_text_data = json_decode( $menu_text_data[0] );
				}

				if ( ! empty( $menu_text_data ) && count( $menu_text_data ) > 0 ) {
					$title = '';
				}
			}
		}
	}

	if ( 1 === $depth || 2 === $depth ) {
		/*Text field*/
		$textarea = get_post_meta( $id, stm_menu_meta( 'stm_mega_textarea' ), true );
		$modify   = '';
		if ( ! empty( $textarea ) ) {
			$textarea = '<span class="stm_mega_textarea">' . $textarea . '</span>';
			$modify   = $textarea;
			$title    = $textarea;
		}

		$menu_icon_data = get_post_meta( $id, '_menu_item_stm_menu_icon_repeater' );
		if ( ! empty( $menu_icon_data ) ) {
			$menu_icon_data = json_decode( $menu_icon_data[0] );
		}

		if ( ! empty( $menu_text_data ) ) {
			$menu_text_data = json_decode( $menu_text_data[0] );
		}

		if ( ! empty( $menu_text_data ) ) {
			$list   = "<ul class='mm-list'>";
			$c_data = count( $menu_text_data );
			for ( $q = 0; $q < $c_data; $q ++ ) {
				if ( ! empty( $menu_text_data[ $q ] ) ) {
					$list .= "<li class='normal_font'><i class='" . $menu_icon_data[ $q ] . "'></i>" . $menu_text_data[ $q ] . '</li>';
				}
			}

			$list .= '</ul>';
			$title = $modify . $list;
		}
	}

	/*Icon on both 2 and 3 lvls and not on images*/
	if ( empty( $image ) && empty( $menu_text_data ) ) {
		$icon = get_post_meta( $id, stm_menu_meta( 'stm_menu_icon' ), true );
		if ( ! empty( $icon ) ) {
			$icon  = '<i class="stm_megaicon ' . $icon . '"></i>';
			$title = $icon . $title;
		}
	}

	$logo_width = '';
	if ( function_exists( 'stm_me_get_nuxy_mod' ) ) {
		$logo_width = apply_filters( 'stm_me_get_nuxy_mod', '157', 'logo_width' );
	}

	if ( 0 === $depth && 'checked' === $menu_use_logo ) {
		$logo_main = apply_filters( 'stm_me_get_nuxy_img_src', '', 'logo' );
		$output    = '<div class="logo-main">';
		if ( empty( $logo_main ) ) :
			$output .= '<h2>' . esc_attr( get_bloginfo( 'name' ) ) . '</h2>';
		else :
			$output .= '<img
                            src="' . esc_url( $logo_main ) . '"
                            style="width: ' . esc_attr( $logo_width ) . 'px;"
                            title="' . esc_html_e( 'Home', 'stm-megamenu' ) . '"
                            alt="' . esc_html_e( 'Logo', 'stm-megamenu' ) . '"
								/>';
		endif;
		$output .= '</div>';
		$title   = $output;
	}

	if ( 1 === $depth && 'checked' === $special_offers ) {

		$specials = stm_mm_get_featured_listings( 2, 'stm-img-120-120' );

		$output = '<div class="stm-special-offers">';

		foreach ( $specials as $special ) {

			$special_url = get_the_permalink( $special['ID'] );
			$link        = sprintf( '<a href="%s">%s</a>', $special_url, $special['title'] );

			$output .= '<div class="special-wrap">';
			$output .= '<div class="img-wrap">';
			$output .= '<a href="' . $special_url . '">';
			$output .= '<img src="' . $special['img'] . '" />';
			$output .= '</a>';
			$output .= '</div>';
			$output .= '<div class="title-price-wrap">';
			$output .= '<div class="car-title">' . $link . '</div>';
			$output .= '<div class="prices">';
			$output .= ( ! empty( $special['sale_price'] ) ) ? '<span class="normal_price normal_font has_sale">' . $special['price'] . '</span><span class="sale_price heading-font">' . $special['sale_price'] . '</span>' : '<span class="normal_price normal_font">' . $special['price'] . '</span>';
			$output .= '</div>';
			$output .= '</div>';
			$output .= '</div>';
		}

		$output .= '</div>';
		$title   = $output;
	}

	return $title;
}

add_filter( 'nav_menu_link_attributes', 'stm_nav_menu_link_attributes', 10, 4 );

function stm_nav_menu_link_attributes( $atts, $item, $args, $depth ) {
	/*ONLY LVL 0*/
	if ( ! $depth ) {
		$id = $item->ID;
		$bg = get_post_meta( $id, stm_menu_meta( 'stm_menu_bg' ), true );

		if ( ! empty( $bg ) ) {
			$bg = wp_get_attachment_image_src( $bg, 'full' );
			if ( ! empty( $bg[0] ) ) {
				$atts['data-megabg'] = esc_url( $bg[0] );
			}
		}
	}

	return $atts;
}

add_filter( 'walker_nav_menu_start_el', 'stm_nav_start_el', 100, 4 );

function stm_nav_start_el( $item_output, $item, $depth, $args ) {

	$atts           = array();
	$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
	$atts['target'] = ! empty( $item->target ) ? $item->target : '';
	if ( '_blank' === $item->target && empty( $item->xfn ) ) {
		$atts['rel'] = 'noopener noreferrer';
	} else {
		$atts['rel'] = $item->xfn;
	}
	$atts['href']         = ! empty( $item->url ) ? $item->url : '';
	$atts['aria-current'] = $item->current ? 'page' : '';

	$attributes = '';
	foreach ( $atts as $attr => $value ) {
		if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
			$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
			$attributes .= ' ' . $attr . '="' . $value . '"';
		}
	}

	$title = apply_filters( 'the_title', $item->title, $item->ID );
	$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

	$content  = '<a' . $attributes . '>';
	$content .= $args->link_before . $title . $args->link_after;
	$content .= '</a>';

	$use_as_title   = get_post_meta( $item->ID, stm_menu_meta( 'stm_menu_as_title' ), true );
	$special_offers = get_post_meta( $item->ID, '_menu_item_stm_menu_show_special_offer', true );
	$menu_text_data = get_post_meta( $item->ID, '_menu_item_stm_menu_text_repeater' );

	$title_text = $item->title;
	$icon       = get_post_meta( $item->ID, stm_menu_meta( 'stm_menu_icon' ), true );
	if ( ! empty( $icon ) ) {
		$icon       = '<i class="stm_megaicon ' . $icon . '"></i>';
		$title_text = $icon . $title_text;
	}

	if ( ! empty( $use_as_title ) && empty( $special_offers ) && empty( $menu_text_data ) ) {
		$content = sprintf( '<div class="menu-title heading-font">%s</div>', $title_text );
	} elseif ( 'checked' === $special_offers && empty( $use_as_title ) ) {
		$content = $title_text;
	} elseif ( 'checked' === $special_offers && ! empty( $use_as_title ) ) {
		$content  = sprintf( '<div class="menu-title heading-font">%s</div>', $title_text );
		$content .= $title;
	} elseif ( $menu_text_data && ! empty( $menu_text_data ) ) {
		$content  = sprintf( '<div class="menu-title heading-font">%s</div>', $title_text );
		$content .= $title;
	}

	if ( 'stm_megamenu' === $item->object ) {

		$post_content = get_post_field( 'post_content', $item->object_id );

		$content  = sprintf( '<div class="menu-title heading-font">%s</div>', $title_text );
		$content .= '<style type="text/css">' . get_post_meta( $item->object_id, '_wpb_shortcodes_custom_css', true ) . '</style>';
		$content .= '<div class="stm_mm_post_content">';

		if ( stm_mm_is_elementor_active() ) {
			ob_start();
			apply_filters( 'motors_render_elementor_content', $item->object_id );
			$content .= ob_get_clean();
		} else {
			$content .= apply_filters( 'the_content', $post_content );
		}

		$content .= '</div>';
	}

	$item_output  = $args->before;
	$item_output .= $content;
	$item_output .= $args->after;

	return $item_output;
}

function stm_menu_meta( $name ) {
	return '_menu_item_' . $name;
}


function stm_mm_subcat_list( $parent_id ) {

	$categories = get_categories(
		array(
			'child_of'            => $parent_id,
			'current_category'    => 0,
			'depth'               => 0,
			'echo'                => 1,
			'exclude'             => '',
			'exclude_tree'        => '',
			'feed'                => '',
			'feed_image'          => '',
			'feed_type'           => '',
			'hide_empty'          => 0,
			'hide_title_if_empty' => false,
			'hierarchical'        => true,
			'order'               => 'ASC',
			'orderby'             => 'name',
			'separator'           => '<br />',
			'show_count'          => 0,
			'show_option_all'     => '',
			'show_option_none'    => '',
			'style'               => 'list',
			'taxonomy'            => 'category',
			'title_li'            => '',
			'use_desc_for_title'  => 1,
		)
	);

	$cat_array_walker = new STM_MM_List_Walker();
	$cat_array_walker->walk( $categories, 4 );

	return ( $cat_array_walker->list );
}

class STM_MM_List_Walker extends Walker {

	public $tree_type = 'category';
	public $db_fields = array(
		'parent' => 'parent',
		'id'     => 'term_id',
	);

	public $list = '';

	public function start_lvl( &$output, $depth = 0, $args = array() ) {
	}

	public function end_lvl( &$output, $depth = 0, $args = array() ) {
	}

	public function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {

		$class = 'stm-mm-' . $depth . '-level';

		$this->list .= '<li class="' . esc_attr( $class ) . '"><a href="' . esc_url( get_category_link( $category ) ) . '" class="stm-mm-load-on-hover" data-cat-id="' . esc_attr( $category->term_id ) . '" data-has-child="has_child">' . $category->name . '<i class="stm-mm-chevron"></i></a></li>';
	}


	public function end_el( &$output, $page, $depth = 0, $args = array() ) {
	}
}
