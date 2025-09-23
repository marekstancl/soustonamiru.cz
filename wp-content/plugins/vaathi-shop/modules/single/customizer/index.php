<?php

/**
 * Customizer - Product Single Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Vaathi_Shop_Customizer_Single' ) ) {

    class Vaathi_Shop_Customizer_Single {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            // Load Sections
                $this->load_sections();

        }

        /*
        Load Sections
        */

            function load_sections() {

                foreach( glob( VAATHI_SHOP_MODULE_PATH. 'single/customizer/sections/*.php' ) as $module ) {
                    include_once $module;
                }

            }


    }

}


if( !function_exists('vaathi_shop_customizer_single') ) {
	function vaathi_shop_customizer_single() {
		return Vaathi_Shop_Customizer_Single::instance();
	}
}

vaathi_shop_customizer_single();