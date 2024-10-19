<?php
/**
 * Shortcode attributes
 * @var $id
 * @var $taxonomies
 * @var $use_inputs
 * */

defined( 'ABSPATH' ) || exit;

if ( ! empty( $taxonomies ) ) :
	?>
	<div class="stm-form1-intro-unit">
		<div class="row">
			<?php
			foreach ( $taxonomies as $_taxonomy ) :
				$tax_info = apply_filters( 'stm_vl_get_all_by_slug', array(), $_taxonomy );

				$_option_default = sprintf(
					/* translators: %s name option */
					esc_html__( 'Select %s', 'stm_vehicles_listing' ),
					esc_html( apply_filters( 'stm_dynamic_string_translation', stm_get_name_by_slug( $_taxonomy ), 'Add A Car Step 1 Slug Name' ) )
				);

				$terms = array();

				if ( empty( $tax_info['listing_taxonomy_parent'] ) ) {
					$terms = apply_filters( 'stm_get_category_by_slug_all', array(), $_taxonomy, true );

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
				}

				$has_selected = '';

				if ( ! empty( $id ) ) {
					$post_terms = wp_get_post_terms( $id, $_taxonomy );
					if ( ! empty( $post_terms[0] ) ) {
						$has_selected = $post_terms[0]->slug;
					} elseif ( ! empty( $tax_info['slug'] ) ) {
						$has_selected = get_post_meta( $id, $tax_info['slug'], true );
					}
				}

				$number_field    = false;
				$number_as_input = apply_filters( 'motors_vl_get_nuxy_mod', '', 'addl_number_as_input' );

				if ( $number_as_input && ! empty( $tax_info['numeric'] ) && $tax_info['numeric'] ) {
					$number_field = true;
				}
				?>
					<div class="col-md-3 col-sm-3 stm-form-1-selects">
						<div class="stm-label heading-font" id="<?php printf( 'listing-%s', esc_html( $tax_info['slug'] ) ); ?>">
							<?php printf( '%s*', esc_html( stm_get_name_by_slug( $_taxonomy ) ) ); ?>
						</div>
					<?php
					if ( $number_field ) :
						$value = get_post_meta( $id, $tax_info['slug'], true );
						?>
							<input
									value="<?php echo esc_attr( $value ); ?>"
									min="0"
									type="number"
									name="stm_f_s[<?php echo esc_attr( $_taxonomy ); ?>]"
									aria-label="<?php echo esc_attr( apply_filters( 'stm_dynamic_string_translation', stm_get_name_by_slug( $_taxonomy ), 'Add A Car Step 1 Slug Name' ) ); ?>"
									aria-labelledby="<?php printf( 'listing-%s', esc_html( $tax_info['slug'] ) ); ?>"
									required />
						<?php else : ?>
							<select
									class="add_a_car-select add_a_car-select-<?php echo esc_attr( $_taxonomy ); ?>"
									data-class="stm_select_overflowed"
									data-selected="<?php echo esc_attr( $has_selected ); ?>"
									name="stm_f_s[<?php echo esc_attr( str_replace( '-', '_pre_', $_taxonomy ) ); ?>]"
									aria-label="<?php echo esc_attr( apply_filters( 'stm_dynamic_string_translation', stm_get_name_by_slug( $_taxonomy ), 'Add A Car Step 1 Slug Name' ) ); ?>"
									aria-labelledby="<?php printf( 'listing-%s', esc_html( $tax_info['slug'] ) ); ?>"
									required
							>
								<option value="" <?php selected( $has_selected, '' ); ?>>
									<?php echo esc_html( $_option_default ); ?>
								</option>
								<?php
								if ( ! empty( $terms ) ) :
									foreach ( $terms as $_term ) :
										?>
										<option value="<?php echo esc_attr( $_term->slug ); ?>" <?php selected( $has_selected, $_term->slug ); ?>>
											<?php echo esc_html( $_term->name ); ?>
										</option>
										<?php
										endforeach;
									endif;
								?>
							</select>
						<?php endif; ?>
					</div>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
endif;

require_once STM_LISTINGS_PATH . '/templates/add_car/binding.php';
