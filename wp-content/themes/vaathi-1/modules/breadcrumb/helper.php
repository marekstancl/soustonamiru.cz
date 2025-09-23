<?php
add_action( 'vaathi_after_main_css', 'breadcrumb_style' );
function breadcrumb_style() {
    wp_enqueue_style( 'vaathi-breadcrumb', get_theme_file_uri('/modules/breadcrumb/assets/css/breadcrumb.css'), false, VAATHI_THEME_VERSION, 'all');
}

if( ! function_exists( 'vaathi_breadcrumb_template' )  ) {
	function vaathi_breadcrumb_template() {
        if ( !is_front_page() && !is_home() ) {
		    vaathi_template_part( 'breadcrumb', 'templates/title' );
        }
	}

	add_action( 'vaathi_breadcrumb', 'vaathi_breadcrumb_template' );
}
function vaathi_breadcrumb_params() {
    $params = array(
        "home"            => esc_html__('Home','vaathi'),
        "home_link"       => home_url('/'),
        "delimiter"       => '<span class="breadcrumb-default-delimiter"></span>',
        "wrapper_classes" => "dark-bg-breadcrumb aligncenter"
    );
    return apply_filters( 'vaathi_breadcrumb_params', $params );
}

if( ! function_exists( 'vaathi_update_header_wrapper_classes' )  ) {
	function vaathi_update_header_wrapper_classes($classes) {
        // array_push($classes, 'wdt-dark-bg'); // For dark bg enable this line
        return $classes;
	}
	add_filter( 'vaathi_header_wrapper_classes', 'vaathi_update_header_wrapper_classes', 10, 1 );
}

function vaathi_breadcrumb_title() {
    $title = get_the_title( vaathi_get_page_id() );

	if ( ( is_home() && is_front_page() ) || is_singular('attachment') ) {
        $title = get_option( 'blogname' );
    } elseif( is_archive() ) {
        $title = get_the_archive_title();
    } elseif ( is_search() ) {
        $title = esc_html__("Search Result for: ",'vaathi').' '.get_search_query();
    }

    return apply_filters( 'vaathi_breadcrumb_title', '<h1>'.$title.'</h1>' );
}

function vaathi_breadcrumbs( $home, $separator ) {
    $output      = '';
    $breadcrumbs = array();

    if( !empty( $home ) ) {
        $breadcrumbs[] =  '<a href="'. esc_url( $home['link'] ) .'">'. esc_html( $home['text'] ) .'</a>';
    }

    if ( is_category() ) {
        $breadcrumbs[] = '<a href="'. get_category_link( get_query_var('cat') ) .'">' . single_cat_title('', false) . '</a>';
    } elseif ( is_tag() ) {
        $breadcrumbs[] = '<a href="'. get_tag_link( get_query_var('tag_id') ) .'">' . single_tag_title('', false) . '</a>';
    } elseif( is_author() ){
        $breadcrumbs[] = '<a href="'. get_author_posts_url( get_the_author_meta( 'ID' ) ) .'">' . get_the_author() . '</a>';
    } elseif( is_day() || is_time() ){
        $breadcrumbs[] = '<a href="'. get_year_link( get_the_time('Y') ) . '">'. get_the_time('Y') .'</a>';
        $breadcrumbs[] = '<a href="'. get_month_link( get_the_time('Y'), get_the_time('m') ) .'">'. get_the_time('F') .'</a>';
        $breadcrumbs[] = '<a href="'. get_day_link( get_the_time('Y'), get_the_time('m'), get_the_time('d') ) .'">'. get_the_time('d') .'</a>';
    } elseif( is_month() ){
        $breadcrumbs[] = '<a href="'. get_year_link( get_the_time('Y') ) . '">' . get_the_time('Y') . '</a>';
        $breadcrumbs[] = '<a href="'. get_month_link( get_the_time('Y'), get_the_time('m') ) .'">'. get_the_time('F') .'</a>';
    } elseif( is_year() ){
        $breadcrumbs[] = '<a href="'. get_year_link( get_the_time('Y') ) .'">'. get_the_time('Y') .'</a>';
    } elseif( is_tax('post_format') ){
        $breadcrumbs[] = '<a href="'. get_post_format_link( get_post_format() ) .'">'. single_term_title('', false) .'</a>';
    }

    if( is_search() ) {
    	$breadcrumbs[] = esc_html__(' - Search', 'vaathi');
    }

    if( is_page() ) {
    	global $post;

	    if( $post->post_parent ) {
	        $parent_id  = $post->post_parent;
	        $parents = array();

	        while( $parent_id ) {
	            $page = get_page( $parent_id );
	            $parents[] = '<a href="' . get_permalink( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a>';
	            $parent_id  = $page->post_parent;
	        }

	        $parents = array_reverse( $parents );
	        $breadcrumbs = array_merge_recursive($breadcrumbs, $parents);
	    }
	    $breadcrumbs[] = the_title( '<span class="current">', '</span>', false );
    }

    if( is_singular( 'post' ) ) {
		$cat = get_the_category();
		if( $cat ) {
			$cat = $cat[0];
			$breadcrumbs[] = get_category_parents( $cat, true, '' );
		}
		$breadcrumbs[] = the_title( '<span class="current">', '</span>', false );
    }

    $filtered_breadcrumbs = apply_filters( 'vaathi_breadcrumbs', $breadcrumbs );

    $count = count( $filtered_breadcrumbs );
    if( $count > 1 ) {
        $output .=  '<div class="breadcrumb">';

            $i = 1;
            foreach( $filtered_breadcrumbs as $breadcrumb ) {
                if( $i == $count ) {
                    $separator = '';
                }
                $output .=  $breadcrumb.$separator;
                $i++;
            }

        $output .= '</div>';
    }

    return $output;
}