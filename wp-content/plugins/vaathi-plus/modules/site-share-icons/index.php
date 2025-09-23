<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'VaathiPlusSiteShareIcons' ) ) {
    class VaathiPlusSiteShareIcons {

        private static $_instance = null;

        private $follow_us_link = false;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->follow_us_link = vaathi_customizer_settings('show_follow_us_icons');
            $this->load_modules();
            $this->frontend();
        }

        function load_modules() {
            include_once VAATHI_PLUS_DIR_PATH.'modules/site-share-icons/customizer/index.php';
        }

        function frontend() {
            if( $this->follow_us_link ) {
                add_action( 'vaathi_after_main_css', array( $this, 'enqueue_assets' ) );
                add_action( 'wp_footer', array( $this, 'load_template' ), 999 );
            }
        }

        function enqueue_assets() {
            wp_enqueue_style( 'site-share-icons-style', VAATHI_PLUS_DIR_URL . 'modules/site-share-icons/assets/css/style.css', false, VAATHI_PLUS_VERSION, 'all' );
        }

        function load_template() {
            if($this->follow_us_link) {
                echo vaathi_get_template_part( 'site-share-icons/layouts', '/template', '', array() );
            }
        }
    }
}

VaathiPlusSiteShareIcons::instance();