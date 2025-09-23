<?php

/**
 * Locate file
 */

if ( ! function_exists( 'vaathi_woo_locate_file' ) ) {

	function vaathi_woo_locate_file( $module ) {

		$plugin_file_path = apply_filters( 'vaathi_woo_locate_file', '', $module);

		if( $plugin_file_path ) {
			$file_path = $plugin_file_path;
		} else {
			$file_path = VAATHI_MODULE_DIR . '/woocommerce/' . $module .'.php';
		}

		$located_file_path = false;
		if ( $file_path && file_exists( $file_path ) ) {
			$located_file_path = $file_path;
		}

		return $located_file_path;
	}

}

/**
 * Check file is in theme
 */

if ( ! function_exists( 'vaathi_is_file_in_theme' ) ) {

	function vaathi_is_file_in_theme( $file_path = __FILE__ ) {

		$root = get_theme_root();
		$root = str_replace( '\\', '/', $root );

		$file_path = str_replace( '\\', '/', $file_path );

		$bool = stripos( $file_path, $root );
		if ( false === $bool ) {
			return false;
		}

		return true;
	}

}

/**
 * Check item is in cart
 */

if(!function_exists('vaathi_check_item_is_in_cart')) {

	function vaathi_check_item_is_in_cart( $product_id ){

		if ( $product_id > 0 ) {

			foreach( WC()->cart->get_cart() as $cart_item_key => $values ) {
				$cart_product = $values['data'];
				if( $product_id == $cart_product->get_id() ) {
					return true;
				}
			}

		}

		return false;

	}

}