<?php
	$template_args['post_ID'] = $ID;
	$template_args['post_Style'] = $Post_Style;
	$template_args = array_merge( $template_args, vaathi_single_post_params() ); ?>
    <?php vaathi_template_part( 'post', 'templates/'.$Post_Style.'/parts/image', '', $template_args ); ?>

    <!-- Post Meta -->
    <div class="post-meta">
		<div class="meta-date-field">
			<?php vaathi_template_part( 'post', 'templates/'.$Post_Style.'/parts/date', '', $template_args ); ?>
		</div>
    	<!-- Meta Left -->
    	<div class="meta-left">
			<?php vaathi_template_part( 'post', 'templates/'.$Post_Style.'/parts/comment', '', $template_args ); ?>
			<?php vaathi_template_part( 'post', 'templates/'.$Post_Style.'/parts/author', '', $template_args ); ?>
    	</div><!-- Meta Left -->
    </div><!-- Post Meta -->

    <!-- Post Dynamic -->
    <?php echo apply_filters( 'vaathi_single_post_dynamic_template_part', vaathi_get_template_part( 'post', 'templates/'.$Post_Style.'/parts/dynamic', '', $template_args ) ); ?><!-- Post Dynamic -->