<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if (! class_exists ( 'VaathiPlusHeaderPostType' ) ) {

	class VaathiPlusHeaderPostType {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

		function __construct() {

			add_action ( 'init', array( $this, 'vaathi_register_cpt' ), 5 );
			add_filter ( 'template_include', array ( $this, 'vaathi_template_include' ) );
		}

		function vaathi_register_cpt() {

			$labels = array (
				'name'				 => __( 'Headers', 'vaathi-plus' ),
				'singular_name'		 => __( 'Header', 'vaathi-plus' ),
				'menu_name'			 => __( 'Headers', 'vaathi-plus' ),
				'add_new'			 => __( 'Add Header', 'vaathi-plus' ),
				'add_new_item'		 => __( 'Add New Header', 'vaathi-plus' ),
				'edit'				 => __( 'Edit Header', 'vaathi-plus' ),
				'edit_item'			 => __( 'Edit Header', 'vaathi-plus' ),
				'new_item'			 => __( 'New Header', 'vaathi-plus' ),
				'view'				 => __( 'View Header', 'vaathi-plus' ),
				'view_item' 		 => __( 'View Header', 'vaathi-plus' ),
				'search_items' 		 => __( 'Search Headers', 'vaathi-plus' ),
				'not_found' 		 => __( 'No Headers found', 'vaathi-plus' ),
				'not_found_in_trash' => __( 'No Headers found in Trash', 'vaathi-plus' ),
			);

			$args = array (
				'labels' 				=> $labels,
				'public' 				=> true,
				'exclude_from_search'	=> true,
				'show_in_nav_menus' 	=> false,
				'show_in_rest' 			=> true,
				'menu_position'			=> 25,
				'menu_icon' 			=> 'dashicons-heading',
				'hierarchical' 			=> false,
				'supports' 				=> array ( 'title', 'editor', 'revisions' ),
			);

			register_post_type ( 'wdt_headers', $args );
		}

		function vaathi_template_include($template) {
			if ( is_singular( 'wdt_headers' ) ) {
				if ( ! file_exists ( get_stylesheet_directory () . '/single-wdt_headers.php' ) ) {
					$template = VAATHI_PLUS_DIR_PATH . 'post-types/templates/single-wdt_headers.php';
				}
			}

			return $template;
		}
	}
}

VaathiPlusHeaderPostType::instance();