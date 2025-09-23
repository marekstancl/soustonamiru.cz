<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'VaathiPlusSiteBlog' ) ) {
    class VaathiPlusSiteBlog {

        private static $_instance = null;
        public $element_position = array();

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->load_modules();
            $this->load_pagination_layouts();
            $this->frontend();
        }

        function load_modules() {
            include_once VAATHI_PLUS_DIR_PATH.'modules/blog/elementor/index.php';
            include_once VAATHI_PLUS_DIR_PATH.'modules/blog/customizer/index.php';
        }

        function load_pagination_layouts() {
            foreach( glob( VAATHI_PLUS_DIR_PATH. 'modules/blog/templates/post-pagination/*/index.php'  ) as $module ) {
                include_once $module;
            }
        }

        function frontend() {

            $elp = vaathi_customizer_settings( 'blog-elements-position' );
            if( is_array( $elp ) ) {
                foreach( $elp as $ep ) {
                    $this->element_position[$ep] = $ep;
                }
            }

            add_action( 'vaathi_after_main_css', array( $this, 'enqueue_css_assets' ), 20 );

            add_filter( 'post_class', array( $this, 'register_add_remove_post_class' ), 15, 1 );
            add_filter( 'vaathi_archive_blog_post_params', array( $this, 'register_archive_blog_post_params' ) );
            add_filter( 'vaathi_archive_post_cmb_class', array( $this, 'register_archive_post_cmb_class' ) );
            add_filter( 'vaathi_archive_post_hld_class', array( $this, 'register_archive_post_hld_class' ) );
            add_filter( 'vaathi_blog_archive_pagination', array( $this, 'register_blog_archive_pagination' ) );
            add_action( 'vaathi_blog_archive_post_thumbnail', array( $this, 'register_blog_archive_post_thumbnail' ), 10, 3 );
            add_action( 'vaathi_blog_archive_post_format', array( $this, 'register_blog_archive_post_format' ), 10, 2 );
            add_filter( 'vaathi_blog_archive_order_params', array( $this, 'register_blog_archive_order_params' ), 10, 1 );
            add_action( 'vaathi_blog_post_entry_details_close_wrap', array( $this, 'register_blog_post_entry_details_close_wrap' ), 10 );
        }

        function enqueue_css_assets() {
            wp_enqueue_style( 'vaathi-plus-blog', VAATHI_PLUS_DIR_URL . 'modules/blog/assets/css/blog.css', false, VAATHI_PLUS_VERSION, 'all');

            $post_style = vaathi_get_archive_post_style();

            $file_path = VAATHI_PLUS_DIR_PATH . 'modules/blog/templates/'.esc_attr($post_style).'/assets/css/blog-archive-'.esc_attr($post_style).'.css';
            if ( file_exists( $file_path ) ) {
                wp_enqueue_style( 'wdt-blog-archive-'.esc_attr($post_style), VAATHI_PLUS_DIR_URL . 'modules/blog/templates/'.esc_attr($post_style).'/assets/css/blog-archive-'.esc_attr($post_style).'.css', false, VAATHI_PLUS_VERSION, 'all');
            }

        }

        function register_add_remove_post_class( $classes ) {
            if( !array_key_exists( 'feature_image', $this->element_position ) && ( is_post_type_archive('post') || is_search() || is_home() || ( defined('DOING_AJAX') && DOING_AJAX ) ) ) {
                if( ( $key = array_search( 'has-post-thumbnail', $classes ) ) !== false ) {
                    unset( $classes[$key] );
                }
            }

            global $post;
            if ( is_sticky( $post->ID ) ) {
                $classes[] = 'sticky';
            }

            return $classes;
        }

        function register_archive_blog_post_params() {

            $params = array(
                'enable_post_format'      => vaathi_customizer_settings( 'enable-post-format' ),
                'enable_video_audio'      => vaathi_customizer_settings( 'enable-video-audio' ),
                'enable_gallery_slider'   => vaathi_customizer_settings( 'enable-gallery-slider' ),
                'archive_post_elements'   => vaathi_customizer_settings( 'blog-elements-position' ),
                'archive_meta_elements'   => vaathi_customizer_settings( 'blog-meta-position' ),
                'archive_readmore_text'   => vaathi_customizer_settings( 'blog-readmore-text' ),
                'enable_excerpt_text'     => vaathi_customizer_settings( 'enable-excerpt-text' ),
                'archive_excerpt_length'  => vaathi_customizer_settings( 'blog-excerpt-length' ),
                'enable_disqus_comments'  => vaathi_customizer_settings( 'enable_disqus_comments' ),
                'post_disqus_shortname'   => vaathi_customizer_settings( 'post_disqus_shortname' ),
                'archive_blog_pagination' => vaathi_customizer_settings( 'blog-pagination' )
            );

            return $params;
        }

        function register_archive_post_cmb_class( $option = array() ) {

            $option['post-layout']      = vaathi_customizer_settings( 'blog-post-layout' );
            $option['post-gl-style']    = vaathi_customizer_settings( 'blog-post-grid-list-style' );
            $option['post-cover-style'] = vaathi_customizer_settings( 'blog-post-cover-style' );
            $option['list-type']        = vaathi_customizer_settings( 'blog-list-thumb' );
            $option['hover-style']      = vaathi_customizer_settings( 'blog-image-hover-style' );
            $option['overlay-style']    = vaathi_customizer_settings( 'blog-image-overlay-style' );
            $option['post-align']       = vaathi_customizer_settings( 'blog-alignment' );
            $option['post-column']      = vaathi_customizer_settings( 'blog-post-columns' );

            $option = apply_filters('register_archive_post_cmb_elementor_class', $option);

            return $option;
        }

        function register_archive_post_hld_class( $option = array() ) {

            $option['enable-equal-height'] = vaathi_customizer_settings( 'enable-equal-height' );
            $option['enable-no-space']     = vaathi_customizer_settings( 'enable-no-space' );

            return $option;
        }

        function register_blog_archive_pagination( $template ) {

            $pagination_template = $this->register_archive_blog_post_params();
            $pagination_template = $pagination_template['archive_blog_pagination'];

            $param1 = $this->register_archive_post_cmb_class();
            $param2 = $this->register_archive_post_hld_class();

            $template_args = array_merge( $param1, $param2 );
            echo vaathi_get_template_part( 'blog/templates/', 'post-pagination/'.esc_attr($pagination_template).'/'.'post', '', $template_args );
        }

        function register_blog_archive_post_thumbnail( $post_ID, $img_size, $post_column ) {

            $options = $this->register_archive_post_cmb_class();

            switch ( $options['post-layout'] ) {
                case 'entry-grid':
                    echo '<a href="'.get_permalink($post_ID).'" title="'.sprintf(esc_attr__('Permalink to %s','vaathi-plus'), the_title_attribute('echo=0')).'">'.get_the_post_thumbnail( $post_ID, $img_size[$post_column] ).'</a>';
                    break;

                default:
                    $entry_bg = '';
                    $url = get_the_post_thumbnail_url( $post_ID, 'full' );
                    $entry_bg = "style=background-image:url(".esc_url($url).")";

                    echo '<div class="blog-image">';
                        echo '<a '.vaathi_html_output($entry_bg).' href="'.get_permalink( $post_ID ).'" title="'.sprintf(esc_attr__('Permalink to %s','vaathi-plus'), the_title_attribute('echo=0')).'"></a>';
                    echo '</div>';
                    break;
            }
        }

        function register_blog_archive_post_format( $enable_post_format, $post_format ) {

            if( $enable_post_format ) {

                $options = $this->register_archive_post_cmb_class();

                switch ( $options['post-layout'] ) {
                    case 'entry-cover':
                        echo '</div><!-- Featured Image -->';
                        echo '<!-- Post Format -->';
                        echo '<div class="entry-format">';
                            echo '<a class="ico-format" href="'.esc_url(get_post_format_link( $post_format )).'"></a>';
                        echo '</div><!-- Post Format -->';

                        // When image with details, seperate via extra div here...
                        echo '<!-- Entry Details --><div class="entry-details">';

                        break;

                    default:
                            echo '<!-- Post Format -->';
                            echo '<div class="entry-format">';
                                echo '<a class="ico-format" href="'.esc_url(get_post_format_link( $post_format )).'"></a>';
                            echo '</div><!-- Post Format -->';
                        echo '</div><!-- Featured Image -->';
                        break;
                }
            } else {
                $options = $this->register_archive_post_cmb_class();

                if( $options['post-layout'] == 'entry-cover' ) {
                    echo '</div><!-- Featured Image -->';
                    echo '<!-- Entry Details --><div class="entry-details">';
                } else {
                    echo '</div><!-- Featured Image -->';
                }
            }
        }

        function register_blog_archive_order_params( $template_args ) {

            $archive_post_elements = $this->element_position;
            $post_layout           = $this->register_archive_post_cmb_class();
            $post_layout           = $post_layout['post-layout'];

            if( array_key_exists( 'feature_image', $archive_post_elements ) && ( $post_layout == 'entry-list' || $post_layout == 'entry-cover' ) ) {
                $archive_post_elements = array( 'feature_image' => $archive_post_elements['feature_image'] ) + $archive_post_elements;
                $template_args['archive_post_elements'] = $archive_post_elements;
            }

            return $template_args;
        }

        function register_blog_post_entry_details_close_wrap() {

            $post_elements = $this->element_position;
            $post_layout = $this->register_archive_post_cmb_class();
            $post_layout   = $post_layout['post-layout'];

            if( $post_layout == 'entry-cover' && array_key_exists( 'feature_image', $post_elements ) ):
                echo '</div><!-- Entry Details -->';
            endif;
        }
    }
}

VaathiPlusSiteBlog::instance();

if( !class_exists( 'VaathiPlusSiteRelatedBlog' ) ) {
    class VaathiPlusSiteRelatedBlog extends VaathiPlusSiteBlog {
        function __construct() {}
    }
}