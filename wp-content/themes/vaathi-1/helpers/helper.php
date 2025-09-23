<?php
if ( ! function_exists( 'vaathi_template_part' ) ) {
	/**
	 * Function that echo module template part.
	 */
	function vaathi_template_part( $module, $template, $slug = '', $params = array() ) {
		echo vaathi_get_template_part( $module, $template, $slug, $params );
	}
}

if ( ! function_exists( 'vaathi_get_template_part' ) ) {
	/**
	 * Function that load module template part.
	 */
	function vaathi_get_template_part( $module, $template, $slug = '', $params = array() ) {
        $file_path = '';
        $html      = '';
        $template_path = VAATHI_MODULE_DIR . '/' . $module;
        $temp_path = $template_path . '/' . $template;
        if ( ! empty( $temp_path ) ) {
            if ( ! empty( $slug ) ) {
                $file_path = "{$temp_path}-{$slug}.php";
                if ( ! file_exists( $file_path ) ) {
                    $file_path = $temp_path . '.php';
                }
            } else {
                $file_path = $temp_path . '.php';
            }
        }
        $file_path = apply_filters( 'vaathi_get_template_plugin_part', $file_path, $module, $template, $slug );
        if ( $file_path && file_exists( $file_path ) ) {
            ob_start();
            if ( is_array( $params ) && count( $params ) ) {
                extract( $params, EXTR_SKIP );
            }
            include $file_path;
            $html = ob_get_clean();
        }
        return $html;
    }
}

if ( ! function_exists( 'vaathi_get_page_id' ) ) {
	function vaathi_get_page_id() {

		$page_id = get_queried_object_id();

		if( is_archive() || is_search() || is_404() || ( is_front_page() && is_home() ) ) {
			$page_id = -1;
		}

		return $page_id;
	}
}

/* Convert hexdec color string to rgb(a) string */
if ( ! function_exists( 'vaathi_hex2rgba' ) ) {
	function vaathi_hex2rgba($color, $opacity = false) {

		$default = 'rgb(0,0,0)';

		if(empty($color)) {
			return $default;
		}

		if ($color[0] == '#' ) {
			$color = substr( $color, 1 );
		}

		if (strlen($color) == 6) {
				$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
		} elseif ( strlen( $color ) == 3 ) {
				$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
		} else {
				return $default;
		}

		$rgb =  array_map('hexdec', $hex);

		if($opacity){
			if(abs($opacity) > 1) {
				$opacity = 1.0;
			}
			$output = implode(",",$rgb).','.$opacity;
		} else {
			$output = implode(",",$rgb);
		}

		return $output;

	}
}

if ( ! function_exists( 'vaathi_html_output' ) ) {
	function vaathi_html_output( $html ) {
		return apply_filters( 'vaathi_html_output', $html );
	}
}


if ( ! function_exists( 'vaathi_theme_defaults' ) ) {
	/**
	 * Function to load default values
	 */
	function vaathi_theme_defaults() {

		$defaults = array (
			'primary_color' => '#825846',
			'primary_color_rgb' => vaathi_hex2rgba('#825846', false),
			'secondary_color' => '#000000',
			'secondary_color_rgb' => vaathi_hex2rgba('#000000', false),
			'tertiary_color' => '#F2EBE1',
			'tertiary_color_rgb' => vaathi_hex2rgba('#F2EBE1', false),
			'body_bg_color' => '#E4D8C9',
			'body_bg_color_rgb' => vaathi_hex2rgba('#E4D8C9', false),
			'body_text_color' => '#464340',
			'body_text_color_rgb' => vaathi_hex2rgba('#464340', false),
			'headalt_color' => '#000000',
			'headalt_color_rgb' => vaathi_hex2rgba('#000000', false),
			'link_color' => '#000000',
			'link_color_rgb' => vaathi_hex2rgba('#000000', false),
			'link_hover_color' => '#825846',
			'link_hover_color_rgb' => vaathi_hex2rgba('#825846', false),
			'border_color' => '#000000',
			'border_color_rgb' => vaathi_hex2rgba('#000000', false),
			'accent_text_color' => '#ffffff',
			'accent_text_color_rgb' => vaathi_hex2rgba('#ffffff', false),

			'body_typo' => array (
				'font-family' => "Jost",
				'font-fallback' => '"Jost", sans-serif',
				'font-weight' => 400,
				'fs-desktop' => 18,
				'fs-desktop-unit' => 'px',
				'lh-desktop' => 1.65,
				'lh-desktop-unit' => ''
			),
			'h1_typo' => array (
				'font-family' => "Marcellus",
				'font-fallback' => '"Marcellus", serif',
				'font-weight' => 400,
				'fs-desktop' => 70,
				'fs-desktop-unit' => 'px',
				'lh-desktop' => 1.17,
				'lh-desktop-unit' => ''
			),
			'h2_typo' => array (
				'font-family' => "Marcellus",
				'font-fallback' => '"Marcellus", serif',
				'font-weight' => 400,
				'fs-desktop' => 60,
				'fs-desktop-unit' => 'px',
				'lh-desktop' => 1.17,
				'lh-desktop-unit' => ''
			),
			'h3_typo' => array (
				'font-family' => "Marcellus",
				'font-fallback' => '"Marcellus", serif',
				'font-weight' => 400,
				'fs-desktop' => 50,
				'fs-desktop-unit' => 'px',
				'lh-desktop' => 1.17,
				'lh-desktop-unit' => ''
			),
			'h4_typo' => array (
				'font-family' => "Marcellus",
				'font-fallback' => '"Marcellus", serif',
				'font-weight' => 400,
				'fs-desktop' => 40,
				'fs-desktop-unit' => 'px',
				'lh-desktop' => 1.17,
				'lh-desktop-unit' => ''
			),
			'h5_typo' => array (
				'font-family' => "Marcellus",
				'font-fallback' => '"Marcellus", serif',
				'font-weight' => 400,
				'fs-desktop' => 30,
				'fs-desktop-unit' => 'px',
				'lh-desktop' => 1.17,
				'lh-desktop-unit' => ''
			),
			'h6_typo' => array (
				'font-family' => "Marcellus",
				'font-fallback' => '"Marcellus", serif',
				'font-weight' => 400,
				'fs-desktop' => 24,
				'fs-desktop-unit' => 'px',
				'lh-desktop' => 1.17,
				'lh-desktop-unit' => ''
			),
			'extra_typo' => array (
				'font-family' => "Permanent Marker",
				'font-fallback' => '"Permanent Marker", serif',
				'font-weight' => 600,
				'fs-desktop' => 20,
				'fs-desktop-unit' => 'px',
				'lh-desktop' => 1,
				'lh-desktop-unit' => ''
			),

		);

		return $defaults;

	}
}