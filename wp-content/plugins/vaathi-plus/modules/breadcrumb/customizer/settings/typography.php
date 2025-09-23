<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'VaathiPlusBreadCrumbTypo' ) ) {
    class VaathiPlusBreadCrumbTypo {

        private static $_instance = null;
        private $settings         = null;
        private $selector         = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_action( 'customize_register', array( $this, 'register' ), 15);
        }

        function register( $wp_customize ) {
            $wp_customize->add_section(
                new Vaathi_Customize_Section(
                    $wp_customize,
                    'site-breadcrumb-typo-section',
                    array(
                        'title'    => esc_html__('Typography', 'vaathi-plus'),
                        'panel'    => 'site-breadcrumb-main-panel',
                        'priority' => 15,
                    )
                )
            );

                if ( ! defined( 'VAATHI_PRO_VERSION' ) ) {
                    $wp_customize->add_control(
                        new Vaathi_Customize_Control_Separator(
                            $wp_customize, VAATHI_CUSTOMISER_VAL . '[vaathi-plus-site-breadcrumb-typo-separator]',
                            array(
                                'type'        => 'wdt-separator',
                                'section'     => 'site-breadcrumb-typo-section',
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

VaathiPlusBreadCrumbTypo::instance();