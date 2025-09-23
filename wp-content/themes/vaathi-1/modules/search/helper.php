<?php

    add_action( 'vaathi_after_main_css', 'search_style' );
    function search_style() {
        wp_enqueue_style( 'vaathi-quick-search', get_theme_file_uri('/modules/search/assets/css/search.css'), false, VAATHI_THEME_VERSION, 'all');
    }

    add_action('wp_ajax_vaathi_search_data_fetch' , 'vaathi_search_data_fetch');
	add_action('wp_ajax_nopriv_vaathi_search_data_fetch','vaathi_search_data_fetch');
	function vaathi_search_data_fetch(){
        $nonce = $_POST['security'];
        if ( ! wp_verify_nonce( $nonce, 'search_data_fetch_nonce' ) ) {
            die( 'Security check failed' );
        }
        $search_val = vaathi_sanitization($_POST['search_val']);

        $the_query = new WP_Query( array( 'posts_per_page' => 5, 's' => $search_val, 'post_type' => array('post', 'product') ) );
        if( $the_query->have_posts() ) :
            while( $the_query->have_posts() ): $the_query->the_post(); ?>
                <li class="quick_search_data_item">
                    <a href="<?php echo esc_url( get_permalink() ); ?>">
                        <?php the_post_thumbnail( 'thumbnail', array( 'class' => ' ' ) ); ?>
                        <?php the_title();?>
                    </a>
                </li>
            <?php endwhile;
            wp_reset_postdata();
        else:
            echo'<p>'. esc_html__( 'No Results Found', 'vaathi') .'</p>';
        endif;

        die();
}
add_action( 'wp_enqueue_scripts', 'vaathi_enqueue_scripts' );
    function vaathi_enqueue_scripts() {
        // Enqueue your script here
        wp_enqueue_script( 'vaathi-jqcustom', get_theme_file_uri('/assets/js/custom.js'), array('jquery'), false, true );
        // Create nonce and pass it to the script
        $ajax_nonce = wp_create_nonce( 'search_data_fetch_nonce' );
        wp_localize_script( 'vaathi-jqcustom', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'ajax_nonce' => $ajax_nonce ) );
    }

?>