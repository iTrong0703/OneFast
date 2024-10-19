<?php

namespace Motors_Elementor_Widgets_Free\Helpers;

use WP_Query;

class RegisterActions {
	public static function init() {
		add_action( 'init', array( self::class, 'motors_remove_post_type_supports' ) );
		add_action( 'wp_loaded', array( self::class, 'motors_create_nonce' ) );
		add_action( 'elementor/editor/after_save', array( self::class, 'motors_elementor_after_save' ), 100, 2 );

		add_filter( 'motors_merge_wpcfto_config', array( self::class, 'motors_remove_inventory_settings_conf' ) );
		add_filter( 'search_settings_conf', array( self::class, 'motors_remove_search_settings_conf' ), 55, 1 );
		add_filter( 'listing_settings_conf', array( self::class, 'motors_remove_listing_settings_conf' ), 55, 1 );
		add_filter(
			'stm_is_elementor_demo',
			function () {
				return true;
			}
		);

		add_filter( 'stm_ew_modify_post_type_objects', array( self::class, 'motors_modify_post_type_objects' ) );

		add_filter( 'stm_ew_kses_svg', array( self::class, 'stm_ew_kses_svg' ) );
		add_filter( 'stm_dynamic_icon_output', array( self::class, 'stm_dynamic_icon_output' ) );

		add_action( 'wp_ajax_close_after_click', array( self::class, 'close_after_click' ) );

		add_action( 'wp_ajax_grid_tabs_widget', array( self::class, 'motors_ew_grid_tabs' ) );
		add_action( 'wp_ajax_nopriv_grid_tabs_widget', array( self::class, 'motors_ew_grid_tabs' ) );

		add_action( 'wp_ajax_ml_grid_tabs', array( self::class, 'motors_ew_ml_grid_tabs' ) );
		add_action( 'wp_ajax_nopriv_ml_grid_tabs', array( self::class, 'motors_ew_ml_grid_tabs' ) );

		add_action( 'wp_ajax_car_listing_tabs_widget', array( self::class, 'motors_ew_car_listing_tabs' ) );
		add_action( 'wp_ajax_nopriv_car_listing_tabs_widget', array( self::class, 'motors_ew_car_listing_tabs' ) );
	}

	public static function motors_create_nonce() {
		$tm_nonce            = wp_create_nonce( 'motors_create_template' );
		$tm_delete_nonce     = wp_create_nonce( 'motors_delete_template' );
		$close_after_click   = wp_create_nonce( 'motors_close_after_click' );
		$grid_tabs_widget    = wp_create_nonce( 'motors_grid_tabs' );
		$ml_grid_tabs_widget = wp_create_nonce( 'motors_ml_grid_tabs' );
		$car_listing_tabs    = wp_create_nonce( 'motors_car_listing_tabs' );

		wp_localize_script(
			'jquery',
			'mew_nonces',
			array(
				'ajaxurl'                 => admin_url( 'admin-ajax.php' ),
				'tm_nonce'                => $tm_nonce,
				'tm_delete_nonce'         => $tm_delete_nonce,
				'close_after_click'       => $close_after_click,
				'motors_grid_tabs'        => $grid_tabs_widget,
				'motors_ml_grid_tabs'     => $ml_grid_tabs_widget,
				'motors_car_listing_tabs' => $car_listing_tabs,
			)
		);
	}

	public static function motors_remove_post_type_supports() {
	}

	public static function motors_remove_inventory_settings_conf( $settings ) {

		unset( $settings['listing_sidebar'] );
		unset( $settings['listing_filter_position'] );

		return $settings;
	}

	public static function motors_remove_search_settings_conf( $settings ) {

		unset( $settings['listing_filter_position'] );
		unset( $settings['listing_list_sort_slug'] );
		unset( $settings['position_keywords_search'] );

		return $settings;
	}

	public static function motors_remove_listing_settings_conf( $settings ) {

		unset( $settings['listing_directory_title_default'] );

		return $settings;
	}

