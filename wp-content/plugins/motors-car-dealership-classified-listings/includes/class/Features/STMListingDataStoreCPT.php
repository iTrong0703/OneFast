<?php

class STMListingDataStoreCPT extends WC_Product_Data_Store_CPT implements WC_Object_Data_Store_Interface, WC_Product_Data_Store_Interface {
	/**
	 * Method to read a product from the database.
	 *
	 * @param WC_Product
	 *
	 * @throws Exception
	 */
	public function read( &$product ) {

		add_filter(
			'woocommerce_is_purchasable',
			function () {
				return true;
			},
			10,
			1
		);

		$product->set_defaults();

		$post_types = array( apply_filters( 'stm_listings_post_type', 'listings' ) );

		if ( class_exists( '\STMMultiListing' ) ) {
			$slugs = \STMMultiListing::stm_get_listing_type_slugs();
			if ( ! empty( $slugs ) ) {
				$post_types = array_merge( $post_types, $slugs );
			}
		}

		$post_types[] = 'product';
		$post_object  = get_post( $product->get_id() );

		if ( ! $product->get_id() || ! ( $post_object ) || ! ( in_array( $post_object->post_type, $post_types, true ) ) ) {
			throw new Exception( __( 'Invalid product.', 'stm_vehicles_listing' ) );
		}

		$product->set_id( $post_object->ID );

		$product->set_props(
			array(
				'product_id'        => $post_object->ID,
				'name'              => $post_object->post_title,
				'slug'              => $post_object->post_name,
				'date_created'      => 0 < $post_object->post_date_gmt ? wc_string_to_timestamp( $post_object->post_date_gmt ) : null,
				'date_modified'     => 0 < $post_object->post_modified_gmt ? wc_string_to_timestamp( $post_object->post_modified_gmt ) : null,
				'status'            => $post_object->post_status,
				'description'       => $post_object->post_content,
				'short_description' => $post_object->post_excerpt,
				'parent_id'         => $post_object->post_parent,
				'menu_order'        => $post_object->menu_order,
				'reviews_allowed'   => 'open' === $post_object->comment_status,
				'post_type'         => $post_object->post_type,
			)
		);

		$this->read_attributes( $product );
		$this->read_downloads( $product );
		$this->read_visibility( $product );
		$this->read_product_data( $product );
		$this->read_extra_data( $product );
		$product->set_object_read( true );

		do_action( 'woocommerce_product_read', $product->get_id() );
	}

	/**
	 * Get the product type based on product ID.
	 *
	 * @param int $product_id
	 *
	 * @return bool|string
	 * @since 3.0.0
	 */

	public function get_product_type( $product_id ) {
		$cache_key    = WC_Cache_Helper::get_cache_prefix( 'product_' . $product_id ) . '_type_' . $product_id;
		$product_type = wp_cache_get( $cache_key, 'products' );

		if ( $product_type ) {
			return $product_type;
		}

		$post_type  = get_post_type( $product_id );
		$post_types = array( apply_filters( 'stm_listings_post_type', 'listings' ) );

		if ( class_exists( '\STMMultiListing' ) ) {
			$slugs = \STMMultiListing::stm_get_listing_type_slugs();
			if ( ! empty( $slugs ) ) {
				$post_types = array_merge( $post_types, $slugs );
			}
		}

		$post_types[] = 'product';

		if ( 'product_variation' === $post_type ) {
			$product_type = 'variation';
		} elseif ( in_array( $post_type, $post_types, true ) ) {
			$terms        = get_the_terms( $product_id, 'product_type' );
			$product_type = ! empty( $terms ) && ! is_wp_error( $terms ) ? sanitize_title( current( $terms )->name ) : 'simple';
		} else {
			$product_type = false;
		}

		wp_cache_set( $cache_key, $product_type, 'products' );

		return $product_type;
	}
}

class STMWCOrderItemProduct extends WC_Order_Item_Product { //phpcs:ignore

	public function set_product_id( $value ) {
		$post_types = array( apply_filters( 'stm_listings_post_type', 'listings' ) );

		if ( class_exists( '\STMMultiListing' ) ) {
			$slugs = \STMMultiListing::stm_get_listing_type_slugs();
			if ( ! empty( $slugs ) ) {
				$post_types = array_merge( $post_types, $slugs );
			}
		}

		if ( $value > 0 && ! in_array( get_post_type( absint( $value ) ), $post_types, true ) ) {
			$this->error( 'order_item_product_invalid_product_id', __( 'Invalid product ID', 'woocommerce' ) );
		}

		$this->set_prop( 'product_id', absint( $value ) );
	}
}

