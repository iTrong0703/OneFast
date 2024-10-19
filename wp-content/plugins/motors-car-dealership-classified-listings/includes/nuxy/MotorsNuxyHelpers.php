<?php

namespace MotorsNuxy;

class MotorsNuxyHelpers {
	public function __construct() {
		add_filter( 'wpcfto_check_is_pro_field', array( $this, 'is_pro' ) );

		add_filter(
			'wpcfto_field_pro_banner',
			function () {
				return STM_LISTINGS_PATH . '/includes/nuxy/unlock-banner-component.php';
			}
		);

		add_filter( 'stm_wpcfto_single_field_classes', array( $this, 'wpcfto_field_addon_state' ), 10, 3 );

		add_action( 'stm_wpcfto_single_field_before_start', array( $this, 'start_field' ), 10, 6 );

		add_filter(
			'wpcfto_field_nuxy-hidden',
			function () {
				return STM_LISTINGS_PATH . '/includes/nuxy/custom-fields/nuxy-hidden.php';
			}
		);
	}

	public function is_pro( $pro ) {
		return defined( 'STM_LISTINGS_PRO_PATH' );
	}

	public function wpcfto_field_addon_state( $classes, $field_name, $field ) {
		$is_addon = ( ! empty( $field['pro'] ) && empty( $is_pro ) );

		if ( 'addons' === $field['type'] ) {
			$is_addon = false;
		}

		$addon_state = apply_filters( "wpcfto_addon_option_{$field_name}", '' );

		if ( empty( $addon_state ) ) {
			$is_addon = false;
		}

		/*CHECK IF ADDON IS ENABLED*/
		if ( $this->motors_vl_check_addon_enabled( $addon_state ) ) {
			$is_addon = false;
		}

		if ( $is_addon ) {
			$classes[] = 'is_pro is_pro_in_addon';
		}

		if ( ! empty( $addon_state ) ) {
			$classes[] = "motors_vl_addon_group_settings_{$addon_state}";
		}

		return $classes;
	}

	public function is_addon( $classes, $field_name, $field ) {
		return in_array( 'is_pro is_pro_in_addon', $classes, true );
	}

	public function addon_state( $field_name ) {
		$addon_state = apply_filters( "wpcfto_addon_option_{$field_name}", '' );

		return $addon_state;
	}

	public function motors_vl_check_addon_enabled( $addon_name ) {
		if ( empty( $addon_name ) ) {
			return false;
		}

		$addons = get_option( 'motors_vl_addons' );

		return ( ! empty( $addons[ $addon_name ] ) && 'on' === $addons[ $addon_name ] );
	}

	public function start_field( $classes, $field_name, $field, $is_pro, $pro_url, $disable ) {
		$is_addon    = $this->is_addon( $classes, $field_name, $field );
		$addon_state = $this->addon_state( $field_name );

		if ( isset( $field['label'] ) && ! empty( $field['label'] ) ) {
			$converted_label = preg_replace( '/[^\p{L}\p{N}_]+/u', '_', $field['label'] );
		} else {
			$converted_label = '';
		}

		$field_label = rtrim( strtolower( $converted_label ), '_' );

		if ( empty( $pro_url ) ) {
			$pro_url = admin_url( 'admin.php?page=mvl-go-pro' );
		} else {
			$pro_url = admin_url( 'admin.php?page=mvl-go-pro&source=' . $field_label );
		}

		if ( 'is_pro' === $is_pro ) { ?>
			<div class="field_overlay"></div>
			<!--We have no pro plugin active-->
			<span class="pro-notice">
				<?php esc_html_e( 'Available in ', 'motors-car-dealership-classified-listings-pro' ); ?>
				<a href="<?php echo esc_url( $pro_url ); ?>" target="_blank"><?php esc_html_e( 'Pro Version', 'motors-car-dealership-classified-listings-pro' ); ?></a>
			</span>
			<?php
		}

		if ( $is_addon ) {
			/*We have pro plugin but addon seems to be disabled*/
			?>
			<div class="field_overlay"></div>
			<span class="pro-notice">
				<a href="#" @click.prevent="enableAddon($event, '<?php echo esc_attr( $addon_state ); ?>')">
					<i class="fa fa-power-off"></i>
				<?php esc_html_e( 'Enable addon', 'motors-car-dealership-classified-listings-pro' ); ?>
				</a>
			</span>
			<?php
		}
	}
}
