<?php

namespace MotorsVehiclesListing\Elementor\Nuxy;

class AddListingManager {
	public function __construct() {
		add_filter( 'me_add_car_form_settings_conf', array( $this, 'motors_config_map_tab_add_listing' ), 41, 1 );
	}

	public function motors_config_map_tab_add_listing( $global_conf ) {
		if ( apply_filters( 'stm_is_motors_theme', false ) && ! apply_filters( 'is_listing', false, array( 'listing_one_elementor', 'listing_two_elementor', 'listing_three_elementor', 'listing_four_elementor', 'listing_five_elementor' ) ) ) { //phpcs:ignore
			return $global_conf;
		}

		$conf = array(
			'add_listing' => array(
				'name'   => esc_html__( 'Add listing form', 'stm_vehicles_listing' ),
				'fields' => apply_filters( 'motors_add_listing_config', $this->motors_create_config() ),
			),
		);

		return $conf;
	}

	private function motors_create_config() {

		$conf = array_merge(
			$this->desc_slots_conf(),
			$this->listing_title(),
			$this->listing_details(),
			$this->listing_features(),
			$this->listing_gallery(),
			$this->listing_videos(),
			$this->listing_seller_note(),
			$this->listing_plans(),
			$this->listing_price(),
			$this->listing_register_login(),
			$this->sort_add_listing_steps_config(),
		);

		return $conf;
	}

	private function sort_add_listing_steps_config() {
		return array(
			'sorted_steps' => array(
				'type'        => 'sorter',
				'label'       => esc_html__( 'Arrange field order', 'stm_vehicles_listing' ),
				'description' => sprintf( esc_html__( 'Reorder how fields appear on the listing detail page. Keep the options with %s enabled so that the page works', 'stm_vehicles_listing' ), '<i class="fa fa-exclamation-triangle"></i>' ),
				'options'     => array(
					array(
						'id'      => 'enable_layouts',
						'name'    => esc_html__( 'Enable', 'stm_vehicles_listing' ),
						'options' => array(
							array(
								'id'    => 'item_details',
								'label' => esc_html__( 'Details', 'stm_vehicles_listing' ),
								'icon'  => 'fa fa-exclamation-triangle',
							),
							array(
								'id'    => 'item_features',
								'label' => esc_html__( 'Features', 'stm_vehicles_listing' ),
							),
							array(
								'id'    => 'item_gallery',
								'label' => esc_html__( 'Gallery', 'stm_vehicles_listing' ),
							),
							array(
								'id'    => 'item_videos',
								'label' => esc_html__( 'Videos', 'stm_vehicles_listing' ),
							),
							array(
								'id'    => 'item_seller_note',
								'label' => esc_html__( 'Seller Note', 'stm_vehicles_listing' ),
							),
							array(
								'id'    => 'item_price',
								'label' => esc_html__( 'Price', 'stm_vehicles_listing' ),
								'icon'  => 'fa fa-exclamation-triangle',
							),
							array(
								'id'    => 'item_plans',
								'label' => esc_html__( 'Plans', 'stm_vehicles_listing' ),
							),
						),
					),
					array(
						'id'      => 'disable_layouts',
						'name'    => esc_html__( 'Disable', 'stm_vehicles_listing' ),
						'options' => array(),
					),
				),
				'submenu'     => 'Layout builder',
			),
		);
	}

