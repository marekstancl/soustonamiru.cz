<?php

/**
 * Listing Framework Template Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Vaathi_Woo_Listing_Backup_Template_Settings' ) ) {

    class Vaathi_Woo_Listing_Backup_Template_Settings {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            /* Template Options Filter */
                add_action( 'cs_framework_options', array ( $this, 'vaathi_woo_cs_framework_backup_options' ), 10 );

        }


        function vaathi_woo_cs_framework_backup_options( $options ) {

            $options['backup']   = array(
                'name'     => 'backup_section',
                'title'    => esc_html__('Backup', 'vaathi-shop'),
                'icon'     => 'fa fa-shield',
                'fields'   => array(
                  array(
                    'type'    => 'notice',
                    'class'   => 'warning',
                    'content' => esc_html__('You can save your current options. Download a Backup and Import.', 'vaathi-shop')
                  ),
                  array(
                    'type'    => 'backup',
                  ),
                )
              );

              return $options;
        }

    }

}


if( !function_exists('vaathi_woo_listing_backup_template_settings') ) {
	function vaathi_woo_listing_backup_template_settings() {
		return Vaathi_Woo_Listing_Backup_Template_Settings::instance();
	}
}

vaathi_woo_listing_backup_template_settings();