<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if (! class_exists ( 'VaathiPlusFooterPostType' ) ) {

	class VaathiPlusFooterPostType {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

		function __construct() {

			add_action ( 'init', array( $this, 'vaathi_register_cpt' ) );
			add_filter ( 'template_include', array ( $this, 'vaathi_template_include' ) );
		}

		function vaathi_register_cpt() {

			$labels = array (
				'name'				 => __( 'Footers', 'vaathi-plus' ),
				'singular_name'		 => __( 'Footer', 'vaathi-plus' ),
				'menu_name'			 => __( 'Footers', 'vaathi-plus' ),
				'add_new'			 => __( 'Add Footer', 'vaathi-plus' ),
				'add_new_item'		 => __( 'Add New Footer', 'vaathi-plus' ),
				'edit'				 => __( 'Edit Footer', 'vaathi-plus' ),
				'edit_item'			 => __( 'Edit Footer', 'vaathi-plus' ),
				'new_item'			 => __( 'New Footer', 'vaathi-plus' ),
				'view'				 => __( 'View Footer', 'vaathi-plus' ),
				'view_item' 		 => __( 'View Footer', 'vaathi-plus' ),
				'search_items' 		 => __( 'Search Footers', 'vaathi-plus' ),
				'not_found' 		 => __( 'No Footers found', 'vaathi-plus' ),
				'not_found_in_trash' => __( 'No Footers found in Trash', 'vaathi-plus' ),
			);

			$args = array (
				'labels' 				=> $labels,
				'public' 				=> true,
				'exclude_from_search'	=> true,
				'show_in_nav_menus' 	=> false,
				'show_in_rest' 			=> true,
				'menu_position'			=> 26,
				'menu_icon' 			=> 'dashicons-editor-insertmore',
				'hierarchical' 			=> false,
				'supports' 				=> array ( 'title', 'editor', 'revisions' ),
			);

			register_post_type ( 'wdt_footers', $args );
		}

		function vaathi_template_include($template) {
			if ( is_singular( 'wdt_footers' ) ) {
				if ( ! file_exists ( get_stylesheet_directory () . '/single-wdt_footers.php' ) ) {
					$template = VAATHI_PLUS_DIR_PATH . 'post-types/templates/single-wdt_footers.php';
				}
			}

			return $template;
		}
	}
}

VaathiPlusFooterPostType::instance();