	private function desc_slots_conf() {
		return array(
			'addl_group_ds_title' => array(
				'type'             => 'group_title',
				'label'            => esc_html__( 'Listing description & availability', 'stm_vehicles_listing' ),
				'submenu'          => esc_html__( 'Listing creation form', 'stm_vehicles_listing' ),
				'description'      => esc_html__( 'Add a detailed description of the vehicle listing and specify the available slots ', 'stm_vehicles_listing' ),
				'preview'          => STM_LISTINGS_URL . '/assets/images/elementor/nuxy/desc_slots.png',
				'preview_position' => 'preview_bottom',
				'group'            => 'started',
			),
			'addl_title'          => array(
				'label'   => esc_html__( 'Title', 'stm_vehicles_listing' ),
				'type'    => 'text',
				'value'   => esc_html__( 'Build Your Ad', 'stm_vehicles_listing' ),
				'submenu' => esc_html__( 'Listing creation form', 'stm_vehicles_listing' ),
			),
			'addl_description'    => array(
				'label'   => esc_html__( 'Description', 'stm_vehicles_listing' ),
				'type'    => 'editor',
				'submenu' => esc_html__( 'Listing creation form', 'stm_vehicles_listing' ),
			),
			'addl_show_slots'     => array(
				'label'   => esc_html__( 'Available Slots', 'stm_vehicles_listing' ),
				'type'    => 'checkbox',
				'value'   => true,
				'submenu' => esc_html__( 'Listing creation form', 'stm_vehicles_listing' ),
			),
			'addl_slots_title'    => array(
				'label'      => esc_html__( 'Title for the field', 'stm_vehicles_listing' ),
				'type'       => 'text',
				'value'      => esc_html__( 'Slots available', 'stm_vehicles_listing' ),
				'submenu'    => esc_html__( 'Listing creation form', 'stm_vehicles_listing' ),
				'group'      => 'ended',
				'dependency' => array(
					'key'   => 'addl_show_slots',
					'value' => 'not_empty',
				),
			),
		);
	}

	private function listing_title() {
		return array(
			'addl_group_lt_title' => array(
				'type'             => 'group_title',
				'label'            => esc_html__( 'Title', 'stm_vehicles_listing' ),
				'preview'          => STM_LISTINGS_URL . '/assets/images/elementor/nuxy/item_title.png',
				'preview_position' => 'preview_bottom',
				'submenu'          => esc_html__( 'Listing creation form', 'stm_vehicles_listing' ),
				'group'            => 'started',
			),
			'addl_car_title'      => array(
				'label'       => esc_html__( 'Custom Title', 'stm_vehicles_listing' ),
				'description' => esc_html__( 'Enable an input field for customizing the listing title. If autogeneration of the titles is enabled in the Listing info card settings, generated titles will be shown', 'stm_vehicles_listing' ),
				'type'        => 'checkbox',
				'value'       => false,
				'submenu'     => esc_html__( 'Listing creation form', 'stm_vehicles_listing' ),
				'group'       => 'ended',
			),
		);
	}

