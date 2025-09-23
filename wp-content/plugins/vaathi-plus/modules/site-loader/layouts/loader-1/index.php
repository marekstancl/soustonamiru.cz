<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'VaathiPlusSiteLoaderOne' ) ) {
    class VaathiPlusSiteLoaderOne {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'vaathi_loader_layouts', array( $this, 'add_option' ) );

            $site_loader = vaathi_customizer_settings( 'site_loader' );

            if( $site_loader == 'loader-1' ) {

                add_action( 'vaathi_after_main_css', array( $this, 'enqueue_assets' ) );

                /**
                 * filter: vaathi_primary_color_style - to use primary color
                 * filter: vaathi_secondary_color_style - to use secondary color
                 * filter: vaathi_tertiary_color_style - to use tertiary color
                 */
                add_filter( 'vaathi_tertiary_color_style', array( $this, 'tertiary_color_style' ) );
            }
        }

        function add_option( $options ) {
            $options['loader-1'] = esc_html__('Loader 1', 'vaathi-plus');
            return $options;
        }

        function enqueue_assets() {
            wp_enqueue_style( 'site-loader', VAATHI_PLUS_DIR_URL . 'modules/site-loader/layouts/loader-1/assets/css/loader-1.css', false, VAATHI_PLUS_VERSION, 'all' );
        }

        function tertiary_color_style( $style ) {
            $style .= ".loader1 { background-color:var( --wdtBodyBGColor );}";
            return $style;
        }
    }
}

VaathiPlusSiteLoaderOne::instance();