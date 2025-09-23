<?php if (!defined('ABSPATH')) {
	exit;
} ?>

<?php
if ($enable_disqus_comments && $post_disqus_shortname != ''): ?>
	<!-- Entry Comment -->
	<div class="entry-comments">
		<div class="comment-wrap">
			<i class="vaathi-comments-icon"> </i>
			<?php echo '<a href="' . get_permalink($post_ID) . '#disqus_thread"></a>'; ?>
		</div>
		<script id="dsq-count-scr" src='//<?php echo vaathi_html_output($disqus_name); ?>.disqus.com/count.js'
			async></script>
	</div><!-- Entry Comment --><?php
else:
	if (!post_password_required() && (comments_open() || get_comments_number())) {
		echo '<div class="comment-wrap">';
		echo '<i class="vaathi-comments-icon"> </i>';
		comments_popup_link(esc_html__('Add Comment', 'vaathi'), esc_html__('1 Comment', 'vaathi'), esc_html__('% Comments', 'vaathi'), '', esc_html__('Comments Off', 'vaathi'));
		echo '</div>';
	}
endif; ?>