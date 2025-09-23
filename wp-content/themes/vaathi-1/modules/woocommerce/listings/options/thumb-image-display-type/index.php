<?php
/**
 * Listing Options - Image Effect
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Vaathi_Woo_Listing_Option_Thumb_Image_Display_Type' ) ) {

    class Vaathi_Woo_Listing_Option_Thumb_Image_Display_Type extends Vaathi_Woo_Listing_Option_Core {

        private static $_instance = null;

        public $option_slug;

        public $option_name;

        public $option_desc;

        public $option_type;

        public $option_default_value;
        
        public $option_class_name;

        public $option_value_prefix;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {

            $this->option_slug          = 'product-thumb-image-display-type';
            $this->option_name          = esc_html__('Thumb Image Display Type', 'vaathi');
            $this->option_desc          = esc_html__('YES! to use it as background image. Its must if you use Product Thumb Content', 'vaathi');
            $this->option_type          = array ( 'html', 'class', 'key-css' );
            $this->option_default_value = false;
            $this->option_class_name    = 'product-thumb-bg-image';
            $this->option_value_prefix  = 'product-';

            $this->render_backend();
        }

        /**
         * Backend Render
         */
        function render_backend() {
            add_filter( 'vaathi_woo_custom_product_template_thumb_options', array( $this, 'woo_custom_product_template_thumb_options'), 5, 1 );
        }

        /**
         * Custom Product Templates - Options
         */
        function woo_custom_product_template_thumb_options( $template_options ) {

            array_push( $template_options, $this->setting_args() );

            return $template_options;
        }

        /**
         * Settings Group
         */
        function setting_group() {
            return 'thumb';
        }

        /**
         * Setting Args
         */
        function setting_args() {
            $settings            =  array ();
            $settings['id']      =  $this->option_slug;
            $settings['type']    =  'switcher';
            $settings['title']   =  $this->option_name;
            $settings['desc']    =  $this->option_desc;
            $settings['default'] =  $this->option_default_value;

            return $settings;
        }
    }

}

if( !function_exists('vaathi_woo_listing_option_thumb_image_display_type') ) {
	function vaathi_woo_listing_option_thumb_image_display_type() {
		return Vaathi_Woo_Listing_Option_Thumb_Image_Display_Type::instance();
	}
}

vaathi_woo_listing_option_thumb_image_display_type();