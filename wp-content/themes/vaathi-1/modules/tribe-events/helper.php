<?php

if (!function_exists('vaathi_event_breadcrumb_title')) {
    function vaathi_event_breadcrumb_title($title)
    {
        if (get_post_type() == 'tribe_events' && is_single()) {
            $etitle = esc_html__('Class Details', 'vaathi');
            $data = '';
            $post_id = get_the_ID();
            $post_title = get_the_title($post_id);
            $data .= '<h1>' . $etitle . '</h1>';
            $data .= '<div class="breadcrumb"><a href="' . home_url('/') . '">Home</a><span class="breadcrumb-default-delimiter"></span><span class="current">' . $post_title . '</span></div>';
            return $data;
        } else {
            return $title;
        }
    }

    add_filter('vaathi_breadcrumb_title', 'vaathi_event_breadcrumb_title', 20, 1);
}

?>