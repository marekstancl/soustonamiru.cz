<?php

/**
 * Listing Customizer - Shop Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Vaathi_Shop_Listing_Customizer_Shop' ) ) {

    class Vaathi_Shop_Listing_Customizer_Shop {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            add_filter( 'vaathi_woo_shop_page_default_settings', array( $this, 'shop_page_default_settings' ), 10, 1 );
            add_action( 'customize_register', array( $this, 'register' ), 40);
            add_action( 'vaathi_hook_content_before', array( $this, 'woo_handle_product_breadcrumb' ), 10);

        }

        function shop_page_default_settings( $settings ) {

            $disable_breadcrumb             = vaathi_customizer_settings('wdt-woo-shop-page-disable-breadcrumb' );
            $settings['disable_breadcrumb'] = $disable_breadcrumb;

            $apply_isotope                  = vaathi_customizer_settings('wdt-woo-shop-page-apply-isotope' );
            $settings['apply_isotope']      = $apply_isotope;

            $show_sorter_on_header              = vaathi_customizer_settings('wdt-woo-shop-page-show-sorter-on-header' );
            $settings['show_sorter_on_header']  = $show_sorter_on_header;

            $sorter_header_elements             = vaathi_customizer_settings('wdt-woo-shop-page-sorter-header-elements' );
            $settings['sorter_header_elements'] = (is_array($sorter_header_elements) && !empty($sorter_header_elements) ) ? $sorter_header_elements : array ();

            $show_sorter_on_footer              = vaathi_customizer_settings('wdt-woo-shop-page-show-sorter-on-footer' );
            $settings['show_sorter_on_footer']  = $show_sorter_on_footer;

            $sorter_footer_elements             = vaathi_customizer_settings('wdt-woo-shop-page-sorter-footer-elements' );
            $settings['sorter_footer_elements'] = (is_array($sorter_footer_elements) && !empty($sorter_footer_elements) ) ? $sorter_footer_elements : array ();

            return $settings;

        }

        function register( $wp_customize ) {

                /**
                * Option : Disable Breadcrumb
                */
                    $wp_customize->add_setting(
                        VAATHI_CUSTOMISER_VAL . '[wdt-woo-shop-page-disable-breadcrumb]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new Vaathi_Customize_Control_Switch(
                            $wp_customize, VAATHI_CUSTOMISER_VAL . '[wdt-woo-shop-page-disable-breadcrumb]', array(
                                'type'    => 'wdt-switch',
                                'label'   => esc_html__( 'Disable Breadcrumb', 'vaathi-shop'),
                                'section' => 'woocommerce-shop-page-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'vaathi-shop' ),
                                    'off' => esc_attr__( 'No', 'vaathi-shop' )
                                )
                            )
                        )
                    );

                /**
                * Option : Apply Isotope
                */
                $wp_customize->add_setting(
                    VAATHI_CUSTOMISER_VAL . '[wdt-woo-shop-page-apply-isotope]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Vaathi_Customize_Control_Switch(
                        $wp_customize, VAATHI_CUSTOMISER_VAL . '[wdt-woo-shop-page-apply-isotope]', array(
                            'type'    => 'wdt-switch',
                            'label'   => esc_html__( 'Apply Isotope', 'vaathi-shop'),
                            'section' => 'woocommerce-shop-page-section',
                            'choices' => array(
                                'on'  => esc_attr__( 'Yes', 'vaathi-shop' ),
                                'off' => esc_attr__( 'No', 'vaathi-shop' )
                            )
                        )
                    )
                );

                /**
                 * Option : Show Sorter On Header
                 */
                    $wp_customize->add_setting(
                        VAATHI_CUSTOMISER_VAL . '[wdt-woo-shop-page-show-sorter-on-header]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new Vaathi_Customize_Control_Switch(
                            $wp_customize, VAATHI_CUSTOMISER_VAL . '[wdt-woo-shop-page-show-sorter-on-header]', array(
                                'type'    => 'wdt-switch',
                                'label'   => esc_html__( 'Show Sorter On Header', 'vaathi-shop'),
                                'section' => 'woocommerce-shop-page-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'vaathi-shop' ),
                                    'off' => esc_attr__( 'No', 'vaathi-shop' )
                                )
                            )
                        )
                    );

                /**
                 * Option : Sorter Header Elements
                 */
                    $wp_customize->add_setting(
                        VAATHI_CUSTOMISER_VAL . '[wdt-woo-shop-page-sorter-header-elements]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control( new Vaathi_Customize_Control_Sortable(
                        $wp_customize, VAATHI_CUSTOMISER_VAL . '[wdt-woo-shop-page-sorter-header-elements]', array(
                            'type' => 'wdt-sortable',
                            'label' => esc_html__( 'Sorter Header Elements', 'vaathi-shop'),
                            'section' => 'woocommerce-shop-page-section',
                            'choices' => apply_filters( 'vaathi_shop_header_sorter_elements', array(
                                'filter'               => esc_html__( 'Filter - OrderBy', 'vaathi-shop' ),
                                'filters_widget_area'  => esc_html__( 'Filters - Widget Area', 'vaathi-shop' ),
                                'result_count'         => esc_html__( 'Result Count', 'vaathi-shop' ),
                                'pagination'           => esc_html__( 'Pagination', 'vaathi-shop' ),
                                'display_mode'         => esc_html__( 'Display Mode', 'vaathi-shop' ),
                                'display_mode_options' => esc_html__( 'Display Mode Options', 'vaathi-shop' )
                            )),
                        )
                    ));

                /**
                 * Option : Show Sorter On Footer
                 */
                    $wp_customize->add_setting(
                        VAATHI_CUSTOMISER_VAL . '[wdt-woo-shop-page-show-sorter-on-footer]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new Vaathi_Customize_Control_Switch(
                            $wp_customize, VAATHI_CUSTOMISER_VAL . '[wdt-woo-shop-page-show-sorter-on-footer]', array(
                                'type'    => 'wdt-switch',
                                'label'   => esc_html__( 'Show Sorter On Footer', 'vaathi-shop'),
                                'section' => 'woocommerce-shop-page-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'vaathi-shop' ),
                                    'off' => esc_attr__( 'No', 'vaathi-shop' )
                                )
                            )
                        )
                    );

                /**
                 * Option : Sorter Footer Elements
                 */
                    $wp_customize->add_setting(
                        VAATHI_CUSTOMISER_VAL . '[wdt-woo-shop-page-sorter-footer-elements]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control( new Vaathi_Customize_Control_Sortable(
                        $wp_customize, VAATHI_CUSTOMISER_VAL . '[wdt-woo-shop-page-sorter-footer-elements]', array(
                            'type' => 'wdt-sortable',
                            'label' => esc_html__( 'Sorter Footer Elements', 'vaathi-shop'),
                            'section' => 'woocommerce-shop-page-section',
                            'choices' => apply_filters( 'vaathi_shop_footer_sorter_elements', array(
                                'filter'               => esc_html__( 'Filter', 'vaathi-shop' ),
                                'result_count'         => esc_html__( 'Result Count', 'vaathi-shop' ),
                                'pagination'           => esc_html__( 'Pagination', 'vaathi-shop' ),
                                'display_mode'         => esc_html__( 'Display Mode', 'vaathi-shop' ),
                                'display_mode_options' => esc_html__( 'Display Mode Options', 'vaathi-shop' )
                            )),
                        )
                    ));

                /**
                 * Option : Hooks - Page Top
                 */
                    $wp_customize->add_setting(
                        VAATHI_CUSTOMISER_VAL . '[wdt-woo-shop-page-template-hooks-page-top]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new Vaathi_Customize_Control(
                            $wp_customize, VAATHI_CUSTOMISER_VAL . '[wdt-woo-shop-page-template-hooks-page-top]', array(
                                'type'     => 'select',
                                'label'    => esc_html__( 'Template Hooks - Page Top', 'vaathi-shop'),
                                'description'   => esc_html__('Choose elementor template that you want to display in Shop page top position.', 'vaathi-shop'),
                                'section'  => 'woocommerce-shop-page-section',
                                'choices'  => vaathi_elementor_page_list()
                            )
                        )
                    );

                /**
                 * Option : Hooks - Page Bottom
                 */
                    $wp_customize->add_setting(
                        VAATHI_CUSTOMISER_VAL . '[wdt-woo-shop-page-template-hooks-page-bottom]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new Vaathi_Customize_Control(
                            $wp_customize, VAATHI_CUSTOMISER_VAL . '[wdt-woo-shop-page-template-hooks-page-bottom]', array(
                                'type'     => 'select',
                                'label'    => esc_html__( 'Template Hooks - Page Bottom', 'vaathi-shop'),
                                'description'   => esc_html__('Choose elementor template that you want to display in Shop page bottom position.', 'vaathi-shop'),
                                'section'  => 'woocommerce-shop-page-section',
                                'choices'  => vaathi_elementor_page_list()
                            )
                        )
                    );

                /**
                 * Option : Hooks - Content Top
                 */
                    $wp_customize->add_setting(
                        VAATHI_CUSTOMISER_VAL . '[wdt-woo-shop-page-template-hooks-content-top]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new Vaathi_Customize_Control(
                            $wp_customize, VAATHI_CUSTOMISER_VAL . '[wdt-woo-shop-page-template-hooks-content-top]', array(
                                'type'     => 'select',
                                'label'    => esc_html__( 'Template Hooks - Content Top', 'vaathi-shop'),
                                'description'   => esc_html__('Choose elementor template that you want to display in Shop page content top position.', 'vaathi-shop'),
                                'section'  => 'woocommerce-shop-page-section',
                                'choices'  => vaathi_elementor_page_list()
                            )
                        )
                    );

                /**
                 * Option : Hooks - Content Bottom
                 */
                    $wp_customize->add_setting(
                        VAATHI_CUSTOMISER_VAL . '[wdt-woo-shop-page-template-hooks-content-bottom]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new Vaathi_Customize_Control(
                            $wp_customize, VAATHI_CUSTOMISER_VAL . '[wdt-woo-shop-page-template-hooks-content-bottom]', array(
                                'type'     => 'select',
                                'label'    => esc_html__( 'Template Hooks - Content Bottom', 'vaathi-shop'),
                                'description'   => esc_html__('Choose elementor template that you want to display in Shop page content bottom position.', 'vaathi-shop'),
                                'section'  => 'woocommerce-shop-page-section',
                                'choices'  => vaathi_elementor_page_list()
                            )
                        )
                    );

        }

        function woo_handle_product_breadcrumb() {

            if(is_shop() && vaathi_customizer_settings('wdt-woo-shop-page-disable-breadcrumb' )) {
                remove_action('vaathi_breadcrumb', 'vaathi_breadcrumb_template');
            }

        }

    }

}


if( !function_exists('vaathi_shop_listing_customizer_shop') ) {
	function vaathi_shop_listing_customizer_shop() {
		return Vaathi_Shop_Listing_Customizer_Shop::instance();
	}
}

vaathi_shop_listing_customizer_shop();