<?php

namespace Motors_Elementor_Widgets_Free\Widgets\WidgetManager;

use Motors_Elementor_Widgets_Free\Widgets\ListingSearchTabs;
use Motors_Elementor_Widgets_Free\Widgets\ImageCategories;
use Motors_Elementor_Widgets_Free\Widgets\InventorySearchFilter;
use Motors_Elementor_Widgets_Free\Widgets\InventorySortBy;
use Motors_Elementor_Widgets_Free\Widgets\InventoryViewType;
use Motors_Elementor_Widgets_Free\Widgets\InventorySearchResults;
use Motors_Elementor_Widgets_Free\Widgets\SingleListing\Title;
use Motors_Elementor_Widgets_Free\Widgets\SingleListing\Gallery;
use Motors_Elementor_Widgets_Free\Widgets\SingleListing\Features;
use Motors_Elementor_Widgets_Free\Widgets\SingleListing\DealerEmail;
use Motors_Elementor_Widgets_Free\Widgets\SingleListing\DealerPhoneNumber;
use Motors_Elementor_Widgets_Free\Widgets\SingleListing\OfferPriceButton;
use Motors_Elementor_Widgets_Free\Widgets\SingleListing\Similar;
use Motors_Elementor_Widgets_Free\Widgets\SingleListing\ListingDescription;
use Motors_Elementor_Widgets_Free\Widgets\ContactFormSeven;
use Motors_Elementor_Widgets_Free\Widgets\SingleListing\Classified\UserDataSimple;
use Motors_Elementor_Widgets_Free\Widgets\HeaderFooter\AddCarButton;
use Motors_Elementor_Widgets_Free\Widgets\HeaderFooter\CompareButton;
use Motors_Elementor_Widgets_Free\Widgets\HeaderFooter\ProfileButton;
use Motors_Elementor_Widgets_Free\Widgets\ListingsCompare;
use Motors_Elementor_Widgets_Free\Widgets\AddListing;
use Motors_Elementor_Widgets_Free\Widgets\DealersList;
use Motors_Elementor_Widgets_Free\Widgets\PricingPlan;
use Motors_Elementor_Widgets_Free\Widgets\ListingsGridTabs;
use Motors_Elementor_Widgets_Free\Widgets\LoginRegister;
use Motors_Elementor_Widgets_Free\Widgets\SingleListing\Classified\Title as TitleClassified;
use Motors_Elementor_Widgets_Free\Widgets\SingleListing\Classified\Price as PriceClassified;
use Motors_Elementor_Widgets_Free\Widgets\SingleListing\Classified\ListingData as ListingDataClassified;

class MotorsWidgetsManagerFree {

	private static $instance = array();

	protected function __construct() {
	}

	protected function __clone() {
	}

	public static function getInstance() {
		$cls = static::class;
		if ( ! isset( self::$instance[ $cls ] ) ) {
			self::$instance[ $cls ] = new static();
		}

		return self::$instance[ $cls ];
	}

	public function stm_ew_get_all_registered_widgets() {
		$widgets = array(
			ListingSearchTabs::class,
			ImageCategories::class,
			InventorySearchFilter::class,
			InventorySortBy::class,
			InventoryViewType::class,
			InventorySearchResults::class,
			Title::class,
			TitleClassified::class,
			PriceClassified::class,
			Gallery::class,
			ListingDataClassified::class,
			Features::class,
			ListingDescription::class,
			UserDataSimple::class,
			DealerEmail::class,
			DealerPhoneNumber::class,
			OfferPriceButton::class,
			Similar::class,
			ContactFormSeven::class,
			DealersList::class,
			PricingPlan::class,
			ListingsCompare::class,
			AddCarButton::class,
			CompareButton::class,
			ProfileButton::class,
			ListingsGridTabs::class,
			LoginRegister::class,
		);

		$widgets = array_merge(
			array(
				AddListing::class,
			),
			$widgets
		);

		return $widgets;
	}
}
