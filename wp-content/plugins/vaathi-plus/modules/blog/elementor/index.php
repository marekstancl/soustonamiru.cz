<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'VaathiPlusBlogArchiveElementor' ) ) {
    class VaathiPlusBlogArchiveElementor {

        private static $_instance = null;

        const MINIMUM_ELEMENTOR_VERSION = '3.0.0';

        const MINIMUM_PHP_VERSION = '7.2';

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_action( 'plugins_loaded', array( $this, 'register_init' ) );
        }

        function register_init() {
            $this->load_modules();
        }

        function load_modules() {
            foreach( glob( VAATHI_PLUS_DIR_PATH. 'modules/blog/elementor/widgets/*/index.php'  ) as $module ) {
                include_once $module;
            }
        }

    }
}

VaathiPlusBlogArchiveElementor::instance();