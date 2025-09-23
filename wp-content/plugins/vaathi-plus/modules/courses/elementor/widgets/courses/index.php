<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'VaathiPlusCoursesWidget' ) ) {
    class VaathiPlusCoursesWidget {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }
        function __construct() {
            add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );
            add_action( 'elementor/frontend/after_register_styles', array( $this, 'register_widget_styles' ) );
            add_action( 'elementor/frontend/after_register_scripts', array( $this, 'register_widget_scripts' ) );
        }

        function register_widgets( $widgets_manager ) {
            require VAATHI_PLUS_DIR_PATH. 'modules/courses/elementor/widgets/courses/class-widget-courses.php';
            $widgets_manager->register( new \Elementor_Header_Courses() );
        }

        function register_widget_styles() {
            wp_register_style( 'wdt-courses-css',
                VAATHI_PLUS_DIR_URL . 'modules/courses/elementor/widgets/courses/assets/css/style.css', array(), VAATHI_PLUS_VERSION );
            wp_enqueue_style( 'wdt-courses-css' );
        }

        function register_widget_scripts() {
            wp_register_style( 'wdt-courses-js',
                VAATHI_PLUS_DIR_URL . 'modules/courses/elementor/widgets/courses/assets/css/script.js', array(), VAATHI_PLUS_VERSION );
            wp_enqueue_style( 'wdt-courses-js' );
        }
        
    }
}

VaathiPlusCoursesWidget::instance();