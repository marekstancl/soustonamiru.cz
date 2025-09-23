<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'VaathiPlusWidgetContentSettings' ) ) {
    class VaathiPlusWidgetContentSettings {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_action( 'customize_register', array( $this, 'register' ), 15);
        }

        function register( $wp_customize ){

            /**
             * Content Section
             */
            $wp_customize->add_section(
                new Vaathi_Customize_Section(
                    $wp_customize,
                    'site-widgets-content-style-section',
                    array(
                        'title'    => esc_html__('Widget Content', 'vaathi-plus'),
                        'panel'    => 'site-widget-settings-panel',
                        'priority' => 10,
                    )
                )
            );

            if ( ! defined( 'VAATHI_PRO_VERSION' ) ) {
                $wp_customize->add_control(
                    new Vaathi_Customize_Control_Separator(
                        $wp_customize, VAATHI_CUSTOMISER_VAL . '[vaathi-plus-site-widgets-content-style-separator]',
                        array(
                            'type'        => 'wdt-separator',
                            'section'     => 'site-widgets-content-style-section',
                            'settings'    => array(),
                            'caption'     => VAATHI_PLUS_REQ_CAPTION,
                            'description' => VAATHI_PLUS_REQ_DESC,
                        )
                    )
                );
            }

        }

    }
}

VaathiPlusWidgetContentSettings::instance();