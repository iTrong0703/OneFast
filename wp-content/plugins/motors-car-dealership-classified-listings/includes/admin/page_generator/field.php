<?php
/**
 * @var $field
 * @var $field_id
 * @var $field_value
 * @var $field_label
 * @var $field_name
 * @var $field_data
 * @var $section_name
 */
wp_enqueue_script( 'page-generator', STM_LISTINGS_URL . '/includes/admin/page_generator/js/page_generator.js', array(), STM_LISTINGS_V, true );
wp_enqueue_style( 'page-generator', STM_LISTINGS_URL . '/includes/admin/page_generator/css/page_generator.css', array(), STM_LISTINGS_V );
$has_pages = mvl_has_generated_pages( $field_data['options'] );
if ( ! $has_pages ) { ?>
	<mvl_page_generator v-bind:field_data="<?php echo esc_attr( $field ); ?>['options']" inline-template>
		<div class="mvl_page_generator">
			<p><?php esc_html_e( 'Create pages automatically. Dont forget to re-save permalinks after operation.', 'stm_vehicles_listing' ); ?></p>
			<a href="#" class="button" @click.prevent="generatePages" v-bind:class="{'loading' : loading}">
				<span><?php esc_html_e( 'Generate pages', 'stm_vehicles_listing' ); ?></span>
				<i class="fa fa-sync"></i>
			</a>
		</div>
	</mvl_page_generator>
	<?php
}
