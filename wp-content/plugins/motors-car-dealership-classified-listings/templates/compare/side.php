<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<div class="col-md-3 col-sm-3 hidden-xs">
	<?php if ( ! empty( $filter_options ) ) : ?>
		<div class="compare-options">
			<h3 class="compare-side-title">
				<?php esc_html_e( 'Compare Vehicles' ); ?>
			</h3>
			<table>
				<?php foreach ( $filter_options as $filter_option ) : ?>
					<?php if ( 'price' !== $filter_option['slug'] ) { ?>
						<tr>
							<?php
								$compare_option = get_post_meta( get_the_id(), $filter_option['slug'], true );
								$compare_value  = 'compare-value-' . $filter_option['slug'];
							?>
							<td class="compare-value-hover"
								data-value="<?php echo esc_attr( $compare_value ); ?>">
								<div class="h5"><?php esc_html( $filter_option['single_name'] ); ?></div>
							</td>
						</tr>
					<?php }; ?>
				<?php endforeach; ?>
			</table>
		</div>
	<?php endif; ?>
</div>
