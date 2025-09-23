<?php

/**
 * WooCommerce - Checkout Core Class
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Vaathi_Shop_Others_Checkout' ) ) {

    class Vaathi_Shop_Others_Checkout {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            // Load Modules
                $this->load_modules();

        }


        /*
        Module Paths
        */

            function module_dir_path() {

                if( vaathi_is_file_in_theme( __FILE__ ) ) {
                    return VAATHI_MODULE_DIR . '/woocommerce/others/checkout/';
                } else {
                    return trailingslashit( plugin_dir_path( __FILE__ ) );
                }

            }

            function module_dir_url() {

                if( vaathi_is_file_in_theme( __FILE__ ) ) {
                    return VAATHI_MODULE_URI . '/woocommerce/others/checkout/';
                } else {
                    return trailingslashit( plugin_dir_url( __FILE__ ) );
                }

            }

        /**
         * Load Modules
         */
            function load_modules() {

                // Includes
                include_once $this->module_dir_path(). 'includes/index.php';

            }

    }

}

if( !function_exists('vaathi_shop_others_checkout') ) {
	function vaathi_shop_others_checkout() {
        $reflection = new ReflectionClass('Vaathi_Shop_Others_Checkout');
        return $reflection->newInstanceWithoutConstructor();
	}
}

Vaathi_Shop_Others_Checkout::instance();