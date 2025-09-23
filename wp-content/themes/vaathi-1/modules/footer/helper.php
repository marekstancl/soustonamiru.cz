<?php
add_action( 'vaathi_after_main_css', 'footer_style' );
function footer_style() {
    wp_enqueue_style( 'vaathi-footer', get_theme_file_uri('/modules/footer/assets/css/footer.css'), false, VAATHI_THEME_VERSION, 'all');
}

add_action( 'vaathi_footer', 'footer_content' );
function footer_content() {
    vaathi_template_part( 'content', 'content', 'footer' );
}