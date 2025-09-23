<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<!-- Entry Author -->
<div class="entry-author">
    <?php echo get_avatar(get_the_author_meta('ID'), 40 );?>
    <a href="<?php echo get_author_posts_url(get_the_author_meta('ID'));?>"
        title="<?php esc_attr_e('View all posts by ', 'vaathi-plus'); echo get_the_author();?>"><?php echo get_the_author();?></a>
</div><!-- Entry Author -->