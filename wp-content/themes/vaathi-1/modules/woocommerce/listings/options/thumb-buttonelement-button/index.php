<?php
/**
 * Listing Options - Image Effect
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Vaathi_Woo_Listing_Option_Thumb_Button_Element_button' ) ) {

    class Vaathi_Woo_Listing_Option_Thumb_Button_Element_button extends Vaathi_Woo_Listing_Option_Core {

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

            $this->option_slug          = 'product-thumb-buttonelement-button';
            $this->option_name          = esc_html__('Button Element - Button', 'vaathi');
            $this->option_type          = array ( 'html', 'value-css' );
            $this->option_default_value = '';
            $this->option_value_prefix  = '';

            $this->render_backend();
        }

        /**
         * Backend Render
         */
        function render_backend() {
            add_filter( 'vaathi_woo_custom_product_template_thumb_options', array( $this, 'woo_custom_product_template_thumb_options'), 35, 1 );
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
            $settings['type']    =  'select';
            $settings['title']   =  $this->option_name;
            $settings['options'] =  array (
                ''          => esc_html__('None', 'vaathi'),
                'cart'      => esc_html__('Cart', 'vaathi'),
                'wishlist'  => esc_html__('Wishlist', 'vaathi'),
                'compare'   => esc_html__('Compare', 'vaathi'),
                'quickview' => esc_html__('Quick View', 'vaathi')
            );
            $settings['default']    =  $this->option_default_value;

            return $settings;
        }
    }

}

if( !function_exists('vaathi_woo_listing_option_thumb_buttonelement_button') ) {
	function vaathi_woo_listing_option_thumb_buttonelement_button() {
		return Vaathi_Woo_Listing_Option_Thumb_Button_Element_button::instance();
	}
}

vaathi_woo_listing_option_thumb_buttonelement_button();