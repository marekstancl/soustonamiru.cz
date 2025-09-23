<?php

/**
 * WooCommerce - Others Core Class
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Vaathi_Woo_Others' ) ) {

    class Vaathi_Woo_Others {

        private static $_instance = null;

        private $settings;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            // Load Modules

				$this->woo_load_modules();

        }

        /*
        Load Default Values
        */
            function woo_default_settings() {

                $this->settings = array (

					'addtocart_custom_action'                         => '',
					'cross_sell_column'                               => 3,
					'cross_sell_title'                                => '',
					'cross_sell_style_template'                       => 'predefined',
                    'cross_sell_style_custom_template' => 'default',
                    'enable_quantity_plusminus'        => 1,
                    'enable_recently_viewed_products'  => 0,
                    'custom_product_types'             => '',
					'enable_suggested_products'        => 0

                );

                $this->settings = apply_filters( 'vaathi_woo_others_settings', $this->settings );

                return $this->settings;

            }

		/*
		* Load Modules
		*/
			function woo_load_modules() {

				/* Custom Modules */

					$custom_modules = array (
						'cart'                     => 'others/cart/index',
						'cart-notification'        => 'others/cart-notification/index',
						'checkout'                 => 'others/checkout/index',
						'custom-product-type'      => 'others/custom-product-type/index',
						'taxonomy'                 => 'others/taxonomy/index',
						'search'                   => 'others/search/index',
						'size-guide'               => 'others/size-guide/index',
						'wishlist'                 => 'others/wishlist/index',
						'quantity-plus-minus'      => 'others/quantity-plus-minus/index',
						'recently-viewed-products' => 'others/recently-viewed-products/index',
						'suggested-products' 	   => 'others/suggested-products/index'
					);

					if( is_array( $custom_modules ) && !empty( $custom_modules ) ) {
						foreach( $custom_modules as $custom_module ) {

							if( $file_path = vaathi_woo_locate_file( $custom_module ) ) {
								include_once $file_path;
							}

						}
					}

			}

    }

}

if( !function_exists('vaathi_woo_others') ) {
	function vaathi_woo_others() {
		return Vaathi_Woo_Others::instance();
	}
}

vaathi_woo_others();