	private function listing_details() {

		return array(
			'addl_group_details_title' => array(
				'type'             => 'group_title',
				'label'            => esc_html__( 'Details', 'stm_vehicles_listing' ),
				'preview'          => STM_LISTINGS_URL . '/assets/images/elementor/nuxy/item_details.png',
				'preview_position' => 'preview_bottom',
				'submenu'          => esc_html__( 'Listing creation form', 'stm_vehicles_listing' ),
				'group'            => 'started',
			),
			'addl_required_fields'     => array(
				'label'       => esc_html__( 'Required Categories', 'stm_vehicles_listing' ),
				'description' => sprintf( esc_html__( 'Specify the categories under the Details section that must be filled out when creating a listing. Add new %s', 'stm_vehicles_listing' ), '<a href="' . admin_url( 'edit.php?post_type=listings&page=listing_categories' ) . '" target="_blank">' . esc_html__( 'category', 'stm_vehicles_listing' ) . '</a>' ),
				'type'        => 'multi_checkbox',
				'options'     => $this->get_main_taxonomies_to_fill(),
				'submenu'     => esc_html__( 'Listing creation form', 'stm_vehicles_listing' ),
			),
			'addl_number_as_input'     => array(
				'label'       => esc_html__( 'Convert numeric categories to input field', 'stm_vehicles_listing' ),
				'description' => esc_html__( 'Modify numeric required categories into input fields', 'stm_vehicles_listing' ),
				'type'        => 'checkbox',
				'value'       => true,
				'submenu'     => esc_html__( 'Listing creation form', 'stm_vehicles_listing' ),
			),
			'addl_show_registered'     => array(
				'label'       => esc_html__( 'Vehicle production date', 'stm_vehicles_listing' ),
				'description' => esc_html__( 'Include a field for entering date when vehicles were manufactured', 'stm_vehicles_listing' ),
				'type'        => 'checkbox',
				'value'       => true,
				'submenu'     => esc_html__( 'Listing creation form', 'stm_vehicles_listing' ),
			),
			'addl_show_vin'            => array(
				'label'       => esc_html__( 'VIN', 'stm_vehicles_listing' ),
				'description' => esc_html__( 'Include a field for entering VIN for detailed listing information', 'stm_vehicles_listing' ),
				'type'        => 'checkbox',
				'value'       => true,
				'submenu'     => esc_html__( 'Listing creation form', 'stm_vehicles_listing' ),
			),
			'addl_show_history'        => array(
				'label'       => esc_html__( 'History', 'stm_vehicles_listing' ),
				'description' => esc_html__( 'Add a field to enter information about the vehicle history', 'stm_vehicles_listing' ),
				'type'        => 'checkbox',
				'value'       => true,
				'submenu'     => esc_html__( 'Listing creation form', 'stm_vehicles_listing' ),
			),
			'addl_history_report'      => array(
				'label'       => esc_html__( 'Services to check history', 'stm_vehicles_listing' ),
				'description' => esc_html__( 'Specify the allowed services to add links to the reports, separated by commas, such as Carfax, AutoCheck, etc.', 'stm_vehicles_listing' ),
				'type'        => 'text',
				'value'       => 'Carfax, AutoCheck',
				'submenu'     => esc_html__( 'Listing creation form', 'stm_vehicles_listing' ),
				'dependency'  => array(
					'key'   => 'addl_show_history',
					'value' => 'not_empty',
				),
			),
			'addl_details_location'    => array(
				'label'   => esc_html__( 'Location', 'stm_vehicles_listing' ),
				'type'    => 'checkbox',
				'value'   => true,
				'submenu' => esc_html__( 'Listing creation form', 'stm_vehicles_listing' ),
				'group'   => 'ended',
			),
		);
	}

	private function listing_features() {
		return array(
			'addl_group_features_setting_title' => array(
				'type'             => 'group_title',
				'label'            => esc_html__( 'Features settings', 'stm_vehicles_listing' ),
				'description'      => wp_kses_post( 'Configure settings related to the features section of the listing, such as adding or editing Features List' ),
				'preview'          => STM_LISTINGS_URL . '/assets/images/elementor/nuxy/item_features.png',
				'preview_position' => 'preview_bottom',
				'submenu'          => esc_html__( 'Listing creation form', 'stm_vehicles_listing' ),
			),
		);
	}

	private function listing_gallery() {
		return array(
			'addl_group_gallery_title' => array(
				'type'             => 'group_title',
				'label'            => esc_html__( 'Image gallery', 'stm_vehicles_listing' ),
				'description'      => esc_html__( 'Let users upload images for vehicle listings', 'stm_vehicles_listing' ),
				'preview'          => STM_LISTINGS_URL . '/assets/images/elementor/nuxy/item_gallery.png',
				'preview_position' => 'preview_bottom',
				'submenu'          => esc_html__( 'Listing creation form', 'stm_vehicles_listing' ),
				'group'            => 'started',
			),
			'addl_gallery_content'     => array(
				'type'    => 'editor',
				'label'   => esc_html__( 'Description', 'stm_vehicles_listing' ),
				'submenu' => esc_html__( 'Listing creation form', 'stm_vehicles_listing' ),
				'group'   => 'ended',
			),
		);
	}

