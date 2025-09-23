<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'VaathiPlusCustomFooter' ) ) {
    class VaathiPlusCustomFooter {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'vaathi_footer_layouts', array( $this, 'add_custom_footer_option' ), 20 );
            add_action( 'customize_register', array( $this, 'register' ), 30 );
            add_filter( 'vaathi_footer_get_template_part', array( $this, 'register_footer_template' ), 10 );
        }

        function add_custom_footer_option( $options ) {
            $options['custom-footer'] = esc_html__('Custom Footer', 'vaathi-plus');
            return $options;
        }

        function register( $wp_customize ) {
            /**
             * Option :Site Elementor Footer
             */
            $wp_customize->add_setting(
                VAATHI_CUSTOMISER_VAL . '[site_custom_footer]', array(
                    'type'    => 'option',
                )
            );

            $wp_customize->add_control(
                new Vaathi_Customize_Control(
                    $wp_customize, VAATHI_CUSTOMISER_VAL . '[site_custom_footer]', array(
                        'type'       => 'select',
                        'section'    => 'site-footer-section',
                        'label'      => esc_html__( 'Footer Template', 'vaathi-plus' ),
                        'dependency' => array( 'site_footer', '==', 'custom-footer' ),
                        'choices'    => $this->footer_template_list()
                    )
                )
            );
        }

        public function footer_template_list() {
            $choices = array();
            $choices[''] = esc_html__('Select Footer Template', 'vaathi-plus' );

            $args = array(
                'post_type'      => 'wdt_footers',
                'orderby'        => 'title',
                'order'          => 'ASC',
                'posts_per_page' => -1,
                'post_status'    => 'publish'
            );

            $pages = get_posts($args);

            if ( ! is_wp_error( $pages ) && ! empty( $pages ) ) {

                foreach( $pages as $page ):
                    $choices[$page->ID]	= $page->post_title;
                endforeach;
            }

            return $choices;
        }

        function register_footer_template( $template ) {

            $footer_type = vaathi_customizer_settings( 'site_footer' );

            if( 'custom-footer' == $footer_type ) :

                $id = vaathi_customizer_settings( 'site_custom_footer' );
                if( $id > 0 ):
                    return apply_filters( 'vaathi_print_footer_template', $id );
                endif;

            endif;

            return $template;

        }
    }
}

VaathiPlusCustomFooter::instance();