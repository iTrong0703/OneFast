<?php

if ( ! function_exists( 'output_multiple_currency_html' ) ) {
	function output_multiple_currency_html() {
		$currency_list = apply_filters( 'motors_vl_get_nuxy_mod', '', 'currency_list' );

		if ( ! empty( $currency_list ) && is_array( $currency_list ) ) {
			$current_currency = '';
			if ( isset( $_COOKIE['stm_current_currency'] ) ) {
				$mc               = explode( '-', sanitize_text_field( $_COOKIE['stm_current_currency'] ) );
				$current_currency = $mc[0];
			}

			$currency[0] = apply_filters( 'motors_vl_get_nuxy_mod', 'USD', 'price_currency_name' );
			$symbol[0]   = apply_filters( 'motors_vl_get_nuxy_mod', '$', 'price_currency' );
			$to[0]       = '1';

			if ( ! empty( $currency_list ) ) {
				foreach ( $currency_list as $k => $val ) {
					if ( ! empty( $val['currency'] ) && ! empty( $val['symbol'] ) && ! empty( $val['to'] ) ) {
						$currency[] = trim( $val['currency'] );
						$symbol[]   = $val['symbol'];
						$to[]       = trim( $val['to'] );
					}
				}
			}

			// translators: %s: Selected currency.
			$selected_currency_text  = __( 'Currency (%s)', 'stm_vehicles_listing' );
			$currency_switcher_class = apply_filters( 'stm_currency_switcher_class', 'pull-left currency-switcher' );
			$select_html             = '<div class="' . $currency_switcher_class . '">';
			$select_html            .= "<div class='stm-multiple-currency-wrap'><select data-translate='" . esc_attr( $selected_currency_text ) . "' data-class='stm-multi-currency' name='stm-multi-currency'>";
			$count_currency          = count( $currency );
			for ( $q = 0; $q < $count_currency; $q ++ ) {
				$selected      = ( $symbol[ $q ] === $current_currency ) ? 'selected' : '';
				$val           = html_entity_decode( $symbol[ $q ] ) . '-' . $to[ $q ];
				$currencyTitle = $currency[ $q ];

				if ( ! isset( $_COOKIE['stm_current_currency'] ) && 0 === $q || ! empty( $selected ) ) {
					$currencyTitle = sprintf( $selected_currency_text, $currency[ $q ] );
				}

				$select_html .= "<option value='{$val}' " . $selected . ">{$currencyTitle}</option>";
			}
			$select_html .= '</select></div>';
			$select_html .= '</div>';

			if ( count( $currency ) > 1 ) {
				return wp_kses(
					$select_html,
					array(
						'select' => array(
							'data-translate' => array(),
							'data-class'     => array(),
							'name'           => array(),
						),
						'option' => array(
							'value'    => array(),
							'selected' => array(),
						),
						'div'    => array(
							'class' => array(),
						),
					)
				);
			}
		}

		return false;
	}

	add_filter( 'output_multiple_currency_html', 'output_multiple_currency_html' );
	add_shortcode( 'output_multiple_currency_html', 'output_multiple_currency_html' );
}

if ( ! function_exists( 'getConverPrice' ) ) {
	function getConverPrice( $price ) {
		if ( isset( $_COOKIE['stm_current_currency'] ) ) {
			$cookie = explode( '-', sanitize_text_field( $_COOKIE['stm_current_currency'] ) );
			$cookie = ( ! empty( $cookie[1] ) ) ? $cookie[1] : 1;
			if ( is_numeric( $price ) && is_numeric( $cookie ) ) {
				$price = ( $price * $cookie );
			}
		}

		return $price;
	}

	add_filter( 'get_conver_price', 'getConverPrice' );
}

