<?php
/**
 * Listing Options - Image Effect
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Vaathi_Woo_Listing_Option_Hover_Secondary_Image_Effect' ) ) {

    class Vaathi_Woo_Listing_Option_Hover_Secondary_Image_Effect extends Vaathi_Woo_Listing_Option_Core {

        private static $_instance = null;

        public $option_slug;

        public $option_name;

        public $option_type;

        public $option_default_value;

        public $option_value_prefix;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {

            $this->option_slug          = 'product-hover-secondary-image-effect';
            $this->option_name          = esc_html__('Hover Secondary Image Effect', 'vaathi');
            $this->option_default_value = 'product-hover-secimage-fade';
            $this->option_type          = array ( 'class', 'value-css' );
            $this->option_value_prefix  = 'product-hover-';

            $this->render_backend();
        }

        /**
         * Backend Render
         */
        function render_backend() {
            add_filter( 'vaathi_woo_custom_product_template_hover_options', array( $this, 'woo_custom_product_template_hover_options'), 15, 1 );
        }

        /**
         * Custom Product Templates - Options
         */
        function woo_custom_product_template_hover_options( $template_options ) {

            array_push( $template_options, $this->setting_args() );

            return $template_options;
        }

        /**
         * Settings Group
         */
        function setting_group() {
            return 'hover';
        }

        /**
         * Setting Args
         */
        function setting_args() {
            $settings            =  array ();
            $settings['id']      =  $this->option_slug;
            $settings['type']    =  'select';
            $settings['title']   =  $this->option_name;
            $settings['options'] =  array (
                'product-hover-secimage-fade'         => esc_html__('Fade', 'vaathi'),
                'product-hover-secimage-zoomin'       => esc_html__('Zoom In', 'vaathi'),
                'product-hover-secimage-zoomout'      => esc_html__('Zoom Out', 'vaathi'),
                'product-hover-secimage-zoomoutup'    => esc_html__('Zoom Out Up', 'vaathi'),
                'product-hover-secimage-zoomoutdown'  => esc_html__('Zoom Out Down', 'vaathi'),
                'product-hover-secimage-zoomoutleft'  => esc_html__('Zoom Out Left', 'vaathi'),
                'product-hover-secimage-zoomoutright' => esc_html__('Zoom Out Right', 'vaathi'),
                'product-hover-secimage-pushup'       => esc_html__('Push Up', 'vaathi'),
                'product-hover-secimage-pushdown'     => esc_html__('Push Down', 'vaathi'),
                'product-hover-secimage-pushleft'     => esc_html__('Push Left', 'vaathi'),
                'product-hover-secimage-pushright'    => esc_html__('Push Right', 'vaathi'),
                'product-hover-secimage-slideup'      => esc_html__('Slide Up', 'vaathi'),
                'product-hover-secimage-slidedown'    => esc_html__('Slide Down', 'vaathi'),
                'product-hover-secimage-slideleft'    => esc_html__('Slide Left', 'vaathi'),
                'product-hover-secimage-slideright'   => esc_html__('Slide Right', 'vaathi'),
                'product-hover-secimage-hingeup'      => esc_html__('Hinge Up', 'vaathi'),
                'product-hover-secimage-hingedown'    => esc_html__('Hinge Down', 'vaathi'),
                'product-hover-secimage-hingeleft'    => esc_html__('Hinge Left', 'vaathi'),
                'product-hover-secimage-hingeright'   => esc_html__('Hinge Right', 'vaathi'),
                'product-hover-secimage-foldup'       => esc_html__('Fold Up', 'vaathi'),
                'product-hover-secimage-folddown'     => esc_html__('Fold Down', 'vaathi'),
                'product-hover-secimage-foldleft'     => esc_html__('Fold Left', 'vaathi'),
                'product-hover-secimage-foldright'    => esc_html__('Fold Right', 'vaathi'),
                'product-hover-secimage-fliphoriz'    => esc_html__('Flip Horizontal', 'vaathi'),
                'product-hover-secimage-flipvert'     => esc_html__('Flip Vertical', 'vaathi')
            );
            $settings['default'] =  $this->option_default_value;

            return $settings;
        }
    }

}

if( !function_exists('vaathi_woo_listing_option_hover_secondary_image_effect') ) {
	function vaathi_woo_listing_option_hover_secondary_image_effect() {
		return Vaathi_Woo_Listing_Option_Hover_Secondary_Image_Effect::instance();
	}
}

vaathi_woo_listing_option_hover_secondary_image_effect();