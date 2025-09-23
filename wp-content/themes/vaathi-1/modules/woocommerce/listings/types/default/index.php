<?php

/**
 * Listing Types - Default
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Vaathi_Woo_Listing_Type_Default' ) ) {

    class Vaathi_Woo_Listing_Type_Default {

        private static $_instance = null;

        private $type_slug;

        private $type_name;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            /* Initialize Type */
                $this->type_slug = 'default';
                $this->type_name = esc_html__('Default', 'vaathi');

            /* Backend Render */
                $this->render_backend();

        }

        /*
        Module Paths
        */

            function module_dir_path() {

                if( vaathi_is_file_in_theme( __FILE__ ) ) {
                    return VAATHI_MODULE_DIR . '/woocommerce/listings/types/';
                } else {
                    return trailingslashit( plugin_dir_path( __FILE__ ) );
                }

            }

            function module_dir_url() {

                if( vaathi_is_file_in_theme( __FILE__ ) ) {
                    return VAATHI_MODULE_URI . '/woocommerce/listings/types/';
                } else {
                    return trailingslashit( plugin_dir_url( __FILE__ ) );
                }

            }

        /*
        Backend Render
        */
            function render_backend() {

                /* Custom Product Templates - Options */
                    add_filter( 'vaathi_woo_default_product_templates', array( $this, 'woo_default_product_templates'), 10, 1 );

            }

        /*
        Custom Product Templates - Options
        */
            function woo_default_product_templates( $templates ) {

                $type_options = array_merge (
                    array( 'product-template-id' => $this->type_name ),
                    $this->set_type_options()
                );

                $default_template = array (
                    'id'              => 'vaathi-woo-product-style-template-'.$this->type_slug,
                    'type'            => 'group',
                    'vaathi_default_type' => true,
                    'title'           => sprintf( esc_html__( 'Product Templates - %1$s', 'vaathi' ), $this->type_name ),
                    'button_title'    => esc_html__('Add New', 'vaathi'),
                    'accordion_title' => esc_html__('Add New Template', 'vaathi'),
                    'fields'          => vaathi_woo_listing_fw_template_settings()->woo_get_options_params( $type_options, 'default' ),
                    'default'         => array ( 0 => $type_options )
                );

                array_push( $templates, $default_template );

                return $templates;

            }

        /*
        Set Type Options
        */
            function set_type_options() {

                $type_options = array ();

                $type_options['product-style']       = 'product-style-default';
                $type_options['product-hover-style'] = '';
                $type_options['product-hover-image-effect'] = '';
                $type_options['product-hover-secondary-image-effect'] = 'product-hover-secimage-fade';
                $type_options['product-overlay-effect'] = '';
                $type_options['product-overlay-bgcolor'] = '';
                $type_options['product-overlay-dark-bgcolor'] = 0;
                $type_options['product-icongroup-hover-effect'] = '';
                $type_options['product-content-hover-effect'] = 'product-content-hover-slideright';
                $type_options['product-display-type'] = 'grid';
                $type_options['product-display-type-list-option'] = 'left-thumb';
                $type_options['product-space'] = 'product-with-space';
                $type_options['product-padding'] = 'product-padding-content';
                $type_options['product-background-bgcolor'] = '';
                $type_options['product-background-dark-bgcolor'] = 0;
                $type_options['product-borderorshadow'] = 'product-borderorshadow-border';
                $type_options['product-border-type'] = 'product-border-type-thumb';
                $type_options['product-border-position'] = 'product-border-position-default';
                $type_options['product-shadow-type'] = 'product-shadow-type-default';
                $type_options['product-shadow-position'] = 'product-shadow-position-default';
                $type_options['product-bordershadow-highlight'] = '';
                $type_options['product-custom-class'] = 'wdt-product-default-style';
                $type_options['product-show-label'] = 'true';
                $type_options['product-label-design'] = 'product-label-boxed';
                $type_options['product-show-offer-percentage'] = '';
                $type_options['product-show-custom-type'] = 'false';
                $type_options['product-empty-rating'] = 1;
                $type_options['product-thumb-image-display-type'] = 0;
                $type_options['product-thumb-secondary-image-onhover'] = 0;
                $type_options['product-thumb-content']          = array (
                    'enabled'      => array (
                    'icons_group' => esc_html__('Icons Group', 'vaathi'),
                ),
                    'disabled'     => array (
                        'title'          => esc_html__('Title', 'vaathi'),
                        'category'       => esc_html__('Category', 'vaathi'),
                        'price'          => esc_html__('Price', 'vaathi'),
                        'button_element' => esc_html__('Button Element', 'vaathi'),
                        'excerpt'        => esc_html__('Excerpt', 'vaathi'),
                        'rating'         => esc_html__('Rating', 'vaathi'),
                        'countdown'      => esc_html__('Count Down', 'vaathi'),
                        'separator'      => esc_html__('Separator', 'vaathi'),
                        'element_group'  => esc_html__('Element Group', 'vaathi'),
                        'swatches'       => esc_html__('Swatches', 'vaathi')
                    )
                );
                $type_options['product-thumb-alignment'] = 'product-thumb-alignment-top';
                $type_options['product-thumb-iconsgroup-icons'] = array ('cart', 'wishlist');
                $type_options['product-thumb-iconsgroup-position'] = 'product-thumb-iconsgroup-position-vertical vertical-position-top-right';
                $type_options['product-thumb-iconsgroup-style'] = 'product-thumb-iconsgroup-style-bgfill-square';
                $type_options['product-thumb-buttonelement-button'] = '';
                $type_options['product-thumb-buttonelement-secondary-button'] = '';
                $type_options['product-thumb-buttonelement-style'] = 'product-thumb-buttonelement-style-simple';
                $type_options['product-thumb-buttonelement-stretch'] = 'false';
                $type_options['product-thumb-element-group'] = array (
                    'enabled'      => array (
                    ),
                    'disabled'     => array (
                        'cart'           => esc_html__('Cart', 'vaathi'),
                        'button_element' => esc_html__('Button Element', 'vaathi'),
                        'price'          => esc_html__('Price', 'vaathi'),
                        'title'          => esc_html__('Title', 'vaathi'),
                        'wishlist'       => esc_html__('Wishlist', 'vaathi'),
                        'compare'        => esc_html__('Compare', 'vaathi'),
                        'quickview'      => esc_html__('Quick View', 'vaathi'),
                        'category'       => esc_html__('Category', 'vaathi'),
                        'icons_group'    => esc_html__('Icons Group', 'vaathi'),
                        'excerpt'        => esc_html__('Excerpt', 'vaathi'),
                        'rating'         => esc_html__('Rating', 'vaathi'),
                        'separator'      => esc_html__('Separator', 'vaathi'),
                        'swatches'       => esc_html__('Swatches', 'vaathi')
                    )
                );

                $type_options['product-content-enable'] = 1;
                $type_options['product-content-content'] = array (
                    'enabled'      => array (
                        'rating' => esc_html__('Rating', 'vaathi'),
                        'title'          => esc_html__('Title', 'vaathi'),
                        'price'          => esc_html__('Price', 'vaathi'),
                    ),
                    'disabled'     => array (
                        'excerpt'        => esc_html__('Excerpt', 'vaathi'),
                        'button_element' => esc_html__('Button Element', 'vaathi'),
                        'category' => esc_html__('Category', 'vaathi'),
                        'countdown'      => esc_html__('Count Down', 'vaathi'),
                        'separator'      => esc_html__('Separator', 'vaathi'),
                        'element_group'  => esc_html__('Element Group', 'vaathi'),
                        'swatches'       => esc_html__('Swatches', 'vaathi')
                    )
                );
                $type_options['product-content-alignment'] = 'product-content-alignment-left';
                $type_options['product-content-iconsgroup-icons'] = array ();
                $type_options['product-content-iconsgroup-style'] = 'product-content-iconsgroup-style-simple';
                $type_options['product-content-buttonelement-button'] = '';
                $type_options['product-content-buttonelement-secondary-button'] = '';
                $type_options['product-content-buttonelement-style'] = 'product-content-buttonelement-style-simple';
                $type_options['product-content-buttonelement-stretch'] = '';
                $type_options['product-content-element-group'] = array (
                    'enabled'      => array (
                    ),
                    'disabled'     => array (
                        'cart'           => esc_html__('Cart', 'vaathi'),
                        'button_element' => esc_html__('Button Element', 'vaathi'),
                        'price'          => esc_html__('Price', 'vaathi'),
                        'title'          => esc_html__('Title', 'vaathi'),
                        'wishlist'       => esc_html__('Wishlist', 'vaathi'),
                        'compare'        => esc_html__('Compare', 'vaathi'),
                        'quickview'      => esc_html__('Quick View', 'vaathi'),
                        'category'       => esc_html__('Category', 'vaathi'),
                        'icons_group'    => esc_html__('Icons Group', 'vaathi'),
                        'excerpt'        => esc_html__('Excerpt', 'vaathi'),
                        'rating'         => esc_html__('Rating', 'vaathi'),
                        'separator'      => esc_html__('Separator', 'vaathi'),
                        'swatches'       => esc_html__('Swatches', 'vaathi')
                    )
                );

                return $type_options;


            }

        /*
        Frontend Render
        */
            function render_frontend() {

                $non_archive_listing = wc_get_loop_prop('non_archive_listing');

                if( $non_archive_listing ) {

                    /* Types CSS */
                        add_filter( 'vaathi_woo_non_archive_css', array( $this, 'woo_listings_css_load'), 10, 1 );

                } else {

                    /* Types CSS */
                        add_filter( 'vaathi_woo_archive_css', array( $this, 'woo_listings_css_load'), 10, 1 );

                }

            }

        /*
        Types CSS
        */
            function woo_listings_css_load( $css ) {

                $css .= $this->load_type_css();
                $css .= $this->load_type_skin_css();

                return $css;

            }

            // Type Main CSS
            function load_type_css() {

                $css = '';

                $css_file_path = $this->module_dir_path() . 'assets/css/'.$this->type_slug.'.css';

                if( file_exists ( $css_file_path ) ) {

                    $css .=  file_get_contents( $css_file_path );

                }

                return $css;

            }

            // Type Skin CSS
            function load_type_skin_css() {

                $css = '';
                return $css;

            }

        /*
        For Non Archive Listing
        */
            function for_non_archive_listing() {

                /* Load Other Modules */

                    $sub_modules = array (
                        'includes' => 'listings/includes/index'
                    );

                    if( is_array( $sub_modules ) && !empty( $sub_modules ) ) {
                        foreach( $sub_modules as $sub_module ) {

                            if( $file_content = vaathi_woo_locate_file( $sub_module ) ) {
                                include_once $file_content;
                            }

                        }
                    }


                /* Assets Load */

                    // CSS

                        wp_register_style( 'vaathi-woo-non-archive', '', array (), VAATHI_THEME_VERSION, 'all' );
                        wp_enqueue_style( 'vaathi-woo-non-archive' );

                        $css = '';

                        // Load common styles
                        if( !is_shop() && !is_product_category() && !is_product_tag() && !is_product() && !is_cart() && !is_checkout() ) {

                            $css_file_path = VAATHI_MODULE_DIR . '/woocommerce/assets/css/common.css';

                            if(!isset($GLOBALS['wdt_shop_loaded_files']) || (isset($GLOBALS['wdt_shop_loaded_files']) && !in_array($css_file_path, $GLOBALS['wdt_shop_loaded_files']))) {

                                if( file_exists ( $css_file_path ) ) {
                                    $css .=  file_get_contents( $css_file_path );
                                }

                                if(!isset($GLOBALS['wdt_shop_loaded_files'])) {
                                    $GLOBALS['wdt_shop_loaded_files'] = array ();
                                }

                                array_push($GLOBALS['wdt_shop_loaded_files'], $css_file_path);

                            }


                            $css_file_path = VAATHI_MODULE_DIR . '/woocommerce/single/assets/css/common.css';

                            if(!isset($GLOBALS['wdt_shop_loaded_files']) || (isset($GLOBALS['wdt_shop_loaded_files']) && !in_array($css_file_path, $GLOBALS['wdt_shop_loaded_files']))) {

                                if( file_exists ( $css_file_path ) ) {
                                    $css .=  file_get_contents( $css_file_path );
                                }

                                if(!isset($GLOBALS['wdt_shop_loaded_files'])) {
                                    $GLOBALS['wdt_shop_loaded_files'] = array ();
                                }

                                array_push($GLOBALS['wdt_shop_loaded_files'], $css_file_path);

                            }

                        }

                        $css = apply_filters( 'vaathi_woo_non_archive_css', $css );

                        if( !empty($css) ) {
                            wp_add_inline_style( 'vaathi-woo-non-archive', $css );
                        }

                    // JS

                        wp_register_script( 'vaathi-woo-non-archive', '', array ('jquery'), false, true );
                        wp_enqueue_script( 'vaathi-woo-non-archive' );

                        $js = '';

                        // Load common js
                        if( !is_shop() && !is_product_category() && !is_product_tag() && !is_product() && !is_cart() && !is_checkout() ) {

                            $js_file_path = VAATHI_MODULE_DIR . '/woocommerce/assets/js/common.js';
                            if(!isset($GLOBALS['wdt_shop_loaded_files']) || (isset($GLOBALS['wdt_shop_loaded_files']) && !in_array($js_file_path, $GLOBALS['wdt_shop_loaded_files']))) {

                                if( file_exists ( $js_file_path ) ) {
                                    $js .= file_get_contents( $js_file_path );
                                }

                                if(!isset($GLOBALS['wdt_shop_loaded_files'])) {
                                    $GLOBALS['wdt_shop_loaded_files'] = array ();
                                }

                                array_push($GLOBALS['wdt_shop_loaded_files'], $js_file_path);

                            }

                        }

                        $js = apply_filters( 'vaathi_woo_non_archive_js', $js );

                        if( !empty($js) ) {
                            wp_add_inline_script( 'vaathi-woo-non-archive', $js );
                        }

            }

    }

}

if( !function_exists('vaathi_woo_listing_type_default') ) {
	function vaathi_woo_listing_type_default() {
		return Vaathi_Woo_Listing_Type_Default::instance();
	}
}

vaathi_woo_listing_type_default();