	private function listing_videos() {
		return array(
			'addl_group_video_title' => array(
				'type'             => 'group_title',
				'label'            => esc_html__( 'Video gallery', 'stm_vehicles_listing' ),
				'description'      => esc_html__( 'Let users upload videos for vehicle listings', 'stm_vehicles_listing' ),
				'preview'          => STM_LISTINGS_URL . '/assets/images/elementor/nuxy/item_videos.png',
				'preview_position' => 'preview_bottom',
				'submenu'          => esc_html__( 'Listing creation form', 'stm_vehicles_listing' ),
				'group'            => 'started',
			),
			'addl_video_content'     => array(
				'type'    => 'editor',
				'label'   => esc_html__( 'Description', 'stm_vehicles_listing' ),
				'submenu' => esc_html__( 'Listing creation form', 'stm_vehicles_listing' ),
				'group'   => 'ended',
			),
		);
	}

	private function listing_seller_note() {
		return array(
			'addl_group_seller_note_title' => array(
				'type'             => 'group_title',
				'label'            => esc_html__( 'Seller\'s notes', 'stm_vehicles_listing' ),
				'description'      => esc_html__( 'Include a section for sellers to provide additional information or special notes about the vehicle.', 'stm_vehicles_listing' ),
				'preview'          => STM_LISTINGS_URL . '/assets/images/elementor/nuxy/item_seller_note.png',
				'preview_position' => 'preview_bottom',
				'submenu'          => esc_html__( 'Listing creation form', 'stm_vehicles_listing' ),
				'group'            => 'started',
			),
			'addl_seller_note_content'     => array(
				'type'        => 'editor',
				'label'       => esc_html__( 'Template Phrases', 'stm_vehicles_listing' ),
				'description' => esc_html__( 'Enter phrases, separated by a comma. Example - (Excellent condition, Always garaged, etc)', 'motors-elementor_widgets' ),
				'submenu'     => esc_html__( 'Listing creation form', 'stm_vehicles_listing' ),
				'group'       => 'ended',
			),
		);
	}

	private function listing_price() {
		return array(
			'addl_group_price_title' => array(
				'type'             => 'group_title',
				'label'            => esc_html__( 'Price', 'stm_vehicles_listing' ),
				'description'      => esc_html__( 'Include a section to enter the price details of the vehicle', 'stm_vehicles_listing' ),
				'preview'          => STM_LISTINGS_URL . '/assets/images/elementor/nuxy/item_price.png',
				'preview_position' => 'preview_bottom',
				'submenu'          => esc_html__( 'Listing creation form', 'stm_vehicles_listing' ),
				'group'            => 'started',
			),
			'addl_price_title'       => array(
				'type'    => 'text',
				'label'   => esc_html__( 'Title', 'stm_vehicles_listing' ),
				'submenu' => esc_html__( 'Listing creation form', 'stm_vehicles_listing' ),
			),
			'addl_price_label'       => array(
				'type'    => 'text',
				'label'   => esc_html__( 'Price Label', 'stm_vehicles_listing' ),
				'submenu' => esc_html__( 'Listing creation form', 'stm_vehicles_listing' ),
				'preview' => STM_LISTINGS_URL . '/assets/images/elementor/nuxy/tooltip_price.jpg',
			),
			'addl_sale_price'        => array(
				'type'        => 'checkbox',
				'label'       => esc_html__( 'Sale price', 'stm_vehicles_listing' ),
				'description' => esc_html__( 'Include a field to add a sale price', 'stm_vehicles_listing' ),
				'submenu'     => esc_html__( 'Listing creation form', 'stm_vehicles_listing' ),
			),
			'addl_sale_price_label'  => array(
				'type'        => 'text',
				'label'       => esc_html__( 'Sale price label', 'stm_vehicles_listing' ),
				'description' => esc_html__( 'Add a sale price label', 'stm_vehicles_listing' ),
				'submenu'     => esc_html__( 'Listing creation form', 'stm_vehicles_listing' ),
				'preview'     => STM_LISTINGS_URL . '/assets/images/elementor/nuxy/tooltip_sale.jpg',
				'dependency'  => array(
					'key'   => 'addl_sale_price',
					'value' => 'not_empty',
				),
			),
			'addl_custom_label'      => array(
				'type'        => 'checkbox',
				'label'       => esc_html__( 'Custom price label', 'stm_vehicles_listing' ),
				'description' => esc_html__( 'Add a field to customize the label to display price details in the listing', 'stm_vehicles_listing' ),
				'submenu'     => esc_html__( 'Listing creation form', 'stm_vehicles_listing' ),
			),
			'addl_price_desc'        => array(
				'type'         => 'editor',
				'label'        => esc_html__( 'Description', 'stm_vehicles_listing' ),
				'submenu'      => esc_html__( 'Listing creation form', 'stm_vehicles_listing' ),
				'group'        => 'ended',
				'dependencies' => '&&',
				'dependency'   => array(
					array(
						'key'   => 'addl_sale_price',
						'value' => 'empty',
					),
					array(
						'key'   => 'addl_custom_label',
						'value' => 'empty',
					),
				),
			),
		);
	}