	public static function array_value_recursive( $post_id, $key, array $arr ) {
		array_walk_recursive(
			$arr,
			function ( $v, $k ) use ( $post_id, $key, &$val ) {
				$keys_for_save = array(
					'ppp_on_list',
					'ppp_on_grid',
					'quant_grid_items',
				);

				if ( in_array( $k, $keys_for_save, true ) ) {
					update_post_meta( $post_id, $k, $v );
				}
			}
		);
	}

	public static function motors_elementor_after_save( $post_id, $editor_data ) {
		self::array_value_recursive( $post_id, 'ppp_on_grid', $editor_data );
	}

	public static function motors_modify_post_type_objects( $post_types_objects ) {

		unset( $post_types_objects['listings'] );

		return $post_types_objects;
	}

	public static function stm_ew_kses_svg() {
		$kses_defaults = wp_kses_allowed_html( 'post' );

		$svg = array(
			'svg'   => array(
				'class'           => true,
				'aria-hidden'     => true,
				'aria-labelledby' => true,
				'role'            => true,
				'xmlns'           => true,
				'width'           => true,
				'height'          => true,
				'viewbox'         => true,
			),
			'g'     => array( 'fill' => true ),
			'title' => array( 'title' => true ),
			'path'  => array(
				'd'    => true,
				'fill' => true,
			),
		);

		return array_merge( $kses_defaults, $svg );
	}

	public static function stm_dynamic_icon_output( $icon_data ) {
		if ( isset( $icon_data['value']['url'] ) ) {
			$icon_url = $icon_data['value']['url'];
			return wp_kses(
				wp_remote_get( $icon_url ),
				apply_filters( 'stm_ew_kses_svg', array() )
			);
		} elseif ( isset( $icon_data['value'] ) && ! empty( $icon_data['value'] ) ) {
			return '<i class="' . esc_attr( $icon_data['value'] ) . '"></i>';
		}

		return '';
	}

	public static function close_after_click() {
		check_ajax_referer( 'motors_close_after_click', 'nonce' );

		update_option( 'features_settings_clicked', 1 );

		wp_send_json_success();
	}

	public static function motors_ew_grid_tabs() {
		check_ajax_referer( 'motors_grid_tabs', 'security' );

		$listing_types = apply_filters( 'stm_listings_post_type', 'listings' );

		$tab_type = sanitize_text_field( $_POST['tab_type'] );
		$per_page = intval( $_POST['per_page'] );
		$template = sanitize_text_field( $_POST['template'] );
		$img_size = sanitize_text_field( $_POST['img_size'] );

		$args = array(
			'post_type'      => $listing_types,
			'post_status'    => 'publish',
			'posts_per_page' => $per_page,
		);

		if ( 'popular' === $tab_type ) {
			$args = array_merge(
				$args,
				array(
					'orderby'  => 'meta_value_num',
					'meta_key' => 'stm_car_views', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
					'order'    => 'DESC',
				)
			);
		}

		$args['meta_query'][] = array(
			'key'     => 'car_mark_as_sold',
			'value'   => '',
			'compare' => '=',
		);

		$template_args = array();
		if ( ! empty( $img_size ) ) {
			$template_args = array(
				'custom_img_size' => $img_size,
			);
		}

		$listings_query = new WP_Query( $args );

		if ( $listings_query->have_posts() ) {
			$output = '';
			ob_start();
			while ( $listings_query->have_posts() ) {
				$listings_query->the_post();
				do_action( 'stm_listings_load_template', $template, $template_args );
			}
			$output .= ob_get_clean();
		}

		wp_send_json(
			array(
				'html' => $output,
			)
		);
	}

