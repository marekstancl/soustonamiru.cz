<?php
use VaathiElementor\Widgets\VaathiElementorWidgetBase;
use Elementor\Group_Control_Typography;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

class Elementor_Header_Courses extends VaathiElementorWidgetBase {

    public function get_name() {
        return 'wdt-courses-listing';
    }

    public function get_title() {
        return esc_html__('Courses', 'vaathi-plus');
    }

    public function get_icon() {
		return 'eicon-header wdt-icon';
	}

    protected function register_controls() {

        $this->start_controls_section( 'wdt_section_general', array(
            
            'label' => esc_html__('General', 'vaathi-plus'),
            'tab' => Controls_Manager::TAB_CONTENT,

        ) );

        $this->add_control( 'query_posts_by', array(
                'type'    => Controls_Manager::SELECT,
                'label'   => esc_html__('Query posts by', 'vaathi-plus'),
                'default' => 'category',
                'options' => array(
                    'category'  => esc_html__('From Category (for Posts only)', 'vaathi-plus'),
                    'ids'       => esc_html__('By Specific IDs', 'vaathi-plus'),
                )
            ) );

        $this->add_control( '_post_categories', array(
            'label'       => esc_html__( 'Categories', 'vaathi-plus' ),
            'type'        => Controls_Manager:: SELECT2,
            'label_block' => true,
            'multiple'    => true,
            'options'     => $this->vaathi_post_categories(),
            'condition'   => array( 'query_posts_by' => 'category' )
        ) );

        $this->add_control( '_post_ids', array(
            'label'       => esc_html__( 'Select Specific Posts', 'vaathi-plus' ),
            'type'        => Controls_Manager::SELECT2,
            'label_block' => true,
            'multiple'    => true,
            'options'     => $this->vaathi_post_ids(),
            'condition' => array( 'query_posts_by' => 'ids' )
        ) );

        $this->add_control( 'count', array(
            'type'        => Controls_Manager::NUMBER,
            'label'       => esc_html__('Post Counts', 'vaathi-plus'),
            'default'     => '5',
            'placeholder' => esc_html__( 'Enter post count', 'vaathi-plus' ),
        ) );
        $this->add_control( 'couses_excerpt_length', array(
                'type'      => Controls_Manager::NUMBER,
                'label'     => esc_html__('Excerpt Length', 'vaathi-plus'),
                'default'   => '25',
        ) );
        $this->add_control( 'enable_poupup', array(
                'type'         => Controls_Manager::SWITCHER,
                'label'        => esc_html__('Enable Poupup?', 'vaathi-plus'),
                'label_on'     => esc_html__( 'Yes', 'vaathi-plus' ),
                'label_off'    => esc_html__( 'No', 'vaathi-plus' ),
                'return_value' => 'yes',
                'default'      => '',
            ) );
        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $excerpt_length = $this->get_settings('couses_excerpt_length');
        $query_args = array(
            'post_type' => 'wdt_courses',
            'post_status' => 'publish',
            'posts_per_page' => $settings['count'],
        );
        if ($settings['query_posts_by'] == 'category') {
            $query_args['tax_query'] = array(
                array(
                    'taxonomy' => 'category',
                    'field' => 'id',
                    'terms' => $settings['_post_categories'],
                ),
            );
        } elseif ($settings['query_posts_by'] == 'ids') {
            $query_args['post__in'] = $settings['_post_ids'];
        }
        $query = new WP_Query($query_args);
        if ($query->have_posts()) {
            
            while ($query->have_posts()) {
                $author_id = get_post_field('post_author', get_the_ID());
                $author_image = get_avatar($author_id, 50);
                $query->the_post();
                echo '<div class="wdt-course-list">';
                echo '<div class="wdt-course-content-group">';
                        echo '<div class="wdt-course-title">';
                            echo '<h4><a href="' . get_permalink() . '">' . get_the_title() . '</a></h4>';
                        echo '</div>';
                        echo '<div class="wdt-course-content">';
                             echo '<p>' . wp_trim_words(get_the_excerpt(), $excerpt_length) . '</p>';
                        echo '</div>';
                        echo '<div class="wdt-course-author">';
                            echo '<div class="wdt-course-author-img">' . $author_image . '</div>';
                            echo '<div class="wdt-course-author-name-group">';
                                echo '<span>By</span>';
                                echo '<span class="wdt-course-author-name">' . get_the_author() . '</span>';
                            echo '</div>';
                        echo '</div>';
                echo '</div>';
                echo '<div class="wdt-course-media-group">';
                    echo '<div class="wdt-course-image-wrapper">';
                        echo '<img src="' . get_the_post_thumbnail_url(get_the_ID(), 'full') . '" alt="">';
                    echo '</div>';
                echo '</div>';
                echo '<div class="wdt-course-info-group">
                        <div class="wdt-course-detail-title"><h5>Course Details:</h5></div>';
                         echo '<div class="wdt-course-detail-group">';
                            echo '<div class="wdt-course-offer">
                                <label class="wdt-course-label">Course Level -</label>';
                                echo '<span>';
                                    echo get_post_meta(get_the_ID(), 'courses_level', true);
                                echo '</span>';
                            echo '</div>';
                            echo '<div class="wdt-course-duration">
                                <label class="wdt-course-label">Course Duration -</label>';
                                echo '<span>';
                                    echo get_post_meta(get_the_ID(), 'course_duration', true);
                                echo '</span>';
                            echo '</div>';
                            echo '<div class="wdt-course-price">
                                <label class="wdt-course-label">Course Fee -</label>';
                                echo '<span>';
                                    echo get_post_meta(get_the_ID(), 'course_price', true);
                                echo '</span>';
                            echo '</div>';
                        echo '</div>';
                        echo '<div class="wdt-course-btn-group">';
                            if($settings['enable_poupup'] == 'yes') {
                                $new_class = 'popup';
                            }
                            echo '<a href="' . get_permalink() . '" class="wdt-button ' . $new_class . '">Enroll Now</a>';
                        echo '</div>';
                echo '</div>';
            echo '</div>';
            }
        } else {
            echo '<p>No posts found.</p>';
        }
        wp_reset_postdata();
    }

}