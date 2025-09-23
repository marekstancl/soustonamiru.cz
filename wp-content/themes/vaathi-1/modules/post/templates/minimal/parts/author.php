<?php if (!defined('ABSPATH')) {
	exit;
} ?>

<!-- Entry Author -->
<div class="single-entry-author">
	<div class="meta-author-img">
		<i class="wdticon-user"> </i>
	</div>
	<div class="meta-author-info">
		<span><?php esc_html_e('By', 'vaathi'); ?></span>
		<a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"
			title="<?php esc_attr_e('View all posts by ', 'vaathi');
			echo get_the_author(); ?>"><?php echo get_the_author(); ?></a>
	</div>
</div><!-- Entry Author -->