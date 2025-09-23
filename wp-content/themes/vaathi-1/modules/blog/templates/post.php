<!-- Primary -->
<section id="primary" class="<?php echo esc_attr( vaathi_get_primary_classes() ); ?>">

    <!-- Post List Wrapper -->
    <div class="wdt-posts-list-wrapper"><?php

        do_action( 'vaathi_before_blog_post_content_wrap' );

        if( have_posts() ) {

            $holder_class  = vaathi_get_archive_post_holder_class();
            $combine_class = vaathi_get_archive_post_combine_class();

            $post_style    = vaathi_get_archive_post_style();
            $template_args['Post_Style'] = $post_style;
            $template_args = array_merge( $template_args, vaathi_archive_blog_post_params() );
            $template_args = apply_filters( 'vaathi_blog_archive_order_params', $template_args );

            echo "<div class='tpl-blog-holder ".$holder_class."'>";
            echo "<div class='grid-sizer ".$combine_class."'></div>";

                while( have_posts() ) :
                    the_post();
                    $post_ID = get_the_ID(); ?>

                    <div class="<?php echo esc_attr($combine_class);?>">
                        <!-- #post-<?php echo "{$post_ID}"; ?> -->
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>><?php

                            $template_args['ID'] = $post_ID;
                            vaathi_template_part( 'blog', 'templates/'.$post_style.'/post', '', $template_args ); ?>
                        </article><!-- #post-<?php echo "{$post_ID}"; ?> -->
                    </div><?php
                endwhile;

            echo '</div>';
        } else {
            echo '<h2>'.esc_html__('Nothing Found.', 'vaathi').'</h2>';
            echo '<p>'.esc_html__('Apologies, but no results were found for the requested archive.', 'vaathi').'</p>';
        }

        do_action( 'vaathi_after_blog_post_content_wrap' );?>

    </div><!-- Post List Wrapper End -->

</section><!-- Primary End -->
<?php vaathi_template_part( 'sidebar', 'templates/sidebar' ); ?>