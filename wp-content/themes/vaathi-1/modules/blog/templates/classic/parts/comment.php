<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<?php
if( ! post_password_required() && ( comments_open() || get_comments_number() ) ) { ?>
	<!-- Entry Comment -->
	<div class="entry-comments"><?php
		comments_popup_link(); ?>
	</div><!-- Entry Comment --><?php
}
?>