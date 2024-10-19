<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$middle_infos = apply_filters( 'stm_get_car_archive_listings', array() );

if ( ! empty( $middle_infos ) ) : ?>
	<?php
	foreach ( $middle_infos as $middle_info ) :

		$data_meta  = get_post_meta( get_the_ID(), $middle_info['slug'], true );
		$data_value = '';


		//Item option has 3 views - numeric (single value in post meta, single value in term meta and multiply terms).
		if ( ! apply_filters( 'is_empty_value', $data_meta ) && 'price' !== $middle_info['slug'] ) :
			if ( ! empty( $middle_info['numeric'] ) && $middle_info['numeric'] ) :
				$data_value = ucfirst( $data_meta );
			else :
				$data_meta_array = explode( ',', $data_meta );
				$data_value      = array();
				$terms           = get_the_terms( get_the_ID(), $middle_info['slug'] );
				if ( ! empty( $terms ) ) {
					foreach ( $terms as $_term ) {
						$data_value[] = $_term->name;
					}
				}
			endif;
		endif;
		?>
		<?php if ( ! apply_filters( 'is_empty_value', $data_meta ) && '' !== $data_value ) : ?>
			<?php if ( 'price' !== $middle_info['slug'] && ! apply_filters( 'is_empty_value', $data_meta ) ) : ?>
			<div class="meta-middle-unit
				<?php
				if ( ! empty( $middle_info['font'] ) ) {
					echo esc_attr( 'font-exists' );
				}
				?>
				<?php echo esc_attr( $middle_info['slug'] ); ?>">
				<?php if ( ! empty( $middle_info['font'] ) ) : ?>
					<div class="icon"><i class="<?php echo esc_attr( $middle_info['font'] ); ?>"></i></div>
				<?php endif; ?>
				<div class="meta-middle-unit-top">
					<div class="name"><?php echo esc_html( $middle_info['single_name'] ); ?></div>
					<div class="value h5">
						<?php
						if ( is_array( $data_value ) ) {
							echo esc_attr( implode( ', ', $data_value ) );
						} else {
							echo esc_attr( $data_value );
						}
						?>
					</div>
				</div>
			</div>
		<?php endif; ?>
	<?php endif; ?>
	<?php endforeach; ?>
<?php endif; ?>