if ( ( stm_is_motors_theme() && apply_filters( 'motors_vl_perpay', false ) ) || apply_filters( 'is_mvl_pro', false ) ) {
	add_filter( 'woocommerce_data_stores', 'mvl_motors_woocommerce_data_stores', 10, 1 );
	add_filter( 'woocommerce_checkout_create_order_line_item_object', 'mvl_create_order_line_item_object', 20, 3 );
	add_action( 'woocommerce_checkout_create_order_line_item', 'mvl_woocommerce_checkout_create_order_line_item', 20, 3 );
	add_filter( 'woocommerce_get_order_item_classname', 'mvl_woocommerce_get_order_item_classname', 20, 3 );
	add_filter( 'woocommerce_payment_complete_order_status', 'mvl_woocommerce_payment_complete_order_status', 20, 3 );
}

function mvl_woocommerce_payment_complete_order_status( $status, $order_id, $order ) {
	if ( ! $order->get_id() ) { // Order must exist.
		return $status;
	}

	if ( 'completed' === $status ) {
		return $status;
	}

	// Get order items
	$order_items = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );

	// Iterate over order items and get product ids
	foreach ( $order_items as $order_item ) {
		$is_listing = $order_item->get_meta( '_stm-motors-listing' );

		if ( 'yes' !== $is_listing ) {
			continue;
		}

		$status = 'completed';
	}

	return $status;
}

function mvl_woocommerce_payment_complete( $order_id ) {
	// Load order object
	$order = wc_get_order( $order_id );

	// Check if order was loaded
	if ( ! $order ) {
		return;
	}

	$order_status = $order->get_status();

	// Get order items
	$order_items = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );

	// Iterate over order items and get product ids
	foreach ( $order_items as $order_item ) {
		$product = apply_filters( 'woocommerce_order_item_product', $order_item->get_product(), $order_item );

		if ( 'product' !== get_post_type( $product->get_id() ) ) {
			$pay_per_listing = $order_item->get_meta( '_order_pay_per_listing' );

			if ( 'yes' !== $pay_per_listing ) {
				continue;
			}

			$product = apply_filters( 'woocommerce_order_item_product', $order_item->get_product(), $order_item );

			if ( ! $product ) {
				continue;
			}

			$to      = get_bloginfo( 'admin_email' );
			$args    = array(
				'first_name'    => $order->get_billing_first_name(),
				'last_name'     => $order->get_billing_last_name(),
				'email'         => $order->get_billing_email(),
				'order_id'      => $order->get_id(),
				'order_status'  => $order_status,
				'listing_title' => $product->get_title(),
				'car_id'        => $product->get_id(),
			);
			$subject = stm_generate_subject_view( 'pay_per_listing', $args );
			$body    = stm_generate_template_view( 'pay_per_listing', $args );

			do_action( 'stm_wp_mail', $to, $subject, $body, '' );
		}
	}
}

function mvl_create_order_line_item_object( $item, $cart_item_key, $values ) {
	$product = $values['data'];

	$post_types = array( apply_filters( 'stm_listings_post_type', 'listings' ) );

	if ( class_exists( '\STMMultiListing' ) ) {
		$slugs = \STMMultiListing::stm_get_listing_type_slugs();
		if ( ! empty( $slugs ) ) {
			$post_types = array_merge( $post_types, $slugs );
		}
	}

	if ( in_array( get_post_type( $product->get_id() ), $post_types, true ) ) {
		return new STMWCOrderItemProduct();
	}

	return $item;
}

