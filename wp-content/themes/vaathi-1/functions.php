<?php

if( !class_exists( 'Vaathi_Loader' ) ) {

    class Vaathi_Loader {

        private static $_instance = null;

        private $theme_defaults = array ();

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->define_constants();
            $this->load_helpers();

            $this->theme_defaults = vaathi_theme_defaults();

            add_action( 'after_setup_theme', array( $this, 'set_theme_support' ) );

            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_js' ), 50 );

            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_css' ), 50 );
            add_action( 'wp_enqueue_scripts', array( $this, 'add_inline_style' ), 60 );

            add_action( 'vaathi_before_main_css', array( $this, 'add_google_fonts' ) );

            add_action( 'after_setup_theme', array( $this, 'include_module_helpers' ) );

            add_filter('ocdi/import_files', array($this, 'ocdi_import_files'), 10);
            add_filter('ocdi/after_import', array($this, 'import_elementor_on_theme_activation'), 11);
            add_filter('ocdi/import_files', array($this, 'ocdi_before_widgets_import'), 9);
            add_action('after_switch_theme', array($this, 'modify_xml_file'));
            add_action('ocdi/before_content_import', array($this, 'woocommerce_before_content_import'));
            add_filter('ocdi/regenerate_thumbnails_in_content_import', '__return_false');
            add_filter('ocdi/after_import', array($this, 'ocdi_after_import_setup'), 11);

        }

        function define_constants() {
            define( 'VAATHI_ROOT_DIR', get_template_directory() );
            define( 'VAATHI_ROOT_URI', get_template_directory_uri() );
            define( 'VAATHI_MODULE_DIR', VAATHI_ROOT_DIR.'/modules'  );
            define( 'VAATHI_MODULE_URI', VAATHI_ROOT_URI.'/modules' );
            define( 'VAATHI_LANG_DIR', VAATHI_ROOT_DIR.'/languages' );

            $theme = wp_get_theme();
            define( 'VAATHI_THEME_NAME', $theme->get('Name'));
            define( 'VAATHI_THEME_VERSION', $theme->get('Version'));
        }

        function load_helpers() {
            include_once VAATHI_ROOT_DIR . '/helpers/helper.php';
        }
        //one click demo import
        function woocommerce_before_content_import()
        {
            $woocommerce_pages = [
                'shop',
                'cart',
                'checkout',
                'my-account',
            ];
            foreach ($woocommerce_pages as $slug) {
                $page = get_page_by_path($slug);
                if (
                    $page
                ) {
                    wp_delete_post($page->ID, true);
                }
            }
        }
        function ocdi_import_files()
        {
            return array(
                array(
                    'import_file_name' => 'Default Demo',
                    'import_file_url' => VAATHI_ROOT_URI . '/ocdi/theme-content.xml',
                    'import_customizer_file_url' => VAATHI_ROOT_URI . '/ocdi/theme-customizer.dat',
                    'import_widget_file_url' => VAATHI_ROOT_URI . '/ocdi/theme-widgets.wie',
                    'import_preview_image_url' => VAATHI_ROOT_URI . '/screenshot.png',
                    'import_notice' => __('After you import this demo, you will have to setup the slider separately.', 'vaathi'),
                    'preview_url' => 'https://vaathi.wpengine.com/',
                )
            );
        }
        function modify_xml_file()
        {
            // Define paths
            $themeRootDirUri = get_template_directory_uri() . '/ocdi/uploads/';
            $themeRootDirUri1 = get_template_directory_uri();
            $themeRootDir = get_template_directory();
            $themeName = basename($themeRootDir); // Get the current theme directory name
            $xmlFilePath = $themeRootDir . '/ocdi/theme-content.xml';
            if (file_exists($xmlFilePath)) {
                $dom = new DOMDocument();
                $dom->load($xmlFilePath);
                $xmlContent = $dom->saveXML();
                $replacements = [
                    '<wp:attachment_url><![CDATA[https://vaathi.wpengine.com/wp-content/uploads/' => '<wp:attachment_url><![CDATA[' . $themeRootDirUri,
                    'src="https://vaathi.wpengine.com/wp-content/uploads/' => 'src="' . $themeRootDirUri,
                    '<guid isPermaLink="false">https://vaathi.wpengine.com/wp-content/uploads/' => '<guid isPermaLink="false">' . $themeRootDirUri,
                    '<link>https://vaathi.wpengine.com' => '<link>' . $themeRootDirUri1,
                    'href="https://vaathi.wpengine.com' => 'href="' . $themeRootDirUri1,
                    'https:\/\/vaathi.wpengine.com' => home_url(),
                    'https://vaathi.wpengine.com' => home_url(),
                    '\/wp-content\/uploads' => '\/wp-content\/themes\/' . $themeName . '\/ocdi\/uploads'
                ];
                foreach ($replacements as $oldUrl => $newUrl) {
                    $xmlContent = str_replace($oldUrl, $newUrl, $xmlContent);
                }
                $dom->loadXML($xmlContent);
                $dom->save($xmlFilePath);
                echo "XML file has been modified and saved successfully.";
            } else {
                echo "XML file does not exist.";
            }
        }
        function ocdi_before_widgets_import()
        {
            $widget_file_path = VAATHI_ROOT_DIR . '/ocdi/theme-widgets.wie';
            $json_data = file_get_contents($widget_file_path);
            $settings = json_decode($json_data, true);
            $term = 'wdt-cw-';
            $newarr = array();
            foreach ($settings as $key => $value) {
                if (stripos($key, $term) !== false) {
                    $separated_string = str_replace($term, "", $key);
                    register_sidebar(array(
                        'name' => $key,
                        'id' => $key,
                        'before_widget' => '<div class="widget">',
                        'after_widget' => '</div>',
                        'before_title' => '<h2 class="widget-title">',
                        'after_title' => '</h2>',
                    ));
                    $newarr[] = $key;
                }
            }

            $widget_areas_option = get_option('vaathi-widget-areas');
            if (!empty($widget_areas_option) && is_array($widget_areas_option)) {
                $widget_areas1['widget-areas'] = array_unique(array_merge($newarr, $widget_areas_option['widget-areas']));
                update_option('vaathi-widget-areas', $widget_areas1);
            } else {
                $widget_empty = array('widget-areas' => array());
                $widget_areas1['widget-areas'] = array_unique(array_merge($newarr, $widget_empty['widget-areas']));
                update_option('vaathi-widget-areas', $widget_areas1);
            }
        }
        function import_elementor_on_theme_activation()
        {
            $theme_dir = get_template_directory();
            $file_path = $theme_dir . '/ocdi/site-settings.json';
            if (file_exists($file_path)) {
                $json_data = file_get_contents($file_path);
                $settings = json_decode($json_data, true);
                $settings_data = $settings['settings'];
                unset($settings_data['template']);
                $args = array(
                    'post_type' => 'elementor_library',
                    'post_status' => 'publish',
                    'post_title' => 'Default Kit',
                    'fields' => 'ids',
                );
                $query = new WP_Query($args);
                if ($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post();
                        $post_id = get_the_ID();
                        $meta_data = array(
                            '_elementor_edit_mode' => 'builder',
                            '_wp_page_template' => 'default',
                            '_elementor_page_settings' => $settings_data,
                        );
                        foreach ($meta_data as $meta_key => $meta_value) {
                            add_post_meta($post_id, $meta_key, $meta_value);
                        }
                    }
                    wp_reset_postdata();
                }
            }

            // Helper function to get page ID by title
            function get_page_id_by_title($title)
            {
                $query = new WP_Query(array(
                    'post_type' => 'page',
                    'title' => $title,
                    'post_status' => 'publish',
                    'posts_per_page' => 1,
                    'fields' => 'ids',
                ));
                if ($query->have_posts()) {
                    $query->the_post();
                    $page_id = get_the_ID();
                    wp_reset_postdata();
                    return $page_id;
                }
                return null;
            }
            // Set default pages
            $front_page_id = get_page_id_by_title('Home');
            $shop_page_id = get_page_id_by_title('Shop');
            $shop_cart_id = get_page_id_by_title('Cart');
            $shop_checkout_id = get_page_id_by_title('Checkout');
            if ($front_page_id) {
                update_option('show_on_front', 'page');
                update_option('page_on_front', $front_page_id);
            }
            if ($shop_cart_id) {
                update_option('woocommerce_cart_page_id', $shop_cart_id);
            }
            if ($shop_checkout_id) {
                update_option('woocommerce_checkout_page_id', $shop_checkout_id);
            }
            if ($shop_page_id) {
                update_option('woocommerce_shop_page_id', $shop_page_id);
            }
        }
        function ocdi_after_import_setup()
        {
            $product_template_file_path = VAATHI_ROOT_DIR . '/ocdi/product-template.txt';
            if (is_file($product_template_file_path) && is_readable($product_template_file_path)) {
                $file_contents = file_get_contents($product_template_file_path);
                if ($file_contents !== false) {
                    $data = @unserialize($file_contents);
                    if ($data !== false) {
                        update_option('_vaathi_cs_options', $data);
                    } else {
                        error_log("Failed to unserialize data.");
                    }
                } else {
                    error_log("Unable to read file: " . $product_template_file_path);
                }
            } else {
                error_log("Unable to read file: " . $product_template_file_path);
            }
        }

        function set_theme_support() {
            load_theme_textdomain( 'vaathi', VAATHI_LANG_DIR );
            add_theme_support( 'automatic-feed-links' );
            add_theme_support( 'title-tag' );
            add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
            add_theme_support( 'post-formats', array('status', 'quote', 'gallery', 'image', 'video', 'audio', 'link', 'aside', 'chat'));
            add_theme_support( 'post-thumbnails' );
            add_theme_support( 'custom-logo' );
            add_theme_support( 'custom-background', array( 'default-color' => '#d1e4dd' ) );
            add_theme_support( 'custom-header' );

			add_theme_support( 'align-wide' ); // Gutenberg wide images.
            add_theme_support( 'editor-color-palette', array(
                array(
                    'name'  => esc_html__( 'Primary Color', 'vaathi' ),
                    'slug'  => 'primary',
                    'color'	=> $this->theme_defaults['primary_color'],
                ),
                array(
                    'name'  => esc_html__( 'Secondary Color', 'vaathi' ),
                    'slug'  => 'secondary',
                    'color' => $this->theme_defaults['secondary_color'],
                ),
                array(
                    'name'  => esc_html__( 'Tertiary Color', 'vaathi' ),
                    'slug'  => 'tertiary',
                    'color' => $this->theme_defaults['tertiary_color'],
                ),
                array(
                    'name'  => esc_html__( 'Body Background Color', 'vaathi' ),
                    'slug'  => 'body-bg',
                    'color' => $this->theme_defaults['body_bg_color'],
                ),
                array(
                    'name'  => esc_html__( 'Body Text Color', 'vaathi' ),
                    'slug'  => 'body-text',
                    'color' => $this->theme_defaults['body_text_color'],
                ),
                array(
                    'name'  => esc_html__( 'Alternate Color', 'vaathi' ),
                    'slug'  => 'alternate',
                    'color' => $this->theme_defaults['headalt_color'],
                ),
                array(
                    'name'  => esc_html__( 'Transparent Color', 'vaathi' ),
                    'slug'  => 'transparent',
                    'color' => 'rgba(0,0,0,0)',
                )
            ) );

            add_theme_support( 'editor-styles' );
            add_editor_style( './assets/css/style-editor.css' );

            $GLOBALS['content_width'] = apply_filters( 'vaathi_set_content_width', 1230 );
            register_nav_menus( array(
                'main-menu' => esc_html__('Main Menu', 'vaathi'),
            ) );
        }

        function enqueue_js() {

            wp_enqueue_script( 'wc-cart-fragments' );
            wp_enqueue_script('jquery-select2', get_theme_file_uri('/assets/lib/select2/select2.full.js'), array('jquery'), false, true);
            wp_enqueue_script('flatpickr');

            /**
             * Before Hook
             */
            do_action( 'vaathi_before_enqueue_js' );

                wp_enqueue_script('vaathi-jqcustom', get_theme_file_uri('/assets/js/custom.js'), array('jquery'), false, true);

                if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				    wp_enqueue_script( 'comment-reply' );
			    }

            /**
             * After Hook
             */
            do_action( 'vaathi_after_enqueue_js' );

        }

        function enqueue_css() {
            /**
             * Before Hook
             */
            do_action( 'vaathi_before_main_css' );
                wp_enqueue_style('flatpickr');
                wp_enqueue_style( 'vaathi', get_stylesheet_uri(), false, VAATHI_THEME_VERSION, 'all' );
                wp_enqueue_style( 'vaathi-icons', get_theme_file_uri('/assets/css/icons.css'), false, VAATHI_THEME_VERSION, 'all');

                $css = $this->generate_theme_default_css();
                if( !empty( $css ) ) {
                    wp_add_inline_style( 'vaathi', ':root {'.$css.'}' );
                }

                wp_enqueue_style( 'vaathi-base', get_theme_file_uri('/assets/css/base.css'), false, VAATHI_THEME_VERSION, 'all');
                wp_enqueue_style( 'vaathi-grid', get_theme_file_uri('/assets/css/grid.css'), false, VAATHI_THEME_VERSION, 'all');
                wp_enqueue_style( 'vaathi-layout', get_theme_file_uri('/assets/css/layout.css'), false, VAATHI_THEME_VERSION, 'all');
                wp_enqueue_style( 'vaathi-additional', get_theme_file_uri('/assets/css/additional.css'), false, VAATHI_THEME_VERSION, 'all');
                wp_enqueue_style( 'vaathi-e-flex-con', get_theme_file_uri('/assets/css/e-flex-con.css'), false, VAATHI_THEME_VERSION, 'all');
                wp_enqueue_style( 'vaathi-widget', get_theme_file_uri('/assets/css/widget.css'), false, VAATHI_THEME_VERSION, 'all');
                wp_enqueue_style( 'vaathi-additional-2', get_theme_file_uri('/assets/css/additional-2.css'), false, VAATHI_THEME_VERSION, 'all');

            /**
             * After Hook
             */
            do_action( 'vaathi_after_main_css' );

            wp_enqueue_style( 'jquery-select2', get_theme_file_uri('/assets/lib/select2/select2.css'), false, VAATHI_THEME_VERSION, 'all');

            wp_enqueue_style( 'vaathi-theme', get_theme_file_uri('/assets/css/theme.css'), false, VAATHI_THEME_VERSION, 'all');
        }

        function generate_theme_default_css() {

            $css = '';

            $css .= apply_filters( 'vaathi_primary_color_css_var',  '--wdtPrimaryColor: '.$this->theme_defaults['primary_color'].';' );
            $css .= apply_filters( 'vaathi_primary_rgb_color_css_var',  '--wdtPrimaryColorRgb: '.$this->theme_defaults['primary_color_rgb'].';' );
            $css .= apply_filters( 'vaathi_secondary_color_css_var',  '--wdtSecondaryColor: '.$this->theme_defaults['secondary_color'].';' );
            $css .= apply_filters( 'vaathi_secondary_rgb_color_css_var',  '--wdtSecondaryColorRgb: '.$this->theme_defaults['secondary_color_rgb'].';' );
            $css .= apply_filters( 'vaathi_tertiary_color_css_var',  '--wdtTertiaryColor: '.$this->theme_defaults['tertiary_color'].';' );
            $css .= apply_filters( 'vaathi_tertiary_rgb_color_css_var',  '--wdtTertiaryColorRgb: '.$this->theme_defaults['tertiary_color_rgb'].';' );
            $css .= apply_filters( 'vaathi_body_bg_color_css_var',  '--wdtBodyBGColor: '.$this->theme_defaults['body_bg_color'].';' );
            $css .= apply_filters( 'vaathi_body_bg_rgb_color_css_var',  '--wdtBodyBGColorRgb: '.$this->theme_defaults['body_bg_color_rgb'].';' );
            $css .= apply_filters( 'vaathi_body_text_color_css_var',  '--wdtBodyTxtColor:'.$this->theme_defaults['body_text_color'].';' );
            $css .= apply_filters( 'vaathi_body_text_rgb_color_css_var',  '--wdtBodyTxtColorRgb:'.$this->theme_defaults['body_text_color_rgb'].';' );
            $css .= apply_filters( 'vaathi_headalt_color_css_var',  '--wdtHeadAltColor: '.$this->theme_defaults['headalt_color'].';' );
            $css .= apply_filters( 'vaathi_headalt_rgb_color_css_var',  '--wdtHeadAltColorRgb: '.$this->theme_defaults['headalt_color_rgb'].';' );
            $css .= apply_filters( 'vaathi_link_color_css_var',  '--wdtLinkColor: '.$this->theme_defaults['link_color'].';' );
            $css .= apply_filters( 'vaathi_link_rgb_color_css_var',  '--wdtLinkColorRgb: '.$this->theme_defaults['link_color_rgb'].';' );
            $css .= apply_filters( 'vaathi_link_hover_color_css_var',  '--wdtLinkHoverColor: '.$this->theme_defaults['link_hover_color'].';' );
            $css .= apply_filters( 'vaathi_link_hover_rgb_color_css_var',  '--wdtLinkHoverColorRgb: '.$this->theme_defaults['link_hover_color_rgb'].';' );
            $css .= apply_filters( 'vaathi_border_color_css_var',  '--wdtBorderColor: '.$this->theme_defaults['border_color'].';' );
            $css .= apply_filters( 'vaathi_border_rgb_color_css_var',  '--wdtBorderColorRgb: '.$this->theme_defaults['border_color_rgb'].';' );
            $css .= apply_filters( 'vaathi_accent_text_color_css_var',  '--wdtAccentTxtColor: '.$this->theme_defaults['accent_text_color'].';' );
            $css .= apply_filters( 'vaathi_accent_text_rgb_color_css_var',  '--wdtAccentTxtColorRgb: '.$this->theme_defaults['accent_text_color_rgb'].';' );

            if(isset($this->theme_defaults['body_typo']) && !empty($this->theme_defaults['body_typo'])) {

                $body_typo_css_var = apply_filters( 'vaathi_body_typo_customizer_update',  $this->theme_defaults['body_typo'] );

                $css .=  '--wdtFontTypo_Base: '.$body_typo_css_var['font-fallback'].';';
                $css .=  '--wdtFontWeight_Base: '.$body_typo_css_var['font-weight'].';';
                $css .=  '--wdtFontSize_Base: '.$body_typo_css_var['fs-desktop'].$body_typo_css_var['fs-desktop-unit'].';';
                $css .=  '--wdtLineHeight_Base: '.$body_typo_css_var['lh-desktop'].$body_typo_css_var['lh-desktop-unit'].';';
            }

            if(isset($this->theme_defaults['h1_typo']) && !empty($this->theme_defaults['h1_typo'])) {

                $h1_typo_css_var = apply_filters( 'vaathi_h1_typo_customizer_update',  $this->theme_defaults['h1_typo'] );

                $css .= '--wdtFontTypo_Alt: '.$h1_typo_css_var['font-fallback'].';';
                $css .= '--wdtFontWeight_Alt: '.$h1_typo_css_var['font-weight'].';';
                $css .= '--wdtFontSize_Alt: '.$h1_typo_css_var['fs-desktop'].$h1_typo_css_var['fs-desktop-unit'].';';
                $css .= '--wdtLineHeight_Alt: '.$h1_typo_css_var['lh-desktop'].$h1_typo_css_var['lh-desktop-unit'].';';

                $css .= '--wdtFontTypo_H1: '.$h1_typo_css_var['font-fallback'].';';
                $css .= '--wdtFontWeight_H1: '.$h1_typo_css_var['font-weight'].';';
                $css .= '--wdtFontSize_H1: '.$h1_typo_css_var['fs-desktop'].$h1_typo_css_var['fs-desktop-unit'].';';
                $css .= '--wdtLineHeight_H1: '.$h1_typo_css_var['lh-desktop'].$h1_typo_css_var['lh-desktop-unit'].';';

            }

            if(isset($this->theme_defaults['h2_typo']) && !empty($this->theme_defaults['h2_typo'])) {

                $h2_typo_css_var = apply_filters( 'vaathi_h2_typo_customizer_update',  $this->theme_defaults['h2_typo'] );

                $css .= '--wdtFontTypo_H2: '.$h2_typo_css_var['font-fallback'].';';
                $css .= '--wdtFontWeight_H2: '.$h2_typo_css_var['font-weight'].';';
                $css .= '--wdtFontSize_H2: '.$h2_typo_css_var['fs-desktop'].$h2_typo_css_var['fs-desktop-unit'].';';
                $css .= '--wdtLineHeight_H2: '.$h2_typo_css_var['lh-desktop'].$h2_typo_css_var['lh-desktop-unit'].';';

            }

            if(isset($this->theme_defaults['h3_typo']) && !empty($this->theme_defaults['h3_typo'])) {

                $h3_typo_css_var = apply_filters( 'vaathi_h3_typo_customizer_update',  $this->theme_defaults['h3_typo'] );

                $css .= '--wdtFontTypo_H3: '.$h3_typo_css_var['font-fallback'].';';
                $css .= '--wdtFontWeight_H3: '.$h3_typo_css_var['font-weight'].';';
                $css .= '--wdtFontSize_H3: '.$h3_typo_css_var['fs-desktop'].$h3_typo_css_var['fs-desktop-unit'].';';
                $css .= '--wdtLineHeight_H3: '.$h3_typo_css_var['lh-desktop'].$h3_typo_css_var['lh-desktop-unit'].';';

            }

            if(isset($this->theme_defaults['h4_typo']) && !empty($this->theme_defaults['h4_typo'])) {

                $h4_typo_css_var = apply_filters( 'vaathi_h4_typo_customizer_update',  $this->theme_defaults['h4_typo'] );

                $css .= '--wdtFontTypo_H4: '.$h4_typo_css_var['font-fallback'].';';
                $css .= '--wdtFontWeight_H4: '.$h4_typo_css_var['font-weight'].';';
                $css .= '--wdtFontSize_H4: '.$h4_typo_css_var['fs-desktop'].$h4_typo_css_var['fs-desktop-unit'].';';
                $css .= '--wdtLineHeight_H4: '.$h4_typo_css_var['lh-desktop'].$h4_typo_css_var['lh-desktop-unit'].';';

            }

            if(isset($this->theme_defaults['h5_typo']) && !empty($this->theme_defaults['h5_typo'])) {

                $h5_typo_css_var = apply_filters( 'vaathi_h5_typo_customizer_update',  $this->theme_defaults['h5_typo'] );

                $css .= '--wdtFontTypo_H5: '.$h5_typo_css_var['font-fallback'].';';
                $css .= '--wdtFontWeight_H5: '.$h5_typo_css_var['font-weight'].';';
                $css .= '--wdtFontSize_H5: '.$h5_typo_css_var['fs-desktop'].$h5_typo_css_var['fs-desktop-unit'].';';
                $css .= '--wdtLineHeight_H5: '.$h5_typo_css_var['lh-desktop'].$h5_typo_css_var['lh-desktop-unit'].';';

            }

            if(isset($this->theme_defaults['h6_typo']) && !empty($this->theme_defaults['h6_typo'])) {

                $h6_typo_css_var = apply_filters( 'vaathi_h6_typo_customizer_update',  $this->theme_defaults['h6_typo'] );

                $css .= '--wdtFontTypo_H6: '.$h6_typo_css_var['font-fallback'].';';
                $css .= '--wdtFontWeight_H6: '.$h6_typo_css_var['font-weight'].';';
                $css .= '--wdtFontSize_H6: '.$h6_typo_css_var['fs-desktop'].$h6_typo_css_var['fs-desktop-unit'].';';
                $css .= '--wdtLineHeight_H6: '.$h6_typo_css_var['lh-desktop'].$h6_typo_css_var['lh-desktop-unit'].';';

            }

            if(isset($this->theme_defaults['extra_typo']) && !empty($this->theme_defaults['extra_typo'])) {

                $css .= apply_filters( 'vaathi_typo_font_family_css_var',  '--wdtFontTypo_Ext: '.$this->theme_defaults['extra_typo']['font-fallback'].';' );
                $css .= apply_filters( 'vaathi_typo_font_weight_css_var',  '--wdtFontWeight_Ext: '.$this->theme_defaults['extra_typo']['font-weight'].';' );
                $css .= apply_filters( 'vaathi_typo_fs_desktop_css_var',  '--wdtFontSize_Ext: '.$this->theme_defaults['extra_typo']['fs-desktop'].$this->theme_defaults['extra_typo']['fs-desktop-unit'].';' );
                $css .= apply_filters( 'vaathi_typo_lh_desktop_css_var',  '--wdtLineHeight_Ext: '.$this->theme_defaults['extra_typo']['lh-desktop'].$this->theme_defaults['extra_typo']['lh-desktop-unit'].';' );

            }

            return $css;

        }

        function add_inline_style() {

            wp_register_style( 'vaathi-admin', '', array(), VAATHI_THEME_VERSION, 'all' );
            wp_enqueue_style( 'vaathi-admin' );

            $css = apply_filters( 'vaathi_add_inline_style', $css = '' );

            if( !empty( $css ) ) {
                wp_add_inline_style( 'vaathi-admin', $css );
            }

            /**
             * Responsive CSS
             */

                # Tablet Landscape
                    $tablet_landscape = apply_filters( 'vaathi_add_tablet_landscape_inline_style', $tablet_landscape = '' );
                    if( !empty( $tablet_landscape ) ) {
                        $tablet_landscape = '@media only screen and (min-width:1025px) and (max-width:1280px) {'."\n".$tablet_landscape."\n".'}';
                        wp_add_inline_style( 'vaathi-admin', $tablet_landscape );
                    }

                # Tablet Portrait
                    $tablet_portrait = apply_filters( 'vaathi_add_tablet_portrait_inline_style', $tablet_portrait = '' );
                    if( !empty( $tablet_portrait ) ) {
                        $tablet_portrait = '@media only screen and (min-width:768px) and (max-width:1024px) {'."\n".$tablet_portrait."\n".'}';
                        wp_add_inline_style( 'vaathi-admin', $tablet_portrait );
                    }

                # Mobile
                    $mobile_res = apply_filters( 'vaathi_add_mobile_res_inline_style', $mobile_res = '' );
                    if( !empty( $mobile_res ) ) {
                        $mobile_res = '@media (max-width: 767px) {'."\n".$mobile_res."\n".'}';
                        wp_add_inline_style( 'vaathi-admin', $mobile_res );
                    }

        }

        function add_google_fonts() {
            $subset = apply_filters( 'vaathi_google_font_supsets', 'latin-ext' );
            $fonts  = apply_filters( 'vaathi_google_fonts_list', array(
                'Outfit:100,200,300,400,500,600,700,800,900',
                'Syne:400,500,600,700,800',
                'Jost:100,200,300,regular,500,600,700,800,900,100italic,200italic,300italic,italic,500italic,600italic,700italic,800italic,900italic',
                'Permanent Marker:regular'
            ) );

			foreach( $fonts as $font ) {
				$url = '//fonts.googleapis.com/css?family=' . str_replace( ' ', '+', $font );
                $url .= !empty( $subset ) ? '&subset=' . $subset : '';

				$key = md5( $font . $subset );

				// check that the URL is valid. we're going to use transients to make this faster.
				$url_is_valid = get_transient( $key );

				// transient does not exist
				if ( false === $url_is_valid ) {
					$response = wp_remote_get( 'https:' . $url );
					if ( ! is_array( $response ) ) {
						// the url was not properly formatted,
						// cache for 12 hours and continue to the next field
						set_transient( $key, null, 12 * HOUR_IN_SECONDS );
						continue;
					}

					// check the response headers.
					if ( isset( $response['response'] ) && isset( $response['response']['code'] ) ) {
						if ( 200 == $response['response']['code'] ) {
							// URL was ok
							// set transient to true and cache for a week
							set_transient( $key, true, 7 * 24 * HOUR_IN_SECONDS );
							$url_is_valid = true;
						}
					}
				}

				// If the font-link is valid, enqueue it.
				if ( $url_is_valid ) {
					wp_enqueue_style( $key, $url, null, null );
				}
			}

        }

        function include_module_helpers() {

            /**
             * Before Hook
             */
            do_action( 'vaathi_before_load_module_helpers' );

            foreach( glob( VAATHI_ROOT_DIR. '/modules/*/helper.php'  ) as $helper ) {
                include_once $helper;
            }

            /**
             * After Hook
             */
            do_action( 'vaathi_after_load_module_helpers' );
        }

    }

    Vaathi_Loader::instance();
}