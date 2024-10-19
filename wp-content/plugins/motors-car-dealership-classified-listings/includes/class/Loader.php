<?php

namespace MotorsVehiclesListing;

use MotorsVehiclesListing\Api\ApiPosts;
use MotorsVehiclesListing\Helper\FilterHelper;


class Loader {
	public function __construct() {
		/** register api */
		$this->register_api();
		$this->add_filters();
	}
	protected function add_filters() {
		add_filter( 'stm_listings_v8_filter', array( new FilterHelper(), 'stm_listings_v8_filter' ), 10, 2 );
	}

	private function register_api() {
		$post = new ApiPosts();
		$post->init();
	}
}

new Loader();
