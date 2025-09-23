<?php

/**
 * Listing Options - Product Thumb Content
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Vaathi_Woo_Listing_Option_Content_Content' ) ) {

    class Vaathi_Woo_Listing_Option_Content_Content extends Vaathi_Woo_Listing_Option_Core {

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

            $this->option_slug          = 'product-content-content';
            $this->option_name          = esc_html__('Content Elements', 'vaathi');
            $this->option_type          = array ( 'html', 'value-css' );
            $this->option_default_value = '';
            $this->option_value_prefix  = '';

            $this->render_backend();
        }

        /**
         * Backend Render
         */
        function render_backend() {

            /* Custom Product Templates - Options */
            add_filter( 'vaathi_woo_custom_product_template_content_options', array( $this, 'woo_custom_product_template_content_options'), 10, 1 );
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
         * Setting Arguments
         */
        function setting_args() {

            $settings            =  array ();
            $settings['id']      =  $this->option_slug;
            $settings['type']    =  'sorter';
            $settings['title']   =  $this->option_name;
            $settings['default'] =  array (
                'enabled'            => array(
                    'title'          => esc_html__('Title', 'vaathi'),
                    'category'       => esc_html__('Category', 'vaathi'),
                    'price'          => esc_html__('Price', 'vaathi'),
                    'button_element' => esc_html__('Button Element', 'vaathi'),
                    'icons_group'    => esc_html__('Icons Group', 'vaathi'),
                ),
                'disabled'         => array(
                    'excerpt'       => esc_html__('Excerpt', 'vaathi'),
                    'rating'        => esc_html__('Rating', 'vaathi'),
                    'countdown'     => esc_html__('Count Down', 'vaathi'),
                    'separator'     => esc_html__('Separator', 'vaathi'),
                    'element_group' => esc_html__('Element Group', 'vaathi'),
                    'product_notes' => esc_html__('Product Notes', 'vaathi'),
                    'label_instock' => esc_html__('Label - InStock', 'vaathi'),
                    'swatches'      => esc_html__('Swatches', 'vaathi')
                ),
            );



            return $settings;
        }
    }

}

if( !function_exists('vaathi_woo_listing_option_content_content') ) {
	function vaathi_woo_listing_option_content_content() {
		return Vaathi_Woo_Listing_Option_Content_Content::instance();
	}
}

vaathi_woo_listing_option_content_content();