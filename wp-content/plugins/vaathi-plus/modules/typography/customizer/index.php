<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'VaathiPlusCustomizerSiteTypography' ) ) {
    class VaathiPlusCustomizerSiteTypography {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_action( 'customize_register', array( $this, 'register' ), 15);
            $this->load_modules();
        }

        function register( $wp_customize ) {

            /**
             * Panel
             */
            $wp_customize->add_panel(
                new Vaathi_Customize_Panel(
                    $wp_customize,
                    'site-typography-main-panel',
                    array(
                        'title'    => esc_html__('Site Typography', 'vaathi-plus'),
                        'priority' => vaathi_customizer_panel_priority( 'typography' )
                    )
                )
            );

        }

        function load_modules() {
            foreach( glob( VAATHI_PLUS_DIR_PATH . 'modules/typography/customizer/settings/*.php'  ) as $module ) {
                include_once $module;
            }
        }

    }
}

VaathiPlusCustomizerSiteTypography::instance();