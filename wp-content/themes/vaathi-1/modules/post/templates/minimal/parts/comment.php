<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<?php
if(  ! post_password_required() && ( comments_open() || get_comments_number() ) ) { ?>
	<!-- Entry Comment -->
		<div class="single-entry-comments">
		<div class="comment-wrap"><i class="vaathi-comments-icon"> </i><?php
			comments_popup_link(
				esc_html__('No Comments', 'vaathi'),
				esc_html__('1 Comment', 'vaathi'),
				esc_html__('% Comments', 'vaathi'),
				'',
				esc_html__('Comments Off', 'vaathi')
			); ?>
		</div>
	</div><!-- Entry Comment --><?php
}
?>