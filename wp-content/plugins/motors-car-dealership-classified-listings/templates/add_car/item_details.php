<?php
/**
 * Shortcode attributes
 * @var $id
 * @var $taxonomies
 * @var $use_inputs
 * @var $show_listing_title
 */

defined( 'ABSPATH' ) || exit;

$data = apply_filters( 'stm_get_single_car_listings', array() );

$terms_args = array(
	'orderby'    => 'name',
	'order'      => 'ASC',
	'hide_empty' => false,
	'fields'     => 'all',
	'pad_counts' => true,
);

$vars = array(
	'id'                 => ( ! empty( $id ) ) ? $id : false,
	'show_listing_title' => ( ! empty( $show_listing_title ) ) ? $show_listing_title : false,
	'taxonomies'         => ( ! empty( $taxonomies ) ) ? $taxonomies : array(),
	'use_inputs'         => ( ! empty( $use_inputs ) ) ? $use_inputs : false,
);
?>

<div class="stm_add_car_form_1">
	<?php
		$vars['step_title']  = __( 'Listing Item Details', 'stm_vehicles_listing' );
		$vars['step_number'] = 1;
		do_action( 'stm_listings_load_template', 'add_car/step-title', $vars );

		do_action( 'stm_listings_load_template', 'add_car/required-fields', $vars );
	?>

	<div class="stm-form-1-end-unit clearfix">
		<?php
		if ( ! empty( $data ) && is_array( $taxonomies ) ) :
			foreach ( $data as $data_key => $data_unit ) :
				if ( ! in_array( $data_unit['slug'], $taxonomies, true ) ) :
					$tax_info = apply_filters( 'stm_vl_get_all_by_slug', array(), $data_unit['slug'] );
					$terms    = array();
					if ( empty( $tax_info['listing_taxonomy_parent'] ) ) {
						$terms = get_terms( $data_unit['slug'], $terms_args );
					}

					$field = 'name';
					$order = 'ASC';

					if ( ! empty( $tax_info['terms_filters_sort_by'] ) ) {
						if ( str_contains( $tax_info['terms_filters_sort_by'], 'count' ) ) {
							$field = 'count';
						}
						if ( str_contains( $tax_info['terms_filters_sort_by'], 'desc' ) ) {
							$order = 'DESC';
						}
					}

					$terms = wp_list_sort( $terms, $field, $order );

					$is_required = ( isset( $data_unit['required_filed'] ) && $data_unit['required_filed'] ) ? 'required' : '';
					?>
				<div class="stm-form-1-quarter">
					<?php
					if ( ! empty( $data_unit['numeric'] ) ) :
						$value = '';
						if ( ! empty( $id ) ) {
							$value = get_post_meta( $id, $data_unit['slug'], true );
						}

						$placeholder = sprintf(
							/* translators: %1$s single name, %2$s field affix */
							esc_attr__( 'Enter %1$s %2$s', 'stm_vehicles_listing' ),
							$data_unit['single_name'],
							( ! empty( $data_unit['number_field_affix'] ) ) ? '(' . $data_unit['number_field_affix'] . ')' : ''
						);
						?>

						<input
								type="number"
								class="form-control"
								name="stm_s_s_<?php echo esc_attr( $data_unit['slug'] ); ?>"
								value="<?php echo esc_attr( $value ); ?>"
								aria-label="<?php echo esc_attr( $placeholder ); ?>"
								placeholder="<?php echo esc_attr( $placeholder ); ?>"
						/>
						<?php
						else :
							$single_name = sprintf(
								/* translators: %1$s single name */
								esc_attr__( 'Select %1$s', 'stm_vehicles_listing' ),
								$data_unit['single_name']
							);
							$selected = '';
							if ( ! empty( $id ) ) {
								$selected = get_post_meta( $id, $data_unit['slug'], true );
							}
							?>
						<select name="stm_s_s_<?php echo esc_attr( $data_unit['slug'] ); ?>"
								aria-label="<?php echo esc_attr( $single_name ); ?>">
							<option value="" <?php selected( $selected, '' ); ?>>
								<?php echo esc_html( $single_name ); ?>
							</option>
							<?php
							if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) :
								foreach ( $terms as $_term ) :
									?>
									<option value="<?php echo esc_attr( $_term->slug ); ?>" <?php selected( $selected, $_term->slug ); ?>>
										<?php echo esc_html( $_term->name ); ?>
									</option>
									<?php
									endforeach;
								endif;
							?>
						</select>
					<?php endif; ?>
					<div class="stm-label">
						<?php if ( ! empty( $data_unit['font'] ) ) : ?>
							<i class="<?php echo esc_attr( $data_unit['font'] ); ?>"></i>
						<?php endif; ?>
						<?php echo esc_html( $data_unit['single_name'] ); ?>
					</div>
				</div>
					<?php
			endif;
		endforeach;
			?>

			<?php
			$vars = array();
			if ( ! empty( $id ) ) {
				$vars = array( 'id' => $id );
			}
			do_action( 'stm_listings_load_template', 'add_car/step_1_additional_fields', $vars );

			/**
			 * Pro Feature
			 * */
			do_action( 'motors_add_listing_location' );
			?>

		<?php endif; ?>
	</div>
</div>