	public static function motors_ew_ml_grid_tabs() {
		check_ajax_referer( 'motors_ml_grid_tabs', 'security' );

		$listing_type     = ( isset( $_POST['listing_type'] ) ) ? sanitize_text_field( $_POST['listing_type'] ) : 'listings';
		$listing_type     = ( isset( $_POST['listing_types'] ) ) ? explode( ',', sanitize_text_field( $_POST['listing_types'] ) ) : $listing_type;
		$tab_type         = ( isset( $_POST['tab_type'] ) ) ? sanitize_text_field( $_POST['tab_type'] ) : '';
		$per_page         = ( isset( $_POST['per_page'] ) ) ? intval( $_POST['per_page'] ) : 4;
		$template         = ( isset( $_POST['template'] ) ) ? sanitize_text_field( $_POST['template'] ) : '';
		$order_by         = ( isset( $_POST['order_by'] ) ) ? sanitize_text_field( $_POST['order_by'] ) : '';
		$show_all_link    = ( isset( $_POST['show_all_link'] ) ) ? sanitize_text_field( $_POST['show_all_link'] ) : '';
		$show_all_text    = ( isset( $_POST['show_all_text'] ) ) ? sanitize_text_field( $_POST['show_all_text'] ) : '';
		$img_size         = ( isset( $_POST['img_size'] ) ) ? sanitize_text_field( $_POST['img_size'] ) : null;
		$title_max_length = ( isset( $_POST['title_max_length'] ) ) ? sanitize_text_field( $_POST['title_max_length'] ) : '';

		$args = array(
			'post_type'      => $listing_type,
			'post_status'    => 'publish',
			'posts_per_page' => $per_page,
		);

		if ( 'popular' === $order_by || 'popular' === $tab_type ) {
			$args = array_merge(
				$args,
				array(
					'orderby'  => 'meta_value_num',
					'meta_key' => 'stm_car_views',
					'order'    => 'DESC',
				)
			);
		} elseif ( 'featured' === $tab_type ) {
			$args['order'] = 'rand';

			$args['meta_query'][] = array(
				'key'     => 'special_car',
				'value'   => 'on',
				'compare' => '=',
			);
		}

		if ( ! empty( $tab_type ) ) {
			$args['meta_query'][] = array(
				'key'     => 'car_mark_as_sold',
				'value'   => '',
				'compare' => '=',
			);
		}

		$template_args = array(
			'custom_img_size'  => ( ! empty( $img_size ) ) ? $img_size : null,
			'title_max_length' => ( ! empty( $title_max_length ) ) ? $title_max_length : null,
		);

		$listing_cars = new WP_Query( $args );

		ob_start();
		?>

		<?php if ( $listing_cars->have_posts() ) : ?>
			<div class="row row-<?php echo intval( $per_page ); ?> car-listing-row">
				<?php
				while ( $listing_cars->have_posts() ) :
					$listing_cars->the_post();
					?>
					<?php do_action( 'stm_listings_load_template', $template, $template_args ); ?>
				<?php endwhile; ?>
			</div>

			<?php if ( ! empty( $show_all_link ) && 'yes' === $show_all_link && ! empty( $listing_type ) && apply_filters( 'stm_inventory_page_url', '', $listing_type ) ) : ?>
				<div class="row">
					<div class="col-xs-12 text-center">
						<div class="dp-in">
							<a class="load-more-btn" href="<?php echo esc_url( apply_filters( 'stm_inventory_page_url', '', $listing_type ) ); ?>">
								<?php echo esc_html( $show_all_text ); ?>
							</a>
						</div>
					</div>
				</div>
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
		<?php endif; ?>
		<?php
		$output = ob_get_clean();

		wp_send_json(
			array(
				'html' => $output,
			)
		);
	}

