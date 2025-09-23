<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'VaathiPlusPost' ) ) {
    class VaathiPlusPost {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->load_modules();
        }

        function load_modules() {
            include_once VAATHI_PLUS_DIR_PATH.'modules/post/customizer/index.php';
        }

    }
}

VaathiPlusPost::instance();