	private function listing_plans() {
		if ( class_exists( 'Subscriptio' ) || class_exists( 'RP_SUB' ) ) {
			return array(
				'addl_group_plans_title' => array(
					'type'             => 'group_title',
					'label'            => esc_html__( 'Subscription Plans', 'stm_vehicles_listing' ),
					'description'      => esc_html__( 'Displays in accordance with Monetization > Subscription model settings.', 'stm_vehicles_listing' ),
					'preview'          => STM_LISTINGS_URL . '/assets/images/elementor/nuxy/item_plan.png',
					'preview_position' => 'preview_bottom',
					'icon'             => 'fa fa-clock',
					'submenu'          => esc_html__( 'Listing creation form', 'stm_vehicles_listing' ),
				),
			);
		}

		return array();
	}

	private function listing_register_login() {
		return array(
			'addl_group_reg_login_title' => array(
				'type'        => 'group_title',
				'label'       => esc_html__( 'User registration/login', 'stm_vehicles_listing' ),
				'description' => esc_html__( 'Provide a title, description, and terms & conditions for users to register or log in when creating a listing', 'stm_vehicles_listing' ),
				'submenu'     => esc_html__( 'Listing creation form', 'stm_vehicles_listing' ),
				'group'       => 'started',
			),
			'addl_reg_log_title'         => array(
				'type'    => 'text',
				'label'   => esc_html__( 'Title', 'stm_vehicles_listing' ),
				'submenu' => esc_html__( 'Listing creation form', 'stm_vehicles_listing' ),
			),
			'addl_reg_log_desc'          => array(
				'type'    => 'textarea',
				'label'   => esc_html__( 'Description', 'stm_vehicles_listing' ),
				'submenu' => esc_html__( 'Listing creation form', 'stm_vehicles_listing' ),
			),
			'addl_reg_log_link'          => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Terms & Conditions', 'stm_vehicles_listing' ),
				'submenu' => esc_html__( 'Listing creation form', 'stm_vehicles_listing' ),
				'options' => $this->get_page_list(),
				'group'   => 'ended',
			),
		);
	}

	private function get_page_list() {
		$pages = get_pages();

		$p_list = array();
		foreach ( $pages as $page ) {
			$p_list[ $page->ID ] = $page->post_title;
		}

		return $p_list;
	}

	private function get_main_taxonomies_to_fill() {
		$filter_options = apply_filters( 'stm_get_single_car_listings', array() );

		$taxonomies = array();

		if ( ! empty( $filter_options ) ) {
			foreach ( $filter_options as $filter_option ) {
				$taxonomies[ $filter_option['slug'] ] = $filter_option['single_name'];
			}
		}

		return $taxonomies;
	}
}