function mvl_woocommerce_get_order_item_classname( $classname, $item_type, $order_item_id ) {
	global $wpdb;

	$prepare            = $wpdb->prepare(
		"SELECT meta_value FROM {$wpdb->prefix}woocommerce_order_itemmeta WHERE order_item_id = %d AND meta_key = %s",
		$order_item_id,
		'_stm-motors-listing'
	);
	$is_pay_per_listing = $wpdb->get_var( $prepare ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared

	if ( 'yes' === $is_pay_per_listing && 'line_item' === $item_type ) {
		$classname = 'STMWCOrderItemProduct';
	}

	return $classname;
}

function mvl_woocommerce_checkout_create_order_line_item( $item, $cart_item_key, $values ) {
	$product = $values['data'];

	$post_types = array( apply_filters( 'stm_listings_post_type', 'listings' ) );

	if ( class_exists( '\STMMultiListing' ) ) {
		$slugs = \STMMultiListing::stm_get_listing_type_slugs();
		if ( ! empty( $slugs ) ) {
			$post_types = array_merge( $post_types, $slugs );
		}
	}

	$product_id = $product->get_id();

	if ( in_array( get_post_type( $product_id ), $post_types, true ) ) {
		$item->update_meta_data( '_stm-motors-listing', 'yes' );

		if ( ! empty( get_post_meta( $product_id, 'car_make_featured_status', true ) ) ) {
			update_post_meta( $product_id, 'car_make_featured_status', 'processing' );
			$item->update_meta_data( '_car_make_featured', 'yes' );
		} elseif ( ! empty( get_post_meta( $product_id, 'is_sell_online_status', true ) ) ) {
			update_post_meta( $product_id, 'is_sell_online_status', 'processing' );
			$item->update_meta_data( '_is_sell_online_car', 'yes' );
		} else {
			update_post_meta( $product_id, 'pay_per_order_id', $item->get_order_id() );
			$item->update_meta_data( '_order_pay_per_listing', 'yes' );
		}
	}
}

function mvl_motors_woocommerce_data_stores( $stores ) {
	$stores['product'] = 'STMListingDataStoreCPT';

	return $stores;
}

// check car stock amount before adding to cart
add_filter( 'woocommerce_add_to_cart_validation', 'mvl_check_car_stock_amount_before_adding_to_cart', 10, 2 );
function mvl_check_car_stock_amount_before_adding_to_cart( $passed, $product_id ) {

	if ( stm_is_motors_theme() && ! apply_filters( 'motors_vl_perpay_stock', false ) ) {
		return $passed;
	}

	$car_stock = (int) get_post_meta( $product_id, 'stm_car_stock', true );

	if ( get_post_type( $product_id ) === apply_filters( 'stm_listings_post_type', 'listings' ) && $car_stock <= 0 ) {
		$passed = false;
		wc_add_notice( __( 'Sorry, item is out of stock and cannot be added to cart', 'stm_vehicles_listing' ), 'error' );
	}

	return $passed;
}

// order completed
add_action( 'woocommerce_order_status_completed', 'mvl_woo_order_status_positive' );
function mvl_woo_order_status_positive( $order_id ) {
	// Load order object
	$order = wc_get_order( $order_id );

	// Check if order was loaded
	if ( ! $order ) {
		return;
	}

	// Get order items
	$order_items = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );

	// Iterate over order items and get product ids
	foreach ( $order_items as $order_item ) {
		$is_sell_online = $order_item->get_meta( '_is_sell_online_car' );

		if ( 'yes' !== $is_sell_online ) {
			continue;
		}

		$product = apply_filters( 'woocommerce_order_item_product', $order_item->get_product(), $order_item );

		if ( ! $product ) {
			continue;
		}

		$vehicle_id = $product->get_id();

		if ( ! empty( $vehicle_id ) ) {
			$car_stock = (int) get_post_meta( $vehicle_id, 'stm_car_stock', true );

			if ( is_numeric( $car_stock ) ) {
				if ( 1 === $car_stock ) {
					update_post_meta( $vehicle_id, 'car_mark_as_sold', 'on' );
				}

				update_post_meta( $vehicle_id, 'stm_car_stock', $car_stock - 1 );
			}
		}
	}
}

// order canceled
add_action( 'woocommerce_order_status_failed', 'mvl_woo_order_status_negative' );
add_action( 'woocommerce_order_status_refunded', 'mvl_woo_order_status_negative' );
add_action( 'woocommerce_order_status_cancelled', 'mvl_woo_order_status_negative' );
function mvl_woo_order_status_negative( $order_id ) {
	// Load order object
	$order = wc_get_order( $order_id );

	// Check if order was loaded
	if ( ! $order ) {
		return;
	}

	// Get order items
	$order_items = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );

	// Iterate over order items and get product ids
	foreach ( $order_items as $order_item ) {
		$is_sell_online = $order_item->get_meta( '_is_sell_online_car' );

		if ( 'yes' !== $is_sell_online ) {
			continue;
		}

		$product = apply_filters( 'woocommerce_order_item_product', $order_item->get_product(), $order_item );

		if ( ! $product ) {
			continue;
		}

		$vehicle_id = $product->get_id();

		if ( ! empty( $vehicle_id ) ) {
			$car_stock = (int) get_post_meta( $vehicle_id, 'stm_car_stock', true );

			if ( is_numeric( $car_stock ) ) {
				if ( ! empty( get_post_meta( $vehicle_id, 'car_mark_as_sold', true ) ) ) {
					update_post_meta( $vehicle_id, 'car_mark_as_sold', '' );
				}

				update_post_meta( $vehicle_id, 'stm_car_stock', $car_stock + 1 );
			}
		}
	}
}
