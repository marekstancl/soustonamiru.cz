<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'VaathiPlusWidgetTitleSettings' ) ) {
    class VaathiPlusWidgetTitleSettings {

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
             * Title Section
             */
            $wp_customize->add_section(
                new Vaathi_Customize_Section(
                    $wp_customize,
                    'site-widgets-title-style-section',
                    array(
                        'title'    => esc_html__('Widget Title', 'vaathi-plus'),
                        'panel'    => 'site-widget-settings-panel',
                        'priority' => 5,
                    )
                )
            );

            if ( ! defined( 'VAATHI_PRO_VERSION' ) ) {
                $wp_customize->add_control(
                    new Vaathi_Customize_Control_Separator(
                        $wp_customize, VAATHI_CUSTOMISER_VAL . '[vaathi-plus-site-sidebar-title-separator]',
                        array(
                            'type'        => 'wdt-separator',
                            'section'     => 'site-widgets-title-style-section',
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

VaathiPlusWidgetTitleSettings::instance();