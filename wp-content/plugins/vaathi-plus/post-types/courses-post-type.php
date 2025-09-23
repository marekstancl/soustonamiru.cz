<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'VaathiPlusCoursesPostType' ) ) {

	class VaathiPlusCoursesPostType {

		private static $_instance = null;
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}
		function __construct() {

			add_action( 'init', array( $this, 'vaathi_register_cpt' ) );
			add_filter( 'template_include', array( $this, 'vaathi_template_include' ) );
            add_action( 'add_meta_boxes', array( $this, 'add_course_metabox' ) );
            add_action( 'save_post', array( $this, 'save_course_metabox' ) );
		}
		function vaathi_register_cpt() {

			$labels = array(
				'name'               => __( 'Courses', 'vaathi-plus' ),
				'singular_name'      => __( 'Courses', 'vaathi-plus' ),
				'menu_name'          => __( 'Courses', 'vaathi-plus' ),
				'add_new'            => __( 'Add Courses', 'vaathi-plus' ),
				'add_new_item'       => __( 'Add New Courses', 'vaathi-plus' ),
				'edit'               => __( 'Edit Courses', 'vaathi-plus' ),
				'edit_item'          => __( 'Edit Courses', 'vaathi-plus' ),
				'new_item'           => __( 'New Courses', 'vaathi-plus' ),
				'view'               => __( 'View Courses', 'vaathi-plus' ),
				'view_item'          => __( 'View Courses', 'vaathi-plus' ),
				'search_items'       => __( 'Search Courses', 'vaathi-plus' ),
				'not_found'          => __( 'No Courses found', 'vaathi-plus' ),
				'not_found_in_trash' => __( 'No Courses found in Trash', 'vaathi-plus' ),
			);
			$args = array(
				'labels'             => $labels,
				'public'             => true,
				'exclude_from_search'=> false,
				'show_in_nav_menus'  => true,
				'show_in_rest'       => true,
				'menu_position'      => 26,
				'menu_icon'          => 'dashicons-editor-insertmore',
				'hierarchical'       => false,
				'supports'           => array( 'title', 'editor', 'revisions', 'thumbnail', 'excerpt', 'page-attributes', 'custom-fields' ),
				'taxonomies'          => array( 'category' ),
			);
			register_post_type( 'wdt_courses', $args );
		}

        function add_course_metabox() {
            add_meta_box(
                'course_details',
                __( 'Course Details', 'vaathi-plus' ),
                array( $this, 'render_course_metabox' ),
                'wdt_courses',
                'advanced',
                'high'
            );
        }
        function render_course_metabox( $post ) {
            $course_duration = get_post_meta( $post->ID, 'course_duration', true );
            $course_price = get_post_meta( $post->ID, 'course_price', true );
			$courses_level = get_post_meta( $post->ID, 'courses_level', true );
            wp_nonce_field( 'save_course_metabox_nonce', 'course_metabox_nonce' );
            ?>
            <div class="wdt-custom-box">
                <label><?php echo esc_html__( 'Course Duration', 'vaathi-plus' ); ?></label>
                <input type="text" name="course_duration" value="<?php echo esc_attr( $course_duration ); ?>" placeholder="<?php echo esc_attr__( 'Enter the course duration in hours', 'vaathi-plus' ); ?>">
            </div>
            <div class="wdt-custom-box">
                <label><?php echo esc_html__( 'Course Price', 'vaathi-plus' ); ?></label>
                <input type="text" name="course_price" value="<?php echo esc_attr( $course_price ); ?>" placeholder="<?php echo esc_attr__( 'Enter the course price', 'vaathi-plus' ); ?>">
            </div>
           <div class="wdt-custom-box">
			   <label><?php echo esc_html__( 'Course Level', 'vaathi-plus' ); ?></label>
			   <select name="courses_level">
				   <option value="Beginner" <?php if ($courses_level == 'Beginner') echo 'selected="selected"'; ?>><?php echo esc_html__( 'Beginner', 'vaathi-plus' ); ?></option>
				   <option value="Intermediate" <?php if ($courses_level == 'Intermediate') echo 'selected="selected"'; ?>><?php echo esc_html__( 'Intermediate', 'vaathi-plus' ); ?></option>
				   <option value="Advanced" <?php if ($courses_level == 'Advanced') echo 'selected="selected"'; ?>><?php echo esc_html__( 'Advanced', 'vaathi-plus' ); ?></option>
			   </select>
		   </div>
            <?php
        }
        function save_course_metabox( $post_id ) {
            if ( ! isset( $_POST['course_metabox_nonce'] ) || ! wp_verify_nonce( $_POST['course_metabox_nonce'], 'save_course_metabox_nonce' ) ) {
                return $post_id;
            }
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
                return $post_id;
            }
            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return $post_id;
            }
            $course_duration = isset( $_POST['course_duration'] ) ? sanitize_text_field( $_POST['course_duration'] ) : '';
            $course_price = isset( $_POST['course_price'] ) ? sanitize_text_field( $_POST['course_price'] ) : '';
            $courses_level = isset( $_POST['courses_level'] ) ? sanitize_text_field( $_POST['courses_level'] ) : '';
            update_post_meta( $post_id, 'course_duration', $course_duration );
            update_post_meta( $post_id, 'course_price', $course_price );
            update_post_meta( $post_id, 'courses_level', $courses_level );
        }
		function vaathi_template_include( $template ) {
			if ( is_singular( 'wdt_courses' ) ) {
				if ( ! file_exists( get_stylesheet_directory() . '/single-wdt_courses.php' ) ) {
					$template = VAATHI_PLUS_DIR_PATH . 'post-types/templates/single-wdt_courses.php';
				}
			}
			return $template;
		}
	}
}

VaathiPlusCoursesPostType::instance();
