<?php
/**
 * Listing Options - Image Effect
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Vaathi_Woo_Listing_Option_Content_Alignment' ) ) {

    class Vaathi_Woo_Listing_Option_Content_Alignment extends Vaathi_Woo_Listing_Option_Core {

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

            $this->option_slug          = 'product-content-alignment';
            $this->option_name          = esc_html__('Alignment', 'vaathi');
            $this->option_type          = array ( 'class', 'value-css' );
            $this->option_default_value = 'product-content-alignment-left';
            $this->option_value_prefix  = 'product-content-alignment-';

            $this->render_backend();
        }

        /**
         * Backend Render
         */
        function render_backend() {
            add_filter( 'vaathi_woo_custom_product_template_content_options', array( $this, 'woo_custom_product_template_content_options'), 15, 1 );
        }

        /**
         * Custom Product Templates - Options
         */
        function woo_custom_product_template_content_options( $template_options ) {

            array_push( $template_options, $this->setting_args() );

            return $template_options;
        }

        /**
         * Settings Group
         */
        function setting_group() {
            return 'content';
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
                'product-content-alignment-left'   => esc_html__('Left', 'vaathi'),
                'product-content-alignment-center' => esc_html__('Center', 'vaathi'),
                'product-content-alignment-right'  => esc_html__('Right', 'vaathi')
            );
            $settings['default'] =  $this->option_default_value;

            return $settings;
        }
    }

}

if( !function_exists('vaathi_woo_listing_option_content_alignment') ) {
	function vaathi_woo_listing_option_content_alignment() {
		return Vaathi_Woo_Listing_Option_Content_Alignment::instance();
	}
}

vaathi_woo_listing_option_content_alignment();