	public static function motors_ew_car_listing_tabs() {
		check_ajax_referer( 'motors_car_listing_tabs', 'security' );

		$per_page            = intval( $_POST['per_page'] );
		$taxonomy            = sanitize_text_field( $_POST['taxonomy'] );
		$terms               = sanitize_text_field( $_POST['terms'] );
		$found_cars_prefix   = sanitize_text_field( $_POST['fc_prefix'] );
		$found_cars_suffix   = sanitize_text_field( $_POST['fc_suffix'] );
		$enable_ajax_loading = sanitize_text_field( $_POST['enable_ajax_loading'] );
		$img_size            = sanitize_text_field( $_POST['img_size'] );
		$found_cars_icon     = $_POST['found_cars_icon'];
		$random_int          = intval( $_POST['random_int'] );

		$args = array(
			'post_type'      => apply_filters( 'stm_listings_post_type', 'listings' ),
			'post_status'    => 'publish',
			'posts_per_page' => $per_page,
		);

		$args['tax_query'][] = array(
			'taxonomy' => $taxonomy,
			'field'    => 'slug',
			'terms'    => array( $terms ),
		);

		$args['meta_query'][] = array(
			'key'     => 'car_mark_as_sold',
			'value'   => '',
			'compare' => '=',
		);

		$template_args = array();
		if ( ! empty( $img_size ) ) {
			$template_args = array(
				'custom_img_size' => $img_size,
			);
		}

		$listing_cars = new WP_Query( $args );
		$friendly_url = apply_filters( 'motors_vl_get_nuxy_mod', false, 'friendly_url' );
		$atts         = ( $friendly_url ) ? esc_attr( $terms ) : '?' . esc_attr( $taxonomy ) . '=' . esc_attr( $terms );
		$url          = apply_filters( 'stm_filter_listing_link', '' ) . $atts;
		ob_start();
		?>
		<div role="tabpanel" class="tab-pane "
			id="car-listing-category-<?php echo esc_attr( $terms . '-' . $random_int ); ?>">
			<div class="found-cars-clone">
				<div class="found-cars heading-font">
					<?php
					if ( ! empty( $found_cars_icon ) ) {
						echo wp_kses( $found_cars_icon, apply_filters( 'stm_ew_kses_svg', array() ) );
					}
					?>
					<span><?php echo esc_html( $found_cars_prefix ); ?></span>
					<span class="blue-lt">
					<?php echo esc_attr( $listing_cars->found_posts ); ?>
					<?php echo esc_html( $found_cars_suffix ); ?>
				</span>
				</div>
			</div>
			<?php if ( $listing_cars->have_posts() ) : ?>
				<div class="row row-4 car-listing-row">
					<?php
					while ( $listing_cars->have_posts() ) :
						$listing_cars->the_post();
						?>
						<?php do_action( 'stm_listings_load_template', 'car-filter-loop', $template_args ); ?>
					<?php endwhile; ?>
				</div>

				<?php if ( ! empty( $enable_ajax_loading ) && $enable_ajax_loading ) : ?>
					<?php if ( $listing_cars->found_posts > $per_page ) : ?>
						<div class="row car-listing-actions">
							<div class="col-xs-12 text-center">
								<div class="dp-in">
									<div class="preloader">
										<span></span>
										<span></span>
										<span></span>
										<span></span>
										<span></span>
									</div>
									<a class="load-more-btn" href="" onclick="stm_loadMoreCars(jQuery(this),'<?php echo esc_js( $terms ); ?>','<?php echo esc_js( $taxonomy ); ?>',<?php echo esc_js( $per_page ); ?>,<?php echo esc_js( $per_page ); ?>,'<?php echo esc_js( $random_int ); ?>');return false;">
										<?php esc_html_e( 'Load more', 'motors-car-dealership-classified-listings-pro' ); ?>
									</a>
								</div>
							</div>
						</div>
					<?php endif; ?>
				<?php else : ?>
					<div class="row">
						<div class="col-xs-12 text-center">
							<div class="dp-in">
								<a class="load-more-btn" href="<?php echo esc_url( $url ); ?>">
									<?php esc_html_e( 'Show all', 'motors-car-dealership-classified-listings-pro' ); ?>
								</a>
							</div>
						</div>
					</div>
				<?php endif; ?>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>
		</div>
		<?php
		$output = ob_get_clean();
		wp_send_json(
			array(
				'html' => $output,
			)
		);
	}
}
