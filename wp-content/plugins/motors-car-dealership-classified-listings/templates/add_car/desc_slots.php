<?php
$user = wp_get_current_user();

$_title      = apply_filters( 'motors_vl_get_nuxy_mod', '', 'addl_title' );
$desc        = apply_filters( 'motors_vl_get_nuxy_mod', '', 'addl_description' );
$slots_title = apply_filters( 'motors_vl_get_nuxy_mod', '', 'addl_slots_title' );
$show_slots  = apply_filters( 'motors_vl_get_nuxy_mod', false, 'addl_show_slots' );
?>
<div class="motors-desc-slots-wrapper">
	<div class="mdsw-left">
		<?php if ( ! empty( $_title ) ) : ?>
			<h3><?php echo esc_html( apply_filters( 'stm_dynamic_string_translation', $_title, 'Add Listing title' ) ); ?></h3>
		<?php endif; ?>
		<?php
		if ( ! empty( $desc ) ) {
			echo wp_kses_post( $desc );
		}
		?>
	</div>
	<div class="mdsw-right">
		<?php
		if ( ! empty( $user->ID ) && $show_slots ) :
			$limits = apply_filters(
				'stm_get_post_limits',
				array(
					'premoderation' => true,
					'posts_allowed' => 0,
					'posts'         => 0,
					'images'        => 0,
					'role'          => 'user',
				),
				$user->ID
			);
			?>
			<div class="stm-posts-available-number heading-font">
				<?php echo esc_html( apply_filters( 'stm_dynamic_string_translation', $slots_title, 'Slots Available title' ) ); ?>:
				<span><?php echo esc_html( $limits['posts'] ); ?></span>
			</div>
			<?php
		endif;
		?>
	</div>
</div>
