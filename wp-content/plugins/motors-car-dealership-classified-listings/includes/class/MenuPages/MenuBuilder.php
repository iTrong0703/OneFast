<?php

namespace MotorsVehiclesListing\MenuPages;

class MenuBuilder {

	public $menu_positions;

	public function __construct() {
		add_filter( 'custom_menu_order', array( $this, 'submenu_order' ) );
	}

	public function submenu_order( $menu_order ) {
		global $submenu;
		$this->menu_positions = apply_filters( 'mvl_submenu_positions', array() );
		asort( $this->menu_positions );
		$sort_by_position = $this->menu_positions;
		$for_sort         = $submenu['mvl_plugin_settings'];

		$matchedItems = array();

		foreach ( $for_sort as $item ) {
			if ( array_key_exists( $item[2], $sort_by_position ) ) {
				$matchedItems[ $item[2] ] = $item;
			}
		}

		$sortedMatchedItems = array();
		foreach ( $sort_by_position as $key => $value ) {
			if ( isset( $matchedItems[ $key ] ) ) {
				$sortedMatchedItems[] = $matchedItems[ $key ];
			}
		}

		$sortedIterator = 0;
		$finalArray     = array();

		foreach ( $for_sort as $item ) {
			if ( array_key_exists( $item[2], $sort_by_position ) && ! empty( $sortedMatchedItems[ $sortedIterator ] ) ) {
				$finalArray[] = $sortedMatchedItems[ $sortedIterator ];
				$sortedIterator ++;
			} else {
				$finalArray[] = $item;
			}
		}

		$submenu['mvl_plugin_settings'] = $finalArray;

		return $menu_order;
	}
}

